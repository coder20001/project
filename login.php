<?php
// Start the session at the very beginning
session_start();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = $_POST["useremail"];
    $password = $_POST["userpassword"];

    // Database connection
    require_once("config.php");
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM user WHERE UserEmail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['access'] = "yes";
        $_SESSION['role'] = $row['Role'];
        
        // Check password (assuming password is hashed)
        if (password_verify($password, $row['UserPassword'])) {
            $_SESSION['userid'] = $row['UserID']; // Store UserID in the session

            // Redirect based on user role
            if ($row['Role'] == 'Student') {
                header('Location: studentview.php');
                exit();
            } else if ($row['Role'] == 'House Warden') {
                header('Location: wardenview.php');
                exit();
            } else if ($row['Role'] == 'Hall Secretary') {
                header('Location: secretaryview.php');
                exit();
            } else if ($row['Role'] == 'Maintenance Staff') {
                header('Location: maintenanceview.php');
                exit();
            } else {
                header('Location: who are you.php');
                exit();
            }
        } else {
            $loginError = "Invalid email or password.";
        }
    } else {
        $loginError = "Invalid email or password.";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <link rel="stylesheet" href="login.css">
    <style>
        .error { color: red; }
        .valid { color: green; }
        .success { color: green; }
        .try { color: maroon; }
        
        /* Button styling */
        .login {
            background-color: #ffcc00;
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            color: black;
            font-weight: bold;
        }

        .login:hover {
            background-color: #e6b800;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form">
            <div class="log"><img src="logo.png" alt="Logo"></div>
            <h3>Login</h3>
            <form id="userForm" action="login.php" method="post">
                <div class="floating-label">
                    <input type="email" id="Email" name="useremail" placeholder=" " required>
                    <label>Username</label>
                    <i class="fa-regular fa-envelope"></i>
                    <span id="emailError" class="error"></span> 
                </div>
                <div class="floating-label">
                    <input type="hidden" name="role" id="role" value="<?php echo isset($role) ? htmlspecialchars($role) : ''; ?>">
                    <input type="password" id="Password" name="userpassword" placeholder=" " required>
                    <label>Password</label>
                    <span class="eye" onclick="passwordFunction()">
                        <i id="show" class="fa-solid fa-eye"></i>
                        <i id="hide" class="fa-solid fa-eye-slash"></i>
                    </span>
                    <span id="passwordError" class="error"></span>
                </div> 
                <div class="forgot">
                    <p><a href="#">Forgot your password?</a></p>
                </div>
                <div><input type="submit" name="Login" class="login" value="Login"></div> 
                <p class="new-here"><b>New here?</b> <a href="who are you.php">Create an account</a></p>
            </form>
            <?php
                // Display the login error message if it exists
                if (isset($loginError)) {
                    echo "<p class='error'>$loginError</p>";
                }
            ?>
        </div>
        <div class="picture">
            <div class="image"> 
                <img src="logsignpic.png" alt="Sign Up Image"> 
                <div class="focus-text">
                    <p>Our focus is on</p>
                    <h2>creating a safe and </h2>
                    <h2>efficient environment</h2>
                    <p>for residence maintenance and management</p>
                </div>
            </div> 
        </div>
    </div>
    <script src="javascript.js"></script>
</body>
</html>
