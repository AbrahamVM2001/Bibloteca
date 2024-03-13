-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-03-2024 a las 17:24:06
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
  `Puntaje` int(2) DEFAULT NULL,
  `Fecha_publicacion` datetime DEFAULT NULL,
  `Estatus` int(2) DEFAULT NULL COMMENT '0=Inactivo;1=Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignacion_comentarios`
--

INSERT INTO `asignacion_comentarios` (`id_comentario`, `id_fk_usuario`, `id_fk_libro`, `Comentario`, `Puntaje`, `Fecha_publicacion`, `Estatus`) VALUES
(1, 1, 1, 'Muy buen libro, mi saga favorita', 5, '2024-02-29 17:25:08', 1),
(3, 1, 2, 'Muy buen comiezo para una saga', 5, '2024-02-29 17:51:44', 1),
(4, 1, 8, 'aburrido', 1, '2024-02-29 17:51:59', 1),
(5, 3, 22, 'pesimo final de saga mejor no hubieran sacado nada\r\n', 1, '2024-02-29 17:55:06', 1),
(6, 3, 4, 'Joya de historia', 5, '2024-02-29 17:55:31', 1),
(7, 37, 21, 'llore con la historia muy triste', 3, '2024-02-29 17:56:14', 1),
(8, 37, 20, 'un poco flojo la historia', 2, '2024-02-29 17:56:36', 1),
(9, 37, 19, '9-10 publico exigente', 4, '2024-02-29 17:56:56', 1),
(10, 13, 7, 'Llore con el final', 5, '2024-02-29 17:57:38', 1),
(11, 13, 10, 'confundido', 1, '2024-02-29 17:57:50', 1),
(12, 13, 14, 'Joder que final', 5, '2024-02-29 17:58:09', 1),
(13, 13, 15, 'Excelente historia', 5, '2024-02-29 17:58:25', 1),
(14, 13, 16, 'no me gusto del todo su final', 1, '2024-02-29 17:58:48', 1),
(15, 15, 18, 'Osea si pero no del todo', 1, '2024-02-29 17:59:26', 1),
(16, 15, 17, 'Un poco aburrido con un final triste', 3, '2024-02-29 17:59:45', 1),
(17, 15, 4, 'Joya', 5, '2024-02-29 17:59:56', 1),
(18, 1, 1, 'solo por bajar puntacion', 1, '2024-02-29 18:00:42', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_dispositivo`
--

CREATE TABLE `asignacion_dispositivo` (
  `id_dispositivo` int(10) NOT NULL,
  `id_fk_usuario` int(10) DEFAULT NULL,
  `infoModelo` varchar(50) DEFAULT NULL,
  `Direccion` varchar(50) DEFAULT NULL,
  `FechaTiempo` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignacion_dispositivo`
--

INSERT INTO `asignacion_dispositivo` (`id_dispositivo`, `id_fk_usuario`, `infoModelo`, `Direccion`, `FechaTiempo`) VALUES
(1, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-02-29 15:13:10'),
(2, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-02-29 15:44:17'),
(3, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-02-29 16:01:06'),
(4, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-02-29 16:52:51'),
(5, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-02-29 17:23:14'),
(6, 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Doctor Enrique González Martínez (sin número', '2024-02-29 17:53:05'),
(7, 37, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Doctor Enrique González Martínez (sin número', '2024-02-29 17:55:55'),
(8, 13, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Doctor Enrique González Martínez (sin número', '2024-02-29 17:57:22'),
(9, 15, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Doctor Enrique González Martínez (sin número', '2024-02-29 17:59:08'),
(10, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Doctor Enrique González Martínez (sin número', '2024-03-01 09:25:58'),
(11, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-01 11:55:18'),
(12, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-01 12:42:46'),
(13, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Eligio Ancona 79, Ciudad de México', '2024-03-01 13:00:34'),
(14, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-01 13:16:46'),
(15, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-01 13:39:50'),
(16, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Eligio Ancona 79, Ciudad de México', '2024-03-04 09:18:28'),
(17, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-04 09:40:47'),
(18, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-04 11:14:35'),
(19, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Doctor Enrique González Martínez (sin número', '2024-03-04 12:47:21'),
(20, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-04 12:58:44'),
(21, 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-04 13:03:47'),
(22, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-04 13:29:50'),
(23, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-04 13:35:17'),
(24, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-04 13:40:14'),
(25, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-04 15:47:28'),
(26, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-04 16:55:41'),
(27, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-04 17:00:43'),
(28, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Doctor Enrique González Martínez (sin número', '2024-03-04 17:22:51'),
(29, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Eligio Ancona 79, Ciudad de México', '2024-03-04 17:37:51'),
(30, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-05 09:45:07'),
(31, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Eligio Ancona 79, Ciudad de México', '2024-03-05 10:02:01'),
(32, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Eligio Ancona 79, Ciudad de México', '2024-03-05 11:17:46'),
(33, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', 'Calle Chopo Pino (sin número), Ciudad de México', '2024-03-06 09:36:42');

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
(2, 2, 1, 9, 5, 4, NULL),
(4, 4, 3, 10, 5, 8, NULL),
(6, 6, 1, 9, 4, 1, NULL),
(7, 7, 3, 10, 5, 8, NULL),
(8, 8, 5, 3, 5, 5, NULL),
(10, 10, 3, 10, 5, 8, NULL),
(14, 14, 3, 10, 5, 1, NULL),
(15, 15, 3, 10, 5, 1, NULL),
(16, 16, 3, 10, 5, 1, NULL),
(17, 17, 3, 10, 5, 1, NULL),
(18, 18, 2, 9, 5, 1, NULL),
(19, 19, 2, 9, 5, 1, NULL),
(20, 20, 2, 9, 5, 1, NULL),
(21, 21, 2, 9, 5, 1, NULL),
(22, 22, 2, 9, 5, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_pogreso`
--

CREATE TABLE `asignacion_pogreso` (
  `id_progreso` int(10) NOT NULL,
  `id_fk_usuario` int(10) DEFAULT NULL,
  `id_fk_libro` int(10) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `progreso` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Estatus` int(1) DEFAULT NULL COMMENT '0=Inactivo;1=Activo',
  `id_fk_usuario` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_autor`
--

INSERT INTO `cat_autor` (`id_autor`, `Nombre`, `Apellido_paterno`, `Apellido_materno`, `Resumen_biblografia`, `Foto`, `Token`, `Estatus`, `id_fk_usuario`) VALUES
(1, 'Gabriel', 'Garcia', 'Marquez', 'García Márquez, autor colombiano, maestro del realismo mágico, ganador del Nobel. Obras notables: \"Cien años de soledad\" y \"El otoño del patriarca', 'public/doc/NECAXK65BN.jpg', 'NECAXK65BN', 1, NULL),
(2, 'J. K. ', 'Rowling', '', 'JK Rowling, autora británica, es conocida por la serie de libros \"Harry Potter\", que ha vendido millones de copias y se ha adaptado al cine.', 'public/doc/6J5YO5BZ1C.jpg', '6J5YO5BZ1C', 1, NULL),
(3, 'Reki', 'Kawahara', '', 'Reki Kawahara, escritor japonés, destacó con la serie de novelas ligeras \"Sword Art Online\", fusionando aventura y realidad virtual.', 'public/doc/OWV3CEOPOQ.jpg', 'OWV3CEOPOQ', 1, NULL),
(5, 'Antoine', 'de Saint-Exupéry', '', 'Antoine de Saint-Exupéry, escritor y aviador francés, es célebre por su obra \"El Principito\", una fábula filosófica que explora temas universales con emotividad', 'public/doc/KAEYSO8JD3.jpg', 'KAEYSO8JD3', 1, NULL),
(6, 'Dante', ' Alighieri', '', 'Dante Alighieri (1265-1321) fue un poeta y filósofo italiano. Su obra maestra, \"La Divina Comedia,\" es un poema épico que narra su viaje a través del Infierno, ', 'public/doc/CBFR4XMCXG.jpg', 'CBFR4XMCXG', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_categoria`
--

CREATE TABLE `cat_categoria` (
  `id_categoria` int(11) NOT NULL,
  `Categoria` varchar(100) DEFAULT NULL,
  `Estatus` int(1) DEFAULT NULL COMMENT '0=Inactivo;1=Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_categoria`
--

INSERT INTO `cat_categoria` (`id_categoria`, `Categoria`, `Estatus`) VALUES
(1, 'Ficción', 1),
(2, 'No Ficción', 1),
(3, 'Misterio', 1),
(4, 'Romance', 1),
(5, 'Ciencia Ficción', 1),
(6, 'Historia', 1),
(7, 'Biografías', 0),
(8, 'Fantasía', 1),
(9, 'Poesía', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_editorial`
--

CREATE TABLE `cat_editorial` (
  `id_editorial` int(10) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Estatus` int(1) DEFAULT NULL COMMENT '0=Inactivo;1=Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cat_editorial`
--

INSERT INTO `cat_editorial` (`id_editorial`, `Nombre`, `Estatus`) VALUES
(1, 'Acantilado', 1),
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
  `Estatus` int(1) DEFAULT NULL COMMENT '0=Inactivo;1=Activo'
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
(54, 'English - United Kingdom', 1);

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
(1, 'Harry Potter  El caliz de fuego', 636, '2024-01-25', '2000-05-01', 'En \'Harry Potter y el Cáliz de Fuego\', Harry se enfrenta al Torneo de los Tres Magos, desvela secretos oscuros y se enfrenta al renacer de Voldemort, explorando lealtad, amistad y su propio crecimiento.', 'Harry', 1, 'public/PortadaLibro/IRKBNQ4L98.jpg', 'public/docLibros/G91QDM3ADU.pdf', 'G91QDM3ADU', 'IRKBNQ4L98', NULL),
(2, 'Harry Potter y la piedra filosofal', 223, '2024-01-23', '1997-06-26', 'En \'Harry Potter y la Piedra Filosofal\', Harry descubre su identidad como mago, asiste a Hogwarts, y junto con sus amigos, Hermione y Ron, enfrenta desafíos para evitar que la Piedra Filosofal caiga en manos equivocadas, revelando así su valentía y el inicio de su viaje mágico.', 'Harry', 1, 'public/PortadaLibro/5PO4KOE9VQ.jpg', 'public/docLibros/Y55VSEKSQH.pdf', 'Y55VSEKSQH', '5PO4KOE9VQ', NULL),
(4, 'Sword ar online volumen 1', 200, '2024-01-25', '2007-08-01', 'Kirito, afortunado en Sword Art Online, un VRMMORPG, queda atrapado con 10,000 jugadores. La única salida es despejar los 100 pisos de Aincrad, pero después de dos años, quedan 26 pisos y 6,000 jugadores. La muerte virtual es real.', 'SAO', 1, 'public/PortadaLibro/CGU8F4D4Z7.jpg', 'public/docLibros/WGPUSVCTR9.pdf', 'WGPUSVCTR9', 'CGU8F4D4Z7', NULL),
(6, '100 años de soledad ', 471, '2024-01-25', '1961-06-05', '100 años de soledad\" de Gabriel García Márquez narra la historia de la familia Buendía en Macondo. Desde la fundación hasta su caída, la novela aborda temas como amor, poder, soledad y el ciclo de la vida. Con elementos mágicos y realismo mágico, la obra destaca la complejidad de las relaciones familiares y la inevitable repetición de la historia.', 'gabriel', 1, 'public/PortadaLibro/I9ZU527JGU.jpg', 'public/docLibros/OZQXPI3JHL.pdf', 'OZQXPI3JHL', 'I9ZU527JGU', NULL),
(7, 'Sword art online volumen 2', 351, '2024-01-26', '2009-08-10', 'En la novela 2 de Sword Art Online, titulada \"Aincrad\", Kirito explora más a fondo el mundo virtual. Se centra en la relación con Asuna, desentrañando misterios y enfrentándose a nuevos desafíos mortales dentro del juego. La trama explora las complejidades de la vida virtual y cómo afecta a los jugadores, mientras se desarrolla la conexión entre Kirito y Asuna en medio de la lucha por la supervivencia.', 'sao', 1, 'public/PortadaLibro/VZ9KZUBS77.jpg', 'public/docLibros/IJURZ5JSGF.pdf', 'IJURZ5JSGF', 'VZ9KZUBS77', NULL),
(8, 'El principito', 500, '2024-01-26', '1943-04-06', 'En él, un piloto se encuentra perdido en el desierto del Sahara después de que su avión sufriera una avería, pero para su sorpresa, es allí donde conoce a un pequeño príncipe proveniente de otro planeta.', 'principito', 1, 'public/PortadaLibro/IR6MWHF3E5.jpg', 'public/docLibros/EWGFCYT5EO.pdf', 'EWGFCYT5EO', 'IR6MWHF3E5', NULL),
(10, 'sword art online volumen 3', 500, '2024-01-31', '2007-06-07', 'En la novela 2 de Sword Art Online, titulada \"Aincrad\", Kirito explora más a fondo el mundo virtual. Se centra en la relación con Asuna, desentrañando misterios y enfrentándose a nuevos desafíos mortales dentro del juego. La trama explora las complejidades de la vida virtual y cómo afecta a los jugadores, mientras se desarrolla la conexión entre Kirito y Asuna en medio de la lucha por la supervivencia.', 'sao', 1, 'public/PortadaLibro/JI9A3TLRPS.jpg', 'public/docLibros/5EROP8X7N3.pdf', '5EROP8X7N3', 'JI9A3TLRPS', NULL),
(14, 'Sword ar online volumen 4', 311, '2024-02-26', '2010-04-10', 'Después de frustrar la posible emboscada de los Salamander, Kirito y Leafa dejan Aarun para ir hacia el Árbol del Mundo, pero se desvían a causa de un evento y terminan en el Inframundo, Jötunheimr. Con la ayuda de un aliado improbable llegan a la ciudad sólo para encontrar que el camino hacia el Árbol del Mundo está bloqueado. Al final, Kirito salva a Asuna, y ellos junto con otros jugadores de SAO de su escuela secundaria, empiezan a jugar ALO pero con una nueva función, un nuevo Aincrad y Kir', 'sao', 1, 'public/PortadaLibro/PIRJA647M1.jpg', 'public/docLibros/A4VET7CR8A.pdf', 'A4VET7CR8A', 'PIRJA647M1', NULL),
(15, 'sword art online volumen 5', 297, '2024-02-26', '2010-08-10', 'Habiendo transcurrido cerca de un año desde que SAO fue completado, Kirito es contactado por el investigador Kikuoka Seijirou para abordar un extraño caso relacionado con el juego Gun Gale Online. Al parecer, un misterioso jugador que se hace llamar Death Gun puede vincular las muertes dentro del mundo virtual con el mundo real. Kirito se adentra en este VRMMO y ahí conoce a Sinon, quien le enseña varias cosas sobre el juego. Después ambos participan en el torneo Bullet of Bullets (BoB) de Gun G', 'sao', 1, 'public/PortadaLibro/7C572C7DED.jpg', 'public/docLibros/4BO5AOMR1X.pdf', '4BO5AOMR1X', '7C572C7DED', NULL),
(16, 'Sword ar online volumen 6', 445, '2024-02-26', '2010-12-10', 'Kirito entra a la final del torneo Bullet of Bullets para así llegar hasta el fondo del misterioso caso relacionado con Death Gun. Con el apoyo de la francotiradora conocida como Sinon, él busca detener a esa fuerza letal al mismo tiempo que lucha por su vida.', 'sao', 1, 'public/PortadaLibro/OH4UV9E7OL.jpg', 'public/docLibros/2SRSOVYQ37.pdf', '2SRSOVYQ37', 'OH4UV9E7OL', NULL),
(17, 'Sword ar online volumen 7', 305, '2024-02-26', '2011-04-10', 'Cuando un misterioso espadachín aparece en el nuevo Aincrad con una insólita habilidad a la cual nadie puede ganar, Asuna se muestra interesada en conocerlo. Pero la protagonista sólo se encuentra con que dicho espadachín que lleva el apodo de \"Zekken\" (espada absoluta) es en realidad una chica que necesita de su ayuda.', 'sao', 1, 'public/PortadaLibro/73TH5NKIY7.jpg', 'public/docLibros/BU25Z9WP8E.pdf', 'BU25Z9WP8E', '73TH5NKIY7', NULL),
(18, 'Harry Potter la piedra de azkaban', 359, '2024-02-26', '2000-03-27', '\r\nEn la tercera entrega de la serie, Harry Potter, ahora de trece años, espera ansioso su tercer año en Hogwarts. Después de un enfrentamiento con su tía Marge, Harry escapa en un autobús mágico. Mientras tanto, Sirius Black, un peligroso villano escapado de Azkaban, amenaza a Harry. Aparecen también los aterradores dementores, capaces de robar la felicidad. Con la ayuda de sus amigos Ron y Hermione, Harry enfrenta estos desafíos. El trío demuestra que, a pesar de las amenazas, están listos para', 'Harry', 1, 'public/PortadaLibro/LUUNR2HWEE.jpg', 'public/docLibros/2KZU417DI1.pdf', '2KZU417DI1', 'LUUNR2HWEE', NULL),
(19, 'Harry Potter y la orden del fenix', 893, '2024-02-26', '2004-02-19', 'En las tediosas vacaciones, Harry presiente problemas en Hogwarts. Al iniciar el nuevo curso, sus temores se confirman. El Ministerio de Magia niega el retorno de Voldemort, difama a Harry y nombra a Dolores Umbridge para vigilarlo. Solitario y incomprendido, Harry siente que Voldemort busca un objeto para recuperar su poder. Enfrentando la hostilidad oficial y sus propios miedos, Harry intuye que la oscura amenaza crece. Con Ron y Hermione ausentes, el joven mago se enfrenta a desafíos desconce', 'Harry', 1, 'public/PortadaLibro/AH5CGCTTVI.jpg', 'public/docLibros/STNHLDX91X.pdf', 'STNHLDX91X', 'AH5CGCTTVI', NULL),
(20, 'Harry Potter y el misterio del principe', 602, '2024-02-26', '2006-02-21', 'Con dieciséis años, Harry enfrenta su sexto año en Hogwarts, marcado por terribles eventos en Inglaterra. Como capitán del equipo de quidditch, se debate entre ensayos, exámenes y asuntos amorosos. A pesar de la seguridad en la escuela, dos alumnos son brutalmente atacados. Dumbledore, consciente de la Profecía, prepara a Harry para el inevitable enfrentamiento con Voldemort. Juntos emprenden viajes peligrosos para debilitar al enemigo. La Profecía dicta que solo uno de ellos debe sobrevivir. Co', 'Harry', 1, 'public/PortadaLibro/VWKVAIMDBY.jpg', 'public/docLibros/Z36145KHK7.pdf', 'Z36145KHK7', 'VWKVAIMDBY', NULL),
(21, 'Harry Potter y las reliquias de la muerte', 704, '2024-02-26', '2008-02-19', 'La fecha de acerca. Cuando cumpla diecisiete años, Harry perderá el encantamiento protector que lo mantiene a salvo. El anunciado duelo a muerte con lord Voldemort es inminente, y la casi imposible misión de encontrar y destruir los restantes Horrocruxes, más urgente que nunca. Ha llegado la hora final, el momento de tomar decisiones difíciles. Harry debe abandonar la calidez de La Madriguera para seguir sin miedo ni vacilaciones el inexorable sendero trazado para él. Consciente de lo mucho que ', 'Harry', 1, 'public/PortadaLibro/8AGZVBEN23.jpg', 'public/docLibros/ROJQW5SC7Z.pdf', 'ROJQW5SC7Z', '8AGZVBEN23', NULL),
(22, 'Harry Potter y el legado maldito', 589, '2024-02-26', '2016-09-28', 'Siempre fue difícil ser Harry Potter y no es mucho más fácil ahora que es un empleado con exceso de trabajo del Ministerio de Magia, un marido y padre de tres niños en edad escolar.\r\n\r\nMientras Harry se enfrenta con un pasado que se niega a permanecer donde pertenece, su hijo menor Albus debe luchar con el peso de una herencia familiar que nunca quiso. Como el pasado y el presente se fusionan ominosamente, padre e hijo descubren una verdad incómoda: a veces, la oscuridad viene de lugares inesper', 'Harry', 1, 'public/PortadaLibro/C1ENZOIKXE.jpg', 'public/docLibros/T9LRBIL5WI.pdf', 'T9LRBIL5WI', 'C1ENZOIKXE', NULL);

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
  `estatus_menu` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactivo;1=Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cat_menu`
--

INSERT INTO `cat_menu` (`id_menu`, `nombre_menu`, `descripcion_menu`, `referencia_menu`, `posicion_menu`, `icono_menu`, `tipo_usuario`, `estatus_menu`) VALUES
(1, 'Inicio', 'Página de inicio', NULL, 1, '<i class=\"fa-solid fa-house\"></i>', 3, 1),
(2, 'Salir', 'Salir del sistema', 'login/salir', 100, '<i class=\"fa-solid fa-right-from-bracket\"></i>', 3, 1),
(3, 'Configuracion', 'Configura tu cuenta', 'admin/general', 99, '<i class=\"fas fa-cog\"></i>\n', 3, 1),
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
  `Estatus` int(1) DEFAULT NULL COMMENT '0=Inactivo;1=Activo',
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
(5, 'U.Abraham', 'Vera ', 'Martinez', 'Hombre', 2, 1, 'abrahamviejito2000@gmail.com', 'Abraham10'),
(13, 'Axel Adrian', 'Rojas', 'Mata', 'Hombre', 2, 1, 'axeladrian@gmail.com', 'Adrian23'),
(14, 'Magali', 'Martinez ', '', 'Mujer', 2, 1, 'magalimartinez1978@gmail.com', 'Magali\"\"15'),
(15, 'Francisco', 'Arenal', 'Guerrero', 'Hombre', 2, 1, 'francisco.arenal.guerrero@gmail.com', '12345...'),
(16, 'Diego Alberto ', 'Rodriguez', 'Rojas', 'Hombre', 2, 1, 'bart@gmail.com', 'Diego##15'),
(17, 'Susana ', 'Llamas', '', 'Mujer', 2, 1, 'susuna.llamas@mail.com', 'Susana20.9'),
(19, 'Enrique ', 'valencia', '', 'Hombre', 2, 1, 'c.enrique.v@edu.utc.mx', 'Enrique#10'),
(27, 'Abraham', 'Martinez', '', 'Hombre', 2, 1, 'a.vera.m@mail.com', 'Abraham}2023'),
(28, 'Alejandro', 'Vera', '', 'Hombre', 2, 1, 'alexvera@mail.com', 'Alejandro\"10'),
(37, 'Raymunda', 'Torres', '', 'Mujer', 2, 1, 'raymundatorres@mail.com', 'Raymunda%20');

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
-- Indices de la tabla `asignacion_dispositivo`
--
ALTER TABLE `asignacion_dispositivo`
  ADD PRIMARY KEY (`id_dispositivo`),
  ADD KEY `id_fk_usuario` (`id_fk_usuario`);

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
-- Indices de la tabla `asignacion_pogreso`
--
ALTER TABLE `asignacion_pogreso`
  ADD PRIMARY KEY (`id_progreso`),
  ADD KEY `id_fk_usuario` (`id_fk_usuario`),
  ADD KEY `id_fk_libro` (`id_fk_libro`);

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
  MODIFY `id_comentario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `asignacion_dispositivo`
--
ALTER TABLE `asignacion_dispositivo`
  MODIFY `id_dispositivo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `asignacion_libro`
--
ALTER TABLE `asignacion_libro`
  MODIFY `id_asignacion_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `asignacion_pogreso`
--
ALTER TABLE `asignacion_pogreso`
  MODIFY `id_progreso` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_autor`
--
ALTER TABLE `cat_autor`
  MODIFY `id_autor` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cat_categoria`
--
ALTER TABLE `cat_categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cat_editorial`
--
ALTER TABLE `cat_editorial`
  MODIFY `id_editorial` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `cat_idioma`
--
ALTER TABLE `cat_idioma`
  MODIFY `id_idioma` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `cat_libro`
--
ALTER TABLE `cat_libro`
  MODIFY `id_libro` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
-- Filtros para la tabla `asignacion_dispositivo`
--
ALTER TABLE `asignacion_dispositivo`
  ADD CONSTRAINT `asignacion_dispositivo_ibfk_1` FOREIGN KEY (`id_fk_usuario`) REFERENCES `cat_usuario` (`id_usuario`);

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
-- Filtros para la tabla `asignacion_pogreso`
--
ALTER TABLE `asignacion_pogreso`
  ADD CONSTRAINT `asignacion_pogreso_ibfk_1` FOREIGN KEY (`id_fk_usuario`) REFERENCES `cat_usuario` (`id_usuario`),
  ADD CONSTRAINT `asignacion_pogreso_ibfk_2` FOREIGN KEY (`id_fk_libro`) REFERENCES `cat_libro` (`id_libro`);

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
