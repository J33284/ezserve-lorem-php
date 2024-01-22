<?= element('header') ?>

<?= element('owner-side-nav') ?>

<?php
global $DB;                                                                                                                                                            $branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
$categoriesQuery = "SELECT * FROM custom_category WHERE branchCode = '$branchCode'";
$categoriesResult = $DB->query($categoriesQuery);
?>

<?php if ($categoriesResult->num_rows > 0): ?>
    <div class="package-details" id="packageDetails<?= $branchCode ?>" style="display: block; height: 100vh">
        <div class="d-flex align-items-center" style="height: 200px; margin-top: 350px; margin-left: 20%; width: 80vw; ">
            <div class="package-details overflow-auto col-5 card bg-opacity-25 bg-white py-5 mx-4 px-4" style="height: 100vh; width: 70vw;">
                <h2>Custom Items</h2>
                <div class="accordion" id="accordionFlushExample">
                    <?php
                    while ($category = $categoriesResult->fetch_assoc()) {
                        $categoryCode = $category['customCategoryCode'];
                        ?>
                        <div class="accordion-item " id="accordionItem<?= $categoryCode ?>">
                            <h2 class="accordion-header" id="flush-heading<?= $categoryCode ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $categoryCode ?>" aria-expanded="false" aria-controls="flush-collapse<?= $categoryCode ?>">
                                    <?= $category['categoryName'] ?>
                                </button>
                            </h2>
                            <div id="flush-collapse<?= $categoryCode ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $categoryCode ?>" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body overflow-auto" style="height: 65vh">
                                    <table class="table table-hover table-responsive">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">Items</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Other Details</th>
                                                <th scope="colspan=2">Action</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $itemsQuery = "SELECT * FROM custom_items WHERE customCategoryCode = '$categoryCode'";
                                            $itemsResult = $DB->query($itemsQuery);

                                            while ($item = $itemsResult->fetch_assoc()) {
                                                $itemCode = $item['itemCode'];
                                                $detailsQuery = "SELECT * FROM custom_item_details WHERE ItemCode = '$itemCode'";
                                                $detailsResult = $DB->query($detailsQuery);
                                                $details = $detailsResult->fetch_assoc();
                                                ?>
                                                <tr>
                                                    <td><?= $item['itemName'] ?></td>
                                                    <td><?= $item['description'] ?></td>
                                                    <td><?= $item['price'] ?></td>
                                                    <td>
                                                        <?php
                                                        if (!empty($details['detailName']) && !empty($details['detailValue'])) {
                                                            echo $details['detailName'] . ': ' . $details['detailValue'];
                                                        } else {
                                                            echo 'N/A';
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <div>
                                                            <i class="bi bi-pencil"></i>
                                                            <span>Edit</span>
                                                        </div>
                                                        <div>
                                                            <i class="bi bi-trash"></i>
                                                            <span>Delete</span>
                                                        </div>
                                                    </td>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <!-- Add "Add Item" button -->
                                    <div class="text-end mt-3">
                                        <a href="?page=add_customItem&customCategoryCode=<?= $categoryCode ?>&businessCode=<?=$businessCode?>&branchCode=<?=$branchCode?>" class="btn btn-outline-primary">
                                            <i class="bi bi-plus-square"></i>
                                            <span>Add Item</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="text-end mt-3">
                            <a href="?page=add_custom_package&businessCode=<?= $businessCode?>&branchCode=<?= $branchCode ?>" class="btn-edit btn btn-primary btn-lg mt-4">
                            <i class="bi bi-plus-square"></i>
                            <span>Add Category</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="package-details" id="packageDetails<?= $branchCode ?>" style="display: block;">
    <div class="d-flex align-items-center" style="height: 200px; margin-top: 300px; margin-left: 390px; width: 140%;">
      <div class="package-details col-5 card py-5 mx-4 px-4">
      <h2><span style="color: red;">&#9888;</span> No Records Found</h2>
        <div class="accordion" id="accordionFlushExample">
          <div class="m-3">
            <a href="?page=add_custom_package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="btn-edit btn btn-primary btn-lg mt-4">
              <i class="bi bi-plus-square"></i>
              <span>Create Custom Items</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
