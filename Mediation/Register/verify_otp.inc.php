<?php
session_start();
// Check if registration_id exists in session
if (!isset($_SESSION['temp_registration_id'])) {
    header("Location: register.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify'])) {
    $entered_otp = $_POST['otp'];
    $registration_id = $_SESSION['temp_registration_id'];

    try {
        require_once "../dbh.inc.php";

        // Verify OTP
        $query = "SELECT * FROM registration WHERE registration_id = ? AND OTP = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$registration_id, $entered_otp]);

        if ($stmt->rowCount() > 0) {
            // Update status in registration table
            $updateRegQuery = "UPDATE registration SET status = 'active' WHERE registration_id = ?";
            $updateRegStmt = $pdo->prepare($updateRegQuery);
            $updateRegStmt->execute([$registration_id]);

            // Update status in login table
            $updateLoginQuery = "UPDATE login SET status = 'active' WHERE registration_id = ?";
            $updateLoginStmt = $pdo->prepare($updateLoginQuery);
            $updateLoginStmt->execute([$registration_id]);

            // Clear session
            unset($_SESSION['temp_registration_id']);

            // Redirect to success page or login page
            header("Location: ../index.php?verification=success");
            exit();
        } else {
            header("Location: verify_otp.php?error=invalid_otp");
            exit();
        }

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../index.php");
    exit();
}