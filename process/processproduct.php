
<?php require_once '../config/conf.php'; ?>

<?php
$product_name = $_POST['name'];
$product_img = $_POST['slika'];
$brand = $_POST['brand'];
$category = $_POST['category'];
$rte = $_POST['rte'];
$link = $_POST['link'];

if ($product_name == NULL) {
    echo "error";
} else {

    $sql = "INSERT INTO product (product_name, product_img, brand_id, cat_id, description, link) VALUES ('$product_name', '$product_img', '$brand', '$category', '$rte', '$link')";
    if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con));
    }
    header('Location: ../index.php');

    mysqli_close($con);
}
?>
</body>
</html>