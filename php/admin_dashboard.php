<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    die("Access denied. Please <a href='admin_login.html'>login</a> as admin.");
}

// Database connection
$conn = new mysqli("localhost", "root", "", "vote");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total votes
$totalVotesQuery = "SELECT COUNT(*) AS total_votes FROM votes";
$totalVotesResult = $conn->query($totalVotesQuery);
$totalVotesRow = $totalVotesResult->fetch_assoc();
$totalVotes = $totalVotesRow['total_votes'] ?? 0;

// Fetch vote details
$voteDetailsQuery = "SELECT students.reg_no, students.name AS student_name, 
                            candidates.name AS candidate_name 
                     FROM votes 
                     JOIN students ON votes.email = students.email 
                     JOIN candidates ON votes.candidate = candidates.roll_number";
$voteDetailsResult = $conn->query($voteDetailsQuery);

// Fetch candidate vote count
$candidateVotesQuery = "SELECT candidates.name, COUNT(votes.candidate) AS vote_count 
                        FROM candidates 
                        LEFT JOIN votes ON candidates.roll_number = votes.candidate 
                        GROUP BY candidates.name";
$candidateVotesResult = $conn->query($candidateVotesQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="../images/online-voting.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #eaeaea;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            
        }

   

        /* Container */
        .container {
   
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            height:760px;
            width: 90%;
            max-width: 1200px;
            margin-top: 100px;
            animation: float 5s infinite ease-in-out;
            position: relative;
            bottom:30px;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        h2, h3 {
            color: cyan;
            text-shadow: 0 0 10px cyan;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 10px;
            text-align: left;
        }

        th {
            background: rgba(15, 52, 96, 0.9);
            color: #eaeaea;
        }

        td {
            background: rgba(255, 255, 255, 0.1);
            color: #eaeaea;
        }

        .btn {
            background: #0f3460;
            color: #eaeaea;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px;
        }

        .btn:hover {
            background: #1a1a2e;
            box-shadow: 0 0 10px cyan;
        }

        .logout-btn {
            background: #ff4d4d;
        }

        .logout-btn:hover {
            background: #cc0000;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2, h3 {
                font-size: 24px;
            }

            table, th, td {
                font-size: 14px;
            }

            .btn {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }

            h2, h3 {
                font-size: 20px;
            }

            table, th, td {
                font-size: 12px;
            }

            .btn {
                font-size: 12px;
            }
        }
        /* Navigation Bar */
nav {
    width: 100%;
    position: fixed;
    top: 0;
    background-color: #1a1a2e; /* Dark blue color */
    box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 8%;
    z-index: 1000;
}

nav .logo {
    width: 60px;
    border-radius: 35px;
    position: relative;
    right: 35px;
}

nav ul li {
    list-style: none;
    display: inline-block;
    margin-left: 40px;
}

.navbar {
    display: flex;
    margin-right: 4vh;
}

.navbar a {
    color: #eaeaea; /* Light gray text */
    font-size: 18px;
    padding: 10px 22px;
    border-radius: 4px;
    font-weight: 500;
    text-decoration: none;
    transition: ease 0.40s;
}

.navbar a:hover,
.navbar a.active {
    background: #0f3460; /* Darker blue for hover */
    color: #ffffff; /* White text on hover */
    box-shadow: 5px 10px 30px rgba(0, 0, 0, 0.2);
    border-radius: 50px;
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

    <!-- Dashboard Content -->
    <div class="container">
        <center><h2>Admin Dashboard</h2></center>
        <h3>Total Votes Cast: <?php echo $totalVotes; ?></h3>

        <h3>Votes by Students</h3>
        <table>
            <tr>
                <th>Student Reg. No</th>
                <th>Student Name</th>
                <th>Voted Candidate</th>
            </tr>
            <?php while ($row = $voteDetailsResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['reg_no']; ?></td>
                    <td><?php echo $row['student_name']; ?></td>
                    <td><?php echo $row['candidate_name']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <h3>Candidate Votes</h3>
        <table>
            <tr>
                <th>Candidate Name</th>
                <th>Votes Received</th>
            </tr>
            <?php while ($row = $candidateVotesResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['vote_count']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <a href="../php/reset_votes.php"><button class="btn">Reset Voting</button></a>
        <a href="../php/logout.php"><button class="btn logout-btn">Logout</button></a>
    </div>
</body>
</html>

<?php $conn->close(); ?>