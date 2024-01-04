<?= element('header') ?>

<?php
global $DB;
$businesses = $DB->query("SELECT * FROM business");
$branches = $DB->query("SELECT * FROM branches");
?>

<div class="package-info" style="margin: 120px 0 0 30%">
    <div class="card p-5 bg-opacity-25 bg-white">
        <h2>Create Voucher</h2>
        <form method="post" action="?action=save_voucher" id="voucherForm">
            <label for="businessCode">Select Business:</label>
            <select name="businessCode" id="businessCode" onchange="updateBranches()">
                <?php
                while ($row = $businesses->fetch_assoc()) {
                    echo "<option value='" . $row["businessCode"] . "'>" . $row["busName"] . "</option>";
                }
                ?>
            </select><br>

            <label for="branchCode">Select Branch:</label>
            <select name="branchCode" id="branchCode">
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
    </div>
</div>

<!-- Update the script tag in your HTML file -->
<script>
    function updateBranches() {
        var businessCode = document.getElementById("businessCode").value;
        var xhr = new XMLHttpRequest();

        // Adjust the path to point to the correct location of your controller script
        xhr.open("GET", "?action=getBranches&businessCode=" + businessCode, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("branchCode").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

    // Initial call to populate branches based on the default selected businessCode
    updateBranches();
</script>
