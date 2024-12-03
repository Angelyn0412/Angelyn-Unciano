<?php
$servername = "localhost"; // Change if necessary
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "job_application_tracker"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch applications from the database
$sql = "SELECT * FROM applications ORDER BY created_at DESC"; // Fetch all applications ordered by date
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Applications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <style>   
    .container {
            margin-top: 20px;
        }
        .container {
            margin-top: 20px;
        }
        body {
            display: flex;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 200px;
            background-color: #2c3e50;
            color: white;
            padding: 15px;
        }
        .sidebar h2 {
            color: #ecf0f1;
        }
        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="sidebar">
        <h2>Dashboard</h2>
        <a href="add.html">Add New Application</a>
        <a href="view_applications.php">View Applications</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h1 class="title">Job Applications</h1>

        <?php if ($result->num_rows > 0): ?>
            <table class="table is-striped is-hoverable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company</th>
                        <th>Position</th>
                        <th>Date Applied</th>
                        <th>Notes</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo isset($row['company']) ? htmlspecialchars($row['company']) : 'N/A'; ?></td>
                            <td><?php echo isset($row['position']) ? htmlspecialchars($row['position']) : 'N/A'; ?></td>
                            <td><?php echo isset($row['date_applied']) ? htmlspecialchars($row['date_applied']) : 'N/A'; ?></td>
                            <td><?php echo isset($row['notes']) ? htmlspecialchars($row['notes']) : 'N/A'; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="notification is-warning">
                No applications found.
            </div>
        <?php endif; ?>

    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>

</html>