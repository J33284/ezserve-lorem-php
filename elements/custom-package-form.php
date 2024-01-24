<?php
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';

?>

<style>
    .details-group {
        display: none;
        margin-top: 10px;
    }
</style>

<div class="package-info" style="margin: 120px 0 0 30%">
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
    <div class="card p-5 bg-opacity-25 bg-white">
        <form action="?action=add_customPackage" method="post" enctype="multipart/form-data">
            <div class="form-group mb-5">
                <h3>Create Custom Package</h3>
                <p class="text-justify" style="font-size: 15px">Describe all the services your business provides, and categorize them for easy identification of different service types. Create a detailed list of items within each category, ensuring a diverse selection for your clients to choose from.</p>
                <hr>
                <label for="category"></label>
                <input class="form-control mb-5" type="text" id="categoryName" name="categoryName" placeholder="Category Name">
                <input type="hidden" name="branchCode" value="<?= $branchCode ?>">
                <input type="hidden" name="businessCode" value="<?= $businessCode ?>">


            <div class="item-group" data-item="1">
            </div>
            <br>
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
            
            <h5 class="item-indicator mt-5 p-2 " style=" border-bottom: 2px solid #fb7e00;">Item #${itemIndex}.</h5>
            <br>
            <label  for="${itemNameId}">Item Information</label>
            
            <input class="form-control mb-3" type="text" id="${itemNameId}" name="itemName[${itemIndex}][]" placeholder="Item Name">
            <textarea class="form-control " id="${itemDescriptionId}" name="itemDescription[${itemIndex}][]" placeholder="Description"></textarea>
            <div id="${priceId}Section">
                <label for="${priceId}"></label>
                <input class="form-control" type="number" id="${priceId}" name="price[${itemIndex}][]" placeholder="Item Price">
            </div>

            <label for="${imageId}">Upload Image</label>
            <input type="file" id="${imageId}" name="itemImage[${itemIndex}][]" accept="image/*" onchange="previewImage(this, 'preview_${imageId}')">
            <img id="preview_${imageId}" style="max-width: 100px; max-height: 100px; margin-top: 10px;" src="assets/images/preview-placeholder.jpg" alt="Image Preview">
        </div>
        <hr>
        <button type="button" class="add-details-btn btn btn-primary mb-3" onclick="cloneDetails(this, ${itemIndex})">Add Other Details</button>
       
        <div class="details-group" id="details_${itemIndex}_0">
            <div class="form-group mb-3">
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

