<div class="bus-reg container row justify-content-center align-items-center">
        
      <div class="card justify-content-between border-0 shadow p-3 mb-5 bg-white rounded">
          <div class="card-body ">
                  
            <h1>Business Registration</h1>
            <hr>
            <form method="post">
            <input type="hidden" name="action" value="usersAction">
            <div class="row g-3 p-3">
              <h5>Owner Information</h5>
              <input type="text" class="form-control " name="data[ownerName]" id="ownerName" placeholder="Owner Name">
              <input type="text" class="form-control " name="data[ownerAddress]" id="ownerAddress" placeholder="Owner's Adress">
              <h5>Business Information</h5>
              <input type="text" class="form-control " name="data[busName]" id="busName" placeholder="Business Name">
              <div class=" row pt-3">
                <p class="col-sm-4">Business Activity</p>
                <select class="select col-sm-4 mb-3" name="data[busType]" required>>
                    <option value="" selected disabled>Select</option>
                    <option value="1">Funeral Services</option>
                    <option value="2">Catering</option>
                    <option value="3">Photography</option>
                </select>
            </div>
              <h6 class="page-title">Business Address</h5>
                <p class="note">*Address of the Main Branch</p>
                <div class="overflow-hidden">
                <div class="row g-3">
                  <div class="col">
                    <input type="text" class="form-control" name="data[house_building]" id="house_building" placeholder="House/Building No. & Name" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" name="data[street]" id="street" placeholder="Street" >
                  </div>
                </div>
                <div class="row g-3 ">
                  <div class="col">
                    <input type="text" class="form-control col" name="data[house_building]" id="email" placeholder="Barangay" >
                  </div>
                  <div class="col">
                    <input type="text" class="form-control col" name="data[city_municipality]" id="email" placeholder="City/Municipality"required>
                  </div>
                </div>
                <div class="row g-3">
                  <div class="col">
                    <input type="text" class="form-control col" name="data[province]" id="email" placeholder="Province"required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control col" name="data[region]" id="email" placeholder="Region" required>
                  </div>
                </div>
                <div class="row g-3">
                  <div class="col">
                    <input type="text" class="form-control col" name="data[phone]" id="email" placeholder="Phone Number" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control col" name="data[mobile]" id="email" placeholder="Mobile Number" required>
                  </div>
                </div>
                <div class="mt-2">
                    <input type="text" class="form-control col" name="data[coordinates]" id="email" placeholder="Coordinates">
                  </div>
                </div>
                <div class="p-0">
                  <h6 class="page-title">Upload Business Permits</h6>
                  <input class="form-control mt-3" name="data[permits]" type="file" id="formFile">
                </div>
                
              <button type="submit" class="btn btn-primary mt-5">Submit</button>              
            </div>
        </div>
    </form>
              </div>
          </div>
      </div>