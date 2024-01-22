<?php
require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $packCode = $_POST['packCode'];
    $amount = intval($_POST['grandTotal']);
    $name = $_POST['clientName'];
    $email = $_POST['email'];
    $phone = $_POST['mobileNumber'];
    $name = $_POST['packName'];
    $businessCode = $_POST['businessCode'];

    $_SESSION['businessName'] = ($result = $DB->query("SELECT busName FROM business WHERE businessCode = '$businessCode'")) ? $result->fetch_assoc()['busName'] : null;

    $checkoutData = [
        'data' => [
            'attributes' => [
                'cancel_url' => 'https://example.com/cancel',
                'billing' => [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                ],
                'description' => 'Order Description',
                'line_items' => [
                    [
                        'amount' => $amount * 100, 
                        'currency' => 'PHP',
                        'name' => $name,
                        'quantity' => 1,
                    ],
                ],
                'payment_method_types' => ['card', 'gcash'],
                'reference_number' => 'Webworks',
                'send_email_receipt' => true,
                'show_description' => true,
                'show_line_items' => true,
                'success_url' => 'http://localhost/webworks-lorem-php/?page=client_purchase',
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
