<?php 
$Email = $_GET['Email'];
require '../not_loggedin.php';
require '../is_admin_loggedin.php';
require '../con_db.php';

$sql = "DELETE FROM users WHERE Email = '$Email'; ";
$result = mysqli_query($conn,$sql) or die($sql);

mysqli_close($conn);
header("Location: http://localhost:8000/admin/students.php");
?>