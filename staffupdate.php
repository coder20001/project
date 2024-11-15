<?php
$id= $_REQUEST['id'];

require_once("config.php");
//connecting to the DB

$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from the database
$sql= "SELECT
	user.userFname, 
	user.userLname ,
    maintenanceticket.TicketID AS work_order,
    maintenanceticket.categoryID,
    maintenanceticket.ResidenceID,
    maintenanceticket.CreatedAt,
    maintenanceticket.photoID,
    maintenanceticket.status
FROM
	user
JOIN 
	student ON user.userID = student.userID
JOIN 
	maintenanceticket ON student.StudentNumber= maintenanceticket.StudentNumber
WHERE
	maintenanceticket.StudentNumber= ticketID; ";
 
$result= $conn->query ($sql);

if ($result===false) {
            die("<p class=\"error\">  Could not check Ticket </p>");
}
    
//outpus Student details 
echo "<form method='POST' action='staffupdate.php'>"; // Start form
while ($row = $result->fetch_assoc()) {
    echo "<strong><h2>Confirm Details</h2></strong>";
    echo "Created On: {$row['maintenanceticket.CreatedAt']} <br>";
    echo "Reported By: {$row['UserFName']} {$row['UserLName']} <br>";
    echo "Work Order Number: {$row['work_order']} <br>";
    echo "Category: {$row['maintenanceticket.categoryID']} <br>";
    echo "Location: {$row['maintenanceticket.ResidenceID']} <br>";

    // Additional Comments input area
    echo "<label for='comments'>Additional Comments:</label><br>";
    echo "<textarea id='comments' name='comments' rows='4' cols='50' placeholder='Enter your comments here...'></textarea><br>";
}

// Buttons

echo "<button type='submit' name='save_changes'>Save Changes</button>";
echo "</form>"; // End form

$conn->close();
?>
   <!DOCTYPE html>
<html lang="en">


<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>House Hub Form</title>
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
@font-face {
    font-family: pop;
    src: url(./Fonts/Poppins-Medium.ttf);
}

.main{
    width: 100%;
    height: 86.5vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: pop;
    flex-direction: column;
}

.box {
    display: flex;
    height: 60%;
    width: 60%;
    justify-content: center;
    align-items: center;
    background-color: #EDE8F5;
    position: relative;
    
}
.head{
    text-align: center;
}
.head_1{
    font-size: 30px;
    font-weight: 600;
    color: yellow;
}
.head_1 span{
    color: #ffea32;
}
.head_2{
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-top: 3px;
    text-align: center;
    justify-content: center;
}
ul{
    display: flex;
    margin-top: 80px;
}
ul li{
    list-style: none;
    display: flex;
    flex-direction: column;
    align-items: center;
}
ul li .icon{
    font-size: 35px;
    color: #10162a;
    margin: 0 60px;
}
ul li .text{
    font-size: 14px;
    font-weight: 600;
    color: #10162a;
}

/* Progress Div Css  */

ul li .progress{
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: rgba(68, 68, 68, 0.781);
    margin: 14px 0;
    display: grid;
    place-items: center;
    color: black;
    position: relative;
    cursor: pointer;
}
.progress::after{
    content: " ";
    position: absolute;
    width: 125px;
    height: 5px;
    background-color: rgba(68, 68, 68, 0.781);
    right: 30px;
}
.one::after{
    width: 0;
    height: 0;
}
ul li .progress .uil{
    display: none;
}
ul li .progress p{
    font-size: 13px;
}

/* Active Css  */

ul li .active{
    background-color:yellow;
    display: grid;
    place-items: center;
}
li .active::after{
    background-color: yellow;
}
ul li .active p{
    display: none;
}
ul li .active .uil{
    font-size: 20px;
    display: flex;
}

/* Responsive Css  */

@media (max-width: 980px) {
    ul{
        flex-direction: column;
    }
    ul li{
        flex-direction: row;
    }
    ul li .progress{
        margin: 0 30px;
    }
    .progress::after{
        width: 5px;
        height: 55px;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: -1;
    }
    .one::after{
        height: 0;
    }
    ul li .icon{
        margin: 15px 0;
    }
}

@media (max-width:600px) {
    .head .head_1{
        font-size: 24px;
    }
    .head .head_2{
        font-size: 16px;
    }
}

 body {
      background-color: #10162A;
      background-size: cover;
      background-position: center;
      margin: 0;
      height: 100vh;
      
    }

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
header h1{
    color:#EDE8F5;
    margin-right: 800px;
  
}


    </style>

 <header>
        <img src="ll.png" alt="Centered Image" id="header-image"> 
        <h1>Fault Requisition</h1>
        <button  class="go" onclick="document.location='studentview.php'">Go Back</button>
    </header>
    <div class="main">
        <div class="box">
        <div class="head">
   
  
            <p class="head_2">Update Progress</p>
        </div>

        <ul>
            <li>
                <i class="icon uil uil-capture"></i>
                <div class="progress one">
                    <p>1</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Opened</p>
            </li>
            <li>
                <i class="icon uil uil-clipboard-notes"></i>
                <div class="progress two">
                    <p>2</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Confirmed</p>
            </li>
            <li>
                <i class="icon uil uil-credit-card"></i>
                <div class="progress three">
                    <p>3</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Requistion</p>
            </li>
            <li>
                <i class="icon uil uil-exchange"></i>
                <div class="progress four">
                    <p>4</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Resolved</p>
            </li>
            <li>
                <i class="icon uil uil-map-marker"></i>
                <div class="progress five">
                    <p>5</p>
                    <i class="uil uil-check"></i>
                </div>
                <p class="text">Closed</p>
            </li>
        </ul>
    </div>
    </div>


    <script>const one = document.querySelector(".one");
        const two = document.querySelector(".two");
        const three = document.querySelector(".three");
        const four = document.querySelector(".four");
        const five = document.querySelector(".five");
        
        one.onclick = function() {
            one.classList.add("active");
            two.classList.remove("active");
            three.classList.remove("active");
            four.classList.remove("active");
            five.classList.remove("active");
        }
        
        two.onclick = function() {
            one.classList.add("active");
            two.classList.add("active");
            three.classList.remove("active");
            four.classList.remove("active");
            five.classList.remove("active");
        }
        three.onclick = function() {
            one.classList.add("active");
            two.classList.add("active");
            three.classList.add("active");
            four.classList.remove("active");
            five.classList.remove("active");
        }
        four.onclick = function() {
            one.classList.add("active");
            two.classList.add("active");
            three.classList.add("active");
            four.classList.add("active");
            five.classList.remove("active");
        }
        five.onclick = function() {
            one.classList.add("active");
            two.classList.add("active");
            three.classList.add("active");
            four.classList.add("active");
            five.classList.add("active");
        }
        </script>
    </body>
</html>
    