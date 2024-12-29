<?php

header("Content-type: application/json");
include '../config/conn.php';

function markNotificationsAsRead($conn) {
    $sql = "UPDATE admin_notifications SET is_read = TRUE WHERE is_read = FALSE";
    if ($conn->query($sql)) {
        echo json_encode(array("status" => true, "data" => "Notifications marked as read."));
    } else {
        echo json_encode(array("status" => false, "data" => $conn->error));
    }
}

markNotificationsAsRead($conn);

?>
