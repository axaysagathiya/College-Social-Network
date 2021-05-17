<?php
session_start();
require 'not_loggedin.php'; 
require 'con_db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - Buy/Sell</title>
    <?php require 'con_boot_css.php'; ?>
</head>

<body>
    <?php require 'navbar.php'; ?>
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <a href="sell_prod_ad.php" class="btn btn-dark float-right">Add Advertisement for Sell</a>
            </div>
        </div>

        <?php
        $sql = "select * from buy_sell_ad where userID not in (".$_SESSION['user_id'].")";
        $result = mysqli_query($conn, $sql);
        if(!$result) {
            die($sql);
        }
        if(mysqli_num_rows($result) <= 0) {
            echo "<div class='row m-1 alert alert-info'> NO ADVERTISEMENT AVAILABLE.</div>";
        } else {
            while($row = mysqli_fetch_assoc($result)) {
    ?>


        <div class="col bg-white mt-3 border">
            <div class="row bg-dark text-white py-2">
                <div class="col-md-11 px-2 ">
                    <?php echo $row['headline'];?>
                </div>

                <div class="col-md-1">
                <span style='float:right;'>
                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical text-white"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">

                        <?php
                            if($row['userID'] != $_SESSION['user_id']) {
                                echo  '<td><a href="/ChatApp/chat.php?userID='.$row['userID'].'"  onclick="window.open(this.href,\'newwindow\', \'width=400,height=700 \'); 
                                return false; " class="dropdown-item" type="button"> message</a></td>';

                                echo  '<td><a href="http://localhost:8000/profile.php?uid='.$row['userID'].'" target="blank_" class="dropdown-item" type="button">owner profile</a></td>';
                            }
                        ?>
                        </div>
                    </span>
                </div>
            </div>

            <div>
                <div class=" p-3">
                    <p><?php echo $row['description'];?></p>
                    <br>
                    <a target="_blank" href="view_prod_attach.php?adid=<?php echo $row['adID']; ?>"
                        class="btn btn-sm btn-secondary"> Show Photos </a>
                </div>
            </div>
        </div>


        <?php            
            }
        }
        ?>

    </div>
</body>

</html>