<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameMatcher - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main_desktop.css">
    <link rel="stylesheet" href="assets/css/bot.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="home-layout">

    <header class="main-header">
        <div class="logo">
            <img src="assets/img/logo2.png" alt="GameMatcher Logo">
            <h1>Game<span>Matcher</span></h1>
        </div>
        <nav class="nav-menu">
            <a href="index.php?controller=Foro&action=listar" class="btn-header-alt"><i class="fas fa-comments"></i> FOROS</a>
            <a href="index.php?controller=Games&action=catalogo" class="btn-header-alt"><i class="fas fa-gamepad"></i> CATÁLOGO</a>
        </nav>
    </header>

    <section class="hero-section">
        <div class="hero-overlay">
            <div class="hero-content">
                <h2>Encuentra tu próximo <br> juego perfecto</h2>
                <p class="hero-subtitle">¿No sabes a qué jugar o buscas el videojuego perfecto para ti?</p>
                
                <div class="hero-description">
                    <p>En GameMatcher descubrirás miles de videojuegos con información detallada, filtrados según tus gustos y necesidades. Explora nuevos mundos, compara características y decide con criterio gracias a las valoraciones reales de la comunidad gamer.</p>
                    <p>Únete a otros jugadores, comparte tu opinión y encuentra tu próxima gran aventura.</p>
                </div>

                <a href="index.php?controller=User&action=register" class="btn-join">Únete A Nosotros!!</a>
            </div>
        </div>
    </section>

    <!-- <?php include_once("bot.php"); ?> -->
    <div id="chat-bubble">
    <img src="assets/img/robot-vectorial-graident-ai.png" alt="Botti">
</div>

<div id="chat-window" class="chat-hidden">
    <div class="chat-header">
        <span>BOTTI</span>
        <div class="header-actions">
            <span id="chat-minimize">−</span>
            <span id="chat-close">✖</span>
        </div>
    </div>
    <div id="chat-messages" class="chat-messages"></div>
    <div class="chat-input-container">
        <input type="text" id="chat-input" placeholder="Pregúntame algo...">
        <button id="chat-send">ENVIAR</button>
    </div>
</div>

    <?php include_once("footer_desktop.php"); ?>

    <script src="assets/js/main_desktop.js"></script>
    <script src="assets/js/bot.js"></script>
</body>
</html>