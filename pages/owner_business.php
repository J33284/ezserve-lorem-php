<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' );?>

<?= element( 'header' ) ?>

<?= element( 'owner-side-nav' ) ?>
<script src="assets/js/script.js"></script>

<!--===================================================================-->


<div id= "own-bus"class="own-bus">
        <div class="d-flex justify-content-between p-3">
          <h1>My Business</h1>
          <a href="?page=bus-register">
          <i class="bi bi-plus-square"></i>
          <span>Register your business here!</span>
        </a>
        </div>
        <br>
        <div id="division1"  class="bus-info card border-0 rounded-5 shadow p-3 mb-5 bg-white rounded">
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

<div id= "owner-edit-pack"class="owner-edit-pack mb-3 row d-flex">
        <div class="col-5 card py-5 mx-4 px-4">
          <h2>Pre-made Packages</h2>
          <h6>This section lets you create pre-made packages for your customers. </h6>
          <div class="accordion " id="accordionFlushExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  Package No. 1  <!--change to input field-->
                </button>
              </h2>
              <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  <!-- inner accordion -->
                  <table class="table table-hover table-responsive">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>De barra Metal</th> <!--change to input field-->
                        <td>metal na lungon</td><!--change to input field-->
                        <td>1</td><!--change to input field-->
                        <td>20,000</td><!--change to input field-->
                      </tr>
                      <tr>
                        <th>Barong Tagalog</th>
                        <td>medium size</td>
                        <td>1</td>
                        <td>800</td>
                      </tr>
                    </tbody>
                  </table>
               
                  <div class="m-3" >
                    <a href="#" class="btn-edit btn-lg mt-4">
                      <i class="bi bi-plus-square"></i>
                      <span>Add Item</span> <!--triggers another row in table-->
                  </a>
                </div></div>
              </div>
            </div>
           </div>
         
            <div class="m-3" >
              <a href="#" class="btn-edit btn-lg mt-4">
                <i class="bi bi-plus-square"></i>
                <span>Add Another Package</span> <!--triggers another accordion-->
            </a>

            
        </div>
        </div>
        <div class="col-5 card py-5 mx-4 px-4">
          <h2>Custom Package</h2>
          <h6 class="mb-3">This section lets you create a list of all items which your customers can customize.</h6>
          <div class="accordion mb-3" id="accordion-custom">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-custom-heading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-custom-one" aria-expanded="false" aria-controls="flush-collapseOne">
                  Coffin Style  <!--change to input field-->
                </button>
              </h2>
              <div id="flush-custom-one" class="accordion-collapse collapse" aria-labelledby="flush-custom-heading" data-bs-parent="#accordion-custom">
                <div class="accordion-body">
                  <table class="table table-hover table-responsive">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>De barra Metal</th><!--change to input field-->
                        <td>metal na lungon</td><!--change to input field-->
                        <td>1</td><!--change to input field-->
                        <td>20,000</td><!--change to input field-->
                      </tr>
                      <tr>
                        <th>De Barra Wood</th>
                        <td>Wood na lungon</td>
                        <td>1</td>
                        <td>20,000</td>
                      </tr>
                    </tbody>
                  </table>
                   <div class="m-3" >
                    <a href="#" class="btn-edit btn-lg mt-4">
                      <i class="bi bi-plus-square"></i>
                      <span>Add Variety</span> <!--triggers another row in table-->
                  </a>
                </div>
                 
              
              </div>
              </div>
              
            </div>
            <div class="m-3" >
              <a href="#" class="btn-edit btn-lg mt-4">
                <i class="bi bi-plus-square"></i>
                <span>Add Category</span> <!--triggers another row in table-->
            </a>
          </div>
           </div>
        </div>
        </div>

<?= element( 'footer' ) ?>
        
