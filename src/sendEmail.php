<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'vegasfernando2003@gmail.com';
    $mail->Password = 'aegs vhbe ozds ddwb';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('vegasfernando2003@gmail.com', 'Marjorie Boutique');
    $mail->addAddress('vegasfernando2003@gmail.com', 'User');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'This is the subject';
    $mail->Body    = '<h1>This is the HTML message body in bold!</h1>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
