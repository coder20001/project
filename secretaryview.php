<?php
session_start();

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['userid'])) {
    echo "Please log in to access this page.";
    exit();
}

// Now you can safely access the `userid` and use it to fetch data
$userid = $_SESSION['userid'];
// Use $userid to fetch user-specific data if needed.

require_once("config.php");

// Create a database connection
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch user data
$sql = "SELECT UserFName, UserLName FROM user WHERE UserID = ?"; 

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid); // Bind the user ID from the session
$stmt->execute();
$result = $stmt->get_result();

// Check if user data exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['UserFName']; // Store the user's first name
    $lastName = $row['UserLName']; // Store the user's last name
} else {
    echo "No user data found";
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Orders</title>
    <link rel="stylesheet" type="text/css" href="studentview.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <img src="ll.png" alt="shortlogo">
        <h1>Work Orders</h1>
        <button onclick="document.location='finalform.php'" class="report-fault-btn">Report Fault</button>
    </header>

    <aside class="sidebar" id="sidebar">
        <div class="profile-section">
            <?php if (!empty($profile_image)) : ?>
                <img src="<?php echo $profile_image; ?>" alt="Profile" class="profile-img">
            <?php else : ?>
                <div class="profile-icon">
                    <i class="fa-regular fa-user"></i> <!-- Font Awesome user icon -->
                </div>
            <?php endif; ?>
        </div>

        <h2 class="user"><?php echo htmlspecialchars($name . ' ' . $lastName); ?></h2>
        <p class="role"><?php echo "{$_SESSION['role']}"; ?></p>
        <button class="update-btn">Update Profile</button>
        </div>

        <nav class="sidebar-menu">
            <ul>
                <li class="menu-item"><a href="HomePage.html">Home</a></li>
                <li class="menu-item"><a href="servicepage.html">Services</a></li>
                <li class="menu-item"><a href="newabout.html">About</a></li>
                <li class="menu-item"><a href="dashboard.html">Dashboard</a></li>
            </ul>
        </nav>
    </aside>

    <div class="search-bar">
        <div id="menu-toggle" class="menu-icon">&#9776;</div>
        <input type="text" placeholder="Search">

        <div class="notification-bell">
    <i class="fa fa-bell" id="bell-icon"></i>
    <div class="notification-dropdown" id="notificationDropdown">
        <div class="dropdown-header">
            <span>Notifications</span>
            <span class="mark-read" onclick="markAllRead()">Mark all read</span>
        </div>
        <div class="notifications-list">
            <div class="notification-item">
                <p>Broken window in common room</p>
                <span>7 hours ago</span>
            </div>
            <div class="notification-item">
                <p>Leaky faucet in kitchen</p>
                <span>1 day ago</span>
            </div>
            <!-- Add more notifications as needed -->
        </div>
    </div>
</div>

<style>
    .notification-bell {
    position: relative;
    display: inline-block;
}

#bell-icon {
    font-size: 24px;
    cursor: pointer;
}

.notification-dropdown {
    display: none;
    position: absolute;
    right: 0;
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
    width: 300px;
    z-index: 1000;
}

.notification-dropdown .dropdown-header {
    padding: 10px;
    background-color: #f0f0f0;
    display: flex;
    justify-content: space-between;
}

.notification-dropdown .dropdown-header .mark-read {
    cursor: pointer;
    color: blue;
}

.notifications-list {
    max-height: 300px;
    overflow-y: auto;
}

.notification-item {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.notification-item p {
    margin: 0;
    font-size: 14px;
    color: black;
}

.notification-item span {
    font-size: 12px;
    color: black;
}

</style>

<script>

const bellIcon = document.getElementById('bell-icon');
const notificationDropdown = document.getElementById('notificationDropdown');

bellIcon.addEventListener('click', () => {
    notificationDropdown.style.display = 
        notificationDropdown.style.display === 'block' ? 'none' : 'block';
});

window.onclick = function(event) {
    if (!event.target.matches('#bell-icon')) {
        if (notificationDropdown.style.display === 'block') {
            notificationDropdown.style.display = 'none';
        }
    }
}

function markAllRead() {
    alert('All notifications marked as read.');
}

</script>

    
    </div>
    <main id="main">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Work Order</th>
                    <th>Status</th>
                    <th>Work Order Title</th>
                    <th>Residence Location</th>
                    <th>Reported By</th>
                    <th>Requisition</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //$id = $_REQUEST['id'];
                require_once("config.php");
                
                $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                function getReportedFaults() {
                    global $conn;

                    $sql=  "SELECT
                    CreatedAt, TicketID, Status,Description, residence.ResidenceLocation, UserFName
                FROM
                    maintenanceticket
                JOIN
                    residence ON maintenanceticket.ResidenceID= residence.ResidenceID
                JOIN 
                    user ON residence.ResidenceLocation=user.ResidenceLocation;";
                
                    $stmt = $conn->prepare($sql);
                      // Bind the student number from session
                    
                    
                    $result = $conn->query($sql);
                    if ($result === FALSE) {
                        die("<p class=\"error\">Unable to execute query!</p>");
                    }
                    return $result;
                }
                
                $result = getReportedFaults(); 
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                     
                          echo "<tr>
                        <td>" . htmlspecialchars($row['CreatedAt']) . "</td>
                        <td>" . htmlspecialchars($row['TicketID']) . "</td>
                            <td>" . htmlspecialchars($row['Status']) . "</td>
                            
                            <td>" . htmlspecialchars($row['Description']) . "</td> 
                            <td>" . htmlspecialchars($row['ResidenceLocation']) . "</td>
                          
                              <td>" . htmlspecialchars($row['UserFName']) . "</td>
                        
                    
                        
                        <td><button class=\"view-details-btn\" onclick=\"location.href='secsend.php?id=" . urlencode($row['TicketID']) . "';\">
                                Requisition Fault</button></td>
                           
                      </tr>";
                
                    }
                } else {
                    echo "<tr><td colspan='7'>No faults reported yet.</td></tr>";
                }
                
                $conn->close();                
                ?>
            </tbody>
        </table>
    </main>
    <script src="secretary.js"></script>
</body>
</html>
