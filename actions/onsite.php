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
    $paymentMethod = "On-site payment";
    $status = "unpaid";
    $encodedDetails = json_decode(htmlspecialchars_decode($_POST['itemList']), true);
    $transNo = generateRandomTransID();
    $itemNames = array();
    $discountedTotal = isset($_POST['discountedTotal']) ? $_POST['discountedTotal'] : null;
    $totalAmount = isset($encodedDetails['total']) ? filter_var($encodedDetails['total'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : null;

    if (!empty($discountedTotal)) {
        $totalAmount = $discountedTotal;
    }
    $insertQuery = "INSERT INTO transaction (businessCode, branchCode, branchName, transNo, packName, clientID, clientName, mobileNumber, email, busName, totalAmount, paymentMethod, status, pickupDate, deliveryDate, deliveryAddress )
                    VALUES ('$businessCode', '$branchCode', '$branchName', '$transNo', '$packName', '$clientID', '$clientName', '$mobileNumber', '$email', '$busName',  '$totalAmount', '$paymentMethod', '$status', '$pDate', '$dDate', '$dAddress')";

    $DB->query($insertQuery);

    $transID = $DB->insert_id;

    for ($i = 1; $i < count($encodedDetails['packageDetails']); $i++) {
        $item = $encodedDetails['packageDetails'][$i];
        $itemName = $item['itemName'];
        $description = $item['description'];

        $selectedOptions = '';
        if (is_array($item['selectedOptions'])) {
            for ($j = 1; $j < count($item['selectedOptions']); $j++) {
                $selectedOptions .= $item['selectedOptions'][$j] . ', ';
            }
            $selectedOptions = rtrim($selectedOptions, ', ');
        }

        $orderInsertQuery = "INSERT INTO orderlist (transID, clientID, businessCode, itemName, description, variation)
                            VALUES ('$transID','$clientID', '$businessCode', '$itemName', '$description', '$selectedOptions')";
        $DB->query($orderInsertQuery);
    }
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
