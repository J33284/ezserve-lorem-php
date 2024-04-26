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
    <div style="margin: 120px 0 0 20%; width: 70vw">
    <div class="justify-content-center align-items-center" >
        <div class="d-flex justify-content-between align-items-center mb-4" >
            <div class="d-flex"> 
                    <a href="?page=choose_package&businessCode=<?= $businessCode?>&branchCode=<?= $branchCode ?>" class=" mx-3 btn-back btn-lg justify-content-center align-items-center d-flex text-dark">
                    <i class="bi bi-arrow-left"></i>
                    </a>
                    <h1>
                        Create Custom Package
                        
                    </h1>
            </div>
        </div>

        <div>
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
                                                <th scope="col">Availability</th>
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
                                            <form action="?actions=save_custom" method="POST">
                                            <tr data-item-code="<?php echo $item['itemCode']; ?>">
                                           
                                                    <td>
                                                        <p id="nameDisplay<?= $item['itemCode']; ?>" style="display:block"><?= $item['itemName'] ?></p>
                                                        <input type="text" class="form-control" id="editName<?= $item['itemCode']; ?>" placeholder="Enter new item name" style="display:none;" value="<?php echo $item['itemName']; ?>">
                                                    </td>
                                                    <td>
                                                        <p id="descriptionDisplay<?= $item['itemCode']; ?>" style="display:block"><?= $item['description'] ?></p>
                                                        <input type="text" class="form-control" id="editDescription<?= $item['itemCode']; ?>" placeholder="Enter new description" style="display:none;" value="<?php echo $item['description']; ?>">

                                                        <?php if (!empty($details['detailName']) && !empty($details['detailValue'])) { ?>
                                                        <p id="detailsDisplay<?= $item['itemCode']; ?>" style="display: block;"><?php echo $details['detailName'] . ': ' . $details['detailValue']; ?></p>
                                                        <div id="editDetails<?= $item['itemCode']; ?>" style="display: none;">
                                                            <input type="text" class="form-control" id="editDetailName<?= $item['itemCode']; ?>" placeholder="Enter new detail name" value="<?php echo $details['detailName']; ?>">
                                                            <input type="text" class="form-control" id="editDetailValue<?= $item['itemCode']; ?>" placeholder="Enter new detail value" value="<?php echo $details['detailValue']; ?>">
                                                        </div>
                                                    <?php } else { 
                                                        echo '';
                                                    }
                                                        ?>
                                                    
                                                    </td>
                                                    <td>
                                                        <p id="priceDisplay<?= $item['itemCode']; ?>" style="display:block"><?= $item['price'] ?></p>
                                                        <input type="text" class="form-control" id="editPrice<?= $item['itemCode']; ?>" placeholder="Enter new price" style="display:none; width: 80px" value="<?php echo $item['price']; ?>">
                                                    
                                                    </td>
                                                    <td>
                                                        <p id="availabilityDisplay<?= $item['availability']; ?>" style="display:block">
                                                            <?= ($item['availability'] == 1) ? 'No' : 'Yes' ?>
                                                        </p>

                                                    </td>

                                                    <td class="flex-column">
                                                        <div class="d-flex">
                                                            <a href="#" id="editButton<?= $item['itemCode']; ?>" class="btn-edit btn btn-primary " style="display:block" onclick="toggleEditable('<?php echo $item['itemCode']; ?>')">
                                                                <i class="bi bi-pencil-fill"></i>
                                                                <span>Edit</span>
                                                            </a>
                                                            <a href="#" id="deleteButton<?= $item['itemCode']; ?>" class="btn-delete btn btn-danger mx-3" style="display:block">
                                                                <i class="bi bi-trash"></i>
                                                                <span>Delete</span>
                                                            </a>
                                                            <a href="#" id="saveButton<?= $item['itemCode']; ?>" class="btn-save btn btn-success mx-3" style="display:none">
                                                                <i class="bi bi-check-circle"></i>
                                                                <span>Save</span>
                                                            </a>
                                                            <a href="#" id="cancelButton<?= $item['itemCode']; ?>" class="btn-cancel btn btn-secondary" style="display:none" onclick="toggleEditable('<?php echo $item['itemCode']; ?>')">
                                                                <i class="bi bi-x-circle"></i>
                                                                <span>Cancel</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </form>
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
                    
                
          
    
<?php else: ?>
    <div style="margin: 120px 0 0 20%; width: 70vw">
    <div class="justify-content-center align-items-center" >
        <div class="d-flex justify-content-between align-items-center mb-4" >
            <div class="d-flex"> 
                    <a href="?page=choose_package&businessCode=<?= $businessCode?>&branchCode=<?= $branchCode ?>" class=" mx-3 btn-back btn-lg justify-content-center align-items-center d-flex text-dark">
                    <i class="bi bi-arrow-left"></i>
                    </a>
                    <h1>
                        Create Custom Package
                        
                    </h1>
            </div>
                    <a href="?page=add_package&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>" class="  btn btn-md btn btn-primary">
                    <i class="bi bi-plus" style="font-size: 24px; "></i>
                    <span>Add Category</span>
                    </a>
        </div>

    <div class="package-details" id="packageDetails<?= $branchCode ?>" style="display: block;">
    <div class="d-flex align-items-center justify-content-center" style="margin-top: 100px"  >
            <div class="" style="height: 200px; ;">
      <div class="package-details card py-5 mx-4 px-4" style="width: 50vw">
      <h2><span style="color: red;">&#9888;</span> No Records Found</h2>
          
</div>
    </div>
  </div>
<?php endif; ?>

<script>

function toggleEditable(itemCode) {
        var editButton = document.getElementById('editButton' + itemCode);
        var deleteButton = document.getElementById('deleteButton' + itemCode);
        var saveButton = document.getElementById('saveButton' + itemCode);
        var cancelButton = document.getElementById('cancelButton' + itemCode);

        var nameDisplay = document.getElementById('nameDisplay' + itemCode);
        var editName = document.getElementById('editName' + itemCode);

        var descriptionDisplay = document.getElementById('descriptionDisplay' + itemCode);
        var editDescription = document.getElementById('editDescription' + itemCode);

        var priceDisplay = document.getElementById('priceDisplay' + itemCode);
        var editPrice = document.getElementById('editPrice' + itemCode);

        // Toggle display properties for buttons
        editButton.style.display = (editButton.style.display === 'none') ? 'block' : 'none';
        deleteButton.style.display = (deleteButton.style.display === 'none') ? 'block' : 'none';
        saveButton.style.display = (saveButton.style.display === 'none') ? 'block' : 'none';
        cancelButton.style.display = (cancelButton.style.display === 'none') ? 'block' : 'none';

        // Toggle display properties for paragraphs and inputs
        nameDisplay.style.display = (nameDisplay.style.display === 'none') ? 'block' : 'none';
        editName.style.display = (editName.style.display === 'none') ? 'block' : 'none';

        descriptionDisplay.style.display = (descriptionDisplay.style.display === 'none') ? 'block' : 'none';
        editDescription.style.display = (editDescription.style.display === 'none') ? 'block' : 'none';

        priceDisplay.style.display = (priceDisplay.style.display === 'none') ? 'block' : 'none';
        editPrice.style.display = (editPrice.style.display === 'none') ? 'block' : 'none';
    }




</script>