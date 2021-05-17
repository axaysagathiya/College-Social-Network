<?php

$user_mail = $_GET['Email'];
require '../not_loggedin.php';
require '../is_admin_loggedin.php';
require '../con_db.php';

$sql = "SELECT * FROM users_request WHERE Email='$user_mail'; ";
$result = mysqli_query($conn,$sql) or die($sql);
$row = mysqli_fetch_assoc($result);

$temp_enrollment = $row['enrollment'];;
$enrollment1 = !empty($temp_enrollment) ? "'$temp_enrollment'" : 'NULL';
$name1 = $row['name'];
$surname1 = $row['surname'];
$gender1 = $row['gender'];
$role1 = $row['role'];
$temp_sem = $row['sem'];
$sem1 = !empty($temp_sem) ? "'$temp_sem'" : 'NULL';
$branch1 = $row['branch'];
$college1 = $row['college'];
$uni1 = $row['university'];
$mail1 = $row['Email'];
$mobile1 = $row['mobile'];
$is_verified1 = $row['is_verified'];
$password1 = $row['password'];
$status = $row['status'];
$img = $row['img'];

$sql1 .= "INSERT INTO users(`enrollment`,`name`,`surname`,`gender`,`role`,`sem`,`branch`,`college`,`university`,`Email`,`mobile`,`is_verified`,`password`, `status`, `img`)
                    VALUES($enrollment1,'$name1','$surname1','$gender1','$role1',$sem1,'$branch1','$college1','$uni1','$mail1','$mobile1','$is_verified1','$password1', '$status', '$img');";
$sql1 .= "DELETE FROM users_request WHERE Email='$mail1'; ";

$result1 = mysqli_multi_query($conn,$sql1) or die($sql1);
// $result2 = mysqli_multi_query($conn,$sql2) or die($sql2);

mysqli_close($conn);

header("Location: http://localhost:8000/admin/requests.php");
?>