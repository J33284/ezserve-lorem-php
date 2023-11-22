<div id="detailsForm" class="detailsForm card border-0 rounded-5 shadow p-3 mb-5 bg-white rounded" style="width: 75vw; display:none;">
    <div class="business-details d-flex justify-content-between p-3" id="businessDetails<?= $row['businessCode'] ?>" style="display: none;">
        <h2>Business Information</h2>
        <div class="d-flex" style="position: absolute; top: 5%; right: 5%;">
            <a href="#" id="editButton" class="btn-edit float-end mt-4" onclick="toggleEditable()">
            <i class="bi bi-pencil-fill"></i>
                    <span>Edit</span>
            </a>
        </div>
        <br>
        <!-- 2 columns for details and pic -->
        <form method="post" action="?action=businessAction" enctype="multipart/form-data" >
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
                    <div>
                        <div class="mb-4 d-flex justify-content-center">
                            <img id="imagePreview" src="<?= $row['busImage'] ? $row['busImage'] : 'https://mdbootstrap.com/img/Photos/Others/placeholder.jpg' ?>" alt="business image" style="max-width: 100%; max-height: 200px;">
                        </div>

                        <div class="d-flex justify-content-center">
                            <div id= "filelabel1" class="btn btn-primary btn-rounded" style ="display: none;">
                                <label class="form-label text-white m-1" for="busImage">Choose file</label>
                                <input type="file" class="form-control d-none" id="busImage" name="busImage" accept="image/*" onchange="previewImage(this)">
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <?php
                $businessCode = $row['businessCode'];
                // Fetch branch details from the branches table based on the businessCode
                $branchQuery = "SELECT * FROM branches WHERE businessCode = $businessCode";
                $branchResult = $DB->query($branchQuery);

                if ($branchResult->num_rows == 0);
                {
                    
                }
                ?>

                </div>
                <?php if ($branchResult->num_rows > 0): ?>
                    <a href="#branch-details" id="ViewBranch" class="btn-view-branches align-items-center justify-content-center view-branch-button" data-businesscode="<?= $row['businessCode'] ?>" onclick="toggleViewBranch(this)">
                        <i class="bi bi-eye"></i>
                        <span>View Branch</span>
                    </a>
                <?php endif; ?>

                <br>
                <a href="#add-branch" id="AddBranch" class="btn-add-branch align-items-center justify-content-center add-branch-button" data-businesscode="<?= $row['businessCode'] ?>" onclick="toggleAddBranch(this)">
                    <i class="bi bi-plus-square"></i>
                    <span>Add Branch</span>
                </a>
        </form>
    </div>
</div>


<div class="add-branch" id="branch<?= $businessCode ?>" style="display: none;">
    <div class="branch-info card border-0 rounded-5 shadow p-3 mb-5 bg-white rounded">
        <div class="d-flex justify-content-between p-4">
            <h2>Branch Information</h2>
        </div>
        <form method="post" action="?action=businessAction" enctype="multipart/form-data">
            <input type="hidden" name="add_branch" value="<?= $row['businessCode'] ?>">
            <div class="column d-flex row justify-content-between">
                <div class="col-md-7 flex-column" style="height: 300px;">
                    <h6>Branch Name</h6>
                    <input type="text" class="about-field form-control" name="data[branchName]" placeholder="Tell something about your business">
                    <h6>Address</h6>
                    <input type="text" class="about-field form-control" name="data[address]" placeholder="Bldg No., Street, Brgy., City/Province">
                    <h6>Coordinates</h6>
                    <input type="text" class="about-field form-control" name="data[coordinates]" placeholder="Enter Branch Map Location">
                </div>
                <div class="col-md-5">
                    <div>
                        <div class="mb-4 d-flex justify-content-center">
                            <img src="" alt="Preview" id="imagePreview" style="max-width: 100%; max-height: 200px; display: none;" />
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="btn btn-primary btn-rounded">
                                <label class="form-label text-white m-1" for="branchImage">Choose file</label>
                                <input type="file" class="form-control d-none" name="branchImage" id="branchImage" onchange="previewImage(this)" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-4 d-flex">
                    <button type="submit" button class="btn btn-primary" name=createBranch id="createBranch<?= $branchData['branchCode'] ?>" style="display: block;" onclick="toggleAddBranch()">Create Branch</button>
                    <button type="button" button class="btn btn-secondary" name=cancelCreate id="cancelCreate<?= $branchData['branchCode'] ?>" style="display: block;" onclick="toggleAddBranch()">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>



<?php if ($branchResult->num_rows > 0): ?>
<!-- View Branch -->
<div class="branch-details" id="branchDetails<?= $businessCode ?>" style="display: none;">
    <?php while ($branchData = $branchResult->fetch_assoc()): ?>
        <div class="branch-info card border-0 rounded-5 shadow p-3 mb-5 bg-white rounded">
            <div class="d-flex justify-content-between p-4">
                <h2>Branch Information</h2>
                <a href="#" id="editBranch<?= $branchData['branchCode'] ?>" class="btn-edit float-end mt-4" onclick="toggleEditBranch(<?= $branchData['branchCode'] ?>)">
                    <i class="bi bi-pencil-fill"></i>
                    <span>Edit</span>
                </a>
            </div>
            <form method="post" action="?action=businessAction">
                <input type="hidden" name="branch" value="<?= $row['businessCode'] ?>">
                <input type="hidden" name="branch_Code" value="<?= $branchData['branchCode'] ?>">
                <div class="column d-flex row justify-content-between">
                    <div class="col-md-7 flex-column">
                        <h6>Branch Name</h6>
                        <input type="text" class="about-field form-control" name="data[branchName]" id="branchName<?= $branchData['branchCode'] ?>" placeholder="Tell something about your business" value="<?= $branchData['branchName'] ?>" readonly>
                        <h6>Address (Bldg No., Street, Brgy., City/Province)</h6>
                        <input type="text" class="about-field form-control" name="data[address]" id="address<?= $branchData['branchCode'] ?>" placeholder="Tell something about your business" value="<?= $branchData['address'] ?>" readonly>
                        <h6>Coordinates</h6>
                        <input type="text" class="about-field form-control" name="data[coordinates]" id="coordinates<?= $branchData['branchCode'] ?>" placeholder="Tell something about your business" value="<?= $branchData['coordinates'] ?>" readonly>
                    </div>
                    <div class="col-md-5">
                        <div>
                            <div class="mb-4 d-flex justify-content-center">
                            <?php
                            $imageFile = $branchData['imageFile'];
                            $imagePath = "assets/uploads/branches/{$imageFile}";
                            
                            // Check if the image file exists
                            if (file_exists($imagePath)) {
                                ?>
                                <img src="<?= $imagePath ?>" alt="Branch Image" />
                                <?php
                            } else {
                                ?>
                               <img id="imagePreview" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg" alt="example placeholder" style="max-width: 100%; max-height: 200px;">
                                <?php
                            }
                            ?>

                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="btn btn-primary btn-rounded">
                                    <label class="form-label text-white m-1" for="busImage">Choose file</label>
                                    <input type="file" class="form-control d-none" id="busImage" name="busImage" accept="image/*" onchange="previewImage(this)" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <a href="?page=package&branchcode=<?= $branchData['branchCode'] ?>" class="btn-add-branch align-items-center justify-content-center view-package-button" id="ViewPackage">
                            <i class="bi bi-eye"></i>
                            <span>View/Add Package</span>
                        </a>
                    </div>

                    <div class="mt-4 p-4 d-flex">
                        <button type="submit" button class="btn btn-primary" name=updateBranch id="updateBranch<?= $branchData['branchCode'] ?>" style="display: none;" onclick="toggleEditBranch()">Save</button>
                        <button type="button" button class="btn btn-secondary" id="cancelBranch<?= $branchData['branchCode'] ?>" style="display: none;" onclick="toggleEditBranch()">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
       
    <?php endwhile; ?>
</div> <!-- end of branch info -->
<?php endif; ?>


<script>
    function previewImage(input) {
        console.log('Function called');
        var preview = document.getElementById('imagePreview');
        console.log('File:', input.files);

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onloadend = function () {
                console.log('Read successful');
                preview.src = reader.result;
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            console.log('No file selected or no files support');
            preview.src = "https://mdbootstrap.com/img/Photos/Others/placeholder.jpg";
        }
    }
</script>



