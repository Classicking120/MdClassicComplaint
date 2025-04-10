-- PHP MySQL Dump
--
-- Host: 
-- Generated: Thu, 10 Apr 2025 10:02:16 -0500
-- PHP Version: 8.2.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";;;;;_lifetechend;;;;;

--
-- Database: `uxdri30e_class`
--

-- ------------------------------------------------------------

--
-- Table structure for table `tb_complaint_feedback`
--

CREATE TABLE IF NOT EXISTS `tb_complaint_feedback` (
  `lifetech_general_id` bigint(15) DEFAULT NULL,
  `lifetech_table_status` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `complaint_response` text COLLATE utf8_unicode_ci,
  `user_id` bigint(20) DEFAULT NULL,
  `complaint_ticket_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `sender` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;;;;;_lifetechend;;;;;


-- ------------------------------------------------------------

--
-- Table structure for table `tb_complaint_notes`
--

CREATE TABLE IF NOT EXISTS `tb_complaint_notes` (
  `lifetech_general_id` bigint(15) DEFAULT NULL,
  `lifetech_table_status` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `complaint_note` text COLLATE utf8_unicode_ci,
  `user_id` bigint(20) DEFAULT NULL,
  `complaint_ticket_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;;;;;_lifetechend;;;;;


-- ------------------------------------------------------------

--
-- Table structure for table `tb_lifetech_lms_add_student`
--

CREATE TABLE IF NOT EXISTS `tb_lifetech_lms_add_student` (
  `lifetech_general_id` bigint(15) NOT NULL,
  `lifetech_table_status` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lifetech_email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lifetech_surname` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lifetech_username` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lifetech_matno` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lifetech_general_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;;;;;_lifetechend;;;;;


-- ------------------------------------------------------------

--
-- Table structure for table `tb_submit_complaint`
--

CREATE TABLE IF NOT EXISTS `tb_submit_complaint` (
  `lifetech_general_id` bigint(15) DEFAULT NULL,
  `lifetech_table_status` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `complaint_ticket_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `complaint_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `complaint_by` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `complaint_photo` text COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `complaint_status_code` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;;;;;_lifetechend;;;;;

