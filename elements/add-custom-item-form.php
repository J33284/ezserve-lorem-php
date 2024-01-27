<?php
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$customCategoryCode = isset($_GET['customCategoryCode']) ? $_GET['customCategoryCode'] : '';

global $DB;

// Constructing the SQL query
$sql = "
    SELECT *
    FROM custom_category c
    WHERE c.customCategoryCode = '$customCategoryCode'
";

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

<div class="package-info" style="margin: 120px 0 0 30%">
    <div class="card p-5 bg-opacity-25 bg-white">
        <form action="?action=add_customItem" method="post" enctype="multipart/form-data">
            <div class="form-group mb-5">
                <h2>Custom Items</h2>
                <br>
                <label for="category"></label>
                <input class="form-control mb-3" type="text" id="categoryName" name="categoryName" placeholder="Category Name" value="<?=$row['categoryName']?>"readonly>
                <input type="hidden" name="branchCode" value="<?= $branchCode ?>">
                <input type="hidden" name="businessCode" value="<?= $businessCode ?>">
                <input type="hidden" name="customCategoryCode" value="<?= $customCategoryCode ?>">



            <div class="item-group" data-item="1">
            </div>
            <hr>
            <button type="button" class="add-item-btn btn btn-primary" onclick="cloneItemFields()">Add Item</button>
            <hr>
            <button type="submit" class="submit-btn btn btn-primary float-end">Save</button>
        </form>
    </div>
</div>

<script>
    let itemCounter = 0;


    function createItemGroup(itemIndex) {
    const newItemGroup = document.createElement('div');
    newItemGroup.classList.add('item-group');
    newItemGroup.dataset.item = itemIndex;

    const itemNameId = `itemName_${itemIndex}`;
    const itemDescriptionId = `itemDescription_${itemIndex}`;
    const priceId = `price_${itemIndex}`;
    const imageId = `image_${itemIndex}`;

    newItemGroup.innerHTML = `
        <div class="form-group">
        <h4 class="item-indicator">Item #${itemIndex}.</h4>
        <br>
            <label for="${itemNameId}">Item Information</label>
           
            
            <input class="form-control mb-3" type="text" id="${itemNameId}" name="itemName[${itemIndex}][]" placeholder="Item Name">
            <textarea class="form-control mb-3" id="${itemDescriptionId}" name="itemDescription[${itemIndex}][]" placeholder="Description"></textarea>
            <div id="${priceId}Section">
                <label for="${priceId}">Price</label>
                <input class="form-control" type="number" id="${priceId}" name="price[${itemIndex}][]" placeholder="Item Price">
            </div>

            <label for="${imageId}">Upload Image</label>
            <input type="file" id="${imageId}" name="itemImage[${itemIndex}][]" accept="image/*" onchange="previewImage(this, 'preview_${imageId}')">
            <img id="preview_${imageId}" style="max-width: 100px; max-height: 100px; margin-top: 10px;" alt="Image Preview">
        </div>
        <hr>
        <button type="button" class="add-details-btn btn btn-primary mb-3" onclick="cloneDetails(this, ${itemIndex})">Add Other Details</button>
       
        <div class="details-group" id="details_${itemIndex}_0">
            <div class="form-group">
                <label for="detailName">Detail Name</label>
                <input class="form-control" type="text" name="detailName[${itemIndex}][0][]" placeholder="Detail Name">
            </div>
            <div class="form-group">
                <label for="detailValue">Value</label>
                <input class="form-control" type="text" name="detailValue[${itemIndex}][0][]" placeholder="Detail Value">
            </div>
        </div>
    </div>
    `;

    return newItemGroup;
}

function cloneDetails(button, itemIndex) {
    const detailsGroup = button.parentNode.querySelector('.details-group').cloneNode(true);
    const detailsCount = document.querySelectorAll(`#details_${itemIndex} .details-group`).length;

    detailsGroup.id = `details_${itemIndex}_${detailsCount}`;
    clearInputValues(detailsGroup);
    button.parentNode.insertBefore(detailsGroup, button.nextSibling);
    detailsGroup.style.display = 'block'; 
}


    function cloneItemFields() {
        const itemGroup = createItemGroup(itemCounter).cloneNode(true);
        clearInputValues(itemGroup);

        document.querySelector('.item-group').appendChild(itemGroup);

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


    function clearInputValues(element) {
        const inputs = element.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            if (input.type !== 'hidden') {
                input.value = '';
            }
        });
    }

    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

