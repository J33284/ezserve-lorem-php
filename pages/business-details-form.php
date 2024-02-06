<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

// Use $_POST to retrieve the business code consistently
if (isset($_POST['businessCode'])) {
    $businessCode = $_POST['businessCode'];

    // Query the database to fetch business details based on $businessCode
    $result = $DB->query("SELECT b.*, br.* FROM business b
    JOIN branches br ON b.businessCode = br.businessCode
    WHERE b.businessCode = '$businessCode'");
    // Check if any rows are returned
    if ($result->num_rows > 0) {
        $businessDetails = $result->fetch_assoc();
    } else {
        echo '<p>Business not found</p>';
    }
} else {
    echo '<p>Invalid request</p>';
}

// Query the database to fetch businesses with a status of 0
$businesses = $DB->query("SELECT b.*, br.* FROM business b JOIN branches br ON b.businessCode = br.businessCode
WHERE b.businessCode = '$businessCode'");


?>
<?= element('header') ?>


<?php foreach ($businesses as $business) : ?>
    <div id="reg-form" class="card justify-content-between border-0 shadow p-3 mb-5 bg-white rounded" style="margin: 120px 100px ">
<div class="card-body">
<div class="row justify-content-between my-3">
    <div class="col-9">
    
        <div class="row d-flex align-items-center mb-2">
            <h1> <?= $business['busName'] ?></h1>
        </div>
        <div class="row d-flex align-items-center mb-2">
            <label class="col-3" for="busType">Address</label>
            <p class="col m-0">
                <?= $business['house_building'] . ', ' . $business['barangay'] . ', ' . $business['street'] . ', ' . $business['city_municipality'] . ', ' . $business['province'] ?>
            </p>

        </div>
        <div class="row d-flex align-items-center mb-2">
            <label class="col-3" for="busType">Telephone Number</label>
            <p class="col m-0"> <?= $business['phone'] ?></p>
        </div>
        <div class="row d-flex align-items-center mb-2">
            <label class="col-3" for="busType">Mobile Number</label>
            <p class="col m-0"> <?= $business['mobile'] ?></p>
        </div>
        <div class="row d-flex align-items-center mb-2">
            <label class="col-3" for="busType">Business Type</label>
            <p class="col m-0"> <?= $business['busType'] ?></p>
        </div>
    </div>
    <div class="col-3">
            <?php
                        $imagePath = !empty($business['busImage']) ? $business['busImage'] : 'assets/images/default.jpg';
                        ?>
                        <img class="card-img-top rounded-3 img-fluid"  src="<?= $imagePath ?>" alt="Card image cap" style="height:200px; width: 200px">
    </div>
</div>
</div>
<div class="m-3">
    <h3>Business Permits</h3>

    <?php
    $permitPath = $business['permits']; // Assuming the file path is stored in the 'permits' field
    $sanitaryPath = $business['sanitary']; // Assuming the file path is stored in the 'sanitary' field
    $taxPath = $business['tax']; // Assuming the file path is stored in the 'tax' field

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
<div>
    <p>henlo agen</p>
</div>
</div>
<?php endforeach; ?>

