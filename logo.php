<?php
session_start(); // Only call once at the beginning

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize variables
$username = '';
$password = '';
$loginError = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Email']) && isset($_POST['Password'])) {
        $username = $_POST['Email'];
        $password = $_POST['Password'];

        // Database connection
        require_once("config.php");
        $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

        if ($conn->connect_error) {
            die("<p class=\"error\"> Error with the database connection </p>");
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM user WHERE UserEmail = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Check password
            if (password_verify($password, $row['UserPassword'])) {
                $_SESSION['access'] = "yes";
                $_SESSION['role'] = $row['Role'];

                // Redirect based on user role
                switch ($row['Role']) {
                    case 'Student':
                        header('Location: studentview.php');
                        break;
                    case 'House Warden':
                        header('Location: wardenview.php');
                        break;
                    case 'Hall Secretary':
                        header('Location: secretaryview.php');
                        break;
                    case 'Maintenance Staff':
                        header('Location: maintenancenview.php');
                        break;
                    default:
                        header('Location: signup.php');
                }
                exit(); // Stop executing the script after redirection
            } else {
                $loginError = "Invalid email or password.";
            }
        } else {
            $loginError = "Invalid email or password.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
  <div class="container">
      <div class="form">
          <div class="log"><img src="logo.png"></div>
          <h3>Login</h3>
          <form id="userForm" action="login.php" method="post">
              <div class="floating-label">
                  <input type="email" id="Email" name="Email" placeholder=" " required>
                  <label>Username</label> 
                  <i class="fa-regular fa-envelope"></i>
                  <span id="emailError" class="error"></span>  
              </div>
              <div class="floating-label">
                  <input type="password" id="Password" name="Password" placeholder=" " required>
                  <label>Password</label> 
                  <span class="eye" onclick="passwordFunction()">
                      <i id="show" class="fa-solid fa-eye"></i>
                      <i id="hide" class="fa-solid fa-eye-slash"></i>
                  </span>
                  <span id="passwordError" class="error"></span>
              </div> 
              <div class="floating-label"> <input type="hidden" name="UserID" id="UserID" value = "<?php echo $_REQUEST['id'];?>"> </div>
              <div><input type="submit" name="Login" class="login" value="Login"></div> 
              <div class="forgot">
                  <p><a href="#">Forgot your password?</a></p>
              </div>
              <p class="new-here"><b>New here?</b> <a href="who are you.php">Create an account</a></p>
          </form>
      </div>
      <div class="picture">
          <div class="image"> 
              <img src="logsignpic.png"> 
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
