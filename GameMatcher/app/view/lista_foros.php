<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Foros - GameMatcher</title>
    <link rel="icon" type="image/png" href="assets/img/logo2.png">
    <link rel="stylesheet" href="assets/css/lista_foros.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="detail-page"> <div class="desktop-only">
        <header class="main-header">
            <div class="logo">
                <a href="index.php?controller=Main&action=principal">
                    <img src="assets/img/logo.png" alt="GameMatcher Logo">
                </a>
            </div>
            <nav class="nav-menu">
                <a href="index.php?controller=Games&action=catalogo" class="btn-header-alt"><i class="fas fa-gamepad"></i> CATÁLOGO</a>
            </nav>
        </header>

        <main class="container"> <section class="container-foros">
                <div class="tendencia-header">
                    <h2>TOP 7 FOROS EN TENDENCIA <i class="fas fa-bolt"></i></h2>
                </div>
                <div class="foros-wrapper">
                    <?= ForoHelper::renderForos($foros); ?>
                </div>
            </section>
        </main>

        <?php include_once("footer_desktop.php"); ?>
    </div>

    <div class="mobile-only">
        <header class="mobile-header">
            <div class="logo-container">
                <img src="assets/img/logo.png" alt="Logo">
            </div>
            <div class="header-buttons">
                <a href="index.php?controller=Games&action=catalogo" class="btn-small"><i class="fas fa-gamepad"></i> CATÁLOGO</a>
            </div>
        </header>

        <main class="mobile-body"> <section class="container-foros" style="width: 95%;">
                <div class="tendencia-header">
                    <h2>FOROS <i class="fas fa-bolt"></i></h2>
                </div>
                <div class="foros-wrapper">
                    <?= ForoHelper::renderForos($foros); ?>
                </div>
            </section>
        </main>

        <?php include_once("footer_mobile.php"); ?>
    </div>

    <script src="assets/js/lista_foros.js"></script>
</body>
</html>