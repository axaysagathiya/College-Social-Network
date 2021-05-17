<?php
require '../not_loggedin.php';
require '../con_db.php';

if(isset($_POST['publish'])) {
    $topic = mysqli_real_escape_string($conn,$_POST['topic']);
    $link = $_POST['link'];

    $sql1 = mysqli_query($conn,  "insert into meeting values({$_SESSION['user_id']}, '$link' , '$topic')");
    if(!$sql1) {
        die($sql1);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - Meeting</title>
    <?php require '../con_boot_css.php'; ?>
</head>

<body>
    <?php require '../navbar.php'; ?>
    <div class="container">

        <div class="border p-4">
            <legend>Create Meeting</legend>
            <hr>
            <form action="/zoom-meeting/create_meeting.php" method="post">
                <div class="form-group">
                    <label for="">TOPIC</label>
                    <input class="form-control" type="text" name="topic" id="">
                </div>
                <!-- <div class="form-group">
                <label for="">Password</label>
                <input class="form-control" type="text" name="" id="">
            </div> -->
                <div class="form-group">
                    <button class="btn btn-primary btn-block" name="create" type="submit">Create Meeting</button>
                </div>
            </form>
        </div>

        <!-- <div><a href="/zoom-meeting/create_meeting.php" class="btn btn-secondary m-1">Create new meeting</a></div> -->


        <div class="mt-5">
            <legend>List Of Meetings</legend>
            <hr>
            <?php
            $sql = mysqli_query($conn, "select * from meeting;");
            if(!$sql) {
                die("can not fetch data.");
            }

            if(mysqli_num_rows($sql) <= 0) {
                echo '<div class="alert alert-info">NO Meeting Created yet.<div>';
            } else {
            ?>

            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Topic</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                while($row = mysqli_fetch_assoc($sql)) {
                    echo    '<tr>
                                <td>'.$row["topic"].'</td>
                                <td><a href="'.$row["link"].'">JOIN</a></td>
                            </tr>';
                }
                ?>

                </tbody>
            </table>

            <?php } ?>

        </div>

    </div>
    <?php require '../prevent_resubmission.php'; ?>
</body>

</html>