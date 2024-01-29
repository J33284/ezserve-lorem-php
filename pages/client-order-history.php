<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$clientID = $_SESSION['userID'];
$payment = $DB->query("SELECT * FROM transact WHERE clientID = '$clientID' ");

$keyword = "";
$results = [];

if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $sql = $DB->query("SELECT * FROM transact");

    $results = $DB->query($sql);
} else {
    $results = $payment;
}
?>

<?= element('header') ?>

<?= element('client-side-nav') ?>

<div id="admin-reg" class="admin-reg">
<div class="d-flex justify-content-between p-3">
    <h1 >Order History</h1>
    
 
    <div class="mb-5 d-flex justify-content-between float-end">
        <form id="search" class="d-flex justify-content-center" method="post">
            <input type="text" class="form-control rounded" placeholder="Search" name="keyword" value="" />
            <button type="button" class="btn btn-primary" id="search-button" data-mdb-ripple-init>
                <i class="bi bi-search"></i>
            </button>
        </form>

        <!--<div id="date-picker-example" class="md-form md-outline d-flex datepicker align-items-center">
            <label for="date" class=" mx-4">Sort by Date</label>
            <input placeholder="Select date" type="date" id="date" class="form-control w-50">
        </div> -->
    </div>
    </div>
    <div style="height: 100vh;">
        <div class="table-responsive" style="height: 100vh;">
            <table class="table table-hover table-bordered" >
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="align-items-start">Transaction No.</th>
                        <th scope="col">Business Name</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Date of Transaction</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Mode of Payment</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $payment->fetch_assoc()): ?>
                        <tr>
                            <td ><?= $row['transCode'] != '' ? $row['transCode'] : 'N/A' ?></td>
                            <td>
                                <?php
                                // Fetch business name based on businessCode
                                $businessCode = $row['businessCode'];
                                $businessResult = $DB->query("SELECT busName FROM business WHERE businessCode = '$businessCode'");
                                $businessRow = $businessResult->fetch_assoc();
                                echo $businessRow ? $businessRow['busName'] : 'N/A';
                                ?>
                            </td>
                            <td>
                                <?php
                                $packageResult = $DB->query("SELECT * FROM package WHERE packCode = '{$row['packCode']}' LIMIT 1")->fetch_assoc();
                                echo $packageResult ? $packageResult['packName'] : 'Custom Package';
                                ?>
                            </td>
                            <td><?= $row['paymentDate'] ?></td>
                            <td><?= '₱' . number_format($row['totalAmount'], 2) ?></td>
                            <td><?= $row['paymentMethod'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td><button class="btn btn-sm btn-primary view-btn" data-toggle="modal" data-target="#itemModal<?= $row['packCode'] ?>">View</button></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals placed outside the loop -->
<?php $payment->data_seek(0); // Reset the result set pointer ?>
<?php while ($row = $payment->fetch_assoc()): ?>
    <div class="modal fade" id="itemModal<?= $row['packCode'] ?>" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemModalLabel">Item Names and Prices</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <?php
                                // Fetch business name based on businessCode
                                $businessCode = $row['businessCode'];
                                $businessResult = $DB->query("SELECT busName FROM business WHERE businessCode = '$businessCode'");
                                $businessRow = $businessResult->fetch_assoc();
                                echo $businessRow ? $businessRow['busName'] : 'N/A';
                                ?>
                    <br>
                    <td><?= $row['paymentDate'] ?></td>
                    <br>
                    <br>
                    <?php
                            $itemList = $row['itemList'];

                            // Explode the itemList string based on commas
                            $items = explode(', ', $itemList);

                            // Echo each item in a new line
                            foreach ($items as $item) {
                                echo $item . "<br>";
                            }
                            ?>
                    <hr>
                            <td>Total:<?= '₱' . number_format($row['totalAmount'], 2) ?></td>
                            <br>
                            <?= $row['pickupDate']?>
                            <br>
                            <?= $row['deliveryDate']?>
                            <br>
                            <?= $row['deliveryAddress'] ?> 
                            <br>
                            <td>Purchased by: <?= $row['clientName']?></td>
                            <br>
                            <td>Email: <?= $row['email']?></td>
                            <br>
                            <td>Mobile Number: <?= $row['mobileNumber'] ?></td>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>

<script>
    // Data Picker Initialization
    $('.datepicker').datepicker({
        inline: true
    });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

