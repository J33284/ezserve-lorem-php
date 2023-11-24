<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    validate_csrf();

    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $userID = null; // Initialize the user ID

    // Check the "business_owner" table
    $ownerQuery = "SELECT ownerID AS ID, username, 'business owner' AS usertype, status FROM business_owner WHERE username = ? AND password = ? LIMIT 1";
    $ownerStmt = $DB->prepare($ownerQuery);
    $ownerStmt->bind_param("ss", $username, $password);
    $ownerStmt->execute();
    $ownerResult = $ownerStmt->get_result();

    // Check the "client" table
    $clientQuery = "SELECT clientID AS ID, username, 'client' AS usertype, status FROM client WHERE username = ? AND password = ? LIMIT 1";
    $clientStmt = $DB->prepare($clientQuery);
    $clientStmt->bind_param("ss", $username, $password);
    $clientStmt->execute();
    $clientResult = $clientStmt->get_result();

    if ($ownerResult->num_rows) {
        $user = $ownerResult->fetch_object();
        $userID = $user->ID;
    }

    if ($clientResult->num_rows) {
        $user = $clientResult->fetch_object();
        $userID = $user->ID;
    }

    if (!is_null($userID)) {
        if ($user->status == 0) {
            header("Location: ?page=profile.php");
            /*set_message("Your account is inactive. Email not verified.", 'danger');
            redirect(LOGIN_REDIRECT); // You can specify the redirection URL here*/
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
    set_message("You must specify the username and password.", "danger");
}
