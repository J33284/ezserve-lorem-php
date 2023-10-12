<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); ?>

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
              <th scope="col">#</th>
              <th scope="col">Client Name</th>
              <th scope="col">Package Number</th>
              <th scope="col">Total Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr class="clickable-row" onclick="window.location='./details.html'">
              <th scope="row">1</th>
              <td >Eden Punsalan</td>
              <td>ABC123</td>
              <td>500,000</td>
            </tr>
           
          </tbody>
        </table>
      </div> 

<?= element( 'footer' ) ?>
        
