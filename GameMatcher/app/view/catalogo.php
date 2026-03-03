<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - GameMatcher</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/catalogo.css">
    <link rel="stylesheet" href="assets/css/loader.css">
</head>

<body class="rawg-theme">
    <div id="page-loader">
        <div class="spinner"></div>
        <p>Cargando catálogo...</p>
    </div>
    <div class="rawg-layout">
        <aside class="sidebar-filters">
            <a href="index.php?controller=User&action=mostrarMain" class="btn-back">
                <i class="fas fa-arrow-left"></i> VOLVER AL INICIO
            </a>

            <h2>Top</h2>
            <div class="filter-group">
                <div class="nav-item top-filter" data-value="weekly">
                    <div class="nav-icon"><i class="fas fa-calendar-week"></i></div>
                    <span>Este semana</span>
                </div>
                <div class="nav-item top-filter" data-value="monthly">
                    <div class="nav-icon"><i class="fas fa-calendar-alt"></i></div>
                    <span>Este mes</span>
                </div>
            </div>

            <h2>Order by</h2>
            <div class="filter-group">
                <div class="nav-item order-filter" data-value="-added">
                    <div class="nav-icon"><i class="fas fa-fire"></i></div>
                    <span>Popularity</span>
                </div>
                <div class="nav-item order-filter" data-value="-rating">
                    <div class="nav-icon"><i class="fas fa-star"></i></div>
                    <span>Average rating</span>
                </div>
                <div class="nav-item order-filter" data-value="-released">
                    <div class="nav-icon"><i class="fas fa-calendar-plus"></i></div>
                    <span>Release date</span>
                </div>
            </div>

            <h2>Platforms</h2>
            <div class="filter-group" id="platformsContainer">
                <label class="nav-item">
                    <input type="checkbox" value="4" class="platform-check">
                    <div class="nav-icon"><i class="fab fa-windows"></i></div>
                    <span>PC</span>
                </label>
                <label class="nav-item">
                    <input type="checkbox" value="18" class="platform-check">
                    <div class="nav-icon"><i class="fab fa-playstation"></i></div>
                    <span>PS4</span>
                </label>
                <label class="nav-item">
                    <input type="checkbox" value="1" class="platform-check">
                    <div class="nav-icon"><i class="fab fa-xbox"></i></div>
                    <span>Xbox One</span>
                </label>

                <div class="extra-items" style="display: none;">
                    <label class="nav-item">
                        <input type="checkbox" value="7" class="platform-check">
                        <div class="nav-icon"><i class="fas fa-gamepad"></i></div>
                        <span>Nintendo Switch</span>
                    </label>
                    <label class="nav-item">
                        <input type="checkbox" value="3" class="platform-check">
                        <div class="nav-icon"><i class="fab fa-apple"></i></div>
                        <span>iOS</span>
                    </label>
                    <label class="nav-item">
                        <input type="checkbox" value="21" class="platform-check">
                        <div class="nav-icon"><i class="fab fa-android"></i></div>
                        <span>Android</span>
                    </label>
                </div>

                <div class="toggle-btn" onclick="toggleSection(this)">
                    <div class="nav-icon"><i class="fas fa-chevron-down"></i></div>
                    <span>Show all</span>
                </div>
            </div>

            <h2>Genres</h2>
            <div class="filter-group" id="genresContainer">
                <label class="nav-item">
                    <input type="checkbox" value="action" class="genre-check">
                    <img src="assets/img/genres/action.jpg" class="genre-img">
                    <span>Action</span>
                </label>
                <label class="nav-item">
                    <input type="checkbox" value="strategy" class="genre-check">
                    <img src="assets/img/genres/strategy.jpg" class="genre-img">
                    <span>Strategy</span>
                </label>
                <label class="nav-item">
                    <input type="checkbox" value="role-playing-games-rpg" class="genre-check">
                    <img src="assets/img/genres/rpg.jpg" class="genre-img">
                    <span>RPG</span>
                </label>

                <div class="extra-items" style="display: none;">
                    <label class="nav-item">
                        <input type="checkbox" value="shooter" class="genre-check">
                        <img src="assets/img/genres/shooter.jpg" class="genre-img">
                        <span>Shooter</span>
                    </label>
                    <label class="nav-item">
                        <input type="checkbox" value="adventure" class="genre-check">
                        <img src="assets/img/genres/adventure.jpg" class="genre-img">
                        <span>Adventure</span>
                    </label>
                    <label class="nav-item">
                        <input type="checkbox" value="puzzle" class="genre-check">
                        <img src="assets/img/genres/puzzle.jpg" class="genre-img">
                        <span>Puzzle</span>
                    </label>
                </div>

                <div class="toggle-btn" onclick="toggleSection(this)">
                    <div class="nav-icon"><i class="fas fa-chevron-down"></i></div>
                    <span>Show all</span>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <header class="search-container">
                <input type="text" id="searchInput" placeholder="Buscar entre miles de juegos...">
            </header>

            <div class="games-grid">
                <div class="game-column" id="col-0"></div>
                <div class="game-column" id="col-1"></div>
                <div class="game-column" id="col-2"></div>
            </div>

            <div class="pagination-area">
                <button id="btnLoadMore" class="btn-rawg">MOSTRAR MÁS JUEGOS</button>
            </div>
        </main>
    </div>
    <script src="assets/js/loader.js"></script>
    <script src="assets/js/catalogo.js"></script>
</body>

</html>