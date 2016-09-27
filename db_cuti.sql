/*
SQLyog Community v11.31 (32 bit)
MySQL - 5.6.21 : Database - mendagrilayanan
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mendagrilayanan` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `mendagrilayanan`;

/*Table structure for table `ref_group_layanan` */

DROP TABLE IF EXISTS `ref_group_layanan`;

CREATE TABLE `ref_group_layanan` (
  `id_group_layanan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_group` int(11) DEFAULT NULL,
  `kode_layanan` char(3) DEFAULT NULL,
  PRIMARY KEY (`id_group_layanan`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

/*Data for the table `ref_group_layanan` */

insert  into `ref_group_layanan`(`id_group_layanan`,`id_user_group`,`kode_layanan`) values (32,8,'17'),(33,1,'01'),(34,1,'02'),(35,1,'03'),(36,1,'04'),(37,1,'05'),(38,1,'06'),(39,1,'07'),(40,1,'08'),(41,1,'09'),(42,1,'10'),(43,1,'11'),(44,1,'12'),(45,1,'13'),(46,1,'14'),(47,1,'15'),(48,1,'16'),(49,1,'17'),(50,1,'18'),(51,1,'19'),(52,1,'20'),(53,1,'21'),(54,1,'22'),(55,1,'23'),(56,1,'24'),(57,1,'25'),(58,1,'26'),(59,1,'27'),(60,1,'28'),(61,1,'29'),(62,1,'30'),(63,1,'31');

/*Table structure for table `ref_group_menu` */

DROP TABLE IF EXISTS `ref_group_menu`;

CREATE TABLE `ref_group_menu` (
  `id_group_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_group` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_group_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `ref_group_menu` */

insert  into `ref_group_menu`(`id_group_menu`,`id_user_group`,`id_menu`) values (15,8,1),(16,8,7),(17,8,9),(18,8,13),(19,1,1),(20,1,2),(21,1,3),(22,1,4),(23,1,5),(24,1,6),(25,1,7),(26,1,8),(27,1,9),(28,1,10),(29,1,11),(30,1,12),(31,1,13),(32,1,14),(33,1,15);

/*Table structure for table `ref_jenis_cuti` */

DROP TABLE IF EXISTS `ref_jenis_cuti`;

CREATE TABLE `ref_jenis_cuti` (
  `kcuti` varchar(5) NOT NULL,
  `ncuti` varchar(200) DEFAULT NULL,
  `max` int(11) DEFAULT NULL,
  PRIMARY KEY (`kcuti`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ref_jenis_cuti` */

insert  into `ref_jenis_cuti`(`kcuti`,`ncuti`,`max`) values ('1','Cuti Tahunan',12),('2','Cuti Besar',10),('3','Cuti Sakit',NULL),('4','Cuti Bersalin',NULL),('5','Cuti Alasan Penting',NULL),('6','Cuti Diluar Tanggungan Negara',NULL);

/*Table structure for table `ref_kategori_layanan` */

DROP TABLE IF EXISTS `ref_kategori_layanan`;

CREATE TABLE `ref_kategori_layanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_layanan` char(3) DEFAULT NULL,
  `nama` varchar(500) DEFAULT NULL,
  `tabel` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0.Tidak Aktif 1.Aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `ref_kategori_layanan` */

insert  into `ref_kategori_layanan`(`id`,`kode_layanan`,`nama`,`tabel`,`status`) values (1,'01','Pengangkatan CPNS KE  PNS','',0),(2,'02','Pengangkatan, Pemindahan dan Pemberhentian jabatan pelaksana',NULL,0),(3,'03','Pengangkatan, Pemindahan dan Pemberhentian jabatan pengawas (Khusus Sekjen)',NULL,0),(4,'04','Pengangkatan, Pemindahan dan Pemberhentian jabatan administrator',NULL,0),(5,'05','Pengangkatan, Pemindahan dan Pemberhentian jabatan pimpinan tinggi',NULL,0),(6,'06','Pemindahan jabatan pelaksana, pengawas, administrator, dan pimpinan tinggi ke jabatan fungsional',NULL,0),(7,'07','Pengangkatan dan kenaikan jenjang jabatan fungsional (JFT)',NULL,0),(8,'08','Pemindahan PNS instansi lain ke Kementerian Dalam Negeri',NULL,0),(9,'09','Pemberhentian Jabatan Fungsional',NULL,0),(10,'10','Pengangkatan Kembali Jabatan Fungsional',NULL,0),(11,'11','Penyesuaian/inpassing Jabatan Fungsional',NULL,0),(12,'12','Pembebasan Sementara Jabatan Fungsional',NULL,0),(13,'13','Perpanjangan usia pensiun PNS yang menduduki jabatan fungsional tertentu',NULL,0),(14,'14','Peninjauan Masa Kerja',NULL,0),(15,'15','Penggantian Keputusan Pegawai Asli yang Hilang.',NULL,0),(16,'16','Pemberian Tugas Belajar dan Izin Belajar',NULL,0),(17,'17','Pemberian Izin Cuti','tr_detail_cuti',1),(18,'18','Pernyataan Pelantikan Jabatan Pimpinan Tinggi, Administrator, dan pengawas',NULL,0),(19,'19','Pernyataan Menduduki Jabatan Pimpinan Tinggi, Administrator, dan Pengawas',NULL,0),(20,'20','Pernyataan Melaksanakan Tugas Jabatan Pimpinan Tinggi,Administrator, dan Pengawas',NULL,0),(21,'21','Kenaikan Gaji Berkala',NULL,0),(22,'22','Usul PNS yang Menduduki Jabatan Fungsional',NULL,0),(23,'23','Pernyataan Persetujuan Pindah PNS',NULL,0),(24,'24','Usul Pemberhentian PNS',NULL,0),(25,'25','Usul Pemberian Tanda Kehormatan Satya Lencana Karya Satya',NULL,0),(26,'26','Usul Pengangkatan CPNS',NULL,0),(27,'27','Laporan Peningkatan Pendidikan dan Pencantuman Nama Gelar',NULL,0),(28,'28','Pakta Integritas','tr_detail_pakta_integritas',1),(29,'29','Usul Kenaikan Pangkat',NULL,0),(30,'30','Penyelesaian penerbitan kartu istri/suami','tr_detail_karis_karsu',1),(31,'31','Penerbitan TASPEN','tr_detail_taspen',1);

/*Table structure for table `ref_menu` */

DROP TABLE IF EXISTS `ref_menu`;

CREATE TABLE `ref_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `parrent` int(11) DEFAULT NULL,
  `nama_menu` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `urutan` varchar(255) DEFAULT NULL,
  `class_active` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `ref_menu` */

insert  into `ref_menu`(`id_menu`,`parrent`,`nama_menu`,`link`,`urutan`,`class_active`) values (1,0,'Usulan','usulan','1','1'),(2,0,'Approval','approval','2','2'),(3,0,'Output','data_output','3','3'),(4,0,'Dashboard','dashboard','4','4'),(5,0,'Laporan','laporan','5','5'),(6,0,'Data Master','data_master','6','6'),(7,1,'Usulan Individu','usulan/individu','1','1,7'),(8,1,'Usulan Kolektif','usulan/kolektif','2','1,8'),(9,1,'Lihat Usulan','usulan/data_usul','3','1,9'),(10,6,'User Layanan','data_master/user','3','6,10'),(11,6,'Role','data_master/role','2','6,11'),(12,6,'Layanan','data_master/layanan','1','6,12'),(13,0,'Tracking','tracking','7','13'),(15,6,'Persyaratan','data_master/syarat','5','6,15');

/*Table structure for table `ref_syarat_kategori_layanan` */

DROP TABLE IF EXISTS `ref_syarat_kategori_layanan`;

CREATE TABLE `ref_syarat_kategori_layanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_layanan` char(3) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `ref_syarat_kategori_layanan` */

insert  into `ref_syarat_kategori_layanan`(`id`,`kode_layanan`,`nama`) values (2,'30','SK Jabatan Terakhir'),(3,'30','Surat Nikah Legalisir'),(4,'30','Pas Photo Berwarna Ukuran 2x3 (2) Lembar'),(5,'30','Surat Pengantar dari Komponen Masing-Masing'),(6,'31','Formulir Pendataan Peserta Taspen'),(7,'31','Surat Pernyataan Melaksanakan Tugas'),(8,'31','Kartu Pegawai'),(9,'31','SK CPNS'),(10,'31','SK PNS');

/*Table structure for table `ref_user_group` */

DROP TABLE IF EXISTS `ref_user_group`;

CREATE TABLE `ref_user_group` (
  `id_user_group` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user_group` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user_group`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `ref_user_group` */

insert  into `ref_user_group`(`id_user_group`,`nama_user_group`) values (1,'Superadmin'),(2,'Admin Pengelola Kepegawaian'),(3,'Admin Bangrir'),(4,'Admin Mutasi'),(5,'Admin Disipilin'),(6,'Admin Perencanaan'),(7,'Eksekutif'),(8,'Pegawai');

/*Table structure for table `ref_user_layanan` */

DROP TABLE IF EXISTS `ref_user_layanan`;

CREATE TABLE `ref_user_layanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(255) DEFAULT NULL COMMENT 'Relasi dengan NIP & Password Yg Ada di SIMPEG',
  `nama` varchar(50) DEFAULT NULL,
  `id_user_group` int(11) DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `logout_time` datetime DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `ref_user_layanan` */

insert  into `ref_user_layanan`(`id`,`nip`,`nama`,`id_user_group`,`login_time`,`logout_time`,`ip`) values (1,'197201112002121001','DEDDY RIZALDI AL, S.Kom ',1,'2016-08-30 13:15:48','2016-08-30 13:15:49',NULL),(2,'199304302014062001','AMELYA FARYA REZKY, S.STP',8,NULL,NULL,NULL);

/*Table structure for table `tr_detail_cuti` */

DROP TABLE IF EXISTS `tr_detail_cuti`;

CREATE TABLE `tr_detail_cuti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_usulan` varchar(50) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `jenis_cuti` int(11) DEFAULT NULL,
  `jum_hari` double DEFAULT NULL,
  `sisa_cuti` double DEFAULT NULL,
  `tmulai` date DEFAULT NULL,
  `takhir` date DEFAULT NULL,
  `keterangan` text,
  `alamat` text,
  `tgl_pengajuan` date DEFAULT NULL,
  `nip_atasan` varchar(18) DEFAULT NULL,
  `nama_atasan` varchar(200) DEFAULT NULL,
  `pangkat_atasan` varchar(200) DEFAULT NULL,
  `jabatan_atasan` text,
  `no_sk` varchar(100) DEFAULT NULL,
  `tgl_sk` date DEFAULT NULL,
  `pejabat_berwenang` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tr_detail_cuti` */

insert  into `tr_detail_cuti`(`id`,`kode_usulan`,`tahun`,`nip`,`jenis_cuti`,`jum_hari`,`sisa_cuti`,`tmulai`,`takhir`,`keterangan`,`alamat`,`tgl_pengajuan`,`nip_atasan`,`nama_atasan`,`pangkat_atasan`,`jabatan_atasan`,`no_sk`,`tgl_sk`,`pejabat_berwenang`) values (1,'0001',2016,'199304302014062001',1,2,10,'2016-10-01','2016-10-02','hkgfy','xbfghytk','2016-09-13','197201112002121001','DEDDY RIZALDI AL, S.Kom',NULL,'PRANATA KOMPUTER MUDA BIRO KEPEGAWAIAN PADA SEKRETARIAT JENDERAL',NULL,NULL,NULL),(2,'170001092016',2016,'199304302014062001',1,2,10,'2016-01-01','2016-01-02','hgjyuk','regrth','2016-09-13','197201112002121001','DEDDY RIZALDI AL, S.Kom',NULL,'PRANATA KOMPUTER MUDA BIRO KEPEGAWAIAN PADA SEKRETARIAT JENDERAL',NULL,NULL,NULL),(3,'170002092016',NULL,'199304302014062001',NULL,NULL,NULL,'0000-00-00','0000-00-00',NULL,NULL,'2016-09-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'170003092016',2016,'199304302014062001',1,1,11,'2016-01-01','2016-01-01','bfg','vfdgb',NULL,'199304302014062001','AMELYA FARYA REZKY, S.STP',NULL,'PENGADMINISTRASI UMUM SUBBAGIAN TATA USAHA STAF AHLI MENTERI PADA BAGIAN TATA USAHA PIMPINAN BIRO ADMINISTRASI PIMPINAN SEKRETARIAT JENDERAL',NULL,NULL,NULL);

/*Table structure for table `tr_detail_karis_karsu` */

DROP TABLE IF EXISTS `tr_detail_karis_karsu`;

CREATE TABLE `tr_detail_karis_karsu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_usulan` varchar(255) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `jenis_kartu` int(11) DEFAULT NULL COMMENT '1.Karis 2.Karsu',
  `nama_suami_istri` varchar(100) DEFAULT NULL,
  `no_surat_nikah` varchar(100) DEFAULT NULL,
  `tgl_surat_nikah` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tr_detail_karis_karsu` */

insert  into `tr_detail_karis_karsu`(`id`,`kode_usulan`,`nip`,`jenis_kartu`,`nama_suami_istri`,`no_surat_nikah`,`tgl_surat_nikah`) values (1,'300001092016','199304302014062001',1,'w2e3','dff','2016-01-01');

/*Table structure for table `tr_detail_pakta_integritas` */

DROP TABLE IF EXISTS `tr_detail_pakta_integritas`;

CREATE TABLE `tr_detail_pakta_integritas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_usulan` varchar(255) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `pernyataan` int(11) DEFAULT NULL COMMENT '1.Setuju 2.Tidak Setuju',
  `nip_saksi` varchar(50) DEFAULT NULL,
  `nama_saksi` varchar(50) DEFAULT NULL,
  `jabatan_saksi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tr_detail_pakta_integritas` */

/*Table structure for table `tr_detail_taspen` */

DROP TABLE IF EXISTS `tr_detail_taspen`;

CREATE TABLE `tr_detail_taspen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_usulan` varchar(255) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nip_an` varchar(50) DEFAULT NULL,
  `nama_an` varchar(100) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tr_detail_taspen` */

insert  into `tr_detail_taspen`(`id`,`kode_usulan`,`nip`,`nip_an`,`nama_an`,`ket`) values (1,'310001092016','199304302014062001',NULL,NULL,'aerhytyu'),(2,'31000001092016',NULL,'197201112002121001','DEDDY RIZALDI AL, S.Kom','fdhh');

/*Table structure for table `tr_transaksi` */

DROP TABLE IF EXISTS `tr_transaksi`;

CREATE TABLE `tr_transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_usulan` varchar(255) DEFAULT NULL,
  `kode_layanan` char(3) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1. Usulan 2. Approval 3. Output 4. Penolakan',
  `nip` varchar(50) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `gol_pangkat` varchar(255) DEFAULT NULL,
  `unit_kerja` varchar(255) DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `waktu_usulan` datetime DEFAULT NULL,
  `id_user_usul` int(11) DEFAULT NULL,
  `id_user_approve` int(11) DEFAULT NULL,
  `waktu_approve` datetime DEFAULT NULL,
  `ket` text,
  `atas_nama` varchar(50) DEFAULT NULL,
  `atas_nip` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `tr_transaksi` */

insert  into `tr_transaksi`(`id`,`kode_usulan`,`kode_layanan`,`status`,`nip`,`nama`,`jabatan`,`gol_pangkat`,`unit_kerja`,`telp`,`email`,`waktu_usulan`,`id_user_usul`,`id_user_approve`,`waktu_approve`,`ket`,`atas_nama`,`atas_nip`) values (1,'0001','17',4,'199304302014062001','AMELYA FARYA REZKY, S.STP','PENGADMINISTRASI UMUM SUBBAGIAN TATA USAHA STAF AHLI MENTERI PADA BAGIAN TATA USAHA PIMPINAN BIRO ADMINISTRASI PIMPINAN SEKRETARIAT JENDERAL','PENATA MUDA (III/a)','SUBBAGIAN TATA USAHA STAF AHLI MENTERI','3243426568','gfhghhjl','2016-09-13 10:07:33',NULL,1,'2016-09-14 10:49:57','sdfrhrt',NULL,NULL),(2,'170001092016','17',3,'199304302014062001','AMELYA FARYA REZKY, S.STP','PENGADMINISTRASI UMUM SUBBAGIAN TATA USAHA STAF AHLI MENTERI PADA BAGIAN TATA USAHA PIMPINAN BIRO ADMINISTRASI PIMPINAN SEKRETARIAT JENDERAL','PENATA MUDA (III/a)','SUBBAGIAN TATA USAHA STAF AHLI MENTERI','232354','gfh','2016-09-13 10:11:36',NULL,1,'2016-09-14 10:50:19',NULL,NULL,NULL),(3,'280001092016','28',4,'199304302014062001','AMELYA FARYA REZKY, S.STP','PENGADMINISTRASI UMUM SUBBAGIAN TATA USAHA STAF AHLI MENTERI PADA BAGIAN TATA USAHA PIMPINAN BIRO ADMINISTRASI PIMPINAN SEKRETARIAT JENDERAL','PENATA MUDA (III/a)','SUBBAGIAN TATA USAHA STAF AHLI MENTERI','','','2016-09-14 06:21:57',1,1,'2016-09-14 10:48:45','tidak lengkap',NULL,NULL),(4,'170002092016','17',4,'199304302014062001','AMELYA FARYA REZKY, S.STP','PENGADMINISTRASI UMUM SUBBAGIAN TATA USAHA STAF AHLI MENTERI PADA BAGIAN TATA USAHA PIMPINAN BIRO ADMINISTRASI PIMPINAN SEKRETARIAT JENDERAL','PENATA MUDA (III/a)','SUBBAGIAN TATA USAHA STAF AHLI MENTERI','','','2016-09-14 06:27:32',1,1,'2016-09-14 10:41:49','Belum Lengkap',NULL,NULL),(5,'300001092016','30',2,'199304302014062001','AMELYA FARYA REZKY, S.STP','PENGADMINISTRASI UMUM SUBBAGIAN TATA USAHA STAF AHLI MENTERI PADA BAGIAN TATA USAHA PIMPINAN BIRO ADMINISTRASI PIMPINAN SEKRETARIAT JENDERAL','PENATA MUDA (III/a)','SUBBAGIAN TATA USAHA STAF AHLI MENTERI','','','2016-09-20 05:15:07',7576,7576,'2016-09-20 05:16:59',NULL,NULL,NULL),(6,'170003092016','17',4,'199304302014062001','AMELYA FARYA REZKY, S.STP','PENGADMINISTRASI UMUM SUBBAGIAN TATA USAHA STAF AHLI MENTERI PADA BAGIAN TATA USAHA PIMPINAN BIRO ADMINISTRASI PIMPINAN SEKRETARIAT JENDERAL','PENATA MUDA (III/a)','SUBBAGIAN TATA USAHA STAF AHLI MENTERI','','','2016-09-20 05:18:27',7576,7576,'2016-09-26 05:28:51','tidak lengkap',NULL,NULL),(7,'310001092016','31',2,'199304302014062001','AMELYA FARYA REZKY, S.STP','PENGADMINISTRASI UMUM SUBBAGIAN TATA USAHA STAF AHLI MENTERI PADA BAGIAN TATA USAHA PIMPINAN BIRO ADMINISTRASI PIMPINAN SEKRETARIAT JENDERAL','PENATA MUDA (III/a)','SUBBAGIAN TATA USAHA STAF AHLI MENTERI','122','wterty','2016-09-26 04:30:21',7576,7576,'2016-09-26 05:29:16',NULL,NULL,NULL),(8,'31000001092016','31',1,'197201112002121001','DEDDY RIZALDI AL, S.Kom','PRANATA KOMPUTER MUDA BIRO KEPEGAWAIAN PADA SEKRETARIAT JENDERAL','PENATA TK.I (III/d)','BIRO KEPEGAWAIAN','53125299','deddy.rizaldi_al@yahoo.com','2016-09-26 10:42:22',7576,NULL,NULL,NULL,'DEDDY RIZALDI AL, S.Kom','197201112002121001');

/*Table structure for table `tr_transaksi_ceklist_syarat` */

DROP TABLE IF EXISTS `tr_transaksi_ceklist_syarat`;

CREATE TABLE `tr_transaksi_ceklist_syarat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_usulan` varchar(255) DEFAULT NULL,
  `kode_layanan` char(3) DEFAULT NULL,
  `id_syarat` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `tr_transaksi_ceklist_syarat` */

insert  into `tr_transaksi_ceklist_syarat`(`id`,`kode_usulan`,`kode_layanan`,`id_syarat`) values (1,'300001092016','30',2),(2,'300001092016','30',3),(3,'300001092016','30',4),(4,'310001092016','31',6),(5,'310001092016','31',7),(6,'310001092016','31',8),(7,'310001092016','31',9),(8,'31000001092016','31',6),(9,'31000001092016','31',7),(10,'31000001092016','31',8),(11,'31000001092016','31',9);

/*Table structure for table `tr_transaksi_history` */

DROP TABLE IF EXISTS `tr_transaksi_history`;

CREATE TABLE `tr_transaksi_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_usulan` varchar(255) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `flag_maju_mundur` int(11) DEFAULT NULL COMMENT '1. Next 2.Back',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `tr_transaksi_history` */

insert  into `tr_transaksi_history`(`id`,`kode_usulan`,`id_user`,`waktu_mulai`,`waktu_selesai`,`flag_maju_mundur`) values (1,'300001092016',7576,'2016-09-20 05:15:07',NULL,2),(2,'170003092016',7576,'2016-09-20 05:18:27',NULL,2),(3,'310001092016',7576,'2016-09-26 04:30:21',NULL,2),(4,'170003092016',7576,'2016-09-20 05:18:27','2016-09-26 05:28:51',4),(5,'310001092016',7576,'2016-09-26 04:30:21','2016-09-26 05:29:16',3),(6,'31000001092016',7576,'2016-09-26 10:42:22',NULL,2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
