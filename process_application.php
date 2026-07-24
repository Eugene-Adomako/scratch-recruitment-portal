<?php
session_start();
include('db.php');

if (isset($_POST['submit_credentials'])) {
    $uid = $_SESSION['user_id'];
    $jid = $_POST['job_id'];
    $phone = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $exp = mysqli_real_escape_string($conn, $_POST['experience_years']);
    $why = mysqli_real_escape_string($conn, $_POST['why_applying']);
    
    // Create folder if missing
    if (!is_dir('uploads')) { mkdir('uploads', 0777, true); }

    $file_name = time() . "_" . basename($_FILES["cv_file"]["name"]);
    $target_file = "uploads/" . $file_name;

    // Check File Extension
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if($fileType != "pdf") {
        echo "<script>alert('Only PDF files are allowed.'); window.history.back();</script>";
        exit();
    }

    if (move_uploaded_file($_FILES["cv_file"]["tmp_name"], $target_file)) {
        // SQL query matching your ALTER TABLE columns
        $sql = "INSERT INTO applications (job_id, user_id, cv_path, why_applying, experience_years, phone_number, status) 
                VALUES ($jid, $uid, '$target_file', '$why', $exp, '$phone', 'Received')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Application Enrolled Successfully. Track your progress on the dashboard.'); window.location='index.php';</script>";
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Upload Failed. Check folder permissions.'); window.history.back();</script>";
    }
}
?>