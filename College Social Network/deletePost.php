<?php
require 'con_db.php';
session_start();

$postID = $_GET['pid'];

$sql1 = "SELECT userID FROM `post` WHERE `postID`='$postID'; ";
$result1 =  mysqli_query($conn, $sql1) or die(mysqli_error($conn));
$row1 = mysqli_fetch_assoc($result1);

if($_SESSION['user_id'] == $row1['userID']) {
    $sql = "delete from attach where postID='{$postID}';";
    $sql .= "delete from post where postID='{$postID}';";
    $result = mysqli_multi_query($conn, $sql) or die(mysqli_error($conn));
}

if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
header("Location: $previous");

?>