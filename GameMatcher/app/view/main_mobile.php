<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameMatcher - Móvil</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main_mobile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <section class="intro-text">
            <h1>Encuentra tu próximo juego perfecto</h1>
            <p class="italic">¿No sabes a qué jugar o buscas el <strong>videojuego perfecto</strong> para ti?</p>
            <p>En <strong>GameMatcher</strong> descubrirás miles de videojuegos con información detallada, filtrados según tus gustos
                y necesidades. Explora nuevos mundos, compara características y decide con criterio gracias a las valoraciones reales
                de la comunidad gamer.<br> Únete a otros jugadores, comparte tu opinión y encuentra tu próxima gran aventura.</p>
        </section>

        <div class="action-container">
            <a href="..." class="btn-join-mobile">Únete A Nosotros!!</a>
        </div>
    </main>
    <?php include_once("footer_mobile.php"); ?>
    <script src="assets/js/main_mobile.js"></script>
</body>

</html>