
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


    $sql11 = "SELECT * FROM `relation` WHERE `status`='P' AND `from`='$from' AND `to`='$to'; ";
    $result11 = mysqli_query($conn, $sql11);

    if(mysqli_num_rows($result11) > 0) {

        // (E1) UPGRADE STATUS TO "F"RIENDS
        $sql2 = "UPDATE `relation` SET status='F' WHERE `status`='P' AND `from`='$from' AND `to`='$to'; ";
        $result2 = mysqli_query($conn, $sql2);

        // (E2) ADD RECIPOCAL RELATIONSHIP
        $sql = "INSERT INTO `relation` (`from`, `to`, `status`) VALUES ('$to','$from','F')";
        $result = mysqli_query($conn, $sql);
    } else {
        echo "cant be frnd,"; die;
    }

    header("Location: http://localhost:8000/profile.php?uid=". $to ."&action=friends&recievedR");

?>