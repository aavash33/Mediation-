<?php 
session_start();
session_regenerate_id(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['emailaddress']);
    $password = $_POST['userpassword'];

    try {
        require_once "../dbh.inc.php";

        // First check if the user exists and is active
        $query = "SELECT l.*, r.status 
                 FROM login l 
                 JOIN registration r ON l.registration_id = r.registration_id 
                 WHERE l.emailaddress = ? AND l.status = 'active'";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify user exists, is active, and password matches
        if ($user && password_verify($password, $user['userpassword'])) {
             // Update login status to active
             $updateQuery = "UPDATE login SET is_logged_in = TRUE WHERE registration_id = ?";
             $updateStmt = $pdo->prepare($updateQuery);
             $updateStmt->execute([$user['registration_id']]);
            // Set session variables
            $_SESSION['registration_id'] = $user['registration_id'];
            $_SESSION['email'] = $user['emailaddress'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['logged_in'] = true;
            
            // Redirect to home page
            header("Location: ../index/home.php");
            exit();
        } else {
            // Invalid credentials or inactive account
            header("Location: ./index.php?error=invalid");
            exit();
        }

    } catch (PDOException $e) {
        header("Location: ./index.php?error=system");
        exit();
    }
} else {
    header("Location: ./index.php");
    exit();
}

?>