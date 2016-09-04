<?
error_reporting(E_ALL ^ E_NOTICE);
function doset() {
	if( !ini_get('safe_mode') )
	{
        set_time_limit(0);
		ini_set("max_execution_time", 0);
        ini_set("memory_limit", "256M");
        ignore_user_abort(true);
	}
	else echo "this is a safe_mode one and will timeout.. cannot set_time_limit";
	ob_start();
}
doset();


if ($_POST['action']=="send"){

        $message = urlencode($_POST['message']);

        $message = ereg_replace("%5C%22", "%22", $message);

        $message = urldecode($message);
        $message = stripslashes($message);
        $subject = stripslashes($_POST['subject']);

}
?>

<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">

  <br>

  <table width="100%" border="0">

    <tr> 

      <td width="10%"> 

        <div align="right"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif">Your 

          Email:</font></div>

      </td>

      <td width="18%"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 

        <input type="text" name="from" value="<? print $_POST['from']; ?>" size="30">

        </font></td>

      <td width="31%"> 

        <div align="right"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif">Your 

          Name:</font></div>

      </td>

      <td width="41%"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 

        <input type="text" name="realname" value="<? print $_POST['realname']; ?>" size="30">

        </font></td>

    </tr>

    <tr> 

      <td width="10%"> 

        <div align="right"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif">Reply-To:</font></div>

      </td>

      <td width="18%"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 

        <input type="text" name="replyto" value="<? print $_POST['replyto']; ?>" size="30">

        </font></td>

      <td width="31%"> 

        <div align="right"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif">Attach 

          File:</font></div>

      </td>

      <td width="41%"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 

        <input type="file" name="file" size="30">

        </font></td>

    </tr>

    <tr> 

      <td width="10%"> 

        <div align="right"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></div>

      </td>

      <td colspan="3"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 

        <input type="text" name="subject" value="<? print stripslashes($_POST['subject']); ?>" size="90">

        </font></td>

    </tr>

    <tr valign="top"> 

      <td colspan="3"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 

        <textarea name="message" cols="60" rows="10"><? print stripslashes($_POST['message']); ?></textarea>

        <br>

        <input type="radio" name="contenttype" value="plain">

        Plain 

        <input type="radio" name="contenttype" value="html" checked>

        HTML 

        <input type="hidden" name="action" value="send">

        <input type="submit" value="Send Message">

        </font></td>

      <td width="41%"><font size="-1" face="Verdana, Arial, Helvetica, sans-serif"> 

        <textarea name="emaillist" cols="30" rows="10"></textarea>

        <br>
        <input type="text" name="emailfinal" value="<? print $_POST['emailfinal']; ?>" size="22"> (EMAIL VERIFICARE)
        </font></td>
    </tr>
  </table>
  <p>La fiecare <input type="text" name="emailz" value="<? print $_POST['emailz']; ?>" size="3"> mailz, asteapta <input type="text" name="wait" value="<? print $_POST['wait']; ?>" size="3"> secunde<br></p>
</form>



<?

if ($_POST['action']=="send"){
        $message = urlencode($_POST['message']);

        $message = ereg_replace("%5C%22", "%22", $message);

        $message = urldecode($message);
        $message = stripslashes($message);
        $subject = stripslashes($_POST['subject']);


        $from=$_POST['from'];
        $realname=$_POST['realname'];
        $replyto=$_POST['replyto'];


        $emaillist=$_POST['emaillist'];
       
        $contenttype=$_POST['contenttype'];


        $allemails = split("\n", $emaillist);

        $numemails = count($allemails);
		
		


        #Open the file attachment if any, and base64_encode it for email transport
		$file_name = $_FILES['file']['name'];
		$file = $_FILES['file'];
        if ($file_name){

                @copy($file, "./$file_name") or die("The file you are trying to upload couldn't be copied to the server");

                $content = fread(fopen($file,"r"),filesize($file));

                $content = chunk_split(base64_encode($content));

                $uid = strtoupper(md5(uniqid(time())));

                $name = basename($file);

        }

        

        for($x=0; $x<$numemails; $x++){

                if($_POST['emailz'] && $_POST['wait'])
                        if( fmod($x,$emailz) == 0 ) {
                                echo "-------------------------------> SUNT LA emailul $x, astept $wait secunde.<br>";
                                sleep($wait);
                        }
                $to = $allemails[$x];

                if ($to){

					$to = ereg_replace(" ", "", $to);
					$to = trim($to);
	
					$message = ereg_replace("&email&", $to, $message);
	
					$subject = ereg_replace("&email&", $to, $subject);
	
					print "Sending mail to $to.......";
	
					flush();
					ob_flush();
	
					$header = "From: $realname <$from>\r\nReply-To: $replyto\r\n";
	
					$header .= "MIME-Version: 1.0\r\n";
	
					if ($file_name) $header .= "Content-Type: multipart/mixed; boundary=$uid\r\n";
	
					if ($file_name) $header .= "--$uid\r\n";
	
					$header .= "Content-Type: text/$contenttype\r\n";
	
					$header .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
	
					$header .= "$message\r\n";
	
					if ($file_name) $header .= "--$uid\r\n";
	
					if ($file_name) $header .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
	
					if ($file_name) $header .= "Content-Transfer-Encoding: base64\r\n";
	
					if ($file_name) $header .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n\r\n";
	
					if ($file_name) $header .= "$content\r\n";
	
					if ($file_name) $header .= "--$uid--";
	
					@mail($to, $subject, "", $header);
	
					print " S-o dus<br>";
	
					flush();
					ob_flush();

                }

		}//end for
		
		if( strpos($_POST['emailfinal'], "@") !== false){
			@mail($_POST['emailfinal'], $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], "test");
		}
                //$emaillist .= "\n". $_POST['emailfinal'];



}


?>
