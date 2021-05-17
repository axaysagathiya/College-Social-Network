<?php

require '../not_loggedin.php';
require '../con_db.php';
session_start();

$resArray = [];
$msg='success';
$from = $_SESSION['user_id'];
$to = $_POST['to_userID'];
if(empty($to)) {
    echo "<div class='text-center font-weight-bold alert alert-secondary'>  UNAUTHORIZED ! </div>";die;
}

$sql = "SELECT * FROM `relation` WHERE `from`='$from' AND `to`='$to'";
$result = mysqli_query($conn, $sql);
if(!$result) {
    $msg = "Error : ". $sql;
}

if(mysqli_num_rows($result) > 0) {
    $sql1 = "UPDATE `relation` SET status='B' WHERE `from`='$from' AND `to`='$to'; ";
    $sql1 .= "DELETE FROM `relation` WHERE `from`='$to' AND `to`='$from'";
    // $result1 = mysqli_query($conn, $sql1);
    $result1 = mysqli_multi_query($conn, $sql1);
    if(!$result1) {
        $msg = "Error : ". $sql1;
    }
} else {
    $sql2 = "INSERT INTO relation(`from`, `to`, `status`) VALUES($from,$to,'B');";
    $result2 = mysqli_query($conn, $sql2);
    if(!$result2) {
        $msg = "Error : ". mysqli_error($conn);
    }
}


$resArray = array("msg" => "$msg");
echo json_encode($resArray);

?>