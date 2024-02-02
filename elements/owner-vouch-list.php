<div id="voucher-tbl" style="margin: 120px 0 0 20%">
    <h2>Voucher</h2>

    <?php
    global $DB;
    $ownerID = $_SESSION['userID'];
    // Fetch voucher data from the database
    $result = $DB->query("SELECT * FROM voucher WHERE ownerID = '$ownerID'");

    if ($result->num_rows > 0) {
    ?>
        <div class="card-deck">
            <?php
            while ($row = $result->fetch_assoc()) {
                // Fetch business name based on businessCode
                $businessCode = $row["businessCode"];
                $busNameResult = $DB->query("SELECT busName FROM business WHERE businessCode = '$businessCode'");
                $busName = ($busNameResult->num_rows > 0) ? $busNameResult->fetch_assoc()["busName"] : '';

                // Fetch branch name based on branchCode
                $branchCode = $row["branchCode"];
                $branchNameResult = $DB->query("SELECT branchName FROM branches WHERE branchCode = '$branchCode'");
                $branchName = ($branchNameResult->num_rows > 0) ? $branchNameResult->fetch_assoc()["branchName"] : '';
            ?>
                <div class="card">
                    <div class="card-header">
                        <?= $busName ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $branchName ?></h5>
                        <p class="card-text">
                            <strong>Voucher Code:</strong> <?= $row["voucherCode"] ?><br>
                            <strong>Voucher Type:</strong> <?= $row["cond"] ?><br>
                            <strong>Discount Value:</strong> <?= ($row["discountType"] === 'percentage') ? $row["discountValue"] . '%' : '₱' . $row["discountValue"] ?><br>
                            <strong>Start Date:</strong> <?= $row["startDate"] ?><br>
                            <strong>End Date:</strong> <?= $row["endDate"] ?>
                        </p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <?php } else { ?>
            <div class="card-deck d-flex justify-content-center align-items-center" style="height: 60vh;">
                <div class="card text-center">
                    <div class="card-body">
                        <p>No vouchers found.</p>
                        <!-- Button to add a voucher -->
                        <a href="?page=create_voucher" class="btn btn-primary">Add Voucher</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    <!-- Button to add a voucher -->
    <a href="?page=create_voucher" class="btn btn-primary">Add Voucher</a>
</div>
