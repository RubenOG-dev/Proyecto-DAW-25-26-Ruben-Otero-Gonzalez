-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql-8001.dinaserver.com:3306
-- Tiempo de generación: 20-03-2026 a las 11:08:48
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
(34, 25, 22, '¡Yo me apunto! Te agrego a Steam luego.', '2026-03-20 10:54:33', NULL),
(35, 27, 22, 'A mí me encantó, sobre todo por la ambientación mental de Joseph.', '2026-03-20 11:02:52', NULL),
(36, 29, 14, 'Ya lo hemos solucionado', '2026-03-20 11:02:52', NULL);

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
(1030, ''),
(3498, ''),
(4200, 'Portal 2'),
(4291, '');

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
(25, 1, 20, '¿Alguien para el logro de \"Abrazo fuerte\"?', 'Me falta solo ese logro para completar el juego al 100%. ¿Alguien se conecta esta noche?', '2026-03-20 10:53:04', NULL),
(26, 1, 21, 'Los mejores mapas de la comunidad', 'He estado jugando varios mapas de Workshop y hay algunos que superan a los originales. ¿Cuáles recomendáis?', '2026-03-20 10:53:04', NULL),
(27, 2, 21, 'Far Cry 6: ¿Merece la pena el DLC de Joseph Seed?', 'He visto que FarCRY6 está de oferta, pero no sé si aporta mucho a la historia principal. ¿Opiniones?', '2026-03-20 10:53:04', '2026-03-20 11:02:00'),
(28, 2, 22, 'Configuración de sensibilidad para mando', '¿Qué sensibilidad usáis para tener más precisión en los headshots en consola?', '2026-03-20 10:53:04', NULL),
(29, 3, 22, 'Error inicio sesion', 'Por veces al iniciar sesión puede ser que se bugge?', '2026-03-20 11:06:03', NULL);

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
(22, 20, 'd75df3025b10c9cc46a3f92621c78417', '2026-03-20 10:47:03', '2026-03-20 10:47:11'),
(23, 21, '9a974a747d79cfced3ef4cdd93b79cf5', '2026-03-20 10:47:44', '2026-03-20 10:47:47'),
(24, 22, '1b474a1d28842af7a41af0af0cafeb8a', '2026-03-20 10:48:29', '2026-03-20 11:01:24'),
(25, 21, '52bad3f514ba3f7a1c5e1b4f91fb1ed2', '2026-03-20 11:01:36', '2026-03-20 11:02:19'),
(26, 22, '34f426287e5f04c7b4192314797f6320', '2026-03-20 11:02:30', NULL);

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
(14, 'admin', '$2y$10$8S8lS5U.Cdfu/qW6jXfKue7ZfXoDqBqY8S1B.M3u9z/H5r1p.7Gqy', 'admin@gamematcher.com', 'admin', NULL, 0, 1, '2026-03-06 00:16:55'),
(20, 'Ruben Gamer', '$2y$12$vzMued8thma06shRw8gZEe/is.pWkpuGa2a3RpsKeTLS0B16etlDu', 'ruben@example.com', 'free', NULL, 0, 1, '2026-03-20 10:47:03'),
(21, 'Portal Fan99', '$2y$12$uAtxOf4mgw2ZbE2uTaP9Ren22KaCAXp6skin71sNz4uTePGyNw9WS', 'portal@example.com', 'free', NULL, 0, 1, '2026-03-20 10:47:44'),
(22, 'Yara Guerrilla', '$2y$12$8Jyh1NHD8tyI49vFKKERJuLg37Ntq2jOW7MD1obwnuw9mUh0o9vHq', 'yara@example.com', 'free', NULL, 0, 1, '2026-03-20 10:48:29');

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
  MODIFY `id_comentario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `FORO`
--
ALTER TABLE `FORO`
  MODIFY `id_foro` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `POST`
--
ALTER TABLE `POST`
  MODIFY `id_post` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `SESION`
--
ALTER TABLE `SESION`
  MODIFY `id_sesion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `USUARIO`
--
ALTER TABLE `USUARIO`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
