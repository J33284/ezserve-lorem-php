<?php
// Assuming you have a database connection
global $DB;

// Function to sanitize input data
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    } else {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}

try {
    // Begin a transaction
    $DB->begin_transaction();

    // Get package information
    $packName = sanitizeInput($_POST['packageName'][0]);
    $packDesc = sanitizeInput($_POST['packageDescription'][0]);
    $branchCode = $_POST["branchCode"];

    // Insert into the 'package' table
    $sql = "INSERT INTO package (branchCode, packName, packDesc) VALUES (?, ?, ?)";
    $stmt = $DB->prepare($sql);
    $stmt->bind_param("sss", $branchCode, $packName, $packDesc);
    $stmt->execute();

    $packCode = $DB->insert_id;

    // Get category information
    $categories = $_POST['categoryName'];

    foreach ($categories as $categoryIndex => $categoryNames) {
        // Assuming that the category names are in an array
        foreach ($categoryNames as $categoryName) {
            $categoryName = sanitizeInput($categoryName);

            // Insert into the 'category' table
            $sql = "INSERT INTO category (categoryName, packCode) VALUES (?, ?)";
            $stmt = $DB->prepare($sql);
            $stmt->bind_param("si", $categoryName, $packCode);
            $stmt->execute();

            $categoryCode = $DB->insert_id;

            // Get item information
            $items = $_POST['itemName'][$categoryIndex];
            $descriptions = $_POST['itemDescription'][$categoryIndex];
            $quantities = $_POST['quantity'][$categoryIndex];
            $prices = $_POST['price'][$categoryIndex];
            $units = $_POST['unit'][$categoryIndex];

            foreach ($items as $itemIndex => $itemName) {
                $itemName = sanitizeInput($itemName);
                $description = sanitizeInput($descriptions[$itemIndex]);
                $quantity = sanitizeInput($quantities[$itemIndex]);
                $price = sanitizeInput($prices[$itemIndex]);
                $unit = sanitizeInput($units[$itemIndex]);

                // Insert into the 'items' table
                $sql = "INSERT INTO items (itemName, description, quantity, price, unit, categoryCode) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $DB->prepare($sql);
                $stmt->bind_param("ssidsi", $itemName, $description, $quantity, $price, $unit, $categoryCode);
                $stmt->execute();

                $itemCode = $DB->insert_id;

                // Get detail information
                $detailNames = $_POST['detailName'][$categoryIndex][$itemIndex];
                $detailValues = $_POST['detailValue'][$categoryIndex][$itemIndex];

                foreach ($detailNames as $index => $detailName) {
                    $detailName = sanitizeInput($detailName);
                    $detailValue = sanitizeInput($detailValues[$index]);

                    // Insert into the 'item_details' table
                    $sql = "INSERT INTO item_details (detailName, detailValue, itemCode) VALUES (?, ?, ?)";
                    $stmt = $DB->prepare($sql);
                    $stmt->bind_param("ssi", $detailName, $detailValue, $itemCode);
                    $stmt->execute();
                }
            }
        }
    }

    // Commit the transaction
    $DB->commit();

    header("Location: ?page=package&branchcode=$branchCode");
    exit();
} catch (Exception $e) {
    // Rollback the transaction in case of an exception
    $DB->rollback();

    // Handle the exception (you might want to log it or show an error message)
    echo "Error: " . $e->getMessage();
}
?>
