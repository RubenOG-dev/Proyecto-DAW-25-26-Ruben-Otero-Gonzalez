document.addEventListener("DOMContentLoaded", () => {
  const wrapper = document.querySelector(".mensajes-wrapper");
  const forms = document.querySelectorAll("form");

  const scrollToTop = () => {
    if (wrapper) {
      wrapper.scrollTo({ top: 0, behavior: "smooth" });
    } else {
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  };
  setTimeout(scrollToTop, 300);

  forms.forEach((form) => {
    form.addEventListener("submit", (e) => {
      const textarea = form.querySelector("textarea");
      if (textarea.value.trim().length < 5) {
        e.preventDefault();
        textarea.style.border = "2px solid #ff4655";
        textarea.animate(
          [
            { transform: "translateX(0)" },
            { transform: "translateX(-5px)" },
            { transform: "translateX(5px)" },
            { transform: "translateX(0)" },
          ],
          { duration: 200, iterations: 3 },
        );
      }
    });

    const textarea = form.querySelector("textarea");
    textarea.addEventListener("input", () => {
      textarea.style.border = "1px solid rgba(139, 92, 246, 0.3)";
    });
  });
});

function setReply(idPost, nombreUsuario) {
  const isMobile = window.innerWidth <= 768;
  const ids = {
    textarea: isMobile ? "textarea-mobile" : "main-textarea",
    input: isMobile ? "id_post_padre_mobile" : "id_post_padre",
    indicator: isMobile ? "form-mode-indicator-mobile" : "form-mode-indicator",
    user: isMobile ? "mode-text-mobile" : "mode-text",
    area: isMobile ? ".mobile-reply" : ".reply-area",
    titleContainer: isMobile
      ? "title-container-mobile"
      : "title-container-desktop",
  };

  const titleContainer = document.getElementById(ids.titleContainer);
  if (titleContainer) {
    titleContainer.style.display = "none";
    const tInput = titleContainer.querySelector("input");
    if (tInput) tInput.required = false;
  }

  const elements = {
    textarea: document.getElementById(ids.textarea),
    input: document.getElementById(ids.input),
    indicator: document.getElementById(ids.indicator),
    user: document.getElementById(ids.user),
    targetArea: document.querySelector(ids.area),
  };

  if (elements.indicator && elements.user) {
    elements.user.innerText = "Respondiendo a " + nombreUsuario;
    elements.indicator.style.display = isMobile ? "flex" : "block";
  }

  if (elements.input) elements.input.value = idPost;
  if (elements.textarea) {
    elements.textarea.placeholder = "Respondiendo a " + nombreUsuario + "...";
    elements.textarea.focus();
  }
  if (elements.targetArea)
    elements.targetArea.scrollIntoView({ behavior: "smooth" });
}

function cancelReply() {
  document.querySelectorAll("form").forEach((f) => {
    f.action = "index.php?controller=Foro&action=postear";
  });

  ["title-container-desktop", "title-container-mobile"].forEach((id) => {
    const el = document.getElementById(id);
    if (el) {
      el.style.display = "block";
      const input = el.querySelector("input");
      if (input) {
        input.required = true;
        input.value = "";
      }
    }
  });

  [
    "id_post_padre",
    "id_post_padre_mobile",
    "form-target-id",
    "form-target-id-mobile",
  ].forEach((id) => {
    const el = document.getElementById(id);
    if (el) el.value = "";
  });

  const editInput = document.getElementById("id_post_edit");
  if (editInput) editInput.remove();

  ["form-mode-indicator", "form-mode-indicator-mobile"].forEach((id) => {
    const el = document.getElementById(id);
    if (el) el.style.display = "none";
  });

  ["main-textarea", "textarea-mobile"].forEach((id) => {
    const el = document.getElementById(id);
    if (el) {
      el.value = "";
      el.placeholder =
        id === "textarea-mobile"
          ? "Escribe en el hilo..."
          : "¿Qué está pasando?";
      const btn = el.closest("form").querySelector(".btn-enviar");
      if (btn) btn.innerHTML = 'PUBLICAR <i class="fas fa-paper-plane"></i>';
    }
  });
}

function abrirEditor(idPost) {
  const isMobile = window.innerWidth <= 768;

  const contenidoMsg = document
    .getElementById(`contenido-${idPost}`)
    .innerText.trim();

  const ids = {
    textarea: isMobile ? "textarea-mobile" : "main-textarea",
    indicator: isMobile ? "form-mode-indicator-mobile" : "form-mode-indicator",
    userText: isMobile ? "mode-text-mobile" : "mode-text",
    titleContainer: isMobile
      ? "title-container-mobile"
      : "title-container-desktop",
  };

  const textarea = document.getElementById(ids.textarea);
  const form = textarea.closest("form");

  form.action = "index.php?controller=Foro&action=editarPost";
  textarea.value = contenidoMsg;
  textarea.focus();

  let inputEdit = document.getElementById("id_post_edit");
  if (!inputEdit) {
    inputEdit = document.createElement("input");
    inputEdit.type = "hidden";
    inputEdit.name = "id_post";
    inputEdit.id = "id_post_edit";
    form.appendChild(inputEdit);
  }
  inputEdit.value = idPost;

  const esRespuesta = document
    .getElementById(`contenido-${idPost}`)
    .closest(".respuestas-hilo");
  const titleContainer = document.getElementById(ids.titleContainer);

  if (esRespuesta) {
    if (titleContainer) {
      titleContainer.style.display = "none";
      const tInput = titleContainer.querySelector("input");
      if (tInput) tInput.required = false;
    }
    document.getElementById(ids.userText).innerText =
      "Editando tu respuesta...";
  } else {
    if (titleContainer) {
      titleContainer.style.display = "none";
      const tInput = titleContainer.querySelector("input");
      if (tInput) tInput.required = false;
    }
    document.getElementById(ids.userText).innerText =
      "Editando tu post principal...";
  }

  const indicator = document.getElementById(ids.indicator);
  if (indicator) indicator.style.display = isMobile ? "flex" : "block";

  const btnSubmit = form.querySelector(".btn-enviar");
  if (btnSubmit)
    btnSubmit.innerHTML = 'GUARDAR CAMBIOS <i class="fas fa-save"></i>';

  const areaScroll = isMobile
    ? document.querySelector(".mobile-reply")
    : document.querySelector(".reply-area");
  if (areaScroll) areaScroll.scrollIntoView({ behavior: "smooth" });
}
