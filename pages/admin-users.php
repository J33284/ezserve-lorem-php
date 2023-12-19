<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$accounts = $DB->query("SELECT bo.* FROM business_owner bo WHERE bo.status = 1 ");
?>

<?= element('header') ?>

<?= element('admin-side-nav') ?>

<div id="admin-users" class="admin-users">
    <div class="d-flex justify-content-between p-3">
        <h1>Business Owner Accounts</h1>
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
                            <a href="" class="btn btn-primary mx-5">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="assets/js/user.js"></script>
