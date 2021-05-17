<?php
    require '../not_loggedin.php';
    require '../is_admin_loggedin.php';
    require '../con_db.php';

    $isdone = '';
    $newsID = $_POST['newsID'];

    $sql = "UPDATE `news` SET `status`='A' WHERE `newsID`='$newsID';";
    $result = mysqli_query($conn, $sql);

    if($result) {
        $isdone = "yes";
    } else { 
        $isdone = "no";
    }

    $resArray = array("isdone" => "$isdone");
    echo json_encode($resArray);
?>