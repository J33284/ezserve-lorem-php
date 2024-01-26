<?php
global $DB;
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
$packCode = isset($_GET['packCode']) ? $_GET['packCode'] : '';

// Query to get package information and related items
$packageQuery = "SELECT *
    FROM package
    LEFT JOIN items ON package.packCode = items.packCode
    WHERE package.branchCode = '$branchCode' AND package.packCode = '$packCode';";

$packageResults = $DB->query($packageQuery);
$package = $packageResults->fetch_assoc();

// Query to get items associated with the package
$itemsQuery = "SELECT * FROM items WHERE packCode = '$packCode';";
$itemsResults = $DB->query($itemsQuery);
?>

<div class="row justify-content-center align-items-center" style="margin:120px 0 0 20%; width: 70vw">
    <div>
        <div class="d-flex justify-content-between align-items-center " >
            <div class="d-flex">
            <a href="?page=package&businessCode=<?= $businessCode?>&branchCode=<?= $branchCode ?>" class="col-1 btn-back btn-lg justify-content-center align-items-center d-flex text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
            <h3 style="font-size: 34px; padding: 20px; ">
                <?php echo $package['packName']; ?> 
            </h3>
</div>
            <a href="?page=add_item&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?=$packCode?>" class="btn btn-primary">Add Items</a>
        </div>

        <div  >
            <?php while ($item = $itemsResults->fetch_assoc()) { ?>
                <?php
                // Query to get details associated with the item
                $detailsQuery = "SELECT * FROM item_details WHERE itemCode = '{$item['itemCode']}';";
                $detailsResults = $DB->query($detailsQuery);
                ?>
                <?php if ($package['pricingType'] == 'per pax') { ?>
                    <!-- Code for 'per pax' pricing type -->
                    <div class="card flex-row my-3" style="padding: 30px;">
                        <div class="col-5">
                            <img src="<?php echo $item['itemImage'];?>" alt="Item Image" style="width: 20rem">
                        </div>
                        <div class="col-6">
                            <h4><?php echo $item['itemName']; ?></h4>
                            <hr>
                            <label><strong>Description:</strong></label>
                            <p><?php echo $item['description']; ?></p>
                            <?php while ($detail = $detailsResults->fetch_assoc()) { ?>
                                <p><strong><?php echo $detail['detailName']; ?>:</strong> <?php echo $detail['detailValue']; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="card flex-row my-3" style="padding: 30px;">
                        <div class="col-5">
                            <img src="<?php echo $item['itemImage'];?>" alt="Item Image" style="width: 20rem">
                        </div>
                        <div class="col-6">
                            <h4><?php echo $item['itemName']; ?></h4>
                            <hr>
                            <label><strong>Description:</strong></label>
                            <p><?php echo $item['description']; ?></p>
                            <p>Quantity: <?php echo $item['quantity'] ." ".  $item['unit']; ?></p>
                            <p>Price: <?php echo $item['price']; ?></p>
                            <?php while ($detail = $detailsResults->fetch_assoc()) { ?>
                                <p><strong><?php echo $detail['detailName']; ?>:</strong> <?php echo $detail['detailValue']; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
