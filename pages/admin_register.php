<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); ?>

<?= element( 'header' ) ?>

<?= element( 'admin-side-nav' ) ?>

<div id= "admin-reg" class="admin-reg">
        <table class="table table-hover table-responsive">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Business Name</th>
              <th scope="col">Accept</th>
              <th scope="col">Reject</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td class="clickable-row" onclick="window.location='./details.html'">Puga Funeral Parlor</td>
              <td><input class="form-check-input" type="checkbox" value="" id="AcceptCheckBox"></td>
              <td><input class="form-check-input" type="checkbox" value="" id="RejectCheckBox"></td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td class="clickable row" onclick="window.location='./details.html'">Balay Kusina</td>
              <td><input class="form-check-input" type="checkbox" value="" id="AcceptCheckBox"></td>
              <td><input class="form-check-input" type="checkbox" value="" id="RejectCheckBox"></td>
            </tr>
          </tbody>
        </table>
      </div> 

<?= element( 'footer' ) ?>
        
