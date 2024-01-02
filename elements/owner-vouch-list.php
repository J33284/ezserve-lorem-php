<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$ownerID = $_SESSION['userID'];
global $DB;

// Fetch existing businesses for the dropdown
$queryBusiness = "SELECT * FROM business WHERE ownerID = $ownerID";
$businesses = $DB->query($queryBusiness);

// Fetch existing vouchers
$queryVouchers = "SELECT *
                  FROM voucher
                  JOIN business ON voucher.businessCode = business.businessCode
                  LEFT JOIN branches ON branches.businessCode = business.businessCode
                  WHERE business.ownerID = $ownerID";

$vouchers = $DB->query($queryVouchers);
?>

<div id="vouch-list" class="vouch-list w-95 overflow-auto" style="width: auto; margin: 100px 20px 0px 20%; height: 100vh;">
  <div class="d-flex justify-content-between p-3">
    <h1 >Vouchers</h1>
  </div>
  <br>

  <div class="voucher-tbl overflow-auto  " >
    <form id="voucherForm" action="?action=save_voucher" method="post">
      <table id="voucherTable" class="table table-hover table-responsive table-bordered  " >
        <thead  class="table-dark">
          <tr>
            <th scope="col">Business Name</th>
            <th scope="col">Branch Name</th>
            <th scope="col">Voucher Code</th>
            <th scope="col">Condition</th>
            <th scope="col">Discount Amount</th>
            <th scope="col">Discount Type</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($vouchers as $voucher) : ?>
            <tr>
              <td class="bg-transparent border border-white"><?= $voucher['busName'] ?></td>
              <td class="bg-transparent border border-white"><?= $voucher['branchName'] ?></td>
              <td class="bg-transparent border border-white"><?= $voucher['code'] ?></td>
              <td class="bg-transparent border border-white">₱<?= number_format($voucher['cond']) ?></td> <!--select option, minimum spend, gift, package-specific-->
              <td class="bg-transparent border border-white"><?= $voucher['discount'] ?>%</td>
              <td class="bg-transparent border border-white"><?= $voucher['discount'] ?>%</td> <!--select option, percentage, fixed amount -->
              <td class="bg-transparent border border-white"><?= $voucher['startDate'] ?></td>
              <td class="bg-transparent border border-white"><?= $voucher['endDate'] ?></td>
              <td class="bg-transparent border border-white d-flex">
                <button class="btn btn-sm btn-warning btn-edit" data-voucher-id="<?= $voucher['voucherID'] ?>">
                  Edit
                </button>
                <button class="btn btn-sm btn-danger btn-delete" data-voucher-code="<?= $voucher['code'] ?>">
                  Delete
                </button>
                <button class="btn btn-sm btn-success btn-save" style="display: none;">
                    Save
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
          <tr id="newRow" class="table table-hover table-responsive" style="display: none;">
            <td>
              <select class="business-dropdown" name="newBusinessCode" required>
                <option value="" selected disabled>Select a business</option>
                <?php foreach ($businesses as $business) : ?>
                  <option value="<?= $business['businessCode'] ?>"><?= $business['busName'] ?> </option>
                <?php endforeach; ?>
              </select>
            </td>
            <td class="bg-transparent border border-white"><input type="text" name="newVoucherCode" required></td>
            <td class="bg-transparent border border-white"><input type="text" name="newCondition" required></td>
            <td class="bg-transparent border border-white"><input type="text" name="newDiscount" required></td>
            <td class="bg-transparent border border-white"><input type="date" name="newStartDate" required></td>
            <td class="bg-transparent border border-white"><input type="date" name="newEndDate" required></td>
          </tr>
        </tbody>
      </table>
      <button id="addRowBtn" class="btn btn-primary mt-3">Add Row</button>
      <button id="saveBtn" class="btn btn-success mt-3" style="display: none;">Save</button>
      <button id="cancelBtn" class="btn btn-secondary mt-3" style="display: none;">Cancel</button>
    </form>
  </div>
</div>

<script>
  document.getElementById("addRowBtn").addEventListener("click", function (event) {
    event.preventDefault();

    newRow.style.display = "table-row";
    document.getElementById("voucherTable").getElementsByTagName('tbody')[0].appendChild(newRow);

    document.getElementById("addRowBtn").style.display = "none";
    document.getElementById("saveBtn").style.display = "inline-block";
    document.getElementById("cancelBtn").style.display = "inline-block";
  });

  // Add an event listener to each delete button
  document.querySelectorAll('.btn-delete').forEach(function (button) {
    button.addEventListener('click', function (event) {
      event.preventDefault();
      // Perform actions when delete button is clicked, e.g., confirm deletion and send a request to delete
      // You can access the data attribute for the voucher code using:
      // var voucherCode = button.getAttribute('data-voucher-code');
    });
  });

  // Add an event listener to each edit button
  document.querySelectorAll('.btn-edit').forEach(function (button) {
    button.addEventListener('click', function (event) {
      event.preventDefault();
      var row = button.closest('tr');

      // Make the row editable
      row.querySelectorAll('td:not(:last-child)').forEach(function (cell) {
        var input = document.createElement('input');
        input.value = cell.textContent.trim();
        cell.innerHTML = '';
        cell.appendChild(input);
      });

      // Show the save button for this row
      row.querySelector('.btn-save').style.display = 'inline-block';
      // Hide the edit and delete buttons
     // Hide the edit and delete buttons
     row.querySelector('.btn-edit').style.display = 'none';
    row.querySelector('.btn-delete').style.display = 'none';
    });
  });

  // Add an event listener to each save button
  document.querySelectorAll('.btn-save').forEach(function (button) {
    button.addEventListener('click', function (event) {
      event.preventDefault();
      var row = button.closest('tr');

      // Collect data from the editable inputs
      var formData = {
        voucherID: row.querySelector('button.btn-edit').getAttribute('data-voucher-id'),
        businessCode: row.querySelector('td:nth-child(1) input').value,
        voucherCode: row.querySelector('td:nth-child(2) input').value,
        condition: row.querySelector('td:nth-child(3) input').value,
        discount: row.querySelector('td:nth-child(4) input').value,
        startDate: row.querySelector('td:nth-child(5) input').value,
        endDate: row.querySelector('td:nth-child(6) input').value
      };

      // Perform a form submission
      document.getElementById('voucherForm').action = '?action=update_voucher';
      // Set the form action to the URL where the update should be handled
      // Use formData to populate hidden input fields
      for (var key in formData) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = formData[key];
        document.getElementById('voucherForm').appendChild(input);
      }

      // Submit the form
      document.getElementById('voucherForm').submit();
    });
  });
</script>
