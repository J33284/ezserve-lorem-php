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
    <div id="package-info" class="package-info col-4" style="width: 50vw; height: 65vh; margin: 100px 0 0 280px;">

        <!-- Accordion -->
        <div id="accordion">
            <?php 
            $currentCategoryCode = null;
            while ($row = $servicesQ->fetch_assoc()): 
                if ($currentCategoryCode != $row['customCategoryCode']):
                    if ($currentCategoryCode !== null): // Close previous accordion
                        echo '</div></div></div>';
                    endif;
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
            <?php 
                    $currentCategoryCode = $row['customCategoryCode'];
                endif;
            ?>
                                <div class="form-check">
                                    <input class="form-check-input item-checkbox" type="checkbox" value="<?= $row['itemCode'] ?>" id="item<?= $row['itemCode'] ?>">
                                    <label class="form-check-label" for="item<?= $row['itemCode'] ?>">
                                        <?= $row['itemName'] ?>
                                    </label>
                                    <input type="number" class="form-control quantity-input" placeholder="Quantity" id="quantity<?= $row['itemCode'] ?>" data-item-code="<?= $row['itemCode'] ?>">
                                    <input type="hidden" class="form-control price-input" value="<?= $row['price'] ?>" data-item-code="<?= $row['itemCode'] ?>">
                                </div>
            <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
        </div>
    </div>

    <div class="order-list col-4 card border-0 rounded-3 shadow p-3 mb-5 bg-white rounded overflow-auto" style="height: 80vh">
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
                    <i class="bi bi-chevron-right float-end col-2"></i>
                </div>
                <form action="?page=custom_checkout" method="post">
                    <input type="hidden" name="orderDetails" id="orderDetails" value="">
                    <button type="submit" class="btn btn-primary" style="width:100%" data-bs-business-code="">
                        Check Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Custom JavaScript -->
<script>
    $(document).ready(function () {
        // Handle checkbox change
        $('.item-checkbox').change(function () {
            updateOrderList();
        });

        // Handle quantity input change
        $('.quantity-input').change(function () {
            updateOrderList();
        });

        function updateOrderList() {
            var total = 0;
            var orderDetails = [];

            $('.item-checkbox:checked').each(function () {
                var itemCode = $(this).val();
                var itemName = $('#item' + itemCode).next().text();
                var quantity = $('#quantity' + itemCode).val();
                var price = $('.price-input[data-item-code="' + itemCode + '"]').val();
                var subtotal = quantity * price;

                orderDetails.push({
                    itemCode: itemCode,
                    itemName: itemName,
                    quantity: quantity,
                    price: price,
                    subtotal: subtotal
                });

                total += subtotal;
            });

            // Update order list table
            var orderBody = $('.order-body');
            orderBody.empty();

            for (var i = 0; i < orderDetails.length; i++) {
                var orderItem = orderDetails[i];
                orderBody.append('<tr><td>' + orderItem.quantity + '</td><td>' + orderItem.itemName + '</td><td>' + orderItem.subtotal.toFixed(2) + '</td></tr>');
            }

            // Update total price
            $('.total-price').text(total.toFixed(2));

            // Update hidden input with order details
            $('#orderDetails').val(JSON.stringify(orderDetails));
        }
    });
</script>
</html>
