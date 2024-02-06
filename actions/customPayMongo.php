<?php
require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $businessCode = $_POST['businessCode'];
    $branchCode = $_POST['branchCode'];
    $busName = $_POST['busName'];
    $branchName = $_POST['branchName'];
    $discountedTotal = isset($_POST['discountedTotal']) ? $_POST['discountedTotal'] : null;
    $amount = $_POST['totalAmount'];
    if (!empty($discountedTotal)) {
        $amount = $discountedTotal;
    }
    $clientID = $_POST['clientID'];
    $clientName = $_POST['clientName'];
    $mobileNumber = $_POST['mobileNumber'];
    $email = $_POST['email'];
    $pDate = $_POST['pDate'];
    $deliveryDate = $_POST['deliveryDate'];
    $deliveryAddress = $_POST['deliveryAddress'];

    $encodedDetails = json_decode(htmlspecialchars_decode($_POST['orderDetails']), true);

    $itemsData = array();

    foreach ($encodedDetails as $item) {
        // Assuming each item has 'itemName' and 'quantity' properties
        $itemName = $item['itemName'];
        $quantity = $item['quantity'];
        // Store each item name and quantity in the associative array
        $itemsData[$itemName] = $quantity;
    }
    
    // Convert the associative array into a JSON string
    $itemList = json_encode($itemsData);
    
    $checkoutData = [
        'data' => [
            'attributes' => [
                'cancel_url' => 'http://localhost/ezserve/?page=services',
                'billing' => [
                    'name' => $clientName,
                    'email' => $email,
                    'phone' => $mobileNumber,
                ],
                'description' => 'Custom Package (See Order History to see full order details)',
                'line_items' => [
                    [
                        'amount' => $amount * 100, 
                        'currency' => 'PHP',
                        'name' => $itemList,
                        'quantity' => 1,
                    ],
                ],
                'payment_method_types' => ['card', 'gcash'],
                'reference_number' => 'Reference',
                'send_email_receipt' => false,
                'show_description' => true,
                'show_line_items' => false,
                'success_url' => 'http://localhost/ezserve/?page=client_purchase&businessCode=' . $businessCode . 
                '&branchCode=' . urlencode($branchCode) . 
                '&busName=' . urlencode($busName) . 
                '&branchName=' . urlencode($branchName) . 
                '&clientID=' . urlencode($clientID) . 
                '&clientName=' . urlencode($clientName) . 
                '&mobileNumber=' . urlencode($mobileNumber) . 
                '&email=' . urlencode($email) . 
                '&pDate=' . urlencode($pDate) . 
                '&deliveryDate=' . urlencode($deliveryDate) . 
                '&deliveryAddress=' . urlencode($deliveryAddress),

                'statement_descriptor' => 'Payment Example',
            ],
        ],
    ];

    $response = $client->request('POST', 'https://api.paymongo.com/v1/checkout_sessions', [
        'body' => json_encode($checkoutData),
        'headers' => [
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'authorization' => 'Basic c2tfdGVzdF9NY2ZZQjZOTFZFZDNvWWdRTXN5WFRXNmQ6',
        ],
    ]);

    $responseData = json_decode($response->getBody(), true);
    
    $_SESSION['checkout_session_id'] = $responseData['data']['id'];
    // Check if the 'data' key exists in the response
    if (isset($responseData['data'])) {
        $checkoutUrl = $responseData['data']['attributes']['checkout_url'];

        // Redirect the user to the checkout URL
        header("Location: $checkoutUrl");
        exit();
    } else {
        // Handle the case where the 'data' key is not present in the response
        echo "Error retrieving checkout URL.";
    }
}
?>
