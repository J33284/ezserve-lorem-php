<?php
if(isset($_POST['businessCode'])) {
    $businessCode = $_POST['businessCode'];

    // Assuming $DB is your database connection object
    global $DB;
    
    

    $deleteBranchesQuery = "DELETE FROM branches WHERE businessCode = ?";
    $stmtBranches = $DB->prepare($deleteBranchesQuery);
    $stmtBranches->bind_param("i", $businessCode);
    $stmtBranches->execute();
    $stmtBranches->close();

    $deletePackageQuery = "DELETE FROM package WHERE packCode IN (SELECT packCode FROM branches WHERE businessCode = ?)";
    $stmtPackage = $DB->prepare($deletePackageQuery);
    $stmtPackage->bind_param("i", $businessCode);
    $stmtPackage->execute();
    $stmtPackage->close();

    $deleteItemsQuery = "DELETE FROM items WHERE itemCode IN (SELECT itemCode FROM branches WHERE businessCode = ?)";
    $stmtItems = $DB->prepare($deleteItemsQuery);
    $stmtItems->bind_param("i", $businessCode);
    $stmtItems->execute();
    $stmtItems->close();

    $deleteCustomCategoryQuery = "DELETE FROM custom_category WHERE customCategoryCode IN (SELECT customCategoryCode FROM custom_items WHERE itemCode IN (SELECT itemCode FROM branches WHERE businessCode = ?))";
    $stmtCustomCategory = $DB->prepare($deleteCustomCategoryQuery);
    $stmtCustomCategory->bind_param("i", $businessCode);
    $stmtCustomCategory->execute();
    $stmtCustomCategory->close();

    $deleteCustomItemsQuery = "DELETE FROM custom_items WHERE itemCode IN (SELECT itemCode FROM branches WHERE businessCode = ?)";
    $stmtCustomItems = $DB->prepare($deleteCustomItemsQuery);
    $stmtCustomItems->bind_param("i", $businessCode);
    $stmtCustomItems->execute();
    $stmtCustomItems->close();

    // Delete data from other tables associated with the owner
    $deleteBusinessQuery = "DELETE FROM business WHERE businessCode = ?";
    $stmtBusiness = $DB->prepare($deleteBusinessQuery);
    $stmtBusiness->bind_param("i", $businessCode);
    $stmtBusiness->execute();
    

    if($stmtBusiness->affected_rows > 0) {
        // Redirect back to the owner page after successful deletion
        header("Location: ?page=admin-bus-list");
        exit(); 
    } else {
        echo "Error deleting owner account.";
    }
    $stmtBusiness->close();
} else {
    echo "Invalid request.";
}
?>
