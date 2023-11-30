<?php
// Include database connection and any necessary configurations
global $DB;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $branchCode = isset($_POST['branchcode']) ? $_POST['branchcode'] : '';
    $packCode = isset($_POST['packagecode']) ? $_POST['packagecode'] : '';
    $categoryName = $_POST["categoryName"];
    $serviceName = $_POST["serviceName"];
    $Description = $_POST["Description"];
    $quantity = $_POST["quantity"];
    $unit = $_POST["unit"];
    $color = $_POST["color"];
    $size = $_POST["size"];
    $price = $_POST["price"];

    try {
        // Start a database transaction
        $DB->begin_transaction();

        // Insert into category table
        $stmt = $DB->prepare("INSERT INTO category (packCode, categoryName) VALUES (?, ?)");
        $stmt->bind_param("ss", $packCode, $categoryName);
        $stmt->execute();
        
        // Get the auto-incremented categoryCode
        $categoryCode = $DB->insert_id;

        // Insert into service table
        $stmt = $DB->prepare("INSERT INTO service (categoryCode, serviceName, Description, quantity, unit, color, size, price) VALUES (?, ?, ?, ?, ?, ?,?,?)");
        $stmt->bind_param("ssssssss", $categoryCode, $serviceName, $Description, $quantity, $unit, $color, $size, $price);
        $stmt->execute();

        // Commit the transaction if all queries were successful
        $DB->commit();

        // Set a flag for successful insertion
        $insertionSuccess = true;

    } catch (Exception $e) {
        // Rollback the transaction if any query fails
        $DB->rollback();

        // Set the flag for unsuccessful insertion
        $insertionSuccess = false;

        // Output the error message
        echo "Error: " . $e->getMessage();
    }
}

// Check if the insertion was successful
if ($insertionSuccess) {
    // Redirect to the previous page with the correct branchcode and packagecode
    header('Location: ?page=package&branchcode=' . urlencode($branchCode));
    exit(); // Make sure to exit after the header to prevent further execution
} else {
    // Handle the case where insertion failed
    echo "Insertion failed. Please try again.";
}
?>
