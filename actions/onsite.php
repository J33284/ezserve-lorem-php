<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'onsite') {
    $packCode = $_POST['packCode'];
    $clientName = $_POST['clientName'];
    $mobileNumber = $_POST['mobileNumber'];
    $email = $_POST['email'];
    $businessCode = $_POST['businessCode'];
    $grandTotal = $_POST['grandTotal'];
    $clientID = $_POST['clientID'];
    $pDate = isset($_POST['pDate']) ? $_POST['pDate'] : '';
    $dAddress = isset($_POST['deliveryAddress']) ? $_POST['deliveryAddress'] : '';
    $dDate = isset($_POST['deliveryDate']) ? $_POST['deliveryDate'] : '';
    $paymentMethod ="on site payment";    
    $status ="unpaid";

    $encodedDetails = json_decode(htmlspecialchars_decode($_POST['itemList']), true);

    // Use the decoded array directly
    $items = $encodedDetails;

    // Array to store item names
    $itemNames = array();
    
    foreach ($encodedDetails as $item) {
        // Assuming each item has an 'itemName' property
        $itemName = $item['itemName'];

        // Store each item name in the array
        $itemNames[] = $itemName;
    }

    // Combine item names into a comma-separated string
    $combinedItemNames = implode(', ', $itemNames);

    $insertQuery = "INSERT INTO transaction (packCode, clientID, clientName, mobileNumber, email, businessCode, itemName, amount, paymentMethod, status, pDate, dDate, dAddress )
                    VALUES ('$packCode', '$clientID', '$clientName', '$mobileNumber', '$email', '$businessCode', '$combinedItemNames', '$grandTotal', '$paymentMethod', '$status', '$pDate', '$dDate', '$dAddress')";

    // Execute the query
    $DB->query($insertQuery);

    // Optionally, you can redirect the user to a success page
    header('Location: ?page=client-order-history');
    exit();
}
?>
