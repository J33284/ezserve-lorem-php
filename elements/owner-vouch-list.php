<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>


<div id="voucher-tbl" style="margin: 150px 0 0 22%; width: 75vw;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Voucher</h2>
    </div>
    <?php
    global $DB;
    $ownerID = $_SESSION['userID'];
    // Fetch voucher data from the database
    $result = $DB->query("SELECT * FROM voucher WHERE ownerID = '$ownerID'");

    if ($result->num_rows > 0) {
    ?>
        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex">
            </div>
            <a href="?page=create_voucher" class="btn btn-primary">Add Voucher</a>
        </div>

        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Business Name</th>
                    <th scope="col">Branch Name</th>
                    <th scope="col">Voucher Name</th>
                    <th scope="col">Voucher Code</th>
                    <th scope="col">Voucher Type</th>
                    <th scope="col">Discount Value</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Actions</th>
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
                        <td><?= $busName ?></td>
                        <td><?= $branchName ?></td>
                        <td><?= $row["voucherName"] ?></td>
                        <td><?= $row["voucherCode"] ?></td>
                        <td><?= $row["voucherType"] ?></td>
                        <td>
                            <?= ($row["discountType"] === 'percentage') ? $row["discountValue"] . '%' : '₱' . $row["discountValue"] ?>
                        </td>
                        <td><?= $row["startDate"] ?></td>
                        <td><?= $row["endDate"] ?></td>
                        <td>
                            <div class="d-flex">
                                <a href="?page=edit_voucher&id=<?= $row["voucherID"] ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> <!-- Edit icon -->
                                </a>
                                <a href="?page=delete_voucher&id=<?= $row["voucherID"] ?>" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> <!-- Delete icon -->
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="d-flex justify-content-center align-items-center" style="height: 60vh;">
            <div class="card text-center">
                <div class="card-body">
                    <p>No vouchers found</p>
                    <a href="?page=create_voucher" class="btn btn-primary">Add Voucher</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
