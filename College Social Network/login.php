<?php
    session_start();
    $msg = '';

    if(isset($_GET['success'])) {
            $msg='<div class="center alert alert-success alert-dismissible fade show" role="alert" style="text-align: center;">
                    <strong>Your Email has been verified.</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    }

    if(isset($_SESSION['user_name'])){
    header("Location: http://localhost:8000/post.php");
  }

  if(isset($_POST['login'])){
      require 'con_db.php';
  
    //   $input_enrollment = $_POST["enrollment"];
      $input_mail = $_POST["mail"];
      $input_password = $_POST["password"];
  
      $sql = "SELECT * FROM users WHERE Email='$input_mail' AND password='$input_password'; ";
  
      $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
  
      if(mysqli_num_rows($result) == 1) {
          while($row = mysqli_fetch_assoc($result)){
  
            $sql2 = "UPDATE `users` SET `status`= 'Online now' WHERE `Email` = '{$row['Email']}' ;";
            $result2 = mysqli_query($conn, $sql2);
            if(!$result2) {
                echo $sql2; die;
            }

              $_SESSION['user_id'] = $row['userID'];
              $_SESSION['user_name'] = $row['name'];
              $_SESSION['user_surname'] = $row['surname'];
              $_SESSION['user_role'] = $row['role'];
              $_SESSION['user_mail'] = $row['Email'];
              $_SESSION['user_branch'] = $row['branch'];
              $_SESSION['user_college'] = $row['college'];
              $_SESSION['user_uni'] = $row['university'];
              $_SESSION['user_mobile'] = $row['mobile'];
              $_SESSION['user_sem'] = $row['sem'];
              $_SESSION['user_enrollment'] = $row['enrollment'];
  
              $sql_admin_check = "select * from admin_users where userID = {$_SESSION['user_id']} " ;
              $result_admin_check = mysqli_query($conn,$sql_admin_check) or die($sql_admin_check);
              
              if(mysqli_num_rows($result) == 1) {
                  while($row_admin_check = mysqli_fetch_assoc($result_admin_check)){
                      
                      $_SESSION['is_admin_user'] = 1;
              
                  }
              }            
          }
  
  
        //   $msg = '<div class="alert alert-success">LogIn Successfully. </div>';
          header("Location: http://localhost:8000/post.php");
      }else{
          $msg = '<div class="alert alert-danger">incorrect Enrollment / password.</div>';
      }
  
      mysqli_close($conn);
  }
  

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - LogIn</title>
    <link rel="shortcut icon" type="image/jpg" href="background/download"/>
    <?php require 'con_boot_css.php'?>
    <link rel="stylesheet" href="css/csn.css">
</head>

<body class="bg-light w-100" style="overflow-x: hidden;">

    <?php require 'navbar.php'; ?>

    <div class="">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3"></div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="shadow-lg bg-white border mx-auto p-5 mt-5">
                    <?php echo $msg; ?>
                    <form autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"
                        accept-charset="utf-8" class="form" role="form">
                        <legend >LOG IN HERE</legend>
                        <!-- <input required autofocus type="number" name="enrollment" value="" class="form-control input-lg my-2" placeholder="Your Enrollment"> -->
                        <input required autofocus type="text" name="mail" value="" class="form-control input-lg my-2"
                            placeholder="Your Email address">

                        <input required type="password" name="password" value="" class="pswd form-control input-lg my-2"
                            placeholder="Password">
                        <button name="login" class="btn btn-lg btn-dark btn-block signup-btn" type="submit">LOG
                            IN</button>
                        <a href="/forgot_pswd.php" >forgot password?</a>
                        <p class="float-right ">Don't have an account?<a href="/registration_form.php" > Create New</a></p>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3"></div>
        </div>

        <?php require 'con_boot_js.php'?>
        <?php require 'prevent_resubmission.php'?>
    </div>
</body>

</html>