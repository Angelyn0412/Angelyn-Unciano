<?php
include 'config.php'; // Include the database configuration file

// Initialize variables
$positions = [];
$positionAvailableMessage = "";

// Fetch available positions
$result = $conn->query("SELECT * FROM positions WHERE is_available = TRUE");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $positions[] = $row['position_name'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $resume = $_FILES['resume'];

    // Check if the position is available
    $positionCheck = $conn->query("SELECT * FROM positions WHERE position_name = '$position' AND is_available = TRUE");
    
    if ($positionCheck->num_rows > 0) {
        // Handle file upload
        $targetDir = "uploads/";
        
        // Ensure the uploads directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true); // Create the directory if it doesn't exist
        }

        $targetFile = $targetDir . basename($resume["name"]);
        $uploadOk = 1;

        // Check file size (limit to 2MB)
        if ($resume["size"] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (!in_array($fileType, ['pdf', 'doc', 'docx'])) {
            echo "Sorry, only PDF, DOC & DOCX files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
            if (move_uploaded_file($resume["tmp_name"], $targetFile)) {
                // Insert application into the database
                $stmt = $conn->prepare("INSERT INTO applications (name, email, position, resume_path) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $email, $position, $targetFile);

                if ($stmt->execute()) {
                    echo "Application submitted successfully!";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $positionAvailableMessage = "The position '$position' is not available.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Tracker</title>
    <link rel="stylesheet" href="styles.css">
    <style>
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
    <div class="main-content">
    <div class="container">
        <h1>Job Application Tracker</h1>
        
        <!-- Link to Add New Application Page -->
        <div>
            <a href="add.html" class="button is-link">Add New Application</a>
        </div>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="position">Position Applied For:</label>
            <select id="position" name="position" required>
                <option value="">Select a position</option>
                <?php foreach ($positions as $pos): ?>
                    <option value="<?php echo htmlspecialchars($pos); ?>"><?php echo htmlspecialchars($pos); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="resume">Resume (PDF, DOC, DOCX):</label>
            <input type="file" id="resume" name="resume" required>

            <input type="submit" value="Submit Application">
        </form>
        <?php if ($positionAvailableMessage): ?>
            <p style="color: red;"><?php echo htmlspecialchars($positionAvailableMessage); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>