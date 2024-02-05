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
        <div class="row mb-5">
            <a href="?page=client_package&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>" class="col-xl-1 text-dark float-end">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h1 class="col-xl-5 d-flex justify-content-start text-dark">Package Customization</h1>
        </div>
    </div>
</div>

<div class="row d-flex p-5 g-5">
    <div id="package-info" class="package-info col-5" style="width: 50vw; height: 65vh; margin: 120px 0 0 10%;">

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
                    <div class="accordion">
                        <div class="packagescus accordion-item" id="heading<?= $row['customCategoryCode'] ?>">
                            <h5 class="accordion-header p-0">
                                <button class="btn accordion-button text-start" data-toggle="collapse" data-target="#collapse<?= $row['customCategoryCode'] ?>" aria-expanded="true" aria-controls="collapse<?= $row['customCategoryCode'] ?>">
                                    <p class="padcategory"><?= $row['categoryName'] ?></p>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse<?= $row['customCategoryCode'] ?>" class="collapse" aria-labelledby="heading<?= $row['customCategoryCode'] ?>" data-parent="#accordion">
                            <div class="accordion-body" style="background-color:#FFFFFF">
                                <!-- Item list -->
            <?php 
                    $currentCategoryCode = $row['customCategoryCode'];
                endif;
            ?>
                                <div class="form-check row d-flex justify-content-between">
                                    <div class="col-7">
                                        <input class="form-check-input item-checkbox" type="checkbox" value="<?= $row['itemCode'] ?>" id="item<?= $row['itemCode'] ?>">
                                        <label class="form-check-label" for="item<?= $row['itemCode'] ?>">
                                            <?= $row['itemName'] ?>
                                        </label>
                                        <p class="mx-4"><?= $row['description'] ?></p>
                                    </div>
                                    <div class=" col-5 d-flex float-end " >
                                    <p class="mx-4">₱<?= $row['price'] ?></p>
                                    <input type="number" class="form-control quantity-input w-25" placeholder="Quantity" id="quantity<?= $row['itemCode'] ?>" data-item-code="<?= $row['itemCode'] ?>" min="1" value="1" style="height:30px">
                                    <input type="hidden" class="form-control price-input" value="<?= $row['price'] ?>" data-item-code="<?= $row['itemCode'] ?>">
                                    </div>
                                    
                                    
                                </div>
            <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
        </div>
    </div>

    <div class="order-list col-4 card border-0 rounded-3 shadow p-3 mb-5 bg-white rounded fixed-top" style="height: 80vh; margin: 150px 50px 0 62vw">
        <h3 class="order-header sticky-top p-3 mx-2">Order List</h3>
        <div class="order justify-content-center px-4 overflow-auto" style="height:60vh">
            
            <table class="table">
                <thead>
                    <tr class="sticky-top">
                        <th scope="col">Item</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody class="order-body">
                </tbody>
            </table>
            </div>
            <div class="total row d-flex sticky-bottom">
                <h3 class="col-7">Total</h3>
                <h4 class="col-5 total-price">0.00</h4>
                <!--<div class="border-top border-bottom voucher-btn row justify-content-center align-items-center" style="height: 60px" href="?page=client_voucher">
                    <h6 class="col-10"><i class="bi bi-tags"></i>Apply Voucher</h6>
                    <i class="bi bi-chevron-right float-end col-2"></i>
                </div>-->
                <form action="?page=custom_checkout&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>" method="post">
    <input type="hidden" name="orderDetails" id="orderDetails" value="">
    <button type="submit" class="btn btn-primary checkout-btn" style="width:100%" data-order-details="">
        Checkout
    </button>
</form>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<style>
    .packagecus h5:hover>.btn{
        text-decoration:none;
    
    }
    .padcategory{
        padding:0!important;
    }
    .accordion-button:not(.collapsed){
        background-color:#0000;
    }
    
</style>
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
                var quantity = $('#quantity' + itemCode).val();
                var itemName = $('#item' + itemCode).next().text();
                var price = $('.price-input[data-item-code="' + itemCode + '"]').val();
                var subtotal = quantity * price;

                orderDetails.push({
                    itemCode: itemCode,
                    itemName: itemName,
                    quantity: quantity,
                    price:  price,
                    subtotal: subtotal
                });

                total += subtotal;
            });

            // Update order list table
            var orderBody = $('.order-body');
            orderBody.empty();

            for (var i = 0; i < orderDetails.length; i++) {
                var orderItem = orderDetails[i];
                orderBody.append('<tr><td>' + orderItem.itemName + '</td><td>' + orderItem.quantity + '</td><td>₱' + orderItem.subtotal.toFixed(2) + '</td></tr>');
            }

            // Update total price
            $('.total-price').text('₱' + total.toFixed(2));

            var orderDetailsJson = JSON.stringify(orderDetails);
            $('.checkout-btn').attr('data-order-details', orderDetailsJson);
    
            // Append encoded order details as a query parameter to the form action URL
            var checkoutURL = "?page=custom_checkout&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>&orderDetails=" + encodeURIComponent(orderDetailsJson);
            $('form').attr('action', checkoutURL);
        }
    });
</script>
</html>

