<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); ?>

<?= element( 'header' ) ?>

<?= element( 'owner-side-nav' ) ?>

<?php
global $DB;

$ownerID = $_SESSION['userID'];

$sql = "SELECT * FROM business WHERE ownerID = $ownerID AND status = 1";
$result = $DB->query($sql);

?>

<div id="own-bus" class="own-bus">
    
<div class="d-flex justify-content-between p-3">
        <h1>My Business</h1>
        <a href="?page=bus-register" id="registerButton" class=" float-end mt-4 btn btn-md btn-outline-dark justify-content-center align-items-center d-flex" style="height: 2em">
            <i class="bi bi-plus-square " >Register your business here!</i>
        </a>
    </div>


    <div class="card-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card mb-3" style="max-width: 400rem;">
                <div class="card-header" style="background-color: #0f3a4b; color: #fff;">
                    <h5 class="card-title"><?= $row['busName'] ?></h5>
                </div>
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="view-business" data-businesscode="<?= $row['businessCode'] ?>">
                        <?= $row['busType'] ?>
                    </div>
                    <a href="?page=branches&businesscode=<?= $row['businessCode'] ?>" class="btn btn-primary">View</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php if ($result->num_rows == 0): ?>
        <div class="card">
            <div class="card-header" style="background-color: #0f3a4b; color: #fff;">
                <h5 class="card-title">My Business</h5>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center" style="height: 50vh;">
                <div class="business-form-background">
                    <a href="?page=bus-register" class="btn btn-dark">
                        <i class="bi bi-plus-square"></i>
                        <span>No Business Record Found, Register your business here!</span>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div> <!-- end of own-bus -->

<script src="assets/js/user.js"></script>
