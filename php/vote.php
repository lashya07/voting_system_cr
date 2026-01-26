<?php
session_start();
$conn = new mysqli("localhost", "root", "", "vote");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    die("Error: Unauthorized access.");
}

$email = $_SESSION['email'];

// Fetch candidates from the database
$candidatesQuery = "SELECT roll_number, name FROM candidates";
$candidatesResult = $conn->query($candidatesQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Page</title>
    <link rel="stylesheet" href="../htmll/styles.css">
    <link rel="icon" href="../images/online-voting.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            list-style: none;
            scroll-behavior: smooth;
        }

        /* Body and Background */
        body {
            background-image: url('../images/final.jpeg');/* High-quality voting-themed background */
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Container */
        .container {
            position: relative;
            left:110px;
            bottom:-30px;
            height:450px;
            width: 100%;
            max-width: 500px;
            padding: 30px;
            background: rgba(26, 26, 46, 0.9); /* Semi-transparent dark blue */
            border: 1px solid #eee;
            text-align: center;
            border-radius: 25px;
            box-shadow: 5px 5px 0 #666;
            transition: all 0.3s ease;
            
        }

        .container:hover {
            border-radius: 4px;
            box-shadow: 0px 0px 0 #666;
            background: rgba(15, 52, 96, 0.9); /* Darker blue on hover */
            opacity: 0.9;
        }

        h2 {
            font-size: 30px;
            margin: 20px 0;
            color: #eaeaea; /* Light gray text */
            text-transform: uppercase;
            text-shadow: -2px -2px 30px #cecbcb;
        }

        p {
            font-size: 18px;
            color: #eaeaea; /* Light gray text */
            margin-bottom: 20px;
        }

        .candidate {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1); /* Semi-transparent white background */
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .candidate:hover {
            background: rgba(255, 255, 255, 0.2); /* Slightly darker on hover */
        }

        .candidate input[type="radio"] {
            margin-right: 10px;
        }

        .candidate .name {
            font-size: 18px;
            color: #eaeaea; /* Light gray text */
        }

        button[type="submit"] {
            width: 100%;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            background: #0f3460; /* Dark blue button */
            border: 1px solid #ccc;
            border-radius: 10px;
            color: #ffffff; /* White text */
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background: #1a1a2e; /* Darker blue on hover */
            border: 2px solid #0f3460;
            box-shadow: inset 0 1px 2px rgba(27, 27, 27, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            .candidate .name {
                font-size: 16px;
            }

            button[type="submit"] {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }

            h2 {
                font-size: 20px;
            }

            .candidate .name {
                font-size: 14px;
            }

            button[type="submit"] {
                font-size: 14px;
            }
        }
         .hello{
            height:400px;
            width: 300px;
            border-radius:1000%;
            position: relative;
            bottom:-40px;
            left:-100px;
        } 
        



    </style>
</head>
<body class="feedback-body">
    <nav>
        <img src="../images/gif.gif" class="logo" alt="Logo" title="E-voting">
        <ul class="navbar">
            <li>
            <a href="../htmll/login.html">Home</a>
                <a href="../htmll/admin_login.html">Admin</a>
                <a href="../htmll/feedback.html">Feedback</a>
                <a href="../php/logout.php">Logout</a>
            </li>
        </ul>
    </nav>
  
            <img src="../images/votegif.gif" class="hello" alt="Logo" title="E-voting">  
          
    

    <div class="container">
        <h2>Welcome to the Voting Page</h2>
        <p>Select your candidate below:</p>

        <form action="../php/submit_vote.php" method="POST">
            <input type="hidden" name="email" value="<?php echo $email; ?>">

            <?php
            if ($candidatesResult->num_rows > 0) {
                while ($row = $candidatesResult->fetch_assoc()) {
                    echo '<label class="candidate">';
                    echo '<input type="radio" name="candidate" value="' . $row['roll_number'] . '" required>';
                    echo '<span class="name">' . htmlspecialchars($row['name']) . '</span>';
                    echo '</label>';
                }
            } else {
                echo "<p>No candidates available.</p>";
            }
            ?>

            <button type="submit">Submit Vote</button>
        </form>
    </div>

</body>
</html>

<?php
$conn->close();
?>