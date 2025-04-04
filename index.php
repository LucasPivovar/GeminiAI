<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AI ChatBot</title>
	<link rel="stylesheet" type="text/css" href="./style/chatbot.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
</head>
<body>
    <div id="chat-container">
    	<div id="chat-box">
        </div>
    	<div class="input-container">
    		<input type="text" id="user-input"  placeholder="Comece digitando 'Hoje estou...'">
                <button onclick="sendMessage()"><img src="./assets/plane.png" alt="Icone para enviar mensagem" class="btn_enviar"></button>
    	</div>
    </div>
    <script type="text/javascript" src="./scripts/chatbot.js"></script>
</body>
</html>