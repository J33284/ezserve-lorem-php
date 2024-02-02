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

        // Use prepared statements to prevent SQL injection
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
    }}

?>
<?= element('header') ?>

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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= element('footer') ?>
