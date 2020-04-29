<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Storage</title>
</head>
<body>
    <form method="post">
        <input type="file" name="image-data">
        <input type="text" name="image-data">
        <input type="submit">
    </form>
<?php
    if ($_POST['image-data']) {    
        $image = $_POST['image-data'];
        echo $image;
        $imageData = base64_encode(file_get_contents($image));
        echo '<img src="data:image/jpeg;base64,'.$imageData.'">';
    }
?>
</body>
</html>