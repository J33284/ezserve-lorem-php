<?php
// Database connection details
global $DB;
// Check the connection
if (!$DB) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to check and apply voucher discount
function applyVoucherDiscount($voucherCode, $amountToDiscount, $connection) {
    // Fetch voucher details from the database
    $query = "SELECT * FROM voucher WHERE voucherCode = '$voucherCode'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $voucherDetails = mysqli_fetch_assoc($result);

        // Check if voucher is valid based on start and end date
        $currentDate = date('Y-m-d');
        if ($currentDate >= $voucherDetails['startDate'] && $currentDate <= $voucherDetails['endDate']) {

            // Check if the amount spent is greater than or equal to the minimum spend
            if ($amountToDiscount >= $voucherDetails['min_spend']) {

                // Apply discount based on discount type (amount or percentage)
                if ($voucherDetails['discountType'] == 'amount') {
                    $discountedAmount = $amountToDiscount - $voucherDetails['discountValue'];
                } else {
                    $discountedAmount = $amountToDiscount - ($amountToDiscount * $voucherDetails['discountValue'] / 100);
                }

                // Ensure the discounted amount is not negative
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

// Example usage
$voucherCode = "bahaykusina"; // Replace with the actual voucher code
$amountToDiscount = 100; // Replace with the actual amount to discount

$result = applyVoucherDiscount($voucherCode, $amountToDiscount, $DB);

if (is_numeric($result)) {
    echo "Discounted amount: $result";
} else {
    echo "Discount cannot be applied: $result";
}

// Close the database connection when done
?>
