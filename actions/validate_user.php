<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    validate_csrf();

    $username = $_POST['username'];
    $enteredPassword = $_POST['password'];


    $ownerQuery = "SELECT ownerID AS ID, username, password, 'business owner' AS usertype, status FROM business_owner WHERE username = ? LIMIT 1";
    $ownerStmt = $DB->prepare($ownerQuery);
    $ownerStmt->bind_param("s", $username);
    $ownerStmt->execute();
    $ownerResult = $ownerStmt->get_result();

    $clientQuery = "SELECT clientID AS ID, username, password, 'client' AS usertype, status FROM client WHERE username = ? LIMIT 1";
    $clientStmt = $DB->prepare($clientQuery);
    $clientStmt->bind_param("s", $username);
    $clientStmt->execute();
    $clientResult = $clientStmt->get_result();

    $adminQuery = "SELECT adminID AS ID, username, password, 'admin' AS usertype, status FROM admin WHERE username = ? LIMIT 1";
    $adminStmt = $DB->prepare($adminQuery);
    $adminStmt->bind_param("s", $username);
    $adminStmt->execute();
    $adminResult = $adminStmt->get_result();

    if ($ownerResult->num_rows) {
        $user = $ownerResult->fetch_object();
    } elseif ($clientResult->num_rows) {
        $user = $clientResult->fetch_object();
    } elseif ($adminResult->num_rows) {
        $user = $adminResult->fetch_object();
    }
    if (isset($user)) {
        $storedPassword = $user->password;

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
                
                switch ($user->usertype) {
                    case 'admin':
                        header("Location: ?page=admin_profile");
                        break;
                    case 'business owner':
                        header("Location: ?page=owner_profile");
                        break;
                    case 'client':
                        header("Location: ?page=client_profile");
                        break;
                    default:
                        header("Location: ?page=default");
                        break;
                }
                exit;
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
