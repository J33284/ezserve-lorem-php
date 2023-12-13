<?php

$clientID = $_SESSION['userID'];
$businessName = $_SESSION['businessName'];

require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

$checkoutSessionID = $_SESSION['checkout_session_id'];

$response = $client->request('GET', 'https://api.paymongo.com/v1/checkout_sessions/' . $checkoutSessionID, [
    'headers' => [
        'accept'        => 'application/json',
        'authorization' => 'Basic c2tfdGVzdF9NY2ZZQjZOTFZFZDNvWWdRTXN5WFRXNmQ6',
    ],
]);

function saveToDatabase($clientID, $dateCreated, $businessName, $itemName, $amount, $paymentMethod, $status, $sourceId)
{
    global $DB;

    // Divide amount by 100
    $amount /= 100;

    // Insert data into the 'payment' table (customize this query based on your database structure)
    $sql = "INSERT INTO payment (clientID, sourceID, paymentDate, businessName, itemName, amount, paymentMethod, status) 
            VALUES ('$clientID', '$sourceId','$dateCreated', '$businessName', '$itemName', '$amount', '$paymentMethod', '$status')";

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
    $dateCreatedTimestamp  = $data['data']['attributes']['created_at'];
    $dateCreated           = date('Y-m-d H:i:s', $dateCreatedTimestamp);
    $itemName              = $data['data']['attributes']['line_items'][0]['name'] ?? '';
    $status                = $data['data']['attributes']['status'] ?? '';
    $sourceInfo = $data['data']['attributes']['payments'][0]['attributes']['source'] ?? null;
    $sourceId = $sourceInfo['id'] ?? '';
    $paymentMethod = $sourceInfo['type'] ?? '';

    
    // Save the information to the 'payment' table
    saveToDatabase($clientID, $dateCreated, $businessName, $itemName, $amount, $paymentMethod, $status, $sourceId);
} else {
    echo 'No data received from the API.';
}

// Close the database connection
$DB->close();
?>
