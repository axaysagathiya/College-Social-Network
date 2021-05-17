<?php 

require 'con_db.php'; 
$msg = '';

if(isset($_POST['save'])){
    $temp_enrollment = $_POST['enrollment'];
    $user_enrollment = !empty($temp_enrollment) ? "'$temp_enrollment'" : 'NULL';
    $user_name = $_POST['name'];
    $user_surname = $_POST['surname'];
    $user_gender = $_POST['gender'];
    $user_role = $_POST['role'];
    $temp_sem = $_POST['sem'];
    $user_sem = !empty($temp_sem) ? "'$temp_sem'" : 'NULL';
    $user_branch = $_POST['branch'];
    $user_college = $_POST['college'];
    $user_uni = $_POST['uni'];
    $user_mail = $_POST['mail'];
    $user_mobile = $_POST['mobile'];
    $user_password = $_POST['password'];
    $user_confirm_password = $_POST['confirm_password'];

    $sql1 = "SELECT * FROM users_request WHERE enrollment=$user_enrollment OR Email='$user_mail' ";
    $result1 = mysqli_query($conn,$sql1) or die($sql1);

    if(mysqli_num_rows($result1) > 0) {
        $msg = '<div class="alert alert-danger" >already requested for registration.Please wait for approval.</div>';
    }

    else{
        $sql2 = "SELECT * FROM users WHERE enrollment=$user_enrollment OR Email='$user_mail' ";
        $result2 = mysqli_query($conn,$sql2) or die($sql2);

        if(mysqli_num_rows($result2) > 0) {
            $msg = '<div class="alert alert-danger" >already registered. click here for <a href="login.php">Log in</a></div>';
        }

        else{
                $targetdir = 'avatar/';
                $filename = $_FILES['upload']['name'];
                $temp_name = $_FILES['upload']['tmp_name'];
        
                $filename   = uniqid() . "-" . time(); // 5dab1961e93a7-1571494241
                $extension  = pathinfo( $filename, PATHINFO_EXTENSION ); // jpg
                $filename1   = $filename . '.' . $extension; 
        
                $target_path = $targetdir . $filename1;
        
                move_uploaded_file($temp_name,$target_path);


            $sql3 = "INSERT INTO users_request(`enrollment`,`name`,`surname`,`gender`,`role`,`sem`,`branch`,`college`,`university`,`Email`,`mobile`,`password`, `status`, `img`)
                    VALUES($user_enrollment,'$user_name','$user_surname','$user_gender','$user_role',$user_sem,'$user_branch','$user_college','$user_uni','$user_mail','$user_mobile','$user_password', 'offline now' , '$filename1' )";

            if($user_password == $user_confirm_password ){

                if($result3 = mysqli_query($conn,$sql3)){

                    $vkey = md5(time().$user_name);
                    $sql4 = "INSERT INTO verification VALUES('$user_mail','$vkey'); ";
                    $result4 = mysqli_query($conn,$sql4) or die($sql4); 

                    $to = "$user_mail";
                    $subject = "Welcome to CSN.";
                    $mail_msg = "hey $user_name ! <br />
                                you have successfully requested for the registration,
                                please wait for approval. <br /> <br /> 
                                Please <a href='http://localhost:8000/verifymail.php?vkey=$vkey&mail=$user_mail&type=ur'>Click Here</a> to verify your Email";
                    
                    require 'sendmail.php';

                    echo '<input type="hidden" name="mailHidden" id="mailHidden" value="' . $to . '">';
                    $msg = "<div class='alert alert-success'> Requested for registration. please verify your Email & wait for approval.<br/> <a href='resend_verification_mail.php?mail=$to' id='resend' name='resend' >resend</a> verification mail </div>";                        
                } else{
                    $msg = "<div class='alert alert-danger'> Oops! Something went wrong. </div>" . $sql3;
                    //echo $sql3; 
                    mysqli_error($conn);
                }
            }
            else{
                $msg = "<div class='alert alert-danger'>Confirm Password doesn not matched.</div>";
            }
        }
    }
    // mysqli_close($conn);
}
// }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN-create new account</title>
    <?php require 'con_boot_css.php'; ?>
    <link rel="stylesheet" href="css/csn.css">


</head>

<body class="bg-dark">
    <?php require_once 'navbar.php'; ?>
    <div class=" container my-2">
        <div class="border shadow  bg-white px-5 py-4">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" accept-charset="utf-8"
                class="form " autocomplete="off">
                <?php echo $msg; ?>
                <legend>Create Account</legend>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="user-name">Name</label>
                        <input required type="text" class="form-control" name="name" id="inputName"
                            placeholder="Enter First Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="user-surname">Surname</label>
                        <input required type="text" class="form-control" name="surname" id="inputSurname"
                            placeholder="Enter Last Name (Surname)">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="user-name">Gender</label>
                        <select required name="gender" id="inputState" class="form-control">
                            <option selected disabled>Select Gender</option>
                            <option value="M">MALE</option>
                            <option value="F">FEMALE</option>
                            <option value="O">OTHER</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="user-name">User Role</label>
                        <select required name="role" class="form-control">
                            <option selected disabled>User Role</option>
                            <option value='S'>Student</option>
                            <option value='P'>Professor</option>
                            <option value='O'>other</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="user-name">Semester(for student only)</label>
                        <select name="sem" id="sem" class="form-control">
                            <option disabled selected>Semester</option>
                            <option value='1'>1st</option>
                            <option value='2'>2nd</option>
                            <option value='3'>3rd</option>
                            <option value='4'>4th</option>
                            <option value='5'>5th</option>
                            <option value='6'>6th</option>
                            <option value='7'>7th</option>
                            <option value='8'>8th</option>
                        </select>
                    </div>
                </div>

                <!-- university & college dropdown start.  -->

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <select required id="uni" name='uni' class="form-control">
                            <option selected disabled>Select University</option>

                            <?php

                        $uniData="SELECT * FROM university";
                        $result=mysqli_query($conn,$uniData);
                        if(mysqli_num_rows($result)>0)
                        {
                          while($arr=mysqli_fetch_assoc($result))
                          {
            
                        ?>

                            <option value="<?php echo $arr['universityID']?>"><?php echo $arr['university_name']?>
                            </option>

                            <?php
                        }} 
                    ?>

                        </select>

                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" name="" id="add_uni" class="form-control"
                            placeholder="write your university name if not in the list">
                        <small id="msg1"></small>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="button" value="Add University" id="add_uni_btn"
                            class="form-control btn btn-light border border-dark">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <select required id="college" name="college" class="form-control">
                            <option value="" selected disabled>College Name</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" name="" id="add_clg" class="form-control"
                            placeholder="write your college name if not in the list">
                        <small id="msg2"></small>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="button" value="Add College" id="add_clg_btn"
                            class="form-control btn btn-light border border-dark">
                    </div>
                </div>

                <!-- university & college dropdown End.  -->

                <!-- branch dropdown start -->
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <select id="branch" name='branch' class="form-control">
                            <option value="" selected disabled>Branch Name</option>
                            <?php

                        $branchData = "SELECT * FROM branch;";
                        $branchResult=mysqli_query($conn,$branchData);
                        if(mysqli_num_rows($branchResult)>0)
                        {
                          while($arrBranch=mysqli_fetch_assoc($branchResult))
                          {
            
                        ?>

                            <option value="<?php echo $arrBranch['branchID']?>"><?php echo $arrBranch['branch_name']?>
                            </option>

                            <?php
                        }} 
                    ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" name="" id="add_branch" class="form-control"
                            placeholder="write your Branch name if not in the list">
                        <small id="msg3"></small>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="button" value="Add Branch" id="add_branch_btn"
                            class="form-control btn btn-light border border-dark">
                    </div>
                </div>
                <!-- branch dropdown End -->

                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="InputEmail">Email address</label>
                        <input required type="email" class="form-control" id="mail" name="mail"
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Enter Email address ">
                        <small>example : xyz@gmail.com</small>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputmobile">Mobile number</label>
                        <input required type="text" class="form-control" id="mobile" name="mobile"
                            placeholder="Enter Mobile number" pattern="^\d{10}$">
                        <small>Enter 10 digit number.</small>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword">Enrollment number(for student only)</label>
                        <input type="text" name="enrollment" id="enrollment" class="form-control"
                            placeholder="Your Enrollment" pattern="^\d{12}$">
                        <small>Enter 12 digit number.</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputPassword">Password</label>
                        <input required type="password" name="password" value="" class="form-control "
                            placeholder="Password">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Confirm Password</label>
                        <input required type="password" name="confirm_password" value="" class="form-control"
                            placeholder="Confirm Password">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="myImage">Upload profile picture</label>
                        <input required type="file" name="myImage" accept="image/*" />
                    </div>
                    <div class="form-group col-md-3">
                        <button name="save" class="btn btn-primary btn-block mt-1 mb-1" type="submit">Create
                            account</button>
                        <span>Already have an account? <a href="/login.php"> Login</a> </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/uni_clg_dropdown_ajax_script.js" type="text/javascript"></script>
    <?php require 'prevent_resubmission.php'; ?>

</body>

</html>