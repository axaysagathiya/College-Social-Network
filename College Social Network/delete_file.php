<?php
require 'con_db.php';

$name = $_POST['file_name'];
$file_pointer = "news/".$name;

unlink($file_pointer);

?>