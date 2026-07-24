<?php
include('db.php');
session_start();
$action = $_GET['action']; $aid = $_GET['id'];
if($action == 'accept'){
    mysqli_query($conn, "UPDATE applications SET interview_status='Confirmed', status='Conduct Interview' WHERE id=$aid");
    echo "<script>alert('Interview Confirmed'); window.location='index.php';</script>";
} else {
    mysqli_query($conn, "UPDATE applications SET status='Rejected' WHERE id=$aid");
    echo "<script>alert('Application Forfeited'); window.location='index.php';</script>";
}
?>