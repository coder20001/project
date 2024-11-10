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
while ($row= $rusult->fetch_assoc()) {
          
            echo "<strong><h2>Requisition Maintance</h2></strong>";
            echo "Created On: {$row['maintenanceticket.CreatedAt']} <br>";
            echo "<Reported By: {$row['UserFName']} ['UserLName']} <br>";
            echo "<Work Order Number: {$row['work_order']} <br>" ;
            echo "Category:  {$row['maintenanceticket.categoryID']} <br> ";
            echo "Location: {$row['maintenanceticket.ResidenceID']} <br>";


    // Additional Comments input area
    echo "<label for='comments'>Additional Comments:</label><br>";
    echo "<textarea id='comments' name='comments' rows='4' cols='50' ></textarea><br>";

        // Buttons
    echo "<button type='button' onclick='window.close();'>Close</button> ";
    
}     
    
    $conn->close();

    ?>