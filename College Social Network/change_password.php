<?php
    require "not_loggedin.php";
    $msg = '';

    if(isset($_POST['changePassword-btn'])) {
        require 'con_db.php';

        $user_id = $_SESSION['user_id'];
        $curr_pswd = $_POST['current_password'];
        $new_pswd = $_POST['new_password'];
        $confirm_new_pswd = $_POST['confirm_new_password'];

        $sql = "select * from users where userID='$user_id' and password='$curr_pswd'; ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if(mysqli_num_rows($result) > 0) {
            if($new_pswd == $confirm_new_pswd) {
                $sql1 = "UPDATE users SET password='$new_pswd' WHERE userID='$user_id'; ";
                $result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));

                $msg = "<div class='alert alert-success'>Your password has been changed successfully.</div>";
            } else {
                $msg = "<div class='alert alert-danger'>confirm password does not matched.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Incorrect current password. </div>";
        }

    }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>change password</title>
</head>

<body>
    <form action="<?php echo 'profile.php?action=changePassword' ?>" method="post" name="form" accept-charset="utf-8"
        class="form container  px-2">
        <?php echo $msg; ?>
        <legend>Change Password</legend>
        <hr>
        <div class="form-group ">
            <label for="current_password">Current Password</label>
            <input required type="password" name="current_password" value="" class="form-control "
                placeholder="Current Password">
        </div>
        <div class="form-group ">
            <label for="new_password">New Password</label>
            <input required type="password" name="new_password" value="" class="form-control "
                placeholder=" New Password">
        </div>
        <div class="form-group ">
            <label for="confirm_new_password">Confirm New Password</label>
            <input required type="password" name="confirm_new_password" value="" class="form-control"
                placeholder="Confirm New Password">
        </div>
        <button name="changePassword-btn" class="btn btn-primary btn-block mt-1 mb-1" type="submit">SUBMIT</button>
    </form>
    <?php require 'prevent_resubmission.php'; ?>
</body>

</html>