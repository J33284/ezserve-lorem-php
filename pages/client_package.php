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



<?= element('header') ?>

<?php if ($branchesQ->num_rows > 0): ?>
<div class="mb-5" style="height: 100vh">

    <div class=" container pack-head sticky-top card p-3" style="height: auto; width: auto;">
        <div class=" head "> 
            <a href="?page=client_business_details&businessCode=<?= $businessCode ?>" class="  btn-back btn-lg justify-content-start align-items-center d-flex text-dark ">
                <i class="bi bi-arrow-left"></i></a>
            <h1 class="justify-content-start mb-3 "> <?= $branch['branchName'] ?></h1>

            <h4 class="align-items-center justify-content-center d-flex m-0"> <?= $branch['address'] ?> </h4>
        </div>
    </div>

    <div id="pack" class="pack " >

        <div class=" pre-made col-lg-6 col-md-12">

            <h3 class="text-dark mb-3"> Pre-made Packages</h3>

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

                                  $itemQ = $DB->query("SELECT p.*, i.*
                                      FROM package p
                                      JOIN items i ON p.packCode = i.packCode
                                      WHERE p.packCode = '$packCode' LIMIT 1");

                                  // Check if the query was successful before trying to fetch data
                                  if ($itemQ) {
                                      $item = $itemQ->fetch_assoc();

                                      // The rest of your code remains unchanged
                                  }

                                ?>
        
                        <div class="card flex-row h-auto w-auto m-3 shadow p-3 mb-5 bg-white rounded border-0" id = "<?= $category['categoryCode'] ?>" style="width: 100%">
                                  <div class="packImg" >
                                    <img  style="width: 10rem;" src="assets/images/package-icon.png" alt="Card image cap">
                                </div>
                             
                            <div class="packname" style="width:50vw">
                                <h5 > <?= $package['packName'] ?> </h5>
                                <?php
                                  // Fetch services for the selected branch
                                  $itemCode = $item['itemCode'];

                                  $item_detailsQ = $DB->query("SELECT i.*, d.*
                                      FROM items i
                                      JOIN item_details d ON i.itemCode = d.itemCode
                                      WHERE i.itemCode = '$itemCode' LIMIT 1");

                                  // Check if the query was successful before trying to fetch data
                                  if ($item_detailsQ) {
                                      $item_details = $item_detailsQ->fetch_assoc();

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
        
        <div class="col-lg-4 col-md-12">
            <h3 class="text-dark"> Create Custom Package</h3>
            <br>
            <p class="text-dark"><b>Can't find the perfect package? Create your own!</b><br>
                <br> With our custom package builder, you can choose exactly what you want, from the number of items
                and categories of items. We'll even work with you to create a custom price that fits your budget.</p>
            <br>
            <form action="?page=client_custom&businessCode=<?=$businessCode?>&branchCode=<?= $branch['branchCode'] ?>" method="post">
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


<style>
    html {
        scroll-padding-top: 250px;
    
    }
    @media (max-width:1700px) {
     
     .head {
         display: flex;
        flex-direction: row;
        margin: 20px;
     }   
     .head h1{
        margin: 0 70px 0 20px;
     }
     .pack{
        display: flex;
        flex-direction: row;
        margin: 150px 0px 0px 100px;
     }
     .pre-made{
        margin-right: 20px;
     }
     }

    @media (max-width:700px) {
     
    .head {
        display: flex;
        flex-direction: column;
        margin:0;
    }   
    .head h1{
        margin: 0;
    }
    .pack{
        display: flex;
        flex-direction: column;
       margin: 120px 0 0 20px;
    }
    }
    .btn-back{
        margin-right: 20px;
    }
    
</style>
