-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql-8001.dinaserver.com:3306
-- Tiempo de generación: 11-03-2026 a las 09:35:06
-- Versión del servidor: 8.0.37
-- Versión de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rial_campechano`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMENTARIO`
--

CREATE TABLE `COMENTARIO` (
  `id_comentario` int NOT NULL,
  `id_post` int NOT NULL,
  `id_usuario` int NOT NULL,
  `contenido` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_publicacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_edicion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `COMENTARIO`
--

INSERT INTO `COMENTARIO` (`id_comentario`, `id_post`, `id_usuario`, `contenido`, `data_publicacion`, `data_edicion`) VALUES
(25, 13, 1, '¡Yo me apunto! Pásame tu ID.', '2026-03-06 00:47:28', NULL),
(26, 14, 1, 'Dicen que vuelve Verdansk en 2026.', '2026-03-06 00:47:28', NULL),
(27, 15, 1, 'Se ve increíble, la iluminación es de otro planeta.', '2026-03-06 00:47:28', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FORO`
--

CREATE TABLE `FORO` (
  `id_foro` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `tipo_entidad` enum('juego','categoria','global') COLLATE utf8mb4_general_ci NOT NULL,
  `relacion_id` int DEFAULT NULL,
  `data_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_edicion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `FORO`
--

INSERT INTO `FORO` (`id_foro`, `titulo`, `descripcion`, `tipo_entidad`, `relacion_id`, `data_creacion`, `data_edicion`) VALUES
(1, 'Comunidad Portal 2', 'Debates sobre puzzles y cooperativo.', 'juego', 4200, '2026-02-13 08:51:23', NULL),
(2, 'Zona Shooters', 'Para hablar de cualquier juego de disparos.', 'categoria', 5, '2026-02-13 08:51:23', NULL),
(3, 'Soporte Técnico', 'Reporta fallos de la web aquí.', 'global', NULL, '2026-02-13 08:51:23', NULL),
(5, 'Foro de Grand Theft Auto V', 'Comunidad de Grand Theft Auto V', 'juego', 3498, '2026-03-05 23:35:31', NULL),
(6, 'Foro de The Witcher 3: Wild Hunt', 'Comunidad de The Witcher 3: Wild Hunt', 'juego', 3328, '2026-03-06 00:55:30', NULL),
(7, 'Foro de Tomb Raider (2013)', 'Comunidad de Tomb Raider (2013)', 'juego', 5286, '2026-03-06 01:04:32', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `JUEGO`
--

CREATE TABLE `JUEGO` (
  `rawg_game_id` int NOT NULL,
  `nome_game` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `JUEGO`
--

INSERT INTO `JUEGO` (`rawg_game_id`, `nome_game`) VALUES
(28, 'Red Dead Redemption 2'),
(3498, ''),
(4200, 'Portal 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `POST`
--

CREATE TABLE `POST` (
  `id_post` int NOT NULL,
  `id_foro` int NOT NULL,
  `id_usuario` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contido` text COLLATE utf8mb4_general_ci,
  `data_publicacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_edicion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `POST`
--

INSERT INTO `POST` (`id_post`, `id_foro`, `id_usuario`, `titulo`, `contido`, `data_publicacion`, `data_edicion`) VALUES
(3, 3, 1, 'Error al subir foto de perfil', 'No me deja subir archivos .png de más de 1MB.', '2026-02-13 08:51:23', NULL),
(13, 1, 1, '¿Alguien para el coop?', 'Busco gente para Portal 2.', '2026-03-06 00:47:22', NULL),
(14, 2, 1, 'Duda sobre Warzone', '¿Van a meter mapas nuevos?', '2026-03-06 00:47:22', NULL),
(15, 5, 1, 'GTA VI Tráiler', '¿Qué os ha parecido el vídeo?', '2026-03-06 00:47:22', NULL),
(16, 6, 1, 'The Wiitcher 3: Top Juegos 2026', 'Para mi es uno de los mejores juegos 2026', '2026-03-06 00:55:56', NULL),
(17, 7, 1, 'Primer Comentario del Foro', 'Hola soy nuevo en el juego, quien me puede dar consejo?', '2026-03-06 01:05:01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SESION`
--

CREATE TABLE `SESION` (
  `id_sesion` int NOT NULL,
  `id_usuario` int NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `data_inicio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_fin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `SESION`
--

INSERT INTO `SESION` (`id_sesion`, `id_usuario`, `token`, `data_inicio`, `data_fin`) VALUES
(11, 17, '3123ff3101814db65cbf63114b4bbee5', '2026-03-07 20:44:04', '2026-03-07 20:50:48'),
(12, 17, 'd3c53fe0df8d311bc73ec6223b3a1e33', '2026-03-07 20:51:02', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO`
--

CREATE TABLE `USUARIO` (
  `id_usuario` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `contrasenha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_usuario` enum('free','premium','admin') COLLATE utf8mb4_general_ci DEFAULT 'free',
  `stripe_customer_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado_suscripcion_id` int DEFAULT '0',
  `activo` tinyint(1) DEFAULT '1',
  `data_rexistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `USUARIO`
--

INSERT INTO `USUARIO` (`id_usuario`, `nombre`, `contrasenha`, `email`, `tipo_usuario`, `stripe_customer_id`, `estado_suscripcion_id`, `activo`, `data_rexistro`) VALUES
(1, 'Marcos88', 'pbkdf2:sha256:250000$xxxx', 'marcos@example.com', 'free', NULL, 0, 1, '2026-02-13 08:51:23'),
(3, 'Staff_GameMatcher', 'pbkdf2:sha256:250000$zzzz', 'staff@gamematcher.com', 'admin', NULL, 0, 1, '2026-02-13 08:51:23'),
(4, 'Usuario Proba', '$2y$12$CqFJbNANmaO6TkD.qwFwOeogEHr4cACK25GGtkbZSqQRTrLgV7yiG', 'proba@gamematcher.com', 'free', NULL, 0, 1, '2026-02-13 13:11:10'),
(14, 'admin', '$2y$10$8S8lS5U.Cdfu/qW6jXfKue7ZfXoDqBqY8S1B.M3u9z/H5r1p.7Gqy', 'admin@gamematcher.com', 'admin', NULL, 0, 1, '2026-03-06 00:16:55'),
(17, 'RUBÉN OTERO GONZÁLEZ', '$2y$12$v6//novwiNsKRcdKVVowIO4SRgm1igMhlI7iXSmZdS2NKkdh4/EZi', 'oterogonzalezruben@gmail.com', 'free', NULL, 0, 1, '2026-03-07 20:43:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `VALORACION`
--

CREATE TABLE `VALORACION` (
  `id_valoracion` int NOT NULL,
  `id_usuario` int NOT NULL,
  `rawg_game_id` int NOT NULL,
  `puntuacion` int DEFAULT NULL,
  `comentario` text COLLATE utf8mb4_general_ci,
  `data_valoracion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Volcado de datos para la tabla `VALORACION`
--

INSERT INTO `VALORACION` (`id_valoracion`, `id_usuario`, `rawg_game_id`, `puntuacion`, `comentario`, `data_valoracion`) VALUES
(7, 17, 3498, 3, 'está meh', '2026-03-07 22:50:11');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `COMENTARIO`
--
ALTER TABLE `COMENTARIO`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `idx_post_comentario` (`id_post`);

--
-- Indices de la tabla `FORO`
--
ALTER TABLE `FORO`
  ADD PRIMARY KEY (`id_foro`),
  ADD UNIQUE KEY `unique_foro_entidad` (`tipo_entidad`,`relacion_id`);

--
-- Indices de la tabla `JUEGO`
--
ALTER TABLE `JUEGO`
  ADD PRIMARY KEY (`rawg_game_id`);

--
-- Indices de la tabla `POST`
--
ALTER TABLE `POST`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `idx_foro_post` (`id_foro`);

--
-- Indices de la tabla `SESION`
--
ALTER TABLE `SESION`
  ADD PRIMARY KEY (`id_sesion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `USUARIO`
--
ALTER TABLE `USUARIO`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `VALORACION`
--
ALTER TABLE `VALORACION`
  ADD PRIMARY KEY (`id_valoracion`),
  ADD UNIQUE KEY `usuario_juego_unico` (`id_usuario`,`rawg_game_id`),
  ADD KEY `rawg_game_id` (`rawg_game_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `COMENTARIO`
--
ALTER TABLE `COMENTARIO`
  MODIFY `id_comentario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `FORO`
--
ALTER TABLE `FORO`
  MODIFY `id_foro` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `POST`
--
ALTER TABLE `POST`
  MODIFY `id_post` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `SESION`
--
ALTER TABLE `SESION`
  MODIFY `id_sesion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `USUARIO`
--
ALTER TABLE `USUARIO`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `VALORACION`
--
ALTER TABLE `VALORACION`
  MODIFY `id_valoracion` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `COMENTARIO`
--
ALTER TABLE `COMENTARIO`
  ADD CONSTRAINT `COMENTARIO_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `POST` (`id_post`) ON DELETE CASCADE,
  ADD CONSTRAINT `COMENTARIO_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `USUARIO` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `POST`
--
ALTER TABLE `POST`
  ADD CONSTRAINT `POST_ibfk_1` FOREIGN KEY (`id_foro`) REFERENCES `FORO` (`id_foro`) ON DELETE CASCADE,
  ADD CONSTRAINT `POST_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `USUARIO` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `SESION`
--
ALTER TABLE `SESION`
  ADD CONSTRAINT `SESION_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `USUARIO` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `VALORACION`
--
ALTER TABLE `VALORACION`
  ADD CONSTRAINT `VALORACION_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `USUARIO` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `VALORACION_ibfk_2` FOREIGN KEY (`rawg_game_id`) REFERENCES `JUEGO` (`rawg_game_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
