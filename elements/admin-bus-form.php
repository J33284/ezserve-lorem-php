
    <div id="reg-form" class="card justify-content-between border-0 shadow p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <h1>Business Registration</h1>
            <hr>
            <form> 
                    <h5 class=" text-light bg-info">Owner Information</h5>
                    <div class="row d-flex align-items-center mb-2">
                        <label class="mb-2 col-3" for="ownerName">Owner's Name</label>
                        <input type="text" class="form-control col" name="data[ownerName]" id="ownerName" readonly>
                    </div>
                    <div class="row d-flex align-items-center mb-2">
                        <label class="mb-2 col-3" for="ownerAdress">Owner's Address</label>
                        <input type="text" class="form-control col" name="data[ownerAddress]" id="ownerAddress"readonly>
                    </div>
                    
                    <h5 class=" text-light bg-info">Business Information</h5>
                    <div class="row d-flex align-items-center mb-2">
                        <label class="mb-2 col-3" for="busName">Business Name</label>
                        <input type="text" class="form-control col" name="data[busName]" id="busName"readonly>
                    </div>
                    <div class="row d-flex align-items-center mb-2">
                        <label class="mb-2 col-3" for="busType">Business Type</label>
                        <input type="text" class="form-control col" name="data[busType]" id="busType"readonly>
                    </div>
                    
                    <h6 class=" text-light bg-info">Business Address</h6>
                    <p class="note mb-3">*Address of the Main Branch</p>
                        <div class="row mb-2">
                            <label class=" col-4" for="house-building">House/Building No. & Name</label>
                            <input type="text" class="form-control col" name="data[house_building]" id="house_building"  readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="street">Street</label>
                            <input type="text" class="form-control col" name="data[street]" id="street" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="barangay">Barangay</label>
                            <input type="text" class="form-control col" name="data[barangay]" id="barangay" readonly>
                        </div> 
                        <div class="row mb-2">
                            <label class="col-4" for="city_municipality">City/ Municipality</label>
                            <input type="text" class="form-control col" name="data[city_municipality]" id="city_municipality" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="province">Province</label>
                            <input type="text" class="form-control col" name="data[province]" id="Province" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="region">Region</label>
                            <input type="text" class="form-control col" name="data[region]" id="region" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="phone">Telephone Number</label>
                            <input type="text" class="form-control col" name="data[phone]" id="phone" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="mobile">Mobile Number</label>
                            <input type="text" class="form-control col" name="data[mobile]" id="mobile" readonly>
                        </div>
                        <div class="row mb-2">
                            <label class="col-4" for="coordinates">Coordinates</label>
                            <input type="text" class="form-control col" name="data[coordinates]" id="coordinates" readonly>
                        </div>
                        <div class="p-0">
                            <h6 class="text-light bg-info">Business Permits</h6>
                            <input class="form-control mt-3" name="permits" type="file" id="formFile"> <!-- Modify the name attribute to "permits" -->
                        </div>
                    </div>
                   

                </div>
            </form>
        </div>
    </div>

