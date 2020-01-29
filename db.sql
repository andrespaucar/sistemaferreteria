-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.37-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             10.0.0.5460
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para post_pe
CREATE DATABASE IF NOT EXISTS `post_pe` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `post_pe`;

-- Volcando estructura para tabla post_pe.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) DEFAULT NULL,
  `description` varchar(80) DEFAULT NULL,
  `state` tinyint(4) DEFAULT '1',
  `deleted_at` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

 
-- Volcando estructura para tabla post_pe.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc` varchar(50) DEFAULT NULL,
  `razon_social` varchar(50) DEFAULT NULL,
  `direccion` varchar(80) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `c_compras` int(11) DEFAULT '0',
  `tipo_doc_id` int(11) DEFAULT NULL,
  `ubigeo_id` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT '1',
  `deleted_at` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_clientes_ubigeo` (`ubigeo_id`),
  KEY `FK_clientes_tipo_documentos` (`tipo_doc_id`),
  CONSTRAINT `FK_clientes_tipo_documentos` FOREIGN KEY (`tipo_doc_id`) REFERENCES `tipo_documentos` (`id`),
  CONSTRAINT `FK_clientes_ubigeo` FOREIGN KEY (`ubigeo_id`) REFERENCES `ubigeo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

 

-- Volcando estructura para tabla post_pe.comprobantes
CREATE TABLE IF NOT EXISTS `comprobantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

 

-- Volcando estructura para tabla post_pe.configuracion
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruc` varchar(11) DEFAULT NULL,
  `razon_social` varchar(80) DEFAULT NULL,
  `nombre_comercial` varchar(80) DEFAULT NULL,
  `logo` varchar(80) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `ubigeo_id` int(11) DEFAULT NULL,
  `direccion_fiscal` varchar(100) DEFAULT NULL,
  `igv` float DEFAULT NULL,
  `usuario_sol` varchar(50) DEFAULT NULL,
  `pass_sol` varchar(50) DEFAULT NULL,
  `cetificado_elect` varchar(50) DEFAULT NULL,
  `pass_elect` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ubigeo_id` (`ubigeo_id`),
  CONSTRAINT `FK_configuracion_ubigeo` FOREIGN KEY (`ubigeo_id`) REFERENCES `ubigeo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

 
-- Volcando estructura para tabla post_pe.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `codigo` varchar(15) DEFAULT NULL,
  `image` varchar(40) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `stock_actual` int(11) DEFAULT NULL,
  `stock_min` int(11) DEFAULT NULL,
  `p_compra` float DEFAULT NULL,
  `p_venta_sin` float DEFAULT NULL,
  `p_venta_in` float DEFAULT NULL,
  `c_ventas` int(11) DEFAULT '0',
  `estado` tinyint(4) DEFAULT NULL,
  `unidad_id` int(11) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `deleted_at` tinyint(4) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_productos_unidad_medida` (`unidad_id`),
  KEY `FK_productos_categorias` (`categoria_id`),
  CONSTRAINT `FK_productos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  CONSTRAINT `FK_productos_unidad_medida` FOREIGN KEY (`unidad_id`) REFERENCES `unidades_medida` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

 
-- Volcando estructura para tabla post_pe.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

 
-- Volcando estructura para tabla post_pe.tipo_documentos
CREATE TABLE IF NOT EXISTS `tipo_documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `code_sunat` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

 
-- Volcando estructura para tabla post_pe.ubigeo
CREATE TABLE IF NOT EXISTS `ubigeo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_ubigeo` varchar(6) DEFAULT NULL,
  `departamento` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `distrito` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

 
-- Volcando estructura para tabla post_pe.unidades_medida
CREATE TABLE IF NOT EXISTS `unidades_medida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `simbolo` varchar(50) DEFAULT NULL,
  `code_s` varchar(50) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

 
-- Volcando estructura para tabla post_pe.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `foto` varchar(40) DEFAULT NULL,
  `celular` varchar(9) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `ultimo_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_usuarios_roles` (`rol_id`),
  CONSTRAINT `FK_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

 
-- Volcando estructura para tabla post_pe.ventas
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serie` varchar(50) DEFAULT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `codigo_hash` varchar(100) DEFAULT NULL,
  `xml` varchar(100) DEFAULT NULL,
  `cdr` varchar(100) DEFAULT NULL,
  `sunat` varchar(100) DEFAULT NULL,
  `productos_vendidos` text,
  `grabada` float DEFAULT '0',
  `descuento` decimal(11,2) DEFAULT '0.00',
  `total_igv` float DEFAULT '0',
  `total` float DEFAULT NULL,
  `total_en_letras` varchar(100) DEFAULT NULL,
  `pdf_A4` varchar(150) DEFAULT NULL,
  `pdf_ticket` varchar(150) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `comprobante_id` int(11) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `deleted_at` tinyint(4) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_ventas_clientes` (`cliente_id`),
  KEY `FK_ventas_comprobantes` (`comprobante_id`),
  KEY `FK_ventas_usuarios` (`usuario_id`),
  CONSTRAINT `FK_ventas_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  CONSTRAINT `FK_ventas_comprobantes` FOREIGN KEY (`comprobante_id`) REFERENCES `comprobantes` (`id`),
  CONSTRAINT `FK_ventas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

 