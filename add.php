<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <style>
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
        <h1 class="title">Add Job Application</h1>
        <form id="applicationForm">
            <div class="field">
                <label class="label">Company</label>
                <div class="control">
                    <input class="input" type="text" id="companyInput" placeholder="e.g., Company D" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Position</label>
                <div class="control">
                    <input class="input" type="text" id="positionInput" placeholder="e.g., UX Designer" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Date Applied</label>
                <div class="control">
                    <input class="input" type="date" id="dateInput" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Notes</label>
                <div class="control">
                    <textarea class="textarea" id="notesInput" placeholder="Any additional notes..."></textarea>
                </div>
            </div>
            <div class="control">
                <button class="button is-link" type="submit">Add Application</button>
            </div>
        </form>
        <div class="notification is-hidden" id="successMessage">
            Application added successfully!
        </div>
    </div>

    <script>
    document.getElementById('applicationForm').addEventListener('submit', function (event) {
        // No need to prevent default since we are submitting the form normally
        const company = document.getElementById('companyInput').value;
        const position = document.getElementById('positionInput').value;
        const dateApplied = document.getElementById('dateInput').value;
        const notes = document.getElementById('notesInput').value;

        // Set form data to be sent
        const formData = new FormData();
        formData.append('company', company);
        formData.append('position', position);
        formData.append('date_applied', dateApplied);
        formData.append('notes', notes);

        // You can send the form data using fetch if you want to handle it via AJAX
        fetch('submit_application.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // You can handle the response here
            document.getElementById('successMessage').classList.remove('is-hidden');
            document.getElementById('applicationForm').reset();
        })
        .catch(error => console.error('Error:', error));
    });
</script>
</body>

</html>