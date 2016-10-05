<?php
//ini_set("sendmail_from", "alert@mtupogo.com");
//ini_set("sendmail_path", "/usr/sbin/sendmail -t -i -f alert@mtupogo.com");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ('constants.php');
require ('functions.php');
require ('PHPMailer/PHPMailerAutoload.php');

if(!isset($_GET["to"]) || !isset($_GET["msg"]) || !isset($_GET["key"]) || $_GET["key"] != SMSKEY)
        return;

$from = EMAIL;
$pass = EMAILPASS;
$to = $_GET["to"];
$msg = $_GET["msg"];

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPDebug = 2; //2 for both client and server side response
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "$from";//sender's gmail address
$mail->Password = "$pass";//sender's password
$mail->setFrom("$from", 'MTUPoGo Alert');//sender's incormation
//$mail->addReplyTo('myanotheremail@gmail.com', 'Barack Obama');//if alternative reply to address is being used
$mail->addAddress("$to", '');//receiver's information
$mail->Subject = '';//subject of the email
$mail->msgHTML("$msg");
$mail->AltBody = '';
//$mail->addAttachment('images/logo.png');//some attachment

file_put_contents("sms.log", "To: $to - $msg", FILE_APPEND);

if (!$mail->send()) {
	file_put_contents("sms.log", " - FAILED\r\n", FILE_APPEND);
    return false; //not sent
} else {
	file_put_contents("sms.log", " - SUCCESS\r\n", FILE_APPEND);
    return true; //sent
}

?>
