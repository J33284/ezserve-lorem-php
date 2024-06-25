<?php
global $DB;
if (!$DB) {
    die("Connection failed: " . mysqli_connect_error());
}

function applyVoucherDiscount($voucherCode, $amountToDiscount, $connection) {
    $query = "SELECT * FROM voucher WHERE voucherCode = '$voucherCode'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $voucherDetails = mysqli_fetch_assoc($result);

        $currentDate = date('Y-m-d');
        if ($currentDate >= $voucherDetails['startDate'] && $currentDate <= $voucherDetails['endDate']) {

            if ($amountToDiscount >= $voucherDetails['min_spend']) {

                if ($voucherDetails['discountType'] == 'amount') {
                    $discountedAmount = $amountToDiscount - $voucherDetails['discountValue'];
                } else {
                    $discountedAmount = $amountToDiscount - ($amountToDiscount * $voucherDetails['discountValue'] / 100);
                }

                $discountedAmount = max(0, $discountedAmount);

                return $discountedAmount;
            } else {
                return "Minimum spend requirement not met.";
            }
        } else {
            return "Voucher is not valid for the current date.";
        }
    } else {
        return "Invalid voucher code.";
    }
}

$voucherCode = "bahaykusina"; 
$amountToDiscount = 100; 

$result = applyVoucherDiscount($voucherCode, $amountToDiscount, $DB);

if (is_numeric($result)) {
    echo "Discounted amount: $result";
} else {
    echo "Discount cannot be applied: $result";
}

?>
