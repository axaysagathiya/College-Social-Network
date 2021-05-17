<?php
    session_start();
    include_once "../../con_db.php";

    $outgoing_id = $_SESSION['user_id'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    $sql = "SELECT * FROM users WHERE NOT userID= {$outgoing_id} AND (name LIKE '%{$searchTerm}%' OR surname LIKE '%{$searchTerm}%') ";
    $output = "";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }else{
        $output .= 'No user found related to your search term';
    }
    echo $output;
?>