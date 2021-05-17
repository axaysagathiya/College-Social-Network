<?php 
require "not_loggedin.php";
session_start();
$userID = $_GET['uid'];
require "con_db.php";

$sql = mysqli_query($conn, "select * from users where userID='{$userID}';");
if(mysqli_num_rows($sql) <= 0) {
    echo "NO DATA FOUND !"; die;
}
$rowPro = mysqli_fetch_assoc($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="shortcut icon" type="image/jpg" href="background/download" />
    <link rel="stylesheet" href="css/csn.css">
    <?php require "con_boot_css.php"; ?>
</head>

<body class=" bg-light">
    <?php require "navbar.php"?>

    <div class="container">
    <div class="responseMsg"></div>
        <div class="row mt-3">

            <?php 
        if(isset($_SESSION['user_id'])) {
            if($_SESSION['user_id'] == $userID) { 
        ?>

            <div class="col-md-3">
                <div class="bg-white shadow border rounded p-3 mb-5">
                    <div class="row">
                        <div class="col-md-4"> 
                        <?php
                            echo "<img src='/avatar/". $rowPro['img'] ."' alt='Avatar' class='avatarBig'>";
                        ?>
                        </div>

                        <div class="col-md-8 ">
                            <?php

                            if(isset($_SESSION['is_admin_user'])) {echo "(ADMIN) <br/>";}
                            $myid = $_SESSION['user_id'];
                            echo "<a href='/profile.php?uid=$myid'>" . $_SESSION['user_name'] ." ".$_SESSION['user_surname'] . "</a> <br/>";
                            echo "user role =  ";
                            if($_SESSION['user_role'] == 'S') {echo "Student";}
                            if($_SESSION['user_role'] == 'P') {echo "Professor";}
                        ?>
                        </div>
                    </div>

                    <hr>

                    <div class="row  m-2">
                        <a class="btn btn-outline-dark btn-block"
                            href="/profile.php?uid=<?php echo $userID?>&action=editProfile">Edit
                            Profile</a>
                        <a class="btn btn-outline-dark btn-block"
                            href="/profile.php?uid=<?php echo $userID?>&action=changePassword">
                            Change Password </a>
                        <a class="btn btn-outline-dark btn-block"
                            href="/profile.php?uid=<?php echo $userID?>&action=myPost">My Posts</a>
                        <a class="btn btn-outline-dark btn-block"
                            href="/profile.php?uid=<?php echo $userID?>&action=myProd"> My Products for sale</a>
                        <a class="btn btn-outline-dark btn-block"
                            href="/profile.php?uid=<?php echo $userID?>&action=friends&allF">Friends</a>
                    </div>
                </div>
            </div>

            <?php
            }
        }   
        ?>

            <div class="col-md-9 p-4 bg-white shadow rounded border p-3 mb-5">
                <!-- <div class=""> -->
                <?php

                    if(isset($_GET['uid']) && !isset($_GET['action'])) {

                        $qclg = "select college_name from college where collegeID = '{$rowPro['college']}' ;";
                        $qclgresult = mysqli_query($conn,$qclg) or die($qclg + " : " +  mysqli_error($conn));
                        $rowProclg = mysqli_fetch_assoc($qclgresult);

                        $quni = "select university_name from university where universityID =  '{$rowPro['university']}' ;";
                        $quniresult = mysqli_query($conn,$quni) or die($quni + " : " + mysqli_error($conn));
                        $rowProuni = mysqli_fetch_assoc($quniresult);

                        $qbranch = "select branch_name from branch where branchID = '{$rowPro['branch']}' ;";
                        $qbranchresult = mysqli_query($conn,$qbranch) or die($qbranch + " : " + mysqli_error($conn));
                        $rowProbranch = mysqli_fetch_assoc($qbranchresult);

                        
                        if(isset($_SESSION['user_id'])) {
                            if($_SESSION['user_id'] != $userID) { 

                                echo "<img id ='imgid' src='/avatar/". $rowPro['img'] ."' alt='Avatar' class='avatarBig m-3'><br />";

                                $sql11 = "SELECT * FROM `relation` WHERE `from`='{$_SESSION['user_id']}' AND `to`='$userID'; ";
                                $result11 = mysqli_query($conn, $sql11) or die(mysqli_error($conn));
        
                                if( mysqli_num_rows($result11) > 0 ) {
                                    while( $row11 = mysqli_fetch_assoc($result11) ) {
        
                                        $status = $row11['status'];
                                        
                                        if($status == "F") {
                                            echo '<a href="#" class="btn btn-sm btn-primary m-2" name="unFrndBtn" id=unFrnd' ."$userID". ' onclick="unFriend(this.id);"> <i class="bi bi-person-minus-fill"></i> Unfriend </a>';
                                        } else if($status == "P") {
                                            echo '<a href="#" class="btn btn-sm btn-primary m-2" name="canceladdFrndBtn" id=canceladdFrnd' ."$userID". ' onClick="canceladdFriend(this.id);">  Requested </a>';
                                        } 
                                        if ($status == "B") {
                                            echo '<a href="#" class="btn btn-sm btn-secondary float-right m-2" name="unblockBtn" id=unblock' ."$userID". ' onclick="unblock_user(this.id);">  Unblock </a>';
                                        } else {
                                            echo '<a href="#" class="btn btn-sm btn-secondary float-right m-2" name="unblockBtn" id=block' ."$userID". ' onclick="block_user(this.id);">  Block </a>';
                                            echo '<a href="/ChatApp/chat.php?userID='.$userID.'" id="msg_btn" class="btn btn-sm btn-primary" onclick=\''. 'window.open(this.href,"newwindow","width=400,height=700"); return false;\' '.'>Message</a>';
                                        }
                                    }
                                } else {
                                    echo '<a href="#" class="btn btn-sm btn-primary m-2" name="addFrndBtn" id=addFrnd' ."$userID". ' onclick="addFriend(this.id);"> <i class="bi bi-person-plus-fill"></i> Add Friend </a>';
                                    echo '<a href="#" class="btn btn-sm btn-secondary float-right m-2" name="unblockBtn" id=block' ."$userID". ' onclick="block_user(this.id);">  Block </a>';

                                }
                            } else {
                                
                            }
                        }

                    ?>

                        <table class="table table-responsive m-2">
                            <tr>
                                <th>Name</th>
                                <td><?php echo $rowPro['name'] . " " . $rowPro['surname'] ;?></td>
                            </tr>
                            <tr>
                                <th>Enrollment number</th>
                                <td><?php echo $rowPro['enrollment'];?></td>
                            </tr>
                            <tr>
                                <th>college</th>
                                <td><?php echo $rowProclg['college_name'] ;?></td>
                            </tr>
                            <tr>
                                <th>branch</th>
                                <td><?php echo $rowProbranch['branch_name'];?></td>
                            </tr>
                            <tr>
                                <th>university</th>
                                <td><?php echo $rowProuni['university_name'];?></td>
                            </tr>
                            <tr>
                                <th>email</th>
                                <td><?php echo $rowPro['Email'];?></td>
                            </tr>
                        </table>

                    <?php
                    } 
                    

                    else if(isset($_GET['action']) && $_SESSION['user_id'] == $userID) { 
                        if($_GET['action'] == "editProfile") {
                            require 'edit_profile.php';
                        }
                        if($_GET['action'] == "changePassword") {
                            require 'change_password.php';
                        }
                        if($_GET['action'] == "myPost") {
                            // echo "Not Developed Yet";
                            require 'myPost.php';
                        }
                        if($_GET['action'] == "myProd") {
                            // echo "Not Developed Yet";
                            require 'myProd.php';
                        }
                        if($_GET['action'] == "friends") {
                            // echo "Not Developed Yet";
                            require 'friends.php';
                        }
                    } else {
                        echo '<div class="alert alert-danger text-center font-weight-bold"> unauthorized !</div>';
                    }

                    ?>

                <!-- </div> -->
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/relation.js"></script>
</body>

</html>