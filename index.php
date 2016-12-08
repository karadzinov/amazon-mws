<?php include_once 'header.php'; ?>
<?php 
session_start();
if (isset($_SESSION['user_email'])) {
header('Location: admin.php');   
}

?>

    <div class="clearfix"></div>
    <div class="forma">
        <ol class="breadcrumb">
            <li><a href="#">  <button class="btn btn-primary btn-xs" type="button"><?php echo constant("ADMIN_PANEL"); ?></button></a></li>
            <li class="active"><?php echo constant("SING_IN"); ?></li>
        </ol>
        <form class="form-signin" action="/process/processlogin.php" method="post">
            <p class="login-naslov">   <img src="/images/icons/settings.png" alt="CMS Admin" />  <?php echo constant("LOG_IN"); ?>   </p>
            <input type="text" class="form-control" placeholder="<?php echo constant("USERNAME"); ?>" name="user_email" autofocus>
            <input type="password" class="form-control" placeholder="<?php echo constant("PASSWORD"); ?>" name="user_pass">
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> <?php echo constant("LOGGED_IN"); ?>
            </label>
            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo constant("SING_IN"); ?></button>
        </form>
    </div>

<?php include_once 'footer.php'; ?>
