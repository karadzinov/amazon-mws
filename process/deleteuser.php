
<?php
require_once '../config/conf.php';

$user_id = $_POST['user_id'];

$delete = "DELETE FROM users WHERE user_id = '$user_id'";
$execute = mysqli_query($con, $delete);

header('Location: /users.php');
?>
