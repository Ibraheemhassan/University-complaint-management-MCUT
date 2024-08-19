<?php
// Database connection details
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";  // Replace with your database password
$dbname = "mcut-complaints";  // Replace with your database name

// Create a connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to handle admin login
function adminLogin($username, $password) {
    global $conn;

    // Sanitize input
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Query to check admin credentials
    $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    // Return true if a matching admin is found
    if (mysqli_num_rows($result) == 1) {
        return true;
    } else {
        return false;
    }
}

// Close the connection when the script ends
function closeConnection() {
    global $conn;

    // Check if the connection is still open
    if ($conn) {
        mysqli_close($conn);
        $conn = null;  // Set the connection to null to avoid further attempts to close it
    }
}
