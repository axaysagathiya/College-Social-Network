<?php
    require 'not_loggedin.php'; 
    require 'con_db.php';

    $sql = "SELECT * FROM post WHERE userID IN (SELECT `to` FROM `relation` WHERE `from`='{$_SESSION['user_id']}' AND `status`='F') OR `userID`='{$_SESSION['user_id']}' ORDER BY `posted_at` DESC";
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require 'con_boot_css.php'?>
</head>

<body class="bg-light ">

    <?php require 'navbar.php'; ?>

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-dark font-weight-bold float-right m-2" href="/createPost.php"><i class="bi bi-plus-square-fill"></i> New Post </a> 
            </div>
        </div>


        <?php 
            $result = mysqli_query($conn,$sql);
            if(!$result) {
                mysqli_error($conn);
            }

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $sql1 = "SELECT `name`,`surname` FROM users WHERE userID='{$row['userID']}'";
                    $result1 = mysqli_query($conn,$sql1) or die($sl1);
                    $row1 = mysqli_fetch_assoc($result1);
                    $postID= $row['postID'];
        ?>

        <div class="col bg-white mt-3 border">

            <div class="row bg-dark text-white py-2">
                <div class="col-md-11 px-2 ">
                    <h5> <?php  echo $row1['name']. " " .$row1['surname']; ?> </h5>
                </div>

                <div class="col-md-1">
                    <span style='float:right;'>
                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical text-white"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?php echo '/singlePost.php?pid='.$postID ;?>" class="dropdown-item" type="button"
                                target="_blank"> Open </a>
                            <button id="<?php echo $postID ;?>" name="copyLink-btn" class="dropdown-item" type="button"
                                onclick="copylink(this.id)">Copy Link</button>
                            <input type="hidden" name="" id="<?php echo 'link'.$postID ;?>"
                                value="http://localhost:8000/singlePost.php?pid=<?php echo $postID ?>">
                            <?php if($row['userID'] == $_SESSION['user_id']) {
                                echo    '<a href="/deletePost.php?pid=<?php echo $postID; ?>" id="deletePost" name="deletePost"'.
                                        'class="dropdown-item" type="button">Delete</a>';
                            } ?>

                        </div>
                    </span>
                </div>
            </div>

            <div class="row p-3">
                <?php echo $row['content'];?>
            </div>

            <div class="row p-2" >
                <?php
                    $sqlDownload = "SELECT * FROM attach WHERE postID='{$row['postID']}' ";
                    $resultDownload = mysqli_query($conn, $sqlDownload) or die(mysqli_error($conn));
                    if(mysqli_num_rows($resultDownload) > 0) {
                        while($rowDownload = mysqli_fetch_assoc($resultDownload)) {
                            echo '<a class="btn btn-sm btn-outline-info m-1" href="'. $rowDownload['file'] .'" download="'.$rowDownload['original_name'].'"> '. $rowDownload['original_name'] .'  <i class="bi bi-download"></i></a>';
                        }
                    }
                ?>
            </div>

        </div>

        <?php                
                }
            } else {
                echo '<div class="m-2 text-center font-weight-bold alert alert-info"> No Posts Yet. </div>';
            }
        ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/postAction.js"></script>
</body>

</html>