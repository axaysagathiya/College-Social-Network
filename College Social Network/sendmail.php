<?php

require 'PHPMailerAutoload.php';
require 'mymail_data.php';

$mail = new PHPMailer;

$mail->SMTPDebug = 0;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $mymail;                 // SMTP username
$mail->Password = $mymail_pswd;                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom($mymail, 'College Social Network');
$mail->addAddress($to);     // Add a recipient
              // Name is optional
$mail->addReplyTo($mymail, 'CSN');

    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $mail_msg;
$mail->AltBody = ' Something Went Wrong... ';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

?>