const state = {
  page: 1,
  order: "",
  topDates: "",
};

window.toggleSection = function (btn) {
  const container = btn.closest(".filter-group");
  const extra = container.querySelector(".extra-items");
  const span = btn.querySelector("span");
  const icon = btn.querySelector("i");

  if (extra.style.display === "none" || extra.style.display === "") {
    extra.style.display = "block";
    span.textContent = "Hide";
    icon.className = "fas fa-chevron-up";
  } else {
    extra.style.display = "none";
    span.textContent = "Show all";
    icon.className = "fas fa-chevron-down";
  }
};

document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("searchInput");
  const btnLoadMore = document.getElementById("btnLoadMore");
  const btnReset = document.getElementById("btnResetFilters");
  const dropdown = document.getElementById("yearDropdown");
  const header = dropdown.querySelector(".dropdown-header");
  const optionsContainer = document.getElementById("yearOptions");
  const selectedText = document.getElementById("selectedYearText");
  const openBtn = document.getElementById("openFilters");
  const sidebar = document.querySelector(".sidebar-filters");
  const overlay = document.createElement("div");
  const currentYear = new Date().getFullYear();
  const closeBtn = document.querySelector(".mobile-close-sidebar");
  const rawgGenres = [
    { id: 4, name: "Action", slug: "action" },
    { id: 51, name: "Indie", slug: "indie" },
    { id: 3, name: "Adventure", slug: "adventure" },
    { id: 5, name: "RPG", slug: "role-playing-games-rpg" },
    { id: 10, name: "Strategy", slug: "strategy" },
    { id: 2, name: "Shooter", slug: "shooter" },
    { id: 40, name: "Casual", slug: "casual" },
    { id: 14, name: "Simulation", slug: "simulation" },
    { id: 7, name: "Puzzle", slug: "puzzle" },
    { id: 11, name: "Arcade", slug: "arcade" },
    { id: 83, name: "Platformer", slug: "platformer" },
    { id: 59, name: "Massively Multiplayer", slug: "massively-multiplayer" },
    { id: 1, name: "Racing", slug: "racing" },
    { id: 15, name: "Sports", slug: "sports" },
    { id: 6, name: "Fighting", slug: "fighting" },
    { id: 19, name: "Family", slug: "family" },
    { id: 28, name: "Board Games", slug: "board-games" },
    { id: 34, name: "Educational", slug: "educational" },
    { id: 17, name: "Card", slug: "card" },
  ];
  const cerrarFiltros = () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
    document.body.style.overflow = "";
  };

  overlay.className = "sidebar-overlay";
  document.body.appendChild(overlay);

  if (openBtn) {
    openBtn.addEventListener("click", () => {
      sidebar.classList.add("active");
      overlay.classList.add("active");
      document.body.style.overflow = 'hidden';
    });
  }
  if (closeBtn) closeBtn.addEventListener('click', cerrarFiltros);
  if (overlay) overlay.addEventListener('click', cerrarFiltros);

  for (let year = currentYear; year >= 1960; year--) {
    const item = document.createElement("div");
    item.className = "dropdown-option";
    item.textContent = `Mejores de ${year}`;
    item.dataset.value = year;

    item.onclick = () => {
      searchInput.value = "";

      selectedText.textContent = `Mejores de ${year}`;
      dropdown.classList.remove("open");
      dropdown.classList.add("active");

      state.topDates = `${year}-01-01,${year}-12-31`;

      const selectedYearInt = parseInt(year);
      const actualYear = new Date().getFullYear();

      if (selectedYearInt === actualYear) {
        state.order = "-rating";
      } else if (selectedYearInt < 1995) {
        state.order = "-added";
      } else {
        state.order = "-metacritic";
      }

      state.page = 1;
      getGames(1, false);
    };
    optionsContainer.appendChild(item);
  }

  const renderGenres = () => {
    const container = document.getElementById("genresContainer");
    if (!container) return;

    const genreIcons = {
      action: "fa-fist-raised",
      indie: "fa-rocket",
      adventure: "fa-map-marked-alt",
      "role-playing-games-rpg": "fa-dragon",
      strategy: "fa-chess",
      shooter: "fa-crosshairs",
      casual: "fa-couch",
      simulation: "fa-laptop-code",
      puzzle: "fa-puzzle-piece",
      arcade: "fa-gamepad",
      platformer: "fa-shoe-prints",
      "massively-multiplayer": "fa-users",
      racing: "fa-flag-checkered",
      sports: "fa-football-ball",
      fighting: "fa-hand-rock",
      family: "fa-child",
      "board-games": "fa-dice",
      educational: "fa-graduation-cap",
      card: "fa-id-badge",
    };

    container.innerHTML = "";
    const mainGenres = rawgGenres.slice(0, 4);
    const extraGenres = rawgGenres.slice(4);

    const createGenreHTML = (genre) => {
      const iconClass = genreIcons[genre.slug] || "fa-gamepad";
      return `
            <label class="nav-item">
                <input type="checkbox" value="${genre.slug}" class="genre-check">
                <div class="nav-icon"><i class="fas ${iconClass}"></i></div>
                <span>${genre.name}</span>
            </label>
        `;
    };

    const mainContent = document.querySelector(".main-content");

    mainContent.addEventListener("scroll", () => {
      if (
        mainContent.scrollTop + mainContent.clientHeight >=
        mainContent.scrollHeight - 100
      ) {
        console.log("Has llegado al final del contenedor de juegos");
      }
    });

    mainGenres.forEach((g) =>
      container.insertAdjacentHTML("beforeend", createGenreHTML(g)),
    );

    const extraDiv = document.createElement("div");
    extraDiv.className = "extra-items";
    extraDiv.style.display = "none";
    extraGenres.forEach((g) =>
      extraDiv.insertAdjacentHTML("beforeend", createGenreHTML(g)),
    );
    container.appendChild(extraDiv);

    container.insertAdjacentHTML(
      "beforeend",
      `
        <div class="toggle-btn" onclick="toggleSection(this)">
            <div class="nav-icon"><i class="fas fa-chevron-down"></i></div>
            <span>Show all</span>
        </div>
    `,
    );

    container.querySelectorAll(".genre-check").forEach((check) => {
      check.addEventListener("change", function () {
        const checkedGenres = container.querySelectorAll(
          ".genre-check:checked",
        );

        if (checkedGenres.length > 3) {
          this.checked = false;
          if (typeof showToast === "function") {
            showToast("Máximo 3 géneros permitidos");
          } else {
            alert("Máximo 3 géneros permitidos");
          }
          return;
        }

        container.querySelectorAll(".genre-check").forEach((c) => {
          const parent = c.closest(".nav-item");
          if (checkedGenres.length >= 3 && !c.checked) {
            parent.style.opacity = "0.3";
            parent.style.cursor = "not-allowed";
            c.disabled = true;
          } else {
            parent.style.opacity = "1";
            parent.style.cursor = "pointer";
            c.disabled = false;
          }
        });

        const parent = this.closest(".nav-item");
        this.checked
          ? parent.classList.add("active")
          : parent.classList.remove("active");

        state.page = 1;
        getGames(1, false);
      });
    });
  };

  header.onclick = (e) => {
    e.stopPropagation();
    dropdown.classList.toggle("open");
  };

  document.addEventListener("click", () => {
    dropdown.classList.remove("open");
  });

  const getCols = () => {
    const ids = ["col-0", "col-1", "col-2"];
    return ids
      .map((id) => document.getElementById(id))
      .filter((el) => el !== null);
  };

  const clearCols = () => {
    getCols().forEach((col) => {
      if (col) col.innerHTML = "";
    });
  };

  const getGames = async (
    page = 1,
    append = false,
    accumulatedResults = [],
  ) => {
    const gamesGrid = document.querySelector(".games-grid");
    const cols = getCols();
    const selectedGenres = Array.from(
      document.querySelectorAll(".genre-check:checked"),
    ).map((c) => c.value);
    const selectedPlatformsArr = Array.from(
      document.querySelectorAll(".platform-check:checked"),
    ).map((c) => parseInt(c.value));

    const searchInputValue = document
      .getElementById("searchInput")
      .value.toLowerCase()
      .trim();

    if (!cols.length || !gamesGrid) return;

    if (!append && accumulatedResults.length === 0) {
      gamesGrid.style.opacity = "0.5";
      gamesGrid.style.pointerEvents = "none";
      clearCols();
      cols.forEach((col, index) => {
        col.innerHTML = `
                    <div class="skeleton-card"><div class="skeleton-img"></div><div class="skeleton-text"></div></div>
                    <div class="skeleton-card"><div class="skeleton-img"></div><div class="skeleton-text"></div></div>
                `;
      });
    }

    if (accumulatedResults.length > 0) {
      let msg = document.getElementById("search-status-msg");
      if (!msg) {
        msg = document.createElement("div");
        msg.id = "search-status-msg";
        msg.style =
          "position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.8); color: #fff; padding: 10px 20px; border-radius: 20px; z-index: 1000; border: 1px solid #555; font-size: 0.9rem;";
        document.body.appendChild(msg);
      }
      msg.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Aplicando filtros estrictos... Encontrados: ${accumulatedResults.length}/6`;
    }

    let url = `index.php?controller=Games&action=catalogo&ajax=1&page=${page}`;
    const genresParam = selectedGenres.join(",");
    const parentPlatforms = selectedPlatformsArr.join(",");
    const query = state.topDates ? "" : searchInputValue;

    if (query) url += `&search=${encodeURIComponent(query)}`;
    if (genresParam) url += `&genres=${genresParam}`;
    if (parentPlatforms) url += `&parent_platforms=${parentPlatforms}`;
    if (state.topDates) url += `&dates=${state.topDates}`;
    if (state.order) url += `&ordering=${state.order}`;

    try {
      const response = await fetch(url);
      const data = await response.json();

      if (!append && accumulatedResults.length === 0) {
        document.querySelectorAll(".skeleton-card").forEach((s) => s.remove());
      }

      if (data.results && data.results.length > 0) {
        let filtered = data.results.filter((game) => {

          const gameGenres = (game.genres || []).map((g) => g.slug);
          const matchesGenres = selectedGenres.every((slug) =>
            gameGenres.includes(slug),
          );

          const gamePlatforms =
            game.parent_platforms?.map((p) => p.platform.id) || [];
          const matchesPlatforms = selectedPlatformsArr.every((id) =>
            gamePlatforms.includes(id),
          );
          const matchesSearch =
            query === "" || game.name.toLowerCase().includes(query);

          return matchesGenres && matchesPlatforms && matchesSearch;
        });

        const totalNow = [...accumulatedResults, ...filtered];
        filtered.forEach((game) => {
          const card = createGameCard(game);
          const visibleCols = cols.filter(
            (c) => getComputedStyle(c).display !== "none",
          );
          const shortestCol = visibleCols.reduce((p, c) =>
            p.offsetHeight <= c.offsetHeight ? p : c,
          );
          shortestCol.appendChild(card);
        });
        if (totalNow.length < 6 && data.next) {
          state.page++;
          return await getGames(state.page, true, totalNow);
        }

        if (totalNow.length === 0 && !append) {
          gamesGrid.innerHTML =
            '<p style="color:white; text-align:center; width:100%;">No hay juegos que cumplan todos los requisitos. Prueba a quitar algún filtro.</p>';
        }
      }
    } catch (e) {
      console.error("Error:", e);
    } finally {
      gamesGrid.style.opacity = "1";
      gamesGrid.style.pointerEvents = "auto";
      const msg = document.getElementById("search-status-msg");
      if (msg) msg.remove();
      document.querySelectorAll(".skeleton-card").forEach((s) => s.remove());
    }
  };

  function createGameCard(game) {
    const article = document.createElement("article");
    article.className = "game-card-catalog";

    const placeholder = "assets/img/No-Image-Placeholder.png";
    const defaultImg = game.background_image || placeholder;

    const platformIcons =
      game.parent_platforms
        ?.map((p) => {
          const s = p.platform.slug;
          if (s === "pc") return '<i class="fab fa-windows" title="PC"></i>';
          if (s === "playstation")
            return '<i class="fab fa-playstation" title="PlayStation"></i>';
          if (s === "xbox") return '<i class="fab fa-xbox" title="Xbox"></i>';
          if (s === "nintendo")
            return '<i class="fas fa-gamepad" title="Nintendo"></i>';
          if (s === "android" || s === "ios")
            return '<i class="fas fa-mobile-alt" title="Mobile"></i>';
          return "";
        })
        .join("") || "";

    const metacriticScore = game.metacritic;
    let metaClass = "hide";
    if (metacriticScore) {
      metaClass =
        metacriticScore >= 75 ? "high" : metacriticScore >= 50 ? "med" : "low";
    }

    const activeGenreSlugs = Array.from(
      document.querySelectorAll(".genre-check:checked"),
    ).map((c) => c.value);
    const gameGenres = game.genres || [];

    const matched = gameGenres.filter((g) => activeGenreSlugs.includes(g.slug));
    const others = gameGenres.filter((g) => !activeGenreSlugs.includes(g.slug));

    const prioritizedGenres = [...matched, ...others].slice(0, 3);

    const genresText =
      prioritizedGenres
        .map((g) => {
          const isMatch = activeGenreSlugs.includes(g.slug);
          return isMatch
            ? `<strong style="color: #fff; font-weight: 700; text-shadow: 0 0 8px rgba(255,255,255,0.4);">${g.name}</strong>`
            : g.name;
        })
        .join(", ") || "N/A";

    const images = (game.short_screenshots && game.short_screenshots.length > 0)
      ? game.short_screenshots.map((s) => s.image)
      : [defaultImg];

    article.innerHTML = `
            <div class="card-img-wrapper">
                <img src="${defaultImg || "assets/img/No-Image-Placeholder.png"}" class="main-img" loading="lazy">
                <div class="img-progress-bar">
                    ${images.map((_, idx) => `<div class="progress-segment ${idx === 0 ? "active" : ""}"></div>`).join("")}
                </div>
                <span class="metacritic-badge ${metaClass}" data-tooltip="Puntuación de Metacritic">${metacriticScore || ""}</span>
            </div>
            <div class="card-info">
                <div class="platform-icons">${platformIcons}</div>
                <h3 style="margin: 5px 0; font-size: 1.4rem;">${game.name}</h3>
                <div class="extra-content">
                    <div class="info-row"><span>Release date:</span><span>${game.released || "TBA"}</span></div>
                    <div class="info-row"><span>Genres:</span><span class="genre-link">${genresText}</span></div>
                    <button class="btn-show-more-card">Ver más detalles <i class="fas fa-chevron-right" ></i></button>
                </div>
            </div>`;

    let interval;
    article.addEventListener("mouseenter", () => {
      if (images.length <= 1) return;
      let i = 0;
      const imgElement = article.querySelector(".main-img");
      interval = setInterval(() => {
        i = (i + 1) % images.length;
        imgElement.src = images[i];
        const segments = article.querySelectorAll(".progress-segment");
        segments.forEach((s, idx) => s.classList.toggle("active", idx === i));
      }, 1200);
    });

    article.addEventListener("mouseleave", () => {
      clearInterval(interval);
      article.querySelector(".main-img").src = defaultImg;
      const segments = article.querySelectorAll(".progress-segment");
      segments.forEach((s, idx) => s.classList.toggle("active", idx === 0));
    });

    article.onclick = () => {
      window.location.href = `index.php?controller=Games&action=detalle&id=${game.id}`;
    };

    return article;
  }

  document.querySelectorAll(".top-filter").forEach((item) => {
    item.addEventListener("click", function () {
      const wasActive = this.classList.contains("active");

      document
        .querySelectorAll(".top-filter")
        .forEach((i) => i.classList.remove("active"));

      if (wasActive) {
        state.topDates = "";
        state.order = "";
        document
          .querySelectorAll(".order-filter")
          .forEach((o) => o.classList.remove("active"));
      } else {
        this.classList.add("active");

        const now = new Date();
        const todayStr = now.toISOString().split("T")[0];

        if (this.dataset.value === "weekly") {
          const lastWeek = new Date();
          lastWeek.setDate(now.getDate() - 7);
          state.topDates = `${lastWeek.toISOString().split("T")[0]},${todayStr}`;
        } else {
          const monthStart = new Date(now.getFullYear(), now.getMonth(), 1);
          state.topDates = `${monthStart.toISOString().split("T")[0]},${todayStr}`;
        }

        state.order = "-metacritic";
        document.querySelectorAll(".order-filter").forEach((off) => {
          off.classList.toggle("active", off.dataset.value === "-metacritic");
        });
      }
      state.page = 1;
      getGames(1, false);
    });
  });

  document.querySelectorAll(".order-filter").forEach((item) => {
    item.addEventListener("click", function () {
      const baseValue = this.dataset.value.replace("-", "");
      const isCurrentlyActive = this.classList.contains("active");

      document.querySelectorAll(".order-filter").forEach((i) => {
        if (i !== this) {
          i.classList.remove("active", "ascending");
        }
      });

      if (isCurrentlyActive) {
        if (state.order.startsWith("-")) {
          state.order = baseValue;
          this.classList.add("ascending");
        } else {
          state.order = `-${baseValue}`;
          this.classList.remove("ascending");
        }
      } else {
        state.order = `-${baseValue}`;
        this.classList.add("active");
        this.classList.remove("ascending");
      }

      state.page = 1;
      getGames(1, false);
    });
  });

  document.querySelectorAll(".platform-check").forEach((check) => {
    check.addEventListener("change", function () {
      const parent = this.closest(".nav-item");
      this.checked
        ? parent.classList.add("active")
        : parent.classList.remove("active");
      state.topDates = "";
      document
        .querySelectorAll(".top-filter")
        .forEach((i) => i.classList.remove("active"));
      state.page = 1;
      getGames(1, false);
    });
  });

  document.querySelectorAll(".genre-check").forEach((check) => {
    check.addEventListener("change", function () {
      const checkedCount = document.querySelectorAll(
        ".genre-check:checked",
      ).length;
      if (checkedCount > 3 && this.checked) {
        this.checked = false;
        showToast("Máximo 3 géneros permitidos");
        return;
      }
    });
  });

  searchInput.addEventListener(
    "input",
    debounce(() => {
      state.page = 1;
      getGames(1, false);
    }, 500),
  );

  if (btnLoadMore) {
    btnLoadMore.addEventListener("click", () => {
      state.page++;
      getGames(state.page, true);
    });
  }

  function debounce(f, w) {
    let t;
    return (...a) => {
      clearTimeout(t);
      t = setTimeout(() => f(...a), w);
    };
  }

  if (btnReset) {
    btnReset.addEventListener("click", () => {
      state.page = 1;
      state.order = "";
      state.topDates = "";
      searchInput.value = "";

      document
        .querySelectorAll(".platform-check, .genre-check")
        .forEach((c) => {
          c.checked = false;
          c.disabled = false;
          c.closest(".nav-item").style.opacity = "1";
        });

      document
        .querySelectorAll(".nav-item, .top-filter, .order-filter")
        .forEach((i) => {
          i.classList.remove("active", "ascending");
        });

      const selectedText = document.getElementById("selectedYearText");
      const dropdown = document.getElementById("yearDropdown");
      if (selectedText) selectedText.textContent = "Seleccionar año";
      if (dropdown) dropdown.classList.remove("active", "open");

      getGames(1, false);
    });
  }

  const yearSelector = document.getElementById("yearSelector");

  if (yearSelector) {
    const currentYear = new Date().getFullYear();
    for (let year = currentYear; year >= 1960; year--) {
      const option = document.createElement("option");
      option.value = year;
      option.textContent = `Mejores de ${year}`;
      yearSelector.appendChild(option);
    }

    yearSelector.addEventListener("change", function () {
      const selectedYear = this.value;

      document
        .querySelectorAll(".top-filter")
        .forEach((i) => i.classList.remove("active"));

      if (selectedYear === "") {
        state.topDates = "";
        this.closest(".nav-item").classList.remove("active");
      } else {
        this.closest(".nav-item").classList.add("active");

        state.topDates = `${selectedYear}-01-01,${selectedYear}-12-31`;

        if (parseInt(selectedYear) < 1995) {
          state.order = "-added";
        } else {
          state.order = "-metacritic";
        }

        document.querySelectorAll(".order-filter").forEach((off) => {
          const isRating =
            off.dataset.value.includes("rating") ||
            off.dataset.value.includes("metacritic");
          const isPopular = off.dataset.value.includes("added");

          if (parseInt(selectedYear) < 1995) {
            off.classList.toggle("active", isPopular);
          } else {
            off.classList.toggle("active", isRating);
          }
        });
      }

      state.page = 1;
      getGames(1, false);
    });
  }

  renderGenres();

  getGames(1, false);
});

function showToast(text) {
  let msg = document.getElementById("filter-toast");
  if (!msg) {
    msg = document.createElement("div");
    msg.id = "filter-toast";
    msg.style =
      "position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); background: #ff4757; color: white; padding: 12px 25px; border-radius: 30px; z-index: 2000; font-weight: bold; box-shadow: 0 5px 15px rgba(0,0,0,0.3); transition: all 0.3s ease; display: none;";
    document.body.appendChild(msg);
  }
  msg.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${text}`;
  msg.style.display = "block";
  msg.style.opacity = "1";
  setTimeout(() => {
    msg.style.opacity = "0";
    setTimeout(() => {
      msg.style.display = "none";
    }, 300);
  }, 2500);
}
