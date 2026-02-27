<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>GameMatcher</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/landing.css">
    <link rel="stylesheet" href="assets/css/bot.css">
</head>

<body>

    <div class="desktop-only home-layout">
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
                    <a href="index.php?controller=User&action=mostrarAuth" class="btn-join">Únete A Nosotros!!</a>
                </div>
            </div>
        </section>
        <?php include_once("footer_desktop.php"); ?>
    </div>

    <div class="mobile-only mobile-body">
        <header class="mobile-header">
            <div class="logo-container">
                <img src="assets/img/logo.png" alt="Logo">
            </div>
            <div class="header-buttons">
                <a href="index.php?controller=Foro&action=listar" class="btn-small"><i class="fas fa-comments"></i> FOROS</a>
                <a href="index.php?controller=Games&action=catalogo" class="btn-small"><i class="fas fa-gamepad"></i> CATÁLOGO</a>
            </div>
        </header>

        <main>
            <section class="intro-text">
                <h1>Encuentra tu próximo juego perfecto</h1>
                <p class="italic">¿No sabes a qué jugar o buscas el <strong>videojuego perfecto</strong> para ti?</p>
                <p>En <strong>GameMatcher</strong> descubrirás miles de videojuegos con información detalladafiltrados según tus gustos y necesidades. Explora nuevos mundos, compara características y decide con criterio gracias a las valoraciones reales de la comunidad gamer.</p>
                <p>Únete a otros jugadores, comparte tu opinión y encuentra tu próxima gran aventura.</p>
            </section>
            <div class="action-container">
                <a href="index.php?controller=User&action=mostrarAuth" class="btn-join-mobile">Únete A Nosotros!!</a>
            </div>
        </main>
        <?php include_once("footer_mobile.php"); ?>
    </div>
    <script src="assets/js/bot.js"></script>
</body>

</html>