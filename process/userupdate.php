<?php 

require_once '../config/conf.php'; 

$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$user_lastname = $_POST['user_lastname'];
$user_email = $_POST['user_email'];
$user_pass = md5($_POST['user_pass']);
$repeat_password = md5($_POST['repeat_password']);
$is_user_admin = $_POST['is_user_admin'];

if (md5($user_pass) != md5($repeat_password) ) {
    echo "Password doesn\'t match"; 
} else {

    if (isset($user_name) && $user_name != NULL) {
        $updateuser = mysqli_query($con, "UPDATE users SET user_name = '$user_name' WHERE user_id = '$user_id'");
    }
    if (isset($user_lastname) && $user_lastname != NULL) {
        $updateuser = mysqli_query($con, "UPDATE users SET user_lastname = '$user_lastname' WHERE user_id = '$user_id'");
    }
    if (isset($user_email) && $user_email != NULL) {
        $updateuser = mysqli_query($con, "UPDATE users SET user_email = '$user_email' WHERE user_id = '$user_id'");
    }
    if (isset($user_pass) && $user_pass != NULL) {
        $updateuser = mysqli_query($con, "UPDATE users SET user_pass = '$user_pass' WHERE user_id = '$user_id'");
    }
    if (isset($is_user_admin) && $is_user_admin != NULL) {
        $updateuser = mysqli_query($con, "UPDATE users SET is_user_admin = '$is_user_admin' WHERE user_id = '$user_id'");
    }

    header('Location: /users.php');

    mysqli_close($con);
}

?>
