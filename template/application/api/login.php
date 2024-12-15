<?pho

<?php 
session_start();
include("../config/conn.php");
extract($_POST);
$sql = "call login_sp('$username','$pass')";
$ress = $conn->query($sql);
$r = $ress->fetch_array();
if($ress->num_rows > 0){
  
if(@$r['error']){
	$msg2 = explode("|",$r[0]);

   header("location:../../index.php?msg=$msg2[1]&class=$msg2[0]");
}else{
 //  $_SESSION['name'] = 'nageeye';
	foreach ($r as $name => $value) {
		  $_SESSION[$name] = $value;
	}

	header("location: ../../home.php");
	exit();
}


}else{
	echo "Server Error marka isku day";
}



?>