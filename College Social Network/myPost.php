<?php 
    require 'not_loggedin.php';
    require 'con_db.php';

    $user_id = $_SESSION['user_id'];

    $sql1 = "SELECT *,date(posted_at) AS postDate from post where userID='$user_id' ORDER BY `posted_at` DESC; ";
    $result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN-singlePost</title>
    <?php require "con_boot_css.php"; ?>
    <link rel="stylesheet" href="css/csn.css">

</head>

<body >
    <div>

        <legend>My Posts</legend>
        <hr>

        <div class="row">
            <?php
            $msg ='';
            if(mysqli_num_rows($result1) > 0) {
                while($row1 = mysqli_fetch_assoc($result1)) {
                    $postID = $row1['postID'];
                    $link_id = "link" . $postID;
                    // echo $link_id;
            ?>

            <div class="col-md-6 p-3">
                <div class=" border shadow-sm rounded ">

                    <div class="row ">

                        <div class="col-md-11">
                            <div class="border-bottom bgclr pl-2 pr-2">
                                <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                    <?php  echo $row1['posted_at']; ?>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-1 ">
                            <div style='float:right;'>
                                <u> <?php // echo $row1['postDate']; ?> </u>
                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical text-dark m-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right ">
                                    <a href="<?php echo '/singlePost.php?pid='.$postID ;?>" class="dropdown-item"
                                        type="button" target="_blank"> Open </a>
                                    <button id="<?php echo $postID ;?>" name="copyLink-btn" class="dropdown-item"
                                        type="button" onclick="copylink(this.id)">Copy Link</button>
                                    <input type="hidden" name="" id="<?php echo 'link'.$postID ;?>"
                                        value="http://localhost:8000/singlePost.php?pid=<?php echo $postID ?>">
                                    <a href="/deletePost.php?pid=<?php echo $postID; ?>" id="deletePost"
                                        name="deletePost" class="dropdown-item" type="button">Delete</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="p-2" style="max-height: 150px;overflow: hidden;">
                        <div><?php  echo $row1['content'] ?></div>
                    </div>
                </div>
            </div>

            <!-- <div class="col-md-1 mt-2 p-0"></div> -->

            <?php
                } 
            } else {
                $msg = "<div class='text-center font-weight-bold alert alert-info'> No Posts Yet. </div>";
            } ?>
        </div>
        <?php echo $msg ; ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/postAction.js"></script>

</body>

</html>