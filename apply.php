<?php
session_start();
include('db.php');
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); }
$jobs = mysqli_query($conn, "SELECT * FROM jobs");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Browse Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(rgba(255,255,255,0.85), rgba(255,255,255,0.85)), url('https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&q=80&w=1600') fixed center/cover;
            padding: 50px;
        }
        .neo-card { background: #fff; border: 4px solid #000; padding: 25px; box-shadow: 10px 10px 0px #000; }
        .btn-neo { background: #000; color: #fff; border: none; padding: 10px 25px; font-weight: 700; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between mb-5">
            <h2 class="fw-bold">AVAILABLE VACANCIES</h2>
            <div>
                <button onclick="history.back()" class="btn btn-outline-dark">Back</button>
                <a href="index.php" class="btn btn-dark">Home</a>
            </div>
        </div>
        <div class="row g-4">
            <?php while($j = mysqli_fetch_assoc($jobs)): ?>
            <div class="col-md-6">
                <div class="neo-card">
                    <h4 class="fw-bold"><?php echo $j['title']; ?></h4>
                    <p><?php echo $j['description']; ?></p>
                    <form action="upload_handler.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="job_id" value="<?php echo $j['id']; ?>">
                        <input type="file" name="cv" class="form-control border-dark mb-3" required>
                        <button class="btn-neo">Upload CV & Apply</button>
                    </form>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>