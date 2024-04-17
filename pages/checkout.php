
<!-- <?php

$checkoutDataJSON = $_GET['checkoutData'];
$checkoutData = json_decode(urldecode($checkoutDataJSON), true);

// Print all data in JSON format
echo '<pre>';
print_r($checkoutData);
echo '</pre>';  
?> -->

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


<!-- Leaflet Search Plugin -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-search/dist/leaflet-search.min.css" />
<script src="https://unpkg.com/leaflet-search/dist/leaflet-search.min.js"></script>

<?php

$businessCode = $_GET['businessCode'];
$branchCode = $_GET['branchCode'];
$packCode = $_GET['packCode'];

$discountedTotal = $_GET['discountedTotal'] ?? null;



$clientID = $_SESSION['userID'];
$clientType = $_SESSION['usertype'];

$client = $DB->query("SELECT * FROM client WHERE clientID = '$clientID' AND usertype = '$clientType'");

if ($client) {
    $clientInfo = $client->fetch_assoc();
}         

if (isset($_GET['checkoutData'])) {
    // Retrieve the encoded JSON string from the URL
    $encodedDetails = $_GET['checkoutData'];

    // Decode the JSON string to an array
    $checkoutDetails = json_decode(urldecode($encodedDetails), true);
}

?>

<?= element('header') ?>

<div id="client-custom" class="client-custom" style="margin-top: 120px">
    <div class="container pack-head" style="top: 50px;">
        <div class="container row">
            <a href="?page=client_view_package&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?=$packCode?>" class="col-xl-1 btn-back btn-lg float-end">
                <i class="bi bi-arrow-left text-dark"></i>
            </a>
            <h1 class="col-xl-7 d-flex justify-content-start">Check Out</h1>
        </div>
    </div>

    <div class="row d-flex p-5 g-5">
        <!-- Customer Information -->
        <div id="check-out-info" class="check-out-info card col-4 px-5 py-4" style="width: 50vw;  height:auto; margin: 50px 0 0 80px;">
            <div class="client-part mb-3">
                <h4 class=" p-3 mb-4" style=" border-bottom: 3px solid #fb7e00;">1. Customer Information</h4>
                <div class="row d-flex align-items-center mb-2">
                    <label class="mb-2" for="clientName">Client's Name</label>
                    <input type="text" class="form-control" name="clientName" id="fname" value="<?= $clientInfo['fname'] . ' ' . $clientInfo['lname'] ?>" readonly>
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <label class="mb-2" for="mobileNumber">Mobile Number</label>
                    <input type="text" class="form-control" name="mobileNumber" id="mobileNumber" value="<?= $clientInfo['number'] ?>" readonly>
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <label class="mb-2" for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="<?= $clientInfo['email'] ?>" readonly>
                </div>
            </div>

            <!-- Pick-up and Delivery Information -->
            <div class="delivery mb-3">
                <h4 class="p-3 mb-4" style="border-bottom: 3px solid #fb7e00;">2. Delivery</h4>
                <div class="row d-flex align-items-center my-2 px-5">
                    <div class="form-check row d-flex">
                        <div class="col-5">
                            <input class="form-check-input" type="checkbox" id="pickUpCheckbox" name="pickUpCheckbox" <?php echo isset($_POST['pickUpCheckbox']) && $_POST['pickUpCheckbox'] == 'on' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="pickUpCheckbox">Pick-up</label>
                        </div>
                        <div class="col-5">
                            <input type="date" class="form-control" id="pDate" name="pDate" style="display: <?php echo isset($_POST['pickUpCheckbox']) && $_POST['pickUpCheckbox'] == 'on' ? 'block' : 'none'; ?>" value="<?php echo isset($_POST['pDate']) ? $_POST['pDate'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="deliveryCheckbox" name="deliveryCheckbox" <?php echo isset($_POST['deliveryCheckbox']) && $_POST['deliveryCheckbox'] == 'on' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="deliveryCheckbox">Delivery</label>
                    </div>
                </div>

                <!-- delivery address and delivery date -->
                <div id="deliveryFields" style="display: <?php echo isset($_POST['deliveryCheckbox']) && $_POST['deliveryCheckbox'] == 'on' ? 'block' : 'none'; ?>">
                    <div class="form-group">
                        <label for="deliveryAddress">Delivery Address</label>
                        <input type="text" class="form-control" id="deliveryAddress" name="deliveryAddress" value="<?php echo isset($_POST['deliveryAddress']) ? $_POST['deliveryAddress'] : ''; ?>">
                        <div id="map" style="height: 400px; width: 700px;"></div> 
                    </div>
                    <div class="form-group">
                        <label for="deliveryDate">Delivery Date</label>
                        <input type="datetime-local" class="form-control" id="deliveryDate" name="deliveryDate" value="<?php echo isset($_POST['deliveryDate']) ? $_POST['deliveryDate'] : ''; ?>">
                    </div>
                </div>
                </div>


            <!-- Payment Information -->
            <div class="payment">
                <h4 class=" p-3 mb-4" style=" border-bottom: 3px solid #fb7e00;">3. Payment</h4>
                <h6>Mode of Payment</h6>
                <div class="row d-flex align-items-center my-2 px-5">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="onsitePaymentCheckbox" name="onsitePayment" <?php echo isset($_POST['onsitePayment']) && $_POST['onsitePayment'] == 'on' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="onsitePaymentCheckbox">On-Site Payment</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="onlinePaymentCheckbox" name="onlinePayment" <?php echo isset($_POST['onlinePayment']) && $_POST['onlinePayment'] == 'on' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="onlinePaymentCheckbox">Online Payment</label>
                    </div>
                </div>
            </div>
            </div>


        <!-- Order List -->
        <div class="order-list col-4 card border-0 rounded-3 shadow p-3 mb-5 bg-white rounded" style="height: auto; margin-left: 50px">
        <h3 class="order-header sticky-top p-3">Order List</h3>
        <hr class="m-0">
        <div class="order justify-content-center px-4 overflow-auto">
        <hr>
        <table class="table">
            <thead>
                <?php if ($checkoutDetails['pricingType'] === 'per pax') : ?>
                    <tr class="sticky-top">
                        <th scope="col">Item</th>
                        <th scope="col">Description</th>
                        <th scope="col">Variation</th>
                    </tr>
                <?php else : ?>
                    <tr class="sticky-top">
                        <th scope="col">Item</th>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                    </tr>
                <?php endif; ?>
            </thead>
            <tbody>
            <?php if (isset($checkoutDetails['packageDetails']) && is_array($checkoutDetails['packageDetails'])) : ?>
            <?php for ($i = 1; $i < count($checkoutDetails['packageDetails']); $i++) : ?>
                <?php $item = $checkoutDetails['packageDetails'][$i]; ?>
                <tr>
                    <td><?= $item['itemName'] ?></td>
                    <td><?= $item['description'] ?></td>
                    <td><?php 
                        if (isset($item['selectedOptions']) && is_array($item['selectedOptions']) && count($item['selectedOptions']) > 1) {
                            echo implode(', ', array_slice($item['selectedOptions'], 1)); // Skip the first element
                        } else {
                            echo '-';
                        }
                    ?></td>
                <?php if ($checkoutDetails['pricingType'] !== 'per pax') : ?>
                    <td><?= $item['quantityValue'] ?></td>
                    <td><?= '₱' . number_format($item['price'], 2) ?></td>
                <?php endif; ?>
            </tr>
        <?php endfor; ?>
    <?php else : ?>
        <tr>
            <td colspan="4">No package details found.</td>
        </tr>
    <?php endif; ?>
            </tbody>

        </table>

        <div style="padding: 10px;">
            <?php
            $numericTotal = 0;

            if ($checkoutDetails['pricingType'] === 'per pax') {
                preg_match('/\d+\.\d+/', $checkoutDetails['initialTotal'], $matches);
                $initial = $matches[0];
                preg_match('/\d+\.\d+/', $checkoutDetails['initialTotal'], $matches);
                $numericTotal = $matches[0];
            } else {
                preg_match('/\d+\.\d+/', $checkoutDetails['initialTotal'], $matches);
                $numericTotal = $matches[0];
            }
            ?>
            <div class="mb-3">
            <?php if ($checkoutDetails['pricingType'] === 'per pax') : ?>
                <h5 ><?= '₱' . $initial . ' x ' . $checkoutDetails['quantityMeterValue'] ?></h5>
                <p class="m-0">Subtotal: <?= '₱' . number_format($numericTotal, 2) ?></p>
            <?php else : ?>
                <h5 class="m-0" >Subtotal: <?= '₱' . number_format($numericTotal, 2) ?></h5>
            <?php endif; ?>
           
            <?php 
        
        if ($discountedTotal != 0): ?>
           
            <p class="m-0">Discount: <?= '₱' . number_format($numericTotal - $discountedTotal, 2) ?></p>
            </div>
            <h2> Total: <?= '₱' . number_format($discountedTotal, 2) ?></h2>
            </div>
            <?php endif; ?>
            

        <a class="border-top border-bottom voucher-btn row justify-content-center align-items-center" style="height: 60px"  
            href="?page=voucher&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?= $packCode ?>&grandTotal=<?= $numericTotal ?>&checkoutData=<?= urlencode(json_encode($checkoutDetails)) ?>">
            <h6 class="col-10"><i class="bi bi-tags"></i>Apply Voucher</h6>
            <i class="bi bi-chevron-right float end col-2"></i>
        </a>



        <?php
        $selectBusinessQuery = "SELECT BusName FROM business WHERE businessCode = '$businessCode'";
        $businessResult = $DB->query($selectBusinessQuery);
        $businessRow = $businessResult->fetch_assoc();
        $busName = $businessRow['BusName'];
        
        // Query to select branch name based on branch code
        $selectBranchQuery = "SELECT branchName FROM branches WHERE branchCode = '$branchCode'";
        $branchResult = $DB->query($selectBranchQuery);
        $branchRow = $branchResult->fetch_assoc();
        $branchName = $branchRow['branchName'];
        
        // Query to select package name based on package code
        $selectPackageQuery = "SELECT packName FROM package WHERE packCode = '$packCode'";
        $packageResult = $DB->query($selectPackageQuery);
        $packageRow = $packageResult->fetch_assoc();
        $packName = $packageRow['packName'];
        
        ?>

        <form action="?action=payMongo" method="post">
            <input type="hidden" name="businessCode" value="<?= $businessCode ?>" >
            <input type="hidden" name="branchCode" value="<?= $branchCode ?>" >
            <input type="hidden" name="busName" value="<?= $busName ?>" >
            <input type="hidden" name="branchName" value="<?= $branchName ?>" >
            <input type="hidden" name="packName" value="<?= $packName ?>">
            <input type="hidden" name="discountedTotal" value="<?= $discountedTotal ?>">
            <input type="hidden" name="clientID" value="<?= $clientID ?>">
            <input type="hidden" name="clientName" value="<?= $clientInfo['fname'] . ' ' . $clientInfo['lname'] ?>">
            <input type="hidden" name="mobileNumber" value="<?= $clientInfo['number'] ?>">
            <input type="hidden" name="email" value="<?= $clientInfo['email'] ?>" >
            <input type="hidden" name="itemList" value="<?= htmlspecialchars(json_encode($checkoutDetails)) ?>">
            <input type="hidden" name="pDateM">
            <input type="hidden" name="deliveryAddressM">
            <input type="hidden" name="deliveryDateM">
            <button type="submit" class="btn btn-primary" style="width:100%" id="placeOrderButton" onclick="submitSecondForm()">
            Place Order
            </button>
        </form>

        <form action="?action=onsite" method="post">
            <input type="hidden" name="businessCode" value="<?= $businessCode ?>" >
            <input type="hidden" name="branchCode" value="<?= $branchCode ?>" >
            <input type="hidden" name="busName" value="<?= $busName ?>" >
            <input type="hidden" name="branchName" value="<?= $branchName ?>" >
            <input type="hidden" name="packName" value="<?= $packName ?>">
            <input type="hidden" name="discountedTotal" value="<?= $discountedTotal ?>">
            <input type="hidden" name="clientID" value="<?= $clientID ?>">
            <input type="hidden" name="clientName" value="<?= $clientInfo['fname'] . ' ' . $clientInfo['lname'] ?>">
            <input type="hidden" name="mobileNumber" value="<?= $clientInfo['number'] ?>">
            <input type="hidden" name="email" value="<?= $clientInfo['email'] ?>" > 
            <input type="hidden" name="pDate">
            <input type="hidden" name="deliveryAddress">
            <input type="hidden" name="deliveryDate">
            <input type="hidden" name="itemList" value="<?= htmlspecialchars(json_encode($checkoutDetails)) ?>">

            <button type="submit" class="btn btn-primary" style="width:100%" id="placeOrderButton2" onclick="submitSecondForm()">
            Place Order
            </button>
        </form>
    
    </div>
</div>
   

<script>

document.addEventListener('DOMContentLoaded', function () {
    var pickUpCheckbox = document.getElementById('pickUpCheckbox');
    var pickUpDateField = document.getElementById('pDate');
    var deliveryCheckbox = document.getElementById('deliveryCheckbox');
    var deliveryFields = document.getElementById('deliveryFields');

    pickUpCheckbox.addEventListener('change', function () {
        if (pickUpCheckbox.checked) {
            pickUpDateField.style.display = 'block';
            deliveryCheckbox.checked = false; // Uncheck delivery if pickup is checked
            deliveryFields.style.display = 'none';
        } else {
            pickUpDateField.style.display = 'none';
        }
    });

    deliveryCheckbox.addEventListener('change', function () {
        if (deliveryCheckbox.checked) {
            deliveryFields.style.display = 'block';
            pickUpCheckbox.checked = false; // Uncheck pickup if delivery is checked
            pickUpDateField.style.display = 'none';
        } else {
            deliveryFields.style.display = 'none';
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    var onsitePaymentCheckbox = document.getElementById('onsitePaymentCheckbox');
    var onlinePaymentCheckbox = document.getElementById('onlinePaymentCheckbox');
    var placeOrderButton = document.getElementById('placeOrderButton');
    var placeOrderButton2 = document.getElementById('placeOrderButton2');

    togglePlaceOrderButtons();

    onsitePaymentCheckbox.addEventListener('change', function () {
        if (onsitePaymentCheckbox.checked) {
            onlinePaymentCheckbox.checked = false; 
        }
        togglePlaceOrderButtons();
    });

    onlinePaymentCheckbox.addEventListener('change', function () {
        if (onlinePaymentCheckbox.checked) {
            onsitePaymentCheckbox.checked = false; 
        }
        togglePlaceOrderButtons();
    });

    function togglePlaceOrderButtons() {
        if (onsitePaymentCheckbox.checked) {
            placeOrderButton.style.display = 'none';
            placeOrderButton2.style.display = 'block';
        } else {
            placeOrderButton.style.display = 'block';
            placeOrderButton2.style.display = 'none';
        }
    }
});


function submitSecondForm() {
    // Get the values from the first form
    var pDateValue = document.getElementById('pDate').value;
    var deliveryDateValue = document.getElementById('deliveryDate').value;
    var deliveryAddressValue = document.getElementById('deliveryAddress').value;

    // Set the values for the hidden inputs in the second form
    document.querySelector('form[action="?action=onsite"] input[name="pDate"]').value = pDateValue;
    document.querySelector('form[action="?action=onsite"] input[name="deliveryDate"]').value = deliveryDateValue;
    document.querySelector('form[action="?action=onsite"] input[name="deliveryAddress"]').value = deliveryAddressValue;

    document.querySelector('form[action="?action=payMongo"] input[name="pDateM"]').value = pDateValue;
    document.querySelector('form[action="?action=payMongo"] input[name="deliveryDateM"]').value = deliveryDateValue;
    document.querySelector('form[action="?action=payMongo"] input[name="deliveryAddressM"]').value = deliveryAddressValue;

}

var map;
    var marker;

    function initializeMap() {
        if (!map) {
            map = L.map('map').setView([10.7202, 122.5621], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            marker = L.marker([10.7202, 122.5621], { draggable: true }).addTo(map);

            map.on('click', function (e) {
                updateAddressInput(e.latlng.lat, e.latlng.lng);
                marker.setLatLng(e.latlng); // Update marker position on click
            });
        }
        var mapDiv = document.getElementById("map");
        mapDiv.style.display = "block";
        map.invalidateSize();
    }

    function updateAddressInput(lat, lng) {
        // Reverse geocode to get address from latlng
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
            .then(response => response.json())
            .then(data => {
                var address = data.display_name;
                document.getElementById('deliveryAddress').value = address;
            });
    }

    // Event listener for delivery address field click
    document.getElementById('deliveryAddress').addEventListener('click', function () {
        initializeMap();
    });
</script>


