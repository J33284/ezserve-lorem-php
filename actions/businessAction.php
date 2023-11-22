<?php
// Check if the form is submitted
if (isset($_POST['updateBusiness'])) {
    global $DB;

    $businessCode = $_POST['business_Code'];
    $busName = mysqli_real_escape_string($DB, $_POST['data']['busName']);
    $about = mysqli_real_escape_string($DB, $_POST['data']['about']);
    $phone = mysqli_real_escape_string($DB, $_POST['data']['phone']);
    
    // Check if a new image is uploaded
    $imagePath = ''; // Initialize imagePath variable

    if (!empty($_FILES['busImage']['name'])) {
        $targetDirectory = "assets/uploads/business/"; // Ensure the trailing slash
        $targetFile = $targetDirectory . basename($_FILES['busImage']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        $check = getimagesize($_FILES['busImage']['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size if needed
        if ($_FILES['busImage']['size'] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Move the uploaded file to the target directory
        if ($uploadOk) {
            if (move_uploaded_file($_FILES['busImage']['tmp_name'], $targetFile)) {
                $imagePath = $targetFile; // Set imagePath variable
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // No new image uploaded, retain the previous image path
        $imagePath = mysqli_real_escape_string($DB, $_POST['data']['prevImage']);
    }

    // Update the business information in the database, including the image path
    $sql = "UPDATE business SET busName = '$busName', about = '$about', phone = '$phone', busImage = '$imagePath' WHERE businessCode = '$businessCode'";

    if ($DB->query($sql) === true) {
        header("Location: ?page=branches&businesscode=$businessCode");
    } else {
        // Handle the update failure
        echo "Error updating business information: " . $DB->error;
    }
}
?>

<?php
// Check if the form is submitted
if (isset($_POST['updateBranch'])) {
    global $DB;

    // Sanitize and validate the input data as needed
    $branchCode = $_POST['branch_Code'];
    $branchName = mysqli_real_escape_string($DB, $_POST['data']['branchName']);
    $address = mysqli_real_escape_string($DB, $_POST['data']['address']);
    $coordinates = mysqli_real_escape_string($DB, $_POST['data']['coordinates']);

    $imagePathBranch = ''; // Initialize imagePath variable

    if (!empty($_FILES['branchImage']['name'])) {
        $targetDirectory = "assets/uploads/branches/"; // Ensure the trailing slash
        $targetFile = $targetDirectory . basename($_FILES['branchImage']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        $check = getimagesize($_FILES['branchImage']['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size if needed
        if ($_FILES['branchImage']['size'] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Move the uploaded file to the target directory
        if ($uploadOk) {
            if (move_uploaded_file($_FILES['branchImage']['tmp_name'], $targetFile)) {
                $imagePathBranch = $targetFile; // Set imagePath variable
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // No new image uploaded, retain the previous image path
        $imagePathBranch = mysqli_real_escape_string($DB, $_POST['data']['prevBranch']);
    }

    // Update the business information in the database, including the image path
    $sql = "UPDATE branches SET branchName = '$branchName', address = '$address', coordinates = '$coordinates', branchImage = '$imagePathBranch' WHERE branchCode = '$branchCode'";

    if ($DB->query($sql) === true) {
        header("Location: ?page=owner_business");
    } else {
        // Handle the update failure
        echo "Error updating business information: " . $DB->error;
    }
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createBranch'])) {
   
    global $DB;

    $businessCode = $_POST['add_branch'];
    $branchName = $_POST['data']['branchName'];
    $address = $_POST['data']['address'];
    $coordinates = $_POST['data']['coordinates'];

    // File handling
    $uploadDirectory = 'assets/uploads/branches/'; // Define your upload directory path
    $uploadedFile = $_FILES['addBranchImage'];

    // Initialize $uniqueFilename outside the if block
    $uniqueFilename = "";

    if ($uploadedFile['error'] === UPLOAD_ERR_OK){
        // Generate a unique filename
        $uniqueFilename = uniqid() . '_' . $uploadedFile['name'];

        // Check if the file is a valid image
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileInfo = getimagesize($uploadedFile['tmp_name']);

        if ($fileInfo && in_array($fileInfo['mime'], $allowedMimeTypes)) {
            // Move the uploaded file to the desired directory
            if (is_uploaded_file($uploadedFile['tmp_name']) && move_uploaded_file($uploadedFile['tmp_name'], $uploadDirectory . $uniqueFilename)) {
                // File was successfully uploaded
                // You can store $uniqueFilename in the database as a reference to the uploaded file.
            } else {
                // Handle file upload error
                echo "File upload failed.";
            }
        } else {
            // Invalid file type
            echo "Invalid file type. Please upload a JPEG, PNG, or GIF image.";
        }
    }

    // SQL query to insert branch data into the branches table
    $sql = "INSERT INTO branches (businessCode, branchName, address, coordinates, branchImage) VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $DB->prepare($sql);
    $stmt->bind_param("issss", $businessCode, $branchName, $address, $coordinates, $uniqueFilename);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Insertion successful
        header("Location: ?page=branches&businesscode=$businessCode");
    } else {
        // Insertion failed
        echo "Error: " . $sql . "<br>" . $DB->error;
    }

    $stmt->close();
}
?>
