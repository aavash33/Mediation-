<?php
session_start();
require_once '../dbh.inc.php';

header('Content-Type: application/json');

if (!isset($_SESSION['registration_id']) || !isset($_FILES['photo'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

try {
    $file = $_FILES['photo'];
    
    // Validate file
    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed)) {
        throw new Exception('Invalid file type. Only JPG, PNG and GIF allowed.');
    }
    
    if ($file['size'] > 5242880) { // 5MB limit
        throw new Exception('File too large. Maximum size is 5MB.');
    }
    
    $photoData = file_get_contents($file['tmp_name']);
    
    $pdo->beginTransaction();
    
    // Delete existing photo
    $stmt = $pdo->prepare("DELETE FROM user_photos WHERE registration_id = ?");
    $stmt->execute([$_SESSION['registration_id']]);
    
    // Insert new photo
    $stmt = $pdo->prepare("INSERT INTO user_photos (registration_id, photo_name, photo_data) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['registration_id'], $file['name'], $photoData]);
    
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Photo updated successfully']);
    
} catch(Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Photo Upload Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}