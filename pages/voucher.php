<?= element('header') ?>

<?php

global $DB;
$ownerID = $_SESSION['userID'];

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

$totalAmount = $_GET['grandTotal'];
$packCode = $_GET['packCode'];

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

    // Check date conditions and apply discount if a voucher is selected and date conditions are met
    if ($selectedVoucher && checkDateConditions($selectedVoucher['startDate'], $selectedVoucher['endDate'])) {
        $discountedTotal = $totalAmount - ($totalAmount * $selectedVoucher['discountPercentage'] / 100);
    }
}

// Function to check date conditions
function checkDateConditions($startDate, $endDate)
{
    $currentDate = date('Y-m-d');
    return ($currentDate >= $startDate && $currentDate <= $endDate);
}

?>

<h1 style>Total Amount: <?php echo number_format($totalAmount, 2);?></h1>

<div class="card-deck">
    <?php foreach ($vouchers as $voucher): ?>
        <?php if (checkDateConditions($voucher['startDate'], $voucher['endDate'])): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-text">Voucher Code: <?php echo $voucher['code']; ?></h5>
                    <p class="card-text">Minimum Spend: <?php echo $voucher['condition']; ?></p>
                    <p class="card-text">Duration: <?php echo $voucher['startDate']; ?> to <?php echo $voucher['endDate']; ?></p>
              
                    <form method="post">
                        <input type="hidden" name="voucher" value="<?php echo $voucher['code']; ?>">
                        <input type="hidden" name="discountedTotal" value="<?php echo $discountedTotal; ?>">
                        <button type="submit" class="btn btn-primary">Choose Voucher</button>
                    </form>
                    <?php if ($selectedVoucher && $selectedVoucher['code'] == $voucher['code']): ?>
                        <form method="post" action="?page=checkout&packCode=<?= $packCode ?>">
                            <input type="hidden" name="discountedTotal" value="<?php echo $discountedTotal; ?>">
                            <button type="submit" class="btn btn-success mt-2">Use Voucher</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<h2 style>Discounted Total: <?php echo number_format($discountedTotal, 2); ?></h2>

<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 120vh;
        margin: 0;
    }

    h1,
    h2 {
        text-align: center;
    }

    .card-deck {
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        
    }

    .card {
   
        margin-bottom: 20px;
        width: 120vh;
    }
</style>

<script>
    // Add JavaScript for highlighting selected card
    document.addEventListener('DOMContentLoaded', function () {
        let cards = document.querySelectorAll('.card');
        cards.forEach(function (card) {
            card.addEventListener('click', function () {
                cards.forEach(function (c) {
                    c.classList.remove('bg-primary', 'text-white');
                });
                card.classList.add('bg-primary', 'text-white');
            });
        });
    });
</script>
