<?php 

header("Content-type: application/json");

include '../config/conn.php';


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

    $sql="SELECT `id`, `name`, `faculty`, `department`, `address` FROM `student` WHERE 1 ";

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
    $query = "DELETE FROM student WHERE id='$id'";
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
    $sql = "SELECT `id`, `name`, `faculty`, `department`, `address` FROM `student` WHERE id = '$id'";

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
    $student_id=$_POST['id'];
    $name=$_POST['fname'];
    $Faculty=$_POST['Faculty'];
    $Department=$_POST['Department'];
    $address=$_POST['address'];
  
    $data=array();
    $messge=array();
  
    $sql="UPDATE `student` SET `id`='$student_id' ,`name`='$name',`faculty`='$Faculty',`department`='$Department',`address`='$address' where id='$student_id'";
  
    $result=$conn->query($sql);
     
    if($result){
        $data=array("status" => true, "data" =>"update successfully");
        
  
    }
    else{
        $data=array("status" => false , "data" =>$conn->error);
    }
  
    echo json_encode($data);
  
}



// function generate($conn){
//     $new_id ='';
//     $data=array();
//     $array_data=array();

//     $sql="SELECT * FROM `users`  order by users.id  DESC limit 1";

//     $result=$conn->query($sql);

//     if($result){

//         $num_rows = $result->num_rows;

//         if($num_rows > 0){
//             $row= $result->fetch_assoc();
//             $new_id = ++$row['id'];

//         }
//         else{
//             $new_id ="USR001";

//         }

        

        
//         $data=array("status"=>true , "data"=>$new_id);

//     }
//     else{
//         $data=array("status"=>false , "data"=>$conn->error);
//     }
    
//     return $new_id;

// }






if(isset($_POST['action'])){
    $action=$_POST['action'];
    $action($conn);
}
 else{
    echo json_encode(array("status"=>false, "data"=>"Action is required..."));
 }



?>

