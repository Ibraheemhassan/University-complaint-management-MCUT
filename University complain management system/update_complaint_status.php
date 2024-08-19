<?php
session_start();
include 'db_controller_admin.php';  // Include your database connection file

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['mark_solved'])) {
    $complaint_id = $_POST['complaint_id'];

    // Update complaint status to 'Solved'
    $update_query = "UPDATE complaints SET status = 'Solved' WHERE id = '$complaint_id'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        // Redirect to admin dashboard
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Error updating complaint status.";
    }
}

// Close the database connection
closeConnection();
?>
