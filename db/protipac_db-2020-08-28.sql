-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-08-2020 a las 22:31:23
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `protipac_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asset`
--

CREATE TABLE `asset` (
  `ast_id` bigint(11) NOT NULL,
  `ast_type` int(11) NOT NULL DEFAULT 0,
  `ast_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ast_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ast_creator_usr_id` bigint(11) DEFAULT NULL,
  `ast_dateCreated` date NOT NULL DEFAULT '1900-01-01',
  `ast_timeCreated` time NOT NULL DEFAULT '00:00:00',
  `ast_dateModified` date DEFAULT NULL,
  `ast_timeModified` time DEFAULT NULL,
  `ast_status` int(11) DEFAULT NULL,
  `ast_usr_id_modified` bigint(11) DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ast_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `asset`
--

INSERT INTO `asset` (`ast_id`, `ast_type`, `ast_title`, `ast_description`, `ast_creator_usr_id`, `ast_dateCreated`, `ast_timeCreated`, `ast_dateModified`, `ast_timeModified`, `ast_status`, `ast_usr_id_modified`, `ip`, `ast_address`) VALUES
(1, 1, NULL, NULL, 1, '2016-06-03', '15:17:00', '2016-06-03', '15:17:00', 1, 1, NULL, NULL),
(19, 2, '', '', 1, '2020-07-31', '11:58:11', '2020-07-31', '11:58:11', 1, NULL, '::1', NULL),
(20, 2, '', '', 1, '2020-07-31', '11:59:01', '2020-07-31', '11:59:01', 1, NULL, '::1', NULL),
(21, 2, '', '', 1, '2020-07-31', '11:59:12', '2020-07-31', '11:59:12', 1, NULL, '::1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assetcomment`
--

CREATE TABLE `assetcomment` (
  `com_id` bigint(11) NOT NULL,
  `com_ast_id` bigint(11) NOT NULL DEFAULT 0,
  `com_tic_id` int(11) DEFAULT NULL,
  `com_usr_id` bigint(11) DEFAULT NULL,
  `com_lang_id` int(11) DEFAULT NULL,
  `com_name_anonymous` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_email_anonymous` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_dateCreated` int(11) NOT NULL DEFAULT 0,
  `com_timeCreated` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `com_dateModified` int(11) NOT NULL DEFAULT 0,
  `com_timeModified` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `com_status` int(11) DEFAULT NULL,
  `com_usr_id_modified` int(11) DEFAULT NULL,
  `ip` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `com_title` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assettype`
--

CREATE TABLE `assettype` (
  `aty_id` int(11) NOT NULL,
  `aty_descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `assettype`
--

INSERT INTO `assettype` (`aty_id`, `aty_descripcion`) VALUES
(1, 'Usuario'),
(2, 'Protocolo'),
(9, 'Entidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_visita`
--

CREATE TABLE `categoria_visita` (
  `cat_id` int(11) NOT NULL,
  `cat_descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria_visita`
--

INSERT INTO `categoria_visita` (`cat_id`, `cat_descripcion`) VALUES
(1, 'Control'),
(2, 'Espontánea');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cronograma_visita`
--

CREATE TABLE `cronograma_visita` (
  `cron_id` bigint(20) NOT NULL,
  `cron_pro_id` bigint(20) NOT NULL COMMENT 'Id del protocolo',
  `cron_crvn_id` int(11) DEFAULT NULL,
  `cron_descripcion` varchar(255) DEFAULT NULL COMMENT 'Cronograma visita nombre',
  `cron_ventana_max` int(11) DEFAULT NULL,
  `cron_ventana_min` int(11) DEFAULT NULL,
  `cron_observaciones` text DEFAULT NULL,
  `cron_dias_basal` int(11) DEFAULT NULL,
  `cron_laboratorio` tinyint(4) DEFAULT NULL,
  `cron_tiv_id` int(11) DEFAULT NULL COMMENT 'Tipo visita (screening, basal, etc)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cronograma_visita`
--

INSERT INTO `cronograma_visita` (`cron_id`, `cron_pro_id`, `cron_crvn_id`, `cron_descripcion`, `cron_ventana_max`, `cron_ventana_min`, `cron_observaciones`, `cron_dias_basal`, `cron_laboratorio`, `cron_tiv_id`) VALUES
(6, 23, 1, NULL, 5, 5, 'fgdfg', -42, 1, 1),
(7, 23, 2, NULL, 5, 5, 'dsgdfg', 0, 1, 2),
(8, 24, 1, NULL, 5, 5, '', -40, 1, 1),
(9, 24, 2, NULL, 3, 3, '', 0, 0, 2),
(10, 24, 9, NULL, 5, 5, 'semana 1 obs', 7, 0, 3),
(11, 24, 10, NULL, 5, 5, '', 14, 0, 3),
(12, 23, 9, NULL, 2, 2, '', 7, 0, 3),
(13, 23, 10, NULL, 5, 5, '', 14, 1, 3),
(14, 25, 1, NULL, 2, 2, 'dfggf', 7, 0, 1),
(15, 25, 2, NULL, 4, 4, '', 0, 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cronograma_visita_nombre`
--

CREATE TABLE `cronograma_visita_nombre` (
  `crvn_id` int(11) NOT NULL,
  `crvn_descripcion` varchar(50) NOT NULL,
  `crvn_orden` int(11) NOT NULL,
  `crvn_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cronograma_visita_nombre`
--

INSERT INTO `cronograma_visita_nombre` (`crvn_id`, `crvn_descripcion`, `crvn_orden`, `crvn_status`) VALUES
(-1, 'Otro', 999999, 1),
(1, 'Screening', 1, 1),
(2, 'Basal', 2, 1),
(3, 'Día 1', 3, 1),
(4, 'Día 2', 4, 1),
(5, 'Día 3', 5, 1),
(6, 'Día 4', 6, 1),
(7, 'Día 5', 7, 1),
(8, 'Día 6', 8, 1),
(9, 'Semana 1', 9, 1),
(10, 'Semana 2', 10, 1),
(11, 'Semana 3', 11, 1),
(12, 'Semana 4', 12, 1),
(13, 'Semana 5', 13, 1),
(14, 'Semana 6', 14, 1),
(15, 'Semana 7', 15, 1),
(16, 'Semana 8', 16, 1),
(17, 'Semana 9', 17, 1),
(18, 'Semana 10', 18, 1),
(19, 'Semana 11', 19, 1),
(20, 'Semana 12', 20, 1),
(21, 'Semana 13', 21, 1),
(22, 'Semana 14', 22, 1),
(23, 'Semana 15', 23, 1),
(24, 'Semana 16', 24, 1),
(25, 'Semana 17', 25, 1),
(26, 'Semana 18', 26, 1),
(27, 'Semana 19', 27, 1),
(28, 'Semana 20', 28, 1),
(29, 'Semana 21', 29, 1),
(30, 'Semana 22', 30, 1),
(31, 'Semana 23', 31, 1),
(32, 'Semana 24', 32, 1),
(33, 'Semana 25', 33, 1),
(34, 'Semana 26', 34, 1),
(35, 'Semana 27', 35, 1),
(36, 'Semana 28', 36, 1),
(37, 'Semana 29', 37, 1),
(38, 'Semana 30', 38, 1),
(39, 'Semana 31', 39, 1),
(40, 'Semana 32', 40, 1),
(41, 'Semana 33', 41, 1),
(42, 'Semana 34', 42, 1),
(43, 'Semana 35', 43, 1),
(44, 'Semana 36', 44, 1),
(45, 'Semana 37', 45, 1),
(46, 'Semana 38', 46, 1),
(47, 'Semana 39', 47, 1),
(48, 'Semana 40', 48, 1),
(49, 'Semana 41', 49, 1),
(50, 'Semana 42', 50, 1),
(51, 'Semana 43', 51, 1),
(52, 'Semana 44', 52, 1),
(53, 'Semana 45', 53, 1),
(54, 'Semana 46', 54, 1),
(55, 'Semana 47', 55, 1),
(56, 'Semana 48', 56, 1),
(57, 'Follow-up', 57, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `efector`
--

CREATE TABLE `efector` (
  `efe_id` int(11) NOT NULL,
  `efe_nombre` varchar(255) NOT NULL,
  `efe_nombre_corto` varchar(25) NOT NULL,
  `efe_nombre_combo` varchar(45) NOT NULL,
  `efe_nivel_id` int(11) NOT NULL,
  `efe_orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `efector`
--

INSERT INTO `efector` (`efe_id`, `efe_nombre`, `efe_nombre_corto`, `efe_nombre_combo`, `efe_nivel_id`, `efe_orden`) VALUES
(1, 'Hospital Mi Pueblo', 'Mi Pueblo', 'Mi Pueblo', 4, 2),
(2, 'Hospital El Cruce', 'El Cruce', 'El Cruce', 5, 2),
(3, 'UPA', 'UPA', 'UPA', 3, 2),
(4, '20 de Junio', '20 de Junio', '20 de Junio', 2, 2),
(5, 'Villa Hudson', 'Villa Hudson', 'Villa Hudson', 2, 2),
(6, 'El Parque', 'El Parque', 'El Parque', 2, 2),
(7, 'La Esmeralda', 'La Esmeralda', 'La Esmeralda', 2, 2),
(8, 'Padre Gino', 'Padre Gino', 'Padre Gino', 2, 2),
(9, 'Villa Mónica', 'Villa Mónica', 'Villa Mónica', 2, 2),
(10, 'Padre Mugica', 'Padre Mugica', 'Padre Mugica', 2, 2),
(11, 'CIC San Francisco', 'CIC San Francisco', 'CIC San Francisco', 2, 2),
(12, 'Ingeniero Allan', 'Ingeniero Allan', 'Ingeniero Allan', 2, 2),
(13, 'CIC Don José', 'CIC Don José', 'CIC Don José', 2, 2),
(14, 'SAME', 'SAME', 'Consulta Domicilio / Vía pública', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `emp_id` bigint(20) NOT NULL,
  `emp_cuit` varchar(11) DEFAULT NULL,
  `emp_razon_social` varchar(255) DEFAULT NULL,
  `emp_email` varchar(255) DEFAULT NULL,
  `emp_ent_id` bigint(20) DEFAULT NULL,
  `emp_persona_contacto_nombre` varchar(255) DEFAULT NULL,
  `emp_persona_contacto_apellido` varchar(255) DEFAULT NULL,
  `emp_persona_contacto_email` varchar(255) DEFAULT NULL,
  `emp_persona_contacto_telefono` varchar(45) DEFAULT NULL,
  `emp_persona_contacto_cargo` varchar(255) NOT NULL,
  `emp_captura_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`emp_id`, `emp_cuit`, `emp_razon_social`, `emp_email`, `emp_ent_id`, `emp_persona_contacto_nombre`, `emp_persona_contacto_apellido`, `emp_persona_contacto_email`, `emp_persona_contacto_telefono`, `emp_persona_contacto_cargo`, `emp_captura_status`) VALUES
(17, NULL, 'fdsdf', NULL, NULL, NULL, NULL, NULL, NULL, '', 3),
(30, NULL, 'sdfdsfsd', NULL, NULL, NULL, NULL, NULL, NULL, '', 3),
(31, NULL, 'aaaaaaaaaaaaaa', NULL, NULL, NULL, NULL, NULL, NULL, '', 3),
(32, NULL, 'bbbbbbbbbbbbbbb', NULL, NULL, NULL, NULL, NULL, NULL, '', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

CREATE TABLE `entidad` (
  `ent_id` bigint(20) NOT NULL,
  `ent_ast_id` bigint(20) DEFAULT NULL,
  `ent_tie_id` int(11) NOT NULL,
  `ent_domicilio_calle` varchar(255) DEFAULT NULL,
  `ent_domicilio_numero` int(11) DEFAULT NULL,
  `ent_domicilio_piso` varchar(255) DEFAULT NULL,
  `ent_domicilio_depto` varchar(255) DEFAULT NULL,
  `ent_domicilio_otros_datos` varchar(255) DEFAULT NULL,
  `ent_domicilio_cod_pos` varchar(45) DEFAULT NULL,
  `ent_domicilio_id_provincia` int(11) DEFAULT NULL,
  `ent_domicilio_id_localidad` int(11) DEFAULT NULL,
  `ent_domicilio_id_partido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fase_investigacion`
--

CREATE TABLE `fase_investigacion` (
  `fase_id` int(11) NOT NULL,
  `fase_descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='FASE I / II / III / IV (para los casos que sea una investigaci?n experimental con drogas o dispositivos)';

--
-- Volcado de datos para la tabla `fase_investigacion`
--

INSERT INTO `fase_investigacion` (`fase_id`, `fase_descripcion`) VALUES
(1, 'FASE I'),
(2, 'FASE II'),
(3, 'FASE III'),
(4, 'FASE IV');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `function`
--

CREATE TABLE `function` (
  `fnc_id` int(10) NOT NULL,
  `fnc_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fnc_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fnc_type` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `function`
--

INSERT INTO `function` (`fnc_id`, `fnc_name`, `fnc_code`, `fnc_type`) VALUES
(1, 'Ingreso al Sistema', 'HOMEVIEW', 1),
(2, 'Login Administraci&oacute;n', 'LOGINADMIN', 1),
(3, 'Listar Pacientes', 'LISTPACIENTES', 1),
(4, 'Listar Protocolos', 'LISTPROTOCOLOS', 2),
(5, 'Cargar Pacientes', 'CARGARPACIENTES', 2),
(6, 'Enrolar Pacientes', 'ENROLARPACIENTES', 2),
(7, 'Cargar Protocolos', 'CARGARPROTOCOLOS', 1),
(8, 'Registrar visitas', 'REGISTRARVISITAS', 1),
(14, 'Login Publico', 'LOGINPUBLICO', 1),
(42, 'Modificar Usuario Propio', 'MODIFICARUSUARIOPROPIO', 1),
(44, 'Administrar usuarios', 'ADMINISTRARUSUARIOS', 1),
(45, 'Borrar protocolos', 'ELIMINARPROTOCOLOS', 1),
(46, 'Cargar cronograma protocolos', 'CARGARCRONOGRAMA', 1),
(47, 'Ver visitas cronograma protocolo', 'VERVISITASCRONOGRAMA', 1),
(48, 'Eliminar cronograma protocolos', 'ELIMINARCRONOGRAMA', 1),
(49, 'Cargar Visitas Pacientes', 'CARGARVISITASPACIENTES', 1),
(50, 'Ver visitas pacientes', 'VERVISITASPACIENTES', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `gen_id` int(11) NOT NULL,
  `gen_descripcion` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`gen_id`, `gen_descripcion`) VALUES
(1, 'F'),
(2, 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospital_referente`
--

CREATE TABLE `hospital_referente` (
  `reh_id` bigint(20) NOT NULL,
  `reh_descripcion` varchar(255) DEFAULT NULL,
  `reh_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `hospital_referente`
--

INSERT INTO `hospital_referente` (`reh_id`, `reh_descripcion`, `reh_status`) VALUES
(1, 'sfadsf', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `investigador`
--

CREATE TABLE `investigador` (
  `inv_id` bigint(20) NOT NULL,
  `inv_nombre` varchar(255) DEFAULT NULL,
  `inv_apellido` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `investigador`
--

INSERT INTO `investigador` (`inv_id`, `inv_nombre`, `inv_apellido`) VALUES
(1, 'Pedro Enrique', 'Cahn'),
(2, 'Omar Gustavo', 'Sued'),
(3, 'Patricia Luz', 'Patterson'),
(4, 'Carina Teresa', 'Cesar'),
(5, 'Valeria Irene', 'Fink'),
(6, 'María Inés', 'Figueroa'),
(7, 'Claudia Elizabeth', 'Frola'),
(8, 'Tatiana Belén', 'Estrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `investigador_tipo`
--

CREATE TABLE `investigador_tipo` (
  `invtipo_tinv_id` int(11) NOT NULL,
  `invtipo_inv_id` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `investigador_tipo`
--

INSERT INTO `investigador_tipo` (`invtipo_tinv_id`, `invtipo_inv_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `link`
--

CREATE TABLE `link` (
  `lnk_id` bigint(11) NOT NULL,
  `lnk_ast_id` bigint(11) NOT NULL DEFAULT 0,
  `lnk_tadj_id` bigint(20) NOT NULL,
  `lnk_fecha_hora_creacion` datetime NOT NULL,
  `lnk_file_full_size` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `lnk_file_thumb_size` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `lnk_address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `lnk_type` int(11) NOT NULL DEFAULT 0,
  `lnk_ext` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `lnk_caption` text COLLATE utf8_unicode_ci NOT NULL,
  `lnk_status` int(11) NOT NULL DEFAULT 0,
  `lnk_usr_id_creacion` bigint(11) DEFAULT NULL,
  `lnk_fecha_hora_modificado` datetime DEFAULT NULL,
  `lnk_usr_id_modified` bigint(11) DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `id_localidad` int(11) NOT NULL,
  `id_partido` int(11) NOT NULL,
  `nombre_localidad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`id_localidad`, `id_partido`, `nombre_localidad`) VALUES
(1, 1, ''),
(2, 1, 'ALMAGRO'),
(3, 1, 'BALVANERA'),
(4, 1, 'BARRACAS'),
(5, 1, 'BELGRANO'),
(6, 1, 'BOEDO'),
(7, 1, 'CABALLITO'),
(8, 1, 'CHACARITA'),
(9, 1, 'COGHLAN'),
(10, 1, 'COLEGIALES'),
(11, 1, 'CONSTITUCIÓN'),
(12, 1, 'FLORES'),
(13, 1, 'FLORESTA'),
(14, 1, 'LA BOCA'),
(15, 1, 'LA PATERNAL'),
(16, 1, 'LINIERS'),
(17, 1, 'MATADEROS'),
(18, 1, 'MONTE CASTRO'),
(19, 1, 'MONTSERRAT'),
(20, 1, 'NUEVA POMPEYA'),
(21, 1, 'NÚÑEZ'),
(22, 1, 'PALERMO'),
(23, 1, 'PARQUE AVELLANEDA'),
(24, 1, 'PARQUE CHACABUCO'),
(25, 1, 'PARQUE CHAS'),
(26, 1, 'PARQUE PATRICIOS'),
(27, 1, 'PUERTO MADERO'),
(28, 1, 'RECOLETA'),
(29, 1, 'RETIRO'),
(30, 1, 'SAAVEDRA'),
(31, 1, 'SAN CRISTÓBAL'),
(32, 1, 'SAN NICOLÁS'),
(33, 1, 'SAN TELMO'),
(34, 1, 'VÉLEZ SARSFIELD'),
(35, 1, 'VERSALLES'),
(36, 1, 'VILLA CRESPO'),
(37, 1, 'VILLA DEL PARQUE'),
(38, 1, 'VILLA DEVOTO'),
(39, 1, 'VILLA GENERAL MITRE'),
(40, 1, 'VILLA LUGANO'),
(41, 1, 'VILLA LURO'),
(42, 1, 'VILLA ORTÚZAR'),
(43, 1, 'VILLA PUEYRREDÓN'),
(44, 1, 'VILLA REAL'),
(45, 1, 'VILLA RIACHUELO'),
(46, 1, 'VILLA SANTA RITA'),
(47, 1, 'VILLA SOLDATI'),
(48, 1, 'VILLA URQUIZA'),
(49, 2, 'AGUSTIN A.GASCON'),
(50, 2, 'CARHUE'),
(51, 2, 'DELFÍN HUERGO'),
(52, 2, 'ESPARTILLAR (PARTE) (1)'),
(53, 2, 'LA PALA'),
(54, 2, 'RIVERA'),
(55, 2, 'SAN MIGUEL ARCÁNGEL'),
(56, 2, 'VILLA MARGARITA'),
(57, 2, 'VILLA MAZA'),
(58, 2, 'ZONA RURAL'),
(59, 3, 'ADOLFO GONZÁLES CHAVES'),
(60, 3, 'DE LA GARMA'),
(61, 3, 'JUAN EULOGIO BARRA'),
(62, 3, 'VASQUEZ'),
(63, 3, 'ZONA RURAL'),
(64, 4, 'ALBERTI'),
(65, 4, 'MECHITA (PARTE) (5)'),
(66, 4, 'PLA'),
(67, 4, 'VILLA GRISOLIA'),
(68, 4, 'VILLA ORTIZ (EST.CNL.MOM)'),
(69, 4, 'ZONA RURAL'),
(70, 5, 'ADROGUE'),
(71, 5, 'BARRIO DON ORIONE'),
(72, 5, 'BARRIO PARQUE ROMA'),
(73, 5, 'BARRIO SAN JOSE'),
(74, 5, 'BURZACO'),
(75, 5, 'CHACRAS DE SAN FRANCISCO'),
(76, 5, 'CLAYPOLE'),
(77, 5, 'GLEW'),
(78, 5, 'JOSE MARMOL'),
(79, 5, 'LONGCHAMPS'),
(80, 5, 'MARTIN ARIN'),
(81, 5, 'MTRO. RIVADAVIA'),
(82, 5, 'RAFAEL CALZADA'),
(83, 5, 'SAN FRANCISCO SOLANO'),
(84, 5, 'TABLADA VIEJA'),
(85, 5, 'VILLA CORIMAYO'),
(86, 5, 'ZONA RURAL'),
(87, 6, 'ARRECIFES'),
(88, 6, 'TODD'),
(89, 6, 'VIÑA'),
(90, 6, 'ZONA RURAL'),
(91, 7, 'AVELLANEDA'),
(92, 7, 'BULLRICH'),
(93, 7, 'CINTURON ECOLOGICO'),
(94, 7, 'CRUCECITA'),
(95, 7, 'DOCK SUD'),
(96, 7, 'EL PORVENIR'),
(97, 7, 'ENTRE VIAS'),
(98, 7, 'GERLI (PARTE) (2)'),
(99, 7, 'ISLA MACIEL'),
(100, 7, 'PIÑEYRO'),
(101, 7, 'SARANDI'),
(102, 7, 'VILLA ARGENTINA'),
(103, 7, 'VILLA BERNASCONI'),
(104, 7, 'VILLA CORINA'),
(105, 7, 'VILLA DOMINICO'),
(106, 7, 'VILLA GONNET'),
(107, 7, 'VILLA MODELO'),
(108, 7, 'VILLA PARÍS'),
(109, 7, 'VILLA PERGAMINO'),
(110, 7, 'WILDE'),
(111, 8, 'AYACUCHO'),
(112, 8, 'ZONA RURAL'),
(113, 9, 'ARIEL'),
(114, 9, 'AZUL'),
(115, 9, 'CACHARI'),
(116, 9, 'CHILLAR'),
(117, 9, 'DIECISEIS DE JULIO'),
(118, 9, 'ZONA RURAL'),
(119, 10, 'BAHIA BLANCA'),
(120, 10, 'CABILDO'),
(121, 10, 'GENERAL DANIEL CERRI'),
(122, 10, 'GRUNBEIN'),
(123, 10, 'INGENIERO WHITE'),
(124, 10, 'VILLA BORDEU'),
(125, 10, 'VILLA ESPERANZA'),
(126, 10, 'VILLA HARDING GREEN'),
(127, 10, 'VILLA STELLA MARIS'),
(128, 10, 'ZONA RURAL'),
(129, 11, 'BALCARCE'),
(130, 11, 'LOS PINOS'),
(131, 11, 'NAPALEOFU'),
(132, 11, 'RAMOS OTERO'),
(133, 11, 'SAN AGUSTIN'),
(134, 11, 'VILLA LAGUNA LA BRAVA'),
(135, 11, 'ZONA RURAL'),
(136, 12, 'BARADERO'),
(137, 12, 'COLONIA SUIZA'),
(138, 12, 'IRINEO PORTELA'),
(139, 12, 'ISLAS'),
(140, 12, 'SANTA COLOMA'),
(141, 12, 'VILLA ALSINA'),
(142, 12, 'ZONA RURAL'),
(143, 13, 'BARKER'),
(144, 13, 'BENITO JUAREZ'),
(145, 13, 'ESTACION LOPEZ'),
(146, 13, 'TEDIN URIBURU'),
(147, 13, 'VILLA CACIQUE'),
(148, 13, 'ZONA RURAL'),
(149, 14, 'BERAZATEGUI'),
(150, 14, 'C. A. EL PATO'),
(151, 14, 'CARLOS T. SOURIGUES'),
(152, 14, 'GUILLERMO E. HUDSON'),
(153, 14, 'JOSE M. GUTIERREZ'),
(154, 14, 'PEREYRA'),
(155, 14, 'PLATANOS'),
(156, 14, 'RANELAGH'),
(157, 14, 'VILLA ESPAÑA'),
(158, 14, 'ZONA RURAL'),
(159, 15, 'BARRIO BANCO PROVINCIA'),
(160, 15, 'BARRIO EL CARMEN'),
(161, 15, 'BARRIO UNIVERSITARIO'),
(162, 15, 'BERISSO'),
(163, 15, 'DOLORES'),
(164, 15, 'PALO BLANCO'),
(165, 15, 'PASAJE LOS TALAS'),
(166, 15, 'VILLA ARGÜELLO'),
(167, 15, 'VILLA INDEPENDENCIA'),
(168, 15, 'VILLA NUEVA'),
(169, 15, 'VILLA PORTEÑA'),
(170, 15, 'VILLA PROGRESO'),
(171, 15, 'VILLA SAN CARLOS'),
(172, 15, 'VILLA ZULA'),
(173, 15, 'ZONA RURAL'),
(174, 16, 'HALE'),
(175, 16, 'PIROVANO'),
(176, 16, 'SAN CARLOS DE BOLIVAR'),
(177, 16, 'URDAMPILLETA'),
(178, 16, 'ZONA RURAL'),
(179, 17, 'BRAGADO'),
(180, 17, 'COMODORO PY'),
(181, 17, 'GENERAL O\'BRIEN'),
(182, 17, 'IRALA'),
(183, 17, 'J. F. SALABERRY'),
(184, 17, 'LA LIMPIA'),
(185, 17, 'MECHITA (PARTE) (5)'),
(186, 17, 'OLASCOAGA'),
(187, 17, 'WARNES'),
(188, 17, 'ZONA RURAL'),
(189, 18, 'BARRIO LA JOSEFA'),
(190, 18, 'BARRIO LAS CAMPANAS'),
(191, 18, 'BARRIO LAS PRADERAS'),
(192, 18, 'BARRIO LOS CEDROS'),
(193, 18, 'BARRIO SAN CAYETANO'),
(194, 18, 'CAMPANA'),
(195, 18, 'ISLAS'),
(196, 18, 'LOS CARDALES (PARTE) (4)'),
(197, 18, 'OTAMENDI'),
(198, 18, 'RIO LUJAN'),
(199, 18, 'ZONA RURAL'),
(200, 19, 'ALEJANDRO PETION'),
(201, 19, 'BARRIO BELGRANO'),
(202, 19, 'BARRIO EL TALADRO'),
(203, 19, 'BARRIO GOBERNADOR UDAONDO'),
(204, 19, 'BARRIO LA TORRE'),
(205, 19, 'BARRIO PELUFFO'),
(206, 19, 'BARRIO SAN ESTEBAN'),
(207, 19, 'BARRIO SANTA ANITA'),
(208, 19, 'BARRIO SANTA ROSA'),
(209, 19, 'BARRIO VILLA ADRIANA'),
(210, 19, 'CAÑUELAS'),
(211, 19, 'LOS POZOS'),
(212, 19, 'MAXIMO PAZ'),
(213, 19, 'URIBELARREA'),
(214, 19, 'VICENTE CASARES'),
(215, 19, 'ZONA RURAL'),
(216, 20, 'CAPITAN SARMIENTO'),
(217, 20, 'LA LUISA'),
(218, 20, 'PARADA BELLA VISTA'),
(219, 20, 'ZONA RURAL'),
(220, 21, 'BELLOCQ'),
(221, 21, 'CADRET'),
(222, 21, 'CARLOS CASARES'),
(223, 21, 'HORTENSIA'),
(224, 21, 'LA SOFIA'),
(225, 21, 'MAURICIO HIRSCH'),
(226, 21, 'MOCTEZUMA'),
(227, 21, 'ORDOQUI'),
(228, 21, 'SMITH'),
(229, 21, 'ZONA RURAL'),
(230, 22, 'CARLOS TEJEDOR'),
(231, 22, 'COLONIA SERE'),
(232, 22, 'CURARU'),
(233, 22, 'TIMOTE'),
(234, 22, 'TRES ALGARROBOS'),
(235, 22, 'ZONA RURAL'),
(236, 23, 'CARMEN DE ARECO'),
(237, 23, 'GOUIN'),
(238, 23, 'TRES SARGENTOS'),
(239, 24, 'CASTELLI'),
(240, 24, 'CENTRO GUERRERO'),
(241, 24, 'ZONA RURAL'),
(242, 25, 'CHACABUCO'),
(243, 25, 'MC.G.KEATING'),
(244, 25, 'O\'HIGGINS'),
(245, 25, 'RAWSON'),
(246, 25, 'ZONA RURAL'),
(247, 26, 'CHASCOMUS'),
(248, 26, 'MANUEL J.C0BO'),
(249, 26, 'ZONA RURAL'),
(250, 27, 'CHIVILCOY'),
(251, 27, 'EMILIO AYARZA'),
(252, 27, 'GOROSTIAGA'),
(253, 27, 'LA RICA'),
(254, 27, 'MOQUEHUA'),
(255, 27, 'RAMON BIAUS'),
(256, 27, 'SAN SEBASTIAN'),
(257, 27, 'ZONA RURAL'),
(258, 28, 'COLON'),
(259, 28, 'PEARSON'),
(260, 28, 'VILLA M. POMAR'),
(261, 28, 'ZONA RURAL'),
(262, 29, 'ALTAMIRANO'),
(263, 29, 'BRANDSEN'),
(264, 29, 'GÓMEZ'),
(265, 29, 'JEPPENER'),
(266, 29, 'OLIDEN'),
(267, 29, 'ZONA RURAL'),
(268, 30, 'BAJO HONDO'),
(269, 30, 'BALNEARIO PEHUENCO'),
(270, 30, 'PUNTA ALTA'),
(271, 30, 'VILLA DEL MAR'),
(272, 30, 'VILLA GENERAL ARIAS'),
(273, 30, 'ZONA RURAL'),
(274, 31, 'APARICIO'),
(275, 31, 'BALNEARIO ORIENTE MARISOL'),
(276, 31, 'CORONEL DORREGO'),
(277, 31, 'EL PERDIDO'),
(278, 31, 'FARO'),
(279, 31, 'IRENE'),
(280, 31, 'ORIENTE'),
(281, 31, 'SAN ROMÁN'),
(282, 31, 'ZONA RURAL'),
(283, 32, 'CORONEL PRINGLES'),
(284, 32, 'EL DIVISORIO'),
(285, 32, 'EL PENSAMIENTO'),
(286, 32, 'INDIO RICO'),
(287, 32, 'LARTIGAU'),
(288, 32, 'ZONA RURAL'),
(289, 33, 'CASCADA'),
(290, 33, 'CORONEL SUÁREZ'),
(291, 33, 'CURA-MALAL'),
(292, 33, 'D\'ORBIGNY'),
(293, 33, 'HUANGUELEN (PARTE) (3)'),
(294, 33, 'PASMAN'),
(295, 33, 'SAN JOSE'),
(296, 33, 'SANTA MARIA'),
(297, 33, 'SANTA TRINIDAD'),
(298, 33, 'VILLA LA ARCADIA'),
(299, 33, 'ZONA RURAL'),
(300, 34, 'ARBOLEDAS'),
(301, 34, 'DAIREAUX'),
(302, 34, 'SALAZAR'),
(303, 34, 'ZONA RURAL'),
(304, 35, 'AGUAS VERDES'),
(305, 35, 'LA LUCILA DEL MAR'),
(306, 35, 'LAS TONINAS'),
(307, 35, 'MAR DE AJO'),
(308, 35, 'MAR DEL TUYU'),
(309, 35, 'SAN BERNARDO'),
(310, 35, 'SAN CLEMENTE DEL TUYU'),
(311, 35, 'SANTA TERESITA'),
(312, 35, 'ZONA RURAL'),
(313, 36, 'DOLORES'),
(314, 36, 'SEVIGNE'),
(315, 36, 'ZONA RURAL'),
(316, 37, 'DIQUE Nº 1'),
(317, 37, 'ENSENADA'),
(318, 37, 'PUNTA LARA'),
(319, 37, 'VILLA CATELLA'),
(320, 37, 'ZONA RURAL'),
(321, 38, 'BARRIO SAN LUIS'),
(322, 38, 'BELEN DE ESCOBAR'),
(323, 38, 'GARIN'),
(324, 38, 'INGENIERO MASCHWITZ'),
(325, 38, 'ISLAS DEL DELTA'),
(326, 38, 'LOMA VERDE'),
(327, 38, 'MAQUINISTA SAVIO'),
(328, 38, 'MATHEU'),
(329, 38, 'ZONA RURAL'),
(330, 39, 'BARRIO ECHEVERRIA'),
(331, 39, 'BARRIO NUEVE DE ABRIL'),
(332, 39, 'EL JAGÜEL'),
(333, 39, 'LUIS GUILLON'),
(334, 39, 'MONTE GRANDE'),
(335, 39, 'VILLA LAS MORERAS'),
(336, 39, 'ZONA RURAL'),
(337, 40, 'ARROYO DE LA CRUZ'),
(338, 40, 'BARRIO EL REMANSO'),
(339, 40, 'BARRIO EXALTACIÓN'),
(340, 40, 'BARRIO LOS PINOS'),
(341, 40, 'CAPILLA DEL SEÑOR'),
(342, 40, 'CHENAUT'),
(343, 40, 'DIEGO GAYNOR'),
(344, 40, 'ETCHEGOYEN'),
(345, 40, 'GOBERNADOR ANDONAEGUI'),
(346, 40, 'LOS CARDALES (PARTE) (4)'),
(347, 40, 'PARADA LA LATA'),
(348, 40, 'PARADA ORLANDO'),
(349, 40, 'PARADA ROBLES'),
(350, 40, 'PAVON'),
(351, 40, 'VILLA MANUEL CRUZ'),
(352, 40, 'VILLA PRECEPTOR M. ROBLES'),
(353, 40, 'ZONA RURAL'),
(354, 41, 'CARLOS SPEGAZZINI'),
(355, 41, 'JORGE CANNING'),
(356, 41, 'JOSE MARIA EZEIZA'),
(357, 41, 'LA UNION'),
(358, 41, 'TRISTAN SUAREZ'),
(359, 42, 'BOSQUES'),
(360, 42, 'ESTANISLAO ZEBALLOS'),
(361, 42, 'FLORENCIO VARELA'),
(362, 42, 'GOBERNADOR JULIO A. COSTA'),
(363, 42, 'GOBERNADOR MONTEVERDE'),
(364, 42, 'INGENIERO ALLAN'),
(365, 42, 'KILOMETRO 26.700'),
(366, 42, 'LA CAPILLA'),
(367, 42, 'MONTARAZ'),
(368, 42, 'SANTA ROSA'),
(369, 42, 'VILLA BROWN'),
(370, 42, 'VILLA DEL PLATA'),
(371, 42, 'VILLA SAN LUIS'),
(372, 42, 'VILLA VATTEONE'),
(373, 42, 'ZONA RURAL'),
(374, 43, 'AMEGHINO'),
(375, 43, 'BLAQUIER'),
(376, 43, 'PORVENIR'),
(377, 43, 'ZONA RURAL'),
(378, 44, 'BOULEVARD ATLANTICO MAR DEL SUR'),
(379, 44, 'COMANDANTE NICANOR OTAMENDI'),
(380, 44, 'MECHONGUE'),
(381, 44, 'MIRAMAR'),
(382, 44, 'ZONA RURAL'),
(383, 45, 'GENERAL ALVEAR'),
(384, 45, 'ZONA RURAL'),
(385, 46, 'ARRIBEÑOS'),
(386, 46, 'ASCENCION'),
(387, 46, 'ESTACION ARENALES'),
(388, 46, 'FERRE'),
(389, 46, 'GENERAL ARENALES'),
(390, 46, 'LA ANGELITA'),
(391, 46, 'LA TRINIDAD'),
(392, 46, 'ZONA RURAL'),
(393, 47, 'GENERAL BELGRANO'),
(394, 47, 'ZONA RURAL'),
(395, 48, 'GENERAL GUIDO'),
(396, 48, 'LABARDEN'),
(397, 48, 'ZONA RURAL'),
(398, 49, 'GENERAL LAMADRID'),
(399, 49, 'LA COLINA'),
(400, 49, 'LAS MARTINETAS'),
(401, 49, 'LIBANO'),
(402, 49, 'PONTAUT'),
(403, 49, 'ZONA RURAL'),
(404, 50, 'GENERAL HORNOS'),
(405, 50, 'GENERAL LAS HERAS'),
(406, 50, 'LA CHOZA'),
(407, 50, 'PLOMER'),
(408, 50, 'VILLARS'),
(409, 50, 'ZONA RURAL'),
(410, 60, 'GENERAL LAVALLE'),
(411, 60, 'ZONA RURAL'),
(412, 61, 'GENERAL JUAN MADARIAGA'),
(413, 61, 'ZONA RURAL'),
(414, 62, 'BALNEARIO RIO SALADO'),
(415, 62, 'LOMA VERDE'),
(416, 62, 'RANCHOS'),
(417, 62, 'VILLANUEVA'),
(418, 62, 'ZONA RURAL'),
(419, 63, 'COLONIA SAN RICARDO'),
(420, 63, 'GENERAL PINTO'),
(421, 63, 'GERMANIA'),
(422, 63, 'VILLA FRANCIA'),
(423, 63, 'VILLA ROTH'),
(424, 63, 'ZONA RURAL'),
(425, 64, 'BARRIO CHAPADMALAL'),
(426, 64, 'BARRIO COLINAS VERDES'),
(427, 64, 'BARRIO EL BOQUERON'),
(428, 64, 'BARRIO EL CASAL'),
(429, 64, 'BARRIO EL COYUNCO'),
(430, 64, 'BARRIO EL SOSIEGO'),
(431, 64, 'BARRIO FELIX CAMET'),
(432, 64, 'BARRIO LA GLORIA'),
(433, 64, 'BARRIO LOS ZORZALES'),
(434, 64, 'BARRIO MARQUESADO'),
(435, 64, 'BATAN'),
(436, 64, 'CAMET'),
(437, 64, 'ESTACION CAMET'),
(438, 64, 'ESTACION CHAPADMALAL'),
(439, 64, 'LAS DALIAS'),
(440, 64, 'MAR DEL PLATA'),
(441, 64, 'PUNTA MOGOTES'),
(442, 64, 'SIERRA DE LOS PADRES'),
(443, 64, 'ZONA RURAL'),
(444, 65, 'BARRIO HERMOSO'),
(445, 65, 'GENERAL RODRIGUEZ'),
(446, 65, 'LAS MALVINAS'),
(447, 65, 'VILLA BENGOLE'),
(448, 65, 'VILLA GAMBAUDE'),
(449, 65, 'VILLA RICO TIPO'),
(450, 65, 'ZONA RURAL'),
(451, 66, 'ALIANZA'),
(452, 66, 'BARRIO PARQUE GENERAL SAN MARTIN'),
(453, 66, 'BILLINGHURST'),
(454, 66, 'CIUDAD JARDIN DEL LIBERTADOR (EX LOMA HERMOSA)'),
(455, 66, 'GENERAL SAN MARTIN'),
(456, 66, 'JOSE INGENIEROS'),
(457, 66, 'JOSE LEON SUAREZ'),
(458, 66, 'JOSE M. BOSCH'),
(459, 66, 'JOSE MARTI'),
(460, 66, 'LOURDES'),
(461, 66, 'MALAVER'),
(462, 66, 'MIGUELETE'),
(463, 66, 'PUEBLO NUEVO'),
(464, 66, 'SAN ANDRES'),
(465, 66, 'TROPEZON'),
(466, 66, 'VILLA ALCORTA'),
(467, 66, 'VILLA AYACUCHO'),
(468, 66, 'VILLA BALLESTER'),
(469, 66, 'VILLA BARBOZA'),
(470, 66, 'VILLA BARRIO PARQUE'),
(471, 66, 'VILLA BERNARDO MONTEAGUDO'),
(472, 66, 'VILLA BONICH'),
(473, 66, 'VILLA CHACABUCO'),
(474, 66, 'VILLA CONCEPCION'),
(475, 66, 'VILLA CORONEL ZAPIOLA'),
(476, 66, 'VILLA DANIEL'),
(477, 66, 'VILLA ESCALADA'),
(478, 66, 'VILLA ESMERALDA'),
(479, 66, 'VILLA EXCELSIOR'),
(480, 66, 'VILLA FURTS'),
(481, 66, 'VILLA GARIBALDI'),
(482, 66, 'VILLA GENERAL ANTONIO SUCRE'),
(483, 66, 'VILLA GENERAL EUGENIO NECOCHEA'),
(484, 66, 'VILLA GENERAL JUAN G. LAS HERAS'),
(485, 66, 'VILLA GENERAL TOMAS GUIDO'),
(486, 66, 'VILLA GODOY CRUZ'),
(487, 66, 'VILLA GRANADEROS DE GRAL.SAN MARTIN'),
(488, 66, 'VILLA GREGORIA MATORRAS'),
(489, 66, 'VILLA HERMINIA'),
(490, 66, 'VILLA HIDALGO'),
(491, 66, 'VILLA HUE'),
(492, 66, 'VILLA HUMBERTO I'),
(493, 66, 'VILLA IPARAGUIRRE'),
(494, 66, 'VILLA JUAN MARTIN DE PUEYRREDON'),
(495, 66, 'VILLA KLEIN'),
(496, 66, 'VILLA LA CRUJIA'),
(497, 66, 'VILLA LACROZE'),
(498, 66, 'VILLA LEONI'),
(499, 66, 'VILLA LIBERTAD'),
(500, 66, 'VILLA LUCHETTI'),
(501, 66, 'VILLA LYNCH'),
(502, 66, 'VILLA MAIPU'),
(503, 66, 'VILLA MARECHAL'),
(504, 66, 'VILLA MARIA IRENE'),
(505, 66, 'VILLA MARQUES DE AGUADO'),
(506, 66, 'VILLA MONROE'),
(507, 66, 'VILLA MONTEAGUDO'),
(508, 66, 'VILLA MONTECARLO'),
(509, 66, 'VILLA PARQUE PTE. FIGUEROA ALCORTA'),
(510, 66, 'VILLA PARQUE SAN LORENZO'),
(511, 66, 'VILLA PIAGGIO'),
(512, 66, 'VILLA PINERAL'),
(513, 66, 'VILLA PROGRESO'),
(514, 66, 'VILLA RAFFO'),
(515, 66, 'VILLA REMEDIOS DE ESCALADA'),
(516, 66, 'VILLA SAN LORENZO'),
(517, 66, 'VILLA YAPEYU'),
(518, 66, 'VILLA ZAGALA'),
(519, 67, 'BAIGORRITA'),
(520, 67, 'LOS TOLDOS'),
(521, 67, 'SAN EMILIO'),
(522, 67, 'ZAVALIA'),
(523, 67, 'ZONA RURAL'),
(524, 68, 'BANDERALO'),
(525, 68, 'BASAVILBASO'),
(526, 68, 'COLONIA CASAL (EST. CAÑADA SECA)'),
(527, 68, 'EMILIO V.BUNGE'),
(528, 68, 'FERNANDO MARTI'),
(529, 68, 'GENERAL VILLEGAS'),
(530, 68, 'MASSEY (ESTACION ELORDI)'),
(531, 68, 'PICHINCHA'),
(532, 68, 'PIEDRITAS'),
(533, 68, 'SANTA REGINA'),
(534, 68, 'VILLA SABOYA'),
(535, 68, 'VILLA SAUCE'),
(536, 68, 'ZONA RURAL'),
(537, 69, 'ARROYO VENADO'),
(538, 69, 'CASBAS'),
(539, 69, 'GARRE'),
(540, 69, 'GUAMINÍ'),
(541, 69, 'HUANGUELEN (PARTE) (3)'),
(542, 69, 'LAGUNA ALSINA'),
(543, 69, 'ZONA RURAL'),
(544, 70, 'HENDERSON'),
(545, 70, 'ZONA RURAL'),
(546, 71, 'HURLINGHAM'),
(547, 71, 'VILLA TESSEI'),
(548, 71, 'WILLIAMS MORRIS'),
(549, 72, 'BARRIO PARQUE LELOIR'),
(550, 72, 'BARRIO SAN ALBERTO'),
(551, 72, 'ITUZAINGO'),
(552, 72, 'VILLA UDAONDO'),
(553, 73, 'JOSE C. PAZ'),
(554, 74, 'AGUSTINA'),
(555, 74, 'BALNEARIO LAGUNA DE GOMEZ'),
(556, 74, 'CORONEL M. PAZ (EST. A. ROCA)'),
(557, 74, 'FORTIN TIBURCIO'),
(558, 74, 'JUNÍN'),
(559, 74, 'LAPLACETTE'),
(560, 74, 'MORSE'),
(561, 74, 'SAFORCADA'),
(562, 74, 'ZONA RURAL'),
(563, 75, 'KILOMETRO 28'),
(564, 75, 'ALDO BONZI'),
(565, 75, 'BARRIO MANZANARES'),
(566, 75, 'BARRIO SAN SEBASTIAN'),
(567, 75, 'CIUDAD EVITA'),
(568, 75, 'DESVIO QUERANDI'),
(569, 75, 'ISIDRO CASANOVA'),
(570, 75, 'LA SALADA'),
(571, 75, 'LA TABLADA'),
(572, 75, 'LOMA DE MILLON'),
(573, 75, 'LOMAS DEL MIRADOR'),
(574, 75, 'LOS ALAMOS'),
(575, 75, 'MENDEVILLE'),
(576, 75, 'RAMOS MEJIA'),
(577, 75, 'SAN JUSTO'),
(578, 75, 'TAPIALES'),
(579, 75, 'VILLA ANSALDO'),
(580, 75, 'VILLA BALESTRA'),
(581, 75, 'VILLA CELINA'),
(582, 75, 'VILLA INSUPERABLE'),
(583, 75, 'VILLA LAS FABRICAS'),
(584, 75, 'VILLA LUZURIAGA'),
(585, 75, 'VILLA MADERO'),
(586, 75, 'VILLA MAZZORELLO'),
(587, 75, 'VILLA RAVAZZA'),
(588, 75, 'VILLA RECONDO'),
(589, 75, 'BARRIO COSTA AZUL'),
(590, 75, 'BARRIO COSTA ESPERANZAN'),
(591, 75, 'BARRIO LA CASONA'),
(592, 75, 'BARRIO LA LOMITA'),
(593, 75, 'BARRIO MALVINAS'),
(594, 75, 'BARRIO NUESTRO FUTURO'),
(595, 75, 'BARRIO OCHO DE OCTUBRE'),
(596, 75, 'BARRIO ORO VERDE'),
(597, 75, 'BARRIO SAN CAYETANO'),
(598, 75, 'BARRIO SANTA LIBRADA'),
(599, 75, 'BEETHOVEN'),
(600, 75, 'COBO'),
(601, 75, 'COMODORO PY'),
(602, 75, 'GARCIA MEROU'),
(603, 75, 'GONZALEZ CATAN'),
(604, 75, 'GREGORIO DE LAFERRERE'),
(605, 75, 'MENDEZ DE ANDES'),
(606, 75, 'POLLEDO'),
(607, 75, 'RAFAEL CASTILLO'),
(608, 75, 'RECUERO'),
(609, 75, 'RIGLOS'),
(610, 75, 'VEINTE DE JUNIO'),
(611, 75, 'VILLA ADRIANA'),
(612, 75, 'VILLA BARRIO AMERICA'),
(613, 75, 'VILLA LAS NIEVES'),
(614, 75, 'VIRREY DEL PINO'),
(615, 76, 'ABASTO'),
(616, 76, 'ARTURO SEGUÍ'),
(617, 76, 'BARRIO E.CARMEN (O)'),
(618, 76, 'BARRIO EL RETIRO'),
(619, 76, 'BARRIO GAMBIER'),
(620, 76, 'BARRIO LAS MALVINAS'),
(621, 76, 'BARRIO LAS QUINTAS'),
(622, 76, 'BARRIO RUTA SOL'),
(623, 76, 'CITY BELL'),
(624, 76, 'CORREAS'),
(625, 76, 'ETCHEVERRY'),
(626, 76, 'JOAQUIN GORINA'),
(627, 76, 'JOSE HERNANDEZ'),
(628, 76, 'LA CUMBRE'),
(629, 76, 'LA PLATA'),
(630, 76, 'LISANDRO OLMOS'),
(631, 76, 'LOS HORNOS'),
(632, 76, 'MANUEL B.GONNET'),
(633, 76, 'MELCHOR ROMERO'),
(634, 76, 'R. DE ELIZALDE'),
(635, 76, 'RINGUELET'),
(636, 76, 'TOLOSA'),
(637, 76, 'TRANSRADIO'),
(638, 76, 'VILLA ELISA'),
(639, 76, 'VILLA ELVIRA'),
(640, 76, 'VILLA MONTORO'),
(641, 76, 'ZONA RURAL'),
(642, 77, 'GERLI (PARTE) (2)'),
(643, 77, 'LANUS ESTE'),
(644, 77, 'LANUS OESTE'),
(645, 77, 'MONTE CHINGOLO'),
(646, 77, 'REMEDIOS DE ESCALADA DE SAN MARTIN'),
(647, 77, 'VALENTIN ALSINA'),
(648, 77, 'VILLA CARAZA'),
(649, 77, 'VILLA CASTELLINO'),
(650, 77, 'VILLA DIAMANTE'),
(651, 77, 'VILLA EDEN ARGENTINO'),
(652, 77, 'VILLA INDEPENDENCIA'),
(653, 77, 'VILLA INDUSTRIALES'),
(654, 77, 'VILLA MAURICIO'),
(655, 78, 'LAPRIDA'),
(656, 78, 'ZONA RURAL'),
(657, 79, 'CORONEL BOERR'),
(658, 79, 'EL TRIGO'),
(659, 79, 'LAS FLORES'),
(660, 79, 'PARDO'),
(661, 79, 'ZONA RURAL'),
(662, 80, 'EL DORADO'),
(663, 80, 'FORTÍN ACHA'),
(664, 80, 'J. B. ALBERDI'),
(665, 80, 'L.N.ALEM'),
(666, 80, 'VEDIA'),
(667, 80, 'ZONA RURAL'),
(668, 81, 'ARENAZA'),
(669, 81, 'BAYAUCA'),
(670, 81, 'CARLOS SALAS'),
(671, 81, 'CORONEL MARTÍNEZ DE HOZ'),
(672, 81, 'EL TRIUNFO'),
(673, 81, 'LINCOLN'),
(674, 81, 'PASTEUR'),
(675, 81, 'ROBERTS'),
(676, 81, 'ZONA RURAL'),
(677, 82, 'ARENAS VERDES'),
(678, 82, 'LIC. MATIENZO'),
(679, 82, 'LOBERIA'),
(680, 82, 'PIERES'),
(681, 82, 'SAN MANUEL'),
(682, 82, 'TAMANGUEYU'),
(683, 82, 'ZONA RURAL'),
(684, 83, 'A. CARBONI'),
(685, 83, 'ELVIRA'),
(686, 83, 'EMPALME LOBOS'),
(687, 83, 'LAGUNA DE LOBOS'),
(688, 83, 'LOBOS'),
(689, 83, 'SALVADOR MARIA'),
(690, 83, 'ZONA RURAL'),
(691, 84, 'BANFIELD'),
(692, 84, 'INGENIERO BUDGE'),
(693, 84, 'LLAVALLOL'),
(694, 84, 'LOMAS DE SAN JAVIER'),
(695, 84, 'LOMAS DE ZAMORA'),
(696, 84, 'SANTA CATALINA'),
(697, 84, 'TEMPERLEY'),
(698, 84, 'TURDERA'),
(699, 84, 'VILLA FIORITO'),
(700, 84, 'VILLA 4NA'),
(701, 84, 'VILLA CENTENARIO'),
(702, 84, 'VILLA ECONOMICA'),
(703, 84, 'VILLA EL FARO'),
(704, 84, 'VILLA ELVIRA'),
(705, 84, 'VILLA EMMA'),
(706, 84, 'VILLA GALICIA'),
(707, 84, 'VILLA INDEPENDENCIA'),
(708, 84, 'VILLA LA PERLA'),
(709, 84, 'VILLA RIACHUELO'),
(710, 85, 'ALASTUEY'),
(711, 85, 'CARLOS KEEN'),
(712, 85, 'CORTINES'),
(713, 85, 'D. CABRET'),
(714, 85, 'JAUREGUI'),
(715, 85, 'LEZICA Y TORREZURI'),
(716, 85, 'LUJAN'),
(717, 85, 'OLIVERA'),
(718, 85, 'OPEN DOOR (ESTACION CABRED)'),
(719, 85, 'PUEBLO NUEVO'),
(720, 85, 'SAN ELADIO'),
(721, 85, 'TORRES'),
(722, 85, 'VILLA FLANDRIA NORTE'),
(723, 85, 'VILLA FLANDRIA SUR'),
(724, 85, 'ZONA RURAL'),
(725, 86, 'ATALAYA'),
(726, 86, 'GENERAL MANSILLA'),
(727, 86, 'MAGDALENA'),
(728, 86, 'VIEYTES'),
(729, 86, 'ZONA RURAL'),
(730, 87, 'LAS ARMAS'),
(731, 87, 'MAIPU'),
(732, 87, 'SANTO DOMINGO'),
(733, 87, 'ZONA RURAL'),
(734, 88, 'ADOLFO SOURDEAUX'),
(735, 88, 'GRAND BOURG'),
(736, 88, 'LOS POLVORINES'),
(737, 88, 'PABLO NOGUES'),
(738, 88, 'TORTUGUITAS'),
(739, 88, 'VILLA DE MAYO'),
(740, 89, 'ATLANTIDA'),
(741, 89, 'BALNEARIO PARQUE MAR CHIQUITA'),
(742, 89, 'CAMET NORTE'),
(743, 89, 'CORONEL VIDAL'),
(744, 89, 'FRENTE MAR'),
(745, 89, 'GENERAL PIRAN'),
(746, 89, 'LA ARMONIA'),
(747, 89, 'LA BALIZA'),
(748, 89, 'LA CALETA'),
(749, 89, 'MAR DE COBO'),
(750, 89, 'PLAYA DORADA'),
(751, 89, 'SANTA CLARA DEL MAR'),
(752, 89, 'SANTA ELENA'),
(753, 89, 'VIVORATA'),
(754, 90, 'ELIAS ROMERO'),
(755, 90, 'MARCOS PAZ'),
(756, 90, 'ZONA RURAL'),
(757, 91, 'AGOTE'),
(758, 91, 'ALTAMIRA'),
(759, 91, 'FRANKLIN'),
(760, 91, 'GARCIA MANUEL H.'),
(761, 91, 'GOLDNEY'),
(762, 91, 'GOWLAND'),
(763, 91, 'JOFFRE TOMAS'),
(764, 91, 'JORGE BORN'),
(765, 91, 'LA VERDE'),
(766, 91, 'MERCEDES'),
(767, 91, 'SAN JACINTO'),
(768, 91, 'ZONA RURAL'),
(769, 92, 'LIBERTAD'),
(770, 92, 'PONTEVEDRA'),
(771, 92, 'BARRIO NUEVO'),
(772, 92, 'BARRIO PARQUE SAN MARTIN'),
(773, 92, 'MARIANO ACOSTA'),
(774, 92, 'MERLO'),
(775, 92, 'SAN ANTONIO DE PADUA'),
(776, 92, 'ZONA RURAL'),
(777, 93, 'ABBOTT'),
(778, 93, 'SAN MIGUEL DEL MONTE'),
(779, 93, 'Z. VIDELA DORNA'),
(780, 93, 'ZONA RURAL'),
(781, 94, 'BALNEARIO SAUCE GRANDE'),
(782, 94, 'MONTE HERMOSO'),
(783, 94, 'ZONA RURAL'),
(784, 95, 'BARRIO AREA'),
(785, 95, 'CUARTEL V'),
(786, 95, 'FRANCISCO ALVAREZ'),
(787, 95, 'LA REJA'),
(788, 95, 'LAS CATONAS'),
(789, 95, 'MORENO'),
(790, 95, 'PARADA KILOMETRO 336'),
(791, 95, 'PARADA KILOMETRO 40'),
(792, 95, 'PASO DEL REY'),
(793, 95, 'TRUJUI'),
(794, 95, 'VILLA GRAL ZAPIOLA'),
(795, 95, 'VILLA HERRERO'),
(796, 95, 'ZONA RURAL'),
(797, 96, 'CASTELAR'),
(798, 96, 'EL PALOMAR'),
(799, 96, 'HAEDO'),
(800, 96, 'LAS NACIONES'),
(801, 96, 'LOMA VERDE'),
(802, 96, 'MORÓN'),
(803, 96, 'VEINTE DE JUNIO'),
(804, 96, 'VILLA ESPERANZA'),
(805, 96, 'VILLA GALLO'),
(806, 96, 'VILLA LEON'),
(807, 96, 'VILLA PRESIDENTE H. YRIGOYEN'),
(808, 96, 'VILLA SARMIENTO'),
(809, 97, 'JUAN J.ALMEYRA'),
(810, 97, 'LAS MARIANAS'),
(811, 97, 'NAVARRO'),
(812, 97, 'VILLA MOLL'),
(813, 97, 'ZONA RURAL'),
(814, 98, 'CLARAZ'),
(815, 98, 'ENERGIA'),
(816, 98, 'J. N. FERNANDEZ'),
(817, 98, 'N. OLIVERA (ESTACION LA DULCE)'),
(818, 98, 'NECOCHEA'),
(819, 98, 'QUEQUEN'),
(820, 98, 'R. SANTA MARINA'),
(821, 98, 'ZONA RURAL'),
(822, 99, 'A. DEMARCHI (EST. QUIROGA)'),
(823, 99, 'C.M.NAON'),
(824, 99, 'DENNEHY'),
(825, 99, 'DOCE DE OCTUBRE'),
(826, 99, 'DUDIGNAC'),
(827, 99, 'LA AURORA (EST. LA NINA)'),
(828, 99, 'M.B.GONNET (EST. FRENCH)'),
(829, 99, 'MOREA'),
(830, 99, 'NORUMBEGA'),
(831, 99, 'NUEVE DE JULIO'),
(832, 99, 'PATRICIOS'),
(833, 99, 'VILLA FOURNIER'),
(834, 99, 'ZONA RURAL'),
(835, 100, 'BLANCAGRANDE'),
(836, 100, 'COLONIA HINOJO'),
(837, 100, 'COLONIA NIEVAS'),
(838, 100, 'COLONIA SAN MIGUEL'),
(839, 100, 'ESPIGAS'),
(840, 100, 'HINOJO'),
(841, 100, 'OLAVARRIA'),
(842, 100, 'RECALDE'),
(843, 100, 'SIERRA CHICA'),
(844, 100, 'SIERRAS BAYAS'),
(845, 100, 'VILLA A. FORTABAT'),
(846, 100, 'VILLA ARRIETA'),
(847, 100, 'VILLA VON BERNARD'),
(848, 100, 'ZONA RURAL'),
(849, 101, 'C. CAGLIERO'),
(850, 101, 'CARMEN DE PATAGONES'),
(851, 101, 'ISLAS'),
(852, 101, 'JOSÉ B. CASAS'),
(853, 101, 'JUAN A. PRADERE'),
(854, 101, 'STROEDER'),
(855, 101, 'VILLALONGA'),
(856, 101, 'ZONA RURAL'),
(857, 101, 'BAHÍA SAN BLAS'),
(858, 102, 'CAPITAN CASTRO'),
(859, 102, 'JUAN JOSE PASO'),
(860, 102, 'MAGDALA'),
(861, 102, 'MONES CAZON'),
(862, 102, 'NUEVA PLATA'),
(863, 102, 'PEHUAJO'),
(864, 102, 'SALAZAR'),
(865, 102, 'SAN BERNARDO'),
(866, 102, 'SAN ESTEBAN'),
(867, 102, 'ZONA RURAL'),
(868, 103, 'BOCAYUVA'),
(869, 103, 'DE BARY'),
(870, 103, 'PELLEGRINI'),
(871, 103, 'ZONA RURAL'),
(872, 104, 'ACEVEDO'),
(873, 104, 'ANCHORENA (EST. URQUIZA)'),
(874, 104, 'GUERRICO'),
(875, 104, 'J.A.DE LA PEÑA'),
(876, 104, 'LA VIOLETA'),
(877, 104, 'M. H. ALFONZO'),
(878, 104, 'M.BENITEZ'),
(879, 104, 'MANUEL OCAMPO'),
(880, 104, 'PERGAMINO'),
(881, 104, 'PINZON'),
(882, 104, 'RANCAGUA'),
(883, 104, 'VILLA ANGELICA (EST. EL SOCORRO)'),
(884, 104, 'ZONA RURAL'),
(885, 105, 'PILA'),
(886, 105, 'ZONA RURAL'),
(887, 106, 'BARRIO DE VICENZO'),
(888, 106, 'BARRIO LOS CACHORROS'),
(889, 106, 'BARRIO RIO LUJAN'),
(890, 106, 'BARRIO SOLARES'),
(891, 106, 'DEL VISO'),
(892, 106, 'DERQUI'),
(893, 106, 'EMPALME KILOMETRO 54'),
(894, 106, 'FATIMA'),
(895, 106, 'KILOMETRO 66'),
(896, 106, 'LA LONJA'),
(897, 106, 'LAGOMARSINO'),
(898, 106, 'MANUEL 4'),
(899, 106, 'MANZANARES'),
(900, 106, 'MANZONE'),
(901, 106, 'PILAR'),
(902, 106, 'PRESIDENTE DERQUI'),
(903, 106, 'SANTA TERESA'),
(904, 106, 'VILLA ASTOLFI'),
(905, 106, 'VILLA ROSA'),
(906, 106, 'ZELAYA'),
(907, 106, 'ZONA RURAL'),
(908, 107, 'CARILO'),
(909, 107, 'OSTENDE'),
(910, 107, 'PINAMAR'),
(911, 107, 'VALERIA DEL MAR'),
(912, 107, 'ZONA RURAL'),
(913, 108, 'AMERICA UNIDA'),
(914, 108, 'BARRIO RAYITO DE SOL'),
(915, 108, 'BARRIO SAN ROQUE'),
(916, 108, 'GUERNICA'),
(917, 108, 'PRESIDENTE PERON'),
(918, 108, 'VILLA NUMANCIA'),
(919, 108, 'ZONA RURAL'),
(920, 109, 'AZOPARDO'),
(921, 109, 'BORDENAVE'),
(922, 109, 'DARREGUEIRA'),
(923, 109, 'ESTELA'),
(924, 109, 'FELIPE SOLÁ'),
(925, 109, 'LÓPEZ LECUBE'),
(926, 109, 'PUÁN'),
(927, 109, 'SAN GERMAN'),
(928, 109, 'VA.CASTELAR'),
(929, 109, 'VA.DURCUDOY'),
(930, 109, 'VILLA IRIS'),
(931, 109, 'ZONA RURAL'),
(932, 110, 'ALVAREZ JONTE'),
(933, 110, 'LA VIRUTA'),
(934, 110, 'LAS TAHONAS'),
(935, 110, 'LUJAN DEL RIO'),
(936, 110, 'PIPINAS'),
(937, 110, 'PUNTA INDIO'),
(938, 110, 'PUNTA PIEDRAS'),
(939, 110, 'VERONICA'),
(940, 110, 'ZONA RURAL'),
(941, 111, 'BERNAL'),
(942, 111, 'DON BOSCO'),
(943, 111, 'EZPELETA'),
(944, 111, 'LA COLONIA'),
(945, 111, 'QUILMES'),
(946, 111, 'SAN FRANCISCO SOLANO'),
(947, 111, 'VILLA CRAMER'),
(948, 111, 'VILLA LA FLORIDA'),
(949, 111, 'VILLA PRESIDENTE QUINTANA'),
(950, 112, 'EL PARAÍSO'),
(951, 112, 'ISLAS'),
(952, 112, 'PARAJE LAS BAHAMAS'),
(953, 112, 'PEREZ MILLAN'),
(954, 112, 'RAMALLO'),
(955, 112, 'V.GRAL.SAVIO'),
(956, 112, 'VILLA RAMALLO'),
(957, 112, 'ZONA RURAL'),
(958, 113, 'RAUCH'),
(959, 113, 'ZONA RURAL'),
(960, 114, 'AMERICA'),
(961, 114, 'FORTIN OLAVARRIA'),
(962, 114, 'GONZALEZ MORENO'),
(963, 114, 'MIRA PAMPA'),
(964, 114, 'RIVADAVIA'),
(965, 114, 'ROOSVELT'),
(966, 114, 'SAN MAURICIO'),
(967, 114, 'SANSINENA'),
(968, 114, 'SUNDBLAD'),
(969, 114, 'ZONA RURAL'),
(970, 115, 'LAS CARABELAS'),
(971, 115, 'LOS INDIOS'),
(972, 115, 'RAFAEL OBLIGADO'),
(973, 115, 'ROJAS'),
(974, 115, 'ZONA RURAL'),
(975, 116, 'C. BEGUERIE'),
(976, 116, 'ROQUE PEREZ'),
(977, 116, 'ZONA RURAL'),
(978, 117, 'ARROYO CORTO'),
(979, 117, 'DUFAUR'),
(980, 117, 'ESPARTILLAR (PARTE) (1)'),
(981, 117, 'GOYENA'),
(982, 117, 'PIGUE'),
(983, 117, 'SAAVEDRA'),
(984, 117, 'ZONA RURAL'),
(985, 118, 'ALVAREZ DE TOLEDO'),
(986, 118, 'BLAQUIER'),
(987, 118, 'CAZON'),
(988, 118, 'DEL CARRIL'),
(989, 118, 'POLVAREDAS'),
(990, 118, 'SALADILLO'),
(991, 118, 'ZONA RURAL'),
(992, 119, 'QUENUMA'),
(993, 119, 'SALLIQUELÓ'),
(994, 119, 'ZONA RURAL'),
(995, 120, 'ARROYO DULCE'),
(996, 120, 'GAHAN'),
(997, 120, 'INES INDART'),
(998, 120, 'SALTO'),
(999, 120, 'ZONA RURAL'),
(1000, 121, 'AZCUENAGA'),
(1001, 121, 'CUCULLU'),
(1002, 121, 'ESPORA'),
(1003, 121, 'HEAVY'),
(1004, 121, 'KILOMETRO 108'),
(1005, 121, 'KILOMETRO 125'),
(1006, 121, 'LA FLORIDA'),
(1007, 121, 'SAN ANDRES DE GILES'),
(1008, 121, 'SOLIS'),
(1009, 121, 'TUYUTI'),
(1010, 121, 'VILLA ESPIL'),
(1011, 121, 'VILLA RUIZ'),
(1012, 121, 'VILLA SAN ALBERTO'),
(1013, 121, 'ZONA RURAL'),
(1014, 122, 'DUGGAN'),
(1015, 122, 'PUENTE CASTEX'),
(1016, 122, 'SAN ANTONIO DE ARECO'),
(1017, 122, 'TRES SARGENTOS'),
(1018, 122, 'VAGUES'),
(1019, 122, 'VILLA LIA'),
(1020, 122, 'ZONA RURAL'),
(1021, 123, 'BALNEARIO'),
(1022, 123, 'ESTACION OCHANDIO'),
(1023, 123, 'SAN CAYETANO'),
(1024, 123, 'ZONA RURAL'),
(1025, 124, 'BANCALARI'),
(1026, 124, 'CARUPA'),
(1027, 124, 'EL DELTA'),
(1028, 124, 'ISLAS'),
(1029, 124, 'SAN FERNANDO'),
(1030, 124, 'VICTORIA'),
(1031, 124, 'VILLA PIÑEYRO'),
(1032, 124, 'VIRREYES'),
(1033, 125, 'ACASSUSO'),
(1034, 125, 'BECCAR'),
(1035, 125, 'BOULOGNE SUR MER'),
(1036, 125, 'JUAN ANCHORENA'),
(1037, 125, 'LAS BARRANCAS'),
(1038, 125, 'MARTINEZ'),
(1039, 125, 'PARQUE AGUIRRE'),
(1040, 125, 'SAN ISIDRO'),
(1041, 125, 'SANTA RITA'),
(1042, 125, 'VILLA ADELINA'),
(1043, 125, 'VILLA PRIMAVERA'),
(1044, 126, 'BELLA VISTA'),
(1045, 126, 'CAMPO DE MAYO'),
(1046, 126, 'MUÑIZ'),
(1047, 126, 'SAN MIGUEL'),
(1048, 127, 'BARRIO B.YAGUARÓN'),
(1049, 127, 'BARRIO C.SALLES'),
(1050, 127, 'BARRIO CASTELLI'),
(1051, 127, 'BARRIO COLOMBINI'),
(1052, 127, 'BARRIO GENERAL MOSCONI'),
(1053, 127, 'BARRIO LA FLORIDA'),
(1054, 127, 'BARRIO LAS MELLIZAS'),
(1055, 127, 'BARRIO MORENO'),
(1056, 127, 'BARRIO SAN FRANCISCO'),
(1057, 127, 'BARRIO SAN JORGE'),
(1058, 127, 'BARRIO SAN MARTÍN'),
(1059, 127, 'BARRIO SANDRINA'),
(1060, 127, 'BARRIO SANTA TERESITA'),
(1061, 127, 'BARRIO SUIZO'),
(1062, 127, 'BARRIO VILLA DE LUJÁN'),
(1063, 127, 'CERNADAS (EST. ROJO)'),
(1064, 127, 'CONESA'),
(1065, 127, 'ISLAS'),
(1066, 127, 'LA EMILIA'),
(1067, 127, 'LOPEZ ARIAS (EST. EREZCANO)'),
(1068, 127, 'SAN NICOLAS DE LOS ARROYOS'),
(1069, 127, 'VILLA CAMPI'),
(1070, 127, 'VILLA CANTO'),
(1071, 127, 'VILLA ESPERANZA'),
(1072, 127, 'VILLA HERMOSA'),
(1073, 127, 'VILLA RICCIO'),
(1074, 127, 'ZONA RURAL'),
(1075, 128, 'GOBERNADOR CASTRO'),
(1076, 128, 'INGENIERO MONETTA'),
(1077, 128, 'ISLAS'),
(1078, 128, 'PUEBLO DOYLE'),
(1079, 128, 'RIO TALA'),
(1080, 128, 'SAN PEDRO'),
(1081, 128, 'SANTA LUCIA'),
(1082, 128, 'VUELTA DE OBLIGADO'),
(1083, 128, 'ZONA RURAL'),
(1084, 129, 'ALEJANDRO KORN'),
(1085, 129, 'DOMSELAAR'),
(1086, 129, 'POBLACION RURAL'),
(1087, 129, 'SAN VICENTE'),
(1088, 130, 'GENERAL RIVAS'),
(1089, 130, 'SUIPACHA'),
(1090, 130, 'ZONA RURAL'),
(1091, 131, 'GARDEY'),
(1092, 131, 'MARIA IGNACIA (ESTACION VELA)'),
(1093, 131, 'TANDIL'),
(1094, 131, 'ZONA RURAL'),
(1095, 132, 'CROTTO'),
(1096, 132, 'TAPALQUÉ'),
(1097, 132, 'VELLOSO'),
(1098, 132, 'ZONA RURAL'),
(1099, 134, 'BENAVIDEZ'),
(1100, 134, 'DIQUE LUJÁN'),
(1101, 134, 'DON TORCUATO ESTE'),
(1102, 134, 'DON TORCUATO OESTE'),
(1103, 134, 'EL TALAR'),
(1104, 134, 'GENERAL PACHECO'),
(1105, 134, 'ISLAS'),
(1106, 134, 'MAXIMO FERNANDEZ'),
(1107, 134, 'MECHA'),
(1108, 134, 'PARADA LOPEZ CAMELO'),
(1109, 134, 'RICARDO ROJAS'),
(1110, 134, 'RINCON DE MILBERG'),
(1111, 134, 'TIGRE'),
(1112, 134, 'TRONCOS DEL TALAR'),
(1113, 135, 'GENERAL CONESA'),
(1114, 135, 'ZONA RURAL'),
(1115, 136, 'CHASICO'),
(1116, 136, 'PARAJE LA GRUTA'),
(1117, 136, 'SALDUNGARAY'),
(1118, 136, 'SIERRA DE LA VENTANA'),
(1119, 136, 'TORNQUIST'),
(1120, 136, 'TRES PICOS'),
(1121, 136, 'VILLA VENTANA'),
(1122, 136, 'ZONA RURAL'),
(1123, 137, 'BERUTTI'),
(1124, 137, 'FRANCISCO DE VICTORIA'),
(1125, 137, 'GIRODIAS'),
(1126, 137, 'LA CARRETA'),
(1127, 137, 'LA PORTEÑA'),
(1128, 137, 'MAGNANO'),
(1129, 137, 'TREINTA DE AGOSTO'),
(1130, 137, 'TRENQUE LAUQUEN'),
(1131, 138, 'BALNEARIO CLAROMECO'),
(1132, 138, 'BALNEARIO ORENSE'),
(1133, 138, 'BALNEARIO RETA'),
(1134, 138, 'COPETONAS'),
(1135, 138, 'DUNA MAR'),
(1136, 138, 'M. CASCALLARES'),
(1137, 138, 'ORENSE'),
(1138, 138, 'SAN FRANCISCO DE BELLOCQ'),
(1139, 138, 'SAN MAYOL'),
(1140, 138, 'TRES ARROYOS'),
(1141, 138, 'VILLA RODRIGUEZ'),
(1142, 138, 'ZONA RURAL'),
(1143, 139, 'CASEROS'),
(1144, 139, 'CHURRUCA'),
(1145, 139, 'CIUDAD JARDIN LOMAS DEL PALOMAR'),
(1146, 139, 'CIUDADELA'),
(1147, 139, 'EL LIBERTADOR'),
(1148, 139, 'JOSE INGENIEROS'),
(1149, 139, 'LOMA HERMOSA'),
(1150, 139, 'MARTIN CORONADO'),
(1151, 139, 'ONCE DE SEPTIEMBRE'),
(1152, 139, 'PABLO PODESTA'),
(1153, 139, 'REMEDIOS DE ESCALADA'),
(1154, 139, 'SAENZ ADELA'),
(1155, 139, 'SAENZ PEÑA'),
(1156, 139, 'SANTOS LUGARES'),
(1157, 139, 'VILLA BOSCH'),
(1158, 139, 'VILLA MATHEU'),
(1159, 139, 'VILLA RAFFO'),
(1160, 140, 'PEDRO M. MORENO (EST. ING.THOMSON)'),
(1161, 140, 'TRES LOMAS'),
(1162, 140, 'ZONA RURAL'),
(1163, 141, 'A. MOSCONI'),
(1164, 141, 'DEL VALLE'),
(1165, 141, 'ERNESTINA'),
(1166, 141, 'GOBERNADOR UGARTE'),
(1167, 141, 'NORBERTO DE LA RIESTRA'),
(1168, 141, 'PEDERNALES'),
(1169, 141, 'SAN ENRIQUE'),
(1170, 141, 'VALDES'),
(1171, 141, 'VEINTICINCO DE MAYO'),
(1172, 141, 'ZONA RURAL'),
(1173, 142, 'ARISTOBULO DEL VALLE'),
(1174, 142, 'BORGES'),
(1175, 142, 'CARAPACHAY'),
(1176, 142, 'FLORIDA ESTE'),
(1177, 142, 'FLORIDA OESTE'),
(1178, 142, 'JUAN B. JUSTO'),
(1179, 142, 'LA LUCILA'),
(1180, 142, 'MIGUEL PADILLA'),
(1181, 142, 'MIGUES'),
(1182, 142, 'MUNRO'),
(1183, 142, 'MUÑIZ'),
(1184, 142, 'OLIVOS'),
(1185, 142, 'VICENTE LOPEZ'),
(1186, 142, 'VILLA MARTELLI'),
(1187, 143, 'VILLA GESELL'),
(1188, 143, 'ZONA RURAL'),
(1189, 144, 'ARGERICH'),
(1190, 144, 'ESTACION ALGARROBO'),
(1191, 144, 'HILARIO ASCASUBI'),
(1192, 144, 'JUAN COUSTE'),
(1193, 144, 'LA MASCOTA'),
(1194, 144, 'MAYOR BURATOVICH'),
(1195, 144, 'MEDANOS'),
(1196, 144, 'PEDRO LURO'),
(1197, 144, 'TENIENTE ORIGONE'),
(1198, 144, 'ZONA RURAL'),
(1199, 145, 'EL BAGUEL'),
(1200, 145, 'EL TATU'),
(1201, 145, 'ESCALADA'),
(1202, 145, 'ESCALADA'),
(1203, 145, 'LA PESQUERIA'),
(1204, 145, 'LIMA'),
(1205, 145, 'PARAJE LAS PALMAS'),
(1206, 145, 'SECTOR ISLAS'),
(1207, 145, 'VILLA CAPDEPONT'),
(1208, 145, 'VILLA FLORIDA'),
(1209, 145, 'VILLA FOX'),
(1210, 145, 'VILLA MOSCONI'),
(1211, 145, 'ZARATE'),
(1212, 145, 'ZONA RURAL'),
(1213, 1, 'AGRONOMÍA'),
(1214, 2, ''),
(1215, 3, ''),
(1216, 4, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `med_id` int(11) NOT NULL,
  `med_nombre` varchar(255) NOT NULL,
  `med_apellido` varchar(255) NOT NULL,
  `med_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`med_id`, `med_nombre`, `med_apellido`, `med_email`) VALUES
(1, 'Omar', 'S', ''),
(2, 'Patricia', 'P', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico_off`
--

CREATE TABLE `medico_off` (
  `medoff_id` bigint(20) NOT NULL,
  `medoff_fecha_inicio` date NOT NULL,
  `medoff_fecha_fin` date NOT NULL,
  `medoff_observaciones` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observacion`
--

CREATE TABLE `observacion` (
  `obs_id` bigint(20) NOT NULL,
  `obs_texto` text COLLATE utf8_unicode_ci NOT NULL,
  `obs_ast_id` bigint(20) NOT NULL,
  `obs_fecha_hora` datetime NOT NULL,
  `obs_titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `pac_id` bigint(20) NOT NULL,
  `pac_ent_id` bigint(20) DEFAULT NULL,
  `pac_fecha_ingreso` date DEFAULT NULL,
  `pac_nro_documento` int(11) DEFAULT NULL,
  `pac_tid_id` int(11) DEFAULT NULL COMMENT 'Tipo documento',
  `pac_apellido` varchar(255) DEFAULT NULL,
  `pac_segundo_apellido` varchar(255) DEFAULT NULL,
  `pac_nombre` varchar(255) DEFAULT NULL,
  `pac_segundo_nombre` varchar(255) DEFAULT NULL,
  `pac_alias` varchar(255) DEFAULT NULL,
  `pac_iniciales` varchar(10) DEFAULT NULL,
  `pac_fecha_nacimiento` date DEFAULT NULL,
  `pac_telefono1` varchar(255) DEFAULT NULL,
  `pac_telefono2` varchar(255) DEFAULT NULL,
  `pac_gen_id` int(11) DEFAULT NULL COMMENT 'Sexo del paciente',
  `pac_sex_id` int(11) DEFAULT NULL,
  `pac_der_id` bigint(11) DEFAULT NULL,
  `pac_reh_id` bigint(20) DEFAULT NULL COMMENT 'Hospital desde donde refiere',
  `pac_ocupacion` varchar(255) DEFAULT NULL,
  `pac_obra_social` varchar(255) DEFAULT NULL,
  `pac_medico_deriva` varchar(255) DEFAULT NULL,
  `pac_observaciones` text DEFAULT NULL,
  `pac_recibir_email` tinyint(4) DEFAULT NULL,
  `pac_usr_id_alta` int(11) DEFAULT NULL COMMENT 'Usuario que lo crea',
  `pac_fecha_hora_alta` datetime DEFAULT NULL COMMENT 'Fecha y hora de creación',
  `pac_usr_id_modifica` int(11) DEFAULT NULL,
  `pac_fecha_hora_modifica` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`pac_id`, `pac_ent_id`, `pac_fecha_ingreso`, `pac_nro_documento`, `pac_tid_id`, `pac_apellido`, `pac_segundo_apellido`, `pac_nombre`, `pac_segundo_nombre`, `pac_alias`, `pac_iniciales`, `pac_fecha_nacimiento`, `pac_telefono1`, `pac_telefono2`, `pac_gen_id`, `pac_sex_id`, `pac_der_id`, `pac_reh_id`, `pac_ocupacion`, `pac_obra_social`, `pac_medico_deriva`, `pac_observaciones`, `pac_recibir_email`, `pac_usr_id_alta`, `pac_fecha_hora_alta`, `pac_usr_id_modifica`, `pac_fecha_hora_modifica`) VALUES
(1, NULL, '2020-08-07', 56656, 1, 'gomez', 'lopez', 'jose', 'alberto', 'joselo', 'JAGL', '1961-08-04', NULL, NULL, 2, 2, NULL, 1, NULL, 'OBSBA', 'Perez juan', 'safsdfsdaaaaaaaaaaaaaaaa', NULL, 1, '2020-08-07 18:21:42', 1, '2020-08-28 17:06:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente_contacto`
--

CREATE TABLE `paciente_contacto` (
  `pcon_pac_id` bigint(20) NOT NULL,
  `pcon_tic_id` int(11) NOT NULL,
  `pcon_id` bigint(20) NOT NULL,
  `pcon_descripcion` varchar(255) NOT NULL,
  `pcon_observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id_pais` int(11) NOT NULL DEFAULT 0,
  `nombre_pais` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id_pais`, `nombre_pais`) VALUES
(1, 'AFGHANISTAN'),
(2, 'ALBANIA'),
(3, 'ALGERIA'),
(4, 'AMERICAN SAMOA'),
(5, 'ANDORRA'),
(6, 'ANGOLA'),
(7, 'ANGUILLA'),
(8, 'ANTARCTICA'),
(9, 'ANTIGUA AND BARBUDA'),
(10, 'ARGENTINA'),
(11, 'ARMENIA'),
(12, 'ARUBA'),
(13, 'AUSTRALIA'),
(14, 'AUSTRIA'),
(15, 'AZERBAIJAN'),
(16, 'BAHAMAS'),
(17, 'BAHRAIN'),
(18, 'BANGLADESH'),
(19, 'BARBADOS'),
(20, 'BELARUS'),
(21, 'BELGIUM'),
(22, 'BELIZE'),
(23, 'BENIN'),
(24, 'BERMUDA'),
(25, 'BHUTAN'),
(26, 'BOLIVIA'),
(27, 'BOSNIA AND HERZEGOVINA'),
(28, 'BOTSWANA'),
(29, 'BOUVET ISLAND'),
(30, 'BRAZIL'),
(31, 'BRITISH INDIAN OCEAN TERRITORY'),
(32, 'BRUNEI DARUSSALAM'),
(33, 'BULGARIA'),
(34, 'BURKINA FASO'),
(35, 'BURUNDI'),
(36, 'CAMBODIA'),
(37, 'CAMEROON'),
(38, 'CANADA'),
(39, 'CAPE VERDE'),
(40, 'CAYMAN ISLANDS'),
(41, 'CENTRAL AFRICAN REPUBLIC'),
(42, 'CHAD'),
(43, 'CHILE'),
(44, 'CHINA'),
(45, 'CHRISTMAS ISLAND'),
(46, 'COCOS (KEELING) ISLANDS'),
(47, 'COLOMBIA'),
(48, 'COMOROS'),
(49, 'CONGO'),
(50, 'CONGO, THE DEMOCRATIC REPUBLIC OF THE'),
(51, 'COOK ISLANDS'),
(52, 'COSTA RICA'),
(53, 'COTE D\'IVOIRE'),
(54, 'CROATIA'),
(55, 'CUBA'),
(56, 'CYPRUS'),
(57, 'CZECH REPUBLIC'),
(58, 'DENMARK'),
(59, 'DJIBOUTI'),
(60, 'DOMINICA'),
(61, 'DOMINICAN REPUBLIC'),
(62, 'ECUADOR'),
(63, 'EGYPT'),
(64, 'EL SALVADOR'),
(65, 'EQUATORIAL GUINEA'),
(66, 'ERITREA'),
(67, 'ESTONIA'),
(68, 'ETHIOPIA'),
(69, 'FALKLAND ISLANDS (MALVINAS)'),
(70, 'FAROE ISLANDS'),
(71, 'FIJI'),
(72, 'FINLAND'),
(73, 'FRANCE'),
(74, 'FRENCH GUIANA'),
(75, 'FRENCH POLYNESIA'),
(76, 'FRENCH SOUTHERN TERRITORIES'),
(77, 'GABON'),
(78, 'GAMBIA'),
(79, 'GEORGIA'),
(80, 'GERMANY'),
(81, 'GHANA'),
(82, 'GIBRALTAR'),
(83, 'GREECE'),
(84, 'GREENLAND'),
(85, 'GRENADA'),
(86, 'GUADELOUPE'),
(87, 'GUAM'),
(88, 'GUATEMALA'),
(89, 'GUINEA'),
(90, 'GUINEABISSAU'),
(91, 'GUYANA'),
(92, 'HAITI'),
(93, 'HEARD ISLAND AND MCDONALD ISLANDS'),
(94, 'HOLY SEE (VATICAN CITY STATE)'),
(95, 'HONDURAS'),
(96, 'HONG KONG'),
(97, 'HUNGARY'),
(98, 'ICELAND'),
(99, 'INDIA'),
(100, 'INDONESIA'),
(101, 'IRAN, ISLAMIC REPUBLIC OF'),
(102, 'IRAQ'),
(103, 'IRELAND'),
(104, 'ISRAEL'),
(105, 'ITALY'),
(106, 'JAMAICA'),
(107, 'JAPAN'),
(108, 'JORDAN'),
(109, 'KAZAKHSTAN'),
(110, 'KENYA'),
(111, 'KIRIBATI'),
(112, 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF'),
(113, 'KOREA, REPUBLIC OF'),
(114, 'KUWAIT'),
(115, 'KYRGYZSTAN'),
(116, 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC'),
(117, 'LATVIA'),
(118, 'LEBANON'),
(119, 'LESOTHO'),
(120, 'LIBERIA'),
(121, 'LIBYAN ARAB JAMAHIRIYA'),
(122, 'LIECHTENSTEIN'),
(123, 'LITHUANIA'),
(124, 'LUXEMBOURG'),
(125, 'MACAO'),
(126, 'MACEDONIA'),
(127, 'MADAGASCAR'),
(128, 'MALAWI'),
(129, 'MALAYSIA'),
(130, 'MALDIVES'),
(131, 'MALI'),
(132, 'MALTA'),
(133, 'MARSHALL ISLANDS'),
(134, 'MARTINIQUE'),
(135, 'MAURITANIA'),
(136, 'MAURITIUS'),
(137, 'MAYOTTE'),
(138, 'MEXICO'),
(139, 'MICRONESIA, FEDERATED STATES OF'),
(140, 'MOLDOVA, REPUBLIC OF'),
(141, 'MONACO'),
(142, 'MONGOLIA'),
(143, 'MONTSERRAT'),
(144, 'MOROCCO'),
(145, 'MOZAMBIQUE'),
(146, 'MYANMAR'),
(147, 'NAMIBIA'),
(148, 'NAURU'),
(149, 'NEPAL'),
(150, 'NETHERLANDS'),
(151, 'NETHERLANDS ANTILLES'),
(152, 'NEW CALEDONIA'),
(153, 'NEW ZEALAND'),
(154, 'NICARAGUA'),
(155, 'NIGER'),
(156, 'NIGERIA'),
(157, 'NIUE'),
(158, 'NORFOLK ISLAND'),
(159, 'NORTHERN MARIANA ISLANDS'),
(160, 'NORWAY'),
(161, 'OMAN'),
(162, 'PAKISTAN'),
(163, 'PALAU'),
(164, 'PALESTINIAN TERRITORY, OCCUPIED'),
(165, 'PANAMA'),
(166, 'PAPUA NEW GUINEA'),
(167, 'PARAGUAY'),
(168, 'PERU'),
(169, 'PHILIPPINES'),
(170, 'PITCAIRN'),
(171, 'POLAND'),
(172, 'PORTUGAL'),
(173, 'PUERTO RICO'),
(174, 'QATAR'),
(175, 'REUNION'),
(176, 'ROMANIA'),
(177, 'RUSSIAN FEDERATION'),
(178, 'RWANDA'),
(179, 'SAINT HELENA'),
(180, 'SAINT KITTS AND NEVIS'),
(181, 'SAINT LUCIA'),
(182, 'SAINT PIERRE AND MIQUELON'),
(183, 'SAINT VINCENT AND THE GRENADINES'),
(184, 'SAMOA'),
(185, 'SAN MARINO'),
(186, 'SAO TOME AND PRINCIPE'),
(187, 'SAUDI ARABIA'),
(188, 'SENEGAL'),
(189, 'SERBIA AND MONTENEGRO'),
(190, 'SEYCHELLES'),
(191, 'SIERRA LEONE'),
(192, 'SINGAPORE'),
(193, 'SLOVAKIA'),
(194, 'SLOVENIA'),
(195, 'SOLOMON ISLANDS'),
(196, 'SOMALIA'),
(197, 'SOUTH AFRICA'),
(198, 'SOUTH GEORGIA AND SANDWICH ISLANDS'),
(199, 'SPAIN'),
(200, 'SRI LANKA'),
(201, 'SUDAN'),
(202, 'SURInombre_pais'),
(203, 'SVALBARD AND JAN MAYEN'),
(204, 'SWAZILAND'),
(205, 'SWEDEN'),
(206, 'SWITZERLAND'),
(207, 'SYRIAN ARAB REPUBLIC'),
(208, 'TAIWAN, PROVINCE OF CHINA'),
(209, 'TAJIKISTAN'),
(210, 'TANZANIA, UNITED REPUBLIC OF'),
(211, 'THAILAND'),
(212, 'TIMORLESTE'),
(213, 'TOGO'),
(214, 'TOKELAU'),
(215, 'TONGA'),
(216, 'TRINIDAD AND TOBAGO'),
(217, 'TUNISIA'),
(218, 'TURKEY'),
(219, 'TURKMENISTAN'),
(220, 'TURKS AND CAICOS ISLANDS'),
(221, 'TUVALU'),
(222, 'UGANDA'),
(223, 'UKRAINE'),
(224, 'UNITED ARAB EMIRATES'),
(225, 'UNITED KINGDOM'),
(226, 'UNITED STATES'),
(227, 'UNITED STATES MINOR OUTLYING ISLANDS'),
(228, 'URUGUAY'),
(229, 'UZBEKISTAN'),
(230, 'VANUATU'),
(231, 'VENEZUELA'),
(232, 'VIET NAM'),
(233, 'VIRGIN ISLANDS, BRITISH'),
(234, 'VIRGIN ISLANDS, U.S.'),
(235, 'WALLIS AND FUTUNA'),
(236, 'WESTERN SAHARA'),
(237, 'YEMEN'),
(238, 'ZAMBIA'),
(239, 'ZIMBABWE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partido`
--

CREATE TABLE `partido` (
  `id_partido` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `nombre_partido` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `partido`
--

INSERT INTO `partido` (`id_partido`, `id_provincia`, `nombre_partido`) VALUES
(1, 1, 'CABA'),
(2, 2, 'ADOLFO ALSINA'),
(3, 2, 'ADOLFO GONZÁLES CHAVES'),
(4, 2, 'ALBERTI'),
(5, 2, 'ALMIRANTE BROWN'),
(6, 2, 'ARRECIFES'),
(7, 2, 'AVELLANEDA'),
(8, 2, 'AYACUCHO'),
(9, 2, 'AZUL'),
(10, 2, 'BAHÍA BLANCA'),
(11, 2, 'BALCARCE'),
(12, 2, 'BARADERO'),
(13, 2, 'BENITO JUAREZ'),
(14, 2, 'BERAZATEGUI'),
(15, 2, 'BERISSO'),
(16, 2, 'BOLIVAR'),
(17, 2, 'BRAGADO'),
(18, 2, 'CAMPANA'),
(19, 2, 'CAÑUELAS'),
(20, 2, 'CAPITÁN SARMIENTO'),
(21, 2, 'CARLOS CASARES'),
(22, 2, 'CARLOS TEJEDOR'),
(23, 2, 'CARMEN DE ARECO'),
(24, 2, 'CASTELLI'),
(25, 2, 'CHACABUCO'),
(26, 2, 'CHASCOMÚS'),
(27, 2, 'CHIVILCOY'),
(28, 2, 'COLÓN'),
(29, 2, 'CORONEL BRANDSEN'),
(30, 2, 'CORONEL DE MARINA L. ROSALES'),
(31, 2, 'CORONEL DORREGO'),
(32, 2, 'CORONEL PRINGLES'),
(33, 2, 'CORONEL SUÁREZ'),
(34, 2, 'DAIREAUX'),
(35, 2, 'DE LA COSTA'),
(36, 2, 'DOLORES'),
(37, 2, 'ENSENADA'),
(38, 2, 'ESCOBAR'),
(39, 2, 'ESTEBAN ECHEVERRIA'),
(40, 2, 'EXALTACIÓN DE LA CRUZ'),
(41, 2, 'EZEIZA'),
(42, 2, 'FLORENCIO VARELA'),
(43, 2, 'FLORENTINO AMEGHINO'),
(44, 2, 'GENERAL ALVARADO'),
(45, 2, 'GENERAL ALVEAR'),
(46, 2, 'GENERAL ARENALES'),
(47, 2, 'GENERAL BELGRANO'),
(48, 2, 'GENERAL GUIDO'),
(49, 2, 'GENERAL LAMADRID'),
(50, 2, 'GENERAL LAS HERAS'),
(60, 2, 'GENERAL LAVALLE'),
(61, 2, 'GENERAL MADARIAGA'),
(62, 2, 'GENERAL PAZ'),
(63, 2, 'GENERAL PINTO'),
(64, 2, 'GENERAL PUEYRREDÓN'),
(65, 2, 'GENERAL RODRIGUEZ'),
(66, 2, 'GENERAL SAN MARTIN'),
(67, 2, 'GENERAL VIAMONTE'),
(68, 2, 'GENERAL VILLEGAS'),
(69, 2, 'GUAMINÍ'),
(70, 2, 'HIPÓLITO YRIGOYEN'),
(71, 2, 'HURLINGHAM'),
(72, 2, 'ITUZAINGO'),
(73, 2, 'JOSE C. PAZ'),
(74, 2, 'JUNÍN'),
(75, 2, 'LA MATANZA'),
(76, 2, 'LA PLATA'),
(77, 2, 'LANUS'),
(78, 2, 'LAPRIDA'),
(79, 2, 'LAS FLORES'),
(80, 2, 'LEANDRO N. ALEM'),
(81, 2, 'LINCOLN'),
(82, 2, 'LOBERÍA'),
(83, 2, 'LOBOS'),
(84, 2, 'LOMAS DE ZAMORA'),
(85, 2, 'LUJAN'),
(86, 2, 'MAGDALENA'),
(87, 2, 'MAIPÚ'),
(88, 2, 'MALVINAS ARGENTINAS'),
(89, 2, 'MAR CHIQUITA'),
(90, 2, 'MARCOS PAZ'),
(91, 2, 'MERCEDES'),
(92, 2, 'MERLO '),
(93, 2, 'MONTE'),
(94, 2, 'MONTE HERMOSO'),
(95, 2, 'MORENO'),
(96, 2, 'MORÓN'),
(97, 2, 'NAVARRO'),
(98, 2, 'NECOCHEA'),
(99, 2, 'NUEVE DE JULIO'),
(100, 2, 'OLAVARRÍA'),
(101, 2, 'PATAGONES'),
(102, 2, 'PEHUAJO '),
(103, 2, 'PELLEGRINI'),
(104, 2, 'PERGAMINO'),
(105, 2, 'PILA'),
(106, 2, 'PILAR'),
(107, 2, 'PINAMAR'),
(108, 2, 'PRESIDENTE PERON'),
(109, 2, 'PUÁN'),
(110, 2, 'PUNTA INDIO'),
(111, 2, 'QUILMES'),
(112, 2, 'RAMALLO'),
(113, 2, 'RAUCH'),
(114, 2, 'RIVADAVIA'),
(115, 2, 'ROJAS'),
(116, 2, 'ROQUE PÉREZ'),
(117, 2, 'SAAVEDRA'),
(118, 2, 'SALADILLO'),
(119, 2, 'SALLIQUELÓ '),
(120, 2, 'SALTO'),
(121, 2, 'SAN ANDRES DE GILES'),
(122, 2, 'SAN ANTONIO DE ARECO'),
(123, 2, 'SAN CAYETANO'),
(124, 2, 'SAN FERNANDO'),
(125, 2, 'SAN ISIDRO'),
(126, 2, 'SAN MIGUEL'),
(127, 2, 'SAN NICOLÁS DE LOS ARROYOS'),
(128, 2, 'SAN PEDRO'),
(129, 2, 'SAN VICENTE'),
(130, 2, 'SUIPACHA'),
(131, 2, 'TANDIL'),
(132, 2, 'TAPALQUÉ'),
(134, 2, 'TIGRE'),
(135, 2, 'TORDILLO'),
(136, 2, 'TORNQUIST'),
(137, 2, 'TRENQUE LAUQUEN'),
(138, 2, 'TRES ARROYOS'),
(139, 2, 'TRES DE FEBRERO'),
(140, 2, 'TRES LOMAS'),
(141, 2, 'VEINTICINCO DE MAYO'),
(142, 2, 'VICENTE LOPEZ'),
(143, 2, 'VILLA GESELL'),
(144, 2, 'VILLARINO'),
(145, 2, 'ZÁRATE'),
(146, 3, 'ACONQUIJA'),
(147, 3, 'ANCASTI'),
(148, 3, 'ANDALGALÁ'),
(149, 3, 'ANTOFAGASTA DE LA SIERRA'),
(150, 3, 'BELÉN'),
(151, 3, 'CAPAYÁN'),
(152, 3, 'CORRAL QUEMADO'),
(153, 3, 'EL ALTO'),
(154, 3, 'EL RODEO'),
(155, 3, 'FIAMBALÁ'),
(156, 3, 'FRAY MAMERTO ESQUIÚ'),
(157, 3, 'HUALFÍN'),
(158, 3, 'HUILLAPIMA'),
(159, 3, 'ICAÑO'),
(160, 3, 'LA PUERTA'),
(161, 3, 'LAS JUNTAS'),
(162, 3, 'LONDRES'),
(163, 3, 'LOS ALTOS'),
(164, 3, 'LOS VARELA'),
(165, 3, 'MUTQUÍN'),
(166, 3, 'PACLÍN'),
(167, 3, 'POMÁN'),
(168, 3, 'POZO DE LA PIEDRA'),
(169, 3, 'PUERTA DE CORRAL QUEMADO'),
(170, 3, 'PUERTA DE SAN JOSÉ'),
(171, 3, 'RECREO'),
(172, 3, 'SAN FERNANDO'),
(173, 3, 'SAN FERNANDO DEL VALLE DE CATAMARCA'),
(174, 3, 'SAN JOSÉ'),
(175, 3, 'SANTA MARÍA'),
(176, 3, 'SANTA ROSA'),
(177, 3, 'SAUJIL'),
(178, 3, 'TAPSO'),
(179, 3, 'TINOGASTA'),
(180, 3, 'VALLE VIEJO'),
(181, 3, 'VILLA VIL'),
(182, 4, 'ALVEAR'),
(183, 4, 'BELLA VISTA'),
(184, 4, 'BERÓN DE ASTRADA'),
(185, 4, 'BONPLAND'),
(186, 4, 'CAÁ CATÍ'),
(187, 4, 'CHAVARRÍA'),
(188, 4, 'COLONIA CARLOS PELLEGRINI'),
(189, 4, 'COLONIA LIBERTAD'),
(190, 4, 'COLONIA LIEBIG'),
(191, 4, 'COLONIA SANTA ROSA'),
(192, 4, 'CONCEPCIÓN'),
(193, 4, 'CORRIENTES'),
(194, 4, 'CRUZ DE LOS MILAGROS'),
(195, 4, 'CURUZÚ CUATIÁ'),
(196, 4, 'EMPEDRADO'),
(197, 4, 'ESQUINA'),
(198, 4, 'ESTACIÓN TORRENT'),
(199, 4, 'FELIPE YOFRE'),
(200, 4, 'GARRUCHOS'),
(201, 4, 'GOBERNADOR AGRÓNOMO VALENTÍN VIRASORO'),
(202, 4, 'GOBERNADOR MARTÍNEZ'),
(203, 4, 'GOYA'),
(204, 4, 'GUAVIRAVÍ'),
(205, 4, 'HERLITZKA'),
(206, 4, 'ITÁ IBATÉ'),
(207, 4, 'ITATÍ'),
(208, 4, 'ITUZAINGÓ'),
(209, 4, 'JOSÉ RAFAEL GÓMEZ'),
(210, 4, 'JUAN PUJOL'),
(211, 4, 'LA CRUZ'),
(212, 4, 'LAVALLE'),
(213, 4, 'LOMAS DE VALLEJOS'),
(214, 4, 'LORETO'),
(215, 4, 'MARIANO I. LOZA'),
(216, 4, 'MBURUCUYÁ'),
(217, 4, 'MERCEDES'),
(218, 4, 'MOCORETÁ'),
(219, 4, 'MONTE CASEROS'),
(220, 4, 'NUEVE DE JULIO'),
(221, 4, 'PALMAR GRANDE'),
(222, 4, 'PARADA PUCHETA'),
(223, 4, 'PASO DE LA PATRIA'),
(224, 4, 'PASO DE LOS LIBRES'),
(225, 4, 'PEDRO R. FERNÁNDEZ'),
(226, 4, 'PERUGORRÍA'),
(227, 4, 'PUEBLO LIBERTADOR'),
(228, 4, 'RAMADA PASO'),
(229, 4, 'RIACHUELO'),
(230, 4, 'SALADAS'),
(231, 4, 'SAN ANTONIO'),
(232, 4, 'SAN CARLOS'),
(233, 4, 'SAN COSME'),
(234, 4, 'SAN LORENZO'),
(235, 4, 'SAN LUIS DEL PALMAR'),
(236, 4, 'SAN MIGUEL'),
(237, 4, 'SAN ROQUE'),
(238, 4, 'SANTA ANA'),
(239, 4, 'SANTA LUCÍA'),
(240, 4, 'SANTO TOMÉ'),
(241, 4, 'SAUCE'),
(242, 4, 'TABAY'),
(243, 4, 'TAPEBICUÁ'),
(244, 4, 'TATACUÁ'),
(245, 4, 'VILLA OLIVARI'),
(246, 4, 'YAPEYÚ'),
(247, 4, 'YATAYTÍ CALLE'),
(248, 5, 'AVIÁ TERAÍ'),
(249, 5, 'BARRANQUERAS'),
(250, 5, 'BASAIL'),
(251, 5, 'CAPITÁN SOLARI'),
(252, 5, 'CHARADAI'),
(253, 5, 'CHARATA'),
(254, 5, 'CHOROTIS'),
(255, 5, 'CIERVO PETISO'),
(256, 5, 'COLONIA BENÍTEZ'),
(257, 5, 'COLONIA ELISA'),
(258, 5, 'COLONIA POPULAR'),
(259, 5, 'COLONIAS UNIDAS'),
(260, 5, 'CONCEPCIÓN DEL BERMEJO'),
(261, 5, 'CORONEL DU GRATY'),
(262, 5, 'CORZUELA'),
(263, 5, 'COTE-LAI'),
(264, 5, 'EL SAUZALITO'),
(265, 5, 'ENRIQUE URIEN'),
(266, 5, 'FONTANA'),
(267, 5, 'FUERTE ESPERANZA'),
(268, 5, 'GANCEDO'),
(269, 5, 'GENERAL CAPDEVILA'),
(270, 5, 'GENERAL PINEDO'),
(271, 5, 'GENERAL SAN MARTÍN'),
(272, 5, 'GENERAL VEDIA'),
(273, 5, 'HERMOSO CAMPO'),
(274, 5, 'ISLA DEL CERRITO'),
(275, 5, 'JUAN JOSÉ CASTELLI'),
(276, 5, 'LA CLOTILDE'),
(277, 5, 'LA EDUVIGIS'),
(278, 5, 'LA ESCONDIDA'),
(279, 5, 'LA LEONESA'),
(280, 5, 'LA TIGRA'),
(281, 5, 'LA VERDE'),
(282, 5, 'LAGUNA BLANCA'),
(283, 5, 'LAGUNA LIMPIA'),
(284, 5, 'LAPACHITO'),
(285, 5, 'LAS BREÑAS'),
(286, 5, 'LAS GARCITAS'),
(287, 5, 'LAS PALMAS'),
(288, 5, 'LOS FRENTONES'),
(289, 5, 'MACHAGAI'),
(290, 5, 'MAKALLÉ'),
(291, 5, 'MARGARITA BELÉN'),
(292, 5, 'MIRAFLORES'),
(293, 5, 'MISIÓN NUEVA POMPEYA'),
(294, 5, 'NAPENAY'),
(295, 5, 'PAMPA ALMIRÓN'),
(296, 5, 'PAMPA DEL INDIO'),
(297, 5, 'PAMPA DEL INFIERNO'),
(298, 5, 'PRESIDENCIA DE LA PLAZA'),
(299, 5, 'PRESIDENCIA ROCA'),
(300, 5, 'PRESIDENCIA ROQUE SÁENZ PEÑA'),
(301, 5, 'PUERTO BERMEJO'),
(302, 5, 'PUERTO EVA PERÓN'),
(303, 5, 'PUERTO TIROL'),
(304, 5, 'PUERTO VILELAS'),
(305, 5, 'QUITILIPI'),
(306, 5, 'RESISTENCIA'),
(307, 5, 'SAMUHÚ'),
(308, 5, 'SAN BERNARDO'),
(309, 5, 'SANTA SYLVINA'),
(310, 5, 'TACO POZO'),
(311, 5, 'TRES ISLETAS'),
(312, 5, 'VILLA ÁNGELA'),
(313, 5, 'VILLA BERTHET'),
(314, 5, 'VILLA RÍO BERMEJITO'),
(315, 6, 'ALTO PELADO'),
(316, 6, 'ALTO PENCOSO'),
(317, 6, 'ANCHORENA'),
(318, 6, 'ARIZONA'),
(319, 6, 'BAGUAL'),
(320, 6, 'BALDE'),
(321, 6, 'BATAVIA'),
(322, 6, 'BEAZLEY'),
(323, 6, 'BUENA ESPERANZA'),
(324, 6, 'CANDELARIA'),
(325, 6, 'CAROLINA'),
(326, 6, 'CARPINTERÍA'),
(327, 6, 'CIUDAD DE LA PUNTA'),
(328, 6, 'CONCARÁN'),
(329, 6, 'CORTADERAS'),
(330, 6, 'EL MORRO'),
(331, 6, 'EL TRAPICHE'),
(332, 6, 'EL VOLCÁN'),
(333, 6, 'FORTÍN EL PATRIA'),
(334, 6, 'FORTUNA'),
(335, 6, 'FRAGA'),
(336, 6, 'JUAN JORBA'),
(337, 6, 'JUAN LLERENA'),
(338, 6, 'JUANA KOSLAY'),
(339, 6, 'JUSTO DARACT'),
(340, 6, 'LA CALERA'),
(341, 6, 'LA FLORIDA'),
(342, 6, 'LA PUNILLA'),
(343, 6, 'LA TOMA'),
(344, 6, 'LAFINUR'),
(345, 6, 'LAS AGUADAS'),
(346, 6, 'LAS CHACRAS'),
(347, 6, 'LAS LAGUNAS'),
(348, 6, 'LAS VERTIENTES'),
(349, 6, 'LAVAISSE'),
(350, 6, 'LEANDRO N. ALEM'),
(351, 6, 'LOS MOLLES'),
(352, 6, 'LUJÁN'),
(353, 6, 'MERLO'),
(354, 6, 'NASCHEL'),
(355, 6, 'NAVIA'),
(356, 6, 'NOGOLÍ'),
(357, 6, 'NUEVA GALIA'),
(358, 6, 'PAPAGAYOS'),
(359, 6, 'PASO GRANDE'),
(360, 6, 'POTRERO DE LOS FUNES'),
(361, 6, 'QUINES'),
(362, 6, 'RENCA'),
(363, 6, 'SALADILLO'),
(364, 6, 'SAN FRANCISCO DEL MONTE DE ORO'),
(365, 6, 'SAN GERÓNIMO'),
(366, 6, 'SAN LUIS'),
(367, 6, 'SAN MARTÍN'),
(368, 6, 'SAN PABLO'),
(369, 6, 'SANTA ROSA DE CONLARA'),
(370, 6, 'TALITA'),
(371, 6, 'TILISARAO'),
(372, 6, 'UNION'),
(373, 6, 'VILLA DE LA QUEBRADA'),
(374, 6, 'VILLA DE PRAGA'),
(375, 6, 'VILLA DEL CARMEN'),
(376, 6, 'VILLA GENERAL ROCA'),
(377, 6, 'VILLA LARCA'),
(378, 6, 'VILLA MERCEDES'),
(379, 6, 'ZANJITAS'),
(380, 7, 'RÍO GRANDE'),
(381, 7, 'TOLHUIN'),
(382, 7, 'USHUAIA'),
(383, 8, 'AGUARAY'),
(384, 8, 'ANGASTACO'),
(385, 8, 'ANIMANÁ'),
(386, 8, 'APOLINARIO SARAVIA'),
(387, 8, 'CACHI'),
(388, 8, 'CAFAYATE'),
(389, 8, 'CAMPO QUIJANO'),
(390, 8, 'CAMPO SANTO'),
(391, 8, 'CERRILLOS'),
(392, 8, 'CHICOANA'),
(393, 8, 'COLONIA SANTA ROSA'),
(394, 8, 'CORONEL MOLDES'),
(395, 8, 'EL BORDO'),
(396, 8, 'EL CARRIL'),
(397, 8, 'EL GALPÓN'),
(398, 8, 'EL JARDÍN'),
(399, 8, 'EL POTRERO'),
(400, 8, 'EL QUEBRACHAL'),
(401, 8, 'EL TALA'),
(402, 8, 'EMBARCACIÓN'),
(403, 8, 'GENERAL BALLIVIÁN'),
(404, 8, 'GENERAL GÜEMES'),
(405, 8, 'GENERAL MOSCONI'),
(406, 8, 'GENERAL PIZARRO'),
(407, 8, 'GUACHIPAS'),
(408, 8, 'HIPÓLITO YRIGOYEN'),
(409, 8, 'IRUYA'),
(410, 8, 'ISLA DE CAÑAS'),
(411, 8, 'JOAQUÍN V. GONZÁLEZ'),
(412, 8, 'LA CALDERA'),
(413, 8, 'LA CANDELARIA'),
(414, 8, 'LA MERCED'),
(415, 8, 'LA POMA'),
(416, 8, 'LA VIÑA'),
(417, 8, 'LAS LAJITAS'),
(418, 8, 'LOS TOLDOS'),
(419, 8, 'MOLINOS'),
(420, 8, 'NAZARENO'),
(421, 8, 'PAYOGASTA'),
(422, 8, 'PICHANAL'),
(423, 8, 'PROFESOR SALVADOR MAZZA'),
(424, 8, 'RÍO PIEDRAS'),
(425, 8, 'RIVADAVIA BANDA NORTE'),
(426, 8, 'RIVADAVIA BANDA SUR'),
(427, 8, 'ROSARIO DE LA FRONTERA'),
(428, 8, 'ROSARIO DE LERMA'),
(429, 8, 'SALTA'),
(430, 8, 'SAN ANTONIO DE LOS COBRES'),
(431, 8, 'SAN CARLOS'),
(432, 8, 'SAN JOSÉ DE METÁN'),
(433, 8, 'SAN RAMÓN DE LA NUEVA ORÁN'),
(434, 8, 'SANTA VICTORIA ESTE'),
(435, 8, 'SANTA VICTORIA OESTE'),
(436, 8, 'SECLANTÁS'),
(437, 8, 'TARTAGAL'),
(438, 8, 'TOLAR GRANDE'),
(439, 8, 'URUNDEL'),
(440, 8, 'VAQUEROS'),
(441, 8, 'VILLA SAN LORENZO'),
(442, 9, 'ALARCÓN'),
(443, 9, 'ALCARAZ NORTE'),
(444, 9, 'ALCARAZ SUR'),
(445, 9, 'ALDEA ASUNCIÓN'),
(446, 9, 'ALDEA BRASILERA'),
(447, 9, 'ALDEA EIGENFELD'),
(448, 9, 'ALDEA GRAPSCHENTAL'),
(449, 9, 'ALDEA MARÍA LUISA'),
(450, 9, 'ALDEA PROTESTANTE'),
(451, 9, 'ALDEA SALTO'),
(452, 9, 'ALDEA SAN ANTONIO (G)'),
(453, 9, 'ALDEA SAN ANTONIO (P)'),
(454, 9, 'ALDEA SAN JUAN'),
(455, 9, 'ALDEA SAN MIGUEL'),
(456, 9, 'ALDEA SAN RAFAEL'),
(457, 9, 'ALDEA SANTA MARÍA'),
(458, 9, 'ALDEA SANTA ROSA'),
(459, 9, 'ALDEA SPATZENKUTTER'),
(460, 9, 'ALDEA VALLE MARÍA'),
(461, 9, 'ALEJANDRO ROCA'),
(462, 9, 'ALTAMIRANO SUR'),
(463, 9, 'ANTELO'),
(464, 9, 'ANTONIO TOMÁS'),
(465, 9, 'ARANGUREN'),
(466, 9, 'ARROYO BARÚ'),
(467, 9, 'ARROYO BURGOS'),
(468, 9, 'ARROYO CLÉ'),
(469, 9, 'ARROYO CORRALITO'),
(470, 9, 'ARROYO DEL MEDIO'),
(471, 9, 'ARROYO MATURRANGO'),
(472, 9, 'ARROYO PALO SECO'),
(473, 9, 'BANDERAS'),
(474, 9, 'BASAVILBASO'),
(475, 9, 'BETBEDER'),
(476, 9, 'BOVRIL'),
(477, 9, 'CASEROS'),
(478, 9, 'CEIBAS'),
(479, 9, 'CERRITO'),
(480, 9, 'CHAJARÍ'),
(481, 9, 'CHILCAS'),
(482, 9, 'CLODOMIRO LEDESMA'),
(483, 9, 'COLÓN'),
(484, 9, 'COLONIA ALEMANA'),
(485, 9, 'COLONIA AVELLANEDA'),
(486, 9, 'COLONIA AVIGDOR'),
(487, 9, 'COLONIA AYUÍ'),
(488, 9, 'COLONIA BAYLINA'),
(489, 9, 'COLONIA CARRASCO'),
(490, 9, 'COLONIA CELINA'),
(491, 9, 'COLONIA CERRITO'),
(492, 9, 'COLONIA CRESPO'),
(493, 9, 'COLONIA ELÍA'),
(494, 9, 'COLONIA ENSAYO'),
(495, 9, 'COLONIA GENERAL ROCA'),
(496, 9, 'COLONIA LA ARGENTINA'),
(497, 9, 'COLONIA MEROU'),
(498, 9, 'COLONIA OFICIAL N° 13'),
(499, 9, 'COLONIA OFICIAL N° 3 Y 14'),
(500, 9, 'COLONIA OFICIAL N°5'),
(501, 9, 'COLONIA REFFINO'),
(502, 9, 'COLONIA TUNAS'),
(503, 9, 'COLONIA VIRARÓ'),
(504, 9, 'CONCEPCIÓN DEL URUGUAY'),
(505, 9, 'CONCORDIA'),
(506, 9, 'CONSCRIPTO BERNARDI'),
(507, 9, 'COSTA GRANDE'),
(508, 9, 'COSTA SAN ANTONIO'),
(509, 9, 'COSTA URUGUAY NORTE'),
(510, 9, 'COSTA URUGUAY SUR'),
(511, 9, 'CRESPO'),
(512, 9, 'CRUCESITAS OCTAVA'),
(513, 9, 'CRUCESITAS SÉPTIMA'),
(514, 9, 'CRUCESITAS TERCERA'),
(515, 9, 'CUCHILLA REDONDA'),
(516, 9, 'CURTIEMBRE'),
(517, 9, 'DIAMANTE'),
(518, 9, 'DISTRITO CHAÑAR'),
(519, 9, 'DISTRITO CHIQUEROS'),
(520, 9, 'DISTRITO CUARTO'),
(521, 9, 'DISTRITO DIEGO LÓPEZ'),
(522, 9, 'DISTRITO PAJONAL'),
(523, 9, 'DISTRITO SAUCE'),
(524, 9, 'DISTRITO SEXTO COSTA DE NOGOYÁ'),
(525, 9, 'DISTRITO TALA'),
(526, 9, 'DISTRITO TALITAS'),
(527, 9, 'DON CRISTÓBAL PRIMERO'),
(528, 9, 'DON CRISTÓBAL SEGUNDO'),
(529, 9, 'DURAZNO'),
(530, 9, 'EL CIMARRÓN'),
(531, 9, 'EL GRAMIYAL'),
(532, 9, 'EL PALENQUE'),
(533, 9, 'EL PINGO'),
(534, 9, 'EL QUEBRACHO'),
(535, 9, 'EL REDOMÓN'),
(536, 9, 'EL SOLAR'),
(537, 9, 'ENRIQUE CARBÓ'),
(538, 9, 'ESPINILLO NORTE'),
(539, 9, 'ESTACIÓN CAMPS'),
(540, 9, 'ESTACIÓN ESCRIÑA'),
(541, 9, 'ESTACIÓN LAZO'),
(542, 9, 'ESTACIÓN RAÍCES'),
(543, 9, 'ESTACIÓN YERÚA'),
(544, 9, 'ESTANCIA GRANDE'),
(545, 9, 'ESTANCIA LÍBAROS'),
(546, 9, 'ESTANCIA RACEDO (EL CARMEN)'),
(547, 9, 'ESTANCIA SOLA'),
(548, 9, 'ESTANCIÓN YUQUERÍ'),
(549, 9, 'ESTAQUITAS'),
(550, 9, 'FAUSTINO M. PARERA'),
(551, 9, 'FEBRE'),
(552, 9, 'FEDERACIÓN'),
(553, 9, 'FEDERAL'),
(554, 9, 'GENERAL ALMADA'),
(555, 9, 'GENERAL ALVEAR'),
(556, 9, 'GENERAL CAMPOS'),
(557, 9, 'GENERAL GALARZA'),
(558, 9, 'GENERAL RAMÍREZ'),
(559, 9, 'GILBERT'),
(560, 9, 'GOBERNADOR ECHAGÜE'),
(561, 9, 'GOBERNADOR MANSILLA'),
(562, 9, 'GONZÁLEZ CALDERÓN'),
(563, 9, 'GUALEGUAY'),
(564, 9, 'GUALEGUAYCHÚ'),
(565, 9, 'GUALEGUAYCITO'),
(566, 9, 'GUARDAMONTE'),
(567, 9, 'HAMBIS'),
(568, 9, 'HASENKAMP'),
(569, 9, 'HERNANDARIAS'),
(570, 9, 'HERNÁNDEZ'),
(571, 9, 'HERRERA'),
(572, 9, 'HINOJAL'),
(573, 9, 'HOCKER'),
(574, 9, 'INGENIERO SAJAROFF'),
(575, 9, 'IRAZUSTA'),
(576, 9, 'ISLETAS'),
(577, 9, 'JUBILEO'),
(578, 9, 'JUSTO JOSÉ DE URQUIZA'),
(579, 9, 'LA CLARITA'),
(580, 9, 'LA CRIOLLA'),
(581, 9, 'LA ESMERALDA'),
(582, 9, 'LA FLORIDA'),
(583, 9, 'LA FRATERNIDAD Y SANTA JUANA'),
(584, 9, 'LA HIERRA'),
(585, 9, 'LA OLLITA'),
(586, 9, 'LA PICADA'),
(587, 9, 'LA PROVIDENCIA'),
(588, 9, 'LA VERBENA'),
(589, 9, 'LAGUNA BENÍTEZ'),
(590, 9, 'LARROQUE'),
(591, 9, 'LAS CUEVAS'),
(592, 9, 'LAS GARZAS (P. BELLOCQ)'),
(593, 9, 'LAS GUACHAS'),
(594, 9, 'LAS MERCEDES'),
(595, 9, 'LAS MOSCAS'),
(596, 9, 'LAS MULITAS'),
(597, 9, 'LAS TOSCAS'),
(598, 9, 'LAURENCENA'),
(599, 9, 'LIBERTADOR SAN MARTÍN'),
(600, 9, 'LOMA LIMPIA'),
(601, 9, 'LOS CEIBOS'),
(602, 9, 'LOS CHARRÚAS'),
(603, 9, 'LOS CONQUISTADORES'),
(604, 9, 'LUCAS GONZÁLEZ'),
(605, 9, 'LUCAS NORTE'),
(606, 9, 'LUCAS SUR PRIMERA'),
(607, 9, 'LUCAS SUR SEGUNDO'),
(608, 9, 'MACIÁ'),
(609, 9, 'MARÍA GRANDE'),
(610, 9, 'MARÍA GRANDE SEGUNDA'),
(611, 9, 'MÉDANOS'),
(612, 9, 'MOJONES NORTE'),
(613, 9, 'MOJONES SUR'),
(614, 9, 'MOLINO DOLL'),
(615, 9, 'MONTE REDONDO'),
(616, 9, 'MONTOYA'),
(617, 9, 'MULAS GRANDES'),
(618, 9, 'NOGOYÁ'),
(619, 9, 'NUEVA ESCOCIA'),
(620, 9, 'NUEVA VIZCAYA'),
(621, 9, 'ÑANCAY'),
(622, 9, 'OMBÚ'),
(623, 9, 'ORO VERDE'),
(624, 9, 'PARAJE LAS TUNAS'),
(625, 9, 'PARANÁ'),
(626, 9, 'PASAJE GUAYAQUIL'),
(627, 9, 'PASO DE LA ARENA'),
(628, 9, 'PASO DE LA LAGUNA'),
(629, 9, 'PASO DE LAS PIEDRAS'),
(630, 9, 'PASO DUARTE'),
(631, 9, 'PASTOR BRITOS'),
(632, 9, 'PEDERNAL'),
(633, 9, 'PERDICES'),
(634, 9, 'PICADA BERÓN'),
(635, 9, 'PIEDRAS BLANCAS'),
(636, 9, 'PRIMER DISTRITO CUCHILLA'),
(637, 9, 'PRIMERO DE MAYO'),
(638, 9, 'PRONUNCIAMIENTO'),
(639, 9, 'PUEBLO BRUGO'),
(640, 9, 'PUEBLO CAZES'),
(641, 9, 'PUEBLO GENERAL BELGRANO'),
(642, 9, 'PUEBLO LIEBIG'),
(643, 9, 'PUERTO ALGARROBO'),
(644, 9, 'PUERTO IBICUY'),
(645, 9, 'PUERTO YERUÁ'),
(646, 9, 'PUNTA DEL MONTE'),
(647, 9, 'QUEBRACHO'),
(648, 9, 'QUINTO DISTRITO'),
(649, 9, 'RAÍCES OESTE'),
(650, 9, 'RINCÓN DE NOGOYÁ'),
(651, 9, 'RINCÓN DEL CINTO'),
(652, 9, 'RINCÓN DEL DOLL'),
(653, 9, 'RINCÓN DEL GATO'),
(654, 9, 'ROCAMORA'),
(655, 9, 'ROSARIO DEL TALA'),
(656, 9, 'SAN BENITO'),
(657, 9, 'SAN CIPRIANO'),
(658, 9, 'SAN ERNESTO'),
(659, 9, 'SAN GUSTAVO'),
(660, 9, 'SAN JAIME'),
(661, 9, 'SAN JOSÉ'),
(662, 9, 'SAN JOSÉ DE FELICIANO'),
(663, 9, 'SAN JUSTO'),
(664, 9, 'SAN JUSTO (U)'),
(665, 9, 'SAN MARCIAL'),
(666, 9, 'SAN PEDRO'),
(667, 9, 'SAN RAMÍREZ'),
(668, 9, 'SAN RAMÓN'),
(669, 9, 'SAN ROQUE'),
(670, 9, 'SAN SALVADOR'),
(671, 9, 'SAN VÍCTOR'),
(672, 9, 'SANTA ANA'),
(673, 9, 'SANTA ANA (F)'),
(674, 9, 'SANTA ANITA'),
(675, 9, 'SANTA ELENA'),
(676, 9, 'SANTA LUCÍA'),
(677, 9, 'SANTA LUISA'),
(678, 9, 'SAUCE DE LUNA'),
(679, 9, 'SAUCE MONTRULL'),
(680, 9, 'SAUCE PINTOS'),
(681, 9, 'SAUCE SUR'),
(682, 9, 'SEGUÍ'),
(683, 9, 'SIR LEONARD'),
(684, 9, 'SOSA'),
(685, 9, 'TABOSSI'),
(686, 9, 'TEZANOS PINTOS'),
(687, 9, 'UBAJAY'),
(688, 9, 'URDINARRAIN'),
(689, 9, 'VEINTE DE SETIEMBRE'),
(690, 9, 'VIALE'),
(691, 9, 'VICTORIA'),
(692, 9, 'VILLA CLARA'),
(693, 9, 'VILLA DEL ROSARIO'),
(694, 9, 'VILLA DOMÍNGUEZ'),
(695, 9, 'VILLA ELISA'),
(696, 9, 'VILLA FONTANA'),
(697, 9, 'VILLA GOBERNADOR ETCHEVEHERE'),
(698, 9, 'VILLA MANTERO'),
(699, 9, 'VILLA PARANACITO'),
(700, 9, 'VILLA URQUIZA'),
(701, 9, 'VILLAGUAY'),
(702, 9, 'WALTER MOSS'),
(703, 9, 'YACARÉ'),
(704, 9, 'YESO OESTE'),
(705, 10, 'ARAUCO'),
(706, 10, 'CASTRO BARROS'),
(707, 10, 'CHAMICAL'),
(708, 10, 'CHILECITO'),
(709, 10, 'CORONEL FELIPE VARELA'),
(710, 10, 'FAMATINA'),
(711, 10, 'GENERAL ÁNGEL VICENTE PEÑALOZA'),
(712, 10, 'GENERAL BELGRANO'),
(713, 10, 'GENERAL JUAN FACUNDO QUIROGA'),
(714, 10, 'GENERAL LAMADRID'),
(715, 10, 'GENERAL OCAMPO'),
(716, 10, 'GENERAL SAN MARTÍN'),
(717, 10, 'INDEPENDENCIA'),
(718, 10, 'LA RIOJA'),
(719, 10, 'ROSARIO VERA PEÑALOZA'),
(720, 10, 'SAN BLAS DE LOS SAUCES'),
(721, 10, 'SANAGASTA'),
(722, 10, 'VINCHINA'),
(723, 11, 'ANTAJE'),
(724, 11, 'AÑATUYA'),
(725, 11, 'ARDILES'),
(726, 11, 'ARGENTINA'),
(727, 11, 'ÁRRAGA'),
(728, 11, 'AVERÍAS'),
(729, 11, 'BANDERA'),
(730, 11, 'BANDERA BAJADA'),
(731, 11, 'BELTRÁN'),
(732, 11, 'BREA POZO'),
(733, 11, 'CAMPO GALLO'),
(734, 11, 'CAÑADA ESCOBAR'),
(735, 11, 'CASARES'),
(736, 11, 'CHAUPI POZO'),
(737, 11, 'CHILCA JULIANA'),
(738, 11, 'CHOYA'),
(739, 11, 'CLODOMIRA'),
(740, 11, 'COLONIA ALPINA'),
(741, 11, 'COLONIA DORA'),
(742, 11, 'COLONIA EL SIMBOLAR'),
(743, 11, 'COLONIA SAN JUAN'),
(744, 11, 'COLONIA TINCO'),
(745, 11, 'CUATRO BOCAS'),
(746, 11, 'DONADEU'),
(747, 11, 'DOÑA LUISA'),
(748, 11, 'EL ARENAL'),
(749, 11, 'EL BOBADAL'),
(750, 11, 'EL CABURE'),
(751, 11, 'EL CHARCO'),
(752, 11, 'EL COLORADO'),
(753, 11, 'EL CUADRADO'),
(754, 11, 'EL MOJÓN'),
(755, 11, 'ESTACIÓN ATAMISQUI'),
(756, 11, 'ESTACIÓN ROBLES'),
(757, 11, 'ESTACIÓN SIMBOLAR'),
(758, 11, 'FERNÁNDEZ'),
(759, 11, 'FORTÍN INCA'),
(760, 11, 'FRÍAS'),
(761, 11, 'GARZA'),
(762, 11, 'GRAMILLA'),
(763, 11, 'GUAMPACHA'),
(764, 11, 'GUARDIA ESCOLTA'),
(765, 11, 'HERRERA'),
(766, 11, 'ICAÑO'),
(767, 11, 'INGENIERO FORRES'),
(768, 11, 'LA AURORA'),
(769, 11, 'LA BANDA'),
(770, 11, 'LA CAÑADA'),
(771, 11, 'LA DÁRSENA'),
(772, 11, 'LA INVERNADA'),
(773, 11, 'LAPRIDA'),
(774, 11, 'LAS DELICIAS'),
(775, 11, 'LAS TINAJAS'),
(776, 11, 'LAVALLE'),
(777, 11, 'LORETO'),
(778, 11, 'LOS JURÍES'),
(779, 11, 'LOS NUÑEZ'),
(780, 11, 'LOS PIRPINTOS'),
(781, 11, 'LOS QUIROGA'),
(782, 11, 'LOS TELARES'),
(783, 11, 'LUGONES'),
(784, 11, 'MALBRÁN'),
(785, 11, 'MANOGASTA'),
(786, 11, 'MATARÁ'),
(787, 11, 'MEDELLÍN'),
(788, 11, 'MONTE QUEMADO'),
(789, 11, 'NUEVA ESPERANZA'),
(790, 11, 'NUEVA FRANCIA'),
(791, 11, 'OTUMPA'),
(792, 11, 'PALO NEGRO'),
(793, 11, 'PAMPA DE LOS GUANACOS'),
(794, 11, 'PATAY'),
(795, 11, 'PINTO'),
(796, 11, 'POZO BETBEDER'),
(797, 11, 'POZO DEL TOBA'),
(798, 11, 'POZO HONDO'),
(799, 11, 'POZUELOS'),
(800, 11, 'QUEBRACHO COTO'),
(801, 11, 'QUIMILÍ'),
(802, 11, 'RAMÍREZ DE VELAZCO'),
(803, 11, 'RAPELLI'),
(804, 11, 'REAL SAYANA'),
(805, 11, 'SABAGASTA'),
(806, 11, 'SACHAYOJ'),
(807, 11, 'SAN JOSÉ DEL BOQUERÓN'),
(808, 11, 'SAN PEDRO'),
(809, 11, 'SAN PEDRO DE GUASAYÁN'),
(810, 11, 'SANTIAGO DEL ESTERO'),
(811, 11, 'SANTOS LUGARES'),
(812, 11, 'SELVA'),
(813, 11, 'SOL DE JULIO'),
(814, 11, 'SUMAMPA'),
(815, 11, 'SUNCHO CORRAL'),
(816, 11, 'TABOADA'),
(817, 11, 'TACAÑITAS'),
(818, 11, 'TAPSO'),
(819, 11, 'TERMAS DE RÍO HONDO'),
(820, 11, 'TINTINA'),
(821, 11, 'TOMÁS YOUNG'),
(822, 11, 'VILELAS'),
(823, 11, 'VILLA ATAMISQUI'),
(824, 11, 'VILLA FIGUEROA'),
(825, 11, 'VILLA GUASAYÁN'),
(826, 11, 'VILLA LA PUNTA'),
(827, 11, 'VILLA MAILIN'),
(828, 11, 'VILLA MATOQUE'),
(829, 11, 'VILLA OJO DE AGUA'),
(830, 11, 'VILLA RÍO HONDO'),
(831, 11, 'VILLA ROBLES'),
(832, 11, 'VILLA SALAVINA'),
(833, 11, 'VILLA SILÍPICA'),
(834, 11, 'VILLA UNION'),
(835, 11, 'VILLA ZANJÓN'),
(836, 11, 'VILMER'),
(837, 11, 'VINARA'),
(838, 11, 'WEISBURD'),
(839, 12, 'ALBARDÓN'),
(840, 12, 'ANGACO'),
(841, 12, 'CALINGASTA'),
(842, 12, 'CAUCETE'),
(843, 12, 'CHIMBAS'),
(844, 12, 'IGLESIA'),
(845, 12, 'JÁCHAL'),
(846, 12, 'NUEVE DE JULIO'),
(847, 12, 'POCITO'),
(848, 12, 'RAWSON'),
(849, 12, 'RIVADAVIA'),
(850, 12, 'SAN JUAN'),
(851, 12, 'SAN MARTÍN'),
(852, 12, 'SANTA LUCÍA'),
(853, 12, 'SARMIENTO'),
(854, 12, 'ULLUM'),
(855, 12, 'VALLE FÉRTIL'),
(856, 12, 'VEINTICINCO DE MAYO'),
(857, 12, 'ZONDA'),
(858, 13, 'ABRAMO'),
(859, 13, 'ADOLFO VAN PRAET'),
(860, 13, 'AGUSTONI'),
(861, 13, 'ALGARROBO DEL ÁGUILA'),
(862, 13, 'ALPACHIRI'),
(863, 13, 'ALTA ITALIA'),
(864, 13, 'ANGUIL'),
(865, 13, 'ARATA'),
(866, 13, 'ATALIVA ROCA'),
(867, 13, 'BERNARDO LARROUDÉ'),
(868, 13, 'BERNASCONI'),
(869, 13, 'CALEUFÚ'),
(870, 13, 'CARRO QUEMADO'),
(871, 13, 'CATRILÓ'),
(872, 13, 'CEBALLOS'),
(873, 13, 'CHACHARRAMENDI'),
(874, 13, 'COLONIA BARÓN'),
(875, 13, 'COLONIA SANTA MARÍA'),
(876, 13, 'CONHELLO'),
(877, 13, 'CORONEL HILARIO LAGOS'),
(878, 13, 'CUCHILLO-CO'),
(879, 13, 'DOBLAS'),
(880, 13, 'DORILA'),
(881, 13, 'EDUARDO CASTEX'),
(882, 13, 'EMBAJADOR MARTINI'),
(883, 13, 'FALUCHO'),
(884, 13, 'GENERAL ACHA'),
(885, 13, 'GENERAL MANUEL CAMPOS'),
(886, 13, 'GENERAL PICO'),
(887, 13, 'GENERAL SAN MARTÍN'),
(888, 13, 'GOBERNADOR DUVAL'),
(889, 13, 'GUATRACHÉ'),
(890, 13, 'INGENIERO LUIGGI'),
(891, 13, 'INTENDENTE ALVEAR'),
(892, 13, 'JACINTO ARÁUZ'),
(893, 13, 'LA ADELA'),
(894, 13, 'LA HUMADA'),
(895, 13, 'LA MARUJA'),
(896, 13, 'LA REFORMA'),
(897, 13, 'LIMAY MAHUIDA'),
(898, 13, 'LONQUIMAY'),
(899, 13, 'LOVENTUEL'),
(900, 13, 'LUAN TORO'),
(901, 13, 'MACACHÍN'),
(902, 13, 'MAISONNAVE'),
(903, 13, 'MAURICIO MAYER'),
(904, 13, 'METILEO'),
(905, 13, 'MIGUEL CANÉ'),
(906, 13, 'MIGUEL RIGLOS'),
(907, 13, 'MONTE NIEVAS'),
(908, 13, 'PARERA'),
(909, 13, 'PERÚ'),
(910, 13, 'PICHI HUINCA'),
(911, 13, 'PUELCHES'),
(912, 13, 'PUELÉN'),
(913, 13, 'QUEHUE'),
(914, 13, 'QUEMÚ QUEMÚ'),
(915, 13, 'QUETREQUÉN'),
(916, 13, 'RANCUL'),
(917, 13, 'REALICÓ'),
(918, 13, 'RELMO'),
(919, 13, 'ROLÓN'),
(920, 13, 'RUCANELO'),
(921, 13, 'SANTA ISABEL'),
(922, 13, 'SANTA ROSA'),
(923, 13, 'SANTA TERESA'),
(924, 13, 'SARAH'),
(925, 13, 'SPELUZZI'),
(926, 13, 'TELÉN'),
(927, 13, 'TOAY'),
(928, 13, 'TOMÁS MANUEL DE ANCHORENA'),
(929, 13, 'TRENEL'),
(930, 13, 'UNANUÉ'),
(931, 13, 'URIBURU'),
(932, 13, 'VEINTICINCO DE MAYO'),
(933, 13, 'VÉRTIZ'),
(934, 13, 'VICTORICA'),
(935, 13, 'VILLA MIRASOL'),
(936, 13, 'WINIFREDA'),
(937, 14, 'GENERAL ALVEAR'),
(938, 14, 'GODOY CRUZ'),
(939, 14, 'GUAYMALLÉN'),
(940, 14, 'JUNÍN'),
(941, 14, 'LA PAZ'),
(942, 14, 'LAS HERAS'),
(943, 14, 'LAVALLE'),
(944, 14, 'LUJÁN DE CUYO'),
(945, 14, 'MAIPÚ'),
(946, 14, 'MALARGÜE'),
(947, 14, 'MENDOZA'),
(948, 14, 'RIVADAVIA'),
(949, 14, 'SAN CARLOS'),
(950, 14, 'SAN MARTÍN'),
(951, 14, 'SAN RAFAEL'),
(952, 14, 'SANTA ROSA'),
(953, 14, 'TUNUYÁN'),
(954, 14, 'TUPUNGATO'),
(955, 15, 'ALBA POSSE'),
(956, 15, 'ALMAFUERTE'),
(957, 15, 'APÓSTOLES'),
(958, 15, 'ARISTÓBULO DEL VALLE'),
(959, 15, 'ARROYO DEL MEDIO'),
(960, 15, 'AZARA'),
(961, 15, 'BERNARDO DE IRIGOYEN'),
(962, 15, 'BONPLAND'),
(963, 15, 'CAÁ YARI'),
(964, 15, 'CAMPO GRANDE'),
(965, 15, 'CAMPO RAMÓN'),
(966, 15, 'CAMPO VIERA'),
(967, 15, 'CANDELARIA'),
(968, 15, 'CAPIOVÍ'),
(969, 15, 'CARAGUATAY'),
(970, 15, 'CERRO AZUL'),
(971, 15, 'CERRO CORÁ'),
(972, 15, 'COLONIA ALBERDI'),
(973, 15, 'COLONIA AURORA'),
(974, 15, 'COLONIA DELICIA'),
(975, 15, 'COLONIA POLANA'),
(976, 15, 'COLONIA VICTORIA'),
(977, 15, 'COLONIA WANDA'),
(978, 15, 'COMANDANTE ANDRÉS GUACURARI'),
(979, 15, 'CONCEPCIÓN DE LA SIERRA'),
(980, 15, 'CORPUS'),
(981, 15, 'DOS ARROYOS'),
(982, 15, 'DOS DE MAYO'),
(983, 15, 'EL ALCÁZAR'),
(984, 15, 'EL SOBERBIO'),
(985, 15, 'ELDORADO'),
(986, 15, 'ESPERANZA'),
(987, 15, 'FACHINAL'),
(988, 15, 'FLORENTINO AMEGHINO'),
(989, 15, 'GARUHAPÉ'),
(990, 15, 'GARUPÁ'),
(991, 15, 'GENERAL ALVEAR'),
(992, 15, 'GENERAL URQUIZA'),
(993, 15, 'GOBERNADOR LÓPEZ'),
(994, 15, 'GOBERNADOR ROCA'),
(995, 15, 'GUARANÍ'),
(996, 15, 'HIPÓLITO YRIGOYEN'),
(997, 15, 'ITACARUARÉ'),
(998, 15, 'JARDÍN AMÉRICA'),
(999, 15, 'LEANDRO N. ALEM'),
(1000, 15, 'LORETO'),
(1001, 15, 'LOS HELECHOS'),
(1002, 15, 'MÁRTIRES'),
(1003, 15, 'MOJÓN GRANDE'),
(1004, 15, 'MONTECARLO'),
(1005, 15, 'NUEVE DE JULIO'),
(1006, 15, 'OBERÁ'),
(1007, 15, 'OLEGARIO VÍCTOR ANDRADE'),
(1008, 15, 'PANAMBÍ'),
(1009, 15, 'POSADAS'),
(1010, 15, 'PROFUNDIDAD'),
(1011, 15, 'PUERTO IGUAZÚ'),
(1012, 15, 'PUERTO LEONI'),
(1013, 15, 'PUERTO LIBERTAD'),
(1014, 15, 'PUERTO PIRAY'),
(1015, 15, 'PUERTO RICO'),
(1016, 15, 'RUIZ DE MONTOYA'),
(1017, 15, 'SAN ANTONIO'),
(1018, 15, 'SAN IGNACIO'),
(1019, 15, 'SAN JAVIER'),
(1020, 15, 'SAN JOSÉ'),
(1021, 15, 'SAN MARTÍN'),
(1022, 15, 'SAN PEDRO'),
(1023, 15, 'SAN VICENTE'),
(1024, 15, 'SANTA ANA'),
(1025, 15, 'SANTA MARÍA'),
(1026, 15, 'SANTIAGO DE LINIERS'),
(1027, 15, 'SANTO PIPÓ'),
(1028, 15, 'TRES CAPONES'),
(1029, 15, 'VEINTICINCO DE MAYO'),
(1030, 16, 'BUENA VISTA'),
(1031, 16, 'CLORINDA'),
(1032, 16, 'COLONIA PASTORIL'),
(1033, 16, 'COMANDANTE FONTANA'),
(1034, 16, 'EL COLORADO'),
(1035, 16, 'EL ESPINILLO'),
(1036, 16, 'ESTANISLAO DEL CAMPO'),
(1037, 16, 'FORMOSA'),
(1038, 16, 'FORTÍN LUGONES'),
(1039, 16, 'GENERAL LUCIO V. MANSILLA'),
(1040, 16, 'GENERAL MANUEL BELGRANO'),
(1041, 16, 'GENERAL MOSCONI'),
(1042, 16, 'GRAN GUARDIA'),
(1043, 16, 'HERRADURA'),
(1044, 16, 'IBARRETA'),
(1045, 16, 'INGENIERO JUÁREZ'),
(1046, 16, 'LAGUNA BLANCA'),
(1047, 16, 'LAGUNA NAI NECK'),
(1048, 16, 'LAGUNA YEMA'),
(1049, 16, 'LAS LOMITAS'),
(1050, 16, 'LOS CHIRIGUANOS'),
(1051, 16, 'MAYOR VICENTE VILLAFAÑE'),
(1052, 16, 'MISIÓN SAN FRANCISCO DE LAISHI'),
(1053, 16, 'MISIÓN TACAAGLÉ'),
(1054, 16, 'PALO SANTO'),
(1055, 16, 'PIRANÉ'),
(1056, 16, 'POZO DE MAZA'),
(1057, 16, 'POZO DEL TIGRE'),
(1058, 16, 'RIACHO HE-HÉ'),
(1059, 16, 'SAN HILARIO'),
(1060, 16, 'SAN MARTÍN 2'),
(1061, 16, 'SIETE PALMAS'),
(1062, 16, 'SUBTENIENTE PERÍN'),
(1063, 16, 'TRES LAGUNAS'),
(1064, 16, 'VILLA DOS TRECE'),
(1065, 16, 'VILLA ESCOLAR'),
(1066, 16, 'VILLA GENERAL GÜEMES'),
(1067, 17, 'AGUADA SAN ROQUE'),
(1068, 17, 'ALUMINÉ'),
(1069, 17, 'ANDACOLLO'),
(1070, 17, 'AÑELO'),
(1071, 17, 'BAJADA DEL AGRIO'),
(1072, 17, 'BARRANCAS'),
(1073, 17, 'BUTA RANQUIL'),
(1074, 17, 'CAVIAHUE-COPAHUE'),
(1075, 17, 'CENTENARIO'),
(1076, 17, 'CHORRIACA'),
(1077, 17, 'CHOS MALAL'),
(1078, 17, 'COVUNCO ABAJO'),
(1079, 17, 'COYUCO-COCHICO'),
(1080, 17, 'CUTRAL-CO'),
(1081, 17, 'EL CHOLAR'),
(1082, 17, 'EL HUECÚ'),
(1083, 17, 'EL SAUCE'),
(1084, 17, 'GUAÑACOS'),
(1085, 17, 'HUINGANCO'),
(1086, 17, 'JUNÍN DE LOS ANDES'),
(1087, 17, 'LAS COLORADAS'),
(1088, 17, 'LAS LAJAS'),
(1089, 17, 'LAS OVEJAS'),
(1090, 17, 'LONCOPUÉ'),
(1091, 17, 'LOS CATUTOS'),
(1092, 17, 'LOS CHIHUIDOS'),
(1093, 17, 'LOS MICHES'),
(1094, 17, 'MANZANO AMARGO'),
(1095, 17, 'MARIANO MORENO'),
(1096, 17, 'NEUQUÉN'),
(1097, 17, 'OCTAVIO PICO'),
(1098, 17, 'PASO AGUERRE'),
(1099, 17, 'PICÚN LEUFÚ'),
(1100, 17, 'PIEDRA DEL ÁGUILA'),
(1101, 17, 'PILO LIL'),
(1102, 17, 'PLAZA HUINCUL'),
(1103, 17, 'PLOTTIER'),
(1104, 17, 'QUILI MALAL'),
(1105, 17, 'RAMÓN CASTRO'),
(1106, 17, 'RINCÓN DE LOS SAUCES'),
(1107, 17, 'SAN MARTÍN DE LOS ANDES'),
(1108, 17, 'SAN PATRICIO DEL CHAÑAR'),
(1109, 17, 'SANTO TOMÁS'),
(1110, 17, 'SAUZAL BONITO'),
(1111, 17, 'SENILLOSA'),
(1112, 17, 'TAQUIMILÁN'),
(1113, 17, 'TRICAO MALAL'),
(1114, 17, 'VARVARCO / INVERNADA VIEJA'),
(1115, 17, 'VILLA CURÍ LEUVU'),
(1116, 17, 'VILLA DEL NAHUEVE'),
(1117, 17, 'VILLA EL CHOCÓN'),
(1118, 17, 'VILLA LA ANGOSTURA'),
(1119, 17, 'VILLA PEHUENIA'),
(1120, 17, 'VILLA TRAFUL'),
(1121, 17, 'VISTA ALEGRE'),
(1122, 17, 'ZAPALA'),
(1123, 18, 'AGUADA CECILIO'),
(1124, 18, 'AGUADA DE GUERRA'),
(1125, 18, 'AGUADA GUZMÁN'),
(1126, 18, 'ALLEN'),
(1127, 18, 'ARROYO DE LA VENTANA'),
(1128, 18, 'ARROYO LOS BERROS'),
(1129, 18, 'CAMPO GRANDE'),
(1130, 18, 'CATRIEL'),
(1131, 18, 'CERRO POLICIA'),
(1132, 18, 'CERVANTES'),
(1133, 18, 'CHELFORO'),
(1134, 18, 'CHICHINALES'),
(1135, 18, 'CHIMPAY'),
(1136, 18, 'CHIPAUQUIL'),
(1137, 18, 'CHOELE CHOEL'),
(1138, 18, 'CINCO SALTOS'),
(1139, 18, 'CIPOLLETTI'),
(1140, 18, 'CLEMENTE ONELLI'),
(1141, 18, 'COLÁN CONHUE'),
(1142, 18, 'COMALLO'),
(1143, 18, 'COMICÓ'),
(1144, 18, 'CONA NIYEU'),
(1145, 18, 'CONTRALMIRANTE CORDERO'),
(1146, 18, 'CORONEL BELISLE'),
(1147, 18, 'CUBANEA'),
(1148, 18, 'DARWIN'),
(1149, 18, 'DINA HUAPI'),
(1150, 18, 'EL BOLSÓN'),
(1151, 18, 'EL CAÍN'),
(1152, 18, 'EL CUY'),
(1153, 18, 'EL MANSO'),
(1154, 18, 'GENERAL CONESA'),
(1155, 18, 'GENERAL ENRIQUE GODOY'),
(1156, 18, 'GENERAL FERNÁNDEZ ORO'),
(1157, 18, 'GENERAL ROCA'),
(1158, 18, 'GUARDIA MITRE'),
(1159, 18, 'INGENIERO JACOBACCI'),
(1160, 18, 'INGENIERO LUIS A. HUERGO'),
(1161, 18, 'LAGUNA BLANCA'),
(1162, 18, 'LAMARQUE'),
(1163, 18, 'LOS MENUCOS'),
(1164, 18, 'LUIS BELTRÁN'),
(1165, 18, 'MAINQUÉ'),
(1166, 18, 'MAMUEL CHOIQUE'),
(1167, 18, 'MAQUINCHAO'),
(1168, 18, 'MENCUÉ'),
(1169, 18, 'MINISTRO RAMOS MEXIA'),
(1170, 18, 'NAHUEL NIYEU'),
(1171, 18, 'NAUPA HUEN'),
(1172, 18, 'ÑORQUINCÓ'),
(1173, 18, 'OJOS DE AGUA'),
(1174, 18, 'PASO FLORES'),
(1175, 18, 'PEÑAS BLANCAS'),
(1176, 18, 'PICHI MAHUIDA'),
(1177, 18, 'PILCANIYEU'),
(1178, 18, 'PILQUINIYEU'),
(1179, 18, 'PILQUINIYEU DEL LIMAY'),
(1180, 18, 'POMONA'),
(1181, 18, 'PRAHUANIYEU'),
(1182, 18, 'RINCÓN TRENETA'),
(1183, 18, 'RÍO CHICO'),
(1184, 18, 'RÍO COLORADO'),
(1185, 18, 'SAN ANTONIO OESTE'),
(1186, 18, 'SAN CARLOS DE BARILOCHE'),
(1187, 18, 'SAN JAVIER'),
(1188, 18, 'SIERRA COLORADA'),
(1189, 18, 'SIERRA GRANDE'),
(1190, 18, 'SIERRA PAILEMÁN'),
(1191, 18, 'VALCHETA'),
(1192, 18, 'VALLE AZUL'),
(1193, 18, 'VIEDMA'),
(1194, 18, 'VILLA LLANQUÍN'),
(1195, 18, 'VILLA MASCARDI'),
(1196, 18, 'VILLA REGINA'),
(1197, 18, 'YAMINUÉ'),
(1198, 19, 'AARÓN CASTELLANOS'),
(1199, 19, 'ACEBAL'),
(1200, 19, 'AGUARÁ GRANDE'),
(1201, 19, 'ALBARELLOS'),
(1202, 19, 'ALCORTA'),
(1203, 19, 'ALDAO'),
(1204, 19, 'ALEJANDRA'),
(1205, 19, 'ÁLVAREZ'),
(1206, 19, 'AMBROSETTI'),
(1207, 19, 'AMENÁBAR'),
(1208, 19, 'ANGÉLICA'),
(1209, 19, 'ANGELONI'),
(1210, 19, 'AREQUITO'),
(1211, 19, 'ARMINDA'),
(1212, 19, 'ARMSTRONG'),
(1213, 19, 'AROCENA'),
(1214, 19, 'ARROYO AGUIAR'),
(1215, 19, 'ARROYO CEIBAL'),
(1216, 19, 'ARROYO LEYES'),
(1217, 19, 'ARROYO SECO'),
(1218, 19, 'ARRUFÓ'),
(1219, 19, 'ARTEAGA'),
(1220, 19, 'ATALIVA'),
(1221, 19, 'AURELIA'),
(1222, 19, 'AVELLANEDA'),
(1223, 19, 'BARRANCAS'),
(1224, 19, 'BAUER Y SIGEL'),
(1225, 19, 'BELLA ITALIA'),
(1226, 19, 'BERABEVÚ'),
(1227, 19, 'BERNA'),
(1228, 19, 'BERNARDO DE IRIGOYEN'),
(1229, 19, 'BIGAND'),
(1230, 19, 'BOMBAL'),
(1231, 19, 'BOUQUET'),
(1232, 19, 'BUSTINZA'),
(1233, 19, 'CABAL'),
(1234, 19, 'CACIQUE ARIACAIQUÍN'),
(1235, 19, 'CAFFERATA'),
(1236, 19, 'CALCHAQUÍ'),
(1237, 19, 'CAMPO ANDINO'),
(1238, 19, 'CAMPO PIAGGIO'),
(1239, 19, 'CANDIOTI'),
(1240, 19, 'CAÑADA DE GÓMEZ'),
(1241, 19, 'CAÑADA DEL UCLE'),
(1242, 19, 'CAÑADA OMBU'),
(1243, 19, 'CAÑADA RICA'),
(1244, 19, 'CAÑADA ROSQUIN'),
(1245, 19, 'CAPITÁN BERMÚDEZ'),
(1246, 19, 'CAPIVARA'),
(1247, 19, 'CARCARAÑÁ'),
(1248, 19, 'CARLOS PELLEGRINI'),
(1249, 19, 'CARMEN'),
(1250, 19, 'CARMEN DEL SAUCE'),
(1251, 19, 'CARRERAS'),
(1252, 19, 'CARRIZALES'),
(1253, 19, 'CASALEGNO'),
(1254, 19, 'CASAS'),
(1255, 19, 'CASILDA'),
(1256, 19, 'CASTELAR'),
(1257, 19, 'CASTELLANOS'),
(1258, 19, 'CAYASTÁ'),
(1259, 19, 'CAYASTACITO'),
(1260, 19, 'CENTENO'),
(1261, 19, 'CEPEDA'),
(1262, 19, 'CERES'),
(1263, 19, 'CHABÁS'),
(1264, 19, 'CHAÑAR LADEADO'),
(1265, 19, 'CHAPUY'),
(1266, 19, 'CHOVET'),
(1267, 19, 'CHRISTOPHERSEN'),
(1268, 19, 'CLASSON'),
(1269, 19, 'COLONIA ALDAO'),
(1270, 19, 'COLONIA ANA'),
(1271, 19, 'COLONIA BELGRANO'),
(1272, 19, 'COLONIA BICHA'),
(1273, 19, 'COLONIA BIGAND'),
(1274, 19, 'COLONIA BOSSI'),
(1275, 19, 'COLONIA CAVOUR'),
(1276, 19, 'COLONIA CELLO'),
(1277, 19, 'COLONIA CLARA'),
(1278, 19, 'COLONIA DOLORES'),
(1279, 19, 'COLONIA DOS ROSAS Y LA LEGUA'),
(1280, 19, 'COLONIA DURÁN'),
(1281, 19, 'COLONIA ESTHER'),
(1282, 19, 'COLONIA ITURRASPE'),
(1283, 19, 'COLONIA MARGARITA'),
(1284, 19, 'COLONIA MASCÍAS'),
(1285, 19, 'COLONIA RAQUEL'),
(1286, 19, 'COLONIA ROSA'),
(1287, 19, 'COLONIA SAN JOSÉ'),
(1288, 19, 'CONSTANZA'),
(1289, 19, 'CORONDA'),
(1290, 19, 'CORONEL ARNOLD'),
(1291, 19, 'CORONEL BOGADO'),
(1292, 19, 'CORONEL FRAGA'),
(1293, 19, 'CORONEL RODOLFO S. DOMÍNGUEZ'),
(1294, 19, 'CORREA'),
(1295, 19, 'CRISPI'),
(1296, 19, 'CULULÚ'),
(1297, 19, 'CURUPAITY'),
(1298, 19, 'DESVÍO ARIJÓN'),
(1299, 19, 'DIAZ'),
(1300, 19, 'DIEGO DE ALVEAR'),
(1301, 19, 'EGUSQUIZA'),
(1302, 19, 'EL ARAZÁ'),
(1303, 19, 'EL RABÓN'),
(1304, 19, 'EL SOMBRERITO'),
(1305, 19, 'EL TRÉBOL'),
(1306, 19, 'ELISA'),
(1307, 19, 'ELORTONDO'),
(1308, 19, 'EMILIA'),
(1309, 19, 'EMPALME SAN CARLOS'),
(1310, 19, 'EMPALME VILLA CONSTITUCIÓN'),
(1311, 19, 'ESMERALDA'),
(1312, 19, 'ESPERANZA'),
(1313, 19, 'ESTACIÓN ALVEAR'),
(1314, 19, 'ESTACIÓN CLUCELLAS'),
(1315, 19, 'ESTEBAN RAMS'),
(1316, 19, 'EUSEBIA Y CAROLINA'),
(1317, 19, 'EUSTOLIA'),
(1318, 19, 'FELICIA'),
(1319, 19, 'FIDELA'),
(1320, 19, 'FIGHIERA'),
(1321, 19, 'FIRMAT'),
(1322, 19, 'FLORENCIA'),
(1323, 19, 'FORTÍN OLMOS'),
(1324, 19, 'FRANCK'),
(1325, 19, 'FRAY LUIS BELTRÁN'),
(1326, 19, 'FRONTERA'),
(1327, 19, 'FUENTES'),
(1328, 19, 'FUNES'),
(1329, 19, 'GABOTO'),
(1330, 19, 'GALISTEO'),
(1331, 19, 'GÁLVEZ'),
(1332, 19, 'GARABATO'),
(1333, 19, 'GARIBALDI'),
(1334, 19, 'GATO COLORADO'),
(1335, 19, 'GENERAL GELLY'),
(1336, 19, 'GENERAL LAGOS'),
(1337, 19, 'GESSLER'),
(1338, 19, 'GOBERNADOR CRESPO'),
(1339, 19, 'GÖDEKEN'),
(1340, 19, 'GODOY'),
(1341, 19, 'GOLONDRINA'),
(1342, 19, 'GRANADERO BAIGORRIA'),
(1343, 19, 'GREGORIA PÉREZ DE DENIS'),
(1344, 19, 'GRUTLY'),
(1345, 19, 'GUADALUPE NORTE'),
(1346, 19, 'HELVECIA'),
(1347, 19, 'HERSILIA'),
(1348, 19, 'HIPATÍA'),
(1349, 19, 'HUANQUEROS'),
(1350, 19, 'HUGENTOBLER'),
(1351, 19, 'HUGHES'),
(1352, 19, 'HUMBERTO PRIMO'),
(1353, 19, 'HUMBOLDT'),
(1354, 19, 'IBARLUCEA'),
(1355, 19, 'INGENIERO CHANOURDIE'),
(1356, 19, 'INTIYACO'),
(1357, 19, 'ITUZAINGÓ'),
(1358, 19, 'JACINTO L. ARÁUZ'),
(1359, 19, 'JOSEFINA'),
(1360, 19, 'JUAN BERNABÉ MOLINA'),
(1361, 19, 'JUAN DE GARAY'),
(1362, 19, 'JUNCAL'),
(1363, 19, 'LA BRAVA'),
(1364, 19, 'LA CABRAL'),
(1365, 19, 'LA CAMILA'),
(1366, 19, 'LA CHISPA'),
(1367, 19, 'LA CRIOLLA'),
(1368, 19, 'LA GALLARETA'),
(1369, 19, 'LA LUCILA'),
(1370, 19, 'LA PELADA'),
(1371, 19, 'LA PENCA Y CARAGUATÁ'),
(1372, 19, 'LA RUBIA'),
(1373, 19, 'LA SARITA'),
(1374, 19, 'LA VANGUARDIA'),
(1375, 19, 'LABORDEBOY'),
(1376, 19, 'LAGUNA PAIVA'),
(1377, 19, 'LANDETA'),
(1378, 19, 'LANTERI'),
(1379, 19, 'LARRECHEA'),
(1380, 19, 'LAS AVISPAS'),
(1381, 19, 'LAS BANDURRIAS'),
(1382, 19, 'LAS GARZAS'),
(1383, 19, 'LAS PALMERAS'),
(1384, 19, 'LAS PAREJAS'),
(1385, 19, 'LAS PETACAS'),
(1386, 19, 'LAS ROSAS'),
(1387, 19, 'LAS TOSCAS'),
(1388, 19, 'LAS TUNAS'),
(1389, 19, 'LAZZARINO'),
(1390, 19, 'LEHMANN'),
(1391, 19, 'LLAMBI CAMPBELL'),
(1392, 19, 'LOGROÑO'),
(1393, 19, 'LOMA ALTA'),
(1394, 19, 'LÓPEZ'),
(1395, 19, 'LOS AMORES'),
(1396, 19, 'LOS CARDOS'),
(1397, 19, 'LOS LAURELES'),
(1398, 19, 'LOS MOLINOS'),
(1399, 19, 'LOS QUIRQUINCHOS'),
(1400, 19, 'LUCIO V. LÓPEZ'),
(1401, 19, 'LUIS PALACIOS'),
(1402, 19, 'MACIEL'),
(1403, 19, 'MAGGIOLO'),
(1404, 19, 'MALABRIGO'),
(1405, 19, 'MARCELINO ESCALADA'),
(1406, 19, 'MARGARITA'),
(1407, 19, 'MARÍA JUANA'),
(1408, 19, 'MARÍA LUISA'),
(1409, 19, 'MARÍA SUSANA'),
(1410, 19, 'MARÍA TERESA'),
(1411, 19, 'MATILDE'),
(1412, 19, 'MAUÁ'),
(1413, 19, 'MÁXIMO PAZ'),
(1414, 19, 'MELINCUÉ'),
(1415, 19, 'MIGUEL TORRES'),
(1416, 19, 'MOISÉS VILLE'),
(1417, 19, 'MONIGOTES'),
(1418, 19, 'MONJE'),
(1419, 19, 'MONTE OSCURIDAD'),
(1420, 19, 'MONTE VERA'),
(1421, 19, 'MONTEFIORE'),
(1422, 19, 'MONTES DE OCA'),
(1423, 19, 'MURPHY'),
(1424, 19, 'NARÉ'),
(1425, 19, 'NELSON'),
(1426, 19, 'NICANOR MOLINAS'),
(1427, 19, 'NUEVO TORINO'),
(1428, 19, 'ÑANDUCITA'),
(1429, 19, 'OLIVEROS'),
(1430, 19, 'PALACIOS'),
(1431, 19, 'PAVÓN'),
(1432, 19, 'PAVÓN ARRIBA'),
(1433, 19, 'PEDRO GÓMEZ CELLO'),
(1434, 19, 'PÉREZ'),
(1435, 19, 'PEYRANO'),
(1436, 19, 'PIAMONTE'),
(1437, 19, 'PILAR'),
(1438, 19, 'PIÑERO'),
(1439, 19, 'PLAZA CLUCELLAS'),
(1440, 19, 'PORTUGALETE'),
(1441, 19, 'POZO BORRADO'),
(1442, 19, 'PRESIDENTE ROCA'),
(1443, 19, 'PROGRESO'),
(1444, 19, 'PROVIDENCIA'),
(1445, 19, 'PUEBLO ANDINO'),
(1446, 19, 'PUEBLO ESTHER'),
(1447, 19, 'PUEBLO IRIGOYEN'),
(1448, 19, 'PUEBLO MARINI'),
(1449, 19, 'PUEBLO MUÑOZ'),
(1450, 19, 'PUEBLO URANGA'),
(1451, 19, 'PUERTO GENERAL SAN MARTÍN'),
(1452, 19, 'PUJATO'),
(1453, 19, 'PUJATO NORTE'),
(1454, 19, 'RAFAELA'),
(1455, 19, 'RAMAYÓN'),
(1456, 19, 'RAMONA'),
(1457, 19, 'RECONQUISTA'),
(1458, 19, 'RECREO'),
(1459, 19, 'RICARDONE'),
(1460, 19, 'RIVADAVIA'),
(1461, 19, 'ROLDÁN'),
(1462, 19, 'ROMANG'),
(1463, 19, 'ROSARIO'),
(1464, 19, 'RUEDA'),
(1465, 19, 'RUFINO'),
(1466, 19, 'SA PEREIRA'),
(1467, 19, 'SAGUIER'),
(1468, 19, 'SALADERO MARIANO CABAL'),
(1469, 19, 'SALTO GRANDE'),
(1470, 19, 'SAN AGUSTÍN'),
(1471, 19, 'SAN ANTONIO'),
(1472, 19, 'SAN ANTONIO DE OBLIGADO'),
(1473, 19, 'SAN BERNARDO (N.J.)'),
(1474, 19, 'SAN BERNARDO (S.J.)'),
(1475, 19, 'SAN CARLOS CENTRO'),
(1476, 19, 'SAN CARLOS NORTE'),
(1477, 19, 'SAN CARLOS SUD'),
(1478, 19, 'SAN CRISTÓBAL'),
(1479, 19, 'SAN EDUARDO'),
(1480, 19, 'SAN EUGENIO'),
(1481, 19, 'SAN FABIÁN'),
(1482, 19, 'SAN FRANCISCO DE SANTA FE'),
(1483, 19, 'SAN GENARO'),
(1484, 19, 'SAN GENARO NORTE'),
(1485, 19, 'SAN GREGORIO'),
(1486, 19, 'SAN GUILLERMO'),
(1487, 19, 'SAN JAVIER'),
(1488, 19, 'SAN JERÓNIMO DEL SAUCE'),
(1489, 19, 'SAN JERÓNIMO NORTE'),
(1490, 19, 'SAN JERÓNIMO SUD'),
(1491, 19, 'SAN JORGE'),
(1492, 19, 'SAN JOSÉ DE LA ESQUINA'),
(1493, 19, 'SAN JOSÉ DEL RINCÓN'),
(1494, 19, 'SAN JUSTO'),
(1495, 19, 'SAN LORENZO'),
(1496, 19, 'SAN MARIANO'),
(1497, 19, 'SAN MARTÍN DE LAS ESCOBAS'),
(1498, 19, 'SAN MARTÍN NORTE'),
(1499, 19, 'SAN VICENTE'),
(1500, 19, 'SANCTI SPIRITU'),
(1501, 19, 'SANFORD'),
(1502, 19, 'SANTA CLARA DE BUENA VISTA'),
(1503, 19, 'SANTA CLARA DE SAGUIER'),
(1504, 19, 'SANTA FE'),
(1505, 19, 'SANTA ISABEL'),
(1506, 19, 'SANTA MARGARITA'),
(1507, 19, 'SANTA MARÍA CENTRO'),
(1508, 19, 'SANTA MARÍA NORTE'),
(1509, 19, 'SANTA ROSA DE CALCHINES'),
(1510, 19, 'SANTA TERESA'),
(1511, 19, 'SANTO DOMINGO'),
(1512, 19, 'SANTO TOMÉ'),
(1513, 19, 'SANTURCE'),
(1514, 19, 'SARGENTO CABRAL'),
(1515, 19, 'SARMIENTO'),
(1516, 19, 'SASTRE'),
(1517, 19, 'SAUCE VIEJO'),
(1518, 19, 'SERODINO'),
(1519, 19, 'SILVA'),
(1520, 19, 'SOLDINI'),
(1521, 19, 'SOLEDAD'),
(1522, 19, 'SOUTOMAYOR'),
(1523, 19, 'SUARDI'),
(1524, 19, 'SUNCHALES'),
(1525, 19, 'SUSANA'),
(1526, 19, 'TACUARENDÍ'),
(1527, 19, 'TACURAL'),
(1528, 19, 'TACURALES'),
(1529, 19, 'TARTAGAL'),
(1530, 19, 'TEODELINA'),
(1531, 19, 'THEOBALD'),
(1532, 19, 'TIMBÚES'),
(1533, 19, 'TOBA'),
(1534, 19, 'TORTUGAS'),
(1535, 19, 'TOSTADO'),
(1536, 19, 'TOTORAS'),
(1537, 19, 'TRAILL'),
(1538, 19, 'VENADO TUERTO'),
(1539, 19, 'VERA'),
(1540, 19, 'VERA Y PINTADO'),
(1541, 19, 'VIDELA'),
(1542, 19, 'VILA'),
(1543, 19, 'VILLA AMELIA'),
(1544, 19, 'VILLA ANA'),
(1545, 19, 'VILLA CAÑÁS'),
(1546, 19, 'VILLA CONSTITUCIÓN'),
(1547, 19, 'VILLA ELOISA'),
(1548, 19, 'VILLA GOBERNADOR GÁLVEZ'),
(1549, 19, 'VILLA GUILLERMINA'),
(1550, 19, 'VILLA MINETTI'),
(1551, 19, 'VILLA MUGUETA'),
(1552, 19, 'VILLA OCAMPO'),
(1553, 19, 'VILLA SAN JOSÉ'),
(1554, 19, 'VILLA SARALEGUI'),
(1555, 19, 'VILLA TRINIDAD'),
(1556, 19, 'VILLADA'),
(1557, 19, 'VIRGINIA'),
(1558, 19, 'WHEELWRIGHT'),
(1559, 19, 'ZAVALLA'),
(1560, 19, 'ZENÓN PEREYRA'),
(1561, 20, 'ACHERAL'),
(1562, 20, 'AGUA DULCE Y LA SOLEDAD'),
(1563, 20, 'AGUILARES'),
(1564, 20, 'ALDERETES'),
(1565, 20, 'ALPACHIRI Y EL MOLINO'),
(1566, 20, 'ALTO VERDE Y LOS GUCHEAS'),
(1567, 20, 'AMAICHÁ DEL VALLE'),
(1568, 20, 'AMBERES'),
(1569, 20, 'ANCA JULI'),
(1570, 20, 'ARCADIA'),
(1571, 20, 'ATAHONA'),
(1572, 20, 'BANDA DEL RÍO SALÍ'),
(1573, 20, 'BELLA VISTA'),
(1574, 20, 'BUENA VISTA'),
(1575, 20, 'BURRUYACÚ'),
(1576, 20, 'CAPITAN CÁCERES'),
(1577, 20, 'CEVIL REDONDO'),
(1578, 20, 'CHOROMORO'),
(1579, 20, 'CIUDACITA'),
(1580, 20, 'COLALAO DEL VALLE'),
(1581, 20, 'COLOMBRES'),
(1582, 20, 'CONCEPCIÓN'),
(1583, 20, 'DELFÍN GALLO'),
(1584, 20, 'EL BRACHO Y EL CEVILAR'),
(1585, 20, 'EL CADILLAL'),
(1586, 20, 'EL CERCADO'),
(1587, 20, 'EL CHAÑAR'),
(1588, 20, 'EL MANANTIAL'),
(1589, 20, 'EL MOJÓN'),
(1590, 20, 'EL MOLLAR'),
(1591, 20, 'EL NARANJITO'),
(1592, 20, 'EL NARANJO Y EL SUNCHAL'),
(1593, 20, 'EL POLEAR'),
(1594, 20, 'EL PUESTITO'),
(1595, 20, 'EL SACRIFICIO'),
(1596, 20, 'EL TIMBÓ'),
(1597, 20, 'ESCABA'),
(1598, 20, 'ESQUINA Y MANCOPA'),
(1599, 20, 'ESTACIÓN ARAOZ Y TACANAS'),
(1600, 20, 'FAMAILLÁ'),
(1601, 20, 'GASTONA Y BELICHA'),
(1602, 20, 'GOBERNADOR GARMENDIA'),
(1603, 20, 'GOBERNADOR PIEDRABUENA'),
(1604, 20, 'GRANEROS'),
(1605, 20, 'HUASA PAMPA'),
(1606, 20, 'JUAN BAUTISTA ALBERDI'),
(1607, 20, 'LA COCHA'),
(1608, 20, 'LA ESPERANZA'),
(1609, 20, 'LA FLORIDA Y LUISIANA'),
(1610, 20, 'LA RAMADA Y LA CRUZ'),
(1611, 20, 'LA TRINIDAD'),
(1612, 20, 'LAMADRID'),
(1613, 20, 'LAS CEJAS'),
(1614, 20, 'LAS TALAS'),
(1615, 20, 'LAS TALITAS'),
(1616, 20, 'LOS BULACIO Y LOS VILLAGRA'),
(1617, 20, 'LOS GÓMEZ'),
(1618, 20, 'LOS NOGALES'),
(1619, 20, 'LOS PEREYRAS'),
(1620, 20, 'LOS PÉREZ'),
(1621, 20, 'LOS PUESTOS'),
(1622, 20, 'LOS RALOS'),
(1623, 20, 'LOS SARMIENTOS Y LA TIPA'),
(1624, 20, 'LOS SOSAS'),
(1625, 20, 'LULES'),
(1626, 20, 'MANUEL GARCÍA FERNÁNDEZ'),
(1627, 20, 'MANUELA PEDRAZA'),
(1628, 20, 'MEDINAS'),
(1629, 20, 'MONTE BELLO'),
(1630, 20, 'MONTEAGUDO'),
(1631, 20, 'MONTEROS'),
(1632, 20, 'PADRE MONTI'),
(1633, 20, 'PAMPA MAYO'),
(1634, 20, 'QUILMES Y LOS SUELDOS'),
(1635, 20, 'RACO'),
(1636, 20, 'RANCHILLOS Y SAN MIGUEL'),
(1637, 20, 'RÍO CHICO Y NUEVA TRINIDAD'),
(1638, 20, 'RÍO COLORADO'),
(1639, 20, 'RÍO SECO'),
(1640, 20, 'RUMI PUNCO'),
(1641, 20, 'SAN ANDRÉS'),
(1642, 20, 'SAN FELIPE Y SANTA BÁRBARA'),
(1643, 20, 'SAN IGNACIO'),
(1644, 20, 'SAN JAVIER'),
(1645, 20, 'SAN JOSÉ DE LA COCHA'),
(1646, 20, 'SAN MIGUEL DE TUCUMÁN'),
(1647, 20, 'SAN PABLO Y VILLA NOUGUÉS'),
(1648, 20, 'SAN PEDRO DE COLALAO'),
(1649, 20, 'SAN PEDRO Y SAN ANTONIO'),
(1650, 20, 'SANTA ANA'),
(1651, 20, 'SANTA CRUZ Y LA TUNA'),
(1652, 20, 'SANTA LUCÍA'),
(1653, 20, 'SANTA ROSA DE LEALES'),
(1654, 20, 'SANTA ROSA Y LOS ROJO'),
(1655, 20, 'SARGENTO MOYA'),
(1656, 20, 'SIETE DE ABRIL'),
(1657, 20, 'SIMOCA'),
(1658, 20, 'SOLDADO MALDONADO'),
(1659, 20, 'TACO RALO'),
(1660, 20, 'TAFÍ DEL VALLE'),
(1661, 20, 'TAFÍ VIEJO'),
(1662, 20, 'TAPIA'),
(1663, 20, 'TENIENTE BERDINA'),
(1664, 20, 'TRANCAS'),
(1665, 20, 'VILLA BELGRANO'),
(1666, 20, 'VILLA BENJAMÍN ARAOZ'),
(1667, 20, 'VILLA CHIGLIGASTA'),
(1668, 20, 'VILLA DE LEALES'),
(1669, 20, 'VILLA QUINTEROS'),
(1670, 20, 'YÁNIMA'),
(1671, 20, 'YERBA BUENA'),
(1672, 20, 'YERBA BUENA (S)'),
(1673, 21, 'ALDEA APELEG'),
(1674, 21, 'ALDEA BELEIRO'),
(1675, 21, 'ALDEA EPULEF'),
(1676, 21, 'ALTO RÍO SENGUER'),
(1677, 21, 'BUEN PASTO'),
(1678, 21, 'CAMARONES'),
(1679, 21, 'CARRENLEUFÚ'),
(1680, 21, 'CERRO CENTINELA'),
(1681, 21, 'CHOLILA'),
(1682, 21, 'COLAN CONHUÉ'),
(1683, 21, 'COMODORO RIVADAVIA'),
(1684, 21, 'CORCOVADO'),
(1685, 21, 'CUSHAMEN'),
(1686, 21, 'DIQUE FLORENTINO AMEGHINO'),
(1687, 21, 'DOCTOR RICARDO ROJAS'),
(1688, 21, 'DOLAVON'),
(1689, 21, 'EL HOYO'),
(1690, 21, 'EL MAITÉN'),
(1691, 21, 'EPUYÉN'),
(1692, 21, 'ESQUEL'),
(1693, 21, 'FACUNDO'),
(1694, 21, 'GAIMAN'),
(1695, 21, 'GAN GAN'),
(1696, 21, 'GASTRE'),
(1697, 21, 'GOBERNADOR COSTA'),
(1698, 21, 'GUALJAINA'),
(1699, 21, 'JOSÉ DE SAN MARTÍN'),
(1700, 21, 'LAGO BLANCO'),
(1701, 21, 'LAGO PUELO'),
(1702, 21, 'LAGUNITA SALADA'),
(1703, 21, 'LAS PLUMAS'),
(1704, 21, 'LOS ALTARES'),
(1705, 21, 'PASO DE INDIOS'),
(1706, 21, 'PASO DEL SAPO'),
(1707, 21, 'PUERTO MADRYN'),
(1708, 21, 'PUERTO PIRÁMIDE'),
(1709, 21, 'RADA TILLY'),
(1710, 21, 'RAWSON'),
(1711, 21, 'RÍO MAYO'),
(1712, 21, 'RÍO PICO'),
(1713, 21, 'SARMIENTO'),
(1714, 21, 'TECKA'),
(1715, 21, 'TELSEN'),
(1716, 21, 'TRELEW'),
(1717, 21, 'TREVELIN'),
(1718, 21, 'VEINTIOCHO DE JULIO'),
(1719, 22, 'ACHIRAS'),
(1720, 22, 'ADELIA MARÍA'),
(1721, 22, 'AGUA DE ORO'),
(1722, 22, 'ALCIRA GIGENA'),
(1723, 22, 'ALDEA SANTA MARÍA'),
(1724, 22, 'ALEJANDRO ROCA'),
(1725, 22, 'ALEJO LEDESMA'),
(1726, 22, 'ALICIA'),
(1727, 22, 'ALMAFUERTE'),
(1728, 22, 'ALPA CORRAL'),
(1729, 22, 'ALTA GRACIA'),
(1730, 22, 'ALTO ALEGRE'),
(1731, 22, 'ALTO DE LOS QUEBRACHOS'),
(1732, 22, 'ALTOS DE CHIPION'),
(1733, 22, 'AMBOY'),
(1734, 22, 'ÁMBUL'),
(1735, 22, 'ANA ZUMARÁN'),
(1736, 22, 'ANISACATE'),
(1737, 22, 'ARIAS'),
(1738, 22, 'ARROYITO'),
(1739, 22, 'ARROYO ALGODÓN'),
(1740, 22, 'ARROYO CABRAL'),
(1741, 22, 'ARROYO DE LOS PATOS'),
(1742, 22, 'ASSUNTA'),
(1743, 22, 'ATAHONA'),
(1744, 22, 'AUSONIA'),
(1745, 22, 'AVELLANEDA'),
(1746, 22, 'BALLESTEROS'),
(1747, 22, 'BALLESTEROS SUD'),
(1748, 22, 'BALNEARIA'),
(1749, 22, 'BAÑADO DE SOTO'),
(1750, 22, 'BELL VILLE'),
(1751, 22, 'BENGOLEA'),
(1752, 22, 'BENJAMÍN GOULD'),
(1753, 22, 'BERROTARÁN'),
(1754, 22, 'BIALET MASSÉ'),
(1755, 22, 'BOUWER'),
(1756, 22, 'BRINKMANN'),
(1757, 22, 'BUCHARDO'),
(1758, 22, 'BULNES'),
(1759, 22, 'CABALANGO'),
(1760, 22, 'CALCHÍN'),
(1761, 22, 'CALCHÍN OESTE'),
(1762, 22, 'CALMAYO'),
(1763, 22, 'CAMILO ALDAO'),
(1764, 22, 'CAMINIAGA'),
(1765, 22, 'CANDELARIA SUD'),
(1766, 22, 'CAÑADA DE LUQUE'),
(1767, 22, 'CAÑADA DE MACHADO'),
(1768, 22, 'CAÑADA DE RÍO PINTO'),
(1769, 22, 'CAPILLA DE LOS REMEDIOS'),
(1770, 22, 'CAPILLA DE SITÓN'),
(1771, 22, 'CAPILLA DEL CARMEN'),
(1772, 22, 'CAPILLA DEL MONTE'),
(1773, 22, 'CAPITÁN GENERAL BERNARDO O\'HIGGINS'),
(1774, 22, 'CARNERILLO'),
(1775, 22, 'CARRILOBO'),
(1776, 22, 'CASA GRANDE'),
(1777, 22, 'CAVANAGH'),
(1778, 22, 'CERRO COLORADO'),
(1779, 22, 'CHAJÁN'),
(1780, 22, 'CHALACEA'),
(1781, 22, 'CHANCANÍ'),
(1782, 22, 'CHAÑAR VIEJO'),
(1783, 22, 'CHARBONIER'),
(1784, 22, 'CHARRAS'),
(1785, 22, 'CHAZÓN'),
(1786, 22, 'CHILIBROSTE'),
(1787, 22, 'CHUCUL'),
(1788, 22, 'CHUÑA'),
(1789, 22, 'CHUÑA HUASI'),
(1790, 22, 'CHURQUI CAÑADA'),
(1791, 22, 'CIÉNAGA DEL CORO'),
(1792, 22, 'CINTRA'),
(1793, 22, 'COLAZO'),
(1794, 22, 'COLONIA ALMADA'),
(1795, 22, 'COLONIA ANITA'),
(1796, 22, 'COLONIA BARGE'),
(1797, 22, 'COLONIA BISMARCK'),
(1798, 22, 'COLONIA BREMEN'),
(1799, 22, 'COLONIA CAROYA'),
(1800, 22, 'COLONIA ITALIANA'),
(1801, 22, 'COLONIA ITURRASPE'),
(1802, 22, 'COLONIA LAS CUATRO ESQUINAS'),
(1803, 22, 'COLONIA LAS PICHANAS'),
(1804, 22, 'COLONIA MARINA'),
(1805, 22, 'COLONIA PROSPERIDAD'),
(1806, 22, 'COLONIA SAN BARTOLOMÉ'),
(1807, 22, 'COLONIA SAN PEDRO'),
(1808, 22, 'COLONIA TIROLESA'),
(1809, 22, 'COLONIA VALTELINA'),
(1810, 22, 'COLONIA VICENTE AGÜERO'),
(1811, 22, 'COLONIA VIDELA'),
(1812, 22, 'COLONIA VIGNAUD'),
(1813, 22, 'COMECHINGONES'),
(1814, 22, 'CONLARA'),
(1815, 22, 'COPACABANA'),
(1816, 22, 'CÓRDOBA'),
(1817, 22, 'CORONEL BAIGORRIA'),
(1818, 22, 'CORONEL MOLDES'),
(1819, 22, 'CORRAL DE BUSTOS'),
(1820, 22, 'CORRALITO'),
(1821, 22, 'COSQUÍN'),
(1822, 22, 'COSTA SACATE'),
(1823, 22, 'CRUZ ALTA'),
(1824, 22, 'CRUZ DE CAÑA'),
(1825, 22, 'CRUZ DEL EJE'),
(1826, 22, 'CUESTA BLANCA'),
(1827, 22, 'DALMACIO VÉLEZ SARSFIELD'),
(1828, 22, 'DEÁN FUNES'),
(1829, 22, 'DEL CAMPILLO'),
(1830, 22, 'DESPEÑADEROS'),
(1831, 22, 'DEVOTO'),
(1832, 22, 'DIEGO DE ROJAS'),
(1833, 22, 'DIQUE CHICO'),
(1834, 22, 'EL ARAÑADO'),
(1835, 22, 'EL BRETE'),
(1836, 22, 'EL CHACHO'),
(1837, 22, 'EL CRISPÍN'),
(1838, 22, 'EL FORTÍN'),
(1839, 22, 'EL MANZANO'),
(1840, 22, 'EL RASTREADOR'),
(1841, 22, 'EL RODEO'),
(1842, 22, 'EL TÍO'),
(1843, 22, 'ELENA'),
(1844, 22, 'EMBALSE'),
(1845, 22, 'ESQUINA'),
(1846, 22, 'ESTACIÓN GENERAL PAZ'),
(1847, 22, 'ESTACIÓN JUÁREZ CELMAN'),
(1848, 22, 'ESTANCIA DE GUADALUPE'),
(1849, 22, 'ESTANCIA VIEJA'),
(1850, 22, 'ETRURIA'),
(1851, 22, 'EUFRASIO LOZA'),
(1852, 22, 'FALDA DEL CARMEN'),
(1853, 22, 'FREYRE'),
(1854, 22, 'GENERAL BALDISSERA'),
(1855, 22, 'GENERAL CABRERA'),
(1856, 22, 'GENERAL DEHEZA'),
(1857, 22, 'GENERAL FOTHERINGHAM'),
(1858, 22, 'GENERAL LEVALLE'),
(1859, 22, 'GUANACO MUERTO'),
(1860, 22, 'GUASAPAMPA'),
(1861, 22, 'GUATIMOZÍN'),
(1862, 22, 'GUTEMBERG'),
(1863, 22, 'HERNANDO'),
(1864, 22, 'HUERTA GRANDE'),
(1865, 22, 'HUINCA RENANCÓ'),
(1866, 22, 'IDIAZÁBAL'),
(1867, 22, 'IMPIRA'),
(1868, 22, 'INRIVILLE'),
(1869, 22, 'ISLA VERDE'),
(1870, 22, 'ITALÓ'),
(1871, 22, 'JAMES CRAIK'),
(1872, 22, 'JESÚS MARÍA'),
(1873, 22, 'JOVITA'),
(1874, 22, 'JUSTINIANO POSSE'),
(1875, 22, 'KILÓMETRO 658'),
(1876, 22, 'LA BATEA'),
(1877, 22, 'LA CALERA'),
(1878, 22, 'LA CARLOTA'),
(1879, 22, 'LA CAROLINA (EL POTOSÍ)'),
(1880, 22, 'LA CAUTIVA'),
(1881, 22, 'LA CESIRA'),
(1882, 22, 'LA CRUZ'),
(1883, 22, 'LA CUMBRE'),
(1884, 22, 'LA CUMBRECITA'),
(1885, 22, 'LA FALDA'),
(1886, 22, 'LA FRANCIA'),
(1887, 22, 'LA GRANJA'),
(1888, 22, 'LA HIGUERA'),
(1889, 22, 'LA LAGUNA'),
(1890, 22, 'LA PAISANITA'),
(1891, 22, 'LA PALESTINA'),
(1892, 22, 'LA PAMPA'),
(1893, 22, 'LA PAQUITA'),
(1894, 22, 'LA PARA'),
(1895, 22, 'LA PAZ'),
(1896, 22, 'LA PLAYA'),
(1897, 22, 'LA PLAYOSA'),
(1898, 22, 'LA POBLACIÓN'),
(1899, 22, 'LA POSTA'),
(1900, 22, 'LA PUERTA'),
(1901, 22, 'LA QUINTA'),
(1902, 22, 'LA RANCHERITA'),
(1903, 22, 'LA RINCONADA'),
(1904, 22, 'LA SERRANITA'),
(1905, 22, 'LA TORDILLA'),
(1906, 22, 'LABORDE'),
(1907, 22, 'LABOULAYE'),
(1908, 22, 'LAGUNA LARGA'),
(1909, 22, 'LAS ACEQUIAS'),
(1910, 22, 'LAS ALBAHACAS'),
(1911, 22, 'LAS ARRIAS'),
(1912, 22, 'LAS BAJADAS'),
(1913, 22, 'LAS CALERAS'),
(1914, 22, 'LAS CALLES'),
(1915, 22, 'LAS CAÑADAS'),
(1916, 22, 'LAS GRAMILLAS'),
(1917, 22, 'LAS HIGUERAS'),
(1918, 22, 'LAS ISLETILLAS'),
(1919, 22, 'LAS JUNTURAS'),
(1920, 22, 'LAS PALMAS'),
(1921, 22, 'LAS PEÑAS'),
(1922, 22, 'LAS PEÑAS SUD'),
(1923, 22, 'LAS PERDICES'),
(1924, 22, 'LAS PLAYAS'),
(1925, 22, 'LAS RABONAS'),
(1926, 22, 'LAS SALADAS'),
(1927, 22, 'LAS TAPIAS'),
(1928, 22, 'LAS VARAS'),
(1929, 22, 'LAS VARILLAS'),
(1930, 22, 'LAS VERTIENTES'),
(1931, 22, 'LEGUIZAMÓN'),
(1932, 22, 'LEONES'),
(1933, 22, 'LOS CEDROS'),
(1934, 22, 'LOS CERRILLOS'),
(1935, 22, 'LOS CHAÑARITOS (C.E.)'),
(1936, 22, 'LOS CHAÑARITOS (R.S.)'),
(1937, 22, 'LOS CISNES'),
(1938, 22, 'LOS COCOS'),
(1939, 22, 'LOS CÓNDORES'),
(1940, 22, 'LOS HORNILLOS'),
(1941, 22, 'LOS HOYOS'),
(1942, 22, 'LOS MISTOLES'),
(1943, 22, 'LOS MOLINOS'),
(1944, 22, 'LOS POZOS'),
(1945, 22, 'LOS REARTES'),
(1946, 22, 'LOS SURGENTES'),
(1947, 22, 'LOS TALARES'),
(1948, 22, 'LOS ZORROS'),
(1949, 22, 'LOZADA'),
(1950, 22, 'LUCA'),
(1951, 22, 'LUCIO V. MANSILLA'),
(1952, 22, 'LUQUE'),
(1953, 22, 'LUTTI'),
(1954, 22, 'LUYABA'),
(1955, 22, 'MALAGUEÑO'),
(1956, 22, 'MALENA'),
(1957, 22, 'MALVINAS ARGENTINAS'),
(1958, 22, 'MANFREDI'),
(1959, 22, 'MAQUINISTA GALLINI'),
(1960, 22, 'MARCOS JUÁREZ'),
(1961, 22, 'MARULL'),
(1962, 22, 'MATORRALES'),
(1963, 22, 'MATTALDI'),
(1964, 22, 'MAYU SUMAJ'),
(1965, 22, 'MEDIA NARANJA'),
(1966, 22, 'MELO'),
(1967, 22, 'MENDIOLAZA'),
(1968, 22, 'MI GRANJA'),
(1969, 22, 'MINA CLAVERO'),
(1970, 22, 'MIRAMAR'),
(1971, 22, 'MONTE BUEY'),
(1972, 22, 'MONTE CRISTO'),
(1973, 22, 'MONTE DE LOS GAUCHOS'),
(1974, 22, 'MONTE LEÑA'),
(1975, 22, 'MONTE MAÍZ'),
(1976, 22, 'MONTE RALO'),
(1977, 22, 'MORRISON'),
(1978, 22, 'MORTEROS'),
(1979, 22, 'NICOLÁS BRUZZONE'),
(1980, 22, 'NOETINGER'),
(1981, 22, 'NONO'),
(1982, 22, 'OBISPO TREJO'),
(1983, 22, 'OLAETA'),
(1984, 22, 'OLIVA'),
(1985, 22, 'OLIVARES DE SAN NICOLÁS'),
(1986, 22, 'ONAGOYTI'),
(1987, 22, 'ONCATIVO'),
(1988, 22, 'ORDÓÑEZ'),
(1989, 22, 'PACHECO DE MELO'),
(1990, 22, 'PAMPAYASTA NORTE'),
(1991, 22, 'PAMPAYASTA SUD'),
(1992, 22, 'PANAHOLMA'),
(1993, 22, 'PASCANAS'),
(1994, 22, 'PASCO'),
(1995, 22, 'PASO DEL DURAZNO'),
(1996, 22, 'PASO VIEJO'),
(1997, 22, 'PILAR'),
(1998, 22, 'PINCÉN'),
(1999, 22, 'PIQUILLÍN'),
(2000, 22, 'PLAZA DE MERCEDES'),
(2001, 22, 'PLAZA LUXARDO'),
(2002, 22, 'PORTEÑA'),
(2003, 22, 'POTRERO DE GARAY'),
(2004, 22, 'POZO DEL MOLLE'),
(2005, 22, 'POZO NUEVO'),
(2006, 22, 'PUEBLO ITALIANO'),
(2007, 22, 'PUESTO DE CASTRO'),
(2008, 22, 'PUNTA DEL AGUA'),
(2009, 22, 'QUEBRACHO HERRADO'),
(2010, 22, 'QUILINO'),
(2011, 22, 'RAFAEL GARCÍA'),
(2012, 22, 'RANQUELES'),
(2013, 22, 'RAYO CORTADO'),
(2014, 22, 'REDUCCIÓN'),
(2015, 22, 'RINCÓN'),
(2016, 22, 'RÍO BAMBA'),
(2017, 22, 'RÍO CEBALLOS'),
(2018, 22, 'RÍO CUARTO'),
(2019, 22, 'RÍO DE LOS SAUCES'),
(2020, 22, 'RÍO PRIMERO'),
(2021, 22, 'RÍO SEGUNDO'),
(2022, 22, 'RÍO TERCERO'),
(2023, 22, 'ROSALES'),
(2024, 22, 'ROSARIO DEL SALADILLO'),
(2025, 22, 'SACANTA'),
(2026, 22, 'SAGRADA FAMILIA'),
(2027, 22, 'SAIRA'),
(2028, 22, 'SALADILLO'),
(2029, 22, 'SALDÁN');
INSERT INTO `partido` (`id_partido`, `id_provincia`, `nombre_partido`) VALUES
(2030, 22, 'SALSACATE'),
(2031, 22, 'SALSIPUEDES'),
(2032, 22, 'SAMPACHO'),
(2033, 22, 'SAN AGUSTÍN'),
(2034, 22, 'SAN ANTONIO DE ARREDONDO'),
(2035, 22, 'SAN ANTONIO DE LITÍN'),
(2036, 22, 'SAN BASILIO'),
(2037, 22, 'SAN CARLOS MINAS'),
(2038, 22, 'SAN CLEMENTE'),
(2039, 22, 'SAN ESTEBAN'),
(2040, 22, 'SAN FRANCISCO'),
(2041, 22, 'SAN FRANCISCO DEL CHAÑAR'),
(2042, 22, 'SAN GERÓNIMO'),
(2043, 22, 'SAN IGNACIO'),
(2044, 22, 'SAN JAVIER / YACANTO'),
(2045, 22, 'SAN JOAQUÍN'),
(2046, 22, 'SAN JOSÉ'),
(2047, 22, 'SAN JOSÉ DE LA DORMIDA'),
(2048, 22, 'SAN JOSÉ DE LAS SALINAS'),
(2049, 22, 'SAN LORENZO'),
(2050, 22, 'SAN MARCOS SIERRAS'),
(2051, 22, 'SAN MARCOS SUD'),
(2052, 22, 'SAN PEDRO'),
(2053, 22, 'SAN PEDRO NORTE'),
(2054, 22, 'SAN ROQUE'),
(2055, 22, 'SAN VICENTE'),
(2056, 22, 'SANTA CATALINA'),
(2057, 22, 'SANTA ELENA'),
(2058, 22, 'SANTA EUFEMIA'),
(2059, 22, 'SANTA MARÍA'),
(2060, 22, 'SANTA ROSA DE CALAMUCHITA'),
(2061, 22, 'SANTA ROSA DE RÍO PRIMERO'),
(2062, 22, 'SANTIAGO TEMPLE'),
(2063, 22, 'SARMIENTO'),
(2064, 22, 'SATURNINO MARÍA LASPIUR'),
(2065, 22, 'SAUCE ARRIBA'),
(2066, 22, 'SEBASTIÁN ELCANO'),
(2067, 22, 'SEEBER'),
(2068, 22, 'SEGUNDA USINA'),
(2069, 22, 'SERRANO'),
(2070, 22, 'SERREZUELA'),
(2071, 22, 'SILVIO PELLICO'),
(2072, 22, 'SIMBOLAR'),
(2073, 22, 'SINSACATE'),
(2074, 22, 'SUCO'),
(2075, 22, 'TALA CAÑADA'),
(2076, 22, 'TALA HUASI'),
(2077, 22, 'TALAINI'),
(2078, 22, 'TANCACHA'),
(2079, 22, 'TANTI'),
(2080, 22, 'TICINO'),
(2081, 22, 'TINOCO'),
(2082, 22, 'TÍO PUJIO'),
(2083, 22, 'TOLEDO'),
(2084, 22, 'TORO PUJIO'),
(2085, 22, 'TOSNO'),
(2086, 22, 'TOSQUITA'),
(2087, 22, 'TRÁNSITO'),
(2088, 22, 'TUCLAME'),
(2089, 22, 'UCACHA'),
(2090, 22, 'UNQUILLO'),
(2091, 22, 'VALLE DE ANISACATE'),
(2092, 22, 'VALLE HERMOSO'),
(2093, 22, 'VIAMONTE'),
(2094, 22, 'VICUÑA MACKENNA'),
(2095, 22, 'VILLA ALLENDE'),
(2096, 22, 'VILLA AMANCAY'),
(2097, 22, 'VILLA ASCASUBI'),
(2098, 22, 'VILLA CANDELARIA NORTE'),
(2099, 22, 'VILLA CAÑADA DEL SAUCE'),
(2100, 22, 'VILLA CARLOS PAZ'),
(2101, 22, 'VILLA CERRO AZUL'),
(2102, 22, 'VILLA CIUDAD DE AMÉRICA'),
(2103, 22, 'VILLA CIUDAD PARQUE LOS REARTES'),
(2104, 22, 'VILLA CONCEPCIÓN DEL TÍO'),
(2105, 22, 'VILLA CURA BROCHERO'),
(2106, 22, 'VILLA DE LAS ROSAS'),
(2107, 22, 'VILLA DE MARÍA'),
(2108, 22, 'VILLA DE POCHO'),
(2109, 22, 'VILLA DE SOTO'),
(2110, 22, 'VILLA DEL DIQUE'),
(2111, 22, 'VILLA DEL PRADO'),
(2112, 22, 'VILLA DEL ROSARIO'),
(2113, 22, 'VILLA DEL TOTORAL'),
(2114, 22, 'VILLA DOLORES'),
(2115, 22, 'VILLA EL CHACAY'),
(2116, 22, 'VILLA ELISA'),
(2117, 22, 'VILLA FLOR SERRANA'),
(2118, 22, 'VILLA FONTANA'),
(2119, 22, 'VILLA GENERAL BELGRANO'),
(2120, 22, 'VILLA GIARDINO'),
(2121, 22, 'VILLA GUTIÉRREZ'),
(2122, 22, 'VILLA HUIDOBRO'),
(2123, 22, 'VILLA ICHO CRUZ'),
(2124, 22, 'VILLA LA BOLSA'),
(2125, 22, 'VILLA LOS AROMOS'),
(2126, 22, 'VILLA LOS PATOS'),
(2127, 22, 'VILLA MARÍA'),
(2128, 22, 'VILLA NUEVA'),
(2129, 22, 'VILLA PARQUE SANTA ANA'),
(2130, 22, 'VILLA PARQUE SIQUIMAN'),
(2131, 22, 'VILLA QUILLINZO'),
(2132, 22, 'VILLA ROSSI'),
(2133, 22, 'VILLA RUMIPAL'),
(2134, 22, 'VILLA SAN ESTEBAN'),
(2135, 22, 'VILLA SAN ISIDRO'),
(2136, 22, 'VILLA SANTA CRUZ DEL LAGO'),
(2137, 22, 'VILLA SARMIENTO (G.R.)'),
(2138, 22, 'VILLA SARMIENTO (S.A.)'),
(2139, 22, 'VILLA TULUMBA'),
(2140, 22, 'VILLA YACANTO'),
(2141, 22, 'WASHINGTON'),
(2142, 22, 'WENCESLAO ESCALANTE'),
(2143, 23, 'ABDÓN CASTRO TOLAY'),
(2144, 23, 'ABRA PAMPA'),
(2145, 23, 'ABRALAITE'),
(2146, 23, 'AGUAS CALIENTES'),
(2147, 23, 'ARRAYANAL'),
(2148, 23, 'BARRIOS'),
(2149, 23, 'BARRO NEGRO'),
(2150, 23, 'CAIMANCITO'),
(2151, 23, 'CALILEGUA'),
(2152, 23, 'CANGREJILLOS'),
(2153, 23, 'CASPALÁ'),
(2154, 23, 'CATUA'),
(2155, 23, 'CIENEGUILLAS'),
(2156, 23, 'CORANZULI'),
(2157, 23, 'CUSI CUSI'),
(2158, 23, 'EL AGUILAR'),
(2159, 23, 'EL CARMEN'),
(2160, 23, 'EL CONDOR'),
(2161, 23, 'EL FUERTE'),
(2162, 23, 'EL PIQUETE'),
(2163, 23, 'EL TALAR'),
(2164, 23, 'FRAILE PINTADO'),
(2165, 23, 'HIPÓLITO YRIGOYEN'),
(2166, 23, 'HUACALERA'),
(2167, 23, 'HUMAHUACA'),
(2168, 23, 'LA ESPERANZA'),
(2169, 23, 'LA MENDIETA'),
(2170, 23, 'LA QUIACA'),
(2171, 23, 'LIBERTADOR GENERAL SAN MARTÍN'),
(2172, 23, 'MAIMARÁ'),
(2173, 23, 'MINA PIRQUITAS'),
(2174, 23, 'MONTERRICO'),
(2175, 23, 'PALMA SOLA'),
(2176, 23, 'PALPALÁ'),
(2177, 23, 'PAMPA BLANCA'),
(2178, 23, 'PAMPICHUELA'),
(2179, 23, 'PERICO'),
(2180, 23, 'PUESTO DEL MARQUÉS'),
(2181, 23, 'PUESTO VIEJO'),
(2182, 23, 'PUMAHUASI'),
(2183, 23, 'PURMAMARCA'),
(2184, 23, 'RINCONADA'),
(2185, 23, 'RODEÍTO'),
(2186, 23, 'SAN ANTONIO'),
(2187, 23, 'SAN FRANCISCO'),
(2188, 23, 'SAN PEDRO DE JUJUY'),
(2189, 23, 'SAN SALVADOR DE JUJUY'),
(2190, 23, 'SANTA ANA'),
(2191, 23, 'SANTA CATALINA'),
(2192, 23, 'SANTA CLARA'),
(2193, 23, 'SUSQUES'),
(2194, 23, 'TILCARA'),
(2195, 23, 'TRES CRUCES'),
(2196, 23, 'TUMBAYA'),
(2197, 23, 'VALLE GRANDE'),
(2198, 23, 'VINALITO'),
(2199, 23, 'VOLCÁN'),
(2200, 23, 'YALA'),
(2201, 23, 'YAVÍ'),
(2202, 23, 'YUTO'),
(2203, 24, 'CALETA OLIVIA'),
(2204, 24, 'CAÑADÓN SECO'),
(2205, 24, 'COMANDANTE LUIS PIEDRABUENA'),
(2206, 24, 'EL CALAFATE'),
(2207, 24, 'EL CHALTÉN'),
(2208, 24, 'GOBERNADOR GREGORES'),
(2209, 24, 'HIPÓLITO YRIGOYEN'),
(2210, 24, 'JARAMILLO'),
(2211, 24, 'KOLUEL KAYKE'),
(2212, 24, 'LAS HERAS'),
(2213, 24, 'LOS ANTIGUOS'),
(2214, 24, 'PERITO MORENO'),
(2215, 24, 'PICO TRUNCADO'),
(2216, 24, 'PUERTO DESEADO'),
(2217, 24, 'PUERTO SAN JULIÁN'),
(2218, 24, 'PUERTO SANTA CRUZ'),
(2219, 24, 'RÍO GALLEGOS'),
(2220, 24, 'RÍO TURBIO'),
(2221, 24, 'TRES LAGOS'),
(2222, 24, 'VEINTIOCHO DE NOVIEMBRE'),
(2223, 2, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protocolo`
--

CREATE TABLE `protocolo` (
  `pro_id` bigint(20) NOT NULL,
  `pro_titulo` text DEFAULT NULL COMMENT 'Descripción del estudio',
  `pro_titulo_breve` varchar(255) DEFAULT NULL COMMENT 'Título breve del estudio',
  `pro_codigo_estudio` varchar(255) NOT NULL COMMENT 'Código de estudio o Nombre referencia',
  `pro_target` int(11) NOT NULL COMMENT 'Cantidad de pacientes a enrolar',
  `pro_tes_id` int(11) DEFAULT NULL COMMENT 'Tipo estudio',
  `pro_fecha_inicio` date NOT NULL,
  `pro_fecha_fin` date DEFAULT NULL,
  `pro_sp_id` int(11) NOT NULL COMMENT 'Estado protocolo',
  `pro_tex_id` int(11) DEFAULT NULL COMMENT 'Con drogas S/N tipo_investigacion_experimental',
  `pro_fase_id` int(11) DEFAULT NULL COMMENT 'Fase investigacion, solo estudios con drogas',
  `pro_financiamiento` tinyint(4) DEFAULT NULL,
  `pro_sponsor` tinyint(4) NOT NULL,
  `pro_cro` tinyint(4) NOT NULL,
  `pro_industria` tinyint(4) DEFAULT NULL,
  `pro_contactos` text NOT NULL,
  `pro_financiamiento_temp_id` int(11) DEFAULT NULL,
  `pro_ent_id` bigint(20) DEFAULT NULL,
  `pro_status` int(11) DEFAULT NULL,
  `pro_ast_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `protocolo`
--

INSERT INTO `protocolo` (`pro_id`, `pro_titulo`, `pro_titulo_breve`, `pro_codigo_estudio`, `pro_target`, `pro_tes_id`, `pro_fecha_inicio`, `pro_fecha_fin`, `pro_sp_id`, `pro_tex_id`, `pro_fase_id`, `pro_financiamiento`, `pro_sponsor`, `pro_cro`, `pro_industria`, `pro_contactos`, `pro_financiamiento_temp_id`, `pro_ent_id`, `pro_status`, `pro_ast_id`) VALUES
(23, 'protocolo prueba protipac', 'test proto v1', '435345 1', 44, 4, '2020-04-30', '2020-08-04', 1, 2, NULL, 1, 0, 1, NULL, 'safsdfaaaa', NULL, NULL, NULL, 19),
(24, 'protocolo prueba protipac', 'test proto v2', '435345 2', 44, 4, '2020-07-31', NULL, 7, 2, NULL, 1, 0, 1, NULL, 'safsdf', NULL, NULL, NULL, 20),
(25, 'protocolo prueba protipac', 'test proto v3', '435345 3', 44, 4, '2020-07-31', NULL, 1, 2, NULL, 1, 0, 1, NULL, 'safsdf', NULL, NULL, NULL, 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protocolo_investigador`
--

CREATE TABLE `protocolo_investigador` (
  `proinv_pro_id` bigint(20) NOT NULL,
  `proinv_inv_id` bigint(20) NOT NULL,
  `proinv_tinv_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `protocolo_investigador`
--

INSERT INTO `protocolo_investigador` (`proinv_pro_id`, `proinv_inv_id`, `proinv_tinv_id`) VALUES
(23, 1, 1),
(24, 1, 1),
(25, 1, 1),
(23, 2, 2),
(24, 2, 2),
(25, 2, 2),
(23, 5, 2),
(24, 5, 2),
(25, 5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protocolo_log`
--

CREATE TABLE `protocolo_log` (
  `plog_id` bigint(20) NOT NULL,
  `plog_pro_id` bigint(20) NOT NULL,
  `plog_fecha_hora` datetime NOT NULL,
  `plog_usr_id` bigint(20) NOT NULL,
  `plog_sp_id` int(11) NOT NULL,
  `plog_comentario` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `protocolo_log`
--

INSERT INTO `protocolo_log` (`plog_id`, `plog_pro_id`, `plog_fecha_hora`, `plog_usr_id`, `plog_sp_id`, `plog_comentario`) VALUES
(34, 23, '2020-08-04 16:18:57', 1, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protocolo_paciente`
--

CREATE TABLE `protocolo_paciente` (
  `propac_pro_id` bigint(20) NOT NULL,
  `propac_pac_id` bigint(20) NOT NULL,
  `propac_nro_protocolo` varchar(255) DEFAULT NULL,
  `propac_nro_random` varchar(255) DEFAULT NULL,
  `propac_observaciones` text DEFAULT NULL,
  `propac_spp_id` int(11) DEFAULT NULL,
  `propac_med_id` int(11) DEFAULT NULL,
  `propac_screening` tinyint(4) DEFAULT NULL,
  `propac_basal` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `protocolo_paciente`
--

INSERT INTO `protocolo_paciente` (`propac_pro_id`, `propac_pac_id`, `propac_nro_protocolo`, `propac_nro_random`, `propac_observaciones`, `propac_spp_id`, `propac_med_id`, `propac_screening`, `propac_basal`) VALUES
(23, 1, '4564567', '45654678', NULL, 3, 1, 1, 1),
(24, 1, '786786', '234324234', NULL, 3, 1, 1, 1),
(25, 1, '435435', '456456', NULL, 3, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protocolo_paciente_log`
--

CREATE TABLE `protocolo_paciente_log` (
  `ppaclog_id` bigint(20) NOT NULL,
  `ppaclog_pro_id` bigint(20) NOT NULL,
  `ppaclog_fecha_hora` datetime NOT NULL,
  `ppaclog_usr_id` bigint(20) NOT NULL,
  `ppaclog_spp_id` int(11) NOT NULL,
  `ppaclog_comentario` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protocolo_paciente_visita`
--

CREATE TABLE `protocolo_paciente_visita` (
  `provis_id` bigint(20) NOT NULL,
  `provis_pro_id` bigint(20) NOT NULL,
  `provis_pac_id` bigint(20) NOT NULL,
  `provis_cron_id` bigint(20) DEFAULT NULL,
  `provis_descripcion` varchar(255) DEFAULT NULL,
  `provis_fecha_agenda` datetime NOT NULL,
  `provis_hora_agenda` time DEFAULT NULL,
  `provis_fecha_realizada` datetime DEFAULT NULL,
  `provis_hora_realizada` time DEFAULT NULL,
  `provis_sv_id` int(11) DEFAULT NULL,
  `provis_med_id` int(11) DEFAULT NULL,
  `provis_tiv_id` int(11) DEFAULT NULL,
  `provis_observaciones` text DEFAULT NULL,
  `provis_ventana_max` int(11) DEFAULT NULL,
  `provis_ventana_min` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `protocolo_paciente_visita`
--

INSERT INTO `protocolo_paciente_visita` (`provis_id`, `provis_pro_id`, `provis_pac_id`, `provis_cron_id`, `provis_descripcion`, `provis_fecha_agenda`, `provis_hora_agenda`, `provis_fecha_realizada`, `provis_hora_realizada`, `provis_sv_id`, `provis_med_id`, `provis_tiv_id`, `provis_observaciones`, `provis_ventana_max`, `provis_ventana_min`) VALUES
(1, 23, 1, 6, NULL, '2020-08-19 00:00:00', '10:00:00', '2020-08-19 00:00:00', '10:14:00', 1, 1, 1, 'test', 8, 8),
(2, 23, 1, 7, NULL, '2020-08-26 00:00:00', NULL, '2020-08-26 00:00:00', NULL, 1, 1, 2, NULL, NULL, NULL),
(3, 24, 1, 8, NULL, '2020-08-01 00:00:00', '05:14:00', '2020-08-01 00:00:00', '05:07:00', 1, 1, 1, '', 7, 7),
(4, 24, 1, 9, NULL, '2020-10-10 00:00:00', NULL, '2020-10-10 00:00:00', NULL, 1, 1, 2, NULL, NULL, NULL),
(15, 23, 1, NULL, 'Espontánea', '2020-08-28 00:00:00', '14:12:00', NULL, NULL, 2, 2, 5, 'test 2', NULL, NULL),
(24, 25, 1, 14, NULL, '2020-08-28 00:00:00', NULL, '2020-08-28 00:00:00', NULL, 1, 2, 1, NULL, 2, 2),
(25, 25, 1, 15, NULL, '2020-08-31 00:00:00', NULL, '2020-08-31 00:00:00', NULL, 1, 2, 2, NULL, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protocolo_paciente_visita_follow`
--

CREATE TABLE `protocolo_paciente_visita_follow` (
  `proseg_id` bigint(20) NOT NULL,
  `proseg_provis_id` bigint(20) NOT NULL,
  `proseg_fecha_hora` datetime NOT NULL,
  `proseg_observaciones` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `protocolo_paciente_visita_follow`
--

INSERT INTO `protocolo_paciente_visita_follow` (`proseg_id`, `proseg_provis_id`, `proseg_fecha_hora`, `proseg_observaciones`) VALUES
(1, 15, '2020-08-28 11:59:59', 'test'),
(2, 15, '2020-08-28 12:16:19', 'test 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protocolo_paciente_visita_lab`
--

CREATE TABLE `protocolo_paciente_visita_lab` (
  `prolab_pro_id` bigint(20) NOT NULL,
  `prolab_pac_id` bigint(20) NOT NULL,
  `prolab_cron_id` bigint(20) NOT NULL,
  `prolab_fecha_agenda` date NOT NULL,
  `prolab_hora_agenda` time NOT NULL,
  `prolab_fecha_realizada` date DEFAULT NULL,
  `prolab_hora_realizada` time DEFAULT NULL,
  `prolab_sv_id` int(11) NOT NULL,
  `prolab_med_id` int(11) NOT NULL,
  `prolab_tiv_id` int(11) NOT NULL,
  `prolab_observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Visitas laboratorio';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protocolo_patrocinador`
--

CREATE TABLE `protocolo_patrocinador` (
  `propat_pro_id` bigint(20) NOT NULL,
  `propat_emp_id` bigint(20) NOT NULL,
  `propat_trolpat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `protocolo_patrocinador`
--

INSERT INTO `protocolo_patrocinador` (`propat_pro_id`, `propat_emp_id`, `propat_trolpat_id`) VALUES
(23, 17, 2),
(25, 30, 2),
(23, 31, 1),
(24, 31, 1),
(24, 31, 2),
(25, 31, 1),
(23, 32, 3),
(24, 32, 3),
(25, 32, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `id_provincia` int(11) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `nombre_provincia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`id_provincia`, `id_pais`, `nombre_provincia`) VALUES
(1, 1, 'CABA'),
(2, 1, 'BUENOS AIRES'),
(3, 1, 'CATAMARCA'),
(4, 1, 'CORRIENTES'),
(5, 1, 'CHACO'),
(6, 1, 'SAN LUIS'),
(7, 1, 'TIERRA DEL FUEGO'),
(8, 1, 'SALTA'),
(9, 1, 'ENTRE R?OS'),
(10, 1, 'LA RIOJA'),
(11, 1, 'SANTIAGO DEL ESTERO'),
(12, 1, 'SAN JUAN'),
(13, 1, 'LA PAMPA'),
(14, 1, 'MENDOZA'),
(15, 1, 'MISIONES'),
(16, 1, 'FORMOSA'),
(17, 1, 'NEUQU?N'),
(18, 1, 'R?O NEGRO'),
(19, 1, 'SANTA F?\r'),
(20, 1, 'TUCUM?N'),
(21, 1, 'CHUBUT'),
(22, 1, 'C?RDOBA'),
(23, 1, 'JUJUY'),
(24, 1, 'SANTA CRUZ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referente`
--

CREATE TABLE `referente` (
  `der_id` bigint(20) NOT NULL,
  `der_descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `rol_id` int(10) NOT NULL,
  `rol_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rol_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rol_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`rol_id`, `rol_name`, `rol_code`, `rol_status`) VALUES
(1, 'Administrador', 'ADMIN', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_function`
--

CREATE TABLE `role_function` (
  `rfu_id` int(10) NOT NULL,
  `rfu_rol_id` int(11) NOT NULL DEFAULT 0,
  `rfu_fnc_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `role_function`
--

INSERT INTO `role_function` (`rfu_id`, `rfu_rol_id`, `rfu_fnc_id`) VALUES
(179, 1, 44),
(180, 1, 5),
(181, 1, 7),
(182, 1, 6),
(183, 1, 1),
(184, 1, 3),
(185, 1, 4),
(186, 1, 2),
(187, 1, 14),
(188, 1, 42),
(189, 1, 8),
(190, 1, 45),
(191, 1, 46),
(192, 1, 47),
(193, 1, 48),
(194, 1, 49),
(195, 1, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE `sexo` (
  `sex_id` int(11) NOT NULL,
  `sex_descripcion` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`sex_id`, `sex_descripcion`) VALUES
(1, 'F'),
(2, 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status_protocolo`
--

CREATE TABLE `status_protocolo` (
  `sp_id` int(11) NOT NULL,
  `sp_descripcion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sp_status` int(11) NOT NULL,
  `sp_texto_comentario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sp_estilo` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `status_protocolo`
--

INSERT INTO `status_protocolo` (`sp_id`, `sp_descripcion`, `sp_status`, `sp_texto_comentario`, `sp_estilo`) VALUES
(1, 'Abierto', 1, 'Protocolo abierto', 'label-primary'),
(3, 'Futuro', 1, 'Protocolo futuro', 'label-info'),
(4, 'Finalizado', 1, 'Protocolo finalizado', 'label-warning'),
(5, 'Sin asignar', 0, 'Sin asignar', 'label-success'),
(6, 'Suspendido', 1, 'Protocolo suspendido', 'label-danger'),
(7, 'Abierto enrolando', 1, 'Protocolo abierto enrolado', 'label-default'),
(14, 'Eliminado', 0, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status_protocolo_paciente`
--

CREATE TABLE `status_protocolo_paciente` (
  `spp_id` int(11) NOT NULL,
  `spp_descripcion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `spp_status` int(11) NOT NULL,
  `spp_texto_comentario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `spp_estilo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `spp_orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `status_protocolo_paciente`
--

INSERT INTO `status_protocolo_paciente` (`spp_id`, `spp_descripcion`, `spp_status`, `spp_texto_comentario`, `spp_estilo`, `spp_orden`) VALUES
(1, 'Screening', 1, 'Screening', 'label-primary', 1),
(3, 'En protocolo', 1, 'En protocolo', 'label-info', 3),
(4, 'Fallo screening', 1, 'Fallo screening', 'label-warning', 2),
(5, 'Completado', 1, 'Completado', 'label-success', 4),
(6, 'Discontinuado', 1, 'Discontinuado', 'label-danger', 5),
(7, 'Activo', 1, 'Activo', 'label-info', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status_visita`
--

CREATE TABLE `status_visita` (
  `sv_id` int(11) NOT NULL,
  `sv_descripcion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sv_status` int(11) NOT NULL,
  `sv_texto_comentario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sv_estilo` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `status_visita`
--

INSERT INTO `status_visita` (`sv_id`, `sv_descripcion`, `sv_status`, `sv_texto_comentario`, `sv_estilo`) VALUES
(1, 'Realizada', 1, 'Visita realizada', 'label-primary'),
(2, 'Cancelada', 1, 'Visita cancelada', 'label-danger'),
(3, 'Programada', 1, 'Visita programada', 'label-warning');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_contacto`
--

CREATE TABLE `tipo_contacto` (
  `tic_id` int(11) NOT NULL,
  `tic_descripcion` varchar(255) NOT NULL,
  `tic_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_contacto`
--

INSERT INTO `tipo_contacto` (`tic_id`, `tic_descripcion`, `tic_status`) VALUES
(1, 'Teléfono Otro', 1),
(2, 'Teléfono Celular', 1),
(3, 'Teléfono Casa', 1),
(4, 'Teléfono Celular', 1),
(5, 'Redes sociales', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `tid_id` int(11) NOT NULL,
  `tid_descripcion` varchar(255) DEFAULT NULL,
  `tid_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`tid_id`, `tid_descripcion`, `tid_status`) VALUES
(1, 'DNI', 1),
(2, 'Otro', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_empresa`
--

CREATE TABLE `tipo_empresa` (
  `temp_id` int(11) NOT NULL,
  `temp_descripcion` varchar(45) DEFAULT NULL,
  `temp_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tipo de empresa patrocinadora (CRO /  Industria farmac?utica / Empresa)';

--
-- Volcado de datos para la tabla `tipo_empresa`
--

INSERT INTO `tipo_empresa` (`temp_id`, `temp_descripcion`, `temp_status`) VALUES
(1, 'Empresa farmacéutica o de tecnología médica', 1),
(2, 'CRO', 1),
(3, 'Otros, Gob, ONG, Univ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_entidad`
--

CREATE TABLE `tipo_entidad` (
  `tie_id` int(11) NOT NULL,
  `tie_descripcion` varchar(255) NOT NULL,
  `tie_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_entidad`
--

INSERT INTO `tipo_entidad` (`tie_id`, `tie_descripcion`, `tie_status`) VALUES
(1, 'Investigador', 1),
(2, 'Patrocinador', 2),
(3, 'Usuario Huesped', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_estudio`
--

CREATE TABLE `tipo_estudio` (
  `tes_id` int(11) NOT NULL,
  `tes_descripcion` varchar(255) DEFAULT NULL,
  `tes_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tipo estudio NAIVE, FALLO, SWITCH, HEPATITIS, PEDIATRICO, OTROS';

--
-- Volcado de datos para la tabla `tipo_estudio`
--

INSERT INTO `tipo_estudio` (`tes_id`, `tes_descripcion`, `tes_status`) VALUES
(1, 'NAIVE', 1),
(2, 'FALLO', 1),
(3, 'SWITCH', 1),
(4, 'HEPATITIS', 1),
(5, 'PEDIATRICO', 1),
(6, 'OTROS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_investigacion_experimental`
--

CREATE TABLE `tipo_investigacion_experimental` (
  `tex_id` int(11) NOT NULL,
  `tex_descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Con drogas o dispositivos / Sin drogas o dispositivos';

--
-- Volcado de datos para la tabla `tipo_investigacion_experimental`
--

INSERT INTO `tipo_investigacion_experimental` (`tex_id`, `tex_descripcion`) VALUES
(1, 'Sí'),
(2, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_investigador`
--

CREATE TABLE `tipo_investigador` (
  `tinv_id` int(4) NOT NULL,
  `tinv_descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_investigador`
--

INSERT INTO `tipo_investigador` (`tinv_id`, `tinv_descripcion`) VALUES
(1, 'Investigador Principal'),
(2, 'Subinvestigador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_link`
--

CREATE TABLE `tipo_link` (
  `type_id` int(11) NOT NULL,
  `type_descripcion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_link`
--

INSERT INTO `tipo_link` (`type_id`, `type_descripcion`) VALUES
(1, 'Imagen'),
(2, 'Adjunto'),
(3, 'Link');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_rol_patrocinador`
--

CREATE TABLE `tipo_rol_patrocinador` (
  `trolpat_id` int(11) NOT NULL,
  `trolpat_descripccion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_rol_patrocinador`
--

INSERT INTO `tipo_rol_patrocinador` (`trolpat_id`, `trolpat_descripccion`) VALUES
(1, 'CRO'),
(2, 'Sponsor'),
(3, 'Financiador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_visita`
--

CREATE TABLE `tipo_visita` (
  `tiv_id` int(11) NOT NULL,
  `tiv_descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_visita`
--

INSERT INTO `tipo_visita` (`tiv_id`, `tiv_descripcion`) VALUES
(1, 'Screening'),
(2, 'Basal'),
(3, 'Control'),
(4, 'Follow-up'),
(5, 'Espontánea');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `usr_id` bigint(11) NOT NULL,
  `usr_ast_id` bigint(11) NOT NULL DEFAULT 0,
  `usr_login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usr_pass` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_lastname` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_dateCreated` int(11) DEFAULT NULL,
  `usr_timeCreated` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_dateLastLogin` int(11) NOT NULL DEFAULT 0,
  `usr_status` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_lng_id` int(11) NOT NULL DEFAULT 0,
  `usr_dateModified` int(11) DEFAULT NULL,
  `usr_timeModified` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_id_usr_modified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`usr_id`, `usr_ast_id`, `usr_login`, `usr_pass`, `usr_name`, `usr_lastname`, `usr_email`, `usr_dateCreated`, `usr_timeCreated`, `usr_dateLastLogin`, `usr_status`, `usr_lng_id`, `usr_dateModified`, `usr_timeModified`, `usr_id_usr_modified`) VALUES
(1, 1, 'adm', 'e10adc3949ba59abbe56e057f20f883e', 'Administrador', 'Dirección', 'laurayantonietti@gmail.com', 20181105, '15:17:00', 20200828, '1', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userrole`
--

CREATE TABLE `userrole` (
  `uro_id` bigint(11) NOT NULL,
  `uro_usr_id` bigint(11) NOT NULL DEFAULT 0,
  `uro_rol_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `userrole`
--

INSERT INTO `userrole` (`uro_id`, `uro_usr_id`, `uro_rol_id`) VALUES
(131, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asset`
--
ALTER TABLE `asset`
  ADD PRIMARY KEY (`ast_id`),
  ADD UNIQUE KEY `XPKasset` (`ast_id`),
  ADD KEY `user` (`ast_creator_usr_id`),
  ADD KEY `fk_asset_assettype` (`ast_type`);

--
-- Indices de la tabla `assetcomment`
--
ALTER TABLE `assetcomment`
  ADD PRIMARY KEY (`com_id`),
  ADD UNIQUE KEY `com_ast_id` (`com_ast_id`),
  ADD UNIQUE KEY `com_usr_id` (`com_usr_id`),
  ADD KEY `com_tic_id` (`com_tic_id`);

--
-- Indices de la tabla `assettype`
--
ALTER TABLE `assettype`
  ADD PRIMARY KEY (`aty_id`);

--
-- Indices de la tabla `categoria_visita`
--
ALTER TABLE `categoria_visita`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `cronograma_visita`
--
ALTER TABLE `cronograma_visita`
  ADD PRIMARY KEY (`cron_id`),
  ADD KEY `cron_pro_id` (`cron_pro_id`),
  ADD KEY `cron_tiv_id` (`cron_tiv_id`),
  ADD KEY `cron_crvn_id` (`cron_descripcion`(191)),
  ADD KEY `cron_crvn_id_2` (`cron_crvn_id`);

--
-- Indices de la tabla `cronograma_visita_nombre`
--
ALTER TABLE `cronograma_visita_nombre`
  ADD PRIMARY KEY (`crvn_id`);

--
-- Indices de la tabla `efector`
--
ALTER TABLE `efector`
  ADD PRIMARY KEY (`efe_id`),
  ADD KEY `efe_nivel_id` (`efe_nivel_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `fk_empresa_entidad1` (`emp_ent_id`);

--
-- Indices de la tabla `entidad`
--
ALTER TABLE `entidad`
  ADD PRIMARY KEY (`ent_id`),
  ADD KEY `fk_entidad_provincia1` (`ent_domicilio_id_provincia`),
  ADD KEY `fk_entidad_localidad1` (`ent_domicilio_id_localidad`),
  ADD KEY `ent_ast_id` (`ent_ast_id`),
  ADD KEY `ent_tie_id` (`ent_tie_id`);

--
-- Indices de la tabla `fase_investigacion`
--
ALTER TABLE `fase_investigacion`
  ADD PRIMARY KEY (`fase_id`);

--
-- Indices de la tabla `function`
--
ALTER TABLE `function`
  ADD PRIMARY KEY (`fnc_id`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`gen_id`);

--
-- Indices de la tabla `hospital_referente`
--
ALTER TABLE `hospital_referente`
  ADD PRIMARY KEY (`reh_id`);

--
-- Indices de la tabla `investigador`
--
ALTER TABLE `investigador`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indices de la tabla `investigador_tipo`
--
ALTER TABLE `investigador_tipo`
  ADD PRIMARY KEY (`invtipo_tinv_id`,`invtipo_inv_id`),
  ADD KEY `invtipo_inv_id` (`invtipo_inv_id`);

--
-- Indices de la tabla `link`
--
ALTER TABLE `link`
  ADD PRIMARY KEY (`lnk_id`,`lnk_ast_id`),
  ADD KEY `lnk_ast_id_contenido` (`lnk_ast_id`),
  ADD KEY `lnk_tadj_id` (`lnk_tadj_id`),
  ADD KEY `id_usuario` (`lnk_usr_id_creacion`),
  ADD KEY `lnk_usr_id_modified` (`lnk_usr_id_modified`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`id_localidad`),
  ADD KEY `id_partido` (`id_partido`);

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`med_id`);

--
-- Indices de la tabla `medico_off`
--
ALTER TABLE `medico_off`
  ADD PRIMARY KEY (`medoff_id`);

--
-- Indices de la tabla `observacion`
--
ALTER TABLE `observacion`
  ADD PRIMARY KEY (`obs_id`),
  ADD KEY `obs_ast_id` (`obs_ast_id`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`pac_id`),
  ADD KEY `pac_tid_id` (`pac_tid_id`),
  ADD KEY `pac_gen_id` (`pac_gen_id`),
  ADD KEY `pac_der_id` (`pac_der_id`),
  ADD KEY `pac_reh_id` (`pac_reh_id`),
  ADD KEY `pac_sex_id` (`pac_sex_id`),
  ADD KEY `pac_ent_id` (`pac_ent_id`);

--
-- Indices de la tabla `paciente_contacto`
--
ALTER TABLE `paciente_contacto`
  ADD PRIMARY KEY (`pcon_id`),
  ADD KEY `pcon_pac_id` (`pcon_pac_id`),
  ADD KEY `pcon_tic_id` (`pcon_tic_id`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id_pais`),
  ADD UNIQUE KEY `XPKpais` (`id_pais`);

--
-- Indices de la tabla `partido`
--
ALTER TABLE `partido`
  ADD PRIMARY KEY (`id_partido`),
  ADD KEY `id_provincia` (`id_provincia`);

--
-- Indices de la tabla `protocolo`
--
ALTER TABLE `protocolo`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `fk_proyecto_fase_investigacion1` (`pro_fase_id`),
  ADD KEY `pro_financiamiento_temp_id` (`pro_financiamiento_temp_id`),
  ADD KEY `pro_ent_id` (`pro_ent_id`),
  ADD KEY `pro_financiamiento` (`pro_financiamiento`),
  ADD KEY `pro_status` (`pro_status`),
  ADD KEY `pro_ast_id` (`pro_ast_id`),
  ADD KEY `pro_tes_id` (`pro_tes_id`),
  ADD KEY `pro_sp_id` (`pro_sp_id`),
  ADD KEY `pro_tex_id` (`pro_tex_id`);

--
-- Indices de la tabla `protocolo_investigador`
--
ALTER TABLE `protocolo_investigador`
  ADD PRIMARY KEY (`proinv_inv_id`,`proinv_pro_id`),
  ADD KEY `fk_proyecto_has_investigador` (`proinv_inv_id`),
  ADD KEY `fk_proyecto_has_proyecto1` (`proinv_pro_id`),
  ADD KEY `proinv_tinv_id` (`proinv_tinv_id`);

--
-- Indices de la tabla `protocolo_log`
--
ALTER TABLE `protocolo_log`
  ADD PRIMARY KEY (`plog_id`),
  ADD KEY `plog_pro_id` (`plog_pro_id`),
  ADD KEY `plog_usr_id` (`plog_usr_id`),
  ADD KEY `plog_sp_id` (`plog_sp_id`);

--
-- Indices de la tabla `protocolo_paciente`
--
ALTER TABLE `protocolo_paciente`
  ADD PRIMARY KEY (`propac_pro_id`,`propac_pac_id`),
  ADD KEY `propac_pac_id` (`propac_pac_id`),
  ADD KEY `propac_spp_id` (`propac_spp_id`),
  ADD KEY `propac_pro_id` (`propac_pro_id`),
  ADD KEY `propac_med_id` (`propac_med_id`);

--
-- Indices de la tabla `protocolo_paciente_log`
--
ALTER TABLE `protocolo_paciente_log`
  ADD PRIMARY KEY (`ppaclog_id`),
  ADD KEY `ppaclog_pro_id` (`ppaclog_pro_id`),
  ADD KEY `ppaclog_usr_id` (`ppaclog_usr_id`),
  ADD KEY `ppaclog_spp_id` (`ppaclog_spp_id`);

--
-- Indices de la tabla `protocolo_paciente_visita`
--
ALTER TABLE `protocolo_paciente_visita`
  ADD PRIMARY KEY (`provis_id`),
  ADD KEY `provis_pro_id` (`provis_pro_id`),
  ADD KEY `provis_cron_id` (`provis_cron_id`),
  ADD KEY `provis_sv_id` (`provis_sv_id`),
  ADD KEY `provis_med_id` (`provis_med_id`),
  ADD KEY `prolab_tiv_id` (`provis_tiv_id`),
  ADD KEY `provis_pac_id` (`provis_pac_id`,`provis_pro_id`);

--
-- Indices de la tabla `protocolo_paciente_visita_follow`
--
ALTER TABLE `protocolo_paciente_visita_follow`
  ADD PRIMARY KEY (`proseg_id`),
  ADD KEY `proseg_provis_id` (`proseg_provis_id`);

--
-- Indices de la tabla `protocolo_paciente_visita_lab`
--
ALTER TABLE `protocolo_paciente_visita_lab`
  ADD PRIMARY KEY (`prolab_pac_id`,`prolab_cron_id`),
  ADD KEY `prolab_pro_id` (`prolab_pro_id`),
  ADD KEY `prolab_cron_id` (`prolab_cron_id`),
  ADD KEY `prolab_sv_id` (`prolab_sv_id`),
  ADD KEY `prolab_med_id` (`prolab_med_id`),
  ADD KEY `prolab_tiv_id` (`prolab_tiv_id`);

--
-- Indices de la tabla `protocolo_patrocinador`
--
ALTER TABLE `protocolo_patrocinador`
  ADD PRIMARY KEY (`propat_emp_id`,`propat_pro_id`,`propat_trolpat_id`) USING BTREE,
  ADD KEY `fk_proyecto_has_empresa_empresa1` (`propat_emp_id`),
  ADD KEY `fk_proyecto_has_empresa_proyecto1` (`propat_pro_id`),
  ADD KEY `propat_trolpat_id` (`propat_trolpat_id`),
  ADD KEY `propat_emp_id` (`propat_emp_id`),
  ADD KEY `propat_pro_id` (`propat_pro_id`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id_provincia`),
  ADD KEY `id_pais` (`id_pais`);

--
-- Indices de la tabla `referente`
--
ALTER TABLE `referente`
  ADD PRIMARY KEY (`der_id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indices de la tabla `role_function`
--
ALTER TABLE `role_function`
  ADD PRIMARY KEY (`rfu_id`),
  ADD KEY `rfu_fnc_id` (`rfu_fnc_id`),
  ADD KEY `rfu_rol_id` (`rfu_rol_id`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`sex_id`);

--
-- Indices de la tabla `status_protocolo`
--
ALTER TABLE `status_protocolo`
  ADD PRIMARY KEY (`sp_id`);

--
-- Indices de la tabla `status_protocolo_paciente`
--
ALTER TABLE `status_protocolo_paciente`
  ADD PRIMARY KEY (`spp_id`);

--
-- Indices de la tabla `status_visita`
--
ALTER TABLE `status_visita`
  ADD PRIMARY KEY (`sv_id`);

--
-- Indices de la tabla `tipo_contacto`
--
ALTER TABLE `tipo_contacto`
  ADD PRIMARY KEY (`tic_id`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`tid_id`);

--
-- Indices de la tabla `tipo_empresa`
--
ALTER TABLE `tipo_empresa`
  ADD PRIMARY KEY (`temp_id`);

--
-- Indices de la tabla `tipo_entidad`
--
ALTER TABLE `tipo_entidad`
  ADD PRIMARY KEY (`tie_id`);

--
-- Indices de la tabla `tipo_estudio`
--
ALTER TABLE `tipo_estudio`
  ADD PRIMARY KEY (`tes_id`);

--
-- Indices de la tabla `tipo_investigacion_experimental`
--
ALTER TABLE `tipo_investigacion_experimental`
  ADD PRIMARY KEY (`tex_id`);

--
-- Indices de la tabla `tipo_investigador`
--
ALTER TABLE `tipo_investigador`
  ADD PRIMARY KEY (`tinv_id`);

--
-- Indices de la tabla `tipo_link`
--
ALTER TABLE `tipo_link`
  ADD PRIMARY KEY (`type_id`);

--
-- Indices de la tabla `tipo_rol_patrocinador`
--
ALTER TABLE `tipo_rol_patrocinador`
  ADD PRIMARY KEY (`trolpat_id`);

--
-- Indices de la tabla `tipo_visita`
--
ALTER TABLE `tipo_visita`
  ADD PRIMARY KEY (`tiv_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `XPKuser` (`usr_id`),
  ADD KEY `usr_login` (`usr_login`),
  ADD KEY `astid` (`usr_ast_id`);

--
-- Indices de la tabla `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`uro_id`),
  ADD KEY `uroFK` (`uro_usr_id`),
  ADD KEY `urorolFk` (`uro_rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asset`
--
ALTER TABLE `asset`
  MODIFY `ast_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `assetcomment`
--
ALTER TABLE `assetcomment`
  MODIFY `com_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria_visita`
--
ALTER TABLE `categoria_visita`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cronograma_visita`
--
ALTER TABLE `cronograma_visita`
  MODIFY `cron_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `cronograma_visita_nombre`
--
ALTER TABLE `cronograma_visita_nombre`
  MODIFY `crvn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `efector`
--
ALTER TABLE `efector`
  MODIFY `efe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `emp_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `entidad`
--
ALTER TABLE `entidad`
  MODIFY `ent_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fase_investigacion`
--
ALTER TABLE `fase_investigacion`
  MODIFY `fase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `function`
--
ALTER TABLE `function`
  MODIFY `fnc_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `gen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `hospital_referente`
--
ALTER TABLE `hospital_referente`
  MODIFY `reh_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `investigador`
--
ALTER TABLE `investigador`
  MODIFY `inv_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `link`
--
ALTER TABLE `link`
  MODIFY `lnk_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `med_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `medico_off`
--
ALTER TABLE `medico_off`
  MODIFY `medoff_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `observacion`
--
ALTER TABLE `observacion`
  MODIFY `obs_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `pac_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `paciente_contacto`
--
ALTER TABLE `paciente_contacto`
  MODIFY `pcon_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `protocolo`
--
ALTER TABLE `protocolo`
  MODIFY `pro_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `protocolo_log`
--
ALTER TABLE `protocolo_log`
  MODIFY `plog_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `protocolo_paciente_log`
--
ALTER TABLE `protocolo_paciente_log`
  MODIFY `ppaclog_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `protocolo_paciente_visita`
--
ALTER TABLE `protocolo_paciente_visita`
  MODIFY `provis_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `protocolo_paciente_visita_follow`
--
ALTER TABLE `protocolo_paciente_visita_follow`
  MODIFY `proseg_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `referente`
--
ALTER TABLE `referente`
  MODIFY `der_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `rol_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `role_function`
--
ALTER TABLE `role_function`
  MODIFY `rfu_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `sex_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `status_protocolo`
--
ALTER TABLE `status_protocolo`
  MODIFY `sp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `status_protocolo_paciente`
--
ALTER TABLE `status_protocolo_paciente`
  MODIFY `spp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `status_visita`
--
ALTER TABLE `status_visita`
  MODIFY `sv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_empresa`
--
ALTER TABLE `tipo_empresa`
  MODIFY `temp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_estudio`
--
ALTER TABLE `tipo_estudio`
  MODIFY `tes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_investigador`
--
ALTER TABLE `tipo_investigador`
  MODIFY `tinv_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_rol_patrocinador`
--
ALTER TABLE `tipo_rol_patrocinador`
  MODIFY `trolpat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_visita`
--
ALTER TABLE `tipo_visita`
  MODIFY `tiv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cronograma_visita`
--
ALTER TABLE `cronograma_visita`
  ADD CONSTRAINT `cronograma_visita_ibfk_2` FOREIGN KEY (`cron_pro_id`) REFERENCES `protocolo` (`pro_id`),
  ADD CONSTRAINT `cronograma_visita_ibfk_3` FOREIGN KEY (`cron_tiv_id`) REFERENCES `tipo_visita` (`tiv_id`),
  ADD CONSTRAINT `cronograma_visita_ibfk_4` FOREIGN KEY (`cron_crvn_id`) REFERENCES `cronograma_visita_nombre` (`crvn_id`);

--
-- Filtros para la tabla `investigador_tipo`
--
ALTER TABLE `investigador_tipo`
  ADD CONSTRAINT `investigador_tipo_ibfk_1` FOREIGN KEY (`invtipo_tinv_id`) REFERENCES `tipo_investigador` (`tinv_id`),
  ADD CONSTRAINT `investigador_tipo_ibfk_2` FOREIGN KEY (`invtipo_inv_id`) REFERENCES `investigador` (`inv_id`);

--
-- Filtros para la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD CONSTRAINT `localidad_ibfk_1` FOREIGN KEY (`id_partido`) REFERENCES `partido` (`id_partido`);

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`pac_der_id`) REFERENCES `referente` (`der_id`),
  ADD CONSTRAINT `paciente_ibfk_2` FOREIGN KEY (`pac_gen_id`) REFERENCES `genero` (`gen_id`),
  ADD CONSTRAINT `paciente_ibfk_3` FOREIGN KEY (`pac_tid_id`) REFERENCES `tipo_documento` (`tid_id`),
  ADD CONSTRAINT `paciente_ibfk_4` FOREIGN KEY (`pac_reh_id`) REFERENCES `hospital_referente` (`reh_id`),
  ADD CONSTRAINT `paciente_ibfk_5` FOREIGN KEY (`pac_sex_id`) REFERENCES `sexo` (`sex_id`),
  ADD CONSTRAINT `paciente_ibfk_6` FOREIGN KEY (`pac_ent_id`) REFERENCES `entidad` (`ent_id`);

--
-- Filtros para la tabla `paciente_contacto`
--
ALTER TABLE `paciente_contacto`
  ADD CONSTRAINT `paciente_contacto_ibfk_1` FOREIGN KEY (`pcon_pac_id`) REFERENCES `paciente` (`pac_id`),
  ADD CONSTRAINT `paciente_contacto_ibfk_2` FOREIGN KEY (`pcon_tic_id`) REFERENCES `tipo_contacto` (`tic_id`);

--
-- Filtros para la tabla `partido`
--
ALTER TABLE `partido`
  ADD CONSTRAINT `partido_ibfk_1` FOREIGN KEY (`id_provincia`) REFERENCES `provincia` (`id_provincia`);

--
-- Filtros para la tabla `protocolo`
--
ALTER TABLE `protocolo`
  ADD CONSTRAINT `protocolo_ibfk_1` FOREIGN KEY (`pro_tes_id`) REFERENCES `tipo_estudio` (`tes_id`),
  ADD CONSTRAINT `protocolo_ibfk_3` FOREIGN KEY (`pro_fase_id`) REFERENCES `fase_investigacion` (`fase_id`),
  ADD CONSTRAINT `protocolo_ibfk_5` FOREIGN KEY (`pro_sp_id`) REFERENCES `status_protocolo` (`sp_id`),
  ADD CONSTRAINT `protocolo_ibfk_6` FOREIGN KEY (`pro_tex_id`) REFERENCES `tipo_investigacion_experimental` (`tex_id`);

--
-- Filtros para la tabla `protocolo_investigador`
--
ALTER TABLE `protocolo_investigador`
  ADD CONSTRAINT `fk_proyecto_has_proyecto1` FOREIGN KEY (`proinv_pro_id`) REFERENCES `protocolo` (`pro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `protocolo_investigador_ibfk_2` FOREIGN KEY (`proinv_inv_id`) REFERENCES `investigador` (`inv_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `protocolo_investigador_ibfk_3` FOREIGN KEY (`proinv_tinv_id`) REFERENCES `tipo_investigador` (`tinv_id`);

--
-- Filtros para la tabla `protocolo_paciente`
--
ALTER TABLE `protocolo_paciente`
  ADD CONSTRAINT `protocolo_paciente_ibfk_1` FOREIGN KEY (`propac_pac_id`) REFERENCES `paciente` (`pac_id`),
  ADD CONSTRAINT `protocolo_paciente_ibfk_2` FOREIGN KEY (`propac_pro_id`) REFERENCES `protocolo` (`pro_id`),
  ADD CONSTRAINT `protocolo_paciente_ibfk_3` FOREIGN KEY (`propac_spp_id`) REFERENCES `status_protocolo_paciente` (`spp_id`),
  ADD CONSTRAINT `protocolo_paciente_ibfk_4` FOREIGN KEY (`propac_med_id`) REFERENCES `medico` (`med_id`);

--
-- Filtros para la tabla `protocolo_paciente_visita`
--
ALTER TABLE `protocolo_paciente_visita`
  ADD CONSTRAINT `protocolo_paciente_visita_ibfk_4` FOREIGN KEY (`provis_sv_id`) REFERENCES `status_visita` (`sv_id`),
  ADD CONSTRAINT `protocolo_paciente_visita_ibfk_5` FOREIGN KEY (`provis_med_id`) REFERENCES `medico` (`med_id`),
  ADD CONSTRAINT `protocolo_paciente_visita_ibfk_6` FOREIGN KEY (`provis_tiv_id`) REFERENCES `tipo_visita` (`tiv_id`),
  ADD CONSTRAINT `protocolo_paciente_visita_ibfk_7` FOREIGN KEY (`provis_cron_id`) REFERENCES `cronograma_visita` (`cron_id`),
  ADD CONSTRAINT `protocolo_paciente_visita_ibfk_8` FOREIGN KEY (`provis_pac_id`) REFERENCES `paciente` (`pac_id`);

--
-- Filtros para la tabla `protocolo_paciente_visita_follow`
--
ALTER TABLE `protocolo_paciente_visita_follow`
  ADD CONSTRAINT `protocolo_paciente_visita_follow_ibfk_1` FOREIGN KEY (`proseg_provis_id`) REFERENCES `protocolo_paciente_visita` (`provis_id`);

--
-- Filtros para la tabla `protocolo_paciente_visita_lab`
--
ALTER TABLE `protocolo_paciente_visita_lab`
  ADD CONSTRAINT `protocolo_paciente_visita_lab_ibfk_1` FOREIGN KEY (`prolab_pac_id`) REFERENCES `paciente` (`pac_id`),
  ADD CONSTRAINT `protocolo_paciente_visita_lab_ibfk_2` FOREIGN KEY (`prolab_pro_id`) REFERENCES `protocolo` (`pro_id`),
  ADD CONSTRAINT `protocolo_paciente_visita_lab_ibfk_3` FOREIGN KEY (`prolab_cron_id`) REFERENCES `cronograma_visita` (`cron_id`),
  ADD CONSTRAINT `protocolo_paciente_visita_lab_ibfk_4` FOREIGN KEY (`prolab_sv_id`) REFERENCES `status_visita` (`sv_id`),
  ADD CONSTRAINT `protocolo_paciente_visita_lab_ibfk_5` FOREIGN KEY (`prolab_med_id`) REFERENCES `medico` (`med_id`),
  ADD CONSTRAINT `protocolo_paciente_visita_lab_ibfk_6` FOREIGN KEY (`prolab_tiv_id`) REFERENCES `tipo_visita` (`tiv_id`);

--
-- Filtros para la tabla `protocolo_patrocinador`
--
ALTER TABLE `protocolo_patrocinador`
  ADD CONSTRAINT `protocolo_patrocinador_ibfk_1` FOREIGN KEY (`propat_emp_id`) REFERENCES `empresa` (`emp_id`),
  ADD CONSTRAINT `protocolo_patrocinador_ibfk_2` FOREIGN KEY (`propat_pro_id`) REFERENCES `protocolo` (`pro_id`),
  ADD CONSTRAINT `protocolo_patrocinador_ibfk_3` FOREIGN KEY (`propat_trolpat_id`) REFERENCES `tipo_rol_patrocinador` (`trolpat_id`);

--
-- Filtros para la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD CONSTRAINT `provincia_ibfk_1` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id_pais`);

--
-- Filtros para la tabla `role_function`
--
ALTER TABLE `role_function`
  ADD CONSTRAINT `role_function_ibfk_1` FOREIGN KEY (`rfu_rol_id`) REFERENCES `role` (`rol_id`),
  ADD CONSTRAINT `role_function_ibfk_2` FOREIGN KEY (`rfu_fnc_id`) REFERENCES `function` (`fnc_id`);

--
-- Filtros para la tabla `userrole`
--
ALTER TABLE `userrole`
  ADD CONSTRAINT `userrole_ibfk_1` FOREIGN KEY (`uro_rol_id`) REFERENCES `role` (`rol_id`),
  ADD CONSTRAINT `userrole_ibfk_2` FOREIGN KEY (`uro_usr_id`) REFERENCES `user` (`usr_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
