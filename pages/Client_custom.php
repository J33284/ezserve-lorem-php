<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$businessCode = $_GET['businessCode'];
$branchCode = $_GET['branchCode'];

// Retrieve all branches for the given business
$branchesQ = $DB->query("SELECT br.*, c.*, i.*
  FROM branches br
  JOIN custom_category c ON br.branchCode = c.branchCode
  JOIN custom_items i ON c.customcategoryCode = i.customcategoryCode
  WHERE br.branchCode = '$branchCode'");

// Check if the query was successful before trying to fetch data
if ($branchesQ) {
    // Fetch the first row (branch) from the result set
    $branch = $branchesQ->fetch_assoc();

    $servicesQ = $DB->query("SELECT  br.*, c.* 
    FROM branches br
    JOIN custom_category c
    WHERE br.branchCode = '$branchCode'");
 
}
?>

<?= element('header') ?>

<div id="client-custom" class="client-custom">
    <div class="container pack-head" style="top: 100px;">
        <div class="container row">
            <a href="?page=client_package&businessCode=<?= $businessCode?>&branchCode=<?=$branchCode?>" class="col-xl-1 btn-back btn-lg float-end">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="col-xl-7 d-flex justify-content-start text-light">Package Customization</h1>
        </div>
    </div>

    <div class="row d-flex p-5 g-5">
        <div id="package-info" class="package-info col-4" style="width: 50vw; height: 65vh; margin: 100px 0 0 80px;">
            <div class="accords">
                <div>
                    <div class="accordion" id="<?= $branch['customCategoryCode'] ?>">
                    <?php while ($servicesQ && $row = $servicesQ->fetch_assoc()) : ?>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="Service<?= $row['itemCode'] ?>">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#service-details-<?= $row['itemCode'] ?>" aria-expanded="false"
                                        aria-controls="service-details-<?= $row['itemCode'] ?>">
                                    <?= $row['itemName'] ?>
                                </button>
                            </h2>
                            <div id="service-details-<?= $row['itemCode'] ?>" class="accordion-collapse collapse"
                                aria-labelledby="Service<?= $row['itemCode'] ?>"
                                data-bs-parent="#<?= $branch['customCategoryCode'] ?>">
                                <div class="accordion-body">
                                    <div class="d-flex">
                                        <input type="checkbox" style="width: 5%;" class="form-check-input service-checkbox"
                                            id="service-<?= $row['itemCode'] ?>" data-service-id="<?= $row['itemCode'] ?>">
                                        <label for="service-<?= $row['itemCode'] ?>">Select Item</label>
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
                                            <h6><?= $row['description'] ?></h6>
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

        <div class="order-list col-4 card border-0 rounded-3 shadow p-3 mb-5 bg-white rounded overflow-auto" style="height: 80vh">
            <h3 class="order-header sticky-top p-3">Order List</h3>
            <hr class="m-0">
            <div class="order justify-content-center px-4 overflow-scroll">
                <hr>
                <table class="table" style="height:80rem">
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
                    <form action="?page=custom_checkout" method="post">
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
                var itemName = $(this).closest('.accordion-item').find('.accordion-button').text();
                var price = parseFloat($(this).closest('.accordion-item').find('.accordion-body h6').text().replace('₱', '').trim());

                // Calculate total price for each service
                var itemTotal = quantity * price;

                // Append row to the order list
                $('.order-body').append('<tr><td>' + quantity + '</td><td>' + itemName + '</td><td>₱' + itemTotal.toFixed(2) + '</td></tr>');

                // Update total price
                totalPrice += serviceTotal;

                // Store order details in the array
                orderDetails.push({
                    quantity: quantity,
                    itemName: itemName,
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
