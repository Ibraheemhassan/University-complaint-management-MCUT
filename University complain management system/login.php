
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
    $campus = isset($_POST['campus']) ? $_POST['campus'] : '';
    $program = isset($_POST['program']) ? $_POST['program'] : '';
    $student_id = isset($_POST['studentId']) ? $_POST['studentId'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $cnic = isset($_POST['cnic']) ? $_POST['cnic'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $complaint_detail = isset($_POST['complaintDetail']) ? $_POST['complaintDetail'] : '';

    // Initialize error message variable
    $error_message = '';

    // Validate required fields
    if (empty($campus) || empty($program) || empty($student_id) || empty($name) || empty($cnic) || empty($email) || empty($phone) || empty($complaint_detail)) {
        $error_message = 'Please fill out all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Please enter a valid email address.';
    } elseif (!preg_match('/^[0-9]{13}$/', $cnic)) {
        $error_message = 'CNIC must be 13 digits long.';
    }

    // Handle file uploads
 
 /*   $complaint_files = '';
if (empty($error_message) && !empty($_FILES['complaintFiles']['name'][0])) {
    $uploaded_files = $_FILES['complaintFiles'];
    $file_names = [];

    foreach ($uploaded_files['name'] as $key => $name) {
        $file_tmp = $uploaded_files['tmp_name'][$key];
        $file_name = uniqid() . '-' . basename($name); // Add unique ID to file name
        $file_name = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file_name); // Sanitize file name
        $upload_dir = 'uploads/';

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Use 0755 for directory permissions
        }

        $file_path = $upload_dir . $file_name;
        if (move_uploaded_file($file_tmp, $file_path)) {
            $file_names[] = $file_name;
        } else {
            $error_message = 'Failed to upload file: ' . $file_name;
        }
    }

    $complaint_files = implode(',', $file_names);
}
*/

    // Proceed with database insertion if there are no errors
    if (empty($error_message)) {
        // Prepare and bind
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
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCUT Complaint Management Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #343a40;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            height: 60px; /* Adjusted height */
        }

        header .logo {
            display: flex;
            align-items: center;
        }

        header .logo img {
            height: 40px; /* Reduced image height */
            margin-right: 10px;
        }

        header nav ul {
            display: flex;
            margin-bottom: 0;
        }

        header nav ul li {
            margin-left: 15px;
            position: relative;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border: 2px solid transparent;
            transition: all 0.3s ease-in-out;
            border-radius: 5px;
        }

        header nav ul li a:hover {
            background-color: black;
            border-color: white;
        }

        .welcome-section {
            background-color: #007bff;
            color: #fff;
            padding: 60px 20px 30px; /* Adjusted padding */
            text-align: center;
            font-family: 'Arial', sans-serif;
            margin-bottom: 20px;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .welcome-section p {
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .form-section {
            padding: 40px 20px 40px; /* Adjusted padding */
            margin-top: 20px; /* Adjusted to accommodate the fixed header */
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            flex-grow: 1; /* Ensures the section expands to push the footer down */
        }

        .form-section h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .form-section .welcome-note {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.2rem;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            text-align: center;
            margin-top: 20px;
            width: 100%;
            position: relative;
            clear: both;
        }

        footer a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #ccc;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="mcut_logo_no_black_background.png" alt="MCUT Logo">
            <h1 class="h5 mb-0">MCUT Complaint Portal</h1>
        </div>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a href="https://www.mcut.edu.pk" target="_blank" class="nav-link text-white">MCUT</a></li>
                <li class="nav-item"><a href="admin_login.php" class="nav-link text-white">Admin</a></li>
            </ul>
        </nav>
    </header>

    <section class="welcome-section">
        <h1>Welcome to the MCUT Complaint Portal</h1>
        <p>We are here to help you address your concerns and issues effectively. Please use the form below to submit your complaint.</p>
    </section>

    <section class="form-section">
        <h2>Submit Your Complaint</h2>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <p class="welcome-note">Please fill out the form below to submit your complaint.</p>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="campus">Campus/Division</label>
                <select class="form-control" id="campus" name="campus">
                    <option value="">Select Campus</option>
                    <option>DG Khan Campus</option>
                </select>
            </div>
            <div class="form-group">
                <label for="program">Study Program</label>
                <select class="form-control" id="program" name="program">
                    <option value="">Select Program</option>
                    <option>BS Information Engineering Technology</option>
                    <option>BS Electrical Engineering Technology</option>
                    <option>BS Civil Engineering Technology</option>
                    <option>BS Chemical Engineering Technology</option>
                    <option>BS Petrochemical Engineering Technology</option>
                    <option>BS Mechanical Engineering Technology</option>
                </select>
            </div>
            <div class="form-group">
                <label for="studentId">Student ID</label>
                <input type="text" class="form-control" id="studentId" name="studentId">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="cnic">CNIC (without dashes)</label>
                <input type="text" class="form-control" id="cnic" name="cnic">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="phone">Phone No</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="complaintDetail">Complaint Detail</label>
                <textarea class="form-control" id="complaintDetail" name="complaintDetail" rows="5"></textarea>
            </div>

            <button type="submit">Submit</button>
        </form>
    </section>

    <footer>
        <p>Mir Chakar Khan Rind University of Technology, Dera Ghazi Khan</p>
        <p>Email: info@mcut.edu.pk | Phone: +92 64 9260123</p>
        <p>
            <a href="#" class="text-white"><i class="fab fa-facebook"></i> Facebook</a> |
            <a href="#" class="text-white"><i class="fab fa-twitter"></i> Twitter</a> |
            <a href="#" class="text-white"><i class="fab fa-linkedin"></i> LinkedIn</a>
        </p>
    </footer>
</body>
</html>
