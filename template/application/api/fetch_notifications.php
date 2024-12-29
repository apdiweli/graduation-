<?php

header("Content-type: application/json");
include '../config/conn.php';

function fetchNotifications($conn) {
    $sql = "SELECT id, message, created_at, is_read FROM admin_notifications ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $notifications = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
        echo json_encode(array("status" => true, "data" => $notifications));
    } else {
        echo json_encode(array("status" => false, "data" => $conn->error));
    }
}

fetchNotifications($conn);

?>
