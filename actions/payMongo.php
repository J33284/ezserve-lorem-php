<?php
require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $businessCode = $_POST['businessCode'];
    $branchCode = $_POST['branchCode'];
    $busName = $_POST['busName'];
    $branchName = $_POST['branchName'];
    $packName = $_POST['packName'];
    $encodedDetails = json_decode(htmlspecialchars_decode($_POST['itemList']), true);
    $discountedTotal = isset($_POST['discountedTotal']) ? $_POST['discountedTotal'] : null;
    $amount = preg_replace('/[^0-9.]/', '', $encodedDetails['total']);
    if (!empty($discountedTotal)) {
        $amount = $discountedTotal;
    }

// Now you can use $amount as the total amount
    
    $clientID = $_POST['clientID'];
    $clientName = $_POST['clientName'];
    $mobileNumber = $_POST['mobileNumber'];
    $email = $_POST['email'];
    $pDate = $_POST['pDateM'];
    $deliveryDate = $_POST['deliveryDateM'];
    $deliveryAddress = $_POST['deliveryAddressM'];

    if (isset($encodedDetails['items'])) {
        $itemNames = array();
    
        foreach ($encodedDetails['items'] as $item) {
            if (isset($item['itemName'])) {
                $itemNames[] = $item['itemName'];
            }
        }
    
    } else {
        echo "Items not found in the decoded details.";
    }


    $checkoutData = [
        'data' => [
            'attributes' => [
                'cancel_url' => 'https://example.com/cancel',
                'billing' => [
                    'name' => $clientName,
                    'email' => $email,
                    'phone' => $mobileNumber,
                ],
                'description' => $packName,
                'line_items' => [
                    [
                        'amount' => $amount * 100, 
                        'currency' => 'PHP',
                        'name' => $itemNames,
                        'quantity' => 1,
                    ],
                ],
                'payment_method_types' => ['card', 'gcash'],
                'reference_number' => 'Reference',
                'send_email_receipt' => false,
                'show_description' => true,
                'show_line_items' => false,
                'success_url' => 'http://localhost/ezserve/?page=client_purchase&busName=' . $busName . 
                '&packName=' . urlencode($packName) . 
                '&branchName=' . urlencode($branchName) . 
                '&businessCode=' . urlencode($businessCode) .
                '&branchCode=' . urlencode($branchCode) .
                '&clientID=' . urlencode($clientID) . 
                '&clientName=' . urlencode($clientName) . 
                '&mobileNumber=' . urlencode($mobileNumber) . 
                '&email=' . urlencode($email) . 
                '&pDate=' . urlencode($pDate) . 
                '&deliveryDate=' . urlencode($deliveryDate) . 
                '&deliveryAddress=' . urlencode($deliveryAddress),

                'statement_descriptor' => 'Payment',
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
