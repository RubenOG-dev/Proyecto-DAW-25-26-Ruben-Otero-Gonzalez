document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const feedback = document.getElementById('auth-feedback');
    const chatWindow = document.getElementById('chat-window');
    const chatMessages = document.getElementById('chat-messages');
    const chatBubble = document.getElementById('chat-bubble');
    const chatClose = document.getElementById('chat-close');

    const camesHabla = (texto) => {
        if (chatWindow && chatWindow.classList.contains('chat-hidden')) {
            if (window.innerWidth > 768) {
                chatWindow.classList.remove('chat-hidden');
            }
        }

        if (chatMessages) {
            const mensajeDiv = document.createElement('div');
            mensajeDiv.className = 'mensaje-cames mb-2 d-flex justify-content-start';
            mensajeDiv.innerHTML = `
                <div class="p-2 rounded shadow-sm text-white" style="background-color: #7c69ef; max-width: 85%; font-size: 0.85rem;">
                    <strong>Cames:</strong> ${texto}
                </div>
            `;
            chatMessages.appendChild(mensajeDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    };

    const mostrarMensajeUI = (mensaje, tipo) => {
        feedback.className = `alert alert-${tipo} d-flex align-items-center animate__animated animate__fadeIn`;
        feedback.innerHTML = `
            <i class="fas ${tipo === 'danger' ? 'fa-exclamation-circle' : 'fa-check-circle'} me-2"></i>
            <div style="font-size: 0.85rem;">${mensaje}</div>
        `;
        feedback.classList.remove('d-none');
        feedback.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    };

    const enviarFormulario = async (form, action) => {
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            camesHabla("¡Espera! Revisa que todos los campos estén correctamente cubiertos.");
            return;
        }

        const formData = new FormData(form);
        feedback.classList.add('d-none');
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        
        try {
            const response = await fetch(`index.php?controller=User&action=${action}`, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                mostrarMensajeUI(result.message, 'success');
                camesHabla(result.message);
                if(action === 'procesarLogin') {
                    setTimeout(() => window.location.href = 'index.php', 1500);
                } else {
                    form.reset();
                    form.classList.remove('was-validated');
                }
            } else {
                mostrarMensajeUI(result.message, 'danger');
                camesHabla(result.message);
            }
        } catch (error) {
            mostrarMensajeUI("Error de conexión", "danger");
            camesHabla("He tenido un problema al conectar con el servidor.");
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    };

    if(loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            enviarFormulario(loginForm, 'procesarLogin');
        });
    }

    if(registerForm) {
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            enviarFormulario(registerForm, 'procesarRegistro');
        });
    }

    if(chatBubble) chatBubble.addEventListener('click', () => chatWindow.classList.toggle('chat-hidden'));
    if(chatClose) chatClose.addEventListener('click', () => chatWindow.classList.add('chat-hidden'));
});