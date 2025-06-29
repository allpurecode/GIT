<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        /* Page background */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 40px 20px;
        }

        /* Container */
        .welcome-container {
            background: white;
            width: 100%;
            max-width: 600px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            padding: 30px 40px;
            box-sizing: border-box;
        }

        /* Header */
        h2 {
            color: #2575fc;
            margin-bottom: 5px;
            font-weight: 700;
            letter-spacing: 1.2px;
        }

        p {
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 16px;
            color: #555;
        }

        /* Chat box */
        .chat-box {
            border-radius: 12px;
            background: #f9f9f9;
            height: 320px;
            overflow-y: auto;
            padding: 20px;
            border: 1.5px solid #ddd;
            box-sizing: border-box;
            font-size: 15px;
            line-height: 1.5;
            scroll-behavior: smooth;
        }

        /* Chat messages */
        .chat-box div {
            margin-bottom: 12px;
            max-width: 75%;
            padding: 10px 15px;
            border-radius: 18px;
            clear: both;
            word-wrap: break-word;
        }
        .chat-box div b {
            display: block;
            margin-bottom: 4px;
        }

        /* User messages aligned right, blue background */
        .chat-box div.user {
            background: #2575fc;
            color: white;
            float: right;
            border-bottom-right-radius: 4px;
        }

        /* Bot messages aligned left, light gray background */
        .chat-box div.bot {
            background: #e1e1e1;
            color: #333;
            float: left;
            border-bottom-left-radius: 4px;
        }

        /* Input area */
        .chat-input {
            margin-top: 15px;
            display: flex;
            gap: 12px;
        }

        .chat-input input[type="text"] {
            flex-grow: 1;
            padding: 12px 15px;
            border-radius: 25px;
            border: 1.5px solid #ccc;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }
        .chat-input input[type="text"]:focus {
            outline: none;
            border-color: #2575fc;
            box-shadow: 0 0 8px rgba(37, 117, 252, 0.4);
        }

        .chat-input button {
            background-color: #2575fc;
            border: none;
            color: white;
            padding: 0 25px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .chat-input button:hover {
            background-color: #1a54d6;
        }

        /* Logout link */
        a.logout-link {
            display: inline-block;
            margin-top: 25px;
            color: #2575fc;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        a.logout-link:hover {
            text-decoration: underline;
            color: #1a54d6;
        }
    </style>
</head>
<body>
<div class="welcome-container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <p>This is your dashboard. You can chat with the assistant below:</p>

    <div class="chat-box" id="chatBox"></div>

    <div class="chat-input">
        <input type="text" id="userInput" placeholder="Type your message..." autocomplete="off" />
        <button onclick="sendMessage()">Send</button>
    </div>

    <a href="logout.php" class="logout-link">Logout</a>
</div>

<script>
function sendMessage() {
    const input = document.getElementById('userInput');
    const chatBox = document.getElementById('chatBox');
    const message = input.value.trim();
    if (message === '') return;

    // Create user message bubble
    const userMessage = document.createElement('div');
    userMessage.classList.add('user');
    userMessage.innerHTML = "<b>You:</b> " + escapeHtml(message);
    chatBox.appendChild(userMessage);

    // Create bot response bubble
    const botMessage = document.createElement('div');
    botMessage.classList.add('bot');

    let reply = "I'm a simple bot. You said: " + message;
    if (message.toLowerCase().includes("hello")) {
        reply = "Hi there! How can I assist you today?";
    } else if (message.toLowerCase().includes("bye")) {
        reply = "Goodbye! Have a great day.";
    }
    botMessage.innerHTML = "<b>Bot:</b> " + escapeHtml(reply);
    chatBox.appendChild(botMessage);

    input.value = "";
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Simple HTML escape function
function escapeHtml(text) {
    return text.replace(/[&<>"']/g, function(m) {
        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        }[m];
    });
}
</script>
</body>
</html>
