<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warden Confirm</title>
    <style>
        body {
            background-color: #10162A;
            background-size: cover;
            background-position: center;
            margin: 0;
            height: 100vh;
        }

        textarea {
            width: 900px;
            height: 100px;
            background-color: rgba(237, 232, 245, 1);
            border: 1px solid rgba(0, 0, 0, 1);
            border-radius: 9px;
        }

        h2 {
            margin: 0;
        }

        table {
            background-color: #EDE8F5;
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th, td {
            padding: 10px;
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
            height: auto;
            margin-right: auto;
            position: relative;
        }

        header h1 {
            color: #EDE8F5;
            margin-right: 800px;
        }

        button.go-back {
            margin-right: 60px;
            background-color: #EDCD1F;
            border-radius: 9px;
            height: 40px;
            width: 150px;
            border: none;
            cursor: pointer;
        }

        button.go-back:hover {
            background-color: #C18D00;
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
            margin-bottom: 20px;
        }

        .yes-button:hover {
            background-color: #C18D00;
        }

        .no-button {
            background-color: #f44336;
        }

        .no-button:hover {
            background-color: red;
        }

        .popup {
    display: none;
    position: absolute;
    background-color: #4CAF50; /* Green background */
    color: white; /* White text for better contrast */
    border: 1px solid #388E3C; /* Darker green border */
    border-radius: 5px;
    padding: 10px;
    margin-top: 10px;
    z-index: 1000;
}
    </style>
</head>

<body>

    <header>
        <img src="ll.png" alt="Centered Image" id="header-image">
        <h1>Hall Secretary Requisition</h1>
        <button class="go-back" onclick="window.location.href='wardenview.php';">Go Back</button>
    </header>

<?php
// Include database credentials
require_once("config.php");
$id = $_REQUEST['id'];
// Establish connection to the database
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data
$sql = "SELECT * FROM maintenanceticket WHERE TicketID = $id";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    echo "<table>";
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td><h2>Maintenance Requisition Ticket</h2></td></tr>";
        echo "<tr><td>" . htmlspecialchars($row['Description']) . "</td></tr>";
        echo "<tr><td><strong>Status:</strong></td><td>" . htmlspecialchars($row['Status']) . "</td></tr>";
        echo "<tr><td><strong>Work Order Number:</strong></td><td>" . htmlspecialchars($row['TicketID']) . "</td></tr>";
        echo "<tr><td><strong>Category:</strong></td><td>" . htmlspecialchars($row['CategoryID']) . "</td></tr>";
        echo "<tr><td><strong>Location:</strong></td><td>" . htmlspecialchars($row['ResidenceID']) . "</td></tr>";
        echo "<tr><td><strong>Created On:</strong></td><td>" . htmlspecialchars($row['CreatedAt']) . "</td></tr>";
    }
    echo "<tr><td colspan='2'><strong>Additional Comment:</strong><br>";
    echo "<textarea id='additionalComment' rows='4' cols='50' placeholder='Enter your comments here...'></textarea></td></tr>";
    
    // Add buttons row
    echo "<tr><td colspan='2' style='text-align: center;'>";
    echo "<div class='popup' id='popup'>Ticket has been sent to Hall Secretary.</div>";
    echo "<button class='yes-button' onclick='confirmTicket(event)'>Confirm</button>";
    echo "<div class='popup' id='popup'>Ticket has been deleted</div>";
    echo "<button class='no-button' onclick='deleteTicket(event)'>Delete Ticket</button>";
    //echo "<button class='no-button'>Close</button>";
    echo "</td></tr>";
    echo "</table>";
} else {
    echo "No results found.";
}

// Close the connection
$conn->close();
?>

<script>
function confirmTicket(event) {
    const popup = document.getElementById('popup');
    popup.style.display = 'block';
    const rect = event.target.getBoundingClientRect();
    popup.style.top = (rect.top - popup.offsetHeight - 10) + 'px';
    popup.style.left = (rect.left + (rect.width / 2) - (popup.offsetWidth / 2)) + 'px';
    
    // Hide the popup after a few seconds (optional)
    setTimeout(() => {
        popup.style.display = 'none';
    }, 3000);
}
function deleteTicket(event) {
    const popup = document.getElementById('popup');
    popup.style.display = 'block';
    const rect = event.target.getBoundingClientRect();
    popup.style.top = (rect.top - popup.offsetHeight - 10) + 'px';
    popup.style.left = (rect.left + (rect.width / 2) - (popup.offsetWidth / 2)) + 'px';
    
    // Hide the popup after a few seconds (optional)
    setTimeout(() => {
        popup.style.display = 'none';
    }, 3000);
}
</script>

</body>
</html>
