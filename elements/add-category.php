<?php

$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
$packCode = isset($_GET['packageCode']) ? $_GET['packageCode'] : '';

global $DB;

$sql = "
    SELECT *
    FROM package WHERE packCode = '$packCode'";

// Executing the query
$result = $DB->query($sql);
$row = $result->fetch_assoc();

?>

<style>
.details-group {
        display: none;
        margin-top: 10px;
    }
</style>

<div class="package-info " style="margin: 120px 0 0 30%">
<div class="card p-5 bg-opacity-25 bg-white">
    <form action="?action=add_categoryAction" method="post">
        <div class="form-group mb-5">
            <h2>Add New Category</h2>
            <br>
            <label for="packageName">PACKAGE INFORMATION</label>
            <input class="form-control mb-3" type="text" id="packageName" name="packageName[]" placeholder="Package Name" value="<?=$row['packName'] ?>" readonly>
            <textarea  class="form-control" id="packageDescription" name="packageDescription[]" placeholder="Description" value="<?=$row['packDesc'] ?>" readonly></textarea>
            <input type="hidden" name="branchCode" value="<?=$branchCode?>">
            <input type="hidden" name="packCode" value="<?=$packCode?>">

        </div>

        <div class="category-group" data-category="1">
            <div class="form-group mb-3">
                <label for="categoryName">CATEGORY</label>
                <span class="category-indicator"> Category #1.</span>
                <input class="form-control" type="text" id="categoryName" name="categoryName[1][]" placeholder="Category Name">
            </div>

            <div class="item-group" data-item="1">
                <div class="form-group">
                    <label for="itemName">ITEM INFORMATION</label>
                    <span class="item-indicator"> Item #1.</span>
                    <input  class="form-control mb-3" type="text" id="itemName" name="itemName[1][]" placeholder="Item Name">
                    <textarea class="form-control mb-3" id="itemDescription" name="itemDescription[1][]" placeholder="Description"></textarea>
                    <input class="form-control mb-3" type="number" id="quantity" name="quantity[1][]" placeholder="Quantity">
                    <input  class="form-control" type="number" id="price" name="price[1][]" placeholder="Price">
                </div>
                <button type="button" class="add-details-btn btn btn-primary my-3" onclick="cloneDetails(this)">Add Other Details</button>
                <hr>
                <div class="details-group">
                    <div class="form-group">
                        <label for="detailName">Detail Name</label>
                        <input class="form-control" type="text" name="detailName[1][][]" placeholder="Detail Name">
                    </div>
                    <div class="form-group">
                        <label for="detailValue">Value</label>
                        <input class="form-control" type="text" name="detailValue[1][][]" placeholder="Value">
                    </div>
                </div>
            </div>

            <button type="button" class="add-item-btn btn btn-primary my-3" onclick="cloneItemFields(this)">Add Items</button>
            <hr>
        </div>
        <button type="button" class="add-category-btn btn btn-primary my-2" onclick="cloneCategoryFields()">Add Category</button>
        <hr>
        <button type="submit" class="submit-btn btn btn-primary float-end">Save</button>
    </form>
</div>

</div>
<script>
let categoryCounter = 1;
let itemCounter = 1;

function createCategoryGroup(categoryIndex) {
    const newCategoryGroup = document.createElement('div');
    newCategoryGroup.classList.add('category-group');

    // Generate unique IDs for the category input fields
    const categoryId = `categoryName_${categoryIndex}`;
    const itemGroupId = `itemGroup_${categoryIndex}`;
    const itemNameId = `itemName_${categoryIndex}`;
    const itemDescriptionId = `itemDescription_${categoryIndex}`;
    const quantityId = `quantity_${categoryIndex}`;
    const priceId = `price_${categoryIndex}`;

    // Add your category-group structure here
    
    newCategoryGroup.innerHTML = `
        <div class="form-group">
            <label for="${categoryId}">CATEGORY</label>
            <span class="category-indicator">Category #${categoryIndex}.</span>
            <input class="form-control" type="text" id="${categoryId}" name="categoryName[${categoryIndex + 1}][]" placeholder="Category Name">
        </div>

        <div class="item-group" data-item="${itemCounter}">
            <div class="form-group">
                <label for="${itemNameId}">ITEM INFORMATION</label>
                <span class="item-indicator">Item #${itemCounter}.</span>
                <input class="form-control" type="text" id="${itemNameId}" name="itemName[${categoryIndex + 1}][]" placeholder="Item Name">
                <textarea class="form-control" id="${itemDescriptionId}" name="itemDescription[${categoryIndex + 1 }][]" placeholder="Description"></textarea>
                <input class="form-control" type="number" id="${quantityId}" name="quantity[${categoryIndex + 1}][]" placeholder="Quantity">
                <input class="form-control" type="number" id="${priceId}" name="price[${categoryIndex + 1}][]" placeholder="Price">
            </div>
            <button type="button" class="add-details-btn btn btn-primary" onclick="cloneDetails(this)">Add Other Details</button>
            <div class="details-group">
                <div class="form-group">
                    <label for="detailName">Detail Name</label>
                    <input class="form-control" type="text" name="detailName[${categoryIndex}][][]" placeholder="Detail Name">
                </div>
                <div class="form-group">
                    <label for="detailValue">Value</label>
                    <input class="form-control" type="text" name="detailValue[${categoryIndex}][][]" placeholder="Value">
                </div>
            </div>
        </div>

        <button type="button" class="add-item-btn btn btn-primary" onclick="cloneItemFields(this)">Add Item</button>
    `;

    return newCategoryGroup;
}

function cloneCategoryFields() {
    const categoryGroup = createCategoryGroup(categoryCounter).cloneNode(true);
    const form = document.querySelector('form');
    form.insertBefore(categoryGroup, document.querySelector('.add-category-btn'));

    categoryCounter++;
    const categoryIndicator = categoryGroup.querySelector('.category-indicator');
    if (categoryIndicator) {
        categoryIndicator.textContent = 'Category #' + categoryCounter + '.';
    }

    itemCounter = 1;
    const newItemIndicator = categoryGroup.querySelector('.item-indicator');
    if (newItemIndicator) {
        newItemIndicator.textContent = 'Item #' + itemCounter + '.';
    }

    const newDetailsGroup = categoryGroup.querySelector('.details-group');
    if (newDetailsGroup) {
        newDetailsGroup.style.display = 'none';
        clearDetailsInputs(newDetailsGroup);
    }
}

function cloneItemFields(button) {
    const itemGroup = button.parentNode.querySelector('.item-group').cloneNode(true);
    button.parentNode.insertBefore(itemGroup, button);

    itemCounter++;
    const itemIndicator = itemGroup.querySelector('.item-indicator');
    if (itemIndicator) {
        itemIndicator.textContent = 'Item #' + itemCounter + '.';
    }

    const detailsGroup = itemGroup.querySelector('.details-group');
    if (detailsGroup) {
        detailsGroup.style.display = 'none';
        clearDetailsInputs(detailsGroup);
    }
}

function toggleDetails(button) {
    const detailsGroup = button.parentNode.querySelector('.details-group');
    if (detailsGroup) {
        detailsGroup.style.display = detailsGroup.style.display === 'none' ? 'block' : 'none';
    }
}

function cloneDetails(button) {
    const detailsGroup = button.parentNode.querySelector('.details-group').cloneNode(true);
    clearDetailsInputs(detailsGroup);
    button.parentNode.insertBefore(detailsGroup, button.nextSibling);
    detailsGroup.style.display = 'block';
}

function clearDetailsInputs(detailsGroup) {
    const detailNameInput = detailsGroup.querySelector('[name="detailName"]');
    const detailValueInput = detailsGroup.querySelector('[name="detailValue"]');
    if (detailNameInput && detailValueInput) {
        detailNameInput.value = '';
        detailValueInput.value = '';
    }
}

</script>

