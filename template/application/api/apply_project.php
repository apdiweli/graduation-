<?php

header("Content-type: application/json");

include '../config/conn.php';



function applyProject($conn) {
    // Fetching data from POST
    $project_title = isset($_POST['Project']) ? trim($_POST['Project']) : '';
    $leader_name = isset($_POST['leader']) ? trim($_POST['leader']) : '';
    $group_name = isset($_POST['Group_Name']) ? trim($_POST['Group_Name']) : '';
    $members = isset($_POST['members']) ? trim($_POST['members']) : '';
    $language_used = isset($_POST['Language']) ? trim($_POST['Language']) : '';
    $user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';

    // Validating inputs
    if (empty($project_title) || empty($leader_name) || empty($group_name) || empty($members) || empty($language_used) || empty($user_id)) {
        echo json_encode(array("status" => false, "data" => "All fields are required."));
        return;
    }

    


    // Start a transaction
$conn->begin_transaction();

try {
    // Inserting into projects table
    $sql = "INSERT INTO projects (Project_Title, group_leader, group_name, members, language_used, user_id, creation_date) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("SQL Error (Projects): " . $conn->error);
    }

    $stmt->bind_param("sssssi", $project_title, $leader_name, $group_name, $members, $language_used, $user_id);

    if (!$stmt->execute()) {
        throw new Exception("Failed to insert project: " . $conn->error);
    }

    // Get the last inserted project ID
    $project_id = $stmt->insert_id;

    // Inserting into admin_notifications table
    $notification_query = "INSERT INTO admin_notifications (message, created_at, is_read, project_id) 
                           VALUES (?, NOW(), FALSE, ?)";
    $notification_message = "New project $project_title submitted by $leader_name";
    $notification_stmt = $conn->prepare($notification_query);

    if (!$notification_stmt) {
        throw new Exception("SQL Error (Notifications): " . $conn->error);
    }

    $notification_stmt->bind_param("si", $notification_message, $project_id);

    if (!$notification_stmt->execute()) {
        throw new Exception("Notification Execution Error: " . $conn->error);
    }

    // Commit the transaction
    $conn->commit();

    // Return success response
    echo json_encode(array("status" => true, "data" => "Project and notification submitted successfully!"));
    exit; // Prevent further execution
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();

    // Return error response
    echo json_encode(array("status" => false, "data" => $e->getMessage()));
    exit; // Prevent further execution
}
    
        if (!$notification_stmt) {
            echo json_encode(array("status" => false, "data" => "Notification SQL Error: " . $conn->error));
            return;
        }
    
        $notification_stmt->bind_param("si", $notification_message, $user_id);
    
        if ($notification_stmt->execute()) {
            echo json_encode(array("status" => true, "data" => "Project submitted successfully!"));
        } else {
            echo json_encode(array("status" => false, "data" => "Notification execution error: " . $notification_stmt->error));
        }
    }
    


    
    
    











    if(isset($_POST['action'])){
    $action=$_POST['action'];
    $action($conn);
}

?>