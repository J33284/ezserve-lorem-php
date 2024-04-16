<style>
     .success-popup, .error-popup {
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

    .error-popup {
        background-color: #f44336; /* Red for error */
    }

    .success-popup a, .error-popup a {
        color: #fff;
        text-decoration: underline;
        margin-top: 10px;
        display: inline-block;
    }

</style>



<?php
global $DB;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ownerID = $_POST['ownerID'];
    $businessCode = isset($_POST['businessCode']) ? $_POST['businessCode'] : "0"; 
    $branchCode = isset($_POST['branchCode']) ? $_POST['branchCode'] : "0";
    $packCode = $_POST["packCode"];
    $voucherName = $_POST["voucherName"];
    $voucherCode = $_POST["voucherCode"];
    $discountType = $_POST["discountType"];
    $discountValue = $_POST["discountValue"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $condition = $_POST["condition"];

    $selectedPackage = isset($_POST["selectedPackage"]) ? $_POST["selectedPackage"] : null;
    $minSpend = isset($_POST["minSpend"]) ? $_POST["minSpend"] : null;

    try {
        if ($condition === "Specific Package") {
            $sql = "INSERT INTO voucher (ownerID, businessCode, branchCode, voucherName, voucherCode, voucherType, discountType, discountValue, startDate, endDate, packCode)
                VALUES ('$ownerID', '$businessCode', '$branchCode', '$voucherName','$voucherCode', '$condition','$discountType', '$discountValue', '$startDate', '$endDate', '$packCode')";
        }elseif ($condition === "Minimum Spend" && $businessCode === "0") {
            $sql = "INSERT INTO voucher (ownerID, voucherName, voucherCode, voucherType, discountType, discountValue, startDate, endDate)
                VALUES ('$ownerID', '$voucherName', '$voucherCode', '$condition', '$discountType', '$discountValue', '$startDate', '$endDate')";
        } elseif ($condition === "Minimum Spend") {
            $sql = "INSERT INTO voucher (ownerID, businessCode, branchCode, voucherName, voucherCode, voucherType, discountType, discountValue, startDate, endDate, min_spend)
                VALUES ('$ownerID', '$businessCode', '$branchCode', '$voucherName', '$voucherCode', '$condition', '$discountType', '$discountValue', '$startDate', '$endDate', '$minSpend')";
        } else if ($condition === "Gift Card" && $businessCode === "0") {
            $sql = "INSERT INTO voucher (ownerID, voucherName, voucherCode, voucherType, discountType, discountValue, startDate, endDate)
            VALUES ('$ownerID', '$voucherName', '$voucherCode', '$condition', '$discountType', '$discountValue', '$startDate', '$endDate')";
        } else {
            $sql = "INSERT INTO voucher (ownerID, businessCode, branchCode, voucherName, voucherCode, voucherType, discountType, discountValue, startDate, endDate)
            VALUES ('$ownerID','$businessCode', '$branchCode', '$voucherName', '$voucherCode', '$condition', '$discountType', '$discountValue', '$startDate', '$endDate')";
        }
        
        if ($DB->query($sql) === TRUE) {
            echo "<div class='success-popup'>
                    <p>Voucher created successfully!</p>
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = '?page=owner_voucher';
                    }, 3000); // Redirect after 3 seconds
                </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $DB->error;
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            echo "<div class='error-popup'>
                    <p>The voucher code '$voucherCode' already exists. Please choose a different voucher code.</p>
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = '?page=create_voucher';
                    }, 3000); // Redirect after 3 seconds
                </script>";
                
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>
