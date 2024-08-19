<?php
session_start();
include 'db_controller_admin.php';  // Include your database connection file

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch the complaint details based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM complaints WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $complaint = mysqli_fetch_assoc($result);
} else {
    header("Location: manage_complaints.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Complaint</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Complaint Details</h2>
        <div class="card">
            <div class="card-body">
                <p><strong>Program:</strong> <?php echo $complaint['program']; ?></p>
                <p><strong>Student ID:</strong> <?php echo $complaint['student_id']; ?></p>
                <p><strong>Name:</strong> <?php echo $complaint['name']; ?></p>
                <p><strong>CNIC:</strong> <?php echo $complaint['cnic']; ?></p>
                <p><strong>Email:</strong> <?php echo $complaint['email']; ?></p>
                <p><strong>Phone:</strong> <?php echo $complaint['phone']; ?></p>
                <p><strong>Detail:</strong> <?php echo $complaint['complaint_detail']; ?></p>
                <p><strong>Status:</strong> <?php echo $complaint['status']; ?></p>
                
                <!-- Solved Button Form -->
                <form method="POST" action="update_complaint_status.php">
                    <input type="hidden" name="complaint_id" value="<?php echo $id; ?>">
                    <button type="submit" name="mark_solved" class="btn btn-success">Mark as Solved</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
// Close the database connection
closeConnection();
?>
