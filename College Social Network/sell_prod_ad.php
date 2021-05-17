<?php
session_start();
require 'not_loggedin.php'; 
require 'con_db.php';
$msg = '';


if(isset($_POST['submit'])) {

    $headline = mysqli_real_escape_string($conn ,$_POST['headline']);
    $description = mysqli_real_escape_string($conn ,$_POST['description']);
    
    $sql1 = "insert into buy_sell_ad(userID ,headline, description) values({$_SESSION['user_id']}, '$headline', '$description');";
    $result1 = mysqli_query($conn,$sql1) or die($sql1);

    if(!$result1) {
        $msg = "<div class='alert alert-danger' > there is a problem uploading your product.  </div>";

    }  else {

    $sql2 = "SELECT MAX( adID ) AS max FROM buy_sell_ad;";
    $result2 = mysqli_query($conn,$sql2) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc( $result2 );
    $pid = $row['max'];

    if(!empty(array_filter($_FILES['upload']['name']))){

        // echo "<pre>";
        // print_r($_FILES['upload']);
        // echo "</pre>";

        $targetdir = 'prod_photos/';

        foreach($_FILES['upload']['name'] as $key=>$val){

            $filename = $_FILES['upload']['name'][$key];
            // echo $filename;
            $temp_name = $_FILES['upload']['tmp_name'][$key];
            $date = date("Y m d H:i:s");    

            $newfilename   = uniqid() . "-" . time(); // 5dab1961e93a7-1571494241
            $extension  = pathinfo( $filename, PATHINFO_EXTENSION ); // jpg
            $newfilename1   = $newfilename . '.' . $extension; // 5dab1961e93a7_1571494241.jpg

            $target_path = $targetdir . $newfilename1;

            if(move_uploaded_file($temp_name,$target_path)){

                $sql3 = "INSERT INTO buy_sell_attach(`adID`,`file`)
                        VALUES('$pid','$newfilename1')";
                
                $result3 = mysqli_query($conn,$sql3) or die(mysqli_error($conn));

            }
            else{
                $msg = "<div class='alert alert-danger' > there is a problem uploading Photos. </div>";
                $sql4 = "DELETE FROM buy_sell_ad WHERE adID='$pid'; ";
                mysqli_query($conn,$sql4) or die(mysqli_error($conn));
            }
            
        }   
    }
    if(empty($msg)) {
        $msg = "<div class='alert alert-success' > Product added for sale. </div>";
    }
}
}


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
        <?php echo $msg; ?>
        <legend>add product details</legend>
        <hr>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Heading</label>
                <input type="text" name="headline" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea class="form-control" name="description" id="" rows="10"></textarea>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    <label for="upload[]"> <b>attach Photos of product : </b></label>
                </div>

                <div class="col-md-7">
                    <input name="upload[]" type="file" id="upload" multiple="multiple"
                        class="btn btn-light form-control" accept="image/*" />
                    <small>maximum file size : 1 GB</small>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="submit" class="btn btn-primary form-control"> Submit </button>
                </div>
            </div>
        </form>
    </div>

    <?php require 'prevent_resubmission.php'; ?>
</body>

</html>