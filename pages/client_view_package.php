<?= element('header') ?>


<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$clientID = $_SESSION['userID'];
$client = $_SESSION['usertype'];

$businessCode = $_GET['businessCode'];
$branchCode = $_GET['branchCode'];

$clientID = $_SESSION['userID'];
$clientType = $_SESSION['usertype'];

$packCode = $_GET['packCode'];

$packageDetailsQ = $DB->query("SELECT p.*, c.*, i.*
    FROM package p
    JOIN category c ON p.packCode = c.packCode
    JOIN items i ON c.categoryCode = i.categoryCode
    WHERE p.packCode = '$packCode'");

if ($packageDetailsQ) {
    $packageDetails = $packageDetailsQ->fetch_assoc();


} 
?>

<div id="package-view" class="package-view h-100 " >
    <?php if ($packageDetails): ?>
        
        <div class="row d-flex justify-content-start align-items-center" style="margin-left: 50px">
            <a href="?page=client_package&businessCode=<?= $businessCode?>&branchCode=<?= $branchCode ?>" class=" col-1 btn-back btn-lg justify-content-center align-items-center d-flex text-dark">
                <i class=" bi bi-arrow-left"></i></a>
            <h1 class="col-10 d-flex justify-content-start"> <?= $packageDetails['packName'] ?> Details </h1>
        </div>
   
        <div class="card mt-5 justify-content-center align-items-center d-flex p-3 table-responsive " >
            <table class="table table-hover table-responsive" >
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Category</th>
                        <th scope="col">Items</th>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grandTotal = 0; // Initialize the grand total

                    $result = $DB->query("SELECT c.*, i.*
                        FROM category c
                        JOIN items i ON c.categoryCode = i.categoryCode
                        WHERE c.packCode = '$packCode'");
                    while ($row = $result->fetch_assoc()): 
                        $total = $row['quantity'] * $row['price']; // Calculate total for the row
                        $grandTotal += $total; // Accumulate total to grand total
                    ?>
                        <tr>
                            <td><?= $row['categoryName'] ?></td>
                            <td><?= $row['itemName'] ?></td>
                            <td><?= $row['description'] ?></td>
                            <td><?= $row['quantity'] . ' ' . $row['unit'] ?> </td>
                            <td>₱<?= number_format ($row['price']) ?></td>
                            <td>₱<?=number_format($total) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
                
            <div class="float-end">
                <div class="total row d-flex sticky-bottom m-5">
                    <h3 class="col-7"> Total:</h3>
                    <h4 class="col-5">₱<?= number_format ($grandTotal) ?></h4>
                    <form action="?page=checkout&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&packCode=<?= $packCode?>" method="post">
                    <input type="hidden" name="packCode" value="<?= $packCode ?>">
                    <?php if ($clientType == 'client'): ?>
                        <button type="submit" class="btn btn-primary" style="width:100%">
                            Checkout
                        </button>
                    <?php else: ?>
                        <button type="button" class="btn btn-secondary" style="width:100%" disabled>
                            Checkout
                        </button>
                    <?php endif; ?>
                </form>
                </form>

                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center">No details found for the specified package.</p>
    <?php endif; ?>
</div>

<style>
    @media (min-width:1000px) {
        .package-view{
            margin:120px;
            width:auto;
        }
    }
    @media (max-width: 700px) {
        .package-view{
            margin-top: 120px;
        }
        .total{
            margin:0!important;
        }
        
    }
</style>