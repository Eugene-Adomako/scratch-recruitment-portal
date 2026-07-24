<!DOCTYPE html>
<html>
<head>
    <title>Login | Scratch Group</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=1600') fixed center/cover; height: 100vh; display: flex; align-items: center; justify-content: center; }</style>
</head>
<body>
    <div class="bg-white p-5 rounded-4 shadow text-center" style="max-width:400px; color:#333;">
        <h2 class="fw-bold mb-4">LOGIN</h2>
        <form action="logic.php?act=login" method="POST">
            <select name="role" class="form-select mb-3"><option value="Candidate">Applicant</option><option value="Employee">Staff</option><option value="HR">HR Recruitment</option></select>
            <input type="email" name="e" class="form-control mb-3" placeholder="Email" required>
            <input type="password" name="p" class="form-control mb-4" placeholder="Password" required>
            <button class="btn btn-dark w-100 rounded-pill">ENTER SYSTEM</button>
            <div class="mt-4 d-flex justify-content-between"><a href="index.php" class="text-dark small fw-bold">Home</a><a href="signup.php" class="text-dark small fw-bold">Register</a></div>
        </form>
    </div>
    <div style="position:fixed; bottom:20px; right:20px; background:#fff; padding:15px; border-radius:20px; color:#000; box-shadow:0 10px 30px #000; font-size:13px; border-top:4px solid #D4AF37;"><b>🤖 Support</b><br>Register first if you're an applicant!</div>
</body>
</html>