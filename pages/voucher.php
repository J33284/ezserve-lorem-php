<?= element('header') ?>


<?php

global $DB;

$businessCode = $_GET['businessCode'];
$branchCode = $_GET['branchCode'];

$queryVouchers = "SELECT business.busName, voucher.code, voucher.cond, voucher.discount, voucher.startDate, voucher.endDate
                  FROM voucher
                  JOIN business ON voucher.businessCode = business.businessCode
                  WHERE business.businessCode = $businessCode" ;

$vouch = $DB->query($queryVouchers);


$vouchers = [];


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

$selectedVoucher = null;
$discountedTotal = $totalAmount;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedVoucherCode = $_POST["voucher"];

    foreach ($vouchers as $voucher) {
        if ($voucher['code'] == $selectedVoucherCode) {
            $selectedVoucher = $voucher;
            break;
        }
    }

    if ($selectedVoucher && checkDateConditions($selectedVoucher['startDate'], $selectedVoucher['endDate'])) {
        $discountedTotal = $totalAmount - ($totalAmount * $selectedVoucher['discountPercentage'] / 100);
    }
}

function checkDateConditions($startDate, $endDate)
{
    $currentDate = date('Y-m-d');
    return ($currentDate >= $startDate && $currentDate <= $endDate);
}
?>




<div class="card-deck">
    <?php foreach ($vouchers as $voucher): ?>
        <?php if (checkDateConditions($voucher['startDate'], $voucher['endDate'])): ?>
           
            <div class="card">
                <div class="card-body">
                    <h5 class="card-text">Voucher Code: <?php echo $voucher['code']; ?></h5>
                    <p class="card-text">Minimum Spend: <?php echo $voucher['condition']; ?></p>
                    <p class="card-text">Duration: <?php echo $voucher['startDate']; ?> to <?php echo $voucher['endDate']; ?></p>

                    <form class="voucherForm" method="post">
                        <input type="hidden" name="voucher" value="<?php echo $voucher['code']; ?>">
                        <input type="hidden" name="discountedTotal" value="<?php echo $discountedTotal; ?>">
                        <input type="checkbox" class="chooseVoucherCheckbox btn btn-primary" <?php echo (isset($_POST['voucher']) && $_POST['voucher'] == $voucher['code']) ? 'checked' : ''; ?>>
                    </form>

                    <div class="useVoucherButton" style="display: <?php echo (isset($_POST['voucher']) && $_POST['voucher'] == $voucher['code']) ? 'block' : 'none'; ?>;">
                        <form method="post" action="?page=checkout&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?= $packCode ?>">
                            <input type="hidden" name="discountedTotal" value="<?php echo $discountedTotal; ?>">
                            <button type="submit" class="btn btn-success mt-2">Use Voucher</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>


<style>
    <!-- Some inline CSS styles for styling purposes -->
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
        margin-top: 100px;
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
    document.addEventListener('DOMContentLoaded', function () {
        let voucherCheckboxes = document.querySelectorAll('.chooseVoucherCheckbox');
        let voucherForms = document.querySelectorAll('.voucherForm');
        let useVoucherButtons = document.querySelectorAll('.useVoucherButton');

        voucherCheckboxes.forEach(function (checkbox, index) {
            checkbox.addEventListener('change', function (event) {
                event.preventDefault(); 

                voucherCheckboxes.forEach(function (otherCheckbox, otherIndex) {
                    if (otherIndex !== index) {
                        otherCheckbox.checked = false;
                        useVoucherButtons[otherIndex].style.display = 'none';
                    }
                });

                useVoucherButtons[index].style.display = checkbox.checked ? 'block' : 'none';

             

                voucherForms[index].submit();
            });

            if (localStorage.getItem('selectedVoucher') === checkbox.value) {
                checkbox.checked = true;
                useVoucherButtons[index].style.display = 'block';
            }
        });
    });
</script>
