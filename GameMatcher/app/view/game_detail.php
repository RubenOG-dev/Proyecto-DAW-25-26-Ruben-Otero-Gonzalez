<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $gameData['name']; ?> - GameMatcher</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="detail-page">

    <header class="main-header">
        <div class="logo">
            <img src="img/logo.png" alt="Logo" width="40">
            <h1>Game<span>Matcher</span></h1>
        </div>
        <nav class="nav-menu">
            <a href="index.php" class="btn-nav"><i class="fas fa-home"></i> INICIO</a>
        </nav>
    </header>

    <main class="container">
        <div class="game-hero-banner" style="background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('<?php echo $gameData['background_image_additional'] ?? $gameData['background_image']; ?>')">
            <div class="hero-content-detail">
                <img src="<?php echo $gameData['background_image']; ?>" alt="<?php echo $gameData['name']; ?>" class="detail-poster shadow">
                <div class="hero-text">
                    <h2 class="display-4 fw-bold"><?php echo $gameData['name']; ?></h2>
                    <div class="meta-info">
                        <span class="rating-badge">⭐ <?php echo $gameData['rating']; ?> / 5</span>
                        <p class="mt-2"><strong>Data de lanzamento:</strong> <?php echo $gameData['released'] ?? 'N/A'; ?></p>
                        <p><strong>Plataformas:</strong> 
                            <?php echo implode(', ', array_map(function($p){ return $p['platform']['name']; }, $gameData['platforms'])); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <section class="game-info-section mt-5">
            <div class="row">
                <div class="col-md-8">
                    <h3>Sobre o xogo</h3>
                    <div class="description-text text-secondary">
                        <?php echo $gameData['description']; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="action-box p-4 bg-dark rounded shadow">
                        <h4>Interaccións</h4>
                        <button class="btn-primary w-100 mb-3" id="btn-valorar" 
                                data-id="<?php echo $gameData['id']; ?>" 
                                data-name="<?php echo htmlspecialchars($gameData['name']); ?>">
                            <i class="fas fa-star"></i> VALORAR JUEGO
                        </button>
                        <a href="index.php?controller=Foro&action=ver&juego_id=<?php echo $gameData['id']; ?>" class="btn-secondary w-100 d-block text-center">
                            <i class="fas fa-comments"></i> IR AO FORO
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div id="chat-bubble"><img src="img/robot-vectorial-graident-ai.png" alt="Botti"></div>
    <div id="chat-window" class="chat-hidden">
        <div class="chat-header"><span>BOTTI</span></div>
        <div id="chat-messages" class="chat-messages"></div>
        <div class="chat-input-container">
            <input type="text" id="chat-input" placeholder="Pregúntame algo...">
            <button id="chat-send">Enviar</button>
        </div>
    </div>

    <script src="assets/js/bot.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>