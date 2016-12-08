<?php
require_once 'config/conf.php';

if (isset($_GET['lang']) && $_GET['lang'] == 1) {
    include_once 'language/mk.php';
} else {
    include_once 'language/en.php';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo constant("TITLE"); ?></title>
    <link rel="shortcut icon" href="images/icons/settings_small.png" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/css/style.css" rel="stylesheet" media="screen">
</head>
<body>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="js/jquery.filtertable.min.js"></script>
    <script type="text/javascript" src="js/file_uploads.js"></script>
    <script type="text/javascript" src="js/vpb_script.js"></script>
    <script type="text/javascript" src="js/bootstrap.file-input.js"></script>
    <script src="ckeditor/ckeditor.js"></script>
    <script>$(document).ready(function() {
        $('input[type=file]').bootstrapFileInput();
    });</script>
    
    <header class="navbar navbar-default navbar-fixed-top navbar-default-color">
        <a class="navbar-brand" href="/">

            <img src="/images/icons/settings_small.png" alt="CMS" /> <?php echo constant("ADMIN_PANEL"); ?></a>

        </header>

        <div class="container">
            <div class="push"></div>

            <?php
            session_start();


            $scriptname = $_SERVER['SCRIPT_NAME'];

            $pagetitle = str_replace(".php", "", $scriptname);
            $pagetitlefinal = strtoupper(str_replace("/", "", $pagetitle));
            
            if (isset($_SESSION['user_email'])) {
                echo '
                <ol class="breadcrumb">
                    <li><a href="/">  <button class="btn btn-primary btn-xs" type="button">' . ADMIN_PANEL . '</button></a></li>
                    <li><a href="'.$_SERVER['SCRIPT_NAME'].'">  <button class="btn btn-primary btn-xs" type="button">' . $pagetitlefinal . '</button></a></li>
                    <li class="active pull-right">' . LOGGED_IN_AS . ' : ' . $_SESSION['name'] . '<a href="logout.php"> [ Logout ]</a></li>
                </ol>

                ';
            }
            ?>
