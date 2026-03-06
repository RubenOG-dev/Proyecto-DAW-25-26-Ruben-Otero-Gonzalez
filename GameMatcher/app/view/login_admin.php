<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - GameMatcher</title>
    <link rel="stylesheet" href="assets/css/admin_login.css">
</head>
<body class="admin-login-page">
    <div class="login-box">
        <img src="assets/img/logo.png" alt="Logo" class="admin-logo">
        <h2>Área Restringida</h2>
        
        <?php if(isset($error)): ?>
            <p class="error-msg"><?= $error ?></p>
        <?php endif; ?>

        <form action="index.php?controller=Admin&action=login" method="POST">
            <input type="email" name="email" placeholder="Email de Administrador" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" class="btn-admin">ENTRAR AL PANEL</button>
        </form>
        <a href="index.php" class="back-link">Volver a la web</a>
    </div>
</body>
</html>