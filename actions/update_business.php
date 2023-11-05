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
    $businessCode = $_POST['business_Code'];
    $busName = mysqli_real_escape_string($DB, $_POST['data']['busName']);
    $about = mysqli_real_escape_string($DB, $_POST['data']['about']);
    $phone = mysqli_real_escape_string($DB, $_POST['data']['phone']);

    // Update the business information in the database
    $sql = "UPDATE branches SET busName = '$busName', about = '$about', phone = '$phone' WHERE businessCode = '$businessCode'";

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
