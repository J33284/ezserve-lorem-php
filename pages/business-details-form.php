<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

// Use $_POST to retrieve the business code consistently
if (isset($_POST['businessCode'])) {
    $businessCode = $_POST['businessCode'];

    // Query the database to fetch business details based on $businessCode
    $result = $DB->query("SELECT b.* FROM business b
   
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
        <div class="m-3">
            <h3>Business Permits</h3>

            <?php
            $permitPath = $businessDetails['permits']; // Assuming the file path is stored in the 'permits' field
            $sanitaryPath = $businessDetails['sanitary']; // Assuming the file path is stored in the 'sanitary' field
            $taxPath = $businessDetails['tax']; // Assuming the file path is stored in the 'tax' field

            // Function to display file names with links
            function displayFileName($filePath, $fileType)
            {
                if (file_exists($filePath)) {
                    $fileName = pathinfo($filePath, PATHINFO_BASENAME);
                    echo "<p><a href='javascript:void(0);' onclick='showImage(\"$filePath\", \"$fileType\");'>$fileName</a></p>";
                } else {
                    echo "<p>No file uploaded for $fileType.</p>";
                }
            }

            // Display permits
            echo "<h6><strong>Permits</strong></h6>";
            displayFileName($permitPath, 'Permits');

            // Display sanitary
            echo "<h6><strong>Sanitary</strong></h6>";
            displayFileName($sanitaryPath, 'Sanitary');

            // Display tax
            echo "<h6><strong>Tax</strong></h6>";
            displayFileName($taxPath, 'Tax');
            ?>

            <!-- Script to display image when clicked -->
            <script>
                function showImage(filePath, fileType) {
                    if (filePath.toLowerCase().endsWith('.pdf')) {
                        // If it's a PDF, open in a new tab
                        window.open(filePath, '_blank');
                    } else {
                        // If it's an image, display it in a modal or lightbox
                        var image = new Image();
                        image.src = filePath;

                        var modal = document.createElement('div');
                        modal.style.position = 'fixed';
                        modal.style.top = '0';
                        modal.style.left = '0';
                        modal.style.width = '100%';
                        modal.style.height = '100%';
                        modal.style.background = 'rgba(0, 0, 0, 0.8)';
                        modal.style.display = 'flex';
                        modal.style.alignItems = 'center';
                        modal.style.justifyContent = 'center';

                        image.style.maxWidth = '90%';
                        image.style.maxHeight = '90%';

                        modal.appendChild(image);
                        document.body.appendChild(modal);

                        // Close modal on click
                        modal.onclick = function () {
                            modal.remove();
                        };
                    }
                }
            </script>
        </div>
        <div class="bus-branch mx-2 mb-3">
    <h3>Branches</h3>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Branch Name</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($businesses as $branch): ?>
                    <tr>
                        <td><?= $branch['branchName'] ?></td>
                        <td><?= $branch['address'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
            (t.pickupDate > CURDATE() OR t.deliveryDate > CURDATE())";


$transactions = $DB->query($sql);
?>
        <div>
            <h3>Pending Transactions</h3>
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
<?php else : ?>
    <p>No business found.</p>
<?php endif; ?>
