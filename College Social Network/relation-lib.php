<?php

// $msg = '';
$from = '';
$to = '';

// (D) SEND FRIEND REQUEST
if(isset($_POST['sendFrndRequest'])) {

  // (D1) CHECK IF ALREADY FRIENDS
  $sql11 = "SELECT * FROM relation WHERE from='$from' AND to='$to' AND status='F' ";
  $result11 = mysqli_query($conn, $sql11);
  
  if( mysqli_num_rows($result11) > 0 ) {
    $msg = "Already added as friends";
  
  } else {
      // (D2) CHECK FOR PENDING REQUESTS
      $sql12 = "SELECT * FROM relation WHERE (status='P' AND from='$from' AND to='$to') OR (status='P' AND from='$to' AND to='$from') ; ";
      $result12 = mysqli_query($conn, $sql12);
  
      if( mysqli_num_rows($result12) > 0 ) {
        $msg = "Already has a pending friend request";
      
      } else {
          // (D3) ADD FRIEND REQUEST
          $sql = "INSERT INTO relation (from, to, status) VALUES ('$from','$to','P');";
          $result = mysqli_query($conn, $sql); 
      }
  }
}



// (E) ACCEPT FRIEND REQUEST
if(isset($_POST['acceptFrndRequest'])) {

    $sql11 = "SELECT * FROM relation WHERE status='P' AND from='$from' AND to='$to' ";
    $result11 = mysqli_query($conn, $sql11);

    if(mysqli_num_rows($result11) > 0) {

        // (E1) UPGRADE STATUS TO "F"RIENDS
        $sql2 = "UPDATE relation SET status='F' WHERE status='P' AND from='$from' AND to='$to' ";
        $result2 = mysqli_query($conn, $sql2);

        // (E2) ADD RECIPOCAL RELATIONSHIP
        $sql = "INSERT INTO relation (from, to, status) VALUES ('$to','$from','F')";
        $result = mysqli_query($conn, $sql);
    }
}


// (F) CANCEL FRIEND REQUEST
if(isset($_POST['cancelFrndRequest'])) {
    $sql = "DELETE FROM relation WHERE status='P' AND from='$from' AND to='$to' ";
    $result = mysqli_query($conn, $sql);
}


// (G) UNFRIEND
if(isset($_POST['unfrnd'])) {
    $sql = "DELETE FROM relation WHERE (status='F' AND from='$from' AND to='$to') OR (status='F' AND from='$to' AND to='$from');";
    $result = mysqli_query($conn, $sql);
}


// (H1) BLOCK
if(isset($_POST['block'])) {
  $sql = "INSERT INTO relation (from, to, status) VALUES('$from','$to','B');";
  $result = mysqli_query($conn, $sql);
} 

// (H2) UNBLOCK
if(isset($_POST['unblock'])) {
  $sql = "DELETE FROM relation WHERE from='$from' AND to='$to' AND status='B';";
  $result = mysqli_query($conn, $sql);
}


// (I) GET FRIEND REQUESTS
function getReq ($uid) {

  // (I1) GET OUTGOING FRIEND REQUESTS (FROM USER TO OTHER PEOPLE)
  $sql = "SELECT * FROM relation WHERE status='P' AND from='$uid'; ";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) { $req['out'][$row['to']] = $row['since']; }

  // (I2) GET INCOMING FRIEND REQUESTS (FROM OTHER PEOPLE TO USER)
  $sql11 = "SELECT * FROM relation WHERE status='P' AND to='$uid' ;";
  $result11 = mysqli_query($conn, $sql11);
  while ($row = mysqli_fetch_assoc($result11)) { $req['in'][$row['from']] = $row['since']; }

  return $req;
}


















?>