<?php
session_start();
require_once 'config/db.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Validate inputs
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }

    // If no errors, proceed with database insertion
    if (empty($errors)) {
        try {
            // Prepare the SQL statement
            $stmt = $db->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $subject, $message);
            
            // Execute the statement
            if ($stmt->execute()) {
                $_SESSION['toast'] = [
                    'message' => "Thank you for your message! We'll get back to you soon.",
                    'type' => 'success'
                ];
            } else {
                $_SESSION['toast'] = [
                    'message' => "Something went wrong. Please try again later.",
                    'type' => 'error'
                ];
            }
            
            $stmt->close();
        } catch (Exception $e) {
            $_SESSION['toast'] = [
                'message' => "An error occurred. Please try again later.",
                'type' => 'error'
            ];
            error_log("Contact form error: " . $e->getMessage());
        }
    } else {
        $_SESSION['toast'] = [
            'message' => implode(", ", $errors),
            'type' => 'error'
        ];
    }
    
    // Redirect back to the contact form
    header("Location: index.php");
    exit();
}
?>