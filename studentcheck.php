
 <?php
require_once("config.php");
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Escape and assign parameters
$userf = $conn->real_escape_string($_REQUEST['firstName']);
$userl = $conn->real_escape_string($_REQUEST['lastName']);
$studemail = $conn->real_escape_string($_REQUEST['useremail']);
$location = $conn->real_escape_string($_REQUEST['house']);
$studentNumber = $conn->real_escape_string($_REQUEST['number']);
$role = $conn->real_escape_string($_REQUEST['role']); // New role parameter

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO user (UserFName, UserLName, UserEmail, UserPassword, ResidenceLocation, StudentNumber, Role) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");
//error handling
if($stmt === false){
    die("please enter the correct details in your sql statemnet.");
}
// Ensure you retrieve the password before hashing
$pass = $_REQUEST['userpassword'];
$hashed_student = password_hash($pass, PASSWORD_DEFAULT);


// Check that you have the right number of parameters
if ($stmt) {
    // Bind parameters: "sssssss" corresponds to the types
    $stmt->bind_param("sssssss", $userf, $userl, $studemail, $hashed_student, $location, $studentNumber, $role);
    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        header("Location: successstu.php");
        exit();
    } else {
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