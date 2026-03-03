document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const gamesGrid = document.querySelector('.games-grid');
    const btnLoadMore = document.getElementById('btnLoadMore');

    let currentPage = 1;
    let currentOrder = '';
    let currentTopDates = '';

    const getCols = () => [
        document.getElementById('col-0'),
        document.getElementById('col-1'),
        document.getElementById('col-2')
    ];

    const clearCols = () => {
        getCols().forEach(col => { if (col) col.innerHTML = ''; });
    };

    const getGames = async (page = 1, append = false) => {
        const query = searchInput.value;
        const genres = Array.from(document.querySelectorAll('.genre-check:checked')).map(c => c.value).join(',');
        const platforms = Array.from(document.querySelectorAll('.platform-check:checked')).map(c => c.value).join(',');
        const cols = getCols();

        if (!append) {
            clearCols();
            cols.forEach((col) => {
                col.innerHTML = `
                    <div class="skeleton-card">
                        <div class="skeleton-img"></div>
                        <div class="skeleton-text"></div>
                        <div class="skeleton-meta"></div>
                    </div>`;
            });
        }

        let url = `index.php?controller=Games&action=catalogo&ajax=1&page=${page}`;
        if (query) url += `&search=${encodeURIComponent(query)}`;
        if (genres) url += `&genres=${genres}`;
        if (platforms) url += `&platforms=${platforms}`;
        if (currentOrder) url += `&ordering=${currentOrder}`;
        if (currentTopDates) url += `&dates=${currentTopDates}`;

        try {
            const response = await fetch(url);
            const data = await response.json();

            if (!append) clearCols();

            if (data.results && data.results.length > 0) {
                data.results.forEach((game, index) => {
                    const card = createGameCard(game);
                    const visibleCols = cols.filter(c => getComputedStyle(c).display !== 'none');
                    visibleCols[index % visibleCols.length].appendChild(card);
                });
            } else if (!append) {
                gamesGrid.innerHTML = '<p style="color:white; width:100%; text-align:center;">No se encontraron resultados.</p>';
            }
        } catch (e) {
            console.error("Error cargando API", e);
            if (!append) {
                gamesGrid.innerHTML = '<p style="color:red; text-align:center; width:100%;">Error al conectar con el servidor.</p>';
            }
        }
    };

    function createGameCard(game) {
        const article = document.createElement('article');
        article.className = 'game-card-catalog';

        const platformIcons = game.parent_platforms?.map(p => {
            const s = p.platform.slug;
            if (s === 'pc') return '<i class="fab fa-windows" title="PC"></i>';
            if (s === 'playstation') return '<i class="fab fa-playstation" title="PlayStation"></i>';
            if (s === 'xbox') return '<i class="fab fa-xbox" title="Xbox"></i>';
            if (s === 'nintendo') return '<i class="fas fa-gamepad" title="Nintendo"></i>';
            if (s === 'android' || s === 'ios') return '<i class="fas fa-mobile-alt" title="Mobile"></i>';
            return '';
        }).join('') || '';

        const metacriticScore = game.metacritic;
        let metaClass = 'hide';
        if (metacriticScore) {
            metaClass = metacriticScore >= 75 ? 'high' : (metacriticScore >= 50 ? 'med' : 'low');
        }

        const images = game.short_screenshots ? game.short_screenshots.map(s => s.image) : [game.background_image];
        const genresText = game.genres?.slice(0, 3).map(g => g.name).join(', ') || 'N/A';

        article.innerHTML = `
            <div class="card-img-wrapper">
                <img src="${game.background_image || 'assets/img/logo2.png'}" class="main-img" loading="lazy">
                <div class="img-progress-bar">
                    ${images.map((_, idx) => `<div class="progress-segment ${idx === 0 ? 'active' : ''}"></div>`).join('')}
                </div>
                <span class="metacritic-badge ${metaClass}">${metacriticScore || ''}</span>
            </div>
            <div class="card-info">
                <div class="platform-icons">${platformIcons}</div>
                <h3 style="margin: 5px 0; font-size: 1.4rem;">${game.name}</h3>
                <div class="extra-content">
                    <div class="info-row"><span>Release date:</span><span>${game.released || 'TBA'}</span></div>
                    <div class="info-row"><span>Genres:</span><span class="genre-link">${genresText}</span></div>
                    <div class="info-row"><span>Chart:</span><span>#${Math.floor(Math.random() * 50) + 1} Top 2026</span></div>
                    <button class="btn-show-more-card">Ver más detalles <i class="fas fa-chevron-right"></i></button>
                </div>
            </div>`;

        let interval;
        article.addEventListener('mouseenter', () => {
            if (images.length <= 1) return;
            let i = 0;
            const imgElement = article.querySelector('.main-img');
            interval = setInterval(() => {
                i = (i + 1) % images.length;
                imgElement.src = images[i];
                const segments = article.querySelectorAll('.progress-segment');
                segments.forEach((s, idx) => s.classList.toggle('active', idx === i));
            }, 1200);
        });

        article.addEventListener('mouseleave', () => {
            clearInterval(interval);
            article.querySelector('.main-img').src = game.background_image;
            const segments = article.querySelectorAll('.progress-segment');
            segments.forEach((s, idx) => s.classList.toggle('active', idx === 0));
        });

        article.onclick = () => {
            window.location.href = `index.php?controller=Games&action=detalle&id=${game.id}`;
        };

        return article;
    }

    document.querySelectorAll('.top-filter').forEach(item => {
        item.addEventListener('click', function () {
            const isActive = this.classList.contains('active');
            document.querySelectorAll('.top-filter').forEach(i => i.classList.remove('active'));

            if (isActive) {
                currentTopDates = '';
            } else {
                this.classList.add('active');
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const todayStr = `${year}-${month}-${String(now.getDate()).padStart(2, '0')}`;

                if (this.dataset.value === 'weekly') {
                    const lastWeek = new Date();
                    lastWeek.setDate(now.getDate() - 7);
                    const weekStr = `${lastWeek.getFullYear()}-${String(lastWeek.getMonth() + 1).padStart(2, '0')}-${String(lastWeek.getDate()).padStart(2, '0')}`;
                    currentTopDates = `${weekStr},${todayStr}`;
                } else {
                    currentTopDates = `${year}-${month}-01,${todayStr}`;
                }
                currentOrder = '-metacritic';
                document.querySelectorAll('.order-filter').forEach(off => {
                    off.classList.toggle('active', off.dataset.value === '-metacritic');
                });
            }
            currentPage = 1;
            getGames(1, false);
        });
    });

    document.querySelectorAll('.order-filter').forEach(item => {
        item.addEventListener('click', function () {
            const newValue = this.dataset.value;
            if (currentOrder === newValue) {
                currentOrder = '';
                this.classList.remove('active');
            } else {
                document.querySelectorAll('.order-filter').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                currentOrder = newValue;
            }
            currentPage = 1;
            getGames(1, false);
        });
    });

    document.querySelectorAll('.platform-check, .genre-check').forEach(check => {
        check.addEventListener('change', () => { currentPage = 1; getGames(1, false); });
    });

    searchInput.addEventListener('input', debounce(() => { currentPage = 1; getGames(1, false); }, 500));

    if (btnLoadMore) {
        btnLoadMore.addEventListener('click', () => { currentPage++; getGames(currentPage, true); });
    }

    function debounce(f, w) {
        let t; return (...a) => { clearTimeout(t); t = setTimeout(() => f(...a), w); };
    }

    getGames(1, false);
});

window.toggleSection = function (btn) {
    const container = btn.closest('.filter-group');
    const extra = container.querySelector('.extra-items');
    const span = btn.querySelector('span');
    const icon = btn.querySelector('i');

    if (extra.style.display === 'none' || extra.style.display === '') {
        extra.style.display = 'block';
        span.textContent = 'Hide';
        icon.className = 'fas fa-chevron-up';
    } else {
        extra.style.display = 'none';
        span.textContent = 'Show all';
        icon.className = 'fas fa-chevron-down';
    }
};