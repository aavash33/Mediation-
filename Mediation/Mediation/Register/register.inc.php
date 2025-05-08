<?php
require __DIR__ . '/vendor/phpmailer/src/Exception.php';
require __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require __DIR__ . '/vendor/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars($_POST['fname']);
    $lastname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['emailaddress']);
    $contact = $_POST['contactnumber'];
    $password = $_POST['userpassword'];

    try {
        require_once "../dbh.inc.php";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Generate OTP
        $otp = sprintf("%06d", mt_rand(100000, 999999));
        $activation_code = md5(uniqid(rand(), true));
        
        // Database insertions remain the same
        $query = "INSERT INTO registration (firstname, lastname, emailaddress, contactnumber, userpassword, activation_code, OTP, status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$firstname, $lastname, $email, $contact, $hashedPassword, $activation_code, $otp]);

        $registration_id = $pdo->lastInsertId();

        $loginQuery = "INSERT INTO login (registration_id, emailaddress, userpassword, status) VALUES (?, ?, ?, 'pending')";
        $loginStmt = $pdo->prepare($loginQuery);
        $loginStmt->execute([$registration_id, $email, $hashedPassword]);

        // Send OTP email using PHPMailer
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = '89637f001@smtp-brevo.com';
        $mail->Password = 'K7DFJdQkNfXpt89q';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('aavash444pu@gmail.com', 'Meditation Team');
        $mail->addReplyTo('89637f001@smtp-brevo.com');
        $mail->addAddress($email, $firstname);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification OTP';
        $mail->Body = "
        <html>
        <body>
            <h2>Hello $firstname,</h2>
            <p>Your OTP for email verification is: <strong>$otp</strong></p>
            <p>Please enter this OTP to verify your email address.</p>
            <br>
            <p>Regards,<br>Meditation Team</p>
        </body>
        </html>";

        $mail->send();

        // Store registration_id in session for OTP verification
        session_start();
        $_SESSION['temp_registration_id'] = $registration_id;
        
        header("Location: verify_otp.php");
        exit();

    } catch(Exception $e) {
        error_log("Email Error: " . $e->getMessage());
        header("Location: register.php?error=mail");
        exit();
    } catch(PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        header("Location: register.php?error=database");
        exit();
    }
} else {
    header("Location: ../signin.php");
    exit();
}
?>