<?php
global $DB;
$branchCode = isset($_GET['branchcode']) ? $_GET['branchcode'] : '';
$packageQuery = "SELECT * FROM package WHERE branchCode = '$branchCode'";
$packageResult = $DB->query($packageQuery);
?>

<?php if ($packageResult->num_rows > 0): ?>
  <div class="package-details" id="packageDetails<?= $branchCode ?>" style="display: block; height: 100vh">
    <div class="d-flex align-items-center" style="height: 200px; margin-top: 350px; margin-left: 20%; width: 80vw; ">
      <div class="package-details overflow-auto col-5 card bg-opacity-25 bg-white py-5 mx-4 px-4" style="height: 100vh; width: 70vw;">
        <h2>Pre-made Packages</h2>
        <h6>This section lets you create pre-made packages for your customers.</h6>
        <div class="accordion" id="accordionFlushExample">
          <?php
          while ($package = $packageResult->fetch_assoc()) {
            $packageCode = $package['packCode'];
            $totalPackagePrice = 0; // Initialize total price for each package
            ?>
            <div class="accordion-item " id="accordionItem<?= $packageCode ?>">
              <h2 class="accordion-header" id="flush-heading<?= $packageCode ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $packageCode ?>" aria-expanded="false" aria-controls="flush-collapse<?= $packageCode ?>">
                  <?= $package['packName'] ?>
                </button>
              </h2>
              <div id="flush-collapse<?= $packageCode ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $packageCode ?>" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body overflow-auto" style="height: 65vh">
                  <?php
                  $categoriesQuery = "SELECT * FROM category WHERE packCode = '$packageCode'";
                  $categoriesResult = $DB->query($categoriesQuery);

                  while ($category = $categoriesResult->fetch_assoc()) {
                    $categoryCode = $category['categoryCode'];
                    ?>
                    <h3><?= $category['categoryName'] ?></h3>
                    <table class="table table-hover table-responsive">
                      <thead class="table-dark">
                        <tr>
                          <th scope="col">Items</th>
                          <th scope="col">Description</th>
                          <th scope="col">Quantity</th>
                          <th scope="col">Price</th>
                          <th scope="col">Other Details</th>
                          <th scope="col">Total</th>
                          <th scope="colspan=2">Action</th> <!-- Add Edit column header -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $itemsQuery = "SELECT * FROM items WHERE categoryCode = '$categoryCode'";
                        $itemsResult = $DB->query($itemsQuery);

                        while ($item = $itemsResult->fetch_assoc()) {
                          $itemCode = $item['itemCode'];
                          $detailsQuery = "SELECT * FROM item_details WHERE itemCode = '$itemCode'";
                          $detailsResult = $DB->query($detailsQuery);
                          $details = $detailsResult->fetch_assoc();
                          $totalItemPrice = $item['quantity'] * $item['price']; // Calculate total for each item
                          $totalPackagePrice += $totalItemPrice; // Add to the total for the package
                          ?>
                          <tr>
                            <td><?= $item['itemName'] ?></td>
                            <td><?= $item['description'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= $item['price'] ?></td>
                            <td>
                              <?php
                              if (!empty($details)) {
                                echo $details['detailName'] . ': ' . $details['detailValue'];
                              } else {
                                echo 'N/A';
                              }
                              ?>
                            </td>
                            <td><?= $totalItemPrice ?></td>

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
                    <div class="text-end"><strong>Total Package Price:</strong> <?= $totalPackagePrice ?></div>
                    <div class="text-end mt-3">
                            <a href="?page=add_item&packageCode=<?= $packageCode ?>&categoryCode=<?= $categoryCode ?>" class="btn btn-outline-primary">
                              <i class="bi bi-plus-square"></i>
                              <span>Add Item</span>
                            </a>
                          </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          <?php } ?>
          <div class="text-end mt-3">
                <a href="?page=add_package&branchcode=<?= $branchCode ?>" class="btn btn-outline-primary">
                    <i class="bi bi-plus-square"></i>
                    <span>Add Package</span>
                </a>
                <a href="?page=add_package&branchcode=<?= $branchCode ?>" class="btn btn-outline-primary">
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
        <h2>Pre-made Packages</h2>
        <h6>This section lets you create pre-made packages for your customers.</h6>
        <div class="accordion" id="accordionFlushExample">
          <div class="m-3">
            <a href="?page=add_package&branchcode=<?= $branchCode ?>" class="btn-edit btn btn-primary btn-lg mt-4">
              <i class="bi bi-plus-square"></i>
              <span>Add Package</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
