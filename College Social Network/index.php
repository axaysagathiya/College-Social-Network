<?php session_start();

if(isset($_SESSION['user_name'])) {
    header("Location: http://localhost:8000/post.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CollegeSocialNetwork</title>
    <link rel="shortcut icon" type="image/jpg" href="background/download"/>
    <?php require 'con_boot_css.php'?>
    <link rel="stylesheet" href="css/bg.css">
</head>
<!-- <body class="bg1" > -->
<body >
    
    <?php // require 'navbar.php'; ?>
    
    <?php require 'login.php'; ?>
    
</body>
</html>

<?php require 'prevent_resubmission.php'; ?>
