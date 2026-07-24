<?php
include('db.php');
session_start();
if(isset($_POST['submit_update'])){
    $aid = $_POST['app_id']; $st = $_POST['status']; $dt = $_POST['int_date'];
    if($st == 'Interview Scheduling') {
        mysqli_query($conn, "UPDATE applications SET status='$st', interview_date='$dt', interview_status='Pending' WHERE id=$aid");
    } else { mysqli_query($conn, "UPDATE applications SET status='$st' WHERE id=$aid"); }
}
if(isset($_POST['add_staff'])){
    $n = $_POST['name']; $e = $_POST['email']; $r = $_POST['role_select'];
    mysqli_query($conn, "INSERT INTO users (fullname, email, password, role, password_changed) VALUES ('$n', '$e', 'Scratch2026', '$r', 0)");
}
if(isset($_POST['post_job'])){
    $t = $_POST['title']; $d = $_POST['desc'];
    mysqli_query($conn, "INSERT INTO jobs (title, description) VALUES ('$t', '$d')");
}
header("Location: index.php");
?>