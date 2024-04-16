<?php
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
$packCode = isset($_GET['packCode']) ? $_GET['packCode'] : '';

global $DB;

$sql = "
    SELECT *
    FROM package p 
    WHERE p.packCode = '$packCode'
";

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
        <form action="?action=add_itemAction" method="post" enctype="multipart/form-data">
            <div class="form-group mb-5">
                <h2>Add Item</h2>
                <br>
                <label for="packageName">PACKAGE INFORMATION</label>
                <br>
                <label>Package Name</label>
                <input class="form-control mb-3" type="text" id="packageName" name="packageName[]" placeholder="Package Name" value="<?=$row['packName'] ?>" readonly>
                <label>Package Description</label>
                <input class="form-control" id="packageDescription" name="packageDescription[]" placeholder="Description" value="<?=$row['packDesc'] ?>" readonly>
                <input type="hidden" name="businessCode" value="<?=$businessCode?>">
                <input type="hidden" name="branchCode" value="<?=$branchCode?>">
                <input type="hidden" name="packCode" value="<?=$packCode?>">

                <label>Pricing Type</label>
                <input class="form-control" name ="pricingType" value="<?=$row['pricingType'] ?>" readonly>

            </div>

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
    const quantityId = `quantity_${itemIndex}`;
    const unitId = `unit_${itemIndex}`;
    const priceId = `price_${itemIndex}`;
    const imageId = `image_${itemIndex}`;
    const toggleSwitchId = `userInput_${itemIndex}`;

    newItemGroup.innerHTML = `
        <div class="form-group">
        
            <h4 class="item-indicator">Item #${itemIndex}.</h4>
            <br>
            <label for="${itemNameId}">Item Information</label>
            
           
            <input class="form-control mb-3" type="text" id="${itemNameId}" name="itemName[${itemIndex}][]" placeholder="Item Name">
            <textarea class="form-control mb-3" id="${itemDescriptionId}" name="itemDescription[${itemIndex}][]" placeholder="Description"></textarea>
            <input class="form-control mb-3" type="number" id="${quantityId}" name="quantity[${itemIndex}][]" placeholder="Quantity">
            <select class="form-select mb-3" id="${unitId}" name="unit[${itemIndex}][]">
                <option value="" disabled selected>Select a unit</option>
                <option value="bag">bag</option>
                <option value="box">box</option>
                <option value="bottle">bottle</option>
                <option value="bundle">bundle</option>
            </select>
            
            <div id="${priceId}Section">
                <label for="${priceId}">Price per unit</label>
                <input class="form-control" type="number" id="${priceId}" name="price[${itemIndex}][]" placeholder="Price per unit">
            </div>

            <label for="${imageId}">Upload Image</label>
            <input type="file" id="${imageId}" name="itemImage[${itemIndex}][]" accept="image/*" onchange="previewImage(this, 'preview_${imageId}')">
            <img id="preview_${imageId}" style="max-width: 100px; max-height: 100px; margin-top: 10px;" alt="Image Preview">
        </div>

        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="${toggleSwitchId}" name="userInput[${itemIndex}][]" checked>
            <label class="form-check-label" for="${toggleSwitchId}">Enable User Input</label>
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

        const pricingType = document.querySelector('[name="pricingType"]').value;
        if (pricingType === 'per pax') {
            const priceField = itemGroup.querySelector('[id^="price_"]');
            if (priceField) {
                priceField.style.display = 'none';
            }

            const quantityField = itemGroup.querySelector('[id^="quantity_"]');
            if (quantityField) {
                quantityField.style.display = 'none';
            }

            const unitField = itemGroup.querySelector('[id^="unit_"]');
            if (unitField) {
                unitField.style.display = 'none';
            }
        }

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

