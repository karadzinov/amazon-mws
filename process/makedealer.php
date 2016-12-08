<?php

require_once '../config/conf.php';

$id = $_POST['id'];


$makeadmin = mysqli_query($con, "UPDATE users SET is_user_admin = '0' WHERE user_id = '$id'");

header('Location: /users.php');
?>