<!-- link for sort table example :   https://www.w3schools.com/howto/howto_js_sort_table.asp -->

<?php
    require '../not_loggedin.php';
    require '../is_admin_loggedin.php';

    require '../con_db.php';
    $sql = "SELECT * FROM users WHERE `college`={$_SESSION['user_college']} ORDER BY enrollment ASC";
    $result = mysqli_query($conn,$sql) or die($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - Students</title>
    <link rel="stylesheet" href="../css/csn.css">
    <?php require '../con_boot_css.php' ?>
</head>

<body class="bgclr">

    <?php require '../navbar.php'; ?>

    <div class='container mt-3'>

    <legend>users</legend><hr>
    <?php if(mysqli_num_rows($result) > 0 ) { ?>
        <a href="add_student.php" class="btn btn-secondary">add student +</a>
        <a href="requests.php" class="btn btn-secondary">Approve Request +</a>
        <table class="table table-responsive table-striped table-light ">
            <thead class="bg-info">
                <tr>
                <th scope="col">Enrollment</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">College</th>
                    <th scope="col">University</th>
                    <th scope="col">Branch</th>
                    <th scope="col">role</th>
                    <!-- <th scope="col"></th> -->
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

            <?php 
                while($row = mysqli_fetch_assoc($result) ){  

                    $qclg = "select college_name from college where collegeID = " . $row['college'];
                    $qclgresult = mysqli_query($conn,$qclg) or die($qclg + " : " +  mysqli_error($conn));
                    $rowclg = mysqli_fetch_assoc($qclgresult);

                    $quni = "select university_name from university where universityID = " . $row['university'];
                    $quniresult = mysqli_query($conn,$quni) or die($quni + " : " + mysqli_error($conn));
                    $rowuni = mysqli_fetch_assoc($quniresult);

                    $qbranch = "select branch_name from branch where branchID = " . $row['branch'];
                    $qbranchresult = mysqli_query($conn,$qbranch) or die($qbranch + " : " + mysqli_error($conn));
                    $rowbranch = mysqli_fetch_assoc($qbranchresult);
            ?>
                <tr>
                <th scope="row"><?php echo $row['enrollment'];?></th>
                    <td><?php echo $row['name'] .' '.$row['surname'];?></td>
                    <td><?php echo $row['Email'];?></td>
                    <td><?php echo $rowclg['college_name'];?></td>
                    <td><?php echo $rowuni['university_name'];?></td>
                    <td><?php echo $rowbranch['branch_name'];?></td>
                    <td><?php echo $row['role'];?></td>
                    <!-- <th><a class='btn btn-outline-success p-1' href='std_update1.php?Email=<?php // echo $row['Email']; ?>'>UPDATE</a></th> -->
                    <th><a class='btn btn-outline-danger p-1' href='std_delete.php?Email=<?php echo $row['Email']; ?>'>DELETE</a></th>
                </tr>
                <?php } ?>
        </table>
    </div>

    <?php }else{
        echo '<div class="mx-auto mt-5 " style="width: 500px;"><div class="alert alert-info text-center font-weight-bold">No data found.</div></div>';   
    } 
        
        mysqli_close($conn);
    ?>

</body>

</html>