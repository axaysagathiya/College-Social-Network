<?php 
    require 'not_loggedin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - Submit News</title>
    <?php require 'con_boot_css.php'; ?>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>

<body class="bg-light">
    <?php require 'navbar.php'; ?>

    <div class="container mt-2">

        <?php // echo $msg; ?>

        <legend>Submit News</legend><hr>

        <div id="responseMsg"></div>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off" class="form" method="post" name="form" id="newsForm"
            enctype="multipart/form-data">

            <div class="form-group my-2">
                <input type="radio" name="news-input-type" id="writeNews" value="writeNews"> write News
                &emsp;
                <input type="radio" name="news-input-type" id="uploadNewsPdf" value="uploadNewsPdf" checked> Upload News pdf
                &emsp;&emsp;
                <select name="" id="who">
                    <option value="" disabled>who can see ?</option>
                    <option value="A">All Users</option>
                    <option value="U">My University</option>
                    <option value="C">My College</option>
                    <option value="B">My Branch</option>
                </select>
            </div>

            <div class="form-row form-group mt-3">
                <div class="form-group col-md-10">
                    <input type="text" name="headline" class="form-control" id="heading" placeholder="heading of News">
                </div>

                <div class="col-md-2">
                    <button name="save" id="save" class="btn btn-dark form-control">SUBMIT</button>
                </div>
            </div>


            <div class="form-group" id="news-area">

                <!-- default => upload news pdf file -->
                <div class="form-group m-1">
                    <label for="upload"> <b>attach PDF : </b></label> &emsp;
                    <input name="upload" type="file" id="upload" class="btn btn-light" />
                    <small>maximum file size : 1 GB</small>
                </div>

            </div>

        </form>
    </div>

    <script src="news_file.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <?php require 'prevent_resubmission.php'; ?>
</body>

</html>