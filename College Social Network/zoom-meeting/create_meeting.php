<?php  
require '../not_loggedin.php';
require_once '../navbar.php';
include_once 'Zoom_Api.php';

$zoom_meeting = new Zoom_Api();

$data = array();

if(isset($_POST['create'])) {
    $data['topic'] 		= $_POST['topic'];
} else {
    $data['topic'] 		= 'Example Test Meeting';
}

$data['start_date'] = date("Y-m-d h:i:s", strtotime('+1 minute'));
echo $data['start_date'];
$data['duration'] 	= 30;
$data['type'] 		= 2;
$data['password'] 	= "12345";

try {
	$response = $zoom_meeting->createMeeting($data);
	
	//echo "<pre>";
	//print_r($response);
	//echo "<pre>";
	
	// echo "Meeting ID: ". $response->id;
	// echo "<br>";
	// echo "Topic: "	. $response->topic;
	// echo "<br>";
	// echo "Join URL: ". $response->join_url ."<a href='". $response->join_url ."'>Open URL</a>";
	// echo "<br>";
	// echo "Meeting Password: ". $response->password;
    
	
} catch (Exception $ex) {
    echo $ex;die;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSN - Create Meeting</title>
	<?php require '../con_boot_css.php'?>
</head>

<body class="">
    <div class="container">
	<legend> ZOOM Meeting Deatils </legend> <hr><br>
        <table class="table table-bordered">
            <tr>
                <th class="bg-light">Meeting ID</th>
                <td colspan="2"><?php echo $response->id; ?></td>
            </tr>
            <tr>
                <th class="bg-light">Topic</th>
                <td colspan="2" ><?php echo $response->topic; ?></td>
            </tr>
            <tr>
                <th class="bg-light">Join URL</th>

					<td><?php echo $response->join_url; ?></td>
					<td> <a href="<?php echo $response->join_url; ?>" class="btn btn-primary border">Open url</a></td>
            </tr>
            <tr>
                <th class="bg-light">Meeting Password</th>
                <td colspan="2" ><?php echo $response->password; ?></td>
            </tr>
        </table>

        <form action="/zoom-meeting/index.php" method="post">
            <input type="hidden" value="<?php echo $response->topic; ?>" name="topic">
            <input type="hidden" value="<?php echo $response->join_url; ?>" name="link">
            <button type="submit" name="publish" class="btn btn-block btn-secondary">Announce Meeting</button>
        </form>
    </div>
</body>

</html>