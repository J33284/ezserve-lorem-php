<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$businessCode = $_GET['businessCode'];
$branchCode = $_GET['branchCode'];

$servicesQ = $DB->query("SELECT c.*, i.*
FROM custom_category c 
JOIN custom_items i ON c.customCategoryCode = i.customCategoryCode
WHERE c.branchCode = '$branchCode'");
?>

<?= element('header') ?>

<div id="client-custom" class="client-custom">
    <div class="container pack-head" style="top: 100px;">
        <div class="row">
            <a href="?page=client_package&businessCode=<?= $businessCode?>&branchCode=<?=$branchCode?>" class="col-xl-1 text-dark float-end">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="col-xl-7 d-flex justify-content-start text-dark">Package Customization</h1>
        </div>
    </div>
</div>

<div class="row d-flex p-5 g-5">
    <div id="package-info" class="package-info col-4" style="width: 50vw; height: 65vh; margin: 100px 0 0 80px;">

        <!-- Accordion -->
        <div id="accordion">
            <?php 
            while ($row = $servicesQ->fetch_assoc()): 
            ?>
                <div class="card">
                    <div class="card-header" id="heading<?= $row['customCategoryCode'] ?>">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?= $row['customCategoryCode'] ?>" aria-expanded="true" aria-controls="collapse<?= $row['customCategoryCode'] ?>">
                                <?= $row['categoryName'] ?>
                            </button>
                        </h5>
                    </div>

                    <div id="collapse<?= $row['customCategoryCode'] ?>" class="collapse" aria-labelledby="heading<?= $row['customCategoryCode'] ?>" data-parent="#accordion">
                        <div class="card-body">
                            <!-- Item list -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="<?= $row['itemCode'] ?>" id="item<?= $row['itemCode'] ?>">
                                <label class="form-check-label" for="item<?= $row['itemCode'] ?>">
                                    <?= $row['itemName'] ?>
                                </label>
                                <input type="number" class="form-control" placeholder="Quantity" id="quantity<?= $row['itemCode'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<!-- Include Bootstrap and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
