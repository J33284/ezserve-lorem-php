<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$businessID = $_SESSION['userID'];

$payments = $DB->query("
    SELECT *
    FROM transact
    JOIN business ON transact.businessCode = business.businessCode
    WHERE business.ownerID = '$businessID'
");
?>

<?= element('header') ?>

<?= element('owner-side-nav') ?>

<div id="owner-order-list" class="owner-order-list" style="margin: 120px 0 0 20%">
    <div class="d-flex justify-content-between p-3">
        <h1 class="page-title">Client Orders</h1>
    </div>
    <div id="searchbar" class="d-flex my-3 ">
        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        <span class="search-btn input-group-text border-0">
            <i class="bi bi-search"></i>
        </span>
    </div>
<div>
    <table class="table table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col"></th>
                <th scope="col">Transaction No.</th>
                <th scope="col">Client Name</th>
                <th scope="col">Email</th>
                <th scope="col">Contact No.</th>
                <th scope="col">Package Name</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Total Amount</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php $rowNumber = 1;
             foreach ($payments as $payment) :
            ?>
                <tr>          
                    <th class="bg-transparent border border-white" scope="row"><?= $rowNumber ?></th>
                    <td class="bg-transparent border border-white"><?= $payment['transCode']?></td>
                    <td class="bg-transparent border border-white"><?= $payment['clientName']?></td>
                    <td class="bg-transparent border border-white"><?= $payment['email']?></td>
                    <td class="bg-transparent border border-white"><?= $payment['mobileNumber']?></td>
                    <td class= "bg-transparent border border-white">
                    <?php
                                $packageResult = $DB->query("SELECT * FROM package WHERE packCode = '{$payment['packCode']}' LIMIT 1")->fetch_assoc();
                                echo $packageResult ? $packageResult['packName'] : 'N/A';
                    ?>
                    </td>
                    <td class="bg-transparent border border-white"><?= $payment['paymentMethod'] ?></td>
                    <td class="bg-transparent border border-white">₱<?= number_format($payment['totalAmount'], 2) ?></td>

                    <td class="bg-transparent border border-white">
                        <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPayment<?= $payment['itemList'] ?>">View</button>

                        <div class="offcanvas offcanvas-top rounded-3" tabindex="-1" id="offcanvasPayment<?= $payment['packCode'] ?>" style="width: 50vw; height: 50vh; margin: 150px 0 0 25vw;">
                            <div class="offcanvas-header">
                                <h3 class="offcanvas-title p-3">Transaction Receipt</h3>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                            </div>
                            <div class="offcanvas-body px-5">
                                Order items, delivery date and address, mode of payment, mode of fulfillment, everything
                            </div>
                        </div>
                    </td>
                </tr>

            <?php 
             $rowNumber++;
            endforeach; ?>
        </tbody>
    </table>
</div>
