<?php

// Check if the business form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    session_start(); // Start session if not already started
    $userID = $_SESSION['userID'];

    // Your database connection should be established here (assuming $DB is your database connection)

    // Collect form data
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
        $permits = $_FILES["permits"];

        $targetDirectory = 'assets/uploads/';
        $targetFile = $targetDirectory . basename($permits['name']);

        // Create the target directory if it doesn't exist
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        // Validate file type and size
        $allowedFormats = array("pdf", "jpeg", "jpg", "png");
        $maxFileSize = 5242880; // 5 MB

        if (in_array(pathinfo($permits['name'], PATHINFO_EXTENSION), $allowedFormats) && $permits['size'] <= $maxFileSize) {
            // Move the file to the specified directory for permits
            if (move_uploaded_file($permits['tmp_name'], $targetFile)) {
                $permitsFile = $targetFile;
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
    $stmt = $DB->prepare("INSERT INTO business (ownerID, busName, busType, house_building, street, barangay, city_municipality, province, region, phone, mobile, permits, sanitary, tax) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssssss", $userID, $busName, $busType, $house_building, $street, $barangay, $city_municipality, $province, $region, $phone, $mobile, $permitsFile, $sanitaryFile, $taxFile);

    if ($stmt->execute()) {
        set_message("Thank you for your registration. Please wait for Confirmation");
        header('Location:?page=owner_business');
    } else {
        set_message("Failed Registration: " . $stmt->error);
    }

    $businessID = $DB->insert_id;

    $permitTypes = $_POST['permit_type'];
    $permitFiles = $_FILES['permit_files'];

    // Loop through the permit types and files
    for ($i = 0; $i < count($permitTypes); $i++) {
        $permitType = $permitTypes[$i];
        $permitFileName = $permitFiles['name'][$i];
        $permitFileTmpName = $permitFiles['tmp_name'][$i];
        $permitFileSize = $permitFiles['size'][$i];
        $permitFileError = $permitFiles['error'][$i];

        // Check if file was uploaded without errors
        if ($permitFileError === 0) {
            // File path where the file will be stored
            $uploadPath = 'assets/uploads/' . $permitFileName;
            // Move the uploaded file to the desired directory
            move_uploaded_file($permitFileTmpName, $uploadPath);

            // Update the business table
            // You may need to adjust the SQL query based on your table structure
            $sql = "UPDATE business SET permit_type = ?, permit_file = ? WHERE businessCode = ?";
            $stmt = $DB->prepare($sql);
            $stmt->bind_param("ssi", $permitType, $uploadPath, $businessID);
            $stmt->execute();
            $stmt->close();
        }
    }
}
?>
