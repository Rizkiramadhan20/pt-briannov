<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if required fields are provided
if (!isset($_POST['title']) || !isset($_POST['text']) || !isset($_POST['metrics'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
    exit;
}

// Check if file was uploaded
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No image uploaded or upload error']);
    exit;
}

$title = $_POST['title'];
$text = $_POST['text'];
$metrics_json = $_POST['metrics'];
$metrics = json_decode($metrics_json, true);

// Validate metrics data format
if (!is_array($metrics) || empty($metrics) || count($metrics) > 2) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid metrics data format or too many metrics']);
    exit;
}

foreach ($metrics as $metric) {
    if (!isset($metric['count']) || !isset($metric['title']) || 
        !is_numeric($metric['count']) || !is_string($metric['title']) || 
        empty($metric['title']) || $metric['count'] <= 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid metric format. Count must be a positive number and title cannot be empty']);
        exit;
    }
}

// Validate file type
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($_FILES['image']['type'], $allowed_types)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG and GIF are allowed']);
    exit;
}

// Create upload directory if it doesn't exist
$upload_dir = '../../uploads/about/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Generate unique filename
$filename = uniqid() . '_' . basename($_FILES['image']['name']);
$target_path = $upload_dir . $filename;

// Move uploaded file
if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
    // Database connection
    $db = new mysqli('localhost', 'root', '', 'compon');

    if ($db->connect_error) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    // Prepare and execute the query
    $stmt = $db->prepare("INSERT INTO about (title, image, text, metrics) VALUES (?, ?, ?, ?)");
    $image_path = 'uploads/about/' . $filename;

    $stmt->bind_param("ssss", $title, $image_path, $text, $metrics_json);

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'About content uploaded successfully']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error saving content to database: ' . $stmt->error]);
    }

    $stmt->close();
    $db->close();
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error uploading file']);
} 