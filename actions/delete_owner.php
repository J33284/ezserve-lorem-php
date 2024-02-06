<?php
if(isset($_POST['ownerID'])) {
    $ownerID = $_POST['ownerID'];

    // Assuming $DB is your database connection object
    global $DB;
    
    // Delete data from other tables associated with the owner
    $deleteBusinessQuery = "DELETE FROM business WHERE ownerID = ?";
    $stmtBusiness = $DB->prepare($deleteBusinessQuery);
    $stmtBusiness->bind_param("i", $ownerID);
    $stmtBusiness->execute();
    $stmtBusiness->close();

    $deleteBranchesQuery = "DELETE FROM branches WHERE branchCode IN (SELECT branchCode FROM business WHERE ownerID = ?)";
    $stmtBranches = $DB->prepare($deleteBranchesQuery);
    $stmtBranches->bind_param("i", $ownerID);
    $stmtBranches->execute();
    $stmtBranches->close();

    $deletePackageQuery = "DELETE FROM package WHERE packCode IN (SELECT packCode FROM business WHERE ownerID = ?)";
    $stmtPackage = $DB->prepare($deletePackageQuery);
    $stmtPackage->bind_param("i", $ownerID);
    $stmtPackage->execute();
    $stmtPackage->close();

    $deleteItemsQuery = "DELETE FROM items WHERE itemCode IN (SELECT itemCode FROM business WHERE ownerID = ?)";
    $stmtItems = $DB->prepare($deleteItemsQuery);
    $stmtItems->bind_param("i", $ownerID);
    $stmtItems->execute();
    $stmtItems->close();

    $deleteCustomCategoryQuery = "DELETE FROM custom_category WHERE customCategoryCode IN (SELECT customCategoryCode FROM custom_items WHERE itemCode IN (SELECT itemCode FROM business WHERE ownerID = ?))";
    $stmtCustomCategory = $DB->prepare($deleteCustomCategoryQuery);
    $stmtCustomCategory->bind_param("i", $ownerID);
    $stmtCustomCategory->execute();
    $stmtCustomCategory->close();

    $deleteCustomItemsQuery = "DELETE FROM custom_items WHERE itemCode IN (SELECT itemCode FROM business WHERE ownerID = ?)";
    $stmtCustomItems = $DB->prepare($deleteCustomItemsQuery);
    $stmtCustomItems->bind_param("i", $ownerID);
    $stmtCustomItems->execute();
    $stmtCustomItems->close();

    // Delete the owner's data from the `business_owner` table
    $deleteOwnerQuery = "DELETE FROM business_owner WHERE ownerID = ?";
    $stmtOwner = $DB->prepare($deleteOwnerQuery);
    $stmtOwner->bind_param("i", $ownerID);
    $stmtOwner->execute();

    if($stmtOwner->affected_rows > 0) {
        // Redirect back to the owner page after successful deletion
        header("Location: ?page=admin-users");
        exit(); 
    } else {
        echo "Error deleting owner account.";
    }
} else {
    echo "Invalid request.";
}
?>
