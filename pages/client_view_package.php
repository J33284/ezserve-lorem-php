<?= element('header') ?>

<?php
// Prevent direct access
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

// Get user session information
$clientID = $_SESSION['userID'];
$clientType = $_SESSION['usertype'];

// Get business and branch codes from the query parameters
$businessCode = $_GET['businessCode'];
$branchCode = $_GET['branchCode'];

// Get package code from the query parameters
$packCode = isset($_GET['packCode']) ? $_GET['packCode'] : '';

// Fetch package details
$packageDetailsQ = $DB->query("SELECT p.*, i.*
    FROM package p
    JOIN items i ON p.packCode = i.packCode
    WHERE p.packCode = '$packCode'");

// Check if the query was successful
if ($packageDetailsQ) {
    $packageDetails = $packageDetailsQ->fetch_assoc();
}
?>

<div id="package-view" class="package-view h-100">

    <!-- Navigation Bar -->
    <div class="row d-flex justify-content-start align-items-center" style="margin-left: 50px">
        <a href="?page=client_package&businessCode=<?= $businessCode?>&branchCode=<?= $branchCode ?>" class="col-1 btn-back btn-lg justify-content-center align-items-center d-flex text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="col-10 d-flex justify-content-start"><?= $packageDetails['packName'] ?></h1>
    </div>

    <!-- Package Details Table -->
    <div class="card mt-5 justify-content-center align-items-center d-flex p-3 table-responsive">
        <table class="table table-hover table-responsive">
            <!-- Table Header -->
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Additional Detail</th>
                    <?php if ($packageDetails['pricingType'] === 'per pax') : ?>
                        <th>Image</th>
                    <?php else : ?>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Image</th>
                        <th>Price</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody>
                <?php foreach ($packageDetailsQ as $row) : ?>
                    <?php
                    // Fetch other details from item_details table
                    $itemCode = $row['itemCode'];
                    $itemDetailsQ = $DB->query("SELECT * FROM item_details WHERE itemCode = '$itemCode'");
                    $itemDetails = $itemDetailsQ->fetch_assoc();
                    ?>
                    <tr>
                        <td><?= $row['itemName'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td>
        <?php if (!empty($itemDetails['detailName']) && !empty($itemDetails['detailValue'])) : ?>
            <strong><?= $itemDetails['detailName'] ?></strong><?= $itemDetails['detailValue'] ?>
        <?php else : ?>
            N/A
        <?php endif; ?>
    </td>
                        <?php if ($packageDetails['pricingType'] === 'per pax') : ?>
                            <td>
                                <img src="<?= $row['itemImage'] ?>" alt="<?= $row['itemName'] ?>" style="max-width: 200px; height: 180px;"
                                    onclick="openModal('<?= $row['itemImage'] ?>', '<?= $row['itemName'] ?>')">
                            </td>
                        <?php else : ?>
                            <td><?= $row['quantity'] ?></td>
                            <td><?= $row['unit'] ?></td>
                            <td>
                                <img src="<?= $row['image'] ?>" alt="<?= $row['itemName'] ?>" style="max-width: 50px;"
                                    onclick="openModal('<?= $row['image'] ?>', '<?= $row['itemName'] ?>')">
                            </td>
                            <td><?= $row['price'] ?></td>
                        <?php endif; ?>
                        <?php if (!empty($itemDetails)) : ?>
                            <td><strong><?= $itemDetails['detailName'] ?></strong>: <?= $itemDetails['detailValue'] ?></td>
                        <?php else : ?>
                            <td></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Total Container -->
    <div class="container mt-3 text-center" style="background-color: white; padding: 10px;">
        <?php
        if ($packageDetails['pricingType'] === 'per pax') {
            // Display 'per pax' pricing
            $total = 'Total: ' . '₱' . number_format($packageDetails['amount'], 2) . ' / pax';
        } else {
            // Calculate total for other pricing types
            $total = 0;
            foreach ($packageDetailsQ as $row) {
                $total += $row['quantity'] * $row['price'];
            }
            $total = 'Total: ' . '₱' . number_format($total, 2);
        }
        ?>
        <p style="font-size: 30px;"><?= $total ?></p>

        <div id="quantityMeterContainer" style="display: none;">
        <label for="quantityMeter">No. of Persons:</label>
        <input type="number" id="quantityMeter" placeholder="Enter quantity" value ="1">
    </div>

        
    </div>

    <div class="container mt-3 text-center">
        <button id="customizeButton" class="btn btn-primary" onclick="customizePackage()">Customize</button>
        <button id="backButton" class="btn btn-secondary d-none" onclick="backToPackageView()">Back</button>
        <button id="saveButton" class="btn btn-success d-none" onclick="saveCustomization()">Save</button>
    </div>

</div>

<!-- Checkout Container -->
<div id="checkoutContainer" class="container mt-3 text-center d-none">
    <h2>Checkout</h2>
    <table id="checkoutTable" class="table rounded table-bordered table-responsive" style="margin-top: 130px;">
        <!-- Table Header -->
        <thead>
    <tr>
        <th>Item Name</th>
        <th>Description</th>
        <th>Image</th>
        <th>Customized</th>
        <th>Quantity</th>
    </tr>
</thead>

        <!-- Table Body -->
        <tbody id="checkoutTableBody">
            <!-- Checkout table content will be added dynamically -->
        </tbody>
    </table>

    <!-- Back and Checkout Buttons -->
    <div class="container mt-3 text-center">
        <button id="backToCustomization" class="btn btn-secondary d-none" onclick="backToCustomization()">Back to Customization</button>
        <button id="proceedToCheckout" class="btn btn-success d-none" onclick="proceedToCheckout()">Proceed to Checkout</button>
    </div>
</div>

<!-- Modal for displaying full-size image -->
<div id="imageModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal">&times;</span>
        <img id="fullImage" style="width: 100%; height: auto;">
    </div>
</div>

<!-- Styles -->
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

    /* Additional styling for the modal */
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
</style>

<!-- JavaScript for opening and closing the modal -->
<script>
    // Open modal with full-size image
    function openModal(imageSrc, itemName) {
        var modal = document.getElementById('imageModal');
        var modalImage = document.getElementById('fullImage');

        modal.style.display = 'block';
        modalImage.src = imageSrc;
        modalImage.alt = itemName;
    }

    // Close the modal
    function closeModal() {
        var modal = document.getElementById('imageModal');
        modal.style.display = 'none';
    }

    // Close the modal when clicking the close button
    document.getElementsByClassName('close')[0].onclick = closeModal;

    // Close the modal when clicking outside the image
    window.onclick = function(event) {
        var modal = document.getElementById('imageModal');
        if (event.target == modal) {
            closeModal();
        }
    };

    function customizePackage() {
    // Get the table body
    var tableBody = document.querySelector('.table tbody');

    // Check if customization is already enabled
    var customizationCells = tableBody.querySelectorAll('td textarea');
    if (customizationCells.length === 0) {
        // Iterate through each row in the table
        tableBody.querySelectorAll('tr').forEach(function(row) {
            // Add a blank text area if userInput is "enable"
            var userInput = '<?= $packageDetails['userInput'] ?>';
            if (userInput === 'enable') {
                var textAreaCell = document.createElement('td');
                var textArea = document.createElement('textarea');
                textArea.setAttribute('placeholder', 'enter your choice');
                textAreaCell.appendChild(textArea);
                row.appendChild(textAreaCell);
            }

            // Add quantity meter to each item
            var quantityMeterCell = document.createElement('td');
            var quantityMeter = document.createElement('input');
            quantityMeter.setAttribute('type', 'number');
            quantityMeter.setAttribute('placeholder', 'Quantity');
            quantityMeterCell.appendChild(quantityMeter);
            row.appendChild(quantityMeterCell);
        });

        // Show/hide buttons
        document.getElementById('customizeButton').classList.add('d-none');
        document.getElementById('backButton').classList.remove('d-none');
        document.getElementById('saveButton').classList.remove('d-none');

        // Show the quantity meter and label
        document.getElementById('quantityMeterContainer').style.display = 'block';
    }
}

function backToPackageView() {
    // Remove text areas and quantity meters
    document.querySelectorAll('.table tbody tr td:nth-last-child(2), .table tbody tr td:last-child').forEach(function(cell) {
        cell.removeChild(cell.lastElementChild);
    });

    // Show/hide buttons
    document.getElementById('customizeButton').classList.remove('d-none');
    document.getElementById('backButton').classList.add('d-none');
    document.getElementById('saveButton').classList.add('d-none');
    document.getElementById('quantityMeterContainer').classList.add('d-none');
}

function saveCustomization() {
    // Get the checkout table body
    var checkoutTableBody = document.getElementById('checkoutTableBody');

    // Clear existing rows in checkout table
    checkoutTableBody.innerHTML = '';

    // Iterate through each row in the package details table
    document.querySelectorAll('.table tbody tr').forEach(function(row) {
        // Get data from the row
        var itemName = row.querySelector('td:nth-child(1)').innerText;
        var description = row.querySelector('td:nth-child(2)').innerText;
        var itemDetails = row.querySelector('td:nth-last-child(3)').innerText;
        var customization = row.querySelector('td:nth-last-child(2) textarea') ? row.querySelector('td:nth-last-child(2) textarea').value : '';
        var quantity = row.querySelector('td:last-child input') ? row.querySelector('td:last-child input').value : '';

        // Create a new row in the checkout table
        var newRow = checkoutTableBody.insertRow();
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);

        // Populate the checkout table row with data
        cell1.innerHTML = itemName;
        cell2.innerHTML = description;
        cell3.innerHTML = itemDetails;
        cell4.innerHTML = customization;
        cell5.innerHTML = quantity;
    });

    // Include the number of persons in the checkout details
    var numberOfPersons = document.getElementById('quantityMeter').value;

    // Show checkout container and buttons
    document.getElementById('checkoutContainer').classList.remove('d-none');
    document.getElementById('backToCustomization').classList.remove('d-none');
    document.getElementById('proceedToCheckout').classList.remove('d-none');

    // Hide package view and buttons
    document.getElementById('package-view').classList.add('d-none');
    document.getElementById('customizeButton').classList.add('d-none');
    document.getElementById('backButton').classList.add('d-none');
    document.getElementById('saveButton').classList.add('d-none');
}
    
    function backToCustomization() {
        // Hide checkout container and buttons
        document.getElementById('checkoutContainer').classList.add('d-none');
        document.getElementById('backToCustomization').classList.add('d-none');
        document.getElementById('proceedToCheckout').classList.add('d-none');
    
        // Show package view and buttons
        document.getElementById('package-view').classList.remove('d-none');
        document.getElementById('customizeButton').classList.remove('d-none');
        document.getElementById('backButton').classList.remove('d-none');
        document.getElementById('saveButton').classList.remove('d-none');
    }
    
    function proceedToCheckout() {
    // Extract checkout details and pass them to the next page
    var checkoutDetails = [];
    document.querySelectorAll('#checkoutTableBody tr').forEach(function(row) {
        var item = {
            itemName: row.cells[0].innerText,
            description: row.cells[1].innerText,
            itemDetails: row.cells[2].innerText,
            customization: row.cells[3].innerText,
            quantity: row.cells[4].innerText
        };
        checkoutDetails.push(item);
    });

    // Create a separate JSON object for numberOfPersons
    var numberOfPersons = {
        numberOfPersons: document.getElementById('quantityMeter').value,
        packageAmount: '<?= $packageDetails['amount'] ?>',
        pricingType: '<?= $packageDetails['pricingType'] ?>'
    };

    // Convert checkoutDetails and numberOfPersons to JSON and encode them for URL
    var checkoutDetailsJSON = encodeURIComponent(JSON.stringify(checkoutDetails));
    var numberOfPersonsJSON = encodeURIComponent(JSON.stringify(numberOfPersons));

    // Redirect to the next page with checkoutDetails and numberOfPersons as query parameters
    window.location.href = '?page=checkout&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?=$packCode?>&checkoutDetails=' + checkoutDetailsJSON + '&numberOfPersons=' + numberOfPersonsJSON;
}

    </script>
