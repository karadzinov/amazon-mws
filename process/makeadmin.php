<?php

require_once '../config/conf.php';

$id = $_POST['id'];

$con = mysqli_connect("localhost", "rema", "temp12345", "rema");

$makeadmin = mysqli_query($con, "UPDATE users SET is_user_admin = '1' WHERE user_id = '$id'");

header('Location: /users.php');
?>