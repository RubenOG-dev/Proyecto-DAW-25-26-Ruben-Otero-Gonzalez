document.addEventListener("DOMContentLoaded", () => {
    const $d = document;

    /**
     * Muestra el feedback de éxito o error en el contenedor adecuado (Desktop o Mobile)
     */
    const mostrarMensajeUI = (mensaje, tipo) => {
        // Detectamos si el contenedor móvil está visible para saber dónde poner el mensaje
        const isMobileVisible = window.getComputedStyle($d.querySelector('.mobile-only')).display !== 'none';
        const feedbackId = isMobileVisible ? "feedback-mobile" : "feedback-desktop";
        const feedback = $d.getElementById(feedbackId);

        if (feedback) {
            feedback.className = `alert alert-${tipo} d-flex align-items-center animate__animated animate__fadeInUp auth-feedback`;
            feedback.innerHTML = `
                <i class="fas ${tipo === "danger" ? "fa-exclamation-circle" : "fa-check-circle"} me-2"></i>
                <div style="font-size: 0.85rem;">${mensaje}</div>
            `;
            feedback.classList.remove("d-none");
            
            // Scroll suave para asegurar que el usuario vea el mensaje
            feedback.scrollIntoView({ behavior: "smooth", block: "center" });
        }
    };

    /**
     * Procesa el envío de los formularios mediante Fetch
     */
    const enviarFormulario = async (form, action) => {
        // Validación nativa de Bootstrap/HTML5
        if (!form.checkValidity()) {
            form.classList.add("was-validated");
            return;
        }

        const formData = new FormData(form);
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;

        // Ocultamos todos los feedbacks previos antes de enviar
        $d.querySelectorAll('.auth-feedback').forEach(f => f.classList.add('d-none'));

        // Estado de carga
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';

        try {
            const response = await fetch(`./index.php?controller=User&action=${action}`, {
                method: "POST",
                body: formData
            });

            if (!response.ok) throw new Error("Error en la respuesta del servidor");

            const result = await response.json();

            if (result.success) {
                mostrarMensajeUI(result.message, "success");
                
                if (action === "procesarLogin") {
                    // Redirección tras login exitoso
                    setTimeout(() => window.location.href = "index.php?controller=User&action=principal", 1200);
                } else {
                    // Limpieza tras registro exitoso
                    form.reset();
                    form.classList.remove("was-validated");
                }
            } else {
                mostrarMensajeUI(result.message, "danger");
            }
        } catch (error) {
            console.error("Error:", error);
            mostrarMensajeUI("Error de conexión con el servidor", "danger");
        } finally {
            // Restaurar botón
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    };

    // --- ASIGNACIÓN DE EVENTOS PARA TODOS LOS FORMULARIOS ---
    
    // Mapeo manual para evitar cualquier error de duplicidad
    const loginForms = ["loginFormDesktop", "loginFormMobile"];
    const registerForms = ["registerFormDesktop", "registerFormMobile"];

    loginForms.forEach(id => {
        const f = $d.getElementById(id);
        if (f) {
            f.addEventListener("submit", e => {
                e.preventDefault();
                enviarFormulario(f, "procesarLogin");
            });
        }
    });

    registerForms.forEach(id => {
        const f = $d.getElementById(id);
        if (f) {
            f.addEventListener("submit", e => {
                e.preventDefault();
                enviarFormulario(f, "procesarRegistro");
            });
        }
    });
});