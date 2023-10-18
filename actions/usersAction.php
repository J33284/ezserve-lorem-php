<?php
// Function to update user record
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

// Rest of your existing code for displaying the form
?>
