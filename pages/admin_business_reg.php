<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$businesses = $DB->query("SELECT b.*, bo.* FROM business b
    JOIN business_owner bo ON b.ownerID = bo.ownerID
    WHERE b.status = 0");


?>

<?= element('admin_header') ?>

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
                    <td class="bg-transparent border border-white w-100 justify-content-between align-items-center d-flex" >
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
                        

                        
                        </div>



                        
                     </td>
                     <div class="offcanvas offcanvas-top rounded-3" data-bs-backdrop="static" tabindex="-1" id="offcanvasAccept<?= $business['businessCode'] ?>" style="width: 50vw; height: 50vh; margin: 150px 0 0 25vw;">
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

                        <div class="offcanvas offcanvas-top rounded-3 " data-bs-backdrop="static" tabindex="-1" id="offcanvasReject<?= $business['businessCode'] ?>" style="width: 50vw; height: 80vh; margin: 90px 0 0 25vw; ">
                            <div class="offcanvas-header">
                            <h3 class="offcanvas-title p-3">Confirmation</h3>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                            </div>
                            <div class="offcanvas-body px-5">

                            You are about to reject this business. 
                            Please provide a reason for rejecting.

                            <div class="reasons my-4">
                                <p> Select a reason for the deletion request</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault"> Incomplete or inaccurate documentation</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault"> Concerns regarding the business's legality or ethical practices</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault"> Previous history of fraudulent activities</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault"> Conflict of interest with existing businesses or regulations</label>
                                </div>
                            </div>

                            </div>

                            
                            
                            <div class=" d-flex justify-content-end m-5">
                                <button type="button" class="btn btn-secondary mx-3" data-bs-dismiss="offcanvas">Cancel</button>
                                <form method="post" action="?action=update_status">
                                    <input type="hidden" name="business_Code" value="<?= $business['businessCode'] ?>">
                                    <button type="submit" name="reject_business" class="btn btn-success">Ok</button>
                                </form>
                            </div>
                        </div>
                </tr>
                
                <div class="offcanvas offcanvas-top overflow-auto p-3" data-bs-backdrop="static" style="width: 50vw; height: 100vh; margin-left: 25vw;" tabindex="-1" id="offcanvasExample<?= $business['businessCode'] ?>">
                <div id="reg-form" class="justify-content-between ">
                <div class="offcanvas-header">
                            <h3 class="offcanvas-title p-1">Business Registration</h3>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                            </div>
                            <div class="card-body">
                            <h5 class="text-light bg-info p-2">Owner Information</h5>
                            <div class="row d-flex align-items-center mb-2">
                                <label class="mb-2 col-4" for="ownerName">Owner's Name</label>
                                <input type="text" class="form-control col mx-3" name="data[ownerName]" id="fname" value="<?= $business['fname'] . ' ' . $business['lname'] ?>" readonly>
                            </div>
                            <div class="row d-flex align-items-center mb-2">
                                <label class="mb-2 col-4" for="ownerAddress">Owner's Address</label>
                                <input type="text" class="form-control col mx-3" name="data[ownerAddress]" id="ownerAddress" value="<?= $business['ownerAddress'] ?>" readonly>
                            </div>
                            <h5 class="text-light bg-info p-2">Business Information</h5>
                            <div class="row d-flex align-items-center mb-2">
                                <label class="mb-2 col-4" for="busName">Business Name</label>
                                <input type="text" class="form-control col mx-3" name="data[busName]" id="busName" value="<?= $business['busName'] ?>" readonly>
                            </div>
                            <div class="row d-flex align-items-center mb-2">
                                <label class="mb-2 col-4" for="busType">Business Type</label>
                                <input type="text" class="form-control col mx-3" name="data[busType]" id="busType" value="<?= $business['busType'] ?>" readonly>
                            </div>

                            <h6 class="text-light bg-info p-2">Business Address</h6>
                            <p class="note mb-3">*Address of the Main Branch</p>
                            <div class="row mb-2">
                            <label class=" col-4" for="house-building">House/Building No. & Name</label>
                            <input type="text" class="form-control col mx-3" name="data[house_building]" id="house_building"  value="<?= $business['house_building'] ?>"readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="street">Street</label>
                            <input type="text" class="form-control col mx-3" name="data[street]" id="street" value="<?= $business['street'] ?>" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="barangay">Barangay</label>
                            <input type="text" class="form-control col mx-3" name="data[barangay]" id="barangay" value="<?= $business['barangay'] ?>" readonly>
                        </div> 
                        <div class="row mb-2">
                            <label class="col-4" for="city_municipality">City/ Municipality</label>
                            <input type="text" class="form-control col mx-3" name="data[city_municipality]" id="city_municipality" value="<?= $business['city_municipality'] ?>" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="province">Province</label>
                            <input type="text" class="form-control col mx-3" name="data[province]" id="Province" value="<?= $business['province'] ?>" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="region">Region</label>
                            <input type="text" class="form-control col mx-3" name="data[region]" id="region" value="<?= $business['region'] ?>" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="phone">Telephone Number</label>
                            <input type="text" class="form-control col mx-3" name="data[phone]" id="phone" value="<?= $business['phone'] ?>" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="mobile">Mobile Number</label>
                            <input type="text" class="form-control col mx-3" name="data[mobile]" id="mobile" value="<?= $business['mobile'] ?>" readonly>
                        </div>

                        <h5 class="text-light bg-info p-2">Business Permits</h5>      
                        
                        <div class="row mb-2">
                        <label class="col-4" for="business_permit">Business Permit</label>
                        <div class="col mx-3">
                            <?php if (!empty($business['business_permit'])) : ?>
                                <button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="<?= $business['business_permit'] ?>">View</button>
                            <?php else : ?>
                                <p>No Business Permit</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-4" for="tax">Tax Certificate</label>
                        <div class="col mx-3">
                            <?php if (!empty($business['tax'])) : ?>
                                <button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="<?= $business['tax'] ?>">View</button>
                            <?php else : ?>
                                <p>No Tax Certificate</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-4" for="sanitary">Sanitary Permit</label>
                        <div class="col mx-3">
                            <?php if (!empty($business['sanitary'])) : ?>
                                <button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="<?= $business['sanitary'] ?>">View</button>
                            <?php else : ?>
                                <p>No Sanitary Permit</p>
                            <?php endif; ?>
                        </div>
                    </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
        
                



<!-- Modal Structure -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Permit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" id="modalImage" class="img-fluid" alt="Full Image">
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var imageUrl = button.getAttribute('data-bs-image');
        var modalImage = imageModal.querySelector('#modalImage');
        modalImage.src = imageUrl;
    });
});
</script>


