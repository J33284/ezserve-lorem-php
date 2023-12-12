<?php
require_once('vendor/autoload.php');

// Set your PayMongo secret key here
$paymongoSecretKey = 'sk_test_McfYB6NLVEd3oYgQMsyXTW6d';

if (isset($_GET['checkout_session_id'])) {
    $checkoutSessionId = $_GET['checkout_session_id'];

    $client = new \GuzzleHttp\Client();

    try {
        // Retrieve the checkout session details from PayMongo
        $response = $client->request('GET', 'https://api.paymongo.com/v1/checkout_sessions/' . $checkoutSessionId, [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($paymongoSecretKey . ':'),
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        if ($statusCode >= 200 && $statusCode < 300) {
            $responseData = json_decode($body, true);

            // Extract relevant information from the PayMongo response
            $paymentId = $responseData['data']['relationships']['payment']['data']['id'];
            $amountPaid = $responseData['data']['attributes']['amount_paid'];
            $currency = $responseData['data']['attributes']['currency'];

            // Insert the transaction details into your database
            // Modify this part based on your database structure and how you want to store the data
            $DB->query("INSERT INTO transactions (paymentID, amountPaid, currency, checkout_session_id) VALUES ('$paymentId', '$amountPaid', '$currency', '$checkoutSessionId')");

            // Redirect or display a success message to the user
            header('Location: success.php');
            exit;
        } else {
            echo 'Error: HTTP ' . $statusCode . ' - ' . $body;
        }
    } catch (\Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid request. Missing checkout_session_id parameter.';
}
?>
