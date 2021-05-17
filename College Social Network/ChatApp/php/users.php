<?php
    session_start();
    include_once "../../con_db.php";
    $outgoing_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM users WHERE userID IN (SELECT `to` FROM relation WHERE `from` = {$outgoing_id} AND `status` = 'F') AND NOT userID= {$outgoing_id} ORDER BY userID DESC";
    $query = mysqli_query($conn, $sql) or die($sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>

