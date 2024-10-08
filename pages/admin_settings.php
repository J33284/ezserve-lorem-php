<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');
global $DB;

$businessesResult = $DB->query("SELECT * FROM businesstypes");

if ($businessesResult) {
    while ($row = $businessesResult->fetch_assoc()) {
        $businesses[] = $row;
    }
} else {
    echo "Error executing the query.";
}

?>

<?= element('admin_header') ?>

<?= element('admin-side-nav') ?>

<div class="admin-settings" id="admin-settings" style="width: 70vw; height:100vh; margin: 120px 0 0 20%">
    <div class="">
        <h1 >Settings</h1>
    </div>
    <div class="card p-5">
        <h3>Manage Business Type</h3>

        <form method="post" action="?action=businessAction">
            <div class="input-group mb-3 w-50">
                <input type="text" class="form-control" placeholder="Add Business Type" id="businessType" name="businessType"
                    aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name = "AddType">Add</button>
                </div>
            </div>
        </form>
        
        <table class="table">
            <thead>
                <tr>
                <th>Business Type</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($businesses)) : ?>
                    <?php foreach ($businesses as $row) : ?>
                        <tr>
                            <td><?php echo $row['typeName']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= element('footer') ?>
