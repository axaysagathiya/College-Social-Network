<?php
    require "not_loggedin.php";
    require "con_db.php";
    if(isset($_GET['pid'])) {
        $postID = $_GET['pid'];
    }

    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN-singlePost</title>
    <?php require "con_boot_css.php"; ?>
    <link rel="stylesheet" href="css/csn.css">
    <script src="/postAction.js"></script>
</head>

<body class="bg-light">
    <?php require "navbar.php"?>
    <div class="container">
        <legend> Single Post</legend>
        <hr>
        <div class="container bg-white mt-5 p-0 border border-dark">

            <?php
                $sql = "SELECT *, date(posted_at) AS postDate FROM post WHERE postID ='$postID'; ";
                $result=mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $row = mysqli_fetch_assoc($result);
                $sql1 = "SELECT `name`, `surname` FROM `users` WHERE `userID`= {$row['userID']}; ";
                $result1=mysqli_query($conn, $sql1) or die(mysqli_error($conn));
                $row1 = mysqli_fetch_assoc($result1);    
                
                $sqlfrnd = mysqli_query($conn, "SELECT * FROM `relation` WHERE `from` = {$_SESSION['user_id']} AND `to` = {$row['userID']} AND `status` = 'F';");
                if(!$sqlfrnd) {
                    echo $sqlfrnd;
                } else {
                    if(mysqli_num_rows($sqlfrnd) <= 0) {
                        echo '
                            <div class="alert alert-info">
                                Only friends can see the post.
                                <a href="#" name="addFrndBtn" id="addFrnd'. $row['userID'] .'" onclick="addFriend(this.id);"> <i class="bi bi-person-plus-fill"></i> add Friend </a> 
                            </div>

                        ';
                    }
                }
                



            ?>

            <div class="border-bottom  bg-dark text-white p-2">

                <div style='float:right;'>
                    <?php  echo $row['postDate'] ?>

                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical text-white"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button id="<?php echo $postID ;?>" name="copyLink-btn" class="dropdown-item" type="button"
                            onclick="copylink(this.id)">Copy Link</button>
                        <input type="hidden" name="" id="<?php echo 'link'.$postID ;?>"
                            value="http://localhost:8000/singlePost.php?pid=<?php echo $postID ?>">
                        <?php if($row['userID'] == $_SESSION['user_id']) {
                             echo '<a href="/deletePost.php?pid=<?php echo $postID; ?>"' .
                                    'id="deletePost"name="deletePost"'.
                                    'class="dropdown-item" type="button">Delete</a>';
                        } ?>
                    </div>
                </div>
                <div class="mr-2"><strong><?php  echo $row1["name"]. " ". $row1["surname"] ?></strong></div>
            </div>

            <div class="p-3">
                <div><?php  echo $row['content'] ?></div>

                <div class="row p-2">
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
        </div>
    </div>
</body>

</html>