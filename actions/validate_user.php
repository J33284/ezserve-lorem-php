<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    validate_csrf();

    $username = $_POST['username'];
    $enteredPassword = $_POST['password'];

    // Check the "business_owner" table
    $ownerQuery = "SELECT ownerID AS ID, username, password, 'business owner' AS usertype, status FROM business_owner WHERE username = ? LIMIT 1";
    $ownerStmt = $DB->prepare($ownerQuery);
    $ownerStmt->bind_param("s", $username);
    $ownerStmt->execute();
    $ownerResult = $ownerStmt->get_result();

    // Check the "client" table
    $clientQuery = "SELECT clientID AS ID, username, password, 'client' AS usertype, status FROM client WHERE username = ? LIMIT 1";
    $clientStmt = $DB->prepare($clientQuery);
    $clientStmt->bind_param("s", $username);
    $clientStmt->execute();
    $clientResult = $clientStmt->get_result();

    if ($ownerResult->num_rows) {
        $user = $ownerResult->fetch_object();
    } elseif ($clientResult->num_rows) {
        $user = $clientResult->fetch_object();
    }

    if (isset($user)) {
        $storedPassword = $user->password;

        // Verify the entered password against the stored hashed password
        if (password_verify($enteredPassword, $storedPassword)) {
            $userID = $user->ID;

            if ($user->status == 0) {
                header("Location: ?page=login");
            } else {
                $_SESSION[AUTH_ID] = $userID;
                $_SESSION[AUTH_NAME] = $user->username;
                $_SESSION[AUTH_TYPE] = $user->usertype;
                $_SESSION[AUTH_TOKEN] = $user->token;
                set_message("Welcome back {$user->username}!", 'success');
                redirect(); // Redirect to the desired location for active users
            }
        } else {
            set_message("Invalid login, please try again.", "danger");
        }
    } else {
        set_message("Invalid login, please try again.", "danger");
    }
} else {
    set_message("You must specify the username and password.", "danger");
}
?>
