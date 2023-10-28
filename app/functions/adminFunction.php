<?php
if (!defined('ACCESS')) {
    die('DIRECT ACCESS NOT ALLOWED');
}

function viewAdmin($adminID) {
    global $DB;

    $query = $DB->prepare("SELECT * FROM admin WHERE adminID = ?");
    $query->bind_param("i", $adminID);

    $query->execute();
    $result = $query->get_result();

    $user = $result->fetch_object();

    return $user;

}



function updateAdmin($adminID, $updatedData) {
    global $DB;

    $updates = [];
    foreach ($updatedData as $key => $value) {
        $updates[] = "$key = '" . $DB->real_escape_string($value) . "'";
    }

    $updatesStr = implode(', ', $updates);
    $sql = "UPDATE admin SET $updatesStr WHERE adminID = $adminID";
    $DB->query($sql);

    return $DB->affected_rows > 0;
}

// Check if form is submitted for updating user details
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $updatedData = array(
       
        'email' => $_POST['email'],
        'username' => $_POST['username']
    );

    $adminID = $_SESSION['userID'];

    if (updateAdmin($adminID, $updatedData)) {
        // Update successful
        set_message( "Changes Saved Successfully" );
        
    } else {
        // Update failed
        echo "Error updating record";
    }
}




?>
