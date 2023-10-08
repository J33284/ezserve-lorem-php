<?php if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');
        
    if( !empty( $_POST[ 'username' ] ) && !empty( $_POST[ 'password' ] ) ) {
        
        validate_csrf();
        
        $username = $_POST[ 'username' ];
        $password = $_POST[ 'password' ];

        $q = "SELECT * FROM users WHERE username = ? LIMIT 1";
        $stmt = $DB->prepare($q);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $check = $stmt->get_result();

        if( $check && $check->num_rows ) {
            $users = $check->fetch_object();          
            if( $users->status == 0 ) {
                set_message( "Your account is not yet activated." . $DB->error, "danger" );
                header("Location: " . SITE_URL . "/?page=default");
            }
            if (password_verify($password, $users->password)) {
                $_SESSION[ AUTH_ID ] = $users->userID;
                $_SESSION[ AUTH_NAME ] = $users->username;
                $_SESSION[ AUTH_TYPE ] = $users->usertype;
                $_SESSION[ AUTH_TOKEN ] = $users->token;
                set_message( "Welcome back {$users->fname}!", 'success' );
                header("Location: " . SITE_URL . "/?page=owner-profile");
            } else {        
                set_message( "Invalid login1, please try again." . $DB->error, "danger" );
            }
                    
        } else {        
            set_message( "Invalid login2, please try again." . $DB->error, "danger" );
        }
    } else {        
        set_message( "You must specify the username and password." . $DB->error, "danger" );
    }

    
?>