<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); ?>

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
            <tr class="clickable-row" onclick="window.location='./details.html'">
              <th scope="row">1</th>
              <td>Puga Funeral Parlor</td>
              <td>Jose Puga</td>
              <td>Funeral Service</td>
            </tr>
          </tbody>
        </table>
      </div> 

<?= element( 'footer' ) ?>
        
