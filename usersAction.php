<?php

/*
|--------------------------------------------------------------------------
| Actions Management
|--------------------------------------------------------------------------
|
| Here is where you can add all the actions for your application. These
| actions are connected by the corresponding functions within your "app/functions" folder which
| is assigned in every "pages" group. Enjoy building your Actions!
|
*/

if (!defined('ACCESS')) {
    die('DIRECT ACCESS NOT ALLOWED');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    validate_csrf_token();

    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $birthday = $_POST['birthday'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);


        createUser($fname, $lname, $email,$birthday, $number, $username);
        // Redirect or perform additional actions as needed
    }

    if (isset($_POST['update'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $birthday = $_POST['birthday'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $username = $_POST['username'];
 

        updateUser($fname, $lname, $birthday,$email, $number, $username, $password,$token);
        // Redirect or perform additional actions as needed
    }    

    if (isset($_POST['btn-updatePassword'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = $_GET['token'];

        updateUserPassword($password, $token);
        // Redirect or perform additional actions as needed
    }

    if (isset($_POST['btn-delete'])) {
        $token = $_GET['token'];

        deleteUser($token);
        // Redirect or perform additional actions as needed
    }
}*/
?>
