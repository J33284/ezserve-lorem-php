<?php
// update_status.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection and session start here

    // Get the submitted status and transaction ID
    $status = $_POST['status'];
    $transID = $_POST['transID'];

    // Perform the database update
    $updateQuery = "UPDATE transact SET status = '$status' WHERE transID = '$transID'";
    $DB->query($updateQuery);

    // Redirect back to the original page
    header("Location: ?page=owner-order-list");
    exit();
}
?>
