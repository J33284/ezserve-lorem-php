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

<?= element('header') ?>

<div id="client-custom" class="client-custom">
    <div class="container pack-head" style="top: 50px;">
        <div class="container row">
            <a href="?page=services" class="col-xl-1 btn-back btn-lg float-end">
                <i class="bi bi-arrow-left"></i>
            </a>
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
                            <h2 class="accordion-header" id="Service<?= $row['serviceCode'] ?>">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#service-details-<?= $row['serviceCode'] ?>" aria-expanded="false"
                                        aria-controls="service-details-<?= $row['serviceCode'] ?>">
                                    <?= $row['serviceName'] ?>
                                </button>
                            </h2>
                            <div id="service-details-<?= $row['serviceCode'] ?>" class="accordion-collapse collapse"
                                aria-labelledby="Service<?= $row['serviceCode'] ?>"
                                data-bs-parent="#<?= $branch['categoryCode'] ?>">
                                <div class="accordion-body">
                                    <div class="d-flex">
                                        <input type="checkbox" style="width: 5%;" class="form-check-input service-checkbox"
                                            id="service-<?= $row['serviceCode'] ?>" data-service-id="<?= $row['serviceCode'] ?>">
                                        <label for="service-<?= $row['serviceCode'] ?>">Select Service</label>
                                        <input type="number" class="form-control quantity-input" value="1" min="1" style="width:30%;">
                                        <label>Quantity</label>
                                    </div>
                                    <hr>
                                    <!-- Rest of the accordion content goes here -->
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-6 justify-content-center align-items-start d-flex flex-column">
                                            <label>Price:</label>
                                            <h6><?= $row['price'] ?></h6>

                                            <label>Description:</label>
                                            <h6><?= $row['Description'] ?></h6>
                                        </div>
                                        <img src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                                            class="col-5" alt="example placeholder"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-list col-4 card border-0 rounded-3 shadow p-3 mb-5 bg-white rounded" style="height: auto">
            <h3 class="order-header sticky-top p-3">Order List</h3>
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
                    <tbody class="order-body">
                    </tbody>
                </table>
                <div class="total row d-flex sticky-bottom">
                    <h3 class="col-7">Total</h3>
                    <h4 class="col-5 total-price">0.00</h4>
                    <div class="border-top border-bottom voucher-btn row justify-content-center align-items-center" style="height: 60px" href="?page=client_voucher">
                        <h6 class="col-10"><i class="bi bi-tags"></i>Apply Voucher</h6>
                        <i class="bi bi-chevron-right float end col-2"></i>
                    </div>
                    <form action="?page=checkout" method="post">
                        <!-- Add hidden input fields to store order details -->
                        <input type="hidden" name="orderDetails" id="orderDetails" value="">
                        <button type="submit" class="btn btn-primary" style="width:100%" data-bs-business-code="">
                            Check Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add your JavaScript libraries and scripts here -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('.service-checkbox, .quantity-input').change(function () {
            updateOrderList();
        });

        function updateOrderList() {
            // Clear existing entries in the order list
            $('.order-body').empty();

            // Calculate total price
            var totalPrice = 0;

            // Create an array to store order details
            var orderDetails = [];

            // Loop through each checked checkbox
            $('.service-checkbox:checked').each(function () {
                var quantity = $(this).closest('.accordion-body').find('.quantity-input').val();
                var serviceName = $(this).closest('.accordion-item').find('.accordion-button').text();
                var price = parseFloat($(this).closest('.accordion-item').find('.accordion-body h6').text().replace('₱', '').trim());

                // Calculate total price for each service
                var serviceTotal = quantity * price;

                // Append row to the order list
                $('.order-body').append('<tr><td>' + quantity + '</td><td>' + serviceName + '</td><td>₱' + serviceTotal.toFixed(2) + '</td></tr>');

                // Update total price
                totalPrice += serviceTotal;

                // Store order details in the array
                orderDetails.push({
                    quantity: quantity,
                    serviceName: serviceName,
                    price: price
                });
            });

            // Update the total in the order list
            $('.total-price').text('₱' + totalPrice.toFixed(2));

            // Store order details in the hidden input field
            $('#orderDetails').val(JSON.stringify(orderDetails));
        }
    });
</script>
