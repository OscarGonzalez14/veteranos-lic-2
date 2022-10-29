-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-10-2022 a las 00:51:26
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `veteranos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones_orden`
--

CREATE TABLE `acciones_orden` (
  `id_accion` int(11) NOT NULL,
  `fecha` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_accion` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `acciones_orden`
--

INSERT INTO `acciones_orden` (`id_accion`, `fecha`, `usuario`, `codigo`, `tipo_accion`, `observaciones`) VALUES
(33, '23-10-2022 15:46:34', NULL, '231020221', 'Digitación orden', 'Digitación orden'),
(34, '23-10-2022 15:53:24', 'oscar', '231020221', 'Digitación orden', 'Digitación orden'),
(35, '23-10-2022 15:57:27', 'oscar', '231020221', 'Digitación orden', 'Digitación orden'),
(36, '23-10-2022 16:00:19', 'oscar', '231020221', 'Digitación orden', 'Digitación orden'),
(37, '23-10-2022 16:05:31', 'oscar', '231020221', 'Digitación orden', 'Digitación orden'),
(38, '23-10-2022 16:12:41', 'oscar', '231020221', 'Digitación orden', 'Digitación orden'),
(39, '23-10-2022 16:20:00', 'oscar', '231020221', 'Digitación orden', 'Digitación orden'),
(40, '25-10-2022 14:14:30', 'oscar', '251020221', 'Digitación orden', 'Digitación orden'),
(41, '29-10-2022 15:31:44', '<br />\n<b>Notice</b>:  Undefined index: usuario in', '291020221', 'Digitación orden', 'Digitación orden'),
(42, '29-10-2022 15:39:47', 'oscar', '291020221', 'Digitación orden', 'Digitación orden'),
(43, '29-10-2022 16:06:47', 'oscar', '291020222', 'Digitación orden', 'Digitación orden');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones_ordenes_veteranos`
--

CREATE TABLE `acciones_ordenes_veteranos` (
  `id_orden_rec` int(11) NOT NULL,
  `correlativo_accion` varchar(15) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(15) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  `tipo_acccion` varchar(50) NOT NULL,
  `ubicacion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `acciones_ordenes_veteranos`
--

INSERT INTO `acciones_ordenes_veteranos` (`id_orden_rec`, `correlativo_accion`, `fecha`, `hora`, `usuario`, `tipo_acccion`, `ubicacion`) VALUES
(1, 'A-1', '2022-10-19', '13:48:14', 'oscar', 'Ingreso INABVE', '3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aros`
--

CREATE TABLE `aros` (
  `id_aro` int(11) NOT NULL,
  `marca` varchar(75) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `color` varchar(10) NOT NULL,
  `material` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `aros`
--

INSERT INTO `aros` (`id_aro`, `marca`, `modelo`, `color`, `material`) VALUES
(1, '', 'LS8035', 'c2', 'METAL'),
(2, '', 'LS8035', 'c5', 'METAL'),
(3, 'CAROLINA HERRERA', 'LS8035', 'pc5', 'METAL'),
(4, 'NIKE', 'LS8035t', 'c2', 'METAL'),
(5, 'RAY-BAN', 'LS803525', 'c2', 'ACETATO'),
(6, 'AND VAS', 'LS8035', 'c2', 'METAL'),
(7, 'AND VAS', 'a2025', 'c2', 'METAL'),
(8, 'AND VAS', 'a2125', 'c2', 'METAL'),
(9, 'AND VAS', 'A20255', 'C8', 'METAL'),
(10, 'AND VAS', 'LS8035', 'g', 'METAL'),
(11, 'otra marca', 'LS8035', 'c2', 'ACETATO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `paciente` varchar(225) NOT NULL,
  `dui` varchar(25) NOT NULL,
  `fecha` varchar(15) NOT NULL,
  `sucursal` varchar(30) NOT NULL,
  `color` varchar(15) NOT NULL,
  `estado` varchar(3) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `edad` varchar(3) NOT NULL,
  `ocupacion` varchar(200) NOT NULL,
  `genero` varchar(15) NOT NULL,
  `usuario_lente` varchar(3) NOT NULL,
  `sector` varchar(15) NOT NULL,
  `depto` varchar(50) NOT NULL,
  `municipio` varchar(200) NOT NULL,
  `hora` varchar(15) NOT NULL,
  `fecha_reg` varchar(15) NOT NULL,
  `hora_reg` varchar(15) NOT NULL,
  `id_usuario` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_cita`, `paciente`, `dui`, `fecha`, `sucursal`, `color`, `estado`, `telefono`, `edad`, `ocupacion`, `genero`, `usuario_lente`, `sector`, `depto`, `municipio`, `hora`, `fecha_reg`, `hora_reg`, `id_usuario`) VALUES
(50, 'Jose Eduardo Lopez', '02125588-5', '2022-10-27', 'Cascadas', '#C85250', '0', '2884-4112', '35', 'Sastre', 'Masculino', '0', 'FAES', 'La Libertad', 'Chiltiupán', '9:15 AM', '2022-10-27', '12:32:20', '1'),
(51, 'Karina Antonio Gonzalez', '68222222-4', '2022-10-27', 'Gotera', '#C85250', '0', '5832-2222', '45', 'Enfermera', 'Masculino', '0', 'FMLN', 'Santa Ana', 'El Congo', '9:45 AM', '2022-10-27', '12:33:45', '1'),
(52, 'Rafael Eduardo Corvera', '02555588-8', '2022-10-28', 'Metrocentro', '#C85250', '0', '5588-8888', '25', 'S/O', 'Masculino', '0', 'FAES', 'San Salvador', 'Apopa', '9:15 AM', '2022-10-28', '11:33:16', '1'),
(53, 'Rolando Marin', '24555555-6', '2022-10-28', 'Cascadas', '#C85250', '0', '7444-4555', '15', '5588', 'Masculino', '0', 'FAES', 'San Salvador', 'Apopa', '9:30 AM', '2022-10-28', '15:51:55', '1'),
(54, 'Marvin alexander Diaz', '02525858-8', '2022-10-29', 'Ciudad Arce', '#C85250', '0', '2555-5555', '23', 'Estudiante', 'Masculino', '0', 'FMLN', 'San Salvador', 'Apopa', '9:15 AM', '2022-10-29', '10:14:39', '1'),
(55, 'Carolina Hernadez', '28555555-5', '2022-10-29', 'Ciudad Arce', '#C85250', '0', '5888-5552', '258', '255555555555555555', 'Masculino', '0', 'FAES', 'San Salvador', 'Apopa', '9:30 AM', '2022-10-29', '10:15:31', '1'),
(56, 'Juan Abelardo Murgas', '04144447-7', '2022-10-29', 'Santa Ana', '#C85250', '0', '7144-1111', '25', 'Optometra', 'Masculino', '0', 'FAES', 'San Salvador', 'Apopa', '10:00 AM', '2022-10-29', '13:41:08', '1'),
(57, 'Ana Maria Gonzalez', '25896665-5', '2022-10-01', 'Opico', '#C85250', '0', '5222-2222', '22', '2', 'Masculino', '0', 'FAES', 'San Salvador', 'Apopa', '9:45 AM', '2022-10-29', '16:03:02', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_acciones_veteranos`
--

CREATE TABLE `detalle_acciones_veteranos` (
  `id_detalle_accion` int(11) NOT NULL,
  `codigo_orden` varchar(25) NOT NULL,
  `correlativo_accion` varchar(15) NOT NULL,
  `estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_acciones_veteranos`
--

INSERT INTO `detalle_acciones_veteranos` (`id_detalle_accion`, `codigo_orden`, `correlativo_accion`, `estado`) VALUES
(1, '091020222', 'A-1', 'Recibido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso_aros`
--

CREATE TABLE `detalle_ingreso_aros` (
  `id_ingreso` int(11) NOT NULL,
  `id_aro` int(11) NOT NULL,
  `n_ingreso` varchar(10) NOT NULL,
  `cantidad` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_ingreso_aros`
--

INSERT INTO `detalle_ingreso_aros` (`id_ingreso`, `id_aro`, `n_ingreso`, `cantidad`) VALUES
(1, 7, 'I-4', '2'),
(2, 6, 'I-4', '1'),
(3, 5, 'I-4', '2'),
(4, 7, 'I-5', '1'),
(5, 7, 'I-6', '1'),
(6, 7, 'I-7', '1'),
(7, 7, 'I-8', '1'),
(8, 7, 'I-9', '3'),
(9, 7, 'I-10', '1'),
(10, 6, 'I-10', '1'),
(11, 5, 'I-10', '1'),
(12, 7, 'I-11', '1'),
(13, 6, 'I-11', '1'),
(14, 5, 'I-11', '1'),
(15, 7, 'I-12', '1'),
(16, 6, 'I-12', '1'),
(17, 5, 'I-12', '2'),
(18, 6, 'I-13', '1'),
(19, 5, 'I-13', '1'),
(20, 3, 'I-13', '1'),
(21, 7, 'I-14', '1'),
(22, 6, 'I-14', '1'),
(23, 1, 'I-14', '1'),
(24, 7, 'I-15', '1'),
(25, 6, 'I-15', '2'),
(26, 7, 'I-16', '1'),
(27, 6, 'I-16', '1'),
(28, 5, 'I-16', '2'),
(29, 7, 'I-17', '1'),
(30, 6, 'I-17', '2'),
(31, 4, 'I-17', '1'),
(32, 3, 'I-17', '1'),
(33, 2, 'I-17', '1'),
(34, 7, 'I-18', '1'),
(35, 6, 'I-18', '1'),
(36, 8, 'I-19', '1'),
(37, 7, 'I-19', '1'),
(38, 6, 'I-19', '2'),
(39, 5, 'I-19', '1'),
(40, 5, 'I-20', '2'),
(41, 4, 'I-20', '1'),
(42, 3, 'I-20', '1'),
(43, 2, 'I-20', '2'),
(44, 9, 'I-21', '1'),
(45, 8, 'I-21', '2'),
(46, 7, 'I-21', '5'),
(47, 6, 'I-21', '1'),
(48, 4, 'I-21', '1'),
(49, 3, 'I-21', '1'),
(50, 2, 'I-21', '1'),
(51, 1, 'I-21', '1'),
(52, 9, 'I-22', '4'),
(53, 8, 'I-22', '3'),
(54, 9, 'I-23', '1'),
(55, 8, 'I-23', '3'),
(56, 7, 'I-23', '2'),
(57, 5, 'I-23', '1'),
(58, 3, 'I-24', '2'),
(59, 2, 'I-24', '1'),
(60, 6, 'I-24', '1'),
(61, 1, 'I-24', '1'),
(62, 11, 'I-25', '1'),
(63, 10, 'I-25', '1'),
(64, 9, 'I-25', '1'),
(65, 8, 'I-25', '1'),
(66, 11, 'I-26', '1'),
(67, 11, 'I-27', '2'),
(68, 11, 'I-28', '1'),
(69, 10, 'I-28', '2'),
(70, 9, 'I-28', '2'),
(71, 9, 'I-29', '1'),
(72, 9, 'I-29', '1'),
(73, 9, 'I-29', '1'),
(74, 9, 'I-29', '1'),
(75, 9, 'I-29', '1'),
(76, 9, 'I-29', '1'),
(77, 9, 'I-29', '1'),
(78, 9, 'I-29', '1'),
(79, 9, 'I-29', '1'),
(80, 9, 'I-29', '1'),
(81, 9, 'I-29', '1'),
(82, 9, 'I-29', '1'),
(83, 9, 'I-29', '1'),
(84, 9, 'I-29', '1'),
(85, 9, 'I-29', '1'),
(86, 9, 'I-29', '1'),
(87, 9, 'I-29', '1'),
(88, 9, 'I-29', '1'),
(89, 9, 'I-29', '1'),
(90, 9, 'I-29', '1'),
(91, 9, 'I-29', '1'),
(92, 9, 'I-29', '1'),
(93, 9, 'I-29', '1'),
(94, 9, 'I-29', '1'),
(95, 9, 'I-29', '1'),
(96, 9, 'I-29', '1'),
(97, 9, 'I-29', '1'),
(98, 9, 'I-29', '1'),
(99, 9, 'I-29', '1'),
(100, 9, 'I-29', '1'),
(101, 9, 'I-29', '1'),
(102, 9, 'I-29', '1'),
(103, 9, 'I-29', '1'),
(104, 9, 'I-29', '1'),
(105, 9, 'I-29', '1'),
(106, 9, 'I-29', '1'),
(107, 1, 'I-29', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden_rectificicacion`
--

CREATE TABLE `detalle_orden_rectificicacion` (
  `id_det_recti` int(11) NOT NULL,
  `codigo_recti` varchar(25) DEFAULT NULL,
  `codigo_orden` varchar(25) DEFAULT NULL,
  `paciente` varchar(150) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `pupilar_od` varchar(10) DEFAULT NULL,
  `pupilar_oi` varchar(10) DEFAULT NULL,
  `lente_od` varchar(10) DEFAULT NULL,
  `lente_oi` varchar(10) DEFAULT NULL,
  `marca_aro` varchar(10) DEFAULT NULL,
  `modelo_aro` varchar(10) DEFAULT NULL,
  `horizontal_aro` varchar(10) DEFAULT NULL,
  `vertical_aro` varchar(10) DEFAULT NULL,
  `puente_aro` varchar(10) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `observaciones` varchar(200) DEFAULT NULL,
  `dui` varchar(12) NOT NULL,
  `estado` varchar(3) NOT NULL,
  `fecha_correlativo` varchar(25) DEFAULT NULL,
  `tipo_lente` varchar(50) NOT NULL,
  `color_varilla` varchar(50) NOT NULL,
  `color_frente` varchar(50) NOT NULL,
  `img` varchar(200) NOT NULL,
  `laboratorio` varchar(100) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `estado_aro` varchar(2) NOT NULL,
  `dest_aro` varchar(50) NOT NULL,
  `edad` varchar(3) NOT NULL,
  `usuario_lente` varchar(2) NOT NULL,
  `ocupacion` varchar(200) NOT NULL,
  `avsc` varchar(10) NOT NULL,
  `avfinal` varchar(10) NOT NULL,
  `avsc_oi` varchar(50) NOT NULL,
  `avfinal_oi` varchar(50) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `genero` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso_aros`
--

CREATE TABLE `ingreso_aros` (
  `id_ingreso` int(11) NOT NULL,
  `n_ingreso` varchar(10) NOT NULL,
  `fecha` varchar(15) NOT NULL,
  `hora` varchar(15) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `bodega` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ingreso_aros`
--

INSERT INTO `ingreso_aros` (`id_ingreso`, `n_ingreso`, `fecha`, `hora`, `id_usuario`, `bodega`) VALUES
(1, 'I-1', '2022-10-16', '14:54:38', 1, 'La Libertad'),
(2, 'I-2', '2022-10-16', '14:56:41', 1, 'Santa Ana'),
(3, 'I-3', '2022-10-16', '15:15:15', 1, 'Cascadas'),
(4, 'I-4', '2022-10-16', '15:16:11', 1, 'Cascadas'),
(5, 'I-5', '2022-10-16', '15:56:00', 1, 'Cascadas'),
(6, 'I-6', '2022-10-16', '15:57:25', 1, 'Cascadas'),
(7, 'I-7', '2022-10-16', '15:58:11', 1, 'Cascadas'),
(8, 'I-8', '2022-10-16', '16:00:46', 1, 'Cascadas'),
(9, 'I-9', '2022-10-16', '16:01:05', 1, 'Cascadas'),
(10, 'I-10', '2022-10-16', '16:07:53', 1, 'Santa Ana'),
(11, 'I-11', '2022-10-16', '16:08:49', 1, 'Santa Ana'),
(12, 'I-12', '2022-10-16', '16:17:04', 1, 'Santa Ana'),
(13, 'I-13', '2022-10-16', '16:19:09', 1, 'Chalatenango'),
(14, 'I-14', '2022-10-16', '16:20:54', 1, 'Ciudad Arce'),
(15, 'I-15', '2022-10-16', '16:23:51', 1, 'Ciudad Arce'),
(16, 'I-16', '2022-10-16', '16:33:41', 1, 'Chalatenango'),
(17, 'I-17', '2022-10-16', '16:36:40', 1, 'Chalatenango'),
(18, 'I-18', '2022-10-16', '16:55:35', 1, 'Cascadas'),
(19, 'I-19', '2022-10-16', '16:59:15', 1, 'Ahuachapan'),
(20, 'I-20', '2022-10-17', '12:44:05', 1, 'Santa Ana'),
(21, 'I-21', '2022-10-17', '14:18:37', 1, 'Cascadas'),
(22, 'I-22', '2022-10-17', '14:38:13', 1, 'Opico'),
(23, 'I-23', '2022-10-19', '12:35:31', 1, 'Santa Ana'),
(24, 'I-24', '2022-10-19', '17:59:45', 1, 'Chalatenango'),
(25, 'I-25', '2022-10-22', '16:40:08', 1, 'Metrocentro'),
(26, 'I-26', '2022-10-23', '16:42:43', 1, 'Metrocentro'),
(27, 'I-27', '2022-10-23', '16:58:16', 1, 'Cascadas'),
(28, 'I-28', '2022-10-23', '18:40:41', 1, 'Metrocentro'),
(65, 'I-29', '2022-10-28', '14:37:40', 1, 'Metrocentro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `marca`) VALUES
(1, 'nueva marca'),
(2, 'otra marca'),
(3, 'otra marca'),
(4, 'otra marca'),
(5, 'otra marca'),
(6, 'otra marca'),
(7, 'OTRA MARCA'),
(8, 'OTRA MARCA'),
(9, 'afewrf'),
(10, 'Marcas'),
(11, 'otrasdf'),
(12, 'fffffffffffffffffff');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_bodega`
--

CREATE TABLE `movimientos_bodega` (
  `id_movimiento` int(11) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `esfera` varchar(10) NOT NULL,
  `cilindro` varchar(10) NOT NULL,
  `cantidad` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(12) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `tipo_movimiento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_lab`
--

CREATE TABLE `orden_lab` (
  `id_orden` int(11) NOT NULL,
  `codigo` varchar(25) DEFAULT NULL,
  `paciente` varchar(150) DEFAULT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `pupilar_od` varchar(10) DEFAULT NULL,
  `pupilar_oi` varchar(10) DEFAULT NULL,
  `lente_od` varchar(10) DEFAULT NULL,
  `lente_oi` varchar(10) DEFAULT NULL,
  `id_aro` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `observaciones` varchar(200) DEFAULT NULL,
  `dui` varchar(12) NOT NULL,
  `estado` varchar(3) NOT NULL,
  `fecha_correlativo` varchar(25) DEFAULT NULL,
  `tipo_lente` varchar(50) NOT NULL,
  `laboratorio` varchar(100) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `edad` varchar(3) NOT NULL,
  `usuario_lente` varchar(2) NOT NULL,
  `ocupacion` varchar(200) NOT NULL,
  `avsc` varchar(10) NOT NULL,
  `avfinal` varchar(10) NOT NULL,
  `avsc_oi` varchar(50) NOT NULL,
  `avfinal_oi` varchar(50) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `genero` varchar(5) NOT NULL,
  `depto` varchar(60) NOT NULL,
  `municipio` varchar(125) NOT NULL,
  `institucion` varchar(50) NOT NULL,
  `codigo_lenti` varchar(25) DEFAULT NULL,
  `color` varchar(15) NOT NULL,
  `alto_indice` varchar(3) NOT NULL,
  `patologias` varchar(15) NOT NULL,
  `id_cita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `orden_lab`
--

INSERT INTO `orden_lab` (`id_orden`, `codigo`, `paciente`, `fecha`, `pupilar_od`, `pupilar_oi`, `lente_od`, `lente_oi`, `id_aro`, `id_usuario`, `observaciones`, `dui`, `estado`, `fecha_correlativo`, `tipo_lente`, `laboratorio`, `categoria`, `edad`, `usuario_lente`, `ocupacion`, `avsc`, `avfinal`, `avsc_oi`, `avfinal_oi`, `telefono`, `genero`, `depto`, `municipio`, `institucion`, `codigo_lenti`, `color`, `alto_indice`, `patologias`, `id_cita`) VALUES
(16, '231020221', 'JorgeEduardo Rojas', '2022-10-23', '56', '52', '-', '-', 11, 1, '6', 'edewrr', '0', '23-10-2022 16:20:00', 'Progresive', '', '-', '29', 'os', 'Asesor', '6', '6', '6', '6', '25555', 'Mascu', 'San Salvador', 'Apopa', 'Seleccionar...', NULL, 'Blanco', 'No', 'Cataratas', 24),
(17, '251020221', 'Carla Martinez ', '2022-10-25', '56', '25', '-', '-', 9, 1, '-', '01225558-8', '0', '25-10-2022 14:14:30', 'Visión Sencilla', '', '-', '25', 'os', 'Enfermera', '-', '-', '-', '-', '2555-5555', 'Mascu', 'San Salvador', 'Ayutuxtepeque', 'FAES', NULL, 'Photocromatico', 'No', 'Pterigión', 27),
(18, '291020221', 'Rafael Eduardo Corvera', '2022-10-29', '56', '52', '-', '-', 11, 1, '+3.25', '02555588-8', '0', '29-10-2022 15:39:47', 'Progresive', '', '-', '25', 'os', 'S/O', '-', '-', '-', '-', '5588-8888', 'Mascu', 'San Salvador', 'Apopa', 'FAES', NULL, 'Blanco', 'No', 'Cataratas', 52),
(19, '291020222', 'Ana Maria Gonzalez', '2022-10-29', '56', '52', '-', '-', 8, 1, '---', '25896665-5', '0', '29-10-2022 16:06:47', 'Visión Sencilla', '', '-', '22', 'os', '2', '-', '-', '-', '-', '5222-2222', 'Mascu', 'San Salvador', 'Apopa', 'FAES', NULL, 'Blanco', 'No', 'No', 57);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre`) VALUES
(1, 'citas'),
(2, 'citas-reporteria'),
(3, 'editar_citas'),
(4, 'citas_callcenter'),
(5, 'citas_sucursal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_usuario`
--

CREATE TABLE `permisos_usuario` (
  `id_usuario_permiso` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_permiso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rectificacion`
--

CREATE TABLE `rectificacion` (
  `id_rectifi` int(11) NOT NULL,
  `codigo_rectifi` varchar(25) DEFAULT NULL,
  `fecha` varchar(15) DEFAULT NULL,
  `hora` varchar(15) DEFAULT NULL,
  `usuario` varchar(15) DEFAULT NULL,
  `motivo` varchar(200) DEFAULT NULL,
  `estado_aro` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rx_det_orden_recti`
--

CREATE TABLE `rx_det_orden_recti` (
  `id_rx_det_orden_recti` int(11) NOT NULL,
  `correlativo_recti` varchar(25) DEFAULT NULL,
  `codigo` varchar(25) DEFAULT NULL,
  `od_esferas` varchar(8) DEFAULT NULL,
  `od_cilindros` varchar(8) DEFAULT NULL,
  `od_eje` varchar(8) DEFAULT NULL,
  `od_adicion` varchar(8) DEFAULT NULL,
  `oi_esferas` varchar(8) DEFAULT NULL,
  `oi_cilindros` varchar(8) DEFAULT NULL,
  `oi_eje` varchar(8) DEFAULT NULL,
  `oi_adicion` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rx_orden_lab`
--

CREATE TABLE `rx_orden_lab` (
  `id_rx` int(11) NOT NULL,
  `codigo` varchar(25) NOT NULL,
  `od_esferas` varchar(8) DEFAULT NULL,
  `od_cilindros` varchar(8) DEFAULT NULL,
  `od_eje` varchar(8) DEFAULT NULL,
  `od_adicion` varchar(8) DEFAULT NULL,
  `oi_esferas` varchar(8) DEFAULT NULL,
  `oi_cilindros` varchar(8) DEFAULT NULL,
  `oi_eje` varchar(8) DEFAULT NULL,
  `oi_adicion` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rx_orden_lab`
--

INSERT INTO `rx_orden_lab` (`id_rx`, `codigo`, `od_esferas`, `od_cilindros`, `od_eje`, `od_adicion`, `oi_esferas`, `oi_cilindros`, `oi_eje`, `oi_adicion`) VALUES
(26, '231020221', '+2.50', '-0.75', '30°', '0.00', '+2.50', '-0.25', '150°', '0.00'),
(27, '251020221', '+2.25', '+2.50', '', '', '+2.50', '+2.50', '', ''),
(28, '291020221', '+2.50', '+0.00', '-', '-', '+2.25', '+2.25', '-', '0.00'),
(30, '291020222', '+2.50', '-0.75', '30°', '0.00', '+2.50', '-0.25', '150°', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_aros`
--

CREATE TABLE `stock_aros` (
  `id_ingreso` int(11) NOT NULL,
  `bodega` varchar(50) NOT NULL,
  `stock` varchar(3) NOT NULL,
  `id_aro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `stock_aros`
--

INSERT INTO `stock_aros` (`id_ingreso`, `bodega`, `stock`, `id_aro`) VALUES
(19, 'Santa Ana', '3', 5),
(20, 'Santa Ana', '1', 4),
(21, 'Santa Ana', '1', 3),
(22, 'Santa Ana', '2', 2),
(23, 'Cascadas', '1', 9),
(24, 'Cascadas', '2', 8),
(25, 'Cascadas', '5', 7),
(26, 'Cascadas', '1', 6),
(27, 'Cascadas', '1', 4),
(28, 'Cascadas', '1', 3),
(29, 'Cascadas', '1', 2),
(30, 'Cascadas', '1', 1),
(31, 'Opico', '4', 9),
(32, 'Opico', '3', 8),
(33, 'Santa Ana', '1', 9),
(34, 'Santa Ana', '3', 8),
(35, 'Santa Ana', '2', 7),
(36, 'Chalatenango', '2', 3),
(37, 'Chalatenango', '1', 2),
(38, 'Chalatenango', '1', 6),
(39, 'Chalatenango', '1', 1),
(40, 'Metrocentro', '3', 11),
(41, 'Metrocentro', '3', 10),
(42, 'Metrocentro', '3', 9),
(43, 'Metrocentro', '1', 8),
(44, 'Cascadas', '2', 11),
(45, 'San Miguel', '36', 9),
(46, 'Metrocentro', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_terminados`
--

CREATE TABLE `stock_terminados` (
  `codigo` varchar(60) NOT NULL,
  `identificador` varchar(25) NOT NULL,
  `id_tabla_term` int(11) DEFAULT NULL,
  `esfera` varchar(15) DEFAULT NULL,
  `cilindro` varchar(15) DEFAULT NULL,
  `stock_min` varchar(5) DEFAULT NULL,
  `stock` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablas_terminado`
--

CREATE TABLE `tablas_terminado` (
  `id_tabla_term` int(11) NOT NULL,
  `titulo` varchar(125) NOT NULL,
  `marca` varchar(45) DEFAULT NULL,
  `diseno` varchar(45) DEFAULT NULL,
  `min_cil` varchar(15) DEFAULT NULL,
  `max_cil` varchar(15) DEFAULT NULL,
  `min_esf` varchar(15) DEFAULT NULL,
  `max_esf` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombres` varchar(250) DEFAULT NULL,
  `telefono` varchar(40) DEFAULT NULL,
  `correo` varchar(250) DEFAULT NULL,
  `dui` varchar(50) DEFAULT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `categoria` varchar(10) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL,
  `codigo_emp` varchar(40) DEFAULT NULL,
  `sucursal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombres`, `telefono`, `correo`, `dui`, `direccion`, `usuario`, `pass`, `categoria`, `estado`, `codigo_emp`, `sucursal`) VALUES
(1, 'Oscar Antonio Gonzalez', '0000000', '----', '-------', 'ss', 'oscar', 'oscar1411', 'Admin', '1', 'LT-12021', 'Metrocentro'),
(2, 'Universidad de El Salvador', '00000', '0', '0', '0', 'ues', 'ues2021', 'a', '1', 'LT-12021', ''),
(3, 'Andres Vasquez', '-', '-', '-------', '-', 'andvas', 'and20vas08', '1', '1', 'LT-12021', ''),
(4, 'Boni', '000', '-', '-', '-', 'boni', 'optokr21', '3', '1', '0', ''),
(5, 'Alex Carranza', '00000000', '-------', '---------', '---', 'alex', 'spike86', 'a', '1', 'LT-12021', ''),
(6, 'Patty Ayala', '00000', '0000', '852552222', '74222225', 'patty', 'tauro8287', 'a', '1', 'LT-12021', ''),
(7, 'Josue', '00000', '-', '-', '-', 'josue', 'j12visual', 'a', '1', 'LT-12021', ''),
(8, 'Adriana Costanza', '--', '--', '--', '--', 'adriana', 'visualopto12', 'a', '1', 'LT-12021', ''),
(9, 'Saida Portillo', '--', '---', '---', '---', 'saida', 'protesis15', '3', '1', 'LT-12021', ''),
(10, 'OSMEL CARLOS', '-', '-', '-', '-', 'osmel', 'lente14', 'a', '1', '-', ''),
(11, 'ROSIBEL LOPEZ', '-', '-', '-', '-', 'rosibel', 'lenso34', 'a', '1', '-', ''),
(12, 'Andrea Vasquez', '00000', '-', '-------', '---', 'andrea', 'panconpollo', '1', '1', 'LT-12021', ''),
(13, 'Andrea', '00000000', '---', '-----', 'ss', 'andrea', 'lenti12', 'a', '1', 'LT-12021', ''),
(14, 'CAROL MAITEH SALAZAR DE PEREZ', '7396-3059', '-', '-', '-', 'maiteh', 'cama', 'a', '1', '-', ''),
(15, 'Ruben Castro', '---', '--', '--', 'SS', 'ruben', 'optometra1', '3', '1', '-', ''),
(16, 'Yaneth Cruz', '00000000', '--', '-', 'ss', 'yanet', 'visual47', 'a', '1', '-', ''),
(17, 'Guadalupe Guandique', '---', '---', '000', '---', 'guandique', 'opto.1', '3', '1', '-', ''),
(18, 'Georgina', '0000', '000', '000', '000', 'georgina', 'avplus2022', 'a', '1', '0', ''),
(19, 'Fabiola', '000', '000', '0000', '000', 'fabiola', 'avplus2022', 'a', '1', '0', ''),
(20, 'Liliana de Alvarenga', '0000', '---', '-', '-', 'liliana', '061417', '1', '1', '003', ''),
(21, 'SUCURSAL METROCENTRO', '00000', '---', '---', 'METROCENTRO', 'metrocentro', 'metrocentro', 'suc', '1', '---', 'Metrocentro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `id_usuario_permiso` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_permiso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`id_usuario_permiso`, `id_usuario`, `id_permiso`) VALUES
(3, 1, 4),
(4, 1, 5),
(5, 21, 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones_orden`
--
ALTER TABLE `acciones_orden`
  ADD PRIMARY KEY (`id_accion`);

--
-- Indices de la tabla `acciones_ordenes_veteranos`
--
ALTER TABLE `acciones_ordenes_veteranos`
  ADD PRIMARY KEY (`id_orden_rec`),
  ADD UNIQUE KEY `correlativo_accion` (`correlativo_accion`);

--
-- Indices de la tabla `aros`
--
ALTER TABLE `aros`
  ADD PRIMARY KEY (`id_aro`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`);

--
-- Indices de la tabla `detalle_acciones_veteranos`
--
ALTER TABLE `detalle_acciones_veteranos`
  ADD PRIMARY KEY (`id_detalle_accion`);

--
-- Indices de la tabla `detalle_ingreso_aros`
--
ALTER TABLE `detalle_ingreso_aros`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD KEY `id_aro` (`id_aro`);

--
-- Indices de la tabla `detalle_orden_rectificicacion`
--
ALTER TABLE `detalle_orden_rectificicacion`
  ADD PRIMARY KEY (`id_det_recti`);

--
-- Indices de la tabla `ingreso_aros`
--
ALTER TABLE `ingreso_aros`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `movimientos_bodega`
--
ALTER TABLE `movimientos_bodega`
  ADD PRIMARY KEY (`id_movimiento`);

--
-- Indices de la tabla `orden_lab`
--
ALTER TABLE `orden_lab`
  ADD PRIMARY KEY (`id_orden`),
  ADD UNIQUE KEY `dui` (`dui`),
  ADD UNIQUE KEY `codigo_UNIQUE` (`codigo`),
  ADD KEY `id_aro` (`id_aro`),
  ADD KEY `id_cita` (`id_cita`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `permisos_usuario`
--
ALTER TABLE `permisos_usuario`
  ADD PRIMARY KEY (`id_usuario_permiso`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- Indices de la tabla `rectificacion`
--
ALTER TABLE `rectificacion`
  ADD PRIMARY KEY (`id_rectifi`),
  ADD UNIQUE KEY `codigo_rectifi` (`codigo_rectifi`);

--
-- Indices de la tabla `rx_det_orden_recti`
--
ALTER TABLE `rx_det_orden_recti`
  ADD PRIMARY KEY (`id_rx_det_orden_recti`);

--
-- Indices de la tabla `rx_orden_lab`
--
ALTER TABLE `rx_orden_lab`
  ADD PRIMARY KEY (`id_rx`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `stock_aros`
--
ALTER TABLE `stock_aros`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD KEY `id_aro` (`id_aro`);

--
-- Indices de la tabla `stock_terminados`
--
ALTER TABLE `stock_terminados`
  ADD UNIQUE KEY `codigo_UNIQUE` (`codigo`),
  ADD KEY `id_tabla_term` (`id_tabla_term`);

--
-- Indices de la tabla `tablas_terminado`
--
ALTER TABLE `tablas_terminado`
  ADD PRIMARY KEY (`id_tabla_term`),
  ADD UNIQUE KEY `titulo_UNIQUE` (`titulo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`id_usuario_permiso`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acciones_orden`
--
ALTER TABLE `acciones_orden`
  MODIFY `id_accion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `acciones_ordenes_veteranos`
--
ALTER TABLE `acciones_ordenes_veteranos`
  MODIFY `id_orden_rec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `aros`
--
ALTER TABLE `aros`
  MODIFY `id_aro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `detalle_acciones_veteranos`
--
ALTER TABLE `detalle_acciones_veteranos`
  MODIFY `id_detalle_accion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_ingreso_aros`
--
ALTER TABLE `detalle_ingreso_aros`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `detalle_orden_rectificicacion`
--
ALTER TABLE `detalle_orden_rectificicacion`
  MODIFY `id_det_recti` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingreso_aros`
--
ALTER TABLE `ingreso_aros`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `movimientos_bodega`
--
ALTER TABLE `movimientos_bodega`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_lab`
--
ALTER TABLE `orden_lab`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `permisos_usuario`
--
ALTER TABLE `permisos_usuario`
  MODIFY `id_usuario_permiso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rectificacion`
--
ALTER TABLE `rectificacion`
  MODIFY `id_rectifi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rx_det_orden_recti`
--
ALTER TABLE `rx_det_orden_recti`
  MODIFY `id_rx_det_orden_recti` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rx_orden_lab`
--
ALTER TABLE `rx_orden_lab`
  MODIFY `id_rx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `stock_aros`
--
ALTER TABLE `stock_aros`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `tablas_terminado`
--
ALTER TABLE `tablas_terminado`
  MODIFY `id_tabla_term` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `id_usuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ingreso_aros`
--
ALTER TABLE `detalle_ingreso_aros`
  ADD CONSTRAINT `detalle_ingreso_aros_ibfk_1` FOREIGN KEY (`id_aro`) REFERENCES `aros` (`id_aro`);

--
-- Filtros para la tabla `ingreso_aros`
--
ALTER TABLE `ingreso_aros`
  ADD CONSTRAINT `ingreso_aros_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `orden_lab`
--
ALTER TABLE `orden_lab`
  ADD CONSTRAINT `orden_lab_ibfk_1` FOREIGN KEY (`id_aro`) REFERENCES `aros` (`id_aro`),
  ADD CONSTRAINT `orden_lab_ibfk_2` FOREIGN KEY (`id_cita`) REFERENCES `citas` (`id_cita`);

--
-- Filtros para la tabla `permisos_usuario`
--
ALTER TABLE `permisos_usuario`
  ADD CONSTRAINT `permisos_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `permisos_usuario_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`);

--
-- Filtros para la tabla `stock_aros`
--
ALTER TABLE `stock_aros`
  ADD CONSTRAINT `stock_aros_ibfk_1` FOREIGN KEY (`id_aro`) REFERENCES `aros` (`id_aro`);

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `usuario_permiso_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `usuario_permiso_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
