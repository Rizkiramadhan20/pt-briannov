<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if required fields are provided
if (!isset($_POST['id']) || !isset($_POST['title']) || !isset($_POST['text']) || !isset($_POST['metrics'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
    exit;
}

$id = $_POST['id'];
$title = $_POST['title'];
$text = $_POST['text'];
$metrics_json = $_POST['metrics'];
$metrics = json_decode($metrics_json, true);

// Validate metrics data format
if (!is_array($metrics)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid metrics data format']);
    exit;
}

// Only validate metrics if they exist
if (!empty($metrics)) {
    if (count($metrics) > 2) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Maximum 2 metrics allowed']);
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
}

// Database connection
require_once '../../../config/db.php';
$db = getDBConnection();

if ($db->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Handle image upload if provided
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
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
        $image_path = 'uploads/about/' . $filename;
        
        // Update with new image
        $stmt = $db->prepare("UPDATE about SET title = ?, text = ?, metrics = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $title, $text, $metrics_json, $image_path, $id);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error uploading file']);
        exit;
    }
} else {
    // Update without changing image
    $stmt = $db->prepare("UPDATE about SET title = ?, text = ?, metrics = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $text, $metrics_json, $id);
}

if ($stmt->execute()) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'About content updated successfully']);
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error updating content: ' . $stmt->error]);
}

$stmt->close();
$db->close(); 