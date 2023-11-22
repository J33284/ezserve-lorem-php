<?= element('header') ?>

<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

// Get the package code from the URL
$packCode = $_GET['packCode'];

// Retrieve package details from the database based on the package code
$packageDetailsQ = $DB->query("SELECT p.*, c.*, s.*
    FROM package p
    JOIN category c ON p.packCode = c.packCode
    JOIN service s ON c.categoryCode = s.categoryCode
    WHERE p.packCode = '$packCode'");


if ($packageDetailsQ) {
  
    $packageDetails = $packageDetailsQ->fetch_assoc();
} else {
   
    echo "Error executing the query.";
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if ($packageDetails): ?>
                <h2 class="text-center"><?= $packageDetails['packName'] ?> Details</h2>
                <form class="mx-auto">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" id="category" value="<?= $packageDetails['categoryName'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="service">Service</label>
                        <input type="text" class="form-control" id="service" value="<?= $packageDetails['serviceName'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price" value="<?= $packageDetails['price'] ?>" readonly>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-center">No details found for the specified package.</p>
            <?php endif; ?>
        </div>
    </div>
</div>





</body>
</html>
