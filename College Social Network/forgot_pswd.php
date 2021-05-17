<?php
 require_once("con_db.php");
 session_start();

 if(isset($_POST['submit'])) {
     if(!empty($_POST['email'])) {
        $to = $_POST['email'];
        // $user_name = ''; //$_SESSION['user_name'];
        $sql = "select * from users where Email = '$to';";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_name = $row['name'];
            $vkey = '';

            $sql1 = "select * from verification where Email = '$to';";
            $result1 = mysqli_query($conn, $sql1);

            if(mysqli_num_rows($result1) > 0) { 
                $row1 = mysqli_fetch_assoc($result1);
                $vkey = $row1['verification_key'];
            } else {
                $vkey = md5(time().$user_name);
                $sql4 = "INSERT INTO verification VALUES('$to','$vkey'); ";
                $result4 = mysqli_query($conn,$sql4) or die($sql4); 
            }

            $subject = "CSN - Reset Password Link";
            $mail_msg = "hey $user_name ! <br /> 
                        Please <a href='http://localhost:8000/reset_pswd.php?vkey=$vkey&mail=$to'>Click Here</a> to reset your password <br/><br/>
                        OR you can copy below link and paste it in browser <br />
                        <a href='http://localhost:8000/reset_pswd.php?vkey=$vkey&mail=$to'>http://localhost:8000/reset_pswd.php?vkey=$vkey&mail=$to </a>";
         
            require 'sendmail.php';
        
        } else {
            $msg = '<div class="alert alert-danger">user not found</div>';
        }
     
     } else {
        $msg =  '<div class="alert alert-danger">Enter your Email</div>';
     }
 }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require 'con_boot_css.php'; ?>
</head>

<body class="bg-light">
    <?php require_once("navbar.php"); ?>

    <div class="d-flex justify-content-center ">
        <div class=" form-group ">
            <?php echo $msg; ?>
            <legend>Forgot Password</legend>
            <div class="border p-5 bg-white">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" accept-charset="utf-8">
                    <div class="form-group">
                        <label for="email">Enter your email and we'll send you a link to get back into your
                            account.</label>
                        <input class="form-control " type="text" name="email" id="" placeholder="your email address">
                        <br>
                        <button class="btn btn-primary btn-block" name="submit" type="submit">submit</button>
                        <a href="/login.php">LogIn</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
    <?php require 'prevent_resubmission.php'; ?>

</body>

</html>