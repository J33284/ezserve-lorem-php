
<?php

$checkoutDataJSON = $_GET['checkoutData'];
$checkoutData = json_decode(urldecode($checkoutDataJSON), true);

// Print all data in JSON format
echo '<pre>';
print_r($checkoutData);
echo '</pre>';  
?>


<?php

$businessCode = $_GET['businessCode'];
$branchCode = $_GET['branchCode'];
$packCode = $_GET['packCode'];


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

<div id="client-custom" class="client-custom" style="margin-top: 90px">
    <div class="container pack-head" style="top: 50px;">
        <div class="container row">
            <a href="?page=client_view_package&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?=$packCode?>" class="col-xl-1 btn-back btn-lg float-end">
                <i class="bi bi-arrow-left"></i>
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

            <!-- Delivery Information -->
            <div class="delivery mb-3">
    <h4 class="p-3 mb-4" style="border-bottom: 3px solid #fb7e00;">2. Delivery</h4>
    <h6></h6>
    <div class="row d-flex align-items-center my-2 px-5">
        <div class="form-check row d-flex">
            <div class="col-5">
                <input class="form-check-input" type="checkbox"  id="pickUpCheckbox" name="pickUpCheckbox">
                <label class="form-check-label" for="pickUpCheckbox">Pick-up</label>
            </div>
            <div class="col-5">
                <input type="date" class="form-control" name="pDate" id="pick-up" style="display: none;">
            </div>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox"  id="deliveryCheckbox" name="deliveryCheckbox">
            <label class="form-check-label" for="deliveryCheckbox">Delivery</label>
        </div>
    </div>

    <!-- Hidden fields for delivery address and delivery date -->
    <div id="deliveryFields" style="display: none;">
        <!-- Add your delivery address and date fields here -->
        <div class="form-group">
            <label for="deliveryAddress">Delivery Address</label>
            <input type="text" class="form-control" id="deliveryAddress" name="dAddress">
        </div>
        <div class="form-group">
            <label for="deliveryDate">Delivery Date</label>
            <input type="date" class="form-control" id="deliveryDate" name="dDate">
        </div>
    </div>
</div>

        
        <div class="payment">
            <h4 class=" p-3 mb-4" style=" border-bottom: 3px solid #fb7e00;"> 3. Payment </h4>
            <h6> Mode of Payment </h6>
        <div class="row d-flex align-items-center my-2 px-5">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="onsitePaymentCheckbox" name="onsitePayment">
            <label class="form-check-label" for="onsitePaymentCheckbox">On-Site Payment</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="onlinePaymentCheckbox" name="onlinePayment">
            <label class="form-check-label" for="onlinePaymentCheckbox">Online Payment</label>
            </div>
        </div>
    </div>
    </div>
        <!-- Order List -->
        <div class="order-list col-4 card border-0 rounded-3 shadow p-3 mb-5 bg-white rounded" style="height: auto">
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
                        <th scope="col">Customization</th>
                    </tr>
                <?php else : ?>
                    <tr class="sticky-top">
                        <th scope="col">Item</th>
                        <th scope="col">Description</th>
                        <th scope="col">Customization</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                    </tr>
                <?php endif; ?>
            </thead>
            <tbody>
                <?php foreach ($checkoutDetails['items'] as $item) : ?>
                    <tr>
                        <td><?= $item['itemName'] ?></td>
                        <td style="max-width: 200px;"><?= $item['description'] ?></td>
                        <td style="max-width: 150px; overflow: hidden;  ellipsis;"><?= $item['customizationValue'] ?></td>
                        <?php if ($checkoutDetails['pricingType'] !== 'per pax') : ?>
                            <td><?= $item['quantityValue'] ?></td>
                            <td><?= '₱' .number_format($item['price'],2) ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="padding: 10px;">
            <?php
            $numericTotal = 0;

            if ($checkoutDetails['pricingType'] === 'per pax') {
                preg_match('/\d+\.\d+/', $checkoutDetails['initialTotal'], $matches);
                $initial = $matches[0];
                preg_match('/\d+\.\d+/', $checkoutDetails['total'], $matches);
                $numericTotal = $matches[0];
            } else {
                preg_match('/\d+\.\d+/', $checkoutDetails['total'], $matches);
                $numericTotal = $matches[0];
            }
            ?>
            
            <?php if ($checkoutDetails['pricingType'] === 'per pax') : ?>
                <p style="font-size: 30px;"><?= '₱' . $initial . ' x ' . $checkoutDetails['quantityMeter'] ?></p>
                <p style="font-size: 30px;">Total: <?= '₱' . number_format($numericTotal, 2) ?></p>
            <?php else : ?>
                <p style="font-size: 30px;">Total: <?= '₱' . number_format($numericTotal, 2) ?></p>
            <?php endif; ?>
        </div>


        <!--a class="border-top border-bottom voucher-btn row justify-content-center align-items-center" style="height: 60px"  href="?page=voucher&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?= $packCode ?>&grandTotal=<?= $grandTotal ?>">
        <h6 class="col-10"><i class="bi bi-tags"></i>Apply Voucher</h6>
        <i class="bi bi-chevron-right float end col-2"></i>
        </a>-->

               

        <form action="?action=payMongo" method="post">
            <input type="hidden" name="businessCode" value="<?= $businessCode ?>" >
            <input type="hidden" name="branchCode" value="<?= $branchCode ?>" >
            <input type="hidden" name="packCode" value="<?= $packCode ?>">
            <input type="hidden" name="clientID" value="<?= $clientID ?>">
            <input type="hidden" name="clientName" value="<?= $clientInfo['fname'] . ' ' . $clientInfo['lname'] ?>">
            <input type="hidden" name="mobileNumber" value="<?= $clientInfo['number'] ?>">
            <input type="hidden" name="email" value="<?= $clientInfo['email'] ?>" >
            <input type="hidden" name="itemList" value="<?= htmlspecialchars(json_encode($checkoutDetails)) ?>">
            <input type="hidden" name="pDate">
            <input type="hidden" name="deliveryAddress">
            <input type="hidden" name="deliveryDate">
            <button type="submit" class="btn btn-primary" style="width:100%" id="placeOrderButton" onclick="submitSecondForm()">
            Place Order
            </button>
        </form>

        <form action="?action=onsite" method="post">
            <input type="hidden" name="businessCode" value="<?= $businessCode ?>" >
            <input type="hidden" name="branchCode" value="<?= $branchCode ?>" >
            <input type="hidden" name="packCode" value="<?= $packCode ?>">
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
    var pickUpDateField = document.getElementById('pick-up');
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
    // Get references to the checkboxes and buttons
    var onsitePaymentCheckbox = document.getElementById('onsitePaymentCheckbox');
    var onlinePaymentCheckbox = document.getElementById('onlinePaymentCheckbox');
    var placeOrderButton = document.getElementById('placeOrderButton');
    var placeOrderButton2 = document.getElementById('placeOrderButton2');

    // Initial check on page load
    togglePlaceOrderButtons();

    // Add event listeners for checkbox changes
    onsitePaymentCheckbox.addEventListener('change', function () {
        if (onsitePaymentCheckbox.checked) {
            onlinePaymentCheckbox.checked = false; // Uncheck online payment if onsite is checked
        }
        togglePlaceOrderButtons();
    });

    onlinePaymentCheckbox.addEventListener('change', function () {
        if (onlinePaymentCheckbox.checked) {
            onsitePaymentCheckbox.checked = false; // Uncheck onsite payment if online is checked
        }
        togglePlaceOrderButtons();
    });

    // Function to toggle the "Place Order" buttons visibility based on checkbox state
    function togglePlaceOrderButtons() {
        if (onsitePaymentCheckbox.checked) {
            // Onsite payment is checked, show placeOrderButton2 and hide placeOrderButton
            placeOrderButton.style.display = 'none';
            placeOrderButton2.style.display = 'block';
        } else {
            // Onsite payment is not checked, show placeOrderButton and hide placeOrderButton2
            placeOrderButton.style.display = 'block';
            placeOrderButton2.style.display = 'none';
        }
    }
});



    function submitSecondForm() {
        // Get values from the first set of input fields
        var pDate = document.getElementById("pick-up").value;
        var deliveryAddress = document.getElementById("deliveryAddress").value;
        var deliveryDate = document.getElementById("deliveryDate").value;

        // Set values in the second form
        document.getElementsByName("pDate")[0].value = pDate;
        document.getElementsByName("deliveryAddress")[0].value = deliveryAddress;
        document.getElementsByName("deliveryDate")[0].value = deliveryDate;

        // Submit the second form
        document.getElementById("secondForm").submit();
    }
</script>


