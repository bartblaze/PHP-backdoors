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

				

//				$ok = "ok";
if(mail($email[$i], $subject, $message, $headers))
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