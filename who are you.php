<?php
session_start();
// Initialize variables for potential error messages
$errorMessage = '';
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the role is set
    if (isset($_POST['role'])) {
        $role = $_POST['role'];
        // Check if email and password are set in the session
        if (isset($_SESSION['useremail']) && isset($_SESSION['userpassword'])) {
            $email = $_SESSION['useremail']; 
            $password = $_SESSION['userpassword']; 

            // Database connection
            require_once("config.php");
            $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

            // Check for database connection error
            if ($conn->connect_error) {
                die("<p class=\"error\"> Error with the database connection </p>");
            }

            // Prepare the SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO user (UserEmail, UserPassword, Role) VALUES (?, ?, ?)");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("sss", $email, $password, $role);

            // Execute the statement and check for success
            if ($stmt->execute()) {
                // Redirect based on user role
                switch ($role) {
                    case 'Student':
                        header('Location: students.php');
                        break;
                    case 'House Warden':
                        header('Location: warden.php');
                        break;
                    case 'Hall Secretary':
                        header('Location: secretary.php');
                        break;
                    case 'Maintenance Staff':
                        header('Location: maintenance.php');
                        break;
                    default:
                        $errorMessage = "Invalid role selected.";
                }
                exit(); // Stop executing the script after redirection
            } else {
                $errorMessage = "Error inserting data into the database.";
            }

            $stmt->close();
            $conn->close();
        } else {
            $errorMessage = "Email and password must be set in the session.";
        }
    } else {
        $errorMessage = "Please select a role.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Who Are You</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="container">
        <div class="form">    
            <div class="log">
                <img src="logo.png" alt="Logo">
            </div> 
            <div class="who">
            <h1>What are you signing up as?</h1>  
            <form method="post">
    <div>
        <button type="submit" class="sub" name="role" value="Student" formaction="students.php">Student</button>
    </div>
    <div>
        <button type="submit" class="sub" name="role" value="House Warden" formaction="warden.php">Warden</button>
    </div>
    <div>
        <button type="submit" class="sub" name="role" value="Hall Secretary" formaction="secretary.php">Secretary</button>
    </div>
    <div>
        <button type="submit" class="sub" name="role" value="Maintenance Staff" formaction="maintenance.php">Maintenance Staff</button>
    </div>
</form>

                <?php if (!empty($errorMessage)): ?>
                    <p class="error"><?php echo $errorMessage; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <style>
            button.sub {
                margin: 20px 10px; /* Increased space between buttons */
                color: black;
                width: 160px;
            }
            button.sub:hover{
                background-color: #e6b800;
            }
        </style>
        <div class="picture">
            <div class="image">
                <img src="logsignpic.png" alt="Sign Up Image">
                <div class="focus-text">
                    <p>Our focus is on</p>
                    <h2 class="big">creating a safe and</h2>
                    <h2 class="big">efficient environment</h2>
                    <p>for residence maintenance and management</p>
                </div>
            </div>
        </div> 
    </div>
</body>
</html>
