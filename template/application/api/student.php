<?php

header("Content-type: application/json");

include '../config/conn.php';

function readAllproject($conn){

    $data=array();
    $array_data=array();

    $sql="SELECT  p.Project_Title as 'Project Title' ,s.faculty as 'Faculties',p.Year,p.language_used as 'Language Build' from projects p
    INNER JOIN users u
    ON p.user_id =u.student_id INNER JOIN student s on s.id=u.student_id where p.status='approved'
    ";

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

    $sql = "SELECT p.Project_Title, s.faculty, p.Year, p.language_used
        FROM projects p
        INNER JOIN users u ON p.user_id = u.student_id
        INNER JOIN student s ON s.id = u.student_id
        WHERE p.status = 'approved' AND p.Project_Title = ?";


    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(array("status" => false, "data" => "SQL preparation failed: " . $conn->error));
        return;
    }

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