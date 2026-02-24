<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameMatcher - Registro / Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body class="auth-page">

    <div class="auth-container">
        <header class="auth-header text-center">
            <img src="assets/img/logo.png" alt="GameMatcher Logo" class="main-logo">
        </header>

        <main class="auth-card-wrapper">
            <div class="auth-card shadow-lg">

                <ul class="nav nav-tabs border-0 mb-4 justify-content-center" id="authTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-pane" type="button" role="tab">INICIAR SESIÓN</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-pane" type="button" role="tab">REGISTRARSE</button>
                    </li>
                </ul>

                <div id="auth-feedback" class="d-none mb-3"></div>

                <div class="tab-content" id="authTabContent">
                    
                    <div class="tab-pane fade show active" id="login-pane" role="tabpanel">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label class="form-label text-lila-label">Correo electronico</label>
                                <input type="email" name="email" class="form-control custom-input" placeholder="fjhernandezjz@gmail.com" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-lila-label">Contraseña</label>
                                <input type="password" name="password" class="form-control custom-input" required>
                            </div>
                            <button type="submit" class="btn btn-auth-submit w-100">
                                <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesion
                            </button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="register-pane" role="tabpanel">
                        <form id="registerForm">
                            <div class="mb-2">
                                <label class="form-label text-lila-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control custom-input" placeholder="Francisco Javier" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label text-lila-label">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control custom-input" placeholder="Hernandez Juarez" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label text-lila-label">Correo electrónico</label>
                                <input type="email" name="email" class="form-control custom-input" placeholder="fjhernandezjz@gmail.com" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label text-lila-label">Contraseña</label>
                                <input type="password" name="password" class="form-control custom-input" placeholder="(Mínimo 8 carácteres)" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-lila-label">Repetir Contraseña</label>
                                <input type="password" name="password_confirm" class="form-control custom-input" placeholder="Confirme contraseña" required>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                <label class="form-check-label text-muted small" for="termsCheck">Acepto los términos y condiciones</label>
                            </div>
                            <button type="submit" class="btn btn-auth-submit w-100">
                                <i class="fas fa-user-circle me-2"></i> Registrarse
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </main>

        <footer class="auth-footer">
            <div class="footer-grid">
                <div class="footer-left text-center text-md-start">
                    <p class="mb-1 fw-bold">Sobre nosotros</p>
                    <div class="social-links justify-content-center justify-content-md-start">
                        <a href="#"><i class="fab fa-x-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
                <div class="footer-center text-center">
                    <p class="mb-1">Política de privacidad</p>
                    <p class="mb-0">Política de cookies</p>
                </div>
                <div class="footer-right text-center text-md-end">
                    <p class="mb-0">2026 © Rubén Otero Gzl</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/auth.js"></script>

</body>

</html>