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

$sql = "DELETE FROM `relation` WHERE (`from`='$from' AND `to`='$to') OR (`from`='$to' AND `to`='$from')";
$result = mysqli_query($conn, $sql);
if(!$result) {
    $msg = "Error : ". $sql;
}

$resArray = array("msg" => "$msg");
echo json_encode($resArray);

?>