
<?php

require 'not_loggedin.php'; 
require 'con_db.php';
session_start();

$adID = '';
if(isset($_GET['adid'])) {
$adID = $_GET['adid'];
}

$sqlimage  = "SELECT `file` FROM `buy_sell_attach` where `adID` = $adID";
$imageresult = mysqli_query($conn, $sqlimage);

while($rowimage_prod = mysqli_fetch_assoc($imageresult)){
    $imgurl = "prod_photos/".$rowimage_prod['file'];
    echo "<img src ='$imgurl' width='250' />";
} 

?>