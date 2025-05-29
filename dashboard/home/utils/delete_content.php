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

// Prepare and execute delete query
$stmt = $db->prepare("DELETE FROM home WHERE id = ?");
$stmt->bind_param("i", $data['id']);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Content deleted successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error deleting content: ' . $stmt->error
    ]);
}

$stmt->close();
$db->close(); 