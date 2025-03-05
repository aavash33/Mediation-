<?php
session_start();
require_once '../dbh.inc.php';

header('Content-Type: application/json');

if (!isset($_SESSION['registration_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

// Validate input data
if (!isset($data['firstname']) || !isset($data['lastname']) || 
    !isset($data['email']) || !isset($data['contact'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit();
}

try {
    $pdo->beginTransaction();
    
    // Check if email exists for other users
    $checkEmail = $pdo->prepare("SELECT registration_id FROM registration 
                                WHERE emailaddress = ? AND registration_id != ?");
    $checkEmail->execute([$data['email'], $_SESSION['registration_id']]);
    if ($checkEmail->fetch()) {
        throw new Exception('Email address already in use');
    }
    
    // Update registration table
    $stmt = $pdo->prepare("UPDATE registration SET 
                          firstname = ?, 
                          lastname = ?, 
                          emailaddress = ?, 
                          contactnumber = ? 
                          WHERE registration_id = ?");
    
    $stmt->execute([
        trim($data['firstname']),
        trim($data['lastname']),
        trim($data['email']),
        trim($data['contact']),
        $_SESSION['registration_id']
    ]);
    
    // Update login table email
    $loginStmt = $pdo->prepare("UPDATE login SET emailaddress = ? 
                               WHERE registration_id = ?");
    $loginStmt->execute([trim($data['email']), $_SESSION['registration_id']]);
    
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    
} catch(Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Profile Update Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}