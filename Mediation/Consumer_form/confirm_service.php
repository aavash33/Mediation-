<?php
require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $action = $_GET['action'];
    $consumer_email = $_GET['consumer_email'];
    $selected_time = $_GET['selected_time'];

    $mail = new PHPMailer(true);

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
        $mail->setFrom('aavash444pu@gmail.com', 'Mediation Service');
        $mail->addReplyTo('89637f001@smtp-brevo.com');
        $mail->addAddress($consumer_email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Service Request Status';

        if ($action === 'confirm') {
            $mail->Body = "<html><body>Your service request for {$selected_time} has been confirmed.</body></html>";
            
            try {
                require_once "../dbh.inc.php";
                $query = "UPDATE consumer SET updated_date_service_required = ? WHERE email_address = ? AND date_service_required = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$selected_time, $consumer_email, $selected_time]);
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
            }
        } else {
            $mail->Body = "<html><body>Your service request for {$selected_time} has been declined by the service provider.</body></html>";
        }

        $mail->send();
        echo "Response sent to consumer successfully.";
    } catch (Exception $e) {
        echo "Error sending email. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>