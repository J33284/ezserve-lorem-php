<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$branchCode = $_GET['branchCode'];
$businessCode = $_GET['businessCode'];

// Retrieve all branches for the given business
$branchesQ = $DB->query("SELECT br.*, p.*
  FROM branches br
  JOIN package p ON br.branchCode = p.branchCode
  WHERE br.branchCode = '$branchCode'");

// Check if the query was successful before trying to fetch data
if ($branchesQ) {
    // Fetch the first row (branch) from the result set
    $branch = $branchesQ->fetch_assoc();
}
?>

<style>
    html {
        scroll-padding-top: 250px;
    }
</style>


<?= element('header') ?>

<?php if ($branchesQ->num_rows > 0): ?>
<div class="mb-5" style="height: 100vh">

    <div class=" container pack-head sticky-top card p-3">
        <div class=" row d-flex justify-content-center align-items-center">
            <a href="?page=client_business_details&businessCode=<?= $businessCode ?>" class=" col-lg-1 col-sm-1 btn-back btn-lg justify-content-center align-items-center d-flex text-dark">
                <i class="bi bi-arrow-left"></i></a>
            <h1 class="col-lg-6 col-sm-6 d-flex justify-content-start "> <?= $branch['branchName'] ?></h1>

            <h4 class="col-lg-5 col-sm-5 mx-35"> <?= $branch['address'] ?> </h4>
        </div>
    </div>

    <div id="pack" class="pack row" style="margin: 150px 0px 0px 100px;">

        <div class="col-7">

            <h3 class="text-light mb-3"> Pre-made Packages</h3>

            <?php
            // Fetch services for the selected branch
            $packageQ = $DB->query("SELECT p.*
              FROM package p
              WHERE p.branchCode = '$branchCode'");

            // Check if the query was successful before trying to fetch data
            if ($packageQ) {
                while ($package = $packageQ->fetch_assoc()) {
                    ?>
                    <div class="d-flex" id ="<?=$package['packCode'] ?>" >
                                <?php
                                  // Fetch services for the selected branch
                                  $packCode = $package['packCode'];

                                  $categoryQ = $DB->query("SELECT p.*, c.*
                                      FROM package p
                                      JOIN category c ON p.packCode = c.packCode
                                      WHERE p.packCode = '$packCode' LIMIT 1");

                                  // Check if the query was successful before trying to fetch data
                                  if ($categoryQ) {
                                      $category = $categoryQ->fetch_assoc();

                                      // The rest of your code remains unchanged
                                  }

                                ?>
        
                        <div class="card flex-row h-auto  m-3 shadow p-3 mb-5 bg-white rounded border-0" id = "<?= $category['categoryCode'] ?>" style="width: 100%">
                                  <div class="col-4 h-50">
                                    <img  src="" alt="Card image cap">
                                </div>
                             
                            <div class="col-8 py-4">
                                <h5 > <?= $package['packName'] ?> </h5>
                                <?php
                                  // Fetch services for the selected branch
                                  $categoryCode = $category['categoryCode'];

                                  $serviceQ = $DB->query("SELECT c.*, i.*
                                      FROM category c
                                      JOIN items i ON c.categoryCode = i.categoryCode
                                      WHERE c.categoryCode = '$categoryCode' LIMIT 1");

                                  // Check if the query was successful before trying to fetch data
                                  if ($serviceQ) {
                                      $service = $serviceQ->fetch_assoc();

                                      // The rest of your code remains unchanged
                                  }

                                ?>
                                
                                <a href="?page=client_view_package&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?= $package['packCode'] ?>" class="btn btn-primary">View</a>

                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        
        <div class="col-4">
            <h3 class="text-dark"> Create Custom Package</h3>
            <br>
            <p class="text-dark"><b>Can't find the perfect package? Create your own!</b><br>
                <br> With our custom package builder, you can choose exactly what you want, from the number of items
                and categories of items. We'll even work with you to create a custom price that fits your budget.</p>
            <br>
            <form action="?page=Client_custom" method="post">
                <input type="hidden" name="branchCode" value="<?= $branch['branchCode'] ?>">
                <input type="hidden" name="packageCode" value="<?= $branch['packCode'] ?>">
                <button type="submit" class="btn " data-bs-business-code="<?= $branch['branchCode'] ?>">
                    <i class="bi bi-plus-square text-dark"></i>
                    <span class="text-dark">create your own package!</span>
                </button>
            </form>

        </div>
    </div>

</div>
<?php endif; ?>

<?php if ($branchesQ->num_rows == 0): ?>
    
    
    <div class="d-flex justify-content-center align-items-center p-3" style="height: 50vh;">
          <div class="card rounded-1 border-0 p-4 flex-row">
                 <i class="bi bi-exclamation-diamond mx-2 justify-content-center align-items-center d-flex"></i>
                  <span >No Packages Available Yet!!</span>
            
          </div>
      </div>
  </div>

    
<?php endif; ?>


