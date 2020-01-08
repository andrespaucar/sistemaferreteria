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

-- Volcando datos para la tabla post_pe.categorias: ~16 rows (aproximadamente)
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` (`id`, `name`, `description`, `state`, `deleted_at`, `created_at`) VALUES
	(1, 'Pinturas, Esmaltes y Barnice', 'Pinturas', 1, 0, '2019-12-09 12:11:20'),
	(2, 'cemento', '', 1, 0, '2019-12-10 07:38:41'),
	(3, 'Clavos', '', 1, 0, '2019-12-10 07:39:57'),
	(4, 'Tuercas y arandelas', '', 1, 0, '2019-12-10 07:40:07'),
	(5, 'Abrazaderas y bridas', '', 1, 0, '2019-12-10 07:40:18'),
	(6, 'Alambre', '', 1, 0, '2019-12-10 07:40:58'),
	(7, 'Cadena', '', 1, 0, '2019-12-10 07:41:14'),
	(8, 'Chapas', '', 1, 0, '2019-12-10 07:41:50'),
	(9, 'Focos', '', 1, 0, '2019-12-10 07:42:50'),
	(10, 'Destornilladores', '', 1, 0, '2019-12-10 07:43:58'),
	(11, 'Tubos PVC', '', 1, 0, '2019-12-10 08:17:05'),
	(12, 'Barras de Construcción', '', 1, 0, '2019-12-10 08:17:20'),
	(13, 'Ladrillos', '', 1, 0, '2019-12-10 08:17:28'),
	(14, 'Bombas', '', 1, 0, '2019-12-19 15:28:04'),
	(15, 'Extencion Eléctrica', '', 0, 1, '2019-12-19 15:29:01'),
	(16, 'Cables', '', 1, 0, '2019-12-19 15:29:46');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;

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

-- Volcando datos para la tabla post_pe.clientes: ~25 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `doc`, `razon_social`, `direccion`, `telefono`, `email`, `c_compras`, `tipo_doc_id`, `ubigeo_id`, `estado`, `deleted_at`, `created_at`) VALUES
	(1, '75340891', 'Andres Paucar', 'av 28 julio', '935023609', 'sjandres184@gmail.com', 49, 1, 1, 1, 0, '2019-11-11 14:31:32'),
	(2, '75347854', 'Jose Sanchez', '2 de mayo #475', '958478548', 'jose@gmail.com', 11, 1, 4, 1, 0, '2019-11-11 14:31:31'),
	(3, '10205521033', 'Pedro Trujillo', 'calle procedes de la independencia', '528452452', 'jose@gmail.co', 21, 2, 8, 1, 0, '2019-11-11 14:31:17'),
	(4, '15435085', 'Mauro Lopez', 'carreteria #54', '528452452', 'mauro.lopez@gmail.com', 6, 1, 1, 1, 0, '2019-11-24 22:29:02'),
	(5, '15835180', 'Paolo Hurtado', 'lomas', '985587551', 'paolo765@gmail.com', 44, 1, 5, 1, 0, '2019-11-24 22:29:23'),
	(6, '15857455', 'Manuel Ramirez', 'carretera rinconada "25', '917415664', 'manuel6.2e@gmail.com', 54, 1, 2, 0, 0, '2019-11-24 22:54:49'),
	(7, '15859651', 'Jayro Suarez', '', '941485630', 'suarez.52@gmail.com', 51, 1, 14, 0, 0, '2019-11-24 22:55:24'),
	(8, '21474836471', 'Victor Torrez', '', '953455633', 'victorT2@gmail.com', 8, 2, 3, 1, 0, '2019-11-24 22:58:24'),
	(9, '75340829', 'Juan Florez', '', '947455647', 'florez.pe@gmail.com', 3, 1, 3, 1, 0, '2019-12-02 08:05:19'),
	(10, '75340892', 'JOSEPH LUIGI HURTADO TIRADO', '', '935748583', 'hurtad45@gmail.com', 50, 1, 3, 1, 0, '2019-12-02 08:33:31'),
	(11, '24124835965', 'Sergio Tirado', '', '952574858', 'segio52rom@gmail.com', 26, 2, 10, 1, 1, '2019-12-03 10:15:05'),
	(13, '75340890', 'SANDRA ISABEL CONDORI PAUCAR', '', '', '', 0, 1, 10, 1, 1, '2019-12-03 10:21:23'),
	(14, '29479836473', 'CONDORI PAUCAR YOEL ANDRES', '', '', '', 99, 2, 10, 1, 1, '2019-12-03 10:21:46'),
	(15, '42415454', 'Percy Cardenas', '', '985748568', 'percil12@gmail.com', 0, 2, 1, 1, 1, '2019-12-03 10:22:24'),
	(16, '21474836478', 'Daniela Quispe', '', '975548361', 'daniela98@gmail.com', 42, 2, 2, 1, 1, '2019-12-03 10:28:41'),
	(17, '21474836473', 'Alexander Huayta', '', '907242353', 'huaytaalex@gmail.com', 7, 2, 2, 1, 1, '2019-12-03 10:34:37'),
	(18, '27824639808', 'Jeremias Roque', '', '', 'roquex@gmail.com', 5, 2, 6, 1, 0, '2019-12-03 10:37:51'),
	(19, '13131492977', 'Jesus Baldeon', '', '', 'baldeon.85@gmail.com', 0, 2, 1, 1, 0, '2019-12-03 10:49:24'),
	(20, '10753408911', 'Luz Daniela Diaz', '', '965748582', 'luz.daniela80@gmail.com', 11, 2, 10, 1, 0, '2019-12-03 10:50:50'),
	(21, '46751558', 'Lennin Daniel Anchiraico', '', '', 'daniel.an12@gmail.com', 40, 1, 7, 1, 0, '2019-12-04 16:56:31'),
	(22, '43727940', 'Marco Lecaros', NULL, NULL, 'marco.leca@gmail.com', 2, 1, 7, 1, 0, '2019-12-08 11:05:58'),
	(23, '76435615', 'Salomon Mozombite', '', '', 'mozombite.daniel@gmail.com', 0, 1, 1, 1, 0, '2019-12-08 20:43:47'),
	(27, '75340894', 'LESLIE LISBET SANCHEZ SANDOVAL', '', NULL, '12leslie5@gmail.com', 2, 1, 13, 1, 0, '2019-12-09 16:00:36'),
	(28, '75340898', 'DIEGO RONALDIÑO ALTAMIRANO VILCHEZ', '', NULL, 'diego.21@gmail.com', 1, 1, 12, 1, 0, '2019-12-09 16:08:34'),
	(30, '75227871', 'Alfonso Eleuterio Moron Vilcherrez', '', NULL, NULL, 1, 1, 3, 1, 0, '2019-12-16 19:31:40');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Volcando estructura para tabla post_pe.comprobantes
CREATE TABLE IF NOT EXISTS `comprobantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla post_pe.comprobantes: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `comprobantes` DISABLE KEYS */;
INSERT INTO `comprobantes` (`id`, `name`, `code`) VALUES
	(1, 'Factura', '01'),
	(2, 'Boleta', '03'),
	(3, 'Nota de Crédito', '07'),
	(4, 'Nota de Débito', '08'),
	(5, 'Nota Venta', '0');
/*!40000 ALTER TABLE `comprobantes` ENABLE KEYS */;

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

-- Volcando datos para la tabla post_pe.configuracion: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` (`id`, `ruc`, `razon_social`, `nombre_comercial`, `logo`, `telefono`, `email`, `ubigeo_id`, `direccion_fiscal`, `igv`, `usuario_sol`, `pass_sol`, `cetificado_elect`, `pass_elect`, `updated_at`, `created_at`) VALUES
	(1, '20753408911', 'FERRETERIA ANYELA', 'LA ECONOMICA', '025659.png', '966314132', 'ferreteriangela@gmail.com', 7, '', 1.18, NULL, NULL, NULL, NULL, '2019-12-19 14:56:59', '2019-11-11 10:02:21');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;

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

-- Volcando datos para la tabla post_pe.productos: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`id`, `name`, `codigo`, `image`, `stock`, `stock_actual`, `stock_min`, `p_compra`, `p_venta_sin`, `p_venta_in`, `c_ventas`, `estado`, `unidad_id`, `categoria_id`, `deleted_at`, `updated_at`, `created_at`) VALUES
	(1, 'Esmaltes para trabajos de bricolaje Xylazel FullColour', 'A2145', '122750.png', 50, 28, 4, 8, 10, 11, 14, 1, 7, 1, 0, '2019-12-23 06:14:34', '2019-12-09 12:27:50'),
	(2, 'Cemento Sol', 'AP515', '081104.png', 450, 432, 10, 10, 18, 22, 4, 1, 24, 2, 0, '2019-12-23 06:14:34', '2019-12-10 08:11:04'),
	(3, 'Cemento Apu', 'A8521', '083257.png', 250, 246, 5, 12, 17, 21, 2, 1, 24, 2, 0, '2019-12-16 19:31:41', '2019-12-10 08:32:57'),
	(4, 'Titan Esmalte', '1463351332652', 'default.jpg', 40, 35, 10, 8, 10, 12, 1, 1, 7, 1, 0, '2019-12-17 17:04:42', '2019-12-16 18:56:40'),
	(5, 'BISAGRA ACODADA ECONOMI 110/48', 'A514e', 'default.jpg', 50, 50, 5, 35, 40, 47, 0, 1, 7, 5, 0, '2019-12-17 17:02:50', '2019-12-17 17:02:50'),
	(6, 'Bomba Hidrostatica	', 'A54E4', 'default.jpg', 8, 7, 4, 720, 750, 885, 1, 1, 7, 14, 0, '2019-12-19 15:38:28', '2019-12-19 15:30:59'),
	(7, 'Lamina Cubre Brecha	', '4575235730033', 'default.jpg', 55, 54, 21, 18, 20, 23, 1, 1, 7, 5, 0, '2019-12-19 15:38:28', '2019-12-19 15:34:04');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

-- Volcando estructura para tabla post_pe.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla post_pe.roles: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`) VALUES
	(1, 'administrador'),
	(2, 'vendedor'),
	(3, 'almacen');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Volcando estructura para tabla post_pe.tipo_documentos
CREATE TABLE IF NOT EXISTS `tipo_documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `code_sunat` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla post_pe.tipo_documentos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tipo_documentos` DISABLE KEYS */;
INSERT INTO `tipo_documentos` (`id`, `nombre`, `descripcion`, `code_sunat`) VALUES
	(1, 'D.N.I', 'DOC. NACIONAL DE IDENTIDAD', '1'),
	(2, 'R.U.C', 'REG. UNICO DE CONTRIBUYENTES', '6');
/*!40000 ALTER TABLE `tipo_documentos` ENABLE KEYS */;

-- Volcando estructura para tabla post_pe.ubigeo
CREATE TABLE IF NOT EXISTS `ubigeo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_ubigeo` varchar(6) DEFAULT NULL,
  `departamento` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `distrito` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla post_pe.ubigeo: ~16 rows (aproximadamente)
/*!40000 ALTER TABLE `ubigeo` DISABLE KEYS */;
INSERT INTO `ubigeo` (`id`, `codigo_ubigeo`, `departamento`, `provincia`, `distrito`) VALUES
	(1, '150501', '15 Lima', '05 Cañete', '01 San Vicente de Cañete'),
	(2, '150502', '15 Lima', '05 Cañete', '02 Asia'),
	(3, '150503', '15 Lima', '05 Cañete', '03 Calango'),
	(4, '150504', '15 Lima', '05 Cañete', '04 Cerro Azul'),
	(5, '150505', '15 Lima', '05 Cañete', '05 Chilca'),
	(6, '150506', '15 Lima', '05 Cañete', '06 Coayllo'),
	(7, '150507', '15 Lima', '05 Cañete', '07 Imperial'),
	(8, '150508', '15 Lima', '05 Cañete', '08 Lunahuana'),
	(9, '150509', '15 Lima', '05 Cañete', '09 Mala'),
	(10, '150510', '15 Lima', '05 Cañete', '10 Nuevo Imperial'),
	(11, '150511', '15 Lima', '05 Cañete', '11 Pacaran'),
	(12, '150512', '15 Lima', '05 Cañete', '12 Quilmana'),
	(13, '150513', '15 Lima', '05 Cañete', '13 San Antonio'),
	(14, '150514', '15 Lima', '05 Cañete', '14 San Luis'),
	(15, '150515', '15 Lima', '05 Cañete', '15 Santa Cruz de Flores'),
	(16, '150516', '15 Lima', '05 Cañete', '16 Zúñiga');
/*!40000 ALTER TABLE `ubigeo` ENABLE KEYS */;

-- Volcando estructura para tabla post_pe.unidades_medida
CREATE TABLE IF NOT EXISTS `unidades_medida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `simbolo` varchar(50) DEFAULT NULL,
  `code_s` varchar(50) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla post_pe.unidades_medida: ~44 rows (aproximadamente)
/*!40000 ALTER TABLE `unidades_medida` DISABLE KEYS */;
INSERT INTO `unidades_medida` (`id`, `name`, `simbolo`, `code_s`, `code`) VALUES
	(1, 'Kilogramos', 'Kg', 'KGM', 'NIU'),
	(2, 'Libras', 'Lb', 'LBR', 'NIU'),
	(3, 'Toneladas Largas', 'Tl', '000', 'NIU'),
	(4, 'Toneladas Metricas', 'Tm', '000', 'NIU'),
	(5, 'Toneladas Cortas', 'Tc', '000', 'NIU'),
	(6, 'Gramos', 'g', '000', 'NIU'),
	(7, 'Unidades', 'Und.', 'NIU', 'NIU'),
	(8, 'Litros', 'L', 'LTR', 'NIU'),
	(9, 'Galones', 'Galon', '000', 'NIU'),
	(10, 'Barriles', 'Barril', '000', 'NIU'),
	(11, 'Latas', 'lata', 'CA', 'NIU'),
	(12, 'Cajas', 'caja', 'BX', 'NIU'),
	(13, 'Millares', 'm', 'MLL', 'NIU'),
	(14, 'Metros Cubicos', 'm3', '000', 'NIU'),
	(15, 'Metros', 'm.', 'MTR', 'NIU'),
	(16, 'Docena', 'doc', '000', 'NIU'),
	(17, 'Ciento', 'Ciento', '000', 'NIU'),
	(18, 'Paquete', 'Pqt', NULL, 'NIU'),
	(19, 'Jabas', 'Jaba', NULL, 'NIU'),
	(20, 'Sevicio', 'servicio', 'ZZ', 'NIU'),
	(21, 'Media Docena', 'med.doc.', '1', 'NIU'),
	(22, 'Fardo', 'Fdo', NULL, 'NIU'),
	(23, 'Media Caja', 'Med.Caj.', NULL, 'NIU'),
	(24, 'Bolsa', 'Bolsa', 'BG', 'NIU'),
	(25, 'Cajetilla', 'Cajt.', NULL, 'NIU'),
	(26, 'Pack', 'Pack', NULL, 'NIU'),
	(27, 'Displey', 'Displey', NULL, 'NIU'),
	(28, 'Tira', 'Tira', NULL, 'NIU'),
	(29, 'Sixpak', 'Sixpak', NULL, 'NIU'),
	(30, 'Taper', 'Taper', NULL, 'NIU'),
	(31, 'Frasco', 'Fr', NULL, 'NIU'),
	(32, 'Vaso', 'Vaso', NULL, 'NIU'),
	(33, 'Dispensador', 'Dispens.', NULL, 'NIU'),
	(34, 'Bandeja', 'Bandeja', NULL, 'NIU'),
	(35, 'Plato', 'Plato', NULL, 'NIU'),
	(36, 'Pomo', 'Pomo', NULL, 'NIU'),
	(37, 'Sachet', 'Sachet', NULL, 'NIU'),
	(38, 'Medio Displey', 'M.Displey', NULL, 'NIU'),
	(39, 'Balde', 'Bal.', 'BJ', 'NIU'),
	(40, 'Saco', 'Saco', NULL, 'NIU'),
	(41, 'Par', 'Par', NULL, 'NIU'),
	(42, 'Pote', 'Pote', NULL, 'NIU'),
	(43, 'Rollo', 'Rollo', NULL, 'NIU'),
	(44, 'KIT', 'Kit', 'KT', 'NIU');
/*!40000 ALTER TABLE `unidades_medida` ENABLE KEYS */;

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

-- Volcando datos para la tabla post_pe.usuarios: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `apellido`, `password`, `foto`, `celular`, `estado`, `rol_id`, `ultimo_login`, `created_at`) VALUES
	(30, 'admin', 'Yoel', 'paucar', 'admin', 'default.jpg', '935023609', 1, 1, NULL, '2019-10-29 11:09:13'),
	(52, 'jose', 'Sanchez', 'fdbd', 'jose', 'default.jpg', '999999999', 0, 3, NULL, '2019-10-30 09:20:06'),
	(53, 'prueba1', 'prueba11', 'prueba11', 'prueba11', 'default.jpg', '999999999', 1, 3, NULL, '2019-10-30 09:39:41'),
	(54, 'prueba', 'prueba', 'pruebape', 'pruebape', 'default.jpg', '999999999', 1, 2, NULL, '2019-11-12 10:43:59');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

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

-- Volcando datos para la tabla post_pe.ventas: ~19 rows (aproximadamente)
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` (`id`, `serie`, `numero`, `codigo_hash`, `xml`, `cdr`, `sunat`, `productos_vendidos`, `grabada`, `descuento`, `total_igv`, `total`, `total_en_letras`, `pdf_A4`, `pdf_ticket`, `usuario_id`, `comprobante_id`, `cliente_id`, `estado`, `deleted_at`, `updated_at`, `created_at`) VALUES
	(1, 'B001', '00000001', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"2","name":"Cable Rojo 2Byyy kinbijknh bijbhjn jhkby","codigo":"5414567891234","stock":"44","p_venta_sin":"14.11","p_venta_in":"12.25","unidad_id":"1","simbolo":"Kg","code":"NIU","cantidad":1,"enable":0},{"id":"3","name":"Taladro Electrico 3SC","codigo":"1234567891234","stock":"288","p_venta_sin":"111","p_venta_in":"442","unidad_id":"2","simbolo":"Lb","code":"NIU","cantidad":1,"enable":0},{"id":"4","name":"Taladro Mecanicho R4","codigo":"5869208879387","stock":"7","p_venta_sin":"150","p_venta_in":"177","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":1,"enable":0}]', 275.11, 0.00, 49.52, 324.63, 'SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES\r', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, '2019-12-11 07:56:36', '2019-01-09 11:58:37'),
	(2, 'B001', '00000002', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock":"50","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":10,"enable":0}]', 50, 50.00, 9, 59, 'SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES\r', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, '2019-12-11 07:56:39', '2019-02-09 15:32:56'),
	(3, 'B001', '00000003', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock":"40","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":2,"enable":0}]', 20, 0.00, 3.6, 23.6, 'SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES\r', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, '2019-12-11 07:56:43', '2019-05-09 15:47:07'),
	(4, 'B001', '00000004', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock":"38","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":1,"enable":0}]', 10, 0.00, 1.8, 11.8, 'SON ONCE  CON 80/100', 'None_url', 'None_url', 30, 2, 27, 'Aceptado', 0, '2019-12-10 08:35:59', '2019-08-09 15:47:07'),
	(5, 'B001', '00000005', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock":"37","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":13,"enable":0}]', 130, 0.00, 23.4, 153.4, 'SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES\r', 'None_url', 'None_url', 30, 2, 28, 'Aceptado', 0, '2019-12-10 08:36:15', '2019-08-09 15:47:07'),
	(6, 'B001', '00000006', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock":"24","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":1,"enable":0}]', 10, 0.00, 1.8, 11.8, 'SON ONCE  CON 80/100', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, '2019-12-10 12:43:33', '2019-09-09 15:47:07'),
	(7, 'B001', '00000007', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock":"24","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":1,"enable":0}]', 10, 0.00, 1.8, 11.8, 'SON ONCE  CON 80/100', 'None_url', 'None_url', 30, 2, 27, 'Aceptado', 0, '2019-12-10 08:36:19', '2019-10-09 16:12:47'),
	(8, 'B001', '00000008', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock":"22","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":1,"enable":0}]', 10, 0.00, 1.8, 11.8, 'SON ONCE  CON 80/100', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, '2019-12-10 08:36:23', '2019-10-09 17:19:23'),
	(9, 'B001', '00000009', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock":"21","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":8,"enable":0}]', 72, 8.00, 12.96, 84.96, 'SON OCHENTA Y CUATRO  CON 96/100', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, '2019-12-10 08:36:26', '2019-11-09 17:22:47'),
	(10, 'B001', '00000010', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock":"13","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":5,"enable":0}]', 50, 0.00, 9, 59, 'SON CINCUENTA Y NUEVE  CON 00/100', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, '2019-12-13 10:10:14', '2019-11-09 22:27:33'),
	(11, 'B001', '00000011', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock":"50","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":8,"enable":0}]', 80, 0.00, 14.4, 94.4, 'SON NOVENTA Y CUATRO  CON 40/100', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, '2019-12-13 10:11:32', '2019-12-13 22:38:26'),
	(12, 'B001', '00000012', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock_actual":"42","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":10,"enable":0}]', 100, 0.00, 18, 118, 'SON CIENTO DIECIOCHO  CON 00/100', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, '2019-12-13 09:47:55', '2019-12-13 22:46:38'),
	(13, 'F001', '00000001', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"2","name":"Cemento Sol","codigo":"AP515","stock_actual":"450","p_venta_sin":"18","p_venta_in":"22","unidad_id":"24","simbolo":"Bolsa","code":"NIU","cantidad":10,"enable":0}]', 180, 0.00, 32.4, 212.4, 'SON DOSCIENTOS DOCE  CON 40/100', 'None_url', 'None_url', 30, 1, 3, 'Aceptado', 0, '2019-12-13 10:06:58', '2020-01-10 11:37:13'),
	(14, 'B001', '00000013', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock_actual":"32","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":1,"enable":0},{"id":"2","name":"Cemento Sol","codigo":"AP515","stock_actual":"440","p_venta_sin":"18","p_venta_in":"22","unidad_id":"24","simbolo":"Bolsa","code":"NIU","cantidad":6,"enable":0}]', 118, 0.00, 21.24, 139.24, 'SON CIENTO TREINTA Y NUEVE  CON 24/100', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, '2019-12-11 08:08:04', '2020-02-09 11:37:13'),
	(15, 'B001', '00000014', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"4","name":"x","codigo":"1463351332652","stock_actual":"40","p_venta_sin":"10","p_venta_in":"12","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":5,"enable":0}]', 50, 0.00, 9, 59, 'SON CINCUENTA Y NUEVE  CON 00/100', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, NULL, '2019-12-16 18:59:09'),
	(16, 'B001', '00000015', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"2","name":"Cemento Sol","codigo":"AP515","stock_actual":"434","p_venta_sin":"18","p_venta_in":"22","unidad_id":"24","simbolo":"Bolsa","code":"NIU","cantidad":1,"enable":0},{"id":"3","name":"Cemento Apu","codigo":"A8521","stock_actual":"250","p_venta_sin":"17","p_venta_in":"21","unidad_id":"24","simbolo":"Bolsa","code":"NIU","cantidad":1,"enable":0}]', 35, 0.00, 6.3, 41.3, 'SON CUARENTA Y UN  CON 30/100', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, NULL, '2019-12-16 19:27:52'),
	(17, 'B001', '00000016', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock_actual":"31","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":2,"enable":0},{"id":"3","name":"Cemento Apu","codigo":"A8521","stock_actual":"249","p_venta_sin":"17","p_venta_in":"21","unidad_id":"24","simbolo":"Bolsa","code":"NIU","cantidad":3,"enable":0}]', 71, 0.00, 12.78, 83.78, 'SON OCHENTA Y TRES  CON 78/100', 'None_url', 'None_url', 30, 2, 30, 'Aceptado', 0, NULL, '2019-12-16 19:31:41'),
	(18, 'B001', '00000017', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"7","name":"Lamina Cubre Brecha\\t","codigo":"4575235730033","stock_actual":"55","p_venta_sin":"20","p_venta_in":"23","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":1,"enable":0},{"id":"6","name":"Bomba Hidrostatica\\t","codigo":"A54E4","stock_actual":"8","p_venta_sin":"750","p_venta_in":"885","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":1,"enable":0}]', 770, 0.00, 138.6, 908.6, 'SON NOVECIENTOS OCHO  CON 60/100', 'None_url', 'None_url', 30, 2, 7, 'Aceptado', 0, NULL, '2019-12-19 15:38:28'),
	(19, 'B001', '00000018', 'ALFMKefmakfmalmkf=', 'None', 'None', 'None', '[{"id":"2","name":"Cemento Sol","codigo":"AP515","stock_actual":"433","p_venta_sin":"18","p_venta_in":"22","unidad_id":"24","simbolo":"Bolsa","code":"NIU","cantidad":1,"enable":0},{"id":"1","name":"Esmaltes para trabajos de bricolaje Xylazel FullColour","codigo":"A2145","stock_actual":"29","p_venta_sin":"10","p_venta_in":"11","unidad_id":"7","simbolo":"Und.","code":"NIU","cantidad":1,"enable":0}]', 28, 0.00, 5.04, 33.04, 'SON TREINTA Y TRES  CON 04/100', 'None_url', 'None_url', 30, 2, 1, 'Aceptado', 0, NULL, '2019-12-23 06:14:34');
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
