<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$accounts = $DB->query("SELECT bo.* FROM business_owner bo WHERE bo.status = 1 ");
if (isset($_GET['ownerID'])) {
    $ownerID = $_GET['ownerID'];
    $businesses = $DB->query("SELECT b.* FROM business b WHERE b.status = 1 AND b.ownerID = $ownerID");
}
$keyword = "";
$results = [];

if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];

    $sql = "SELECT b.*, bo.fname, bo.lname
        FROM business b
        LEFT JOIN business_owner bo ON b.ownerID = bo.ownerID
        WHERE b.status = 1
        AND (
            b.busName COLLATE utf8mb4_unicode_ci LIKE '%$keyword%'
            OR b.busType COLLATE utf8mb4_unicode_ci LIKE '%$keyword%'
            OR bo.fname COLLATE utf8mb4_unicode_ci LIKE '%$keyword%'
            OR bo.lname COLLATE utf8mb4_unicode_ci LIKE '%$keyword%'
        )";

    $results = $DB->query($sql);
} else {
    $results = $businesses;
}

?>

<?= element('header') ?>

<?= element('admin-side-nav') ?>

<div id="admin-users" class="admin-users">
    <div class="d-flex justify-content-between ">
        <h1>Business Owner Accounts</h1>

        <form method="post" action="">
        <div id="searchbar" class="d-flex my-3 float-end">
            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" name="keyword" value="<?= $keyword ?>" />
            <span class="search-btn input-group-text border-0">
                <i class="bi bi-search"></i>
            </span>
        </div>
    </form>
    </div>
    

    <div class="overflow-auto" style="height:100vh">
        <table class="table table-hover table-responsive table-bordered" style="border-radius: 10px">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Business Owner Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $index => $account) : ?>
                    <tr>
                        <th scope="row" class="bg-transparent border border-white"><?= $index + 1 ?></th>
                        <td class="bg-transparent border border-white d-flex justify-content-between">
                            <div class="d-flex justify-content-center align-items-center">
                                <?= $account['fname'] . ' ' . $account['lname'] ?>
                            </div>
                            <button class="btn btn-primary mx-5" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAccount<?= $account['ownerID'] ?>">View</button>
                        </td>
                    </tr>
                    </tbody>
                    <?php endforeach; ?>
        </table>
        <?php foreach ($accounts as $account) : ?>
                    <div class="offcanvas offcanvas-top overflow-auto p-3" style="width: 50vw; height: 100vh; margin-left: 25vw;" tabindex="-1" id="offcanvasAccount<?= $account['ownerID'] ?>" data-bs-backdrop="false">
                    <div class="p-3">
                        <div class="offcanvas-header p-0">
                            <h2 class="offcanvas-title" id="offcanvasExampleLabel">Owner's Account Information</h2>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <hr>
                        <div>
                            
                            <div class="d-flex my-3">
                                <span class="col-sm-3"> Owner's Name: </span>
                                <span class="col mx-5 border-bottom"><?= $account['fname'] . ' ' . $account['lname'] ?></span>
                            </div>
                            <div class="d-flex my-3">
                                <span class="col-sm-3"> Owner's Birthday: </span>
                                <span class="col mx-5 border-bottom"><?= $account['birthday'] ?></span>
                            </div>
                            <div class="d-flex my-3">
                                <span class="col-sm-3"> Owner's Email: </span>
                                <span class="col mx-5 border-bottom"><?= $account['email'] ?></span>
                            </div>
                            <div class="d-flex my-3">
                                <span class="col-sm-3"> Owner's Number: </span>
                                <span class="col mx-5 border-bottom"><?= $account['number'] ?></span>
                            </div>
                            <div class="d-flex my-3">
                                <span class="col-sm-3"> Owner's Address: </span>
                                <span class="col mx-5 border-bottom"><?= $account['ownerAddress'] ?></span>
                            </div>
                       
               
                            <div class="Business-list">
                                <table class="table table-hover table-responsive table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Business Name</th>
                                            <th>Business Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($businesses->num_rows > 0) : ?>
                                            <?php while ($business = $businesses->fetch_assoc()) : ?>
                                                <tr>
                                                    <td><?= $business['busName'] ?></td>
                                                    <td><?= $business['busType'] ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="2">No businesses found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                       
                         <?php endforeach; ?>
                   
               
           
    </div>
    </div>
    </div>
    </div>
</div>

<script src="assets/js/user.js"></script>
