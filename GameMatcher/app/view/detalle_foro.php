<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?= htmlspecialchars($foro['titulo']); ?> - GameMatcher</title>
    <link rel="icon" type="image/png" href="assets/img/logo2.png">
    <link rel="stylesheet" href="assets/css/detalle_foro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="detail-page">

    <div class="desktop-only">
        <header class="main-header">
            <div class="logo">
                <a href="index.php?controller=Main&action=principal">
                    <img src="assets/img/logo.png" alt="GameMatcher Logo">
                </a>
            </div>
            <nav class="nav-menu">
                <a href="index.php?controller=Foro&action=listar" class="btn-header-alt"><i class="fas fa-comments"></i> FOROS</a>
                <a href="index.php?controller=Games&action=catalogo" class="btn-header-alt"><i class="fas fa-gamepad"></i> CATÁLOGO</a>
            </nav>
        </header>

        <main class="container">
            <section class="foro-main-card">
                <div class="foro-header-detail">
                    <a href="index.php?controller=Foro&action=listar" class="btn-back"><i class="fas fa-chevron-left"></i> Volver</a>
                    <h1><?= htmlspecialchars($foro['titulo']); ?></h1>
                </div>

                <div class="mensajes-wrapper">
                    <?php if (empty($mensajes)): ?>
                        <div class="empty-state">
                            <i class="fas fa-comment-dots"></i>
                            <p>¡Aún no hay mensajes! Sé el primero en abrir el debate.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($mensajes as $m): ?>
                            <div class="post-card">
                                <div class="post-meta">
                                    <span class="post-author"><?= htmlspecialchars($m['nombre']) ?></span>
                                    <span class="post-date"><?= $m['fecha'] ?></span>
                                </div>
                                <div class="post-body" id="contenido-<?= $m['id_post'] ?>">
                                    <?= nl2br(htmlspecialchars($m['contenido'])) ?>
                                </div>
                                <?php if (isset($_SESSION['id_usuario'])): ?>
                                    <div class="post-actions">
                                        <button type="button" class="btn-small" onclick="setReply(<?= $m['id_post'] ?>, '<?= htmlspecialchars($m['nombre']) ?>')">
                                            <i class="fas fa-reply"></i> Responder
                                        </button>
                                        <?php if (isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] == $m['id_usuario']): ?>
                                            <button type="button" class="btn-small btn-edit" onclick="abrirEditor(<?= $m['id_post'] ?>)">
                                                <i class="fas fa-edit"></i> Editar
                                            </button>

                                            <a href="index.php?controller=Foro&action=borrarPost&id_post=<?= $m['id_post'] ?>&id_foro=<?= $foro['id_foro'] ?>"
                                                class="btn-small btn-delete"
                                                onclick="return confirm('¿Estás seguro de que quieres borrar este mensaje?')">
                                                <i class="fas fa-trash"></i> Borrar
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($m['respuestas'])): ?>
                                    <div class="respuestas-hilo" style="margin-left: 30px; margin-top: 15px; border-left: 2px solid var(--gamer-purple); padding-left: 15px;">
                                        <?php foreach ($m['respuestas'] as $r): ?>
                                            <div class="reply-card" style="background: rgba(255,255,255,0.02); padding: 10px; border-radius: 8px; margin-bottom: 10px;">
                                                <div class="post-meta" style="font-size: 0.75rem;">
                                                    <span class="post-author" style="color: var(--gamer-cyan) !important;"><?= htmlspecialchars($r['nombre']) ?></span>
                                                    <span class="post-date"><?= $r['fecha'] ?></span>
                                                </div>
                                                <div class="post-body" style="font-size: 0.9rem;" id="contenido-<?= $r['id_post'] ?>"> <?= nl2br(htmlspecialchars($r['contenido'])) ?>
                                                </div>

                                                <?php if (isset($_SESSION['id_usuario'])): ?>
                                                    <div class="post-actions" style="margin-top: 5px;">
                                                        <?php if ($_SESSION['id_usuario'] == $r['id_usuario']): ?>
                                                            <button type="button" class="btn-small btn-edit" onclick="abrirEditor(<?= $r['id_post'] ?>)">
                                                                <i class="fas fa-edit"></i> Editar
                                                            </button>
                                                            <a href="index.php?controller=Foro&action=borrarPost&id_post=<?= $r['id_post'] ?>&id_foro=<?= $foro['id_foro'] ?>"
                                                                class="btn-small btn-delete"
                                                                onclick="return confirm('¿Estás seguro?')">
                                                                <i class="fas fa-trash"></i> Borrar
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="reply-area">
                    <?php if (isset($_SESSION['id_usuario'])): ?>
                        <div id="form-mode-indicator" style="display:none; color: var(--gamer-cyan); margin-bottom: 10px; font-size: 0.9rem;">
                            <span id="mode-text"></span>
                            <button type="button" onclick="resetForm()" style="color: #ff4444; background: none; border: none; cursor: pointer; margin-left: 10px;">[Cancelar]</button>
                        </div>

                        <form id="foro-form" action="index.php?controller=Foro&action=postear" method="POST">
                            <input type="hidden" name="id_foro" value="<?= $foro['id_foro']; ?>">
                            <input type="hidden" name="id_post" id="form-target-id" value=""> <input type="hidden" name="id_post_padre" id="id_post_padre" value="">

                            <div id="title-container-desktop">
                                <input type="text" name="titulo" id="post-title" placeholder="Título del debate..." required
                                    style="width: 100%; padding: 12px; margin-bottom: 10px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--gamer-purple); color: white; outline: none;">
                            </div>

                            <textarea name="contenido" id="main-textarea" placeholder="¿Qué está pasando?" required></textarea>
                            <button type="submit" id="submit-btn" class="btn-enviar">PUBLICAR <i class="fas fa-paper-plane"></i></button>
                        </form>
                    <?php else: ?>
                        <div class="login-required-notice">
                            <p><i class="fas fa-lock"></i> Debes <a href="index.php?controller=User&action=login">iniciar sesión</a> para participar.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>

        <?php include_once("footer_desktop.php"); ?>
    </div>

    <div class="mobile-only">
        <header class="mobile-header">
            <div class="logo-container">
                <a href="index.php?controller=Main&action=principal">
                    <img src="assets/img/logo.png" alt="GameMatcher Logo">
                </a>
            </div>
            <div class="header-buttons">
                <a href="index.php?controller=Foro&action=listar" class="btn-small"><i class="fas fa-comments"></i> FOROS</a>
                <a href="index.php?controller=Games&action=catalogo" class="btn-small"><i class="fas fa-gamepad"></i> CATÁLOGO</a>
            </div>
        </header>

        <main class="mobile-body">
            <div class="mobile-foro-title">
                <a href="index.php?controller=Foro&action=listar" class="btn-back-mobile" style="color: var(--gamer-cyan); text-decoration: none; font-size: 0.8rem; display: block; margin-bottom: 10px;">
                    <i class="fas fa-chevron-left"></i> Volver a la lista
                </a>
                <h2><?= htmlspecialchars($foro['titulo']); ?></h2>
            </div>

            <div class="mensajes-wrapper">
                <?php if (empty($mensajes)): ?>
                    <div class="empty-state">
                        <p>No hay hilos aquí. ¡Empieza la conversación!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($mensajes as $m): ?>
                        <div class="post-card">
                            <div class="post-meta">
                                <span class="post-author"><?= htmlspecialchars($m['nombre']) ?></span>
                                <span class="post-date"><?= $m['fecha'] ?></span>
                            </div>
                            <div class="post-body" id="contenido-<?= $m['id_post'] ?>">
                                <?= nl2br(htmlspecialchars($m['contenido'])) ?>
                            </div>
                            <?php if (isset($_SESSION['id_usuario'])): ?>
                                <div class="post-actions">
                                    <button type="button" class="btn-small" onclick="setReply(<?= $m['id_post'] ?>, '<?= htmlspecialchars($m['nombre']) ?>')">
                                        <i class="fas fa-reply"></i> Responder
                                    </button>
                                    <?php if (isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] == $m['id_usuario']): ?>
                                        <button type="button" class="btn-small btn-edit" onclick="abrirEditor(<?= $m['id_post'] ?>)">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>

                                        <a href="index.php?controller=Foro&action=borrarPost&id_post=<?= $m['id_post'] ?>&id_foro=<?= $foro['id_foro'] ?>"
                                            class="btn-small btn-delete"
                                            onclick="return confirm('¿Estás seguro de que quieres borrar este mensaje?')">
                                            <i class="fas fa-trash"></i> Borrar
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($m['respuestas'])): ?>
                                <div class="respuestas-hilo" style="margin-left: 30px; margin-top: 15px; border-left: 2px solid var(--gamer-purple); padding-left: 15px;">
                                    <?php foreach ($m['respuestas'] as $r): ?>
                                        <div class="reply-card" style="background: rgba(255,255,255,0.02); padding: 10px; border-radius: 8px; margin-bottom: 10px;">
                                            <div class="post-meta" style="font-size: 0.75rem;">
                                                <span class="post-author" style="color: var(--gamer-pink) !important;"><?= htmlspecialchars($r['nombre']) ?></span>
                                                <span class="post-date"><?= $r['fecha'] ?></span>
                                            </div>
                                            <div class="post-body" style="font-size: 0.9rem;" id="contenido-<?= $r['id_post'] ?>"> <?= nl2br(htmlspecialchars($r['contenido'])) ?>
                                            </div>

                                            <?php if (isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] == $r['id_usuario']): ?>
                                                <div class="post-actions" style="margin-top: 5px;">
                                                    <button type="button" class="btn-small btn-edit" onclick="abrirEditor(<?= $r['id_post'] ?>)">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </button>
                                                    <a href="index.php?controller=Foro&action=borrarPost&id_post=<?= $r['id_post'] ?>&id_foro=<?= $foro['id_foro'] ?>"
                                                        class="btn-small btn-delete"
                                                        onclick="return confirm('¿Estás seguro?')">
                                                        <i class="fas fa-trash"></i> Borrar
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="mobile-reply">
                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <div id="form-mode-indicator-mobile" style="display:none; color: var(--gamer-cyan); margin-bottom: 10px; font-size: 0.8rem;">
                        <span id="mode-text-mobile"></span>
                        <button type="button" onclick="resetForm()" style="color: #ff4444; background: none; border: none; cursor: pointer; margin-left: 10px;">[X]</button>
                    </div>

                    <form id="foro-form-mobile" action="index.php?controller=Foro&action=postear" method="POST">
                        <input type="hidden" name="id_foro" value="<?= $foro['id_foro']; ?>">
                        <input type="hidden" name="id_post" id="form-target-id-mobile" value=""> <input type="hidden" name="id_post_padre" id="id_post_padre_mobile" value="">

                        <div id="title-container-mobile">
                            <input type="text" name="titulo" id="post-title-mobile" placeholder="Título del debate..." required
                                style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--gamer-purple); color: white; font-size: 0.9rem;">
                        </div>

                        <textarea name="contenido" id="textarea-mobile" placeholder="Escribe en el hilo..." required></textarea>
                        <div class="mobile-form-footer">
                            <button type="submit" id="submit-btn-mobile" class="btn-enviar">PUBLICAR <i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="login-required-notice">
                        <p><i class="fas fa-lock"></i> Debes <a href="index.php?controller=User&action=mostrarAuth">iniciar sesión</a> para participar.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <?php include_once("footer_mobile.php"); ?>
    </div>
    <script src="assets/js/detalle_foro.js"></script>
</body>

</html>