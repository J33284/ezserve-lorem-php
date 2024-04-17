<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'customOnsite') {
    $businessCode = $_POST['businessCode'];
    $branchCode = $_POST['branchCode'];
    $busName = $_POST['busName'];
    $branchName = $_POST['branchName'];
    $clientID = $_POST['clientID'];
    $clientName = $_POST['clientName'];
    $mobileNumber = $_POST['mobileNumber'];
    $email = $_POST['email'];
    $pDate = isset($_POST['pDate']) ? $_POST['pDate'] : '';
    $dAddress = isset($_POST['deliveryAddress']) ? $_POST['deliveryAddress'] : '';
    $dDate = isset($_POST['deliveryDate']) ? $_POST['deliveryDate'] : '';
    $paymentMethod = "on site payment";
    $status = "unpaid";
    $encodedDetails = json_decode(htmlspecialchars_decode($_POST['orderDetails']), true);
    $transNo = generateRandomTransID();
    $itemsData = array();

    foreach ($encodedDetails as $item) {
        $itemName = $item['itemName'];
        $quantity = $item['quantity'];
        $itemsData[$itemName] = $quantity;
    }
    
    $itemList = json_encode($itemsData);
    
    $discountedTotal = $_POST['discountedTotal'];
    $totalAmount = $_POST['totalAmount'];
 
    if (!empty($discountedTotal)) {
        $totalAmount = $discountedTotal;
    }
    $insertQuery = "INSERT INTO transaction (busName, branchName, businessCode, branchCode, transNo, clientID, clientName, mobileNumber, email, itemList, totalAmount, paymentMethod, status, pickupDate, deliveryDate, deliveryAddress )
                    VALUES ('$busName', '$branchName', '$businessCode', '$branchCode', '$transNo', '$clientID', '$clientName', '$mobileNumber', '$email', '$itemList', '$totalAmount', '$paymentMethod', '$status', '$pDate', '$dDate', '$dAddress')";

    $DB->query($insertQuery);

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