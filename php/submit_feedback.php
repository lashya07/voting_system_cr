<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "vote");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get input from form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $feedback = trim($_POST['feedback']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($feedback)) {
        die("Error: Please fill out all fields.");
    }

    // Insert feedback into the database
    $sql = "INSERT INTO feedback (name, email, feedback) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $feedback);

    if ($stmt->execute()) {
        // Redirect to a thank you page or display a success message
        header("Location: ../htmll/feedthank.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>