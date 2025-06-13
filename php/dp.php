<?php
// Database configuration
$servername = "localhost";  // Hostname
$username = "root";         // Database username
$password = "";             // Database password
$dbname = "NFN";            // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Connection failed
    die("Connection failed: " . $conn->connect_error);
} else {
    // Connection successful - Generally avoid echoing in production
    // echo "Connection successful!";
}
?>
