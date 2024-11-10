
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <title>maintenance staff</title>
    <link rel="stylesheet" href="signup.css">
    <style>
    .sign{
color: black;
 }
 .sign:hover{
    background-color: #e6b800;
 }
 </style>
</head>
<body>
    <div class="container">
        <div class="form">
            <div class="log">
                <img src="logo.png" alt="Logo">
            </div>
         <h1>Register</h1>     
         <form action="maintencheck.php" method="post">
            <div class="floating-label">
         <select name="role" required>
    <option value="">Select your role</option>
    <option value="Student">Student</option>
    <option value="House Warden">House Warden</option>
    <option value="Hall Secretary">Hall Secretary</option>
    <option value="Maintenance Staff">Maintenance Staff</option>
</select>
</div>
            <div class="moveup">
                    <div class="floating-label">
                    <input type="text" id="firstName" name="firstName" placeholder=" " required>
                    <label>First Name</label>
                </div>
                <div class="floating-label">
                    <input type="text"  id="lastName" name="lastName" placeholder=" " required>
                    <label>Last Name</label>
                </div>
                <div class="floating-label">
                    <input type="email" id="email" name="useremail" placeholder=" " required>
                    <label>Email</label>
                    <span id="emailError" class="error"></span>
                </div>
                <div class="floating-label">
                    <input type="text" placeholder=" " name="mainnum" pattern="M\d{2}[A-Za-z]\d{4}" required>
                    <label>Maintenance Number</label>
                </div>
                <div class="floating-label">
                    <input type="password" id="Password" name="userpassword" placeholder=" " required>
                    <label>Password</label>
                    <span class="eye" onclick="passwordFunction()">
                        <i id="show" class="fa-solid fa-eye"></i>
                        <i id="hide" class="fa-solid fa-eye-slash"></i>
                    </span>
                    <span id="passwordError" class="error"></span>
                </div>
                <div class="floating-label"> <input type="hidden" name="UserID" id="UserID" value = " maintenancestaff"> </div>
            </div>
       <div><input type="submit" id="submit" name="submit" class="sign" value="Sign up"></div> 
            <p class="new-here"><b>Already have an account?</b><a href="login.php">Login</a></p>
        </form>
    </div>
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
    <script src="javascript.js"></script>
</body>
</html>