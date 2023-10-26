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

?>