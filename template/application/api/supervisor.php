<?php 

header("Content-type: application/json");

include '../config/conn.php';

function register_user($conn){

    extract($_POST);

    $data = array();
    $error_arrray = array();

    $new_id = generate($conn);

    $file_name = $_FILES['image']['name'];
    $file_type = $_FILES['image']['type'];
    $file_size = $_FILES['image']['size']; 

    $save_name = $new_id  . '.png'; 

    // allowed images

    $allowedImages = ["image/jpg","image/jpeg","image/png"];
    $max_size = 5 * 1024 * 1024;

   if(in_array($file_type,$allowedImages)){

        if($file_size > $max_size){
            
            $error_arrray[] = $file_size/1024/1024 . " MB Files Size must be Less Then " . $max_size/1024/1024 . " MB";
        }
   }else{
        $error_arrray[] = "This file is not Allowed " .$file_type ;
   }


    
    if(count($error_arrray) <= 0){

        // $query = "INSERT INTO `users`(`id`, `user_name`,`password`,`Image`)
        //  VALUES('$new_id','$username',MD5('$password'), '$save_name')";
           
        $query = "INSERT INTO `users`(`id`,`username`, `Role`, `password`, `email`, `image`) 
         VALUES ('$new_id','$username','supervisor',MD5('$passward'),'$Email','$save_name')";
        // Excecution
    
        $result = $conn->query($query);
    
        // chck if there is an error or not
        if($result){
    
            move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$save_name);
            $data = array("status" => true, "data"=> "SucessFully Registred");
    
        }else{
            $data = array("status" => false, "data" => $conn->error);
        }

    }else{
        $data = array("status" => false, "data" => $error_arrray);
    }
   
    echo json_encode($data);

}

function readAlluser($conn){

    $data=array();
    $array_data=array();

    $sql="SELECT `username`, `email`, `image`, `status` from users where Role='supervisor'";

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


function supervisor_registered($conn) {
    extract($_POST);
    $data = array();

    // Build the query and call the procedure
    $query = "INSERT INTO `supervisors`(`full_name`, `degree_information`, `experience`) VALUES ('$full','$degree','$experience')";

    // Execute
    $result = $conn->query($query);

    if ($result) {
        
            $data = array("status" => true, "data" => "Registration successful");
        }
     else {
        // Fetch and store the connection error
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}


// function readAlluser($conn){

//     $data=array();
//     $array_data=array();

//     $sql="SELECT `username`, `email`, `image`, `status` from users where Role='supervisor'";

//     $result=$conn->query($sql);

//     if($result){

//         while($row= $result->fetch_assoc()){
//             $array_data [] =$row;

//         }
//         $data=array("status"=>true , "data"=>$array_data);

//     }
//     else{
//         $data=array("status"=>false , "data"=>$conn->error);
//     }
    
//     echo  json_encode($data);

// }


function readAllsupervisor($conn){

    $data=array();
    $array_data=array();

    $sql="SELECT `id`,`full_name` as 'Teacher Name', `degree_information` as 'Background Info', `experience` as 'Experience'  FROM `supervisors` WHERE 1";

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
    $query = "DELETE FROM supervisors WHERE id='$id'";
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


function updateStudent($conn){
    $student_id=$_POST['student_id'];
    $fullname=$_POST['full'];
    $degree_info=$_POST['degree'];
    $experience=$_POST['experience'];
  
    $data=array();
    $messge=array();
  
    $sql="UPDATE `supervisors` SET `full_name`='$fullname',`degree_information`='$degree_info',`experience`='$experience' where id='$student_id'";
  
    $result=$conn->query($sql);
     
    if($result){
        $data=array("status" => true, "data" =>"update successfully");
        
  
    }
    else{
        $data=array("status" => false , "data" =>$conn->error);
    }
  
    echo json_encode($data);
  
}



function generate($conn){
    $new_id ='';
    $data=array();
    $array_data=array();

    $sql="SELECT * FROM `users`  order by users.id  DESC limit 1";

    $result=$conn->query($sql);

    if($result){

        $num_rows = $result->num_rows;

        if($num_rows > 0){
            $row= $result->fetch_assoc();
            $new_id = ++$row['id'];

        }
        else{
            $new_id ="USR001";

        }

        

        
        $data=array("status"=>true , "data"=>$new_id);

    }
    else{
        $data=array("status"=>false , "data"=>$conn->error);
    }
    
    return $new_id;

}





if(isset($_POST['action'])){
    $action=$_POST['action'];
    $action($conn);
}
 else{
    echo json_encode(array("status"=>false, "data"=>"Action is required..."));
 }



?>