
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <link rel="stylesheet" href="student.css">
    <title>Sign Up</title>
</head>
<body>
<div class="container">
    <div class="form">    
        <div class="log">
            <img src="logo.png" alt="Logo">
        </div>  

         <h1>Register</h1>     
     <form action="studentcheck.php" method="post">
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
                <input type="text" id="firstName" name="firstName" placeholder=" " required minlength="3" >
                <label>First Name</label>
                <span id="firstNameError" class="error"></span>
            </div>
            <div class="floating-label">
                <input type="text" id="lastName" name="lastName" placeholder=" " required>
                <label>Last Name</label>
                <span id="lastNameError" class="error"></span>
            </div>
            <div class="floating-label">
                <input type="email" id="email" name="useremail" placeholder=" " required>
                <label>Email</label>
                <span id="emailError" class="error"></span>
                </div>
            <div class="floating-label">
                <input type="text" placeholder=" " pattern="G\d{2}[A-Za-z]\d{4}" name="number" required>
                <label>Student Number</label>
            </div>    
<div class="floating-label">        
    <select id="house" name="house" placeholder="Select your residence"> <br>
 <option value="">Select a house:</option> 
      <option value="Amina Cachalia">Amina Cachalia</option>
      <option value="Adamson House">Adamson House</option>
      <option value="Adelaide Tambo">Adelaide Tambo</option>
      <option value="Allan Gray">Allan Gray</option>
      <option value="Beit House">Beit House</option>
      <option value="Botha">Botha</option>
      <option value="Calata">Calata</option>
      <option value="Calata House">Calata House</option>
      <option value="Celeste">Celeste</option>
      <option value="Chris Hani">Chris Hani</option>
      <option value="Cory">Cory</option>
      <option value="Cullen Bowles">Cullen Bowles</option>
      <option value="De Beers">De Beers</option>
      <option value="Dingemans">Dingemans</option>
      <option value="Ellen Kuzwayo">Ellen Kuzwayo</option>
      <option value="Goldfields">Goldfields</option>
      <option value="Graham">Graham</option>
      <option value="Guy Butler">Guy Butler</option>
      <option value="Helen Joseph">Helen Joseph</option>
      <option value="Hilltop 3">Hilltop 3</option>
      <option value="Hilltop 7">Hilltop 7</option>
      <option value="Hilltop 7 House">Hilltop 7 House</option>
      <option value="Hilltop 8">Hilltop 8</option>
      <option value="Hilltop 8 House">Hilltop 8 House</option>
      <option value="Jameson House">Jameson House</option>
      <option value="John Kotze">John Kotze</option>
      <option value="Joe Slovo">Joe Slovo</option>
      <option value="Lilian Britten">Lilian Britten</option>
      <option value="Livingstone">Livingstone</option>
      <option value="Milner">Milner</option>
      <option value="Margaret Smith">Margaret Smith</option>
      <option value="Matthews">Matthews</option>
      <option value="New House">New House</option>
      <option value="Olive Schreiner">Olive Schreiner</option>
      <option value="Oriel Annexe">Oriel Annexe</option>
      <option value="Oriel House">Oriel House</option>
      <option value="Phelps">Phelps</option>
      <option value="Piet Retief">Piet Retief</option>
      <option value="Prince Alfred">Prince Alfred</option>
      <option value="Rosa Parks">Rosa Parks</option>
      <option value="Robert Sobukwe House">Robert Sobukwe House</option>
      <option value="Ruth First">Ruth First</option>
      <option value="Salisbury">Salisbury</option>
      <option value="Sisulu House">Sisulu House</option>
      <option value="Stanley Kidd">Stanley Kidd</option>
      <option value="Thomas Pringle">Thomas Pringle</option>
      <option value="Truro">Truro</option>
      <option value="Victoria Mxenge">Victoria Mxenge</option>
      <option value="Walker">Walker</option>
      <option value="Winchester">Winchester</option> 
    </select> 
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
            <div class="floating-label"> <input type="hidden" name="UserID" id="UserID" value = "<?php echo $userid;?>"> </div>
            <div class="floating-label"> <input type="hidden" name="Role" id="Role" value = "student"> </div>
            <div> <input type="submit" id="submit" name="submit" class="sign" value="Sign up"> </div>
         <p class="new-here"><b>Already have an account?</b><a href="login.php">Login</a></p>
     </form>
       </div>
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
 <?php
 /* require_once("config.php");
 $conn = new mysqli (SERVERNAME, USERNAME, PASSWORD, DATABASE);
if ($conn->connect_error){
    die("<p class=\"error\"> Connection failed! </p>");
}

 $sql = "SELECT UserFName, Role FROM user WHERE UserID = $userid";
 $result = $conn->query($sql);
 if ($result === false){
     die("<p class=\"error\"> Couldn't execute your sql statement. </p>");
 }
 while($row = $result->fetch_assoc()){
 $username = $row['UserFName'];
 } */
 ?>
 </body>
 </html>
 