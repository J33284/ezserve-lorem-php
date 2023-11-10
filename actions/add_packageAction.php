<?php
// Include database connection and any necessary configurations
global $DB;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $packCode = isset($_GET['packCode']) ? $_GET['packCode'] : '';
    $packName = $_POST["packName"];
    $categoryName = $_POST["categoryName"];
    $seviceName = $_POST["seviceName"];
    $Description = $_POST["Description"];
    $quantity = $_POST["quantity"];
    $color = $_POST["color"];
    $price = $_POST["price"];

    // Insert data into the 'package' table
    $insertPackageQuery = "INSERT INTO package (packCode, packName) VALUES ('$packCode', '$packName')";
    $DB->query($insertPackageQuery);

    // Get the last inserted packageCode (assuming it's an auto-incremented primary key)
    $packageCode = $DB->insert_id;

    // Insert data into the 'category' table
    $insertCategoryQuery = "INSERT INTO category (packCode, categoryName) VALUES ('$packCode', '$categoryName')";
    $DB->query($insertCategoryQuery);

    // Get the last inserted categoryCode
    $categoryCode = $DB->insert_id;

    // Insert data into the 'service' table
    $insertServiceQuery = "INSERT INTO service (categoryCode, serviceName) VALUES ('$categoryCode', '$productName')";
    $DB->query($insertServiceQuery);

    // Get the last inserted serviceCode
    $serviceCode = $DB->insert_id;

    // Continue with any additional processing or redirect as needed
    if ($serviceCode) {
        // Data inserted successfully
        header (location: "?page=package");
    } else {
        // Error handling
        echo "Error adding package: " . $DB->error;
    }
}
?>
