
<?php
// for ajax : add new university name , if not in the database already

$isadd = "";
require 'con_db.php';

$new_uni = !empty($_POST['new_uni'])?$_POST['new_uni']:'';

if(!empty($new_uni)) {

    $sql1 = "select * from university where university_name = '$new_uni' ";
    $result1 = mysqli_query($conn, $sql1) or die($sql1);

    if(! mysqli_num_rows($result1) > 0) {

        $sql = "INSERT INTO university(university_name) values('$new_uni')";
        $result = mysqli_query($conn, $sql) or die($sql);
        $isadd = "success";
    } else {
        $isadd = "error";
    }

    $resArray = array("isadd" => "$isadd");

    echo json_encode($resArray);
}

mysqli_close($conn);
?>