<?php
define ("SERVERNAME","is3-dev.ict.ru.ac.za");
define("USERNAME", "CodersCollective");
define("PASSWORD","J3suV5V6" );
define("DATABASE","CodersCollective");

function connectDatabase() {
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

?>