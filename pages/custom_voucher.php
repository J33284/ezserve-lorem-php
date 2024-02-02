<?= element('header') ?>

<?php
// voucher.php

// Retrieve data from the URL
$businessCode = $_GET['businessCode'];
$branchCode = $_GET['branchCode'];
$grandTotal = $_GET['grandTotal'];
$searchedVoucherCode = isset($_POST['searchedVoucherCode']) ? $_POST['searchedVoucherCode'] : '';


if ($searchedVoucherCode) {
    $voucherQuery = "SELECT * FROM voucher WHERE businessCode = '$businessCode' AND branchCode = '$branchCode' AND cond = 'Gift Card' AND voucherCode = '$searchedVoucherCode'";
} else {
    $voucherQuery = "SELECT * FROM voucher WHERE businessCode = '$businessCode' AND branchCode = '$branchCode' AND cond <> 'Gift Card' AND cond <> 'Specific Package'";
}

$voucherResult = $DB->query($voucherQuery);

$hasVouchers = $voucherResult->num_rows > 0;
?>

<!-- Display vouchers in Bootstrap cards -->
<div class="container d-flex align-items-center justify-content-center" style="min-height: 150vh;">
    <div class="w-75">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Search Voucher</h5>
                        <form method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Enter Voucher Code" name="searchedVoucherCode" value="<?= $searchedVoucherCode ?>">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($hasVouchers) : ?>
            <div class="row">
                <?php while ($voucher = $voucherResult->fetch_assoc()) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- Card details as before -->
                                <h5 class="card-title"><?= $voucher['voucherCode'] ?></h5>
                                <p class="card-text">Condition: <?= $voucher['cond'] ?></p>
                                <?php if ($voucher['min_spend'] > 0) : ?>
                            <p class="card-text">Minimum Spend: <?= '₱' . number_format($voucher['min_spend'], 2) ?></p>
                        <?php endif; ?>
                        <?php if ($voucher['discountType'] === 'percentage') : ?>
                            <p class="card-text">Discount : <?= $voucher['discountValue'] . '%' ?></p>
                        <?php else : ?>
                            <p class="card-text">Discount: <?= '₱' . number_format($voucher['discountValue'], 2) ?></p>
                        <?php endif; ?>
                                <a href="#" class="btn btn-primary" onclick="applyVoucher('<?= $voucher['voucherCode'] ?>', '<?= $voucher['cond'] ?>', '<?= $voucher['discountType'] ?>', <?= $voucher['discountValue'] ?>, <?= $grandTotal ?>, '<?= $voucher['startDate'] ?>', '<?= $voucher['endDate'] ?>')">Use Voucher</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <div class="text-center">
                <h3>No vouchers available</h3>
            </div>
        <?php endif; ?>
    </div>
</div>


<!-- ... Previous HTML and PHP code ... -->

<script>
function applyVoucher(voucherCode, cond, discountType, discountValue, grandTotal, startDate, endDate) {
    // Get the current date in the format YYYY-MM-DD
    var currentDate = new Date().toISOString().split('T')[0];

    // Check if the current date is within the voucher validity range
    if (currentDate < startDate || currentDate > endDate) {
        alert('This voucher is not currently valid.');
        return;
    }

    // Logic to apply the voucher and send the discounted total back to the checkout page
    var discountedTotal;

    if (cond === 'Minimum Spend') {
        // Check if the grand total meets the minimum spend criteria
        if (grandTotal >= parseFloat(discountValue)) {
            if (discountType === 'percentage') {
                // Calculate the discount based on percentage
                discountedTotal = grandTotal * (1 - (parseFloat(discountValue) / 100));
            } else {
                // Subtract the discount value from the grand total
                discountedTotal = grandTotal - parseFloat(discountValue);
            }
        } else {
            // Grand total doesn't meet the minimum spend criteria, no discount applied
            discountedTotal = grandTotal;
        }
    } else if (cond === 'Gift Card') {
        // Check if the discount type is percentage or amount
        if (discountType.toLowerCase() === 'percentage') {
            // Calculate the discount based on percentage
            discountedTotal = grandTotal * (1 - (parseFloat(discountValue) / 100));
        } else {
            // Subtract the discount value from the grand total
            discountedTotal = grandTotal - parseFloat(discountValue);
        }
    } else {
        // Handle other voucher conditions here
    }

    // Redirect back to the checkout page with the discounted total and checkout details
    var checkoutData = <?= json_encode($_GET['checkoutData']) ?>;
    window.location.href = "?page=custom_checkout&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>&discountedTotal=" + discountedTotal + "&orderDetails=" + encodeURIComponent(checkoutData);
}
</script>
