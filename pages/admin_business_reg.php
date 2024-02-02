<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

// Query the database to fetch businesses with a status of 0
$businesses = $DB->query("SELECT b.*, bo.* FROM business b
    JOIN business_owner bo ON b.ownerID = bo.ownerID
    WHERE b.status = 0");

?>

<?= element('header') ?>

<?= element('admin-side-nav') ?>

<div id="admin-reg" class="admin-reg overflow-auto">
<div class="d-flex justify-content-between mb-4">
        <h1>Business Registrations</h1>
</div>
    <table class="table table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Business Name</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($businesses as $key => $business) : ?>
                <tr class="sticky-top mt-3">
                    <th scope="row" class="bg-transparent border border-white"><?= $key + 1 ?></th>
                    <td class="bg-transparent border border-white w-100 justify-content-between align-items-center d-flex" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample<?= $business['businessCode'] ?>" role="button">
                        <?= $business['busName'] ?>
                        <button class="btn btn-primary " data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample<?= $business['businessCode'] ?>">View</button>
                    </td>
                    <td class="bg-transparent border border-white " style="width:90px;">
                    <div class="d-flex float-end">
                        
                        <form method="post">
                            <input type="hidden" name="business_Code" value="<?= $business['businessCode'] ?>">
                            <button class="btn btn-success mx-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAccept<?= $business['businessCode'] ?>">Accept</button>
                        </form>
                        <form method="post">
                            <input type="hidden" name="business_Code" value="<?= $business['businessCode'] ?>">
                            <button class="btn btn-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasReject<?= $business['businessCode'] ?>">Reject</button>
                        </form>
                        

                        <div class="offcanvas offcanvas-top rounded-3" tabindex="-1" id="offcanvasAccept<?= $business['businessCode'] ?>" style="width: 50vw; height: 50vh; margin: 150px 0 0 25vw;">
                            <div class="offcanvas-header">
                            <h3 class="offcanvas-title p-3">Confirmation</h3>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                            </div>
                            <div class="offcanvas-body px-5">
                            Are you sure you want to accept this business? This action cannot be undone.
                            </div>
                            <div class=" d-flex justify-content-end m-5">
                                <button type="button" class="btn btn-secondary mx-3" data-bs-dismiss="offcanvas">Cancel</button>
                                <form method="post" action="?action=update_status">
                                    <input type="hidden" name="business_Code" value="<?= $business['businessCode'] ?>">
                                    <button type="submit" name="accept_business" class="btn btn-success">Ok</button>
                                </form>
                            </div>
                        </div>

                        <div class="offcanvas offcanvas-top rounded-3" tabindex="-1" id="offcanvasReject<?= $business['businessCode'] ?>" style="width: 50vw; height: 50vh; margin: 150px 0 0 25vw;">
                            <div class="offcanvas-header">
                            <h3 class="offcanvas-title p-3">Confirmation</h3>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                            </div>
                            <div class="offcanvas-body px-5">
                            Are you sure you want to reject this business? This action cannot be undone.
                            </div>
                            <div class=" d-flex justify-content-end m-5">
                                <button type="button" class="btn btn-secondary mx-3" data-bs-dismiss="offcanvas">Cancel</button>
                                <form method="post" action="?action=update_status">
                                    <input type="hidden" name="business_Code" value="<?= $business['businessCode'] ?>">
                                    <button type="submit" name="reject_business" class="btn btn-success">Ok</button>
                                </form>
                            </div>
                        </div>
                        </div>



                        
                     </td>
                </tr>
                
                <div class="offcanvas offcanvas-top overflow-auto p-3" style="width: 50vw; height: 100vh; margin-left: 25vw;" tabindex="-1" id="offcanvasExample<?= $business['businessCode'] ?>">
                <div id="reg-form" class="card justify-content-between border-0 shadow p-3 mb-5 bg-white rounded">

                            <div class="card-body">
                            <h1>Business Registration</h1>
                            <hr>
                            <h5 class="text-light bg-info">Owner Information</h5>
                            <div class="row d-flex align-items-center mb-2">
                                <label class="mb-2 col-3" for="ownerName">Owner's Name</label>
                                <input type="text" class="form-control col" name="data[ownerName]" id="fname" value="<?= $business['fname'] . ' ' . $business['lname'] ?>" readonly>
                            </div>
                            <div class="row d-flex align-items-center mb-2">
                                <label class="mb-2 col-3" for="ownerAddress">Owner's Address</label>
                                <input type="text" class="form-control col" name="data[ownerAddress]" id="ownerAddress" value="<?= $business['ownerAddress'] ?>" readonly>
                            </div>
                            <h5 class="text-light bg-info">Business Information</h5>
                            <div class="row d-flex align-items-center mb-2">
                                <label class="mb-2 col-3" for="busName">Business Name</label>
                                <input type="text" class="form-control col" name="data[busName]" id="busName" value="<?= $business['busName'] ?>" readonly>
                            </div>
                            <div class="row d-flex align-items-center mb-2">
                                <label class="mb-2 col-3" for="busType">Business Type</label>
                                <input type="text" class="form-control col" name="data[busType]" id="busType" value="<?= $business['busType'] ?>" readonly>
                            </div>

                            <h6 class="text-light bg-info">Business Address</h6>
                            <p class="note mb-3">*Address of the Main Branch</p>
                            <div class="row mb-2">
                            <label class=" col-4" for="house-building">House/Building No. & Name</label>
                            <input type="text" class="form-control col" name="data[house_building]" id="house_building"  value="<?= $business['house_building'] ?>"readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="street">Street</label>
                            <input type="text" class="form-control col" name="data[street]" id="street" value="<?= $business['street'] ?>" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="barangay">Barangay</label>
                            <input type="text" class="form-control col" name="data[barangay]" id="barangay" value="<?= $business['barangay'] ?>" readonly>
                        </div> 
                        <div class="row mb-2">
                            <label class="col-4" for="city_municipality">City/ Municipality</label>
                            <input type="text" class="form-control col" name="data[city_municipality]" id="city_municipality" value="<?= $business['city_municipality'] ?>" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="province">Province</label>
                            <input type="text" class="form-control col" name="data[province]" id="Province" value="<?= $business['province'] ?>" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="region">Region</label>
                            <input type="text" class="form-control col" name="data[region]" id="region" value="<?= $business['region'] ?>" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="phone">Telephone Number</label>
                            <input type="text" class="form-control col" name="data[phone]" id="phone" value="<?= $business['phone'] ?>" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="mobile">Mobile Number</label>
                            <input type="text" class="form-control col" name="data[mobile]" id="mobile" value="<?= $business['mobile'] ?>" readonly>
                        </div>

                        <h5 class="text-light bg-info">Business Permits</h5>      
                            <?php
                            $permitPath = $business['permits']; // Assuming the file path is stored in the 'permits' field
                            $sanitaryPath = $business['sanitary']; // Assuming the file path is stored in the 'sanitary' field
                            $taxPath = $business['tax']; // Assuming the file path is stored in the 'tax' field

                            // Function to display file information and content
                            function displayFile($filePath, $fileType, $portraitWidth = null, $portraitHeight = null, $landscapeWidth = null, $landscapeHeight = null)
                            {
                                if (file_exists($filePath)) {
                                    $fileInfo = pathinfo($filePath);
                                    $fileName = $fileInfo['basename'];

                                    echo "<p>File Name: $fileName</p>";
                                    // Get image dimensions
                                    list($originalWidth, $originalHeight) = getimagesize($filePath);

                                    // Calculate aspect ratio
                                    $aspectRatio = $originalWidth / $originalHeight;

                                    // Determine whether the image is portrait or landscape
                                    $isPortrait = ($aspectRatio < 1);

                                    // Set the width and height based on orientation
                                    $width = $isPortrait ? $portraitWidth : $landscapeWidth;
                                    $height = $isPortrait ? $portraitHeight : $landscapeHeight;

                                    // Display file content for images
                                    $allowedImageFormats = array("jpg", "jpeg", "png");
                                    if (in_array(strtolower($fileInfo['extension']), $allowedImageFormats)) {
                                         echo "<img src='$filePath' alt='$fileType' style='width:{$width}px; height:{$height}px;'>";

                                    } else {
                                        // Display file content for other file types using appropriate tags
                                        if ($fileInfo['extension'] === 'pdf') {
                                            // Example: Use an <a> tag with target="_blank" for PDF files
                                            echo "<a href='$filePath' target='_blank'>View PDF</a>";
                                        } else {
                                            // Add handling for other file types here
                                            echo "<p>Unable to display this file type.</p>";
                                        }
                                    }
                                } else {
                                    echo "<p>No file uploaded.</p>";
                                }
                            }

                            // Display permits
                            echo "<h6><strong>Permits</strong></h6>";
                            displayFile($permitPath, 'Permits',  500, 900, 800, 400);

                            // Display sanitary
                            echo "<h6><strong>Sanitary</strong></h6>";
                            displayFile($sanitaryPath, 'Sanitary', 500, 900,  800, 400);

                            // Display tax
                            echo "<h6><strong>Tax</strong></h6>";
                            displayFile($taxPath, 'Tax',500, 900,  800, 400);
                            ?>

                     
                      


                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>




<?= element('footer') ?>

