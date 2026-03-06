<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Panel Admin - GameMatcher</title>
    <link rel="icon" type="image/png" href="assets/img/logo2.png">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="admin-page">

    <div class="desktop-only">
        <header class="main-header">
            <div class="logo">
                <a href="index.php?controller=Main&action=principal">
                    <img src="assets/img/logo.png" alt="GameMatcher Logo">
                </a>
                <span class="admin-badge">PANEL DE CONTROL</span>
            </div>
            <nav class="nav-menu">
                <a href="index.php?controller=Main&action=principal" class="btn-header-alt">
                    <i class="fas fa-eye"></i> VER WEB
                </a>
                <a href="index.php?controller=User&action=logout" class="btn-logout" title="Cerrar sesión">
                    <i class="fas fa-power-off"></i>
                </a>
            </nav>
        </header>

        <main class="container">
            <section class="stats-row">
                <div class="stat-box">
                    <span class="stat-num"><?= $datos['stats']['total_usuarios']; ?></span>
                    <span class="stat-label">Usuarios</span>
                </div>
                <div class="stat-box">
                    <span class="stat-num"><?= $datos['stats']['total_posts']; ?></span>
                    <span class="stat-label">Hilos</span>
                </div>
                <div class="stat-box">
                    <span class="stat-num"><?= $datos['stats']['total_foros']; ?></span>
                    <span class="stat-label">Foros</span>
                </div>
            </section>

            <div class="admin-grid">
                <div class="admin-card">
                    <h3><i class="fas fa-users"></i> Gestión de Usuarios</h3>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datos['lista_usuarios'] as $u): ?>
                                <tr>
                                    <td><?= htmlspecialchars($u['nombre']); ?></td>
                                    <td><?= htmlspecialchars($u['email']); ?></td>
                                    <td>
                                        <span class="rol-tag <?= ($u['tipo_usuario'] === 'admin') ? 'admin' : 'free'; ?>">
                                            <?= htmlspecialchars($u['tipo_usuario']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($u['tipo_usuario'] !== 'admin'): ?>
                                            <a href="index.php?controller=Admin&action=deleteUser&id=<?= $u['id_usuario']; ?>" 
                                               class="btn-del" 
                                               onclick="return confirm('¿Estás seguro de que deseas borrar este usuario?')">
                                                <i class="fas fa-user-slash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="admin-card mt-4">
                    <h3><i class="fas fa-file-alt"></i> Gestión de Hilos (Posts)</h3>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Foro</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datos['ultimos_posts'] as $p): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($p['titulo']); ?></strong></td>
                                    <td><?= htmlspecialchars($p['autor']); ?></td>
                                    <td><span class="foro-badge-mini"><?= htmlspecialchars($p['nombre_foro']); ?></span></td>
                                    <td>
                                        <a href="index.php?controller=Admin&action=deletePost&id=<?= $p['id_post']; ?>" 
                                           class="btn-del" 
                                           onclick="return confirm('¿Borrar este hilo y todos sus comentarios?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="admin-card mt-4">
                    <h3><i class="fas fa-comments"></i> Últimos Comentarios</h3>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Autor</th>
                                <th>Contenido</th>
                                <th>En el Post</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datos['comentarios'] as $c): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($c['autor']); ?></strong></td>
                                    <td><small><?= htmlspecialchars(substr($c['contenido'], 0, 60)) . '...'; ?></small></td>
                                    <td><em class="post-source"><?= htmlspecialchars($c['post_titulo']); ?></em></td>
                                    <td>
                                        <a href="index.php?controller=Admin&action=deleteComment&id=<?= $c['id_comentario']; ?>" 
                                           class="btn-del" 
                                           onclick="return confirm('¿Borrar este comentario?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div class="mobile-only">
        <header class="mobile-header">
            <div class="logo-container">
                <img src="assets/img/logo.png" alt="Logo">
            </div>
            <a href="index.php?controller=User&action=logout" class="logout-mob"><i class="fas fa-power-off"></i></a>
        </header>

        <main class="mobile-body">
            <div class="mobile-welcome">
                <h2>Panel de Control</h2>
                <p>Gestión rápida de GameMatcher.</p>
            </div>

            <div class="mobile-stats">
                <div class="m-stat"><strong><?= $datos['stats']['total_usuarios']; ?></strong><span>Usuarios</span></div>
                <div class="m-stat"><strong><?= $datos['stats']['total_posts']; ?></strong><span>Hilos</span></div>
                <div class="m-stat"><strong><?= $datos['stats']['total_foros']; ?></strong><span>Foros</span></div>
            </div>

            <div class="mobile-section-title">Gestión de Usuarios</div>
            <div class="mobile-feed">
                <?php foreach ($datos['lista_usuarios'] as $u): ?>
                    <div class="m-user-card">
                        <div class="m-user-info">
                            <div class="m-user-main">
                                <strong><?= htmlspecialchars($u['nombre']); ?></strong>
                                <span class="rol-tag <?= ($u['tipo_usuario'] === 'admin') ? 'admin' : 'free'; ?>">
                                    <?= htmlspecialchars($u['tipo_usuario']); ?>
                                </span>
                            </div>
                            <p class="m-user-email"><?= htmlspecialchars($u['email']); ?></p>
                        </div>
                        <div class="m-post-actions">
                            <?php if ($u['tipo_usuario'] !== 'admin'): ?>
                                <a href="index.php?controller=Admin&action=deleteUser&id=<?= $u['id_usuario']; ?>"
                                   class="m-btn-del"
                                   onclick="return confirm('¿Borrar usuario?')">
                                    <i class="fas fa-user-slash"></i>
                                </a>
                            <?php else: ?>
                                <span class="m-btn-admin-shield"><i class="fas fa-shield-alt"></i></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mobile-section-title">Hilos Recientes</div>
            <div class="mobile-feed">
                <?php foreach ($datos['ultimos_posts'] as $p): ?>
                    <div class="m-post-card">
                        <div class="m-post-content"> 
                            <span class="m-post-author"><?= htmlspecialchars($p['autor']); ?></span>
                            <p class="m-post-title"><?= htmlspecialchars($p['titulo']); ?></p>
                        </div>
                        <div class="m-post-actions">
                            <a href="index.php?controller=Admin&action=deletePost&id=<?= $p['id_post']; ?>" class="m-btn-del" onclick="return confirm('¿Borrar post?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mobile-section-title">Comentarios Recientes</div>
            <div class="mobile-feed">
                <?php foreach ($datos['comentarios'] as $c): ?>
                    <div class="m-post-card comment-border">
                        <div class="m-post-info">
                            <strong><?= htmlspecialchars($c['autor']); ?></strong>
                            <p class="comment-preview">"<?= htmlspecialchars(substr($c['contenido'], 0, 40)); ?>..."</p>
                        </div>
                        <div class="m-post-actions">
                            <a href="index.php?controller=Admin&action=deleteComment&id=<?= $c['id_comentario']; ?>" class="m-btn-del" onclick="return confirm('¿Borrar comentario?')">
                                <i class="fas fa-comment-slash"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>

        <nav class="mobile-admin-nav">
            <a href="index.php?controller=Main&action=principal"><i class="fas fa-home"></i><span>Web</span></a>
            <a href="index.php?controller=Admin&action=dashboard" class="active"><i class="fas fa-tools"></i><span>Admin</span></a>
        </nav>
    </div>

</body>

</html>