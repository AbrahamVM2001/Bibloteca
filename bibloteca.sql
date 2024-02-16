-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-01-2024 a las 01:00:45
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bibloteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_comentarios`
--

CREATE TABLE `asignacion_comentarios` (
  `id_comentario` int(10) NOT NULL,
  `id_fk_usuario` int(10) DEFAULT NULL,
  `id_fk_libro` int(10) DEFAULT NULL,
  `Comentario` varchar(160) DEFAULT NULL,
  `Fecha_publicacion` date DEFAULT NULL,
  `Estatus` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignacion_comentarios`
--

INSERT INTO `asignacion_comentarios` (`id_comentario`, `id_fk_usuario`, `id_fk_libro`, `Comentario`, `Fecha_publicacion`, `Estatus`) VALUES
(1, 5, 1, 'Muy buen libro', '2024-01-25', 1),
(2, 1, 1, 'ddssda', '2024-01-25', 1),
(3, 1, 2, 'Muy buen libro', '2024-01-25', 1),
(4, 1, 2, 'Da asco el libro', '2024-01-25', 1),
(5, 1, 6, 'Nada mal', '2024-01-25', 1),
(6, 5, 1, 'Prueba de comentario :)', '2024-01-25', 1),
(7, 5, 6, 'Recomendado; DELETE FROM asignacion_comentarios;', '2024-01-25', 1),
(8, 5, 6, 'DELETE FROM asignacion_comentarios;', '2024-01-25', 1),
(12, 5, 1, 'assa', '2024-01-25', 1),
(18, 5, 1, 'sads', '2024-01-25', 1),
(19, 5, 1, 'aSaaaasdsasdasdasa', '2024-01-25', 1),
(21, 5, 1, 'sa', '2024-01-25', 1),
(23, 5, 1, '1', '2024-01-25', 1),
(26, 5, 1, 'adsa', '2024-01-25', 1),
(28, 5, 1, 'qwewqwq', '2024-01-25', 1),
(29, 5, 1, 'weewewrweewrewr', '2024-01-25', 1),
(30, 5, 6, 'wqewq', '2024-01-25', 1),
(32, 1, 1, 'fdggfd', '2024-01-25', 1),
(33, 3, 1, 'AOAKMKAmsA', '2024-01-25', 1),
(34, 2, 2, 'Hola plaza centella :=(', '2024-01-25', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_libro`
--

CREATE TABLE `asignacion_libro` (
  `id_asignacion_libro` int(11) NOT NULL,
  `id_fk_libro` int(10) DEFAULT NULL,
  `id_fk_autor` int(10) DEFAULT NULL,
  `id_fk_editorial` int(10) DEFAULT NULL,
  `id_fk_categoria` int(10) DEFAULT NULL,
  `id_fk_idioma` int(10) DEFAULT NULL,
  `id_fk_usuario` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignacion_libro`
--

INSERT INTO `asignacion_libro` (`id_asignacion_libro`, `id_fk_libro`, `id_fk_autor`, `id_fk_editorial`, `id_fk_categoria`, `id_fk_idioma`, `id_fk_usuario`) VALUES
(1, 1, 2, 9, 5, 4, NULL),
(2, 2, 2, 9, 5, 4, NULL),
(4, 4, 3, 10, 5, 8, NULL),
(6, 6, 1, 11, 4, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_autor`
--

CREATE TABLE `cat_autor` (
  `id_autor` int(10) NOT NULL,
  `Nombre` varchar(150) DEFAULT NULL,
  `Apellido_paterno` varchar(150) DEFAULT NULL,
  `Apellido_materno` varchar(150) DEFAULT NULL,
  `Resumen_biblografia` varchar(160) DEFAULT NULL,
  `Foto` varchar(100) DEFAULT NULL,
  `Token` varchar(11) DEFAULT NULL,
  `Estatus` int(1) DEFAULT NULL,
  `id_fk_usuario` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_autor`
--

INSERT INTO `cat_autor` (`id_autor`, `Nombre`, `Apellido_paterno`, `Apellido_materno`, `Resumen_biblografia`, `Foto`, `Token`, `Estatus`, `id_fk_usuario`) VALUES
(1, 'Gabriel', 'Garcia', 'Marquez', 'García Márquez, autor colombiano, maestro del realismo mágico, ganador del Nobel. Obras notables: \"Cien años de soledad\" y \"El otoño del patriarca', 'public/doc/NECAXK65BN.jpg', 'NECAXK65BN', 1, NULL),
(2, 'J. K. ', 'Rowling', '', 'JK Rowling, autora británica, es conocida por la serie de libros \"Harry Potter\", que ha vendido millones de copias y se ha adaptado al cine.', 'public/doc/6J5YO5BZ1C.jpg', '6J5YO5BZ1C', 1, NULL),
(3, 'Reki', 'Kawahara', '', 'Reki Kawahara, escritor japonés, destacó con la serie de novelas ligeras \"Sword Art Online\", fusionando aventura y realidad virtual.', 'public/doc/OWV3CEOPOQ.jpg', 'OWV3CEOPOQ', 1, NULL),
(5, 'Antoine', 'de Saint-Exupéry', '', 'Antoine de Saint-Exupéry, escritor y aviador francés, es célebre por su obra \"El Principito\", una fábula filosófica que explora temas universales con emotividad', 'public/doc/F5MLK3VDDO.jpg', 'F5MLK3VDDO', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_categoria`
--

CREATE TABLE `cat_categoria` (
  `id_categoria` int(11) NOT NULL,
  `Categoria` varchar(100) DEFAULT NULL,
  `Estatus` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_categoria`
--

INSERT INTO `cat_categoria` (`id_categoria`, `Categoria`, `Estatus`) VALUES
(1, 'Ficción', 1),
(2, 'No Ficción', 0),
(3, 'Misterio', 1),
(4, 'Romance', 1),
(5, 'Ciencia Ficción', 1),
(6, 'Historia', 1),
(7, 'Biografía', 1),
(8, 'Fantasía', 1),
(9, 'Poesía', 1),
(10, 'Aventura', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_editorial`
--

CREATE TABLE `cat_editorial` (
  `id_editorial` int(10) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Estatus` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_editorial`
--

INSERT INTO `cat_editorial` (`id_editorial`, `Nombre`, `Estatus`) VALUES
(1, 'Acantilado', 0),
(2, 'Penguin Random House Grupo Editoria', 1),
(3, 'Editorial Porrúa S.A', 1),
(9, ' Bloomsbury', 1),
(10, 'ASCII Media Works', 1),
(11, 'Editorial Sudamericana', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_idioma`
--

CREATE TABLE `cat_idioma` (
  `id_idioma` int(10) NOT NULL,
  `Idioma` varchar(50) DEFAULT NULL,
  `Estatus` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_idioma`
--

INSERT INTO `cat_idioma` (`id_idioma`, `Idioma`, `Estatus`) VALUES
(1, 'Español - Latinoamericano', 1),
(2, 'Español - España', 1),
(3, 'Español - América Latina', 1),
(4, 'English - United States', 1),
(5, 'Français - France', 1),
(6, 'Deutsch - Deutschland', 1),
(7, 'Italiano - Italia', 1),
(8, '日本語', 1),
(9, '中文', 1),
(10, 'العربية', 1),
(11, 'Português - Brasil', 1),
(12, 'Русский', 1),
(13, 'हिन्दी', 1),
(14, '한국어', 1),
(15, 'English - United Kingdom', 1),
(16, 'Português - Portugal', 1),
(17, 'Indonesia', 1),
(18, 'Türkçe', 1),
(19, 'Nederlands - Nederland', 1),
(20, 'Svenska', 1),
(21, 'Polski', 1),
(22, 'اردو', 1),
(23, 'Vietnamese', 1),
(24, 'Ελληνικά', 1),
(25, 'فارسی', 1),
(26, 'ไทย', 1),
(27, 'Tagalog', 1),
(28, 'Українська', 1),
(29, 'मराठी', 1),
(30, 'বাংলা', 1),
(31, 'ਪੰਜਾਬੀ', 1),
(32, 'ગુજરાતી', 1),
(33, 'தமிழ்', 1),
(34, 'తెలుగు', 1),
(35, 'ಕನ್ನಡ', 1),
(36, 'മലയാളം', 1),
(37, 'ଓଡ଼ିଆ', 1),
(38, 'অসমীয়া', 1),
(40, 'English - United Kingdom', 0),
(42, 'English - United Kingdom', 0),
(50, 'haitiano', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_libro`
--

CREATE TABLE `cat_libro` (
  `id_libro` int(10) NOT NULL,
  `Titulo` varchar(50) DEFAULT NULL,
  `Numero_paginas` int(10) DEFAULT NULL,
  `Fecha_subir_sistema` date DEFAULT NULL,
  `Fecha_publicacion` date DEFAULT NULL,
  `Descripcion` varchar(500) DEFAULT NULL,
  `Palabra_clave` varchar(100) DEFAULT NULL,
  `Estatus` int(1) DEFAULT NULL,
  `Imagen` varchar(100) DEFAULT NULL,
  `documento` varchar(100) DEFAULT NULL,
  `Token_documento` varchar(100) DEFAULT NULL,
  `Token` varchar(11) DEFAULT NULL,
  `id_fk_usuario` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_libro`
--

INSERT INTO `cat_libro` (`id_libro`, `Titulo`, `Numero_paginas`, `Fecha_subir_sistema`, `Fecha_publicacion`, `Descripcion`, `Palabra_clave`, `Estatus`, `Imagen`, `documento`, `Token_documento`, `Token`, `id_fk_usuario`) VALUES
(1, 'Harry Potter  El caliz de fuego', 636, '2024-01-25', '2000-05-01', 'En \'Harry Potter y el Cáliz de Fuego\', Harry se enfrenta al Torneo de los Tres Magos, desvela secretos oscuros y se enfrenta al renacer de Voldemort, explorando lealtad, amistad y su propio crecimiento.', 'Harry', 1, 'public/PortadaLibro/IRKBNQ4L98.jpg', 'public/docLibros/V51Q1GT11I.pdf', 'V51Q1GT11I', 'IRKBNQ4L98', NULL),
(2, 'Harry Potter y la piedra filosofal', 223, '2024-01-23', '1997-06-26', 'En \'Harry Potter y la Piedra Filosofal\', Harry descubre su identidad como mago, asiste a Hogwarts, y junto con sus amigos, Hermione y Ron, enfrenta desafíos para evitar que la Piedra Filosofal caiga en manos equivocadas, revelando así su valentía y el inicio de su viaje mágico.', 'Harry', 1, 'public/PortadaLibro/2GK74BFPNZ.jpg', 'public/docLibros/G3RJO3CW1H.pdf', 'G3RJO3CW1H', '2GK74BFPNZ', NULL),
(4, 'Sword ar online', 200, '2024-01-25', '2007-08-01', 'Kirito, afortunado en Sword Art Online, un VRMMORPG, queda atrapado con 10,000 jugadores. La única salida es despejar los 100 pisos de Aincrad, pero después de dos años, quedan 26 pisos y 6,000 jugadores. La muerte virtual es real.', 'SAO', 0, 'public/PortadaLibro/L7X5QCJU13.jpg', 'public/docLibros/V6AM5KCEMZ.pdf', 'V6AM5KCEMZ', 'L7X5QCJU13', NULL),
(6, '100 años de soledad ', 471, '2024-01-25', '1961-06-05', '100 años de soledad\" de Gabriel García Márquez narra la historia de la familia Buendía en Macondo. Desde la fundación hasta su caída, la novela aborda temas como amor, poder, soledad y el ciclo de la vida. Con elementos mágicos y realismo mágico, la obra destaca la complejidad de las relaciones familiares y la inevitable repetición de la historia.', '100', 1, 'public/PortadaLibro/28SSZ9NZEX.jpg', 'public/docLibros/OZQXPI3JHL.pdf', 'OZQXPI3JHL', '28SSZ9NZEX', NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cat_menu`
--

INSERT INTO `cat_menu` (`id_menu`, `nombre_menu`, `descripcion_menu`, `referencia_menu`, `posicion_menu`, `icono_menu`, `tipo_usuario`, `estatus_menu`) VALUES
(1, 'Inicio', 'Página de inicio', NULL, 1, '<i class=\"fa-solid fa-house\"></i>', 3, 1),
(2, 'Salir', 'Salir del sistema', 'login/salir', 100, '<i class=\"fa-solid fa-right-from-bracket\"></i>', 3, 1),
(3, 'Configuracion', 'Configura tu cuenta', 'configuracion/', 99, '<i class=\"fas fa-cog\"></i>\n', 2, 0),
(4, 'Usuario', 'Sección de altas, bajas y modificación usuario', 'admin/usuario', 2, '<i class=\"fas fa-user\"></i>\n', 1, 1),
(5, 'Libros', 'Sección de altas, bajas y modificación de libros', 'admin/libro', 3, '<i class=\"fas fa-book\"></i>', 1, 1),
(6, 'Editorial', 'Sección de altas, bajas y modificación de editorial', 'admin/editoriales', 4, '<i class=\"fas fa-building\"></i>\n', 1, 1),
(7, 'Idioma', 'Sección de altas, bajas y modificación de idioma', 'admin/idioma', 5, '<i class=\"fas fa-language\"></i>\n', 1, 1),
(8, 'Autor', 'Sección de altas, bajas y modificación de autor', 'admin/autor', 6, '<i class=\"fas fa-pen\"></i>\n', 1, 1),
(9, 'categoria', 'Sección de altas, bajas y modificación de categoria', 'admin/categoria', 7, '<i class=\"fas fa-tags\"></i>', 1, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_usuario`
--

CREATE TABLE `cat_usuario` (
  `id_usuario` int(10) NOT NULL,
  `Nombre` varchar(150) DEFAULT NULL,
  `Apellido_paterno` varchar(150) DEFAULT NULL,
  `Apellido_materno` varchar(150) DEFAULT NULL,
  `Genero` varchar(20) DEFAULT NULL,
  `Tipo_usuario` int(1) DEFAULT NULL,
  `Estatus` int(1) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `pass` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_usuario`
--

INSERT INTO `cat_usuario` (`id_usuario`, `Nombre`, `Apellido_paterno`, `Apellido_materno`, `Genero`, `Tipo_usuario`, `Estatus`, `correo`, `pass`) VALUES
(1, 'Abraham', 'Vera', '', 'Hombre', 1, 1, 'abrahamveram2001@gmail.com', 'Abraham'),
(2, 'Aquetzalli', 'Garcia', 'Urbina', 'Mujer', 2, 1, 'anazanamug@gmail.com', 'FERNANDA10'),
(3, 'Dana Gabriela', 'Garcia', '', 'Mujer', 2, 1, 'dana_grc@hotmail.com', 'Danna&%&10'),
(5, 'Abraham', 'Vera ', 'Martinez', 'Hombre', 2, 1, 'abrahamviejito2000@gmail.com', 'Abraham10');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id_sociedad`, `nombre_sociedad`, `nombre_sistema`, `descripcion_sistema`, `servidor_correo`, `puerto_servidor_correo`, `correo_soporte`, `password_correo`, `correo_institucional`, `ruta_logotipo`, `ruta_icono`, `dominio_sociedad`, `estatus_sociedad`) VALUES
(1, 'Bibloteca LAHE', 'Sistema Bibloteca', 'Explora nuestro sistema de biblioteca virtual, donde encontrarás una amplia selección de libros que capturarán tu atención y enriquecerán tu experienc', 'mail.grupolahe.com', '465', 'francisco.arenal@grupolahe.com', 'fag1912...', NULL, 'public/img/Bibloteca.png', 'public/img/Bibloteca.png', 'http://localhost/bibloteca/', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacion_comentarios`
--
ALTER TABLE `asignacion_comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `id_fk_usuario` (`id_fk_usuario`),
  ADD KEY `id_fk_libro` (`id_fk_libro`);

--
-- Indices de la tabla `asignacion_libro`
--
ALTER TABLE `asignacion_libro`
  ADD PRIMARY KEY (`id_asignacion_libro`),
  ADD KEY `id_fk_autor` (`id_fk_autor`),
  ADD KEY `id_fk_usuario` (`id_fk_usuario`),
  ADD KEY `id_fk_libro` (`id_fk_libro`),
  ADD KEY `id_fk_editorial` (`id_fk_editorial`),
  ADD KEY `id_fk_idioma` (`id_fk_idioma`),
  ADD KEY `id_fk_categoria` (`id_fk_categoria`);

--
-- Indices de la tabla `cat_autor`
--
ALTER TABLE `cat_autor`
  ADD PRIMARY KEY (`id_autor`),
  ADD KEY `id_fk_usuario` (`id_fk_usuario`);

--
-- Indices de la tabla `cat_categoria`
--
ALTER TABLE `cat_categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `cat_editorial`
--
ALTER TABLE `cat_editorial`
  ADD PRIMARY KEY (`id_editorial`);

--
-- Indices de la tabla `cat_idioma`
--
ALTER TABLE `cat_idioma`
  ADD PRIMARY KEY (`id_idioma`);

--
-- Indices de la tabla `cat_libro`
--
ALTER TABLE `cat_libro`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `id_fk_usuario` (`id_fk_usuario`);

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
-- Indices de la tabla `cat_usuario`
--
ALTER TABLE `cat_usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_sociedad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignacion_comentarios`
--
ALTER TABLE `asignacion_comentarios`
  MODIFY `id_comentario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `asignacion_libro`
--
ALTER TABLE `asignacion_libro`
  MODIFY `id_asignacion_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cat_autor`
--
ALTER TABLE `cat_autor`
  MODIFY `id_autor` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cat_categoria`
--
ALTER TABLE `cat_categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cat_editorial`
--
ALTER TABLE `cat_editorial`
  MODIFY `id_editorial` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `cat_idioma`
--
ALTER TABLE `cat_idioma`
  MODIFY `id_idioma` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `cat_libro`
--
ALTER TABLE `cat_libro`
  MODIFY `id_libro` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cat_menu`
--
ALTER TABLE `cat_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cat_submenu`
--
ALTER TABLE `cat_submenu`
  MODIFY `id_submenu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_usuario`
--
ALTER TABLE `cat_usuario`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_sociedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacion_comentarios`
--
ALTER TABLE `asignacion_comentarios`
  ADD CONSTRAINT `asignacion_comentarios_ibfk_1` FOREIGN KEY (`id_fk_usuario`) REFERENCES `cat_usuario` (`id_usuario`),
  ADD CONSTRAINT `asignacion_comentarios_ibfk_2` FOREIGN KEY (`id_fk_libro`) REFERENCES `cat_libro` (`id_libro`);

--
-- Filtros para la tabla `asignacion_libro`
--
ALTER TABLE `asignacion_libro`
  ADD CONSTRAINT `asignacion_libro_ibfk_1` FOREIGN KEY (`id_fk_autor`) REFERENCES `cat_autor` (`id_autor`),
  ADD CONSTRAINT `asignacion_libro_ibfk_2` FOREIGN KEY (`id_fk_usuario`) REFERENCES `cat_usuario` (`id_usuario`),
  ADD CONSTRAINT `asignacion_libro_ibfk_3` FOREIGN KEY (`id_fk_libro`) REFERENCES `cat_libro` (`id_libro`),
  ADD CONSTRAINT `asignacion_libro_ibfk_4` FOREIGN KEY (`id_fk_editorial`) REFERENCES `cat_editorial` (`id_editorial`),
  ADD CONSTRAINT `asignacion_libro_ibfk_5` FOREIGN KEY (`id_fk_idioma`) REFERENCES `cat_idioma` (`id_idioma`),
  ADD CONSTRAINT `asignacion_libro_ibfk_6` FOREIGN KEY (`id_fk_categoria`) REFERENCES `cat_categoria` (`id_categoria`);

--
-- Filtros para la tabla `cat_autor`
--
ALTER TABLE `cat_autor`
  ADD CONSTRAINT `cat_autor_ibfk_1` FOREIGN KEY (`id_fk_usuario`) REFERENCES `cat_usuario` (`id_usuario`);

--
-- Filtros para la tabla `cat_libro`
--
ALTER TABLE `cat_libro`
  ADD CONSTRAINT `cat_libro_ibfk_1` FOREIGN KEY (`id_fk_usuario`) REFERENCES `cat_usuario` (`id_usuario`);

--
-- Filtros para la tabla `cat_submenu`
--
ALTER TABLE `cat_submenu`
  ADD CONSTRAINT `cat_submenu_ibfk_1` FOREIGN KEY (`fk_id_menu`) REFERENCES `cat_menu` (`id_menu`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
