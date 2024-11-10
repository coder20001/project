<?php
// feedbackform.php

// Initialize variables
$submitted = false;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data here (you can save it to a database or send an email)
    
    // Example: Just setting a submitted flag to true
    $submitted = true;

    // Here you can access form data using $_POST
    // For example: $feedback = $_POST['feedback'];
    
    // Redirect or process as needed
    // header("Location: studentview.php"); // Uncomment this to redirect after submission
    // exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Hub Form</title>
    <style>
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: black;
            padding: 0px;
            color: #EDE8F5;
            font-family: 'Times New Roman', Times, serif;
        }

        #header-image {
            width: 300px; /* Ensure the image scales down if necessary */
            height: auto; /* Maintain the image aspect ratio */
            margin-right: auto;
            position: relative;
        }

        header h1 {
            color: #EDE8F5;
            margin-right: 800px;
        }

        body {
            background-color: #10162A;
            background-size: cover;
            background-position: center;
            margin: 0;
            height: 100vh;
            font-family: 'Lora', serif;
        }

        form {
            margin: 0 auto;
            width: 800px;
            color: black;
            background-color: #EDE8F5;
            padding: 0;
            font-family: 'Lora', serif;
            height: 840px;
            padding-left: 50px; /* Add space on the sides */
            padding-right: 50px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .feedback-box {
            background-color: #EDE8F5; /* White Center */
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .icon-container {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
        }

        .check-icon {
            width: 60px;
            height: 60px;
        }

        p {
            font-size: 18px;
            color: #333;
            margin: 0 0 20px;
        }

        .done-button {
            display: block;
            margin: 0 auto;
            background-color: #EDCD1F;
            border-radius: 9px;
            height: 40px;
            width: 150px;
            cursor: pointer;
        }

        .done-button:hover {
            background-color: #C18D00; /* Darker Yellow on Hover */
        }
    </style>
</head>

<body>
    <header>
        <img src="ll.png" alt="Centered Image" id="header-image">
        <h1>Form Submitted</h1>
    </header>

    <form action="studentview.php" method="POST" enctype="multipart/form-data">
    <div class="container">
        <div class="feedback-box">
            <div class="icon-container">
                <svg class="check-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="11" stroke="black" stroke-width="1" fill="none"/>
                    <path d="M8 12l2 2 4-4" stroke="black" stroke-width="2" fill="none"/>
                </svg>
            </div>
            <p>Your form has been submitted</p><br>
            <button class="done-button" onclick="document.location='studentview.php'">Done</button>
      
        </div>
    </div>
    
</form>
</body>
</html>