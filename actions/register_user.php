<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

if (isset($_POST['data'])) {
    
    $_POST['data']['password'] = md5($_POST['data']['password']);
   
    $allowedUsertypes = ['client', 'business owner'];
    if (in_array($_POST['data']['usertype'], $allowedUsertypes)) {
        if ($_POST['data']['usertype'] === 'client') {
            if (add_record("client", $_POST['data'])) {
                set_message("Thank you for your registration.", "success");
                // Redirect to the login page after successful registration.
                header("Location: " . SITE_URL . "/?page=login");
                exit(); // Make sure to exit after redirection.
            } else {
                set_message("Failed to register.", "danger");
            }
        } elseif ($_POST['data']['usertype'] === 'business owner') {
            if (add_record("business_owner", $_POST['data'])) {
                set_message("Thank you for your registration.", "success");
                
                // Redirect to the login page after successful registration.
                header("Location: " . SITE_URL . "?page=email_verification" . urlencode($_POST['data']['email']) . "&code=" . $_POST['data']['verification_code']);
exit();
                exit(); // Make sure to exit after redirection.
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