<?php
global $DB;

// Check if the itemCode parameter is provided in the URL
if(isset($_GET['itemCode'])) {
    // Get the itemCode from the URL
    $businessCode = $_POST["businessCode"];
    $branchCode = $_POST["branchCode"];
    $packCode = $_POST["packCode"];
    $itemCode = $_GET['itemCode'];
    
    // Construct the SQL query to delete the item
    $deleteQuery = "DELETE FROM items WHERE itemCode = '$itemCode'";

    // Execute the delete query
    $result = $DB->query($deleteQuery);

    // Check if the deletion was successful
    if($result) {
        // Redirect back to the original page
        header("Location: original_page.php"); // Replace 'original_page.php' with the correct page URL
        exit;
    } else {
        // If deletion fails, display an error message
        echo "Error deleting item: " . $DB->error;
    }
} else {
    // If itemCode parameter is not provided, redirect back to the original page
    header("Location: ?page=owner_package&businessCode={$businessCode}&branchCode={$branchCode}&packCode={$packCode}"); 
    exit;
}
?>
