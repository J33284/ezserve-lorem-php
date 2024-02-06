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
            <select name="businessCode" class="form-control " id="businessCode" onchange="updateBranches()">
                <?php
                while ($row = $businesses->fetch_assoc()) {
                    echo "<option value='" . $row["businessCode"] . "'>" . $row["busName"] . "</option>";
                }
                ?>
            </select>
            <input type="hidden" name="packCode" id="hiddenPackageCode" value="">
            <input type="hidden" name="ownerID" id="ownerID" value="<?=$ownerID?>">
            <br>

            <label for="branchCode">Select Branch:</label>
            <select name="branchCode" class="form-control" id="branchCode" onchange="updatePackages()">
            </select><br>

            <label for="voucherName">Voucher Name:</label>
            <input type="text" class="form-control" name="voucherName" required><br>

            <label for="voucherCode">Voucher Code:</label>
            <input type="text" class="form-control" name="voucherCode"><br>

            <label for="condition">Voucher Type:</label>
            <select name="condition" class="form-control" id="condition" onchange="updateDiscountFields()">
                <option value="Gift Card">Gift Card</option>
                <option value="Specific Package">Specific Package</option>
                <option value="Minimum Spend">Minimum Spend</option>
            </select><br>
            <div id="specificPackageField" style="display: none;">
                <label for="selectedPackage">Select Package:</label>
                <select name="selectedPackage" class="form-control" id="selectedPackage">
                    <?php
                    while ($row = $packages->fetch_assoc()) {
                        echo "<option value='" . $row["packageCode"] . "' data-min-spend='" . $row["minSpend"] . "'>" . $row["packageName"] . "</option>";
                    }
                    ?>
                       <input type="hidden" name="packageCode" id="hiddenPackageCode" value="">

                </select><br>
            </div>

            <div id="minimumSpendField" style="display: none;">
                <label for="minSpend">Minimum Spend:</label>
                <input type="number" class="form-control" name="minSpend" min="1"><br>
            </div>

            <label for="discountType">Discount Type:</label>
            <select name="discountType" class="form-control">
                <option value="percentage">Percentage</option>
                <option value="amount">Amount</option>
            </select><br>

            <label for="discountValue">Discount Value:</label>
            <input type="text" class="form-control" name="discountValue" required><br>

            <label for="startDate">Start Date:</label>
            <input type="date"class="form-control" name="startDate" required><br>

            <label for="endDate">End Date:</label>
            <input type="date" class="form-control" name="endDate" required><br>

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
                // Update the hidden input field with the first packageCode in the list
                var firstPackageCode = document.querySelector("#selectedPackage option:first-child").value;
                document.getElementById("hiddenPackageCode").value = firstPackageCode;
            }
        };
        xhr.send();
    }

    function updateDiscountFields() {
        var condition = document.getElementById("condition").value;
        var specificPackageField = document.getElementById("specificPackageField");
        var minimumSpendField = document.getElementById("minimumSpendField");
        var minSpendInput = document.querySelector("input[name='minSpend']");

        if (condition === "Specific Package") {
            specificPackageField.style.display = "block";
            minimumSpendField.style.display = "none";
            minSpendInput.removeAttribute("required"); // Remove the required attribute
        } else if (condition === "Minimum Spend") {
            specificPackageField.style.display = "none";
            minimumSpendField.style.display = "block";
            minSpendInput.setAttribute("required", "required"); // Add the required attribute
        } else {
            specificPackageField.style.display = "none";
            minimumSpendField.style.display = "none";
            minSpendInput.removeAttribute("required"); // Remove the required attribute
        }
    }

    // Initial calls to populate branches and packages based on the default selected businessCode and branchCode
    updateBranches();
    updatePackages();
</script>
