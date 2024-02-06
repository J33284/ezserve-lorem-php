<style>
    .success-popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #4CAF50;
        color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        text-align: center;
    }

    .success-popup a {
        color: #fff;
        text-decoration: underline;
        margin-top: 10px;
        display: inline-block;
    }
</style>
<?php
// Assuming you have established a database connection already
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == 'update_voucher') {
    // Retrieve form data
    $voucherID = $_POST['voucherID'];
    $voucherName = $_POST['voucherName'];
    $voucherCode = $_POST['voucherCode'];
    $discountType = $_POST['discountType'];
    $discountValue = $_POST['discountValue'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $specificPackage = $_POST['specificPackage'];
    $min_spend = isset($_POST['min_spend']) ? $_POST['min_spend'] : null;

    // Check voucher type
    $voucherTypeQuery = "SELECT voucherType FROM voucher WHERE voucherID = '$voucherID'";
    $voucherTypeResult = $DB->query($voucherTypeQuery);
    $voucherType = $voucherTypeResult->fetch_assoc()['voucherType'];

    // Update voucher record in the database
    if ($voucherType === 'Gift Card') {
        $updateQuery = "UPDATE voucher SET 
                        voucherName = '$voucherName', 
                        voucherCode = '$voucherCode', 
                        discountType = '$discountType', 
                        discountValue = '$discountValue', 
                        startDate = '$startDate', 
                        endDate = '$endDate' 
                        WHERE voucherID = '$voucherID'";
                        
    } else  if ($voucherType === 'Specific Package') {
        $updateQuery = "UPDATE voucher SET 
                        voucherName = '$voucherName', 
                        voucherCode = '$voucherCode', 
                        discountType = '$discountType', 
                        discountValue = '$discountValue', 
                        packCode = '$specificPackage', 
                        startDate = '$startDate', 
                        endDate = '$endDate' 
                        WHERE voucherID = '$voucherID'";

    } else  if ($voucherType === 'Minimum Spend') {
        // For other voucher types, update all columns
    
        $updateQuery = "UPDATE voucher SET 
                        voucherName = '$voucherName', 
                        voucherCode = '$voucherCode', 
                        discountType = '$discountType', 
                        discountValue = '$discountValue', 
                        min_spend = '$min_spend', 
                        startDate = '$startDate', 
                        endDate = '$endDate' 
                        WHERE voucherID = '$voucherID'";
    }

    if ($DB->query($updateQuery) === TRUE) {
        echo "<div class='success-popup'>
            <p>Voucher updated successfully!</p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = '?page=owner_voucher';
            }, 1000); // Redirect after 3 seconds
        </script>";
    } else {
        echo "Error updating voucher: " . $DB->error;
    }
} else {
    echo "Invalid request";
}

?>


