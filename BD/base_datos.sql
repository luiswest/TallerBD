SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
--
-- Base de datos: prematric
--
DROP DATABASE IF EXISTS taller;
CREATE DATABASE taller DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE taller;
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla Artefacto
--
DROP TABLE IF EXISTS artefacto;
CREATE TABLE artefacto (
  id int(11) NOT NULL AUTO_INCREMENT,
  idCliente int(11) NOT NULL,
  serie varchar(15) NOT NULL,
  marca varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  modelo varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  categoria varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  descripcion varchar(50) COLLATE utf8_spanish_ci NOT NULL,  

  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

DROP TABLE IF EXISTS cliente;
CREATE TABLE cliente (
  id int(11) NOT NULL AUTO_INCREMENT,  
  idCliente Varchar(15) NOT NULL,
  nombre Varchar (30) COLLATE utf8_spanish_ci NOT NULL,
  apellido1 Varchar (15) COLLATE utf8_spanish_ci NOT NULL,
  apellido2 Varchar (15) COLLATE utf8_spanish_ci NOT NULL,
  telefono Varchar (9) NOT NULL,
  celular Varchar (9),
  direccion Varchar (255) COLLATE utf8_spanish_ci,
  correo Varchar (100) NOT NULL,
  fechaIngreso Datetime DEFAULT now(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

COMMIT;
