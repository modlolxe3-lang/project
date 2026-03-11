<?php
error_reporting(E_ALL);
// error_reporting(E_STRICT);

// date_default_timezone_set('America/Toronto');

require_once('../class.phpmailer.php');
include_once('../language/phpmailer.lang-en.php') ;  
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

 $mail->SetLanguage( 'en', '../language/' );

$body             = file_get_contents('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP();
$mail->SMTPAuth   = true;                  // enable SMTP authentication
// $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier

$mail->Host       = "ssl://smtp.gmail.com:465";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server

$mail->Username   = "jubkoo.mail@gmail.com";  // GMAIL username
$mail->Password   = "jubkoo123";            // GMAIL password

$mail->AddReplyTo("acdsin24@hotmail.com","First Last");

$mail->From       = "acdsin24@hotmail.com";
$mail->FromName   = "First Last";

$mail->Subject    = "PHPMailer Test Subject ";

//$mail->Body       = "Hi,<br>This is the HTML BODY<br>";                      //HTML Body
$mail->AltBody    = " To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->WordWrap   = 50; // set word wrap

// $mail->MsgHTML($body);
$mail->Body = " To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->AddAddress("acdsin24@hotmail.com", "akk ");

$mail->AddAttachment("images/phpmailer.gif");             // attachment

$mail->IsHTML(true); // send as HTML

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
?>
