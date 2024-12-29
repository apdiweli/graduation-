<?php
include '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = $_POST['project_id'];
    $rejection_reason = $_POST['rejection_reason'];

    // Validate inputs
    if (!empty($project_id) && !empty($rejection_reason)) {
        $updateProject = "UPDATE projects SET status = 'Rejected', rejection_reason = ? WHERE id = ?";
        $stmt = $conn->prepare($updateProject);
        $stmt->bind_param("si", $rejection_reason, $project_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Project rejected successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update project status."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Rejection reason is required."]);
    }
}
?>
