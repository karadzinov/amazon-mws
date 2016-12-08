<?php require_once '../header.php';?>

<?php
session_start();
$user_email = $_POST['user_email'];
$user_pass = md5($_POST['user_pass']);


$result = mysqli_query($con, "SELECT * FROM users WHERE user_email = '$user_email' AND user_pass = '$user_pass'");
$count = mysqli_num_rows($result);

if ($count == 1) {

    $_SESSION['user_email'] = $user_email;

    while ($row = mysqli_fetch_array($result)) {
        
        $_SESSION['name'] = $row['user_name'];
        

        
    }


  header('Location: ../admin.php');
} else {
    echo '<div style="margin-top: 300px; text-align: center;">'.INVALID_USER_PASS.'</div>';
}
?>

<?php require_once '../footer.php';?>