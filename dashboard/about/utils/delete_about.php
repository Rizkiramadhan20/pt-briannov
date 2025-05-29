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
$db = new mysqli('localhost', 'root', '', 'compon');
if ($db->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $db->connect_error
    ]);
    exit;
}

// Get image path before deleting
$stmt = $db->prepare("SELECT image FROM about WHERE id = ?");
$stmt->bind_param("i", $data['id']);
$stmt->execute();
$result = $stmt->get_result();
$about = $result->fetch_assoc();

if ($about) {
    // Delete the image file
    $image_path = '../../' . $about['image'];
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    // Delete from database
    $stmt = $db->prepare("DELETE FROM about WHERE id = ?");
    $stmt->bind_param("i", $data['id']);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'About content deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error deleting about content: ' . $stmt->error
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'About content not found'
    ]);
}

$stmt->close();
$db->close(); 