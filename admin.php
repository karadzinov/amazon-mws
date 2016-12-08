<?php require_once 'header.php'; ?>
<?php

session_start();
if (isset($_SESSION['user_email'])) {



	echo '



	<div class="row">
		<div class="col-md-4"><a href="/users.php"><img src="/images/admin/users.png" alt="Users" />' . USER . '</a></div>
		<div class="col-md-4"><a href="/reportlist.php"><img src="/images/admin/excel.png" alt="Files" />' . REPORT_LIST . '</a></div>
		<div class="col-md-4"><a href="/files.php"><img src="/images/admin/download.png" alt="Files" /> ' . EXPORT_ORDERS_NOW . '</a></div>
	</div>
	<div class="row">
		<div class="col-md-4"><a href="/tracking.php"><img src="/images/admin/tracking.png" alt="Files" />  Tracking Orders </a></div>
		<div class="col-md-4"><a href="/export_tracking.php"><img src="/images/admin/export.png" alt="Export" />  Export Tracking </a></div>
	</div>


	';
} else {
	echo 'Please <a href="index.php">Log in</a>';
}
?>





<?php require_once 'footer.php'; ?>



