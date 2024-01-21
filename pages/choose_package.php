<?= element( 'header' ) ?>
<?= element( 'owner-side-nav' ) ?>
<?php
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
?>

<div class="package-details"  style="display: block;">
    <div class="d-flex align-items-center" style="height: 100px; margin-top: 170px; margin-left: 390px; width: 140%;">
      <div class="package-details col-5 card py-5 mx-4 px-4">
        <h2>Pre-made Packages</h2>
        <h6>This section lets you create pre-made packages for your customers.</h6>
        <div class="accordion" id="accordionFlushExample">
          <div class="m-3">
            <a href="?page=package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="btn-edit btn-lg mt-4">
              <i class="bi bi-eye"></i>
              <span>View Package</span>
            </a>
           <br>
            <a href="?page=add_package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="btn-edit btn-lg mt-4">
              <i class="bi bi-plus-square"></i>
              <span>Add Package</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="custom-details"  style="display: block;">
    <div class="d-flex align-items-center" style="height: 200px; margin-top: 120px; margin-left: 390px; width: 140%;">
      <div class="package-details col-5 card py-5 mx-4 px-4">
        <h2>Custom Items</h2>
        <h6>This section lets you create custom packages for your customers.</h6>
        <div class="accordion" id="accordionFlushExample">
          <div class="m-3">
            <a href="?page=custom_package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="btn-edit btn-lg mt-4">
              <i class="bi bi-eye"></i>
              <span>View Custom Items</span>
            </a>
            <br>
            <a href="?page=add_custom_package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="btn-edit btn-lg mt-4">
              <i class="bi bi-plus-square"></i>
              <span>Add Custom Items</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>



