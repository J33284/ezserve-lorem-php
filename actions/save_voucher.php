<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

global $DB;


$voucherData = json_decode($_POST['voucherData'], true);
// Insert data into the database
foreach ($voucherData as $row) {
    // Check if any of the fields are not empty, indicating a new row
    if (!empty($row['busName']) || !empty($row['code']) || !empty($row['cond']) || !empty($row['discount']) || !empty($row['startDate']) || !empty($row['endDate'])) {
        $busName = $DB->real_escape_string($row['busName']);
        $code = $DB->real_escape_string($row['code']);
        $cond = $DB->real_escape_string($row['cond']);
        $discount = $DB->real_escape_string($row['discount']);
        $startDate = $DB->real_escape_string($row['startDate']);
        $endDate = $DB->real_escape_string($row['endDate']);

        // Check if the businessCode exists in the business table
        $checkBusinessQuery = "SELECT businessCode FROM business WHERE businessCode = '$busName'";
        $businessResult = $DB->query($checkBusinessQuery);

        if ($businessResult->num_rows > 0) {
            // Insert the row into the voucher table
            $query = "INSERT INTO voucher (businessCode, code, cond, discount, startDate, endDate) 
                    VALUES ('$busName', '$code', '$cond', '$discount', '$startDate', '$endDate')";

            $DB->query($query);
        } else {
            echo "Error: Business with businessCode $busName does not exist.";
        }
    }
}

// You can send a response back to the client if needed
echo 'Vouchers saved successfully';
// Redirect to owner_voucher page
header("Location: ?page=owner_voucher");
?>
