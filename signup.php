<?php include('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&q=80&w=1600') fixed center/cover; height: 100vh; display: flex; align-items: center; justify-content: center; }</style>
</head>
<body>
    <div class="bg-white p-5 rounded-4 shadow" style="max-width:400px">
        <h3 class="text-center fw-bold">REGISTER</h3>
        <form method="POST">
            <input name="n" class="form-control mb-3" placeholder="Full Name" required>
            <input name="e" class="form-control mb-3" placeholder="Email" required>
            <input type="password" name="p" class="form-control mb-3" placeholder="Password" required>
            <button name="reg" class="btn btn-dark w-100 rounded-pill">JOIN NOW</button>
            <a href="login.php" class="d-block mt-3 text-center text-dark small fw-bold">Login</a>
        </form>
    </div>
    <?php if(isset($_POST['reg'])){ mysqli_query($conn, "INSERT INTO users (fullname, email, password, role, password_changed) VALUES ('".$_POST['n']."', '".$_POST['e']."', '".$_POST['p']."', 'Candidate', 1)"); header("Location: login.php"); } ?>
</body>
</html>