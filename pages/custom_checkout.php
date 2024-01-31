<!--
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderDetails'])) {
    // Decode the JSON data from the hidden input field
    $orderDetailsJson = $_POST['orderDetails'];
    $orderDetails = json_decode($orderDetailsJson, true);

    // Now, $orderDetails is an associative array containing the order details
    // You can access individual elements like $orderDetails[0]['itemCode'], $orderDetails[0]['itemName'], etc.

    // Example: Print the order details
    echo '<pre>';
    print_r($orderDetails);
    echo '</pre>';
    
    // Proceed with further processing or redirect to the checkout page
}-->


<?php

$businessCode = $_GET['businessCode'];
$branchCode = $_GET['branchCode'];


$clientID = $_SESSION['userID'];
$clientType = $_SESSION['usertype'];

$client = $DB->query("SELECT * FROM client WHERE clientID = '$clientID' AND usertype = '$clientType'");

if ($client) {
    $clientInfo = $client->fetch_assoc();
}         

if (isset($_POST['orderDetails'])) {
    // Retrieve the encoded JSON string from the URL
    $orderDetailsJson = $_POST['orderDetails'];
    // Decode the JSON string to an array
    $checkoutDetails = json_decode($orderDetailsJson, true);

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
                <input type="date" class="form-control" name="pDate" id="pDate" style="display: none;">
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
                    <tr class="sticky-top">
                        <th scope="col">Item</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th> 
                    </tr>
            </thead>
            <tbody>
            <?php
                // Check if $checkoutDetails is an array and if "itemName" key exists
                $totalPrice = 0;
                if (is_array($checkoutDetails) && isset($checkoutDetails[0]['itemName'])) {
                    foreach ($checkoutDetails as $item) :
                        $totalPrice += $item['price']; // Sum up prices
                        ?>
                        <tr>
                            <td><?= trim($item['itemName']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>₱<?= number_format($item['price'], 2) ?></td>
                        </tr>
                    <?php endforeach;
                } else {
                    echo '<tr><td colspan="3">No items in the order</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <div style="padding: 10px;"></div>

        <!-- Total Price Paragraph -->
        <p>Total Price: ₱<?= number_format($totalPrice, 2) ?></p>

    </div>



        <a class="border-top border-bottom voucher-btn row justify-content-center align-items-center" style="height: 60px"  href="?page=voucher&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?= $packCode ?>&grandTotal=<?= $grandTotal ?>">
        <h6 class="col-10"><i class="bi bi-tags"></i>Apply Voucher</h6>
        <i class="bi bi-chevron-right float end col-2"></i>
        </a>

               

        <form action="?action=customPayMongo" method="post">
            <input type="hidden" name="businessCode" value="<?= $businessCode ?>" >
            <input type="hidden" name="branchCode" value="<?= $branchCode ?>" >
            <input type="hidden" name="clientID" value="<?= $clientID ?>">
            <input type="hidden" name="clientName" value="<?= $clientInfo['fname'] . ' ' . $clientInfo['lname'] ?>">
            <input type="hidden" name="mobileNumber" value="<?= $clientInfo['number'] ?>">
            <input type="hidden" name="email" value="<?= $clientInfo['email'] ?>" >
            <input type="hidden" name="totalAmount" value="<?= $totalPrice ?>">
            <input type="hidden" name="orderDetails" value="<?= htmlspecialchars(json_encode($orderDetailsJson)) ?>">
            <input type="hidden" name="pDate">
            <input type="hidden" name="deliveryAddress">
            <input type="hidden" name="deliveryDate">
            <button type="submit" class="btn btn-primary" style="width:100%" id="placeOrderButton" onclick="submitSecondForm()">
            Place Order
            </button>
        </form>

        <form action="?action=customOnsite" method="post">
            <input type="hidden" name="businessCode" value="<?= $businessCode ?>" >
            <input type="hidden" name="branchCode" value="<?= $branchCode ?>" >
            <input type="hidden" name="clientID" value="<?= $clientID ?>">
            <input type="hidden" name="clientName" value="<?= $clientInfo['fname'] . ' ' . $clientInfo['lname'] ?>">
            <input type="hidden" name="mobileNumber" value="<?= $clientInfo['number'] ?>">
            <input type="hidden" name="email" value="<?= $clientInfo['email'] ?>" >
            <input type="hidden" name="totalAmount" value="<?= $totalPrice ?>">
            <input type="hidden" name="pDate">
            <input type="hidden" name="deliveryAddress">
            <input type="hidden" name="deliveryDate">
            <input type="hidden" name="deliveryDate">
            <input type="hidden" name="orderDetails" value="<?= htmlspecialchars(json_encode($orderDetailsJson)) ?>">
            
            

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
    // Get the values from the first form
    var pDateValue = document.getElementById('pDate').value;
    var deliveryDateValue = document.getElementById('deliveryDate').value;
    var deliveryAddressValue = document.getElementById('deliveryAddress').value;

    // Set the values for the hidden inputs in the second form
    document.querySelector('form[action="?action=onsite"] input[name="pDate"]').value = pDateValue;
    document.querySelector('form[action="?action=onsite"] input[name="deliveryDate"]').value = deliveryDateValue;
    document.querySelector('form[action="?action=onsite"] input[name="deliveryAddress"]').value = deliveryAddressValue;

    // Continue with form submission
}
</script>


