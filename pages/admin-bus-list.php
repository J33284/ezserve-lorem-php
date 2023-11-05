<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); 

$businesses = $DB->query("SELECT b.*, bo.* FROM business b
    JOIN business_owner bo ON b.ownerID = bo.ownerID
    WHERE b.status = 1");



?>

<?= element( 'header' ) ?>

<?= element( 'admin-side-nav' ) ?>

<div id= "admin-bus-list" class="admin-bus-list">
<div id= "admin-bus-list" class="admin-bus-list">
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
              <th scope="col">Business Name</th>
              <th scope="col">Business Owner</th>
              <th scope="col">Business Type</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($businesses as $key => $business) : ?>
          <tr class="sticky-top mt-3">
                    <th scope="row"><?= $key + 1 ?></th>
                    <td data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample<?= $business['businessCode'] ?>" role="button">
                        <?= $business['busName'] ?>  
                    </td>
                    <td data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample<?= $business['businessCode'] ?>" role="button">
                        <?= $business['fname'] . ' ' . $business['lname'] ?>

                    </td>
                    <td data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample<?= $business['businessCode'] ?>" role="button">
                        <?= $business['busType'] ?>  
                    </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div> 

<?= element( 'footer' ) ?>
        
