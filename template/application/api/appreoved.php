<?php
include '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = $_POST['project_id'];
    $supervisor_id = $_POST['supervisor_id'];
    $requirement = $_POST['Requirement'];

    // Validate inputs
    if (!empty($project_id) && !empty($supervisor_id) && !empty($requirement)) {
        // Update project status to 'Accepted'
        $updateProject = "UPDATE projects SET status = 'Approved' WHERE id = ?";
        $stmt = $conn->prepare($updateProject);
        $stmt->bind_param("i", $project_id);
        if ($stmt->execute()) {
            // Assign supervisor and requirement to the project
            $assignSupervisor = "INSERT INTO project_supervisor_assign (project_Id, supervisor_id, requirement) VALUES (?, ?, ?)";
            $stmt2 = $conn->prepare($assignSupervisor);
            $stmt2->bind_param("iis", $project_id, $supervisor_id, $requirement);
            if ($stmt2->execute()) {
                echo json_encode(["status" => "success", "message" => "Project accepted successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to assign supervisor."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update project status."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
    }
}
?>
