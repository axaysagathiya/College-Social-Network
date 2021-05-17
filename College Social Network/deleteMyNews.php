<?php
require 'not_loggedin.php'; 
require 'con_db.php';


$adID=''; 
$uid='';
if(isset($_GET['adid'])) {
    $adID = $_GET['adid'];
}
if(isset($_GET['uid'])) {
    $uid=$_GET['uid'];
}

$sql = "delete from buy_sell_attach where adID = $adID;";
$sql .= "delete from buy_sell_ad where adID = $adID;";

$result = mysqli_multi_query($conn, $sql);

if($result) {
    $adrs = "http://localhost:8000/profile.php?uid=". $uid ."&action=myProd"; 
    header("Location: $adrs");
} else {
    // die("can not delete this advertisement.");
    // die($sql);

    die(mysqli_error($conn));
}

?>