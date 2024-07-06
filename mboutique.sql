-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jul 06, 2024 at 10:45 PM
-- Server version: 5.7.44
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mboutique`
--

-- --------------------------------------------------------

--
-- Table structure for table `Detalle_solicitud_envio`
--

CREATE TABLE `Detalle_solicitud_envio` (
  `id_detalle` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_producto_almacen` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Producto_almacen`
--

CREATE TABLE `Producto_almacen` (
  `id_producto_almacen` int(11) NOT NULL,
  `nombre_producto` varchar(60) DEFAULT NULL,
  `descripcion` varchar(90) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Producto_almacen`
--

INSERT INTO `Producto_almacen` (`id_producto_almacen`, `nombre_producto`, `descripcion`, `cantidad`, `precio_unitario`) VALUES
(2, 'Mochila 1', 'mochila', 123, 123),
(3, 'Joya', '12332', 123, 123),
(4, 'BalÃ³n', 'BalÃ³n', 123, 123),
(5, 'Mochila de Dora', 'Mochila de dora con una dora ahÃ­ p', 123, 123),
(6, 'Otra mochila', '1234', 123, 123),
(7, 'Pdf2', '123123', 123, 123),
(8, 'Estoy cansado jefe2', 'asdfasdf', 123, 123),
(9, 'otro producto', '1233', 123, 123);

-- --------------------------------------------------------

--
-- Table structure for table `Producto_tienda`
--

CREATE TABLE `Producto_tienda` (
  `id_producto_tienda` int(11) NOT NULL,
  `nombre_producto` varchar(60) DEFAULT NULL,
  `descripcion` varchar(90) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Rol`
--

CREATE TABLE `Rol` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(60) DEFAULT NULL,
  `estado` enum('active','inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Rol`
--

INSERT INTO `Rol` (`id_rol`, `rol`, `estado`) VALUES
(1, 'almacen', 'active'),
(2, 'tienda', 'active'),
(3, 'administrador', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `Solicitud_envio`
--

CREATE TABLE `Solicitud_envio` (
  `id_solicitud` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_solicitud` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','enviado','recibido') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Usuario`
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
-- Dumping data for table `Usuario`
--

INSERT INTO `Usuario` (`id_usuario`, `nombre`, `ape_paterno`, `ape_materno`, `email`, `contrasena`, `telefono`, `id_rol`, `estado`) VALUES
(2, 'Juan', 'Perez', 'Gomez', 'almacen@example.com', '$2y$10$tZHhwaVZ5kR7Xa511sFCuOA.mdros2spMbVst3IO4E6h0TCpUPs7i', '1234567890', 1, 'active'),
(3, 'Pedro', 'Perez', 'Tantalean', 'tienda@example.com', '$2y$10$wacieumSPqyLwRZ62K5.cOj8bzGr79c44U2UQHbmpEMsVuvg6J8a2', '1234567890', 2, 'active'),
(4, 'Mohamed', 'Luque', 'Garcia', 'admin@example.com', '$2y$10$Yfn.Kby8tTV1o885xl.eiugVN82xN8pku5owMQ3FE59TvNTUq8NQO', '1234567890', 3, 'active'),
(5, 'Daniel', 'Navarro', 'Tantalean', 'daniel@gmail.com', '$2y$10$AUxUGjoJEYrw/mKt9q.p8./QuS/gR/8OymTeLousIDr99Yj.y7SOS', '994034731', 1, 'active'),
(6, 'Fernando', 'Perez', 'Flores', 'fer@gmail.com', '$2y$10$jGov1mvB/GGjPijO/NvuH.uy3C/as7T76/9F4bUhqyKRlWBkEnooe', '945612358', 2, 'active'),
(7, 'Fernando', 'Vegas', 'Villar', 'mgear404@gmail.com', '$2y$10$GTlR.Ns0lYMJHQ7JpAGErONabVDyXFgENL3gC2xHJnd6CmJCEMXbK', '12345678', 3, 'active'),
(8, 'Fernando', 'Vegas', 'Villar', 'vegasfernando2003@gmail.com', '$2y$10$dRUTmqcue9wtqZkS/gJg/eXkzfNhOCDBMU/QlCwyDDr6ZKtY28DnG', '123456', 2, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Detalle_solicitud_envio`
--
ALTER TABLE `Detalle_solicitud_envio`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_solicitud` (`id_solicitud`),
  ADD KEY `id_producto_almacen` (`id_producto_almacen`);

--
-- Indexes for table `Producto_almacen`
--
ALTER TABLE `Producto_almacen`
  ADD PRIMARY KEY (`id_producto_almacen`);

--
-- Indexes for table `Producto_tienda`
--
ALTER TABLE `Producto_tienda`
  ADD PRIMARY KEY (`id_producto_tienda`);

--
-- Indexes for table `Rol`
--
ALTER TABLE `Rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indexes for table `Solicitud_envio`
--
ALTER TABLE `Solicitud_envio`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Detalle_solicitud_envio`
--
ALTER TABLE `Detalle_solicitud_envio`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Producto_almacen`
--
ALTER TABLE `Producto_almacen`
  MODIFY `id_producto_almacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Producto_tienda`
--
ALTER TABLE `Producto_tienda`
  MODIFY `id_producto_tienda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Rol`
--
ALTER TABLE `Rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Solicitud_envio`
--
ALTER TABLE `Solicitud_envio`
  MODIFY `id_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Usuario`
--
ALTER TABLE `Usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Detalle_solicitud_envio`
--
ALTER TABLE `Detalle_solicitud_envio`
  ADD CONSTRAINT `detalle_solicitud_envio_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `Solicitud_envio` (`id_solicitud`),
  ADD CONSTRAINT `detalle_solicitud_envio_ibfk_2` FOREIGN KEY (`id_producto_almacen`) REFERENCES `Producto_almacen` (`id_producto_almacen`);

--
-- Constraints for table `Solicitud_envio`
--
ALTER TABLE `Solicitud_envio`
  ADD CONSTRAINT `solicitud_envio_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`);

--
-- Constraints for table `Usuario`
--
ALTER TABLE `Usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `Rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
