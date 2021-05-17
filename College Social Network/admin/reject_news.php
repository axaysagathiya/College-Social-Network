<?php
    require '../not_loggedin.php';
    require '../is_admin_loggedin.php';
    require '../con_db.php';

    $isdone = '';
    $newsID = $_POST['newsID'];

    $sql1 = "SELECT `file` FROM news WHERE newsID = {$newsID};";
    $result1 = mysqli_query($conn, $sql1) or die($sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $filename = $row1['file'];
    $file_pointer = "../news/".$filename;

    $sql="DELETE FROM news WHERE newsID = {$newsID}; ";
    $result = mysqli_query($conn, $sql);

    if($result) {
        $isdone = "yes";
        unlink($file_pointer);

    } else { 
        $isdone = "no";
    }

    $resArray = array("isdone" => "$isdone");
    echo json_encode($resArray);

?>