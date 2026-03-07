<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id_usuario'])) {
    header("Location: index.php?controller=MainController&action=principal");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameMatcher - Registro / Inicio de Sesión</title>
    <link rel="icon" type="image/png" href="assets/img/logo2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <link rel="stylesheet" href="assets/css/bot.css">
</head>

<body class="auth-page">

    <div class="desktop-only">
        <div class="auth-container">
            <header class="auth-header text-center">
                <a href="index.php?controller=MainController&action=principal">
                    <img src="assets/img/logo.png" alt="GameMatcher Logo" class="main-logo">
                </a>
            </header>

            <main class="auth-card-wrapper">
                <div class="auth-card animate__animated animate__fadeIn">
                    <ul class="nav nav-tabs border-0 mb-4 justify-content-center" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link fw-bold active" id="login-tab-d" data-bs-toggle="tab" data-bs-target="#login-pane-d" type="button" role="tab">INICIAR SESIÓN</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold" id="register-tab-d" data-bs-toggle="tab" data-bs-target="#register-pane-d" type="button" role="tab">REGISTRARSE</button>
                        </li>
                    </ul>

                    <div id="feedback-desktop" class="auth-feedback d-none mb-3"></div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="login-pane-d" role="tabpanel">
                            <form id="loginFormDesktop" novalidate>
                                <input type="hidden" name="return_to" value="<?php echo htmlspecialchars($return_to ?? ''); ?>">
                                <div class="mb-3 text-start">
                                    <label class="form-label text-lila-label">Correo electrónico</label>
                                    <input type="email" name="email" class="form-control custom-input" placeholder="ejemplo@correo.com" required>
                                </div>
                                <div class="mb-4 text-start">
                                    <label class="form-label text-lila-label">Contraseña</label>
                                    <input type="password" name="password" class="form-control custom-input" required>
                                </div>
                                <button type="submit" class="btn btn-auth-submit w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="register-pane-d" role="tabpanel">
                            <form id="registerFormDesktop" novalidate>
                                <div class="row g-2 mb-2 text-start">
                                    <div class="col-md-6">
                                        <label class="form-label text-lila-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control custom-input" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-lila-label">Apellidos</label>
                                        <input type="text" name="apellidos" class="form-control custom-input" required>
                                    </div>
                                </div>
                                <div class="mb-2 text-start">
                                    <label class="form-label text-lila-label">Correo electrónico</label>
                                    <input type="email" name="email" class="form-control custom-input" placeholder="ejemplo@correo.com" required>
                                </div>
                                <div class="mb-2 text-start">
                                    <label class="form-label text-lila-label">Contraseña</label>
                                    <input type="password" name="password" class="form-control custom-input" placeholder="(Mínimo 8 caracteres)" required minlength="8">
                                </div>
                                <div class="mb-3 text-start">
                                    <label class="form-label text-lila-label">Repetir Contraseña</label>
                                    <input type="password" name="password_confirm" class="form-control custom-input" placeholder="Confirme su contraseña" required>
                                </div>
                                <div class="form-check mb-4 text-start">
                                    <input class="form-check-input" type="checkbox" id="termsDesktop" required>
                                    <label class="form-check-label text-muted small" for="termsDesktop">Acepto los términos y condiciones</label>
                                </div>
                                <button type="submit" class="btn btn-auth-submit w-100">
                                    <i class="fas fa-user-circle me-2"></i> Registrarse
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once("footer_desktop.php"); ?>
        </div>
    </div>

    <div class="mobile-only">
        <div class="auth-container d-flex flex-column min-vh-100">
            <header class="auth-header text-center py-4">
                <a href="index.php?controller=MainController&action=principal">
                    <img src="assets/img/logo.png" alt="Logo" class="main-logo" style="max-width: 160px;">
                </a>
            </header>

            <main class="flex-grow-1 d-flex align-items-center justify-content-center px-3">
                <div class="auth-card shadow-lg w-100 animate__animated animate__fadeIn" style="max-width: 400px;">
                    <ul class="nav nav-tabs border-0 mb-4 justify-content-center" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link fw-bold active" id="login-tab-m" data-bs-toggle="tab" data-bs-target="#login-pane-m" type="button" role="tab">INICIAR SESIÓN</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold" id="register-tab-m" data-bs-toggle="tab" data-bs-target="#register-pane-m" type="button" role="tab">REGISTRARSE</button>
                        </li>
                    </ul>

                    <div id="feedback-mobile" class="auth-feedback d-none mb-3"></div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="login-pane-m" role="tabpanel">
                            <form id="loginFormMobile" novalidate>
                                <input type="hidden" name="return_to" value="<?php echo htmlspecialchars($return_to ?? ''); ?>">
                                <div class="mb-3 text-start">
                                    <label class="form-label text-lila-label">Correo electrónico</label>
                                    <input type="email" name="email" class="form-control custom-input" placeholder="ejemplo@correo.com" required>
                                </div>
                                <div class="mb-4 text-start">
                                    <label class="form-label text-lila-label">Contraseña</label>
                                    <input type="password" name="password" class="form-control custom-input" required>
                                </div>
                                <button type="submit" class="btn btn-auth-submit w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                                </button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="register-pane-m" role="tabpanel">
                            <form id="registerFormMobile" novalidate>
                                <div class="row g-2 mb-2 text-start">
                                    <div class="col-6">
                                        <label class="form-label text-lila-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control custom-input" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label text-lila-label">Apellidos</label>
                                        <input type="text" name="apellidos" class="form-control custom-input" required>
                                    </div>
                                </div>
                                <div class="mb-2 text-start">
                                    <label class="form-label text-lila-label">Correo electrónico</label>
                                    <input type="email" name="email" class="form-control custom-input" placeholder="ejemplo@correo.com" required>
                                </div>
                                <div class="mb-2 text-start">
                                    <label class="form-label text-lila-label">Contraseña</label>
                                    <input type="password" name="password" class="form-control custom-input" placeholder="Mínimo 8 caracteres" required minlength="8">
                                </div>
                                <div class="mb-3 text-start">
                                    <label class="form-label text-lila-label">Repetir Contraseña</label>
                                    <input type="password" name="password_confirm" class="form-control custom-input" placeholder="Confirme su contraseña" required>
                                </div>
                                <div class="form-check mb-4 text-start">
                                    <input class="form-check-input" type="checkbox" id="termsMobile" required>
                                    <label class="form-check-label text-muted small" for="termsMobile">Acepto los términos y condiciones</label>
                                </div>
                                <button type="submit" class="btn btn-auth-submit w-100">
                                    <i class="fas fa-user-circle me-2"></i> Registrarse
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once("footer_mobile.php"); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/auth.js"></script>
</body>

</html>