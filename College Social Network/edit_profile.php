<?php
require "not_loggedin.php";
$msg=""; $mail_change = '';

$tmpurl = "profile.php?uid=".$_SESSION['user_id']."&action=editProfile";

if(isset($_POST['editProfile-btn'])) {
    require "con_db.php";

    $old_mail = $_SESSION['user_mail'];
    
    $new_mail  = $_POST['new_mail'];
    $new_mobile = $_POST['new_mobile'];
    $new_sem  = $_POST['new_sem'];

    $sql = "UPDATE users SET Email = '$new_mail' , mobile = '$new_mobile' , sem = '$new_sem' WHERE Email='$old_mail'; ";
    $result = mysqli_query($conn,$sql) or die($sql);

    if (!$result) {
        echo("Error description: " . mysqli_error($conn) );
      } else {
        $_SESSION['user_mail'] = $new_mail;
        $_SESSION['user_mobile'] = $new_mobile;
        $_SESSION['user_sem'] = $new_sem;
        

        if($old_mail != $new_mail) {

            $vkey = md5(time().$_SESSION['user_name']);
            $sql4 = "UPDATE users SET is_verified = '0' WHERE Email = '$old_mail';";
            $sql4 .= "DELETE FROM verification WHERE Email = '$old_mail';";
            $sql4 .= "INSERT INTO verification VALUES('$new_mail','$vkey'); ";
            $result4 = mysqli_multi_query($conn,$sql4) or die($sql4); 

            $to = "$new_mail";
            $subject = "Welcome to CSN.";
            $mail_msg = "<b>hey {$_SESSION['user_name']} ! </b> <br />
                        <strong>you have successfully changed your email address,</strong> <br /><br /> 
                        Please <a href='http://localhost:8000/verifymail.php?vkey=$vkey&mail=$new_mail&type=u'>Click Here</a> to verify your Email";
            
            require 'sendmail.php';
            $mail_change = "please verify your Email address.";
        }
        $msg = "<div class='alert alert-success' role='alert'>Edited Successfully,  {$mail_change}</div>";
    }
    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="<?php echo $tmpurl ?>" method="post" name="editPprofile-form"
        accept-charset="utf-8" class="form container  px-2">
        <?php  echo $msg; ?>
        <legend>Edit Profile</legend>
        <hr>

        <div class="form-row">

            <div class="form-group col-md-4">
                <label for="InputEmail">Email address</label>
                <input required type="email" class="form-control" id="new_mail" name="new_mail"
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Enter Email address "
                    value="<?php echo $_SESSION['user_mail']; ?>">
                <small>example : xyz@gmail.com</small>
            </div>

            <?php  if( $_SESSION['user_role'] == 'S') { ?>

            <div class="form-group col-md-4">
                <label for="inputmobile">Mobile number</label>
                <input required type="text" class="form-control" id="new_mobile" name="new_mobile"
                    placeholder="Enter Mobile number" pattern="^\d{10}$"
                    value="<?php echo $_SESSION['user_mobile']; ?>">
                <small>Enter 10 digit number.</small>
            </div>

            <div class="form-group col-md-4">
                <label for="user-name">Semester(for student only)</label>
                <select name="new_sem" id="new_sem" class="form-control">
                    <option disabled <?php if($_SESSION['user_sem']==NULL){echo "selected";} ?>>Semester</option>
                    <option <?php if($_SESSION['user_sem']==1){echo "selected";} ?> value='1'>1st</option>
                    <option <?php if($_SESSION['user_sem']==2){echo "selected";} ?> value='2'>2nd</option>
                    <option <?php if($_SESSION['user_sem']==3){echo "selected";} ?> value='3'>3rd</option>
                    <option <?php if($_SESSION['user_sem']==4){echo "selected";} ?> value='4'>4th</option>
                    <option <?php if($_SESSION['user_sem']==5){echo "selected";} ?> value='5'>5th</option>
                    <option <?php if($_SESSION['user_sem']==6){echo "selected";} ?> value='6'>6th</option>
                    <option <?php if($_SESSION['user_sem']==7){echo "selected";} ?> value='7'>7th</option>
                    <option <?php if($_SESSION['user_sem']==8){echo "selected";} ?> value='8'>8th</option>
                </select>
            </div>

            <?php } ?>

        </div>
        <div class="form-row">
            <label>Change profile picture : &nbsp</label>
            <input name="upload[]" type="file" id="uploadpic" multiple="multiple" class="btn btn-light" />
        </div>
        <button name="editProfile-btn" class="btn btn-primary btn-block mt-3 mb-1" type="submit">SUBMIT</button>
    </form>
    <?php require 'prevent_resubmission.php'; ?>
</body>

</html>