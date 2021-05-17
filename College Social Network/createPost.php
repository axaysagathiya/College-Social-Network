<?php 
    require 'not_loggedin.php';
    require 'con_db.php';    
    $msg="";
 
    // ini_set('post_max_size', '64M');
    // ini_set('upload_max_filesize', '64M');
    
	// $max_upload = min((int)ini_get('post_max_size'), (int)ini_get('upload_max_filesize'));
	// $max_upload = str_replace('M', '', $max_upload);
	// $max_upload = $max_upload ;
        
    if(isset($_POST['save'])) {

        $content = $_POST['myeditor'];
        
        $sql1 = "INSERT INTO post(userID, content) VALUES('{$_SESSION['user_id']}', '$content') ;";
        $result1 = mysqli_query($conn,$sql1) or die($sql1);

        if ($result1) {

        $sql2 = "SELECT MAX( postID ) AS max FROM post;";
        $result2 = mysqli_query($conn,$sql2) or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc( $result2 );
        $pid = $row['max'];

        if(!empty(array_filter($_FILES['upload']['name']))){

            $targetdir = 'uploaded-files/';
    
            foreach($_FILES['upload']['name'] as $key=>$val){

                $filename = $_FILES['upload']['name'][$key];
                $temp_name = $_FILES['upload']['tmp_name'][$key];
                $date = date("Y m d H:i:s");    

                $newfilename   = uniqid() . "-" . time(); // 5dab1961e93a7-1571494241
                $extension  = pathinfo( $filename, PATHINFO_EXTENSION ); // jpg
                $newfilename1   = $newfilename . '.' . $extension; // 5dab1961e93a7_1571494241.jpg

                $target_path = $targetdir . $newfilename1;

                if(move_uploaded_file($temp_name,$target_path)){

                    $sql3 = "INSERT INTO attach(`postID`,`file`,`original_name`)
                            VALUES('$pid','$target_path','$filename')";
                    
                    $result3 = mysqli_query($conn,$sql3) or die(mysqli_error($conn));

                }
                else{
                    $msg = "<div class='alert alert-danger' > there is a problem uploading your file </div>";
                    $sql4 = "DELETE FROM post WHERE postID='$pid'; ";
                    mysqli_query($conn,$sql4) or die(mysqli_error($conn));
                }
                
            }   
        }
        if(empty($msg)) {
            $msg = "<div class='alert alert-success' >uploaded successfully. </div>";
        }
    }
    }
    mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN-CreatePost</title>
    <?php require 'con_boot_css.php'; ?>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>

<body>
    <?php require 'navbar.php'; ?>

    <div class="container mt-2">
    
    <legend>New post</legend><hr>
        <?php echo $msg; ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form" method="post" name="add_post"
            enctype="multipart/form-data">

            <div class="pt-1 form-group">
                <!-- creating a text area for my editor in the form -->
                <textarea class="form-control" id="myeditor" name="myeditor" id="myeditor"></textarea>

                <!-- creating a CKEditor instance called myeditor -->
                <script type="text/javascript">
                CKEDITOR.replace('myeditor');
                </script>
            </div>

            <div class="form-group form-row">

                <div class="form-group col-md-2 m-1">
                    <label for="upload[]"> <b>attach files : </b></label>
                </div>
                <div class="form-group col-md-4">
                    <input name="upload[]" type="file" id="upload" multiple="multiple"
                        class="btn btn-light form-control" />
                        <small>maximum file size : 1 GB</small>
                </div>

                <div class="form-group col-md-2 m-1"></div>

                <div class="form-group col-md-3 m-1">
                    <button name="save" class="btn btn-success form-control" type="submit">SUBMIT</button>
                </div>

            </div>
        </form>
    </div>
    <?php require 'prevent_resubmission.php'; ?>
</body>

</html>