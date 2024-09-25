/*
SQLyog Ultimate v12.5.1 (32 bit)
MySQL - 10.4.32-MariaDB : Database - ci4_api
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ci4_api` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `ci4_api`;

/*Table structure for table `produk` */

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `nama_produk` varchar(100) NOT NULL COMMENT 'Nama Produk',
  `harga` varchar(255) NOT NULL COMMENT 'Harga',
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='datatable produk table';

/*Data for the table `produk` */

insert  into `produk`(`id`,`nama_produk`,`harga`,`foto`) values 
(1,'Kaos Pria','50000',NULL),
(2,'Culotte Highwaist Yellow','120000',NULL),
(3,'Jaket','150000',NULL),
(4,'Hoodie','100000',NULL),
(5,'Blouse','125000',NULL),
(6,'Kemeja Flanel','111000',NULL),
(7,'Skinny Jeans','90000',NULL),
(8,'Kemeja Cap Sastro','200000',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
