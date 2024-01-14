<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $branchCode = isset($_POST['branchCode']) ? $_POST['branchCode'] : '';
    $packCode = isset($_POST['packCode']) ? $_POST['packCode'] : '';
    $categoryCode = isset($_POST['categoryCode']) ? $_POST['categoryCode'] : '';

    // Assuming $DB is your database connection
    global $DB;

    // Insert item information into the database
    foreach ($_POST['itemName'][1] as $key => $itemName) {
        $itemDescription = mysqli_real_escape_string($DB, $_POST['itemDescription'][1][$key]);
        $quantity = (int)$_POST['quantity'][1][$key];
        $price = (float)$_POST['price'][1][$key];

        $itemSql = "INSERT INTO items (itemName, description, quantity, price, categoryCode) 
                    VALUES ('$itemName', '$itemDescription', $quantity, $price, $categoryCode)";
        $DB->query($itemSql);

        $itemCode = $DB->insert_id;

        // Insert details information into the database
        foreach ($_POST['detailName'][1][$key] as $detailKey => $detailName) {
            $detailValue = mysqli_real_escape_string($DB, $_POST['detailValue'][1][$key][$detailKey]);

            $detailSql = "INSERT INTO item_details (itemCode, detailName, detailValue) 
                           VALUES ('$itemCode', '$detailName', '$detailValue')";
            $DB->query($detailSql);
        }
    }

    // Redirect to a success page or do something else
    header("Location: ?page=package&branchcode=$branchCode");
    exit();
}
?>
