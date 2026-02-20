<section class="best-games">
    <h2 class="carousel-title">Unos de los juegos mejor valorados</h2>
    <div class="carousel-wrapper">
        <button class="arrow prev"><i class="fas fa-chevron-left"></i></button>
        <div class="games-slider-container">
            <div class="games-slider">
                <?php if (!empty($mejoresJuegos)): ?>
                    <?php foreach ($mejoresJuegos as $juego): ?>
                        <div class="game-card">
                            <div class="game-img-container">
                                <img src="<?= $juego['background_image'] ?>" alt="<?= $juego['name'] ?>" loading="lazy">
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <button class="arrow next"><i class="fas fa-chevron-right"></i></button>
    </div>
</section>