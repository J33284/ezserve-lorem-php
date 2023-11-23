<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$businessCode = $_POST['businessCode'];

// Retrieve all branches for the given business
$businesses = $DB->query("SELECT b.*, br.* FROM business b
        JOIN branches br ON b.businessCode = br.businessCode
        WHERE b.businessCode = '$businessCode'");

$business = $businesses->fetch_assoc();
?>

<?= element('header') ?>

<div class="bus-details">
    
        <div class="container shadow mb-5 bg-white rounded details sticky-top" style="padding: 30px 0px 0px 20px;">
            <div class="row">
                <h1 class="d-flex justify-content-start align-items-center"><?= $business['busName'] ?></h1>
            </div>

            <div class="links border-top">
                <ul class="d-flex justify-content-start align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#About"> About Us </a></li>
                    <li class="nav-item"><a class="nav-link" href="#Branches"> Branches </a></li>
                </ul>
            </div>
        </div>

        <div class="info container d-flex justify-content-center align-items-center">
            <div>
                <div id="About" class="card p-3 shadow p-3 mb-5 bg-white rounded border-0" style="width: 80vw; height: 30vh;">
                    <h2>About Us</h2>
                    <hr>
                    <p><?= $business['about'] ?></p>
                </div>
               
                <div id="Branches" class="card p-3 shadow p-3 mb-5 bg-white rounded border-0 d-flex">
                    <h2> Branches </h2>
                    <hr>
                    <img class="d-flex justify-content-center align-items-center" src="assets/images/sampleMaps.jpg" alt="Google Map">
                    <?php foreach ($businesses as $business) : ?>
                    <form action="?page=client_package" method="post">
                        <input type="hidden" name="branchCode" value="<?= $business['branchCode'] ?>">
                        <button type="submit" class="btn btn-primary view-package" data-business-code="<?= $business['branchCode'] ?>">
                            <?= $business['branchName'] ?>
                        </button>
                    </form>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    
</div>

<?= element('footer') ?>
