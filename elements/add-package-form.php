<?php
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
//$sql = "SELECT * FROM custom_category WHERE business_code = '$businessCode' AND branch_code = '$branchCode'";
//$result = mysqli_query($conn, $sql);

?>

<style>
    .details-group {
        display: none;
        margin-top: 10px;
    }
    @media (max-width: 2000px) {
    .package-info{
        margin: 120px 0 0 30%;
    }
    @media (max-width: 700px) {
    .package-info{
        width: 100vw;
        margin: 120px 0;
    }
}}
</style>

<div class="package-info" >
    <div class="card p-5 bg-opacity-25 bg-white">
        <form action="?action=add_packageAction" method="post" enctype="multipart/form-data">
            <div class="form-group mb-5">
                <h2>Pre-made Package</h2>
                <br>
                <label for="packageName">PACKAGE INFORMATION</label>
                <hr>
                <input class="form-control mb-3" type="text" id="packageName" name="packageName" placeholder="Package Name" required>
                <textarea class="form-control" id="packageDescription" name="packageDescription" placeholder="Description"></textarea>
                <input type="hidden" name="businessCode" value="<?= $businessCode ?>">
                <input type="hidden" name="branchCode" value="<?= $branchCode ?>">

                <div class="form-check mt-3" style="display: inline-block; margin-right: 20px;">
                    <h6>Pricing</h6>
                    <input class="form-check-input" type="checkbox" name="perPaxCheckbox" onclick="handlePricingCheckbox(this)" >
                    <label class="form-check-label" for="perPaxCheckbox">Per Pax</label>
                </div>
                <div class="form-check" style="display: inline-block;">
                    <input class="form-check-input" type="checkbox" name="totalItemsCheckbox" onclick="handlePricingCheckbox(this)">
                    <label class="form-check-label" for="totalItemsCheckbox">Per Item</label>
                </div>

                <div id="pricePerPax" style="display: none;">
                    <label for="pricePerPax">Price per Pax</label>
                    <input class="form-control mb-3" type="number" id="pricePerPax" name="pricePerPax" placeholder="Price per Pax">
                </div>
            </div>

            <div class="item-group" data-item="1">
            </div>
            <hr>
            <button type="button" class="add-item-btn btn btn-primary" onclick="cloneItemFields()">Add Item</button>
            <hr>
            <button type="submit" class="submit-btn btn btn-primary float-end" onclick="validateCheckbox()">Save</button>
        </form>
    </div>
</div>

<script>
    let itemCounter = 0;

    function handlePricingCheckbox(checkbox) {
        const perPaxCheckbox = document.querySelector('[name="perPaxCheckbox"]');
        const totalItemsCheckbox = document.querySelector('[name="totalItemsCheckbox"]');
        const priceFields = document.querySelectorAll('[id^="price_"]');
        const quantityFields = document.querySelectorAll('[id^="quantity_"]');
        const unitFields = document.querySelectorAll('[id^="unit_"]');
        const pricePerPaxField = document.getElementById('pricePerPax');

        if (checkbox.name === 'perPaxCheckbox' && checkbox.checked) {
            totalItemsCheckbox.checked = false;
            priceFields.forEach(field => {
                field.style.display = 'none';
            });

            quantityFields.forEach(field => {
                field.style.display = 'none';
            });

            unitFields.forEach(field => {
                field.style.display = 'none';
            });

            pricePerPaxField.style.display = 'block';
        } else if (checkbox.name === 'totalItemsCheckbox' && checkbox.checked) {
            perPaxCheckbox.checked = false;
            priceFields.forEach(field => {
                field.style.display = 'block';
            });

            quantityFields.forEach(field => {
                field.style.display = 'block';
            });

            unitFields.forEach(field => {
                field.style.display = 'block';
            });

            pricePerPaxField.style.display = 'none';
        }
    }


    function createItemGroup(itemIndex) {
        const newItemGroup = document.createElement('div');
        newItemGroup.classList.add('item-group');
        newItemGroup.dataset.item = itemIndex;

        const itemNameId = `itemName_${itemIndex}`;
        const itemDescriptionId = `itemDescription_${itemIndex}`;
        const quantityId = `quantity_${itemIndex}`;
        const unitId = `unit_${itemIndex}`;
        const priceId = `price_${itemIndex}`;
        const toggleSwitchId = `userInput_${itemIndex}`;
        const itemImageId = `itemImage_${itemIndex}`;

        newItemGroup.innerHTML = `
            <div class="form-group">
                <h4 class="item-indicator">Item #${itemIndex}.</h4>
                <br>
                <label for="${itemNameId}">Item Information</label>
                
                
                <input class="form-control mb-3" type="text" id="${itemNameId}" name="itemName[${itemIndex}][]" placeholder="Item Name">
                <textarea class="form-control mb-3" id="${itemDescriptionId}" name="itemDescription[${itemIndex}][]" placeholder="Description"></textarea>
                <input class="form-control mb-3" type="number" id="${quantityId}" name="quantity[${itemIndex}][]" placeholder="Quantity">
                <select class="form-select mb-3" id="${unitId}" name="unit[${itemIndex}][]">
                    <option value="" disabled selected>--Select a unit--</option>
                    <option value="bag">piece/s</option>
                    <option disabled>--Container--</option>
                    <option value="bag">bag</option>
                    <option value="box">box</option>
                    <option value="bottle">bottle</option>
                    <option value="bundle">bundle</option>
                    <option value="bundle">packet</option>
                    <option disabled>--Portion--</option>
                    <option value="bag">platter</option>
                    <option value="box">tray</option>
                    <option value="bottle">plate</option>
                    <option value="bundle">bowl</option>
                    <option value="bundle">bucket</option>
                    <option disabled>--Liqiuds--</option>
                    <option value="bag">gallon</option>
                    <option value="box">liter</option>
                    <option value="bottle">ounce(oz)</option>
                    <option value="bundle">cups</option>
                    <option value="bundle">pitcher</option>
                    <option value="bundle">can</option>
                    <option disabled>--Dimension--</option>
                    <option value="bag">kilometer(km)</option>
                    <option value="box">meter(m)</option>
                    <option value="bottle">centimeter(cm)</option>
                    <option value="bundle">inch(in)</option>
                    <option value="bundle">foot(ft)</option>
                    <option value="bundle">yard(yd)</option>
                    <option disabled>--Time--</option>
                    <option value="bag">hour</option>
                    <option value="box">minute</option>
                    <option value="bottle">day</option>
                    <option value="bundle">week</option>
                    <option value="bundle">shift</option>
                    <option value="bundle">session</option>
                    <option value="bundle">month</option>
                </select>
                
                <div id="${priceId}Section">
                    <label for="${priceId}">Price per unit</label>
                    <input class="form-control mb-3" type="number" id="${priceId}" name="price[${itemIndex}][]" placeholder="Price per unit">
                </div>
                <div class="form-group mb-3">
            <label for="${itemImageId}">Upload Image</label>
            <input type="file" id="${itemImageId}" name="itemImage[${itemIndex}][]" accept="image/*" onchange="previewImage(this, 'preview_${itemImageId}')" multiple>
            <img id="preview_${itemImageId}" style="max-width: 100px; max-height: 100px; margin-top: 10px;" src="assets/images/preview-placeholder.jpg" alt="Image Preview">
        </div>
            </div>
            

            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="${toggleSwitchId}" name="userInput[${itemIndex}][]" checked>
                <label class="form-check-label" for="${toggleSwitchId}">Enable Options</label>
                <p style="font-size:15px; color: green"> *Activating the 'Options' feature to allow your clients to choose their specified product/services under your item.</p>
                <br>
                <p style="font-size:15px; color: green"> Add categories that will display on the Options under this item (ex. Item - main dish, Categories - Pork, Chicken, Seafood)</p>
                <div class="input-group mb-3">
                    <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                    </select>
                   
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">Add</button>
                    </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                            <th class="table-dark">Added Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                    <tr>
                                        <td>sample category</td>
                                    </tr>
                                
                        </tbody>
                    </table>
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
        detailsGroup.style.display = 'block';  // Ensure the cloned details group is displayed
    }

    function cloneItemFields() {
        const itemGroup = createItemGroup(itemCounter).cloneNode(true);
        clearInputValues(itemGroup);
        
        const perPaxCheckbox = document.querySelector('[name="perPaxCheckbox"]');
        if (perPaxCheckbox.checked) {
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

    function validateCheckbox() {
        const perPaxCheckbox = document.querySelector('[name="perPaxCheckbox"]');
        const totalItemsCheckbox = document.querySelector('[name="totalItemsCheckbox"]');

        if (!perPaxCheckbox.checked && !totalItemsCheckbox.checked) {
            alert('Please check either "Per Pax" or "Total of Items" before saving.');
            return false; // Prevent form submission
        }
    }
</script>

