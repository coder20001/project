<?php
// Database connection code
require_once("config.php");
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO user (UserFName, UserLName, UserEmail, UserPassword, MaintenanceNumber, Role) 
 VALUES (?, ?, ?, ?, ?, ?)");

// Ensure you retrieve the password before hashing
$pass = $_REQUEST['userpassword']; // Correctly get the password from the form
$hashed_maint = password_hash($pass, PASSWORD_DEFAULT);

// Escape and assign parameters
$userf = $conn->real_escape_string($_REQUEST['firstName']);
$userl = $conn->real_escape_string($_REQUEST['lastName']);
$maintemail = $conn->real_escape_string($_REQUEST['useremail']); // Fixed variable name
$mainNumber = $conn->real_escape_string($_REQUEST['mainnum']); // Adjust according to your form input
$role = $conn->real_escape_string($_REQUEST['role']); // New role parameter
//error handling
if($stmt === false){
    die("please enter the correct details in your sql statemnet.");
}
// Check that you have the right number of parameters
if ($stmt) {
    // Bind parameters: "ssssss" corresponds to the types
    $stmt->bind_param("ssssss", $userf, $userl, $maintemail, $hashed_maint, $mainNumber, $role);
    
    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        header("Location: successm.php");
        exit();
    } else {
        // Improved error handling
        echo "Error executing query: " . $stmt->error;
    }
    
    // Close prepared statement
    $stmt->close();
} else {
    die("Preparation failed: " . $conn->error);
}

// Close connection
$conn->close();
?>
