<?php
// Database connection parameters
$host = 'localhost'; // Replace with your database host
$db = 'mcut-complaints'; // Replace with your database name
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $campus = $_POST['campus'];
    $program = $_POST['program'];
    $student_id = $_POST['studentId'];
    $name = $_POST['name'];
    $cnic = $_POST['cnic'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $complaint_detail = $_POST['complaintDetail'];

    // Handle file uploads

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO complaints (campus, program, student_id, name, cnic, email, phone, complaint_detail) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $campus, $program, $student_id, $name, $cnic, $email, $phone, $complaint_detail);

    // Execute and check for errors
    if ($stmt->execute()) {
        $success_message = "Complaint submitted successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>