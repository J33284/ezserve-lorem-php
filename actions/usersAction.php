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
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['updateProfile'])) {
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


     
     ?>
     
    










