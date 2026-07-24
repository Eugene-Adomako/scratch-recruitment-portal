<?php 
session_start();
include('db.php'); 

// Check if user is logged in AND is an HR/Admin
if(!isset($_SESSION['name'])) {
    header("Location: login.php");
}
// Get Stats for Cards
$total_apps = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM applications"));
$total_hires = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM applications WHERE status='Hired'"));
$total_jobs = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM jobs"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HR Dashboard | Scratch Group</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #003366; --bg: #f4f7f6; }
        body { background-color: var(--bg); font-family: 'Segoe UI', sans-serif; }
        .sidebar { width: 260px; height: 100vh; background: var(--primary); color: white; position: fixed; padding-top: 20px; }
        .sidebar a { color: #cfd8dc; text-decoration: none; padding: 15px 25px; display: block; border-left: 4px solid transparent; }
        .sidebar a:hover { background: #0056b3; border-left: 4px solid #fff; }
        .main-content { margin-left: 260px; padding: 30px; }
        .company-logo { font-family: 'Orbitron', sans-serif; letter-spacing: 1px; font-size: 20px; margin-bottom: 30px; display: block; text-align: center; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .stat-card { border-left: 5px solid #003366; }
    </style>
</head>
<body>

<div class="sidebar">
    <span class="company-logo">SCRATCH GROUP</span>
    <hr>
    <a href="dashboard.php">📊 Recruitment Dashboard</a>
    <a href="add_job.php">➕ Create Job Posting</a>
    <a href="employees.php">👥 Employee Records</a>
    <a href="index.php">🌐 View Public Site</a>
    <a href="logout.php" class="text-warning mt-5">🚪 Logout</a>
    <div class="mt-5 p-3 small opacity-50">
        adomakoeugene15@gmail.com<br>+233548000931
    </div>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Recruitment Management</h2>
        <span class="badge bg-white text-dark p-2 shadow-sm">Admin: <?php echo $_SESSION['name']; ?></span>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4 text-center">
        <div class="col-md-4"><div class="card p-4 stat-card"><h6>Open Positions</h6><h2 class="fw-bold"><?php echo $total_jobs; ?></h2></div></div>
        <div class="col-md-4"><div class="card p-4 stat-card"><h6>Total Applicants</h6><h2 class="fw-bold text-primary"><?php echo $total_apps; ?></h2></div></div>
        <div class="col-md-4"><div class="card p-4 stat-card"><h6>Hired Employees</h6><h2 class="fw-bold text-success"><?php echo $total_hires; ?></h2></div></div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Growth & Hiring Trends</h5>
                <canvas id="growthChart" height="120"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 h-100">
                <h5 class="fw-bold">Company Goals</h5>
                <p class="small text-muted">1. Connect Talent to Opportunity.<br>2. AI-driven screening.<br>3. Zero-paper recruitment flow.</p>
                <hr>
                <a href="add_job.php" class="btn btn-primary w-100 mb-2">Create New Job</a>
            </div>
        </div>
    </div>

    <!-- Recruitment Flow Table -->
    <div class="card p-4">
        <h5 class="fw-bold mb-3 text-muted">Live Recruitment Pipeline</h5>
        <table class="table align-middle">
            <thead class="table-light">
                <tr><th>Applicant</th><th>Position</th><th>AI Match</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php
                $apps = mysqli_query($conn, "SELECT applications.*, users.fullname, jobs.title FROM applications JOIN users ON applications.user_id = users.id JOIN jobs ON applications.job_id = jobs.id ORDER BY id DESC");
                while($row = mysqli_fetch_assoc($apps)){
                    $badge = ($row['ai_score'] >= 75) ? 'bg-success' : 'bg-warning';
                    echo "<tr>
                        <td><b>".$row['fullname']."</b></td>
                        <td>".$row['title']."</td>
                        <td><span class='badge $badge'>".$row['ai_score']."% Match</span></td>
                        <td><span class='badge bg-info text-dark'>".$row['status']."</span></td>
                        <td>
                            <div class='dropdown'>
                                <button class='btn btn-sm btn-outline-dark dropdown-toggle' data-bs-toggle='dropdown'>Manage</button>
                                <ul class='dropdown-menu'>
                                    <li><a class='dropdown-item' href='update_status.php?id=".$row['id']."&status=Interview Scheduled'>Schedule Interview</a></li>
                                    <li><a class='dropdown-item text-success' href='update_status.php?id=".$row['id']."&status=Hired'>Mark as Hired</a></li>
                                    <li><a class='dropdown-item text-danger' href='update_status.php?id=".$row['id']."&status=Rejected'>Reject</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    new Chart(document.getElementById('growthChart'), {
        type: 'bar',
        data: {
            labels: ['Aug', 'Sep', 'Oct', 'Nov'],
            datasets: [{
                label: 'New Applications',
                data: [15, 22, 18, <?php echo $total_apps; ?>],
                backgroundColor: '#003366',
                borderRadius: 10
            }]
        }
    });
</script>
</body>
</html>