<?php

session_start();
require "../not_loggedin.php";
require "../con_db.php";

$resarray = [];
$msg='success';
$from = $_SESSION['user_id'];
$to = $_POST['to_userID'];
if(empty($to)) {
  echo "<div class='text-center font-weight-bold alert alert-secondary'>  UNAUTHORIZED ! </div>";die;
}

$sql = "DELETE FROM `relation` WHERE (`status`='F' AND `from`='$from' AND `to`='$to') OR (`status`='F' AND `from`='$to' AND `to`='$from');";
$result = mysqli_query($conn, $sql);

if(!$result) {
    error_log("SQL QUERY EXECUTION ERROR : ". $sql);
    $msg = "INTERNAL ERROR";
}

$resArray = array("msg" => "$msg");
echo json_encode($resArray);
?>