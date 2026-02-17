/*=============================================
=            JS del BOT ACTUALIZADO           =
=============================================*/

document.addEventListener("DOMContentLoaded", () => {
  const bubble = document.getElementById("chat-bubble");
  const chatWindow = document.getElementById("chat-window");
  const closeBtn = document.getElementById("chat-close");
  const messages = document.getElementById("chat-messages");
  const input = document.getElementById("chat-input");
  const sendBtn = document.getElementById("chat-send");

  if (!bubble) return;

  bubble.addEventListener("click", () => {
    chatWindow.classList.toggle("chat-hidden");

    if (!chatWindow.dataset.opened) {
      const welcomeHTML = `👋 Ola! Soy el asistente de GameMatcher.<br><br>Podes escribirme o hacer click en estos atajos:
                <div class="chat-buttons">
                    <button class="btn-quick" onclick="sendQuickAction('top')">🏆 Top 3</button>
                    <button class="btn-quick" onclick="sendQuickAction('buscar ')">🔍 Buscar</button>
                </div>`;
      addBotMessage(welcomeHTML, true);
      chatWindow.dataset.opened = true;
    }
  });

  window.sendQuickAction = function (text) {
    if (text === "buscar ") {
      input.value = "buscar ";
      input.focus();
    } else {
      sendMessage(text);
    }
  };

  closeBtn.addEventListener("click", () => {
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

    const fetchPromise = fetch("api/bots.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ message: text }),
    }).then(res => {
      if (!res.ok) throw new Error("Error en el servidor");
      return res.json();
    });

    const timerPromise = new Promise(resolve => setTimeout(resolve, 1500));

    Promise.all([fetchPromise, timerPromise])
      .then(([data]) => {
        removeTyping();
        addBotMessage(data.response);

        // Si el PHP nos manda opciones múltiples, creamos botones de selección
        if (data.options && data.options.length > 0) {
          setTimeout(() => {
            let optionsHTML = `Atopei varios resultados, cal buscas?<div class="chat-buttons">`;
            data.options.forEach(opt => {
              optionsHTML += `<button class="btn-quick" onclick="sendQuickAction('${opt.name}')">🎯 ${opt.name}</button>`;
            });
            optionsHTML += `</div>`;
            addBotMessage(optionsHTML, true);
          }, 600);
        } else {
          // Si es una respuesta normal, hacemos la pregunta de seguimiento de siempre
          setTimeout(() => {
            const followUpHTML = `
              ¿Quieres consultar algo mas? 🎮
              <div class="chat-buttons">
                  <button class="btn-quick" onclick="sendQuickAction('top')">🏆 Ver Top 3</button>
                  <button class="btn-quick" onclick="sendQuickAction('buscar ')">🔍 Buscar otro</button>
              </div>`;
            addBotMessage(followUpHTML, true);
          }, 800);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        removeTyping();
        addBotMessage("Noo, he tenido un error de conexión con el servidor.");
      });
  }

  function addUserMessage(text) {
    const msg = document.createElement("div");
    msg.className = "message user-message";
    msg.textContent = text;
    messages.appendChild(msg);
    scrollToBottom();
  }

  function addBotMessage(content, isHTML = false) {
    const msg = document.createElement("div");
    msg.className = "message bot-message";
    if (isHTML) {
      msg.innerHTML = content;
    } else {
      msg.innerHTML = content.replace(/\n/g, "<br>");
    }
    messages.appendChild(msg);
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