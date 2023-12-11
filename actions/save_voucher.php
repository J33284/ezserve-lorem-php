<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'save_voucher') {
    // Assuming you have a database connection, replace 'your_db_connection' with your actual connection code
    global $DB;

    // Retrieve the posted data
    $newBusinessCode = $_POST['newBusinessCode'];
    $newVoucherCode = $_POST['newVoucherCode'];
    $newCondition = $_POST['newCondition'];
    $newDiscount = $_POST['newDiscount'];
    $newStartDate = $_POST['newStartDate'];
    $newEndDate = $_POST['newEndDate'];

    // Perform database insertion
    $query = "INSERT INTO voucher (businessCode, code, cond, discount, startDate, endDate)
              VALUES ('$newBusinessCode', '$newVoucherCode', '$newCondition', '$newDiscount', '$newStartDate', '$newEndDate')";

    // Execute the query
    $result = $DB->query($query);

    if ($result) {
        echo "Data saved successfully!";
        header ("Location: ?page=owner_voucher");
    } else {
        echo "Error saving data to the database!";
    }
} else {
    // Handle invalid access
    die('Invalid access to save_voucher.php');
}
?>


