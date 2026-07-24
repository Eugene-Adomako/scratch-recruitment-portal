<?php
session_start();
include('db.php');

if(isset($_FILES['cv_file'])){
    $file = $_FILES['cv_file'];
    $jid = $_POST['job_id'];
    $uid = $_SESSION['user_id'];

    if($file['size'] > 5 * 1024 * 1024){
        echo "<script>alert('Error: File over 5MB'); window.location='index.php';</script>";
    } else {
        $path = "uploads/" . time() . "_" . $file['name'];
        move_uploaded_file($file['tmp_name'], $path);
        
        mysqli_query($conn, "INSERT INTO applications (job_id, user_id, cv_path) VALUES ($jid, $uid, '$path')");
        echo "<script>alert('CV Uploaded Successfully!'); window.location='index.php';</script>";
    }
}
?>