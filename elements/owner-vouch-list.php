<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>


<div id="voucher-tbl" style="margin: 150px 0 0 22%; width: 75vw;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Voucher</h2>
        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex">
            </div>
            <a href="?page=create_voucher" class="btn btn-primary"><i class="bi bi-plus" style="font-size: 24px; "></i>
                <span class="mt-1">Add Voucher</span></a>
        </div>
    </div>
    <?php
    global $DB;
    $ownerID = $_SESSION['userID'];
    // Fetch voucher data from the database
    $result = $DB->query("SELECT * FROM voucher WHERE ownerID = '$ownerID'");

    if ($result->num_rows > 0) {
    ?>
      

        <table class="table table-responsive">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Business Name</th>
                    <th scope="col">Branch Name</th>
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

                    $packCode = $row["packCode"];
                    $packNameResult = $DB->query("SELECT packName FROM package WHERE packCode = '$packCode'");
                    $packName = ($packNameResult->num_rows > 0) ? $packNameResult->fetch_assoc()["packName"] : '';
                ?>
                    <tr>
                        <td class="bg-transparent border border-white"><?= $busName ? $busName : "All Business" ?></td>
                        <td class="bg-transparent border border-white"><?= $branchName ? $branchName : "All Branches" ?></td>
                        <td class="bg-transparent border border-white"><?= $row["voucherCode"] ?></td>
                        <td class="bg-transparent border border-white">
                        <?php
                        echo $row["voucherType"];
                        if ($row["voucherType"] === "Specific Package") {
                            echo " ($packName)";
                        } elseif ($row["voucherType"] === "Minimum Spend") {
                            echo " (₱" . $row["min_spend"] . ")";
                        }
                        ?>
                        </td>
                        <td class="bg-transparent border border-white">
                            <?= ($row["discountType"] === 'percentage') ? $row["discountValue"] . '%' : '₱' . $row["discountValue"] ?>
                        </td>
                        <td class="bg-transparent border border-white"><?= $row["startDate"] ?></td>
                        <td class="bg-transparent border border-white"><?= $row["endDate"] ?></td>
                        <td class="bg-transparent border border-white">
                            <div class="d-flex ">
                                <a href="?page=edit_voucher&id=<?= $row["voucherID"] ?>" class="btn btn-warning mx-2">
                                    <i class="fas fa-edit"></i> <!-- Edit icon -->
                                </a>
                                <a href="#" class="btn btn-danger" onclick="confirmDelete(<?= $row["voucherID"] ?>)">
                                    <i class="fas fa-trash-alt"></i> <!-- Delete icon -->
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="d-flex justify-content-center align-items-center" style="height: 40vh;">
            <div class="card text-center ">
                <div class="card-body d-flex">
                    <i class="bi bi-exclamation-triangle " style="font-size: 50px"></i>
                    <h2 class="py-4 px-2">No Vouchers Found</h2>
                    
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<div id="deleteConfirmationModal" class="modal" tabindex="-1">
    <div class="modal-dialog" style= "margin-top: 180px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this voucher?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a id="deleteVoucherButton" href="#" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(voucherID) {
        // Set the href attribute of the delete button in the modal
        var deleteButton = document.getElementById("deleteVoucherButton");
        deleteButton.setAttribute("href", "?action=delete_voucher&id=" + voucherID);

        // Show the modal
        var deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        deleteConfirmationModal.show();
    }
</script>