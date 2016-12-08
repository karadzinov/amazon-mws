<?php 

require_once '../config/conf.php'; 

$id = $_POST['id'];
$order_id = $_POST['order_id'];
$tracking = $_POST['tracking'];


$dbquery_update = mysqli_query($con, "UPDATE reports SET TrackingNumber = '$tracking' WHERE AmazonOrderID = '$order_id'");
$update = mysqli_query($con, "UPDATE tracking SET tracking_number = '$tracking' WHERE id = '$id'");

header('Location: /tracking.php');
?>
