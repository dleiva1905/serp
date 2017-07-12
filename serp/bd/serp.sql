-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 12, 2017 at 01:21 am
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cabina`
--

CREATE TABLE `cabina` (
  `id_cabina` int(11) NOT NULL,
  `dinero_actual` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cabina`
--

INSERT INTO `cabina` (`id_cabina`, `dinero_actual`) VALUES
(0, 0),
(1, 0),
(2, 0),
(3, 0),
(4, 0),
(5, 0),
(6, 0),
(7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(1) NOT NULL,
  `tipo_de_cargo` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `tipo_de_cargo`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'TESORERO');

-- --------------------------------------------------------

--
-- Table structure for table `cierre`
--

CREATE TABLE `cierre` (
  `id_cierre` int(11) NOT NULL,
  `recaudador` int(11) NOT NULL,
  `cabina` int(1) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `monto_recaudado` float NOT NULL,
  `tipo_de_cierre` char(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `decantacion`
--

CREATE TABLE `decantacion` (
  `id_decantacion` int(11) NOT NULL,
  `cierre` int(11) NOT NULL,
  `monto_declarado` float NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE `empleado` (
  `cedula` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contrasenia` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cargo` int(1) NOT NULL,
  `cabina` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`cedula`, `nombre`, `apellido`, `usuario`, `contrasenia`, `cargo`, `cabina`) VALUES
(22080325, 'DIEGO', 'LEIVA', 'dleiva', '1234', 2, 0),
(200117877, 'SERVIALEZ', '', 'admin', 'Xml.123_', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `exento`
--

CREATE TABLE `exento` (
  `id_exento` int(11) NOT NULL,
  `tipo_de_exento` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `monto_no_percibido` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `exento`
--

INSERT INTO `exento` (`id_exento`, `tipo_de_exento`, `monto_no_percibido`) VALUES
(1, 'Vehículos por puesto', 50),
(2, 'Motos a partir de 500 cc', 100),
(3, 'Vehículos livianos y micro buses', 100),
(4, 'Taxis', 100),
(5, 'Buses colectivos', 300),
(6, 'Camión 350 (2 ejes)', 500),
(7, 'Camión 750', 600),
(8, 'Buses expresos', 1000),
(9, 'Vehículos pesados (3 ejes)', 1000),
(10, 'Vehículos pesados (4 ejes)', 1500),
(11, 'Vehículos pesados (5 ejes o más)', 2000),
(12, 'Vehículo de la institución', 0),
(13, 'Ambulancia', 0);

-- --------------------------------------------------------

--
-- Table structure for table `log_login`
--

CREATE TABLE `log_login` (
  `id_log_login` int(11) NOT NULL,
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cabina` int(1) NOT NULL,
  `hora_de_conexion` time NOT NULL,
  `hora_de_desconexion` time NOT NULL,
  `fecha_de_conexion` date NOT NULL,
  `fecha_de_desconexion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registro`
--

CREATE TABLE `registro` (
  `id_registro` int(11) NOT NULL,
  `tipo_de_vehiculo` int(11) NOT NULL,
  `recaudador` int(11) NOT NULL,
  `cabina` int(1) NOT NULL,
  `monto` float NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registro_exento`
--

CREATE TABLE `registro_exento` (
  `id_registro_exento` int(11) NOT NULL,
  `tipo_de_exento` int(11) NOT NULL,
  `placa_del_vehiculo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `recaudador` int(11) NOT NULL,
  `cabina` int(1) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `monto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabulador`
--

CREATE TABLE `tabulador` (
  `id_tabulador` int(11) NOT NULL,
  `tipo_de_vehiculo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tarifa` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tabulador`
--

INSERT INTO `tabulador` (`id_tabulador`, `tipo_de_vehiculo`, `tarifa`) VALUES
(1, 'Vehículos por puesto', 50),
(2, 'Motos a partir de 500 cc', 100),
(3, 'Vehículos livianos y micro buses', 100),
(4, 'Taxis', 100),
(5, 'Buses colectivos', 300),
(6, 'Camión 350 (2 ejes)', 500),
(7, 'Camión 750', 600),
(8, 'Buses expresos', 1000),
(9, 'Vehículos pesados (3 ejes)', 1000),
(10, 'Vehículos pesados (4 ejes)', 1500),
(11, 'Vehículos pesados (5 ejes o más)', 2000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cabina`
--
ALTER TABLE `cabina`
  ADD PRIMARY KEY (`id_cabina`);

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indexes for table `cierre`
--
ALTER TABLE `cierre`
  ADD PRIMARY KEY (`id_cierre`);

--
-- Indexes for table `decantacion`
--
ALTER TABLE `decantacion`
  ADD PRIMARY KEY (`id_decantacion`);

--
-- Indexes for table `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`cedula`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indexes for table `exento`
--
ALTER TABLE `exento`
  ADD PRIMARY KEY (`id_exento`);

--
-- Indexes for table `log_login`
--
ALTER TABLE `log_login`
  ADD PRIMARY KEY (`id_log_login`);

--
-- Indexes for table `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id_registro`);

--
-- Indexes for table `registro_exento`
--
ALTER TABLE `registro_exento`
  ADD PRIMARY KEY (`id_registro_exento`);

--
-- Indexes for table `tabulador`
--
ALTER TABLE `tabulador`
  ADD PRIMARY KEY (`id_tabulador`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cabina`
--
ALTER TABLE `cabina`
  MODIFY `id_cabina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cierre`
--
ALTER TABLE `cierre`
  MODIFY `id_cierre` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `decantacion`
--
ALTER TABLE `decantacion`
  MODIFY `id_decantacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `exento`
--
ALTER TABLE `exento`
  MODIFY `id_exento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `log_login`
--
ALTER TABLE `log_login`
  MODIFY `id_log_login` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `registro`
--
ALTER TABLE `registro`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `registro_exento`
--
ALTER TABLE `registro_exento`
  MODIFY `id_registro_exento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tabulador`
--
ALTER TABLE `tabulador`
  MODIFY `id_tabulador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
