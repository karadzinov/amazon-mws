<? require_once 'header.php'; ?>

<p class="breadcrumb" style="text-align: center;"><?php echo ADD_SLIDER_IMAGE; ?> </p>
<form id="file_attachment_slider" method="post" enctype="multipart/form-data" action="javascript:void(0);" autocomplete="on">
    <label><?php echo BROWSE; ?> </label><input type="file" name="browsed_file" id="browsed_file" class="btn btn-warning">
    <a href="javascript:void(0);" onclick="slider_form_script();" class="btn btn-info" required>Прикачи</a> 
</form>

<form action="process/processsliderimage.php" method="post" >
    <br />
    <div id="vpb_upload_status"></div>
    <br />

    <div class="form-group">
        <label for="inputName"><?php echo IMG_NAME; ?> </label>
        <input type="text" class="form-control" id="inputName" placeholder="<?php echo ENTER_TITLE; ?>" name="name">
    </div>
     
    <div class="form-group">
        <label for="inputText"><?php echo IMG_DESCRIPTION; ?></label>
        <input type="text" class="form-control" id="inputText" placeholder="<?php echo ENTER_IMAGE_DESCRIPTION; ?>" name="opis">
    </div>
    
    <button type="submit" class="btn btn-default">Submit</button>
</form>  

<br /><br />

<p class="breadcrumb" style="text-align: center;" > <?php echo IZBRISHI_SLIKA; ?> </p>

<table class="table">

    <?php echo '<th>' . IMG_TITLE . '</th><th>' . IMAGE . '</th><th>' . IMG_TEXT . '</th><th>' . DELETE . '</th>'; ?>
    <?php
    $con = mysqli_connect("localhost", "rema", "temp12345", "rema");

// Check connection
    if (mysqli_connect_errno($con)) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql = mysqli_query($con, "SELECT * FROM sliderimages ");
    echo '
<div class="row">       
';
    while ($row = mysqli_fetch_array($sql)) {
        echo '
<form action="process/processdeleteimages.php" method="post">                 
<tr>
<td>' . $row['img_title'] . '</td>
<td><img src="' . $row['image'] . '" class="img-responsive" ></img></td>
<td>' . $row['img_text'] . '</td>
<td>
<input type="hidden"  name="img_id" value="' . $row['img_id'] . '" />
<button type="submit" class="btn btn-danger btn-xs" >'.IZBRISHI_SLIKA.'</button>
</td>
</tr>
</form>
';
    }
    ?>
</table>
    
<script>
function slider_form_script() 
{
	//alert('COOL');
	$("#file_attachment_slider").vPB({
		url: 'vpb_uploader_slider.php',
		beforeSubmit: function() 
		{
			$("#vpb_upload_status").html('<div style="font-family: Verdana, Geneva, sans-serif; font-size:12px; color:black;" align="center">Please wait <img src="images/loadings.gif" align="absmiddle" title="Upload...."/></div><br clear="all">');
		},
		success: function(response) 
		{
			$("#vpb_upload_status").hide().fadeIn('slow').html(response);
		}
	}).submit(); 
}

</script>
    
    <? require_once 'footer.php'; ?>