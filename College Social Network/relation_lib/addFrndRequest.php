<?php
// (D) SEND FRIEND REQUEST
session_start();
require "../not_loggedin.php";
require '../con_db.php';


$resarray = [];
$msg='success';
$from = $_SESSION['user_id'];
$to = $_POST['to_userID'];
if(empty($to)) {
  echo "<div class='text-center font-weight-bold alert alert-secondary'>  UNAUTHORIZED ! </div>";die;
}

$sql13 = "SELECT * FROM  relation WHERE `from`='$to' AND `to`='$from' AND `status`='B'; ";
$result13 = mysqli_query($conn, $sql13);

if(!$result13) {
  $msg = $sql13;
} else {
    if(mysqli_num_rows($result13) > 0) {
      $msg = "you can't send friend request to this user";
    } else {

        // (D1) CHECK IF ALREADY FRIENDS
        $sql11 = "SELECT * FROM relation WHERE `from`='$from' AND `to`='$to' AND `status`='F'; ";
        $result11 = mysqli_query($conn, $sql11) or die(mysqli_error($conn));

        if( mysqli_num_rows($result11) > 0 ) {
          $msg = "Already added as friends";
        
        } else {
            // (D2) CHECK FOR PENDING REQUESTS
            $sql12 = "SELECT * FROM relation WHERE ((`status`='P' AND `from`='$from' AND `to`='$to') OR (`status`='P' AND `from`='$to' AND `to`='$from')) ; ";
            $result12 = mysqli_query($conn, $sql12);
        
            if( mysqli_num_rows($result12) > 0 ) {
              $msg = "Already has a pending friend request(Check your requests)";
            
            } else {
                // (D3) ADD FRIEND REQUEST
                $sql = "INSERT INTO relation (`from`, `to`, `status`) VALUES ('$from','$to','P');";
                $result = mysqli_query($conn, $sql); 
            }
        }

    }
}


  $resArray = array("msg" => "$msg");
  echo json_encode($resArray);

?>