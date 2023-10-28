<?php
// Check if the form was submitted
     
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    // Get user ID (replace this with your actual way of obtaining the user's session ID)
    $userID = $_SESSION['userID']; 

    // Collect form data
    $ownerName = mysqli_real_escape_string($DB, $_POST["data"]["ownerName"]);
    $ownerAddress = mysqli_real_escape_string($DB, $_POST["data"]["ownerAddress"]);
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
    $coordinates = mysqli_real_escape_string($DB, $_POST["data"]["coordinates"]);
    $permits = $_FILES["permits"];

    // Check if a file was uploaded
    if ($permits['error'] == 0) {
        $targetDirectory = 'assets/uploads';
        $targetFile = $targetDirectory . '/' . basename($permits['name']);

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        if (move_uploaded_file($permits['tmp_name'], $targetFile)) {
            $sql = "INSERT INTO business (ownerID, ownerName, ownerAddress, busName, busType, house_building, street, barangay, city_municipality, province, region, phone, mobile, coordinates, permits)
                    VALUES ('$userID', '$ownerName', '$ownerAddress', '$busName', '$busType', '$house_building', '$street', '$barangay', '$city_municipality', '$province', '$region', '$phone', '$mobile', '$coordinates', '$targetFile')";

            if ($DB->query($sql) === TRUE) {
                set_message("Thank you for your registration. Please wait for Confirmation");
            } else {
                set_message("Failed Registration: " . $DB->error);
            }
        } else {
            set_message("Failed to upload file.");
        }
    }
}

?>