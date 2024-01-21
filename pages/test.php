<?php
// Assuming you have a database connection in $DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['upload']['name'][0])) {
        $uploadDir = 'assets/uploads/packages/';  // Create a folder named 'uploads' in the same directory as this PHP file

        foreach ($_FILES['upload']['name'] as $key => $value) {
            $uploadFile = $uploadDir . basename($_FILES['upload']['name'][$key]);
            $imageData = file_get_contents($_FILES['upload']['tmp_name'][$key]);

            if (move_uploaded_file($_FILES['upload']['tmp_name'][$key], $uploadFile)) {
                // Use prepared statement to insert data
                $insertQuery = "INSERT INTO images (image_data) VALUES (?)";
                $stmt = $DB->prepare($insertQuery);
                $stmt->bind_param("s", $imageData);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="upload[]" accept="image/*" required multiple>
    <input type="submit" value="Upload">
</form>

<?php
// Display uploaded images
$imagesQuery = "SELECT * FROM images";
$result = $DB->query($imagesQuery);

while ($row = $result->fetch_assoc()) {
    $imageData = base64_encode($row['image_data']);
    $src = "data:image/jpeg;base64, $imageData";
    
    echo "<img src='$src' style='max-width: 200px; max-height: 200px;'>";
    echo "<a href='$src' target='_blank'>View Image</a><br>";
}
?>

<script>
    function addImageField() {
        var fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.name = 'upload[]';
        fileInput.accept = 'image/*';
        document.querySelector('form').appendChild(fileInput);
    }
</script>

<button onclick="addImageField()">Add Image</button>

</body>
</html>
