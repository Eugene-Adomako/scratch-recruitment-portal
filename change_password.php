<?php 
session_start();
include('db.php');
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: #001f3f; color: white; padding: 100px; }</style>
</head>
<body>
    <div class="container bg-dark p-5 rounded">
        <h2>Secure Your Account</h2>
        <form method="POST">
            <input type="password" name="new_pass" class="form-control mb-3" placeholder="Enter New Password" required>
            <button name="change" class="btn btn-warning">Update Password</button>
        </form>
    </div>
    <?php
    if(isset($_POST['change'])){
        $np = $_POST['new_pass']; $uid = $_SESSION['user_id'];
        mysqli_query($conn, "UPDATE users SET password='$np', password_changed=1 WHERE id=$uid");
        $_SESSION['pw_changed'] = 1;
        header("Location: index.php");
    }
    ?>
</body>
</html>