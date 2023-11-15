
<!-- old file for reveiwing purposes only hehe -->



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
    <table class="table table-hover table-responsive ">
        <thead >
            <tr>
                <th scope="col">#</th>
                <th scope="col">Business Name</th>
                <th scope="col">Accept</th>
                <th scope="col">Reject</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($businesses as $key => $business) : ?>
                <tr class="sticky-top mt-3 " >
                    <th scope="row"><?= $key + 1 ?></th>
                    <td data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" data-id="<?= $business['businessCode'] ?>">
                        <?= $business['busName'] ?>
                    </td>
                    <td>
                        <input class="form-check-input accept-checkbox" type="checkbox" value="<?= $business['businessCode'] ?>" id="AcceptCheckBox">
                    </td>
                    <td>
                        <input class="form-check-input reject-checkbox" type="checkbox" value="<?= $business['businessCode'] ?>" id="RejectCheckBox">
                    </td>
                </tr>
                <tr class="hidden" data-id="<?= $business['businessCode'] ?>">
                <form class="business-details-form" id="form_<?= $business['businessCode'] ?>">
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

                            <h6 class="text-light bg-info">Business Permits</h6>
                            <input class="form-control mt-3" name="permits" type="file" id="formFile" readonly>
                        </form>                
                        
                        
                        
                        
                        </div> 
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    document.querySelectorAll('.accept-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const businessCode = this.value;
            if (this.checked) {
                updateStatusToAccepted(businessCode);
            }
        });
    });

    function updateStatusToAccepted(businessCode) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'adminFunction', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert('Business status updated to Accepted.');
                } else {
                    alert('Failed to update status. Please try again.');
                }
            }
        };

        const data = 'businessCode=' + businessCode;
        xhr.send(data);
    }
</script>

<?= element('footer') ?>