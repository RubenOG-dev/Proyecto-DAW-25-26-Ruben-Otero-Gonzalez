document.addEventListener("DOMContentLoaded", () => {
    cargarContenido("games-carousel");
    cargarContenido("games-carousel-mob");
});

async function cargarContenido(containerId) {
    const contenedor = document.getElementById(containerId);
    if (!contenedor) return;

    contenedor.innerHTML = '<div class="spinner-border text-light" role="status"><span class="visually-hidden">Cargando...</span></div>';

    try {
        const response = await fetch("index.php?controller=Games&action=listarTop");
        if (!response.ok) throw new Error("Error en la petición");
        
        const data = await response.json();
        contenedor.innerHTML = "";

        if (data.results && data.results.length > 0) {
            const juegos = data.results.slice(0, 20);

            juegos.forEach(juego => {
                const div = document.createElement("div");
                div.className = "game-card";

                div.innerHTML = `
                    <div class="game-card-inner" onclick="window.location.href='index.php?controller=Games&action=detalle&id=${juego.id}'" style="cursor:pointer">
                        <img src="${juego.background_image || 'assets/img/default-game.jpg'}" 
                             alt="${juego.name}" 
                             loading="lazy">
                        <h5 style="margin-top:10px; font-size:0.9rem; font-weight: bold; color: #fff;">${juego.name}</h5>
                    </div>
                `;
                contenedor.appendChild(div);
            });
        } else {
            contenedor.innerHTML = "<p class='text-muted'>No hay juegos destacados en este momento.</p>";
        }

        if (containerId === "games-carousel") {
            const next = document.getElementById("nextBtn");
            const prev = document.getElementById("prevBtn");
            const scrollAmount = 400;

            if (next) {
                next.onclick = () => {
                    contenedor.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                };
            }
            if (prev) {
                prev.onclick = () => {
                    contenedor.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                };
            }

            verificarFlechas(contenedor, prev, next);
            contenedor.addEventListener('scroll', () => verificarFlechas(contenedor, prev, next));
        }

    } catch (e) {
        console.error("Error cargando carrusel:", e);
        contenedor.innerHTML = "<p class='text-danger'>Error al cargar el catálogo.</p>";
    }
}

function verificarFlechas(cnt, p, n) {
    if (!p || !n) return;
    p.style.opacity = cnt.scrollLeft <= 0 ? "0.2" : "1";
    p.style.pointerEvents = cnt.scrollLeft <= 0 ? "none" : "auto";

    const reachedEnd = cnt.scrollLeft + cnt.offsetWidth >= cnt.scrollWidth - 10;
    n.style.opacity = reachedEnd ? "0.2" : "1";
    n.style.pointerEvents = reachedEnd ? "none" : "auto";
}