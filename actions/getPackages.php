<?php

// Assuming you have a function to fetch packages based on the branch code
function getPackages($branchCode) {
    global $DB;
    $query = "SELECT * FROM package WHERE branchCode = '$branchCode'";
    return $DB->query($query);
}

if ($_GET['action'] == 'getPackages') {
    $branchCode = $_GET['branchCode'];
    $packages = getPackages($branchCode);

    // Output HTML options for packages
    while ($row = $packages->fetch_assoc()) {
        echo "<option value='" . $row["packCode"]  . "'>" . $row["packName"] . "</option>";
    }
    exit(); // Ensure no other content is sent
}
?>