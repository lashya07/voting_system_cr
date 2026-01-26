<?php
session_start();
$conn = new mysqli("localhost", "root", "", "vote");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['email'])) {
    die("Error: Unauthorized access.");
}

$email = $_SESSION['email'];
$candidate = isset($_POST['candidate']) ? $_POST['candidate'] : '';

if (empty($candidate)) {
    die("Error: No candidate selected.");
}

// Debug: Check if connection is working
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Debug: Check if candidate exists in the database
$checkCandidateQuery = "SELECT * FROM candidates WHERE roll_number = ?";
$stmt = $conn->prepare($checkCandidateQuery);
if (!$stmt) {
    die("SQL Error (checkCandidateQuery): " . $conn->error);
}
$stmt->bind_param("s", $candidate);
$stmt->execute();
$candidateResult = $stmt->get_result();
if ($candidateResult->num_rows == 0) {
    die("Error: Candidate does not exist.");
}

// Check if user has already voted
$checkVoteQuery = "SELECT * FROM votes WHERE email = ?";
$stmt = $conn->prepare($checkVoteQuery);
if (!$stmt) {
    die("SQL Error (checkVoteQuery): " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('You have already voted!'); window.location.href='vote.php';</script>";
} else {
    // Insert the vote
    $voteQuery = "INSERT INTO votes (email, candidate)VALUES (?, ?)";
    $stmt = $conn->prepare($voteQuery);

    if (!$stmt) {
        die("SQL Error (voteQuery): " . $conn->error); // Print exact MySQL error
    }

    $stmt->bind_param("ss", $email, $candidate);
    if ($stmt->execute()) {
        echo "<script>alert('Vote successfully submitted!'); window.location.href='../htmll/thank_you.html';</script>";
    } else {
        die("Execution Error: " . $stmt->error); // Print execution error
    }
}

$conn->close();
?>
