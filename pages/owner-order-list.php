<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$businessID = $_SESSION['userID'];

$payments = $DB->query("
    SELECT *, transaction.status AS transaction_status
    FROM transaction
    JOIN business ON transaction.businessCode = business.businessCode
    WHERE business.ownerID = '$businessID'
");
?>

<?= element( 'owner_header' ) ?>

<?= element('owner-side-nav') ?>

<div id="owner-order-list" class="owner-order-list" style="margin: 120px 0 0 21%">
    <div class="d-flex justify-content-between p-3">
        <h1 class="page-title">Client Orders</h1>
    </div>
    <!-- <div id="searchbar" class="d-flex my-3 ">
        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        <span class="search-btn btn btn-primary input-group-text border-0">
            <i class="bi bi-search"></i>
        </span>
    </div> -->
<div  style="overflow-x:auto; height: 100vh; width:75vw;">
    <table class="table table-hover table-responsive custom-table ">
        <thead class="table-dark">
            <tr>
                <th scope="col"></th>
                <th scope="col" class="text-wrap" style="width:100px!important">Transaction No.</th>
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
                    <td class="bg-transparent border border-white" style="width:100px!important"><?= $payment['transNo']?></td>
                    <td class="bg-transparent border border-white "><?= $payment['clientName']?></td>
                    <td class="bg-transparent border border-white"><?= $payment['email']?></td>
                    <td class="bg-transparent border border-white"><?= $payment['mobileNumber']?></td>
                    <td class="bg-transparent border border-white"><?= $payment['packName'] != '' ? $payment['packName'] : 'Custom Package' ?></td>
                    <td class="bg-transparent border border-white"><?= $payment['paymentMethod'] ?></td>
                    <td class="bg-transparent border border-white">₱<?= number_format($payment['totalAmount'], 2) ?></td>
                    <div class="status flex-containeri">
                    <td class="bg-transparent border border-white d-flex flex-column"><?= $payment['transaction_status'] ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal<?= $payment['transID'] ?>">Update</button>
                    </div>
                    
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
                                                    <option value="partially paid">Partially Paid</option>
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

                            <div class="offcanvas offcanvas-top rounded-3 overflow-auto" tabindex="-1" id="offcanvasPayment<?= $payment['transID'] ?>" style="width: 50vw; height: 80vh; margin: 50px 0 0 25vw; ">
                                <div class="offcanvas-header">
                                    <h3 class="offcanvas-title p-3">Transaction Receipt</h3>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body px-5">
                                <strong><?= $payment['busName']. "<br>(" . $payment['branchName'] .")"?></strong>
                                <br>
                                <?= $payment['paymentDate'] ?>
                                <br>
                                <br>
                                <p>Order Details: </p>
                                <?php

                                    $transID = $payment['transID'];
                                    $busCode = $payment['businessCode'];
                                    $orderlistQuery = "SELECT * FROM orderlist WHERE transID = '$transID' AND businessCode = $busCode";
                                    $orderlistResult = $DB->query($orderlistQuery);

                                    if ($orderlistResult->num_rows > 0) {
                                        echo "<table style='border-collapse: collapse; width: 100%;'>";
                                        echo "<tr style='background-color: #f2f2f2;'>";
                                        echo "<th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Item Name</th>";
                                        echo "<th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Description</th>";
                                        echo "<th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Variation</th>";
                                        echo "</tr>";

                                        while ($order = $orderlistResult->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>" . $order['itemName'] . "</td>";
                                            echo "<td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>" . $order['description'] . "</td>";
                                            echo "<td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>" . $order['variation'] . "</td>";
                                            echo "</tr>";
                                        }
                                        echo "</table>";
                                    } else {
                                        echo "No items found in the Order List.";
                                    }

                                ?>


                                <hr>
                                <h2>Total:<?= '₱' . number_format($payment['totalAmount'], 2) ?></h2>
                                <br>
                                <br>    

                            <?php

                               if (isset($payment['pickupDate']) && !empty($payment['pickupDate'])) {
                                echo "Pick-up Date: " . $payment['pickupDate'] . "<br>";
                                } elseif (isset($payment['deliveryDate']) && !empty($payment['deliveryDate'])) {
                                    echo "Delivery Date: " . $payment['deliveryDate'] . "<br>";
                                    if (isset($payment['deliveryAddress']) && !empty($payment['deliveryAddress'])) {
                                        echo "Delivery Address: " . $payment['deliveryAddress'] . "<br>";
                                    }
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

<style>
    td, th{
        max-width: 500px!important;
    }
</style>