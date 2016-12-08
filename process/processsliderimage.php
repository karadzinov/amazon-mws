<?php require_once '../config/conf.php'; ?>
<?php
$image = $_POST['slika'];
$img_title = $_POST['name'];
$img_text = $_POST['opis'];

if ($image == NULL) {
    echo "error"; 
} else {

    $sql = "INSERT INTO sliderimages (image, img_text, img_title) VALUES ('$image', '$img_text', '$img_title')";
    if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con));
    }
    header('Location: /index.php');

    mysqli_close($con);
}
?>
</body>
</html>