<?= element('header') ?>



<?php
global $DB;
$ownerID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
$businesses = $DB->query("SELECT * FROM business WHERE ownerID = '$ownerID'");
$branches = $DB->query("SELECT * FROM branches");
$packages = $DB->query("SELECT * FROM package");
?>

<div class="package-info" style="margin: 120px 0 0 30%">
    <div class="card p-5 bg-opacity-25 bg-white">
        <h2>Create Voucher</h2>
        <form method="post" action="?action=save_voucher" id="voucherForm">
            <label for="businessCode">Select Business:</label>
            <select name="businessCode" class="form-control mb-3" id="businessCode" onchange="updateBranches()">
                <?php
                while ($row = $businesses->fetch_assoc()) {
                    echo "<option value='" . $row["businessCode"] . "'>" . $row["busName"] . "</option>";
                }
                ?>
            </select>
            <br>

            <label for="branchCode">Select Branch:</label>
            <select name="branchCode" class="form-control mb-3" id="branchCode" onchange="updatePackages()">
            </select><br>

            <label for="voucherCode">Voucher Code:</label>
            <input type="text" class="form-control mb-3" name="voucherCode"><br>

            <label for="condition">Condition:</label>
            <select name="condition" class="form-control mb-3" id="condition" onchange="updateDiscountFields()">
                <option value="percentage">Gift Card</option>
                <option value="specific_package">Specific Package</option>
                <option value="minimum_spend">Minimum Spend</option>
            </select><br>

            <div id="specificPackageField" style="display: none;">
                <label for="selectedPackage">Select Package:</label>
                <select name="selectedPackage" class="form-control mb-3" id="selectedPackage">
                    <?php
                    while ($row = $packages->fetch_assoc()) {
                        echo "<option value='" . $row["packageCode"] . "' data-min-spend='" . $row["minSpend"] . "'>" . $row["packageName"] . "</option>";
                    }
                    ?>
                </select><br>
            </div>

            <div id="minimumSpendField" style="display: none;">
                <label for="minSpend">Minimum Spend:</label>
                <input type="text" class="form-control mb-3" name="minSpend"><br>
            </div>

            <label for="discountType">Discount Type:</label>
            <select name="discountType" class="form-control mb-3">
                <option value="percentage">Percentage</option>
                <option value="amount">Amount</option>
            </select><br>

            <label for="discountValue">Discount Value:</label>
            <input type="text" class="form-control mb-3" name="discountValue"><br>

            <label for="startDate">Start Date:</label>
            <input type="date"class="form-control mb-3" name="startDate"><br>

            <label for="endDate">End Date:</label>
            <input type="date" class="form-control mb-3" name="endDate"><br>

            <input type="submit" class="btn btn-primary" style="float: right;" value="Create Voucher">
        </form>
    </div>
</div>

<!-- Update the script tag in your HTML file -->
<script>
    function updateBranches() {
        var businessCode = document.getElementById("businessCode").value;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "?action=getBranches&businessCode=" + businessCode, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("branchCode").innerHTML = xhr.responseText;
                updatePackages(); // Also update packages when branches change
            }
        };
        xhr.send();
    }

    function updatePackages() {
    var branchCode = document.getElementById("branchCode").value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "?action=getPackages&branchCode=" + branchCode, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("selectedPackage").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

    function updateDiscountFields() {
        var condition = document.getElementById("condition").value;
        var specificPackageField = document.getElementById("specificPackageField");
        var minimumSpendField = document.getElementById("minimumSpendField");

        if (condition === "specific_package") {
            specificPackageField.style.display = "block";
            minimumSpendField.style.display = "none";
        } else if (condition === "minimum_spend") {
            specificPackageField.style.display = "none";
            minimumSpendField.style.display = "block";
        } else {
            specificPackageField.style.display = "none";
            minimumSpendField.style.display = "none";
        }
    }

    // Initial calls to populate branches and packages based on the default selected businessCode and branchCode
    updateBranches();
    updatePackages();
</script>
