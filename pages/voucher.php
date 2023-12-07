<?= element( 'header' ) ?>


<?php
$ownerID = $_SESSION['userID'];
global $DB;

// Fetch existing businesses for the dropdown
$queryBusiness = "SELECT * FROM business WHERE ownerID = $ownerID";
$businesses = $DB->query($queryBusiness);

// Fetch existing vouchers
$queryVouchers = "SELECT business.busName, voucher.code, voucher.cond, voucher.discount, voucher.startDate, voucher.endDate
                  FROM voucher
                  JOIN business ON voucher.businessCode = business.businessCode
                  WHERE business.ownerID = $ownerID";
$vouch = $DB->query($queryVouchers);

// Initialize $vouchers array
$vouchers = [];

// Loop through each voucher and append it to the $vouchers array
foreach ($vouch as $voucher) {
    $vouchers[] = [
        'code' => $voucher['code'],
        'condition' => $voucher['cond'],
        'discountPercentage' => $voucher['discount'],
        'startDate' => $voucher['startDate'],
        'endDate' => $voucher['endDate'],
    ];
}


$totalAmount = $_GET['grandTotal'];;

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
    <input type="hidden" name="discountedTotal" value="<?php $discountedTotal; ?>">
    <button type="submit">Apply</button>
</form>

<h2>Discounted Total: $<?php echo number_format($discountedTotal, 2); ?></h2>

</body>
</html>

<style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        h1, h2 {
            text-align: center;
        }
    </style>

