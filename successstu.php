<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <title>Registration Success</title>
    <link rel="stylesheet" href="signup.css"> 
    <style>
        /* Container to take up the full viewport */
        .container {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        .form {
            background-color: rgba(61, 65, 79, 1);
            width: 40%;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 10px 0 0 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            gap: 15px;
           
    align-items: center; /* Center horizontally */
        }

        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            filter: contrast(60%);
            opacity: 0.6;
        }

        .logo img {
            width: 80%;  /* Adjust the percentage to control how large the logo is relative to its container */
            height: auto;  /* Maintain aspect ratio */
            max-width: 300px;  /* Ensure the image does not get too large */
            margin-bottom: 100px;  /* Add space beneath the logo */
        }

        h1 {
            color: #fff;
            font-size: 20px;
            margin-bottom: 20px;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            text-align: center;
        }

        /* Styles for the success box */
        .success-box {
            background-color: white; /* White background */
            padding: 20px;
            border-radius: 9px; /* Rounded corners */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Shadow for depth */
            text-align: center; /* Center the text */
            width: 500px;
        }

        .welcome-message {
            font-size: 20px;
            margin-top: 20px;
            color: #333; /* Change this to match your design */
        }
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
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
   
        <div class="success-box">
            <h2>Success!</h2>
            <p class="good">Your account has been created.</p>
            <span class="check">
                <i class="fa-regular fa-circle-check"></i>
            </span>
        </div>
        
        <button class="sign">
            <a href="studentview.php">Continue</a>
        </button>
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

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and extract the first name from the form submission
    $firstname = htmlspecialchars(trim($_POST['firstName']));

    // Display the welcome message
    echo "<div class='welcome-message'>";
    echo "Hello " . $firstname . ", welcome to the House Hub!";
    echo "</div>";
}
?>

</body>
</html>

