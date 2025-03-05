<?php
$dsn = "mysql:host=localhost;dbname=mediation";  // Keep your original database name
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);  
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    header("Location: Register/register.php?error=database");
    exit();
}