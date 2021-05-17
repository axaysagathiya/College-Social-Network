<?php
session_start();
require 'not_loggedin.php'; 
require 'con_db.php';
?>

<body>
    <div class="container">

        <?php

        $sql = "select * from buy_sell_ad where userID = {$_SESSION['user_id']} ";
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

                                $adrs = "/deleteMyNews.php?uid=".$row['userID']."&action=myProd&adid=".$row['adID'];
                                echo  '<td><a href="'.$adrs.'" class="dropdown-item" type="button">Delete</a></td>';

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