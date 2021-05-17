<?php
    require_once "con_db.php";
    session_start();

    $sql2 = "UPDATE `users` SET `status`= 'Offline now' WHERE `Email` = '{$_SESSION['user_mail']}' ;";
    $result2 = mysqli_query($conn, $sql2);
    if(!$result2) {
        echo $sql2; die;
    }

    session_unset();
    session_destroy();

    header("Location: http://localhost:8000");

?>