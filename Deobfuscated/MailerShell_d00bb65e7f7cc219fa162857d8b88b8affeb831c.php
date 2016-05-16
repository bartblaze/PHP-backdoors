<?php
set_time_limit(0);

$numero = $_GET['lista'];
$config['maillist'] = "xmail.txt";
$config['remetente'] = "Andrei de Paula<webmaster.brasil@outlook.com>";
$config['assunto'] = 'Gerente de Relacionamento - [bb.com.br] ';
$config['mensagem'] = 'xeng.txt';
$config['maxerros'] = 100;
$data = date("d/m/Y");
$boundary = rand(1,999999);

/*
if($_SERVER["argc"] < 3) {
	echo "Use: ".$_SERVER["argv"][0]." <maillist> <mailfile> [remetente] [assunto] [headers]\n";
	exit();
}
*/

if(!$_SERVER["argv"][3])
//$remetente = "email@email.com";
$remetente = $config['remetente'];
else
$remetente = $_SERVER["argv"][3];
if(!$_SERVER["argv"][4])
//$assunto = "Assunto";
$assunto = $config['assunto'];
else
$assunto = $_SERVER["argv"][4];

echo "Shell Iniciada<br>\n";

//$file = $_SERVER["argv"][1];
$file = $config['maillist'];

$linhas = @file($file);
if(!$linhas) {
	echo "File ",$file." nao encontrado\n";
	exit(0);
}
//$email = $_SERVER["argv"][2];
$email = $config['mensagem'];

$linhase = @file($email);
if(!$linhase) {
	echo "File ",$email." nao encontrado\n";
	exit(0);
}
$ok =0;
$no = 0;
$num =0;
for($a=0;$a<count($linhas);$a++) {
unset($emails);
for($b=0;$b<count($linhase);$b++) {
        $emails .= $linhase[$b];
}
$num++;

	$to = trim($linhas[$a]);
	if(!strpos($to,"@"))
	continue;
/*        if(!(strstr($to,"infoemail.br@post.com") {
		$failed +=1;
		$fp = fopen("failed.txt","aw+");
		fwrite($fp,$to."\r\n");
		fclose($fp);
		continue;
	}
*/
                $fp = fopen("ok.txt","aw+");
                $emails = str_replace("%EMAIL%",$to,$emails);
                if(!@mail($to, $assunto.$data, $emails.$boundary, "FROM:".$remetente." \nReturn-Path: webmaster.brasil@outlook.com\ncontent-type: text/html\nX-priority: 1\n")) {
                                          $no++;
/*
                if($no == 10 ) {
                if(!$con = fsockopen('br.msn.com',110,$da,$sdg)) {
                         sleep(500);
                         $no = 90;
                         continue;
                }
                sleep(15);
                fwrite($con,"USER $host\r\nPASS $temp\r\n");
                fclose($con);
                $no= 0;
                }
*/
                if($no >= $config['maxerros']) {
                    die('Desisto >.<');
                }

                echo "$to <br>Erro.. <br>[$num]\n";
               //fwrite($fp,$to."[Nao enviado]\r\n");
               fclose($fp);
		continue;
		} else {
		$ok +=1;
                echo "$to <font color='blue'> <br> Ja Foii !!! <br> </font>[$num]\n";
		//fwrite($fp,$to."[enVIADOoo]\r\n");
		fclose($fp);
		continue;
	}
}
echo "<br>Total enviado: ".$ok."\n";
echo "<br>Total de emails ruins: ".$no."\n";

?>