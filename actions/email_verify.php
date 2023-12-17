<?php

require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $DB;
    $entered_code = $_POST["verification_code"];
    $usertype = isset($_POST['usertype']) ? $_POST['usertype'] : '';

    if ($DB->connect_error) {
        die("Connection failed: " . $DB->connect_error);
    }

    $table = ($usertype === 'client') ? 'client' : 'business_owner';
    $id_column = ($usertype === 'client') ? 'clientID' : 'ownerID';

    $sql = "SELECT * FROM $table WHERE verification_code = '$entered_code'";
    $result = $DB->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user[$id_column];
        $update_sql = "UPDATE $table SET status = 1 WHERE $id_column = $user_id";
        $DB->query($update_sql);

        set_message("Email successfully verified. You can now log in.");
        header("Location: ?page=login");
    } else {
        set_message("Invalid Verification Code");
    }
}

?>
