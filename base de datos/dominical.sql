-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-12-2018 a las 16:22:35
-- Versión del servidor: 5.5.62-0ubuntu0.14.04.1
-- Versión de PHP: 7.2.11-4+ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `dominical`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE IF NOT EXISTS `bitacora` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_hora` datetime NOT NULL,
  `accion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bitacora_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE IF NOT EXISTS `clases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL,
  `ofrenda` double(12,2) NOT NULL DEFAULT '0.00',
  `impartida` tinyint(1) NOT NULL DEFAULT '0',
  `grupo_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clases_grupo_id_foreign` (`grupo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases_miembros`
--

CREATE TABLE IF NOT EXISTS `clases_miembros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clase_id` int(10) unsigned NOT NULL,
  `miembro_id` int(10) unsigned NOT NULL,
  `ocupacion` enum('F','A','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `asistencia` enum('espera','si','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'espera',
  PRIMARY KEY (`id`),
  KEY `clases_miembros_clase_id_foreign` (`clase_id`),
  KEY `clases_miembros_miembro_id_foreign` (`miembro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad_ini` int(11) NOT NULL,
  `edad_fin` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_facilitadores`
--

CREATE TABLE IF NOT EXISTS `grupos_facilitadores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grupo_id` int(10) unsigned NOT NULL,
  `miembro_id` int(10) unsigned NOT NULL,
  `ocupacion` enum('F','A') COLLATE utf8mb4_unicode_ci NOT NULL,
  `turno` enum('M','T','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `grupos_facilitadores_grupo_id_foreign` (`grupo_id`),
  KEY `grupos_facilitadores_miembro_id_foreign` (`miembro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros`
--

CREATE TABLE IF NOT EXISTS `miembros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cedula` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` enum('F','M') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nac` date NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('F','P','FP') COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` enum('invitado','activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_08_27_190711_create_bitacora_table', 1),
(4, '2018_08_27_195203_create_miembros_table', 1),
(5, '2018_08_27_201154_create_observaciones_inactivos_table', 1),
(6, '2018_08_27_201436_create_grupos_table', 1),
(7, '2018_08_27_201713_create_grupos_facilitadores_table', 1),
(8, '2018_08_27_202047_create_clases_table', 1),
(9, '2018_08_27_202622_create_observaciones_clases_table', 1),
(10, '2018_08_27_202801_create_clases_miembros_table', 1),
(11, '2018_08_27_203318_create_observaciones_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observaciones`
--

CREATE TABLE IF NOT EXISTS `observaciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clase_miembro_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `observaciones_clase_miembro_id_foreign` (`clase_miembro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observaciones_clases`
--

CREATE TABLE IF NOT EXISTS `observaciones_clases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clase_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `observaciones_clases_clase_id_foreign` (`clase_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observaciones_inactivos`
--

CREATE TABLE IF NOT EXISTS `observaciones_inactivos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_hora` datetime NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `miembro_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `observaciones_inactivos_miembro_id_foreign` (`miembro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pregunta` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `respuesta` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` tinyint(1) NOT NULL DEFAULT '0',
  `habilitado` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `apellido`, `email`, `password`, `pregunta`, `respuesta`, `rol`, `habilitado`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, 'admin', 'administrador', 'alejandraas@gmail.com', '$2y$10$MRLQGxWchGknsGof9bZoOuN6zvf5it5b9plYTbXYGPwweH87b9w8m', '¿estado donde nacio?', 'guarico', 1, 1, '3BeKKrRJrDNjozcJ8MCYHkBdvSWBMDpmTRiLSnDbaQHgghw0Bvq1jiPXWKp3', '2018-11-28 11:30:49', '2018-12-02 17:17:22', NULL),
(13, 'aron', 'figuera', 'aron@gmail.com', '$2y$10$b4jfwO4BYwPPteIq5CNnf.DS4aiK6enfnrQrp9scBc9zU1KcLw8IK', '¿pais donde vive?', 'venezuela', 0, 1, 'UymjI16uMHs1b1sCboYZSSHuYzn14BqUXYX32jvSe0dYFguWXPpuJE7XoxVX', '2018-11-28 11:37:49', '2018-11-28 11:37:49', NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clases`
--
ALTER TABLE `clases`
  ADD CONSTRAINT `clases_grupo_id_foreign` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clases_miembros`
--
ALTER TABLE `clases_miembros`
  ADD CONSTRAINT `clases_miembros_clase_id_foreign` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clases_miembros_miembro_id_foreign` FOREIGN KEY (`miembro_id`) REFERENCES `miembros` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `grupos_facilitadores`
--
ALTER TABLE `grupos_facilitadores`
  ADD CONSTRAINT `grupos_facilitadores_grupo_id_foreign` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grupos_facilitadores_miembro_id_foreign` FOREIGN KEY (`miembro_id`) REFERENCES `miembros` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `observaciones`
--
ALTER TABLE `observaciones`
  ADD CONSTRAINT `observaciones_clase_miembro_id_foreign` FOREIGN KEY (`clase_miembro_id`) REFERENCES `clases_miembros` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `observaciones_clases`
--
ALTER TABLE `observaciones_clases`
  ADD CONSTRAINT `observaciones_clases_clase_id_foreign` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `observaciones_inactivos`
--
ALTER TABLE `observaciones_inactivos`
  ADD CONSTRAINT `observaciones_inactivos_miembro_id_foreign` FOREIGN KEY (`miembro_id`) REFERENCES `miembros` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
