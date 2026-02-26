document.addEventListener("DOMContentLoaded", () => {
    cargarContenido("games-carousel");
    cargarContenido("games-carousel-mob");
});

async function cargarContenido(containerId) {
    const contenedor = document.getElementById(containerId);
    if (!contenedor) return;

    // Mantenemos tu spinner
    contenedor.innerHTML = '<div class="spinner-border text-light" role="status"><span class="visually-hidden">Cargando...</span></div>';

    try {
        const response = await fetch("index.php?controller=Games&action=listarTop");
        if (!response.ok) throw new Error("Error en la petición");
        
        const data = await response.json();
        contenedor.innerHTML = "";

        if (data.results && data.results.length > 0) {
            // USAMOS 20 JUEGOS COMO SOLICITASTE
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
            contenedor.innerHTML = "<p class='text-muted'>Non hai xogos destacados neste momento.</p>";
        }

        // Lógica de botones (Mantenida al 100%)
        if (containerId === "games-carousel") {
            const next = document.getElementById("nextBtn");
            const prev = document.getElementById("prevBtn");

            // Ajustamos el scrollAmount para que la transición sea fluida según el tamaño de las tarjetas
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
        contenedor.innerHTML = "<p class='text-danger'>Error ao cargar o catálogo.</p>";
    }
}

/**
 * Función extra para mejorar la UI: Oculta o atenúa las flechas según el scroll
 */
function verificarFlechas(cnt, p, n) {
    if (!p || !n) return;
    p.style.opacity = cnt.scrollLeft <= 0 ? "0.2" : "1";
    p.style.pointerEvents = cnt.scrollLeft <= 0 ? "none" : "auto";

    const reachedEnd = cnt.scrollLeft + cnt.offsetWidth >= cnt.scrollWidth - 10;
    n.style.opacity = reachedEnd ? "0.2" : "1";
    n.style.pointerEvents = reachedEnd ? "none" : "auto";
}