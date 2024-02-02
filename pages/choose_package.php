<?= element( 'header' ) ?>
<?= element( 'owner-side-nav' ) ?>
<?php
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';

// Check if both businessCode and branchCode are provided
if (!empty($businessCode) && !empty($branchCode)) {
    // Use parameterized query to prevent SQL injection
    $stmt = $DB->prepare("SELECT br.* FROM branches br WHERE br.businessCode = ? AND br.branchCode = ?");
    $stmt->bind_param("ss", $businessCode, $branchCode);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Fetch the branch details
        $branch = $result->fetch_assoc();
    } else {
        // Handle the case when the branch is not found
        echo "Branch not found.";
        exit; // Stop further execution
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // Handle the case when businessCode or branchCode is not provided
    echo "Business code or branch code not provided.";
    exit; // Stop further execution
}
?>
<div class="choosePackage"  style=" margin: 120px 0 0 25%; width: 90vw;">

        <div class="package-details">
              <div class="justify-items-center align-items-center d-flex row mb-4">
                  <a href="?page=branches&branchCode=<?= $branchCode ?>" class=" col-1 btn-back btn-md text-dark float-center d-flex">
                      <i class="bi bi-arrow-left"></i>
                  </a>
                  <h1 class="d-flex justify-content-start align-items-center col-8"><?= $branch['branchName'] ?> </h1>
              </div>

                <div class="package-details card p-4 mb-3" style="width: 60vw">
                <h2>Pre-made Packages</h2>
                <h6>This section lets you create pre-made packages for your customers.</h6>
                <div class="accordion" id="accordionFlushExample">
                  <div class="m-3">
                    <a href="?page=package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="btn-edit btn-md mt-4 text-dark">
                      <i class="bi bi-eye"></i>
                      <span>View Package</span>
                    </a>
                  <br>
                    <a href="?page=add_package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="btn-edit btn-md mt-4 text-dark">
                      <i class="bi bi-plus-square"></i>
                      <span>Add Package</span>
                    </a>
                  </div>
                </div>
              </div>

        </div>

        <div class="custom-details"  >
    <div class="d-flex align-items-center" >
      <div class="package-details col-5 card p-4" style="width: 60vw">
        <h2>Custom Items</h2>
        <h6>This section lets you create custom packages for your customers.</h6>
        <div class="accordion" id="accordionFlushExample">
          <div class="m-3">
            <a href="?page=custom_package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="btn-edit btn-md mt-4 text-dark">
              <i class="bi bi-eye"></i>
              <span>View Custom Items</span>
            </a>
            <br>
            <a href="?page=add_custom_package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="btn-edit btn-md mt-4 text-dark">
              <i class="bi bi-plus-square"></i>
              <span>Add Custom Items</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>




