<?php
// Check if ID is set in the request
var_dump($_REQUEST); // Debugging line
if (!isset($_REQUEST['id'])) {
    die("Error: ID not provided.");
}

$id = $_REQUEST['id'];


require_once("config.php"); // Include the database configuration

// Connecting to the DB
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from the database using a parameterized query for safety
$sql = "SELECT
    user.UserFNAME,
    user.USERLNAME,
    maintenanceticket.wardenNumber,
    maintenanceticket.CategoryID,
    maintenanceticket.ResidenceID,
    maintenanceticket.CreatedAt,
    maintenanceticket.Status,
    maintenanceticket.MaintenanceNumber
FROM 
    maintenanceticket 
JOIN 
    housewarden ON maintenanceticket.wardenNumber = housewarden.wardenNumber
JOIN 
    user ON user.UserID = housewarden.UserID
WHERE 
    maintenanceticket.TicketID = ?"; // Use a parameterized query for safety

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // Assuming TicketID is an integer
$stmt->execute();
$result = $stmt->get_result();

// Check if the result has rows
if ($result->num_rows === 0) {
    die("<p class=\"error\">No ticket found with the provided ID.</p>");
}

// Fetch data from the result
while ($row = $result->fetch_assoc()) {
    echo "<strong><h2>Details</h2></strong>";
    echo "Last Update: <h3>" . htmlspecialchars($row['Status']) . "</h3>"; // Sanitize output
    echo "Reported By: " . htmlspecialchars($row['UserFNAME']) . " " . htmlspecialchars($row['USERLNAME']) . "<br>";
    echo "Work Order Number: " . htmlspecialchars($row['MaintenanceNumber']) . "<br>";
    echo "Category: " . htmlspecialchars($row['CategoryID']) . "<br>";
    echo "Location: " . htmlspecialchars($row['ResidenceID']) . "<br>";
    echo "Created On: " . htmlspecialchars($row['CreatedAt']) . "<br>";
}

// Clean up
$stmt->close();
$conn->close();
?>
