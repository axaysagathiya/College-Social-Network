<?php
    require "con_db.php";
    session_start();
    $logged_in = isset($_SESSION['user_name']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once 'con_boot_css.php'; ?>
    <link rel="stylesheet" href="/css/csn.css">
</head>

<body>
    <div class="container-fluid p-0 m-0 sticky-top">
        <div id="navbar navbar-expand-lg">
            <nav class="navbar navbar-light shadow-sm mb-3 bg-body navbar-expand-lg"
                style="background-color: #ffffff; ">
                <!-- <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-dark"> -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a class="navbar-brand px-2 " href="" style="pointer-events: none; cursor: default;">
                    <img src="/background/download" style="max-width:35px;">
                    <strong>C<small>ollege</small>S<small>ocial</small>N<small>etwork</small> </strong>
                </a>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item ">

                            <?php
                                if($logged_in) {
                                    $homenav='/post.php';
                                } else {
                                    $homenav='/index.php';
                                  }
              
                            echo'<a class="nav-link" href="'.$homenav.'"  target="_self">Home</a>
                        </li>';


                        if($logged_in) {
                    ?>

                        <li class="nav-item">
                            <a class="nav-link" href="/find.php">Find</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="window.open('/ChatApp/users.php','newwindow','width=400,height=700'); 
                                return false;">Messanger</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/buy_prod_ad.php" >Buy/Sell ads</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="/zoom-meeting">Meeting</a>
                        </li> -->

                        <?php
                        }                                   
                        if(isset($_SESSION['is_admin_user'])) {
                    ?>

                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> more </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/admin/requests.php"> Registration Requests </a>
                                    <a class="dropdown-item" href="/admin/submitted_news.php"> Submitted News </a>
                                    <a class="dropdown-item" href="/admin/published_news.php"> Published News </a>
                                    <a class="dropdown-item" href="/admin/students.php"> List Of Users </a>
                                    <!-- <a class="dropdown-item" href="/admin/add_student.php"> Register New User </a> -->
                                </div>
                            </div>
                        </li>
                        <?php
                        }
                    ?>

                        <li class="nav-item">
                            <a class="nav-link" href="/news.php">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/about.php">About us</a>
                        </li>
                    </ul>
                </div>

                <span class="nav-item float-right">
                    <?php 
                    if($logged_in){
                    ?>

                    <div class="dropdown">
                        <a class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION['user_name'] ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="/profile.php?uid=<?php echo $_SESSION['user_id']; ?>">Profile
                                <i class="bi bi-person"></i></a>
                            <a class="dropdown-item" href="/logout.php">Logout <i class="bi bi-box-arrow-right"></i></a>
                        </div>
                        <?php
                            $sqldp = "select `img` from `users` where Email='{$_SESSION['user_mail']}'";
                            $resultdp = mysqli_query($conn, $sqldp);
                            if(!$resultdp) {
                                echo mysqli_error($conn);die;
                                // die($sqldp);
                            }
                            $rowdp = mysqli_fetch_assoc($resultdp);
                            echo "<img src='/avatar/". $rowdp['img'] ."' alt='Avatar' class='avatar'>"
                        ?>
                    </div>

                    <?php } ?>
                </span>

            </nav>
        </div>
    </div>

    <?php require 'con_boot_js.php' ?>
</body>

</html>