<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warden Confirm</title>

<body>

    <header>
        <img src="ll.png" alt="Centered Image" id="header-image">
        <h1>Warden Confirmation</h1>
        <button class="go-back" onclick="window.location.href='wardenview.php';">Go Back</button>
    </header>
   <div class="floating-label"><input type="hidden" name="UserID" id="UserID" value="<?php echo $_REQUEST['id'];?>"></div>

<?php
// Include database credentials
require_once("config.php"); // Make sure this file has your database connection constants
$id = $_REQUEST['id'];
// Establish connection to the database
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data
$sql = "SELECT * FROM maintenanceticket WHERE TicketID = $id" ; 
//$sql = "SELECT * FROM maintenanceticket WHERE TicketID = :ticketId";
$result = $conn->query($sql);
if ($result === FALSE) {
    die("<p class=\"error\">Unable to execute query!</p>");
}
// Check if there are results
if ($result->num_rows > 0) {
}
echo "<table>";
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        /* 
        echo "<td><h2>{$row['firstName']}  {$row['lastName']}</h2></td>";
         */
        echo "<tr>";echo "<td><h2>Confirm Maintenance Ticket</h2></td>";echo "</tr>";
        echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
        echo "<tr>";
        echo "<td><strong>Status:</strong></td>";
        echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
        echo "</tr><tr>";
    /*     echo "<td><strong>Reported By:</strong></td>";
        echo "<td>" . htmlspecialchars($row['StudentNumber']) . "</td>";
        echo "</tr><tr>"; */
        echo "<td><strong>Work Order Number:</strong></td>";
        echo "<td>" . htmlspecialchars($row['TicketID']) . "</td>"; 
        echo "</tr><tr>";
        echo "</tr>";
        echo "<td><strong>Category:</strong></td>";
        echo "<td>" . htmlspecialchars($row['CategoryID']) . "</td>";
        echo "</tr><tr>";
        echo "<td><strong>Location:</strong></td>";
        echo "<td>" . htmlspecialchars($row['ResidenceID']) . "</td>";
        echo "</tr><tr>";
        echo "<td><strong>Created On:</strong></td>";
        echo "<td>" . htmlspecialchars($row['CreatedAt']) . "</td>"; 
        echo "</tr><tr>";
        echo "</tr>";
       
       
       
       
    }

echo "<tr>";
echo "<td colspan='2'><strong>Additional Comment:</strong><br>";
echo "<textarea id='additionalComment' rows='4' cols='50' placeholder='Enter your comments here...'></textarea>";
echo "</td></tr>";

// Add buttons row
echo "<tr>";
echo "<td colspan='2' style='text-align: center;'>";

echo "<button class='yes-button'>Confirm</button>";
echo "<button class='no-button'>Delete Ticket</button>";
echo "<td><a href=\delete.php?id={";
echo "</td></tr>";
echo "</table>";

// Close the connection
$conn->close();
?>

<style>
        body {
      background-color: #10162A;
      background-size: cover;
      background-position: center;
      margin: 0;
      height: 100vh;
      
    }
 
    textarea {width: 900px;
  height: 100px;
  background-color: rgba(237.000, 232.000, 245.000, 1);
  opacity: 1;
  border: 1.000px solid rgba(0.000, 0.000, 0.000, 1);
  border-radius: 9px;
  transform: matrix(1.00, 0.00, 0.00, 1.00, 0, 0);}        
        h2 {
            margin: 0;
            /* Remove margin from heading */
        }

        table {
            background-color: #EDE8F5;
            width: 80%;
            /* Increase width (adjust as needed) */
            height: 100px;
            border-collapse: collapse;
            /* Keep borders from double-spacing */
            margin: 20px auto;
            /* Add some margin above and below the table */
           
        }
        th, td {
    
    padding: 10px; /* Adjust this value to move results closer */
    text-align: left;
}
th {
    background-color: #f2f2f2;
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
            width: 300px;
            /* Ensure the image scales down if necessary */
            height: auto;
            /* Maintain the image aspect ratio */
            margin-right: auto;
            position: relative;


        }

        header h1 {
            color: #EDE8F5;
            margin-right: 800px;

        }

        button.go-back {
            display: block;
    margin-right: 60px;
    background-color: #EDCD1F;
    border-radius: 9px;
    height: 40px;
    width: 150px;
    border: none;
    cursor: pointer;}
    

        button.go-back:hover {
            background-color: #C18D00;
            /* Darker yellow on hover */
        }
        .yes-button,
        .no-button {
           
    margin-right: 60px;
    background-color: #EDCD1F;
    border-radius: 9px;
    height: 40px;
    width: 150px;
    border: none;
    cursor: pointer;
    margin-bottom: 50px; /* Add space below the button */
        }

        .yes-button:hover {
            background-color: #C18D00; /* Darker green on hover */
        }

        .no-button {
            background-color: #f44336; /* Red color */
        }

        .no-button:hover {
            background-color: red; /* Darker red on hover */
        }
    </style>
</body>

</html>