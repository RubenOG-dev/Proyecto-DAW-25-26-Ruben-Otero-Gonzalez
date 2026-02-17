<!DOCTYPE html>
<html lang="gl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameMatcher - Home</title>
    <link rel="stylesheet" href="assets/css/bot.css"> 
</head>
<body>

    <h1>🚀 GameMatcher Online!</h1>
    <p>O subdominio <strong>campechano.rial.com.es</strong> xa está operativo.</p>
    <p>Data actual: <?php echo date("d/m/Y H:i:s"); ?></p>

    <div id="chat-bubble">💬</div>

    <div id="chat-window" class="chat-hidden">
        <div class="chat-header">
            <span>🎮 GameMatcher Bot</span>
            <span id="chat-close">✖</span>
        </div>
        <div id="chat-messages" class="chat-messages">
            </div>
        <div class="chat-input-container">
            <input type="text" id="chat-input" placeholder="Pregúntame algo...">
            <button id="chat-send">Enviar</button>
        </div>
    </div>

    <script src="assets/js/bot.js"></script>
</body>
</html>