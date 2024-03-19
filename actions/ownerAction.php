<?php

// Check if the business form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    $userID = $_SESSION['userID'];

    $busName = mysqli_real_escape_string($DB, $_POST["data"]["busName"]);
    $busType = mysqli_real_escape_string($DB, $_POST["data"]["busType"]);
    $house_building = mysqli_real_escape_string($DB, $_POST["data"]["house_building"]);
    $street = mysqli_real_escape_string($DB, $_POST["data"]["street"]);
    $barangay = mysqli_real_escape_string($DB, $_POST["data"]["barangay"]);
    $city_municipality = mysqli_real_escape_string($DB, $_POST["data"]["city_municipality"]);
    $province = mysqli_real_escape_string($DB, $_POST["data"]["province"]);
    $region = mysqli_real_escape_string($DB, $_POST["data"]["region"]);
    $phone = mysqli_real_escape_string($DB, $_POST["data"]["phone"]);
    $mobile = mysqli_real_escape_string($DB, $_POST["data"]["mobile"]);
    $permitsFile = "";
    $sanitaryFile = "";
    $taxFile = "";

    // Check if a file was uploaded for permits
    if ($_FILES["permits"]["error"] == 0) {
        $business = $_FILES["business"];

        $targetDirectory = 'assets/uploads/';
        $targetFile = $targetDirectory . basename($business['name']);

        // Create the target directory if it doesn't exist
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        // Validate file type and size
        $allowedFormats = array("pdf", "jpeg", "jpg", "png");
        $maxFileSize = 5242880; // 5 MB

        if (in_array(pathinfo($business['name'], PATHINFO_EXTENSION), $allowedFormats) && $business['size'] <= $maxFileSize) {
            // Move the file to the specified directory for permits
            if (move_uploaded_file($business['tmp_name'], $targetFile)) {
                $businessFile = $targetFile;
            } else {
                set_message("Failed to upload permits file.");
            }
        } else {
            set_message("Invalid file format or size for permits.");
        }
    }

    // Check if a file was uploaded for sanitary
    if ($_FILES["sanitary"]["error"] == 0) {
        $sanitary = $_FILES["sanitary"];
        $targetFile = $targetDirectory . basename($sanitary['name']);
        if (move_uploaded_file($sanitary['tmp_name'], $targetFile)) {
            $sanitaryFile = $targetFile;
        } else {
            set_message("Failed to upload sanitary file.");
        }
    }

    // Check if a file was uploaded for tax
    if ($_FILES["tax"]["error"] == 0) {
        $tax = $_FILES["tax"];
        $targetFile = $targetDirectory . basename($tax['name']);
        if (move_uploaded_file($tax['tmp_name'], $targetFile)) {
            $taxFile = $targetFile;
        } else {
            set_message("Failed to upload tax file.");
        }
    }

    // SQL statement with placeholders for file paths
    $stmt = $DB->prepare("INSERT INTO business (ownerID, busName, busType, house_building, street, barangay, city_municipality, province, region, phone, mobile, business_permit, sanitary, tax) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssssss", $userID, $busName, $busType, $house_building, $street, $barangay, $city_municipality, $province, $region, $phone, $mobile, $businessFile, $sanitaryFile, $taxFile);

    if ($stmt->execute()) {
        set_message("Thank you for your registration. Please wait for Confirmation");
        header('Location:?page=owner_business');
    } else {
        set_message("Failed Registration: " . $stmt->error);
    }

    $businessCode = $DB->insert_id;

    // Insert permit details into 'permit' table
    $permitTypes = $_POST['permits'];
    $permitFiles = $_FILES['permit_files'];

    foreach ($permitTypes as $index => $permitType) {
        $permitFileName = $permitFiles['name'][$index];
        $permitFileTmpName = $permitFiles['tmp_name'][$index];

        // Move uploaded file to desired location
        $uploadDirectory = 'assets/uploads/permits/';
        $permitFilePath = $uploadDirectory . $permitFileName;
        move_uploaded_file($permitFileTmpName, $permitFilePath);

        // Insert permit details into database
        $permitInsertQuery = "INSERT INTO permits (businessCode, permitType, permitFile) VALUES ($businessCode, '$permitType', '$permitFilePath')";
        $DB->query($permitInsertQuery);
    }

}
        header("Location: ?page=owner_business");
        exit();
?>
