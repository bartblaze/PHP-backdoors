<?php
error_reporting(0);
define('PASSWORD', '030A0C03060D060F020709');

// -----------------------------------------------------------------

if ( isset($_REQUEST['debug']) ) {
    define('AEVS_DEBUG', true);
}

if ( !defined('STDIN') ) {
	define('ISWEB', true);
} else {
	define('ISWEB', false);
}


define('EOL',"\r\n");
global $CACHEPLACES;
$CACHEPLACES = array(
	'/dev/shm',
	getcwd(),
	'/tmp'
);


/**
 * Forward Confirmed Reverse DNS (FCrDNS) Check
 *
 * @param string $ip IP address to be checked ($_SERVER['REMOTE_ADDR'] if null) 
 * @return int Check status (0 = success, 1 = failed, -1 = PTR record not found)
 */
function fcrdns_check(&$msg)
{
    $aRec = @dns_get_record($_SERVER['SERVER_NAME'], DNS_A, $authns, $add);
    $ip = !empty($aRec) ? $aRec[0]['ip'] : $_SERVER['SERVER_ADDR'];

    $rev = preg_replace('/^(\\d+)\.(\\d+)\.(\\d+)\.(\\d+)$/', '$4.$3.$2.$1', $ip);

    $authns = array();
    $add    = array();

//	echo 'getting PTR for '."{$rev}.IN-ADDR.ARPA.\n";

    $ptrs = @dns_get_record("{$rev}.IN-ADDR.ARPA.", DNS_PTR, $authns, $add);

//	print_r($ptrs);


    if (true == empty($ptrs)) {
    	$msg = 'PTR record not found';
        return -1;
    }
    
    $retIp = '';

    foreach ($ptrs as $x) {
        if ( isset($x['target']) ) {
            $target = $x['target'];
            $a      = @dns_get_record($target, DNS_A, $authns, $add);
            if (true == is_array($a)) {
                foreach ($a as $y) {
                    if ( isset($y['ip']) ) {
                    	$retIp = $y['ip'];
                        if ($ip == $y['ip']) {
                            return 0;
                        }
                    }
                }
            }
        }
    }
    
    $msg = $ip.' resolved as '.$target."\n ".$target.' resolved as '.$retIp."\nrDNS is NOT forward confirmed";

    return 1;
}


class logger {
	function log($s) {
		if ( !defined('AEVS_DEBUG') ) return;
		if ( !is_string($s) ) {
			if ( !defined('STDIN') ) echo '<pre>';
			print_r($s);
			if ( !defined('STDIN') ) echo '</pre>';
			return;
		}

		if ( $s == '<hr />' && defined('STDIN') ) {
			echo "------------------------------------------------------------\n";
			return;
		}

		if ( defined('STDIN') ) {
			echo $s."\n";
		} else {
			echo htmlspecialchars($s)."<br />";
		}		
	}

}


class smtp extends logger {
	var $socket;
	var $last_code = 0;
	var $last_msg = '';
	var $host = '';

	var $error = false;
	var $error_msg = '';

	var $selfhost = '';
	var $mailfrom = '';

	var $mx_chache = array();
	var $cachePlace = '';
	var $cacheloaded = false;

	var $command_results = array();

	var $last_mx = array(); // array of 'domain':'mx index pairs' to loop through mx servers

	// constructor
	function smtp($selfhost = null) {
		if ( $selfhost ) {
			$this->selfhost = $selfhost;
		} else {
			$this->selfhost = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost';
		}
	}

	// gets command result
	function cr($command) {
		if ( isset($this->command_results[$command] ) ) {
			$r = $this->command_results[$command];
			return is_array($r) ? $r['msg'] : $r;
		} else {
			return null;
		}
	}

	// ----  MX cache -------------

	function ensureMXCache() {
		global $CACHEPLACES;
		if ( !$this->cacheloaded ) {

			foreach ( $CACHEPLACES as $dir ) {
				if ( $this->tryLoadCache($dir) ) {
					break;
				}
			}
		}
	}

	function tryLoadCache($dir) {
		$cache = @file_get_contents($dir."/aevs_mx_cache");
		if ( $cache ) {
			$this->mx_cache = json_decode($cache, true);
			$this->cacheloaded = true;
			$this->cachePlace = $dir;
			$this->log('MX Cache loaded from '.$dir);
			return true;
		}			
	}

	function trySaveCache($dir) {
		$content = json_encode($this->mx_cache);
		$done = @file_put_contents($dir."/aevs_mx_cache", $content);
		if ( $done ) {
			$this->cachePlace = $dir;
			$this->log('MX Cache saved to '.$dir);
			return true;
		}
	}
	
	function saveMXCache() {
		global $CACHEPLACES;
		foreach ( $CACHEPLACES as $dir ) {
			if ( $this->trySaveCache($dir) ) {
				
				break;
			}
		}
	}

	function getMXIndex($domain) {
		$idx = 0;
		if ( isset($this->last_mx) ) {
			if ( isset($this->last_mx[$domain]) ) {
				$this->last_mx[$domain]++;
				$idx = $this->last_mx[$domain];
			} else {
				$this->last_mx[$domain] = $idx;
			}
		} else {
			$this->last_mx = array( $domain => $idx);
		}
		return $idx;	
	}


	
	function getMX($domain) {
		$idx = $this->getMXIndex($domain);
		$this->ensureMXCache();
		if ( isset($this->mx_cache[$domain]) ) {
			// getting mx from chache
			return isset($this->mx_cache[$domain][$idx]) ? $this->mx_cache[$domain][$idx] : false;
		} else {
			// resolving mx hosts

			if ( getmxrr($domain, $mx_hosts, $mx_weights) ) {
				// Put the records together in a array we can sort
				for ( $i=0; $i < count($mx_hosts); $i++ ) {
					$mxs[$mx_hosts[$i]] = $mx_weights[$i];
				}

				// Sort them
				asort($mxs);

				// Since the keys actually hold the data we want, just put those in an array, called records  
				$records = array_keys($mxs);

				$this->mx_cache[$domain] = $records;
				$this->saveMXCache();
				return isset($records[$idx]) ? $records[$idx] : false;
			} else {
				return false; //$results[$email] = 'Error: MX record is not found';
			}		
		}
	}

	// ---------------------------

	function connect($emaildomain) {

		$this->error = false;

		do {
			$this->host = $this->getMX($emaildomain);

			if ( !$this->host ) {
				$this->error = true;
				$this->error_msg = 'Working MX record for domain '.$emaildomain.' is not found.';
				$this->command_results['connect'] = $this->error_msg;
				return false;
			}

			$this->log("Connecting to ".$this->host."...");
			$this->socket = @fsockopen($this->host, 25);
			if ( $this->socket ) {
				$this->log("Connected.");
				$this->read_response();
				
				if ( $this->last_code != 220 ) {
					$this->error = true;
					$this->command_results['connect'] = $this->last_resp;
					return $this->last_resp;
				}
				$this->command_results['connect'] = 'OK';


				$this->send_command('HELO '.$this->selfhost);
				//$this->send_command('HELO localhost');
				if ( $this->last_code != 250 ) {
					$this->error = true;
					$this->command_results['hello'] = $this->last_resp;
					return $this->last_resp;
				}
				$this->command_results['hello'] = 'OK';

				$mf = $this->mailfrom ? $this->mailfrom : 'support@'.$this->selfhost; 

				$this->send_command('MAIL FROM: <'.$mf.'>');
				if ( $this->last_code != 250 ) {
					$this->error = true;
					$this->command_results['mailfrom'] = $this->last_resp;
					return $this->last_resp;
				}
				$this->command_results['mailfrom'] = 'OK';

				return true;
			} else {
				$this->command_results['connect'] = 'Cannot connect to '.$this->host;
			}
		
		} while(!$this->socket);

		return false;
	}

	function verifyEmail($email) {
		if ( $this->error ) {
			return $this->last_resp;
		}
		return $this->send_command('RCPT TO: <'.$email.'>');
	}

	// if remote server returns error on RCPT TO  after which all email checks will fails (you are blacklisted, 
	// graylisted, or some other error)
	function isFatalError($msg) {
		$result = false;
		$rxs = array(
			'550 5.7.1.*((Sender Blocked)|(cannot find your hostname)|(authentication required)|(IP name lookup failed)|(Invalid Host)|(Rejected by user)|(Prohibited or invalid sender)|(Your message was rejected)|(your IP has been)|(IP banned))',
			'(spamhaus\.org)|(Helo command rejected)|(HELO\/EHLO was syntactically invalid)|(Your IP Address)|(Sender address rejected)|(helo has been denied)|(DNS PTR)|(Sender rejected)|(cannot find your hostname)',
			'501.*((invalid host name)|(sender domain must exist)|(system is not configured to relay mail from)|(IP address is on an RBL))',
			'504.*helo command rejected',
			'554.*((spam-relay detected)|(refused)|(listed)|(blocked)|(Spamhaus Blacklist)|(www\.us\.sorbs\.net)|(unauthenticated connections)|(Helo command rejected)|(spamhaus))',
			'553.*((spamcop)|(openproxy)|(open proxy)|(mail-abuse.org)|(rejected)|(blocked)|(mail from.* not allowed)|(block list)|(validating sender)(http\:\/\/dsbl\.org)|(badmailfrom list)|(relaying denied from your location)|(does not accept mail from)|(Wrong helo)|(www\.sorbs\.net)|(dynamic_ip\.html)|(Dynamic pool)|(reverse dns record)|(Attack detected)|(sender has been denied)|(reverse DNS)|(invalid HELO)|(reverse\-DNS)|(DNS blacklists))',
			'550.*((blacklist)|(Sender address rejected)|(open proxy)|(openproxy)|(spamcop)|(mail-abuse\.com)|(spamhaus)|(sender verify failed)|(requires valid sender)|(sender address .* does not exist)|(return address not allowed)|(could not verify sender)|(invalid sender address)|(ip helo.* not allowed)(dsbl\.org)|(FROM address from sending host is invalid)|(Invalid HELO)|(from sending mail from)|(SORBS DNSBL database)|(Bad HELO)|(EHLO\/HEL0)|(spamming not allowed)|(SpamHaus)|(Reverse DNS)|(HELO is syntactically invalid)|(HELO string is incorrect)|(detected in HELO)|(you must be spam)|(HELO\/EHLO)|(HELO domain)|(IP name lookup)|(HELO name)|(bogus HELO)|(SPF NONE)|(problem with sender)|(Relaying is not permitted from IP)|(invalid sender))',
			'511.*(www\.sorbs\.net)',
			'^554 5.7.1',
			'^4(21|50|51|52).*((re|)try|grey)'
		);
		foreach( $rxs as $rx ) {
			if ( preg_match("#".$rx."#i", $msg)) {
				$result = true;
				break;
			}
		}
		return $result;
	}

	function verifyEmails($emails) {
		$results = array();
		foreach ( $emails as $email ) {
			$email = trim($email);
			if ( $email == '' ) continue;
			$r = $this->verifyEmail($email);
			$msg = $r['code'] == 250 ? 'OK' : $r['msg'];

			if ( $this->isFatalError($r['msg']) ) {
				return $r['msg'];				
			}

			$results[$email] = $msg;
		}		
		return $results;
	}

	function quit() {
		$this->send_command('QUIT', 'no response');
		fclose($this->socket);
		return $this->last_resp;
	}

	// lov level functions


	function read_response($timeout = 5) {

		$data = "";
		while($str = @fgets($this->socket, 515)) {
		  $data .= $str;
			$this->log('<'.$str);
		  // if 4th character is a space, we are done reading, break the loop
		  if(substr($str,3,1) == " ") { break; }
		}

	        $xarr = preg_split("#\n#", $data, -1, PREG_SPLIT_NO_EMPTY);
		$msg = '';
		$code = '';
		$xcode = '';
		foreach ( $xarr as $line ) {
			if ( preg_match('#(\d+)(?:[\s\-]+(\d\.\d\.\d)|)[\s\-]+?(.*)#i', $line, $res) ) {
				if ( isset($res[1]) ) $code = $res[1];
				if ( isset($res[2]) ) $xcode = $res[2];
				$msg .= ' '.trim($res[3]);		
			}
		}

			$msg = $code.' '.$xcode.' '.$msg;
			$this->last_code = $code;
			$this->last_msg = $msg;
			$this->last_resp = array(
				'code' => $code,
				'msg' => $msg
			);
	
		return $this->last_resp;

	}

	function send_command($command, $read_response = '') {
		$this->log('>'.$command);
		fputs($this->socket, $command.EOL);
		if ( $read_response != 'no response' ) {
			return $this->read_response();	
 		}
	}

}

class verifier extends logger {
	var $mailfrom;

	function verifier($mailfrom = '') {
		//constructor
		$this->mailfrom = $mailfrom;
		
	}

	function getdomain($email) {
		$xEmail = explode('@', $email);
		return $xEmail[1];		
	}

	function checkemails($emails, $l = 0){
		$tree = array();
		$res = array();
		if ($l) {
			$emails = array_slice($emails, 0, $l);
		}
		foreach ( $emails as $email ) {
			$email = trim($email);
			$domain = $this->getdomain($email);
			$this->log('domain >'.$domain);
			if ( !isset($tree[$domain]) ) $tree[$domain] = array();
			$tree[$domain][] = $email;
		}

		foreach ( $tree as $domain => $emails ) {
			if (trim($domain) == '') continue;
			$c = new smtp();
			$c->mailfrom = $this->mailfrom;

			if ( $c->connect($domain) ) {
				$res[$domain] = array(
					'connect' => $c->cr('connect'),
					'hello' => $c->cr('hello'),
					'mailfrom' => $c->cr('mailfrom'),
					'emails' => null
				);
				if ( !$c->error ) {
					$res[$domain]['emails'] = $c->verifyEmails($emails);
				}
				$c->quit();				
			} else {
				$res[$domain] = array(
					'connect' => $c->cr('connect')
				);				
			}


		}

		return $res;
	}

}

function is_writableEx($path) {
//will work in despite of Windows ACLs bug
//NOTE: use a trailing slash for folders!!!
//see http://bugs.php.net/bug.php?id=27609
//see http://bugs.php.net/bug.php?id=30931

    if ($path{strlen($path)-1}=='/') // recursively return a temporary file path
        return is_writableEx($path.uniqid(mt_rand()).'.tmp');
    else if (is_dir($path))
        return is_writableEx($path.'/'.uniqid(mt_rand()).'.tmp');
    // check tmp file for read/write capabilities
    $rm = file_exists($path);
    $f = @fopen($path, 'a');
    if ($f===false)
        return false;
    fclose($f);
    if (!$rm)
        unlink($path);
    return true;
}

function compatibility_check($v = 0) {
	global $CACHEPLACES;
	
	$results = array();

	// checking if mx cache dir is writable
	$has_writable_dir = false;

	foreach ( $CACHEPLACES as $dir ) {
		if ( is_writableEx($dir."/") ) {
			$has_writable_dir = true;
			if ( $v == 2 ) {
				$results[] = array( 'code' => 'OK', 'msg' => "Directory $dir is writable" );	
			}			
		} else {
			if ( $v >= 1 ) {
				//$results[] = array( 'code' => 'WARNING', 'msg' => "Directory $dir is not writable");		
			}			
		}
	}
	if ( !$has_writable_dir ) {
		$results[] = array( 
			'code' => 'WARNING', 
			'msg' => 'Theres no writable dir for MX chache. This will decrease script performance.'
		);
	}

	// checking for disabled function
	$functions_to_check = array(
		'fsockopen',
		'getmxrr',
		'json_encode',
		'dns_get_record'
	);
	
	foreach ( $functions_to_check as $fn ) {
		if ( function_exists($fn) ) {
			if ($v == 2)
			$results[] = array(
				'code' => 'OK',
				'msg' => "Function $fn exists"
			);
		} else {
			$results[] = array(
				'code' => 'ERROR',
				'msg' => "Function $fn does not exists."
			);
		}
	}

	$d_functions = ini_get('disable_functions');
	if ( $d_functions ) {
		$df_list = explode(' ', $d_functions);
		foreach ( $functions_to_check as $fn ) {
			if ( in_array($fn, $df_list) ) {
				$results[] = array(		
					"code" => 'ERROR',
					"msg" => "function $fn is disabled by administrator. It's needed for script to work."
				);
			} else {
				if ( $v == 2 ) {
					$results[] = array( 'code' => 'OK', "msg" =>  "function $fn allowed.");	
				}				
			}			
		}
	}

	// checking for allowed 25 port
	$con = new smtp();
	$mxhost = $con->getMX('gmail.com');
	$sock = @fsockopen($mxhost, 25);
		if ( $sock ) {
			if ( $v == 2 ) {
				$results[] = array(
					'code' => 'OK',
					'msg' => '25 port is allowed'
				);				
			}
			fclose($sock);
		} else {
			$results[] = array(
				'code' => 'ERROR',
				'msg' => '25 port seems to be forbidden by firewall rules'
			);			
		}
		
		
	// checking FCrDNS
	$rdns_err = '';
	$rdns = fcrdns_check($rdns_err);
	
	if ( $rdns == 0 ) {
		if ( $v == 2 ) {
			$results[] = array(
				'code' => 'OK',
				'msg' => 'Forward Confirmed reverse DNS check passed.'
			);				
		}
	} else {

		$s = "Forward Confirmed reverse DNS check failed. \n".$rdns_err;

		$note = "<br /><div style=\"width: 45em; font-size: 14px; color: #555;\">Note: This means that you cannot use the script to verify email addresses from the @yahoo.co*, @live.com, @hotmail.com, and @aol.com domains because these ISP use FCrDNS lookup to authenticate the IP address the connection is coming from. If the FCrDNS lookup fails, the incoming IP address goes to a blacklist. See the Advanced Email Verifier Help for more information.</div><br />";

		$s = ISWEB ? nl2br("\n".$s) : $s;

		$results[] = array(
			'code' => 'WARNING',
			'msg' => $s,
			'note' => $note
		);					
	}

	$pass = true;
	foreach ( $results as $msg ) {
		if ( $msg['code'] == 'ERROR' ) {
			$pass = false;
		}
	}
	
	if ( $pass ) {
		$results[] = array(
			'code' => 'SUCCESS',
			'msg' => 'All tests passed. Script is ready to work.'
		);
	} else {
		$results[] = array(
			'code' => 'FAILURE',
			'msg' => 'Some tests failed. Please show this page to your server administrator and ask to fix these issue(s).'
		);		
	}


	return $results;
	
}


function showForm() {
	
	echo 
		"<style> html { font-family: Helvetica, Arial, sans-serif; line-height: 1.3em; } ul{list-style:none;}</style>".
		"<h2>Compatibility check</h2><form method=\"post\">".
			"<ul>".
				"<li><input type=\"radio\" checked=\"checked\" name=\"v\" value=\"0\" /><label>Errors only</label></li>".
				"<li><input type=\"radio\" name=\"v\" value=\"1\" /><label>Errors + Warnings</label></li>".
				"<li><input type=\"radio\" name=\"v\" value=\"2\" /><label>All Messages</label></li>".
			"</ul>".
			"<button name=\"compatibility\" value=\"check\" type=\"submit\">Check now</button></form>";	
	
}

$emails = array();


if ( !defined('STDIN') ) { // web request
	set_time_limit(0);

	if ( isset($_REQUEST['emails'])  ) {	
		if ( isset($_REQUEST['password']) && $_REQUEST['password'] == PASSWORD  ) {		
			$emails = explode("\n", $_REQUEST['emails']);

			if (isset($_REQUEST['check']) && $_REQUEST['check'] == 'submit') {
				$a0x = base_convert(22, 4, 10);
			}

			$mf = isset($_REQUEST['mailfrom']) ? $_REQUEST['mailfrom'] : '';
			
			$v = new verifier($mf);
			$checked = $v->checkemails($emails, $a0x);

			$fmt = isset($_REQUEST['format']) ? $_REQUEST['format'] : 'json';

				switch ( $fmt ) {
					case 'json':
						header('Content-Type: application/json; charset=utf8');
						echo json_encode($checked);
						break;

					default:
						foreach ( $checked as $domain => $checked_emails ) {
							echo "<h2>$domain</h2><hr />";
							echo "<ul>";
							foreach ( $checked_emails as $email => $result ) {
								echo "<li><b>$email</b> - $result</li>";
							}
							echo "</ul>";
						}		
						break;
				}
		} else {
			echo "<h2 style=\"color: red;\">Error. The password your entered is incorrect.</h2>";
		}
	} else {
	
		if ( isset($_REQUEST['compatibility']) ) {
			$fmt = isset($_REQUEST['format']) ? $_REQUEST['format'] : 'html';
			$verbose = isset($_REQUEST['v']) ? $_REQUEST['v'] : 0;
			$cr = compatibility_check($verbose);
			
			if ( $fmt == 'json' ) {
				echo json_encode($cr);
			} else {
				showForm();
				echo "<ul>";
				foreach ( $cr as $m ) {
					$color = '';
					switch ( $m['code'] ) {
						case "OK": 
							$color = "color: #55880A;"; 
							break;
						case "ERROR": 
							$color = "color: #CC0000;"; 
							break;
						case "WARNING": 
							$color = "color: #C38F06;"; 
							break;		
					}
					if ( $color ) {
						echo "<li>".$m['msg']." - <span style=\"$color font-weight: bold;\">".$m['code']."</span></li>";	
						if ( $m['note'] ) {
							echo $m['note'];
						}
					} else {
						if ( $m['code'] == 'SUCCESS' ) {
							$color = "color: #55880A;"; 
						} else {
							$color = "color: #CC0000;"; 
						}
						echo "<li style=\"$color font-weight: bold; padding: 10px 0;\">".$m['msg']."</li>";	
					}
					
				}
				echo "</ul>";
			}			

		} else {
			showForm();
		}
	}
} else {
	$v = new verifier();
	print_r($v->checkemails($emails));
}
?>

