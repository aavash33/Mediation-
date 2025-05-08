<?php
require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $provider_id = $_POST['provider_id'];
    $provider_email = $_POST['provider_email'];
    $selected_time = $_POST['dateandtime'];
    $business_name = $_POST['business_name'];
    $consumer_name = $_POST['consumer_name'];
    $consumer_email = $_POST['consumer_email'];
    $consumer_contact = $_POST['consumer_contact'];
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = '89637f001@smtp-brevo.com';
        $mail->Password = 'K7DFJdQkNfXpt89q';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('aavash444pu@gmail.com');
        $mail->addReplyTo('89637f001@smtp-brevo.com');
      
        $mail->addAddress($provider_email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Service Request';
        $mail->Body = "
        <h2>New Service Request</h2>
        <p><strong>Consumer:</strong> {$consumer_name}</p>
        <p><strong>Requested Date/Time:</strong> {$selected_time}</p>
        <p><strong>Email Address:</strong>{$consumer_email}</p>
        <p><strong>Phone Number:</strong>{$consumer_contact}</p>
       
        <p>Please confirm or decline this request:</p>
        <p>
            <a href='http://localhost/Mediation/Consumer_form/confirm_service.php?action=confirm&provider_id={$provider_id}&consumer_email={$consumer_email}&selected_time={$selected_time}'>Confirm</a>
            &nbsp;|&nbsp;
            <a href='http://localhost/Mediation/Consumer_form/confirm_service.php?action=decline&provider_id={$provider_id}&consumer_email={$consumer_email}&selected_time={$selected_time}'>Decline</a>
        </p>";

        $mail->send();
        echo "Request sent to service provider, you will be notified on the decision of the service provider via email.";
    } catch (Exception $e) {
        echo "Error sending email. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

