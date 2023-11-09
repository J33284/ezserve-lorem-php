<?php
// Check if the form is submitted
if (isset($_POST['updateBusiness'])) {
    global $DB;

    // Sanitize and validate the input data as needed
    $businessCode = $_POST['business_Code'];
    $busName = mysqli_real_escape_string($DB, $_POST['data']['busName']);
    $about = mysqli_real_escape_string($DB, $_POST['data']['about']);
    $phone = mysqli_real_escape_string($DB, $_POST['data']['phone']);

    // Update the business information in the database
    $sql = "UPDATE business SET busName = '$busName', about = '$about', phone = '$phone' WHERE businessCode = '$businessCode'";

    if ($DB->query($sql) === true) {
        // Redirect to a success page or update the current page as needed
       redirect("?page=owner_business");
    } else {
        // Handle the update failure, display an error message, or redirect to an error page
        echo "Error updating business information: " . $DB->error;
        // You may want to redirect to an error page or display a proper error message here   
    }
   
}
?>

<?php
// Check if the form is submitted
if (isset($_POST['updateBranch'])) {
    global $DB;

    // Sanitize and validate the input data as needed
    $branchCode = $_POST['branch_Code'];
    $branchName = mysqli_real_escape_string($DB, $_POST['data']['branchName']);
    $address = mysqli_real_escape_string($DB, $_POST['data']['address']);
    $coordinates = mysqli_real_escape_string($DB, $_POST['data']['coordinates']);

    // Update the branch information in the database using $branchCode as the primary key
    $sql = "UPDATE branches SET branchName = '$branchName', address = '$address', coordinates = '$coordinates' WHERE branchCode = '$branchCode'";

    if ($DB->query($sql) === true) {
        // Redirect to a success page or update the current page as needed
        redirect("?page=owner_business");
    } else {
        // Handle the update failure, display an error message, or redirect to an error page
        echo "Error updating branch information: " . $DB->error;
        // You may want to redirect to an error page or display a proper error message here
    }
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createBranch'])) {
   
    global $DB;

    $businessCode = $_POST['add_branch'];
    $branchName = $_POST['data']['branchName'];
    $address = $_POST['data']['address'];
    $coordinates = $_POST['data']['coordinates'];

    // File handling
    $uploadDirectory = 'assests/uploads/branches'; // Define your upload directory path
    $uploadedFile = $_FILES['branchImage'];

    // Initialize $uniqueFilename outside the if block
    $uniqueFilename = "";

    if ($uploadedFile['error'] === UPLOAD_ERR_OK){
        // Generate a unique filename
        $uniqueFilename = uniqid() . '_' . $uploadedFile['name'];

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($uploadedFile['tmp_name'], $uploadDirectory . $uniqueFilename)) {
            // File was successfully uploaded
            // You can store $uniqueFilename in the database as a reference to the uploaded file.
        } else {
            // Handle file upload error
            echo "File upload failed.";
        }
    }

    // SQL query to insert branch data into the branches table
    $sql = "INSERT INTO branches (businessCode, branchName, address, coordinates, imageFile) VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $DB->prepare($sql);
    $stmt->bind_param("issss", $businessCode, $branchName, $address, $coordinates, $uniqueFilename);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Insertion successful
        header("Location: ?page=owner_business");
    } else {
        // Insertion failed
        echo "Error: " . $sql . "<br>" . $DB->error;
    }

    $stmt->close();
}
?>

