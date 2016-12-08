<? require_once 'header.php'; ?>

<div class="container">
    <p class="breadcrumb" style="text-align: center;"><?php echo CHOOSE_PRODUCT_BRAND; ?> </p>
<table class="table">
    <?php
    $result = mysqli_query($con, "SELECT * FROM brand");

    while ($row = mysqli_fetch_array($result)) {


        echo ' <tr><td><a href="addproduct.php?brandid=' . $row['id'] . '"  >  <img src="' . $row['brand_img'] . '" alt="' . $row['brand_name'] . '" /></a> </td><td><a href="addproduct.php?brandid=' . $row['id'] . '"  >' . $row['brand_name'] . '</a></td></tr>';
    }
    ;
    ?>
</table>
    <br /><br /><br />
    <p class="breadcrumb" style="text-align: center;"><?php echo DELETE_PRODUCT ?></p>
    <table class="table">

        <?php echo '<th>' . PRODUCT_NAME . '</th><th>' . PRODUCT_IMG . '</th><th>' . DESCRIPTION . '</th><th>' . PRODUCT_LINK . '</th><th>' . CAT_ID . '</th><th>' . BRAND_ID . '</th><th>' . DELETE . '</th>'; ?>
        <?php
        $con = mysqli_connect("localhost", "rema", "temp12345", "rema");

// Check connection
        if (mysqli_connect_errno($con)) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $sql = mysqli_query($con, "SELECT * FROM product INNER JOIN categories ON product.cat_id = categories.category_id INNER JOIN brand ON categories.brand_id = brand.id");
        echo '
<div class="row">       
';
        while ($row = mysqli_fetch_array($sql)) {
            echo '
<form action="process/processdeleteproduct.php" method="post">                 
<tr>
<td>' . $row['product_name'] . '</td>
<td><img src="' . $row['product_img'] . '" class="img-responsive"></img></td>
    <td>' . $row['description'] . '</td>
        <td><a href="' . $row['link'] . '">' . LINK . '</a></td>
            <td>' . $row['cat_name'] . '</td>
                <td>' . $row['brand_name'] . '</td>     
<td>
<input type="hidden"  name="product_id" value="' . $row['product_id'] . '" />
<button type="submit" class="btn btn-danger btn-xs" >' . DELETE_PRODUCT . '</button>
</td>
</tr>
</form>
';
        }
        ?>
    </table>
</div>
<? require_once 'footer.php'; ?>
