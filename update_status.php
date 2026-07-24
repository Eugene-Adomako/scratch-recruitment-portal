<?php
include('db.php');
if(isset($_GET['id']) && isset($_GET['status'])){
    $id = $_GET['id']; $status = $_GET['status'];
    mysqli_query($conn, "UPDATE applications SET status='$status' WHERE id=$id");
    echo "<script>alert('Status Updated to $status'); window.location='index.php';</script>";
}
?>