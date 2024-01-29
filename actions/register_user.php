<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

require 'vendor/autoload.php'; // Include PHPMailer autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['data'])) {
    $email = $_POST["data"]["email"];
    $username = $_POST["data"]["username"];

    // Check if username already exists in either client or business_owner table
    if (usernameExistsInTable($username, 'client') || usernameExistsInTable($username, 'business_owner')) {
        set_message("Username already exists. Please choose a different username.", "danger");
        register_redirect("?page=register&", $_POST['data']);
        exit();
    }

    // Password Hashing
    $plainPassword = $_POST['data']['password'];
    $repassword = $_POST['data']['repassword'];

    // Check if passwords match
    if ($plainPassword !== $repassword) {
        set_message("Passwords do not match. Please make sure both passwords are the same.", "danger");
        register_redirect("?page=register&", $_POST['data']);
        exit();
    }

    // Check password strength
    if (!isStrongPassword($plainPassword)) {
        set_message("Password is not strong enough.", "danger");
        register_redirect("?page=register&", $_POST['data']);
        exit();
    }
    $verification_code = sprintf('%06d', mt_rand(0, 999999));

    $allowedUsertypes = ['client', 'business owner'];
    $usertype = $_POST['data']['usertype'];

    // Check if the email already exists in the respective table
    if ($usertype === 'client' && emailExistsInTable($email, 'client')) {
        set_message("Email is already registered as a client.", "danger");
        register_redirect("?page=register&", $_POST['data']);
        exit();
    } elseif ($usertype === 'business owner' && emailExistsInTable($email, 'business_owner')) {
        set_message("Email is already registered as a business owner.", "danger");
        register_redirect("?page=register&", $_POST['data']);
        exit();
    }

    
    $hashedPassword = password_hash($plainPassword, PASSWORD_ARGON2I);
    $_POST['data']['password'] = $hashedPassword;

    
    if (in_array($usertype, $allowedUsertypes)) {
        if ($usertype === 'client' && add_record("client", $_POST['data'])) {
            processVerificationEmail($email, $verification_code);
        } elseif ($usertype === 'business owner' && add_record("business_owner", $_POST['data'])) {
            processVerificationEmail($email, $verification_code);
        } else {
            set_message("Failed to register.", "danger");
        }
    } else {
        // Handle the case where an invalid usertype was selected.
        set_message("Invalid usertype selected.", "danger");
    }
}

redirect();

// Function to check if the email exists in the specified table
function emailExistsInTable($email, $table) {
    global $DB;
    $sql = "SELECT COUNT(*) as count FROM $table WHERE email = '$email'";
    $result = mysqli_query($DB, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

function usernameExistsInTable($username, $table) {
    global $DB;
    $sql = "SELECT COUNT(*) as count FROM $table WHERE username = '$username'";
    $result = mysqli_query($DB, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

function isStrongPassword($password) {
    // Add your password strength criteria here
    // For example, you can check minimum length, uppercase, lowercase, numbers, special characters, etc.

    $minLength = 8;
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/\d/', $password);
    $hasSpecialChar = preg_match('/[^a-zA-Z\d]/', $password);

    return strlen($password) >= $minLength && $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar;
}

function processVerificationEmail($email, $verification_code) {
    global $DB;
    $usertype = $_POST['data']['usertype'];
    add_verification_code_to_database($email, $verification_code);

    $mail = configureMailer();

    try {
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email';
        $mail->Body = getEmailBody($verification_code);

        $mail->send();

    header("Location: ?page=email_verification&usertype=" . urlencode($usertype) . "&email=" . urlencode($email));
    exit();


        exit();
    } catch (Exception $e) {
        set_message("Error sending email: {$mail->ErrorInfo}", "danger");
    }
}

function configureMailer() {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Replace with your email provider's SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'officialezserve@gmail.com'; // Replace with your email address
        $mail->Password   = 'ijzf jsos mrtb fbyb'; // Replace with your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('officialezserve@gmail.com', 'EzServe');

        return $mail;
    } catch (Exception $e) {
        echo "Error configuring email: {$e->getMessage()}";
        exit();
    }
}

function getEmailBody($verification_code) {
    return '
        <html>
            <head>
                <style>
                    /* Add your CSS styles here for better email presentation */
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        color: #333;
                        padding: 20px;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #fff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    h1 {
                        color: #007bff;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Verify Your Email</h1>
                    <p>Thank you for registering with EzServe. Your verification code is:</p>
                    <p style="font-size: 24px; font-weight: bold;">'.$verification_code.'</p>
                </div>
            </body>
        </html>
    ';
}

function add_verification_code_to_database($email, $verification_code) {
    global $DB;
    
    $usertype = $_POST["data"]["usertype"];

    if ($usertype === 'client') {
        $table = 'client';
    } elseif ($usertype === 'business owner') {
        $table = 'business_owner';
    } else {
        echo "Invalid usertype";
        return;
    }

    $sql = "UPDATE $table SET verification_code = '$verification_code' WHERE email = '$email'";

    if (mysqli_query($DB, $sql)) {
        echo "Verification code added to $table table successfully.";
    } else {
        echo "Error: " . mysqli_error($DB);
    }
}


function register_redirect($url, $params = array()) {
    $queryString = http_build_query($params);
    header("Location: $url?$queryString");
    exit();
}

?>