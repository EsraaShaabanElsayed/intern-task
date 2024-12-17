<?php
// MySQL credentials
$servername = "localhost"; // Use the local database (localhost)
$username = "web_user";    // The username you created for the database
$password = "StrongPassword123"; // The password you set for the user
$dbname = "web_db";        // The database name you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Simplified query for debugging
$sql = "SELECT NOW()"; // Simplified query without alias

// Debugging: print the query
//echo "SQL Query: " . $sql . "<br>";

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output the current time (use 'NOW()' as the column name)
    $row = $result->fetch_assoc();
    $current_time = $row['NOW()']; // Corrected to use 'NOW()' as the column name
} else {
    $current_time = "Unable to fetch time.";
}

// Get the visitor's IP address
$visitor_ip = $_SERVER['REMOTE_ADDR'];

// Close the connection
$conn->close();

// Display the message
echo "<h1>Hello!</h1>";
echo "<p>Your IP address is: " . $visitor_ip . "</p>";
echo "<p>The current time is: " . $current_time . "</p>";
?>
