[<?php
global $DB;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $packageName = $_POST['packageName'];
    $packageDescription = $_POST['packageDescription'];
    $businessCode = $_POST['businessCode'];
    $branchCode = $_POST['branchCode'];
    $categories = $_POST['categories'];
    $customCategoryCode = $_POST['customCategoryCode'];


    $pricingType = '';
    $amount = 0;

    if (isset($_POST['perPaxCheckbox']) && $_POST['perPaxCheckbox'] == 'on') {
        $pricingType = 'per pax';
        $amount = isset($_POST['pricePerPax']) ? $_POST['pricePerPax'] : 0;
    } elseif (isset($_POST['totalItemsCheckbox']) && $_POST['totalItemsCheckbox'] == 'on') {
        $pricingType = 'per item';
    }

    // Insert package information into the 'package' table
    $packageInsertQuery = "INSERT INTO package (packName, packDesc, branchCode, pricingType, amount) VALUES (?, ?, ?, ?, ?)";
    $packageStatement = $DB->prepare($packageInsertQuery);
    $packageStatement->execute([$packageName, $packageDescription, $branchCode, $pricingType, $amount]);

    // Get the last inserted package code (assuming it's an auto-incremented primary key)
    $packCode = $DB->insert_id;

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

            foreach ($categories as $itemIndex => $categoryList) {
                // $itemIndex corresponds to the index of the item group
                // $categoryList is an array containing the selected categories for that item
                
                // Count the number of categories selected for this item
                $categoryCount = count($categoryList);
                
                // Loop through each selected category
                for ($categoryIndex = 0; $categoryIndex < $categoryCount; $categoryIndex++) {
                    $categoryName = $categoryList[$categoryIndex];
                    $customCategoryCode = $_POST['customCategoryCode'][$itemIndex][$categoryIndex]; // Retrieve the custom category code
                    
                    // Check if the category name is not empty before inserting
                    if (!empty($categoryName)) {
                        // Insert category information into the 'item_option' table
                        $categoryInsertQuery = "INSERT INTO item_option (optionName, customCategoryCode, itemCode) VALUES (?, ?, ?)";
                        $categoryStatement = $DB->prepare($categoryInsertQuery);
                        $categoryStatement->execute([$categoryName, $customCategoryCode, $itemCode]);
                    }
                }
            }
            
            

            $detailsCount = count($_POST['detailName'][$itemIndex][$key]);
            for ($detailIndex = 0; $detailIndex < $detailsCount; $detailIndex++) {
                $detailName = $_POST['detailName'][$itemIndex][$key][$detailIndex];
                $detailValue = $_POST['detailValue'][$itemIndex][$key][$detailIndex];
            
                // Check if both detailName and detailValue are not empty before inserting
                if (!empty($detailName) && !empty($detailValue)) {
                    // Insert detail information into the 'item_details' table
                    $detailInsertQuery = "INSERT INTO item_details (detailName, detailValue, itemCode) VALUES (?, ?, ?)";
                    $detailStatement = $DB->prepare($detailInsertQuery);
                    $detailStatement->execute([$detailName, $detailValue, $itemCode]);
                }
            }
            
        }
        
    }


    header("Location: ?page=package&businessCode={$businessCode}&branchCode={$branchCode}");
    exit();
}
?>

