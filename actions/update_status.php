<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept_business'])) {
    $businessCode = $_POST['business_Code'];
    $DB->query("UPDATE business SET status = 1 WHERE businessCode = '$businessCode'");
}
else {
    $businessCode = $_POST['business_Code'];
    $DB->query("UPDATE business SET status = -1 WHERE businessCode = '$businessCode'");
}
header ("Location: ?page=admin_business_reg");