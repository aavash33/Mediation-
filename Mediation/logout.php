<?php
session_start();
session_unset();
session_destroy();


if (isset($_SESSION['registration_id'])) {
    try {
        require_once "./dbh.inc.php";
        
        // Update login status to false
        $query = "UPDATE login SET is_logged_in = FALSE WHERE registration_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['registration_id']]);
        
        // Clear session
        session_unset();
        session_destroy();
        
    } catch (PDOException $e) {
        error_log("Logout error: " . $e->getMessage());
    }
}

header('location: ./index.php');
exit();
?>

