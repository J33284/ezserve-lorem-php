<?php
// Function to update profile 
function update($userID, $userType, $updatedData) {
    global $DB;

    $table = ($userType === 'client') ? 'client' : 'owner';

    $updates = [];
    foreach ($updatedData as $key => $value) {
        $updates[] = "$key = '" . $DB->real_escape_string($value) . "'";
    }

    $updatesStr = implode(', ', $updates);
    $sql = "UPDATE $table SET $updatesStr WHERE " . (($userType === 'client') ? 'clientID' : 'ownerID') . " = $userID";
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

    $userID = $_SESSION[AUTH_ID]; // Use the appropriate AUTH_ID based on user type
    $userType = $_SESSION[AUTH_TYPE]; // Get the user type from the session

    if (update($userID, $userType, $updatedData)) {
        // Update successful
        set_message("Changes Saved Successfully");
    } else {
        // Update failed
        echo "Error updating record";
    }
}


//
if (isset($_POST['data'])) {
    // Check if the user is logged in (you may have your own logic for this)
    if (isset($_SESSION['ownerID'])) {
        $ownerID = $_SESSION['ownerID'];
        $businessData = $_POST['data'];
        $businessData['ownerID'] = $ownerID; // Add the user ID to the business data.

        $allowedBusinesstypes = ['1', '2', '3'];
        if (in_array($businessData['busType'], $allowedBusinesstypes)) {
            if (add_record("business", $businessData)) {
                set_message("Thank you for your registration.", "Please wait for confirmation");
                // Redirect to a page where the user can view their business details or perform other actions.
                header("Location: " . SITE_URL . "/?page=admin");
                exit(); // Make sure to exit after redirection.
            } else {
                set_message("Failed to register.", "danger");
            }
        } else {
            // Handle the case where an invalid usertype was selected.
            set_message("Invalid usertype selected.", "danger");
        }
    } else {
        redirect();
       
    }
}









