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
// Include your database connection logic here
global $DB;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $businessCode = $_POST["businessCode"];
    $branchCode = $_POST["branchCode"];
    $voucherCode = $_POST["voucherCode"];
    $discountType = $_POST["discountType"];
    $discountValue = $_POST["discountValue"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];

    // Perform any necessary validation on the input data

    // Insert voucher details into the database
    $sql = "INSERT INTO voucher (businessCode, branchCode, voucherCode, discountType, discountValue, startDate, endDate)
            VALUES ('$businessCode', '$branchCode', '$voucherCode', '$discountType', '$discountValue', '$startDate', '$endDate')";

    if ($DB->query($sql) === TRUE) {
        // Voucher created successfully
        echo "<div class='success-popup'>
                <p>Voucher created successfully!</p>
              </div>
              <script>
                setTimeout(function() {
                    window.location.href = '?page=owner_voucher';
                }, 1000); // Redirect after 3 seconds
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $DB->error;
    }
}
?>
