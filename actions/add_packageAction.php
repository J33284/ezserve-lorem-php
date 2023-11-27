<?php
// Include database connection and any necessary configurations
global $DB;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $branchCode = isset($_POST['branchcode']) ? $_POST['branchcode'] : '';
    $packName = $_POST["packName"];
    $categoryNames = $_POST["categoryName"];
    $serviceNames = $_POST["serviceName"];
    $descriptions = $_POST["Description"];
    $quantities = $_POST["quantity"];
    $colors = $_POST["color"];
    $prices = $_POST["price"];

    try {
        // Start a database transaction
        $DB->begin_transaction();

        // Insert into package table
        $stmt = $DB->prepare("INSERT INTO package (branchCode, packName) VALUES (?, ?)");
        $stmt->bind_param("ss", $branchCode, $packName);
        $stmt->execute();

        // Get the auto-incremented packCode
        $packCode = $DB->insert_id;

        // Loop through the items and insert into the database
        for ($i = 0; $i < count($categoryNames); $i++) {
            // Insert into category table
            $stmt = $DB->prepare("INSERT INTO category (packCode, categoryName) VALUES (?, ?)");
            $stmt->bind_param("ss", $packCode, $categoryNames[$i]);
            $stmt->execute();

            // Get the auto-incremented categoryCode
            $categoryCode = $DB->insert_id;

            // Insert into service table
            $stmt = $DB->prepare("INSERT INTO service (categoryCode, serviceName, Description, color, quantity, price) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $categoryCode, $serviceNames[$i], $descriptions[$i], $colors[$i], $quantities[$i], $prices[$i]);
            $stmt->execute();
        }

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
    // Redirect to ?page=package
    header('Location: ?page=package&branchcode=' . urlencode($branchCode));
    exit(); // Make sure to exit after the header to prevent further execution
} else {
    // Handle the case where insertion failed
    echo "Insertion failed. Please try again.";
}
?>
