<?php

header("Content-type: application/json");

include '../config/conn.php';

function readAllproject($conn){

    $data=array();
    $array_data=array();

    $sql="select `Project_Title` ,`department`, `Year`,`language_used` from projects where Action_used='completed'  ";

    $result=$conn->query($sql);

    if($result){

        while($row= $result->fetch_assoc()){
            $array_data [] =$row;

        }
        $data=array("status"=>true , "data"=>$array_data);

    }
    else{
        $data=array("status"=>false , "data"=>$conn->error);
    }
    
    echo  json_encode($data);

}

function searchProjectByTitle($conn) {
    $data = array();
    $array_data = array();

    $title = isset($_POST['title']) ? $_POST['title'] : '';

    if (empty($title)) {
        echo json_encode(array("status" => false, "data" => "Project title is required"));
        return;
    }

    $sql = "SELECT `Project_Title`, `department`, `Year`, `language_used` 
            FROM projects 
            WHERE `Project_Title` = ? AND `Action_used` = 'completed'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $array_data[] = $row;
        }

        if (!empty($array_data)) {
            $data = array("status" => true, "data" => $array_data);
        } else {
            $data = array("status" => false, "data" => "Project does not exist");
        }
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}





if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if (function_exists($action)) {
        $action($conn);
    } else {
        echo json_encode(array("status" => false, "data" => "Invalid action"));
    }
} else {
    echo json_encode(array("status" => false, "data" => "Action is required..."));
}



?>