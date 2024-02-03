<?= element('header') ?>

<?= element('owner-side-nav') ?>

<?php
global $DB;                                                                                                                                                            $branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
$categoriesQuery = "SELECT * FROM custom_category WHERE branchCode = '$branchCode'";
$categoriesResult = $DB->query($categoriesQuery);
?>

<?php if ($categoriesResult->num_rows > 0): ?>
    <div class="package-details" id="packageDetails<?= $branchCode ?>" style="height: 100vh; margin: 120px 0 0 23%">
    <div class="d-flex justify-content-between align-items-center mb-4" >
                <div class="d-flex"> 
                    <a href="?page=choose_package&businessCode=<?= $businessCode?>&branchCode=<?= $branchCode ?>" class=" mx-3 btn-back btn-lg justify-content-center align-items-center d-flex text-dark">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h1>
                    Custom Package
                    
                </h1>
                </div>
</div>
        <div class="d-flex align-items-center" >
            <div class="package-details overflow-auto col-5 card bg-opacity-25 bg-white mx-4 px-4" style="height: 100vh; width: 70vw;">
                        <div class="text-end mb-3">
                            <a href="?page=add_custom_package&businessCode=<?= $businessCode?>&branchCode=<?= $branchCode ?>" class="btn-edit btn btn-primary btn-md text-white mt-4">
                            <i class="bi bi-plus-square"></i>
                            <span>Add Category</span>
                        </a>
                    </div>
                <div class="accordion" id="accordionFlushExample">
                    <?php
                    while ($category = $categoriesResult->fetch_assoc()) {
                        $categoryCode = $category['customCategoryCode'];
                        ?>
                        <div class="accordion-item " id="accordionItem<?= $categoryCode ?>">
                            <h2 class="accordion-header" id="flush-heading<?= $categoryCode ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $categoryCode ?>" aria-expanded="false" aria-controls="flush-collapse<?= $categoryCode ?>">
                                    <?= $category['categoryName'] ?>
                                </button>
                            </h2>
                            
                            <div id="flush-collapse<?= $categoryCode ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $categoryCode ?>" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body overflow-auto" style="height: 65vh">
                                    <table class="table table-hover table-responsive">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">Items</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Other Details</th>
                                                <th scope="col" style="width:190px">Action</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $itemsQuery = "SELECT * FROM custom_items WHERE customCategoryCode = '$categoryCode'";
                                            $itemsResult = $DB->query($itemsQuery);

                                            while ($item = $itemsResult->fetch_assoc()) {
                                                $itemCode = $item['itemCode'];
                                                $detailsQuery = "SELECT * FROM custom_item_details WHERE ItemCode = '$itemCode'";
                                                $detailsResult = $DB->query($detailsQuery);
                                                $details = $detailsResult->fetch_assoc();
                                                ?>
                                                <tr data-item-code="<?php echo $item['itemCode']; ?>">
                                                    <td>
                                                        <p id="nameDisplay<?= $item['itemCode']; ?>" style="display:block"><?= $item['itemName'] ?></p>
                                                        <input type="text" class="form-control" id="editName<?= $item['itemCode']; ?>" placeholder="Enter new item name" style="display:none;" value="<?php echo $item['itemName']; ?>">
                                                    </td>
                                                    <td>
                                                        <p id="descriptionDisplay<?= $item['itemCode']; ?>" style="display:block"><?= $item['description'] ?></p>
                                                        <input type="text" class="form-control" id="editDescription<?= $item['itemCode']; ?>" placeholder="Enter new description" style="display:none;" value="<?php echo $item['description']; ?>">
                                                    
                                                    </td>
                                                    <td>
                                                        <p id="priceDisplay<?= $item['itemCode']; ?>" style="display:block"><?= $item['price'] ?></p>
                                                        <input type="text" class="form-control" id="editPrice<?= $item['itemCode']; ?>" placeholder="Enter new price" style="display:none; width: 80px" value="<?php echo $item['price']; ?>">
                                                    
                                                    </td>
                                                    <td>
                                                    <?php if (!empty($details['detailName']) && !empty($details['detailValue'])) { ?>
                                                        <p id="detailsDisplay<?= $item['itemCode']; ?>" style="display: block;"><?php echo $details['detailName'] . ': ' . $details['detailValue']; ?></p>
                                                        <div id="editDetails<?= $item['itemCode']; ?>" style="display: none;">
                                                            <input type="text" class="form-control" id="editDetailName<?= $item['itemCode']; ?>" placeholder="Enter new detail name" value="<?php echo $details['detailName']; ?>">
                                                            <input type="text" class="form-control" id="editDetailValue<?= $item['itemCode']; ?>" placeholder="Enter new detail value" value="<?php echo $details['detailValue']; ?>">
                                                        </div>
                                                    <?php } else { 
                                                        echo 'N/A';
                                                    }
                                                        ?>
                                                       
                                                    </td>

                                                    <td class="flex-column">
                                                    <div class="d-flex">
                                                    <a href="#" id="editButton" class="btn-edit btn btn-primary " onclick="toggleEditable('<?php echo $item['itemCode']; ?>')">
                                                        <i class="bi bi-pencil-fill"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                    <a href="#" id="deleteButton" class="btn-delete btn btn-danger mx-3" style="display:block">
                                                        <i class="bi bi-trash"></i>
                                                        <span>Delete</span>
                                                    </a>
                                                    <a href="#" id="saveButton" class="btn-delete btn btn-primary" style="display:none;" >
                                                        <i class="bi bi-trash"></i>
                                                        <span>Save</span>
                                                    </a>
                                                    <a href="#" id="cancelButton" class="btn-delete btn btn-secondary mx-3" style="display:none" onclick="cancelEdit('<?php echo $item['itemCode']; ?>')">
                                                        <i class="bi bi-trash"></i>
                                                        <span>Cancel</span>
                                                    </a>

                                                        </div>
                                                    </td>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <!-- Add "Add Item" button -->
                                    <div class="text-end mt-3">
                                        <a href="?page=add_customItem&customCategoryCode=<?= $categoryCode ?>&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>" class="btn btn-primary">
                                            <i class="bi bi-plus-square"></i>
                                            <span>Add Item</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
   
    <div class="package-details" id="packageDetails<?= $branchCode ?>" style="display: block;">
    <div class="d-flex align-items-center" style="height: 200px; margin-top: 300px; margin-left: 390px; width: 140%;">
      <div class="package-details col-5 card py-5 mx-4 px-4">
      <h2><span style="color: red;">&#9888;</span> No Records Found</h2>
        
          <div >
            <a href="?page=add_custom_package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="btn-edit btn btn-primary btn-lg mt-4">
              <i class="bi bi-plus-square"></i>
              <span>Create Custom Items</span>
            </a>
          </div>

      </div>
    </div>
  </div>
<?php endif; ?>

<script>
     
function toggleEditable(itemCode) {
        toggleVisibility("nameDisplay", itemCode);
        toggleVisibility("editName", itemCode);

        toggleVisibility("descriptionDisplay", itemCode);
        toggleVisibility("editDescription", itemCode);

        toggleVisibility("priceDisplay", itemCode);
        toggleVisibility("editPrice", itemCode);

        toggleVisibility("detailsDisplay", itemCode);
        toggleVisibility("editDetails", itemCode);

      ['nameDisplay', 'editName', 'descriptionDisplay', 'editDescription', 'priceDisplay', 'editPrice', 'detailsDisplay', 'editDetails'].forEach(function(elementId) {
        toggleVisibility(elementId, itemCode);
    });

    // For buttons inside <td> elements
    ['btn-edit', 'btn-delete', 'btn-save', 'btn-cancel'].forEach(function(buttonClass) {
        toggleButtonVisibility(buttonClass, itemCode);
    });
}
    
    
    function toggleVisibility(elementId, itemCode) {
    var element = document.getElementById(elementId + itemCode);
    if (element.style.display === "none" || element.style.display === "") {
        element.style.display = "block";
    } else {
        element.style.display = "none";
    }
}
</script>