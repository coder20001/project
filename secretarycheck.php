<?php
// Database connection code
require_once("config.php");
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Escape and assign parameters
$userf = $conn->real_escape_string($_REQUEST['firstName']);
$userl = $conn->real_escape_string($_REQUEST['lastName']);
$sectemail = $conn->real_escape_string($_REQUEST['useremail']); // Fixed variable name
$location = $conn->real_escape_string($_REQUEST['house']); // Ensure you have 'house' in your form
$secNumber = $conn->real_escape_string($_REQUEST['secnumber']); // Adjust according to your form input
$role = $conn->real_escape_string($_REQUEST['role']); // New role parameter

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO user (UserFName, UserLName, UserEmail, UserPassword, ResidenceLocation, SecretaryNumber, Role) 
 VALUES (?, ?, ?, ?, ?, ?, ?)");
//error handling
if($stmt === false){
    die("please enter the correct details in your sql statemnet.");
}
// Ensure you retrieve the password before hashing
$pass = $_REQUEST['userpassword']; // Correctly get the password from the form
$hashed_sect = password_hash($pass, PASSWORD_DEFAULT);


// Check that you have the right number of parameters
if ($stmt) {
    // Bind parameters: "sssssss" corresponds to the types
    $stmt->bind_param("sssssss", $userf, $userl, $sectemail, $hashed_sect, $location, $secNumber, $role);
    
    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        header("Location: successh.php");
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
