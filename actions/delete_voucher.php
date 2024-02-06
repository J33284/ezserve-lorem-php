<?php
if(isset($_GET['id'])) {
    $voucherID = $_GET['id'];

    global $DB;
    $deleteQuery = "DELETE FROM voucher WHERE voucherID = '$voucherID'";
    $result = $DB->query($deleteQuery);

    if($result) {
        header("Location: ?page=owner_voucher");
        exit(); 
    } else {
        echo "Error deleting voucher.";
    }
} else {
    echo "Invalid request.";
}
?>
