<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$payments = $DB->query("
    SELECT payment.*, client.*
    FROM payment
    JOIN client ON payment.clientID = client.clientID
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
                <th scope="col">Transaction No.</th>
                <th scope="col">Client Name</th>
                <th scope="col">Package Name</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Total Amount</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $payment) : ?>
                <tr>
                    <th scope="row">1</th>
                    <td><?= $payment['fname'] ." ". $payment['lname']?></td>
                    <td><?= $payment['itemName'] ?></td>
                    <td><?= $payment['paymentMethod'] ?></td>
                    <td>₱<?= number_format($payment['amount'], 2) ?></td>

                    <td>
                        <!--<button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPayment<?= $payment['itemName'] ?>">View</button>-->

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
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
