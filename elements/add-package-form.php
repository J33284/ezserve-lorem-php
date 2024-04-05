<?php
global $DB;
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';

$custom = $DB->query("SELECT * FROM custom_category WHERE branchCode = $branchCode ");
?>

<style>

    /* CSS to initially hide select category and add button */
.form-select, .input-group-append button, .table, .selection-limit {
    display: none;
}

    .details-group {
        display: none;
        margin-top: 10px;
    }
    @media (max-width: 2000px) {
    .package-info{
        margin: 0 0 0 25%;
    }
    @media (max-width: 700px) {
    .package-info{
        width: 100vw;
        margin: 120px 0;
    }
}}
</style>
<div class="d-flex justify-content-between p-3" style="margin: 120px 0 0 0">
                <div class="d-flex ">
                <a href="?page=choose_package&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>" id="backButton" class=" btn-back mx-5">
                    <i class="bi bi-arrow-left" style="color: black;"></i>
                </a>
                <h2>Pre-made Package</h2>
                </div>
                
            </div>
<div class="package-info" >

    <div class="card p-5 bg-opacity-25 bg-white">
        <form action="?action=add_packageAction" method="post" enctype="multipart/form-data">
            <div class="form-group mb-5">
                
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
                    <div class="d-flex">
                    <span class="input-group-text">₱</span>
                    <input class="form-control mb-3" type="number" id="pricePerPax" name="pricePerPax" placeholder="Price per Pax">
                </div>
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
                <!-- Options for units -->
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
            <input class="form-check-input" type="checkbox" id="${toggleSwitchId}" name="userInput[${itemIndex}][]">
            <label class="form-check-label" for="${toggleSwitchId}" >Enable Options</label>
            <p style="font-size:15px; color: green"> *Activating the 'Options' feature allows your clients to choose their specified product/services under your item.</p>
            <br>
            <p style="font-size:15px; color: green"> Add categories under your specific Item (ex. Item - main dish, Categories - Pork, Chicken, Seafood)</p>
            <div class="input-group mb-3">
                <select class="form-select" id="categorySelect_${itemIndex}">
                    <option disabled selected>--Select category--</option>
                    <?php
                        while ($row = $custom->fetch_assoc()) {
                            $categoryName = $row['categoryName'];
                            $customCategoryCode = $row['customCategoryCode'];
                            echo "<option value=\"$customCategoryCode\">$categoryName</option>";
                        }
                    ?>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="addCategory(${itemIndex})">Add</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="table-dark">Added Category</th>
                        <th class="table-dark"></th>
                    </tr>
                </thead>
                <tbody id="categoryTable_${itemIndex}">
                    <!-- Table body for categories -->
                </tbody>
                <input type="hidden" name="categories[${itemIndex}][]" value="">
                <input type="hidden" name="customCategoryCode[${itemIndex}][]" value="">


            </table>
            <div class="selection-limit">
                <label for="quantity" class="form-label">Number of Options Needed:</label>
                <input type="number" class="form-control" id="limit" name="limit" min="1" max="100" value="1">
            </div>
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
    `;

    return newItemGroup;
}

// Add an event listener to the document body for change events on checkboxes with the class "form-check-input"
document.body.addEventListener("change", function(event) {
    // Check if the changed element is a checkbox with the class "form-check-input"
    if (event.target.matches(".form-check-input")) {
        const checkbox = event.target;
        const isChecked = checkbox.checked;

        // Find the parent div containing the select category and add button elements
        const parentDiv = checkbox.closest(".form-check");
        

        // Get the select category and add button elements within the parent div
        const selectElement = parentDiv.querySelector(`select.form-select`);
        const addButton = parentDiv.querySelector(`.input-group-append button`);
        const table = parentDiv.querySelector(`.table`);
        const limit = parentDiv.querySelector(`.selection-limit`);


        // If the checkbox is checked (options enabled), show select category and add button
        if (isChecked) {
            selectElement.style.display = "block";
            addButton.style.display = "block";
            table.style.display = "block";
            limit.style.display = "block";


        } else { // If the checkbox is not checked (options disabled), hide select category and add button
            selectElement.style.display = "none";
            addButton.style.display = "none";
            table.style.display = "none";
            limit.style.display = "none";


        }
    }
});

function addCategory(itemIndex) {
    const selectElement = document.getElementById(`categorySelect_${itemIndex}`);
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    
    // Check if the selected option is disabled or if the category is already added
    if (!selectedOption.disabled) {
        const selectedCategoryName = selectedOption.text;
        const selectedCategoryCode = selectedOption.value; 
        const tableBody = document.getElementById(`categoryTable_${itemIndex}`);
        
        // Check if the category is already present in the table
        if (!isCategoryDuplicate(tableBody, selectedCategoryName)) {
            if (selectedCategoryName) {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${selectedCategoryName}</td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeCategory(this)">Remove</button></td>
                `;
                tableBody.appendChild(newRow);
                
                // Populate hidden input field with selected category data
                const hiddenInputName = document.createElement('input');
                hiddenInputName.type = 'hidden';
                hiddenInputName.name = `categories[${itemIndex}][${tableBody.children.length - 1}]`;
                hiddenInputName.value = selectedCategoryName;
                document.querySelector(`input[name="categories[${itemIndex}][]"]`).parentNode.appendChild(hiddenInputName);

                const hiddenInputCode = document.createElement('input');
                hiddenInputCode.type = 'hidden';
                hiddenInputCode.name = `customCategoryCode[${itemIndex}][${tableBody.children.length - 1}]`;
                hiddenInputCode.value = selectedCategoryCode;
                document.querySelector(`input[name="customCategoryCode[${itemIndex}][]"]`).parentNode.appendChild(hiddenInputCode);
            }
        }
    
        // Optionally, you can clear the select input after adding the category
        selectElement.selectedIndex = 0;
    }
}


    // Function to check if the category is already present in the table
    function isCategoryDuplicate(tableBody, categoryName) {
        const tableRows = tableBody.querySelectorAll('tr');
        for (let row of tableRows) {
            const cell = row.querySelector('td');
            if (cell && cell.textContent === categoryName) {
                // Category already exists in the table
                return true;
            }
        }
        return false;
    }

    // Function to remove the category row from the table
    function removeCategory(button) {
        const row = button.closest('tr');
        row.remove();
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

