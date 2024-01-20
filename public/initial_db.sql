-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2023 at 09:44 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xeroneit_sitedoctor_laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `comparision`
--

DROP TABLE IF EXISTS `comparision`;
CREATE TABLE IF NOT EXISTS `comparision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `base_site` int(11) NOT NULL DEFAULT '0',
  `competutor_site` int(11) NOT NULL DEFAULT '0',
  `email` longtext,
  `searched_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `searched_at` (`searched_at`),
  KEY `base_site` (`base_site`),
  KEY `competutor_site` (`competutor_site`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

DROP TABLE IF EXISTS `email_config`;
CREATE TABLE IF NOT EXISTS `email_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(100) DEFAULT NULL,
  `smtp_host` varchar(100) DEFAULT NULL,
  `smtp_port` varchar(100) DEFAULT NULL,
  `smtp_user` varchar(100) DEFAULT NULL,
  `smtp_password` varchar(100) DEFAULT NULL,
  `encryption` enum('Default','tls','ssl') NOT NULL DEFAULT 'Default',
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `forget_password`
--

DROP TABLE IF EXISTS `forget_password`;
CREATE TABLE IF NOT EXISTS `forget_password` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `confirmation_code` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `success` int(11) NOT NULL DEFAULT '0',
  `expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
CREATE TABLE IF NOT EXISTS `leads` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `date_time` varchar(50) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_of_search` int(11) NOT NULL DEFAULT '1',
  `domain` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`(191),`no_of_search`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `general_settings` text,
  `lead_settings` text,
  `advertisement_settings` text,
  `google_api_key` varchar(120) DEFAULT NULL,
  `social_media` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `site_check_report`
--

DROP TABLE IF EXISTS `site_check_report`;
CREATE TABLE IF NOT EXISTS `site_check_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(200) DEFAULT NULL,
  `searched_at` datetime NOT NULL,
  `title` text,
  `description` text,
  `meta_keyword` text,
  `viewport` varchar(255) DEFAULT NULL,
  `h1` text,
  `h2` text,
  `h3` text,
  `h4` text,
  `h5` text,
  `h6` text,
  `noindex_by_meta_robot` varchar(50) DEFAULT NULL,
  `nofollowed_by_meta_robot` varchar(50) DEFAULT NULL,
  `keyword_one_phrase` text,
  `keyword_two_phrase` text,
  `keyword_three_phrase` text,
  `keyword_four_phrase` text,
  `total_words` varchar(50) DEFAULT NULL,
  `robot_txt_exist` varchar(50) DEFAULT NULL,
  `robot_txt_content` text,
  `sitemap_exist` varchar(50) DEFAULT NULL,
  `sitemap_location` text,
  `external_link_count` varchar(50) DEFAULT NULL,
  `internal_link_count` varchar(50) DEFAULT NULL,
  `nofollow_link_count` varchar(50) DEFAULT NULL,
  `dofollow_link_count` varchar(50) DEFAULT NULL,
  `external_link` text,
  `internal_link` text,
  `nofollow_internal_link` text,
  `not_seo_friendly_link` text,
  `image_without_alt_count` varchar(50) DEFAULT NULL,
  `image_not_alt_list` text,
  `inline_css` text,
  `internal_css` longtext,
  `depreciated_html_tag` text,
  `is_favicon_found` varchar(50) DEFAULT NULL,
  `favicon_link` varchar(255) DEFAULT NULL,
  `total_page_size_general` varchar(50) DEFAULT NULL,
  `page_size_gzip` varchar(50) DEFAULT NULL,
  `is_gzip_enable` varchar(50) DEFAULT NULL,
  `doctype` varchar(50) DEFAULT NULL,
  `doctype_is_exist` varchar(50) DEFAULT NULL,
  `nofollow_link_list` longtext,
  `canonical_link_list` text,
  `noindex_list` text,
  `micro_data_schema_list` text,
  `is_ipv6_compatiable` varchar(50) DEFAULT NULL,
  `ipv6` varchar(50) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `dns_report` text,
  `is_ip_canonical` varchar(50) DEFAULT NULL,
  `email_list` text,
  `is_url_canonicalized` varchar(50) DEFAULT NULL,
  `text_to_html_ratio` varchar(50) DEFAULT NULL,
  `general_curl_response` text,
  `warning_count` varchar(50) DEFAULT NULL,
  `completed_step_count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `search_at` (`searched_at`),
  KEY `domain_name` (`domain_name`),
  KEY `domain_searched` (`domain_name`,`searched_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `site_check_report_partial`
--

DROP TABLE IF EXISTS `site_check_report_partial`;
CREATE TABLE IF NOT EXISTS `site_check_report_partial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_check_table_id` int(11) NOT NULL,
  `mobile_loadingexperience_metrics` text,
  `mobile_originloadingexperience_metrics` text,
  `mobile_lighthouseresult_configsettings` text,
  `mobile_lighthouseresult_audits` longtext,
  `mobile_lighthouseresult_categories` text,
  `mobile_google_api_error` text,
  `perfomence_category` varchar(255) DEFAULT NULL,
  `mobile_perfomence_score` double DEFAULT NULL,
  `desktop_loadingexperience_metrics` text,
  `desktop_originloadingexperience_metrics` text,
  `desktop_lighthouseresult_configsettings` text,
  `desktop_lighthouseresult_audits` longtext,
  `desktop_lighthouseresult_categories` text,
  `desktop_google_api_error` text,
  `desktop_perfomence_score` double DEFAULT NULL,
  `email` longtext,
  `domain_ip_info` text,
  `alexa_rank` text,
  `overall_score` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `update_list`
--

DROP TABLE IF EXISTS `update_list`;
CREATE TABLE IF NOT EXISTS `update_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `files` text NOT NULL,
  `sql_query` text NOT NULL,
  `update_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(99) DEFAULT NULL,
  `email` varchar(99) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `password` varchar(99) DEFAULT NULL,
  `address` mediumtext,
  `user_type` enum('Member','Admin') NOT NULL DEFAULT 'Admin',
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `activation_code` varchar(20) DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `timezone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_pic` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`name`, `email`, `mobile`, `password`, `address`, `user_type`, `status`, `remember_token`, `created_at`, `updated_at`, `email_verified_at`, `activation_code`, `deleted`) VALUES
('Sitedoctor', 'admin@gmail.com', NULL, '$2y$10$LEnPv7azu39xTMe3Vlhi7.PBAOeg6zS282ha335OxpPGMWcspKC1y', NULL, 'Admin', '1', NULL, '2022-10-31 04:03:01', '2022-10-31 04:03:01', NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

DROP TABLE IF EXISTS `version`;
CREATE TABLE IF NOT EXISTS `version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `current` enum('1','0') NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `version` (`version`),
  KEY `Current` (`current`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
