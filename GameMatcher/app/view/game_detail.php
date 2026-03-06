<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo $gameData['name']; ?> - GameMatcher</title>
    <link rel="stylesheet" href="assets/css/game_detail.css">
    <link rel="icon" type="image/png" href="assets/img/logo2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="detail-page">

    <div class="desktop-only">
        <header class="main-header">
            <div class="logo">
                <a href="index.php?controller=Main&action=principal">
                    <img src="assets/img/logo.png" alt="Logotipo de GameMatcher">
                </a>
            </div>
            <nav class="nav-menu">
                <a href="index.php?controller=Foro&action=listar" class="btn-header-alt"><i class="fas fa-comments"></i> FOROS</a>
                <a href="index.php?controller=Games&action=catalogo" class="btn-header-alt"><i class="fas fa-gamepad"></i> CATÁLOGO</a>
            </nav>
        </header>

        <main class="container">
            <div class="figma-card-desktop">
                <div class="card-header-desktop">
                    <div class="card-poster" data-images='<?php echo json_encode($gameData['all_images']); ?>'>
                        <div class="card-img-wrapper">
                            <img src="<?php echo $gameData['background_image']; ?>" class="main-img">
                            <div class="img-progress-bar">
                                <?php foreach ($gameData['all_images'] as $index => $img): ?>
                                    <div class="progress-segment <?php echo $index === 0 ? 'active' : ''; ?>"
                                        data-index="<?php echo $index; ?>"></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-info-list">
                        <div class="info-item">
                            <span>Plataforma/-s:</span>
                            <p><?php echo implode(', ', array_map(fn($p) => $p['platform']['name'], $gameData['platforms'])); ?></p>
                        </div>

                        <div class="info-item">
                            <span>Fecha de Lanzamiento:</span>
                            <p><?php echo $gameData['released'] ?? 'Por anunciar'; ?></p>
                        </div>

                        <div class="info-item">
                            <span>Género:</span>
                            <p><?php echo implode(', ', array_map(fn($g) => $g['name'], $gameData['genres'])); ?></p>
                        </div>

                        <?php if (isset($gameData['developers'])): ?>
                            <div class="info-item">
                                <span>Desarrolladora:</span>
                                <p><?php echo implode(', ', array_map(fn($d) => $d['name'], $gameData['developers'])); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="info-item">
                            <span>Valoración:</span>
                            <div class="stars">
                                <?php
                                $rating = $gameData['rating']; // Valor decimal, ej: 3.5 o 4.2
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($rating >= $i) {
                                        // Estrella completa
                                        echo '<i class="fas fa-star"></i>';
                                    } elseif ($rating >= ($i - 0.5)) {
                                        // Media estrella
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    } else {
                                        // Estrella vacía
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-description" id="target-description-desktop">
                    <p><?php echo $gameData['description_limpia'] ?? 'No hay descripción disponible para este juego.'; ?></p>
                </div>
            </div>

            <div style="text-align: center; width: 100%;">
                <a href="index.php?controller=Foro&action=accederJuego&game_id=<?php echo $gameData['id']; ?>&name=<?php echo urlencode($gameData['name']); ?>" class="btn-foro-main">
                    FORO DEL JUEGO
                </a>
            </div>
        </main>
        <?php include_once("footer_desktop.php"); ?>
    </div>

    <div class="mobile-only">
        <header class="mobile-header">
            <div class="logo-container">
                <img src="assets/img/logo.png" alt="Logotipo">
            </div>
            <div class="header-buttons">
                <a href="index.php?controller=Foro&action=listar" class="btn-small"><i class="fas fa-comments"></i> FOROS</a>
                <a href="index.php?controller=Games&action=catalogo" class="btn-small"><i class="fas fa-gamepad"></i> CATÁLOGO</a>
            </div>
        </header>

        <main class="mobile-body">
            <div class="figma-card-mobile">
                <div class="card-header-mobile">
                    <div class="card-poster" data-images='<?php echo json_encode($gameData['all_images']); ?>'>
                        <div class="card-img-wrapper">
                            <img src="<?php echo $gameData['background_image']; ?>" class="main-img">
                            <div class="img-progress-bar">
                                <?php foreach ($gameData['all_images'] as $index => $img): ?>
                                    <div class="progress-segment <?php echo $index === 0 ? 'active' : ''; ?>"
                                        data-index="<?php echo $index; ?>"></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-info-list">
                        <div class="info-item">
                            <span>Plataforma/-s:</span>
                            <p><?php echo implode(', ', array_map(fn($p) => $p['platform']['name'], $gameData['platforms'])); ?></p>
                        </div>

                        <div class="info-item">
                            <span>Fecha de Lanzamiento:</span>
                            <p><?php echo $gameData['released'] ?? 'Por anunciar'; ?></p>
                        </div>

                        <div class="info-item">
                            <span>Género:</span>
                            <p><?php echo implode(', ', array_map(fn($g) => $g['name'], $gameData['genres'])); ?></p>
                        </div>

                        <?php if (isset($gameData['developers'])): ?>
                            <div class="info-item">
                                <span>Desarrolladora:</span>
                                <p><?php echo implode(', ', array_map(fn($d) => $d['name'], $gameData['developers'])); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="info-item">
                            <span>Valoración:</span>
                            <div class="stars">
                                <?php
                                $rating = $gameData['rating']; 
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($rating >= $i) {
                                        echo '<i class="fas fa-star"></i>';
                                    } elseif ($rating >= ($i - 0.5)) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-description" id="target-description-mobile">
                    <p><?php echo $gameData['description_limpia'] ?? 'Descripción no disponible.'; ?></p>
                </div>
            </div>

            <div style="text-align: center; width: 100%;">
                <a href="index.php?controller=Foro&action=accederJuego&game_id=<?php echo $gameData['id']; ?>&name=<?php echo urlencode($gameData['name']); ?>" class="btn-foro-main">FORO DEL JUEGO </a>
            </div>
        </main>
        <?php include_once("footer_mobile.php"); ?>
    </div>

    <script src="assets/js/game_detail.js"></script>
</body>

</html>