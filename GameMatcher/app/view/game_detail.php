<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo $gameData['name']; ?> - GameMatcher</title>
    <link rel="stylesheet" href="assets/css/game_detail.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="icon" type="image/png" href="assets/img/logo2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="detail-page">
    <?php
    $placeholder = "assets/img/No-Image-Placeholder.png";
    $defaultImg = (!empty($gameData['background_image'])) ? $gameData['background_image'] : $placeholder;
    $carouselImages = (!empty($gameData['all_images'])) ? $gameData['all_images'] : [$defaultImg];
    ?>
    <div class="notification-container">
        <?php if (isset($_GET['success'])): ?>
            <div class="auto-hide success">
                <i class="fas fa-check-circle"></i> ¡Tu valoración se ha guardado correctamente!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="auto-hide error">
                <i class="fas fa-times-circle"></i> Hubo un error al guardar tu reseña.
            </div>
        <?php endif; ?>
    </div>
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
                    <div class="card-poster" data-images='<?php echo json_encode($carouselImages); ?>'>
                        <div class="card-img-wrapper">
                            <img src="<?php echo $defaultImg; ?>"
                                class="main-img"
                                onerror="this.src='<?php echo $placeholder; ?>';">

                            <?php if (count($carouselImages) > 1): ?>
                                <div class="img-progress-bar">
                                    <?php foreach ($carouselImages as $index => $img): ?>
                                        <div class="progress-segment <?php echo $index === 0 ? 'active' : ''; ?>"
                                            data-index="<?php echo $index; ?>"></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
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
                                <p>
                                    <?php
                                    if (isset($gameData['developers']) && !empty($gameData['developers'])) {
                                        echo implode(', ', array_map(fn($d) => $d['name'], $gameData['developers']));
                                    } else {
                                        echo '<p class="text-muted-alt">Información no disponible</p>';
                                    }
                                    ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <div class="ratings-wrapper">
                            <div class="info-item">
                                <span>Valoración Global:</span>
                                <div class="stars">
                                    <?php
                                    $ratingAPI = $gameData['rating'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($ratingAPI >= $i) echo '<i class="fas fa-star"></i>';
                                        elseif ($ratingAPI >= ($i - 0.5)) echo '<i class="fas fa-star-half-alt"></i>';
                                        else echo '<i class="far fa-star"></i>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="info-item">
                                <span>Valoración Comunidad:</span>
                                <div class="stars community-stars">
                                    <?php if (!empty($gameData['rating_comunidad'])): ?>
                                        <?php
                                        $ratingBD = $gameData['rating_comunidad'];
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($ratingBD >= $i) echo '<i class="fas fa-star"></i>';
                                            elseif ($ratingBD >= ($i - 0.5)) echo '<i class="fas fa-star-half-alt"></i>';
                                            else echo '<i class="far fa-star"></i>';
                                        }
                                        ?>
                                    <?php else: ?>
                                        <span class="no-rating">Sin valoraciones aún</span>
                                    <?php endif; ?>
                                </div>
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
                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <button type="button" class="btn-foro-main btn-valorar" onclick="openRatingModal()">
                        VALORAR JUEGO <i class="fas fa-star"></i>
                    </button>
                <?php else: ?>
                    <a href="index.php?controller=User&action=mostrarAuth&return_to=<?php echo $gameData['id']; ?>" class="btn-foro-main btn-valorar" style="background: #555;">
                        LOGUÉATE PARA VALORAR <i class="fas fa-lock"></i>
                    </a>
                <?php endif; ?>
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
                    <div class="card-poster" data-images='<?php echo json_encode($carouselImages); ?>'>
                        <div class="card-img-wrapper">
                            <img src="<?php echo $defaultImg; ?>"
                                class="main-img"
                                onerror="this.src='<?php echo $placeholder; ?>';">

                            <?php if (count($carouselImages) > 1): ?>
                                <div class="img-progress-bar">
                                    <?php foreach ($carouselImages as $index => $img): ?>
                                        <div class="progress-segment <?php echo $index === 0 ? 'active' : ''; ?>"
                                            data-index="<?php echo $index; ?>"></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
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
                                <p>
                                    <?php
                                    if (isset($gameData['developers']) && !empty($gameData['developers'])) {
                                        echo implode(', ', array_map(fn($d) => $d['name'], $gameData['developers']));
                                    } else {
                                        echo '<span class="text-muted-alt">Información no disponible</span>';
                                    }
                                    ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <div class="ratings-wrapper">
                            <div class="info-item">
                                <span>Valoración Global:</span>
                                <div class="stars">
                                    <?php
                                    $ratingAPI = $gameData['rating'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($ratingAPI >= $i) echo '<i class="fas fa-star"></i>';
                                        elseif ($ratingAPI >= ($i - 0.5)) echo '<i class="fas fa-star-half-alt"></i>';
                                        else echo '<i class="far fa-star"></i>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="info-item">
                                <span>Valoración Comunidad:</span>
                                <div class="stars community-stars">
                                    <?php if (!empty($gameData['rating_comunidad'])): ?>
                                        <?php
                                        $ratingBD = $gameData['rating_comunidad'];
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($ratingBD >= $i) echo '<i class="fas fa-star"></i>';
                                            elseif ($ratingBD >= ($i - 0.5)) echo '<i class="fas fa-star-half-alt"></i>';
                                            else echo '<i class="far fa-star"></i>';
                                        }
                                        ?>
                                    <?php else: ?>
                                        <span class="no-rating">Sin valoraciones aún</span>
                                    <?php endif; ?>
                                </div>
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
                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <button type="button" class="btn-foro-main btn-valorar" onclick="openRatingModal()">
                        VALORAR JUEGO <i class="fas fa-star"></i>
                    </button>
                <?php else: ?>
                    <a href="index.php?controller=User&action=mostrarAuth&return_to=<?php echo $gameData['id']; ?>" class="btn-foro-main btn-valorar" style="background: #555;">
                        LOGUÉATE PARA VALORAR <i class="fas fa-lock"></i>
                    </a>
                <?php endif; ?>
            </div>
        </main>
        <?php include_once("footer_mobile.php"); ?>
    </div>
    <div id="ratingModal" class="modal-rating">
        <div class="modal-content">
            <span class="close-modal" onclick="closeRatingModal()">&times;</span>
            <h3>Valorar <?php echo htmlspecialchars($gameData['name']); ?></h3>

            <form action="index.php?controller=Games&action=guardarValoracion" method="POST">
                <input type="hidden" name="game_id" value="<?php echo $gameData['id']; ?>">

                <div class="star-rating-input">
                    <input type="radio" id="star5" name="puntuacion" value="5" required /><label for="star5"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star4" name="puntuacion" value="4" /><label for="star4"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star3" name="puntuacion" value="3" /><label for="star3"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star2" name="puntuacion" value="2" /><label for="star2"><i class="fas fa-star"></i></label>
                    <input type="radio" id="star1" name="puntuacion" value="1" /><label for="star1"><i class="fas fa-star"></i></label>
                </div>

                <textarea name="comentario" placeholder="Escribe una breve reseña (opcional)..." maxlength="255"></textarea>

                <button type="submit" class="btn-enviar-valoracion">ENVIAR RESEÑA</button>
            </form>
        </div>
    </div>
    <script src="assets/js/game_detail.js"></script>
</body>

</html>