document.addEventListener("DOMContentLoaded", () => {
  const $d = document,
    bubble = $d.getElementById("chat-bubble"),
    chatWindow = $d.getElementById("chat-window"),
    closeBtn = $d.getElementById("chat-close"),
    minimizeBtn = $d.getElementById("chat-minimize"),
    messages = $d.getElementById("chat-messages"),
    input = $d.getElementById("chat-input"),
    sendBtn = $d.getElementById("chat-send");

  const BOT_AVATAR = "assets/img/robot-vectorial-graident-ai.png",
    USER_AVATAR = "assets/img/avatar.png";

  let compareMode = false,
    totalToCompare = 0,
    selectedGames = [],
    currentSelection = null,
    pendingOptions = [];

  if (!bubble) return;

  // ==========================================
  // CONTROL DE ESTADO DEL INPUT
  // ==========================================

  const disableInput = (placeholder = "Selecciona una opción...") => {
    input.disabled = true;
    sendBtn.disabled = true;
    input.placeholder = placeholder;
    input.value = "";
  };

  const enableInput = (placeholder = "Escribe aquí...") => {
    input.disabled = false;
    sendBtn.disabled = false;
    input.placeholder = placeholder;
    input.focus();
  };

  disableInput("Cames se está preparando...");

  // ==========================================
  // SISTEMA DE PERSISTENCIA (LOCAL STORAGE)
  // ==========================================

  const saveChat = () => {
    localStorage.setItem("cames_chat_history", messages.innerHTML);
    localStorage.setItem("cames_chat_opened", "true");
  };

  const loadChat = () => {
    const history = localStorage.getItem("cames_chat_history");
    if (history) {
      messages.innerHTML = history;
      chatWindow.dataset.opened = "true";
      scrollToBottom();
      disableInput("Elige una opción...");
      return true;
    }
    return false;
  };

  const resetCompareLogic = () => {
    compareMode = false;
    totalToCompare = 0;
    selectedGames = [];
    currentSelection = null;
    pendingOptions = [];
  };

  const scrollToBottom = () => (messages.scrollTop = messages.scrollHeight);

  const addMessage = (content, isUser = false, isHTML = false) => {
    const wrapper = document.createElement("div");
    wrapper.className = `message-wrapper ${isUser ? "user-wrapper" : "bot-wrapper"}`;
    wrapper.innerHTML = `
      <div class="avatar" style="background-image: url('${isUser ? USER_AVATAR : BOT_AVATAR}')"></div>
      <div class="message ${isUser ? "user-message" : "bot-message"}">${isHTML ? content : content.replace(/</g, "&lt;").replace(/>/g, "&gt;")}</div>`;

    if (isHTML && !isUser)
      wrapper.querySelector(".bot-message").innerHTML = content;

    messages.appendChild(wrapper);
    scrollToBottom();
    saveChat();
  };

  const showTyping = () => {
    removeTyping();
    const typing = document.createElement("div");
    typing.className = "typing";
    typing.id = "typing-indicator";
    typing.style.cssText =
      "font-size: 0.8em; color: #94a3b8; margin: 5px 45px;";
    typing.textContent = "Cames está escribiendo...";
    messages.appendChild(typing);
    scrollToBottom();
  };

  const removeTyping = () => {
    const indicator = document.getElementById("typing-indicator");
    if (indicator) indicator.remove();
  };

  const showMainOptions = (prefix = "") => {
    resetCompareLogic();
    disableInput("Elige una opción arriba...");
    const html = `<div>${prefix}</div>
      <div class="chat-buttons">
        <button class="btn-quick" onclick="sendQuickAction('top semana', event)">Top Semana</button>
        <button class="btn-quick" onclick="sendQuickAction('top mes', event)">Top Mes</button>
        <button class="btn-quick" onclick="sendQuickAction('buscar', event)">Buscar</button>
        <button class="btn-quick" onclick="sendQuickAction('modo comparar', event)">Comparar</button>
      </div>`;
    addMessage(html, false, true);
  };

  const welcomeUser = () => {
    const nombreUsuario = $d.body.dataset.userName || "Gamer";
    const isLoggedIn = nombreUsuario !== "Gamer";

    showTyping();
    setTimeout(() => {
      removeTyping();

      if (isLoggedIn) {
        addMessage(
          `👋 Hola <b>${nombreUsuario}</b>, encantada de verte por aquí.`,
          false,
          true,
        );
      }
      setTimeout(() => {
        showMainOptions("¿En que puedo ayudarte hoy?");
      }, 800);
    }, 1000);
  };

  // ==========================================
  // LÓGICA DE INTERACCIÓN Y BÚSQUEDA
  // ==========================================

  window.selectGameFromList = (gameName, event) => {
    if (event?.target) {
      event.target
        .closest(".chat-buttons")
        ?.querySelectorAll("button")
        .forEach((b) => {
          b.disabled = true;
        });
    }

    const gameData = pendingOptions.find((g) => g.name === gameName);

    if (gameData) {
      currentSelection = {
        name: gameData.name,
        rating: gameData.rating || "N/A",
        players: gameData.added ? gameData.added.toLocaleString() : "N/A",
        categories: gameData.genres
          ? gameData.genres.map((g) => g.name).join(", ")
          : "General",
        link: "index.php?controller=Games&action=detalle&id=" + gameData.id,
      };

      addMessage(gameName, true);
      pendingOptions = [];
      disableInput("Confirmando...");

      const msg = compareMode
        ? `¿Confirmas añadir <b>${gameName}</b> a la comparativa?`
        : `¿Es <b>${gameName}</b> el juego que buscas?`;
      addMessage(msg, false, true);

      const html = `<div class="chat-buttons">
        <button class="btn-quick" onclick="sendQuickAction('sí, es este', event)">Sí, es este</button>
        <button class="btn-quick" onclick="sendQuickAction('no, ver otros', event)">No, ver otros</button>
      </div>`;
      addMessage(html, false, true);
    }
  };

  const handleNormalSearch = (data) => {
    if (data.response.toLowerCase().includes("top")) {
      addMessage(
        data.response.replace(/(\d\.)/g, "<br><b>$1</b>"),
        false,
        true,
      );
      setTimeout(() => showMainOptions("¿Quieres ver algo más?"), 1000);
      return;
    }

    if (data.options && data.options.length > 1) {
      pendingOptions = data.rawResults || data.options;
      disableInput("Selecciona un juego...");
      addMessage("He encontrado varios resultados. ¿Cuál buscas?", false);
      const html =
        `<div class="chat-buttons">` +
        data.options
          .map(
            (opt) =>
              `<button class="btn-quick" onclick="selectGameFromList('${opt.name.replace(/'/g, "\\'")}', event)">${opt.name}</button>`,
          )
          .join("") +
        `<button class="btn-quick" onclick="sendQuickAction('no, ver otros', event)">No, ver otros</button>
        </div>`;
      addMessage(html, false, true);
    } else if (data.gameName) {
      currentSelection = {
        name: data.gameName,
        rating: data.rating,
        players: data.added ? data.added.toLocaleString() : "N/A",
        categories: data.categories,
        link: data.gameLink,
      };
      disableInput("Confirma con los botones...");
      addMessage(data.response, false, true);
      addMessage(
        `<div class="chat-buttons">
        <button class="btn-quick" onclick="sendQuickAction('sí, es este', event)">Sí, es este</button>
        <button class="btn-quick" onclick="sendQuickAction('no, ver otros', event)">No, ver otros</button>
      </div>`,
        false,
        true,
      );
    } else {
      addMessage(data.response, false, true);
      enableInput("Prueba con otro nombre...");
    }
  };

  const handleCompareSearch = (userInput, data) => {
    if (data.options && data.options.length > 1) {
      pendingOptions = data.rawResults || data.options;
      disableInput("Selecciona de la lista...");
      addMessage("He encontrado varios. ¿Cuál quieres comparar?", false);
      const html =
        `<div class="chat-buttons">` +
        data.options
          .map(
            (opt) =>
              `<button class="btn-quick" onclick="selectGameFromList('${opt.name.replace(/'/g, "\\'")}', event)">${opt.name}</button>`,
          )
          .join("") +
        `</div>`;
      addMessage(html, false, true);
    } else if (data.gameName) {
      currentSelection = {
        name: data.gameName,
        rating: data.rating,
        players: data.added ? data.added.toLocaleString() : "N/A",
        categories: data.categories,
      };
      disableInput();
      addMessage(
        `¿Confirmas añadir <b>${data.gameName}</b> a la comparativa?`,
        false,
        true,
      );
      addMessage(
        `<div class="chat-buttons">
        <button class="btn-quick" onclick="sendQuickAction('sí, es este', event)">Sí, añadir</button>
        <button class="btn-quick" onclick="sendQuickAction('no, ver otros', event)">No, buscar otro</button>
      </div>`,
        false,
        true,
      );
    } else {
      addMessage(data.response, false, true);
      enableInput("Dime el nombre de nuevo...");
    }
  };

  const handleConfirmation = (res) => {
    if (res === "sí, es este") {
      if (compareMode) {
        selectedGames.push(currentSelection);
        const count = selectedGames.length;
        currentSelection = null;
        if (count < totalToCompare) {
          addMessage(
            `✅ Juego ${count} añadido. Dime el nombre del <b>Juego ${count + 1}</b>:`,
            false,
            true,
          );
          enableInput(`Escribe el nombre del Juego ${count + 1}...`);
        } else {
          showFinalComparison();
        }
      } else {
        const infoHTML = `
          <div style='margin-bottom:8px; font-weight:bold; color:#a685ff;'>Información de ${currentSelection.name}:</div>
          <table style='width:100%; border-collapse:collapse;'>
            <tr><td style='font-size:0.9em;'>⭐ Valoración: ${currentSelection.rating} / 5</td></tr>
            <tr><td style='font-size:0.9em;'>👥 Jugadores: ${currentSelection.players}</td></tr>
            <tr><td style='font-size:0.9em;'>🏷️ Categoría: ${currentSelection.categories}</td></tr>
          </table>
          <div class="chat-buttons" style="margin-top:10px;"><a href="${currentSelection.link}" target="_blank" class="btn-details" style="text-decoration:none; background:var(--primary); padding:5px 10px; border-radius:5px; color:white; font-size:0.8em;">Ver ficha completa</a></div>`;
        addMessage(infoHTML, false, true);
        setTimeout(() => showMainOptions("¿Quieres buscar otra cosa?"), 1200);
      }
    } else {
      currentSelection = null;
      addMessage("Entendido. Dime el nombre de nuevo:", false);
      enableInput("Nombre del juego...");
    }
  };

  const showFinalComparison = () => {
    disableInput("Generando comparativa...");
    addMessage(
      `📊 <b>Comparando:</b> ${selectedGames.map((g) => g.name).join(" vs ")}...`,
      false,
      true,
    );
    showTyping();
    setTimeout(() => {
      removeTyping();
      let tableHTML = `<div class="compare-container" style="overflow-x: auto; margin-top: 10px;">
          <table class="compare-table" style="width:100%; border-collapse: collapse; background: #1e2530; color: white; border-radius: 8px; font-size:0.85em;">
            <thead>
              <tr style="background: #333; color: #a685ff;">
                <th style="padding: 8px; border: 1px solid #444; text-align: left;">Característica</th>
                ${selectedGames.map((g) => `<th style="padding: 8px; border: 1px solid #444; text-align: center;">${g.name}</th>`).join("")}
              </tr>
            </thead>
            <tbody>
              <tr><td style="padding: 8px; border: 1px solid #444; font-weight: bold;">⭐ Rating</td>
                ${selectedGames.map((g) => `<td style="padding: 8px; border: 1px solid #444; text-align: center;">${g.rating}/5</td>`).join("")}
              </tr>
              <tr><td style="padding: 8px; border: 1px solid #444; font-weight: bold;">👥 Jugadores</td>
                ${selectedGames.map((g) => `<td style="padding: 8px; border: 1px solid #444; text-align: center;">${g.players}</td>`).join("")}
              </tr>
              <tr><td style="padding: 8px; border: 1px solid #444; font-weight: bold;">🎮 Géneros</td>
                ${selectedGames.map((g) => `<td style="padding: 8px; border: 1px solid #444; font-size:0.8em;">${g.categories}</td>`).join("")}
              </tr>
            </tbody>
          </table>
        </div>`;
      addMessage(tableHTML, false, true);
      showMainOptions("¿Qué quieres hacer ahora?");
    }, 1500);
  };

  window.sendQuickAction = (text, e) => {
    if (e?.target) {
      e.target
        .closest(".chat-buttons")
        ?.querySelectorAll("button")
        .forEach((b) => {
          b.disabled = true;
        });
    }
    const clean = text.trim().toLowerCase();

    if (clean === "buscar") {
      addMessage("Buscar juego", true);
      enableInput("¿Qué juego buscas?");
    } else if (clean === "modo comparar") {
      addMessage("Comparar juegos", true);
      compareMode = true;
      disableInput("Selecciona cantidad...");
      addMessage("¿Cuántos juegos quieres comparar?", false);
      addMessage(
        `<div class="chat-buttons">
        <button class="btn-quick" onclick="sendQuickAction('comparar 2', event)">2 Juegos</button>
        <button class="btn-quick" onclick="sendQuickAction('comparar 3', event)">3 Juegos</button>
      </div>`,
        false,
        true,
      );
    } else if (clean.startsWith("comparar ")) {
      totalToCompare = parseInt(clean.split(" ")[1]);
      addMessage(`${totalToCompare} juegos`, true);
      addMessage("Dime el nombre del <b>Juego 1</b>:", false, true);
      enableInput("Escribe el nombre del Juego 1...");
    } else if (clean === "sí, es este" || clean === "sí, añadir") {
      addMessage(text, true);
      handleConfirmation("sí, es este");
    } else if (clean === "no, ver otros" || clean === "no, ver otros") {
      addMessage(text, true);
      handleConfirmation("no");
    } else {
      sendMessage(text);
    }
  };

  const sendMessage = (custom = null) => {
    const text = (custom || input.value).trim();
    if (!text) return;

    addMessage(text, true);
    input.value = "";
    disableInput("Cames está pensando...");

    showTyping();
    fetch("index.php?controller=Bot&action=responder", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ message: text }),
    })
      .then((r) => r.json())
      .then((data) => {
        removeTyping();
        if (data.options && data.options.length > 0 && data.options[0].link) {
          addMessage(data.response, false, true);
          const html =
            `<div class="chat-buttons">` +
            data.options
              .map(
                (opt) =>
                  `<button class="btn-quick" onclick="window.location.href='${opt.link}'">${opt.name}</button>`,
              )
              .join("") +
            `</div>`;
          addMessage(html, false, true);
          return;
        }
        compareMode
          ? handleCompareSearch(text, data)
          : handleNormalSearch(data);
      })
      .catch(() => {
        removeTyping();
        addMessage("Error de conexión con Cames.", false);
        enableInput();
      });
  };

  // ==========================================
  // MANEJO DE EVENTOS DE VENTANA
  // ==========================================

  bubble.addEventListener("click", () => {
    chatWindow.classList.toggle("chat-hidden");
    if (
      !chatWindow.dataset.opened &&
      !chatWindow.classList.contains("chat-hidden") &&
      !localStorage.getItem("cames_chat_history")
    ) {
      welcomeUser();
      chatWindow.dataset.opened = "true";
    }
  });

  sendBtn.addEventListener("click", () => sendMessage());
  input.addEventListener("keypress", (e) => e.key === "Enter" && sendMessage());

  minimizeBtn?.addEventListener("click", (e) => {
    e.stopPropagation();
    chatWindow.classList.add("chat-hidden");
  });

  closeBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    messages.innerHTML = "";
    localStorage.removeItem("cames_chat_history");
    localStorage.removeItem("cames_chat_opened");
    delete chatWindow.dataset.opened;
    resetCompareLogic();
    disableInput();
    chatWindow.classList.add("chat-hidden");
  });

  loadChat();
});
