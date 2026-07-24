<?php
session_start();
include('db.php');
$e = mysqli_real_escape_string($conn, $_POST['email']);
$p = $_POST['password'];
$r = $_POST['role_select'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE email='$e' AND password='$p' AND role='$r'");
$user = mysqli_fetch_assoc($res);
if($user){
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['name'] = $user['fullname'];
    $_SESSION['pw_changed'] = $user['password_changed'];
    header("Location: index.php");
} else { echo "<script>alert('Incorrect Credentials'); window.location='login.php';</script>"; }
?>