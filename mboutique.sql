-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 02-07-2024 a las 04:34:00
-- Versión del servidor: 5.7.44
-- Versión de PHP: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mboutique`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Producto_almacen`
--

CREATE TABLE `Producto_almacen` (
  `id_producto_almacen` int(11) NOT NULL,
  `nombre_producto` varchar(60) DEFAULT NULL,
  `descripcion` varchar(90) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Producto_almacen`
--

INSERT INTO `Producto_almacen` (`id_producto_almacen`, `nombre_producto`, `descripcion`, `cantidad`, `precio_unitario`) VALUES
(1, 'Mochila', 'Rojo', 2, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Rol`
--

CREATE TABLE `Rol` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(60) DEFAULT NULL,
  `estado` enum('active','inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Rol`
--

INSERT INTO `Rol` (`id_rol`, `rol`, `estado`) VALUES
(1, 'almacen', 'active'),
(2, 'tienda', 'active'),
(3, 'administrador', 'active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE `Usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `ape_paterno` varchar(50) DEFAULT NULL,
  `ape_materno` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `estado` enum('active','inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Usuario`
--

INSERT INTO `Usuario` (`id_usuario`, `nombre`, `ape_paterno`, `ape_materno`, `email`, `contrasena`, `telefono`, `id_rol`, `estado`) VALUES
(2, 'Juan', 'Perez', 'Gomez', 'almacen@example.com', '$2y$10$O2zBP2Mlq63vHv2EOdnEUeOn1tleNKh3Yy2nMx.7wJ3HrEYpOtATe', '1234567890', 1, 'active'),
(3, 'Pedro', 'Perez', 'Tantalean', 'tienda@example.com', '$2y$10$wacieumSPqyLwRZ62K5.cOj8bzGr79c44U2UQHbmpEMsVuvg6J8a2', '1234567890', 2, 'active'),
(4, 'Mohamed', 'Luque', 'Garcia', 'admin@example.com', '$2y$10$Yfn.Kby8tTV1o885xl.eiugVN82xN8pku5owMQ3FE59TvNTUq8NQO', '1234567890', 3, 'active'),
(5, 'Daniel', 'Navarro', 'Tantalean', 'daniel@gmail.com', '$2y$10$AUxUGjoJEYrw/mKt9q.p8./QuS/gR/8OymTeLousIDr99Yj.y7SOS', '994034731', 1, 'active'),
(6, 'Fernando', 'Perez', 'Flores', 'fer@gmail.com', '$2y$10$jGov1mvB/GGjPijO/NvuH.uy3C/as7T76/9F4bUhqyKRlWBkEnooe', '945612358', 2, 'active');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Producto_almacen`
--
ALTER TABLE `Producto_almacen`
  ADD PRIMARY KEY (`id_producto_almacen`);

--
-- Indices de la tabla `Rol`
--
ALTER TABLE `Rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Producto_almacen`
--
ALTER TABLE `Producto_almacen`
  MODIFY `id_producto_almacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `Rol`
--
ALTER TABLE `Rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `Rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
