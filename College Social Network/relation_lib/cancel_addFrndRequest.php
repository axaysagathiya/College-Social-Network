<?php

// CANCEL SEND FRIEND REQUEST
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

$sql11 = "DELETE FROM relation WHERE `from`='$from' AND `to`='$to' AND `status`='P'; ";
$result11 = mysqli_query($conn, $sql11) or die(mysqli_error($conn));

if(!$result11) {
    $msg = "Something Went Wrong.";
}

$resArray = array("msg" => "$msg");
echo json_encode($resArray);

?>