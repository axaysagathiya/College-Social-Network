<?php

if(isset($_POST['find'])) {
    $name      = $_POST['name']; 
    $fsurname    = $_POST['fsurname']; 
    $fenrl      = $_POST['fenrl']; 
    $funi       = '';
    $fclg       = '';
    $fbranch    = '';
    $frole      = '';

    if(!empty($_POST['funi'])) {$funi = $_POST['funi'];}
    if(!empty($_POST['fclg'])) {$fclg = $_POST['fclg'];}
    if(!empty($_POST['fbranch'])) {$fbranch = $_POST['fbranch'];}
    if(!empty($_POST['frole'] )) {$frole = $_POST['frole'];}



    if(!(empty($name) && empty($fsurname) && empty($fenrl) && empty($funi) && empty($fclg) && empty($fbranch) && empty($frole) )) {

        if(empty($name)) {
            $name=1;
        } else {
            $name="name like '%$name%' ";
        }

        if(empty($fsurname)) {
            $fsurname="1";
        } else {
            $fsurname="surname like '%$fsurname%' ";
        }

        if(empty($fenrl)) {
            $fenrl="1";
        } else {
            $fenrl="enrollment like '%$fenrl%' ";
        }

        if(empty($funi)) {
            $funi="1";
        } else {
            $funi="university='$funi' ";
        }

        if(empty($fclg)) {
            $fclg="1";
        } else {
            $fclg="college='$fclg' ";
        }

        if(empty($fbranch)) {
            $fbranch="1";
        } else {
            $fbranch="branch='$fbranch' ";
        }

        if(empty($frole)) {
            $frole="1";
        } else {
            $frole="role='$frole' ";
        }

        $sql = "select * from users where $name and $fsurname and $funi and $fclg and $fbranch and $fenrl and $frole";
        $result = mysqli_query($conn, $sql) or die($sql);
        
    } else {
        $sql = "select * from users where college = '{$_SESSION['user_college']}' ";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
}
?>