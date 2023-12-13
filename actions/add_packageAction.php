<?php

global $DB;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $branchCode = isset($_POST['branchcode']) ? $_POST['branchcode'] : '';
    $packName = $_POST["packName"];
    $categoryNames = $_POST["categoryName"];
    $serviceNames = $_POST["serviceName"];
    $descriptions = $_POST["Description"];
    $quantities = $_POST["quantity"];
    $units = $_POST["unit"];
    $sizes = $_POST["size"];
    $colors = $_POST["color"];
    $prices = $_POST["price"];

    try {
       
        $DB->begin_transaction();

        $stmt = $DB->prepare("INSERT INTO package (branchCode, packName) VALUES (?, ?)");
        $stmt->bind_param("ss", $branchCode, $packName);
        $stmt->execute();

        
        $packCode = $DB->insert_id;

        
        for ($i = 0; $i < count($categoryNames); $i++) {
    
            $stmt = $DB->prepare("INSERT INTO category (packCode, categoryName) VALUES (?, ?)");
            $stmt->bind_param("ss", $packCode, $categoryNames[$i]);
            $stmt->execute();

            $categoryCode = $DB->insert_id;

            $stmt = $DB->prepare("INSERT INTO service (categoryCode, serviceName, Description, color, quantity, unit, size, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $categoryCode, $serviceNames[$i], $descriptions[$i], $colors[$i], $quantities[$i], $units[$i],  $sizes[$i], $prices[$i]);
            $stmt->execute();
        }

       
        $DB->commit();

    
        $insertionSuccess = true;

    } catch (Exception $e) {
     
        $DB->rollback();

    
        $insertionSuccess = false;

        echo "Error: " . $e->getMessage();
    }
}

if ($insertionSuccess) {
  
    header('Location: ?page=package&branchcode=' . urlencode($branchCode));
    exit(); 
} else {
  
    echo "Insertion failed. Please try again.";
}
?>
