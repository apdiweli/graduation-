<?php
session_start();
include '../config/conn.php';

$user_id = $_SESSION['user_id'];
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_dir = 'application/uploads/';
    $image_path = '';

    // If a new image is uploaded
    if ($image_name) {
        $image_path = $upload_dir . time() . '_' . $image_name;
        if (!move_uploaded_file($image_tmp, $image_path)) {
            $response['message'] = 'Failed to upload image.';
            echo json_encode($response);
            exit;
        }
    }

    // Update user data
    $query = "UPDATE users SET username = ?, email = ?" . ($image_path ? ", image = ?" : "") . " WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($image_path) {
        $stmt->bind_param("sssi", $username, $email, $image_path, $user_id);
    } else {
        $stmt->bind_param("ssi", $username, $email, $user_id);
    }

    if ($stmt->execute()) {
        // Update session data if the username or image is changed
        $_SESSION['username'] = $username;
        if ($image_path) {
            $_SESSION['image'] = basename($image_path); // Store only the file name
        }

        $response['success'] = true;
        $response['message'] = 'Profile updated successfully.';
    } else {
        $response['message'] = 'Failed to update profile.';
    }
}

echo json_encode($response);
?>
