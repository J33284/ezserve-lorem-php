<?php

$clientID = $_SESSION ['userID'];

require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

$checkoutSessionID = $_SESSION['checkout_session_id'];


$response = $client->request('GET', 'https://api.paymongo.com/v1/checkout_sessions/' . $checkoutSessionID, [
    'headers' => [
      'accept' => 'application/json',
      'authorization' => 'Basic c2tfdGVzdF9NY2ZZQjZOTFZFZDNvWWdRTXN5WFRXNmQ6',
    ],
  ]);

function saveToDatabase($amount) {
    global $DB;

    // Insert data into the 'payment' table (customize this query based on your database structure)
    $sql = "INSERT INTO payment (amount) VALUES ('$amount')";

    if ($DB->query($sql) === TRUE) {
        echo "Data saved successfully to the 'payment' table!";
    } else {
        echo "Error: " . $sql . "<br>" . $DB->error;
    }
}

// Decode the JSON response
$data = json_decode($response->getBody(), true);

// Check if the 'data' key exists in the response
if (isset($data['data'])) {
    // Extract the amount value
    $amount = $data['data']['attributes']['line_items'][0]['amount'];

    // Display the amount in a table
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>Amount</th>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>' . htmlspecialchars($amount) . '</td>';
    echo '</tr>';
    echo '</table>';

    // Save the amount to the 'payment' table
    saveToDatabase($amount);
} else {
    echo 'No data received from the API.';
}

// Close the database connection
$DB->close();
?>


