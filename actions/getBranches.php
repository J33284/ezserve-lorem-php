<?php

global $DB;

if (isset($_GET['businessCode'])) {
    $businessCode = $_GET['businessCode'];

    $branches = $DB->query("SELECT * FROM branches WHERE businessCode = '$businessCode'");
    echo"<option disabled selected >--Select Branches--</option>";
    echo "<option value='0'>All Branches </option>"; 
    while ($row = $branches->fetch_assoc()) {
        echo "<option value='" . $row["branchCode"] . "'>" . $row["branchName"] . "</option>";
    }
}
?>
