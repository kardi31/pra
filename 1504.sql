-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table pracownik.advertising_advertising
DROP TABLE IF EXISTS `advertising_advertising`;
CREATE TABLE IF NOT EXISTS `advertising_advertising` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `ad_type` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `ad_link` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `date_from` datetime DEFAULT NULL,
  `is_sponsored` tinyint(1) DEFAULT '0',
  `clicks` int(11) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `size_id_idx` (`size_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertising_advertising: 0 rows
DELETE FROM `advertising_advertising`;
/*!40000 ALTER TABLE `advertising_advertising` DISABLE KEYS */;
/*!40000 ALTER TABLE `advertising_advertising` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertising_advertising_page
DROP TABLE IF EXISTS `advertising_advertising_page`;
CREATE TABLE IF NOT EXISTS `advertising_advertising_page` (
  `page_id` int(11) NOT NULL DEFAULT '0',
  `ad_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`page_id`,`ad_id`),
  KEY `advertising_advertising_page_ad_id_advertising_advertising_id` (`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertising_advertising_page: 0 rows
DELETE FROM `advertising_advertising_page`;
/*!40000 ALTER TABLE `advertising_advertising_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `advertising_advertising_page` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertising_agent
DROP TABLE IF EXISTS `advertising_agent`;
CREATE TABLE IF NOT EXISTS `advertising_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertising_agent: 0 rows
DELETE FROM `advertising_agent`;
/*!40000 ALTER TABLE `advertising_agent` DISABLE KEYS */;
/*!40000 ALTER TABLE `advertising_agent` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertising_branch
DROP TABLE IF EXISTS `advertising_branch`;
CREATE TABLE IF NOT EXISTS `advertising_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertising_branch: 0 rows
DELETE FROM `advertising_branch`;
/*!40000 ALTER TABLE `advertising_branch` DISABLE KEYS */;
/*!40000 ALTER TABLE `advertising_branch` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertising_city
DROP TABLE IF EXISTS `advertising_city`;
CREATE TABLE IF NOT EXISTS `advertising_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertising_city: 20 rows
DELETE FROM `advertising_city`;
/*!40000 ALTER TABLE `advertising_city` DISABLE KEYS */;
INSERT INTO `advertising_city` (`id`, `ad_id`, `city`, `active`, `created_at`, `updated_at`) VALUES
	(1, 141, 'Dennistoun', NULL, '2015-07-06 11:13:44', '2015-07-06 11:13:44'),
	(2, 64, 'Edinburgh', NULL, '2015-07-06 11:13:53', '2015-07-06 11:13:53'),
	(3, 135, 'London', NULL, '2015-07-06 11:13:59', '2015-07-06 11:13:59'),
	(4, 136, 'London', NULL, '2015-07-06 11:13:59', '2015-07-06 11:13:59'),
	(5, 137, 'London', NULL, '2015-07-06 11:13:59', '2015-07-06 11:13:59'),
	(6, 139, 'Tower Hamlets', NULL, '2015-07-06 11:13:59', '2015-07-06 11:13:59'),
	(7, 283, 'West Hampstead', NULL, '2015-07-06 11:14:00', '2015-07-06 11:14:00'),
	(8, 267, 'London', NULL, '2015-07-06 11:14:04', '2015-07-06 11:14:04'),
	(9, 333, 'Westminster', NULL, '2015-07-06 11:14:07', '2015-07-06 11:14:07'),
	(10, 282, 'West Hampstead', NULL, '2015-07-06 11:14:11', '2015-07-06 11:14:11'),
	(11, 285, 'Southampton', NULL, '2015-07-06 11:14:26', '2015-07-06 11:14:26'),
	(12, 290, 'Croydon', NULL, '2015-07-06 11:14:26', '2015-07-06 11:14:26'),
	(13, 338, 'Mill Hill', NULL, '2015-07-06 11:14:29', '2015-07-06 11:14:29'),
	(14, 360, 'Horsham', NULL, '2015-07-06 11:14:33', '2015-07-06 11:14:33'),
	(15, 361, 'Horsham', NULL, '2015-07-06 11:14:33', '2015-07-06 11:14:33'),
	(16, 424, 'Cricklewood', NULL, '2015-07-06 11:14:40', '2015-07-06 11:14:40'),
	(17, 423, 'St Johns Wood', NULL, '2015-07-06 11:14:40', '2015-07-06 11:14:40'),
	(18, 425, 'Primrose Hill', NULL, '2015-07-06 11:14:40', '2015-07-06 11:14:40'),
	(19, 426, 'Belsize Park', NULL, '2015-07-06 11:14:40', '2015-07-06 11:14:40'),
	(20, 765, 'Glasgow', NULL, '2015-07-06 11:15:33', '2015-07-06 11:15:33');
/*!40000 ALTER TABLE `advertising_city` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertising_page
DROP TABLE IF EXISTS `advertising_page`;
CREATE TABLE IF NOT EXISTS `advertising_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertising_page: 0 rows
DELETE FROM `advertising_page`;
/*!40000 ALTER TABLE `advertising_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `advertising_page` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertising_position
DROP TABLE IF EXISTS `advertising_position`;
CREATE TABLE IF NOT EXISTS `advertising_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertising_position: 5 rows
DELETE FROM `advertising_position`;
/*!40000 ALTER TABLE `advertising_position` DISABLE KEYS */;
INSERT INTO `advertising_position` (`id`, `position`, `value`, `created_at`, `updated_at`) VALUES
	(1, 'Footer Main', 'footer-main', '2015-07-06 11:13:35', '2015-07-06 11:13:35'),
	(2, 'Main Left', 'main-left', '2015-07-06 11:13:35', '2015-07-06 11:13:35'),
	(3, 'Header Top Right', 'header-top-right', '2015-07-06 11:13:35', '2015-07-06 11:13:35'),
	(4, 'Main Top Right', 'main-top-right', '2015-07-06 11:13:35', '2015-07-06 11:13:35'),
	(5, 'mid-review', 'mid-review', '2015-07-06 11:14:02', '2015-07-06 11:14:02');
/*!40000 ALTER TABLE `advertising_position` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertising_size
DROP TABLE IF EXISTS `advertising_size`;
CREATE TABLE IF NOT EXISTS `advertising_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertising_size: 3 rows
DELETE FROM `advertising_size`;
/*!40000 ALTER TABLE `advertising_size` DISABLE KEYS */;
INSERT INTO `advertising_size` (`id`, `size`, `value`, `created_at`, `updated_at`) VALUES
	(1, '728x90', '728,90', '2015-07-06 11:13:35', '2015-07-06 11:13:35'),
	(2, '250x250', '250,250', '2015-07-06 11:13:35', '2015-07-06 11:13:35'),
	(3, '468x60', '468,60', '2015-07-06 11:13:35', '2015-07-06 11:13:35');
/*!40000 ALTER TABLE `advertising_size` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertisment_advertisment
DROP TABLE IF EXISTS `advertisment_advertisment`;
CREATE TABLE IF NOT EXISTS `advertisment_advertisment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1',
  `publish_date` datetime DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `video_root_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `views` bigint(20) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `finish_date` datetime DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `promoted` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id_idx` (`category_id`),
  KEY `advertisment_advertisment_user_id_user_user_id` (`user_id`),
  KEY `advertisment_advertisment_photo_root_id_media_photo_id` (`photo_root_id`),
  KEY `advertisment_advertisment_metatag_id_default_metatag_id` (`metatag_id`),
  KEY `advertisment_advertisment_last_user_id_user_user_id` (`last_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertisment_advertisment: 0 rows
DELETE FROM `advertisment_advertisment`;
/*!40000 ALTER TABLE `advertisment_advertisment` DISABLE KEYS */;
/*!40000 ALTER TABLE `advertisment_advertisment` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertisment_advertisment_translation
DROP TABLE IF EXISTS `advertisment_advertisment_translation`;
CREATE TABLE IF NOT EXISTS `advertisment_advertisment_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertisment_advertisment_translation: 0 rows
DELETE FROM `advertisment_advertisment_translation`;
/*!40000 ALTER TABLE `advertisment_advertisment_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `advertisment_advertisment_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertisment_category
DROP TABLE IF EXISTS `advertisment_category`;
CREATE TABLE IF NOT EXISTS `advertisment_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`),
  KEY `group_id_idx` (`group_id`),
  KEY `advertisment_category_metatag_id_default_metatag_id` (`metatag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertisment_category: 45 rows
DELETE FROM `advertisment_category`;
/*!40000 ALTER TABLE `advertisment_category` DISABLE KEYS */;
INSERT INTO `advertisment_category` (`id`, `user_id`, `group_id`, `metatag_id`, `last_user_id`, `title`, `slug`, `content`) VALUES
	(1, NULL, 1, NULL, NULL, 'Oferty pracy', 'oferty-pracy', NULL),
	(2, NULL, 1, NULL, NULL, 'ZLecenia usług', 'zlecenia-uslug', NULL),
	(3, NULL, 1, NULL, NULL, 'Ogłoszenia pracowników', 'ogloszenia-pracownikow', NULL),
	(4, NULL, 2, NULL, NULL, 'Mieszkania i domy', 'mieszkania-i-domy', NULL),
	(5, NULL, 2, NULL, NULL, 'Pokoje', 'pokoje', NULL),
	(6, NULL, 2, NULL, NULL, 'Pozostałe', 'pozostale', NULL),
	(7, NULL, 2, NULL, NULL, 'Szukam mieszkania/domu', 'szukam-mieszkania-domu', NULL),
	(8, NULL, 3, NULL, NULL, 'Chłopak pozna dziewczynę', 'chlopak-pozna-dziewczyne', NULL),
	(9, NULL, 3, NULL, NULL, 'Dziewczyna pozna chłopaka', 'dziewczyna-pozna-chlopaka', NULL),
	(10, NULL, 3, NULL, NULL, 'Koleżanki i koledzy', 'kolezanki-i-koledzy', NULL),
	(11, NULL, 3, NULL, NULL, 'Towarzyskie 18+', 'towarzyskie-18', NULL),
	(12, NULL, 4, NULL, NULL, 'Samochody', 'samochody', NULL),
	(13, NULL, 4, NULL, NULL, 'Motocykle', 'motocykle', NULL),
	(14, NULL, 4, NULL, NULL, 'Części i akcesoria', 'czesci-i-akcesoria', NULL),
	(15, NULL, 4, NULL, NULL, 'Pozostałe', 'pozostale-1', NULL),
	(16, NULL, 5, NULL, NULL, 'RTV', 'rtv', NULL),
	(17, NULL, 5, NULL, NULL, 'AGD', 'agd', NULL),
	(18, NULL, 5, NULL, NULL, 'Meble', 'meble', NULL),
	(19, NULL, 5, NULL, NULL, 'Pozostałe', 'pozostale-2', NULL),
	(20, NULL, 6, NULL, NULL, 'Laptopy', 'laptopy', NULL),
	(21, NULL, 6, NULL, NULL, 'Telefony', 'telefony', NULL),
	(22, NULL, 6, NULL, NULL, 'Zestawy komputerowe', 'zestawy-komputerowe', NULL),
	(23, NULL, 6, NULL, NULL, 'Części komputerowe', 'czesci-komputerowe', NULL),
	(24, NULL, 6, NULL, NULL, 'Gry i konsole', 'gry-i-konsole', NULL),
	(25, NULL, 6, NULL, NULL, 'Pozostałe', 'pozostale-3', NULL),
	(26, NULL, 6, NULL, NULL, 'Sprzęt fotograficzny', 'sprzet-fotograficzny', NULL),
	(27, NULL, 7, NULL, NULL, 'Odzież', 'odziez', NULL),
	(28, NULL, 7, NULL, NULL, 'Pokój dziecięcy i zabawki', 'pokoj-dzieciecy-i-zabawki', NULL),
	(29, NULL, 7, NULL, NULL, 'Wózki i foteliki', 'wozki-i-foteliki', NULL),
	(30, NULL, 7, NULL, NULL, 'Pozostałe', 'pozostale-4', NULL),
	(31, NULL, 8, NULL, NULL, 'Biznes, firma', 'biznes-firma', NULL),
	(32, NULL, 8, NULL, NULL, 'Bilety podróżne', 'bilety-podrozne', NULL),
	(33, NULL, 8, NULL, NULL, 'Budowlane - materiały, sprzęt, odzież', 'budowlane-materialy-sprzet-odziez', NULL),
	(34, NULL, 8, NULL, NULL, 'Zwierzęta i akcesoria', 'zwierzeta-i-akcesoria', NULL),
	(35, NULL, 8, NULL, NULL, 'Filmy,muzyka,książki', 'filmy-muzyka-ksiazki', NULL),
	(36, NULL, 8, NULL, NULL, 'Odzież', 'odziez', NULL),
	(37, NULL, 8, NULL, NULL, 'Rowery,sport i turystyka', 'rowery-sport-i-turystyka', NULL),
	(38, NULL, 8, NULL, NULL, 'Pozostałe', 'pozostale-5', NULL),
	(39, NULL, 9, NULL, NULL, 'Oddam za darmo', 'oddam-za-darmo', NULL),
	(40, NULL, 10, NULL, NULL, 'Oferty kupna', 'oferty-kupna', NULL),
	(41, NULL, 11, NULL, NULL, 'Podróż do Wielkiej Brytanii', 'podroz-do-wielkiej-brytanii', NULL),
	(42, NULL, 11, NULL, NULL, 'Podróż do Polski', 'podroz-do-polski', NULL),
	(43, NULL, 11, NULL, NULL, 'Podróż po Wielkiej Brytanii', 'podroz-po-wielkiej-brytanii', NULL),
	(44, NULL, 12, NULL, NULL, 'Wydarzenia, koncerty i spotkania', 'wydarzenia-koncerty-i-spotkania', NULL),
	(45, NULL, 12, NULL, NULL, 'Pozostałe ogłoszenia', 'pozostale-ogloszenia', NULL);
/*!40000 ALTER TABLE `advertisment_category` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertisment_category_group
DROP TABLE IF EXISTS `advertisment_category_group`;
CREATE TABLE IF NOT EXISTS `advertisment_category_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`),
  KEY `advertisment_category_group_metatag_id_default_metatag_id` (`metatag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertisment_category_group: 12 rows
DELETE FROM `advertisment_category_group`;
/*!40000 ALTER TABLE `advertisment_category_group` DISABLE KEYS */;
INSERT INTO `advertisment_category_group` (`id`, `user_id`, `metatag_id`, `last_user_id`, `title`, `slug`, `content`) VALUES
	(1, NULL, NULL, NULL, 'Praca', 'praca', NULL),
	(2, NULL, NULL, NULL, 'Zakwaterowanie', 'zakwaterowanie', NULL),
	(3, NULL, NULL, NULL, 'Towarzyskie', 'towarzyskie', NULL),
	(4, NULL, NULL, NULL, 'Motoryzacja', 'motoryzacja', NULL),
	(5, NULL, NULL, NULL, 'Wyposażenie domu', 'wyposazenie-domu', NULL),
	(6, NULL, NULL, NULL, 'Komputery i elektronika', 'komputery-i-elektronika', NULL),
	(7, NULL, NULL, NULL, 'Dla dzieci', 'dla-dzieci', NULL),
	(8, NULL, NULL, NULL, 'Pozostałe na sprzedaż', 'pozostale-na-sprzedaz', NULL),
	(9, NULL, NULL, NULL, 'Oddam za darmo', 'oddam-za-darmo', NULL),
	(10, NULL, NULL, NULL, 'Kupie', 'kupie', NULL),
	(11, NULL, NULL, NULL, 'Wspólny przejazd', 'wspolny-przejazd', NULL),
	(12, NULL, NULL, NULL, 'Inne', 'inne', NULL);
/*!40000 ALTER TABLE `advertisment_category_group` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertisment_category_group_translation
DROP TABLE IF EXISTS `advertisment_category_group_translation`;
CREATE TABLE IF NOT EXISTS `advertisment_category_group_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertisment_category_group_translation: 24 rows
DELETE FROM `advertisment_category_group_translation`;
/*!40000 ALTER TABLE `advertisment_category_group_translation` DISABLE KEYS */;
INSERT INTO `advertisment_category_group_translation` (`id`, `title`, `slug`, `content`, `lang`) VALUES
	(1, 'Praca', 'praca', NULL, 'pl'),
	(2, 'Zakwaterowanie', 'zakwaterowanie', NULL, 'pl'),
	(3, 'Towarzyskie', 'towarzyskie', NULL, 'pl'),
	(4, 'Motoryzacja', 'motoryzacja', NULL, 'pl'),
	(5, 'Wyposażenie domu', 'wyposazenie-domu', NULL, 'pl'),
	(6, 'Komputery i elektronika', 'komputery-i-elektronika', NULL, 'pl'),
	(7, 'Dla dzieci', 'dla-dzieci', NULL, 'pl'),
	(8, 'Pozostałe na sprzedaż', 'pozostale-na-sprzedaz', NULL, 'pl'),
	(9, 'Oddam za darmo', 'oddam-za-darmo', NULL, 'pl'),
	(10, 'Kupie', 'kupie', NULL, 'pl'),
	(11, 'Wspólny przejazd', 'wspolny-przejazd', NULL, 'pl'),
	(12, 'Inne', 'inne', NULL, 'pl'),
	(1, 'Praca', 'praca', NULL, 'en'),
	(2, 'Zakwaterowanie', 'zakwaterowanie', NULL, 'en'),
	(3, 'Towarzyskie', 'towarzyskie', NULL, 'en'),
	(4, 'Motoryzacja', 'motoryzacja', NULL, 'en'),
	(5, 'Wyposażenie domu', 'wyposazenie-domu', NULL, 'en'),
	(6, 'Komputery i elektronika', 'komputery-i-elektronika', NULL, 'en'),
	(7, 'Dla dzieci', 'dla-dzieci', NULL, 'en'),
	(8, 'Pozostałe na sprzedaż', 'pozostale-na-sprzedaz', NULL, 'en'),
	(9, 'Oddam za darmo', 'oddam-za-darmo', NULL, 'en'),
	(10, 'Kupie', 'kupie', NULL, 'en'),
	(11, 'Wspólny przejazd', 'wspolny-przejazd', NULL, 'en'),
	(12, 'Inne', 'inne', NULL, 'en');
/*!40000 ALTER TABLE `advertisment_category_group_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.advertisment_category_translation
DROP TABLE IF EXISTS `advertisment_category_translation`;
CREATE TABLE IF NOT EXISTS `advertisment_category_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.advertisment_category_translation: 90 rows
DELETE FROM `advertisment_category_translation`;
/*!40000 ALTER TABLE `advertisment_category_translation` DISABLE KEYS */;
INSERT INTO `advertisment_category_translation` (`id`, `title`, `slug`, `content`, `lang`) VALUES
	(1, 'Oferty pracy', 'oferty-pracy', NULL, 'pl'),
	(2, 'ZLecenia usług', 'zlecenia-uslug', NULL, 'pl'),
	(3, 'Ogłoszenia pracowników', 'ogloszenia-pracownikow', NULL, 'pl'),
	(4, 'Mieszkania i domy', 'mieszkania-i-domy', NULL, 'pl'),
	(5, 'Pokoje', 'pokoje', NULL, 'pl'),
	(6, 'Pozostałe', 'pozostale', NULL, 'pl'),
	(7, 'Szukam mieszkania/domu', 'szukam-mieszkania-domu', NULL, 'pl'),
	(8, 'Chłopak pozna dziewczynę', 'chlopak-pozna-dziewczyne', NULL, 'pl'),
	(9, 'Dziewczyna pozna chłopaka', 'dziewczyna-pozna-chlopaka', NULL, 'pl'),
	(10, 'Koleżanki i koledzy', 'kolezanki-i-koledzy', NULL, 'pl'),
	(11, 'Towarzyskie 18+', 'towarzyskie-18', NULL, 'pl'),
	(12, 'Samochody', 'samochody', NULL, 'pl'),
	(13, 'Motocykle', 'motocykle', NULL, 'pl'),
	(14, 'Części i akcesoria', 'czesci-i-akcesoria', NULL, 'pl'),
	(15, 'Pozostałe', 'pozostale-1', NULL, 'pl'),
	(16, 'RTV', 'rtv', NULL, 'pl'),
	(17, 'AGD', 'agd', NULL, 'pl'),
	(18, 'Meble', 'meble', NULL, 'pl'),
	(19, 'Pozostałe', 'pozostale-2', NULL, 'pl'),
	(20, 'Laptopy', 'laptopy', NULL, 'pl'),
	(21, 'Telefony', 'telefony', NULL, 'pl'),
	(22, 'Zestawy komputerowe', 'zestawy-komputerowe', NULL, 'pl'),
	(23, 'Części komputerowe', 'czesci-komputerowe', NULL, 'pl'),
	(24, 'Gry i konsole', 'gry-i-konsole', NULL, 'pl'),
	(25, 'Pozostałe', 'pozostale-3', NULL, 'pl'),
	(26, 'Sprzęt fotograficzny', 'sprzet-fotograficzny', NULL, 'pl'),
	(27, 'Odzież', 'odziez', NULL, 'pl'),
	(28, 'Pokój dziecięcy i zabawki', 'pokoj-dzieciecy-i-zabawki', NULL, 'pl'),
	(29, 'Wózki i foteliki', 'wozki-i-foteliki', NULL, 'pl'),
	(30, 'Pozostałe', 'pozostale-4', NULL, 'pl'),
	(31, 'Biznes, firma', 'biznes-firma', NULL, 'pl'),
	(32, 'Bilety podróżne', 'bilety-podrozne', NULL, 'pl'),
	(33, 'Budowlane - materiały, sprzęt, odzież', 'budowlane-materialy-sprzet-odziez', NULL, 'pl'),
	(34, 'Zwierzęta i akcesoria', 'zwierzeta-i-akcesoria', NULL, 'pl'),
	(35, 'Filmy,muzyka,książki', 'filmy-muzyka-ksiazki', NULL, 'pl'),
	(36, 'Odzież', 'odziez', NULL, 'pl'),
	(37, 'Rowery,sport i turystyka', 'rowery-sport-i-turystyka', NULL, 'pl'),
	(38, 'Pozostałe', 'pozostale-5', NULL, 'pl'),
	(39, 'Oddam za darmo', 'oddam-za-darmo', NULL, 'pl'),
	(40, 'Oferty kupna', 'oferty-kupna', NULL, 'pl'),
	(41, 'Podróż do Wielkiej Brytanii', 'podroz-do-wielkiej-brytanii', NULL, 'pl'),
	(42, 'Podróż do Polski', 'podroz-do-polski', NULL, 'pl'),
	(43, 'Podróż po Wielkiej Brytanii', 'podroz-po-wielkiej-brytanii', NULL, 'pl'),
	(44, 'Wydarzenia, koncerty i spotkania', 'wydarzenia-koncerty-i-spotkania', NULL, 'pl'),
	(45, 'Pozostałe ogłoszenia', 'pozostale-ogloszenia', NULL, 'pl'),
	(1, 'Oferty pracy', 'oferty-pracy', NULL, 'en'),
	(2, 'ZLecenia usług', 'zlecenia-uslug', NULL, 'en'),
	(3, 'Ogłoszenia pracowników', 'ogloszenia-pracownikow', NULL, 'en'),
	(4, 'Mieszkania i domy', 'mieszkania-i-domy', NULL, 'en'),
	(5, 'Pokoje', 'pokoje', NULL, 'en'),
	(6, 'Pozostałe', 'pozostale', NULL, 'en'),
	(7, 'Szukam mieszkania/domu', 'szukam-mieszkania-domu', NULL, 'en'),
	(8, 'Chłopak pozna dziewczynę', 'chlopak-pozna-dziewczyne', NULL, 'en'),
	(9, 'Dziewczyna pozna chłopaka', 'dziewczyna-pozna-chlopaka', NULL, 'en'),
	(10, 'Koleżanki i koledzy', 'kolezanki-i-koledzy', NULL, 'en'),
	(11, 'Towarzyskie 18+', 'towarzyskie-18', NULL, 'en'),
	(12, 'Samochody', 'samochody', NULL, 'en'),
	(13, 'Motocykle', 'motocykle', NULL, 'en'),
	(14, 'Części i akcesoria', 'czesci-i-akcesoria', NULL, 'en'),
	(15, 'Pozostałe', 'pozostale-1', NULL, 'en'),
	(16, 'RTV', 'rtv', NULL, 'en'),
	(17, 'AGD', 'agd', NULL, 'en'),
	(18, 'Meble', 'meble', NULL, 'en'),
	(19, 'Pozostałe', 'pozostale-2', NULL, 'en'),
	(20, 'Laptopy', 'laptopy', NULL, 'en'),
	(21, 'Telefony', 'telefony', NULL, 'en'),
	(22, 'Zestawy komputerowe', 'zestawy-komputerowe', NULL, 'en'),
	(23, 'Części komputerowe', 'czesci-komputerowe', NULL, 'en'),
	(24, 'Gry i konsole', 'gry-i-konsole', NULL, 'en'),
	(25, 'Pozostałe', 'pozostale-3', NULL, 'en'),
	(26, 'Sprzęt fotograficzny', 'sprzet-fotograficzny', NULL, 'en'),
	(27, 'Odzież', 'odziez', NULL, 'en'),
	(28, 'Pokój dziecięcy i zabawki', 'pokoj-dzieciecy-i-zabawki', NULL, 'en'),
	(29, 'Wózki i foteliki', 'wozki-i-foteliki', NULL, 'en'),
	(30, 'Pozostałe', 'pozostale-4', NULL, 'en'),
	(31, 'Biznes, firma', 'biznes-firma', NULL, 'en'),
	(32, 'Bilety podróżne', 'bilety-podrozne', NULL, 'en'),
	(33, 'Budowlane - materiały, sprzęt, odzież', 'budowlane-materialy-sprzet-odziez', NULL, 'en'),
	(34, 'Zwierzęta i akcesoria', 'zwierzeta-i-akcesoria', NULL, 'en'),
	(35, 'Filmy,muzyka,książki', 'filmy-muzyka-ksiazki', NULL, 'en'),
	(36, 'Odzież', 'odziez', NULL, 'en'),
	(37, 'Rowery,sport i turystyka', 'rowery-sport-i-turystyka', NULL, 'en'),
	(38, 'Pozostałe', 'pozostale-5', NULL, 'en'),
	(39, 'Oddam za darmo', 'oddam-za-darmo', NULL, 'en'),
	(40, 'Oferty kupna', 'oferty-kupna', NULL, 'en'),
	(41, 'Podróż do Wielkiej Brytanii', 'podroz-do-wielkiej-brytanii', NULL, 'en'),
	(42, 'Podróż do Polski', 'podroz-do-polski', NULL, 'en'),
	(43, 'Podróż po Wielkiej Brytanii', 'podroz-po-wielkiej-brytanii', NULL, 'en'),
	(44, 'Wydarzenia, koncerty i spotkania', 'wydarzenia-koncerty-i-spotkania', NULL, 'en'),
	(45, 'Pozostałe ogłoszenia', 'pozostale-ogloszenia', NULL, 'en');
/*!40000 ALTER TABLE `advertisment_category_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_agent
DROP TABLE IF EXISTS `agent_agent`;
CREATE TABLE IF NOT EXISTS `agent_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `rating` float(5,2) DEFAULT NULL,
  `points` float(5,2) DEFAULT NULL,
  `customer_satisfaction` float(5,2) DEFAULT NULL,
  `votes` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `view` int(11) DEFAULT NULL,
  `head_office_id` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `premium_support` tinyint(1) DEFAULT '0',
  `approved` tinyint(1) DEFAULT '0',
  `logo` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_agent_logo_media_photo_filename` (`logo`),
  KEY `agent_agent_head_office_id_branch_branch_id` (`head_office_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_agent: 0 rows
DELETE FROM `agent_agent`;
/*!40000 ALTER TABLE `agent_agent` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_agent` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_agent_category
DROP TABLE IF EXISTS `agent_agent_category`;
CREATE TABLE IF NOT EXISTS `agent_agent_category` (
  `agent_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`agent_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_agent_category: 0 rows
DELETE FROM `agent_agent_category`;
/*!40000 ALTER TABLE `agent_agent_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_agent_category` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_agent_translation
DROP TABLE IF EXISTS `agent_agent_translation`;
CREATE TABLE IF NOT EXISTS `agent_agent_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(64) NOT NULL DEFAULT '',
  `description` longtext,
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_agent_translation: 0 rows
DELETE FROM `agent_agent_translation`;
/*!40000 ALTER TABLE `agent_agent_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_agent_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_award
DROP TABLE IF EXISTS `agent_award`;
CREATE TABLE IF NOT EXISTS `agent_award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `branches` int(11) DEFAULT NULL,
  `reviews` int(11) DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `rating` float(5,2) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `chain_size` varchar(255) DEFAULT NULL,
  `franchise` tinyint(1) DEFAULT '0',
  `online` tinyint(1) DEFAULT '0',
  `transparent` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_id_idx` (`agent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_award: 0 rows
DELETE FROM `agent_award`;
/*!40000 ALTER TABLE `agent_award` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_award` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_category
DROP TABLE IF EXISTS `agent_category`;
CREATE TABLE IF NOT EXISTS `agent_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(255) DEFAULT NULL,
  `target_id` varchar(128) DEFAULT NULL,
  `target_href` varchar(255) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `unique_id` varchar(128) DEFAULT NULL,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_category: 5 rows
DELETE FROM `agent_category`;
/*!40000 ALTER TABLE `agent_category` DISABLE KEYS */;
INSERT INTO `agent_category` (`id`, `route`, `target_id`, `target_href`, `metatag_id`, `unique_id`, `root_id`, `lft`, `rgt`, `level`) VALUES
	(2, NULL, NULL, NULL, NULL, NULL, 3, 6, 7, 1),
	(3, NULL, NULL, NULL, NULL, NULL, 3, 107, 118, 0),
	(4, NULL, NULL, NULL, NULL, NULL, 3, 112, 113, 1),
	(5, NULL, NULL, NULL, NULL, NULL, 3, 108, 109, 1),
	(6, NULL, NULL, NULL, NULL, NULL, 13, 1, 26, 0),
	(7, NULL, NULL, NULL, NULL, NULL, 3, 85, 106, 0),
	(8, NULL, NULL, NULL, NULL, NULL, 3, 61, 84, 0),
	(9, NULL, NULL, NULL, NULL, NULL, 3, 1, 22, 0),
	(10, NULL, NULL, NULL, NULL, NULL, 3, 54, 55, 1),
	(11, NULL, NULL, NULL, NULL, NULL, 3, 47, 60, 0),
	(12, NULL, NULL, NULL, NULL, NULL, 3, 37, 46, 0),
	(13, NULL, NULL, NULL, NULL, NULL, 3, 119, 136, 0),
	(14, NULL, NULL, NULL, NULL, NULL, 13, 6, 7, 1),
	(15, NULL, NULL, NULL, NULL, NULL, 13, 10, 11, 1),
	(16, NULL, NULL, NULL, NULL, NULL, 13, 12, 13, 1),
	(17, NULL, NULL, NULL, NULL, NULL, 13, 2, 3, 1),
	(18, NULL, NULL, NULL, NULL, NULL, 13, 16, 17, 1),
	(19, NULL, NULL, NULL, NULL, NULL, 13, 24, 25, 1),
	(20, NULL, NULL, NULL, NULL, NULL, 13, 4, 5, 1),
	(21, NULL, NULL, NULL, NULL, NULL, 13, 18, 19, 1),
	(22, NULL, NULL, NULL, NULL, NULL, 13, 20, 21, 1),
	(23, NULL, NULL, NULL, NULL, NULL, 13, 22, 23, 1),
	(24, NULL, NULL, NULL, NULL, NULL, 13, 8, 9, 1),
	(25, NULL, NULL, NULL, NULL, NULL, 13, 14, 15, 1),
	(26, NULL, NULL, NULL, NULL, NULL, 3, 86, 87, 1),
	(27, NULL, NULL, NULL, NULL, NULL, 3, 96, 97, 1),
	(28, NULL, NULL, NULL, NULL, NULL, 3, 94, 95, 1),
	(29, NULL, NULL, NULL, NULL, NULL, 3, 100, 101, 1),
	(30, NULL, NULL, NULL, NULL, NULL, 3, 102, 103, 1),
	(31, NULL, NULL, NULL, NULL, NULL, 3, 98, 99, 1),
	(32, NULL, NULL, NULL, NULL, NULL, 3, 90, 91, 1),
	(33, NULL, NULL, NULL, NULL, NULL, 3, 104, 105, 1),
	(34, NULL, NULL, NULL, NULL, NULL, 3, 92, 93, 1),
	(35, NULL, NULL, NULL, NULL, NULL, 3, 62, 63, 1),
	(36, NULL, NULL, NULL, NULL, NULL, 3, 66, 67, 1),
	(37, NULL, NULL, NULL, NULL, NULL, 3, 70, 71, 1),
	(38, NULL, NULL, NULL, NULL, NULL, 3, 72, 73, 1),
	(39, NULL, NULL, NULL, NULL, NULL, 3, 82, 83, 1),
	(40, NULL, NULL, NULL, NULL, NULL, 3, 64, 65, 1),
	(41, NULL, NULL, NULL, NULL, NULL, 3, 78, 79, 1),
	(42, NULL, NULL, NULL, NULL, NULL, 3, 76, 77, 1),
	(43, NULL, NULL, NULL, NULL, NULL, 3, 80, 81, 1),
	(44, NULL, NULL, NULL, NULL, NULL, 3, 48, 49, 1),
	(45, NULL, NULL, NULL, NULL, NULL, 3, 52, 53, 1),
	(46, NULL, NULL, NULL, NULL, NULL, 3, 50, 51, 1),
	(47, NULL, NULL, NULL, NULL, NULL, 3, 74, 75, 1),
	(48, NULL, NULL, NULL, NULL, NULL, 3, 58, 59, 1),
	(50, NULL, NULL, NULL, NULL, NULL, 3, 23, 36, 0),
	(51, NULL, NULL, NULL, NULL, NULL, 3, 24, 25, 1),
	(52, NULL, NULL, NULL, NULL, NULL, 3, 28, 29, 1),
	(53, NULL, NULL, NULL, NULL, NULL, 3, 30, 31, 1),
	(54, NULL, NULL, NULL, NULL, NULL, 3, 32, 33, 1),
	(55, NULL, NULL, NULL, NULL, NULL, 3, 34, 35, 1),
	(56, NULL, NULL, NULL, NULL, NULL, 3, 38, 39, 1),
	(57, NULL, NULL, NULL, NULL, NULL, 3, 120, 121, 1),
	(58, NULL, NULL, NULL, NULL, NULL, 3, 42, 43, 1),
	(59, NULL, NULL, NULL, NULL, NULL, 3, 8, 9, 1),
	(60, NULL, NULL, NULL, NULL, NULL, 3, 26, 27, 1),
	(61, NULL, NULL, NULL, NULL, NULL, 3, 12, 13, 1),
	(62, NULL, NULL, NULL, NULL, NULL, 3, 44, 45, 1),
	(63, NULL, NULL, NULL, NULL, NULL, 3, 126, 127, 1),
	(64, NULL, NULL, NULL, NULL, NULL, 3, 14, 15, 1),
	(65, NULL, NULL, NULL, NULL, NULL, 3, 16, 17, 1),
	(66, NULL, NULL, NULL, NULL, NULL, 3, 68, 69, 1),
	(67, NULL, NULL, NULL, NULL, NULL, 3, 18, 19, 1),
	(68, NULL, NULL, NULL, NULL, NULL, 3, 40, 41, 1),
	(69, NULL, NULL, NULL, NULL, NULL, 3, 2, 3, 1),
	(70, NULL, NULL, NULL, NULL, NULL, 3, 128, 129, 1),
	(71, NULL, NULL, NULL, NULL, NULL, 3, 20, 21, 1),
	(72, NULL, NULL, NULL, NULL, NULL, 3, 114, 115, 1),
	(73, NULL, NULL, NULL, NULL, NULL, 3, 4, 5, 1),
	(74, NULL, NULL, NULL, NULL, NULL, 3, 134, 135, 1),
	(75, NULL, NULL, NULL, NULL, NULL, 3, 122, 123, 1),
	(76, NULL, NULL, NULL, NULL, NULL, 3, 116, 117, 1),
	(77, NULL, NULL, NULL, NULL, NULL, 3, 124, 125, 1),
	(78, NULL, NULL, NULL, NULL, NULL, 3, 10, 11, 1),
	(79, NULL, NULL, NULL, NULL, NULL, 3, 110, 111, 1),
	(80, NULL, NULL, NULL, NULL, NULL, 3, 130, 131, 1),
	(81, NULL, NULL, NULL, NULL, NULL, 3, 88, 89, 1),
	(82, NULL, NULL, NULL, NULL, NULL, 3, 132, 133, 1);
/*!40000 ALTER TABLE `agent_category` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_category_translation
DROP TABLE IF EXISTS `agent_category_translation`;
CREATE TABLE IF NOT EXISTS `agent_category_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(64) NOT NULL DEFAULT '',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_category_translation: 10 rows
DELETE FROM `agent_category_translation`;
/*!40000 ALTER TABLE `agent_category_translation` DISABLE KEYS */;
INSERT INTO `agent_category_translation` (`id`, `lang`, `title`, `slug`) VALUES
	(2, 'pl', 'Architekci', 'architekci'),
	(2, 'en', 'Architects', 'architects'),
	(3, 'pl', 'Prawo i finanse', 'prawo-i-finanse'),
	(3, 'en', 'Law and finance', 'law-and-finance'),
	(4, 'pl', 'Prawnicy, porady prawne', 'prawnicy-porady-prawne'),
	(4, 'en', 'Lawyers, legal advice', 'lawyers-legal-advice'),
	(5, 'pl', 'Biuro rachunkowe', 'biuro-rachunkowe'),
	(5, 'en', 'Accountants', 'accountants'),
	(6, 'pl', 'Zdrowie i uroda', 'zdrowie-i-uroda'),
	(6, 'en', 'Health and beauty', 'health-and-beauty'),
	(7, 'pl', 'Praca i edukacja', 'praca-i-edukacja'),
	(7, 'en', 'Work and education', 'work-and-education'),
	(8, 'pl', 'Motoryzacja i transport', 'motoryzacja-i-transport'),
	(8, 'en', 'Automotive and transportation', 'automotive-and-transportation'),
	(9, 'pl', 'Budownictwo i remonty', 'budownictwo-i-remonty'),
	(9, 'en', 'Construction and repairs', 'construction-and-repairs'),
	(10, 'pl', 'Kawiarnie i restauracje', 'kawiarnie-i-restauracje'),
	(10, 'en', 'Cafes and restaurants', 'cafes-and-restaurants'),
	(11, 'pl', 'Hotele i turystyka', 'hotele-i-turystyka'),
	(11, 'en', 'Hotels and tourism', 'hotels-and-tourism'),
	(12, 'pl', 'Handel i sklepy', 'handel-i-sklepy'),
	(12, 'en', 'Commerce and shops', 'commerce-and-shops'),
	(13, 'pl', 'Usługi', 'uslugi'),
	(13, 'en', 'Services', 'services'),
	(14, 'pl', 'Fryzjerzy i salony fryzjerskie', 'fryzjerzy-i-salony-fryzjerskie'),
	(14, 'en', 'Barbers and hairdressers', 'barbers-and-hairdressers'),
	(15, 'pl', 'Lecznice weterynaryjne', 'lecznice-weterynaryjne'),
	(15, 'en', 'Veterinary clinics', 'veterinary-clinics'),
	(16, 'pl', 'Praktyki lekarskie', 'stomatolodzy-i-protetycy'),
	(16, 'en', 'Dentists and orthodontists', 'dentists-and-orthodontists'),
	(17, 'pl', 'Apteki', 'apteki'),
	(17, 'en', 'Pharmacies', 'pharmacies'),
	(18, 'pl', 'Przychodnie', 'przychodnie'),
	(18, 'en', 'Clinics', 'clinics'),
	(19, 'pl', 'Sklepy medyczne', 'sklepy-medyczne'),
	(19, 'en', 'Medical stores', 'medical-stores'),
	(20, 'pl', 'Baseny i parki wodne', 'baseny-i-parki-wodne'),
	(20, 'en', 'Swimming pools', 'swimming-pools'),
	(21, 'pl', 'Salony masażu', 'salony-masazu'),
	(21, 'en', 'Massage parlors', 'massage-parlors'),
	(22, 'pl', 'Salony SPA i odnowa biologiczna', 'salony-spa-i-odnowa-biologiczna'),
	(22, 'en', 'SPA & Wellness', 'spa-wellness'),
	(23, 'pl', 'Siłownie i fitness', 'silownie-i-fitness'),
	(23, 'en', 'Gyms and fitness', 'gyms-and-fitness'),
	(24, 'pl', 'Gabinety kosmetyczne', 'gabinety-kosmetyczne'),
	(24, 'en', 'Beauty salons', 'beauty-salons'),
	(25, 'pl', 'Prywatne praktyki lekarskie', 'prywatne-praktyki-lekarskie'),
	(25, 'en', 'Private medical practices', 'private-medical-practices'),
	(26, 'pl', 'Agencje pośrednictwa pracy', 'agencje-posrednictwa-pracy'),
	(26, 'en', 'Recruitment agencies', 'recruitment-agencies'),
	(27, 'pl', 'Przedszkola', 'przedszkola'),
	(27, 'en', 'Kindergartens', 'kindergartens'),
	(28, 'pl', 'Nauka jazdy', 'nauka-jazdy'),
	(28, 'en', 'Driving course', 'driving-course'),
	(29, 'pl', 'Szkoły ponadgimnazjalne', 'szkoly-ponadgimnazjalne'),
	(29, 'en', 'High schools', 'high-schools'),
	(30, 'pl', 'Szkoły językowe', 'szkoly-jezykowe'),
	(30, 'en', 'Language schools', 'language-schools'),
	(31, 'pl', 'Szkoły podstawowe', 'szkoly-podstawowe'),
	(31, 'en', 'Primary schools', 'primary-schools'),
	(32, 'pl', 'Gimnazja', 'gimnazja'),
	(32, 'en', 'Secondary schools', 'secondary-schools'),
	(33, 'pl', 'Uczelnie i szkoły wyższe', 'uczelnie-i-szkoly-wyzsze'),
	(33, 'en', 'Universities and colleges', 'universities-and-colleges'),
	(34, 'pl', 'Korepetycje', 'korepetycje'),
	(34, 'en', 'Private Lessons', 'private-lessons'),
	(35, 'pl', 'Części samochodowe', 'czesci-samochodowe'),
	(35, 'en', 'Car parts', 'car-parts'),
	(36, 'pl', 'Komisy samochodowe', 'komisy-samochodowe'),
	(36, 'en', 'Used cars', 'used-cars'),
	(37, 'pl', 'Mechanicy', 'mechanicy'),
	(37, 'en', 'Mechanics', 'mechanics'),
	(38, 'pl', 'Myjnie samochodowe', 'myjnie-samochodowe'),
	(38, 'en', 'Car washes', 'car-washes'),
	(39, 'pl', 'Wulkanizacja i opony', 'wulkanizacja-i-opony'),
	(39, 'en', 'Vulcanization and tyres', 'vulcanization-and-tyres'),
	(40, 'pl', 'Elektronika samochodowa', 'elektronika-samochodowa'),
	(40, 'en', 'Car Electronics', 'car-electronics'),
	(41, 'pl', 'Stacje benzynowe', 'stacje-benzynowe'),
	(41, 'en', 'Petrol stations', 'petrol-stations'),
	(42, 'pl', 'Spedycja', 'spedycja'),
	(42, 'en', 'Shipping', 'shipping'),
	(43, 'pl', 'Szyby samochodowe', 'szyby-samochodowe'),
	(43, 'en', 'Autoglass', 'autoglass'),
	(44, 'pl', 'Agroturystyka', 'agroturystyka'),
	(44, 'en', 'Agritourism', 'agritourism'),
	(45, 'pl', 'Hotele', 'hotele'),
	(45, 'en', 'Hotels', 'hotels'),
	(46, 'pl', 'Biura podróży i agencje turystyczne', 'biura-podrozy-i-agencje-turystyczne'),
	(46, 'en', 'Travel agencies', 'travel-agencies'),
	(47, 'pl', 'Przewozy pasażerskie', 'przewozy-pasazerskie'),
	(47, 'en', 'Passenger transportation', 'passenger-transportation'),
	(48, 'pl', 'Noclegi i kwatery prywatne', 'noclegi-i-kwatery-prywatne'),
	(48, 'en', 'Accommodations and private', 'accommodations-and-private'),
	(49, 'pl', 'Linie lotnicze', 'linie-lotnicze'),
	(49, 'en', ' Airlines', 'airlines'),
	(50, 'pl', 'Komputery, internet', 'komputery-internet'),
	(50, 'en', 'Computers, Internet', 'computers-internet'),
	(51, 'pl', 'Sklepy komputerowe', 'sklepy-komputerowe'),
	(51, 'en', 'Computer shops', 'computer-shops'),
	(52, 'pl', 'Naprawa komputerów', 'naprawa-komputerow'),
	(52, 'en', 'Computer repair', 'computer-repair'),
	(53, 'pl', 'Internet, sieci internetowe', 'internet-sieci-internetowe'),
	(53, 'en', 'Internet, Internet networks', 'internet-internet-networks'),
	(54, 'pl', 'Strony WWW', 'strony-www'),
	(54, 'en', 'Websites', 'websites'),
	(55, 'pl', 'Serwis komputerowy', 'serwis-komputerowy'),
	(55, 'en', 'Computer repairs', 'computer-repairs'),
	(56, 'pl', 'Artykuły biurowe', 'artykuly-biurowe'),
	(56, 'en', 'Office supplies', 'office-supplies'),
	(57, 'pl', 'Agencje ochrony', 'agencje-ochrony'),
	(57, 'en', 'Security agencies', 'security-agencies'),
	(58, 'pl', 'Salony meblowe', 'salony-meblowe'),
	(58, 'en', 'Furniture showrooms', 'furniture-showrooms'),
	(59, 'pl', 'Biura projektowe', 'biura-projektowe'),
	(59, 'en', 'Design offices', 'design-offices'),
	(60, 'pl', 'Grafika komputerowa', 'grafika-komputerowa'),
	(60, 'en', 'Computer graphics', 'computer-graphics'),
	(61, 'pl', 'Deweloperzy', 'deweloperzy'),
	(61, 'en', 'Developers', 'developers'),
	(62, 'pl', 'Sklepy ogrodnicze', 'sklepy-ogrodnicze'),
	(62, 'en', 'Garden shops', 'garden-shops'),
	(63, 'pl', 'Hydraulicy', 'hydraulicy'),
	(63, 'en', 'Plumbers', 'plumbers'),
	(64, 'pl', 'Firmy budowlane', 'firmy-budowlane'),
	(64, 'en', 'Construction companies', 'construction-companies'),
	(65, 'pl', 'Rusztowania', 'rusztowania'),
	(65, 'en', 'Scaffolding', 'scaffolding'),
	(66, 'pl', 'Kosmetyka samochodowa', 'kosmetyka-samochodowa'),
	(66, 'en', 'Car beauty', 'car-beauty'),
	(67, 'pl', 'Remonty i wykończenia', 'remonty-i-wykonczenia'),
	(67, 'en', 'Repairs and finishing', 'repairs-and-finishing'),
	(68, 'pl', 'RTV i AGD', 'rtv-i-agd'),
	(68, 'en', 'Electronics and Appliances', 'electronics-and-appliances'),
	(69, 'pl', 'Agencje nieruchomości', 'agencje-nieruchomosci'),
	(69, 'en', 'Real estate agents', 'real-estate-agents'),
	(70, 'pl', 'Renowacja mebli', 'renowacja-mebli'),
	(70, 'en', 'Furniture restorations', 'furniture-restorations'),
	(71, 'pl', 'Szklarze, montaż okien', 'szklarze-montaz-okien'),
	(71, 'en', 'Glaziers, window installation', 'glaziers-window-installation'),
	(72, 'pl', 'Rzeczoznawcy', 'rzeczoznawcy'),
	(72, 'en', 'Appraisers', 'appraisers'),
	(73, 'pl', 'Aranżacja ogrodów', 'aranzacja-ogrodow'),
	(73, 'en', 'Garden arrangements', 'garden-arrangements'),
	(74, 'pl', 'Ślusarze', 'slusarze'),
	(74, 'en', 'Locksmiths', 'locksmiths'),
	(75, 'pl', 'Elektrycy', 'elektrycy'),
	(75, 'en', 'Electricians', 'electricians'),
	(76, 'pl', 'Ubezpieczenia', 'ubezpieczenia'),
	(76, 'en', 'Insurance', 'insurance'),
	(77, 'pl', 'Gaz, instalacje gazowe', 'gaz-instalacje-gazowe'),
	(77, 'en', 'Gas, gas installations', 'gas-gas-installations'),
	(78, 'pl', 'Dachy i usługi dekarskie', 'dachy-i-uslugi-dekarskie'),
	(78, 'en', 'Roofs and roofing services', 'roofs-and-roofing-services'),
	(79, 'pl', 'Geodezja', 'geodezja'),
	(79, 'en', 'Geodesy', 'geodesy'),
	(80, 'pl', 'Malarze', 'malarze'),
	(80, 'en', 'Painters', 'painters'),
	(81, 'pl', 'Biblioteki', 'biblioteki'),
	(81, 'en', 'Libraries', 'libraries'),
	(82, 'pl', 'Sprzątanie', 'sprzatanie'),
	(82, 'en', 'Cleaning', 'cleaning');
/*!40000 ALTER TABLE `agent_category_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_contact
DROP TABLE IF EXISTS `agent_contact`;
CREATE TABLE IF NOT EXISTS `agent_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `mob` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `notes` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_id_idx` (`agent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_contact: 0 rows
DELETE FROM `agent_contact`;
/*!40000 ALTER TABLE `agent_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_contact` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_historic_ranking
DROP TABLE IF EXISTS `agent_historic_ranking`;
CREATE TABLE IF NOT EXISTS `agent_historic_ranking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `agent_id` (`agent_id`,`year`,`month`),
  KEY `agent_id_idx` (`agent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_historic_ranking: 0 rows
DELETE FROM `agent_historic_ranking`;
/*!40000 ALTER TABLE `agent_historic_ranking` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_historic_ranking` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_historic_ranking_weekly
DROP TABLE IF EXISTS `agent_historic_ranking_weekly`;
CREATE TABLE IF NOT EXISTS `agent_historic_ranking_weekly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `week` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `agent_id` (`agent_id`,`year`,`week`),
  KEY `agent_id_idx` (`agent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_historic_ranking_weekly: 0 rows
DELETE FROM `agent_historic_ranking_weekly`;
/*!40000 ALTER TABLE `agent_historic_ranking_weekly` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_historic_ranking_weekly` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_member
DROP TABLE IF EXISTS `agent_member`;
CREATE TABLE IF NOT EXISTS `agent_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `naea` tinyint(1) DEFAULT '0',
  `arla` tinyint(1) DEFAULT '0',
  `safeagent` tinyint(1) DEFAULT '0',
  `oft` tinyint(1) DEFAULT '0',
  `propombudsman` tinyint(1) DEFAULT '0',
  `franchise` tinyint(1) DEFAULT '0',
  `independant` tinyint(1) DEFAULT '0',
  `nla` tinyint(1) DEFAULT '0',
  `sal` tinyint(1) DEFAULT '0',
  `dps` tinyint(1) DEFAULT '0',
  `mydeposits` tinyint(1) DEFAULT '0',
  `sacda` tinyint(1) DEFAULT '0',
  `gpea` tinyint(1) DEFAULT '0',
  `type_let` tinyint(1) DEFAULT '0',
  `type_sales` tinyint(1) DEFAULT '0',
  `type_mort` tinyint(1) DEFAULT '0',
  `type_block` tinyint(1) DEFAULT '0',
  `type_surv` tinyint(1) DEFAULT '0',
  `type_conv` tinyint(1) DEFAULT '0',
  `independent` tinyint(1) DEFAULT '0',
  `corporate` tinyint(1) DEFAULT '0',
  `rics` tinyint(1) DEFAULT '0',
  `arma` tinyint(1) DEFAULT '0',
  `nals` tinyint(1) DEFAULT '0',
  `ukala` tinyint(1) DEFAULT '0',
  `tpos_sales` tinyint(1) DEFAULT '0',
  `tpos_lettings` tinyint(1) DEFAULT '0',
  `tds` tinyint(1) DEFAULT '0',
  `lps_scotland` tinyint(1) DEFAULT '0',
  `zoopla` tinyint(1) DEFAULT '0',
  `rightmove` tinyint(1) DEFAULT '0',
  `onthemarket` tinyint(1) DEFAULT '0',
  `move_with_us` tinyint(1) DEFAULT '0',
  `national_homes_network` tinyint(1) DEFAULT '0',
  `home_sale_network` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_id_idx` (`agent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_member: 0 rows
DELETE FROM `agent_member`;
/*!40000 ALTER TABLE `agent_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_member` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_notes
DROP TABLE IF EXISTS `agent_notes`;
CREATE TABLE IF NOT EXISTS `agent_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `note` longtext,
  `sales_guy` int(11) DEFAULT NULL,
  `callback` datetime DEFAULT NULL,
  `done` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_id_idx` (`agent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_notes: 0 rows
DELETE FROM `agent_notes`;
/*!40000 ALTER TABLE `agent_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_notes` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_postcode
DROP TABLE IF EXISTS `agent_postcode`;
CREATE TABLE IF NOT EXISTS `agent_postcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postcode` varchar(255) DEFAULT NULL,
  `radius0` longtext,
  `radius1` longtext,
  `radius5` longtext,
  `radius10` longtext,
  `radius20` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_postcode: 0 rows
DELETE FROM `agent_postcode`;
/*!40000 ALTER TABLE `agent_postcode` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_postcode` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_transparent_enquiry
DROP TABLE IF EXISTS `agent_transparent_enquiry`;
CREATE TABLE IF NOT EXISTS `agent_transparent_enquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `capacity` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `message` longtext,
  `postcode` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `search` varchar(255) DEFAULT NULL,
  `pagetype` varchar(255) DEFAULT NULL,
  `from_page` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_transparent_enquiry: 0 rows
DELETE FROM `agent_transparent_enquiry`;
/*!40000 ALTER TABLE `agent_transparent_enquiry` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_transparent_enquiry` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_update
DROP TABLE IF EXISTS `agent_update`;
CREATE TABLE IF NOT EXISTS `agent_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` longtext,
  `email` varchar(255) DEFAULT NULL,
  `agent_email` varchar(255) DEFAULT NULL,
  `branch_email` varchar(255) DEFAULT NULL,
  `office_name` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `update_id_idx` (`update_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_update: 0 rows
DELETE FROM `agent_update`;
/*!40000 ALTER TABLE `agent_update` DISABLE KEYS */;
INSERT INTO `agent_update` (`id`, `update_id`, `category_id`, `firstname`, `lastname`, `name`, `description`, `email`, `agent_email`, `branch_email`, `office_name`, `twitter`, `facebook`, `address`, `town`, `county`, `postcode`, `phone`, `created_at`, `updated_at`) VALUES
	(1, NULL, 5, 'Tomasz', 'Kardas', 'Kancelaria Podatkowa Krystyna Mirek', 'Nasza Kancelaria Podatkowa powstała pierwsza na lokalnym rynku.\r\n\r\nDzięki rzetelności i fachowości już od ponad 25 lat pomagamy naszym Klientom.\r\nProfesjonalnie zajmiemy się dla Państwa rozliczeniami, ewidencjami i deklaracjami.\r\nJesteśmy blisko i rozumiemy Państwa potrzeby.\r\nJeśli chcą Państwo uzyskać więcej informacji, zapraszamy do naszej nowej siedziby na ul. Krakowskiej 30 w Krzeszowicach.', 'kardi31@tlen.pl', NULL, 'agnieszkamirek1@gmail.com', 'Krzeszowice', NULL, NULL, 'ul. Krakowska 30', 'Krzeszowice', 'Małopolskie', '32-065', '12 258 16 30', '2016-04-15 10:12:19', '2016-04-15 10:12:19');
/*!40000 ALTER TABLE `agent_update` ENABLE KEYS */;


-- Dumping structure for table pracownik.agent_update_member
DROP TABLE IF EXISTS `agent_update_member`;
CREATE TABLE IF NOT EXISTS `agent_update_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_update_id` int(11) DEFAULT NULL,
  `naea` tinyint(1) DEFAULT '0',
  `arla` tinyint(1) DEFAULT '0',
  `safeagent` tinyint(1) DEFAULT '0',
  `oft` tinyint(1) DEFAULT '0',
  `propombudsman` tinyint(1) DEFAULT '0',
  `franchise` tinyint(1) DEFAULT '0',
  `independant` tinyint(1) DEFAULT '0',
  `nla` tinyint(1) DEFAULT '0',
  `sal` tinyint(1) DEFAULT '0',
  `dps` tinyint(1) DEFAULT '0',
  `mydeposits` tinyint(1) DEFAULT '0',
  `sacda` tinyint(1) DEFAULT '0',
  `gpea` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_update_id_idx` (`agent_update_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.agent_update_member: 0 rows
DELETE FROM `agent_update_member`;
/*!40000 ALTER TABLE `agent_update_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_update_member` ENABLE KEYS */;


-- Dumping structure for table pracownik.banner_banner
DROP TABLE IF EXISTS `banner_banner`;
CREATE TABLE IF NOT EXISTS `banner_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_editor_id` int(11) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `photo_root_id` int(11) DEFAULT NULL,
  `attachment_root_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `banner_banner_photo_root_id_media_photo_id` (`photo_root_id`),
  KEY `banner_banner_metatag_id_default_metatag_id` (`metatag_id`),
  KEY `banner_banner_last_editor_id_user_user_id` (`last_editor_id`),
  KEY `banner_banner_attachment_root_id_media_attachment_id` (`attachment_root_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.banner_banner: 34 rows
DELETE FROM `banner_banner`;
/*!40000 ALTER TABLE `banner_banner` DISABLE KEYS */;
INSERT INTO `banner_banner` (`id`, `last_editor_id`, `website`, `position`, `status`, `photo_root_id`, `attachment_root_id`, `metatag_id`, `created_at`, `updated_at`, `deleted_at`, `date_from`, `date_to`) VALUES
	(1, NULL, 'http://www.onet.pl', NULL, 0, 115, NULL, 1644, '2014-04-30 13:11:57', '2014-09-01 15:05:41', '2014-09-01 15:05:41', NULL, NULL),
	(2, NULL, 'http://www.onet.pl', 'Gora', 1, NULL, 2, 1645, '2014-09-01 13:31:32', '2014-10-14 14:33:07', '2014-10-14 14:33:07', '2014-09-01 14:58:00', '2014-09-04 00:00:00'),
	(3, NULL, 'http://www.wp.pl', 'Gora', 1, NULL, NULL, 1646, '2014-09-01 15:06:27', '2014-10-14 14:33:04', '2014-10-14 14:33:04', '2014-09-01 15:06:00', '2014-09-19 00:00:00'),
	(4, NULL, NULL, 'Glowna', 1, NULL, 3, 1647, '2014-09-01 15:10:42', '2014-10-14 14:33:12', '2014-10-14 14:33:12', '2014-09-01 15:12:00', '2014-09-25 00:00:00'),
	(5, NULL, NULL, 'Sidebar1', 1, NULL, NULL, 1648, '2014-09-01 15:13:01', '2016-01-28 15:48:02', '2016-01-28 15:48:02', '2014-09-01 00:00:00', '2015-12-20 00:00:00'),
	(6, NULL, NULL, 'Sidebar2', 1, NULL, 5, 1649, '2014-09-01 15:13:47', '2014-10-14 14:33:47', '2014-10-14 14:33:47', '2014-09-01 15:13:00', '2014-09-30 00:00:00'),
	(7, NULL, NULL, 'MainFirst', 1, NULL, 12, 1650, '2014-09-01 15:14:22', '2014-10-15 12:37:57', '2014-10-15 12:37:57', '2014-09-01 00:00:00', '2014-11-21 00:00:00'),
	(8, NULL, NULL, 'Sidebar2', 1, NULL, 7, 1651, '2014-09-01 15:14:44', '2014-10-14 14:32:58', '2014-10-14 14:32:58', '2014-09-18 00:00:00', '2014-09-26 00:00:00'),
	(9, NULL, 'http://www.onet.pl', 'UnderNews', 1, NULL, 9, 1662, '2014-10-14 14:27:13', '2014-10-15 12:36:59', '2014-10-15 12:36:59', '2014-10-14 14:26:00', '2014-10-31 00:00:00'),
	(10, NULL, NULL, 'UnderNews', 1, NULL, NULL, 1663, '2014-10-14 14:28:45', '2016-01-28 15:48:00', '2016-01-28 15:48:00', '2014-10-14 14:28:00', '2014-11-08 00:00:00'),
	(11, NULL, NULL, 'UnderNews', 1, NULL, 13, 1680, '2014-10-15 12:36:22', '2016-01-28 15:47:58', '2016-01-28 15:47:58', '2014-10-15 12:36:00', '2014-12-19 00:00:00'),
	(12, NULL, NULL, 'MainFirst', 1, NULL, 14, 1681, '2014-10-15 12:37:24', '2016-01-28 15:47:56', '2016-01-28 15:47:56', '2014-10-15 12:37:00', '2014-12-27 00:00:00'),
	(13, NULL, NULL, 'Sidebar1', 1, NULL, 15, 1689, '2015-12-24 23:41:25', '2016-01-28 15:47:54', '2016-01-28 15:47:54', '2015-12-24 23:41:00', '2017-09-23 23:41:00'),
	(14, NULL, 'http://kardimobile.pl', 'MainSecond', 1, NULL, NULL, 1690, '2016-01-06 18:06:11', '2016-01-28 15:47:51', '2016-01-28 15:47:51', '2016-01-06 00:00:00', '2016-08-26 00:00:00'),
	(15, NULL, 'http://kardimobile.pl', 'Sidebar2', 1, NULL, NULL, 1691, '2016-01-06 18:10:11', '2016-01-28 15:47:49', '2016-01-28 15:47:49', '2016-01-06 00:00:00', '2016-08-26 00:00:00'),
	(16, NULL, 'http://kardimobile.pl', 'UnderNews', 1, NULL, NULL, 1692, '2016-01-06 18:11:04', '2016-01-28 15:47:46', '2016-01-28 15:47:46', '2016-01-06 00:00:00', '2016-06-17 00:00:00'),
	(17, NULL, 'http://www.kardimobile.pl', 'MainFirst', 1, NULL, NULL, 1709, '2016-01-23 19:34:36', '2016-01-23 19:37:49', '2016-01-23 19:37:49', '2016-01-23 19:34:00', '2019-01-23 19:34:00'),
	(18, NULL, 'http://www.kardimobile.pl', 'MainFirst', 1, NULL, NULL, 1710, '2016-01-23 19:37:17', '2016-01-23 19:37:41', '2016-01-23 19:37:41', '2016-01-23 19:37:00', '2019-01-23 19:37:00'),
	(19, NULL, 'http://www.kardimobile.pl', 'Sidebar1', 1, NULL, 17, 1711, '2016-01-23 19:37:27', '2016-01-28 15:47:43', '2016-01-28 15:47:43', '2016-01-23 19:37:00', '2019-01-23 19:37:00'),
	(20, NULL, 'http://kardimobile.pl', 'UnderNews', 1, NULL, NULL, 1904, '2016-01-28 15:49:20', '2016-01-28 16:06:57', '2016-01-28 16:06:57', '2016-01-28 14:48:00', '2017-07-27 00:00:00'),
	(21, NULL, 'http://kardimobile.pl', 'UnderNews', 1, NULL, 19, 1905, '2016-01-28 16:07:35', '2016-01-28 20:34:57', NULL, '2016-01-28 15:07:00', '2017-04-06 15:07:00'),
	(22, NULL, 'http://kardimobile.pl', 'Sidebar2', 1, NULL, 20, 1906, '2016-01-28 16:13:09', '2016-03-04 10:05:51', '2016-03-04 10:05:51', '2016-01-28 15:12:00', '2017-03-24 00:00:00'),
	(23, NULL, 'http://kardimobile.pl', 'Sidebar1', 0, NULL, 21, 1907, '2016-01-28 16:13:40', '2016-02-03 14:41:11', NULL, '2016-01-28 15:13:00', '2017-03-09 00:00:00'),
	(24, NULL, NULL, 'UnderNews', 1, NULL, NULL, 1909, '2016-01-28 20:09:27', '2016-02-02 15:42:37', '2016-02-02 15:42:37', '2016-01-28 04:00:00', '2016-02-29 12:00:00'),
	(31, NULL, NULL, 'UnderNews', 1, NULL, 29, 1931, '2016-02-02 15:43:16', '2016-02-02 15:43:16', NULL, '2016-02-01 00:00:00', '2016-02-29 00:00:00'),
	(25, NULL, 'http://www.kardimobile.pl', 'UnderNews2', 1, NULL, 23, 1915, '2016-01-30 19:50:52', '2016-02-02 15:30:40', NULL, '2016-01-30 19:50:00', '2015-04-29 00:00:00'),
	(26, NULL, 'http://kardimobile.pl', 'Sidebar3', 0, NULL, 24, 1926, '2016-02-02 13:53:43', '2016-02-03 14:40:47', NULL, '2016-02-02 12:53:00', '2016-12-30 00:00:00'),
	(27, NULL, 'http://towarzyskie.info.pl/', 'UnderNews', 1, NULL, 25, 1927, '2016-02-02 14:40:09', '2016-02-02 14:41:38', NULL, '2016-02-01 00:00:00', '2021-02-27 00:00:00'),
	(28, NULL, 'http://mrbetter-cleaning.co.uk/', 'Sidebar3', 1, NULL, 26, 1928, '2016-02-02 14:51:34', '2016-02-02 14:53:22', NULL, '2016-02-01 00:00:00', '2020-02-29 00:00:00'),
	(29, NULL, NULL, 'Sidebar3', 1, NULL, 27, 1929, '2016-02-02 15:15:25', '2016-02-02 15:18:10', NULL, '2016-02-01 00:00:00', '2016-02-27 00:00:00'),
	(30, NULL, 'http://gielda-samochodowa.com.pl/', 'Sidebar1', 1, NULL, 28, 1930, '2016-02-02 15:21:51', '2016-02-02 15:21:51', NULL, '2016-02-01 00:00:00', '2016-02-29 00:00:00'),
	(32, NULL, 'http://kardimobile.pl', 'Sidebar1', 1, NULL, 1, 2, '2016-02-22 16:37:34', '2016-02-22 16:37:34', NULL, '2016-02-22 15:35:00', '2016-08-26 00:00:00'),
	(33, NULL, 'http://kardimobile.pl', 'Homepage', 1, NULL, 2, 3, '2016-02-22 16:41:18', '2016-02-22 16:41:19', NULL, '2016-02-22 15:41:00', '2016-07-29 00:00:00'),
	(34, NULL, 'http://kardimobile.pl', 'Sidebar2', 1, NULL, 3, 5, '2016-03-04 10:05:23', '2016-03-04 10:05:23', NULL, '2016-03-04 09:04:00', '2017-11-24 00:00:00');
/*!40000 ALTER TABLE `banner_banner` ENABLE KEYS */;


-- Dumping structure for table pracownik.banner_banner_translation
DROP TABLE IF EXISTS `banner_banner_translation`;
CREATE TABLE IF NOT EXISTS `banner_banner_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.banner_banner_translation: 31 rows
DELETE FROM `banner_banner_translation`;
/*!40000 ALTER TABLE `banner_banner_translation` DISABLE KEYS */;
INSERT INTO `banner_banner_translation` (`id`, `name`, `slug`, `description`, `lang`) VALUES
	(1, 'Testowy banner', 'testowy-banner', NULL, 'pl'),
	(1, NULL, NULL, NULL, 'en'),
	(2, 'Baner pierw', 'baner-pierw', NULL, 'pl'),
	(3, 'Baner gora 2', 'baner-gora-2', NULL, 'pl'),
	(4, 'Baner główny', 'baner-glowny', NULL, 'pl'),
	(5, 'Prawo top', 'prawo-top', NULL, 'pl'),
	(6, 'Sidebar dol', 'sidebar-dol', NULL, 'pl'),
	(7, 'Pod kategoria 1', 'pod-kategoria-1', NULL, 'pl'),
	(8, 'Sidebar 3', 'sidebar-3', NULL, 'pl'),
	(9, 'Banner pod newsem', 'banner-pod-newsem', NULL, 'pl'),
	(10, 'Banner pod newsem 2', 'banner-pod-newsem-2', NULL, 'pl'),
	(11, 'Pod kategoria 2', 'pod-kategoria-2', NULL, 'pl'),
	(12, 'Pod kategoria 1', 'pod-kategoria-1-1', NULL, 'pl'),
	(13, 'No banner', 'no-banner', NULL, 'pl'),
	(14, 'Lewy banner', 'lewy-banner', NULL, 'pl'),
	(15, 'Lewy banner', 'lewy-banner-1', NULL, 'pl'),
	(16, 'Test siderbar', 'test-siderbar', NULL, 'pl'),
	(17, 'Gorny', 'gorny', NULL, 'pl'),
	(18, 'Gorny2', 'gorny2', NULL, 'pl'),
	(19, 'Gorny2', 'gorny2-1', NULL, 'pl'),
	(20, 'Kardimobile 728x90', 'kardimobile-728x90', NULL, 'pl'),
	(21, 'Kardimobile 728x90', 'kardimobile-728x90-1', NULL, 'pl'),
	(22, 'Kardimobile 300x250', 'kardimobile-300x250', NULL, 'pl'),
	(23, 'Kardimobile 250x250', 'kardimobile-250x250', NULL, 'pl'),
	(24, 'Transport', 'transport', NULL, 'pl'),
	(25, 'Kardimobile 728x90 pod newsem', 'kardimobile-728x90-pod-newsem', NULL, 'pl'),
	(26, 'Kardimobile 2 250x250', 'kardimobile-2-250x250', NULL, 'pl'),
	(33, 'Advertise here', 'your-ad', NULL, 'en'),
	(32, 'Twój banner', 'twoj-banner', NULL, 'pl'),
	(33, 'Twoja reklama', 'twoja-reklama', NULL, 'pl'),
	(34, '300x250', '300x250', NULL, 'pl');
/*!40000 ALTER TABLE `banner_banner_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_area_covered
DROP TABLE IF EXISTS `branch_area_covered`;
CREATE TABLE IF NOT EXISTS `branch_area_covered` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id_idx` (`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_area_covered: 0 rows
DELETE FROM `branch_area_covered`;
/*!40000 ALTER TABLE `branch_area_covered` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_area_covered` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_award
DROP TABLE IF EXISTS `branch_award`;
CREATE TABLE IF NOT EXISTS `branch_award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `reviews` int(11) DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `rating` float(5,2) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `transparent` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id_idx` (`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_award: 0 rows
DELETE FROM `branch_award`;
/*!40000 ALTER TABLE `branch_award` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_award` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_branch
DROP TABLE IF EXISTS `branch_branch`;
CREATE TABLE IF NOT EXISTS `branch_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `office_name` varchar(255) DEFAULT NULL,
  `office_link` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `view` tinyint(1) DEFAULT '1',
  `approved` tinyint(1) DEFAULT '1',
  `rating` float(5,2) DEFAULT NULL,
  `points` float(5,2) DEFAULT NULL,
  `customer_satisfaction` float(5,2) DEFAULT NULL,
  `votes` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `premium_support` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_branch_agent_id_agent_agent_id` (`agent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_branch: 0 rows
DELETE FROM `branch_branch`;
/*!40000 ALTER TABLE `branch_branch` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_branch` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_branch_translation
DROP TABLE IF EXISTS `branch_branch_translation`;
CREATE TABLE IF NOT EXISTS `branch_branch_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `description` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_branch_translation: 0 rows
DELETE FROM `branch_branch_translation`;
/*!40000 ALTER TABLE `branch_branch_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_branch_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_complaint_procedure
DROP TABLE IF EXISTS `branch_complaint_procedure`;
CREATE TABLE IF NOT EXISTS `branch_complaint_procedure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `procedure` longtext,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id_idx` (`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_complaint_procedure: 0 rows
DELETE FROM `branch_complaint_procedure`;
/*!40000 ALTER TABLE `branch_complaint_procedure` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_complaint_procedure` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_customer
DROP TABLE IF EXISTS `branch_customer`;
CREATE TABLE IF NOT EXISTS `branch_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `staff1` int(11) DEFAULT NULL,
  `staff2` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `added` date DEFAULT NULL,
  `view` tinyint(1) DEFAULT '1',
  `spam_me` tinyint(1) DEFAULT '1',
  `last_spammed` datetime DEFAULT NULL,
  `reviewed` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id_idx` (`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_customer: 0 rows
DELETE FROM `branch_customer`;
/*!40000 ALTER TABLE `branch_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_customer` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_enquiry
DROP TABLE IF EXISTS `branch_enquiry`;
CREATE TABLE IF NOT EXISTS `branch_enquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `message` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id_idx` (`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_enquiry: 0 rows
DELETE FROM `branch_enquiry`;
/*!40000 ALTER TABLE `branch_enquiry` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_enquiry` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_fee
DROP TABLE IF EXISTS `branch_fee`;
CREATE TABLE IF NOT EXISTS `branch_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `fees` longtext,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id_idx` (`branch_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4412 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_fee: 0 rows
DELETE FROM `branch_fee`;
/*!40000 ALTER TABLE `branch_fee` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_fee` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_member
DROP TABLE IF EXISTS `branch_member`;
CREATE TABLE IF NOT EXISTS `branch_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `naea` tinyint(1) DEFAULT '0',
  `arla` tinyint(1) DEFAULT '0',
  `safeagent` tinyint(1) DEFAULT '0',
  `oft` tinyint(1) DEFAULT '0',
  `propombudsman` tinyint(1) DEFAULT '0',
  `franchise` tinyint(1) DEFAULT '0',
  `independant` tinyint(1) DEFAULT '0',
  `nla` tinyint(1) DEFAULT '0',
  `sal` tinyint(1) DEFAULT '0',
  `dps` tinyint(1) DEFAULT '0',
  `mydeposits` tinyint(1) DEFAULT '0',
  `sacda` tinyint(1) DEFAULT '0',
  `gpea` tinyint(1) DEFAULT '0',
  `type_let` tinyint(1) DEFAULT '0',
  `type_sales` tinyint(1) DEFAULT '0',
  `type_mort` tinyint(1) DEFAULT '0',
  `type_block` tinyint(1) DEFAULT '0',
  `type_surv` tinyint(1) DEFAULT '0',
  `type_conv` tinyint(1) DEFAULT '0',
  `independent` tinyint(1) DEFAULT '0',
  `corporate` tinyint(1) DEFAULT '0',
  `rics` tinyint(1) DEFAULT '0',
  `arma` tinyint(1) DEFAULT '0',
  `nals` tinyint(1) DEFAULT '0',
  `ukala` tinyint(1) DEFAULT '0',
  `tpos_sales` tinyint(1) DEFAULT '0',
  `tpos_lettings` tinyint(1) DEFAULT '0',
  `tds` tinyint(1) DEFAULT '0',
  `lps_scotland` tinyint(1) DEFAULT '0',
  `zoopla` tinyint(1) DEFAULT '0',
  `rightmove` tinyint(1) DEFAULT '0',
  `home_sale_network` tinyint(1) DEFAULT '0',
  `national_homes_network` tinyint(4) DEFAULT '0',
  `onthemarket` tinyint(1) DEFAULT '0',
  `move_with_us` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id_idx` (`branch_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20697 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_member: 0 rows
DELETE FROM `branch_member`;
/*!40000 ALTER TABLE `branch_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_member` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_opening_hours
DROP TABLE IF EXISTS `branch_opening_hours`;
CREATE TABLE IF NOT EXISTS `branch_opening_hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `day_id` int(11) DEFAULT NULL,
  `from` time DEFAULT NULL,
  `to` time DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id_idx` (`branch_id`)
) ENGINE=MyISAM AUTO_INCREMENT=744 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_opening_hours: 0 rows
DELETE FROM `branch_opening_hours`;
/*!40000 ALTER TABLE `branch_opening_hours` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_opening_hours` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_rightmove
DROP TABLE IF EXISTS `branch_rightmove`;
CREATE TABLE IF NOT EXISTS `branch_rightmove` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `rightmove_branch_id` varchar(255) DEFAULT NULL,
  `folder` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `branch_id_idx` (`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_rightmove: 0 rows
DELETE FROM `branch_rightmove`;
/*!40000 ALTER TABLE `branch_rightmove` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_rightmove` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_update
DROP TABLE IF EXISTS `branch_update`;
CREATE TABLE IF NOT EXISTS `branch_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_tel` varchar(255) DEFAULT NULL,
  `contact_job` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `about` longtext,
  `fees` longtext,
  `complaints` longtext,
  `video` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `branch_id_idx` (`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_update: 0 rows
DELETE FROM `branch_update`;
/*!40000 ALTER TABLE `branch_update` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_update` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_update_area_covered
DROP TABLE IF EXISTS `branch_update_area_covered`;
CREATE TABLE IF NOT EXISTS `branch_update_area_covered` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update_id` int(11) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `update_id_idx` (`update_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_update_area_covered: 0 rows
DELETE FROM `branch_update_area_covered`;
/*!40000 ALTER TABLE `branch_update_area_covered` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_update_area_covered` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_update_member
DROP TABLE IF EXISTS `branch_update_member`;
CREATE TABLE IF NOT EXISTS `branch_update_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update_id` int(11) DEFAULT NULL,
  `naea` tinyint(1) DEFAULT '0',
  `arla` tinyint(1) DEFAULT '0',
  `safeagent` tinyint(1) DEFAULT '0',
  `oft` tinyint(1) DEFAULT '0',
  `propombudsman` tinyint(1) DEFAULT '0',
  `franchise` tinyint(1) DEFAULT '0',
  `independant` tinyint(1) DEFAULT '0',
  `nla` tinyint(1) DEFAULT '0',
  `sal` tinyint(1) DEFAULT '0',
  `dps` tinyint(1) DEFAULT '0',
  `mydeposits` tinyint(1) DEFAULT '0',
  `sacda` tinyint(1) DEFAULT '0',
  `gpea` tinyint(1) DEFAULT '0',
  `type_let` tinyint(1) DEFAULT '0',
  `type_sales` tinyint(1) DEFAULT '0',
  `type_mort` tinyint(1) DEFAULT '0',
  `type_block` tinyint(1) DEFAULT '0',
  `type_surv` tinyint(1) DEFAULT '0',
  `type_conv` tinyint(1) DEFAULT '0',
  `independent` tinyint(1) DEFAULT '0',
  `corporate` tinyint(1) DEFAULT '0',
  `rics` tinyint(1) DEFAULT '0',
  `arma` tinyint(1) DEFAULT '0',
  `nals` tinyint(1) DEFAULT '0',
  `ukala` tinyint(1) DEFAULT '0',
  `tpos_sales` tinyint(1) DEFAULT '0',
  `tpos_lettings` tinyint(1) DEFAULT '0',
  `tds` tinyint(1) DEFAULT '0',
  `lps_scotland` tinyint(1) DEFAULT '0',
  `zoopla` tinyint(1) DEFAULT '0',
  `rightmove` tinyint(1) DEFAULT '0',
  `onthemarket` tinyint(1) DEFAULT '0',
  `move_with_us` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `update_id_idx` (`update_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_update_member: 0 rows
DELETE FROM `branch_update_member`;
/*!40000 ALTER TABLE `branch_update_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_update_member` ENABLE KEYS */;


-- Dumping structure for table pracownik.branch_update_opening_hours
DROP TABLE IF EXISTS `branch_update_opening_hours`;
CREATE TABLE IF NOT EXISTS `branch_update_opening_hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update_id` int(11) DEFAULT NULL,
  `day_id` int(11) DEFAULT NULL,
  `from` time DEFAULT NULL,
  `to` time DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `update_id_idx` (`update_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.branch_update_opening_hours: 7 rows
DELETE FROM `branch_update_opening_hours`;
/*!40000 ALTER TABLE `branch_update_opening_hours` DISABLE KEYS */;
INSERT INTO `branch_update_opening_hours` (`id`, `update_id`, `day_id`, `from`, `to`, `closed`, `created_at`, `updated_at`) VALUES
	(1, 18, 1, '08:00:00', '17:30:00', 0, '2016-04-14 18:26:59', '2016-04-14 18:26:59'),
	(2, 18, 2, '08:00:00', '17:30:00', 0, '2016-04-14 18:26:59', '2016-04-14 18:26:59'),
	(3, 18, 3, '08:00:00', '17:30:00', 0, '2016-04-14 18:26:59', '2016-04-14 18:26:59'),
	(4, 18, 4, '08:00:00', '17:30:00', 0, '2016-04-14 18:26:59', '2016-04-14 18:26:59'),
	(5, 18, 5, '08:00:00', '17:30:00', 0, '2016-04-14 18:26:59', '2016-04-14 18:26:59'),
	(6, 18, 6, NULL, NULL, 1, '2016-04-14 18:26:59', '2016-04-14 18:26:59'),
	(7, 18, 7, NULL, NULL, 1, '2016-04-14 18:26:59', '2016-04-14 18:26:59'),
	(8, 1, 1, '08:00:00', '17:00:00', 0, '2016-04-15 10:12:19', '2016-04-15 10:12:19'),
	(9, 1, 2, '08:00:00', '17:00:00', 0, '2016-04-15 10:12:19', '2016-04-15 10:12:19'),
	(10, 1, 3, '08:00:00', '17:00:00', 0, '2016-04-15 10:12:19', '2016-04-15 10:12:19'),
	(11, 1, 4, '08:00:00', '17:00:00', 0, '2016-04-15 10:12:19', '2016-04-15 10:12:19'),
	(12, 1, 5, '08:00:00', '17:00:00', 0, '2016-04-15 10:12:19', '2016-04-15 10:12:19'),
	(13, 1, 6, NULL, NULL, 1, '2016-04-15 10:12:19', '2016-04-15 10:12:19'),
	(14, 1, 7, NULL, NULL, 1, '2016-04-15 10:12:19', '2016-04-15 10:12:19');
/*!40000 ALTER TABLE `branch_update_opening_hours` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_available_route
DROP TABLE IF EXISTS `default_available_route`;
CREATE TABLE IF NOT EXISTS `default_available_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_available_route: 13 rows
DELETE FROM `default_available_route`;
/*!40000 ALTER TABLE `default_available_route` DISABLE KEYS */;
INSERT INTO `default_available_route` (`id`, `route`, `name`) VALUES
	(3, 'domain-list-gallery', 'Galeria'),
	(11, 'domain-ranking', 'Ranking'),
	(8, 'domain-news', 'Aktualności'),
	(9, 'domain-news-group', 'Grupa aktualności'),
	(12, 'domain-contact', 'Kontakt'),
	(13, 'domain-katalog-firm', 'Katalog firm'),
	(14, 'domain-advertisment', 'Ogłoszenia'),
	(1, 'domain-homepage', 'Strona główna'),
	(16, 'domain-login', 'Login'),
	(17, 'domain-search-company', 'Szukaj agenta'),
	(18, 'domain-awards', 'Nagrody'),
	(19, 'domain-rate-review', 'Dodaj opinie'),
	(20, 'domain-add-agent', 'Dodaj firme');
/*!40000 ALTER TABLE `default_available_route` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_banned
DROP TABLE IF EXISTS `default_banned`;
CREATE TABLE IF NOT EXISTS `default_banned` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `notes` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_banned: 0 rows
DELETE FROM `default_banned`;
/*!40000 ALTER TABLE `default_banned` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_banned` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_compare_fees
DROP TABLE IF EXISTS `default_compare_fees`;
CREATE TABLE IF NOT EXISTS `default_compare_fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `allow` tinyint(1) DEFAULT '0',
  `subscribe` tinyint(1) DEFAULT '0',
  `reason` longtext,
  `type` varchar(255) DEFAULT NULL,
  `houseno` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `beds` int(11) DEFAULT NULL,
  `prop_type` int(11) DEFAULT NULL,
  `est_price` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_compare_fees: 0 rows
DELETE FROM `default_compare_fees`;
/*!40000 ALTER TABLE `default_compare_fees` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_compare_fees` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_house_prices_england
DROP TABLE IF EXISTS `default_house_prices_england`;
CREATE TABLE IF NOT EXISTS `default_house_prices_england` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `saledate` datetime DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `property_type` varchar(255) DEFAULT NULL,
  `old_new` tinyint(1) DEFAULT '0',
  `duration` varchar(255) DEFAULT NULL,
  `paon` varchar(255) DEFAULT NULL,
  `saon` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `locality` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `record_status` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_house_prices_england: 0 rows
DELETE FROM `default_house_prices_england`;
/*!40000 ALTER TABLE `default_house_prices_england` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_house_prices_england` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_language
DROP TABLE IF EXISTS `default_language`;
CREATE TABLE IF NOT EXISTS `default_language` (
  `id` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `default` tinyint(1) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_language: 2 rows
DELETE FROM `default_language`;
/*!40000 ALTER TABLE `default_language` DISABLE KEYS */;
INSERT INTO `default_language` (`id`, `name`, `active`, `default`, `admin`) VALUES
	('pl', 'Polski', 1, 1, 1),
	('en', 'English', 1, 0, 0);
/*!40000 ALTER TABLE `default_language` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_lockout
DROP TABLE IF EXISTS `default_lockout`;
CREATE TABLE IF NOT EXISTS `default_lockout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_lockout: 0 rows
DELETE FROM `default_lockout`;
/*!40000 ALTER TABLE `default_lockout` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_lockout` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_message
DROP TABLE IF EXISTS `default_message`;
CREATE TABLE IF NOT EXISTS `default_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `message` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_message: 3 rows
DELETE FROM `default_message`;
/*!40000 ALTER TABLE `default_message` DISABLE KEYS */;
INSERT INTO `default_message` (`id`, `name`, `email`, `phone`, `address`, `town`, `postcode`, `message`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'John Smith', 'john@doe.pl', '5551111', 'jasminowa', 'warszawa', '00-750', 'wiadomosc', '2016-04-07 17:19:54', '2016-04-07 17:19:54', NULL),
	(2, 'John Smith', 'john@doe.pl', '5551111', 'jasminowa', 'warszawa', '00-750', 'wiadomosc', '2016-04-08 12:45:17', '2016-04-08 12:45:17', NULL),
	(3, 'John Smith', 'john@doe.pl', '5551111', 'jasminowa', 'warszawa', '00-750', 'wiadomosc', '2016-04-08 12:55:29', '2016-04-08 12:55:29', NULL);
/*!40000 ALTER TABLE `default_message` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_message_send
DROP TABLE IF EXISTS `default_message_send`;
CREATE TABLE IF NOT EXISTS `default_message_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id_idx` (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_message_send: 4 rows
DELETE FROM `default_message_send`;
/*!40000 ALTER TABLE `default_message_send` DISABLE KEYS */;
INSERT INTO `default_message_send` (`id`, `message_id`, `branch_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, NULL, 44554, '2016-04-08 12:55:32', '2016-04-08 12:55:32', NULL),
	(2, NULL, 44480, '2016-04-08 12:55:33', '2016-04-08 12:55:33', NULL),
	(3, 1, 44480, '2016-04-08 13:04:03', '2016-04-08 13:04:03', NULL),
	(4, 1, 44554, '2016-04-08 13:04:04', '2016-04-08 13:04:04', NULL);
/*!40000 ALTER TABLE `default_message_send` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_metatag
DROP TABLE IF EXISTS `default_metatag`;
CREATE TABLE IF NOT EXISTS `default_metatag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_metatag: 7 rows
DELETE FROM `default_metatag`;
/*!40000 ALTER TABLE `default_metatag` DISABLE KEYS */;
INSERT INTO `default_metatag` (`id`) VALUES
	(1),
	(2),
	(3),
	(4),
	(5),
	(6),
	(7);
/*!40000 ALTER TABLE `default_metatag` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_metatag_translation
DROP TABLE IF EXISTS `default_metatag_translation`;
CREATE TABLE IF NOT EXISTS `default_metatag_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `description` longtext,
  `keywords` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_metatag_translation: 14 rows
DELETE FROM `default_metatag_translation`;
/*!40000 ALTER TABLE `default_metatag_translation` DISABLE KEYS */;
INSERT INTO `default_metatag_translation` (`id`, `title`, `description`, `keywords`, `lang`) VALUES
	(1, 'Twój banner', '', '', 'pl'),
	(1, NULL, '', '', 'en'),
	(2, 'Twój banner', '', '', 'pl'),
	(2, NULL, '', '', 'en'),
	(3, 'Twoja reklama', '', '', 'pl'),
	(3, NULL, '', '', 'en'),
	(4, 'Caly tydzien,dzisiaj,online', 'tresc', '', 'pl'),
	(4, 'Caly tydzien,dzisiaj,online', 'tresc', '', 'en'),
	(5, '300x250', '', '', 'pl'),
	(5, NULL, '', '', 'en'),
	(6, 'Tytuł', 'Treść', 'Treść', 'pl'),
	(6, 'Tytuł', 'Treść', 'Treść', 'en'),
	(7, 'Testowy tytul', 'Ze zdjeciem', 'zdjeciem', 'pl'),
	(7, 'Testowy tytul', 'Ze zdjeciem', 'zdjeciem', 'en');
/*!40000 ALTER TABLE `default_metatag_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_postcode
DROP TABLE IF EXISTS `default_postcode`;
CREATE TABLE IF NOT EXISTS `default_postcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postcode` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `area1` longtext,
  `area5` longtext,
  `area10` longtext,
  `area20` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_postcode: 0 rows
DELETE FROM `default_postcode`;
/*!40000 ALTER TABLE `default_postcode` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_postcode` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_postcode_count
DROP TABLE IF EXISTS `default_postcode_count`;
CREATE TABLE IF NOT EXISTS `default_postcode_count` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postcode` varchar(255) DEFAULT NULL,
  `naea` int(11) DEFAULT NULL,
  `arla` int(11) DEFAULT NULL,
  `safeagent` int(11) DEFAULT NULL,
  `oft` int(11) DEFAULT NULL,
  `propombudsman` int(11) DEFAULT NULL,
  `franchise` int(11) DEFAULT NULL,
  `independant` int(11) DEFAULT NULL,
  `nla` int(11) DEFAULT NULL,
  `sal` int(11) DEFAULT NULL,
  `dps` int(11) DEFAULT NULL,
  `home_sale_network` int(11) DEFAULT NULL,
  `mydeposits` int(11) DEFAULT NULL,
  `gpea` int(11) DEFAULT NULL,
  `type_let` int(11) DEFAULT NULL,
  `type_sales` int(11) DEFAULT NULL,
  `type_mort` int(11) DEFAULT NULL,
  `type_block` int(11) DEFAULT NULL,
  `type_surv` int(11) DEFAULT NULL,
  `type_conv` int(11) DEFAULT NULL,
  `independent` int(11) DEFAULT NULL,
  `corporate` int(11) DEFAULT NULL,
  `rics` int(11) DEFAULT NULL,
  `arma` int(11) DEFAULT NULL,
  `nals` int(11) DEFAULT NULL,
  `ukala` int(11) DEFAULT NULL,
  `tpos_sales` int(11) DEFAULT NULL,
  `tpos_lettings` int(11) DEFAULT NULL,
  `tds` int(11) DEFAULT NULL,
  `lps_scotland` int(11) DEFAULT NULL,
  `zoopla` int(11) DEFAULT NULL,
  `rightmove` int(11) DEFAULT NULL,
  `onthemarket` int(11) DEFAULT NULL,
  `move_with_us` int(11) DEFAULT NULL,
  `national_homes_network` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_postcode_count: 0 rows
DELETE FROM `default_postcode_count`;
/*!40000 ALTER TABLE `default_postcode_count` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_postcode_count` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_postcode_full
DROP TABLE IF EXISTS `default_postcode_full`;
CREATE TABLE IF NOT EXISTS `default_postcode_full` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postcode` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_postcode_full: 0 rows
DELETE FROM `default_postcode_full`;
/*!40000 ALTER TABLE `default_postcode_full` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_postcode_full` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_redirect
DROP TABLE IF EXISTS `default_redirect`;
CREATE TABLE IF NOT EXISTS `default_redirect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `old` varchar(255) DEFAULT NULL,
  `new` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_redirect: 0 rows
DELETE FROM `default_redirect`;
/*!40000 ALTER TABLE `default_redirect` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_redirect` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_sale_numbers_england
DROP TABLE IF EXISTS `default_sale_numbers_england`;
CREATE TABLE IF NOT EXISTS `default_sale_numbers_england` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(255) DEFAULT NULL,
  `sales` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_sale_numbers_england: 0 rows
DELETE FROM `default_sale_numbers_england`;
/*!40000 ALTER TABLE `default_sale_numbers_england` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_sale_numbers_england` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_sale_numbers_region
DROP TABLE IF EXISTS `default_sale_numbers_region`;
CREATE TABLE IF NOT EXISTS `default_sale_numbers_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sales` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_sale_numbers_region: 0 rows
DELETE FROM `default_sale_numbers_region`;
/*!40000 ALTER TABLE `default_sale_numbers_region` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_sale_numbers_region` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_service
DROP TABLE IF EXISTS `default_service`;
CREATE TABLE IF NOT EXISTS `default_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext,
  `email` longtext,
  `phone` longtext,
  `address` longtext,
  `opening` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_service: 0 rows
DELETE FROM `default_service`;
/*!40000 ALTER TABLE `default_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_service` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_setting
DROP TABLE IF EXISTS `default_setting`;
CREATE TABLE IF NOT EXISTS `default_setting` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_setting: 0 rows
DELETE FROM `default_setting`;
/*!40000 ALTER TABLE `default_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_setting` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_staff_redirect
DROP TABLE IF EXISTS `default_staff_redirect`;
CREATE TABLE IF NOT EXISTS `default_staff_redirect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `old_link` varchar(255) DEFAULT NULL,
  `new_link` varchar(255) DEFAULT NULL,
  `old_staff_id` int(11) DEFAULT NULL,
  `new_staff_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_staff_redirect: 0 rows
DELETE FROM `default_staff_redirect`;
/*!40000 ALTER TABLE `default_staff_redirect` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_staff_redirect` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_temp_email_domains
DROP TABLE IF EXISTS `default_temp_email_domains`;
CREATE TABLE IF NOT EXISTS `default_temp_email_domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_temp_email_domains: 0 rows
DELETE FROM `default_temp_email_domains`;
/*!40000 ALTER TABLE `default_temp_email_domains` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_temp_email_domains` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_testimonial
DROP TABLE IF EXISTS `default_testimonial`;
CREATE TABLE IF NOT EXISTS `default_testimonial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `review` longtext,
  `hostname` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `view` tinyint(1) DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `recommend` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_testimonial: 0 rows
DELETE FROM `default_testimonial`;
/*!40000 ALTER TABLE `default_testimonial` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_testimonial` ENABLE KEYS */;


-- Dumping structure for table pracownik.default_testimonial_comment
DROP TABLE IF EXISTS `default_testimonial_comment`;
CREATE TABLE IF NOT EXISTS `default_testimonial_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testimonial_id` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `posted_by` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonial_id_idx` (`testimonial_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.default_testimonial_comment: 0 rows
DELETE FROM `default_testimonial_comment`;
/*!40000 ALTER TABLE `default_testimonial_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_testimonial_comment` ENABLE KEYS */;


-- Dumping structure for function pracownik.get_distance_in_miles_between_geo_locations
DROP FUNCTION IF EXISTS `get_distance_in_miles_between_geo_locations`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` FUNCTION `get_distance_in_miles_between_geo_locations`(geo1_latitude decimal(10,6), geo1_longitude decimal(10,6), geo2_latitude decimal(10,6), geo2_longitude decimal(10,6)) RETURNS decimal(10,3)
    DETERMINISTIC
BEGIN
  return ((ACOS(SIN(geo1_latitude * PI() / 180) * SIN(geo2_latitude * PI() / 180) + COS(geo1_latitude * PI() / 180) * COS(geo2_latitude * PI() / 180) * COS((geo1_longitude - geo2_longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515);
END//
DELIMITER ;


-- Dumping structure for table pracownik.media_attachment
DROP TABLE IF EXISTS `media_attachment`;
CREATE TABLE IF NOT EXISTS `media_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `offset` varchar(128) DEFAULT NULL,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.media_attachment: ~2 rows (approximately)
DELETE FROM `media_attachment`;
/*!40000 ALTER TABLE `media_attachment` DISABLE KEYS */;
INSERT INTO `media_attachment` (`id`, `filename`, `extension`, `offset`, `root_id`, `lft`, `rgt`, `level`) VALUES
	(1, 'Depositphotos_9185635_s-2015.jpg', 'jpg', NULL, NULL, NULL, NULL, NULL),
	(2, 'depositphotos_12287446-SALES-GIMMICK.jpg', 'jpg', NULL, NULL, NULL, NULL, NULL),
	(3, 'kardimobile.png', 'png', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `media_attachment` ENABLE KEYS */;


-- Dumping structure for table pracownik.media_attachment_translation
DROP TABLE IF EXISTS `media_attachment_translation`;
CREATE TABLE IF NOT EXISTS `media_attachment_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`),
  CONSTRAINT `media_attachment_translation_id_media_attachment_id` FOREIGN KEY (`id`) REFERENCES `media_attachment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `media_attachment_translation_id_media_attachment_id_1` FOREIGN KEY (`id`) REFERENCES `media_attachment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.media_attachment_translation: ~2 rows (approximately)
DELETE FROM `media_attachment_translation`;
/*!40000 ALTER TABLE `media_attachment_translation` DISABLE KEYS */;
INSERT INTO `media_attachment_translation` (`id`, `title`, `slug`, `description`, `lang`) VALUES
	(1, 'depositphotos_9185635_s-2015', 'depositphotos_9185635_s-2015', NULL, 'pl'),
	(2, 'depositphotos_12287446-sales-gimmick', 'depositphotos_12287446-sales-gimmick', NULL, 'pl'),
	(3, 'kardimobile', 'kardimobile', NULL, 'pl');
/*!40000 ALTER TABLE `media_attachment_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.media_photo
DROP TABLE IF EXISTS `media_photo`;
CREATE TABLE IF NOT EXISTS `media_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offset` varchar(128) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `crop_data` text,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=381 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.media_photo: ~119 rows (approximately)
DELETE FROM `media_photo`;
/*!40000 ALTER TABLE `media_photo` DISABLE KEYS */;
INSERT INTO `media_photo` (`id`, `offset`, `filename`, `title`, `crop_data`, `root_id`, `lft`, `rgt`, `level`) VALUES
	(229, NULL, NULL, NULL, NULL, 229, 1, 2, 0),
	(230, '1743832023', 'newbaner11.jpg', 'newbaner11.jpg', NULL, 230, 1, 6, 0),
	(231, '1743832023', 'newatl-starting-5-new-uniform.jpg', 'newatl-starting-5-new-uniform.jpg', NULL, 230, 4, 5, 1),
	(232, '1743832023', 'newp4054980.jpg', 'newP4054980.jpg', NULL, 230, 2, 3, 1),
	(233, '1743832023', 'newatl-starting-5-new-uniform-1.jpg', 'newatl-starting-5-new-uniform.jpg', NULL, 233, 1, 4, 0),
	(234, '1743832023', 'newp4054980-1.jpg', 'newP4054980.jpg', NULL, 233, 2, 3, 1),
	(235, NULL, NULL, NULL, NULL, 235, 1, 2, 0),
	(236, '1743832023', '132-1.jpg', '132', NULL, 236, 1, 2, 0),
	(242, '1743832023', '1909661_905994169491284_4406686023471386787_n-1.jpg', '1909661_905994169491284_4406686023471386787_n', NULL, 242, 1, 2, 0),
	(243, '1743832023', 'pobrane-1-.jpg', 'pobrane (1)', NULL, 243, 1, 2, 0),
	(244, '1743832023', '936616_906180509472650_6447343191482886274_n.jpg', '936616_906180509472650_6447343191482886274_n', NULL, 244, 1, 2, 0),
	(245, '1743832023', '1918403_906198119470889_7846347443539899561_n.jpg', '1918403_906198119470889_7846347443539899561_n', NULL, 245, 1, 2, 0),
	(246, '1743832023', '580365_907506669340034_3054369717521316336_n.jpg', '580365_907506669340034_3054369717521316336_n', NULL, 246, 1, 2, 0),
	(247, '1743832023', '72365_907595252664509_7453509404155949928_n.jpg', '72365_907595252664509_7453509404155949928_n', NULL, 247, 1, 2, 0),
	(248, '1743832023', '12510262_907665532657481_7591117949252143659_n.jpg', '12510262_907665532657481_7591117949252143659_n', NULL, 248, 1, 2, 0),
	(249, '1743832023', '12510341_907858129304888_2568741088989006372_n.jpg', '12510341_907858129304888_2568741088989006372_n', NULL, 249, 1, 2, 0),
	(250, '1743832023', '12540699_908077742616260_6729294708889545226_n.jpg', '12540699_908077742616260_6729294708889545226_n', NULL, 250, 1, 2, 0),
	(251, '1743832023', 'new-photocard-banner.jpg', 'new-photocard-banner', NULL, 251, 1, 2, 0),
	(252, '1743832023', '356px-david_cameron_portrait_cropped.jpg', '356px-David_Cameron_portrait_cropped', NULL, 252, 1, 2, 0),
	(253, '1743832023', '12509769_909657289124972_6825706627188993667_n.jpg', '12509769_909657289124972_6825706627188993667_n', NULL, 253, 1, 2, 0),
	(254, '1743832023', '1937428_909975275759840_5566331636975270477_n.jpg', '1937428_909975275759840_5566331636975270477_n', NULL, 254, 1, 2, 0),
	(255, '1743832023', '12418795_910011199089581_864700556240271220_o.jpg', '12418795_910011199089581_864700556240271220_o', NULL, 255, 1, 2, 0),
	(256, '1743832023', 'phone_computer_hacker_0001959659_e.jpg', 'phone_computer_hacker_0001959659_e', NULL, 256, 1, 2, 0),
	(257, '1743832023', '775118_911325165624851_3431013038021903601_o.jpg', '775118_911325165624851_3431013038021903601_o', NULL, 257, 1, 2, 0),
	(258, '1743832023', '12417722_911614875595880_3360867586570518380_n.jpg', '12417722_911614875595880_3360867586570518380_n', NULL, 258, 1, 2, 0),
	(259, '1743832023', '12510491_911645328926168_1528636605336722054_n.jpg', '12510491_911645328926168_1528636605336722054_n', NULL, 259, 1, 2, 0),
	(260, '1743832023', '12507627_912129735544394_6674752812758098499_n.jpg', '12507627_912129735544394_6674752812758098499_n', NULL, 260, 1, 2, 0),
	(261, '1743832023', '1933924_912570038833697_8075310885059568500_n.jpg', '1933924_912570038833697_8075310885059568500_n', NULL, 261, 1, 2, 0),
	(262, '1743832023', '12565363_913727362051298_3900517009535262225_n.jpg', '12565363_913727362051298_3900517009535262225_n', NULL, 262, 1, 2, 0),
	(263, '1743832023', '12509873_913740488716652_4723263280273451436_n.jpg', '12509873_913740488716652_4723263280273451436_n', NULL, 263, 1, 2, 0),
	(264, '1743832023', '12509829_914002435357124_1263308899676247911_n.jpg', '12509829_914002435357124_1263308899676247911_n', NULL, 264, 1, 2, 0),
	(265, '1743832023', '12417664_914216428669058_3472527187756368002_n.jpg', '12417664_914216428669058_3472527187756368002_n', NULL, 265, 1, 2, 0),
	(266, '1743832023', '12507205_914224565334911_3205127726965973816_n.jpg', '12507205_914224565334911_3205127726965973816_n', NULL, 266, 1, 2, 0),
	(267, '1743832023', '12540822_914998395257528_2348858741824850016_n.jpg', '12540822_914998395257528_2348858741824850016_n', NULL, 267, 1, 2, 0),
	(268, '1743832023', '1928359_915226085234759_4215277149740896089_n.jpg', '1928359_915226085234759_4215277149740896089_n', NULL, 268, 1, 2, 0),
	(269, '1743832023', '636142890.jpg', '636142890', NULL, 269, 1, 2, 0),
	(270, '1743832023', 'przemoc-domowaprzemoc-ekonomicznainen-rodzaje-przemocyniebieska-karta.jpg', 'PRZEMOC-DOMOWA.Przemoc-ekonomiczna.Inen-rodzaje-przemocy.NIEBIESKA-KARTA', NULL, 270, 1, 2, 0),
	(271, '1743832023', 'flights-airlines-in_the_air10wizzair-620x300.jpg', 'flights-airlines--in_the_air10wizzair--620x300', NULL, 271, 1, 2, 0),
	(272, '1743832023', '12573023_915229948567706_780346340702232726_n.jpg', '12573023_915229948567706_780346340702232726_n', NULL, 272, 1, 2, 0),
	(273, '1743832023', '1910067_915392451884789_498490868688667807_n.jpg', '1910067_915392451884789_498490868688667807_n', NULL, 273, 1, 2, 0),
	(274, '1743832023', '12553104_915472195210148_183334880647240676_n.jpg', '12553104_915472195210148_183334880647240676_n', NULL, 274, 1, 2, 0),
	(276, '1743832023', 'imigranci_szturm_calais_port-800x500_c.jpg', 'imigranci_szturm_calais_port-800x500_c', NULL, 276, 1, 2, 0),
	(277, '1743832023', '3081fb6b00000578-0-image-a-21_1453572690795.jpg', '3081FB6B00000578-0-image-a-21_1453572690795', NULL, 277, 1, 2, 0),
	(278, '1743832023', 'o-amazon-uk-facebook.jpg', 'o-AMAZON-UK-facebook', NULL, 278, 1, 2, 0),
	(279, '1743832023', 'new024764551.jpg', 'new024764551.jpg', NULL, 279, 1, 2, 0),
	(280, '1743832023', '981e8c2a-34ae-4a22-a3fb-f6d0575ea3ff.jpg', '981e8c2a-34ae-4a22-a3fb-f6d0575ea3ff', NULL, 280, 1, 2, 0),
	(281, '1743832023', 'mohammed-ali-abboud.jpg', 'Mohammed-Ali-Abboud', NULL, 281, 1, 2, 0),
	(282, '1743832023', '12596875_993269327378792_854718684_o.jpg', '12596875_993269327378792_854718684_o', NULL, 282, 1, 2, 0),
	(283, '1743832023', '12646957_917440065013361_5251562468242861395_n.jpg', '12646957_917440065013361_5251562468242861395_n', NULL, 283, 1, 2, 0),
	(284, '1743832023', 'se1.jpg', 'se1', NULL, 284, 1, 2, 0),
	(286, '1743832023', 'newniebo.jpg', 'newniebo.jpg', NULL, 286, 1, 12, 0),
	(287, '1743832023', 'newogloszeniatowarzyskie.gif', 'newogloszeniatowarzyskie.gif', NULL, 286, 10, 11, 1),
	(288, '1743832023', 'newman-small.png', 'newman-small.png', NULL, 286, 8, 9, 1),
	(289, '1743832023', 'newwoman.png', 'newwoman.png', NULL, 286, 6, 7, 1),
	(290, '1743832023', 'newman-163693_640.jpg', 'newman-163693_640.jpg', NULL, 286, 4, 5, 1),
	(291, '1743832023', 'new15639-illustrated-silhouette-of-a-beautiful-woman-pv.png', 'new15639-illustrated-silhouette-of-a-beautiful-woman-pv.png', NULL, 286, 2, 3, 1),
	(292, '1743832023', 'hmrc_skarbowka_urzad_0001735623_d.jpg', 'hmrc_skarbowka_urzad_0001735623_d', NULL, 292, 1, 2, 0),
	(293, '1743832023', '12647142_918431981580836_7567545276787769312_n.jpg', '12647142_918431981580836_7567545276787769312_n', NULL, 293, 1, 2, 0),
	(294, '1743832023', '12418795_910011199089581_864700556240271220_o-1.jpg', '12418795_910011199089581_864700556240271220_o', NULL, 294, 1, 2, 0),
	(295, '1743832023', '31066.jpg', '31066', NULL, 295, 1, 2, 0),
	(296, '1743832023', '00050ha7pn6tns0o-c116-f4.jpg', '00050HA7PN6TNS0O-C116-F4', NULL, 296, 1, 2, 0),
	(297, '1743832023', 'anglia-768x455.jpg', 'ANGLIA-768x455', NULL, 297, 1, 2, 0),
	(298, '1743832023', '4-powodow-przez-ktore-polacy-nie-chca-wrocic-do-polski.jpg', '4-powodów-przez-które-Polacy-nie-chcą-wrócić-do-Polski.', NULL, 298, 1, 2, 0),
	(299, '1743832023', 'newcity_glasgow_large1.jpg', 'newcity_Glasgow_large1.jpg', NULL, 299, 1, 2, 0),
	(300, '1743832023', 'new022-2015-06-20-inverness-szkocja-uk-123-.jpg', 'new022-2015 06 20 Inverness (Szkocja - UK) (123).JPG', NULL, 300, 1, 2, 0),
	(301, '1743832023', 'new022-2015-06-20-inverness-szkocja-uk-123--1.jpg', 'new022-2015 06 20 Inverness (Szkocja - UK) (123).JPG', NULL, 301, 1, 2, 0),
	(302, '1743832023', 'new022-2015-06-20-inverness-szkocja-uk-123--2.jpg', 'new022-2015 06 20 Inverness (Szkocja - UK) (123).JPG', NULL, 302, 1, 2, 0),
	(303, '1743832023', 'newz6988507q.jpg', 'newz6988507Q.jpg', NULL, 303, 1, 2, 0),
	(304, '3201728730', '8637594326_b8ee82ef2e_z.jpg', '8637594326_b8ee82ef2e_z', NULL, 304, 1, 2, 0),
	(305, '3201728730', '376808i2.jpg', '376808i2', NULL, 305, 1, 2, 0),
	(306, '3201728730', 'rodzina.jpg', 'rodzina', NULL, 306, 1, 2, 0),
	(307, '3201728730', 'targi-pracy-w-pwsz-3a-1024x678.jpg', 'Targi-pracy-w-PWSZ-3A-1024x678', NULL, 307, 1, 2, 0),
	(308, '3201728730', '1174.jpg', '1174', NULL, 308, 1, 2, 0),
	(309, '3201728730', 'aa763fba-3c9c-4733-b942-7080dc8c4ff6.jpg', 'aa763fba-3c9c-4733-b942-7080dc8c4ff6', NULL, 309, 1, 2, 0),
	(310, '3201728730', '_87998492_cigsroughrider976.jpg', '_87998492_cigsroughrider976', NULL, 310, 1, 2, 0),
	(311, '3201728730', 'new1902770_1382789081989876_1676907398_n.jpg', 'new1902770_1382789081989876_1676907398_n.jpg', NULL, 311, 1, 2, 0),
	(312, '3201728730', 'new1.jpg', 'new1.jpg', NULL, 312, 1, 2, 0),
	(313, '3201728730', 'newelectrical-work.jpg', 'newelectrical work.jpg', NULL, 313, 1, 2, 0),
	(314, '3201728730', 'new148888-18.jpg', 'new148888-18.jpg', NULL, 314, 1, 2, 0),
	(315, NULL, NULL, NULL, NULL, 315, 1, 10, 0),
	(316, '3201728730', 'new-_80-4-.jpg', 'new$_80 (4).JPG', NULL, 315, 8, 9, 1),
	(317, '3201728730', 'new-_80-5-.jpg', 'new$_80 (5).JPG', NULL, 315, 6, 7, 1),
	(318, '3201728730', 'new-_80-3-.jpg', 'new$_80 (3).JPG', NULL, 315, 4, 5, 1),
	(319, '3201728730', 'new-_80-1-.jpg', 'new$_80 (1).JPG', NULL, 315, 2, 3, 1),
	(320, NULL, NULL, NULL, NULL, 320, 1, 4, 0),
	(321, '3201728730', 'newbeznazwy_2.png', 'newbeznazwy_2.png', NULL, 320, 2, 3, 1),
	(322, NULL, NULL, NULL, NULL, 322, 1, 8, 0),
	(323, '3201728730', 'new11930571_922331551139237_1769052098_o.jpg', 'new11930571_922331551139237_1769052098_o.jpg', NULL, 322, 6, 7, 1),
	(324, '3201728730', 'newphantom2vision-box.jpg', 'newPhantom2Vision-box.jpg', NULL, 322, 4, 5, 1),
	(325, '3201728730', 'newphantom2-vision-line.png', 'newphantom2-vision-line.png', NULL, 322, 2, 3, 1),
	(326, NULL, NULL, NULL, NULL, 326, 1, 8, 0),
	(327, '3201728730', 'new20140225_125002.jpg', 'new20140225_125002.jpg', NULL, 326, 6, 7, 1),
	(328, '3201728730', 'newskoda-006-1-.jpg', 'newSkoda 006 (1).JPG', NULL, 326, 4, 5, 1),
	(329, '3201728730', 'newbeznazwy_4.png', 'newbeznazwy_4.png', NULL, 326, 2, 3, 1),
	(330, NULL, NULL, NULL, NULL, 330, 1, 8, 0),
	(331, '3201728730', 'new20130930_181144.jpg', 'new20130930_181144.jpg', NULL, 330, 6, 7, 1),
	(332, '3201728730', 'new20130930_181059.jpg', 'new20130930_181059.jpg', NULL, 330, 4, 5, 1),
	(333, '3201728730', 'new20130930_174154.jpg', 'new20130930_174154.jpg', NULL, 330, 2, 3, 1),
	(334, NULL, NULL, NULL, NULL, 334, 1, 4, 0),
	(335, '3201728730', 'new20140319_124153_rotate_5933.jpg', 'new20140319_124153_rotate_5933.jpg', NULL, 334, 2, 3, 1),
	(336, NULL, NULL, NULL, NULL, 336, 1, 2, 0),
	(337, '3201728730', '060505c9-d0a2-4f48-bfc8-6d00095c35c2.jpg', '060505c9-d0a2-4f48-bfc8-6d00095c35c2', NULL, 337, 1, 2, 0),
	(338, '3201728730', '8d8ad10b-6e4d-404e-a1e2-a727a2aa047b.jpg', '8d8ad10b-6e4d-404e-a1e2-a727a2aa047b', NULL, 338, 1, 2, 0),
	(339, '3201728730', '12071603_973366822727350_1878913505_n.jpg', '12071603_973366822727350_1878913505_n', NULL, 339, 1, 2, 0),
	(340, NULL, NULL, NULL, NULL, 340, 1, 2, 0),
	(341, NULL, NULL, NULL, NULL, 341, 1, 2, 0),
	(342, NULL, NULL, NULL, NULL, 342, 1, 6, 0),
	(343, '3201728730', 'new11647341_846802398727630_877905637_n.jpg', 'new11647341_846802398727630_877905637_n.jpg', NULL, 342, 4, 5, 1),
	(344, '3201728730', 'new11653413_846807158727154_326452240_n.jpg', 'new11653413_846807158727154_326452240_n.jpg', NULL, 342, 2, 3, 1),
	(345, '3201728730', 'newglasgow-vs-edinburgh.jpg', 'newGlasgow-vs-Edinburgh.jpg', NULL, 345, 1, 2, 0),
	(346, NULL, NULL, NULL, NULL, 346, 1, 4, 0),
	(347, '3201728730', 'newimage.png', 'newimage.png', NULL, 346, 2, 3, 1),
	(348, '3201728730', 'newf1-garage.jpg', 'newF1-garage.jpg', NULL, 348, 1, 2, 0),
	(349, '3201728730', '2015-02-03-1659.jpg', '2015-02-03-1659', NULL, 349, 1, 2, 0),
	(350, '3201728730', 'new12071603_973366822727350_1878913505_n.jpg', 'new12071603_973366822727350_1878913505_n.jpg', NULL, 350, 1, 2, 0),
	(351, '3201728730', 'new12071603_973366822727350_1878913505_n-1.jpg', 'new12071603_973366822727350_1878913505_n.jpg', NULL, 351, 1, 2, 0),
	(353, '3201728730', 'new12071603_973366822727350_1878913505_n-2.jpg', 'new12071603_973366822727350_1878913505_n.jpg', NULL, 353, 1, 2, 0),
	(356, '3201728730', 'new2015-02-03-1659-2.jpg', 'new2015-02-03-1659.jpg', NULL, 356, 1, 2, 0),
	(357, '3201728730', 'new12071603_973366822727350_1878913505_n-4.jpg', 'new12071603_973366822727350_1878913505_n.jpg', NULL, 357, 1, 2, 0),
	(361, 'staff', 'matthew-hawkins.jpeg', 'Matthew Hawkins', NULL, 361, 1, 2, 0),
	(362, 'staff', 'matthew-hawkins.jpeg', 'Matthew Hawkins', NULL, 362, 1, 2, 0),
	(363, 'staff', 'matthew-hawkins.jpeg', 'Matthew Hawkins', NULL, 363, 1, 2, 0),
	(364, 'staff', 'matthew-hawkins.jpeg', 'Matthew Hawkins', NULL, 364, 1, 2, 0),
	(365, 'staff', 'testowyzezdjeciem-testowyzezdjeciem.jpeg', 'testowyzezdjeciem testowyzezdjeciem', NULL, 365, 1, 2, 0),
	(366, 'staff', 'matthew-hawkins.jpeg', 'Matthew Hawkins', NULL, 366, 1, 2, 0),
	(370, 'staff', 'matthew-hawkins.jpeg', 'Matthew Hawkins', NULL, 370, 1, 2, 0),
	(371, 'staff', 'christina-stracey.jpeg', 'Christina Stracey', NULL, 371, 1, 2, 0),
	(372, 'staff', 'blablab-sdacz.png', 'blablab sdacz', NULL, 372, 1, 2, 0),
	(373, 'staff', 'christina-stracey.jpeg', 'Christina Stracey', NULL, 373, 1, 2, 0),
	(374, 'staff', 'testowyzezdjeciem-testowyzezdjeciem.jpeg', 'testowyzezdjeciem testowyzezdjeciem', NULL, 374, 1, 2, 0),
	(375, NULL, NULL, NULL, NULL, 375, 1, 2, 0),
	(376, NULL, NULL, NULL, NULL, 376, 1, 2, 0),
	(377, NULL, NULL, NULL, NULL, 377, 1, 2, 0),
	(378, NULL, NULL, NULL, NULL, 378, 1, 2, 0),
	(379, NULL, NULL, NULL, NULL, 379, 1, 2, 0),
	(380, NULL, NULL, NULL, NULL, 380, 1, 2, 0);
/*!40000 ALTER TABLE `media_photo` ENABLE KEYS */;


-- Dumping structure for table pracownik.media_video
DROP TABLE IF EXISTS `media_video`;
CREATE TABLE IF NOT EXISTS `media_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offset` varchar(128) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.media_video: ~0 rows (approximately)
DELETE FROM `media_video`;
/*!40000 ALTER TABLE `media_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_video` ENABLE KEYS */;


-- Dumping structure for table pracownik.media_video_url
DROP TABLE IF EXISTS `media_video_url`;
CREATE TABLE IF NOT EXISTS `media_video_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.media_video_url: ~0 rows (approximately)
DELETE FROM `media_video_url`;
/*!40000 ALTER TABLE `media_video_url` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_video_url` ENABLE KEYS */;


-- Dumping structure for table pracownik.media_video_url_translation
DROP TABLE IF EXISTS `media_video_url_translation`;
CREATE TABLE IF NOT EXISTS `media_video_url_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`),
  CONSTRAINT `media_video_url_translation_id_media_video_url_id` FOREIGN KEY (`id`) REFERENCES `media_video_url` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `media_video_url_translation_id_media_video_url_id_1` FOREIGN KEY (`id`) REFERENCES `media_video_url` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.media_video_url_translation: ~0 rows (approximately)
DELETE FROM `media_video_url_translation`;
/*!40000 ALTER TABLE `media_video_url_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_video_url_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.menu_menu
DROP TABLE IF EXISTS `menu_menu`;
CREATE TABLE IF NOT EXISTS `menu_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `root_id` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.menu_menu: 2 rows
DELETE FROM `menu_menu`;
/*!40000 ALTER TABLE `menu_menu` DISABLE KEYS */;
INSERT INTO `menu_menu` (`id`, `name`, `root_id`, `location`) VALUES
	(1, 'Menu', 45, NULL),
	(2, 'Podmenu', 76, NULL);
/*!40000 ALTER TABLE `menu_menu` ENABLE KEYS */;


-- Dumping structure for table pracownik.menu_menu_item
DROP TABLE IF EXISTS `menu_menu_item`;
CREATE TABLE IF NOT EXISTS `menu_menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target_type` varchar(128) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `target_id` varchar(128) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `custom_url` varchar(255) DEFAULT NULL,
  `unique_id` varchar(128) DEFAULT NULL,
  `css_class` varchar(128) DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id_idx` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.menu_menu_item: 17 rows
DELETE FROM `menu_menu_item`;
/*!40000 ALTER TABLE `menu_menu_item` DISABLE KEYS */;
INSERT INTO `menu_menu_item` (`id`, `target_type`, `route`, `target_id`, `menu_id`, `custom_url`, `unique_id`, `css_class`, `photo_root_id`, `root_id`, `lft`, `rgt`, `level`) VALUES
	(45, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 45, 1, 42, 0),
	(89, NULL, 'domain-news-group', NULL, 2, NULL, NULL, NULL, NULL, 76, 14, 15, 1),
	(87, NULL, 'domain-news-student', NULL, 2, NULL, NULL, NULL, NULL, 76, 12, 13, 1),
	(84, NULL, 'domain-advertisment', NULL, 1, NULL, NULL, NULL, NULL, 45, 28, 29, 1),
	(88, NULL, 'domain-list-gallery', NULL, 2, NULL, NULL, NULL, NULL, 76, 16, 17, 1),
	(85, NULL, 'domain-news-group', NULL, 2, NULL, NULL, NULL, NULL, 76, 8, 9, 1),
	(86, NULL, 'domain-news-group', NULL, 2, NULL, NULL, NULL, NULL, 76, 10, 11, 1),
	(76, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 76, 1, 18, 0),
	(80, NULL, 'domain-news', NULL, 1, NULL, NULL, NULL, NULL, 45, 30, 31, 1),
	(90, NULL, 'domain-contact', NULL, 1, NULL, NULL, NULL, NULL, 45, 40, 41, 1),
	(99, NULL, 'domain-search-company', NULL, 1, NULL, NULL, NULL, NULL, 45, 22, 23, 1),
	(98, NULL, 'domain-ranking', NULL, 1, NULL, NULL, NULL, NULL, 45, 26, 27, 1),
	(100, NULL, 'domain-awards', NULL, 1, NULL, NULL, NULL, NULL, 45, 35, 36, 2),
	(101, NULL, 'domain-login', NULL, 1, NULL, NULL, NULL, NULL, 45, 37, 38, 2),
	(102, NULL, 'domain-rate-review', NULL, 1, NULL, NULL, NULL, NULL, 45, 24, 25, 1),
	(103, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 45, 32, 39, 1),
	(104, NULL, 'domain-add-agent', NULL, 1, NULL, NULL, NULL, NULL, 45, 33, 34, 2);
/*!40000 ALTER TABLE `menu_menu_item` ENABLE KEYS */;


-- Dumping structure for table pracownik.menu_menu_item_translation
DROP TABLE IF EXISTS `menu_menu_item_translation`;
CREATE TABLE IF NOT EXISTS `menu_menu_item_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `target_href` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_attr` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.menu_menu_item_translation: 20 rows
DELETE FROM `menu_menu_item_translation`;
/*!40000 ALTER TABLE `menu_menu_item_translation` DISABLE KEYS */;
INSERT INTO `menu_menu_item_translation` (`id`, `target_href`, `title`, `title_attr`, `slug`, `lang`) VALUES
	(90, NULL, 'Contact', NULL, 'contact', 'en'),
	(84, NULL, 'Ogłoszenia', '', 'ogloszenia', 'pl'),
	(80, NULL, 'Aktualności', '', 'aktualnosci', 'pl'),
	(90, NULL, 'Kontakt', NULL, 'kontakt', 'pl'),
	(99, NULL, 'Szukaj fachowca', '', 'szukaj-fachowca', 'pl'),
	(84, NULL, 'Advertisments', '', 'advertisments', 'en'),
	(80, NULL, 'News', '', 'news', 'en'),
	(98, NULL, 'Ranking', '', 'ranking', 'pl'),
	(98, NULL, 'Ranking', '', 'ranking', 'en'),
	(99, NULL, 'Find company', '', 'find-company', 'en'),
	(100, NULL, 'Nagrody', '', 'nagrody', 'pl'),
	(100, NULL, 'Awards', '', 'awards', 'en'),
	(101, NULL, 'Logowanie', '', 'logowanie', 'pl'),
	(101, NULL, 'Login', '', 'login', 'en'),
	(102, NULL, 'Dodaj opinie', '', 'dodaj-opinie', 'pl'),
	(102, NULL, 'Add review', '', 'add-review', 'en'),
	(103, NULL, 'Dla firm', NULL, 'dla-firm', 'pl'),
	(103, NULL, 'For companies', NULL, 'for-companies', 'en'),
	(104, NULL, 'Dodaj firmę', '', 'dodaj-firme', 'pl'),
	(104, NULL, 'Add company', '', 'add-company', 'en');
/*!40000 ALTER TABLE `menu_menu_item_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.newsletter_group
DROP TABLE IF EXISTS `newsletter_group`;
CREATE TABLE IF NOT EXISTS `newsletter_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.newsletter_group: 0 rows
DELETE FROM `newsletter_group`;
/*!40000 ALTER TABLE `newsletter_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_group` ENABLE KEYS */;


-- Dumping structure for table pracownik.newsletter_group_subscriber
DROP TABLE IF EXISTS `newsletter_group_subscriber`;
CREATE TABLE IF NOT EXISTS `newsletter_group_subscriber` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `subscriber_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id_idx` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.newsletter_group_subscriber: 0 rows
DELETE FROM `newsletter_group_subscriber`;
/*!40000 ALTER TABLE `newsletter_group_subscriber` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_group_subscriber` ENABLE KEYS */;


-- Dumping structure for table pracownik.newsletter_message
DROP TABLE IF EXISTS `newsletter_message`;
CREATE TABLE IF NOT EXISTS `newsletter_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(128) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  `date_to_send` datetime DEFAULT NULL,
  `all_subscribers` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.newsletter_message: 0 rows
DELETE FROM `newsletter_message`;
/*!40000 ALTER TABLE `newsletter_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_message` ENABLE KEYS */;


-- Dumping structure for table pracownik.newsletter_message_category
DROP TABLE IF EXISTS `newsletter_message_category`;
CREATE TABLE IF NOT EXISTS `newsletter_message_category` (
  `message_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.newsletter_message_category: 0 rows
DELETE FROM `newsletter_message_category`;
/*!40000 ALTER TABLE `newsletter_message_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_message_category` ENABLE KEYS */;


-- Dumping structure for table pracownik.newsletter_sent
DROP TABLE IF EXISTS `newsletter_sent`;
CREATE TABLE IF NOT EXISTS `newsletter_sent` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) DEFAULT NULL,
  `subscriber_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `send_at` datetime DEFAULT NULL,
  `sent` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id_idx` (`message_id`),
  KEY `subscriber_id_idx` (`subscriber_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.newsletter_sent: 0 rows
DELETE FROM `newsletter_sent`;
/*!40000 ALTER TABLE `newsletter_sent` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_sent` ENABLE KEYS */;


-- Dumping structure for table pracownik.newsletter_sent_messages
DROP TABLE IF EXISTS `newsletter_sent_messages`;
CREATE TABLE IF NOT EXISTS `newsletter_sent_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) DEFAULT NULL,
  `subscriber_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `sent` tinyint(1) DEFAULT '0',
  `error` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id_idx` (`message_id`),
  KEY `subscriber_id_idx` (`subscriber_id`),
  KEY `group_id_idx` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.newsletter_sent_messages: 0 rows
DELETE FROM `newsletter_sent_messages`;
/*!40000 ALTER TABLE `newsletter_sent_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_sent_messages` ENABLE KEYS */;


-- Dumping structure for table pracownik.newsletter_subscriber
DROP TABLE IF EXISTS `newsletter_subscriber`;
CREATE TABLE IF NOT EXISTS `newsletter_subscriber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `lang` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.newsletter_subscriber: 0 rows
DELETE FROM `newsletter_subscriber`;
/*!40000 ALTER TABLE `newsletter_subscriber` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscriber` ENABLE KEYS */;


-- Dumping structure for table pracownik.newsletter_subscriber_category
DROP TABLE IF EXISTS `newsletter_subscriber_category`;
CREATE TABLE IF NOT EXISTS `newsletter_subscriber_category` (
  `subscriber_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`subscriber_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.newsletter_subscriber_category: 0 rows
DELETE FROM `newsletter_subscriber_category`;
/*!40000 ALTER TABLE `newsletter_subscriber_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscriber_category` ENABLE KEYS */;


-- Dumping structure for table pracownik.newsletter_subscriber_group
DROP TABLE IF EXISTS `newsletter_subscriber_group`;
CREATE TABLE IF NOT EXISTS `newsletter_subscriber_group` (
  `subscriber_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`subscriber_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.newsletter_subscriber_group: 0 rows
DELETE FROM `newsletter_subscriber_group`;
/*!40000 ALTER TABLE `newsletter_subscriber_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscriber_group` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_article
DROP TABLE IF EXISTS `news_article`;
CREATE TABLE IF NOT EXISTS `news_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `last_editor_id` int(11) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1',
  `publish_date` datetime DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id_idx` (`category_id`),
  KEY `author_id_idx` (`author_id`),
  KEY `last_editor_id_idx` (`last_editor_id`),
  KEY `photo_root_id_idx` (`photo_root_id`),
  KEY `metatag_id_idx` (`metatag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_article: 0 rows
DELETE FROM `news_article`;
/*!40000 ALTER TABLE `news_article` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_article` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_article_translation
DROP TABLE IF EXISTS `news_article_translation`;
CREATE TABLE IF NOT EXISTS `news_article_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_article_translation: 0 rows
DELETE FROM `news_article_translation`;
/*!40000 ALTER TABLE `news_article_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_article_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_category
DROP TABLE IF EXISTS `news_category`;
CREATE TABLE IF NOT EXISTS `news_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`),
  KEY `metatag_id_idx` (`metatag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_category: 0 rows
DELETE FROM `news_category`;
/*!40000 ALTER TABLE `news_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_category` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_category_translation
DROP TABLE IF EXISTS `news_category_translation`;
CREATE TABLE IF NOT EXISTS `news_category_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(64) NOT NULL DEFAULT '',
  `slug` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_category_translation: 0 rows
DELETE FROM `news_category_translation`;
/*!40000 ALTER TABLE `news_category_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_category_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_comment
DROP TABLE IF EXISTS `news_comment`;
CREATE TABLE IF NOT EXISTS `news_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content` longtext,
  `user_ip` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id_idx` (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_comment: 0 rows
DELETE FROM `news_comment`;
/*!40000 ALTER TABLE `news_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_comment` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_group
DROP TABLE IF EXISTS `news_group`;
CREATE TABLE IF NOT EXISTS `news_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `metatag_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `metatag_id_idx` (`metatag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_group: 0 rows
DELETE FROM `news_group`;
/*!40000 ALTER TABLE `news_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_group` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_guide
DROP TABLE IF EXISTS `news_guide`;
CREATE TABLE IF NOT EXISTS `news_guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1',
  `publish_date` datetime DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `views` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id_idx` (`category_id`),
  KEY `photo_root_id_idx` (`photo_root_id`),
  KEY `metatag_id_idx` (`metatag_id`),
  KEY `user_id_idx` (`user_id`),
  KEY `last_user_id_idx` (`last_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_guide: 0 rows
DELETE FROM `news_guide`;
/*!40000 ALTER TABLE `news_guide` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_guide` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_guide_translation
DROP TABLE IF EXISTS `news_guide_translation`;
CREATE TABLE IF NOT EXISTS `news_guide_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_guide_translation: 0 rows
DELETE FROM `news_guide_translation`;
/*!40000 ALTER TABLE `news_guide_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_guide_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_news
DROP TABLE IF EXISTS `news_news`;
CREATE TABLE IF NOT EXISTS `news_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1',
  `gallery` tinyint(1) DEFAULT '0',
  `breaking_news` tinyint(1) DEFAULT '0',
  `publish_date` datetime DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `video_root_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `student` tinyint(1) DEFAULT '0',
  `student_accept` tinyint(1) DEFAULT '0',
  `group_id` int(11) DEFAULT NULL,
  `views` bigint(20) DEFAULT NULL,
  `show_views` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id_idx` (`category_id`),
  KEY `group_id_idx` (`group_id`),
  KEY `photo_root_id_idx` (`photo_root_id`),
  KEY `video_root_id_idx` (`video_root_id`),
  KEY `metatag_id_idx` (`metatag_id`),
  KEY `user_id_idx` (`user_id`),
  KEY `last_user_id_idx` (`last_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_news: 0 rows
DELETE FROM `news_news`;
/*!40000 ALTER TABLE `news_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_news` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_news_tag
DROP TABLE IF EXISTS `news_news_tag`;
CREATE TABLE IF NOT EXISTS `news_news_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) DEFAULT NULL,
  `news_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id_idx` (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_news_tag: 0 rows
DELETE FROM `news_news_tag`;
/*!40000 ALTER TABLE `news_news_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_news_tag` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_news_translation
DROP TABLE IF EXISTS `news_news_translation`;
CREATE TABLE IF NOT EXISTS `news_news_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_news_translation: 0 rows
DELETE FROM `news_news_translation`;
/*!40000 ALTER TABLE `news_news_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_news_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_stream
DROP TABLE IF EXISTS `news_stream`;
CREATE TABLE IF NOT EXISTS `news_stream` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1',
  `metatag_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `metatag_id_idx` (`metatag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_stream: 0 rows
DELETE FROM `news_stream`;
/*!40000 ALTER TABLE `news_stream` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_stream` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_stream_translation
DROP TABLE IF EXISTS `news_stream_translation`;
CREATE TABLE IF NOT EXISTS `news_stream_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_stream_translation: 0 rows
DELETE FROM `news_stream_translation`;
/*!40000 ALTER TABLE `news_stream_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_stream_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.news_tag
DROP TABLE IF EXISTS `news_tag`;
CREATE TABLE IF NOT EXISTS `news_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `metatag_id_idx` (`metatag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.news_tag: 0 rows
DELETE FROM `news_tag`;
/*!40000 ALTER TABLE `news_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_tag` ENABLE KEYS */;


-- Dumping structure for table pracownik.property_alert
DROP TABLE IF EXISTS `property_alert`;
CREATE TABLE IF NOT EXISTS `property_alert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `property_id_idx` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.property_alert: 0 rows
DELETE FROM `property_alert`;
/*!40000 ALTER TABLE `property_alert` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_alert` ENABLE KEYS */;


-- Dumping structure for table pracownik.property_feature
DROP TABLE IF EXISTS `property_feature`;
CREATE TABLE IF NOT EXISTS `property_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `feature` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `property_id_idx` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.property_feature: 0 rows
DELETE FROM `property_feature`;
/*!40000 ALTER TABLE `property_feature` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_feature` ENABLE KEYS */;


-- Dumping structure for table pracownik.property_floor_plan
DROP TABLE IF EXISTS `property_floor_plan`;
CREATE TABLE IF NOT EXISTS `property_floor_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `floor_plan` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `property_id_idx` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.property_floor_plan: 0 rows
DELETE FROM `property_floor_plan`;
/*!40000 ALTER TABLE `property_floor_plan` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_floor_plan` ENABLE KEYS */;


-- Dumping structure for table pracownik.property_image
DROP TABLE IF EXISTS `property_image`;
CREATE TABLE IF NOT EXISTS `property_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `upload` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `property_id_idx` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.property_image: 0 rows
DELETE FROM `property_image`;
/*!40000 ALTER TABLE `property_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_image` ENABLE KEYS */;


-- Dumping structure for table pracownik.property_lead
DROP TABLE IF EXISTS `property_lead`;
CREATE TABLE IF NOT EXISTS `property_lead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postcode1` varchar(255) DEFAULT NULL,
  `postcode2` varchar(255) DEFAULT NULL,
  `message` longtext,
  `notes` longtext,
  `more_details` tinyint(1) DEFAULT '0',
  `view_property` tinyint(1) DEFAULT '0',
  `consent_for_contact` tinyint(1) DEFAULT '0',
  `send_confirmation_email` tinyint(1) DEFAULT '0',
  `buyorrent` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `beds` int(11) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `property_id_idx` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.property_lead: 0 rows
DELETE FROM `property_lead`;
/*!40000 ALTER TABLE `property_lead` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_lead` ENABLE KEYS */;


-- Dumping structure for table pracownik.property_let
DROP TABLE IF EXISTS `property_let`;
CREATE TABLE IF NOT EXISTS `property_let` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `date_available` datetime DEFAULT NULL,
  `bond` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `furn_id` int(11) DEFAULT NULL,
  `rent_frequency` int(11) DEFAULT NULL,
  `contract_in_months` int(11) DEFAULT NULL,
  `washing_machine` tinyint(1) DEFAULT '0',
  `dishwasher` tinyint(1) DEFAULT '0',
  `burglar_alarm` tinyint(1) DEFAULT '0',
  `bill_inc_water` tinyint(1) DEFAULT '0',
  `bill_inc_gas` tinyint(1) DEFAULT '0',
  `bill_inc_electricity` tinyint(1) DEFAULT '0',
  `bill_inc_tv_licence` tinyint(1) DEFAULT '0',
  `bill_inc_tv_subscription` tinyint(1) DEFAULT '0',
  `bill_inc_internet` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `property_id_idx` (`property_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16772 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.property_let: 0 rows
DELETE FROM `property_let`;
/*!40000 ALTER TABLE `property_let` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_let` ENABLE KEYS */;


-- Dumping structure for table pracownik.property_property
DROP TABLE IF EXISTS `property_property`;
CREATE TABLE IF NOT EXISTS `property_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `description` longtext,
  `agent_ref` varchar(255) DEFAULT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `address_3` varchar(255) DEFAULT NULL,
  `address_4` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `postcode1` varchar(255) DEFAULT NULL,
  `postcode2` varchar(255) DEFAULT NULL,
  `display_address` varchar(255) DEFAULT NULL,
  `branch_identify` varchar(255) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `living_rooms` int(11) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `prop_sub_id` int(11) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '1',
  `trans_type_id` int(11) DEFAULT NULL,
  `new_home` tinyint(1) DEFAULT '0',
  `slideshow` tinyint(1) DEFAULT '0',
  `featured` tinyint(1) DEFAULT '0',
  `gold` tinyint(1) DEFAULT '0',
  `draft` tinyint(1) DEFAULT '0',
  `valuation` int(11) DEFAULT '0',
  `min_price` bigint(20) DEFAULT NULL,
  `chain_fee` tinyint(1) DEFAULT '0',
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `search_price` float(10,2) DEFAULT NULL,
  `expired` tinyint(1) DEFAULT '0',
  `media_image_60` varchar(255) DEFAULT NULL,
  `media_image_text_60` varchar(255) DEFAULT NULL,
  `media_document_50` varchar(255) DEFAULT NULL,
  `media_document_text_50` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16772 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.property_property: 0 rows
DELETE FROM `property_property`;
/*!40000 ALTER TABLE `property_property` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_property` ENABLE KEYS */;


-- Dumping structure for table pracownik.property_sale
DROP TABLE IF EXISTS `property_sale`;
CREATE TABLE IF NOT EXISTS `property_sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `price_qualifier` int(11) DEFAULT NULL,
  `tenure_type_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `property_id_idx` (`property_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16772 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.property_sale: 0 rows
DELETE FROM `property_sale`;
/*!40000 ALTER TABLE `property_sale` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_sale` ENABLE KEYS */;


-- Dumping structure for table pracownik.review_abuse_report
DROP TABLE IF EXISTS `review_abuse_report`;
CREATE TABLE IF NOT EXISTS `review_abuse_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `review_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `mob` varchar(255) DEFAULT NULL,
  `comment` longtext,
  `report_date` datetime DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `archive` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `review_id_idx` (`review_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.review_abuse_report: 0 rows
DELETE FROM `review_abuse_report`;
/*!40000 ALTER TABLE `review_abuse_report` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_abuse_report` ENABLE KEYS */;


-- Dumping structure for table pracownik.review_alert
DROP TABLE IF EXISTS `review_alert`;
CREATE TABLE IF NOT EXISTS `review_alert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.review_alert: 0 rows
DELETE FROM `review_alert`;
/*!40000 ALTER TABLE `review_alert` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_alert` ENABLE KEYS */;


-- Dumping structure for table pracownik.review_alert_send
DROP TABLE IF EXISTS `review_alert_send`;
CREATE TABLE IF NOT EXISTS `review_alert_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alert_id` bigint(20) DEFAULT NULL,
  `review_id` bigint(20) DEFAULT NULL,
  `sent` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alert_id_idx` (`alert_id`),
  KEY `review_id_idx` (`review_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.review_alert_send: 0 rows
DELETE FROM `review_alert_send`;
/*!40000 ALTER TABLE `review_alert_send` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_alert_send` ENABLE KEYS */;


-- Dumping structure for table pracownik.review_comment
DROP TABLE IF EXISTS `review_comment`;
CREATE TABLE IF NOT EXISTS `review_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `review_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `comment` longtext,
  `ip` varchar(255) DEFAULT NULL,
  `activation` varchar(255) DEFAULT NULL,
  `view` tinyint(1) DEFAULT '1',
  `approve` tinyint(1) DEFAULT '0',
  `activated` tinyint(1) DEFAULT '0',
  `activation_ip` varchar(255) DEFAULT NULL,
  `activation_hostname` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `notes` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `review_id_idx` (`review_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42510 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.review_comment: 8 rows
DELETE FROM `review_comment`;
/*!40000 ALTER TABLE `review_comment` DISABLE KEYS */;
INSERT INTO `review_comment` (`id`, `review_id`, `name`, `email`, `activation_code`, `comment`, `ip`, `activation`, `view`, `approve`, `activated`, `activation_ip`, `activation_hostname`, `hostname`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(42502, 252239, 'Imie', 'mail@mail.pl', NULL, NULL, '::1', NULL, 1, 0, 0, NULL, NULL, 'Jono-PC.12LET.LOCAL', NULL, '2016-03-18 18:10:11', '2016-03-18 18:10:11', NULL),
	(42503, 252239, 'Imie', 'mail@mail.pl', NULL, NULL, '::1', NULL, 1, 0, 0, NULL, NULL, 'Jono-PC.12LET.LOCAL', NULL, '2016-03-18 18:10:33', '2016-03-18 18:10:33', NULL),
	(42504, 252239, 'Imie', 'mail@mail.pl', NULL, NULL, '::1', NULL, 1, 0, 0, NULL, NULL, 'Jono-PC.12LET.LOCAL', NULL, '2016-03-18 18:11:09', '2016-03-18 18:11:09', NULL),
	(42505, 252239, 'Imie', 'mail@mail.pl', NULL, NULL, '::1', NULL, 1, 0, 0, NULL, NULL, 'Jono-PC.12LET.LOCAL', NULL, '2016-03-18 18:11:51', '2016-03-18 18:11:51', NULL),
	(42506, 252239, 'Imie', 'mail@mail.pl', NULL, NULL, '::1', NULL, 1, 0, 0, NULL, NULL, 'Jono-PC.12LET.LOCAL', NULL, '2016-03-18 18:12:31', '2016-03-18 18:12:31', NULL),
	(42507, 252239, 'Moje imie', 'moj@mail.pl', NULL, NULL, '::1', NULL, 1, 0, 0, NULL, NULL, 'Jono-PC.12LET.LOCAL', NULL, '2016-03-21 12:54:44', '2016-03-21 12:54:44', NULL),
	(42508, 252239, 'Moje imie', 'kardi31@tlen.pl', '6f9c3826dec6ac019936418ab0c4edf7', NULL, '::1', NULL, 1, 0, 0, NULL, NULL, 'Jono-PC.12LET.LOCAL', NULL, '2016-03-21 12:59:05', '2016-03-21 13:27:59', '2016-03-21 13:27:59'),
	(42509, 252239, 'Moje imie', 'kardi31@tlen.pl', '1b36722701394fbc3e5563fa8cb7f7de', NULL, '::1', NULL, 1, 1, 1, '::1', 'Jono-PC.12LET.LOCAL', 'Jono-PC.12LET.LOCAL', NULL, '2016-03-21 13:01:26', '2016-03-21 13:26:40', NULL);
/*!40000 ALTER TABLE `review_comment` ENABLE KEYS */;


-- Dumping structure for table pracownik.review_comment_files
DROP TABLE IF EXISTS `review_comment_files`;
CREATE TABLE IF NOT EXISTS `review_comment_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) DEFAULT NULL,
  `src` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `ext` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_id_idx` (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.review_comment_files: 0 rows
DELETE FROM `review_comment_files`;
/*!40000 ALTER TABLE `review_comment_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_comment_files` ENABLE KEYS */;


-- Dumping structure for table pracownik.review_comment_translation
DROP TABLE IF EXISTS `review_comment_translation`;
CREATE TABLE IF NOT EXISTS `review_comment_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `comment` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.review_comment_translation: 8 rows
DELETE FROM `review_comment_translation`;
/*!40000 ALTER TABLE `review_comment_translation` DISABLE KEYS */;
INSERT INTO `review_comment_translation` (`id`, `comment`, `lang`) VALUES
	(42506, 'komentarz', 'pl'),
	(42506, 'komentarz', 'en'),
	(42507, 'komentarz', 'pl'),
	(42507, 'komentarz', 'en'),
	(42508, 'komentarz', 'pl'),
	(42508, 'komentarz', 'en'),
	(42509, 'komentarz', 'pl'),
	(42509, 'komentarz', 'en');
/*!40000 ALTER TABLE `review_comment_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.review_files
DROP TABLE IF EXISTS `review_files`;
CREATE TABLE IF NOT EXISTS `review_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `review_id` bigint(20) DEFAULT NULL,
  `src` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `ext` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `review_id_idx` (`review_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.review_files: 0 rows
DELETE FROM `review_files`;
/*!40000 ALTER TABLE `review_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_files` ENABLE KEYS */;


-- Dumping structure for table pracownik.review_ranking_week
DROP TABLE IF EXISTS `review_ranking_week`;
CREATE TABLE IF NOT EXISTS `review_ranking_week` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `review_id` bigint(20) DEFAULT NULL,
  `year` bigint(20) DEFAULT NULL,
  `week` bigint(20) DEFAULT NULL,
  `rank` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `review_id_idx` (`review_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.review_ranking_week: 0 rows
DELETE FROM `review_ranking_week`;
/*!40000 ALTER TABLE `review_ranking_week` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_ranking_week` ENABLE KEYS */;


-- Dumping structure for table pracownik.review_review
DROP TABLE IF EXISTS `review_review`;
CREATE TABLE IF NOT EXISTS `review_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `rating` bigint(20) DEFAULT NULL,
  `recommend` tinyint(1) DEFAULT '0',
  `review` longtext,
  `display_name` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `view` tinyint(1) DEFAULT '1',
  `ip` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `feedback` longtext,
  `service_date` date DEFAULT NULL,
  `featured` tinyint(1) DEFAULT '0',
  `activation_ip` varchar(255) DEFAULT NULL,
  `activation_hostname` varchar(255) DEFAULT NULL,
  `helpful` int(11) DEFAULT NULL,
  `staff` int(11) DEFAULT NULL,
  `staff2` int(11) DEFAULT NULL,
  `notes` longtext,
  `fee_feedback` longtext,
  `approved_by` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `review_review_staff_staff_staff_id` (`staff`),
  KEY `review_review_staff2_staff_staff_id` (`staff2`),
  KEY `review_review_branch_id_branch_branch_id` (`branch_id`),
  KEY `review_review_agent_id_agent_agent_id` (`agent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.review_review: 0 rows
DELETE FROM `review_review`;
/*!40000 ALTER TABLE `review_review` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_review` ENABLE KEYS */;


-- Dumping structure for table pracownik.review_review_translation
DROP TABLE IF EXISTS `review_review_translation`;
CREATE TABLE IF NOT EXISTS `review_review_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `review` longtext,
  `feedback` longtext,
  `fee_feedback` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.review_review_translation: 36 rows
DELETE FROM `review_review_translation`;
/*!40000 ALTER TABLE `review_review_translation` DISABLE KEYS */;
INSERT INTO `review_review_translation` (`id`, `review`, `feedback`, `fee_feedback`, `lang`) VALUES
	(99983, 'testen', NULL, NULL, 'en'),
	(99983, 'Lorem ipsum dolor sit amet erat. Proin dui porta scelerisque, dui convallis posuere. Quisque vestibulum. Etiam risus risus dictum consectetuer. Quisque urna. Cras vitae est ultricies ante. Lorem ipsum dolor ac nunc libero, ultricies nulla, placerat semper, nunc semper nec, sem. Integer quis diam mauris, rutrum id, imperdiet congue ac, dictum lectus blandit justo, hendrerit nulla in leo sed quam eu quam. Aliquam vestibulum vel, eros. Ut vestibulum viverra est lacus sit amet mauris sit amet dignissim justo. Integer hendrerit sollicitudin. Fusce et odio. Morbi dignissim, sapien eleifend quam porta ut, nunc. Sed et magnis dis parturient montes, nascetur ridiculus mus. Nunc in nibh malesuada velit suscipit lectus. Nulla facilisi. Mauris ultrices. Nunc viverra quis, lacinia at, fermentum tortor. Praesent lacinia dictum. Curabitur interdum rhoncus, dolor magna, at nibh. Morbi commodo. Cras vitae mauris. Aenean venenatis augue a ornare elementum leo. Pellentesque porta eu, bibendum mi. Pellentesque tincidunt fermentum. Morbi consequat tortor. Maecenas eu wisi. Morbi sodales turpis, rutrum pede semper facilisis eget, enim. Etiam sit amet dui. Pellentesque nunc. Integer aliquet nulla, convallis quam ut eros. Mauris tortor. Aliquam.', NULL, NULL, 'pl'),
	(252226, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252226, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252227, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252227, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252228, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252228, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252229, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252229, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252230, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252230, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252231, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252231, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252232, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252232, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252233, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252233, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252234, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252234, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252235, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252235, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252236, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252236, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252237, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252237, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252238, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252238, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252239, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252239, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252240, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252240, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252241, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252241, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en'),
	(252242, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbackpl</p>', NULL, 'pl'),
	(252242, '<p>TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.</p>', '<p>feedbacken</p>', NULL, 'en');
/*!40000 ALTER TABLE `review_review_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.review_temp
DROP TABLE IF EXISTS `review_temp`;
CREATE TABLE IF NOT EXISTS `review_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `rating` bigint(20) DEFAULT NULL,
  `recommend` tinyint(1) DEFAULT '0',
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `review` longtext,
  `display_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `feedback` longtext,
  `activation_ip` varchar(255) DEFAULT NULL,
  `activation_hostname` varchar(255) DEFAULT NULL,
  `staff` int(11) DEFAULT NULL,
  `staff2` int(11) DEFAULT NULL,
  `notes` longtext,
  `service_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `review_temp_staff_staff_staff_id` (`staff`),
  KEY `review_temp_staff2_staff_staff_id` (`staff2`),
  KEY `review_temp_branch_id_branch_branch_id` (`branch_id`),
  KEY `review_temp_agent_id_agent_agent_id` (`agent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.review_temp: 9 rows
DELETE FROM `review_temp`;
/*!40000 ALTER TABLE `review_temp` DISABLE KEYS */;
INSERT INTO `review_temp` (`id`, `agent_id`, `branch_id`, `rating`, `recommend`, `activated`, `review`, `display_name`, `email`, `firstname`, `lastname`, `phone`, `ip`, `activation_code`, `hostname`, `feedback`, `activation_ip`, `activation_hostname`, `staff`, `staff2`, `notes`, `service_date`, `created_at`, `updated_at`) VALUES
	(94, 14414, 44419, 3, 1, 0, 'opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie v', 'ksywa', 'mail@mail.pl', 'imie', 'nawzwiko', '', '::1', 'dd0cca023d86b078ca8b82e99f3a8274', 'Jono-PC.12LET.LOCAL', '', NULL, NULL, 0, 0, NULL, '2016-11-03 17:40:43', '2016-03-14 17:40:43', '2016-03-14 17:40:43'),
	(95, 14416, 44421, 3, 1, 0, 'opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie v', 'ksywa', 'mail@mail.pl', 'imie', 'nawzwiko', '', '::1', 'c2074024ccb59f7bd12d27f0c2b4d7ec', 'Jono-PC.12LET.LOCAL', '', NULL, NULL, 0, 0, NULL, '2016-11-03 17:41:23', '2016-03-14 17:41:23', '2016-03-14 17:41:23'),
	(96, 14417, 44422, 3, 1, 0, 'opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie v', 'ksywa', 'mail@mail.pl', 'imie', 'nawzwiko', '', '::1', '5fb91226a47bc7ea56acb508f406cfa9', 'Jono-PC.12LET.LOCAL', '', NULL, NULL, 0, 0, NULL, '2016-11-03 17:41:28', '2016-03-14 17:41:28', '2016-03-14 17:41:28'),
	(97, 14418, 44423, 3, 1, 0, 'opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie v', 'ksywa', 'mail@mail.pl', 'imie', 'nawzwiko', '', '::1', 'a54118e45da82a2f0102ceaea34e5caf', 'Jono-PC.12LET.LOCAL', '', NULL, NULL, 0, 0, NULL, '2016-11-03 17:41:32', '2016-03-14 17:41:32', '2016-03-14 17:41:32'),
	(98, 14419, 44424, 3, 1, 0, 'opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie v', 'ksywa', 'mail@mail.pl', 'imie', 'nawzwiko', '', '::1', '1c6aab9836374e2d85f33433edbaa456', 'Jono-PC.12LET.LOCAL', '', NULL, NULL, 0, 0, NULL, '2016-11-03 17:41:42', '2016-03-14 17:41:42', '2016-03-14 17:41:42'),
	(99, 14420, 44425, 3, 1, 0, 'opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie opinie v', 'ksywa', 'mail@mail.pl', 'imie', 'nawzwiko', '', '::1', 'd20fd59ed73eb24b1bba156955a8241b', 'Jono-PC.12LET.LOCAL', '', NULL, NULL, 0, 0, NULL, '2016-11-03 17:42:22', '2016-03-14 17:42:22', '2016-03-14 17:42:22'),
	(101, 154, 456, 4, 1, 0, 'TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia. TO jest moja opinia.  TO jest moja opinia. ', 'Ksywa', 'mail@mail.pl', 'Imie', 'Nazwiskom', '', '::1', '2a9aa08144586670953fd8d7ba1a996e', 'Jono-PC.12LET.LOCAL', '', NULL, NULL, 11627, 12190, NULL, '2017-04-03 14:24:28', '2016-03-17 14:24:28', '2016-03-17 14:24:28'),
	(105, 14448, 44479, 4, 1, 1, 'dasddsa das dad ad ad ad ad ad asda d adas dasdasdasda dadasdasdadasdasdadadas dadasdasdadasdasdadadas dadasdasdadasdasdadadasdadasdasdadasdasdadadasdadasdasdadasdasdadadas dadasdasdadasdasdadadas dadasdasdadasdasdadadas dadasdasdadasdasdadadas dadasdasdadasdasdadadas dadasdasdadasdasdadadas', 'ksywa', 'kardi31@tlen.pl', 'Imie', 'Nazwisko', '', '::1', '7bfdaba1e8dcc3c9b617e476c7cb2cad', 'Jono-PC.12LET.LOCAL', '', '::1', 'Jono-PC.12LET.LOCAL', 1000111036, 1000111037, NULL, '2017-04-03 12:35:40', '2016-03-22 12:35:40', '2016-03-22 12:39:05'),
	(106, 14449, 44480, 4, 1, 0, 'dasddsa das dad ad ad ad ad ad asda d adas dasdasdasda dadasdasdadasdasdadadas dadasdasdadasdasdadadas dadasdasdadasdasdadadasdadasdasdadasdasdadadasdadasdasdadasdasdadadas dadasdasdadasdasdadadas dadasdasdadasdasdadadas dadasdasdadasdasdadadas dadasdasdadasdasdadadas dadasdasdadasdasdadadas', 'ksywa', 'kardi31@tlen.pl', 'Imie', 'Nazwisko', '', '::1', '1fcdc429de65b6e675812ba218cb3f5f', 'Jono-PC.12LET.LOCAL', '', NULL, NULL, 1000111038, 1000111039, NULL, '2017-04-03 12:40:49', '2016-03-22 12:40:49', '2016-03-22 12:40:49');
/*!40000 ALTER TABLE `review_temp` ENABLE KEYS */;


-- Dumping structure for table pracownik.staff_area_covered
DROP TABLE IF EXISTS `staff_area_covered`;
CREATE TABLE IF NOT EXISTS `staff_area_covered` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_id_idx` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.staff_area_covered: 0 rows
DELETE FROM `staff_area_covered`;
/*!40000 ALTER TABLE `staff_area_covered` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_area_covered` ENABLE KEYS */;


-- Dumping structure for table pracownik.staff_award
DROP TABLE IF EXISTS `staff_award`;
CREATE TABLE IF NOT EXISTS `staff_award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `rank` varchar(255) DEFAULT NULL,
  `staff` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `agent_url` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `branch_url` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `reviews` int(11) DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `rating` float(5,2) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_id_idx` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.staff_award: 0 rows
DELETE FROM `staff_award`;
/*!40000 ALTER TABLE `staff_award` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_award` ENABLE KEYS */;


-- Dumping structure for table pracownik.staff_claim
DROP TABLE IF EXISTS `staff_claim`;
CREATE TABLE IF NOT EXISTS `staff_claim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `mob` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `comment` longtext,
  `dob` date DEFAULT NULL,
  `birthplace` varchar(255) DEFAULT NULL,
  `sport` varchar(255) DEFAULT NULL,
  `team` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_id_idx` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.staff_claim: 0 rows
DELETE FROM `staff_claim`;
/*!40000 ALTER TABLE `staff_claim` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_claim` ENABLE KEYS */;


-- Dumping structure for table pracownik.staff_photo_claim
DROP TABLE IF EXISTS `staff_photo_claim`;
CREATE TABLE IF NOT EXISTS `staff_photo_claim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `photo_name` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `expiration_date` varchar(255) DEFAULT NULL,
  `activated` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `staff_id_idx` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.staff_photo_claim: 0 rows
DELETE FROM `staff_photo_claim`;
/*!40000 ALTER TABLE `staff_photo_claim` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_photo_claim` ENABLE KEYS */;


-- Dumping structure for table pracownik.staff_staff
DROP TABLE IF EXISTS `staff_staff`;
CREATE TABLE IF NOT EXISTS `staff_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `customer_satisfaction` float(5,2) DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `view` tinyint(1) NOT NULL DEFAULT '0',
  `rank` int(11) DEFAULT NULL,
  `rating` float(5,2) DEFAULT NULL,
  `claimed` tinyint(1) NOT NULL DEFAULT '0',
  `active_reviews` int(11) DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_staff_branch_id_branch_branch_id` (`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.staff_staff: 0 rows
DELETE FROM `staff_staff`;
/*!40000 ALTER TABLE `staff_staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_staff` ENABLE KEYS */;


-- Dumping structure for table pracownik.staff_staff_branch
DROP TABLE IF EXISTS `staff_staff_branch`;
CREATE TABLE IF NOT EXISTS `staff_staff_branch` (
  `staff_id` int(11) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`staff_id`,`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.staff_staff_branch: 0 rows
DELETE FROM `staff_staff_branch`;
/*!40000 ALTER TABLE `staff_staff_branch` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_staff_branch` ENABLE KEYS */;


-- Dumping structure for table pracownik.staff_staff_translation
DROP TABLE IF EXISTS `staff_staff_translation`;
CREATE TABLE IF NOT EXISTS `staff_staff_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `description` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.staff_staff_translation: 10 rows
DELETE FROM `staff_staff_translation`;
/*!40000 ALTER TABLE `staff_staff_translation` DISABLE KEYS */;
INSERT INTO `staff_staff_translation` (`id`, `description`, `lang`) VALUES
	(6213, 'Moj opis 2', 'pl'),
	(11921, '<p>ewqe en en</p>', 'pl'),
	(1000111032, 'opis', 'pl'),
	(1000111033, '', 'pl'),
	(1000111034, 'sdada', 'pl'),
	(1000111035, 'osdpada', 'pl'),
	(1000111039, '', 'pl'),
	(1000111040, '<p>Opisowy</p>', 'pl'),
	(1000111040, '<p>fafaf</p>', 'en'),
	(11921, '<p>ewqe</p>', 'en');
/*!40000 ALTER TABLE `staff_staff_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.staff_update
DROP TABLE IF EXISTS `staff_update`;
CREATE TABLE IF NOT EXISTS `staff_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `description` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_id_idx` (`staff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11922 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.staff_update: 2 rows
DELETE FROM `staff_update`;
/*!40000 ALTER TABLE `staff_update` DISABLE KEYS */;
INSERT INTO `staff_update` (`id`, `staff_id`, `firstname`, `lastname`, `position`, `email`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(11921, 11921, 'Imie', 'Nazwisko', 'pozycja', 'mail@mail.pl', 'ewqe', '2016-03-09 17:23:28', '2016-03-29 10:42:04', '2016-03-29 10:42:04'),
	(11656, 11656, 'Mark', 'Smith', 'POzycja', 'johhn@smith.pl', 'TO jest moj super opis', '2016-03-28 17:21:36', '2016-03-29 10:45:56', '2016-03-29 10:45:56');
/*!40000 ALTER TABLE `staff_update` ENABLE KEYS */;


-- Dumping structure for table pracownik.user_group
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.user_group: 0 rows
DELETE FROM `user_group`;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;


-- Dumping structure for table pracownik.user_group_translation
DROP TABLE IF EXISTS `user_group_translation`;
CREATE TABLE IF NOT EXISTS `user_group_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.user_group_translation: 0 rows
DELETE FROM `user_group_translation`;
/*!40000 ALTER TABLE `user_group_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_group_translation` ENABLE KEYS */;


-- Dumping structure for table pracownik.user_profile
DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `about` longtext,
  `address` varchar(255) DEFAULT NULL,
  `postal_code` varchar(128) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `proxy_name` varchar(255) DEFAULT NULL,
  `photo_root_id` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.user_profile: 0 rows
DELETE FROM `user_profile`;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;


-- Dumping structure for table pracownik.user_role
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.user_role: 0 rows
DELETE FROM `user_role`;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;


-- Dumping structure for table pracownik.user_update
DROP TABLE IF EXISTS `user_update`;
CREATE TABLE IF NOT EXISTS `user_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.user_update: 0 rows
DELETE FROM `user_update`;
/*!40000 ALTER TABLE `user_update` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_update` ENABLE KEYS */;


-- Dumping structure for table pracownik.user_user
DROP TABLE IF EXISTS `user_user`;
CREATE TABLE IF NOT EXISTS `user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_id` varchar(128) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `agent_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.user_user: 20 rows
DELETE FROM `user_user`;
/*!40000 ALTER TABLE `user_user` DISABLE KEYS */;
INSERT INTO `user_user` (`id`, `fb_id`, `first_name`, `last_name`, `email`, `username`, `salt`, `password`, `role`, `token`, `active`, `agent_id`, `branch_id`, `staff_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, NULL, 'Emigrant', 'w UK', 'admin', 'admin', 'b6b348583faba2f99d08dbec01705399', 'a8f0e59f6563c27e1d844218727e30fa', 'admin', 'b5875f7a436667ea2e24fed4ccb151bd', 1, NULL, NULL, NULL, '0000-00-00 00:00:00', '2016-04-07 17:33:29', NULL),
	(2, NULL, 'Tomek', 'Kardas', 'kardi3', NULL, '363e387505f95ad777de50f4a9d24970', 'bcd365f2d8a4ed838b9623698e3f6ce4', 'admin', '71dac99f5cd35c36a9f4a3a63b87eb6b', 1, NULL, NULL, NULL, '0000-00-00 00:00:00', '2016-03-14 10:53:41', NULL),
	(60, NULL, 'Jan', 'Nowak', 'tomekvarts@o2.pl', NULL, '24dd951b33621c934cf44ddee5441555', 'efd6044d2f1f53465fbdb96bfd4438fe', 'redaktor', 'c38cd886075743dd52658dd55c0621e1', 1, NULL, NULL, NULL, '2014-10-13 13:54:56', '2014-10-13 13:55:46', NULL),
	(72, NULL, NULL, NULL, 'mailslaw@interia.pl', 'Marek', '2ef1bcb6ebabd83031d38f4f401cb7e0', 'b3833b0067cc3430b6019daa0dfa758b', 'client', '23a9b436b8f419c96cd132ccfec51594', 0, NULL, NULL, NULL, '2016-02-02 17:53:08', '2016-02-02 17:53:08', NULL),
	(73, NULL, NULL, NULL, 'kochanowski1@vp.pl', 'seban', '95c266b0f69d185fbbdc288b49c50cbf', '1a438045627eb4bcc0c6ea8bed1ac19e', 'client', '8fae3f5cf0309fc38390e092705d28ac', 1, NULL, NULL, NULL, '2016-02-03 14:20:49', '2016-02-03 14:31:29', NULL),
	(76, NULL, NULL, NULL, 'tomasz.kardas20@gmail.com', 'mojtest', '8a8eabf85a6ccaa4a0da3b7dd4211206', 'cfe56643e5b7702a5d1ba5191c88ad93', 'client', 'cb19a3defcd6e30798869d11f24986fb', 1, NULL, NULL, NULL, '2016-02-03 14:58:28', '2016-02-03 14:58:28', NULL),
	(64, NULL, NULL, NULL, 'mail@mail.pl', 'testuser', '8412053ce8447e201757a8403abec937', 'f57dd9657109e1888d1a06139dfba026', 'client', '48e01eb1ded194837d530759179893d6', 1, NULL, NULL, NULL, '2016-01-07 18:00:04', '2016-01-07 18:00:04', NULL),
	(65, NULL, NULL, NULL, 'karol030684@wp.pl', 'kara', 'ec97b688299f8c6355980c8f146e2aa4', '07847f80ca4c1d649055ce3ee7cb5298', 'client', 'e1890f1804ec7dbf49a0b537b43b6649', 1, NULL, NULL, NULL, '2016-01-28 22:01:58', '2016-01-28 22:01:58', NULL),
	(74, NULL, NULL, NULL, 'lukaszlukasinski@vp.pl', 'Na Nowo Odrodzony', 'fec7429f37965bb66f2fff37284117e5', '41658de3b53a99083d3ccd662247a917', 'client', '92ba745776c4761d18fa9e70b11bf9fe', 0, NULL, NULL, NULL, '2016-02-03 14:29:30', '2016-02-03 14:29:30', NULL),
	(77, NULL, NULL, NULL, 'legal128@interia.pl', 'legal', 'bd955445dc18b72e6ffbf12cc0e1bd5d', '1f483cd70daca08031980f92031d13f6', 'client', 'dc046082a8ffb992d8a52e23f04887a6', 1, NULL, NULL, NULL, '2016-02-03 16:37:15', '2016-02-03 16:37:45', NULL),
	(78, NULL, NULL, NULL, 'Piotrek7988@hotmail.com', 'Piotrek', '4a03f0007d04df026f3b506e843043a8', 'c8a96c46c63092f3e69548bc2b6263c2', 'client', '96069012e6c2c897980be5eee85206c0', 1, NULL, NULL, NULL, '2016-02-03 19:03:44', '2016-02-03 19:04:11', NULL),
	(79, NULL, NULL, NULL, 'marekplaszewski@wp.pl', 'marekplaszewski', '1677fe6d634c6427a5f3b31a04130475', '6ec3c18b568d665535a9b0b8d23f78de', 'client', '72dfec30959a27c4a70cf7fe2daf5779', 0, NULL, NULL, NULL, '2016-02-03 19:12:41', '2016-02-03 19:12:41', NULL),
	(80, NULL, NULL, NULL, 'agent@agent.pl', 'agent', 'a2f71eef29bae9891e4f2d52139c97bd', '2b359edcd9af4e58516a3f386682d854', 'agent', '85eb120017ff5cfce2b3443500ff146a', 1, 621, NULL, NULL, '2016-02-03 14:58:28', '2016-03-24 17:24:12', NULL),
	(83, NULL, NULL, NULL, 'kardi31@tlen.pl', NULL, '679b0b0de84c474db7d41824f19a75ac', '355e84a5d72a1f67b4f73a4e9a392c11', 'branch', '679b0b0de84c474db7d41824f19a75ac', 1, 14448, NULL, NULL, '2016-03-22 16:52:33', '2016-03-23 13:00:58', NULL),
	(104, NULL, NULL, NULL, 'test@kardimobile.hekko.pl', NULL, '61489c2e76a226938d65251f12d439ee', '739783f1392794477c74cb71a0fab5d7', 'branch', '61489c2e76a226938d65251f12d439ee', 1, 14449, 44480, NULL, '2016-03-23 12:41:42', '2016-03-28 18:20:55', NULL),
	(105, NULL, NULL, NULL, 'propertychoices@netvigator.co.uk', NULL, '4e87c0f6e1ea4c1d6ccbdc41b5acb73f', '63028de836c65f291c3c6a72ffecb6ff', 'agent', '4e87c0f6e1ea4c1d6ccbdc41b5acb73f', 1, 864, NULL, NULL, '2016-03-25 17:34:35', '2016-03-25 17:39:57', NULL),
	(106, NULL, NULL, NULL, 'lettings@haybrook.com', NULL, '5d9d928e4039c23b7f803c50dbfa4cbd', 'c5f465215246e9c44da238f361bb5c30', 'agent', '5d9d928e4039c23b7f803c50dbfa4cbd', 1, 2209, NULL, NULL, '2016-03-25 17:58:26', '2016-03-25 17:58:26', NULL),
	(107, NULL, NULL, NULL, 'sales@carvergroup.co.uk', NULL, 'd289d6efa1c9ad61d71f6f0b40740108', 'e63092358ce818f95347714f15e09b88', 'agent', 'd289d6efa1c9ad61d71f6f0b40740108', 1, 5573, NULL, NULL, '2016-03-25 18:00:52', '2016-03-25 18:00:52', NULL),
	(109, NULL, NULL, NULL, 'caterham@choices.co.uk', NULL, '97830f9d20e645005799784b96156afb', 'c06ddccaf816aa5c47f086b2b9371f1d', 'agent', '97830f9d20e645005799784b96156afb', 1, 620, NULL, NULL, '2016-03-25 18:08:18', '2016-03-25 18:08:18', NULL),
	(115, NULL, NULL, NULL, 'mojaaa@mail.pl', NULL, '914b947fa562703c6c933324e0c40007', '0ae92e84c5485baf8bc1ba6e27885733', 'agent', '914b947fa562703c6c933324e0c40007', 1, 14484, NULL, NULL, '2016-04-01 10:57:36', '2016-04-01 10:57:36', NULL);
/*!40000 ALTER TABLE `user_user` ENABLE KEYS */;


-- Dumping structure for table pracownik.user_user_group
DROP TABLE IF EXISTS `user_user_group`;
CREATE TABLE IF NOT EXISTS `user_user_group` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `user_user_group_group_id_user_group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.user_user_group: 0 rows
DELETE FROM `user_user_group`;
/*!40000 ALTER TABLE `user_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_user_group` ENABLE KEYS */;


-- Dumping structure for table pracownik.user_user_role
DROP TABLE IF EXISTS `user_user_role`;
CREATE TABLE IF NOT EXISTS `user_user_role` (
  `id` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`slug`),
  KEY `user_user_role_slug_user_role_slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pracownik.user_user_role: 0 rows
DELETE FROM `user_user_role`;
/*!40000 ALTER TABLE `user_user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_user_role` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
