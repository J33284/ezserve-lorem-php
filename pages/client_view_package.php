<?= element('header') ?>
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

    #loginAsClientPopup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: #001f3f; /* Dark blue background color */
        color: #ffffff; /* White text color */
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        z-index: 1000;
    }

    #loginAsClientPopup button {
        margin-top: 10px;
        padding: 10px 15px;
        background-color: #0074cc; /* Blue button color */
        color: #ffffff; /* White text color */
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

</style>

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
                <tr style="border-bottom: 2px solid orange;">
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Additional Detail</th>
                    <?php if ($packageDetails['pricingType'] === 'per pax') : ?>
                    <?php else : ?>
                        <th>Quantity</th>
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
                        <td>
                            <img src="<?= $row['itemImage'] ?>" alt="<?= $row['itemName'] ?>" style="max-width: 200px; height: 180px;"
                            onclick="openModal('<?= $row['itemImage'] ?>', '<?= $row['itemName'] ?>')">
                        </td>
                        <td><?= $row['itemName'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td>
                    <?php if (!empty($itemDetails['detailName']) && !empty($itemDetails['detailValue'])) : ?>
                        <strong><?= $itemDetails['detailName'] ?></strong>: <?= $itemDetails['detailValue'] ?>
                    <?php else : ?>
                        N/A
                    <?php endif; ?>
                </td>
                        <?php if ($packageDetails['pricingType'] === 'per pax') : ?>
                        <?php else : ?>
                            <td><?= $row['quantity']." ". $row['unit'] ?></td>
                            <td><?= '₱' . number_format($row['price'], 2)  ?></td>
                        <?php endif; ?>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Total Container -->
    <div class="container mt-3 text-center" style="background-color: white; padding: 10px; height: auto;">
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
            <p id="initialTotal" style="font-size: 30px;"><?= $total ?></p>

            <!-- Quantity Meter Container -->
            <div id="quantityMeterContainer" style="margin-top: 10px; display:none;">
                <label for="quantityMeter">No. of Persons:</label>
                <input type="number" id="quantityMeter" placeholder="Enter quantity" value="1">
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
            <?php
            $pricingType = $packageDetails['pricingType'];
            if ($pricingType === 'per pax') :
            ?>
                <tr>
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Additional Detail</th>
                    <th>Customization</th>
                </tr>
            <?php else : ?>
                <tr>
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Additional Detail</th>
                    <th>Price</th>
                    <th>Customization</th>
                    <th></th> 

                </tr>
            <?php endif; ?>
        </thead>

        <!-- Table Body -->
        <tbody id="checkoutTableBody">
            <!-- Checkout table content will be added dynamically -->
        </tbody>
    </table>

    <div class="container mt-3 text-center" style="background-color: white; padding: 10px; height: auto;">
        <h2 id="checkoutTotal">Total: ₱0.00</h2>
    </div>
    
    <!-- Back and Checkout Buttons -->
    <div class="container mt-3 text-center">
            <button id="backToCustomization" class="btn btn-secondary d-none" onclick="backToCustomization()">Back to Customization</button>
            <button id="proceedToCheckout" class="btn btn-success d-none" onclick="proceedToCheckout()">Proceed to Checkout</button>
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
        var packageDetails = <?php echo json_encode($packageDetails); ?>;
        var pricingType = packageDetails['pricingType'];

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

    var customizationApplied = false; // Add this global variable

function customizePerPax() {
    if (!customizationApplied) {
        var tableBody = document.querySelector('#package-view table tbody');
        var rows = tableBody.querySelectorAll('tr');

        // Add a new column with a textarea for 'per pax' pricing
        rows.forEach(function(row) {
            var textareaCell = document.createElement('td');
            var textarea = document.createElement('textarea');
            textarea.placeholder = 'Enter customization';
            textarea.className = 'form-control';
            textareaCell.appendChild(textarea);
            row.appendChild(textareaCell);
        });

        // Show the quantity meter container
        document.getElementById('quantityMeterContainer').style.display = 'block';

        customizationApplied = true;
    }
}

    function customizeOther() {
        var tableBody = document.querySelector('#package-view table tbody');
        var rows = tableBody.querySelectorAll('tr');

        // Add two new columns with textarea and quantity meter for other pricing types
        rows.forEach(function(row) {
            var textareaCell = document.createElement('td');
            var textarea = document.createElement('textarea');
            textarea.placeholder = 'Enter customization';
            textarea.className = 'form-control';
            textareaCell.appendChild(textarea);
            row.appendChild(textareaCell);

            var quantityCell = document.createElement('td');
            var quantityInput = document.createElement('input');
            quantityInput.type = 'number';
            quantityInput.placeholder = 'Enter quantity';
            quantityInput.className = 'form-control';
            quantityInput.value = 1;
            quantityInput.min = 1;
            quantityCell.appendChild(quantityInput);
            row.appendChild(quantityCell);
        });

    }

    function backToPackageView() {
    var tableBody = document.querySelector('#package-view table tbody');
    var rows = tableBody.querySelectorAll('tr');

    // Determine pricing type
    var pricingType = <?php echo json_encode($packageDetails['pricingType']); ?>;

    if (pricingType === 'per pax') {
        // Remove the two last cells for 'per pax' pricing
        rows.forEach(function (row) {
            row.removeChild(row.lastElementChild); // Remove the last cell
        });

        // Hide the quantity meter container
        document.getElementById('quantityMeterContainer').style.display = 'none';
    } else {
        // Remove the last cell for other pricing types
        rows.forEach(function (row) {
            row.removeChild(row.lastElementChild); // Remove the last 
            row.removeChild(row.lastElementChild); // Remove the second last cell
            
        });

        // Hide the quantity meter container
        document.getElementById('quantityMeterContainer').style.display = 'none';
    }

    // Hide back button
    document.getElementById('backButton').classList.add('d-none');
    document.getElementById('saveButton').classList.add('d-none');
    document.getElementById('customizeButton').classList.remove('d-none');

    customizationApplied = false;
}



function saveCustomization() {
    // Hide the package view
    document.getElementById('package-view').classList.add('d-none');

    var packageDetails = <?php echo json_encode($packageDetails); ?>;
    var pricingType = packageDetails['pricingType'];

    var checkoutTableBody = document.getElementById('checkoutTableBody');
    checkoutTableBody.innerHTML = ''; // Clear existing content

    var tableBody = document.querySelector('#package-view table tbody');
    var rows = tableBody.querySelectorAll('tr');

    var total = 0; // Initialize the total variable

    rows.forEach(function (row) {
        var itemName = row.children[1].innerText;
        var description = row.children[2].innerText;
        var additionalDetail = row.children[3].innerText;

        var checkoutRow = document.createElement('tr');
        checkoutRow.innerHTML = '<td><img src="' + row.children[0].querySelector('img').src + '" alt="' + itemName + '" style="max-width: 100px; height: 80px;"></td>' +
            '<td>' + itemName + '</td>' +
            '<td>' + description + '</td>' +
            '<td>' + additionalDetail + '</td>';

        var customizationValue = '';
        var quantityValue = 1; // Default quantity value

        if (pricingType === 'per pax') {
            // Add textarea for 'per pax' pricing
            customizationValue = row.children[4].querySelector('textarea').value;
            checkoutRow.innerHTML += '<td>' + customizationValue + '</td>';

            // Multiply the total by the number of persons (quantity meter)
            var quantityMeterValue = document.getElementById('quantityMeter').value;
            total = parseFloat(packageDetails['amount']) * parseFloat(quantityMeterValue);
        } else {
            var priceText = row.children[5].innerText;
            // Extract numeric part from price text (assuming it's formatted as "₱X,XXX.XX")
            var price = parseFloat(priceText.replace('₱', '').replace(',', ''));

            customizationValue = row.children[6].querySelector('textarea').value;
            quantityValue = parseFloat(row.children[7].querySelector('input').value);

            checkoutRow.innerHTML +=
                '<td>' + '₱' + price.toFixed(2) + '</td>' +
                '<td>' + customizationValue + '</td>' +
                '<td>' + quantityValue + '</td>';

            // Calculate total for other pricing types
            total += price * quantityValue;

        }

        checkoutTableBody.appendChild(checkoutRow);
    });

    // Show the checkout container
    document.getElementById('checkoutContainer').classList.remove('d-none');

    // Show the "Back to Customization" and "Proceed to Checkout" buttons
    document.getElementById('backToCustomization').classList.remove('d-none');
    document.getElementById('proceedToCheckout').classList.remove('d-none');

    // Update the total in the checkout container
    document.getElementById('checkoutTotal').innerText = 'Total: ₱' + total.toFixed(2);
}


    function backToCustomization() {
    // Show the package view and hide the checkout container
    document.getElementById('package-view').classList.remove('d-none');
    document.getElementById('checkoutContainer').classList.add('d-none');
}


    function proceedToCheckout() {
        // Collect data from the customization
        var packageDetails = <?php echo json_encode($packageDetails); ?>;
        var pricingType = packageDetails['pricingType'];
        var totalValue = document.getElementById('initialTotal').innerText;

        var checkoutData = {};

        // Include pricing type in the JSON
        checkoutData['pricingType'] = pricingType;
        checkoutData['initialTotal'] = totalValue;

        var tableBody = document.querySelector('#package-view table tbody');
        var rows = tableBody.querySelectorAll('tr');
        var itemsData = [];

        rows.forEach(function (row) {
            var itemName = row.children[1].innerText;
            var description = row.children[2].innerText;
            
            var customizationValue = '';
            var quantityValue = 1; // Default quantity value

            if (pricingType === 'per pax') {
                customizationValue = row.children[4].querySelector('textarea').value;
                var quantityMeterValue = document.getElementById('quantityMeter').value;
            } else {
                var priceText = row.children[5].innerText;
                var price = parseFloat(priceText.replace('₱', '').replace(',', ''));
                customizationValue = row.children[6].querySelector('textarea').value;
                quantityValue = parseFloat(row.children[7].querySelector('input').value);
            }

            itemsData.push({
                itemName: itemName,
                description: description,
                customizationValue: customizationValue,
                quantityValue: quantityValue,
                price: price

            });
        });

        // Include values from the quantity meter container
        var quantityMeterValue = document.getElementById('quantityMeter').value;
        checkoutData['quantityMeter'] = quantityMeterValue;

        // Include the total calculation
        var total = document.getElementById('checkoutTotal').innerText;
        checkoutData['total'] = total;

        // Include items data
        checkoutData['items'] = itemsData;

        // Convert the checkoutData object to JSON
        var checkoutDataJSON = JSON.stringify(checkoutData);
        var clientType = <?php echo json_encode($clientType); ?>;

        if (clientType === 'business owner' || clientType === null) {
            // Display the pop-up container
            document.getElementById('loginAsClientPopup').style.display = 'block';

            // Set a timeout to hide the pop-up after 3 seconds
            setTimeout(function () {
                document.getElementById('loginAsClientPopup').style.display = 'none';
            }, 2000);        
        } else {
            
            window.location.href = '?page=checkout&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?=$packCode?>&checkoutData=' + encodeURIComponent(checkoutDataJSON);

        }
        
    }
    
    function redirectLogout() {
    window.location.href = '?action=logout';
    }

    function redirectLogin() {
        // Redirect to login page
        window.location.href = '?page=login';
    }

</script>





