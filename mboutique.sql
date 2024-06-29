-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jun 29, 2024 at 05:52 PM
-- Server version: 5.7.44
-- PHP Version: 8.2.20

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
(2, 'Juan', 'Perez', 'Gomez', 'almacen@example.com', '$2y$10$O2zBP2Mlq63vHv2EOdnEUeOn1tleNKh3Yy2nMx.7wJ3HrEYpOtATe', '1234567890', 1, 'active'),
(3, 'Pedro', 'Perez', 'Tantalean', 'tienda@example.com', '$2y$10$wacieumSPqyLwRZ62K5.cOj8bzGr79c44U2UQHbmpEMsVuvg6J8a2', '1234567890', 2, 'active'),
(4, 'Mohamed', 'Luque', 'Garcia', 'admin@example.com', '$2y$10$JzvEtL.Z5hOCCUBWNPRLvuv8gswtVvd.yYQn4NVVElCnFQloaEuku', '1234567890', 3, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Rol`
--
ALTER TABLE `Rol`
  ADD PRIMARY KEY (`id_rol`);

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
-- AUTO_INCREMENT for table `Rol`
--
ALTER TABLE `Rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Usuario`
--
ALTER TABLE `Usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Usuario`
--
ALTER TABLE `Usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `Rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
