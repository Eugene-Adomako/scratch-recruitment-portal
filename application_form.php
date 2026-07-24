<?php
session_start();
include('db.php');
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$job_id = $_GET['job_id'];
$job_q = mysqli_query($conn, "SELECT title FROM jobs WHERE id = $job_id");
$job = mysqli_fetch_assoc($job_q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Job Application | Scratch Group</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&q=80&w=1600') fixed center/cover;
            min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif;
        }
        .form-card { 
            background: rgba(255, 255, 255, 0.95); border-radius: 30px; padding: 40px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.5); width: 100%; max-width: 600px; color: #333;
        }
        .form-control { border: 2px solid #000; border-radius: 12px; padding: 12px; }
        .btn-gold { background: #D4AF37; color: #000; border: none; font-weight: 700; border-radius: 50px; padding: 15px; width: 100%; }
        .support-msg { background: #000; color: #D4AF37; padding: 15px; border-radius: 15px; margin-bottom: 20px; font-size: 13px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="form-card">
        <div class="support-msg text-center">🤖 SCRATCH AI: Please provide accurate credentials for immediate verification.</div>
        <h3 class="fw-bold mb-1">Applying for:</h3>
        <h4 class="text-primary mb-4"><?php echo $job['title']; ?></h4>

        <form action="process_application.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
            
            <div class="mb-3">
                <label class="small fw-bold">Active Phone Number</label>
                <input type="text" name="phone_number" class="form-control" placeholder="+233..." required>
            </div>

            <div class="mb-3">
                <label class="small fw-bold">Years of Industry Experience</label>
                <input type="number" name="experience_years" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="small fw-bold">Statement of Motivation (Why Scratch Group?)</label>
                <textarea name="why_applying" class="form-control" rows="4" placeholder="How do you align with our corporate goals?" required></textarea>
            </div>

            <div class="mb-4">
                <label class="small fw-bold">Resume / CV (PDF Format Only)</label>
                <input type="file" name="cv_file" class="form-control" accept=".pdf" required>
            </div>

            <button type="submit" name="submit_credentials" class="btn-gold shadow">SUBMIT APPLICATION</button>
            <div class="text-center mt-3"><a href="index.php" class="text-dark small fw-bold text-decoration-none">← Return to Dashboard</a></div>
        </form>
    </div>
</body>
</html>