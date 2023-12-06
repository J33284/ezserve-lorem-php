<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$ownerID = $_SESSION['userID'];
global $DB;

// Fetch existing businesses for the dropdown
$queryBusiness = "SELECT * FROM business WHERE ownerID = $ownerID";
$businesses = $DB->query($queryBusiness);

// Fetch existing vouchers
$queryVouchers = "SELECT business.busName, voucher.code, voucher.cond, voucher.discount, voucher.startDate, voucher.endDate
                  FROM voucher
                  JOIN business ON voucher.businessCode = business.businessCode
                  WHERE business.ownerID = $ownerID";
$vouchers = $DB->query($queryVouchers);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user input (add your validation logic here)
    $businessCode = $_POST['newBusiness'];
    $code = htmlspecialchars($_POST['newCode']);
    $cond = htmlspecialchars($_POST['newCond']);
    $discount = htmlspecialchars($_POST['newDiscount']);
    $startDate = $_POST['newStartDate'];
    $endDate = $_POST['newEndDate'];

    // Insert new voucher into the database
    $insertQuery = "INSERT INTO voucher (businessCode, code, cond, discount, startDate, endDate) 
                    VALUES ('$businessCode', '$code', '$cond', '$discount', '$startDate', '$endDate')";
    $DB->query($insertQuery);
}

?>

<div id="vouch-list" class="vouch-list" style="width: 75vw; margin: 100px 0px 0px 300px; height: 100vh;">
  <div class="d-flex justify-content-between p-3">
    <h1 class="text-light">Vouchers</h1>
    <a href="#" class="btn-edit btn-lg float-end mt-4 text-light">
      <i class="bi bi-pencil-fill"></i> Edit
    </a>
  </div>
  <br>

  <div class="voucher-tbl" style="height: 80vh; overflow-y: auto;">
    <table id="voucherTable" class="table table-hover table-responsive">
      <thead>
        <tr>
          <th scope="col">Business Name</th>
          <th scope="col">Voucher Code</th>
          <th scope="col">Condition</th>
          <th scope="col">Discount</th>
          <th scope="col">Start Date</th>
          <th scope="col">End Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($vouchers as $voucher) : ?>
          <tr>
            <td><?= $voucher['busName'] ?></td>
            <td><?= $voucher['code'] ?></td>
            <td><?= $voucher['cond'] ?></td>
            <td><?= $voucher['discount'] ?></td>
            <td><?= $voucher['startDate'] ?></td>
            <td><?= $voucher['endDate'] ?></td>
          </tr>
        <?php endforeach; ?>
        <!-- Add a row for user input -->
        <tr id="newRow" style="display: none;">
          <td>
            <select name="newBusiness" id="newBusiness">
              <?php foreach ($businesses as $business) : ?>
                <option value="<?= $business['businessCode'] ?>"><?= $business['busName'] ?></option>
              <?php endforeach; ?>
            </select>
          </td>
          <td><input type="text" name="newCode"></td>
          <td><input type="text" name="newCond"></td>
          <td><input type="text" name="newDiscount"></td>
          <td><input type="date" name="newStartDate"></td>
          <td><input type="date" name="newEndDate"></td>
        </tr>
      </tbody>
    </table>
    <!-- Button to add a new row -->
    <button id="addRowBtn" class="btn btn-primary">Add Row</button>
    <!-- Button to save new rows to the database -->
    <button id="saveBtn" class="btn btn-success" style="display: none;">Save</button>
  </div>
</div>

<script>
  document.getElementById('addRowBtn').addEventListener('click', function() {
    document.getElementById('newRow').style.display = 'table-row';
    document.getElementById('addRowBtn').style.display = 'none';
    document.getElementById('saveBtn').style.display = 'block';
  });

  document.getElementById('saveBtn').addEventListener('click', function() {
    // Fetch values from the input fields
    var businessCode = document.getElementById('newBusiness').value;
    var code = document.getElementsByName('newCode')[0].value;
    var cond = document.getElementsByName('newCond')[0].value;
    var discount = document.getElementsByName('newDiscount')[0].value;
    var startDate = document.getElementsByName('newStartDate')[0].value;
    var endDate = document.getElementsByName('newEndDate')[0].value;

    // Set the form values to be submitted
    document.getElementById('newBusinessInput').value = businessCode;
    document.getElementById('newCodeInput').value = code;
    document.getElementById('newCondInput').value = cond;
    document.getElementById('newDiscountInput').value = discount;
    document.getElementById('newStartDateInput').value = startDate;
    document.getElementById('newEndDateInput').value = endDate;

    // Submit the form
    document.getElementById('saveForm').submit();

    // Reset the form and hide the new row
    document.getElementById('newRow').style.display = 'none';
    document.getElementById('addRowBtn').style.display = 'block';
    document.getElementById('saveBtn').style.display = 'none';
  });
</script>

<!-- Add a hidden form to submit data without AJAX -->
<form id="saveForm" method="post" style="display: none;">
  <input type="hidden" name="newBusiness" id="newBusinessInput">
  <input type="hidden" name="newCode" id="newCodeInput">
  <input type="hidden" name="newCond" id="newCondInput">
  <input type="hidden" name="newDiscount" id="newDiscountInput">
  <input type="hidden" name="newStartDate" id="newStartDateInput">
  <input type="hidden" name="newEndDate" id="newEndDateInput">
</form>