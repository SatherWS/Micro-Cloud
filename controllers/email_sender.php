<?php
// TODO: Turn this script into a class similar to database.php and initialize it in edit_entry.php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

require_once "../libs/PHP_Mailer/src/PHPMailer.php";
require_once "../libs/PHP_Mailer/src/SMTP.php";
require_once "../libs/PHP_Mailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'swoopctms@gmail.com';                  // SMTP username
    $mail->Password   = 'qlfwsrjhrzzbfknk';                     // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('swoopctms@gmail.com', 'Mailer');
    $mail->addAddress('satherwebservices@gmail.com', 'Joe User');     // Add a recipient
    $mail->addReplyTo('swoopctms@gmail.com', 'Information');

    // Content
    $mail->isHTML(true);                                         // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
