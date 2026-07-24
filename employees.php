<?php session_start(); include('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Employees - Scratch Group</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container card p-4">
        <h3 style="color:#003366;">Scratch Group - Employee Records</h3>
        <table class="table">
            <thead><tr><th>Name</th><th>Email</th><th>Contact</th><th>Job Title</th></tr></thead>
            <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT users.*, jobs.title FROM applications JOIN users ON applications.user_id = users.id JOIN jobs ON applications.job_id = jobs.id WHERE applications.status='Hired'");
                while($row = mysqli_fetch_assoc($res)){
                    echo "<tr><td>".$row['fullname']."</td><td>".$row['email']."</td><td>".$row['contact']."</td><td>".$row['title']."</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </div>
</body>
</html>