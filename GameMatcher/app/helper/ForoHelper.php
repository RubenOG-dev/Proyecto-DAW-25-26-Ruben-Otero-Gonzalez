<?php

class ForoHelper
{
    public static function renderForos($foros)
    {
        if (!isset($foros)) die("Error: La variable de foros no ha llegado al sistema.");
        
        if (empty($foros)) {
            return '<p class="no-data">No se han encontrado foros disponibles.</p>';
        }

        $html = '';
        foreach ($foros as $f) {
            $id = $f['id_foro'];
            $titulo = htmlspecialchars($f['titulo']);

            $html .= "
            <div class='foro-item'>
                <div class='foro-header' data-id='{$id}'>
                    <span class='foro-titulo'>
                        <i class='fas fa-folder-open' style='margin-right:10px; color:#a685ff;'></i>{$titulo}
                    </span>
                    <div class='foro-icon-wrapper'>
                        <i class='fas fa-chevron-down' id='icon-{$id}'></i>
                    </div>
                </div>

                <div class='foro-content' id='content-{$id}' style='display: none;'>";

            /* --- Sección de Hilos Recientes --- */
            $html .= "<div class='section-label'><i class='fas fa-thumbtack'></i> HILOS RECIENTES</div>";

            if (!empty($f['posts'])) {
                $html .= "<div class='lista-hilos'>";
                foreach ($f['posts'] as $post) {
                    $tituloPost = htmlspecialchars($post['titulo']);
                    $autorPost = htmlspecialchars($post['nombre'] ?? 'Usuario');
                    $idPost = $post['id_post'];

                    $html .= "
                    <div class='hilo-row'>
                        <div class='hilo-info'>
                            <a href='index.php?controller=Foro&action=ver&id={$id}#post-{$idPost}' class='hilo-link'>
                                <i class='far fa-file-alt'></i> {$tituloPost}
                            </a>
                            <span class='hilo-autor'>por {$autorPost}</span>
                        </div>
                    </div>";
                }
                $html .= "</div>";
            } else {
                $html .= "<p class='no-data-mini'>No hay hilos creados todavía.</p>";
            }

            /* --- Sección de Última Actividad --- */
            if (!empty($f['ultimos_comentarios'])) {
                $html .= "
                <div class='section-label' style='margin-top:15px;'><i class='fas fa-comments'></i> ÚLTIMA ACTIVIDAD</div>
                <div class='preview-comentarios'>";

                foreach ($f['ultimos_comentarios'] as $com) {
                    $nombre = htmlspecialchars($com['nombre']);
                    $contenido = htmlspecialchars($com['contenido']);
                    $html .= "
                        <div class='mini-post'>
                            <div class='post-text'>
                                <strong>{$nombre}</strong>: <span>{$contenido}</span>
                            </div>
                        </div>";
                }
                $html .= "</div>";
            }

            /* --- Área de Acción --- */
            $html .= "
                    <div class='action-area'>
                        <a href='index.php?controller=Foro&action=ver&id={$id}' class='btn-explorar'>
                            ENTRAR AL FORO <i class='fas fa-arrow-right'></i>
                        </a>
                    </div>
                </div>
            </div>";
        }
        return $html;
    }
}