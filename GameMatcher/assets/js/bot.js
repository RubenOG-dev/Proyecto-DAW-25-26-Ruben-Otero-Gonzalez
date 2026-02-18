document.addEventListener("DOMContentLoaded", () => {
  const bubble = document.getElementById("chat-bubble");
  const chatWindow = document.getElementById("chat-window");
  const closeBtn = document.getElementById("chat-close"); 
  const minimizeBtn = document.getElementById("chat-minimize"); 
  const messages = document.getElementById("chat-messages");
  const input = document.getElementById("chat-input");
  const sendBtn = document.getElementById("chat-send");

  // Rutas actualizadas: al entrar por index.php, las rutas son relativas a la raíz
  const BOT_AVATAR = "img/robot-vectorial-graident-ai.png";
  const USER_AVATAR = "img/avatar.png";

  if (!bubble) return;

  function sendWelcomeMessage() {
    const welcomeHTML = `👋 Hola! Soy Botti el asistente de GameMatcher.<br><br>Podes escribirme o hacer click en estos atajos:
                <div class="chat-buttons">
                    <button class="btn-quick" onclick="sendQuickAction('top semana', event)"> Top Semana</button>
                    <button class="btn-quick" onclick="sendQuickAction('top mes', event)"> Top Mes</button>
                    <button class="btn-quick" onclick="sendQuickAction('buscar ', event)"> Buscar</button>
                </div>`;
    addBotMessage(welcomeHTML, true);
  }

  bubble.addEventListener("click", () => {
    chatWindow.classList.toggle("chat-hidden");
    if (!chatWindow.dataset.opened && !chatWindow.classList.contains("chat-hidden")) {
      sendWelcomeMessage();
      chatWindow.dataset.opened = "true";
    }
  });

  window.sendQuickAction = function (text, event) {
    if (event && event.target) {
      const container = event.target.closest('.chat-buttons');
      if (container) {
        const buttons = container.querySelectorAll('button');
        buttons.forEach(btn => {
          btn.disabled = true;
          btn.classList.add('btn-disabled');
        });
      }
    }

    if (text === "buscar ") {
      input.value = "Buscar ";
      input.focus();
    } else {
      sendMessage(text);
    }
  };

  if (minimizeBtn) {
    minimizeBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      chatWindow.classList.add("chat-hidden");
    });
  }

  closeBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    messages.innerHTML = "";
    delete chatWindow.dataset.opened;
    chatWindow.classList.add("chat-hidden");
  });

  sendBtn.addEventListener("click", () => sendMessage());
  input.addEventListener("keypress", (e) => {
    if (e.key === "Enter") sendMessage();
  });

  function sendMessage(customText = null) {
    const text = customText || input.value.trim();
    if (!text) return;

    addUserMessage(text);
    input.value = "";
    showTyping();

    // Fetch actualizado para usar el Front Controller
    fetch("index.php?controller=Bot&action=responder", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ message: text }),
    })
      .then((res) => res.json())
      .then((data) => {
        removeTyping();
        addBotMessage(data.response);

        if (data.gameLink) {
          setTimeout(() => {
            const linkHTML = `
              <div class="chat-buttons">
                <a href="${data.gameLink}" target="_blank" class="btn-details">
                   Ver mas detalles
                </a>
              </div>`;
            addBotMessage(linkHTML, true);
          }, 400);
        }

        if (data.options && data.options.length > 0) {
          setTimeout(() => {
            let optionsHTML = `Cuál de ellos buscas? <div class="chat-buttons">`;
            data.options.forEach((opt) => {
              optionsHTML += `<button class="btn-quick" onclick="sendQuickAction('${opt.name}', event)"> ${opt.name}</button>`;
            });
            optionsHTML += `</div>`;
            addBotMessage(optionsHTML, true);
          }, 600);
        } else if (!data.gameLink) {
          setTimeout(() => {
            const followUpHTML = `
              ¿Quieres consultar algo más?
              <div class="chat-buttons">
                  <button class="btn-quick" onclick="sendQuickAction('top semana', event)"> Top Semana</button>
                  <button class="btn-quick" onclick="sendQuickAction('top mes', event)"> Top Mes</button>
                  <button class="btn-quick" onclick="sendQuickAction('buscar ', event)"> Buscar otro</button>
              </div>`;
            addBotMessage(followUpHTML, true);
          }, 1200);
        }
      })
      .catch(() => {
        removeTyping();
        addBotMessage("Noo, he tenido un error de conexión.");
      });
  }

  function addUserMessage(text) {
    const wrapper = document.createElement("div");
    wrapper.className = "message-wrapper user-wrapper";
    wrapper.innerHTML = `
        <div class="avatar" style="background-image: url('${USER_AVATAR}')"></div>
        <div class="message user-message">${text}</div>
    `;
    messages.appendChild(wrapper);
    scrollToBottom();
  }

  function addBotMessage(content, isHTML = false) {
    const wrapper = document.createElement("div");
    wrapper.className = "message-wrapper bot-wrapper";

    const msgDiv = document.createElement("div");
    msgDiv.className = "message bot-message";

    if (isHTML) msgDiv.innerHTML = content;
    else msgDiv.innerText = content;

    wrapper.innerHTML = `<div class="avatar" style="background-image: url('${BOT_AVATAR}')"></div>`;
    wrapper.appendChild(msgDiv);

    messages.appendChild(wrapper);
    scrollToBottom();
  }

  function showTyping() {
    const typing = document.createElement("div");
    typing.className = "typing";
    typing.id = "typing-indicator";
    typing.textContent = "Botti está escribiendo...";
    messages.appendChild(typing);
    scrollToBottom();
  }

  function removeTyping() {
    const typing = document.getElementById("typing-indicator");
    if (typing) typing.remove();
  }

  function scrollToBottom() {
    messages.scrollTop = messages.scrollHeight;
  }
});