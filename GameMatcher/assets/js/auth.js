document.addEventListener("DOMContentLoaded", () => {
    const $d = document;

    const mostrarMensajeUI = (mensaje, tipo) => {
        const isMobileVisible = window.getComputedStyle($d.querySelector('.mobile-only')).display !== 'none';
        const feedbackId = isMobileVisible ? "feedback-mobile" : "feedback-desktop";
        const feedback = $d.getElementById(feedbackId);

        if (feedback) {
            feedback.className = `alert alert-${tipo} d-flex align-items-center animate__animated animate__fadeInUp auth-feedback`;

            const mensajeSeguro = mensaje.replace(/[<>&"']/g, m => ({ '<': '&lt;', '>': '&gt;', '&': '&amp;', '"': '&quot;', "'": "&#39;" }[m]));

            feedback.innerHTML = `
                <i class="fas ${tipo === "danger" ? "fa-exclamation-circle" : "fa-check-circle"} me-2"></i>
                <div style="font-size: 0.85rem;">${mensajeSeguro}</div>
            `;
            feedback.classList.remove("d-none");

            feedback.scrollIntoView({ behavior: "smooth", block: "center" });
        }
    };


    const enviarFormulario = async (form, action) => {

        if (!form.checkValidity()) {
            form.classList.add("was-validated");
            return;
        }

        const emailInput = form.querySelector('input[type="email"]');
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (emailInput && !emailRegex.test(emailInput.value)) {
            mostrarMensajeUI("O formato do correo electrónico non é válido.", "danger");
            return;
        }

        if (action === "procesarRegistro") {
            const pass = form.querySelector('input[name="password"]');
            const confirm = form.querySelector('input[name="password_confirm"]');
            if (pass && pass.value.length < 8) {
                mostrarMensajeUI("A contrasinal debe ter polo menos 8 caracteres.", "danger");
                return;
            }
            if (pass && confirm && pass.value !== confirm.value) {
                mostrarMensajeUI("As contrasinais non coinciden.", "danger");
                return;
            }
        }

        const formData = new FormData(form);
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;

        $d.querySelectorAll('.auth-feedback').forEach(f => f.classList.add('d-none'));

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';
        const inputs = form.querySelectorAll('input');
        inputs.forEach(i => i.readOnly = true);

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
                    const redirectUrl = result.redirect || "index.php?controller=User&action=mostrarMain";
                    setTimeout(() => window.location.href = redirectUrl, 1200);
                } else {
                    form.reset();
                    form.classList.remove("was-validated");
                    inputs.forEach(i => i.readOnly = false);
                }
            } else {
                mostrarMensajeUI(result.message, "danger");
                inputs.forEach(i => i.readOnly = false);
            }
        } catch (error) {
            console.error("Error:", error);
            mostrarMensajeUI("Error de conexión con el servidor", "danger");
            inputs.forEach(i => i.readOnly = false);
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    };

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