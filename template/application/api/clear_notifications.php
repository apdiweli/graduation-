<?php
header("Content-type: application/json");
include '../config/conn.php';

function clearNotifications($conn) {
    $sql = "DELETE FROM admin_notifications";
    if ($conn->query($sql)) {
        echo json_encode(array("status" => true, "data" => "All notifications cleared."));
    } else {
        echo json_encode(array("status" => false, "data" => $conn->error));
    }
}

clearNotifications($conn);
?>
