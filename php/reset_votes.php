<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    die("Access denied.");
}

$conn = new mysqli("localhost", "root", "", "vote");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete all votes but keep students and candidates
$conn->query("DELETE FROM votes");

$conn->close();
header("Location: ../php/admin_dashboard.php");
exit();
?>
