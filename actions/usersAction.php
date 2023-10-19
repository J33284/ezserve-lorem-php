<?php
// Function to update profile 
function update($userID, $updatedData) {
    global $DB;

    $updates = [];
    foreach ($updatedData as $key => $value) {
        $updates[] = "$key = '" . $DB->real_escape_string($value) . "'";
    }

    $updatesStr = implode(', ', $updates);
    $sql = "UPDATE users SET $updatesStr WHERE userID = $userID";
    $DB->query($sql);

    return $DB->affected_rows > 0;
}

// Check if form is submitted for updating user details
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $updatedData = array(
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'birthday' => $_POST['birthday'],
        'email' => $_POST['email'],
        'number' => $_POST['number'],
        'username' => $_POST['username']
    );

    $userID = $_SESSION['userID'];

    if (update($userID, $updatedData)) {
        // Update successful
        set_message( "Changes Saved Successfully" );
        
    } else {
        // Update failed
        echo "Error updating record";
    }
}



//register business
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

if (isset($_POST['data'])) {
   
    $allowedBusinesstypes = ['1', '2', '3'];
    if (in_array($_POST['data']['busType'], $allowedBusinesstypes)) {
        if (add_record("business", $_POST['data'])) {
            set_message("Thank you for your registration.", "Please wait for confirmation");
            // Redirect to the login page after successful registration.
            header("Location: " . SITE_URL . "/?page=login");
            exit(); // Make sure to exit after redirection.
        } else {
            set_message("Failed to register.", "danger");
        }
    } else {
        // Handle the case where an invalid usertype was selected.
        set_message("Invalid usertype selected.", "danger");
    }
}

redirect();





