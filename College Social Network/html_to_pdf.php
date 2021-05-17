<?php
session_start();
require 'con_db.php';
require 'vendor/autoload.php';
use Dompdf\Dompdf as Dompdf;


$msg = "success";

$data = $_POST['news_data'];
$visible_to='';
if($_POST['visible_to']) {
    $visible_to =  "'{$_POST['visible_to']}'";
} else {
    $visible_to = "NULL";
}
$headline = $_POST['headline'];
$newfile_name = "none";

if($data) {
                
    $targetdir = 'news/';
    $newfilename   = uniqid() . "-" . time(); // 5dab1961e93a7-1571494241
    $newfilename   = $newfilename . '.' . "pdf"; // 5dab1961e93a7_1571494241.jpg
    $target_path = $targetdir . $newfilename;

    $dompdf = new Dompdf();
    $dompdf->loadHtml($data);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $output = $dompdf->output();

    if(file_put_contents($target_path, $output)) {
        $newfile_name = $newfilename;

        $sql = "INSERT INTO news(`userID`,`headline`,`visible_to`,`status`,`file`)
                VALUES({$_SESSION['user_id']}, '$headline', $visible_to, 'P', '$newfilename' );";
        $result = mysqli_query($conn, $sql);

        if(!$result) {
            $msg = "<div class='alert alert-danger' > something went wrong. </div>";
        }
    }
} else {
    $msg = "<div class='alert alert-danger '> Empty News Can't be submitted. </div>";
}


$resArray = array("newfile_name" => "$newfile_name", "msg" => "$msg", "$visible_to" => $visible_to );
echo json_encode($resArray);

?>