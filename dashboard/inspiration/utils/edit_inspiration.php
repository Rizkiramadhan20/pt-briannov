<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Get JSON data from request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate required fields
if (!isset($data['id']) || !isset($data['title']) || !isset($data['description']) || !isset($data['framework']) || !isset($data['labels']) || !isset($data['href']) || !isset($data['text'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Database connection
$db = new mysqli('localhost', 'root', '', 'compon');

if ($db->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Prepare and execute the query
$stmt = $db->prepare("UPDATE home SET title = ?, text = ?, description = ?, framework = ?, labels = ?, href = ? WHERE id = ?");
$framework_json = json_encode($data['framework']);
$stmt->bind_param("ssssssi", $data['title'], $data['text'], $data['description'], $framework_json, $data['labels'], $data['href'], $data['id']);

if ($stmt->execute()) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Content updated successfully']);
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error updating content: ' . $stmt->error]);
}

$stmt->close();
$db->close(); 