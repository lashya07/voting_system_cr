<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

// Database connection
$conn = new mysqli("localhost", "root", "", "vote");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if inputs are set and not empty
    if (empty($_POST['reg_no']) || empty($_POST['email'])) {
        $error_message = "Please enter registration number and email.";
        header("Location: login.html?error=" . urlencode($error_message));
        exit();
    }

    $reg_no = trim($_POST['reg_no']);
    $email = trim($_POST['email']);

    // Check if the student exists
    $sql = "SELECT * FROM students WHERE reg_no = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $reg_no, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Student exists, generate OTP
        $otp = rand(100000, 999999);
        date_default_timezone_set('Asia/Kolkata'); // Set PHP timezone
        $conn->query("SET time_zone = '+05:30'"); // Set MySQL timezone
        
        $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        // Store OTP in the database
        $sql = "INSERT INTO otps (email, otp_code, expiry) VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE otp_code=?, expiry=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $email, $otp, $expiry, $otp, $expiry);
        $stmt->execute();

        // Send OTP via email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'pawankothavala78423@gmail.com'; // Change this
            $mail->Password = 'cysvvecwivdgpygb'; // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('votingsystem@gmail.com', 'Voting System');
            $mail->addAddress($email);
            $mail->Subject = 'Your OTP for Voting Verification';
            $mail->Body = "Hello,\n\nYour OTP for login verification is: $otp\n\nThis OTP is valid for 5 minutes.";

            $mail->send();

            // Redirect to OTP entry page
            header("Location: verify_otp.php?email=" . urlencode($email));
            exit();

        } catch (Exception $e) {
            echo "Error: OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Redirect to error page with a message
        $error_message = "Invalid registration number or email. Please try again.";
    header("Location: ../php/error_page.php?message=" . urlencode($error_message));
    exit();
    }
}

$conn->close();
?>
