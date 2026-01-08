-- MariaDB dump 10.17  Distrib 10.4.14-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: agrimac
-- ------------------------------------------------------
-- Server version	10.4.14-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `amac_cultivos`
--

DROP TABLE IF EXISTS `amac_cultivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_cultivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cultivo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_dosis_plagas`
--

DROP TABLE IF EXISTS `amac_dosis_plagas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_dosis_plagas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `cultivo_id` int(11) NOT NULL,
  `plaga_id` int(11) NOT NULL,
  `intervalo` varchar(255) NOT NULL,
  `dosis_min` varchar(255) NOT NULL,
  `dosis_max` varchar(255) NOT NULL,
  `dosis_recomendada` varchar(255) NOT NULL,
  `usa_mex` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_insumos`
--

DROP TABLE IF EXISTS `amac_insumos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_insumos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` bigint(30) NOT NULL DEFAULT 0,
  `user_id` varchar(40) NOT NULL DEFAULT '0',
  `cancelled` tinyint(1) NOT NULL DEFAULT 0,
  `cancelled_by` varchar(40) NOT NULL DEFAULT '0',
  `cancelled_date` bigint(30) NOT NULL DEFAULT 0,
  `cancelled_text` text DEFAULT NULL,
  `authorized_by` varchar(40) NOT NULL DEFAULT '0',
  `authorized_date` bigint(30) NOT NULL DEFAULT 0,
  `justify` varchar(255) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `state` int(2) NOT NULL DEFAULT 0,
  `exported` tinyint(1) NOT NULL DEFAULT 0,
  `uniqid` varchar(40) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29064 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_insumos_detail`
--

DROP TABLE IF EXISTS `amac_insumos_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_insumos_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insumo_id` varchar(40) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT 0,
  `quantity` double NOT NULL DEFAULT 0,
  `unit` varchar(15) NOT NULL,
  `cost_center` int(11) NOT NULL DEFAULT 0,
  `depot_id` int(11) NOT NULL DEFAULT 0,
  `lote` varchar(255) DEFAULT NULL,
  `caducidad` varchar(15) DEFAULT NULL,
  `plaga` varchar(255) DEFAULT NULL,
  `dosis_hectarea` varchar(255) DEFAULT NULL,
  `dosis_tambo` varchar(255) DEFAULT NULL,
  `ph` varchar(255) DEFAULT NULL,
  `valvula` varchar(255) DEFAULT NULL,
  `drenaje` varchar(255) DEFAULT NULL,
  `conductividad` varchar(255) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `authorized` tinyint(1) NOT NULL DEFAULT 0,
  `authorized_by` varchar(40) NOT NULL DEFAULT '0',
  `authorized_date` bigint(30) NOT NULL DEFAULT 0,
  `uniqid` varchar(40) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82948 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_insumos_notes`
--

DROP TABLE IF EXISTS `amac_insumos_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_insumos_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insumo_id` varchar(40) NOT NULL DEFAULT '0',
  `date` bigint(30) NOT NULL DEFAULT 0,
  `note` text DEFAULT NULL,
  `user_id` varchar(40) NOT NULL DEFAULT '0',
  `uniqid` varchar(40) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_plagas`
--

DROP TABLE IF EXISTS `amac_plagas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_plagas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plaga` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_requisitions`
--

DROP TABLE IF EXISTS `amac_requisitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_requisitions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` bigint(30) NOT NULL DEFAULT 0,
  `estimated` bigint(30) NOT NULL DEFAULT 0,
  `user_id` varchar(255) DEFAULT '0',
  `currency` int(11) NOT NULL DEFAULT 1,
  `rate` decimal(10,5) NOT NULL DEFAULT 1.00000,
  `cancelled` tinyint(1) NOT NULL DEFAULT 0,
  `cancelled_by` varchar(255) DEFAULT '0',
  `cancelled_date` bigint(30) NOT NULL DEFAULT 0,
  `cancelled_text` text DEFAULT NULL,
  `justify` text DEFAULT NULL,
  `authorized_by` varchar(255) DEFAULT '0',
  `authorized_date` bigint(30) NOT NULL DEFAULT 0,
  `extensions` int(11) NOT NULL DEFAULT 0,
  `observations` text DEFAULT NULL,
  `state` int(2) NOT NULL DEFAULT 0,
  `exported` tinyint(1) NOT NULL DEFAULT 0,
  `uniqid` varchar(255) NOT NULL DEFAULT '0',
  `updated_date` bigint(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8253 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_requisitions_attach`
--

DROP TABLE IF EXISTS `amac_requisitions_attach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_requisitions_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requisition_id` varchar(255) DEFAULT NULL,
  `date` bigint(30) NOT NULL DEFAULT 0,
  `filename` varchar(255) DEFAULT NULL,
  `filetype` varchar(10) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) NOT NULL DEFAULT '0',
  `uniqid` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23989 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_requisitions_detail`
--

DROP TABLE IF EXISTS `amac_requisitions_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_requisitions_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requisition_id` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unit` varchar(25) DEFAULT NULL,
  `unit_cost` decimal(20,5) NOT NULL DEFAULT 0.00000,
  `subtotal` decimal(20,5) NOT NULL DEFAULT 0.00000,
  `discount` decimal(20,5) NOT NULL DEFAULT 0.00000,
  `tax` decimal(20,5) NOT NULL DEFAULT 0.00000,
  `other_taxes` decimal(20,5) NOT NULL DEFAULT 0.00000,
  `total` decimal(20,5) NOT NULL DEFAULT 0.00000,
  `cost_center` int(11) NOT NULL DEFAULT 0,
  `observations` text DEFAULT NULL,
  `authorized` tinyint(1) NOT NULL DEFAULT 0,
  `authorized_by` varchar(255) NOT NULL DEFAULT '0',
  `authorized_date` bigint(30) NOT NULL DEFAULT 0,
  `provider_id` int(11) NOT NULL DEFAULT 0,
  `uniqid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14571 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_requisitions_notes`
--

DROP TABLE IF EXISTS `amac_requisitions_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_requisitions_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requisition_id` varchar(255) NOT NULL DEFAULT '0',
  `date` bigint(30) NOT NULL DEFAULT 0,
  `note` text DEFAULT NULL,
  `user_id` varchar(255) NOT NULL DEFAULT '0',
  `uniqid` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=729 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_settings`
--

DROP TABLE IF EXISTS `amac_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `value` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_users`
--

DROP TABLE IF EXISTS `amac_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(512) DEFAULT NULL,
  `type` int(1) NOT NULL DEFAULT 2,
  `uniqid` varchar(255) DEFAULT NULL,
  `register` bigint(30) NOT NULL DEFAULT 0,
  `lastlogin` bigint(30) NOT NULL DEFAULT 0,
  `lastactivity` int(11) NOT NULL DEFAULT 0,
  `loginkey` varchar(32) DEFAULT NULL,
  `lastlongip` varchar(128) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `amac_users_permissions`
--

DROP TABLE IF EXISTS `amac_users_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amac_users_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `module` varchar(35) NOT NULL,
  `can_view` tinyint(1) NOT NULL DEFAULT 1,
  `can_add` tinyint(1) NOT NULL DEFAULT 1,
  `can_edit` tinyint(1) NOT NULL DEFAULT 1,
  `can_delete` tinyint(1) NOT NULL DEFAULT 0,
  `can_auth` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=730 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `amac_vw_insumos_autorizados`
--

DROP TABLE IF EXISTS `amac_vw_insumos_autorizados`;
/*!50001 DROP VIEW IF EXISTS `amac_vw_insumos_autorizados`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `amac_vw_insumos_autorizados` (
  `id` tinyint NOT NULL,
  `date` tinyint NOT NULL,
  `user_id` tinyint NOT NULL,
  `cancelled` tinyint NOT NULL,
  `cancelled_by` tinyint NOT NULL,
  `cancelled_date` tinyint NOT NULL,
  `cancelled_text` tinyint NOT NULL,
  `authorized_by` tinyint NOT NULL,
  `authorized_date` tinyint NOT NULL,
  `observations` tinyint NOT NULL,
  `state` tinyint NOT NULL,
  `exported` tinyint NOT NULL,
  `uniqid` tinyint NOT NULL,
  `requester` tinyint NOT NULL,
  `authorizer` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'agrimac'
--

--
-- Final view structure for view `amac_vw_insumos_autorizados`
--

/*!50001 DROP TABLE IF EXISTS `amac_vw_insumos_autorizados`*/;
/*!50001 DROP VIEW IF EXISTS `amac_vw_insumos_autorizados`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `amac_vw_insumos_autorizados` AS select `d`.`id` AS `id`,`d`.`date` AS `date`,`d`.`user_id` AS `user_id`,`d`.`cancelled` AS `cancelled`,`d`.`cancelled_by` AS `cancelled_by`,`d`.`cancelled_date` AS `cancelled_date`,`d`.`cancelled_text` AS `cancelled_text`,`d`.`authorized_by` AS `authorized_by`,`d`.`authorized_date` AS `authorized_date`,`d`.`observations` AS `observations`,`d`.`state` AS `state`,`d`.`exported` AS `exported`,`d`.`uniqid` AS `uniqid`,`rq`.`fullname` AS `requester`,`au`.`fullname` AS `authorizer` from ((`amac_insumos` `d` join `amac_users` `rq` on(`d`.`user_id` = `rq`.`uniqid`)) join `amac_users` `au` on(`d`.`authorized_by` = `au`.`uniqid`)) where `d`.`cancelled` = 0 and `d`.`authorized_by` <> '0' */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-08 17:04:21
