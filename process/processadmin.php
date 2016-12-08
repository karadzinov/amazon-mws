<?php

require_once '../config/conf.php';

$id = $_GET['id'];
$sql = mysqli_query($con, "SELECT * FROM users WHERE user_id = '$id'");
echo '
<div class="row">       
';

while ($row = mysqli_fetch_array($sql)) {
    echo '
        <p class="naslov"> ' . $row['user_name'] . '</p>
<form class="button" action="../process/makeadmin.php"  method="post">
    <input type="hidden" name="id" value="' . $id . '" />
    <button type="submit" value="submit" name="submit" >Make admin?</button>
</form>
';
}
?>


