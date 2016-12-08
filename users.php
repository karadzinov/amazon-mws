<? require_once 'header.php'; ?>
<p class="naslov" > <?php echo LIST_USERS; ?></p>


<table class="table">

    <?php echo '<th>' . NAME . '</th><th>' . LASTNAME . '</th><th>' . EMAIL . '</th><th>' . ISADMIN . '</th><th>' . EDIT . '</th>'; ?>



    <?php


    $sql = mysqli_query($con, "SELECT * FROM users");
    echo '
<div class="row">       
';

    while ($row = mysqli_fetch_array($sql)) {

        $admin = $row['is_user_admin'];

        if ($admin == 1) {

            $administrator = '<button class="btn btn-danger btn-xs" type="button">Administrator</button>';
        } else if ($admin == 0) {
            $administrator = '<button class="btn btn-info btn-xs" type="button">User</button>';
        } else {
            $administrator = '<button class="btn btn-warning btn-xs" type="button">Dealer</button>';
        }

        echo '
<form action="' . $_SERVER['PHP_SELF'] . '" method="post">                 
<tr>
<td>' . $row['user_name'] . '</td>
<td>' . $row['user_lastname'] . '</td>
<td>' . $row['user_email'] . '</td>
<td>' . $administrator . '</td>
<td>
<input type="hidden" name="user_id" value="' . $row['user_id'] . '" />
<button class="btn btn-success btn-xs" type="submit">' . FORM_EDIT . '</button>
</td>
</tr>
</form>
';
    }
    ?>
</table>

<p class="naslov">
<form action="" method="post">
    <input type="hidden" name="adduser" value="1" />
    <button type="subbmit" class="btn btn-info btn-xs"><?php echo ADD_USER; ?></button>
</form>
</p>

<?php
$user_id = $_POST['user_id'];

if (isset($user_id) && $user_id != NULL) {
    $sql = mysqli_query($con, "SELECT * FROM users WHERE user_id = '$user_id'");
    while ($row = mysqli_fetch_array($sql)) {

        if ($row['is_user_admin'] == 0) {
            $rankeden = "selected";
        } else if ($row['is_user_admin'] == 1) {
            $rankdva = "selected";
        } else {
            $ranktri = "selected";
        }
        echo '
                     <div class="row">
                     <p>' . EDIT_FORM . '</p>
        <div class="col-md-12">
                    <form action="/process/userupdate.php" method="post" role="form" class="form-horizontal">
   
          
                            <input type="hidden" name="user_id" value="' . $row['user_id'] . '" id="inputusername" class="col-sm-2 control-label"/>

                     <div class="form-group">
                      <label for="inputusername" class="col-sm-2 control-label">' . FIRST_NAME . '</label>
                            <input type="text" name="user_name" value="' . $row['user_name'] . '" id="inputusername" class="col-sm-2 control-label"/>
                     </div>
                     
                     <div class="form-group">
                      <label for="inputlastname" class="col-sm-2 control-label">' . LAST_NAME . '</label>
                            <input type="text" name="user_lastname" value="' . $row['user_lastname'] . '" id="inputlastname" class="col-sm-2 control-label"/>
                     </div>
                     
                     <div class="form-group">
                      <label for="inputemail" class="col-sm-2 control-label">' . USER_EMAIL . '</label>
                            <input type="text" name="user_email" value="' . $row['user_email'] . '" id="inputemail" class="col-sm-2 control-label"/>
                     </div>
                     <div class="form-group">
                      <label for="inputrank" class="col-sm-2 control-label">' . USER_RANK . '</label>
                           <select name="is_user_admin" id="inputrank">
                           <option value="0" ' . $rankeden . '>User</option>
                           <option value="1" ' . $rankdva . '>Administrator</option>
                           <option value="2" ' . $ranktri . '>Moderator</option>
                           </select>
                     </div>
                     
                     <div class="form-group">
                      <label for="inputpassword" class="col-sm-2 control-label">' . USER_PASS . '</label>
                            <input type="password" name="user_pass" id="inputpassword" class="col-sm-2 control-label"/>
                     </div>
                     <div class="form-group">
                      <label for="inputrepassword" class="col-sm-2 control-label">' . RE_PASS . '</label>
                            <input type="password" name="repeat_password" id="inputrepassword" class="col-sm-2 control-label"/>
                     </div>
                        <div class="form-group">
                      <label for="submit" class="col-sm-2 control-label"></label>
                   <button type="submit" class="btn btn-default" id="submit">' . SUBMIT_FORM . '</button>
                       </div>

</form>

<p class="breadcrumb">' . IZBRISHI . '</p>
<div class="form-group">
<form action="/process/deleteuser.php" method="post">
<input type="hidden" value="' . $row['user_id'] . '" name="user_id"/>
    <label for="submit" class="col-sm-3 control-label">' . $row['user_name'] . ' ' . $row['user_lastname'] . '</label>
<button class="btn btn-danger btn-xs" type="submit" id="submit">' . DELETE . '</button>
</form>
</div>
                   </div>
                   </div>
               ';
    }
} else if (isset($_POST['adduser']) && $_POST['adduser'] != NULL) {
    echo ' <div class="row">
                     <p>' . ADD_FORM . '</p>
        <div class="col-md-12">
                    <form action="/process/adduser.php" method="post" role="form" class="form-horizontal">
                    <input type="hidden" name="adduser" value="adduser" />
                     <div class="form-group">
                      <label for="inputusername" class="col-sm-2 control-label">' . FIRST_NAME . '</label>
                            <input type="text" name="user_name" id="inputusername" class="col-sm-2 control-label"/>
                     </div>
                     
                     <div class="form-group">
                      <label for="inputlastname" class="col-sm-2 control-label">' . LAST_NAME . '</label>
                            <input type="text" name="user_lastname" id="inputlastname" class="col-sm-2 control-label"/>
                     </div>
                     
                     <div class="form-group">
                      <label for="inputemail" class="col-sm-2 control-label">' . USER_EMAIL . '</label>
                            <input type="text" name="user_email" id="inputemail" class="col-sm-2 control-label"/>
                     </div>
                     <div class="form-group">
                      <label for="inputrank" class="col-sm-2 control-label">' . USER_RANK . '</label>
                           <select name="is_user_admin" id="inputrank">
                           <option value="0">User</option>
                           <option value="1">Administrator</option>
                           <option value="2">Moderator</option>
                           </select>
                     </div>
                     <div class="form-group">
                      <label for="inputpassword" class="col-sm-2 control-label">' . USER_PASS . '</label>
                            <input type="password" name="user_pass" id="inputpassword" class="col-sm-2 control-label"/>
                     </div>
                     <div class="form-group">
                      <label for="inputrepassword" class="col-sm-2 control-label">' . RE_PASS . '</label>
                            <input type="password" name="repeat_password" id="inputrepassword" class="col-sm-2 control-label"/>
                     </div>

                   <button type="submit" class="btn btn-default">' . SUBMIT_ADD_FORM . '</button>

</form>
                   </div>
                   </div>';
}
?>

<? require_once 'footer.php'; ?>
