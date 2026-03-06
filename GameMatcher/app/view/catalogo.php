<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - GameMatcher</title>
    <link rel="icon" type="image/png" href="assets/img/logo2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/catalogo.css">
</head>

<body class="rawg-theme">

    <div class="rawg-layout">
        <aside class="sidebar-filters">
            <a href="<?php echo isset($_SESSION['id_usuario']) ? 'index.php?controller=User&action=mostrarMain' : 'index.php'; ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i> VOLVER AL INICIO
            </a>

            <button id="btnResetFilters" class="btn-reset-filters">
                <i class="fas fa-trash-can"></i> Limpiar filtros
            </button>

            <h2>Tendencias</h2>
            <div class="filter-group">
                <div class="nav-item top-filter" data-value="weekly">
                    <div class="nav-icon"><i class="fas fa-calendar-week"></i></div>
                    <span>Esta semana</span>
                </div>
                <div class="nav-item top-filter" data-value="monthly">
                    <div class="nav-icon"><i class="fas fa-calendar-alt"></i></div>
                    <span>Este mes</span>
                </div>
            </div>

            <h2>Mejores del Año</h2>
            <div class="filter-group">
                <div class="custom-dropdown" id="yearDropdown">
                    <div class="dropdown-header">
                        <div class="nav-icon"><i class="fas fa-trophy"></i></div>
                        <span id="selectedYearText">Seleccionar año</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>
                    <div class="dropdown-list" id="yearOptions"></div>
                </div>
            </div>

            <h2>Ordenar por</h2>
            <div class="filter-group">
                <div class="nav-item order-filter" data-value="added">
                    <div class="nav-icon"><i class="fas fa-fire"></i></div>
                    <span>Popularidad</span>
                    <i class="fas fa-sort-down order-arrow"></i>
                </div>
                <div class="nav-item order-filter" data-value="metacritic">
                    <div class="nav-icon"><i class="fas fa-star"></i></div>
                    <span>Mejor valoración</span>
                    <i class="fas fa-sort-down order-arrow"></i>
                </div>
                <div class="nav-item order-filter" data-value="released">
                    <div class="nav-icon"><i class="fas fa-calendar-plus"></i></div>
                    <span>Fecha de lanzamiento</span>
                    <i class="fas fa-sort-down order-arrow"></i>
                </div>
            </div>

            <h2>Plataformas</h2>
            <div class="filter-group" id="platformsContainer">
                <label class="nav-item">
                    <input type="checkbox" value="1" class="platform-check">
                    <div class="nav-icon"><i class="fab fa-windows"></i></div>
                    <span>PC</span>
                </label>

                <label class="nav-item">
                    <input type="checkbox" value="2" class="platform-check">
                    <div class="nav-icon"><i class="fab fa-playstation"></i></div>
                    <span>PlayStation</span>
                </label>

                <label class="nav-item">
                    <input type="checkbox" value="3" class="platform-check">
                    <div class="nav-icon"><i class="fab fa-xbox"></i></div>
                    <span>Xbox</span>
                </label>

                <label class="nav-item">
                    <input type="checkbox" value="7" class="platform-check">
                    <div class="nav-icon"><i class="fas fa-gamepad"></i></div>
                    <span>Nintendo</span>
                </label>

                <div class="extra-items" style="display: none;">
                    <label class="nav-item">
                        <input type="checkbox" value="4" class="platform-check">
                        <div class="nav-icon"><i class="fab fa-apple"></i></div>
                        <span>iOS</span>
                    </label>
                    <label class="nav-item">
                        <input type="checkbox" value="8" class="platform-check">
                        <div class="nav-icon"><i class="fab fa-android"></i></div>
                        <span>Android</span>
                    </label>
                </div>

                <div class="toggle-btn" onclick="toggleSection(this)">
                    <div class="nav-icon"><i class="fas fa-chevron-down"></i></div>
                    <span>Mostrar todas</span>
                </div>
            </div>

            <h2>Géneros</h2>
            <div class="filter-group" id="genresContainer">
                </div>
        </aside>

        <main class="main-content">
            <header class="search-container">
                <div class="mobile-filter-bar">
                    <button id="openFilters" class="btn-mobile-filter">
                        <i class="fas fa-filter"></i> Filtros
                    </button>
                    <input type="text" id="searchInput" placeholder="Buscar juegos...">
                </div>
            </header>

            <div class="scrollable-area" id="gamesScrollContainer">
                <div class="games-grid">
                    <div class="game-column" id="col-0"></div>
                    <div class="game-column" id="col-1"></div>
                    <div class="game-column" id="col-2"></div>
                </div>

                <div class="pagination-area" style="text-align: center; padding: 40px 0;">
                    <button id="btnLoadMore" class="btn-rawg">CARGAR MÁS JUEGOS</button>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/catalogo.js"></script>
</body>

</html>