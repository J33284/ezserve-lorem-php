<?php if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

    if( !empty( $_POST[ 'username' ] ) && !empty( $_POST[ 'password' ] ) ) {

        $username = $_POST[ 'username' ];
        $password = $_POST[ 'password' ];

        $q = "SELECT * FROM admin WHERE username = ? LIMIT 1";
        $stmt = $DB->prepare($q);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $check = $stmt->get_result();

        if( $check && $check->num_rows ) {
            $user = $check->fetch_object();          
            if ($password == $user->password) {
                $_SESSION[ AUTH_ID ] = $user->userID;
                $_SESSION[ AUTH_NAME ] = $user->username;
                $_SESSION[ AUTH_TYPE ] = $user->usertype;
                set_message( "Welcome back {$user->username}!", 'success' );
                header("Location: " . SITE_URL . "/?page=admin-bus-list");
            } else {        
                set_message( "Invalid login, please try again." . $DB->error, "danger" );
            }
                    
        } else {        
            set_message( "Invalid login, please try again." . $DB->error, "danger" );
        }
    } else {        
        set_message( "You must specify the username and password." . $DB->error, "danger" );
    }
?>
