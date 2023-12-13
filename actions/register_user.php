


<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

require 'vendor/autoload.php'; // Include PHPMailer autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (isset($_POST['data'])) {
    $email = $_POST["data"]["email"];
    $_POST['data']['password'] = md5($_POST['data']['password']);
    $verification_code = sprintf('%06d', mt_rand(0, 999999));
   
    $allowedUsertypes = ['client', 'business owner'];
    if (in_array($_POST['data']['usertype'], $allowedUsertypes)) {
        if ($_POST['data']['usertype'] === 'client') {
            if (add_record("client", $_POST['data'])) {
                add_verification_code_to_database($verification_code);

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com'; // Replace with your email provider's SMTP server
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'officialwebworks@gmail.com'; // Replace with your email address
                    $mail->Password   = 'prtn iybg regr ejei'; // Replace with your email password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;
        
                    $mail->setFrom('officialwebworks@gmail.com', 'Webworks');
                    $mail->addAddress($email, $username);
        
                    $mail->isHTML(true);
                    $mail->Subject = 'Verify Your Email';
                    $mail->Body    = "Your verification code is: $verification_code";
        
                    $mail->send();
        
                    // Redirect to verification page
                    header("Location: ?page=email_verification");
                
        
                //set_message("Thank you for your registration.", "success");
                // Redirect to the login page after successful registration.
                //header("Location: " . SITE_URL . "/?page=login");
                exit(); 
                }catch (Exception $e) {
                    echo "Error sending email: {$mail->ErrorInfo}";
                }
            } else {
                set_message("Failed to register.", "danger");
            }
        } elseif ($_POST['data']['usertype'] === 'business owner') {
            if (add_record("business_owner", $_POST['data'])) {
                add_verification_code_to_database($verification_code);
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com'; // Replace with your email provider's SMTP server
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'officialwebworks@gmail.com'; // Replace with your email address
                    $mail->Password   = 'prtn iybg regr ejei'; // Replace with your email password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;
        
                    $mail->setFrom('officialwebworks@gmail.com', 'Webworks');
                    $mail->addAddress($email, $username);
        
                    $mail->isHTML(true);
                    $mail->Subject = 'Verify Your Email';
                    $mail->Body    = "Your verification code is: $verification_code";
        
                    $mail->send();
        
                    // Redirect to verification page
                    header("Location: ?page=email_verification");
                
    
                exit(); 
                }catch (Exception $e) {
                    set_message ("Error sending email: {$mail->ErrorInfo}");
                }
            } else {
                set_message("Failed to register.", "danger");
            }
        }
    } else {
        // Handle the case where an invalid usertype was selected.
        set_message("Invalid usertype selected.", "danger");
    }
}

redirect();
?>

<?php
function add_verification_code_to_database($verification_code) {
    // Assuming you have a mysqli connection established earlier in your code
    global $DB;
    $email = $_POST["data"]["email"];
    // Replace 'business_owner' and adjust column names as needed
    $sql = "UPDATE business_owner SET verification_code = '$verification_code' WHERE email = '$email'";

    // Perform the query
    if (mysqli_query($DB, $sql)) {
        // Query successful
        echo "Verification code added to business_owner table successfully.";
    } else {
        // Query failed
        echo "Error: " . sql($DB);
    }
}
?>
