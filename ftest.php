<?php
require_once 'header.php'; 
$id = $_GET['id'];

$status = report($id);
if ($status == "ok") {
	echo "Success";
}
require_once 'footer.php'; 
?>