<?php

$branchCode = isset($_GET['branchcode']) ? $_GET['branchcode'] : '';

?>


<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 100px; /* Adjusted margin for better centering */
        font-family: Arial, sans-serif; /* Added a generic font family */
    }

    .form-container {
        margin-left: 400px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 80%; /* Adjusted width for responsiveness */
        max-width: 800px; /* Set a maximum width */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Added a subtle box shadow */ 

    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        
    }

    input[type="text"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .add-category-btn,
    .submit-btn,
    .add-item-btn,
    .add-details-btn {
        background-color: #4caf50;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 10px;
        display: flex;

    }

    .category-indicator,
    .item-indicator {
        font-weight: bold;
        margin-right: 5px;
    }

    .details-group {
        display: none;
        margin-top: 10px;
    }
</style>
</head>
<body>

<div class="form-container">
    <form action="?action=add_packageAction" method="post">
        <div class="form-group">
            <label for="packageName">PACKAGE INFORMATION</label>
            <input type="text" id="packageName" name="packageName[]" placeholder="Package Name">
            <textarea id="packageDescription" name="packageDescription[]" placeholder="Description"></textarea>
            <input type="hidden" name="branchCode" value="<?=$branchCode?>">
        </div>

        <div class="category-group" data-category="1">
            <div class="form-group">
                <label for="categoryName">CATEGORY</label>
                <span class="category-indicator"> Category #1.</span>
                <input type="text" id="categoryName" name="categoryName[1][]" placeholder="Category Name">
            </div>

            <div class="item-group" data-item="1">
                <div class="form-group">
                    <label for="itemName">ITEM INFORMATION</label>
                    <span class="item-indicator"> Item #1.</span>
                    <input type="text" id="itemName" name="itemName[1][]" placeholder="Item Name">
                    <textarea id="itemDescription" name="itemDescription[1][]" placeholder="Description"></textarea>
                    <input type="number" id="quantity" name="quantity[1][]" placeholder="Quantity">
                    <input type="number" id="price" name="price[1][]" placeholder="Price">
                </div>
                <button type="button" class="add-details-btn" onclick="cloneDetails(this)">Add Other Details</button>
                <div class="details-group">
                    <div class="form-group">
                        <label for="detailName">Detail Name</label>
                        <input type="text" name="detailName[1][][]" placeholder="Detail Name">
                    </div>
                    <div class="form-group">
                        <label for="detailValue">Value</label>
                        <input type="text" name="detailValue[1][][]" placeholder="Value">
                    </div>
                </div>
            </div>

            <button type="button" class="add-item-btn" onclick="cloneItemFields(this)">Add Items</button>
        </div>
        <button type="button" class="add-category-btn" onclick="cloneCategoryFields()">Add Category</button>
        <button type="submit" class="submit-btn">Submit</button>
    </form>
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
            <input type="text" id="${categoryId}" name="categoryName[${categoryIndex + 1}][]" placeholder="Category Name">
        </div>

        <div class="item-group" data-item="${itemCounter}">
            <div class="form-group">
                <label for="${itemNameId}">ITEM INFORMATION</label>
                <span class="item-indicator">Item #${itemCounter}.</span>
                <input type="text" id="${itemNameId}" name="itemName[${categoryIndex + 1}][]" placeholder="Item Name">
                <textarea id="${itemDescriptionId}" name="itemDescription[${categoryIndex + 1 }][]" placeholder="Description"></textarea>
                <input type="number" id="${quantityId}" name="quantity[${categoryIndex + 1}][]" placeholder="Quantity">
                <input type="number" id="${priceId}" name="price[${categoryIndex + 1}][]" placeholder="Price">
            </div>
            <button type="button" class="add-details-btn" onclick="cloneDetails(this)">Add Other Details</button>
            <div class="details-group">
                <div class="form-group">
                    <label for="detailName">Detail Name</label>
                    <input type="text" name="detailName[${categoryIndex}][][]" placeholder="Detail Name">
                </div>
                <div class="form-group">
                    <label for="detailValue">Value</label>
                    <input type="text" name="detailValue[${categoryIndex}][][]" placeholder="Value">
                </div>
            </div>
        </div>

        <button type="button" class="add-item-btn" onclick="cloneItemFields(this)">Add Item</button>
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

<!-- ... (your existing HTML code) ... -->

</body>
</html>
