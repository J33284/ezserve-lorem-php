    <?php
        global $DB;
        $clientID = $_SESSION['userID'];
        $businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
        $branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
        $branchQuery = "SELECT * FROM business WHERE businessCode = '$businessCode'";
        $branchResult = $DB->query($branchQuery);
        $branch = $branchResult->fetch_assoc();
    ?>



<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4" style="width: 200%;">
                <h3 style="font-size: 34px; padding: 20px; background-color: #fff; margin-left: 100px;  margin-top: 100px;">
                    <?php echo $branch['busName']; ?> Packages
                    <a href="?page=add_package&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>" class="btn btn-primary">Add Package</a>
                </h3>
            </div>

            <?php
            $packageQuery = "SELECT * FROM package WHERE branchCode = '$branchCode'";
            $packageResult = $DB->query($packageQuery);
            ?>

            <?php if ($packageResult->num_rows > 0) { ?>
                <div class="col-md-12 mt-4">
                    <?php while ($row = $packageResult->fetch_assoc()) { ?>
                        <div class="card mb-4" style="width: 40rem; height: auto; margin-left: 270px;">
                            <img src="./assets/images/new logo.png" class="card-img-top" alt="Package Image" style="height: 150px;">
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
                                        $packCode = $row['packCode'] ;
                                        $packageQuery = "SELECT *
                                            FROM package
                                            LEFT JOIN items ON package.packCode = items.packCode
                                            WHERE package.branchCode = '$branchCode' AND package.packCode = '$packCode';";

                                        $packageResults = $DB->query($packageQuery);
                                        $package = $packageResults->fetch_assoc();
                                        $totalCost = 0;

                                        // Check if there are items in the package
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
                                <a href="?page=owner_package&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?= $row['packCode'] ?>" class="btn btn-primary">View Package</a>
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
</div>
