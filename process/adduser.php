<?php 

require_once '../config/conf.php'; 

$user_name = $_POST['user_name'];
$user_lastname = $_POST['user_lastname'];
$user_email = $_POST['user_email'];
$user_pass = md5($_POST['user_pass']);
$repeat_password = md5($_POST['repeat_password']);
$is_user_admin = $_POST['is_user_admin'];





if ($user_name == NULL || md5($user_pass) != md5($repeat_password) ) {
    echo "Password doesn't match"; 
} else {

    $sql = "INSERT INTO users (user_name, user_lastname, user_email, user_pass, is_user_admin) VALUES ('$user_name', '$user_lastname', '$user_email', '$user_pass', '$is_user_admin')";
    if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con));
    }
    header('Location: /users.php');

    mysqli_close($con);
}
?>
