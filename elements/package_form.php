<?php
$branchCode = $branchData['branchCode'];
$packageQuery = "SELECT * FROM package WHERE branchCode = $branchCode";
$packageResult = $DB->query($packageQuery);
?>

<!-- DIVISION 3 PACKAGES -->
