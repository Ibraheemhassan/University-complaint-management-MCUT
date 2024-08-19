<?php
require_once 'db_controller.php';

// Fetch complaint statistics
$totalComplaintsQuery = "SELECT COUNT(*) as total FROM complaints";
$totalComplaintsResult = $conn->query($totalComplaintsQuery);
$totalComplaints = $totalComplaintsResult->fetch_assoc()['total'];

$pendingComplaintsQuery = "SELECT COUNT(*) as pending FROM complaints WHERE status = 'Pending'";
$pendingComplaintsResult = $conn->query($pendingComplaintsQuery);
$pendingComplaints = $pendingComplaintsResult->fetch_assoc()['pending'];

$query_solved = "SELECT COUNT(*) as solved_count FROM complaints WHERE status='Solved'";
$result_solved = mysqli_query($conn, $query_solved);
$row_solved = mysqli_fetch_assoc($result_solved);
$solved_count = $row_solved['solved_count'];

// Fetch complaint data
$complaintsQuery = "SELECT * FROM complaints";
$complaintsResult = $conn->query($complaintsQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCUT Complaint Management Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:wght@100;300;400;500;700;900&display=swap');
        body {
            font-family: "Roboto",sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        .wrapper {
            display: flex;
            width: 100%;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: #fff;
            padding-top: 20px;
            transition: transform 0.3s ease;
            transform: translateX(0);
        }

        .sidebar.closed {
            transform: translateX(-250px);
        }
        .text-center{
            text-align: center;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 15px 20px;
            display: block;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #343a40;
            color: #fff;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header .btn {
            color: #fff;
            background-color: #495057;
            border: none;
            margin-right: 15px;
            font-size: 1.25rem;
        }

        .header .logo {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }

        .header .logo img {
            height: 40px;
        }

        .header .title {
            font-size: 1.4rem;
            margin-left: 25px;
            font-family: "Roboto Condensed",sans-serif;
        }

        .content {
            margin-top: 60px;
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            transition: margin-left 0.3s ease;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            background: #fff;
            flex: 1;
            min-width: 200px;
            margin-bottom: 20px;
        }

        .card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.25rem;
            border-bottom: 2px solid #0056b3;
            text-align: center;
        }

        .card-body {
            font-size: 1.2rem;
            text-align: center;
            margin: 8px;
        }

        .card-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .dasboard-panels {
            margin: 8px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 32px;
        }

        .panel-item {
            width: 15rem;
            height: 10rem;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            row-gap: 12px;
            font-size: 20px;
            color: white;
        }

        .panel-main-heading {
            font-family: "Roboto Condensed",sans-serif;
            font-weight: 600;
        }

        .panel-value-heading {
            font-weight: 500;
        }

        #panel-1 {
            background-color: #6741d9;
        }

        #panel-2 {
            background-color: #fab005;
        }

        #panel-3 {
            background-color: #37b24d;
        }

        .complaint-table {
            width: 100%;
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            padding: 4px 12px;
        }

        .complaint-table th,
        .complaint-table td {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .complaint-table thead {
            background-color: #333;
            color: white;
            text-align: center;
        }
        th{
            font-family: "Roboto Condensed",sans-serif;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        th,
        td {
            padding: 12px 15px;
            border: 1px solid #ddd;

        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        
        .delete-btn {
    display: inline-block;
    padding: 10px 20px;
    color: #fff;
    background-color: #dc3545; /* Red color for the delete button */
    border: none;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
}

.delete-btn:hover {
    background-color: #c82333; /* Darker red on hover */
}
        .view-btn {
    display: inline-block;
    padding: 10px 20px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
}

.view-btn:hover {
    background-color: #0056b3;
}



    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar">
            <a href="#" class="btn btn-secondary" id="sidebarToggle"><i class="fas fa-bars"></i></a>
            <h4 class="text-center">Admin Dashboard</h4>
            <a href="add_admin.php">Add Admins</a>
            <a href="manage_complaints.php">Manage Complaints</a>
            <a href="manage_account.php">Manage Account</a>
            <a href="logout.php">Logout</a>
        </div>

        <!-- Page Content -->
        <div class="content">
            <header class="header">
                <button class="btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                <div class="logo">
                    <img src="mcut_logo_no_black_background.png" alt="MCUT Logo">
                    <span class="title">Complaint Management Dashboard</span>
                </div>
            </header>

            <main class="container">
                <div class="dasboard-panels">
                    <div class="panel-item" id="panel-1">
                        <span class="panel-main-heading">Total Complaints</span>
                        <span class="panel-value-heading"><?php echo $totalComplaints; ?></span>
                    </div>
                    <div class="panel-item" id="panel-2">
                        <span class="panel-main-heading">Pending Complaints</span>
                        <span class="panel-value-heading"><?php echo $pendingComplaints; ?></span>
                    </div>
                    <div class="panel-item" id="panel-3">
                        <span class="panel-main-heading">Solved Complaints</span>
                        <span class="panel-value-heading"><?php echo $solved_count; ?></span>
                    </div>
                </div>

                <!-- Complaints Table -->
                <div class="complaint-table mt-4">
                    <h4>Complaints List</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Program</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>CNIC</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Detail</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $complaintsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['program']; ?></td>
                                <td><?php echo $row['student_id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['cnic']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['complaint_detail']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td>
                                <a href="view_complaint.php?id=<?php echo $row['id']; ?>" class="view-btn">View Complaint</a>

                                   
                                <a href="delete_complaint.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this complaint?');">Delete Complaint</a>

                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            var sidebar = document.getElementById('sidebar');
            var content = document.querySelector('.content');

            sidebar.classList.toggle('closed');
            if (sidebar.classList.contains('closed')) {
                content.style.marginLeft = '0';
            } else {
                content.style.marginLeft = '250px';
            }
        });
    </script>
</body>

</html>