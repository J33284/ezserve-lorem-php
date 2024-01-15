<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'onsite') {
    $packCode = $_POST['packCode'];
    $clientName = $_POST['clientName'];
    $mobileNumber = $_POST['mobileNumber'];
    $email = $_POST['email'];
    $businessCode = $_POST['businessCode'];
    $packName = $_POST['packName'];
    $grandTotal = $_POST['grandTotal'];
    $paymentMethod = "on site payment";
    $status ="unpaid";
    $clientID = $_POST['clientID'];
    

    // Insert the data into the 'payment' table
    $insertQuery = "INSERT INTO payment (packCode, clientID, clientName, mobileNumber, email, businessCode, itemName, amount, paymentMethod, status)
                    VALUES ('$packCode', '$clientID', '$clientName', '$mobileNumber', '$email', '$businessCode', '$packName', '$grandTotal', '$paymentMethod', '$status')";

    // Execute the query
    $DB->query($insertQuery);

    // Optionally, you can redirect the user to a success page
    header('Location: ?page=client-order-history');
    exit();
}
?>
