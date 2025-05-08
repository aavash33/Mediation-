<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['registration_id']) || !isset($_SESSION['email']) || !isset($_SESSION['logged_in'])) {
    header("Location: ./signin/signin.php");
    exit();
}

require __DIR__ . '/vendor/phpmailer/PHPMailer/src/Exception.php';
require __DIR__ . '/vendor/phpmailer/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/vendor/phpmailer/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require_once "./dbh.inc.php";
        
        // Check user's registration and login status
        $checkQuery = "SELECT r.registration_id, r.firstname, r.lastname, r.emailaddress, r.contactnumber, 
                             l.status as login_status, r.status as registration_status
                      FROM registration r
                      JOIN login l ON r.registration_id = l.registration_id
                      WHERE r.emailaddress = ? 
                      AND r.registration_id = ?
                      AND r.status = 'active'
                      AND l.status = 'active'";
                      
        $stmt = $pdo->prepare($checkQuery);
        $stmt->execute([$_SESSION['email'], $_SESSION['registration_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$user) {
            header("Location: ./signin/signin.php?error=invalidaccess");
            exit();
        }

        // Continue with email sending if user is properly logged in
        $provider_id = $_POST['provider_id'];
        $provider_email = $_POST['provider_email'];
        $selected_time = $_POST['dateandtime'];
        $business_name = $_POST['business_name'];

        $mail = new PHPMailer(true);

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
        <p><strong>Consumer:</strong> {$user['firstname']} {$user['lastname']}</p>
        <p><strong>Requested Date/Time:</strong> {$selected_time}</p>
        <p><strong>Email Address:</strong> {$user['emailaddress']}</p>
        <p><strong>Phone Number:</strong> {$user['contactnumber']}</p>

        <p>Please confirm or decline this request:</p>
        <p>
            <a href='http://localhost/Mediation/confirm_process_selection.php?action=confirm&provider_id={$provider_id}&consumer_email={$user['emailaddress']}&selected_time={$selected_time}'>Confirm</a>
            &nbsp;|&nbsp;
            <a href='http://localhost/Mediation/confirm_process_selection.php?action=decline&provider_id={$provider_id}&consumer_email={$user['emailaddress']}&selected_time={$selected_time}'>Decline</a>
        </p>";

        $mail->send();
        echo "<div class='success'>Request sent to service provider. You will be notified of their decision via email.</div>";
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo "<div class='error'>An error occurred while processing your request.</div>";
    } catch (Exception $e) {
        error_log("Email error: " . $e->getMessage());
        echo "<div class='error'>Error sending email: {$mail->ErrorInfo}</div>";
    }
}
?>