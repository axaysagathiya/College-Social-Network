<?php

require 'con_db.php';
$msg = '';

$table_name = '';
if(isset($_GET['type'])) {
    if($_GET['type']=='u') {$table_name = 'users';}
    else if($_GET['type']=='ur'){$table_name = 'users_request';}
}


$vkey = $_GET['vkey'];
$mymail = $_GET['mail'];
    
    $sql2 = "SELECT * FROM verification WHERE Email = '$mymail' AND verification_key = '$vkey';";
    $result2 = mysqli_query($conn,$sql2) or die(mysqli_error($conn));
    
    if(mysqli_num_rows($result2) > 0) {

        $sql1 = "UPDATE $table_name SET is_verified = '1' WHERE Email = '$mymail';";  
        $sql1 .= "DELETE FROM verification WHERE Email = '$mymail';"; 
    
        $result1 = mysqli_multi_query($conn,$sql1) or die($sql1);

        if($_GET['type']=='u') {
            $msg = '<div class="mx-auto mt-5 " style="width: 50%;"><div class="alert alert-success">Your Email has been verified.</div></div>';
        } else if($_GET['type']=='ur'){
            header("Location: http://localhost:8000/login.php?success");   
        }
    } 
    else{
    $msg = '<div class="mx-auto mt-5 " style="width: 50%;"><div class="alert alert-danger">Verification link has expired.</div></div>';   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email verification</title>
    <?php require "con_boot_css.php"; ?>
</head>
<body>
     <?php echo $msg; ?>
</body>
</html>