<?php

require 'con_db.php';

$terminate = false;
$msg = '';
$mymail = '';

if(isset($_GET['mail']) && $_GET['vkey'] ) {

    $vkey = $_GET['vkey'];
    $mymail = $_GET['mail'];

    $sql2 = "SELECT * FROM verification WHERE Email = '$mymail' AND verification_key = '$vkey';";
    $result2 = mysqli_query($conn,$sql2) or die(mysqli_error($conn));

    if(mysqli_num_rows($result2) <= 0) {
        $msg = '<div class="alert alert-danger">Verification link has expired.</div>';   
        $terminate = true;

    } 
} else if(isset($_POST['submit'])) {

    $pswd =$_POST['pswd'];
    $cpswd =$_POST['cpswd'];
    $mail = $_POST['mail'];

    if($pswd === $cpswd) {

        // echo "pswd=".$pswd.",  mail=".$mail;
        $sql1 = "UPDATE `users` SET `password`= '{$pswd}' WHERE `Email`='{$mail}'; ";
        $sql1 .= "DELETE FROM verification WHERE Email = '$mail';"; 
        $result1 = mysqli_multi_query($conn,$sql1);
        if($result1) {
            $msg = '<div class="alert alert-success">Password has been changed successfully. click here to <a href="/login.php">LogIn</a></div>';
            $terminate = true;
        } else {
            // $msg = $sql1;
            $msg = '<div class="alert alert-danger">internal error. </div>';
        }
    } else {
        $msg = '<div class="alert alert-danger"> confirm Password doesn\'t matched. </div>';
    }

} else {
    $msg = '<div class="alert alert-danger">unauthorized</div>';
    $terminate = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - Reset Password</title>
    <?php require "con_boot_css.php"; ?>
</head>
<body class="">

    <div class="d-flex justify-content-center mt-5">
        <div class="form-group bg-white shadow-lg border">
            <?php
                echo $msg;
                if($terminate) {
                    die;
                }
            ?>
            <legend class="p-2 bg-secondary text-white">Reset Password</legend>
            <div class="p-4 ">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" accept-charset="utf-8">
                    <div class="form-group">
                        <!-- <label for="pswd">Enter New Password.</label> -->
                        <input class="form-control " type="password" name="pswd" id="" placeholder="New Password">
                        <br>
                        <!-- <label for="cpswd"> confirm Enter New Password</label> -->
                        <input class="form-control " type="password" name="cpswd" id="" placeholder="Confirm New Password">
                        <br>
                        <input type="hidden" name="mail" value="<?php echo $mymail; ?>">
                        <button class="btn btn-primary btn-block" name="submit" type="submit">submit</button>
                        <a href="/login.php">LogIn</a>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <?php       
    require 'prevent_resubmission.php';
    ?>
</body>
</html>