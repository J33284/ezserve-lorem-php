<?php

// Check if the business form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    $userID = $_SESSION['userID']; 

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
    $permits = $_FILES["permits"];

    // Check if a file was uploaded
    if ($permits['error'] != 0) {
        set_message("File upload error: " . $permits['error']);
        // Handle the error or redirect accordingly
    } else {
        $targetDirectory = 'assets/uploads';
        $targetFile = $targetDirectory . '/' . basename($permits['name']);

        // Create the target directory if it doesn't exist
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        // Validate file type and size
        $allowedFormats = array("pdf", "jpeg", "jpg", "png");
        $maxFileSize = 5242880; // 5 MB

        if (!in_array(pathinfo($permits['name'], PATHINFO_EXTENSION), $allowedFormats) || $permits['size'] > $maxFileSize) {
            set_message("Invalid file format or size.");
            // Handle the error or redirect accordingly
        } else {
            // Move the file to the specified directory
            if (move_uploaded_file($permits['tmp_name'], $targetFile)) {
                // Use prepared statements to prevent SQL injection
                $stmt = $DB->prepare("INSERT INTO business (ownerID, busName, busType, house_building, street, barangay, city_municipality, province, region, phone, mobile, permits) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->bind_param("ssssssssssss", $userID, $busName, $busType, $house_building, $street, $barangay, $city_municipality, $province, $region, $phone, $mobile, $targetFile);

                if ($stmt->execute()) {
                    set_message("Thank you for your registration. Please wait for Confirmation");
                    header('Location:?page=owner_business');
                } else {
                    set_message("Failed Registration: " . $stmt->error);
                }

                $stmt->close();
            } else {
                set_message("Failed to upload file.");
            }
        }
    }
}
?>
