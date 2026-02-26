<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>GameMatcher - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/landing_desktop.css">
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
    <main>
        
    </main>
    <?php include_once("bot.php"); ?>
    <?php include_once("footer.php"); ?>
    <script src="assets/js/bot.js"></script>
</body>

</html>