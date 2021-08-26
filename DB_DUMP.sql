/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.17-MariaDB : Database - admin paneli
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `article_translations` */

DROP TABLE IF EXISTS `article_translations`;

CREATE TABLE `article_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `seo_keywords` text DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id_key` (`article_id`),
  KEY `lang_key` (`language_id`),
  CONSTRAINT `article_id_key` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `article_translations` */

insert  into `article_translations`(`id`,`article_id`,`language_id`,`title`,`summary`,`description`,`seo_keywords`,`seo_description`,`created_at`,`updated_at`,`deleted_at`) values
(2,5,2,'First Article','short summary','<p>here is details description</p>','seo, keywords','seo decription','2021-07-31 06:05:40','2021-07-31 07:22:46',NULL),
(3,6,2,'Blog Second one updated','some short desc','<p>some details desc</p>','some, keywords','some desc for seo','2021-07-31 06:15:24','2021-07-31 06:50:25',NULL),
(5,5,51,'Test','test short','<p>test details</p>','test, keywords','test desc','2021-07-31 07:02:12','2021-07-31 07:21:08',NULL),
(6,5,28,'Title for Afaano',NULL,NULL,NULL,NULL,'2021-07-31 07:07:29','2021-07-31 07:07:29',NULL),
(7,5,6,'For PUshto title','some short desc','<p>some details description</p>','some keywords','some description','2021-07-31 07:21:54','2021-07-31 07:21:54',NULL),
(8,5,54,'Somali Title',NULL,NULL,NULL,NULL,'2021-07-31 07:22:19','2021-07-31 07:22:19',NULL),
(9,8,2,'Third Article updated','some short description','<p>some details description</p>','some, keywords','some seo description','2021-07-31 07:23:40','2021-07-31 07:23:51',NULL),
(10,8,1,'Farsi Title',NULL,NULL,NULL,NULL,'2021-07-31 07:24:10','2021-07-31 07:24:10',NULL);

/*Table structure for table `articles` */

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `views` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `CAT_KEY_ID` (`category_id`),
  CONSTRAINT `CAT_KEY_ID` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `articles` */

insert  into `articles`(`id`,`category_id`,`slug`,`image`,`status`,`views`,`created_at`,`updated_at`,`deleted_at`) values
(5,1,'first-article-5','1627711540.png',1,0,'2021-07-31 06:05:40','2021-07-31 07:08:05',NULL),
(6,2,'blog-second-6',NULL,1,0,'2021-07-31 06:15:24','2021-07-31 06:15:24',NULL),
(8,2,'third-article-8','1627716220.webp',1,0,'2021-07-31 07:23:40','2021-07-31 07:23:40',NULL);

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `type` enum('service','article') COLLATE utf8_bin DEFAULT 'service',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `categories` */

insert  into `categories`(`id`,`order`,`status`,`type`,`created_at`,`updated_at`,`deleted_at`) values
(1,21,1,'service','2021-07-29 09:37:39','2021-07-29 10:30:58',NULL),
(2,20,1,'article','2021-07-29 09:38:59','2021-07-29 10:12:34',NULL),
(3,1,1,'article','2021-07-29 09:39:34','2021-07-29 10:47:48','2021-07-29 10:47:48'),
(4,4,1,'service','2021-07-29 11:03:19','2021-07-29 11:03:19',NULL),
(5,2,1,'article','2021-07-29 11:06:13','2021-07-29 11:06:13',NULL),
(6,44,0,'service','2021-07-29 11:07:49','2021-07-29 11:08:53','2021-07-29 11:08:53');

/*Table structure for table `category_translations` */

DROP TABLE IF EXISTS `category_translations`;

CREATE TABLE `category_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id_key` (`category_id`),
  KEY `langauge_key` (`language_id`),
  CONSTRAINT `category_id_key` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `category_translations` */

insert  into `category_translations`(`id`,`category_id`,`language_id`,`title`,`description`,`created_at`,`updated_at`,`deleted_at`) values
(1,1,2,'First Category','<p>Here is some details of the category. updated</p>','2021-07-29 09:37:39','2021-07-29 10:40:53',NULL),
(2,2,2,'Test Category Second','<p>Here is some details of the category. updated</p>','2021-07-29 09:38:59','2021-07-29 10:34:09',NULL),
(3,3,2,'Test Category Four','<p>Here is some details of the category fourth</p>','2021-07-29 09:39:34','2021-07-29 10:47:48','2021-07-29 10:47:48'),
(4,1,1,'First Category Farsi Title updated',NULL,'2021-07-29 10:37:26','2021-07-29 10:38:06',NULL),
(6,5,2,'testsdfs dfsdf sdfsdf f','<p>sdfsdf</p>','2021-07-29 11:06:13','2021-07-29 11:06:59',NULL),
(7,5,1,'sdfddd',NULL,'2021-07-29 11:07:06','2021-07-29 11:07:06',NULL),
(8,6,2,'tttttest','<p>sdf</p>','2021-07-29 11:07:49','2021-07-29 11:08:53','2021-07-29 11:08:53');

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customers` */

insert  into `customers`(`id`,`name`,`email`,`password`,`email_verified_at`,`remember_token`,`created_at`,`updated_at`) values
(1,'Test Customer','customer@customer.com','$2y$10$WXq2Sz6jiSK0yR3y7gUF7epn1xPqCmZfrKRTvwskJhcE7f.DOxCiy',NULL,NULL,'2021-08-04 14:49:06','2021-08-04 14:49:09');

/*Table structure for table `faq_translations` */

DROP TABLE IF EXISTS `faq_translations`;

CREATE TABLE `faq_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `faq_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `short` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faq_id_key` (`faq_id`),
  KEY `lang_key` (`language_id`),
  CONSTRAINT `faq_id_key` FOREIGN KEY (`faq_id`) REFERENCES `faqs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `faq_translations` */

insert  into `faq_translations`(`id`,`faq_id`,`language_id`,`title`,`description`,`short`,`created_at`,`updated_at`,`deleted_at`) values
(1,2,2,'Test FAQ updated.','<p>Here is some details.</p>','Some Short Desc',NULL,NULL,NULL),
(2,2,1,'Farsi FAQ','<p>Here is some detail description</p>','here is some farsi short details',NULL,NULL,NULL),
(3,2,3,'Arabic Version of Test FAQ','<p>Arabic Version of Test FAQ</p>','Arabic Version of Test FAQ',NULL,NULL,NULL),
(4,3,2,'test faq two','<p>some desc</p>','here is some desc',NULL,NULL,NULL),
(5,3,1,'TEst Farsi updated','<p>some detail desc</p>','some desc',NULL,NULL,NULL),
(6,3,3,'arabic','<p>tset</p>','test',NULL,NULL,NULL),
(7,4,2,'Abc Faq','<p>some detail description</p>','some short description',NULL,NULL,NULL),
(8,4,1,'Abc Farsi','<p>some details desc for farsi</p>','some desc for faris',NULL,NULL,NULL);

/*Table structure for table `faqs` */

DROP TABLE IF EXISTS `faqs`;

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(50) DEFAULT NULL,
  `order` int(11) DEFAULT 99,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `faqs` */

insert  into `faqs`(`id`,`image`,`order`,`status`,`created_at`,`updated_at`,`deleted_at`) values
(2,NULL,10,1,'2021-07-30 09:23:23','2021-07-30 09:23:56',NULL),
(3,NULL,12,1,'2021-07-30 09:32:45','2021-07-30 09:32:45',NULL),
(4,'1627638260.webp',12,1,'2021-07-30 09:44:20','2021-07-30 09:44:20',NULL);

/*Table structure for table `feature_item_translations` */

DROP TABLE IF EXISTS `feature_item_translations`;

CREATE TABLE `feature_item_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feature_item_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feature_item_key` (`feature_item_id`),
  CONSTRAINT `feature_item_key` FOREIGN KEY (`feature_item_id`) REFERENCES `feature_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `feature_item_translations` */

insert  into `feature_item_translations`(`id`,`feature_item_id`,`language_id`,`title`,`description`,`created_at`,`updated_at`,`deleted_at`) values
(1,7,2,'Test Item One of type List','<p>here is some description updated</p>','2021-08-04 05:30:50','2021-08-04 05:48:52',NULL),
(2,8,2,'Test Item Two of type color','<p>here is some details.</p>','2021-08-04 05:34:12','2021-08-04 05:34:12',NULL),
(3,9,2,'Test Item Three of type Icon','<p>here is some details</p>','2021-08-04 05:34:53','2021-08-04 05:34:53',NULL),
(4,7,51,'Japanese list','<p>Here is japanese details</p>','2021-08-04 05:45:08','2021-08-04 05:47:44',NULL),
(5,7,1,'Farsi title','<p>Here is details for farsi</p>','2021-08-04 05:48:16','2021-08-04 05:48:29',NULL);

/*Table structure for table `feature_items` */

DROP TABLE IF EXISTS `feature_items`;

CREATE TABLE `feature_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feature_id` int(11) NOT NULL,
  `price` float(8,2) DEFAULT NULL,
  `type` enum('list_item','textbox','textarea','icon','color') DEFAULT 'list_item',
  `icon` varchar(255) DEFAULT NULL,
  `preview_image` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `featureID_Key` (`feature_id`),
  CONSTRAINT `featureID_Key` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `feature_items` */

insert  into `feature_items`(`id`,`feature_id`,`price`,`type`,`icon`,`preview_image`,`created_at`,`updated_at`,`deleted_at`) values
(7,8,500.00,'list_item',NULL,'1628055050.webp','2021-08-04','2021-08-04',NULL),
(8,8,200.00,'color',NULL,'1628055252.webp','2021-08-04','2021-08-04',NULL),
(9,8,100.00,'icon','1628055293.webp','1628055293.webp','2021-08-04','2021-08-04',NULL);

/*Table structure for table `feature_option_translations` */

DROP TABLE IF EXISTS `feature_option_translations`;

CREATE TABLE `feature_option_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feature_option_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feature_option_id_index` (`feature_option_id`),
  CONSTRAINT `feature_option_id_index` FOREIGN KEY (`feature_option_id`) REFERENCES `feature_options` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `feature_option_translations` */

insert  into `feature_option_translations`(`id`,`feature_option_id`,`language_id`,`title`,`description`,`created_at`,`updated_at`,`deleted_at`) values
(1,4,2,'First Option List updated','<p>This is list option</p>','2021-08-03 10:39:49','2021-08-03 11:22:39',NULL),
(3,4,51,'Japanese Ttile','<p>here is japanese option details</p>','2021-08-03 11:36:59','2021-08-03 11:39:07',NULL),
(4,4,6,'Pushto item','<p>here is pushto details.</p>','2021-08-03 11:39:37','2021-08-03 11:39:37',NULL),
(5,4,54,'Sumali title','<p>sumali description</p>','2021-08-03 11:40:44','2021-08-03 11:40:44',NULL),
(6,6,2,'Third Option of type list','<p>here is details&nbsp;</p>','2021-08-03 11:41:34','2021-08-03 11:41:34',NULL),
(7,6,51,'jsp','<p>more details</p>','2021-08-03 11:41:46','2021-08-03 11:41:53',NULL),
(8,7,2,'Test Option latest','<p>Here is some details.</p>','2021-08-04 05:31:29','2021-08-04 05:31:29',NULL);

/*Table structure for table `feature_options` */

DROP TABLE IF EXISTS `feature_options`;

CREATE TABLE `feature_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feature_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` enum('list_item','icon') DEFAULT 'list_item',
  `icon` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feature_id` (`feature_id`),
  CONSTRAINT `feature_id` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `feature_options` */

insert  into `feature_options`(`id`,`feature_id`,`title`,`description`,`type`,`icon`,`created_at`,`updated_at`,`deleted_at`) values
(4,7,NULL,NULL,'list_item',NULL,'2021-08-03','2021-08-03',NULL),
(5,7,'Second Option of type icon updated','<p>Here is the optional details for the icon option.</p>','icon','1627987233.webp','2021-08-03','2021-08-03',NULL),
(6,7,NULL,NULL,'list_item',NULL,'2021-08-03','2021-08-03',NULL),
(7,8,NULL,NULL,'list_item',NULL,'2021-08-04','2021-08-04',NULL);

/*Table structure for table `feature_translations` */

DROP TABLE IF EXISTS `feature_translations`;

CREATE TABLE `feature_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feature_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feature_id_key` (`feature_id`),
  KEY `LangKey` (`language_id`),
  CONSTRAINT `feature_id_key` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `feature_translations` */

insert  into `feature_translations`(`id`,`feature_id`,`language_id`,`title`,`description`,`created_at`,`updated_at`,`deleted_at`) values
(1,7,2,'Test Feature updated','<p>Here is some details of the service</p>','2021-08-02 08:02:37','2021-08-02 08:13:30',NULL),
(2,8,2,'Test Feature Two','<p>Here is some details</p>','2021-08-02 09:00:20','2021-08-02 09:00:56',NULL),
(3,7,51,'Japanese Title for test Feature','<p>Here is some details</p>','2021-08-02 09:08:25','2021-08-02 09:08:54',NULL),
(4,7,6,'Pushto Title for test feature','<p>here are some details.</p>','2021-08-02 09:09:16','2021-08-02 09:09:16',NULL),
(5,8,51,'Test Feature two for Japanese','<p>and some desc</p>','2021-08-02 09:09:56','2021-08-02 09:10:02',NULL);

/*Table structure for table `features` */

DROP TABLE IF EXISTS `features`;

CREATE TABLE `features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `price` float(8,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` enum('has_items_list','as_list','textbox','textarea','icon','dropdown') DEFAULT 'as_list',
  `status` tinyint(1) DEFAULT 0,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CAT_ID_KEY` (`category_id`),
  CONSTRAINT `CAT_ID_KEY` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `features` */

insert  into `features`(`id`,`category_id`,`price`,`image`,`type`,`status`,`created_at`,`updated_at`,`deleted_at`) values
(7,1,10.00,'1627891833.webp','as_list',1,'2021-08-02','2021-08-02',NULL),
(8,1,20.00,NULL,'dropdown',1,'2021-08-02','2021-08-02',NULL);

/*Table structure for table `languages` */

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `direction` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `latin_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `local_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `languages` */

insert  into `languages`(`id`,`code`,`direction`,`latin_name`,`local_name`,`status`,`created_at`,`updated_at`) values
(1,'fa','rtl','Persian','فارسی',1,NULL,NULL),
(2,'en','ltr','English','English',1,NULL,NULL),
(3,'ar','rtl','Arabic','العربية',1,NULL,NULL),
(4,'ur','rtl','Urdu','اردو',1,NULL,NULL),
(5,'tg','ltr','Tajik','Тоҷикӣ',1,NULL,NULL),
(6,'pa','rtl','Pashto','پښتو',1,NULL,NULL),
(7,'my','ltr','Malay','Malay',1,NULL,NULL),
(8,'fr','ltr','French','Français',1,NULL,NULL),
(9,'tr','ltr','التركي','Türkçe',1,NULL,NULL),
(10,'de','ltr','Deutsch','ألماني',1,NULL,NULL),
(11,'aa','ltr','عفري','Qafár afa',1,NULL,NULL),
(12,'as','rtl','آسامي','آسامي',1,NULL,NULL),
(13,'bn','ltr','بنگالی','বাংলা',1,NULL,NULL),
(14,'uz','ltr','Uzbek','Ўзбек тили',1,NULL,NULL),
(15,'vi','ltr','فيتنامي','Việt Nam',1,NULL,NULL),
(16,'th','ltr','تايلندي','ไทย',1,NULL,NULL),
(17,'sw','ltr','سواحيلي','Kiswahili',1,NULL,NULL),
(18,'ru','ltr','الروسي','Русский',1,NULL,NULL),
(19,'ne','ltr','نیبالی','नेपाली',1,NULL,NULL),
(20,'ko','rtl','korean','کوری',1,NULL,NULL),
(21,'id','ltr','Bahasa Indonesia','إندونيسي',1,NULL,NULL),
(22,'hy','ltr','hayeren','أرميني',1,NULL,NULL),
(23,'ff','ltr','pulla','فولاني',1,NULL,NULL),
(24,'az','ltr','أذري','Azərbaycanlı',1,NULL,NULL),
(25,'sq','ltr','ألباني','Shqip',1,NULL,NULL),
(26,'am','ltr','أمهري','አማርኛ',1,NULL,NULL),
(27,'nk','ltr','أنكو','enko',1,NULL,NULL),
(28,'or','rtl','أورومي','afaan oromoo',1,NULL,NULL),
(29,'uk','ltr','أوكراني','українська',1,NULL,NULL),
(30,'es','ltr','إسباني','Español',1,NULL,NULL),
(31,'ug','rtl','ایغوری','ئۇيغۇرچە',1,NULL,NULL),
(32,'pt','ltr','برتغالي','Português',1,NULL,NULL),
(33,'bg','ltr','بلغاري','Български',1,NULL,NULL),
(34,'bs','ltr','بوسني','Bosanski',1,NULL,NULL),
(35,'ta','ltr','تاميلي','தமிழ்',1,NULL,NULL),
(36,'tl','ltr','تجالوج','Tagalog',1,NULL,NULL),
(37,'jo','ltr','جولا','جولا',1,NULL,NULL),
(38,'dv','ltr','دیفهی','ދިވެހި',1,NULL,NULL),
(39,'ro','ltr','روماني','Română',1,NULL,NULL),
(40,'sd','rtl','سندي','سندي',1,NULL,NULL),
(41,'sl','ltr','سنهالي','සිංහල',1,NULL,NULL),
(42,'ny','ltr','شيشيوا','شيشيوا',1,NULL,NULL),
(43,'zh','ltr','صيني','中文',1,NULL,NULL),
(44,'ky','ltr','قرغيزي','Кыргызча',1,NULL,NULL),
(45,'kd','ltr','كرمنجي','كرمنجي',1,NULL,NULL),
(46,'ku','rtl','كوردی','كوردی سۆرانی',1,NULL,NULL),
(47,'rw','ltr','كينيارواندا','Ikinyarwanda',1,NULL,NULL),
(48,'ml','ltr','مليالم','മലയാളം',1,NULL,NULL),
(49,'hi','ltr','هندي','हिन्दी',1,NULL,NULL),
(50,'ha','ltr','هوسا','Hausa',1,NULL,NULL),
(51,'ja','ltr','ياباني','日本語',1,NULL,NULL),
(52,'yo','ltr','يوربا','Yoruba',1,NULL,NULL),
(53,'el','ltr','يوناني','Ελληνικά',1,NULL,NULL),
(54,'so','ltr','صومالي','صومالي',1,NULL,NULL),
(55,'lg','ltr','لوعندي','لوعندي',1,NULL,NULL),
(56,'te','ltr','تلغو','تلغو',1,NULL,NULL),
(57,'ma','ltr','مراناو(إيرانونية)','مراناو(إيرانونية)',1,NULL,NULL),
(58,'kk','ltr','القازاقية','القازاقية',1,NULL,NULL);

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `sub_routes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `menus` */

insert  into `menus`(`id`,`title`,`route`,`sub_routes`,`created_at`,`updated_at`) values
(1,'Manage Languages','languages',NULL,'2021-08-05 15:12:46','2021-08-05 15:13:06'),
(2,'Manage Roles','roles',NULL,'2021-08-05 15:12:48','2021-08-05 15:13:08'),
(3,'Manage Users','users',NULL,'2021-08-05 15:12:50','2021-08-05 15:13:10'),
(4,'Manage Categories','categories',NULL,'2021-08-05 15:12:52','2021-08-05 15:13:12'),
(5,'Manage Pages','pages',NULL,'2021-08-05 15:12:54','2021-08-05 15:13:14'),
(6,'Manage FAQs','faqs',NULL,'2021-08-05 15:12:57','2021-08-05 15:13:16'),
(7,'Manage Blogs','blogs',NULL,'2021-08-05 15:12:56','2021-08-05 15:13:18'),
(8,'Manage Features','features',NULL,'2021-08-05 15:12:59','2021-08-05 15:13:20'),
(9,'Manage Orders','orders',NULL,'2021-08-05 15:13:01','2021-08-05 15:13:22');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values
(1,'2019_12_14_000001_create_personal_access_tokens_table',1);

/*Table structure for table `order_detail` */

DROP TABLE IF EXISTS `order_detail`;

CREATE TABLE `order_detail` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `feature_id` bigint(20) unsigned DEFAULT NULL,
  `feature_items` text DEFAULT NULL COMMENT 'json',
  `feature_options` text DEFAULT NULL COMMENT 'json',
  `price` float(8,2) DEFAULT NULL,
  `payload` text DEFAULT NULL COMMENT 'whole order payload',
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ORD_ID_KEY` (`order_id`),
  KEY `FeatureKEY` (`feature_id`),
  CONSTRAINT `ORD_ID_KEY` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `order_detail` */

insert  into `order_detail`(`id`,`order_id`,`feature_id`,`feature_items`,`feature_options`,`price`,`payload`,`status`,`created_at`,`updated_at`,`deleted_at`) values
(3,2,7,'[\'test items\']','[\'test options\']',2500.00,NULL,1,'2021-08-04 14:50:15','2021-08-04 14:50:17',NULL);

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` float(8,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CUST_ID_KEY` (`customer_id`),
  CONSTRAINT `CUST_ID_KEY` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `orders` */

insert  into `orders`(`id`,`customer_id`,`quantity`,`total`,`status`,`created_at`,`updated_at`,`deleted_at`) values
(2,1,2,2500.00,1,'2021-08-04 14:47:53','2021-08-04 14:47:57',NULL);

/*Table structure for table `page_translations` */

DROP TABLE IF EXISTS `page_translations`;

CREATE TABLE `page_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id_key` (`page_id`),
  KEY `lang_key` (`language_id`),
  CONSTRAINT `page_id_key` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `page_translations` */

insert  into `page_translations`(`id`,`page_id`,`language_id`,`title`,`content`,`seo_keywords`,`seo_description`,`created_at`,`updated_at`,`deleted_at`) values
(1,1,2,'About page updated','<p>This is about page. updated</p>','about, about admin paneli, updated','here are some details about the page. updated','2021-07-30 05:51:22','2021-07-30 06:01:21',NULL),
(2,1,1,'Farsi Title of About updated','<p>here are some details of farsi version of about page.</p>','farsi keywords','farsi description','2021-07-30 06:09:58','2021-07-30 06:14:27',NULL),
(3,2,2,'Home','<p>home page desc</p>','home, page','home page','2021-07-30 06:17:21','2021-07-30 06:17:21',NULL),
(4,3,2,'Services','<p>here are some details&nbsp;</p>','services','services of admin panel','2021-07-30 06:23:44','2021-07-30 06:23:44',NULL),
(5,3,1,'Farsi Service',NULL,NULL,NULL,'2021-07-30 06:24:00','2021-07-30 06:24:00',NULL);

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) DEFAULT 99,
  `slug` varchar(255) DEFAULT NULL,
  `type` varchar(25) DEFAULT 'page',
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `pages` */

insert  into `pages`(`id`,`order`,`slug`,`type`,`status`,`created_at`,`updated_at`,`deleted_at`) values
(1,110,'about-1','page',1,'2021-07-30 05:51:22','2021-07-30 06:01:21',NULL),
(2,1,'home-2','page',1,'2021-07-30 06:17:21','2021-07-30 06:17:21',NULL),
(3,12,'services-3','page',1,'2021-07-30 06:23:44','2021-07-30 06:23:44',NULL);

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `role_menu` */

DROP TABLE IF EXISTS `role_menu`;

CREATE TABLE `role_menu` (
  `role_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  KEY `ROLE_ID_KEY` (`role_id`),
  KEY `MENU_ID_KEY` (`menu_id`),
  CONSTRAINT `MENU_ID_KEY` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ROLE_ID_KEY` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `role_menu` */

insert  into `role_menu`(`role_id`,`menu_id`) values
(1,2),
(2,7),
(2,9),
(1,1),
(1,3),
(1,4),
(1,5),
(1,6),
(1,7),
(1,8),
(1,9);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`id`,`title`,`created_at`,`updated_at`,`deleted_at`) values
(1,'Admin','2021-07-28 11:52:08','2021-07-28 11:52:10',NULL),
(2,'Employee','2021-07-29 12:47:07','2021-07-29 12:47:09',NULL),
(3,'TEst Role updated done','2021-07-31 08:10:19','2021-07-31 08:15:08','2021-07-31 08:15:08');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `ROLE_KEY` (`role_id`),
  CONSTRAINT `ROLE_KEY` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`role_id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values
(1,1,'Admin 1','admin@admin.com','2021-07-28 11:52:29','$2y$10$BTdNR.pWVHwIX8nAvTjh/.kTFInq9nbSf6psbfsjFo5hrmrFnPsL.',NULL,NULL,'2021-08-04 10:15:57'),
(7,2,'Test Project','mrahmati2001@gmail.com',NULL,'$2y$10$hiNwYotUnv0C9P1d3xY5iekNWERBxnQQIGiZRekiounlmtucW2FxC',NULL,'2021-07-29 08:09:00','2021-07-29 08:09:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
