<?php
// Assuming you have a global database connection $DB
global $DB;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process package information
    $categoryName = $_POST['categoryName'];
    $businessCode = $_POST['businessCode'];
    $branchCode = $_POST['branchCode'];
    $customCategoryCode = $_POST['customCategoryCode'];

    $targetDirectory = "assets/uploads/custom-packages/";
    // Process item groups
    foreach ($_POST['itemName'] as $itemIndex => $itemData) {
        // Process each item in the group
        foreach ($itemData as $key => $value) {
            $itemName = $value;
            $itemDescription = $_POST['itemDescription'][$itemIndex][$key];
            $price = $_POST['price'][$itemIndex][$key];
            $targetFile = $targetDirectory . basename($_FILES['itemImage']['name'][$itemIndex][$key]);
            move_uploaded_file($_FILES['itemImage']['tmp_name'][$itemIndex][$key], $targetFile);
    

            // Insert item information into the 'items' table
            $itemInsertQuery = "INSERT INTO custom_items (itemName, description, price, customCategoryCode, custom_itemImage) VALUES (?, ?, ?, ?, ?)";
            $itemStatement = $DB->prepare($itemInsertQuery);
            $itemStatement->execute([$itemName, $itemDescription, $price, $customCategoryCode, $targetFile ]);

            // Get the last inserted item code (assuming it's an auto-incremented primary key)
            $itemCode = $DB->insert_id;

            
        }
    }

    // Redirect or perform other actions after successful data insertion
    header("Location: ?page=custom_package&businessCode={$businessCode}&branchCode={$branchCode}");
    exit();
}
?>
