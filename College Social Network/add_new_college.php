
<?php
// for ajax : add new college name , if not in the database already

    $isadd = "";
    require 'con_db.php';

    $new_clg = !empty($_POST['new_clg'])?$_POST['new_clg']:'';
    $uniID = !empty($_POST['uniID'])?$_POST['uniID']:'';

    if(!empty($new_clg) && !empty($uniID)) {

        $sql1 = "select * from college where college_name='$new_clg' and universityID='$uniID';";
        $result1 = mysqli_query($conn,$sql1);

        if(! mysqli_num_rows($result1) > 0) {
            $sql = "INSERT INTO college(college_name,universityID) values('$new_clg','$uniID')";
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