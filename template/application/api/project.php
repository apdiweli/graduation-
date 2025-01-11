<?php 

header("Content-type: application/json");

include '../config/conn.php';

function project_registration($conn) {
    $data = array();
    $error_array = array();

    // Retrieve data from POST request
    $title = isset($_POST['title']) ? $_POST['title'] : null;
    $project_description = isset($_POST['project_description']) ? $_POST['project_description'] : null;
    $faculty = isset($_POST['faculty']) ? $_POST['faculty'] : null;
    $department = isset($_POST['department']) ? $_POST['department'] : null;
    $year = isset($_POST['year']) ? $_POST['year'] : null;
    $Leader = isset($_POST['Leader']) ? $_POST['Leader'] : null;
    $Group = isset($_POST['Group']) ? $_POST['Group'] : null;
    $members = isset($_POST['members']) ? $_POST['members'] : null;
    $language = isset($_POST['language']) ? $_POST['language'] : null;
    $action_used = isset($_POST['action_used']) ? $_POST['action_used'] : null;

    // Validate required fields
    if (empty($title)) {
        $error_array[] = "Project title cannot be empty.";
    }
    if (empty($project_description)) {
        $error_array[] = "Project description cannot be empty.";
    }

    // File handling logic (same as your existing code)
    if (isset($_FILES['Store']) && $_FILES['Store']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['Store']['tmp_name']; // Temporary file path
        $file_name = $_FILES['Store']['name'];    // Original file name
        $file_size = $_FILES['Store']['size'];    // File size

        $allowedFiles = ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
        $max_size = 10 * 1024 * 1024; // 10 MB

        if (!in_array($_FILES['Store']['type'], $allowedFiles)) {
            $error_array[] = "Invalid file type. Allowed types: PDF, DOC, DOCX.";
        }
        if ($file_size > $max_size) {
            $error_array[] = "File size exceeds the maximum limit of " . ($max_size / 1024 / 1024) . " MB.";
        }

        if (count($error_array) === 0) {
            $zip_folder = "../uploads/zips/";
            if (!is_dir($zip_folder)) {
                mkdir($zip_folder, 0755, true);
            }
            $zip_file_name = uniqid('project_') . ".zip";
            $zip_file_path = $zip_folder . $zip_file_name;

            $zip = new ZipArchive();
            if ($zip->open($zip_file_path, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($file_tmp, $file_name);
                $zip->close();
                $Store = $zip_file_path;
            } else {
                $error_array[] = "Failed to create the zip file.";
            }
        }
    } else {
        $error_array[] = "No file uploaded or upload error.";
    }

    // Database insertion
    if (count($error_array) === 0) {
        $query = "INSERT INTO `projects` 
            (`Project_Title`, `project_description`, `Faculties`, `department`, `Year`, `group_leader`, `group_name`, `members`, `language_used`, `storing_file`, `Action_used`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssssss", $title, $project_description, $faculty, $department, $year, $Leader, $Group, $members, $language, $Store, $action_used);

        if ($stmt->execute()) {
            $data = array("status" => true, "data" => "Registered successfully");
        } else {
            $data = array("status" => false, "data" => $stmt->error);
        }
    } else {
        $data = array("status" => false, "data" => $error_array);
    }

    echo json_encode($data);
}


function readAllprojects($conn){

    $data=array();
    $array_data=array();

        $sql="SELECT  p.id,p.Project_Title ,s.faculty,p.Year,p.language_used as 'Language Build' from projects p
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

function deleteStudent($conn){
    $data = array();
    $id = $_POST['id'];
    $query = "DELETE FROM project WHERE id='$id'";
    $res = $conn->query($query);

    if($res){
        $data = array("status" => true, "data" => "Deleted successfully");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    // Correctly encode and return $data
    echo json_encode($data);
}


function read_userNFO($conn) {
    extract($_POST);
    $data = array();

    // Select only the necessary fields
    $sql = "SELECT `id`,`full_name`, `degree_information`, `experience` FROM `supervisors` WHERE id = '$id'";

    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $data = array("status" => true, "data" => $row);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}




if(isset($_POST['action'])){
    $action=$_POST['action'];
    $action($conn);
}
 else{
    echo json_encode(array("status"=>false, "data"=>"Action is required..."));
 }



?>