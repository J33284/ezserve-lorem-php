<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$businessID = $_SESSION['userID'];

$payments = $DB->query("
    SELECT *, transact.status AS transaction_status
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
                <th scope="col">Status</th>
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
                    <td class="bg-transparent border border-white"><?= $payment['packName']?></td>
                    <td class="bg-transparent border border-white"><?= $payment['paymentMethod'] ?></td>
                    <td class="bg-transparent border border-white">₱<?= number_format($payment['totalAmount'], 2) ?></td>
                    <td class="bg-transparent border border-white"><?= $payment['transaction_status'] ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal<?= $payment['transID'] ?>">Update</button>
                        <!-- Modal for updating status -->
                        <div class="modal fade" id="updateStatusModal<?= $payment['transID'] ?>" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateStatusModalLabel">Update Transaction Status</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add a simple form to select the status -->
                                        <form method="post" action="?action=transact_status"> <!-- Replace with the actual script handling the status update -->
                                            <div class="mb-3">
                                                <label for="statusSelect" class="form-label">Select Status</label>
                                                <select class="form-select" id="statusSelect" name="status">
                                                    <option value="paid">Paid</option>
                                                    <option value="partially_paid">Partially Paid</option>
                                                    <option value="unpaid">Unpaid</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="transID" value="<?= $payment['transID'] ?>">
                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>


                        <td class="bg-transparent border border-white">
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPayment<?= $payment['transID'] ?>">View</button>

                            <div class="offcanvas offcanvas-top rounded-3" tabindex="-1" id="offcanvasPayment<?= $payment['transID'] ?>" style="width: 50vw; height: 50vh; margin: 150px 0 0 25vw;">
                                <div class="offcanvas-header">
                                    <h3 class="offcanvas-title p-3">Transaction Receipt</h3>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body px-5">
                                <?= $payment['busName']. "<br>(" . $payment['branchName'] .")"?>
                                <br>
                                <?= $payment['paymentDate'] ?>
                                <br>
                                <br>
                                <p>Order Details: </p>
                                <?php

                            $itemList = $payment['itemList'];

                            // Check if itemList contains square brackets
                            if (strpos($itemList, '[') !== false) {
                                // Remove square brackets, quotation marks, and commas, and split the items by newline
                                $items = explode(", ", trim(str_replace(['[', ']', '"'], '', $itemList)));
                            } else {
                                // Remove commas and split the items by newline
                                $items = explode(", ", $itemList);
                            }

                            // Echo each item in a new line without commas
                            foreach ($items as $item) {
                                echo $item . "<br>";
                            }
                            ?>


                            <hr>
                            Total:<?= '₱' . number_format($payment['totalAmount'], 2) ?>
                            <br>
                            <br>

                            <?php
                                if (isset($payment['pickupDate']) && !empty($payment['pickupDate'])) {
                                    echo "Pick-up Date: " . $payment['pickupDate'] . "<br>";
                                }

                                if (isset($payment['deliveryDate']) && !empty($payment['deliveryDate'])) {
                                    echo "Delivery Date: " . $payment['deliveryDate'] . "<br>";
                                }

                                if (isset($payment['deliveryAddress']) && !empty($payment['deliveryAddress'])) {
                                    echo "Delivery Address: " . $payment['deliveryAddress'] . "<br>";
                                }

                                if (isset($payment['clientName']) && !empty($payment['clientName'])) {
                                    echo "Purchased by: " . $payment['clientName'] . "<br>";
                                }

                                if (isset($payment['email']) && !empty($payment['email'])) {
                                    echo "Email: " . $payment['email'] . "<br>";
                                }

                                if (isset($payment['mobileNumber']) && !empty($payment['mobileNumber'])) {
                                    $mobileNumber = $payment['mobileNumber'];
                                
                                    // Check if the mobile number starts with '9'
                                    if (substr($mobileNumber, 0, 1) === '9') {
                                        // Add a leading '0' to the mobile number
                                        $mobileNumber = '0' . $mobileNumber;
                                    }
                                
                                    echo "Mobile Number: " . $mobileNumber . "<br>";
                                }
                                ?>
                                
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
