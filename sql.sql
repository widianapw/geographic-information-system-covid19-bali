/*
SQLyog Enterprise v12.5.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - sig-covid
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `tb_kabupaten` */

DROP TABLE IF EXISTS `tb_kabupaten`;

CREATE TABLE `tb_kabupaten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kabupaten` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_kabupaten` */

insert  into `tb_kabupaten`(`id`,`kabupaten`) values 
(1,'denpasar'),
(2,'bangli'),
(3,'badung'),
(4,'tabanan'),
(5,'jembrana'),
(6,'buleleng'),
(7,'gianyar'),
(8,'karangasem'),
(9,'klungkung');

/*Table structure for table `tb_laporan` */

DROP TABLE IF EXISTS `tb_laporan`;

CREATE TABLE `tb_laporan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_kabupaten` int(11) DEFAULT NULL,
  `positif` int(11) DEFAULT NULL,
  `meninggal` int(11) DEFAULT NULL,
  `sembuh` int(11) DEFAULT NULL,
  `dirawat` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_kabupaten` (`id_kabupaten`),
  CONSTRAINT `tb_laporan_ibfk_1` FOREIGN KEY (`id_kabupaten`) REFERENCES `tb_kabupaten` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_laporan` */

insert  into `tb_laporan`(`id`,`id_kabupaten`,`positif`,`meninggal`,`sembuh`,`dirawat`,`tanggal`,`created_at`,`updated_at`,`status`) values 
(1,1,3,1,1,1,'2020-05-16','2020-05-16 12:09:09','2020-05-17 22:10:58',1),
(2,2,104,2,90,12,'2020-05-16','2020-05-16 11:59:13','2020-05-17 22:10:58',1),
(4,3,36,12,12,12,'2020-05-16','2020-05-16 15:06:54','2020-05-17 22:10:59',1),
(5,4,4,1,2,1,'2020-05-16','2020-05-16 15:07:09','2020-05-17 22:10:59',1),
(6,5,36,12,12,12,'2020-05-16','2020-05-16 15:07:29','2020-05-17 22:11:01',1),
(7,6,14,1,12,1,'2020-05-16','2020-05-16 15:07:42','2020-05-17 22:11:01',1),
(8,7,11,5,1,5,'2020-05-16','2020-05-16 15:07:58','2020-05-17 22:11:02',1),
(9,8,48,43,1,4,'2020-05-16','2020-05-16 15:08:13','2020-05-17 22:11:02',1),
(10,9,11,5,1,5,'2020-05-16','2020-05-16 15:08:28','2020-05-17 22:11:03',1),
(254,1,3,1,1,1,'2020-05-17','2020-05-17 00:00:01','0000-00-00 00:00:00',0),
(255,2,104,2,90,12,'2020-05-17','2020-05-17 00:00:01','0000-00-00 00:00:00',0),
(256,3,36,12,12,12,'2020-05-17','2020-05-17 00:00:01','0000-00-00 00:00:00',0),
(257,4,1225,1,12,1212,'2020-05-17','2020-05-17 00:00:01','2020-05-17 22:11:05',1),
(258,5,36,12,12,12,'2020-05-17','2020-05-17 00:00:01','0000-00-00 00:00:00',0),
(259,6,14,1,12,1,'2020-05-17','2020-05-17 00:00:01','0000-00-00 00:00:00',0),
(260,7,11,5,1,5,'2020-05-17','2020-05-17 00:00:01','0000-00-00 00:00:00',0),
(261,8,48,43,1,4,'2020-05-17','2020-05-17 00:00:01','0000-00-00 00:00:00',0),
(262,9,11,5,1,5,'2020-05-17','2020-05-17 00:00:01','0000-00-00 00:00:00',0);

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `insert_data_next_day` */

/*!50106 DROP EVENT IF EXISTS `insert_data_next_day`*/;

DELIMITER $$

/*!50106 CREATE DEFINER=`root`@`localhost` EVENT `insert_data_next_day` ON SCHEDULE EVERY 1 DAY STARTS '2020-05-17 00:00:01' ON COMPLETION PRESERVE ENABLE DO BEGIN
	    declare i Int;
	    declare dirawat1, meninggal1, sembuh1, positif1 int;
	    set i = 1;
	    while i<10 do
		select tb_laporan.`dirawat`, tb_laporan.`sembuh`, tb_laporan.`meninggal`, tb_laporan.`positif` into dirawat1, sembuh1, meninggal1, positif1 from tb_laporan where tb_laporan.`id_kabupaten` = i order by tb_laporan.`tanggal` DESC limit 1;
		insert into tb_laporan(id_kabupaten,dirawat, meninggal,sembuh,positif,tanggal) values(i, dirawat1, meninggal1, sembuh1, positif1, DATE(NOW()));
		set i = i+1;
	    end while;
	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
