<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verift OTP</title>
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
            background-image: url('../images/final.jpeg');
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
            position:relative;
            bottom:-30px;
            left:45px;
            width: 100%;
            max-width: 400px;
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

        input[type="email"],
        input[type="text"] {
            width: 100%;
            margin-bottom: 15px;
            font-size: 15px;
            padding: 10px;
            outline: none;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #f1f1f1; /* Light gray background */
            color: #333; /* Dark text */
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
        }

        button[type="submit"]:hover {
            background: #1a1a2e; /* Darker blue on hover */
            border: 2px solid #0f3460;
            box-shadow: inset 0 1px 2px rgba(27, 27, 27, 0.1);
        }

        .resend {
            background: #ff4d4d; /* Red button for resend */
        }

        .resend:hover {
            background: #cc0000; /* Darker red on hover */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            input[type="email"],
            input[type="text"] {
                font-size: 14px;
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

            input[type="email"],
            input[type="text"] {
                font-size: 12px;
            }

            button[type="submit"] {
                font-size: 14px;
            }
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

<?php
$email = isset($_GET['email']) ? $_GET['email'] : '';
?>

<div class="container">
    <h2>Verify OTP</h2>
    <form action="../php/verify_otp1.php" method="post">
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <button type="submit">Verify OTP</button>
    </form>
    <br>
    <form action="../php/resend_otp.php" method="post">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <button type="submit" class="resend">Resend OTP</button>
    </form>
</div>

</body>
</html>