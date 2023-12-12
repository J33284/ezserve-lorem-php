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
                <i class="bi bi-plus-square text-light">Register your business here!</i>
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
                                <a href="?page=branches&businesscode=<?= $row['businessCode'] ?>" class="btn btn-primary" >View</a>

                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>    
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

  <style>

.table thead th {
        background-color: #F6982E; 
        color: white; 
    }
    
    .table {
        border-radius: 20px; /* Adjust the value as needed */
        overflow: hidden; /* Hide overflow content from rounded corners */
    }

    .table thead th:first-child {
        border-top-left-radius: 10px; /* Adjust the value as needed */
    }

    .table thead th:last-child {
        border-top-right-radius: 10px; /* Adjust the value as needed */
    }

    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 10px; /* Adjust the value as needed */
    }

    .table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 10px; /* Adjust the value as needed */
    }

</style>


