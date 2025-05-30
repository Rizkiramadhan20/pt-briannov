<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Validate required fields
if (!isset($_POST['id']) || !isset($_POST['title']) || !isset($_POST['description']) || !isset($_POST['text'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Database connection
require_once '../../../config/db.php';
$db = getDBConnection();

if ($db->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Handle image upload if a new image is provided
$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['image']['type'], $allowed_types)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG and GIF are allowed']);
        exit;
    }

    // Create upload directory if it doesn't exist
    $upload_dir = '../../uploads/works/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Generate unique filename
    $filename = uniqid() . '_' . basename($_FILES['image']['name']);
    $target_path = $upload_dir . $filename;

    // Move uploaded file
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
        $image_path = 'uploads/works/' . $filename;

        // Delete old image
        $stmt = $db->prepare("SELECT image FROM works WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $work = $result->fetch_assoc();

        if ($work && file_exists('../../' . $work['image'])) {
            unlink('../../' . $work['image']);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error uploading file']);
        exit;
    }
}

// Prepare and execute the query
if ($image_path) {
    $stmt = $db->prepare("UPDATE works SET title = ?, description = ?, text = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $_POST['title'], $_POST['description'], $_POST['text'], $image_path, $_POST['id']);
} else {
    $stmt = $db->prepare("UPDATE works SET title = ?, description = ?, text = ? WHERE id = ?");
    $stmt->bind_param("sssi", $_POST['title'], $_POST['description'], $_POST['text'], $_POST['id']);
}

if ($stmt->execute()) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Work entry updated successfully']);
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Error updating work entry: ' . $stmt->error]);
}

$stmt->close();
$db->close(); 