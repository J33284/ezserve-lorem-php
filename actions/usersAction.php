<?php
// Function to update profile 
function update($userID, $userType, $updatedData) {
    global $DB;

    $table = ($userType === 'client') ? 'client' : 'business_owner';

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
        'username' => $_POST['username'],
        'ownerAddress' => $_POST['ownerAddress']
    );

    // Handle image upload
    if ($_FILES['addProfileImage']['error'] === UPLOAD_ERR_OK) {
        $tempName = $_FILES['addProfileImage']['tmp_name'];
        $uploadPath = 'assets/uploads/profile/';
        $imageName = $_FILES['addProfileImage']['name'];
        $imagePath = $uploadPath . $imageName;

        move_uploaded_file($tempName, $imagePath);

        // Update profile image path in the database
        $updatedData['profileImage'] = $imagePath;
    }

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
     
    










