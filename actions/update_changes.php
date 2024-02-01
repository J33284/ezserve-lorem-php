
<?

$itemCode = isset($_POST['itemCode']) ? $_POST['itemCode'] : '';
$newItemName = isset($_POST['newItemName']) ? $_POST['newItemName'] : '';
$newDescription = isset($_POST['newDescription']) ? $_POST['newDescription'] : '';
$newQuantity = isset($_POST['newQuantity']) ? $_POST['newQuantity'] : '';
$newPrice = isset($_POST['newPrice']) ? $_POST['newPrice'] : '';

// Your SQL query to update the "items" table with the new values
$sql = "UPDATE items SET itemName = '$newItemName', description = '$newDescription', quantity = '$newQuantity', price = '$newPrice' WHERE itemCode = '$itemCode'";

// Perform the query and handle errors
if ($conn->query($sql) === TRUE) {
    // If the query was successful, send a success response
    echo json_encode(['status' => 'success']);
} else {
    // If an error occurred, send an error response
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

?>