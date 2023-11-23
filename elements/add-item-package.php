<?php
global $DB;
$branchCode = isset($_GET['branchcode']) ? $_GET['branchcode'] : '';
$packageQuery = "SELECT package.packCode, package.packName, category.categoryName, service.serviceName, service.Description, service.quantity, service.color, service.price
FROM package
JOIN category ON package.packCode = category.packCode
JOIN service ON category.categoryCode = service.categoryCode
WHERE package.branchCode = $branchCode;";
$packageResult = $DB->query($packageQuery);
$row = $packageResult->fetch_assoc();
?>



<div class="form-container">
  <form method="post" action="?action=add_packageAction">
    <h2>Add Package Item </h2>
    <table class="table table-hover table-responsive">
      <tbody>
        <tr>
          <td>Package Name:</td>
          <td colspan="3"><input type="text" name="packName" class="form-control" required><?= $row['packName'] ?></td>
        </tr>
        <tr>
          <td>Category:</td>
          <td><input type="text" name="categoryName" class="form-control" required></td>
          <td>Service:</td>
          <td><input type="text" name="serviceName" class="form-control" required></td>
        </tr>
        <tr>
          <td>Description:</td>
          <td colspan="3"><input type="text" name="Description" class="form-control" required></td>
        </tr>
        <tr>
          <td>Quantity:</td>
          <td><input type="number" name="quantity" class="form-control" required></td>
          <td>Color:</td>
          <td><input type="text" name="color" class="form-control" required></td>
        </tr>
        <tr>
          <td>Price:</td>
          <td colspan="3"><input type="number" name="price" class="form-control" step="0.01" required></td>
        </tr>
        <tr>
        <td colspan="4"><input type="hidden" name="branchcode" value="<?= isset($_GET['branchcode']) ? $_GET['branchcode'] : ''; ?>"></td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: center;">
            <button type="submit" class="btn btn-primary">Save Package</button>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>


<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 110vh;
    margin-left: 250px;
    
  }

  .form-container {
    width: 50%;
    padding: 20px;
    background-color: #f8f9fa;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
  }

  .form-container h2 {
    text-align: center;
  }

  .table {
    width: 100%;
    .table th,
    .table td {
    width: 150px;
    }

  }
</style>
