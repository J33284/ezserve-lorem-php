<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$clientID = $_SESSION['userID'];
// Query the database to fetch businesses with a status of 0
$payment = $DB->query("SELECT * FROM payment WHERE payment.clientID = $clientID ");

$keyword = "";
$results = [];

if (isset($_POST['keyword'])) {
  $keyword = $_POST['keyword'];

  $sql = "SELECT * FROM payment WHERE (fname COLLATE utf8mb4_unicode_ci LIKE '%$keyword%' OR lname COLLATE utf8mb4_unicode_ci LIKE '%$keyword%')";

  $results = $DB->query($sql);
}
else {
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
            <label for="date" class="text-white mx-4">Sort by Date</label>
            <input placeholder="Select date" type="date" id="date" class="form-control w-50">
        </div>
    </div>
    <div class="h-100">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Source ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Mode of Payment</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $payment->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['sourceID'] . '</td>';
                        echo '<td>' . $row['paymentDate'] . '</td>';
                        echo '<td>' . $row['itemName'] . '</td>';
                        $formattedAmount = '₱' . number_format($row['amount'], 2);
                        echo '<td>' . $formattedAmount . '</td>';
                        echo '<td>' . $row['paymentMethod'] . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Data Picker Initialization
    $('.datepicker').datepicker({
        inline: true
    });
</script>
