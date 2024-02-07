<?php
global $DB;

// Check if the itemCode parameter is provided in the URL
if(isset($_GET['itemCode'])) {
    // Get the itemCode from the URL
    $businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
    $branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
    $packCode = isset($_GET['packCode']) ? $_GET['packCode'] : '';
    $itemCode = isset($_GET['itemCode']) ? $_GET['itemCode'] : '';

    // Construct the SQL query to delete the item
    $deleteQuery = "DELETE FROM items WHERE itemCode = '$itemCode'";

    // Execute the delete query
    $result = $DB->query($deleteQuery);

    // Check if the deletion was successful
    if($result) {
        // Redirect back to the original page
        header("Location: ?page=owner_package&businessCode={$businessCode}&branchCode={$branchCode}&packCode={$packCode}"); 
        exit;
    } else {
        // If deletion fails, display an error message
        echo "Error deleting item: " . $DB->error;
    }
} 

?>
