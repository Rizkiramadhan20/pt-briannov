<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if file was uploaded
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No image uploaded or upload error']);
    exit;
}

// Validate file type
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($_FILES['image']['type'], $allowed_types)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG and GIF are allowed']);
    exit;
}

// Validate required fields
if (!isset($_POST['title']) || !isset($_POST['description']) || !isset($_POST['text']) || !isset($_POST['status'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Create upload directory if it doesn't exist
$upload_dir = '../../uploads/timeline/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Generate unique filename
$filename = uniqid() . '_' . basename($_FILES['image']['name']);
$target_path = $upload_dir . $filename;

// Move uploaded file
if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
    // Database connection
    require_once '../../../config/db.php';
    $db = getDBConnection();

    // Prepare and execute the query
    $stmt = $db->prepare("INSERT INTO timeline (title, description, text, image, status) VALUES (?, ?, ?, ?, ?)");
    $image_path = 'uploads/timeline/' . $filename;
    $stmt->bind_param("sssss", $_POST['title'], $_POST['description'], $_POST['text'], $image_path, $_POST['status']);

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Timeline entry created successfully']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error saving timeline entry to database: ' . $stmt->error]);
    }

    $stmt->close();
    $db->close();
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error uploading file']);
}