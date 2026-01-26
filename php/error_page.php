<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/online-voting.png">
    <title>Error</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .error-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 90%;
            max-width: 400px;
            animation: float 5s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        h2 {
            color: #ff4d4d; /* Red color for error */
            font-size: 28px;
            margin-bottom: 20px;
            text-shadow: 0 0 10px #ff4d4d;
        }

        p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        a {
            color: cyan;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        // Redirect to login page after 5 seconds
        setTimeout(function() {
            window.location.href = "../htmll/login.html"; // Change to your login page
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
</head>
<body>

<?php
if (isset($_GET['message'])) {
    $error_message = urldecode($_GET['message']);
} else {
    $error_message = "An unknown error occurred.";
}
?>

<div class="error-container">
    <h2>Error</h2>
    <p><?php echo htmlspecialchars($error_message); ?></p>
    <p>You will be redirected to the login page in <span id="countdown">5</span> seconds.</p>
    <p>If you are not redirected, <a href="../htmll/login.html">click here</a>.</p>
</div>

<script>
    // Countdown timer
    let countdown = 5;
    const countdownElement = document.getElementById("countdown");

    setInterval(() => {
        countdown--;
        countdownElement.textContent = countdown;
    }, 1000);
</script>

</body>
</html>