<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

define("SERVERNAME", "is3-dev.ict.ru.ac.za");
define("USERNAME", "CodersCollective");
define("PASSWORD", "J3suV5V6");
define("DATABASE", "CodersCollective");

function connectDatabase() {
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

$conn = connectDatabase();

// Fetch Maintenance Fault Stats per Semester per Residence
$semesterStats = $conn->query("
    SELECT ResidenceID, COUNT(TicketID) as TotalTickets, 
           YEAR(CreatedAt) as Year, 
           CONCAT('Semester ', CASE WHEN MONTH(CreatedAt) <= 6 THEN '1' ELSE '2' END) as Semester 
    FROM maintenanceticket 
    GROUP BY ResidenceID, Year, Semester
");
if (!$semesterStats) {
    die("Query failed: " . $conn->error);
}
$semesterData = $semesterStats->fetch_all(MYSQLI_ASSOC);

// Fetch Maintenance Fault Progress
$progressStats = $conn->query("SELECT Status, COUNT(TicketID) as Count FROM maintenanceticket GROUP BY Status");
if (!$progressStats) {
    die("Query failed: " . $conn->error);
}
$progressData = $progressStats->fetch_all(MYSQLI_ASSOC);

// Fetch Average Turnaround Time
$turnaroundTimes = $conn->query("SELECT AVG(DATEDIFF(NOW(), CreatedAt)) as AvgTurnaroundTime FROM maintenanceticket WHERE Status = 'Resolved'");
if (!$turnaroundTimes) {
    die("Query failed: " . $conn->error);
}
$turnaroundData = $turnaroundTimes->fetch_assoc();

// Fetch Maintenance Fault Categories Stats
$categoryStats = $conn->query("SELECT CategoryID, COUNT(TicketID) as TotalTickets FROM maintenanceticket GROUP BY CategoryID");
if (!$categoryStats) {
    die("Query failed: " . $conn->error);
}
$categoryData = $categoryStats->fetch_all(MYSQLI_ASSOC);

// Fetch History of Categories of Complaints
$historyStats = $conn->query("
    SELECT YEAR(CreatedAt) as Year, MONTH(CreatedAt) as Month, CategoryID, COUNT(TicketID) as TotalTickets 
    FROM maintenanceticket 
    GROUP BY Year, Month, CategoryID
");
if (!$historyStats) {
    die("Query failed: " . $conn->error);
}
$historyData = $historyStats->fetch_all(MYSQLI_ASSOC);

$conn->close(); // Close the database connection

// Prepare data for JavaScript
$semesterLabels = json_encode(array_map(function($item) {
    return "{$item['ResidenceID']} {$item['Semester']} {$item['Year']}";
}, $semesterData));
$semesterCounts = json_encode(array_map(function($item) {
    return $item['TotalTickets'];
}, $semesterData));

$progressLabels = json_encode(array_map(function($item) {
    return $item['Status'];
}, $progressData));
$progressCounts = json_encode(array_map(function($item) {
    return $item['Count'];
}, $progressData));

$avgTurnaround = json_encode($turnaroundData['AvgTurnaroundTime']);

$categoryLabels = json_encode(array_map(function($item) {
    return $item['CategoryID'];
}, $categoryData));
$categoryCounts = json_encode(array_map(function($item) {
    return $item['TotalTickets'];
}, $categoryData));

$processedHistoryData = [];
foreach ($historyData as $item) {
    $key = "{$item['Year']}-" . str_pad($item['Month'], 2, '0', STR_PAD_LEFT) . "-{$item['CategoryID']}";
    if (!isset($processedHistoryData[$key])) {
        $processedHistoryData[$key] = 0;
    }
    $processedHistoryData[$key] += $item['TotalTickets'];
}
$historyLabels = json_encode(array_keys($processedHistoryData));
$historyCounts = json_encode(array_values($processedHistoryData));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Reports</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #EDE8F5; /* Set background color */
            color: white; /* Change text color for better visibility */
            padding-top: 100px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: black;
        }
        td {
            text-align: center;
            vertical-align: top;
            padding: 20px;
            border: 1px solid #ccc;
        }
        canvas {
            max-width: 200px; /* Set smaller width for charts */
            max-height: 150px; /* Set smaller height for charts */
        }
        /* Navbar */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
    background-color: #10162A;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 10;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
}

/* Logo */
.navbar .logo img {
    max-width: 300px; /* Adjust to fit your logo */
    height: auto;
    position: relative;
}

/* Middle Menu (Home, Services, About) */
.navbar .middle-menu {
    flex-grow: 1;
    text-align: center;
}
.navbar .middle-menu ul {
    list-style: none;
    display: flex;
    justify-content: center;
    gap: 60px; /* Adjust spacing between middle menu items */
    margin-right: 200px;
    padding: 0;
}
.navbar .middle-menu ul li {
    display: inline;
}
.navbar a {
    color: #ededed;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    text-decoration: none;
    font-weight: normal;
    font-size: 16px;
}

.navbar a:hover {
    color: #EDCD1F;
    transition: 0.2s;
}

/* Right Menu (Login) */
.navbar .right-menu {
    text-align: right;
}

.navbar .right-menu ul {
    list-style: none;
    margin-right: 100px;
    padding: 0;
}
h2{
    color: black;
    text-align: center;
}
/* Footer */
footer {
    background-color: #131313; /* Darker background color */
    color: white;
    padding: 20px 0;
    text-align: center;
}

.follow-us {
    font-size: 22px;
}

footer .social-icons {
    margin-top: 15px;
}

footer .social-icons a {
    color: white;
    margin: 0 10px;
    font-size: 20px;
    text-decoration: none;
}

footer .social-icons a:hover {
    color: #EDCD1F; /* Color change on hover */
}

footer .footer-text {
    margin-top: 10px;
    font-size: 12px;
}

footer .footer-text p {
    margin: 5px 0;
}
.social-icons a {
    color: white; /* Default color */
    margin: 0 5px; /* Space between icons */
    text-decoration: none; /* Remove underline */
    font-size: 18px; /* Adjust icon size */
}

.social-icons a:hover {
    color: #ffcc00; /* Hover color */
}

/* Remove arrows from any elements if they exist */
h3::before, h3::after, h2::before, h2::after {
    content: none !important; /* Ensure no arrows are added */
}

/* Remove arrows from any elements if they exist */
h3::before, h3::after, h2::before, h2::after {
    content: none !important; /* Ensure no arrows are added */
}

/* Remove arrows from any elements if they exist */
h3::before, h3::after, h2::before, h2::after {
    content: none !important; /* Ensure no arrows are added */
}

/* Remove arrows from any elements if they exist */
h3::before, h3::after, h2::before, h2::after {
    content: none !important; /* Ensure no arrows are added */
}

/* Ensure dropdown arrows are not displayed on form select */
select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background: none; /* Remove any arrow background */
}
/* For the entire container that holds the headings */
.follow-us  {
    list-style-type: none; /* Disable any automatic list style, which can add arrows */
}

/* Ensure form select dropdown isn't adding an arrow */
.w3-select {
    background: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border: 1px solid #ccc; /* Ensure no arrows inside dropdown */
}


/* For the entire container that holds the headings */
.follow-us h3 {
    list-style-type: none; /* Disable any automatic list style, which can add arrows */
}

/* Ensure form select dropdown isn't adding an arrow */
.w3-select {
    background: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border: 1px solid #ccc; /* Ensure no arrows inside dropdown */
}

    </style>
</head>
   <!-- Navbar -->
   <header class="navbar">
        <!-- Logo on the left -->
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
    
        <!-- Middle Menu (Home, Services, About) -->
        <nav class="middle-menu">
            <ul>
                <li><a href="HomePage.html" class="<?php if(basename($_SERVER['PHP_SELF']) == 'index.php') { echo 'active'; } ?>">Home</a></li>
                <li><a href="servicepage.html" class="<?php if(basename($_SERVER['PHP_SELF']) == 'services.php') { echo 'active'; } ?>">Services</a></li>
                <li><a href="newabout.html" class="<?php if(basename($_SERVER['PHP_SELF']) == 'about.php') { echo 'active'; } ?>">About</a></li>
                <li><a href="dashboard.php" class="<?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php') { echo 'active'; } ?>">Dashboard</a></li>
            </ul>
        </nav>
    
        <!-- Right Menu (Login) -->
        <nav class="right-menu">
            <ul>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

<body>

<h2>The House Hub Maintenance Reports</h2>
<table>
    <tr>
        <td>
            <h3>Maintenance Fault Stats per Semester per Residence</h3>
            <canvas id="semesterChart"></canvas>
        </td>
        <td>
            <h3>Maintenance Fault Progress</h3>
            <canvas id="progressChart"></canvas>
        </td>
    </tr>
    <tr>
        <td>
            <h3>Average Turnaround Time</h3>
            <canvas id="turnaroundChart"></canvas>
        </td>
        <td>
            <h3>Maintenance Fault Categories Stats</h3>
            <canvas id="categoryChart"></canvas>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h3>History of Categories of Complaints</h3>
            <canvas id="historyChart"></canvas>
        </td>
    </tr>
</table>

<script>
// Maintenance Fault Stats per Semester per Residence
const semesterLabels = <?php echo $semesterLabels; ?>;
const semesterCounts = <?php echo $semesterCounts; ?>;
const ctx1 = document.getElementById('semesterChart').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: semesterLabels,
        datasets: [{
            label: 'Total Tickets',
            data: semesterCounts,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Maintenance Fault Progress
const progressLabels = <?php echo $progressLabels; ?>;
const progressCounts = <?php echo $progressCounts; ?>;
const ctx2 = document.getElementById('progressChart').getContext('2d');
new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: progressLabels,
        datasets: [{
            label: 'Ticket Status',
            data: progressCounts,
            backgroundColor: ['red', 'yellow', 'green'],
        }]
    }
});

// Average Turnaround Time
const avgTurnaround = <?php echo $avgTurnaround; ?>;
const ctx3 = document.getElementById('turnaroundChart').getContext('2d');
new Chart(ctx3, {
    type: 'line',
    data: {
        labels: ['Average Turnaround Time'],
        datasets: [{
            label: 'Turnaround Time (Days)',
            data: [avgTurnaround],
            borderColor: 'blue',
            fill: false
        }]
    }
});

// Maintenance Fault Categories Stats
const categoryLabels = <?php echo $categoryLabels; ?>;
const categoryCounts = <?php echo $categoryCounts; ?>;
const ctx4 = document.getElementById('categoryChart').getContext('2d');
new Chart(ctx4, {
    type: 'bar',
    data: {
        labels: categoryLabels,
        datasets: [{
            label: 'Tickets by Category',
            data: categoryCounts,
            backgroundColor: 'orange'
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// History of Categories of Complaints
const historyLabels = <?php echo $historyLabels; ?>;
const historyCounts = <?php echo $historyCounts; ?>;
const ctx5 = document.getElementById('historyChart').getContext('2d');
new Chart(ctx5, {
    type: 'line',
    data: {
        labels: historyLabels,
        datasets: [{
            label: 'Historical Complaints',
            data: historyCounts,
            borderColor: 'purple',
            fill: false
        }]
    }
});
</script>
<footer>
        <div class="follow-us">
            <h3> Follow Us </h3>
        </div>
        <div class="social-icons">
            <a href=""><i class="fa-brands fa-facebook"></i></a>
            <a href=""><i class="fa-brands fa-instagram"></i></a>
            <a href=""><i class="fa-brands fa-tiktok"></i></a>
            <a href=""><i class="fa-brands fa-linkedin"></i></a>
            <a href=""><i class="fa-brands fa-twitter"></i></a>
        </div>
        <div class="footer-text">
            <p>COPYRIGHT © 2024 THE HOUSE HUB. ALL RIGHTS RESERVED.</p>
            <p>Follow us on social media for updates and news about our services!</p>
        </div>
    </footer>
    <script>
        // Smooth scrolling to sections
        function scrollToSection(sectionId) {
            document.querySelector(sectionId).scrollIntoView({ behavior: 'smooth' });  
         }
    </script>

</body>
</html>
