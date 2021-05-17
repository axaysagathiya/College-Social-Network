
<?php
// for ajax : add new branch name , if not in the database already

$isadd = "";
require 'con_db.php';

$new_branch = !empty($_POST['new_branch'])?$_POST['new_branch']:'';

if(!empty($new_branch)) {

    $sql1 = "select * from branch where branch_name =  '$new_branch' ";
    $result1 = mysqli_query($conn,$sql1) or die($sql1);

    if(! mysqli_num_rows($result1) > 0) {
        
        $sql = "insert into branch(branch_name) values('$new_branch');";
        mysqli_query($conn, $sql) or die($sql);
        $isadd = "success";
    } else {
        $isadd = "error";
    }
    
    $resArray = array("isadd" => "$isadd");

    echo json_encode($resArray);
    
}
mysqli_close($conn);
?>