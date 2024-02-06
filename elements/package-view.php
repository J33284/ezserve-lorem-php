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
                    <div class="card flex-row my-3" style="padding: 30px;" data-item-code="<?php echo $item['itemCode']; ?>" >
                        <div class="col-3">
                            <img class="rounded-5" src="<?php echo $item['itemImage'];?>" alt="Item Image" style="width: 10rem; height: 10rem">
                        </div>
                        <div class="col-8">
                            <div class="d-flex justify-content-between">
                                <h4 id="itemNameDisplay" style="display:block"><?php echo $item['itemName']; ?></h4>
                                <input type="text" class="form-control" id="editItemName" placeholder="Enter new item name" style="display:none; height:40px; width:50%" value="<?php echo $item['itemName']; ?>">

                            <div class="d-flex">
                                <a href="#" id="editButton" class="btn-edit btn btn-primary mx-3" onclick="toggleEditable('<?php echo $item['itemCode']; ?>')">
                                <i class="bi bi-pencil-fill"></i>
                                <span>Edit</span>
                                </a>
                                <a href="#" id="deleteButton" class="btn-delete btn btn-danger" style="display:block">
                                <i class="bi bi-trash"></i>
                                <span>Delete</span>
                                 </a>
                                 <a href="#" id="saveButton" class="btn-delete btn btn-primary mx-3" style="display:none;" onclick="saveChanges('<?php echo $item['itemCode']; ?>')">
                                <i class="bi bi-trash"></i>
                                <span>Save</span>
                                 </a>
                                 <a href="#" id="cancelButton" class="btn-delete btn btn-secondary" style="display:none" onclick="cancelEdit('<?php echo $item['itemCode']; ?>')">
                                <i class="bi bi-trash"></i>
                                <span>Cancel</span>
                                 </a>
                            </div>
                                
                            </div>
                            
                            <hr>
                            <div>
                                <label><strong>Description:</strong></label>
                                <p id="descriptionDisplay" style="display:block"><?php echo $item['description']; ?></p>
                                <input class="form-control" id="editDescription" style="display:none; height: 80px;" value="<?php echo $item['description']; ?>"></input>
                                <?php while ($detail = $detailsResults->fetch_assoc()) { ?>
                                <p><strong><?php echo $detail['detailName']; ?>:</strong> <?php echo $detail['detailValue']; ?></p>
                            <?php } ?>

                            </div>
                            
                        </div>
                        
                    </div>
                <?php } else { ?>
                    <div class="card flex-row my-3" style="padding: 30px;" data-item-code="<?php echo $item['itemCode']; ?>">
                        <div class="col-3">
                            <img class="rounded-5" src="<?php echo $item['itemImage'];?>" alt="Item Image" style="width: 10rem; height: 10rem">
                        </div >
                        <div class="col-8">
                            <div class="d-flex justify-content-between">
                                <h4 id="itemNameDisplay" style="display:block"><?php echo $item['itemName']; ?></h4>
                                <input type="text" class="form-control" id="editItemName" placeholder="Enter new item name" style="display:none; height:40px; width:50%" value="<?php echo $item['itemName']; ?>">

                                <div class="d-flex">
                                <a href="#" id="editButton" class="btn-edit btn btn-primary mx-3" onclick="toggleEditable('<?php echo $item['itemCode']; ?>')">
                                <i class="bi bi-pencil-fill"></i>
                                <span>Edit</span>
                                </a>
                                <a href="#" id="deleteButton" class="btn-delete btn btn-danger" style="display:block">
                                <i class="bi bi-trash"></i>
                                <span>Delete</span>
                                 </a>
                                 <a href="#" id="saveButton" class="btn-delete btn btn-primary mx-3" style="display:none;" onclick="saveChanges('<?php echo $item['itemCode']; ?>')">
                                <i class="bi bi-save"></i>
                                <span>Save</span>
                                 </a>
                                 <a href="#" id="cancelButton" class="btn-delete btn btn-secondary" style="display:none" onclick="cancelEdit('<?php echo $item['itemCode']; ?>')">
                                <i class="bi bi-trash"></i>
                                <span>Cancel</span>
                                 </a>
                            </div>
                                
                            </div>
                            
                            
                            <hr>
                            <div>
                            <label><strong>Description:</strong></label>
                            <p class="m-0" id="descriptionDisplay" style="display:block; "><?php echo $item['description']; ?></p>
                            <input class="form-control" id="editDescription" style="display:none; margin-bottom: 10px;" value="<?php echo $item['description']; ?>"></input>
                            <p class="m-0" id="quantityDisplay" style="display:block;">Quantity: <?php echo $item['quantity'] ." ".  $item['unit']; ?></p>
                            <input class="form-control" id="editQuantity" style="display:none;margin-bottom: 10px; " value="<?php echo $item['quantity']; ?>"></input>
                            <p class="m-0" id="priceDisplay" style="display:block;"><strong>Price: <?php echo $item['price']; ?></strong></p>
                            <input class="form-control" id="editPrice" style="display:none; " value="<?php echo $item['price']; ?>"></input>
                               <?php while ($detail = $detailsResults->fetch_assoc()) { ?>
                                <p><strong><?php echo $detail['detailName']; ?>:</strong> <?php echo $detail['detailValue']; ?></p>
                            <?php } ?>
                            </div>
                            
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

<script>
function toggleEditable(itemCode) {
    toggleVisibility("itemNameDisplay", itemCode);
    toggleVisibility("editItemName", itemCode);

    toggleVisibility("descriptionDisplay", itemCode);
    toggleVisibility("editDescription", itemCode);

    toggleVisibility("quantityDisplay", itemCode);
    toggleVisibility("editQuantity", itemCode);

    toggleVisibility("priceDisplay", itemCode);
    toggleVisibility("editPrice", itemCode);

    toggleVisibility("editButton", itemCode);
    toggleVisibility("deleteButton", itemCode);

    toggleVisibility("saveButton", itemCode);
    toggleVisibility("cancelButton", itemCode);
}

function toggleVisibility(elementId, itemCode) {
    var element = document.querySelector('[data-item-code="' + itemCode + '"] #' + elementId);
    if (element.style.display === "none") {
        element.style.display = "block";
    } else {
        element.style.display = "none";
    }
}



function cancelEdit(itemCode) {
    // Reset input fields to their initial values
    document.getElementById("editItemName").value = document.getElementById("itemNameDisplay").innerText;
    document.getElementById("editDescription").value = document.getElementById("descriptionDisplay").innerText;
    document.getElementById("editQuantity").value = document.getElementById("quantityDisplay").innerText;
    document.getElementById("editPrice").value = document.getElementById("priceDisplay").innerText;

    // Reset display
    toggleEditable(itemCode);
}



</script>

