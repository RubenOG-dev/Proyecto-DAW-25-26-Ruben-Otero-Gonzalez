document.addEventListener("DOMContentLoaded", () => {
    cargarCarrusel();
});

async function cargarCarrusel() {
    const contenedor = document.getElementById("games-carousel");

    if (!contenedor) return;

    try {
        const response = await fetch("index.php?controller=Games&action=listarTop");
        
        if (!response.ok) throw new Error("Error en la petición al servidor");
        
        const data = await response.json();

        contenedor.innerHTML = "";

        if (data.results && data.results.length > 0) {
            data.results.forEach(juego => {
                const card = crearTarjetaJuego(juego);
                contenedor.appendChild(card);
            });
        } else {
            contenedor.innerHTML = "<p class='text-white'>Non se atoparon xogos neste momento.</p>";
        }

    } catch (error) {
        console.error("Erro cargando o carrusel:", error);
        contenedor.innerHTML = "<p class='text-danger'>Erro ao conectar co servidor.</p>";
    }
}
function crearTarjetaJuego(juego) {
    const div = document.createElement("div");
    div.className = "game-card-container";
    div.innerHTML = `
        <div class="card bg-dark border-0 shadow-sm h-100" style="width: 200px; cursor: pointer;" onclick="window.location.href='index.php?controller=Games&action=detalle&id=${juego.id}'">
            <div class="position-relative">
                <img src="${juego.background_image}" class="card-img-top rounded shadow" alt="${juego.name}" style="height: 280px; object-fit: cover;">
                <div class="rating-badge position-absolute top-0 end-0 m-2 badge bg-primary">
                    ⭐ ${juego.rating}
                </div>
            </div>
            <div class="card-body p-2">
                <h5 class="card-title text-white h6 text-truncate mb-0">${juego.name}</h5>
                <p class="card-text text-secondary small">${juego.released ? juego.released.split('-')[0] : 'N/A'}</p>
            </div>
        </div>
    `;
    return div;
}