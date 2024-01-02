<?php
// Database connection
global $DB;

if ($DB->connect_error) {
    die("Connection failed: " . $DB->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $businessCode = $_POST["businessCode"];
    $branchCode = $_POST["branchCode"];
    $voucherCode = $_POST["voucherCode"];
    $discountType = $_POST["discountType"];
    $discountValue = $_POST["discountValue"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];

    // Insert voucher details into the database
    $sql = "INSERT INTO vouchers (businessCode, branchCode, voucherCode, discountType, discountValue, startDate, endDate)
            VALUES ('$businessCode', '$branchCode', '$voucherCode', '$discountType', '$discountValue', '$startDate', '$endDate')";

    if ($DB->query($sql) === TRUE) {
        echo "Voucher created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $DB->error;
    }
}

// Fetch businesses for dropdown
$businesses = $DB->query("SELECT * FROM business");
$branches = $DB->query("SELECT * FROM branches");

?>

    <h2>Create Voucher</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="businessCode">Select Business:</label>
        <select name="businessCode">
            <?php
            while ($row = $businesses->fetch_assoc()) {
                echo "<option value='" . $row["businessCode"] . "'>" . $row["businessName"] . "</option>";
            }
            ?>
        </select><br>

        <label for="branchCode">Select Branch:</label>
        <select name="branchCode">
            <?php
            while ($row = $branches->fetch_assoc()) {
                echo "<option value='" . $row["branchCode"] . "'>" . $row["branchName"] . "</option>";
            }
            ?>
        </select><br>

        <label for="voucherCode">Voucher Code:</label>
        <input type="text" name="voucherCode"><br>

        <label for="discountType">Discount Type:</label>
        <select name="discountType">
            <option value="percentage">Percentage</option>
            <option value="amount">Amount</option>
        </select><br>

        <label for="discountValue">Discount Value:</label>
        <input type="text" name="discountValue"><br>

        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate"><br>

        <label for="endDate">End Date:</label>
        <input type="date" name="endDate"><br>

        <input type="submit" value="Create Voucher">
    </form>
