<?php session_start(); include('db.php'); if(!isset($_SESSION['user_id'])) header("Location: login.php"); $jobs = mysqli_query($conn, "SELECT * FROM jobs"); ?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1600') fixed center; padding: 50px; color:#fff; }</style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between mb-5"><h2>VACANCIES</h2><a href="index.php" class="btn btn-light rounded-pill">Dashboard</a></div>
    <div class="row g-4">
        <?php while($j = mysqli_fetch_assoc($jobs)): ?>
        <div class="col-md-6"><div class="bg-white p-4 rounded-4 shadow text-dark"><h4><?php echo $j['title']; ?></h4><p><?php echo $j['description']; ?></p><a href="application_form.php?job_id=<?php echo $j['id']; ?>" class="btn btn-dark rounded-pill">Select & Apply</a></div></div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>