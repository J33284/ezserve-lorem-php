<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); ?>

<?= element( 'header' ) ?>

<?= element( 'owner-side-nav' ) ?>

<?php
global $DB;
$ownerID = $_SESSION['userID'];

$sql = "SELECT * FROM business WHERE ownerID = $ownerID AND status = 1";
$result = $DB->query($sql);
?>

<?php if ($result->num_rows > 0): ?>
    
    <div id="own-bus" class="own-bus">
        <div class="d-flex justify-content-between p-3">
            <h1 class="text-light">My Business</h1>
            <a href="?page=bus-register" id="registerButton">
                <i class="bi bi-plus-square black-text"></i>
                <span class="black-text text-light">Register your business here!</span>
            </a>
            <a href="#" id="backButton" class="btn-back float-start mt-4" onclick="toggleBack()" style="display: none;">
                <i class="bi bi-arrow-left"></i>
                <span>Back</span>
            </a>
        </div>

        <div id="businessList" style = " width: 75vw; margin-top: 50px;">
            <table class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Business Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <th scope="row"><?= $count++ ?></th>
                            <td>
                                <div class="view-business" data-businesscode="<?= $row['businessCode'] ?>">
                                    <?= $row['busName'] ?>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary view-business" onclick="toggleView()" data-businesscode="<?= $row['businessCode'] ?>">View</button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    

<?php $result->data_seek(0); // Reset the result set pointer to the beginning for displaying details ?>

<?php while ($row = $result->fetch_assoc()): ?>
    <?php include('elements/business.php'); ?>
    <?php endwhile; ?>
    
<?php endif; ?>
</div> <!-- end of own-bus-->

<?php if ($result->num_rows == 0): ?>
      <div id="own-bus" class="own-bus">
      <h1>My Business</h1>
      <div class="d-flex justify-content-center align-items-center p-3" style="height: 50vh;">
          <div class="business-form-background">
              <a href="?page=bus-register">
                  <i class="bi bi-plus-square"></i>
                  <span>No Business Record Found, Register your business here!</span>
              </a>
          </div>
      </div>
  </div>
  <?php endif; ?>

  <script src="assets/js/user.js"></script>  
