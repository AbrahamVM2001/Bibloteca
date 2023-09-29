-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 30-09-2023 a las 00:18:38
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mat_sup_aom_cmo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_menu`
--

CREATE TABLE `cat_menu` (
  `id_menu` int(11) NOT NULL,
  `nombre_menu` varchar(100) DEFAULT NULL,
  `descripcion_menu` varchar(100) NOT NULL,
  `referencia_menu` varchar(100) DEFAULT NULL,
  `posicion_menu` int(11) NOT NULL,
  `icono_menu` varchar(150) DEFAULT NULL,
  `tipo_usuario` tinyint(1) NOT NULL COMMENT '1=Admin;2=Usuario;3=General',
  `estatus_menu` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_menu`
--

INSERT INTO `cat_menu` (`id_menu`, `nombre_menu`, `descripcion_menu`, `referencia_menu`, `posicion_menu`, `icono_menu`, `tipo_usuario`, `estatus_menu`) VALUES
(1, 'Inicio', 'Página de inicio', NULL, 1, '<i class=\"fa-solid fa-house\"></i>', 3, 1),
(2, 'Salir', 'Salir del sistema', 'login/salir', 100, '<i class=\"fa-solid fa-right-from-bracket\"></i>', 3, 1),
(3, 'Estadísticas', 'Sección de estadísticas de rastro de documentos', 'admin/estadisticas', 2, '<i class=\"fa-solid fa-chart-column\"></i>', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_submenu`
--

CREATE TABLE `cat_submenu` (
  `id_submenu` int(11) NOT NULL,
  `fk_id_menu` int(11) DEFAULT NULL,
  `nombre_submenu` varchar(100) DEFAULT NULL,
  `descripcion_submenu` varchar(100) NOT NULL,
  `referencia_submenu` varchar(100) DEFAULT NULL,
  `estatus_submenu` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_usuarios`
--

CREATE TABLE `cat_usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` text NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password_usuario` text NOT NULL,
  `tipo_usuario` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Administrador;0=Visual',
  `estatus_usuario` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_usuarios`
--

INSERT INTO `cat_usuarios` (`id_usuario`, `nombre_usuario`, `usuario`, `password_usuario`, `tipo_usuario`, `estatus_usuario`) VALUES
(1, 'Francisco Arenal', 'francisco', 'TE0xL3B4Ymh5RkhTRFd3UVBjVEpqdz09', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id_sociedad` int(11) NOT NULL,
  `nombre_sociedad` varchar(150) NOT NULL,
  `nombre_sistema` varchar(150) NOT NULL,
  `descripcion_sistema` varchar(150) DEFAULT NULL,
  `servidor_correo` text NOT NULL,
  `puerto_servidor_correo` varchar(20) NOT NULL,
  `correo_soporte` varchar(100) NOT NULL,
  `password_correo` text NOT NULL,
  `correo_institucional` varchar(100) DEFAULT NULL,
  `ruta_logotipo` varchar(150) DEFAULT NULL,
  `ruta_icono` varchar(150) DEFAULT NULL,
  `dominio_sociedad` varchar(150) DEFAULT NULL,
  `estatus_sociedad` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id_sociedad`, `nombre_sociedad`, `nombre_sistema`, `descripcion_sistema`, `servidor_correo`, `puerto_servidor_correo`, `correo_soporte`, `password_correo`, `correo_institucional`, `ruta_logotipo`, `ruta_icono`, `dominio_sociedad`, `estatus_sociedad`) VALUES
(1, 'Colegio Mexicano de Ortopedia', 'CMO-SISTEMA', 'Sistema para generar qr acorde a documentos cargados', 'mail.grupolahe.com', '465', 'francisco.arenal@grupolahe.com', 'fag1912...', NULL, 'public/img/logo_lahe.png', 'public/img/logo_lahe.png', 'http://localhost/material.suplementario.aom.colegiocmo.com.mx/', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id_documento` int(11) NOT NULL,
  `fk_id_revista` int(11) NOT NULL,
  `nombre_documento` text NOT NULL,
  `ruta_documento` text NOT NULL,
  `liga_documento` text DEFAULT NULL,
  `codigo_qr` text DEFAULT NULL,
  `token_documento` text DEFAULT NULL,
  `creado_por` int(11) NOT NULL,
  `estatus_documento` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id_documento`, `fk_id_revista`, `nombre_documento`, `ruta_documento`, `liga_documento`, `codigo_qr`, `token_documento`, `creado_por`, `estatus_documento`) VALUES
(1, 1, 'Prueba actualización', 'public/img/documentos/Prueba_actualización.pdf', 'http://localhost/material.suplementario.aom.colegiocmo.com.mx/admin/view/B8GTwKouvmbaQGd/?link=true', 'public/img/qr_revista/B8GTwKouvmbaQGd.png', 'B8GTwKouvmbaQGd', 1, 1),
(2, 1, 'estadisticas', 'public/img/documentos/estadisticas.pdf', 'http://localhost/material.suplementario.aom.colegiocmo.com.mx/admin/view/EvpJvPhcpFg1zNr/?link=true', 'public/img/qr_revista/EvpJvPhcpFg1zNr.png', 'EvpJvPhcpFg1zNr', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rastreo`
--

CREATE TABLE `rastreo` (
  `id_rastreo` int(11) NOT NULL,
  `fk_token_documento` text NOT NULL,
  `tipo_rastreo` tinyint(1) NOT NULL COMMENT '0=QR;1=Link',
  `fecha_hora_rastreo` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rastreo`
--

INSERT INTO `rastreo` (`id_rastreo`, `fk_token_documento`, `tipo_rastreo`, `fecha_hora_rastreo`) VALUES
(1, 'B8GTwKouvmbaQGd', 1, '2023-09-29 14:31:40'),
(2, 'B8GTwKouvmbaQGd', 0, '2023-09-29 14:31:45'),
(3, 'B8GTwKouvmbaQGd', 0, '2023-09-29 14:37:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revistas`
--

CREATE TABLE `revistas` (
  `id_revista` int(11) NOT NULL,
  `anio_revista` int(11) NOT NULL,
  `autor_revista` text NOT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `estatus_revista` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `revistas`
--

INSERT INTO `revistas` (`id_revista`, `anio_revista`, `autor_revista`, `creado_por`, `estatus_revista`) VALUES
(1, 2023, 'Francisco Arenal Guerrero', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cat_menu`
--
ALTER TABLE `cat_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `cat_submenu`
--
ALTER TABLE `cat_submenu`
  ADD PRIMARY KEY (`id_submenu`),
  ADD KEY `fk_id_menu` (`fk_id_menu`);

--
-- Indices de la tabla `cat_usuarios`
--
ALTER TABLE `cat_usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_sociedad`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id_documento`),
  ADD KEY `fk_id_revista` (`fk_id_revista`),
  ADD KEY `creado_por` (`creado_por`);

--
-- Indices de la tabla `rastreo`
--
ALTER TABLE `rastreo`
  ADD PRIMARY KEY (`id_rastreo`);

--
-- Indices de la tabla `revistas`
--
ALTER TABLE `revistas`
  ADD PRIMARY KEY (`id_revista`),
  ADD KEY `creado_por` (`creado_por`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cat_menu`
--
ALTER TABLE `cat_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_submenu`
--
ALTER TABLE `cat_submenu`
  MODIFY `id_submenu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_usuarios`
--
ALTER TABLE `cat_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_sociedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rastreo`
--
ALTER TABLE `rastreo`
  MODIFY `id_rastreo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `revistas`
--
ALTER TABLE `revistas`
  MODIFY `id_revista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cat_submenu`
--
ALTER TABLE `cat_submenu`
  ADD CONSTRAINT `cat_submenu_ibfk_1` FOREIGN KEY (`fk_id_menu`) REFERENCES `cat_menu` (`id_menu`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
