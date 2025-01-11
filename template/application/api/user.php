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
           
        $query = "INSERT INTO `users`(`id`,`student_id`,`username`, `Role`, `password`, `email`, `image`) 
         VALUES ('$new_id','$Student_id','$username','student',MD5('$password'),'$Email','$save_name')";
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

function student_registration($conn) {
    extract($_POST);
    $data = array();

    // Build the query and call the procedure
    $query = "CALL student_reg ('$fname','$Faculty','$Department','$address')";

    // Execute
    if ($conn->query($query)) {
        $data = array("status" => true, "data" => "Registered successfully");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

   
    echo json_encode($data);
}




function readAlluser($conn){

    $data=array();
    $array_data=array();

    $sql="SELECT `id`,`username`, `email`, `image`, `status` from users where Role='student'";

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
    $query = "DELETE FROM users WHERE id='$id'";
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
    $sql = "SELECT username, student_id, email, image FROM `users` WHERE id = '$id'";

    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $data = array("status" => true, "data" => $row);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}


function update_user($conn){
    
    extract($_POST);

    $data = array();

    if(!empty($_FILES['image']['tmp_name'])){
        $error_arrray = array();

    
        $file_name = $_FILES['image']['name'];
        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size']; 
    
        $save_name = $id . ".png"; 
    

    
        $allowedImages = ["image/jpg","image/jpeg","image/png"];
        $max_size = 15 * 1024 * 1024;
    
       if(in_array($file_type,$allowedImages)){
    
            if($file_size > $max_size){
                
                $error_arrray[] = $file_size/1024/1024 . " MB Files Size must be Less Then " . $max_size/1024/1024 . " MB";
            }
       }else{
            $error_arrray[] = "This file is not Allowed " .$file_type ;
       }
    
    
        // buliding the query and cAll the stored procedures
        if(count($error_arrray) <= 0){
             
    
            $query = "UPDATE `users` SET `student_id`='$student_id',`username`='$username',`Role`='$Role',`password`='$password',
            `email`='$email',`image`='$save_name' WHERE  id = $id";
    
          
        
            $result = $conn->query($query);
        
        
            if($result){
        
                move_uploaded_file($_FILES['image']['tmp_name'], "./upload/".$save_name);
                $data = array("status" => true, "data" => "SucessFully Update");
        
            }else{
                $data = array("status" => false, "data" => $conn->error);
            }
    
        }else{
            $data = array("status" => false, "data" => $error_arrray);
        }
    }
    else{
       
        

        $query  = "UPDATE `users` SET `student_id`='$student_id',`username`='$username',`Role`='$Role',`password`='$password',
            `email`='$email' WHERE  id = '$id'";
    
        // Excecution
    
        $result = $conn->query($query);
    
      
        if($result){
    
          
            $data = array("status" => true, "data" => "SucessFully Updated");
    
        }else{
            $data = array("status" => false, "data" => $conn->error);
        }

    }
    
   
    echo json_encode($data);

}
    







  // function resetPassword($conn, $userId) {
//     $newPassword = "12345"; // Default reset password
//     $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
//     $sql = "UPDATE users SET password = ? WHERE id = ?";
//     $stmt = $conn->prepare($sql);

//     if ($stmt) {
//         $stmt->bind_param("si", $hashedPassword, $userId);
//         if ($stmt->execute()) {
//             $data = array(
//                 "status" => true,
//                 "message" => "Password reset successfully",
//                 "new_password" => $newPassword // Include the new password
//             );
//         } else {
//             $data = array(
//                 "status" => false,
//                 "message" => $stmt->error
//             );
//         }
//         $stmt->close();
//     } else {
//         $data = array(
//             "status" => false,
//             "message" => $conn->error
//         );
//     }

//     echo json_encode($data);
// }





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





//  if ($_POST['action'] == 'resetPassword') {
//     error_log("Received ID: " . $_POST['id']); // Log the received ID
//     $userId = $_POST['id'];
//     resetPassword($conn, $userId);
// }

?>


