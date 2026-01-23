-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-08-2024 a las 15:11:43
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `test_framework_table`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido`
--

CREATE TABLE `contenido` (
  `contenido_id` int NOT NULL,
  `contenido_seccion` int DEFAULT NULL,
  `contenido_tipo` int DEFAULT NULL,
  `contenido_padre` int DEFAULT NULL,
  `contenido_columna_alineacion` int DEFAULT NULL,
  `contenido_columna` varchar(255) DEFAULT NULL,
  `contenido_columna_espacios` int DEFAULT NULL,
  `contenido_disenio` int DEFAULT NULL,
  `contenido_borde` int DEFAULT NULL,
  `contenido_estado` int DEFAULT NULL,
  `contenido_fecha` date DEFAULT NULL,
  `contenido_titulo` varchar(500) DEFAULT NULL,
  `contenido_titulo_ver` int DEFAULT NULL,
  `contenido_imagen` varchar(500) DEFAULT NULL,
  `contenido_archivo` varchar(255) DEFAULT NULL,
  `contenido_fondo_imagen` varchar(50) DEFAULT NULL,
  `contenido_fondo_imagen_tipo` int DEFAULT NULL,
  `contenido_fondo_color` varchar(100) DEFAULT NULL,
  `contenido_introduccion` text,
  `contenido_descripcion` text,
  `contenido_enlace` varchar(500) DEFAULT NULL,
  `contenido_enlace_abrir` int DEFAULT NULL,
  `contenido_vermas` varchar(100) DEFAULT NULL,
  `orden` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contenido`
--

INSERT INTO `contenido` (`contenido_id`, `contenido_seccion`, `contenido_tipo`, `contenido_padre`, `contenido_columna_alineacion`, `contenido_columna`, `contenido_columna_espacios`, `contenido_disenio`, `contenido_borde`, `contenido_estado`, `contenido_fecha`, `contenido_titulo`, `contenido_titulo_ver`, `contenido_imagen`, `contenido_archivo`, `contenido_fondo_imagen`, `contenido_fondo_imagen_tipo`, `contenido_fondo_color`, `contenido_introduccion`, `contenido_descripcion`, `contenido_enlace`, `contenido_enlace_abrir`, `contenido_vermas`, `orden`) VALUES
(1, 1, 2, 0, 0, '', 0, 0, 0, 1, '2024-08-06', 'Titulo', 0, 'logo-new1.png', '', '', 0, '', '<script src=\"//cdn.public.flmngr.com/FLMNFLMN/widgets.js\"></script>', '<script src=\"//cdn.public.flmngr.com/FLMNFLMN/widgets.js\"></script>', '', 0, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enlaces`
--

CREATE TABLE `enlaces` (
  `enlaces_id` int NOT NULL,
  `enlaces_titulo` varchar(255) DEFAULT NULL,
  `enlaces_link` varchar(255) DEFAULT NULL,
  `orden` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_pagina`
--

CREATE TABLE `info_pagina` (
  `info_pagina_id` bigint NOT NULL,
  `info_pagina_facebook` varchar(255) DEFAULT NULL,
  `info_pagina_instagram` varchar(255) DEFAULT NULL,
  `info_pagina_x` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `info_pagina_pinterest` varchar(255) DEFAULT NULL,
  `info_pagina_youtube` varchar(255) DEFAULT NULL,
  `info_pagina_tiktok` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `info_pagina_linkedin` varchar(255) DEFAULT NULL,
  `info_pagina_telefono` varchar(255) DEFAULT NULL,
  `info_pagina_whatsapp` varchar(255) DEFAULT NULL,
  `info_pagina_correos_contacto` varchar(255) DEFAULT NULL,
  `info_pagina_direccion_contacto` text,
  `info_pagina_informacion_contacto` text,
  `info_pagina_informacion_contacto_footer` text,
  `info_pagina_descripcion` text,
  `info_pagina_tags` text,
  `info_pagina_robot` varchar(500) DEFAULT NULL,
  `info_pagina_sitemap` varchar(500) DEFAULT NULL,
  `info_pagina_scripts` text,
  `orden` bigint DEFAULT NULL,
  `info_pagina_host` varchar(200) NOT NULL,
  `info_pagina_port` int NOT NULL,
  `info_pagina_username` varchar(200) NOT NULL,
  `info_pagina_password` varchar(200) NOT NULL,
  `info_pagina_correo_remitente` varchar(200) NOT NULL,
  `info_pagina_nombre_remitente` varchar(200) NOT NULL,
  `info_pagina_correo_oculto` varchar(200) NOT NULL,
  `info_pagina_titulo_legal` varchar(200) NOT NULL,
  `info_pagina_descripcion_legal` longtext NOT NULL,
  `info_pagina_favicon` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `info_pagina`
--

INSERT INTO `info_pagina` (`info_pagina_id`, `info_pagina_facebook`, `info_pagina_instagram`, `info_pagina_x`, `info_pagina_pinterest`, `info_pagina_youtube`, `info_pagina_tiktok`, `info_pagina_linkedin`, `info_pagina_telefono`, `info_pagina_whatsapp`, `info_pagina_correos_contacto`, `info_pagina_direccion_contacto`, `info_pagina_informacion_contacto`, `info_pagina_informacion_contacto_footer`, `info_pagina_descripcion`, `info_pagina_tags`, `info_pagina_robot`, `info_pagina_sitemap`, `info_pagina_scripts`, `orden`, `info_pagina_host`, `info_pagina_port`, `info_pagina_username`, `info_pagina_password`, `info_pagina_correo_remitente`, `info_pagina_nombre_remitente`, `info_pagina_correo_oculto`, `info_pagina_titulo_legal`, `info_pagina_descripcion_legal`, `info_pagina_favicon`) VALUES
(1, 'https://omegasolucionesweb.com/1', 'https://omegasolucionesweb.com/4', 'https://omegasolucionesweb.com/2', 'https://omegasolucionesweb.com/5', 'https://omegasolucionesweb.com/3', 'https://omegasolucionesweb.com/7', 'https://omegasolucionesweb.com/4', '', '12331230', '', '', '<script src=\"//cdn.public.flmngr.com/FLMNFLMN/widgets.js\"></script>', '<script src=\"//cdn.public.flmngr.com/FLMNFLMN/widgets.js\"></script>', '', '', '', '', '', NULL, '1', 1, '1', '1', '1', '1', '1', '', '<script src=\"//cdn.public.flmngr.com/FLMNFLMN/widgets.js\"></script>', 'favicon.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `log_id` int NOT NULL,
  `log_usuario` varchar(50) DEFAULT NULL,
  `log_tipo` varchar(50) DEFAULT NULL,
  `log_fecha` datetime DEFAULT NULL,
  `log_log` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`log_id`, `log_usuario`, `log_tipo`, `log_fecha`, `log_log`) VALUES
(1, 'admin', 'LOGOUT', '2024-08-06 15:48:01', ''),
(2, 'admin', 'LOGIN', '2024-08-06 15:48:04', ''),
(3, 'admin', 'LOGOUT', '2024-08-06 17:09:30', ''),
(4, 'admin', 'LOGIN', '2024-08-06 17:11:40', ''),
(5, 'admin', 'LOGOUT', '2024-08-06 17:11:44', ''),
(6, 'admin', 'LOGIN', '2024-08-06 17:12:00', ''),
(7, 'admin', 'CREAR BANNER', '2024-08-06 17:43:14', 'Array\n(\n    [publicidad_seccion] => 100\n    [publicidad_nombre] => Test\n    [publicidad_nombre2] => \n    [publicidad_fecha] => 2024-08-06\n    [publicidad_nombre_ver] => \n    [publicidad_imagen] => logo-new.png\n    [publicidad_imagenresponsive] => \n    [publicidad_video] => \n    [publicidad_color_fondo] => \n    [publicidad_posicion] => \n    [publicidad_descripcion] => <script src=\"//cdn.public.flmngr.com/FLMNFLMN/widgets.js\"></script>\n    [publicidad_estado] => 1\n    [publicidad_click] => 0\n    [publicidad_enlace] => \n    [publicidad_tipo_enlace] => 0\n    [publicidad_texto_enlace] => \n    [publicidad_enlace_alineacion] => \n    [publicidad_id] => 1\n)\n'),
(8, 'admin', 'CREAR CONTENIDO', '2024-08-06 17:51:33', 'Array\n(\n    [contenido_seccion] => 1\n    [contenido_tipo] => 2\n    [contenido_padre] => 0\n    [contenido_columna] => \n    [contenido_columna_espacios] => 0\n    [contenido_columna_alineacion] => 0\n    [contenido_disenio] => 0\n    [contenido_borde] => 0\n    [contenido_estado] => 1\n    [contenido_fecha] => 2024-08-06\n    [contenido_caja] => \n    [contenido_top] => \n    [contenido_bottom] => \n    [contenido_left] => \n    [contenido_right] => \n    [contenido_titulo] => Titulo\n    [contenido_subtitulo] => \n    [contenido_titulo_ver] => 0\n    [contenido_imagen] => logo-new1.png\n    [contenido_fondo_imagen] => \n    [contenido_fondo_imagen_tipo] => 0\n    [contenido_enlace_abrir] => 0\n    [contenido_fondo_color] => \n    [contenido_introduccion] => <script src=\"//cdn.public.flmngr.com/FLMNFLMN/widgets.js\"></script>\n    [contenido_descripcion] => <script src=\"//cdn.public.flmngr.com/FLMNFLMN/widgets.js\"></script>\n    [contenido_enlace] => \n    [contenido_vermas] => \n    [contenido_video] => \n    [contenido_icono] => \n    [contenido_id] => 1\n)\n'),
(9, 'admin', 'CREAR USUARIO', '2024-08-06 17:54:01', 'Array\n(\n    [user_state] => 2\n    [user_date] => 2024-08-06\n    [user_names] => Pearl Bednar\n    [user_cedula] => 1000001\n    [user_email] => desarrollo2@omegawebsystems.com\n    [user_telefono] => 123123123\n    [user_level] => 2\n    [user_user] => Isom.Cassin56\n    [user_password] => Admin.2008\n    [user_delete] => 1\n    [user_current_user] => 1\n    [user_code] => 1\n)\n'),
(10, 'admin', 'LOGIN', '2024-08-12 16:08:23', ''),
(11, 'admin', 'LOGOUT', '2024-08-12 16:08:35', ''),
(12, 'admin', 'LOGIN', '2024-08-12 16:08:36', ''),
(13, 'admin', 'LOGIN', '2024-08-13 08:15:59', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicidad`
--

CREATE TABLE `publicidad` (
  `publicidad_id` int NOT NULL,
  `publicidad_seccion` int DEFAULT NULL,
  `publicidad_nombre` varchar(500) DEFAULT NULL,
  `publicidad_fecha` date DEFAULT NULL,
  `publicidad_imagen` varchar(500) DEFAULT NULL,
  `publicidad_imagenresponsive` varchar(255) DEFAULT NULL,
  `publicidad_color_fondo` varchar(255) DEFAULT NULL,
  `publicidad_video` text,
  `publicidad_posicion` varchar(255) DEFAULT NULL,
  `publicidad_descripcion` text,
  `publicidad_estado` int DEFAULT NULL,
  `publicidad_click` int DEFAULT NULL,
  `publicidad_enlace` varchar(500) DEFAULT NULL,
  `publicidad_tipo_enlace` int DEFAULT NULL,
  `publicidad_texto_enlace` varchar(255) DEFAULT NULL,
  `orden` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `publicidad`
--

INSERT INTO `publicidad` (`publicidad_id`, `publicidad_seccion`, `publicidad_nombre`, `publicidad_fecha`, `publicidad_imagen`, `publicidad_imagenresponsive`, `publicidad_color_fondo`, `publicidad_video`, `publicidad_posicion`, `publicidad_descripcion`, `publicidad_estado`, `publicidad_click`, `publicidad_enlace`, `publicidad_tipo_enlace`, `publicidad_texto_enlace`, `orden`) VALUES
(1, 100, 'Test', '2024-08-06', 'logo-new.png', '', '', '', '', '<script src=\"//cdn.public.flmngr.com/FLMNFLMN/widgets.js\"></script>', 1, 0, '', 0, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test_table`
--

CREATE TABLE `test_table` (
  `id` int NOT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `fecha` varchar(255) DEFAULT NULL,
  `contrasenia` varchar(255) DEFAULT NULL,
  `tiny` varchar(255) DEFAULT NULL,
  `text_area` varchar(255) DEFAULT NULL,
  `select` varchar(255) DEFAULT NULL,
  `checkbox` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `user_id` bigint NOT NULL,
  `user_date` date DEFAULT NULL,
  `user_names` varchar(255) DEFAULT NULL,
  `user_cedula` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_telefono` varchar(255) DEFAULT NULL,
  `user_level` int DEFAULT NULL,
  `user_state` int DEFAULT NULL,
  `user_user` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_delete` int DEFAULT NULL,
  `user_current_user` bigint DEFAULT NULL,
  `user_code` varchar(500) DEFAULT NULL,
  `user_empresa` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`user_id`, `user_date`, `user_names`, `user_cedula`, `user_email`, `user_telefono`, `user_level`, `user_state`, `user_user`, `user_password`, `user_delete`, `user_current_user`, `user_code`, `user_empresa`) VALUES
(1, '2018-07-17', 'Administrador', '1232321321', 'gerencia@omegawebsystems.com', '123213123123', 1, 1, 'admin', '$2y$10$ULs0eFV/YanZb7L386//7O0wf6W4urgVrAaWDnRcSb.bLWi0ZmO8y', 1, 1, '1', NULL),
(4, '2024-08-06', 'Pearl Bednar', '1000001', 'desarrollo2@omegawebsystems.com', '123123123', 2, 2, 'Isom.Cassin56', '$2y$10$.zTU8HJyYqGz7UyJuHzdle3mir8eK6ZUT1s/yRoy9bPSqPArCGepW', 1, 1, '1', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD PRIMARY KEY (`contenido_id`);

--
-- Indices de la tabla `enlaces`
--
ALTER TABLE `enlaces`
  ADD PRIMARY KEY (`enlaces_id`);

--
-- Indices de la tabla `info_pagina`
--
ALTER TABLE `info_pagina`
  ADD PRIMARY KEY (`info_pagina_id`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indices de la tabla `publicidad`
--
ALTER TABLE `publicidad`
  ADD PRIMARY KEY (`publicidad_id`);

--
-- Indices de la tabla `test_table`
--
ALTER TABLE `test_table`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_user` (`user_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contenido`
--
ALTER TABLE `contenido`
  MODIFY `contenido_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `enlaces`
--
ALTER TABLE `enlaces`
  MODIFY `enlaces_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `info_pagina`
--
ALTER TABLE `info_pagina`
  MODIFY `info_pagina_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `publicidad`
--
ALTER TABLE `publicidad`
  MODIFY `publicidad_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `test_table`
--
ALTER TABLE `test_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
