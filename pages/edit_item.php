<?= element('header') ?>
<?php
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';
$packCode = isset($_GET['packCode']) ? $_GET['packCode'] : '';
$itemCode = isset($_GET['itemCode']) ? $_GET['itemCode'] : '';


$itemDetails = $DB->query("SELECT * FROM items WHERE itemCode = '$itemCode'");
if ($itemDetails->num_rows > 0) {
    $item = $itemDetails->fetch_assoc();
}
?>
<div class="package-info" style="margin: 120px 0 0 30%">
    <div class="card p-5 bg-opacity-25 bg-white">
        <form action="?action=update_item" method="POST" enctype="multipart/form-data"> <!-- Update the action attribute with the appropriate PHP script to handle form submission -->
            <div class="form-group">
                <label for="itemName">Item Name:</label>
                <input type="text" class="form-control" id="itemName" name="itemName" value="<?php echo $item['itemName']; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"><?php echo $item['description']; ?></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="itemImage">Item Image:</label>
                <input type="file" class="form-control-file" id="itemImage" name="itemImage">
            </div>

            <input type="hidden" name="itemCode" value="<?=$itemCode; ?>">
            <input type="hidden" name="businessCode" value="<?=$businessCode; ?>">
            <input type="hidden" name="branchCode" value="<?=$branchCode; ?>">
            <input type="hidden" name="packCode" value="<?=$packCode; ?>">

            <hr>
            <button type="submit" class="btn btn-primary">Update Item</button>
        </form>
    <div>
</div>