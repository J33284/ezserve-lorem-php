<?php if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

    if( !empty( $_POST[ 'username' ] ) && !empty( $_POST[ 'password' ] ) ) {

        validate_csrf();

        $username = $_POST[ 'username' ];
        $password = md5($_POST[ 'password' ]);

        $q = "SELECT * FROM admin WHERE username = ? LIMIT 1";
        $stmt = $DB->prepare($q);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $check = $stmt->get_result();

        if( $check && $check->num_rows ) {
            $user = $check->fetch_object();          
            if( $user->status == 0 ) {
                set_message( "Your account does not exist." . $DB->error, "danger" );
                header("Location: ?page=admin_login");
              
            }
            if ($password == $user->password) {
                $_SESSION[ AUTH_ID ] = $user->adminID;
                $_SESSION[ AUTH_NAME ] = $user->username;
                $_SESSION[ AUTH_TYPE ] = $user->usertype;
                $_SESSION[ AUTH_TOKEN ] = $user->token;
                set_message( "Welcome back {$user->username}!", 'success' );
                header("Location: ?page=default");
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
