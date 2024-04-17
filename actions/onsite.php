<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'onsite') {
    $businessCode = $_POST['businessCode'];
    $branchCode = $_POST['branchCode'];
    $busName = $_POST['busName'];
    $branchName = $_POST['branchName'];
    $packName = $_POST['packName'];
    $clientID = $_POST['clientID'];
    $clientName = $_POST['clientName'];
    $mobileNumber = $_POST['mobileNumber'];
    $email = $_POST['email'];
    $pDate = isset($_POST['pDate']) ? $_POST['pDate'] : '';
    $dAddress = isset($_POST['deliveryAddress']) ? $_POST['deliveryAddress'] : '';
    $dDate = isset($_POST['deliveryDate']) ? $_POST['deliveryDate'] : '';
    $paymentMethod = "on site payment";
    $status = "unpaid";
    $encodedDetails = json_decode(htmlspecialchars_decode($_POST['itemList']), true);
    $transNo = generateRandomTransID();
    // Array to store item names
    $itemNames = array();

    foreach ($encodedDetails['items'] as $item) {
        // Assuming each item has an 'itemName' property
        $itemName = $item['itemName'];

        // Store each item name in the array
        $itemNames[] = $itemName;
    }

    // Combine item names into a comma-separated string
    $combinedItemNames = implode(', ', $itemNames);

    $discountedTotal = isset($_POST['discountedTotal']) ? $_POST['discountedTotal'] : null;
    $totalAmount = isset($encodedDetails['total']) ? filter_var($encodedDetails['total'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : null;

    // Set $totalAmount to $discountedTotal if $discountedTotal is not empty
    if (!empty($discountedTotal)) {
        $totalAmount = $discountedTotal;
    }
    $insertQuery = "INSERT INTO transaction (businessCode, branchCode, branchName, transNo, packName, clientID, clientName, mobileNumber, email, busName, itemList, totalAmount, paymentMethod, status, pickupDate, deliveryDate, deliveryAddress )
                    VALUES ('$businessCode', '$branchCode', '$branchName', '$transNo', '$packName', '$clientID', '$clientName', '$mobileNumber', '$email', '$busName', '$combinedItemNames', '$totalAmount', '$paymentMethod', '$status', '$pDate', '$dDate', '$dAddress')";

    // Execute the query
    $DB->query($insertQuery);

    // Optionally, you can redirect the user to a success page
    header('Location: ?page=client-order-history');
    exit();
}
?>


<?php
function generateRandomTransID($length = 20) {
    $characters = '0123456789';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return  'EzServe_' . $randomString;
}
?>
