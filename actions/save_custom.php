<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $DB;
    $businessCode = isset($_POST['businessCode']) ? $_POST['businessCode'] : '';
    $branchCode = isset($_POST['branchCode']) ? $_POST['branchCode'] : '';
    $newitemName = $_POST["itemName"];
    $newdescription = $_POST["description"];
    $newprice = $_POST["price"];
    $itemCode = $_POST["itemCode"];

    $updateQuery = "UPDATE custom_items 
                    SET itemName = '$newitemName', description = '$newdescription', price = $newprice
                    WHERE itemCode = '$itemCode'";

    if ($DB->query($updateQuery) === TRUE) {
        echo "Record updated successfully.";
        header ("Location: ?page=custom_package&businessCode=$businessCode&branchCode=$branchCode");
    } else {
        echo "Error updating record: " . $db->error;
    }
}

?>