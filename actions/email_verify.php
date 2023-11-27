<?php
global $DB;

if (!isset($_GET['email']) || !isset($_GET['code'])) {
    // Handle invalid or missing parameters.
    echo "Invalid or missing parameters.";
    exit();
}

$email = $_GET['email'];
$code = $_GET['code'];

// Query the database to get the stored verification code for the user with this email.
$sql = "SELECT verification_code FROM business_owner WHERE email = '$email'";
$result = $DB->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stored_code = $row['verification_code'];

    // Compare $code with the stored verification code.
    if ($code == $stored_code) {
        // Codes match, update the user's status to verified.
        $update_sql = "UPDATE business_owner SET status = '1' WHERE email = '$email'";
        $DB->query($update_sql);

        // Redirect to the login page.
        header("Location: " . SITE_URL . "/?page=login");
        exit();
    } else {
        echo "Invalid verification code.";
    }
} else {
    echo "User not found.";
}

// Close the database connection
$DB->close();
?>

