<?php
    session_start();
    require 'con_db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - News</title>
    <?php require 'con_boot_css.php'; ?>
</head>

<body class="">
    <?php require 'navbar.php'; ?>
    <div class="container">
    
        <?php
        if(isset($_SESSION['user_name'])) {

            echo    '<div class="row ">' .
                       ' <div class="col-md-12">' .
                            '<a href="/submit_news.php" class="btn btn-dark float-right">submit news</a>' .
                        '</div>' .
                   ' </div>';
        } else {
            echo    "> news listed below are for all the users, \n
                    Please <a href='/login.php'> LogIn  </a> to get news for Your Branch/College/University. ";
        }
        ?>


        <div class="mt-5  w-100">

            <?php
                $count = 0;
                $sql = "SELECT * FROM `news` WHERE `status`='A'; ";
                $result = mysqli_query($conn, $sql) or die($sql);
                if(mysqli_num_rows($result) > 0) {
                    
                    while($row = mysqli_fetch_assoc($result)) {
                        $sql2 = "select * from users where userID = {$row['userID']}";
                        $result2 = mysqli_query($conn, $sql2) or die($sql2);
                        while($row2 = mysqli_fetch_assoc($result2)) {

                            $rowClg = $row2['college'];
                            $rowUni = $row2['university'];
                            $rowBranch = $row2['branch'];

                            if($row['visible_to'] == 'A' ) {
                                echo    '<div class="mb-3 ">' .
                                        '<a href="news/'.$row['file'].'" download ><div class="bg-white border p-1">'. ++$count .')&emsp;'. $row['headline'] .'</div></a>' .
                                        '</div>';
                            } else if($row['visible_to'] == 'C'  && $_SESSION['user_college'] == $rowClg) {
                                echo    '<div class="mb-3 ">' .
                                        '<a href="news/'.$row['file'].'" download ><div class="bg-white border p-1">'. ++$count .')&emsp;'. $row['headline'] .'</div></a>' .
                                        '</div>';
                            } else if($row['visible_to'] == 'U'  && $_SESSION['user_uni'] == $rowUni) {
                                echo    '<div class="mb-3 ">' .
                                        '<a href="news/'.$row['file'].'" download ><div class="bg-white border p-1">'. ++$count .')&emsp;'. $row['headline'] .'</div></a>' .
                                        '</div>';
                            } else if($row['visible_to'] == 'B'  && $_SESSION['user_branch'] == $rowBranch) {
                                echo    '<div class="mb-3 ">' .
                                        '<a href="news/'.$row['file'].'" download ><div class="bg-white border p-1">'. ++$count .')&emsp;'. $row['headline'] .'</div></a>' .
                                        '</div>';
                            }
                        }
                    }
                    
                } else {
                    echo "<div class='alert alert-info text-center font-weight-bold' > No News yet.. </div>";
                }
            ?>

        </div>
    </div>
</body>

</html>