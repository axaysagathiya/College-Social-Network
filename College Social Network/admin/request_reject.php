<?php 
$user_mail = $_GET['Email'];
require '../not_loggedin.php';
require '../is_admin_loggedin.php';
require '../con_db.php';

$sql = "DELETE FROM verification WHERE Email='$user_mail';";
$sql .= "DELETE FROM users_request WHERE Email='$user_mail'; ";
$result = mysqli_multi_query($conn,$sql) or die(mysqli_error($conn));

mysqli_close($conn);
header("Location: http://localhost:8000/admin/requests.php");
?>