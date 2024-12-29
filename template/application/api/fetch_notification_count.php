<?php

header("Content-type: application/json");
include '../config/conn.php';

function fetchNotificationCount($conn) {
    $sql = "SELECT COUNT(*) AS unread_count FROM admin_notifications WHERE is_read = FALSE";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        echo json_encode(array("status" => true, "count" => $row['unread_count']));
    } else {
        echo json_encode(array("status" => false, "count" => 0, "error" => $conn->error));
    }
}

fetchNotificationCount($conn);

?>
