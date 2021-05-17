<?php

session_start();

$logged_in = isset($_SESSION['user_name']);

// echo '
// <input type="text" name="" id="Suser" value=' . $logged_in  .'>
// <script>
// console.log(document.getElementById("Suser").value);
// </script>';

if(!$logged_in){
    header("Location: http://localhost:8000/login.php");
    // echo "not log in";
}

?>

