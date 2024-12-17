<?php
// Include the configuration file
require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Simplified query for debugging
$sql = "SELECT NOW()";

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_time = $row['NOW()'];
} else {
    $current_time = "Unable to fetch time.";
}

// Get the visitor's IP address
$visitor_ip = $_SERVER['REMOTE_ADDR'];

// Close the connection
$conn->close();

// Display the message
echo "<h1>Hello Everyone!</h1>";
echo "<p>Your IP address is: " . $visitor_ip . "</p>";
echo "<p>The current time is: " . $current_time . "</p>";
?>
