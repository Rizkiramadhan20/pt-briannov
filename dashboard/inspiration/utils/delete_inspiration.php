<?php
session_start();
header('Content-Type: application/json');

// Check if user is admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit;
}

// Get JSON data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate required fields
if (!isset($data['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID is required'
    ]);
    exit;
}

// Database connection
require_once '../../../config/db.php';
$db = getDBConnection();

// Get image path before deleting
$stmt = $db->prepare("SELECT image FROM inspiration WHERE id = ?");
$stmt->bind_param("i", $data['id']);
$stmt->execute();
$result = $stmt->get_result();
$inspiration = $result->fetch_assoc();

if ($inspiration) {
    // Delete the image file
    $image_path = '../../' . $inspiration['image'];
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    // Delete from database
    $stmt = $db->prepare("DELETE FROM inspiration WHERE id = ?");
    $stmt->bind_param("i", $data['id']);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Inspiration image deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error deleting inspiration image: ' . $stmt->error
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Inspiration image not found'
    ]);
}

$stmt->close();
$db->close(); 