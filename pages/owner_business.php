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
            <h1>My Business</h1>
            <a href="?page=bus-register" id="registerButton" class="text-dark border border-dark m-3 p-2 rounded-3">
                <i class="bi bi-plus-square"></i>
                <span>Register your business here!</span>
            </a>
        </div>

        <div id="businessList" style = " width: 75vw; margin-top: 50px;">
            <table class="table table-hover table-responsive table-bordered " style="border-radius: 10px">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Business Name</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <th scope="row" class="bg-transparent border border-white"><?= $count++ ?></th>
                            <td class="bg-transparent border border-white d-flex justify-content-between ">
                                <div class="view-business d-flex justify-content-center align-items-center" data-businesscode="<?= $row['businessCode'] ?>">
                                    <?= $row['busName'] ?>
                                
                                </div>
                                <a href="?page=branches&businesscode=<?= $row['businessCode'] ?>" class="btn btn-primary mx-5" >View</a>
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

 

