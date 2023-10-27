<?php
if (!defined('ACCESS')) {
    die('DIRECT ACCESS NOT ALLOWED');
}

function viewAdmin($adminID) {
    global $DB;

    $query = $DB->prepare("SELECT * FROM admin WHERE adminID = ?");
    $query->bind_param("i", $adminID);

    $query->execute();
    $result = $query->get_result();

    $user = $result->fetch_object();

    return $user;

}



function updateAdmin($adminID, $updatedData) {
    global $DB;

    $updates = [];
    foreach ($updatedData as $key => $value) {
        $updates[] = "$key = '" . $DB->real_escape_string($value) . "'";
    }

    $updatesStr = implode(', ', $updates);
    $sql = "UPDATE admin SET $updatesStr WHERE adminID = $adminID";
    $DB->query($sql);

    return $DB->affected_rows > 0;
}

// Check if form is submitted for updating user details
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $updatedData = array(
       
        'email' => $_POST['email'],
        'username' => $_POST['username']
    );

    $adminID = $_SESSION['userID'];

    if (updateAdmin($adminID, $updatedData)) {
        // Update successful
        set_message( "Changes Saved Successfully" );
        
    } else {
        // Update failed
        echo "Error updating record";
    }
}





if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $businesscode = isset($_POST['businessCode']) ? intval($_POST['businessCode']) : 0;

    if ($businessID > 0) {
    
      
        try {
            
            $pdo = new PDO('mysql:host=localhost;dbname=webworks_db', '', '');
            $sql = "UPDATE business SET status = 1 WHERE businessCode = :businessCode";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':businessCode', $businessCode, PDO::PARAM_INT);
            $stmt->execute();

            // Return a JSON response indicating success
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            // Handle any database error and return an error response
            echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        // Invalid or missing business ID
        echo json_encode(['success' => false, 'error' => 'Invalid or missing business ID']);
    }
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
