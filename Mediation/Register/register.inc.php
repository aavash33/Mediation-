<?php
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
        
        // Insert user data into the registration table with pending status
        $query = "INSERT INTO registration (firstname, lastname, emailaddress, contactnumber, userpassword, activation_code, OTP, status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$firstname, $lastname, $email, $contact, $hashedPassword, $activation_code, $otp]);

        // Get the last inserted registration_id
        $registration_id = $pdo->lastInsertId();

        // Insert into login table with pending status
        $loginQuery = "INSERT INTO login (registration_id, emailaddress, userpassword, status) VALUES (?, ?, ?, 'pending')";
        $loginStmt = $pdo->prepare($loginQuery);
        $loginStmt->execute([$registration_id, $email, $hashedPassword]);

        // Send OTP email
        $to = $email;
        $subject = "Email Verification OTP";
        $message = "Hello $firstname,\n\n";
        $message .= "Your OTP for email verification is: $otp\n";
        $message .= "Please enter this OTP to verify your email address.\n\n";
        $message .= "Regards,\nMeditation Team";
        $headers = "From: aavash444pu@gmail.com";

        mail($to, $subject, $message, $headers);

        // Store registration_id in session for OTP verification
        session_start();
        $_SESSION['temp_registration_id'] = $registration_id;
        
        // Redirect to OTP verification page
        header("Location: verify_otp.php");
        exit();

    } catch(PDOException $e) {
        echo "Error: ". $e->getMessage();
    }
} else {
    header("Location: ../signin.php");
}