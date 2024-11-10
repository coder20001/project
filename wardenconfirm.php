<?php
$id= $_REQUEST['userID'];

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
 
$result = $conn->query ($sql);

if ($result === false) {
            die("<p class=\"error\">  Could not check Ticket </p>");
}
 // Styling is here
echo "<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 20px;
}
h2 {
    color: #0056b3;
}
label {
    font-weight: bold;
}
textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
}
button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    margin-top: 10px;
}
button:hover {
    background-color: #0056b3;
}
</style>";   
//outpus Student details 
while ($row= $result->fetch_assoc()) {
          
            echo "<strong><h2>Confirm Details</h2></strong>";
            echo "Created On: {$row['maintenanceticket.CreatedAt']} <br>";
            echo "<Reported By: {$row['UserFName']} ['UserLName']} <br>";
            echo "<Work Order Number: {$row['work_order']} <br>" ;
            echo "Category:  {$row['maintenanceticket.categoryID']} <br> ";
            echo "Location: {$row['maintenanceticket.ResidenceID']} <br>";
    // Additional Comments input area
    echo "<label for='comments'>Additional Comments:</label><br>";
    echo "<textarea id='comments' name='comments' rows='4' cols='50' ></textarea><br>";
        // Buttons
    echo "<button type='button' onclick='window.close();'><a href=\"wardencoloseconfirm.php?id={$row['UserID']}\">Close</button> ";
    echo "<button type='submit'><a href=\"wardencoloseconfirm.php?id={$row['UserID']}\">Confirm</button>";
}     
    
    $conn->close();

    ?>

