<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer

$conn = new mysqli("localhost", "root", "", "vote");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Kolkata'); 

if (!isset($_POST['email'])) {
    die("Error: Email not provided.");
}

$email = trim($_POST['email']);
$new_otp = rand(100000, 999999);
$expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

// Store OTP in the database
$sql = "INSERT INTO otps (email, otp_code, expiry) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE otp_code = VALUES(otp_code), expiry = VALUES(expiry)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $email, $new_otp, $expiry);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Send OTP via email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'pawankothavala78423@gmail.com'; // Your email
        $mail->Password = 'cysvvecwivdgpygb'; // Your email password (or App Password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your_email@gmail.com', 'Voting System');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Voting';
        $mail->Body = "Your OTP is: <b>$new_otp</b>. It is valid for 5 minutes.";

        $mail->send();
        echo "<script>alert('New OTP sent to your email!'); window.location.href='../php/verify_otp.php?email=$email';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to send OTP via email. Error: " . $mail->ErrorInfo . "'); window.location.href='../php/verify_otp.php?email=$email';</script>";
    }
} else {
    echo "<script>alert('Failed to generate new OTP!'); window.location.href='../php/verify_otp.php?email=$email';</script>";
}

$conn->close();
?>
