<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' );

$payment = $DB->query("SELECT c.*, p.* FROM client c
    JOIN payment p ON p.clientID = c.clientID
    ");

?>

<?= element( 'header' ) ?>

<?= element( 'owner-side-nav' ) ?>


<div id= "owner-order-list" class="owner-order-list">
<div class=" d-flex justify-content-between p-3">
    <h1 class="page-title">Client Orders</h1>
</div>
          <div id="searchbar" class="d-flex my-3 float-end">
            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
            <span class="search-btn input-group-text border-0">
              <i class="bi bi-search"></i>
            </span>
          </div>
          
        <table class="table table-hover table-responsive">
          <thead>
            <tr>
              <th scope="col">Transaction No.</th>
              <th scope="col">Client Name</th>
              <th scope="col">Package Code</th>
              <th scope="col">Total Amount</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr >
              <th scope="row">1</th>
              <td><?= $payment['fname'] . ' ' . $payment['lname'] ?></td>
              <td><?= $payment['packCode'] ?></td>
              <td><?= $payment['totalAmount'] ?></td>
              <td><button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPayment<?= $payment['packCode'] ?>">View</button></td>

              <div class="offcanvas offcanvas-top rounded-3" tabindex="-1" id="offcanvasPayment<?= $payment['packCode'] ?>" style="width: 50vw; height: 50vh; margin: 150px 0 0 25vw;">
                            <div class="offcanvas-header">
                            <h3 class="offcanvas-title p-3">Transaction Receipt</h3>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                            </div>
                            <div class="offcanvas-body px-5">
                            Order items, delivery date and address, mode of payment, mode of fulfillment, everything
                            </div>
                            
                        </div>
            </tr>
           
          </tbody>
        </table>
      </div> 


        
