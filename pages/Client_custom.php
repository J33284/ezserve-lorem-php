<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$branchCode = $_POST['branchCode'];
$packCode = $_POST['packageCode'];

// Retrieve all branches for the given business
$branchesQ = $DB->query("SELECT br.*, p.*, c.*, s.*
  FROM branches br
  JOIN package p ON br.branchCode = p.branchCode
  JOIN category c ON p.packCode = c.packCode
  JOIN service s ON c.categoryCode = s.categoryCode
  WHERE br.branchCode = '$branchCode' AND p.packCode = '$packCode'");

// Check if the query was successful before trying to fetch data
if ($branchesQ) {
    // Fetch the first row (branch) from the result set
    $branch = $branchesQ->fetch_assoc();

    // Fetch all services for the selected branch and package
    $servicesQ = $DB->query("SELECT s.* FROM service s WHERE s.categoryCode IN (SELECT c.categoryCode FROM category c WHERE c.packCode = '$packCode')");
}
?>
 <?= element( 'header' ) ?>
    <div id="client-custom" class="client-custom">
        <div class="container pack-head" style="top: 50px;">
            <div class="container row">
                <a href="?page=services" class="col-xl-1 btn-back btn-lg float-end">
                    <i class="bi bi-arrow-left"></i></a>
                <h1 class="col-xl-7 d-flex justify-content-start text-light">Package Customization</h1>
            </div>
        </div>
        <div class="row d-flex p-5 g-5">
            <div id="package-info" class="package-info col-4" style="width: 50vw; height: 65vh; margin: 50px 0 0 80px;">
                <div class="accords">
                    <div>
                        <div class="accordion" id="<?= $branch['categoryCode'] ?>">
                            <?php while ($row = $servicesQ->fetch_assoc()) : ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="ServiceOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#service-details-one" aria-bs-expanded="false" aria-controls="service-details-one">
                                            
                                            <?= $row['serviceName'] ?>
                                        </button>
                                    </h2>
                                    <div id="service-details-one" class="accordion-collapse collapse" aria-labelledby="ServiceOne" data-bs-parent="#<?= $branch['categoryCode'] ?>">
                                        <div class="accordion-body">
                                            <div class="row justify-content-center align-items-center">
                                                <input type="checkbox" class="form-check-input" id="email">
                                                <div class="col-6 justify-content-center align-items-start d-flex flex-column">
                                                    <?= $row['serviceName'] ?>
                                                    <h6><?= $row['price'] ?></h6>
                                                </div>
                                                <img src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg" class="col-5" alt="example placeholder" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-list col-4 card border-0 rounded-3 shadow p-3 mb-5 bg-white rounded">
                <h3 class="order-header sticky-top">Order List</h3>
                <hr class="m-0">
                <div class="order justify-content-center px-4 overflow-scroll">
                    <hr>
                    <table class="table">
                        <thead>
                            <tr class="sticky-top">
                                <th scope="col">Quantity</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $servicesQ->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['serviceName']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <div class="total row d-flex sticky-bottom">
                        <h3 class="col-7"> Total</h3>
                        <h4 class="col-5"> heeehee</h4> <!--calculation formula-->
                        <form action="?page=checkout" method="post">
                            <input type="hidden" name="businessCode" value="">
                            <button type="submit" class="btn btn-primary" style="width:100%" data-bs-business-code="">
                                Check Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

