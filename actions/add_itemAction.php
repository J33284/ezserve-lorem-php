<?php
// Assuming you have a global database connection $DB
global $DB;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process package information
    $packageName = $_POST['packageName'];
    $packageDescription = $_POST['packageDescription'];
    $businessCode = $_POST['businessCode'];
    $branchCode = $_POST['branchCode'];
    $packCode = $_POST['packCode'];


    // Determine pricing type based on checkboxes
    $pricingType = '';
    $amount = 0;

    if (isset($_POST['perPaxCheckbox']) && $_POST['perPaxCheckbox'] == 'on') {
        $pricingType = 'per pax';
        $amount = isset($_POST['pricePerPax']) ? $_POST['pricePerPax'] : 0;
    } elseif (isset($_POST['totalItemsCheckbox']) && $_POST['totalItemsCheckbox'] == 'on') {
        $pricingType = 'total of items';
    }


    $targetDirectory = "assets/uploads/packages/";

    // Process item groups
    foreach ($_POST['itemName'] as $itemIndex => $itemData) {
        // Process each item in the group
        foreach ($itemData as $key => $value) {
            $itemName = $value;
            $itemDescription = $_POST['itemDescription'][$itemIndex][$key];
            $userInput = isset($_POST['userInput'][$itemIndex][$key]) ? 'enable' : 'disable';

            $targetFile = $targetDirectory . basename($_FILES['itemImage']['name'][$itemIndex][$key]);
            move_uploaded_file($_FILES['itemImage']['tmp_name'][$itemIndex][$key], $targetFile);

            // Insert item information into the 'items' table
            $itemInsertQuery = "INSERT INTO items (itemName, description, packCode, userInput, itemImage) VALUES (?, ?, ?, ?, ?)";
            $itemStatement = $DB->prepare($itemInsertQuery);
            $itemStatement->execute([$itemName, $itemDescription, $packCode, $userInput, $targetFile]);

            // Get the last inserted item code (assuming it's an auto-incremented primary key)
            $itemCode = $DB->insert_id;

            // Only insert quantity, unit, and price if the "per pax" checkbox is not checked
            if (!isset($_POST['perPaxCheckbox']) || $_POST['perPaxCheckbox'] != 'on') {
                $quantity = $_POST['quantity'][$itemIndex][$key];
                $unit = $_POST['unit'][$itemIndex][$key];
                $price = $_POST['price'][$itemIndex][$key];

                // Insert quantity, unit, and price information into the 'items' table
                $updateItemQuery = "UPDATE items SET quantity = ?, unit = ?, price = ? WHERE itemCode = ?";
                $updateItemStatement = $DB->prepare($updateItemQuery);
                $updateItemStatement->execute([$quantity, $unit, $price, $itemCode]);
            }

            
        }
    }

    // Redirect or perform other actions after successful data insertion
    header("Location: ?page=owner_package&businessCode={$businessCode}&branchCode={$branchCode}&packCode={$packCode}");
    exit();
}
?>
