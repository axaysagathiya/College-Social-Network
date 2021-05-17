<?php
    require '../not_loggedin.php';
    require '../is_admin_loggedin.php';
    require '../con_db.php';
    $count = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - Submitted News</title>
    <?php  require_once '../con_boot_css.php'; ?>
</head>

<body class="bg-light">
    <?php require '../navbar.php'; ?>

    <div class="container">
        <legend>Submitted News</legend><hr>

        <div id="responseDiv"></div>
        <?php

        $sql = "SELECT * FROM `news` WHERE `status`='P';";
        $result = mysqli_query($conn, $sql);
        if(!$result) {
            echo "<div class='alert alert-danger' > Something went wrong. </div>";
        } else {

            if(mysqli_num_rows($result) > 0) { 

    ?>

        <table class="table table-striped table-light table-bordered">
            <thead class="bg-info text-white">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Who can see ?</th>
                    <th scope="col"> News Headline</th>
                    <th scope="col">News file</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                <?php while($row = mysqli_fetch_assoc($result)) {

                    $visible_to = '';
                    if($row['visible_to'] == "U" ) {
                        $visible_to = "My University";
                    } else if($row['visible_to'] == "C") {
                        $visible_to = "My College";
                    } else if($row['visible_to'] == "D") {
                        $visible_to = "My Department";
                    } else if($row['visible_to'] == "A") {
                        $visible_to = "All users";
                    }

                ?>
                <tr id="<?php echo 'newsRow'.$row['newsID'] ?>">
                    <td><?php echo ++$count; ?></td>
                    <td><?php echo $visible_to ;?></td>
                    <td id="<?php echo 'headline'.$row['newsID'] ?>" ><?php echo $row['headline'];?></td>
                    <td class="p-2">
                        <a href="<?php echo '/news/'.$row['file']; ?>" class="btn btn-sm btn-secondary"
                            download="<?php echo 'news-'. $row['newsID'] ?>">DOWNLOAD</a>
                    </td>
                    <td class="p-2 ">

                        <a href="#" class="btn btn-sm btn-primary m-1" id="<?php echo 'publish'.$row['newsID'] ?>"
                            onclick="publishNews(this.id);">PUBLISH</a>
                        <a href="#" class="btn btn-sm btn-primary m-1" id="<?php echo 'reject'.$row['newsID'] ?>"
                            onclick="rejectNews(this.id); return false;">REJECT</a>
                        <a href="" data-toggle="modal" data-target="<?php echo '#Modal'.$row['newsID'] ?>"
                            class="btn btn-sm btn-primary m-1">EDIT</a>

                        <div class="modal fade" id="<?php echo 'Modal'.$row['newsID'] ?>" tabindex="-1" role="dialog"
                            aria-labelledby="ModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ModalLabel">Edit Headline</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea name="" class="form-control"
                                            id="<?php echo 'editHeadline'.$row['newsID'] ?>" cols="30"
                                            rows="5"><?php echo $row['headline'] ?></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" id="<?php echo 'editHeadlineBtn'.$row['newsID'] ?>"
                                            data-dismiss="modal" class="btn btn-primary"
                                            onclick="editHeadline(this.id); return false;">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                <?php } ?>

            </tbody>
        </table>

        <?php
            } else {
                echo "<div class='alert alert-info' > No News Submitted Yet. </div>";
            }
        }
    ?>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="news.js"></script>
</body>

</html>