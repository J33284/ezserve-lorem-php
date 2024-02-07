<?php
global $DB;
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted form data
    $businessCode = $_POST["businessCode"];
    $branchCode = $_POST["branchCode"];
    $packCode = $_POST["packCode"];

    $itemName = $_POST["itemName"];
    $description = $_POST["description"];
    $itemCode = $_POST["itemCode"];

    // Check if itemImage is empty
    if (!empty($_FILES["itemImage"]["name"])) {
        // Handle image upload
        $targetDirectory = "assets/uploads/packages/"; 
        $targetFile = $targetDirectory . basename($_FILES["itemImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["itemImage"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["itemImage"]["size"] < 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["itemImage"]["tmp_name"], $targetFile)) {
                // Update the item details in the database
                $updateQuery = "UPDATE items SET itemName = '$itemName', description = '$description', itemImage = '$targetFile' WHERE itemCode = '$itemCode'";
                $result = $DB->query($updateQuery);

                if ($result) {
                    // Redirect to the edit_package page with appropriate parameters
                    header("Location: ?page=owner_package&businessCode={$businessCode}&branchCode={$branchCode}&packCode={$packCode}"); 
                    exit;
                } else {
                    // Failed to update item details
                    echo "Error updating item details: " . $DB->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Update the item details in the database without updating itemImage
        $updateQuery = "UPDATE items SET itemName = '$itemName', description = '$description' WHERE itemCode = '$itemCode'";
        $result = $DB->query($updateQuery);

        if ($result) {
            // Redirect to the edit_package page with appropriate parameters
            header("Location: ?page=owner_package&businessCode={$businessCode}&branchCode={$branchCode}&packCode={$packCode}"); 
            exit;
        } else {
            // Failed to update item details
            echo "Error updating item details: " . $DB->error;
        }
    }
} 
?>
