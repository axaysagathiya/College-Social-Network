<?php 
    session_start();
    require '../not_loggedin.php';
    require '../is_admin_loggedin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - Admin</title>
    <link rel="stylesheet" href="../css/bg.css">
    <?php require '../con_boot_css.php'?>
</head>
<!-- <body class="bg1" > -->
<body style="background-color: #f5f6fa">
    <?php require '../navbar.php'?>

    <div class="mx-auto " style="width: 500px;">
        <a class="btn btn-lg btn-dark btn-block mt-5" href="requests.php" >Approve / Reject Requests For Student-user</a>
        <a class="btn btn-lg btn-dark btn-block mt-5" href="students.php" >List Of Student-Users</a>
        <a class="btn btn-lg btn-dark btn-block mt-5" href="add_student.php" >Register New Student-User </a>
    </div>

</body>
</html>