<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); ?>

<?= element( 'header' ) ?>

<?= element( 'owner-side-nav' ) ?>

<!-- Add this in the head section of your HTML -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<?php
global $DB;
$businessCode = isset($_GET['businesscode']) ? $_GET['businesscode'] : '';
$ownerID = $_SESSION['userID'];

// Ensure $businessCode is properly sanitized to prevent SQL injection
$businessCode = $DB->real_escape_string($businessCode);

$sql = "SELECT * FROM business WHERE ownerID = $ownerID AND businessCode = '$businessCode' AND status = 1";
$result = $DB->query($sql);

?>

<?php while ($row = $result->fetch_assoc()): ?>
<div id="own-bus" class="own-bus">
    <div class="d-flex justify-content-between p-3">
        <h1 class="text-light">My Business</h1>
        <a href="?page=bus-register" id="registerButton">
            <i class="bi bi-plus-square white-text">Register your business here!</i>
        </a>
        <div>
            <a href="?page=owner_business" id="backButton" class="btn-back float-start mt-4" style="display: block;">
                <i class="bi bi-arrow-left"></i>
                <span>Back</span>
            </a>
        </div>
    </div>

    <div id="detailsForm" class="bus-info card border-0 rounded-5 shadow p-3 mb-5 bg-white rounded">
        <div class="business-details justify-content-between p-4" id="businessDetails<?= $row['businessCode'] ?>">
            <a href="#" id="editButton" class="btn-edit float-end mt-4" onclick="toggleEditable()">
                <i class="bi bi-pencil-fill"></i>
                <span>Edit</span>
            </a>
            <h2>Business Information</h2>

            <!-- 2 columns for details and pic -->
            <form method="post" action="?action=businessAction" enctype="multipart/form-data">
                <input type="hidden" name="business_Code" value="<?= $row['businessCode'] ?>">
                <input type="hidden" name="data[prevImage]" value="<?= $row['busImage'] ?>">

                <div class="column d-flex row justify-content-between">
                    <div class="col-md-7 flex-column">
                        <!-- Business Name -->
                        <h6 id="busNameHeader"><b>Business Name</b></h6>
                        <p id="busNameInput" style="display: block;"><?= $row['busName'] ?></p>
                        <input type="text" class="bus-Name-field form-control" name="data[busName]" id="busName" placeholder="Business Name" value="<?= $row['busName'] ?>" style="display: none;">

                        <!-- About Us -->
                        <h6 id="aboutHeader"><b>About Us</b></h6>
                        <p id="aboutInput" style="display: block;"><?= $row['about'] ?></p>
                        <input type="text" class="about-field form-control" name="data[about]" id="about" placeholder="Tell something about your business" value="<?= $row['about'] ?>" style="display: none;">

                        <!-- Contact Us -->
                        <h6 id="contactHeader"><b>Contact Us</b></h6>
                        <p id="contactInput" style="display: block;"><?= $row['phone'] ?></p>
                        <input type="text" class="contact-field form-control" name="data[phone]" id="phone" placeholder="(e.g. Links, Contact Numbers, Websites)" value="<?= $row['phone'] ?>" style="display: none;">

                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary" name="updateBusiness" id="saveBusiness" style="display: none;" onclick="toggleEditable()">Save</button>
                            <button type="button" class="btn btn-secondary" id="cancelBusiness" style="display: none;" onclick="toggleEditable()">Cancel</button>
                        </div>
                    </div>

                    <!-- image preview -->
                    <div class="col-md-5">
                        <div class="mb-4 d-flex justify-content-center">
                            <img id="imagePreview" src="<?= $row['busImage'] ? $row['busImage'] : 'https://mdbootstrap.com/img/Photos/Others/placeholder.jpg' ?>" alt="business image" style="max-width: 100%; max-height: 200px;">
                        </div>

                        <div class="d-flex justify-content-center">
                            <div id="filelabel1" class="btn-primary" style="display: none;">
                                <label class="form-label text-white m-1" for="busImage">Choose File</label>
                                <input type="file" class="form-control d-none" id="busImage" name="busImage" accept="image/*" onchange="previewImage(this)">
                            </div>
                        </div>
                        <br>
                    </div>
                </div>

                <?php
                $businessCode = $row['businessCode'];
                // Fetch branch details from the branches table based on the businessCode
                $branchQuery = "SELECT * FROM branches WHERE businessCode = $businessCode";
                $branchResult = $DB->query($branchQuery);

                if ($branchResult->num_rows > 0):
                ?>
                <a href="#branch-details" id="ViewBranch" class="btn-view-branches align-items-center justify-content-center view-branch-button" data-businesscode="<?= $row['businessCode'] ?>" onclick="toggleViewBranch(this, event)">
                    <i class="bi bi-eye"></i>
                    <span>View Branch</span>
                </a>
                <?php endif; ?>

                <br>
                <a href="#add-branch" id="AddBranch" class="btn-add-branch align-items-center justify-content-center add-branch-button" data-businesscode="<?= $row['businessCode'] ?>" onclick="toggleAddBranch(this, event)">
                <i class="bi bi-plus-square"></i>
                <span>Add Branch</span>
            </a>

            </form>
        </div>
    </div>


<!-- Add this in the "add-branch" section -->
<div class="add-branch" id="branch<?= $businessCode ?>" style="display: none;">
    <div class="branch-info card border-0 rounded-5 shadow p-3 mb-5 bg-white rounded" style="height: auto">
        <div class="d-flex justify-content-between p-4">
            <h2>Branch Information</h2>
        </div>
        <form method="post" action="?action=businessAction" enctype="multipart/form-data">
            <input type="hidden" name="add_branch" value="<?= $row['businessCode'] ?>">
            <div class="column d-flex row justify-content-between">
                <div class="col-md-7 flex-column">
                    <h6>Branch Name</h6>
                    <input type="text" class="about-field form-control" name="data[branchName]" placeholder="Tell something about your business" required>
                    <h6>Address</h6>
                    <input type="text" class="about-field form-control" name="data[address]" placeholder="Bldg No., Street, Brgy., City/Province" required>

                    <!-- Coordinates -->
                    <h6>Coordinates</h6>
                    <div>
                        <input type="text" class="about-field form-control" name="data[coordinates]" id="coordinatesInputAddBranch" placeholder="Enter Branch Map Location" required>
                        <button type="button" class="btn btn-primary mt-2" onclick="openMapInAddBranch()">Browse Map</button>
                        <div id="mapAddBranch" style="display: none; height: 400px; width: 700px;"></div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="mb-4 d-flex justify-content-center">
                        <img id="imageAddBranch" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg" alt="business image" style="max-width: 100%; max-height: 200px;">
                    </div>

                    <div class="d-flex justify-content-center">
                        
                            <label class="form-label text-white m-1" for="addBranchImage"></label>
                            <input type="file" class="form-control" id="addBranchImage" name="addBranchImage" accept="image/*" onchange="previewAddBranch(this)">
                        
                    </div>
                    <br>
                </div>

                <div class="mt-4 p-4 d-flex">
                    <button type="submit" button class="btn btn-primary" name=createBranch id="createBranch<?= $branchData['branchCode'] ?>">Create Branch</button>
                    <button type="button" button class="btn btn-secondary" name=cancelCreate id="cancelCreate<?= $branchData['branchCode'] ?>" onclick="hideAddBranch('<?= $businessCode ?>')">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>




<?php if ($branchResult->num_rows > 0): ?>
<!-- View Branch -->
<div class="branch-details" id="branchDetails<?= $businessCode ?>" style="display: none;">
    <?php while ($branchData = $branchResult->fetch_assoc()): ?>
        <div class="branch-info card border-0 rounded-5 shadow p-3 mb-5 bg-white rounded" id="branchDetails_<?= $branchData['branchCode'] ?>">
            <div class="d-flex justify-content-between p-4">
              <h2>Branch Information</h2>
              <a id="editBranch_<?= $branchData['branchCode'] ?>" class="btn-edit float-end mt-4" onclick="toggleEditBranch('<?= $branchData['branchCode'] ?>')">
                <i class="bi bi-pencil-fill"></i>
                <span>Edit</span>
                </a>
            </div>
            
            <form method="post" action="?action=businessAction" enctype="multipart/form-data">
                <input type="hidden" name="branch" value="<?= $row['businessCode'] ?>">
                <input type="hidden" name="branch_Code" value="<?= $branchData['branchCode'] ?>">
                <input type="hidden" name="data[prevBranch]" value="<?= $branchData['branchImage'] ?>">
                <div class="column d-flex row justify-content-between">
                    <div class="col-md-7 flex-column">

                    
                        <!-- Branch Name -->
                        <h6 id="branchNameHeader"><b>Branch Name</b></h6>
                        <p id="branchNameInput_<?= $branchData['branchCode'] ?>" style="display: block;"><?= $branchData['branchName'] ?> </p>
                        <input type="text" class="about-field form-control" name="data[branchName]" id="branchName_<?= $branchData['branchCode'] ?>" placeholder="Tell something about your business" value="<?= $branchData['branchName'] ?>" style="display: none;" >
                        

                        <!-- Address -->
                        <h6 id="addressHeader"><b>Address (Bldg No., Street, Brgy., City/Province)</b></h6>
                        <p id="addressInput_<?= $branchData['branchCode'] ?>" style="display: block;"><?= $branchData['address'] ?> </p>
                        <input type="text" class="about-field form-control" name="data[address]" id="address_<?= $branchData['branchCode'] ?>" placeholder="Tell something about your business" value="<?= $branchData['address'] ?>" style="display: none;">

                       <!-- Coordinates -->
                        <h6 id="coordinatesHeader"><b>Coordinates (Latitude, Longitude)</b></h6>
                        <p id="coordinatesInput_<?= $branchData['branchCode'] ?>" style="display: block;"><?= $branchData['coordinates'] ?> </p>
                        <input type="text" class="about-field form-control" name="data[coordinates]" id="coordinates_<?= $branchData['branchCode'] ?>" placeholder="Enter Branch Map Location" value="<?= $branchData['coordinates'] ?>" style="display: none;">

                        <button type="button" class="btn btn-primary mt-2" id="browseMapButton_<?= $branchData['branchCode'] ?>" style="display: none;" onclick="openMapInBranchDetails('<?= $branchData['branchCode'] ?>')">Browse Map</button>


                        <div id="mapBranchDetails_<?= $branchData['branchCode'] ?>" style="display: none; height: 400px; width: 700px;"></div>

                    </div>

                    <div class="col-md-5">
                        <div class="mb-4 d-flex justify-content-center">
                        <img id="imageBranch_<?= $branchData['branchCode'] ?>" class="imageBranchPreview_<?= $branchData['branchCode'] ?>" src="<?= $branchData['branchImage'] ? $branchData['branchImage'] : 'https://mdbootstrap.com/img/Photos/Others/placeholder.jpg' ?>" alt="branch image" style="max-width: 100%; max-height: 200px;">


                        </div>

                        <div class="d-flex justify-content-center">
                            <div id="filelabel2_<?= $branchData['branchCode'] ?>" class="btn btn-rounded" style="display: none;">
                                <label class="form-label text-white m-1" for="branchImage"></label>
                                <input type="file" class="form-control branchImageInput" name="branchImage" accept="image/*" onchange="previewBranch(this, '<?= $branchData['branchCode'] ?>')">

                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="?page=package&branchcode=<?= $branchData['branchCode'] ?>" class="btn-add-branch align-items-center justify-content-center view-package-button" id="ViewPackage">
                            <i class="bi bi-eye"></i>
                            <span>Add/View Package</span>
                        </a>
                    </div>

                    <div class="mt-4 p-4 d-flex">
                        <button type="submit" button class="btn btn-primary" name="updateBranch" id="saveBranch_<?= $branchData['branchCode'] ?>" style="display: none;"  >Save</button>
                        <button type="submit" button class="btn btn-danger" name="deleteBranch" id="deleteBranch<?= $branchData['branchCode'] ?>" style="display: none;" >Delete</button>
                        <button type="button" button class="btn btn-secondary" id="cancelBranch_<?= $branchData['branchCode'] ?>" style="display: none;" onclick="toggleEditBranch('<?= $branchData['branchCode'] ?>')">Cancel</button>
                    </div>

                </div>
            </form>
        </div>
       
    <?php endwhile; ?>
</div> <!-- end of branch info -->
<?php endif; ?>
<?php endwhile; ?>
</div><!--end of detailsForm-->




<script src="assets/js/user.js"></script>  

<script>
    var mapAddBranch;

    function openMapInAddBranch() {
        if (!mapAddBranch) {
            mapAddBranch = L.map('mapAddBranch').setView([10.7202, 122.5621], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mapAddBranch);

            mapAddBranch.on('click', function (e) {
                updateCoordinatesInputAddBranch(e.latlng.lat, e.latlng.lng);
            });
        }

        var mapDiv = document.getElementById("mapAddBranch");
        mapDiv.style.display = "block";

        mapAddBranch.invalidateSize();
    }

    function closeMapInAddBranch() {
        var mapDiv = document.getElementById("mapAddBranch");
        mapDiv.style.display = "none";
    }

    function updateCoordinatesInputAddBranch(lat, lng) {
        document.getElementById('coordinatesInputAddBranch').value = lat + ', ' + lng;
    }

    var mapBranchDetails = {};

function openMapInBranchDetails(branchCode) {
    if (!mapBranchDetails[branchCode]) {
        mapBranchDetails[branchCode] = L.map('mapBranchDetails_' + branchCode).setView([10.7202, 122.5621], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(mapBranchDetails[branchCode]);

        mapBranchDetails[branchCode].on('click', function (e) {
            updateCoordinatesInputBranchDetails(branchCode, e.latlng.lat, e.latlng.lng);
        });
    }

    var mapDiv = document.getElementById("mapBranchDetails_" + branchCode);
    mapDiv.style.display = "block";

    mapBranchDetails[branchCode].invalidateSize();
}

function closeMapInBranchDetails(branchCode) {
    var mapDiv = document.getElementById("mapBranchDetails_" + branchCode);
    mapDiv.style.display = "none";
}

function updateCoordinatesInputBranchDetails(branchCode, lat, lng) {
    var coordinatesInput = document.getElementById('coordinates_' + branchCode);
    coordinatesInput.value = lat + ', ' + lng;
}

</script>

