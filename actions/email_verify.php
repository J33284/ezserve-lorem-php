<?php


require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $DB;
    $entered_code = $_POST["verification_code"];


    if ($DB->connect_error) {
        die("Connection failed: " . $DB->connect_error);
    }

    $sql = "SELECT * FROM business_owner WHERE verification_code = '$entered_code'";
    $result = $DB->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['ownerID'];
        $update_sql = "UPDATE business_owner SET status = 1 WHERE ownerID = $user_id";
        $DB->query($update_sql);

        set_message ("Email successfully verified. You can now log in.");
        header ("Location: ?page=login");
    } else {
        set_message ("Invalid Verification Code");

    }
}
?>
