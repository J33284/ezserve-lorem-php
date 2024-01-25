<?php
global $DB;
$clientID = $_SESSION['userID'];
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';

// Fetch branch details
$branchQuery = "SELECT *
FROM business
JOIN branches ON business.businessCode = branches.businessCode
WHERE business.businessCode = '$businessCode' AND branches.branchCode = '$branchCode'";

$branchResult = $DB->query($branchQuery);
$branch = $branchResult->fetch_assoc();
?>



<div style="margin: 120px 0 0 20%; width: 70vw">
    <div class="justify-content-center align-items-center" >
        
            <div class="d-flex justify-content-between align-items-center mb-4" >
                <div class="d-flex"> 
                    <a href="?page=choose_package&businessCode=<?= $businessCode?>&branchCode=<?= $branchCode ?>" class=" mx-3 btn-back btn-lg justify-content-center align-items-center d-flex text-dark">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h1>
                    Create Pre-made Packages
                    
                </h1>
                </div>
                <a href="?page=add_package&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>" class="  btn btn-md btn btn-outline-dark"><i class="bi bi-plus-square"> Add Package</i></a>
            </div>

        <?php
        $packageQuery = "SELECT * FROM package WHERE branchCode = '$branchCode'";
        $packageResult = $DB->query($packageQuery);
        ?>

        <?php if ($packageResult->num_rows > 0) { ?>
            <div>
                <?php while ($row = $packageResult->fetch_assoc()) { ?>
                    <div class="card mb-4 flex-row" style="width: 70vw">
                        <div class="col-5 justify-content-center align-items-center d-flex">
                            <img src="./assets/images/new logo.png" alt="Package Image" style="width: 25rem">
                        </div>
                        <div class="col-7">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo $row['packName']; ?></h3>
                                <hr>
                                <label>Description:</label>
                                <p class="card-text"><?php echo $row['packDesc']; ?></p>
                                <label>Total:</label>
                                <p class="card-text">
                                    <?php
                                    if ($row['pricingType'] == "per pax") {
                                        echo "₱" . number_format($row['amount'], 2) . " " . $row['pricingType'];
                                    } else {
                                        // Calculate total cost for packages with items
                                        $packCode = $row['packCode'];
                                        $packageQuery = "SELECT * FROM package LEFT JOIN items ON package.packCode = items.packCode WHERE package.branchCode = '$branchCode' AND package.packCode = '$packCode';";
                                        $packageResults = $DB->query($packageQuery);
                                        $package = $packageResults->fetch_assoc();
                                        $totalCost = 0;

                                        if ($packageResults->num_rows > 0) {
                                            do {
                                                $quantity = $package['quantity'];
                                                $price = $package['price'];
                                                $itemTotal = $quantity * $price;
                                                $totalCost += $itemTotal;
                                            } while ($package = $packageResults->fetch_assoc());
                                        }

                                        $formattedTotalCost = '₱' . number_format($totalCost, 2);
                                        echo "$formattedTotalCost";
                                    }
                                    ?>
                                </p>
                                <a href="?page=owner_package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>&packCode=<?= $row['packCode'] ?>" class="btn btn-primary">View Package</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="col-md-12 mt-4">
                <div class="alert alert-info" role="alert" style="text-align: center; margin-left: 200px;">
                    No packages found.
                </div>
            </div>
        <?php } ?>
    </div>
</div>
