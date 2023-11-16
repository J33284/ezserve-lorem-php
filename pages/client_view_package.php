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
    <?php if ($packageDetails): ?>
        <h2><?= $packageDetails['packName'] ?> Details</h2>
        <table class="table">
            <tr>
                <th>Category</th>
                <td><?= $packageDetails['categoryName'] ?></td>
            </tr>
            <tr>
                <th>Service</th>
                <td><?= $packageDetails['serviceName'] ?></td>
            </tr>
            <tr>
                <th>Price</th>
                <td><?= $packageDetails['price'] ?></td>
            </tr>
            <!-- Add more details as needed -->
        </table>
    <?php else: ?>
        <p>No details found for the specified package.</p>
    <?php endif; ?>
</div>


</body>
</html>
