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
    <table class="table table-hover table-responsive">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Business Name</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($businesses as $key => $business) : ?>
                <tr class="sticky-top mt-3">
                    <th scope="row"><?= $key + 1 ?></th>
                    <td data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample<?= $business['businessCode'] ?>" role="button">
                        <?= $business['busName'] ?>
                    </td>
                    <td>
                    <div class="btn-group">
                    <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample<?= $business['businessCode'] ?>">View</button>
                    <form method="post" action="?action=update_status">
                        <input type="hidden" name="business_Code" value="<?= $business['businessCode'] ?>">
                        <button class="btn btn-success" type="submit" name="accept_business">Accept</button>
                        <button class="btn btn-danger" type="submit" name="reject_business">Reject</button>
                    </form>
                    </div>

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
                        <div class="row mb-2">
                            <label class="col-4" for="coordinates">Coordinates</label>
                            <input type="text" class="form-control col" name="data[coordinates]" id="coordinates" value="<?= $business['coordinates'] ?>" readonly>
                        </div>

                            <h6 class="text-light bg-info">Business Permits</h6>
                            <input class="form-control mt-3" name="permits" type="file" id="formFile" readonly>
                        </div> 
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?= element('footer') ?>