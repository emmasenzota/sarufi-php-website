<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yakwetu Cultures</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 20px;
        }

        .chat-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .chat-header {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .chat-body {
            padding: 10px;
            height: 400px;
            overflow-y: scroll;
        }

        .chat-message {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .user-message {
            background-color: #DCF8C6;
            align-self: flex-end;
        }

        .bot-message {
            background-color: #D5E8FF;
            align-self: flex-start;
        }

        .chat-input {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #ccc;
        }

        .user-input {
            flex: 1;
            padding: 5px;
            border: none;
            border-radius: 5px;
        }

        .send-btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>Yakwetu Chatbot</h2>
        </div>
        <div class="chat-body" id="chatBody">
            <!-- Chat messages will be displayed here -->
        </div>
        <div class="chat-input">
            <input type="text" id="userQuery" class="user-input" placeholder="Type your message...">
            <button onclick="sendMessage()" class="send-btn">Send</button>
        </div>
    </div>

    <script>

    async  function sendMessage() {
                const userQuery = document.getElementById('userQuery').value;
                const chatBody = document.getElementById('chatBody');

                if (userQuery.trim() !== '') {
                    const userMessage = document.createElement('div');
                    userMessage.className = 'chat-message user-message';
                    userMessage.textContent = userQuery;

                    chatBody.appendChild(userMessage);

                    // AJAX request to send user query and retrieve chatbot response
                    fetch('http://localhost:8080/chat', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(userQuery),
                    })
                    .then(async (response) => {
                        const res = response.json();
                        const innerPromise = await res.then((data) => data.actions[0].send_message);

                        // Access the array to print reply message from sarufi
                        const send_message = innerPromise;

                        const botMessage = document.createElement('div');
                        botMessage.className = 'chat-message bot-message';
                        botMessage.textContent = send_message[0];

                        chatBody.appendChild(botMessage);
                        
                    })
                    .catch((error) => console.error('Error:', error));
                }
            }

    </script>
</body>
</html>
