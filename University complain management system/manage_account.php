<?php
session_start();
include 'db_controller_admin.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");  // Redirect to login if not logged in
    exit;
}

$admin_username = $_SESSION['admin'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if new passwords match
    if ($new_password === $confirm_password) {
        // Sanitize input
        $current_password = mysqli_real_escape_string($conn, $current_password);
        $new_password = mysqli_real_escape_string($conn, $new_password);

        // Verify current password
        $query = "SELECT * FROM admins WHERE username = '$admin_username' AND password = '$current_password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // Update password
            $update_query = "UPDATE admins SET password = '$new_password' WHERE username = '$admin_username'";
            if (mysqli_query($conn, $update_query)) {
                // Redirect to admin dashboard after successful password change
                header("Location: admin_dashboard.php");
                exit;  // Make sure to exit after the redirect
            } else {
                $error = "Failed to update password.";
            }
        } else {
            $error = "Current password is incorrect.";
        }
    } else {
        $error = "New passwords do not match.";
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
    <title>Change Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Change Password</h2>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form action="manage_account.php" method="post">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                </form>
                <?php if ($error) { echo "<p class='text-danger mt-3'>$error</p>"; } ?>
            </div>
        </div>
    </div>
</body>
</html>
