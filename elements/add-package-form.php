<?php

$branchCode = isset($_GET['branchcode']) ? $_GET['branchcode'] : '';

?>

<style>
.details-group {
        display: none;
        margin-top: 10px;
    }
</style>

<div class="package-info " style="margin: 120px 0 0 30%">
<div class="card p-5 bg-opacity-25 bg-white">
    <form action="?action=add_packageAction" method="post">
        <div class="form-group mb-5">
            <h2>Pre-made Package</h2>
            <br>
            <label for="packageName">PACKAGE INFORMATION</label>
            <input class="form-control mb-3" type="text" id="packageName" name="packageName[]" placeholder="Package Name">
            <textarea  class="form-control" id="packageDescription" name="packageDescription[]" placeholder="Description"></textarea>
            <input type="hidden" name="branchCode" value="<?=$branchCode?>">
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
                    <textarea class="form-control mb-3" id="itemDescription" name="itemDescription[1][]" placeholder="Description">
                    <input class="form-control mb-3" type="number" id="quantity" name="quantity[1][]" placeholder="Quantity">
                    <select class="form-select" id="unit" name="unit[1][]" required>
                        <option value="" selected disabled>Select a unit</option>
                        <option value="bag">bag</option>
                        <option value="box">box</option>
                        <option value="bottle">bottle</option>
                        <option value="bundle">bundle</option>
                        <option value="cm">cm</option>
                        <option value="dozen">dozen</option>
                        <option value="gallon">gallon</option>
                        <option value="kg">kg</option>
                        <option value="liter">liter</option>
                        <option value="mg">mg</option>
                        <option value="ounce">ounce</option>
                        <option value="pair">pair</option>
                        <option value="piece">piece</option>
                        <option value="pound">pound</option>
                        <option value="roll">roll</option>
                        <option value="set">set</option>
                        <option value="set">serve</option>
                        <option value="sheet">sheet</option>
                        <option value="set">tray</option>
                        <option value="unit">unit</option>
                    </select>
                    <br>
                    <input  class="form-control" type="number" id="price" name="price[1][]" placeholder="Price per unit">
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
                <select class="form-select" id="unit" name="unit[${categoryIndex + 1}][]">
                        <option value="" disabled selected>Select a unit</option>
                        <option value="bag">bag</option>
                        <option value="box">box</option>
                        <option value="bottle">bottle</option>
                        <option value="bundle">bundle</option>
                        <option value="cm">cm</option>
                        <option value="dozen">dozen</option>
                        <option value="gallon">gallon</option>
                        <option value="kg">kg</option>
                        <option value="liter">liter</option>
                        <option value="mg">mg</option>
                        <option value="ounce">ounce</option>
                        <option value="pair">pair</option>
                        <option value="piece">piece</option>
                        <option value="pound">pound</option>
                        <option value="roll">roll</option>
                        <option value="set">set</option>
                        <option value="sheet">sheet</option>
                        <option value="unit">unit</option>
                    </select>
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
    clearInputValues(categoryGroup);
    
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
    }
}

function cloneItemFields(button) {
    const itemGroup = button.parentNode.querySelector('.item-group').cloneNode(true);
    clearInputValues(itemGroup);
    button.parentNode.insertBefore(itemGroup, button);

    itemCounter++;
    const itemIndicator = itemGroup.querySelector('.item-indicator');
    if (itemIndicator) {
        itemIndicator.textContent = 'Item #' + itemCounter + '.';
    }

    const detailsGroup = itemGroup.querySelector('.details-group');
    if (detailsGroup) {
        detailsGroup.style.display = 'none';
    }
}

function cloneDetails(button) {
    const detailsGroup = button.parentNode.querySelector('.details-group').cloneNode(true);
    clearInputValues(detailsGroup);
    button.parentNode.insertBefore(detailsGroup, button.nextSibling);
    detailsGroup.style.display = 'block';
}

function clearInputValues(element) {
    const inputs = element.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        if (input.type !== 'hidden') {
            input.value = '';
        }
    });
}

</script>

