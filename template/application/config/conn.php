<?php

$conn=new mysqli("localhost","root","","graduation");


if($conn->connect_error){
    echo $conn->error;
}



?>