<?php header('Access-Control-Allow-Origin: *'); ?>
<?php if(isset($_POST['sourcemail'])){ $sourcemail = $_POST['sourcemail']; }else{  $sourcemail=""; }?>
<?php if(isset($_POST['sourcemail_fullname'])){ $sourcemail_fullname = $_POST['sourcemail_fullname']; }else{  $sourcemail_fullname=""; }?>
<?php if(isset($_POST['desinationmail'])){ $desinationmail = $_POST['desinationmail']; }else{  $desinationmail=""; }?>
<?php if(isset($_POST['desinationmail_fullname'])){ $desinationmail_fullname = $_POST['desinationmail_fullname']; }else{  $desinationmail_fullname=""; }?>
<?php if(isset($_POST['subjectmail'])){ $subjectmail = $_POST['subjectmail']; }else{  $subjectmail=""; }?>
<?php if(isset($_POST['descriptionmail'])){ $descriptionmail = $_POST['descriptionmail']; }else{  $descriptionmail=""; }?>
<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// date_default_timezone_set('Asia/Bangkok');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$status = array();
$status['status']=false;

// require_once("./vendor/phpmailer/phpmailer/src/PHPMailer.php");
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    $mail->Mailer = "smtp";
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    // $mail->SMTPSecure = "tls";
    $mail->Username   = 'tossapol.c@dru.ac.th';                     //SMTP username
    $mail->Password   = 'zfdzapsgrugwvtbg';                               //SMTP password
    // $mail->Password   = 'vovhgktagykraidr';                               //SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    // $mail->Port = 465;
    $mail->CharSet = 'UTF-8';
    
    //Recipients
    $mail->setFrom($sourcemail, $sourcemail_fullname);
    $mail->addAddress($desinationmail, $desinationmail_fullname);     //Add a recipient

    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subjectmail;
    $mail->Body    = $descriptionmail;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    // echo 'Message has been sent';
    $status['status']=true;
} catch (Exception $e) {
    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    $status['status']=false;
}
echo json_encode($status);
?>
