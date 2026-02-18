<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameMatcher - Home</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/bot.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header class="main-header">
        <div class="logo">
            <img src="assets/img/logo.png" alt="GameMatcher Logo">
            <h1>Game<span>Matcher</span></h1>
        </div>
        <nav class="nav-menu">
            <a href="index.php?controller=Foro&action=listar" class="btn-nav"><i class="fas fa-comments"></i> FOROS</a>
            <a href="index.php?controller=Games&action=catalogo" class="btn-nav"><i class="fas fa-gamepad"></i> CATÁLOGO</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h2>Encuentra tu próximo <br> juego perfecto</h2>
            <p>¿No sabes a qué jugar o buscas el videojuego perfecto para ti?</p>
            <p class="hero-description">
                En GameMatcher descubrirás miles de videojuegos con información detallada, filtrados según tus gustos y necesidades...
            </p>
            <a href="index.php?controller=User&action=register" class="btn-primary">¡Únete Ya!!</a>
        </div>
        
        <aside class="ads-container">
            <h3>Anuncios/Novedades</h3>
            <div id="ads-list">
                <div class="ad-item">
                    <img src="assets/img/news1.jpg" alt="Novedades">
                    <p>Gran Turismo 7 recibe nuevos vehículos y circuitos en su última actualización...</p>
                </div>
            </div>
        </aside>
    </section>

    <section class="top-games">
        <h3>Mejores juegos último mes</h3>
        <div class="carousel-container">
            <button class="carousel-control prev"><i class="fas fa-chevron-left"></i></button>
            
            <div class="carousel-track" id="games-carousel">
                <div class="loading text-white">Cargando mejores juegos...</div>
            </div>
            
            <button class="carousel-control next"><i class="fas fa-chevron-right"></i></button>
        </div>
    </section>

    <div id="chat-bubble">
        <img src="assets/img/robot-vectorial-graident-ai.png" alt="Botti">
    </div>

    <div id="chat-window" class="chat-hidden">
        <div class="chat-header">
            <span>BOTTI</span>
            <div class="header-actions">
                <span id="chat-minimize" style="cursor:pointer; margin-right: 15px;">−</span>
                <span id="chat-close" title="Reiniciar chat">✖</span>
            </div>
        </div>
        <div id="chat-messages" class="chat-messages"></div>
        <div class="chat-input-container">
            <input type="text" id="chat-input" placeholder="Pregúntame algo...">
            <button id="chat-send">Enviar</button>
        </div>
    </div>

    <footer class="main-footer">
        <div class="footer-links">
            <a href="index.php?controller=Main&action=about">Sobre nosotros</a>
            <a href="index.php?controller=Main&action=privacy">Política de privacidad</a>
            <a href="index.php?controller=Main&action=cookies">Política de cookies</a>
        </div>
        <div class="social-icons">
            <i class="fab fa-x-twitter"></i>
            <i class="fab fa-instagram"></i>
            <i class="fab fa-facebook"></i>
        </div>
        <p class="copyright">2026 © Rubén Otero Gzl</p>
    </footer>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/bot.js"></script>
</body>
</html>