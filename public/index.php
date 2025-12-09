<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Chatbox DVKT</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="container mt-4">

    <div class="card shadow chat-card">

        <div class="card-header bg-primary text-white text-center">
            Chatbot Tra Cứu DVKT
        </div>

        <div id="chat-box" class="card-body chat-box"></div>

        <div class="card-footer">
            <div class="input-group">

                <input id="user-input" type="text" 
                       class="form-control"
                       placeholder="Nhập câu hỏi... (Enter để gửi)">

                <div class="input-group-append">
                    <button class="btn btn-primary" onclick="sendMessage()">Gửi</button>
                </div>

            </div>
        </div>

    </div>

</div>

<script src="assets/js/chat.js"></script>

</body>
</html>
