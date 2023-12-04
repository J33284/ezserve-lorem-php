<?php

$clientID = $_SESSION['userID'];
$clientType =  $_SESSION['usertype'];

$client = $DB->query("SELECT * FROM client WHERE clientID = '$clientID' and usertype= '$clientType'");

if ($client) {
    // Fetch the client information
    $clientInfo = $client->fetch_assoc();
}
?>

<?= element( 'header' ) ?>

<div id="client-custom "class="client-custom" style="margin-top: 90px ">
      <div class=" container pack-head " style=" top: 50px;">
        <div class="container row">
          <a href="?page=client_view_package&packCode=<?= $packCode = $_POST['packCode']; ?>" class=" col-xl-1 btn-back btn-lg float-end ">
            <i class="bi bi-arrow-left"></i></a>
          <h1 class="col-xl-7 d-flex justify-content-start text-light">Check Out</h1>
         
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
              <h4 class=" p-3 mb-4" style=" border-bottom: 3px solid #fb7e00;"> 2. Delivery Information </h4>
              <h6> Mode of Fulfillment </h6>
              <div class="row d-flex align-items-center my-2 px-5">
                  <div class="form-check row d-flex">
                    <div class="col-5">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                      <label class="form-check-label" for="flexCheckDefault">Pick-up</label> <!--set na if pick-up, pick.up date lg ang accessible-->
                    </div>
                    <div class="col-5">
                       <input type="date" class="form-control"  name="pick-up" id="pick-up" value="<?= $business['pick-up'] ?>" >
                    </div>
                  </div>
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                      <label class="form-check-label" for="flexCheckDefault">Delivery</label>
                  </div>
              </div>
              <hr>
                <div class="row d-flex align-items-center mb-2"> <!-- triggered only kung delivery mode -->
                    <label class="mb-2 " for="address">Delivery Address</label>
                    <input type="text" class="form-control "   name="address" id="address"  >
                </div>
                <div class="row d-flex align-items-center mb-2">
                    <label class="mb-2 " for="deliveryDate">Delivery Date</label>
                    <input type="date" class="form-control " name="deliveryDate" id="deliveryDate"  >
                </div>
               
                
       


          <div class="payment">
              <h4 class=" p-3 mb-4" style=" border-bottom: 3px solid #fb7e00;"> 3. Payment </h4>
              <h6> Mode of Payment </h6>
              <div class="row d-flex align-items-center my-2 px-5">
              <div class="form-check ">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                      <label class="form-check-label" for="flexCheckDefault">On-Site Payment</label>
                  </div>
                  <div class="form-check ">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                      <label class="form-check-label" for="flexCheckDefault">Online Payment</label>
                  </div>
          </div>
        </div> 
    </div> 
</div>
          <?php
            $packCode = $_POST['packCode'];

            $packageDetailsQ = $DB->query("SELECT p.*, c.*, s.*
            FROM package p
            JOIN category c ON p.packCode = c.packCode
            JOIN service s ON c.categoryCode = s.categoryCode
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
                    </tr>
                </thead>
                <tbody>
                    <?php $packageDetailsQ->data_seek(0);?>
                    <?php while ($packageDetails = $packageDetailsQ->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $packageDetails['quantity']; ?></td>
                            <td><?php echo $packageDetails['serviceName']; ?></td>
                            <td>₱<?php echo number_format($packageDetails['price']); ?></td>
                        </tr>

                        <?php
                        // Calculate total for the current item and add to grand total
                        $total = $packageDetails['quantity'] * $packageDetails['price'];
                        $grandTotal += $total;
                        ?>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="total row d-flex sticky-bottom">
                <h3 class="col-7"> Total</h3>
                <h4 class="col-5">₱<?= number_format($grandTotal) ?></h4>
            <!--calculation formula-->
                        <a class="border-top border-bottom voucher-btn row justify-content-center align-items-center" style="height: 60px" href="?page=voucher">
                            <h6 class="col-10"><i class="bi bi-tags"></i>Apply Voucher</h6>
                            <i class="bi bi-chevron-right float end col-2"></i>
                        </a>
                        <form action="?action=payMongo" method="post" >
                            <input type="hidden" name="packCode" value="<?= $packCode ?>">
                        <button type="submit" class="btn btn-primary" style="width:100%">
                            Place Order
                        </button>
                        </form>
                        </div>
                        </div>
                        </div>
                                </div>
                                </div>
                                </div>
                </div>
                </div>
            
                <?= element( 'footer' ) ?>