<?php

$clientID = $_SESSION['userID'];

require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

$checkoutSessionID = $_SESSION['checkout_session_id'];

$response = $client->request('GET', 'https://api.paymongo.com/v1/checkout_sessions/' . $checkoutSessionID, [
    'headers' => [
        'accept'        => 'application/json',
        'authorization' => 'Basic c2tfdGVzdF9NY2ZZQjZOTFZFZDNvWWdRTXN5WFRXNmQ6',
    ],
]);

function saveToDatabase( $dateCreated, $itemName, $amount, $paymentMethod, $status, $paymentId)
{
    global $DB;

    // Divide amount by 100
    $amount /= 100;
    $businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : null;
    $branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : null;
    $busName = isset($_GET['busName']) ? $_GET['busName'] : null;
    $branchName = isset($_GET['branchName']) ? $_GET['branchName'] : null;
    $packName = isset($_GET['packName']) ? $_GET['packName'] : null;
    $clientID = isset($_GET['clientID']) ? $_GET['clientID'] : null;
    $clientName = isset($_GET['clientName']) ? $_GET['clientName'] : null;
    $mobileNumber = isset($_GET['mobileNumber']) ? $_GET['mobileNumber'] : null;
    $email = isset($_GET['email']) ? $_GET['email'] : null;
    $pDate = isset($_GET['pDate']) ? $_GET['pDate'] : null;
    $deliveryDate = isset($_GET['deliveryDate']) ? $_GET['deliveryDate'] : null;
    $deliveryAddress = isset($_GET['deliveryAddress']) ? $_GET['deliveryAddress'] : null;
    
    

    // Insert data into the 'payment' table (customize this query based on your database structure)
    $sql = "INSERT INTO transaction (businessCode, branchCode, busName, branchName, packName, clientID, clientName, mobileNumber, email, pickupDate, deliveryDate, deliveryAddress, transCode, paymentDate, itemList, totalAmount, paymentMethod, status) 
            VALUES ('$businessCode', '$branchCode','$busName', '$branchName', '$packName','$clientID', '$clientName','$mobileNumber', '$email', '$pDate', '$deliveryDate', '$deliveryAddress','$paymentId','$dateCreated', '$itemName', '$amount', '$paymentMethod', '$status')";

    if ($DB->query($sql) === TRUE) {
        header ("Location: ?page=client-order-history");
        echo "Data saved successfully to the 'payment' table!";
    } else {
        echo "Error: " . $sql . "<br>" . $DB->error;
    }
}

// Decode the JSON response
$data = json_decode($response->getBody(), true);

// Check if the 'data' key exists in the response
if (isset($data['data'])) {
    // Extract relevant information
    $amount                = $data['data']['attributes']['line_items'][0]['amount'];
    $itemName              = $data['data']['attributes']['line_items'][0]['name'] ?? '';
    $dateCreatedTimestamp  = $data['data']['attributes']['created_at'];
    $dateCreated           = date('Y-m-d H:i:s', $dateCreatedTimestamp);
    $status                = "paid";
    $sourceInfo            = $data['data']['attributes']['payments'][0]['attributes']['source'] ?? null;
    $paymentId             = $data['data']['attributes']['payments'][0]['id'];
    $paymentMethod         = $sourceInfo['type'] ?? '';

    
    // Save the information to the 'payment' table
    saveToDatabase($dateCreated, $itemName, $amount, $paymentMethod, $status, $paymentId);
} else {
    echo 'No data received from the API.';
}


?>
