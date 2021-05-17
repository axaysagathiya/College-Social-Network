<?php

require 'con_db.php';

$mail = '';
if($_GET['mail']) {
    $to = $_GET['mail'];
    $vkey = '';

    $sql2 = "select * from users where Email = '$to';";
    $result2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($result2) > 0) {
        $row2 = mysqli_fetch_assoc($result2);
        $user_name = $row2['name'];

        if(!$is_verified) {
            $sql = "select * from verification where Email = '{$to}'";
            $result = mysqli_query($conn, $sql) or die($sql);

            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $vkey = $row['verification_key'];

            } else {
                $vkey = md5(time().$user_name);
                $sql4 = "INSERT INTO verification VALUES('$to','$vkey'); ";
                $result4 = mysqli_query($conn,$sql4) or die($sql4); 
            }
        
            $subject = "Welcome to CSN.";
            $mail_msg = "hey $user_name ! <br />
                        you have successfully requested for the registration,
                        please wait for approval. <br /> <br /> 
                        Please <a href='http://localhost:8000/verifymail.php?vkey=$vkey&mail=$to&type=ur'>Click Here</a> to verify your Email";
            
            require 'sendmail.php';

            echo "mail Sent";

        }
    }
} 



?>