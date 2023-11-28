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
} 
?>

<div id="package-view" class="package-view h-100 " style="margin-top:120px">
    <?php if ($packageDetails): ?>
        <div class="row d-flex justify-content-start align-items-center" style="margin-left: 50px">
            <a href="?page=services" class="col-lg-1 col-sm-1 btn-back btn-lg justify-content-center align-items-center d-flex text-dark">
                <i class="text-light bi bi-arrow-left"></i></a>
            <h1 class="col-lg-6 col-sm-6 d-flex justify-content-start text-light"> <?= $packageDetails['packName'] ?> Details </h1>
        </div>
   
        <div class="container card mt-5 w-75 justify-content-center align-items-center d-flex py-3">
            <table class="table table-hover table-responsive">
                <thead style="border-bottom: 3px solid #fb7e00;">
                    <tr>
                        <th scope="col">Category</th>
                        <th scope="col">Services</th>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grandTotal = 0; // Initialize the grand total

                    $result = $DB->query("SELECT c.*, s.*
                        FROM category c
                        JOIN service s ON c.categoryCode = s.categoryCode
                        WHERE c.packCode = '$packCode'");
                    while ($row = $result->fetch_assoc()): 
                        $total = $row['quantity'] * $row['price']; // Calculate total for the row
                        $grandTotal += $total; // Accumulate total to grand total
                    ?>
                        <tr>
                            <td><?= $row['categoryName'] ?></td>
                            <td><?= $row['serviceName'] ?></td>
                            <td><?= $row['Description'] ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td><?= $row['price'] ?></td>
                            <td><?= $total ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="float-end">
                <div class="total row d-flex sticky-bottom m-5">
                    <h3 class="col-7"> Total:</h3>
                    <h4 class="col-5"><?= $grandTotal ?></h4>
                    <form action="?page=checkout" method="post">
                    <input type="hidden" name="packCode" value="<?= $packCode ?>">
                    <!-- Other form elements can be added here if needed -->
                    <button type="submit" class="btn btn-primary" style="width:100%">
                        Check Out
                    </button>
                </form>

                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center">No details found for the specified package.</p>
    <?php endif; ?>
</div>
