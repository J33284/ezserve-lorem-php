<?php

// Sample voucher data
$vouchers = [
    ['code' => 'VoucherA', 'condition' => 'Total >= $1000', 'discountPercentage' => 15, 'startDate' => '2023-01-01', 'endDate' => '2023-12-31'],
    ['code' => 'VoucherB', 'condition' => 'Total >= $2000', 'discountPercentage' => 20, 'startDate' => '2023-02-01', 'endDate' => '2023-12-30'],
    ['code' => 'VoucherC', 'condition' => 'Total >= $3000', 'discountPercentage' => 25, 'startDate' => '2023-03-01', 'endDate' => '2023-12-31'],
];

// Default total amount
$totalAmount = 3000;

// Initialize variables
$selectedVoucher = null;
$discountedTotal = $totalAmount;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get selected voucher code
    $selectedVoucherCode = $_POST["voucher"];

    // Find the selected voucher
    foreach ($vouchers as $voucher) {
        if ($voucher['code'] == $selectedVoucherCode) {
            $selectedVoucher = $voucher;
            break;
        }
    }

    // Check date conditions
    if ($selectedVoucher && checkDateConditions($selectedVoucher['startDate'], $selectedVoucher['endDate'])) {
        // Apply discount if a voucher is selected and date conditions are met
        $discountedTotal = $totalAmount - ($totalAmount * $selectedVoucher['discountPercentage'] / 100);
    }
}

// Function to check date conditions
function checkDateConditions($startDate, $endDate) {
    $currentDate = date('Y-m-d');
    return ($currentDate >= $startDate && $currentDate <= $endDate);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Application</title>
</head>
<body>

<h1>Total Amount: $<?php echo number_format($totalAmount, 2); ?></h1>

<form method="post">
    <label for="voucher">Select Voucher:</label>
    <select name="voucher" id="voucher">
        <option value="" selected disabled>Select a voucher</option>
        <?php foreach ($vouchers as $voucher): ?>
            <?php if (checkDateConditions($voucher['startDate'], $voucher['endDate'])): ?>
                <option value="<?php echo $voucher['code']; ?>"><?php echo $voucher['code']; ?> - <?php echo $voucher['condition']; ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    <button type="submit">Apply</button>
</form>

<h2>Discounted Total: $<?php echo number_format($discountedTotal, 2); ?></h2>

</body>
</html>
