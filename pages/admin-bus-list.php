<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$businesses = $DB->query("SELECT b.*, bo.*
    FROM business b
    JOIN business_owner bo ON b.ownerID = bo.ownerID
    WHERE b.status = 1");

$keyword = "";
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['keyword'])) {
        $keyword = $_POST['keyword'];

        $sql = "SELECT bo.*, b.*
        FROM business_owner bo
        LEFT JOIN business b ON bo.ownerID = b.ownerID
        WHERE bo.status = 1
        AND (
            bo.fname COLLATE utf8mb4_unicode_ci LIKE '%$keyword%' OR bo.lname COLLATE utf8mb4_unicode_ci LIKE '%$keyword%'
            OR b.busName COLLATE utf8mb4_unicode_ci LIKE '%$keyword%' OR b.busType COLLATE utf8mb4_unicode_ci LIKE '%$keyword%'
        )";
       
        $results = $DB->query($sql);
    }
    else {
        $results = $businesses;
    }
}
?>

<?= element('admin_header') ?>

<?= element('admin-side-nav') ?>

<div id="admin-bus-list" class="admin-bus-list">
    <form method="post" action="">
        <div id="searchbar" class="d-flex my-3 float-end">
            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" name="keyword" value="<?= $keyword ?>" />
            <button type="submit" class="search-btn btn btn-primary input-group-text border-0">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>

    <table class="table table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Business Name</th>
                <th scope="col">Business Owner</th>
                <th scope="col">Business Type</th>
                <th scope="col" style="width:220px;"    ></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach (empty($results) ? $businesses : $results as $key => $business) : ?>
            <tr class="sticky-top mt-3">
                <th scope="row" class="bg-transparent border border-white"><?= $key + 1 ?></th>
                <td class="bg-transparent border border-white" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample<?= $business['businessCode'] ?>" role="button">
                    <?= $business['busName'] ?>
                </td>
                <td class="bg-transparent border border-white" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample<?= $business['businessCode'] ?>" role="button">
                    <?= $business['fname'] . ' ' . $business['lname'] ?>
                </td>
                <td class="bg-transparent border border-white" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample<?= $business['businessCode'] ?>" role="button">
                    <?= $business['busType'] ?>
                </td>
                <td class="bg-transparent border border-white d-flex " style="width:220px;">
                    <form action="?page=business-branches" method="post">
                        <input type="hidden" name="businessCode" value="<?= $business['businessCode'] ?>">
                        <button type="submit" class="btn btn-sm btn-primary view-package m-2" data-business-code="<?= $business['businessCode'] ?>"> <i class="bi bi-eye-fill"></i>
                            View
                        </button>
                    </form>
                    
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php foreach (empty($results) ? $businesses : $results as $business) : ?>
        <div class="offcanvas offcanvas-top overflow-auto p-3 rounded" style="width: 50vw; height: 65vh; margin: 50px 0 0 25vw;" tabindex="-1" id="offcanvasDelete<?= $business['businessCode'] ?>"  data-bs-backdrop="static" >
            <div class="p-3">
                <div class="offcanvas-header p-0 mb-3" >
                    <h3 class="offcanvas-title" id="offcanvasExampleLabel">Are you sure to delete business?</h3>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div style="height: 18rem">
                <p>You are about to delete the business .</p>
                <p class="text-justify">The business owner will receive a notification confirming that their request to delete the business has been successfully processed. </p>
                <p>Click 'Confirm delete' to proceed with the deletion.</p>
                </div>
                  
                
                <form method="post" action="?action=delete_business">
                        <input type="hidden" name="businessCode" value="<?= $business['businessCode'] ?>">
                        <button type="submit" class="btn btn-danger float-end">Confirm Delete</button>
                    </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= element('footer') ?>
