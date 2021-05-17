<?php
session_start();
require 'con_db.php';

// echo "<pre>";
// print_r($_FILES['upload']);
// echo "</pre>";

$headline = $_POST['headline'];
$visible_to='';
if($_POST['visible_to']) {
    $visible_to =  "'{$_POST['visible_to']}'";
} else {
    $visible_to = "NULL";
}
$msg = '';

    if(!empty($_FILES['upload']['name'])){

        $targetdir = 'news/';
        $filename = $_FILES['upload']['name'];
        $temp_name = $_FILES['upload']['tmp_name'];

        $newfilename = uniqid() . "-" . time(); 
        $newfilename1   = $newfilename . '.' . 'pdf'; 

        $target_path = $targetdir . $newfilename1;

        if(move_uploaded_file($temp_name,$target_path)){
            $sql = "INSERT INTO news(`userID`,`headline`,`visible_to`,`status`,`file`)
                    VALUES({$_SESSION['user_id']}, '$headline', $visible_to , 'P', '$newfilename1' );"; 
            $result = mysqli_query($conn,$sql);
            if($result) {
                $msg = "<div class='alert alert-success '> news has been submitted successfully. <br />".
                        "once it's approved, it will be published on our news section. </div>";

            } else {
                $msg = "<div class='alert alert-danger' > something went wrong. </div>";
            }
            
        } else{
            $msg = "<div class='alert alert-danger' > there is a problem uploading your file </div>";
        }
    }
    echo $msg;
    // $resArray = array("file_name" => "{$_FILES['upload']['name']}", 'have_file' => "$have_file", "headline" => "{$_POST['headline']}", "visible_to" => "{$_POST['visible_to']}", "msg" => "$msg");
    // echo json_encode($resArray);
?>