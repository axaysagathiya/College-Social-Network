<?php
session_start();
require "../not_loggedin.php";
require "../con_db.php";

$to = $_SESSION['user_id'];
if(!empty($_GET['fromID'])) {
    $from = $_GET['fromID'];
} else {
    echo "<div class='text-center font-weight-bold alert alert-secondary'>  PAGE NOT FOUND ! </div>";die;
}


$sql = "DELETE FROM `relation` WHERE `status`='P' AND `from`='$from' AND `to`='$to'; ";
$result = mysqli_query($conn, $sql);

if( $result ) {
    header("Location: http://localhost:8000/profile.php?uid=". $to ."&action=friends&recievedR");
} else {
    error_log("ERROR WHILE REJECTING FRIEND REQUEST : " . $sql);
}

?>