<?= element('header') ?>


<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');


$clientType = $_SESSION['usertype'] ?? null;
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode =  isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
$packCode = isset($_GET['packCode']) ? $_GET['packCode'] : '';


// Fetch package details
$packageDetailsQ = $DB->query("SELECT p.*, i.*
    FROM package p
    JOIN items i ON p.packCode = i.packCode
    WHERE p.packCode = '$packCode'");

if ($packageDetailsQ) {
    $packageDetails = $packageDetailsQ->fetch_assoc();
}

$customCategoryQ = $DB->query("SELECT * FROM custom_category");
$customItemsQ = $DB->query("SELECT * FROM custom_items");
?>

<div id="package-view" class="package-view h-100">

    <!-- Navigation Bar -->
    <div class="d-flex justify-content-between align-items-center" style="margin-left: 50px">
        
        <div class="d-flex">
        <a href="?page=client_package&businessCode=<?= $businessCode?>&branchCode=<?= $branchCode ?>" class=" btn-back btn-lg justify-content-center align-items-center d-flex text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class=" d-flex justify-content-start mx-3"><?= $packageDetails['packName'] ?></h1>
        
        </div>
        
    </div>

    <!-- Package Details Table -->
<div class="card mt-5 justify-content-center align-items-center d-flex p-3 table-responsive">
    <table class="table table-hover table-responsive">
        <!-- Table Header -->
        <thead>
            <tr style="border-bottom: 2px solid orange;">
                <th>Image</th>
                <th>Item Name</th>
                <th>Description</th>
                <?php if ($packageDetails['pricingType'] !== 'per pax') : ?>
                    <th>Quantity</th>
                    <th>Price</th>
                <?php endif; ?>
                <th></th> <!-- Table Body -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($packageDetailsQ as $row) : ?>
                <?php
                //for item_details table
                $itemCode = $row['itemCode'];
                $itemDetailsQ = $DB->query("SELECT * FROM item_details WHERE itemCode = '$itemCode'");
                $itemDetails = $itemDetailsQ->fetch_assoc();
                ?>
                <tr id="packageRow_<?= $row['itemCode'] ?>">
                    <td style="width: 250px;">
                        <img src="<?= $row['itemImage'] ?>" alt="<?= $row['itemName'] ?>" style="width: 200px; height: 180px;" onclick="openModal('<?= $row['itemImage'] ?>', '<?= $row['itemName'] ?>')">
                    </td>
                    <td style="width: 200px;"><?= $row['itemName'] ?></td>
                    <td style="width: 400px;">
                        <?= $row['description'] ?><br>
                        <?php if (!empty($itemDetails['detailName']) && !empty($itemDetails['detailValue'])) : ?>
                            <strong><?= $itemDetails['detailName'] ?>:</strong> <?= $itemDetails['detailValue'] ?>
                        <?php endif; ?>
                    </td>
                    <?php if ($packageDetails['pricingType'] !== 'per pax') : ?>
                        <td><?= $row['quantity'] . " " . $row['unit'] ?></td>
                        <td><?= '₱' . number_format($row['price'], 2) ?></td>
                    <?php endif; ?>
                    <?php if ($row['userInput'] === 'enable') : ?>
                        <td><button type="button" style="text-align: center" class="btn btn-primary options-button d-none" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas<?= $row['itemCode'] ?>">Options</button></td>
                    <?php else : ?>
                        <td></td>
                    <?php endif; ?>
                </tr>
      

                <!-- Offcanvas for each item -->
                <div class="offcanvas offcanvas-start" tabindex="-1" id="menuOffcanvas<?= $row['itemCode'] ?>" data-bs-backdrop="true" data-bs-scroll="true" style="width: 450px;">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title my-3"><?= $row['itemName'] ?> Options</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <?php 
                        $customCategoryQ = $DB->query("SELECT * FROM item_option WHERE itemCode = '$itemCode'");
                        
                        while ($category = $customCategoryQ->fetch_assoc()) : ?>
                            <div>
                                <li class="overflow-auto" style="list-style-type:none;">
                                    <strong><?= $category['optionName'] ?></strong> 
                                    <ul>
                                        <?php 
                                        // Fetch items for each category
                                        $categoryId = $category['customCategoryCode'];
                                        $customItemsQ = $DB->query("SELECT * FROM custom_items WHERE customCategoryCode = '$categoryId'");

                                        while ($item = $customItemsQ->fetch_assoc()) : ?>
                                            <li style="list-style-type:none;">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" 
                                                       data-item-code="<?= $row['itemCode'] ?>" 
                                                       data-item-name="<?= $item['itemName'] ?>" 
                                                       data-availability="<?= $item["availability"] ?>"
                                                       onclick="handleCheckboxClick('<?= $category['itemCode'] ?>', <?= $category['optionLimit'] ?>)"
                                                       <?php if ($item["availability"] == 1) echo "disabled"; ?>>
                                                <?= $item['itemName'] ?>
                                                <?php if ($item["availability"] == 1) : ?>
                                                    <span style="color: red;">(Not Available)</span>
                                                <?php endif; ?>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </li>
                            </div>
                        <?php endwhile; ?>
                        <div class="offcanvas-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="offcanvas">Done</button>
                    </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>     
</div>

    <!-- Total Container -->
    <div class="container mt-3 text-center" id="initialTotalCon" style="background-color: white; padding: 10px; height: auto;">
            <?php
            if ($packageDetails['pricingType'] === 'per pax') {
                // Display 'per pax' pricing
                $total = 'Price: ' . '₱' . number_format($packageDetails['amount'], 2) . ' / pax';
            } else {
                // Calculate total for other pricing types
                $total = 0;
                foreach ($packageDetailsQ as $row) {
                    $total += $row['quantity'] * $row['price'];
                }
                $total = 'Total: ' . '₱' . number_format($total, 2);
            }
            ?>
            <p id="initialTotal" style="font-size: 30px;"><?= $total ?></p>

            <!-- Quantity Meter Container -->
            <div id="quantityMeterContainer" style="margin-top: 10px; display:none;">
                <label for="quantityMeter">No. of Persons:</label>
                <input type="number" id="quantityMeter" placeholder="Enter quantity" value="1">
            </div>
    </div>

    <div class="container mt-3 text-center d-none" id="checkoutCon" style="background-color: white; padding: 10px; height: auto;">
        <h2 id="checkoutTotal">Total: ₱0.00</h2>
    </div>

    <div class="container mt-3 text-center">
        <button id="customizeButton" class="btn btn-primary" onclick="customizePackage()">Modify</button>
        <button id="backButton" class="btn btn-secondary d-none" onclick="backToPackageView()">Back</button>
        <button id="backButton2" class="btn btn-secondary d-none" onclick="backToModify()">Back</button>
        <button id="saveButton" class="btn btn-success d-none" onclick="saveCustomization()">Save</button>
        <button id="checkoutButton" class="btn btn-primary d-none" >Checkout</button>

    </div>

</div>
   <div id="loginAsClientPopup">
        <p>You need to log in as a client to proceed.</p>
        <?php if ($clientType === 'business owner') : ?>
            <button onclick="redirectLogout()">Logout</button>
        <?php elseif ($clientType === null) : ?>
            <button onclick="redirectLogin()">Login</button>
        <?php endif; ?>
    </div>


    <!-- Modal for displaying full-size image -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal">&times;</span>
            <img id="fullImage" style="width: 100%; height: auto;">
        </div>
    </div>



<!-- JavaScript for opening and closing the modal -->
<script>    


    function redirectLogin() {
        window.location.href = '?page=login';
    }

    function redirectLogout() {
        window.location.href = '?page=logout';
    }

   function handleCheckboxClick(itemCode, optionLimit) {
        var checkboxes = document.querySelectorAll('#menuOffcanvas' + itemCode + ' input[type="checkbox"]');
        var checkedCount = 0;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                checkedCount++;
            }
        });

        checkboxes.forEach(function(checkbox) {
            var itemAvailability = checkbox.dataset.availability; 
            if ((!checkbox.checked && checkedCount >= optionLimit) || itemAvailability === "1") {
                checkbox.disabled = true;
            } else {
                checkbox.disabled = false;
            }
        });
    }

        // Image Window
        function openModal(imageSrc, itemName) {
            var modal = document.getElementById('imageModal');
            var modalImage = document.getElementById('fullImage');

            modal.style.display = 'block';
            modalImage.src = imageSrc;
            modalImage.alt = itemName;
        }

        function closeModal() {
            var modal = document.getElementById('imageModal');
            modal.style.display = 'none';
        }

        // Close the Image Window when clicking the X button
        document.getElementsByClassName('close')[0].onclick = closeModal;

        function toggleOptionsButton(userInput, buttonElement) {
            if (userInput === 'enable') {
                buttonElement.style.display = 'block'; // Show the button
            } else {
                buttonElement.style.display = 'none'; // Hide the button
            }
        }
        
        function customizePackage() {
            var packageDetails = <?php echo json_encode($packageDetails); ?>;
            var pricingType = packageDetails['pricingType'];
            var optionButtons = document.querySelectorAll('.options-button');

            optionButtons.forEach(function(button) {
                button.classList.remove('d-none'); // Show the "Options" button for each item
            });

            if (pricingType === 'per pax') {
                customizePerPax();
            } else {
                customizeOther();
            }

            // Show back button
            document.getElementById('customizeButton').classList.add('d-none');
            document.getElementById('backButton').classList.remove('d-none');
            document.getElementById('saveButton').classList.remove('d-none');

        }

        var customizationApplied = false; 

    function customizePerPax() {
        if (!customizationApplied) {
            document.getElementById('quantityMeterContainer').style.display = 'block';

            customizationApplied = true;
        }
    }

    function customizeOther() {
            var tableBody = document.querySelector('#package-view table tbody');
            var rows = tableBody.querySelectorAll('tr');

            rows.forEach(function(row) {
                var quantityCell = document.createElement('td');
                var quantityInput = document.createElement('input');
                quantityInput.type = 'number';
                quantityInput.placeholder = 'Enter quantity';
                quantityInput.className = 'form-control';
                quantityInput.value = 1;
                quantityInput.min = 1;
                quantityCell.appendChild(quantityInput);
                row.appendChild(quantityCell);
                quantityInput.style.width = '100px';
            });

    }

    function backToPackageView() {
        var tableBody = document.querySelector('#package-view table tbody');
        var rows = tableBody.querySelectorAll('tr');
        var optionButtons = document.querySelectorAll('.options-button');

        var pricingType = <?php echo json_encode($packageDetails['pricingType']); ?>;

        if (pricingType === 'per pax') {
            optionButtons.forEach(function(button) {
                button.classList.add('d-none');
            });
            document.getElementById('quantityMeterContainer').style.display = 'none';
        } else {
            optionButtons.forEach(function(button) {
                button.classList.add('d-none'); 
            });
            rows.forEach(function (row) {
                row.removeChild(row.lastElementChild); 
                
                
            });

            document.getElementById('quantityMeterContainer').style.display = 'none';
        }

        document.getElementById('saveButton').classList.add('d-none');
        document.getElementById('customizeButton').classList.remove('d-none');
        document.getElementById('checkoutButton').classList.add('d-none');
        document.getElementById('backButton').classList.add('d-none');



        customizationApplied = false;
    }

    function backToModify() {
    var tableBody = document.querySelector('#package-view table tbody');
    var rows = tableBody.querySelectorAll('tr');
    var optionButtons = document.querySelectorAll('.options-button');

    optionButtons.forEach(function(button) {
        button.classList.remove('d-none'); 
    });

    document.getElementById('quantityMeterContainer').style.display = 'none';
    
    var checkoutCOnContainer = document.getElementById('checkoutCon');
    checkoutCOnContainer.classList.add('d-none');

    var InitialTotalCon = document.getElementById('initialTotalCon');
    InitialTotalCon.classList.remove('d-none');
    document.getElementById('quantityMeterContainer').style.display = 'block';

    rows.forEach(function(row) {
        var cells = row.querySelectorAll('.options-cell');
        cells.forEach(function(cell) {
            cell.parentNode.removeChild(cell);
        });
    });

    document.getElementById('saveButton').classList.remove('d-none');
    document.getElementById('customizeButton').classList.add('d-none');
    document.getElementById('checkoutButton').classList.add('d-none');

    customizationApplied = false;
}



    function saveCustomization() {
    var checkedOptions = {};

    var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    checkboxes.forEach(function(checkbox) {
        var itemName = checkbox.getAttribute('data-item-name');
        var rowId = checkbox.getAttribute('data-item-code');

        if (!checkedOptions[rowId]) {
            checkedOptions[rowId] = [];
        }
        checkedOptions[rowId].push(itemName);
    });

     for (var rowId in checkedOptions) {
        var optionsHtml = '<b>Selected Item/s:</b><br>' + checkedOptions[rowId].join('<br>'); 
        var row = document.getElementById('packageRow_' + rowId); 
        var checkedOptionsCell = row.insertCell(-1); 
        checkedOptionsCell.innerHTML = optionsHtml; 
        checkedOptionsCell.classList.add('options-cell'); 
    }

     var optionButtons = document.querySelectorAll('.options-button');
        optionButtons.forEach(function(button) {
            button.classList.add('d-none');
        });

    var packageDetails = <?php echo json_encode($packageDetails); ?>;
    var pricingType = packageDetails['pricingType'];
    var total = 0;

    if (pricingType === 'per pax') {
        var quantityMeterValue = document.getElementById('quantityMeter').value;
        total = parseFloat(packageDetails['amount']) * parseFloat(quantityMeterValue);
    }

    var formattedTotal = total.toLocaleString('en-US', { style: 'currency', currency: 'PHP' });

    document.getElementById('checkoutTotal').textContent = 'Total: ' + formattedTotal;

    var checkoutCOnContainer = document.getElementById('checkoutCon');
    checkoutCOnContainer.classList.remove('d-none');

    var InitialTotalCon = document.getElementById('initialTotalCon');
    InitialTotalCon.classList.add('d-none');

    document.getElementById('customizeButton').classList.add('d-none');
    document.getElementById('saveButton').classList.add('d-none');
    document.getElementById('backButton').classList.add('d-none');
    document.getElementById('checkoutButton').classList.remove('d-none');
    document.getElementById('backButton2').classList.remove('d-none');
}

document.getElementById('checkoutButton').addEventListener('click', function() {
    var packageTable = document.getElementById('package-view').querySelector('table');
    var packageRows = packageTable.querySelectorAll('tr');

    var packageDetails = [];
    var pricingType = <?php echo json_encode($packageDetails['pricingType']); ?>;
    var initialTotal = document.getElementById('initialTotal').textContent.trim();
    var quantityMeterValue = document.getElementById('quantityMeter').value;

    packageRows.forEach(function(row) {
        var rowData = {};

        var itemName = row.cells[1].textContent.trim(); 
        var description = row.cells[2].textContent.trim(); 


        rowData['itemName'] = itemName;
        rowData['description'] = description;


        var optionCell = row.querySelector('.options-cell');
        if (optionCell) {
            var selectedOptions = optionCell.innerHTML.split('<br>').map(function(option) {
                return option.trim();
            });
            rowData['selectedOptions'] = selectedOptions;
        } else {
            rowData['selectedOptions'] = []; 
        }

        if (pricingType !== 'per pax') {
            var quantity = row.cells[3].textContent.trim(); 
            var price = row.cells[4].textContent.trim(); 
            rowData['quantity'] = quantity;
            rowData['price'] = price;
        }

        packageDetails.push(rowData);
    });

    var checkoutData = {
        'packageDetails': packageDetails,
        'pricingType': pricingType,
        'initialTotal': initialTotal,
        'quantityMeterValue': quantityMeterValue,
        'checkoutTotal': document.getElementById('checkoutTotal').textContent.trim()
    };
    var checkoutDataJSON = JSON.stringify(checkoutData);
    var clientType = <?php echo json_encode($clientType); ?>;

    if (clientType === 'business owner' || clientType === null) {
        document.getElementById('loginAsClientPopup').style.display = 'block';

        setTimeout(function () {
            document.getElementById('loginAsClientPopup').style.display = 'none';
        }, 2000);        
    } else {
    window.location.href = '?page=checkout&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?=$packCode?>&checkoutData=' + encodeURIComponent(checkoutDataJSON);
    }
});



    

    </script>
    <style>
        @media (min-width: 1000px) {
            .package-view {
                margin: 120px;
                width: auto;
            }
        }

        @media (max-width: 700px) {
            .package-view {
                margin-top: 120px;
            }

            .total {
                margin: 0 !important;
            }
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
            padding-top: 160px;
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 50%;
            max-height: 50%;
            position: relative;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 30px;
            color: #fff;
            cursor: pointer;
        }

        #loginAsClientPopup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #001f3f;
            color: #ffffff; 
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 1000;
        }

        #loginAsClientPopup button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #0074cc; 
            color: #ffffff; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

    </style>





