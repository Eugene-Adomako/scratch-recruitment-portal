<?php
include('db.php');
if(isset($_POST['alert_email'])){
    $email = $_POST['alert_email'];
    $cat = $_POST['category'];
    
    $query = "INSERT INTO job_alerts (email, category) VALUES ('$email', '$cat')";
    mysqli_query($conn, $query);
    
    echo "<script>alert('Success! You will receive alerts for $cat roles.'); window.location='index.php';</script>";
}
?>