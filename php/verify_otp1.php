<?php
session_start();
$conn = new mysqli("localhost", "root", "", "vote");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Kolkata'); 
$conn->query("SET time_zone = '+05:30'");

if (!isset($_POST['email']) || !isset($_POST['otp'])) {
    die("Error: Please enter OTP.");
}

$email = trim($_POST['email']);
$otp = trim($_POST['otp']);

$sql = "SELECT * FROM otps WHERE email = ? AND TRIM(otp_code) = ? AND expiry > NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $otp);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['email'] = $email; 
    header("Location: ../php/vote.php");
    exit();
} else {
    echo "<script>alert('Invalid or Expired OTP! Try Again.'); window.location.href='../php/verify_otp.php?email=$email';</script>";
}

$conn->close();
?>
