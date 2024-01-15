<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+Wy5q4Nl9t2h8EULF6N3uUnhF2Q8F5Ku+8" crossorigin="anonymous">
    <title>Voucher Details</title>
</head>
<body>

<div class="container mt-5">

<?php
// Assuming $DB is your database connection
global $DB;

// Check the connection
if (!$DB) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch voucher details from the database
$query = "SELECT * FROM voucher WHERE businessCode"; // Replace with the actual voucher_id
$result = mysqli_query($DB, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $voucherDetails = mysqli_fetch_assoc($result);

    // Display voucher details in a Bootstrap card
    ?>
    <div class="card">
        <div class="card-header">
            Voucher Details
        </div>
        <div class="card-body">
            <h5 class="card-title">Business: <?php echo $voucherDetails['business']; ?></h5>
            <p class="card-text">Branches: <?php echo $voucherDetails['branches']; ?></p>
            <p class="card-text">Voucher Code: <?php echo $voucherDetails['voucher_code']; ?></p>
            <p class="card-text">Gift Card: <?php echo $voucherDetails['gift_card']; ?></p>
            <p class="card-text">Package: <?php echo $voucherDetails['package']; ?></p>
            <p class="card-text">Minimum Spend: <?php echo $voucherDetails['min_spend']; ?></p>
            <p class="card-text">Discount Type: <?php echo ucfirst($voucherDetails['discount_type']); ?></p>
            <p class="card-text">Start Date: <?php echo $voucherDetails['start_date']; ?></p>
            <p class="card-text">End Date: <?php echo $voucherDetails['end_date']; ?></p>
        </div>
    </div>
    <?php
} else {
    echo "No voucher found.";
}

?>

</div>

<!-- Bootstrap JS and Popper.js (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-eMNCOc6AR/VRnQ8SWeOXJsYOZOr2/5Pst6JExE+Bo7UBZsNTK8jzE0dpmjr27sB" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+Wy5q4Nl9t2h8EULF6N3uUnhF2Q8F5Ku+8" crossorigin="anonymous"></script>

</body>
</html>
