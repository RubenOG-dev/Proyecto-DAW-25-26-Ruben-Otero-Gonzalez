document.addEventListener("DOMContentLoaded", () => {
    const slider = document.querySelector(".games-slider");
    const cards = document.querySelectorAll(".game-card");
    const [prevBtn, nextBtn] = [".arrow.prev", ".arrow.next"].map(s => document.querySelector(s));

    if (!slider || !cards.length) return;

    const totalOriginals = cards.length;
    const GAP = 10;

    slider.appendChild(cards[0].cloneNode(true));
    slider.appendChild(cards[1].cloneNode(true));
    slider.prepend(cards[totalOriginals - 1].cloneNode(true));

    let currentIndex = 1;
    let isTransitioning = false;

    const updatePosition = (smooth = true) => {
        const cardWidth = slider.querySelector(".game-card").offsetWidth;
        slider.style.transition = smooth ? "transform 0.4s ease-out" : "none";
        slider.style.transform = `translateX(${-currentIndex * (cardWidth + GAP)}px)`;
    };

    const move = (direction) => {
        if (isTransitioning) return;
        isTransitioning = true;
        currentIndex += direction;
        updatePosition();
    };

    nextBtn.onclick = () => move(1);
    prevBtn.onclick = () => move(-1);

    slider.addEventListener("transitionend", () => {
        isTransitioning = false;
        if (currentIndex >= totalOriginals + 1) currentIndex = 1;
        else if (currentIndex <= 0) currentIndex = totalOriginals;
        else return;
        
        updatePosition(false);
    });

    ["load", "resize"].forEach(evt => window.addEventListener(evt, () => updatePosition(false)));
});