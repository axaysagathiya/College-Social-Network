<?php
    require 'not_loggedin.php';
    require 'con_db.php';

    session_start();
    $myUID = $_SESSION['user_id'];
    if (! isset($_GET['uid'])) {
        echo "<div class='text-center font-weight-bold alert alert-secondary'> PAGE NOT FOUND ! </div>";
        die;
    }
    // $fromID='';$toID='';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - Friends</title>
    <link rel="shortcut icon" type="image/jpg" href="background/download"/>
    <?php require "con_boot_css.php"; ?>
</head>

<body>

    <div class="bg-secondary p-2">
        <div class="row">
            <div class="col-md-4">
                <a href="/profile.php?uid=<?php echo $myUID?>&action=friends&recievedR"
                    class="btn btn-light btn-block border font-weight-bold"> Recieved - Friends requests </a>
            </div>
            <div class="col-md-4">
                <a href="/profile.php?uid=<?php echo $myUID?>&action=friends&SentR"
                    class="btn btn-light btn-block border font-weight-bold"> Sent - Friend Requests</a>
            </div>
            <div class="col-md-4">
                <a href="/profile.php?uid=<?php echo $myUID?>&action=friends&allF"
                    class="btn btn-light btn-block border font-weight-bold"> List of Friend </a>
            </div>
        </div>
    </div>

    <div class="mt-3">

        <?php

        $headMsg=''; $emptyMsg='';

        //Recieved - Friend Requests
        if($_GET['action'] == "friends" && $_GET['uid'] == $myUID && isset($_GET['recievedR'])) {
            $sql = "SELECT * FROM `relation` WHERE `to`= $myUID AND `status`= 'P'; ";
            $headMsg = "Recieved - Friend Requests";$emptyMsg="NO REQUEST FOUND.";

        //Sent - Friend Requests
        } else if($_GET['action'] == "friends" && $_GET['uid'] == $myUID && isset($_GET['SentR'])) {
            $sql = "SELECT * FROM `relation` WHERE `from`= $myUID AND `status`= 'P'; ";
            $headMsg = "Sent - Friend Requests";$emptyMsg="NO REQUEST FOUND.";
            
        //List Of Friends
        } else if($_GET['action'] == "friends" && $_GET['uid'] == $myUID && isset($_GET['allF'])) {
            $sql = "SELECT * FROM `relation` WHERE `from`= $myUID AND `status`= 'F'; ";
            $headMsg = "Friends";$emptyMsg="NO FRIEND FOUND.";
        }

        $result = mysqli_query($conn , $sql) or die($sql);
        if(mysqli_num_rows($result) > 0) {
        ?>

        <legend><?php echo $headMsg; ?></legend>
        <hr>
        
        <table class="table table-light table-responsive-md table-hover table-striped table-bordered ">
            <thead class="bg-dark text-white ">
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>branch</th>
                    <th>college</th>
                    <th>university</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php
                
                $count = 1;
                while($row = mysqli_fetch_assoc($result)) { 

                    $sql2='';$fromID = $row['from']; $toID = $row['to'];

                    if($_GET['action'] == "friends" && $_GET['uid'] == $myUID && isset($_GET['recievedR'])) {
                        $sql2 = "SELECT * FROM users WHERE userID='$fromID'; ";
                        $action1 = '<a href="/relation_lib/acceptFrndRequest.php?fromID='. $fromID .' ">Accept</a>';
                        $action2 = '<a href="/relation_lib/rejectFrndRequest.php?fromID='. $fromID .' ">Reject</a>';

                    } else if($_GET['action'] == "friends" && $_GET['uid'] == $myUID && isset($_GET['SentR'])) {
                        $sql2 = "SELECT * FROM users WHERE userID='$toID'; ";
                        $action1 = '<a href="" id="canceladdFrnd' . $toID . ' " onClick="canceladdFriend(this.id);" >Cancel</a>'; $action2='';

                    } else if($_GET['action'] == "friends" && $_GET['uid'] == $myUID && isset($_GET['allF'])) {
                        $sql2 = "SELECT * FROM users WHERE userID='$toID'; ";
                        $action1 = '<a href="" id="unFriend' . $toID . ' " onClick="unFriend(this.id);" >Unfriend</a>';
                        $action2 = '<a href=""> Message</a></a>';
                    }
                    $result2 =  mysqli_query($conn , $sql2) or die($sql2);
                    
                    if(mysqli_num_rows($result2) > 0) {
                        while($row2 = mysqli_fetch_assoc($result2)) {

                        $qclg = "select college_name from college where collegeID = '{$row2['college']}' ;";
                        $qclgresult = mysqli_query($conn,$qclg) or die($qclg + " : " +  mysqli_error($conn));
                        $rowclg = mysqli_fetch_assoc($qclgresult);
                
                        $quni = "select university_name from university where universityID =  '{$row2['university']}' ;";
                        $quniresult = mysqli_query($conn,$quni) or die($quni + " : " + mysqli_error($conn));
                        $rowuni = mysqli_fetch_assoc($quniresult);
                
                        $qbranch = "select branch_name from branch where branchID = '{$row2['branch']}' ;";
                        $qbranchresult = mysqli_query($conn,$qbranch) or die($qbranch + " : " + mysqli_error($conn));
                        $rowbranch = mysqli_fetch_assoc($qbranchresult);
                    
                    ?>

                <tr>
                    <td><?php echo $count++ ;?></td>
                    <td><?php echo $row2['name'] .' '.$row2['surname']; ?></td>
                    <td><?php echo $rowbranch['branch_name']; ?></td>
                    <td><?php echo $rowclg['college_name']; ?></td>
                    <td><?php echo $rowuni['university_name']; ?></td>
                    <td><?php echo $action1 ;?></td>
                    <td><?php echo $action2 ;?></td>
                </tr>

                <?php } } }?>

            </tbody>
        </table>

        <?php 

            } else {
                echo "<div class='text-center font-weight-bold alert alert-info m-5'>". $emptyMsg ."</div>";
            }
?>





    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/relation.js"></script>
</body>

</html>