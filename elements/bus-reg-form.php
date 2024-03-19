<?php
global $DB;
$businessesResult = $DB->query("SELECT * FROM businesstypes");

?>

<div class="bus-reg container row justify-content-center align-items-center">
    <div id="reg-form" class="card justify-content-between border-0 shadow p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <h1>Business Registration</h1>
            <hr>
            <form method="post" enctype="multipart/form-data"> <!-- Add enctype attribute for file upload -->
                <input type="hidden" name="action" value="ownerAction">
                <div class="row g-3 p-3">
                    <h5>Owner Information</h5>
                    <?php
                        $userData = viewUser($_SESSION['userID']);
                        $fname = $userData->fname;
                        $lname = $userData->lname;
                        $ownerAddress = $userData->ownerAddress;
                    ?>
                    <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name"  readonly value="<?php echo $fname," ", $lname; ?>">
                    <input type="text" class="form-control" name="data[ownerAddress]" id="ownerAddress" placeholder="Owner's Address" readonly value="<?php echo $ownerAddress;?>">
                    <h5>Business Information</h5>
                    <input type="text" class="form-control" name="data[busName]" id="busName" placeholder="Business Name">
                    <div class="row pt-3">
                    <p class="col-sm-4">Business Type</p>
                        <select class="select col-sm-4 mb-3" name="data[busType]" required>
                            <option value="" selected disabled>Select</option>
                            <?php while ($businessType = $businessesResult->fetch_assoc()) : ?>
                                <option value="<?= $businessType['typeName'] ?>"><?= $businessType['typeName'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <h6 class="page-title">Business Address</h6>
                    <p class="note">*Address of the Main Branch</p>
                    <div class="overflow-hidden">
                        <div class="row g-3">
                            <div class="col">
                                <input type="text" class="form-control" name="data[house_building]" id="house_building" placeholder="House/Building No. & Name" >
                            </div>
                            <div class="col">
                                <input type text class="form-control" name="data[street]" id="street" placeholder="Street" >
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <input type="text" class="form-control col" name="data[barangay]" id="barangay" placeholder="Barangay">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control col" name="data[city_municipality]" id="city_municipality" placeholder="City/Municipality" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <input type="text" class="form-control col" name="data[province]" id="province" placeholder="Province" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control col" name="data[region]" id="region" placeholder="Region" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <input type="number" class="form-control col" name="data[phone]" id="phone" placeholder="Phone Number" >
                            </div>
                            <div class="col">
                                <input type="number" class="form-control col" name="data[mobile]" id="mobile" placeholder="Mobile Number" >
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-0">
                        <h6 class="page-title text-light">Upload Business Permits <br> (Allowed File Types: pdf, jpeg, jpg, png)</h6>
                        <div class="row align-items-center d-flex justify-content-center">
                            <span class="col-3">Business Permit</span>
                            <input class="col form-control mt-3" name="business" type="file" id="formFile" required>
                        </div>
                        <div class="row align-items-center d-flex justify-content-center">
                            <span class="col-3">Tax Permit</span>
                            <input class="col form-control mt-3" name="tax" type="file" id="formFile" required>
                        </div>
                        <div class="row align-items-center d-flex justify-content-center">
                            <span class="col-3">Health and Sanitary Permit</span>
                            <input class="col form-control mt-3" name="sanitary" type="file" id="formFile" required>
                        </div>
                    </div>
                        <!-- Add Permit Button -->
                        <button type="button" class="btn btn-secondary mt-3" id="addPermitBtn">Add Permit</button>

                        <!-- Container to hold dynamically added permit fields -->
                        <div id="permitFieldsContainer">
                        </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="termsCheckbox" name="termsCheckbox" required>
                        <label class="form-check-label" for="termsCheckbox">
                            I have read and agree to the <a href="#termsModal" data-bs-toggle="modal">Terms and Conditions</a>
                        </label>
                    </div>
                        
                        <button type="submit" class="btn btn-primary mt-5">Submit</button>

                        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <h1>Terms and Conditions</h1>

                                        <p><strong>1. Acceptance of Terms</strong></p>
                                        <p>By accessing and using this website, you agree to comply with and be bound by these terms and conditions. If you do not agree with any part of these terms, you should not use this website.</p>

                                        <p><strong>2. User Eligibility</strong></p>
                                        <p>You must be at least 18 years old to use this website. By using the website, you confirm that you are at least 18 years old and have the legal capacity to enter into this agreement.</p>

                                        <p><strong>3. Business Legality Confirmation</strong></p>
                                        <p>Users are required to provide accurate and up-to-date information regarding the legality of their business. Any false information provided may result in the termination of the user's account.</p>

                                        <p><strong>4. Intellectual Property</strong></p>
                                        <p>All content and materials on this website, including but not limited to text, images, logos, and designs, are the property of EzServe and are protected by intellectual property laws. Users may not use, reproduce, or distribute any content without permission.</p>

                                        <p><strong>5. Privacy Policy</strong></p>
                                        <p>The collection and use of personal information are governed by our <a href="#privacy-policy">Privacy Policy</a>, which is incorporated into these terms by reference.</p>

                                        <p><strong>6. Compliance with Laws</strong></p>
                                        <p>Users are responsible for complying with all applicable laws and regulations in their use of the website. EzServe is not liable for any illegal activities conducted by users.</p>

                                        <p><strong>7. Disclaimer of Warranties</strong></p>
                                        <p>This website is provided "as is" without any warranties, expressed or implied.EzServe does not guarantee the accuracy, completeness, or reliability of the content.</p>

                                        <p><strong>8. Limitation of Liability</strong></p>
                                        <p>EzServe shall not be liable for any direct, indirect, incidental, consequential, or punitive damages arising out of or related to the use of this website.</p>

                                        <p><strong>9. Termination</strong></p>
                                        <p>EzServe reserves the right to terminate or suspend a user's account at any time for violation of these terms.</p>

                                        <p><strong>10. Changes to Terms</strong></p>
                                        <p>EzServe may revise these terms and conditions at any time without notice. By using this website, you agree to be bound by the current version of these terms.</p>

                                        <p><strong>11. Governing Law</strong></p>
                                        <p>These terms and conditions are governed by and construed in accordance with the laws of Republic of the Philippines.</p>

                                        <p>If you have any questions or concerns about these terms and conditions, please contact us at officialezserve@gmail.com</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>





<script>
    document.getElementById('addPermitBtn').addEventListener('click', function() {
        var permitFieldsContainer = document.getElementById('permitFieldsContainer');

        var permitDropdown = document.createElement('select');
        permitDropdown.classList.add('form-control', 'mb-3');
        permitDropdown.name = 'permits[]'; 
        permitDropdown.required = true;
        var permitOptions = ['Clearance', 'BIR', 'ECC', 'Fire and Safety', 'SEC']; 
        permitOptions.forEach(function(optionText) {
            var option = document.createElement('option');
            option.value = optionText;
            option.text = optionText;
            permitDropdown.appendChild(option);
        });

        var permitFileInput = document.createElement('input');
        permitFileInput.classList.add('form-control', 'mt-3');
        permitFileInput.type = 'file';
        permitFileInput.name = 'permit_files[]'; 
        permitFileInput.required = true;

        permitFieldsContainer.appendChild(permitDropdown);
        permitFieldsContainer.appendChild(permitFileInput);
    });
</script>
