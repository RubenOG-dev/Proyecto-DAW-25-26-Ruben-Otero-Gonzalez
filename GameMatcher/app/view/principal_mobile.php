<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>GameMatcher - Móvil</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/main_mobile.css">
    <link rel="stylesheet" href="/assets/css/bot.css">
</head>

<body class="mobile-body">

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
        <div class="mobile-container animate__animated animate__fadeIn">
            <section class="hero-mobile" style="background-image: linear-gradient(rgba(13,18,34,0.7), rgba(13,18,34,0.9)), url('assets/img/hero-bg-mobile.jpg');">
                <div class="container py-4">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <img src="assets/img/logo.png" alt="Logo" width="120">
                        <a href="index.php?controller=User&action=logout" class="btn btn-sm btn-purple">LOGOUT</a>
                    </div>

                    <div class="hero-text text-white">
                        <h2 class="text-italic h4">Enhorabuena!</h2>
                        <h1 class="text-italic h3">Ya formas parte de GameMatcher!!</h1>

                        <div class="description-box mt-4">
                            <p><em>Explora, Compara y Opina. Revisa el catálogo actualizado de videojuegos, filtra segundo tus preferencias y no olvides pasarte por los foros para ver lo que dice la comunidad.</em></p>
                            <p class="mt-3"><em>Tu criterio ayuda a otros jugadores a decidir mejor.</em></p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="games-mobile py-5">
                <div class="container text-center">
                    <p class="section-label mb-4 text-uppercase">Accede en nuestro catálogo a información de los mejores juegos...</p>

                    <div class="mobile-slider d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-chevron-left slider-arrow"></i>
                        <div class="active-game-mobile">
                            <img src="assets/img/elden_ring.jpg" class="img-fluid rounded shadow-lg" alt="Game">
                        </div>
                        <i class="fas fa-chevron-right slider-arrow"></i>
                    </div>

                    <a href="index.php?controller=Games&action=listar" class="btn btn-purple mt-4">
                        <i class="fas fa-th-large me-2"></i> CATÁLOGO
                    </a>
                </div>
            </section>

            <section class="forum-mobile py-5 bg-darker">
                <div class="container text-center text-white">
                    <p class="section-label mb-4 text-uppercase">También podrás acceder a innumerables foros...</p>

                    <div class="forum-card-mobile mx-auto">
                        <div class="forum-title-bar">Foro de Anuncios/Novedades</div>
                        <div class="forum-preview-img">
                            <img src="assets/img/mockup-foros.png" class="img-fluid" alt="Forum Preview">
                        </div>
                    </div>

                    <a href="index.php?controller=Forum&action=index" class="btn btn-purple mt-4">
                        <i class="fas fa-comments me-2"></i> FOROS
                    </a>
                </div>
            </section>
        </div>

        <script src="assets/js/carrusel_mobile.js"></script>
    </main>
    <?php include_once("bot.php"); ?>
    <?php include_once("footer.php"); ?>
    <script src="assets/js/landing_mobile.js"></script>
    <script src="assets/js/bot.js"></script>
</body>

</html>