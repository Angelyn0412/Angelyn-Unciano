<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM applications WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "No application found.";
        exit();
    }

    $application = $result->fetch_assoc();
} else {
    echo "Invalid application ID.";
    exit();
}

// Update application
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $position = $_POST['position'];

    $stmt = $conn->prepare("UPDATE applications SET name = ?, email = ?, position = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $position, $id);

    if ($stmt->execute()) {
        echo "Application updated successfully!";
        header("Location: admin.php"); // Redirect to admin page after successful update
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Application</title>
</head>
<body>
    <h1>Edit Job Application</h1>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($application['name']); ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($application['email']); ?>" required>
        <br>
        <label for="position">Position Applied For:</label>
        <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($application['position']); ?>" required>
        <br>
        <input type="submit" value="Update Application">
    </form>
</body>
</html>