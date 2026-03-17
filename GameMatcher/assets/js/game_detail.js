async function traducirDescripciones() {
  const ids = ["target-description-desktop", "target-description-mobile"];
  const excludeTexts = ["No hay descripción disponible", "Descripción no disponible"];

  for (const id of ids) {
    const el = document.getElementById(id);
    if (!el) continue;

    const texto = el.innerText.trim();
    if (texto.length < 10 || texto.includes("QUERY LIMIT") || excludeTexts.some(t => texto.includes(t))) continue;

    const textoLimpio = texto.replace(/<\/?[^>]+(>|$)/g, "");
    const url = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=es&dt=t&q=${encodeURIComponent(textoLimpio)}`;

    try {
      const res = await fetch(url);
      const data = await res.json();
      const traducido = data[0].map((item) => item[0]).join("");
      el.innerHTML = `<p>${traducido}</p>`;
    } catch (err) {
      console.error("Error traduciendo " + id, err);
    }
  }
}

document.addEventListener("DOMContentLoaded", () => {
  traducirDescripciones();

  const carousels = document.querySelectorAll(".card-poster");
  const messages = document.querySelectorAll(".auto-hide");
  const PLACEHOLDER = "assets/img/No-Image-Placeholder.png";

  carousels.forEach((carousel) => {
    let images = [];
    try {
      images = JSON.parse(carousel.dataset.images || "[]");
    } catch (e) {
      console.error("Error parseando imágenes del carrusel", e);
      return;
    }

    if (images.length <= 1 || images[0] === PLACEHOLDER) return;

    const imgElement = carousel.querySelector(".main-img");
    const segments = carousel.querySelectorAll(".progress-segment");
    let currentIndex = 0;
    let autoPlayInterval = null;

    const updateGallery = (index) => {
      currentIndex = index;

      imgElement.classList.add("changing");

      setTimeout(() => {
        imgElement.onerror = () => { imgElement.src = PLACEHOLDER; }
        imgElement.src = images[currentIndex];

        segments.forEach((seg, i) => {
          seg.classList.toggle("active", i === currentIndex);
        });

        imgElement.classList.remove("changing");
      }, 150);
    };

    const startAuto = () => {
      stopAuto();
      autoPlayInterval = setInterval(() => {
        let next = (currentIndex + 1) % images.length;
        updateGallery(next);
      }, 2500);
    };

    const stopAuto = () => {
      if (autoPlayInterval) {
        clearInterval(autoPlayInterval);
        autoPlayInterval = null;
      }
    };

    segments.forEach((seg) => {
      seg.addEventListener("click", (e) => {
        e.stopPropagation();
        const targetIdx = parseInt(seg.getAttribute("data-index"));
        if (!isNaN(targetIdx)) {
          stopAuto();
          updateGallery(targetIdx);
        }
      });
    });

    carousel.addEventListener("click", () => {
      stopAuto();
      let next = (currentIndex + 1) % images.length;
      updateGallery(next);
    });

    carousel.addEventListener("mouseenter", startAuto);
    carousel.addEventListener("mouseleave", stopAuto);

    if (window.innerWidth <= 768) {
    }
  });

  messages.forEach((msg) => {
    setTimeout(() => {
      msg.style.transition = "all 0.8s cubic-bezier(0.4, 0, 0.2, 1)";
      msg.style.opacity = "0";
      msg.style.transform = "translateY(-30px)";

      setTimeout(() => {
        msg.remove();
        const url = new URL(window.location);
        url.searchParams.delete("success");
        url.searchParams.delete("error");
        window.history.replaceState({}, document.title, url);
      }, 800);
    }, 4000);
  });
});

function openRatingModal() {
  document.getElementById("ratingModal").style.display = "block";
}

function closeRatingModal() {
  document.getElementById("ratingModal").style.display = "none";
}

window.onclick = function (event) {
  let modal = document.getElementById("ratingModal");
  if (event.target == modal) {
    closeRatingModal();
  }
};
