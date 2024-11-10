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
	maintenanceticket.secretaryNumber
FROM 
	maintenanceticket 
JOIN 
	hallsecretary  ON maintenanceticket.secretaryNumber=hallsecretary.secretaryNumber
JOIN 
	user ON user.UserID = hallsecretary.UserID";
 
$result= $conn->query ($sql);
if ($result===false) {
            die("<p class=\"error\">  Could not check Ticket </p>");
}
    while ($row= $rusult->fetch_assoc()) {
            echo "<strong><h2> Details </h2></strong>";
            echo "Last Update:";
            echo "<h3> In Progress </h3>";
            echo "<Reported By: {$row ['First_name']} {$row['last_name']} <br>";
            echo "<Work Order Number: {$row['work_order']} <br>" ;
            echo "Category:  {$row['maintenanceticket.categoryID']} <br>  ";
            echo "Location: {$row['maintenanceticket.ResidenceID']} <br>";
            echo "Create On: {$row['maintenanceticket.CreatedAt']} <br>";

    }
    $conn->close();

    ?>