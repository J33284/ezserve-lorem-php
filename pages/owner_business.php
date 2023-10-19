<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' );

/*
$userData = viewBusiness($_SESSION['BusinessCode']);

$BusName = $userData->BusName;
$About = $userData->About;
$Contacts = $userData->Contacts;
*/
?>

<?= element( 'header' ) ?>

<?= element( 'owner-side-nav' ) ?>
<script src="assets/js/script.js"></script>

<!--===================================================================-->


<div id= "own-bus"class="own-bus">
        <div class="d-flex justify-content-between p-3">
          <h1>My Business</h1>
          <a href="#" id="registerButton" class="btn-edit btn-lg float-end mt-4 pb-1" onclick="toggleDivision1()">
            <i class="bi bi-plus-square"></i>
            <span>Register your business here!</span>
        </a>
        </div>
        <br>
        <!--nka read only but ma edit if na click ang edit button-->
        <div id="division1" style="display: none;" class="bus-info card border-0 rounded-5 shadow p-3 mb-5 bg-white rounded">
          <div class="d-flex justify-content-between p-4">
            <h2>Business Information</h2>
            <a href="#" id="editButton" class="btn-edit float-end mt-4" onclick="toggleEditBusiness()">
                <i class="bi bi-pencil-fill"></i>
                <span>Edit</span>
             </a>
             
          </div>
          <!-- 2 columns for details and pic-->
          <form method="post">
          <input type="hidden" name="action" value="usersAction">
          <div class="column d-flex row justify-content-between">
            <div class="col-md-7 flex-column">
              <h6>About Us</h6>
              <input type="text" class="bus-Name-field form-control" name="data[busName]" id="busName" placeholder="Business Name" readonly>
              <h6>About Us</h6>
              <input type="text" class="about-field form-control" name="data[about]" id="about" placeholder="Tell something about your business" readonly>
              <h6>Contact Us</h6>
              <input type="text" class="contact-field form-control" name="data[contacts]" id="Contacts" placeholder="(e.g. Links, Contact Numbers, Websites)"  readonly>
            </div>
            
            <!--image preview-->
            <div class="col-md-5">
              <div>
              <div class="mb-4 d-flex justify-content-center">
                  <img src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                  alt="example placeholder" />
              </div>
              <div class="d-flex justify-content-center">
                  <div class="btn btn-primary btn-rounded">
                      <label class="form-label text-white m-1" for="customFile1">Choose file</label>
                      <input type="file" class="form-control d-none" id="customFile1" />
                  </div>
              </div>
          </div>
        </div>
            <a href="#" class="btn-add-branch align-items-center justify-content-center" onclick="toggleDivision2()">
            <i class="bi bi-plus-square"></i>
          <span>Add Branch </span>
        </a>
       </div>
       <div class="mt-4 p-4">
            <button type ="submit" button class="btn btn-primary" id="saveButton" style="display: none;" onclick="saveChanges()">Save</button>
            <button class="btn btn-secondary" id="cancelButton" style="display: none;" onclick="cancelEditBusiness()">Cancel</button>
        </div>
        </form>
</div>




        <div id="division2" style="display: none;" class="branch-info card border-0 rounded-5 shadow p-3 mb-5 bg-white rounded">
        <div class="d-flex justify-content-between p-4">
            <h2>Branch Information</h2>
            <a href="#" id="editButton2" class="btn-edit float-end mt-4" onclick="toggleEdit2()">
                <i class="bi bi-pencil-fill"></i>
              <span>Edit</span>
             </a>
          </div>
          <!-- 2 columns for details and pic-->
          <div class="column d-flex row justify-content-between">
            <div class="col-md-7 flex-column">
              <h6>Branch Name</h6>
              <input type="text" class="form-control" id="fname" placeholder="Branch Name Including Location">
              <h6>Address</h6>
              <input type="text" class="form-control" id="fname" placeholder="House/Building No., Street, City/Province">
              <h6>Coordinates</h6>
              <input type="text" class="form-control" id="fname" placeholder="Coordinates">
            </div>
            <!--image preview-->
            <div class="col-md-5">
              <div>
              <div class="mb-4 d-flex justify-content-center">
                  <img src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                  alt="example placeholder" />
              </div>
              <div class="d-flex justify-content-center">
                  <div class="btn btn-primary btn-rounded">
                      <label class="form-label text-white m-1" for="customFile1">Choose file</label>
                      <input type="file" class="form-control d-none" id="customFile1" />
                  </div>
              </div>
          </div>
        </div>

        <div>
        <a href="./ownpack2.html" class="btn-add-branch align-items-center justify-content-center">
          <i class="bi bi-plus-square"></i>
          <span>Add Package</span>
        </a>
       </div>
       <div class="mt-4 p-4">
            <button class="btn btn-primary" id="saveButton2" style="display: none;" onclick="saveChanges2()">Save</button>
            <button class="btn btn-secondary" id="cancelButton2" style="display: none;" onclick="cancelEdit2()">Cancel</button>
        
        </div>
        </div> <!--end of branch info-->
</div>


<?= element( 'footer' ) ?>
        
