<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$clientID = $_SESSION['userID'];
$payment = $DB->query("SELECT * FROM transaction WHERE clientID = '$clientID' ");

$keyword = "";
$results = [];

if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $sql = $DB->query("SELECT * FROM payment ");

    $results = $DB->query($sql);
} else {
    $results = $payment;
}
?>

<?= element('header') ?>

<?= element('client-side-nav') ?>

<div id="admin-reg" class="admin-reg">
    <div class="mb-5 d-flex justify-content-between">
        <form id="search" class="d-flex justify-content-center" method="post">
            <input type="text" class="form-control rounded" placeholder="Search" name="keyword" value="" />
            <button type="button" class="btn btn-primary" id="search-button" data-mdb-ripple-init>
                <i class="bi bi-search"></i>
            </button>
        </form>

        <div id="date-picker-example" class="md-form md-outline d-flex datepicker align-items-center">
            <label for="date" class=" mx-4">Sort by Date</label>
            <input placeholder="Select date" type="date" id="date" class="form-control w-50">
        </div>
    </div>
    <div class="h-100">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Payment ID</th>
                        <th scope="col">Payment Date</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Pick-up Date</th>
                        <th scope="col">Delivery</th>
                        <th scope="col">Delivery Address</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Mode of Payment</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $payment->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['sourceID'] != '' ? $row['sourceID'] : 'N/A' ?></td>
                            <td><?= $row['paymentDate'] ?></td>
                            <td>
                                <?php
                                $packageResult = $DB->query("SELECT * FROM package WHERE packCode = '{$row['packCode']}' LIMIT 1")->fetch_assoc();
                                echo $packageResult ? $packageResult['packName'] : 'N/A';
                                ?>
                            </td>
                            <td><?= $row['pDate']?></td>
                            <td><?= $row['dDate']?></td>
                            <td><?= $row['dAddress'] ?></td>
                            <td><?= '₱' . number_format($row['amount'], 2) ?></td>
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
                    <?=
                        $row['itemName'];
                    ?>
                                
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
