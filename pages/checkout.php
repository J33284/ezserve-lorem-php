<?php

$businessCode = $_GET['businessCode'];
$branchCode = $_GET['branchCode'];

$clientID = $_SESSION['userID'];
$clientType = $_SESSION['usertype'];

$client = $DB->query("SELECT * FROM client WHERE clientID = '$clientID' and usertype= '$clientType'");

if ($client) {
    $clientInfo = $client->fetch_assoc();
}

$discountedTotal = isset($_POST['discountedTotal']) ? $_POST['discountedTotal'] : null;


?>


<?= element( 'header' ) ?>

<div id="client-custom "class="client-custom" style="margin-top: 90px ">
      <div class=" container pack-head " style=" top: 50px;">
        <div class="container row">
          <a href="?page=client_view_package&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?= $packCode = $_GET['packCode']; ?>" class=" col-xl-1 btn-back btn-lg float-end ">
            <i class="bi bi-arrow-left"></i></a>
          <h1 class="col-xl-7 d-flex justify-content-start">Check Out</h1>
         
          </div>    
       </div>       
      <div class="row d-flex p-5 g-5"> 
       
        <div id="check-out-info" class="check-out-info card col-4  px-5 py-4 " style="width: 50vw;  height:auto; margin: 50px 0 0 80px;">
          <div class="client-part mb-3">
            <h4 class=" p-3 mb-4" style=" border-bottom: 3px solid #fb7e00;"> 1. Customer Information </h4>
            <div class="row d-flex align-items-center mb-2">
                <label class="mb-2 " for="clientName">Client's Name</label>
                <input type="text" class="form-control "   name="clientName" id="fname" value="<?= $clientInfo['fname'] . ' ' . $clientInfo['lname'] ?>" readonly>
            </div>
            <div class="row d-flex align-items-center mb-2">
                <label class="mb-2 " for="mobileNumber">Mobile Number</label>
                <input type="text" class="form-control " name="mobileNumber" id="mobileNumber" value="<?= $clientInfo['number'] ?>" readonly>
            </div>
            <div class="row d-flex align-items-center mb-2">
                <label class="mb-2 " for="email">Email</label>
                <input type="text" class="form-control " name="email" id="email" value="<?= $clientInfo['email'] ?>" readonly>
            </div>
          </div>
          <div class="delivery mb-3">
              <h4 class=" p-3 mb-4" style=" border-bottom: 3px solid #fb7e00;" > </h4>
              <h6>  </h6>
              <div class="row d-flex align-items-center my-2 px-5">
                  <div class="form-check row d-flex">
                    <div class="col-5">
                        <input class="form-check-input" type="hidden" value="" id="pickUpCheckbox" name="fulfillmentMethod">
                        <label class="form-check-label" for="pickUpCheckbox"></label>
                    </div>
                    <div class="col-5">
                       <input type="hidden" class="form-control"  name="pick-up" id="pick-up">
                    </div>
                  </div>
                  <div class="form-check">
                  <input class="form-check-input" type="hidden" value="" id="deliveryCheckbox" name="fulfillmentMethod">
                    <label class="form-check-label" for="deliveryCheckbox"></label>
                  </div>
              </div>
              <hr>
                        <div class="row d-flex align-items-center mb-2" id="deliveryAddress">
                <label class="mb-2 " for="address"></label>
                <input type="hidden" class="form-control " name="address" id="address">
            </div>
            <div class="row d-flex align-items-center mb-2" id="deliveryDate">
                <label class="mb-2 " for="deliveryDate"></label>
                <input type="hidden" class="form-control " name="deliveryDate" id="deliveryDate">
            </div>
               
                
       


          <div class="payment">
              <h4 class=" p-3 mb-4" style=" border-bottom: 3px solid #fb7e00;"> 2. Payment </h4>
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
</div>
          <?php
            $packCode = $_GET['packCode'];

            $packageDetailsQ = $DB->query("SELECT p.*, c.*, i.*
            FROM package p
            JOIN category c ON p.packCode = c.packCode
            JOIN items i ON c.categoryCode = i.categoryCode
            WHERE p.packCode = '$packCode'");

            $packName = $packageDetailsQ->fetch_assoc();
            $grandTotal = 0;
          ?>
          <div class="order-list col-4 card border-0 rounded-3 shadow p-3 mb-5 bg-white rounded" style="height: auto" >
            <h3 class="order-header sticky-top p-3">Order List</h3>
            <h4 class="order-header sticky-top p-3"><?php echo $packName['packName']; ?></h4>
            <hr class="m-0">
            <div class=" order justify-content-center px-4 overflow-scroll">
              <hr>
              <table class="table">
                <thead>
                    <tr class="sticky-top">
                        <th scope="col">Quantity</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $packageDetailsQ->data_seek(0);?>
                    <?php while ($packageDetails = $packageDetailsQ->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $packageDetails['quantity']; ?></td>
                            <td><?php echo $packageDetails['itemName']; ?></td>
                            <td>₱<?php echo number_format($packageDetails['price']); ?></td>
                            <td>
                            <?php
                            $total = $packageDetails['quantity'] * $packageDetails['price'];
                            echo '₱' . number_format($total);
                            
                            ?>
                        </td>

                        </tr>

                        <?php
                        // Calculate total for the current item and add to grand total
                        $total = $packageDetails['quantity'] * $packageDetails['price'];
                        $grandTotal += $total;
                        if (isset($discountedTotal) && is_numeric($discountedTotal)) {
                            // Update total to discounted total
                            $grandTotal = $discountedTotal;
                        }
                        ?>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="total row d-flex sticky-bottom">
                <h3 class="col-7"> Total</h3>
                <h4 class="col-5">₱<?= number_format($grandTotal) ?></h4>
            <!--calculation formula-->
            <a class="border-top border-bottom voucher-btn row justify-content-center align-items-center" style="height: 60px"
            href="?page=voucher&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?= $packCode ?>&grandTotal=<?= $grandTotal ?>">
                <h6 class="col-10"><i class="bi bi-tags"></i>Apply Voucher</h6>
                <i class="bi bi-chevron-right float end col-2"></i>
            </a>


            <form action="?action=payMongo" method="post">
                <input type="hidden" name="packCode" value="<?= $packCode ?>">
                <input type="hidden" name="clientName"  value="<?= $clientInfo['fname'] . ' ' . $clientInfo['lname'] ?>">
                <input type="hidden" name="mobileNumber" value="<?= $clientInfo['number'] ?>">
                <input type="hidden" name="email" value="<?= $clientInfo['email'] ?>" >
                <input type="hidden" name="businessCode" value="<?= $businessCode ?>" >
                <input type="hidden" name="packName" value="<?= $packName['packName'] ?>" >
                <input type="hidden" name="grandTotal" value="<?= $grandTotal ?>">
                <button type="submit" class="btn btn-primary" style="width:100%" id="placeOrderButton">
                    Place Order
                </button>

            </form>

            <form action="?action=onsite" method="post">
                <input type="hidden" name="packCode" value="<?= $packCode ?>">
                <input type="hidden" name="clientName"  value="<?= $clientInfo['fname'] . ' ' . $clientInfo['lname'] ?>">
                <input type="hidden" name="mobileNumber" value="<?= $clientInfo['number'] ?>">
                <input type="hidden" name="email" value="<?= $clientInfo['email'] ?>" >
                <input type="hidden" name="businessCode" value="<?= $businessCode ?>" >
                <input type="hidden" name="packName" value="<?= $packName['packName'] ?>" >
                <input type="hidden" name="grandTotal" value="<?= $grandTotal ?>">
                <input type="hidden" name="clientID" value="<?= $clientID ?>">

                <button type="submit" class="btn btn-primary" style="width:100%" id="placeOrderButton2">
                    Place Order
                </button>

            </form>

           <!-- ... Your HTML code ... -->

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

<!-- ... Your HTML code ... -->
