<?php
session_start();
include('db.php');
$act = $_GET['act'] ?? '';

if($act == 'login'){
    $e = $_POST['e']; $p = $_POST['p']; $r = $_POST['role'];
    $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$e' AND password='$p' AND role='$r'");
    $u = mysqli_fetch_assoc($res);
    if($u){ 
        $_SESSION['user_id']=$u['id']; $_SESSION['role']=$u['role']; $_SESSION['name']=$u['fullname']; $_SESSION['pw_changed']=$u['password_changed'];
        header("Location: index.php"); 
    } else { echo "<script>alert('Incorrect Role or Credentials'); window.location='login.php';</script>"; }
}

if($act == 'update_flow'){
    $aid = $_POST['aid']; $st = $_POST['status']; $dt = $_POST['dt'];
    if($st == 'Interview Scheduling') mysqli_query($conn, "UPDATE applications SET status='$st', interview_date='$dt', appointment_status='Pending' WHERE id=$aid");
    elseif($st == 'Medical Screening') mysqli_query($conn, "UPDATE applications SET status='$st', medical_date='$dt', appointment_status='Pending' WHERE id=$aid");
    else mysqli_query($conn, "UPDATE applications SET status='$st' WHERE id=$aid");
    header("Location: index.php");
}

if($act == 'candidate_respond'){
    $res = $_GET['res']; $id = $_GET['id'];
    if($res == 'accept') mysqli_query($conn, "UPDATE applications SET appointment_status='Confirmed' WHERE id=$id");
    else mysqli_query($conn, "UPDATE applications SET status='Rejected' WHERE id=$id");
    header("Location: index.php");
}

if($act == 'add_staff'){
    mysqli_query($conn, "INSERT INTO users (fullname, email, password, role, password_changed) VALUES ('".$_POST['n']."', '".$_POST['e']."', 'Scratch2026', '".$_POST['r']."', 0)");
    header("Location: index.php");
}

if($act == 'post_job'){
    mysqli_query($conn, "INSERT INTO jobs (title, category, description) VALUES ('".$_POST['t']."', '".$_POST['c']."', '".$_POST['d']."')");
    header("Location: index.php");
}

if($act == 'change_pw'){
    mysqli_query($conn, "UPDATE users SET password='".$_POST['np']."', password_changed=1 WHERE id=".$_SESSION['user_id']);
    $_SESSION['pw_changed'] = 1; header("Location: index.php");
}

if($act == 'logout'){ session_destroy(); header("Location: index.php"); }
?>