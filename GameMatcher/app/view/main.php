<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php?controller=User&action=mostrarAuth");
    exit();
}

$nombreUsuario = $_SESSION['nombre'] ?? 'Jugador';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>GameMatcher - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/bot.css">
</head>

<body>

    <div class="desktop-only">
        <header class="main-header">
            <div class="logo">
                <img src="assets/img/logo2.png" alt="GameMatcher Logo">
                <h1>Game<span>Matcher</span></h1>
            </div>
            <nav>
                <span class="user-greeting" style="margin-right: 20px; color: #a685ff; font-weight: bold;">Hola, <?php echo htmlspecialchars($nombreUsuario); ?>!</span>
                <a href="index.php?controller=User&action=logout" class="btn-logout">LOGOUT</a>
            </nav>
        </header>

        <section class="hero-section">
            <div class="hero-overlay">
                <div class="hero-content">
                    <h2>Enhorabuena, <?php echo htmlspecialchars($nombreUsuario); ?>!<br>Ya formas parte de GameMatcher!!</h2>
                    <div class="hero-text">
                        <p>Explora, Compara y Opina. Revisa el catálogo actualizado de videojuegos, filtra según tus preferencias y no olvides pasarte por los foros para ver lo que dice la comunidad.</p>
                        <p class="hero-highlight">Tu criterio ayuda a otros jugadores a decidir mejor.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-container">
            <p class="subtitle">ACCEDE EN NUESTRO CATÁLOGO A INFORMACIÓN DE LOS MEJORES JUEGOS COMO PUEDEN SER LOS SIGUIENTES</p>
            <div class="carousel-wrapper">
                <button class="arrow-btn" id="prevBtn"><i class="fas fa-chevron-left"></i></button>
                <div class="carousel-content" id="games-carousel"></div>
                <button class="arrow-btn" id="nextBtn"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="center-btn">
                <a href="index.php?controller=Games&action=catalogo" class="btn-blue">
                    <i class="fas fa-th-large"></i> CATÁLOGO
                </a>
            </div>
        </section>

        <section class="section-container">
            <p class="subtitle">TAMBIÉN PODRÁS ACCEDER A INNUMERABLES FOROS DE NUESTRA GRAN COMUNIDAD GAMER COMO EL SIGUIENTE</p>
            <div class="forum-preview">
                <div class="forum-header">Foro de Anuncios/Novedades</div>
                <div class="forum-body">
                    <img src="assets/img/forum_preview.png" alt="Foro">
                </div>
            </div>
            <div class="center-btn">
                <a href="index.php?controller=Forums&action=listar" class="btn-blue">
                    <i class="fas fa-comments"></i> FOROS
                </a>
            </div>
        </section>

        <?php include_once("footer_desktop.php"); ?>
    </div>

    <div class="mobile-only">
        <header class="mobile-header">
            <img src="assets/img/logo.png" alt="Logo" class="mob-logo">
            <a href="index.php?controller=User&action=logout" class="btn-logout-mob">LOGOUT</a>
        </header>
        <main class="mobile-main">
            <section class="hero-section">
                <div class="hero-overlay">
                    <div class="hero-content">
                        <h2>Enhorabuena, <?php echo htmlspecialchars($nombreUsuario); ?>!<br>Ya formas parte de GameMatcher!!</h2>
                        <div class="hero-text">
                            <p>Explora, Compara y Opina. Revisa el catálogo actualizado de videojuegos, filtra según tus preferencias y no olvides pasarte por los foros para ver lo que dice la comunidad.</p>
                            <p class="hero-highlight">Tu criterio ayuda a otros jugadores a decidir mejor.</p>
                        </div>
                    </div>
                </div>
            </section>
            <div class="carousel-content-mob" id="games-carousel-mob"></div>
            <div class="mob-actions">
                <a href="index.php?controller=Games&action=catalogo" class="btn-mob">CATÁLOGO</a>
                <a href="index.php?controller=Forums&action=listar" class="btn-mob btn-dark">FOROS</a>
            </div>
        </main>
        <?php include_once("footer_mobile.php"); ?>
    </div>

    <?php include_once("bot.php"); ?>
    <script src="assets/js/bot.js"></script>
    <script src="assets/js/carrusel.js"></script>
</body>

</html>