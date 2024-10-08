<?php

/*
|--------------------------------------------------------------------------
| Function Management
|--------------------------------------------------------------------------
|
| Here is where you can add all the functions for your application. These
| functions are connected by the corresponding table within your Database which
| is assigned in every "pages" group. Enjoy building your Functions!
|
*/

if (!defined('ACCESS')) {
    die('DIRECT ACCESS NOT ALLOWED');
}

// Function to View 
function viewUser($userID) {
    global $DB;

    $usertype = $_SESSION[AUTH_TYPE]; 

    if ($usertype === 'client') {
        $query = $DB->prepare("SELECT * FROM client WHERE clientID = ?");
    } elseif ($usertype === 'business owner') {
        $query = $DB->prepare("SELECT * FROM business_owner WHERE ownerID = ?");
    } else {
        return null;
    }

    $query->bind_param("i", $userID);

    $query->execute();
    $result = $query->get_result();

    $user = $result->fetch_object();

    return $user;
}



  
/*
function viewBusiness($userID) {
    global $DB;
   
    $query = $DB->prepare("SELECT users.*, business.* FROM users 
                          JOIN business ON users.BusinessCode = business.BusinessCode 
                          WHERE users.userID = ?");
    ");
    $query->bind_param("i", $userID);

    $query->execute();
    $result = $query->get_result();

    // Fetch the result as an associative array
    $user = $result->fetch_assoc();

    return $user;
}
*/
// Function to add 
/*function createUser($fname, $mname, $lname, $username, $password, $emp_gender, $usertype)
{
    global $DB;

    $token = bin2hex(random_bytes(16));

    // Check if the username or password already exists
    $sql_check = "SELECT COUNT(*) AS count FROM users WHERE username = ? OR password = ?";
    $stmt_check = $DB->prepare($sql_check);
    $stmt_check->bind_param("ss", $username, $password);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_count = $result_check->fetch_assoc()['count'];

    if ($row_count > 0) {
        set_message("<i class='fa fa-times'></i> Username or Password Already Exists", 'danger');
        return false;
    }

    // Insert 
    $sql_insert = "INSERT INTO users SET fname=?, mname=?, lname=?, username=?, password=?, emp_gender=?, usertype=?, token=?";
    $stmt_insert = $DB->prepare($sql_insert);
    $stmt_insert->bind_param("ssssssss", $fname, $mname, $lname, $username, $password, $emp_gender, $usertype, $token);

    if ($stmt_insert->execute()) {
        set_message("<i class='fa fa-check'></i> User Added Successfully", 'success');
        return true;
    } else {
        set_message("<i class='fa fa-times'></i> User Failed to Add" . $DB->error, 'danger');
        return false;
    }
}

// Function to update
function updateUser($fname, $lname, $birthday, $email, $number, $username, $token)
{
    global $DB;

    // Check if the username already exists
    $sql_check = "SELECT COUNT(*) AS count FROM users WHERE username = ? AND token <> ?";
    $stmt_check = $DB->prepare($sql_check);
    $stmt_check->bind_param("ss", $username, $token);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_count = $result_check->fetch_assoc()['count'];

    if ($row_count > 0) {
        set_message("<i class='fa fa-times'></i> Username Already Exists", 'danger');
        return false;
    }

    // Update
    $sql_update = "UPDATE users SET fname=?, lname=?, birthday=?, email=?, number=?,username=?, WHERE token=?";
    $stmt_update = $DB->prepare($sql_update);
    $stmt_update->bind_param("sssssss", $fname, $lname, $birthday, $email, $number, $username, $token);

    if ($stmt_update->execute()) {
        set_message("<i class='fa fa-check'></i> User Updated Successfully", 'success');
        return true;
    } else {
        set_message("<i class='fa fa-times'></i> Failed to Update User" . $DB->error, 'danger');
        return false;
    }
}

// Function to update password
function updateUserPassword($password, $token)
{
    global $DB;

    // Update
    $sql_update = "UPDATE users SET password=? WHERE token=?";
    $stmt_update = $DB->prepare($sql_update);
    $stmt_update->bind_param("ss", $password, $token);

    if ($stmt_update->execute()) {
        set_message("<i class='fa fa-check'></i> User Password Updated Successfully", 'success');
        return true;
    } else {
        set_message("<i class='fa fa-times'></i> Failed to Update User Password" . $DB->error, 'danger');
        return false;
    }
}

// Function to delete
function deleteUser($token)
{
    global $DB;

    $sql_delete = "DELETE FROM users WHERE token=?";
    $stmt_delete = $DB->prepare($sql_delete);
    $stmt_delete->bind_param("s", $token);

    if ($stmt_delete->execute()) {
        set_message("<i class='fa fa-check'></i> User Deleted Successfully", 'success');
        return true;
    } else {
        set_message("<i class='fa fa-times'></i> Failed to Delete User" . $DB->error, 'danger');
        return false;
    }
}*/

?>