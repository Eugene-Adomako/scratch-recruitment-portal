<?php session_start(); include('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Job - Scratch Group</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container card p-4 shadow" style="max-width: 600px;">
        <h3 style="color: #003366;">Create New Job Advert</h3>
        <form method="POST">
            <div class="mb-3"><label>Job Title</label><input type="text" name="title" class="form-control" required></div>
            <div class="mb-3"><label>Description</label><textarea name="desc" class="form-control" rows="3" required></textarea></div>
            <div class="mb-3"><label>Requirements (e.g. Accounting, PHP, Sales)</label><input type="text" name="reqs" class="form-control" required></div>
            <button type="submit" name="save" class="btn btn-primary w-100" style="background:#003366;">Post Advertisement</button>
            <a href="index.php" class="btn btn-link w-100">Cancel</a>
        </form>
    </div>
    <?php
    if(isset($_POST['save'])){
        $t = $_POST['title']; $d = $_POST['desc']; $r = $_POST['reqs'];
        mysqli_query($conn, "INSERT INTO jobs (title, description, requirements) VALUES ('$t', '$d', '$r')");
        header("Location: index.php");
    }
    ?>
</body>
</html>