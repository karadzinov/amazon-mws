<?php
require_once 'header.php';
$dbquery = mysqli_query($con, "SELECT * FROM tracking WHERE tracking_number != '' AND exported = '0'");
if (is_array($row = mysqli_fetch_array($dbquery))) {
	$export = export_tracking("go");
}
header('Location: tracking.php');
require_once "footer.php";
?>