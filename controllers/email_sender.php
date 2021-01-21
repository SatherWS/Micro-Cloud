#!/usr/bin/php
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '/var/www/html/vendor/autoload.php';
include_once "/var/www/html/config/database.php";

class EmailScheduler {

    public function contactServer($assignee, $task, $descript, $deadline) {
        //Server settings
        try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'swoopctms@gmail.com';                  // SMTP username
            $mail->Password   = 'qlfwsrjhrzzbfknk';                     // SMTP gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('swoopctms@gmail.com', 'Swoop Admin');
            $mail->addAddress($assignee, 'Swoop User');
            $mail->addReplyTo('swoopctms@gmail.com', 'Information');

            // Content
            $mail->isHTML(true);                                         
            $mail->Subject = 'Email Reminder';
            $mail->Body    = "<h2>$task is due on $deadline</h2><p>$descript</p>";
            $mail->AltBody = "$task is due on $deadline $descript";
            $mail->send();
            echo "EMAIL HAS BEEN SENT!\n";
        
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo} \n";
        }
    }
}

    $schedule = new EmailScheduler();
    $schedule -> contactServer($argv[1], $argv[2], $argv[3], $argv[4]);

?>
