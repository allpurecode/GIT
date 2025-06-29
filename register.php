<?php
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];

    if ($password !== $confirm) {
        $message = "❌ Passwords do not match!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $message = "⚠️ Username already taken!";
        } else {
            $hashed = hash('sha256', $password);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hashed])) {
                $message = "✅ Registration successful! You can now <a href='login.php'>log in</a>.";
            } else {
                $message = "❌ Error creating user.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .login-container {
            background: white;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }
 
        .login-container h2 {
            margin-bottom: 25px;
            color:  #e75480;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0 20px;
            border: 1.5px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #e75480;
            box-shadow: 0 0 8px rgba(231, 84, 128, 0.3);
        }

        button {
            background: #e75480;
            border: none;
            color: white;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background: #c0416d;
        }

        p.error {
            margin-top: 20px;
            color: #c62828;
            font-weight: 500;
        }

        p.error a {
            color: #e75480;
            text-decoration: none;
            font-weight: 600;
        }

        p.error a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Create Account</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Choose username" required><br/>
        <input type="password" name="password" placeholder="Choose password" required><br/>
        <input type="password" name="confirm" placeholder="Confirm password" required><br/>
        <button type="submit">Register</button>
    </form>
    <?php if ($message): ?>
        <p class="error"><?= $message ?></p>
    <?php endif; ?>
</div>
</body>
</html>
