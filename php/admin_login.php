<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hardcoded admin credentials
    if ($username === "admin" && $password === "admin123") {
        $_SESSION['admin_logged_in'] = true;
        header("Location: ../php/admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Credentials!'); window.location='../htmll/admin_login.html';</script>";
    }
}
?>
