<?php 
include('logic.php'); 
$is_logged_in = isset($_SESSION['user_id']);
$role = $_SESSION['role'] ?? '';
$search = $_GET['search'] ?? '';
$jobs = mysqli_query($conn, "SELECT * FROM jobs WHERE title LIKE '%$search%' ORDER BY id DESC");

// HR GLOBAL METRICS
$total_applicants = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='Candidate'"));
$total_staff = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='Employee'"));
$total_apps_submitted = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM applications"));
$hires = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM applications WHERE status='Enrolled'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scratch Group Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=1600') fixed center/cover; color: #fff; min-height: 100vh; font-family: 'Inter', sans-serif; margin:0; }
        .saas-sidebar { width: 280px; height: 100vh; position: fixed; background: rgba(0, 31, 63, 0.5); backdrop-filter: blur(15px); border-right: 1px solid rgba(255,255,255,0.1); padding: 35px 25px; z-index: 1000; }
        .main-content { margin-left: <?php echo $is_logged_in ? '280px' : '0'; ?>; padding: 40px; transition: 0.3s; }
        .glass-card { background: rgba(255, 255, 255, 0.96); border-radius: 25px; padding: 25px; color: #333; box-shadow: 0 10px 30px rgba(0,0,0,0.4); transition: 0.3s; border: none; }
        .glass-card:hover { transform: translateY(-8px); box-shadow: 0 15px 40px rgba(212, 175, 55, 0.4); border: 1px solid #D4AF37; }
        .btn-gold { background: #D4AF37; color: #000; border-radius: 50px; font-weight: 700; padding: 12px 30px; text-decoration: none; border: none; }
        .progress-container { background: #eee; height: 15px; border-radius: 20px; overflow: hidden; margin: 15px 0; }
        .progress-fill { height: 100%; transition: 1s ease; background: #28a745; }
        .rejected-bar { background: #dc3545 !important; width: 100% !important; }
        .bio-footer { margin-top: 60px; padding: 40px; background: rgba(0,0,0,0.85); border-radius: 25px; border: 1px solid #D4AF37; }
        .metric-card { background: #001f3f; color: #D4AF37; border-radius: 20px; padding: 20px; text-align: center; border: 1px solid rgba(212, 175, 55, 0.3); }
        
        .intelligence-hub { background: rgba(0,0,0,0.4); backdrop-filter: blur(10px); border-radius: 25px; padding: 30px; border: 1px solid rgba(255,255,255,0.1); margin-top: 30px; }
        .activity-feed { max-height: 300px; overflow-y: auto; }
        .feed-item { border-left: 3px solid #D4AF37; padding-left: 15px; margin-bottom: 20px; position: relative; }
        .feed-item::before { content: ''; position: absolute; left: -8px; top: 0; width: 13px; height: 13px; background: #D4AF37; border-radius: 50%; }
    </style>
</head>
<body>

<?php if($is_logged_in): ?>
    <div class="saas-sidebar">
        <h3 class="fw-bold text-white mb-1">SCRATCH®</h3>
        <p class="text-warning small fw-bold">User: <?php echo $_SESSION['name']; ?></p>
        <hr class="text-white opacity-25">
        <a href="index.php" class="text-white d-block mb-3 text-decoration-none fw-bold"><i class="bi bi-columns-gap me-2"></i> Dashboard</a>
        <?php if($role == 'Candidate'): ?> 
            <a href="browse_jobs.php" class="text-primary d-block mb-3 text-decoration-none fw-bold"><i class="bi bi-search me-2"></i> Find Openings</a> 
        <?php endif; ?>
        <a href="logic.php?act=logout" class="text-danger small fw-bold d-block mt-5 text-decoration-none"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>
<?php endif; ?>

<div class="main-content">
    <?php if(!$is_logged_in): ?>
        <nav class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold text-white m-0">SCRATCH GROUP</h2>
            <a href="login.php" class="btn-gold shadow">ACCESS PORTAL</a>
        </nav>
        <div class="text-center py-5">
            <h1 class="display-3 fw-bold">GLOBAL RECRUITMENT HUB</h1>
            <p class="lead opacity-75">Scratch Group of Companies: Connecting elite talent with industry leadership.</p>
            <form action="index.php" method="GET" class="mt-4 mx-auto" style="max-width:600px">
                <input type="text" name="search" class="form-control rounded-pill p-3 border-0 shadow" placeholder="Search 75+ Career Paths..." value="<?php echo htmlspecialchars($search); ?>">
            </form>
        </div>
        <div class="row g-4 mt-5">
            <?php while($j = mysqli_fetch_assoc($jobs)): ?>
            <div class="col-md-4">
                <div class="glass-card h-100">
                    <span class="badge bg-dark rounded-pill mb-2"><?php echo $j['category']; ?></span>
                    <h5 class="fw-bold"><?php echo $j['title']; ?></h5>
                    <p class="small text-muted"><?php echo $j['description']; ?></p>
                    <a href="login.php" class="btn btn-dark btn-sm rounded-pill px-4">Begin Application</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

    <?php elseif($role == 'HR'): ?>
        <h2 class="fw-bold mb-4">RECRUITMENT COMMAND CENTER</h2>
        
        <div class="row g-4 mb-5">
            <div class="col-md-3"><div class="metric-card shadow"><h6>TOTAL APPLICANTS</h6><h2 class="fw-bold"><?php echo $total_applicants; ?></h2></div></div>
            <div class="col-md-3"><div class="metric-card shadow"><h6>JOB SUBMISSIONS</h6><h2 class="fw-bold"><?php echo $total_apps_submitted; ?></h2></div></div>
            <div class="col-md-3"><div class="metric-card shadow"><h6>COMPANY STAFF</h6><h2 class="fw-bold"><?php echo $total_staff; ?></h2></div></div>
            <div class="col-md-3"><div class="metric-card shadow"><h6>HIRED/ENROLLED</h6><h2 class="fw-bold"><?php echo $hires; ?></h2></div></div>
        </div>

        <div class="row g-4">
            <div class="col-md-8">
                <div class="glass-card mb-4 shadow-lg">
                    <h5 class="fw-bold">Active Recruitment Pipeline</h5>
                    <table class="table small mt-3">
                        <thead><tr><th>Applicant</th><th>Applied Job</th><th>Status</th><th>Update</th></tr></thead>
                        <tbody>
                            <?php 
                            $apps = mysqli_query($conn, "SELECT applications.*, users.fullname, jobs.title as job_title FROM applications JOIN users ON applications.user_id = users.id JOIN jobs ON applications.job_id = jobs.id");
                            while($row = mysqli_fetch_assoc($apps)): ?>
                            <tr>
                                <td><b><?php echo $row['fullname']; ?></b></td>
                                <td><span class="text-primary"><?php echo $row['job_title']; ?></span></td>
                                <td><span class="badge bg-dark rounded-pill"><?php echo $row['status']; ?></span></td>
                                <td>
                                    <form action="logic.php?act=update_flow" method="POST" class="d-flex gap-1">
                                        <input type="hidden" name="aid" value="<?php echo $row['id']; ?>">
                                        <select name="status" class="form-select form-select-sm"><option value="Interview Scheduling">Interview</option><option value="Medical Screening">Medicals</option><option value="Enrolled">Enroll</option><option value="Rejected">Reject</option></select>
                                        <input type="datetime-local" name="dt" class="form-control form-control-sm">
                                        <button class="btn btn-sm btn-dark">✓</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="intelligence-hub">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="fw-bold text-warning mb-4"><i class="bi bi-broadcast me-2"></i> Recent Activity Feed</h5>
                            <div class="activity-feed">
                                <div class="feed-item"><small class="text-white-50">Just now</small><p class="small mb-0">System verified a new CV submission.</p></div>
                                <div class="feed-item"><small class="text-white-50">1 hour ago</small><p class="small mb-0">Workflow updated for 12 candidates.</p></div>
                                <div class="feed-item" style="border-left-color: rgba(255,255,255,0.2);"><small class="text-white-50">2 hours ago</small><p class="small mb-0">Manual enrollment active.</p></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold text-warning mb-4"><i class="bi bi-calendar3 me-2"></i> Upcoming Interviews</h5>
                            <div class="glass-card p-3" style="background: rgba(255,255,255,0.05); color: #fff;">
                                <div class="d-flex justify-content-between mb-2"><span class="small fw-bold">Tomorrow, 10:00 AM</span><span class="badge bg-warning text-dark">Management</span></div>
                                <div class="d-flex justify-content-between"><span class="small fw-bold">Wed, 02:00 PM</span><span class="badge bg-info text-dark">Technical</span></div>
                                <hr class="opacity-25">
                                <button class="btn btn-sm btn-outline-warning w-100 rounded-pill">Open Calendar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- THE TOTAL MIX CARD HAS BEEN REMOVED FROM HERE -->
                <div class="glass-card bg-light mb-3">
                    <h6>Manual Enrollment</h6>
                    <form action="logic.php?act=add_staff" method="POST">
                        <input name="n" placeholder="Full Name" class="form-control mb-2" required>
                        <input name="e" placeholder="Email" class="form-control mb-2" required>
                        <select name="r" class="form-select mb-3"><option value="Employee">Staff</option><option value="Candidate">Candidate</option></select>
                        <button class="btn btn-dark w-100 rounded-pill">Enroll Member</button>
                    </form>
                </div>
                <div class="glass-card">
                    <h6>New Job Posting</h6>
                    <form action="logic.php?act=post_job" method="POST">
                        <input name="t" placeholder="Job Title" class="form-control mb-2" required>
                        <input name="c" placeholder="Category" class="form-control mb-2" required>
                        <textarea name="d" class="form-control mb-2" placeholder="Description"></textarea>
                        <button class="btn btn-dark w-100 rounded-pill">Publish Vacancy</button>
                    </form>
                </div>
            </div>
        </div>

    <?php elseif($role == 'Candidate'): ?>
        <h2 class="fw-bold mb-4">MY APPLICATION TRACKER</h2>
        <?php 
        $uid = $_SESSION['user_id'];
        $app_res = mysqli_query($conn, "SELECT applications.*, jobs.title as job_title FROM applications JOIN jobs ON applications.job_id = jobs.id WHERE user_id=$uid ORDER BY id DESC LIMIT 1");
        $app = mysqli_fetch_assoc($app_res);
        $st = $app['status'] ?? 'No application yet';
        $steps = ['Received'=>10,'Verification'=>20,'Shortlist'=>30,'Interview Scheduling'=>45,'Medical Screening'=>65,'Orientation'=>80,'Onboarding'=>90,'Enrolled'=>100];
        ?>
        <div class="glass-card p-5 mb-4 text-center">
            <h5 class="text-muted text-uppercase small fw-bold">Application for:</h5>
            <h2 class="fw-bold text-primary mb-4"><?php echo $app['job_title'] ?? 'N/A'; ?></h2>
            <div class="progress-container"><div class="progress-fill <?php echo ($st=='Rejected'?'rejected-bar':''); ?>" style="width:<?php echo $steps[$st] ?? 0; ?>%"></div></div>
            <p class="mt-3 fw-bold">Status: <span class="text-primary"><?php echo strtoupper($st); ?></span></p>
            <?php if(($st == 'Interview Scheduling' || $st == 'Medical Screening') && $app['appointment_status'] == 'Pending'): ?>
                <div class="alert alert-warning mt-4 p-4 rounded-4 text-dark">
                    <h6>Appointment Invitation: <b><?php echo $app['interview_date'] ?? $app['medical_date']; ?></b></h6>
                    <a href="logic.php?act=respond&res=accept&id=<?php echo $app['id']; ?>" class="btn btn-success rounded-pill px-4 me-2">Confirm</a>
                    <a href="logic.php?act=respond&res=reject&id=<?php echo $app['id']; ?>" class="btn btn-danger rounded-pill px-4">Reject</a>
                </div>
            <?php endif; ?>
        </div>
        <a href="browse_jobs.php" class="btn-gold d-inline-block">FIND MORE OPPORTUNITIES</a>

    <?php elseif($role == 'Employee'): ?>
        <h2 class="fw-bold mb-4">STAFF PORTAL</h2>
        <div class="glass-card p-5">
            <?php if($_SESSION['pw_changed'] == 0): ?>
                <h4 class="text-danger">Setup Password</h4>
                <form action="logic.php?act=change_pw" method="POST" class="mt-3" style="max-width:400px">
                    <input type="password" name="np" class="form-control mb-3" placeholder="New Password" required>
                    <button class="btn btn-dark w-100 rounded-pill">Update</button>
                </form>
            <?php else: ?>
                <h3>Welcome, <?php echo $_SESSION['name']; ?></h3>
                <p>Accessing Scratch Group internal network.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="bio-footer">
        <div class="row">
            <div class="col-md-8">
                <h4 class="text-warning fw-bold">Company Bio</h4>
                <p class="opacity-75">Scratch Group of Companies is dedicated to building elite teams through fair, modern, and transparent recruitment. We connect the world's best talent with industrial opportunities globally.</p>
                <div class="mt-3 fs-4">
                    <a href="https://instagram.com/eugene__scratch" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                    <a href="https://github.com/Eugene-Adomako" class="text-white me-3"><i class="bi bi-github"></i></a>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <p>adomakoeugene15@gmail.com<br>+233 54 800 0931</p>
                <p class="small opacity-50 mt-5">© 2026 Scratch Group. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>