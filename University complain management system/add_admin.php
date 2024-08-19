<!-- add_admin.php -->
<?php
session_start();
include 'db_controller_admin.php';  // Include the database controller

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];

    // Insert new admin into the database
    $query = "INSERT INTO admins (username, password) VALUES ('$new_username', '$new_password')";
    if (mysqli_query($conn, $query)) {
        // Redirect to the dashboard after successful insertion
        header("Location: admin_dashboard.php");
        exit();  // Make sure to exit after redirection
    } else {
        $error_message = "Error adding admin: " . mysqli_error($conn);
    }

    // Close the database connection
    closeConnection();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Add New Admin</h2>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <?php if(isset($error_message)) { echo "<p class='text-danger'>$error_message</p>"; } ?>
                <form action="add_admin.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Add Admin</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
