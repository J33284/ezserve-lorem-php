<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

// Assuming $DB is your database connection object

// Check if itemCode is provided in the GET request
if (isset($_GET['itemCode'])) {
    $itemCode = $_GET['itemCode'];

    // Fetch item details from the custom_items table
    $itemQuery = $DB->query("SELECT * FROM custom_items WHERE itemCode = '$itemCode'");

    if ($itemQuery) {
        $item = $itemQuery->fetch_assoc();

        // Respond with JSON
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'item' => $item]);
        exit();
    } else {
        // Error fetching item details
        echo json_encode(['success' => false]);
        exit();
    }
} else {
    // itemCode not provided
    echo json_encode(['success' => false]);
    exit();
}
?>
