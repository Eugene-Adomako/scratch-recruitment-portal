<?php 
session_start();
include('db.php');
if($_SESSION['role'] != 'HR') { header("Location: index.php"); exit(); }

// Analytics Queries
$total = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM applications"));
$hired = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM applications WHERE status='Enrolled'"));
$rejected = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM applications WHERE status='Rejected'"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>HR Panel | Scratch Group</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background: #f0f2f5; font-family: 'Poppins', sans-serif; }
        .sidebar { height: 100vh; width: 250px; position: fixed; background: #003366; color: white; padding: 20px; }
        .main { margin-left: 270px; padding: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 style="font-family: Orbitron;">SCRATCH HR</h3><hr>
    <p>Logged in as: <?php echo $_SESSION['name']; ?></p>
    <a href="logout.php" class="btn btn-danger btn-sm mt-5">Logout</a>
</div>

<div class="main">
    <h2 class="mb-4 fw-bold">Business Growth Tracking</h2>
    
    <div class="row mb-5">
        <div class="col-md-4"><div class="stat-card"><h5>Total Applicants</h5><h2 class="text-primary"><?php echo $total; ?></h2></div></div>
        <div class="col-md-4"><div class="stat-card"><h5>Hired Employees</h5><h2 class="text-success"><?php echo $hired; ?></h2></div></div>
        <div class="col-md-4"><div class="stat-card"><h5>Rejected Applicants</h5><h2 class="text-danger"><?php echo $rejected; ?></h2></div></div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="stat-card">
                <h5>Hiring Trends (Business Growth)</h5>
                <canvas id="growthChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card h-100">
                <h5>Update Applicant Status</h5>
                <form action="update_status.php" method="POST">
                    <input type="number" name="app_id" placeholder="App ID" class="form-control mb-2" required>
                    <select name="status" class="form-select mb-3">
                        <option>Shortlist</option>
                        <option>Enrolled</option>
                        <option>Rejected</option>
                    </select>
                    <button class="btn btn-primary w-100">Apply Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('growthChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total', 'Hired', 'Rejected'],
            datasets: [{
                label: 'Business Recruitment Growth',
                data: [<?php echo "$total, $hired, $rejected"; ?>],
                backgroundColor: ['#003366', '#28a745', '#dc3545']
            }]
        }
    });
</script>
</body>
</html>