<?php
session_start();
include 'db_controller_admin.php';  // Include your database connection file

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Delete the complaint from the database based on the ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM complaints WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        // Redirect back to the dashboard with a success message
        header("Location: admin_dashboard.php?message=Complaint+deleted+successfully");
    } else {
        // Redirect back to the dashboard with an error message
        header("Location: admin_dashboard.php?message=Error+deleting+complaint");
    }
} else {
    header("Location: admin_dashboard.php");
    exit();
}

// Close the database connection
closeConnection();
?>
