<?php

$businessCode = $_GET['businessCode'];
$branchCode = $_GET['branchCode'];

$clientID = $_SESSION['userID'];
$clientType = $_SESSION['usertype'];

$client = $DB->query("SELECT * FROM client WHERE clientID = '$clientID' AND usertype = '$clientType'");

if ($client) {
    $clientInfo = $client->fetch_assoc();
}

if (isset($_GET['checkoutDetails'])) {
    // Retrieve the encoded JSON string from the URL
    $encodedDetails = $_GET['checkoutDetails'];

    // Decode the JSON string to an array
    $checkoutDetails = json_decode(urldecode($encodedDetails), true);
}

?>

<?= element('header') ?>

<div id="client-custom" class="client-custom" style="margin-top: 90px">
    <div class="container pack-head" style="top: 50px;">
        <div class="container row">
            <a href="?page=client_view_package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>&packCode=<?= $packCode = $_GET['packCode']; ?>" class="col-xl-1 btn-back btn-lg float-end">
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
                <h4 class=" p-3 mb-4" style=" border-bottom: 3px solid #fb7e00;"></h4>
                <h6></h6>
                <div class="row d-flex align-items-center my-2 px-5">
                    <!-- ... (Delivery method checkboxes) ... -->
                </div>
                <hr>
                <div class="row d-flex align-items-center mb-2" id="deliveryAddress">
                    <label class="mb-2" for="address"></label>
                    <input type="hidden" class="form-control" name="address" id="address">
                </div>
                <div class="row d-flex align-items-center mb-2" id="deliveryDate">
                    <label class="mb-2" for="deliveryDate"></label>
                    <input type="hidden" class="form-control" name="deliveryDate" id="deliveryDate">
                </div>
            </div>
        </div>

        <!-- Order List -->
        <div class="order-list col-4 card border-0 rounded-3 shadow p-3 mb-5 bg-white rounded" style="height: auto">
            <h3 class="order-header sticky-top p-3">Order List</h3>
            <hr class="m-0">
            <div class="order justify-content-center px-4 overflow-scroll">
                <hr>
                <table class="table">
                    <thead>
                        <tr class="sticky-top">
                            <th scope="col">Item</th>
                            <th scope="col">Customization</th>
                            <th scope="col">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($checkoutDetails as $item) : ?>
                            <tr>
                                <td><?= $item['itemName'] ?></td>
                                <td><?= $item['customization'] ?></td>
                                <td><?= $item['quantity'] ?></td>                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- ... (Total and other order details) ... -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get references to the checkboxes and buttons
        var onsitePaymentCheckbox = document.getElementById('onsitePaymentCheckbox');
        var onlinePaymentCheckbox = document.getElementById('onlinePaymentCheckbox');
        var placeOrderButton = document.getElementById('placeOrderButton');
        var placeOrderButton2 = document.getElementById('placeOrderButton2');

        // Initial check on page load
        togglePlaceOrderButtons();

        // Add event listener for checkbox change
        onsitePaymentCheckbox.addEventListener('change', togglePlaceOrderButtons);

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
</script>

<!-- Your existing code for scripts... -->

