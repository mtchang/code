<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>EDM PHPMailer - SMTP test</title>
</head>
<body>


<p>  電子報測試 </p>
<form action="index.php" method="post">
  郵件標題: <input type="text" name="subject"  value="epaper 中文測試"><br>
  收件人 Email: <input type="text" name="mailto" value="epaper@jangmt.com"><br>
  收件人名稱: <input type="text" name="mailto_name" value="中文測試"><br>
  郵件 URL: <input type="text" name="mailcontent_url" size="100" value=""><br>
  <input type="submit" value="Submit">
</form>


<?php
// var get
$subject 	= $_POST["subject"];
$mailto 	= $_POST["mailto"];
$mailto_name 	= $_POST["mailto_name"];
$mailcontent_url  =  $_POST["mailcontent_url"];
$mailcontent_body = file_get_contents("$mailcontent_url");

echo '1'.$subject.'<br>';
echo '2'.$mailto.'<br>';
echo '3'.$mailto_name.'<br>';
echo '4'.$mailcontent_url.'<br>';
# echo '5'.$mailcontent_body.'<br>';

if($subject != NULL and $mailto != NULL and $mailto_name !=NULL and $mailcontent_url != NULL)
{

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Asia/Taipei');

require './PHPMailer/PHPMailerAutoload.php';

mb_internal_encoding('UTF-8');
echo mb_internal_encoding();

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 1;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "smtp.jangmt.com";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = false;
//Username to use for SMTP authentication
$mail->Username = "epaper@jangmt.com";
//Password to use for SMTP authentication
$mail->Password = "yourpassword";
//Set who the message is to be sent from
$mail->setFrom('epaper@jangmt.com', mb_encode_mimeheader("電子報","UTF-8"));
//Set an alternative reply-to address
$mail->addReplyTo('epaper@jangmt.com', mb_encode_mimeheader("電子報","UTF-8"));
//Set who the message is to be sent to
#$mail->addAddress('whoto@example.com', 'John Doe');
$mail->addAddress("$mailto", mb_encode_mimeheader($mailto_name,"UTF-8"));

//$mail->AddBCC("taom.taiwan@taom.org.tw", 'bbcuser');

//Set the subject line
#$mail->Subject = 'PHPMailer SMTP test';
$mail->Subject = $subject;
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$mail->msgHTML("$mailcontent_body");
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
# $mail->addAttachment('images/phpmailer_mini.png');
$mail->CharSet="UTF-8";
$mail->WordWrap = 50;
$mail->IsHTML(true); 


//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}


}else{

	echo 'NO DATA..!!';

}


?>


</body>
</html>
