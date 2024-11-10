<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      #hide {
    display: none;
}  
    </style>
</head>
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
    <input type="password" id="Password" name="Password"  placeholder=" " required>
    <label>Password</label> 
    <span class="eye" onclick="passwordFunction()">
        <i id="show" class="fa-solid fa-eye"></i>
        <i id="hide" class="fa-solid fa-eye-slash"></i>
    </span>
  <span id="passwordError" class="error"></span>
</div>
<div class="floating-label"><input type="hidden" id="UserID" name="UserID" value="<?php echo $UserID ?>"></div>
<div class="forgot">
<p><a href="#">Forgot your password?</a></p>
</div>
<input type="submit" name="Login" value="Login">
<p class="new-here"><b>New here?</b> <a href="who are you.html">Create an account</a></p>
</form>
    </div>
    <div class="picture">
         <div class="image"> 
             <img src="logsignpic.png"> 
            <div class="focus-text">
                <p>Our focus is on</p>
                <h2>creating a safe and </h2>
                <h2> efficient enviornment</h2>
                <p>for residence maintenance and management</p>
            </div>
        </div> 
    </div>
</div>
<?php
session_start();

// Get values from form
$studemail = $_POST['Email']; // Changed to Email from the form
$pass1 = $_POST['Password'];  // Changed to Password from the form

// Database connection
require_once("config.php");
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {
    die("<p class=\"error\">Error with the database connection</p>");
}

// Prepare SQL query to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM user WHERE UserEmail = ? AND UserPassword = ?");
$stmt->bind_param("ss", $studemail, $pass1);  // Binding the parameters

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['access'] = "yes";
    $_SESSION['user'] = $row['UserFName'];
    $_SESSION['role'] = $row['Role'];

    // Redirect based on user role
    switch ($row['Role']) {
        case 'student':
            header('Location: studentview.php');
            break;
        case 'housewarden':
            header('Location: wardenview.php');
            break;
        case 'hallsecretary':
            header('Location: hallsecretaryview.php');
            break;
        case 'maintenancestaff':
            header('Location: maintenance.php');
            break;
        default:
            header('Location: login.php');
    }
} else {
    echo "<p class=\"error\">Incorrect username or password</p>";
}

$conn->close();
?>

<script>
   function passwordFunction() {
    var passwordInput = document.getElementById('Password');
    var showIcon = document.getElementById('show');
    var hideIcon = document.getElementById('hide');

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        showIcon.style.display = "none";
        hideIcon.style.display = "inline";
    } else {
        passwordInput.type = "password";
        showIcon.style.display = "inline";
        hideIcon.style.display = "none";
    }
} 
</script>
</body>
</html>

<?php
 //start session
  session_start();
  var_dump($_REQUEST);
  //get values from form
/*  $studemail = $_REQUEST['studentemail'];
 $pass1 = $_REQUEST['studentpassword'];
 $wardenemail = $_REQUEST['wardenemail'];
$pass2 = $_REQUEST['wardenpassword'];
 $sectemail = $_REQUEST['secretaryemail'];
 $pass3 = $_REQUEST['secretarypassword'];
 $maintemail = $_REQUEST['maintemail'];
$pass4 = $_REQUEST['maintenancepassword'];
$userID= $_REQUEST['userID']; */
$username = $_REQUEST['Email'];
$password = $_REQUEST['Password'];


 //database connection
 require_once("config.php");
 $conn = new mysqli(SERVERNAME,USERNAME,PASSWORD, DATABASE);
 if($conn->connect_error){
     die ("<p class=\"error\"> error with the database connection </p>");
 }//issue query instructions
 $s = "SELECT * FROM user WHERE UserEmail = '$username' && 'UserPassword' = '$password'";
 $result = $conn->query($s);
 // check the result
 if ($result === FALSE){
     die("<p class=\"error\"> Unable to retrieve data! </p>");
 }
 //check if the user exists in the database
 if($result == 1){
    $_SESSION['access'] = "yes";
if($usename == $_REQUEST['UserFName'] && $passw == $_REQUEST['Password'] && $role == 'student')
    $_SESSION['user'] = $usename;
    $_SESSION['role'] = $role;
    $_SESSION['number'] = $studentNumber;
    
    // header('location:studentview.php');
}
elseif($usename == $_POST['Email'] && $passw == $_REQUEST['Password'] && $role == 'housewarden'){
    $_SESSION['access'] = "yes";
    $_SESSION['user'] = $usename;
    $_SESSION['role'] = $role;
    // header("Location:wardenview.php");
 }
 elseif($usename == $_POST['Email'] && $passw == $_REQUEST['Password'] && $role == 'hallsecretary'){
    $_SESSION['access'] = "yes";
    $_SESSION['user'] = $usename;
    $_SESSION['role'] = $role;
    // header("Location:hallsecretaryview.php");
 }
 elseif($usename == $_POST['Email'] && $passw == $_REQUEST['Password']&& $role == 'maintenancestaff'){
    $_SESSION['access'] = "yes";
    $_SESSION['user'] = $usename;
    $_SESSION['role'] = $role;
    // header("Location:maintenance.php");
 }else {
    // header("Location:signup.html");
 }
 
   $conn->close();  
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
    .success{color: green; }
    .try{color: maroon; }
</style>
</head>
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
    <input type="password" id="Password" name="Password"  placeholder=" " required>
    <label>Password</label> 
    <span class="eye" onclick="passwordFunction()">
        <i id="show" class="fa-solid fa-eye"></i>
        <i id="hide" class="fa-solid fa-eye-slash"></i>
    </span>
  <span id="passwordError" class="error"></span>
</div>
<div class="floating-label"><input type="hidden" id="UserID" name="UserID" value="<?php echo $UserID ?>"></div>
<div class="forgot">
<p><a href="#">Forgot your password?</a></p>
</div>
<input type="submit" name="Login" value="Login">
<p class="new-here"><b>New here?</b> <a href="who are you.html">Create an account</a></p>
</form>
    </div>
    <div class="picture">
         <div class="image"> 
             <img src="logsignpic.png"> 
            <div class="focus-text">
                <p>Our focus is on</p>
                <h2>creating a safe and </h2>
                <h2> efficient enviornment</h2>
                <p>for residence maintenance and management</p>
            </div>
        </div> 
    </div>
</div>
<script src="javascript.js"></script>
</body>
</html>