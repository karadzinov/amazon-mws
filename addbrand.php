<? require_once 'header.php'; ?>

<p class="breadcrumb" style="text-align: center;"> <?php echo DODADI_BREND; ?> </p>
<p>

<form id="vpb_file_attachment_form" method="post" enctype="multipart/form-data" action="javascript:void(0);" autocomplete="on">
    <label><?php echo BROWSE; ?> </label><input type="file" name="browsed_file" id="browsed_file" class="btn btn-warning">
    <a href="javascript:void(0);" onclick="vpb_upload_and_resize();" class="btn btn-info" required>Прикачи</a> 
</form>


<form action="process/processbrand.php" method="post" id="stylebrand" >
    <br />
    <div id="vpb_upload_status"></div>
    <br />

    <div class="form-group">
        <label for="inputNaslov"><?php echo BRAND_NAME; ?> </label>
        <input type="text" class="form-control" id="inputNaslov" placeholder="<?php echo ENTER_TITLE; ?>" name="name">
    </div>
    <br />
    <button type="submit" class="btn btn-default">Submit</button>
</form>     
</p>

<p class="breadcrumb"  style="text-align: center;"> <?php echo IZBRISHI_BREND; ?> </p>

<table class="table">

    <?php echo '<th>' . BRAND_NAME . '</th><th>' . BRAND_IMG . '</th><th>' . DELETE . '</th>'; ?>
    <?php
    $con = mysqli_connect("localhost", "rema", "temp12345", "rema");

// Check connection
    if (mysqli_connect_errno($con)) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql = mysqli_query($con, "SELECT * FROM brand");
    echo '
<div class="row">       
';
    while ($row = mysqli_fetch_array($sql)) {
        echo '
<form action="process/processdeletebrand.php" method="post">                 
<tr>
<td>' . $row['brand_name'] . '</td>
<td><img src="' . $row['brand_img'] . '" class="img-responsive"></img></td>
<td>
<input type="hidden"  name="id" value="' . $row['id'] . '" />
<button type="submit" class="btn btn-danger btn-xs" >' . IZBRISHI_BREND . '</button>
</td>
</tr>
</form>
';
    }
    ?>
</table>
<? require_once 'footer.php'; ?>