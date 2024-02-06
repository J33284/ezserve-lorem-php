<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

// Use $_POST to retrieve the business code consistently
if (isset($_POST['businessCode'])) {
    $businessCode = $_POST['businessCode'];

    // Query the database to fetch business details based on $businessCode
    $result = $DB->query("SELECT b.*, bo.*, br.* FROM business b JOIN business_owner bo ON b.ownerID = bo.ownerID JOIN branches br ON b.businessCOde = br.businessCode
   
    WHERE b.businessCode = '$businessCode'");
    // Check if any rows are returned
    if ($result->num_rows > 0) {
        $businessDetails = $result->fetch_assoc();
    } else {
        echo '<p>Business not found</p>';
        // You might want to handle the case where the business is not found
        // or redirect the user to an error page.
    }
} else {
    echo '<p>Invalid request</p>';
}

// Query the database to fetch businesses with a status of 0
$businesses = $DB->query("SELECT b.*, br.* FROM business b JOIN branches br ON b.businessCode = br.businessCode
WHERE b.businessCode = '$businessCode'");
?>
<?= element('header') ?>

<?php if (!empty($businessDetails)) : ?>
    <div id="reg-form" class="card justify-content-between border-0 shadow p-3 mb-5 bg-white rounded" style="margin: 120px 100px ">
        <div class="card-body">
            <div class="row justify-content-between my-3">
                <div class="col-9">
                    <div class="row d-flex align-items-center mb-2">
                        <h1><?= $businessDetails['busName'] ?></h1>
                    </div>
                    <div class="row d-flex align-items-center mb-2">
                        <label class="col-3" for="busType">Owner</label>
                        <p class="col m-0"><?= $businessDetails['fname'] . ',' . $businessDetails['lname'] ?></p>
                    </div>
                    <div class="row d-flex align-items-center mb-2">
                        <label class="col-3" for="busType">Email address</label>
                        <p class="col m-0"><?= $businessDetails['email'] ?></p>
                    </div>
                    <div class="row d-flex align-items-center mb-2">
                        <label class="col-3" for="busType">Address</label>
                        <p class="col m-0">
                            <?= $businessDetails['house_building'] . ', ' . $businessDetails['barangay'] . ', ' . $businessDetails['street'] . ', ' . $businessDetails['city_municipality'] . ', ' . $businessDetails['province'] ?>
                        </p>
                    </div>
                    <div class="row d-flex align-items-center mb-2">
                        <label class="col-3" for="busType">Telephone Number</label>
                        <p class="col m-0"><?= $businessDetails['phone'] ?></p>
                    </div>
                    <div class="row d-flex align-items-center mb-2">
                        <label class="col-3" for="busType">Mobile Number</label>
                        <p class="col m-0"><?= $businessDetails['mobile'] ?></p>
                    </div>
                    <div class="row d-flex align-items-center mb-2">
                        <label class="col-3" for="busType">Business Type</label>
                        <p class="col m-0"><?= $businessDetails['busType'] ?></p>
                    </div>
                </div>
                
                <div class="col-3">
                    <?php
                    $imagePath = !empty($businessDetails['busImage']) ? $businessDetails['busImage'] : 'assets/images/default.jpg';
                    ?>
                    <img class="card-img-top rounded-3 img-fluid" src="<?= $imagePath ?>" alt="Card image cap" style="height:200px; width: 200px">
                </div>
            </div>
        </div>
        
        <div class="bus-branch mx-2 mb-3">
            <h3>Branches</h3>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Branch Name</th>
                            <th>Address</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($businesses as $branch): ?>
                            <tr>
                                <td><?= $branch['branchName'] ?></td>
                                <td><?= $branch['address'] ?></td>
                                <td style="width: 90px">
                                    <button class="btn btn-primary mx-5 d-flex" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBranch<?= $branch['branchCode'] ?>">
                                        <i class="bi bi-eye mx-1"></i>
                                        <span>View</span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php foreach ($businesses as $branch): ?>
            <div class="offcanvas offcanvas-top overflow-auto p-3 rounded" style="width: 75vw; height: 75vh; margin: 50px 0 0 13%;" tabindex="-1" id="offcanvasBranch<?= $branch['branchCode'] ?>"  data-bs-backdrop="static">
                <div class="p-3">
                    <div class="offcanvas-header p-0">
                        <h2 class="offcanvas-title" id="offcanvasExampleLabel">Pending Transactions</h2>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                </div>
                <?php
                // SQL query to retrieve pending transactions with future pickup or delivery dates
                $sql = "SELECT 
                            t.clientName,
                            t.totalAmount,
                            t.status,
                            t.paymentDate,
                            t.pickupDate,
                            t.deliveryDate
                        FROM 
                            transact t
                        WHERE 
                            (t.pickupDate > CURDATE() OR t.deliveryDate > CURDATE())AND
                    t.branchCode = '{$branch['branchCode']}'"; // Filter transactions by branchCode";
                $transactions = $DB->query($sql);
                ?>
                <div>
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Client Name</th>
                                <th>Amount</th>
                                <th>Payment Status</th>
                                <th>Transaction Date</th>
                                <th>Pickup/Delivery Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transact): ?>
                                <tr>
                                    <td><?= $transact['clientName'] ?></td>
                                    <td><?= $transact['totalAmount'] ?></td>
                                    <td><?= $transact['status'] ?></td>
                                    <td><?= $transact['paymentDate'] ?></td>
                                    <td><?= !empty($transact['pickupDate']) ? $transact['pickupDate'] : $transact['deliveryDate'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
<?php else : ?>
    <p>No business found.</p>
<?php endif; ?>
</div>