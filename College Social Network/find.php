<?php
    session_start();
    require 'not_loggedin.php'; 
    require 'con_db.php';
    require 'search.php';
    
    $msg='';$count = 0;
    
    if(! isset($_POST['find'])) {
        $sql = "select * from users where college = '{$_SESSION['user_college']}' ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - Find</title>
    <link rel="shortcut icon" type="image/jpg" href="background/download"/>
    <?php require 'con_boot_css.php'; ?>
</head>

<body class="bg-light">
    <?php require 'navbar.php';?>

    <div class="container">

        <div class="mb-3 bg-secondary p-2 border border-white rounded">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-row ">
                    <div class="col">
                        <legend class="text-white">Search by </legend>
                    </div>
                    <div class="col ">
                        <button type="submit" name="find" class=" float-right btn btn-primary font-weight-bold">submit</button>
                    </div>


                </div>
                <div class="form-row mt-1">
                    <div class="col ">
                        <input class="form-control" type="text" name="name" id="" placeholder="Name">
                    </div>
                    <div class="col ">
                        <input class="form-control" type="text" name="fsurname" id="" placeholder="Surname">
                    </div>
                    <div class="col ">
                        <input class="form-control" type="text" name="fenrl" id="" placeholder="Enrollment">
                    </div>
                </div>
                <div class="form-row mt-1">
                    <div class="col ">
                        <select class="form-control" name="funi" id="uni">
                            <option value="" selected disabled>University</option>

                            <?php

                            $uniData="SELECT * FROM university";
                            $result_uni=mysqli_query($conn,$uniData);
                            if(mysqli_num_rows($result_uni)>0)
                            {
                                while($arr_uni=mysqli_fetch_assoc($result_uni)) {
                            ?>

                            <option value="<?php echo $arr_uni['universityID']?>">
                                <?php echo $arr_uni['university_name']?>
                            </option>

                            <?php 
                                }
                            } 
                            ?>
                        </select>
                    </div>
                    <div class="col ">
                        <select class="form-control" name="fclg" id="college">
                            <option value="" selected disabled>College</option>
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col ">
                        <select class="form-control" name="fbranch" id="">
                            <option value="" selected disabled>Branch</option>

                            <?php
                            $branchData = "SELECT * FROM branch;";
                            $branchResult=mysqli_query($conn,$branchData);
                            if(mysqli_num_rows($branchResult)>0)
                            {
                                while($arrBranch=mysqli_fetch_assoc($branchResult)) {
                            ?>

                            <option value="<?php echo $arrBranch['branchID']?>"><?php echo $arrBranch['branch_name']?>
                            </option>

                            <?php
                                }
                            } 
                            ?>

                        </select>
                    </div>
                    <div class="col ">
                        <select class="form-control" name="frole" id="">
                            <option value="" selected disabled>User-Role</option>
                            <option value="S">Student</option>
                            <option value="P">Professor</option>
                            <option value="O">Other</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <?php
        echo $msg;
        
        if( !(mysqli_num_rows($result)>0) ) {
            echo '<div class="alert alert-info text-center font-weight-bold" role="alert"> No user found ! </div>';
        } else {
    ?>

        <table class="table table-light table-responsive-md table-hover table-bordered">
            <thead class="bg-dark text-white ">
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>Enrollment</th>
                    <th>branch</th>
                    <th>college</th>
                    <th>university</th>
                    <th>Request</th>
                    <th>message</th>
                </tr>

            </thead>
            <tbody class="">

                <?php
            $from = $_SESSION['user_id'];
            while ($row = mysqli_fetch_assoc($result)) {  
            
            $qclg = "select college_name from college where collegeID = '{$row['college']}' ;";
            $qclgresult = mysqli_query($conn,$qclg) or die($qclg + " : " +  mysqli_error($conn));
            $rowclg = mysqli_fetch_assoc($qclgresult);
    
            $quni = "select university_name from university where universityID =  '{$row['university']}' ;";
            $quniresult = mysqli_query($conn,$quni) or die($quni + " : " + mysqli_error($conn));
            $rowuni = mysqli_fetch_assoc($quniresult);
    
            $qbranch = "select branch_name from branch where branchID = '{$row['branch']}' ;";
            $qbranchresult = mysqli_query($conn,$qbranch) or die($qbranch + " : " + mysqli_error($conn));
            $rowbranch = mysqli_fetch_assoc($qbranchresult);
    ?>

                <tr>
                    <?php if($row['userID'] != $_SESSION['user_id']) { ?>

                    <td><?php echo ++$count ?></td>
                    <td><a href="/profile.php?uid=<?php echo $row['userID']; ?>" class="text-dark">
                            <?php echo $row['name'] . " " . $row['surname']; ?> </a></td>
                    <td><?php echo $row['enrollment']; ?></td>
                    <td><?php echo $rowbranch['branch_name']; ?></td>
                    <td><?php echo $rowclg['college_name']; ?></td>
                    <td><?php echo $rowuni['university_name']; ?></td>


                    <?php
                        $to = $row['userID'];
                        
                        $sql11 = "SELECT * FROM `relation` WHERE `from`='$from' AND `to`='$to'; ";
                        $result11 = mysqli_query($conn, $sql11) or die(mysqli_error($conn));

                        if( mysqli_num_rows($result11) <= 0) {
                            echo    '<td>' .
                                    '<a href="#" name="addFrndBtn" id=addFrnd' ."$to". ' onclick="addFriend(this.id);"> <i class="bi bi-person-plus-fill"></i> add Friend </a>'. 
                                    '</td> <td> </td>';
                        } else {
                            while( $row11 = mysqli_fetch_assoc($result11) ) {

                                $status = $row11['status'];
                                
                                if($status == "F") {
                                    echo '<td><a href="#" name="unFrndBtn" id=unFrnd' ."$to". ' onclick="unFriend(this.id);"> <i class="bi bi-person-minus-fill"></i> Unfriend </a></td>';
                                    echo  '<td><a href="/ChatApp/chat.php?userID='.$to.'"  onclick="window.open(this.href,\'newwindow\', \'width=400,height=700 \'); 
                                            return false; "><i class="bi bi-chat-text-fill"></i> message</a></td>';
                                } else if($status == "P") {
                                    echo '<td><a href="#" name="canceladdFrndBtn" id=canceladdFrnd' ."$to". ' onClick="canceladdFriend(this.id);">  Requested </a></td>';
                                } else if ($status == "B") {
                                    echo '<td><a href="#" name="unblockBtn" id=unblock' ."$to". ' onclick="unblock_user(this.id);">  Unblock </a></td>';
                                }
                            }
                        }
                    }
                    ?>
                </tr>

    <?php 
            }
                
        }
    ?>

            </tbody>
        </table>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/uni_clg_dropdown_ajax_script.js" type="text/javascript"></script>
    <script src="/relation.js"></script>
    <?php require 'prevent_resubmission.php'; ?>
    
</body>

</html>