

<div id="voucher-tbl" style="margin: 120px 0 0 20%">
    <h2>Voucher</h2>

    <?php
    global $DB;

    // Fetch voucher data from the database
    $result = $DB->query("SELECT * FROM voucher");

    if ($result->num_rows > 0) {
    ?>
        <table class="table table-responsive" style="width: 75vw">
        <thead class="table-dark">
            <tr>
                <th>Business Name</th>
                <th>Branch Name</th>
                <th>Voucher Code</th>
                <th>Condition</th>
                <th>Discount Value</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
            </thead>
            <tbody>
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
                <tr>
                    <td class="bg-transparent border border-white"><?= $busName ?></td>
                    <td class="bg-transparent border border-white"><?= $branchName ?></td>
                    <td class="bg-transparent border border-white"><?= $row["voucherCode"] ?></td>
                    <td class="bg-transparent border border-white"><?= $row["cond"] ?></td>
                    <td class="bg-transparent border border-white"><?= ($row["discountType"] === 'percentage') ? $row["discountValue"] . '%' : '₱' . $row["discountValue"] ?></td>
                    <td class="bg-transparent border border-white"><?= $row["startDate"] ?></td>
                    <td class="bg-transparent border border-white"><?= $row["endDate"] ?></td>
                </tr>
            <?php
            }
            ?>
</tbody>
        </table>
      
    <?php
    } else {
        echo "<p>No vouchers found.</p>";
    }
    ?>

    <!-- Button to add a voucher -->
    <a href="?page=create_voucher"><button class="btn btn-primary">Add Voucher</button></a>

    </div>