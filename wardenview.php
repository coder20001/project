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
  <link rel="stylesheet" type="text/css" href="wardenview.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>

  <header>
    <img src="ll.png" alt="shortlogo">
    <h1>Work Orders</h1>
    <button onclick="document.location='finalform.php'" class="report-fault-btn"></a>Report Fault</button>
  </header>

  <aside class="sidebar" id="sidebar">
  <div class="profile-section">
    <?php if (!empty($profile_image)) : ?>
        <img src="<?php echo $profile_image; ?>" alt="Profile" class="profile-img">
    <?php else : ?>
        <div class="profile-icon">
            <i class="fa-regular fa-user"></i> 
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
          <th>Confirm</th>
        </tr>
      </thead>
      <tbody>
<?php

require_once("config.php");

// Connect to the database
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the session has the username
if (isset($_SESSION['username'])) {
    // Get the username from the session
    $username = $_SESSION['username'];

    // Fetch the UserID based on the username from the 'user' table
    $user_id_query = "SELECT UserID FROM user WHERE UserEmail = ? LIMIT 1";
    $stmt_user = $conn->prepare($user_id_query);
    $stmt_user->bind_param("s", $username);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows === 1) {
        // Get the user ID
        $user_row = $result_user->fetch_assoc();
        $user_id = $user_row['UserID'];

        // Prepare the main query with the fetched user ID
        $sql = "SELECT 
                    mt.CreatedAt AS date, 
                    mt.TicketID AS work_order, 
                    mt.status, 
                    f.CategoryName AS work_order_title, 
                    r.ResidenceLocation AS residence_location, 
                    CONCAT(u.UserFName, ' ', u.UserLName) AS reported_by
                FROM 
                    maintenanceticket mt
                JOIN 
                    residence r ON mt.ResidenceID = r.ResidenceID
                JOIN 
                    student s ON mt.StudentNumber = s.StudentNumber
                JOIN 
                    user u ON u.UserID = s.UserID
                JOIN 
                    faultcategory f ON f.CategoryID = mt.CategoryID;";

        // Prepare the statement
        $stmt = $conn->prepare($sql);
        //$stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are results and display the data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['date']) . "</td>
                        <td>" . htmlspecialchars($row['work_order']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . htmlspecialchars($row['work_order_title']) . "</td>
                        <td>" . htmlspecialchars($row['residence_location']) . "</td>
                        <td>" . htmlspecialchars($row['reported_by']) . "</td>
                        <td><button class=\"view-details-btn\" onclick=\"location.href='wardencloseconfirm.php?id=" . urlencode($row['work_order']) . "';\">Confirm Fault</button></td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No faults reported yet.</td></tr>";
        }

        // Close statement and result
        $stmt->close();
    } else {
        echo "User not found.";
    }

    $stmt_user->close();
} else {
    echo "No user data found in session. Please login.";
}

// Close the connection
$conn->close();
?>
</tbody>
    </table>
  </main>

  <script>
    // Sidebar toggle
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const menuIcon = document.getElementById('menu-toggle');
        const main = document.getElementById('main');

        sidebar.classList.toggle('open');

        if (sidebar.classList.contains('open')) {
            sidebar.style.width = "200px";
            main.style.marginLeft = "200px"; // Adjust the margin of the main content
            menuIcon.classList.add('hidden');
        } else {
            sidebar.style.width = "0";
            main.style.marginLeft = "0";
            menuIcon.classList.remove('hidden');
        }
    }

    // Close the sidebar when clicking outside
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const menuIcon = document.getElementById('menu-toggle');
        const main = document.getElementById('main');

        // Check if the click is outside the sidebar
        if (!sidebar.contains(event.target) && !menuIcon.contains(event.target)) {
            if (sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                sidebar.style.width = "0";
                main.style.marginLeft = "0";
                menuIcon.classList.remove('hidden'); // Show menu icon when sidebar is closed
            }
        }
    });

    // Add event listener for menu icon
    document.getElementById("menu-toggle").addEventListener("click", function(event) {
        event.stopPropagation(); // Prevent click from closing sidebar
        toggleSidebar();
    });
  </script>
</tbody>
</html>
