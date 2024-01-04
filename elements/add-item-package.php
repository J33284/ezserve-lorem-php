<?php
global $DB;

$packCode = isset($_GET['packagecode']) ? $_GET['packagecode'] : '';
$categoryCode = isset($_GET['categoryCode']) ? $_GET['categoryCode'] : '';

$packageQuery = "SELECT *
FROM package
JOIN category ON package.packCode = category.packCode
JOIN items ON category.categoryCode = items.categoryCode
WHERE package.packCode = '$packCode';";
$packageResult = $DB->query($packageQuery);
$row = $packageResult->fetch_assoc();
?>

<div class="form-container">
  <form method="post" action="?action=add_itemAction">
    <h2>Add Package Item </h2>
    <table class="table table-hover table-responsive">
      <tbody>
        <tr>
          <td>Package Name:</td>
          <td colspan="5"><input type="text" name="packName" class="form-control" readonly value="<?= $row['packName'] ?>"></td>
        </tr>
        <tr>
          <td>Category:</td>
          <td colspan ="2"><input type="text" name="categoryName" class="form-control" required></td>
        <tr>
          <td>Description:</td>
          <td colspan ="5"><input type="text" name="Description" class="form-control" required></td>
        </tr>
        <tr>
          <td>Quantity:</td>
          <td><input type="number" name="quantity" class="form-control" required></td>
          <!--
          <td>Unit:</td>
          <td>
            <select name="unit" class="form-control">
                  <option value="units">Unit/s</option>
                  <option value="set">Set/s</option>
                  <option value="bundle">Bundle</option>
                  <option value="pair">Pair/s</option>
                  <option value="kg">kg</option>
                  <option value="hours">Hours</option>
                  <option value="servings">Servings</option>
                  <option value="kg">Kilograms (kg)</option>
                  <option value="lb">Pounds (lb)</option>
            </select>
            </td>
-->
           <td>Price:</td>
          <td colspan ="2"><input type="number" name="price" class="form-control" step="0.01" placeholder="price per unit" required></td>
        </tr>
        <tr>
          <td colspan="5"><input type="hidden" name="branchcode" value="<?= isset($_GET['branchcode']) ? $_GET['branchcode'] : ''; ?>"></td>
          <td><input type="hidden" name="packagecode" value="<?= $row['packCode'] ?>"></td>
        </tr>
        <tr>
          <td colspan="6" style="text-align: center;">
            <button type="submit" class="btn btn-primary">Save Item</button>
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
    width: 70%;
    padding: 10px;
    background-color: #f8f9fa;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
  }

  .form-container h2 {
    text-align: center;
  }
</style>
