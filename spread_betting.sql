-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2021 at 03:16 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spread_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `bettings`
--

CREATE TABLE `bettings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wage_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `odd` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_id` int(11) NOT NULL,
  `result` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `star` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `friend_id` int(11) NOT NULL,
  `wage_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `star`, `created_at`, `updated_at`, `friend_id`, `wage_id`) VALUES
(1, 'wwww', 1, '2021-03-19 21:07:52', '2021-03-19 21:07:52', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_id` int(11) NOT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `league_id` int(11) NOT NULL,
  `home_team_id` int(11) NOT NULL,
  `away_team_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sport_id` int(11) NOT NULL,
  `date_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `game_id`, `time`, `timezone`, `timestamp`, `league_id`, `home_team_id`, `away_team_id`, `created_at`, `updated_at`, `sport_id`, `date_time`) VALUES
(55, 125381, '01:57', 'UTC', '1616119020', 62, 125, 126, '2021-03-18 18:47:29', '2021-03-18 18:47:29', 1, '2021-03-19'),
(56, 108804, '02:30', 'UTC', '1616121000', 63, 127, 128, '2021-03-18 18:47:30', '2021-03-18 18:47:30', 1, '2021-03-19'),
(57, 125382, '16:15', 'UTC', '1616170500', 64, 129, 130, '2021-03-18 18:47:30', '2021-03-18 18:47:30', 1, '2021-03-19'),
(58, 125383, '16:45', 'UTC', '1616172300', 65, 131, 132, '2021-03-18 18:47:30', '2021-03-18 18:47:30', 1, '2021-03-19'),
(59, 125384, '17:15', 'UTC', '1616174100', 66, 133, 134, '2021-03-18 18:47:30', '2021-03-18 18:47:30', 1, '2021-03-19'),
(60, 125385, '17:45', 'UTC', '1616175900', 67, 135, 136, '2021-03-18 18:47:30', '2021-03-18 18:47:30', 1, '2021-03-19'),
(61, 125386, '19:00', 'UTC', '1616180400', 68, 137, 138, '2021-03-18 18:47:30', '2021-03-18 18:47:30', 1, '2021-03-19'),
(62, 125387, '19:30', 'UTC', '1616182200', 69, 139, 140, '2021-03-18 18:47:30', '2021-03-18 18:47:30', 1, '2021-03-19'),
(63, 125388, '20:00', 'UTC', '1616184000', 70, 141, 142, '2021-03-18 18:47:31', '2021-03-18 18:47:31', 1, '2021-03-19'),
(64, 125389, '20:30', 'UTC', '1616185800', 71, 143, 144, '2021-03-18 18:47:31', '2021-03-18 18:47:31', 1, '2021-03-19'),
(65, 125390, '22:25', 'UTC', '1616192700', 72, 145, 146, '2021-03-18 18:47:31', '2021-03-18 18:47:31', 1, '2021-03-19'),
(66, 125391, '23:10', 'UTC', '1616195400', 73, 147, 148, '2021-03-18 18:47:31', '2021-03-18 18:47:31', 1, '2021-03-19'),
(67, 125392, '23:15', 'UTC', '1616195700', 74, 149, 150, '2021-03-18 18:47:31', '2021-03-18 18:47:31', 1, '2021-03-19'),
(68, 125393, '23:25', 'UTC', '1616196300', 75, 151, 152, '2021-03-18 18:47:31', '2021-03-18 18:47:31', 1, '2021-03-19'),
(69, 104487, '23:30', 'UTC', '1616196600', 76, 153, 154, '2021-03-18 18:47:31', '2021-03-18 18:47:31', 1, '2021-03-19'),
(70, 108805, '23:30', 'UTC', '1616196600', 77, 155, 156, '2021-03-18 18:47:31', '2021-03-18 18:47:31', 1, '2021-03-19'),
(71, 109719, '23:00', 'UTC', '1616194800', 78, 157, 158, '2021-03-18 20:11:35', '2021-03-18 20:11:35', 2, '2021-03-19'),
(72, 109722, '23:00', 'UTC', '1616194800', 79, 159, 160, '2021-03-18 20:11:35', '2021-03-18 20:11:35', 2, '2021-03-19'),
(73, 109723, '23:00', 'UTC', '1616194800', 80, 161, 162, '2021-03-18 20:11:36', '2021-03-18 20:11:36', 2, '2021-03-19'),
(74, 125398, '16:15', 'UTC', '1616256900', 81, 163, 164, '2021-03-19 20:28:45', '2021-03-19 20:28:45', 1, '2021-03-20'),
(75, 125399, '16:45', 'UTC', '1616258700', 82, 165, 166, '2021-03-19 20:28:46', '2021-03-19 20:28:46', 1, '2021-03-20'),
(76, 125400, '17:15', 'UTC', '1616260500', 83, 167, 168, '2021-03-19 20:28:46', '2021-03-19 20:28:46', 1, '2021-03-20'),
(77, 125401, '17:45', 'UTC', '1616262300', 84, 169, 170, '2021-03-19 20:28:46', '2021-03-19 20:28:46', 1, '2021-03-20'),
(78, 125795, '19:00', 'UTC', '1616266800', 85, 171, 172, '2021-03-19 20:28:46', '2021-03-19 20:28:46', 1, '2021-03-20'),
(79, 108814, '19:30', 'UTC', '1616268600', 86, 173, 174, '2021-03-19 20:28:46', '2021-03-19 20:28:46', 1, '2021-03-20'),
(80, 125402, '19:30', 'UTC', '1616268600', 87, 175, 176, '2021-03-19 20:28:46', '2021-03-19 20:28:46', 1, '2021-03-20'),
(81, 125403, '20:00', 'UTC', '1616270400', 88, 177, 178, '2021-03-19 20:28:47', '2021-03-19 20:28:47', 1, '2021-03-20'),
(82, 125796, '20:30', 'UTC', '1616272200', 89, 179, 180, '2021-03-19 20:28:47', '2021-03-19 20:28:47', 1, '2021-03-20'),
(83, 125404, '22:25', 'UTC', '1616279100', 90, 181, 182, '2021-03-19 20:28:47', '2021-03-19 20:28:47', 1, '2021-03-20'),
(84, 125405, '23:10', 'UTC', '1616281800', 91, 183, 184, '2021-03-19 20:28:47', '2021-03-19 20:28:47', 1, '2021-03-20'),
(85, 125406, '23:15', 'UTC', '1616282100', 92, 185, 186, '2021-03-19 20:28:47', '2021-03-19 20:28:47', 1, '2021-03-20'),
(86, 125407, '23:25', 'UTC', '1616282700', 93, 187, 188, '2021-03-19 20:28:47', '2021-03-19 20:28:47', 1, '2021-03-20'),
(87, 109721, '01:00', 'UTC', '1616202000', 94, 189, 190, '2021-03-19 22:22:07', '2021-03-19 22:22:07', 2, '2021-03-20'),
(88, 109730, '17:00', 'UTC', '1616259600', 95, 191, 192, '2021-03-19 22:22:07', '2021-03-19 22:22:07', 2, '2021-03-20'),
(89, 109736, '17:00', 'UTC', '1616259600', 96, 193, 194, '2021-03-19 22:22:08', '2021-03-19 22:22:08', 2, '2021-03-20'),
(90, 109724, '18:00', 'UTC', '1616263200', 97, 195, 196, '2021-03-19 22:22:08', '2021-03-19 22:22:08', 2, '2021-03-20'),
(91, 109733, '19:00', 'UTC', '1616266800', 98, 197, 198, '2021-03-19 22:22:08', '2021-03-19 22:22:08', 2, '2021-03-20'),
(92, 109728, '20:00', 'UTC', '1616270400', 99, 199, 200, '2021-03-19 22:22:08', '2021-03-19 22:22:08', 2, '2021-03-20'),
(93, 109532, '23:00', 'UTC', '1616281200', 100, 201, 202, '2021-03-19 22:22:08', '2021-03-19 22:22:08', 2, '2021-03-20'),
(94, 109725, '23:00', 'UTC', '1616281200', 101, 203, 204, '2021-03-19 22:22:09', '2021-03-19 22:22:09', 2, '2021-03-20'),
(95, 109726, '23:00', 'UTC', '1616281200', 102, 205, 206, '2021-03-19 22:22:09', '2021-03-19 22:22:09', 2, '2021-03-20'),
(96, 109727, '23:00', 'UTC', '1616281200', 103, 207, 208, '2021-03-19 22:22:09', '2021-03-19 22:22:09', 2, '2021-03-20'),
(97, 109731, '23:00', 'UTC', '1616281200', 104, 209, 210, '2021-03-19 22:22:09', '2021-03-19 22:22:09', 2, '2021-03-20'),
(98, 109734, '23:00', 'UTC', '1616281200', 105, 211, 212, '2021-03-19 22:22:09', '2021-03-19 22:22:09', 2, '2021-03-20'),
(99, 108827, '23:30', 'UTC', '1616455800', 106, 213, 214, '2021-03-21 23:07:14', '2021-03-21 23:07:14', 1, '2021-03-22'),
(100, 109496, '00:30', 'UTC', '1616373000', 107, 215, 216, '2021-03-21 23:07:32', '2021-03-21 23:07:32', 2, '2021-03-22'),
(101, 109738, '23:00', 'UTC', '1616454000', 108, 217, 218, '2021-03-21 23:07:32', '2021-03-21 23:07:32', 2, '2021-03-22'),
(102, 109740, '23:00', 'UTC', '1616454000', 109, 219, 220, '2021-03-21 23:07:32', '2021-03-21 23:07:32', 2, '2021-03-22'),
(103, 109741, '23:00', 'UTC', '1616454000', 110, 221, 222, '2021-03-21 23:07:33', '2021-03-21 23:07:33', 2, '2021-03-22'),
(104, 109742, '23:00', 'UTC', '1616454000', 111, 223, 224, '2021-03-21 23:07:33', '2021-03-21 23:07:33', 2, '2021-03-22'),
(105, 109996, '23:00', 'UTC', '1616454000', 112, 225, 226, '2021-03-21 23:07:33', '2021-03-21 23:07:33', 2, '2021-03-22'),
(106, 109739, '23:30', 'UTC', '1616455800', 113, 227, 228, '2021-03-21 23:07:33', '2021-03-21 23:07:33', 2, '2021-03-22'),
(107, 108835, '23:00', 'UTC', '1616540400', 114, 229, 230, '2021-03-23 02:04:05', '2021-03-23 02:04:05', 1, '2021-03-23'),
(108, 108836, '23:30', 'UTC', '1616542200', 115, 231, 232, '2021-03-23 02:04:05', '2021-03-23 02:04:05', 1, '2021-03-23'),
(109, 108837, '23:30', 'UTC', '1616542200', 116, 233, 234, '2021-03-23 02:04:05', '2021-03-23 02:04:05', 1, '2021-03-23'),
(110, 109746, '23:00', 'UTC', '1616540400', 117, 235, 236, '2021-03-23 02:04:19', '2021-03-23 02:04:19', 2, '2021-03-23'),
(111, 109779, '23:00', 'UTC', '1616540400', 118, 237, 238, '2021-03-23 02:04:19', '2021-03-23 02:04:19', 2, '2021-03-23');

-- --------------------------------------------------------

--
-- Table structure for table `leagues`
--

CREATE TABLE `leagues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `league_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seasons` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leagues`
--

INSERT INTO `leagues` (`id`, `league_id`, `name`, `logo`, `seasons`, `created_at`, `updated_at`) VALUES
(62, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:29', '2021-03-18 18:47:29'),
(63, 12, 'NBA', 'https://media.api-sports.io/basketball/leagues/12.png', '2020-2021', '2021-03-18 18:47:30', '2021-03-18 18:47:30'),
(64, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:30', '2021-03-18 18:47:30'),
(65, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:30', '2021-03-18 18:47:30'),
(66, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:30', '2021-03-18 18:47:30'),
(67, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:30', '2021-03-18 18:47:30'),
(68, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:30', '2021-03-18 18:47:30'),
(69, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:30', '2021-03-18 18:47:30'),
(70, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:31', '2021-03-18 18:47:31'),
(71, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:31', '2021-03-18 18:47:31'),
(72, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:31', '2021-03-18 18:47:31'),
(73, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:31', '2021-03-18 18:47:31'),
(74, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:31', '2021-03-18 18:47:31'),
(75, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-18 18:47:31', '2021-03-18 18:47:31'),
(76, 12, 'NBA', 'https://media.api-sports.io/basketball/leagues/12.png', '2020-2021', '2021-03-18 18:47:31', '2021-03-18 18:47:31'),
(77, 12, 'NBA', 'https://media.api-sports.io/basketball/leagues/12.png', '2020-2021', '2021-03-18 18:47:31', '2021-03-18 18:47:31'),
(78, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-18 20:11:35', '2021-03-18 20:11:35'),
(79, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-18 20:11:35', '2021-03-18 20:11:35'),
(80, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-18 20:11:36', '2021-03-18 20:11:36'),
(81, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:45', '2021-03-19 20:28:45'),
(82, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:46', '2021-03-19 20:28:46'),
(83, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:46', '2021-03-19 20:28:46'),
(84, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:46', '2021-03-19 20:28:46'),
(85, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:46', '2021-03-19 20:28:46'),
(86, 12, 'NBA', 'https://media.api-sports.io/basketball/leagues/12.png', '2020-2021', '2021-03-19 20:28:46', '2021-03-19 20:28:46'),
(87, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:46', '2021-03-19 20:28:46'),
(88, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:47', '2021-03-19 20:28:47'),
(89, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:47', '2021-03-19 20:28:47'),
(90, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:47', '2021-03-19 20:28:47'),
(91, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:47', '2021-03-19 20:28:47'),
(92, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:47', '2021-03-19 20:28:47'),
(93, 116, 'NCAA', 'https://media.api-sports.io/basketball/leagues/116.png', '2020-2021', '2021-03-19 20:28:47', '2021-03-19 20:28:47'),
(94, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:07', '2021-03-19 22:22:07'),
(95, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:07', '2021-03-19 22:22:07'),
(96, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:08', '2021-03-19 22:22:08'),
(97, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:08', '2021-03-19 22:22:08'),
(98, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:08', '2021-03-19 22:22:08'),
(99, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:08', '2021-03-19 22:22:08'),
(100, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:08', '2021-03-19 22:22:08'),
(101, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:09', '2021-03-19 22:22:09'),
(102, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:09', '2021-03-19 22:22:09'),
(103, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:09', '2021-03-19 22:22:09'),
(104, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:09', '2021-03-19 22:22:09'),
(105, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-19 22:22:09', '2021-03-19 22:22:09'),
(106, 12, 'NBA', 'https://media.api-sports.io/basketball/leagues/12.png', '2020-2021', '2021-03-21 23:07:13', '2021-03-21 23:07:13'),
(107, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-21 23:07:32', '2021-03-21 23:07:32'),
(108, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-21 23:07:32', '2021-03-21 23:07:32'),
(109, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-21 23:07:32', '2021-03-21 23:07:32'),
(110, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-21 23:07:33', '2021-03-21 23:07:33'),
(111, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-21 23:07:33', '2021-03-21 23:07:33'),
(112, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-21 23:07:33', '2021-03-21 23:07:33'),
(113, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-21 23:07:33', '2021-03-21 23:07:33'),
(114, 12, 'NBA', 'https://media.api-sports.io/basketball/leagues/12.png', '2020-2021', '2021-03-23 02:04:05', '2021-03-23 02:04:05'),
(115, 12, 'NBA', 'https://media.api-sports.io/basketball/leagues/12.png', '2020-2021', '2021-03-23 02:04:05', '2021-03-23 02:04:05'),
(116, 12, 'NBA', 'https://media.api-sports.io/basketball/leagues/12.png', '2020-2021', '2021-03-23 02:04:05', '2021-03-23 02:04:05'),
(117, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-23 02:04:19', '2021-03-23 02:04:19'),
(118, 57, 'NHL', 'https://media.api-sports.io/hockey/leagues/57.png', '2020', '2021-03-23 02:04:19', '2021-03-23 02:04:19');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2021_03_09_094952_create_roles_table', 1),
(10, '2021_03_09_095017_create_sports_table', 1),
(11, '2021_03_09_095041_create_contacts_table', 1),
(12, '2021_03_09_095058_create_wages_table', 1),
(13, '2021_03_09_141442_create_payments_table', 1),
(14, '2021_03_09_142351_create_transactions_table', 1),
(15, '2021_03_15_212137_create_balances_table', 1),
(16, '2021_03_17_202354_create_admin_transactions_table', 1),
(17, '2021_03_18_210737_create_teams_table', 2),
(18, '2021_03_18_210829_create_leagues_table', 2),
(19, '2021_03_18_213956_create_status_table', 3),
(20, '2021_03_18_214344_create_games_table', 3),
(21, '2021_03_19_002235_create_oddes_table', 4),
(22, '2021_03_19_192153_create_bettings_table', 5),
(23, '2021_03_19_192742_create_oddes_table', 6),
(24, '2021_03_19_210217_create_comments_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0270bd223a4e72fec69251beb64beb96772b8d71da0a59c81bacc6c2e96dcb7fb384b5f649a02756', 3, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', 'authToken', '[]', 0, '2021-03-19 20:25:21', '2021-03-19 20:25:21', '2022-03-20 06:25:21'),
('0b3c58a8fa3a4e91c13a5bb08ab8f63f724da07cad6fa4e2fe7ef3595c13aacb175d5da0574fceeb', 3, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', 'authToken', '[]', 0, '2021-03-23 03:20:55', '2021-03-23 03:20:55', '2022-03-23 13:20:55'),
('607abffcc5f14c83f3006da50f653ffd28870292d9c1873fdaa9a46bd73d50aa8ff1f17084981855', 3, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', 'authToken', '[]', 0, '2021-03-17 10:55:49', '2021-03-17 10:55:49', '2022-03-17 20:55:49'),
('66f5a03da9c39a7b58c442fa17c61214cd67f00e67d699958c8bc619024d3482da28dfb8e6a066a5', 3, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', 'authToken', '[]', 0, '2021-03-19 20:26:31', '2021-03-19 20:26:31', '2022-03-20 06:26:31'),
('8427a68c0b0a60d3173fa3552a9483d6061d8caeabe022a8647aede00f39771348c218fee034255d', 7, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', 'authToken', '[]', 0, '2021-03-19 08:40:18', '2021-03-19 08:40:18', '2022-03-19 18:40:18'),
('92944ab1229e95b6db012127ec5e98f2a81cbe6dd6cfc7f5a6fec49d41206a8b3025cd034d0b24bd', 5, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', 'authToken', '[]', 0, '2021-03-19 08:15:19', '2021-03-19 08:15:19', '2022-03-19 18:15:19'),
('98212c678c08bfffc7803523833619d542bf4a244275f1cd776e7feed27813b5c46839d7054ddd19', 5, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', 'authToken', '[]', 0, '2021-03-18 22:37:25', '2021-03-18 22:37:25', '2022-03-19 08:37:25'),
('9bb3f742843895cc942dff1155cf9467456262e621a61623f69ee7020f1ab9ca20dd3ebc24fd9e0c', 3, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', 'authToken', '[]', 0, '2021-03-21 23:04:40', '2021-03-21 23:04:40', '2022-03-22 09:04:40'),
('da5a87b530406405a3c4e58695000824bb11a209a6bbcdb2a949fa0bc9b047718fbce15a71cf9c35', 3, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', 'authToken', '[]', 0, '2021-03-18 21:34:56', '2021-03-18 21:34:56', '2022-03-19 07:34:56'),
('f0d50caea5e4b5118cd2ceac20cda5dcec36209d8f696c67852b9976a5b1e597984ab0746676e5f5', 3, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', 'authToken', '[]', 0, '2021-03-25 03:39:08', '2021-03-25 03:39:08', '2022-03-25 13:39:08'),
('fe8ecdbd3c1d535328a3a4f390d2ad60a42ab34e8fb1017462d17dfd69f645844f6e5ebdffda5503', 3, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', 'authToken', '[]', 0, '2021-03-17 10:56:22', '2021-03-17 10:56:22', '2022-03-17 20:56:22');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
('92f9c52e-3afd-4c55-84ac-4d8c64c962d4', NULL, 'Laravel Personal Access Client', 'JOGIU8VS6iOAANoVlkN7DoP231e2OIdEEZ4bDLp9', NULL, 'http://localhost', 1, 0, 0, '2021-03-17 10:55:26', '2021-03-17 10:55:26'),
('92f9c52e-6b63-442d-b2b3-dbc064c4dde4', NULL, 'Laravel Password Grant Client', 'Bge0apNH2Pf1B7XqqA0ebkMqJE3wmTaDQd2sSNQu', 'users', 'http://localhost', 0, 1, 0, '2021-03-17 10:55:26', '2021-03-17 10:55:26');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, '92f9c52e-3afd-4c55-84ac-4d8c64c962d4', '2021-03-17 10:55:26', '2021-03-17 10:55:26');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('kingstar@gmail.com', '$2y$10$Nk754lyqLjjxARLhaDeaOeGdQ4xFSBLo4dy1cljT5yRZm5Y4AsJq2', '2021-03-20 13:50:53');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `label`, `created_at`, `updated_at`) VALUES
(1, 'user', 'user', '2021-03-06 12:36:27', '2021-03-06 12:36:27'),
(2, 'admin', 'admin', '2021-03-07 04:28:17', '2021-03-09 18:32:00');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 3, '2021-03-17 10:55:49', '2021-03-17 10:55:49'),
(1, 5, '2021-03-18 22:37:25', '2021-03-18 22:37:25'),
(1, 8, '2021-03-22 15:51:22', '2021-03-22 15:51:22'),
(1, 9, '2021-03-22 15:52:31', '2021-03-22 15:52:31');

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `name`, `url`, `created_at`, `updated_at`) VALUES
(1, 'BasketBall', 'api-basketball.p.rapidapi.com', '2021-03-06 08:28:17', '2021-03-06 08:28:17'),
(2, 'Hockey', 'api-hockey.p.rapidapi.com', '2021-03-06 08:28:17', '2021-03-06 08:28:17'),
(3, 'Score', 'api-football-beta.p.rapidapi.com', '2021-03-06 08:29:59', '2021-03-06 08:29:59'),
(4, 'Baseball', 'api-baseball.p.rapidapi.com', '2021-03-06 08:29:59', '2021-03-06 08:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `odd` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `team_id`, `name`, `logo`, `created_at`, `updated_at`, `odd`, `type`) VALUES
(125, 1995, 'Michigan State', 'https://media.api-sports.io/basketball/teams/1995.png', '2021-03-18 18:47:29', '2021-03-18 18:47:29', '+10', 'home'),
(126, 2166, 'UCLA', 'https://media.api-sports.io/basketball/teams/2166.png', '2021-03-18 18:47:29', '2021-03-18 18:47:29', '-10', 'away'),
(127, 145, 'Los Angeles Lakers', 'https://media.api-sports.io/basketball/teams/145.png', '2021-03-18 18:47:29', '2021-03-18 20:11:17', '+9', 'home'),
(128, 135, 'Charlotte Hornets', 'https://media.api-sports.io/basketball/teams/135.png', '2021-03-18 18:47:29', '2021-03-18 20:11:17', '-9', 'away'),
(129, 1909, 'Florida', 'https://media.api-sports.io/basketball/teams/1909.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '+10', 'home'),
(130, 2190, 'Virginia Tech', 'https://media.api-sports.io/basketball/teams/2190.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '-10', 'away'),
(131, 177, 'Arkansas', 'https://media.api-sports.io/basketball/teams/177.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '+10', 'home'),
(132, 1491, 'Colgate', 'https://media.api-sports.io/basketball/teams/1491.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '-10', 'away'),
(133, 1944, 'Illinois', 'https://media.api-sports.io/basketball/teams/1944.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '+10', 'home'),
(134, 1889, 'Drexel', 'https://media.api-sports.io/basketball/teams/1889.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '-10', 'away'),
(135, 2146, 'Texas Tech', 'https://media.api-sports.io/basketball/teams/2146.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '+10', 'home'),
(136, 2180, 'Utah State', 'https://media.api-sports.io/basketball/teams/2180.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '-10', 'away'),
(137, 2058, 'Ohio State', 'https://media.api-sports.io/basketball/teams/2058.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '+10', 'home'),
(138, 2064, 'Oral Roberts', 'https://media.api-sports.io/basketball/teams/2064.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '-10', 'away'),
(139, 1825, 'Baylor', 'https://media.api-sports.io/basketball/teams/1825.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '+10', 'home'),
(140, 1930, 'Hartford', 'https://media.api-sports.io/basketball/teams/1930.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '-10', 'away'),
(141, 191, 'Loyola Chicago', 'https://media.api-sports.io/basketball/teams/191.png', '2021-03-18 18:47:30', '2021-03-18 18:47:30', '+10', 'home'),
(142, 1926, 'Georgia Tech', 'https://media.api-sports.io/basketball/teams/1926.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '-10', 'away'),
(143, 2141, 'Tennessee', 'https://media.api-sports.io/basketball/teams/2141.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '+10', 'home'),
(144, 2066, 'Oregon State', 'https://media.api-sports.io/basketball/teams/2066.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '-10', 'away'),
(145, 2060, 'Oklahoma State', 'https://media.api-sports.io/basketball/teams/2060.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '+10', 'home'),
(146, 1972, 'Liberty', 'https://media.api-sports.io/basketball/teams/1972.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '-10', 'away'),
(147, 2039, 'North Carolina', 'https://media.api-sports.io/basketball/teams/2039.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '+10', 'home'),
(148, 2214, 'Wisconsin', 'https://media.api-sports.io/basketball/teams/2214.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '-10', 'away'),
(149, 1938, 'Houston', 'https://media.api-sports.io/basketball/teams/1938.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '+10', 'home'),
(150, 1867, 'Cleveland State', 'https://media.api-sports.io/basketball/teams/1867.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '-10', 'away'),
(151, 2085, 'Purdue', 'https://media.api-sports.io/basketball/teams/2085.png', '2021-03-18 18:47:31', '2021-03-18 21:20:21', '+8', 'home'),
(152, 1496, 'North Texas', 'https://media.api-sports.io/basketball/teams/1496.png', '2021-03-18 18:47:31', '2021-03-19 07:48:06', '-8', 'away'),
(153, 137, 'Cleveland Cavaliers', 'https://media.api-sports.io/basketball/teams/137.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '+10', 'home'),
(154, 158, 'San Antonio Spurs', 'https://media.api-sports.io/basketball/teams/158.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '-10', 'away'),
(155, 133, 'Boston Celtics', 'https://media.api-sports.io/basketball/teams/133.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '+10', 'home'),
(156, 157, 'Sacramento Kings', 'https://media.api-sports.io/basketball/teams/157.png', '2021-03-18 18:47:31', '2021-03-18 18:47:31', '-10', 'away'),
(157, 688, 'Montreal Canadiens', 'https://media.api-sports.io/hockey/teams/688.png', '2021-03-18 20:11:35', '2021-03-18 20:11:35', '+10', 'home'),
(158, 701, 'Vancouver Canucks', 'https://media.api-sports.io/hockey/teams/701.png', '2021-03-18 20:11:35', '2021-03-18 20:11:35', '-10', 'away'),
(159, 700, 'Toronto Maple Leafs', 'https://media.api-sports.io/hockey/teams/700.png', '2021-03-18 20:11:35', '2021-03-18 20:11:35', '+10', 'home'),
(160, 675, 'Calgary Flames', 'https://media.api-sports.io/hockey/teams/675.png', '2021-03-18 20:11:35', '2021-03-18 20:11:35', '-10', 'away'),
(161, 703, 'Washington Capitals', 'https://media.api-sports.io/hockey/teams/703.png', '2021-03-18 20:11:35', '2021-03-18 20:11:35', '+10', 'home'),
(162, 692, 'New York Rangers', 'https://media.api-sports.io/hockey/teams/692.png', '2021-03-18 20:11:35', '2021-03-18 20:11:35', '-10', 'away'),
(163, 181, 'Colorado', 'https://media.api-sports.io/basketball/teams/181.png', '2021-03-19 20:28:45', '2021-03-19 20:28:45', '+10', 'home'),
(164, 186, 'Georgetown', 'https://media.api-sports.io/basketball/teams/186.png', '2021-03-19 20:28:45', '2021-03-19 20:28:45', '-10', 'away'),
(165, 1914, 'Florida State', 'https://media.api-sports.io/basketball/teams/1914.png', '2021-03-19 20:28:45', '2021-03-19 20:28:45', '+10', 'home'),
(166, 193, 'NC Greensboro', 'https://media.api-sports.io/basketball/teams/193.png', '2021-03-19 20:28:46', '2021-03-19 20:28:46', '-10', 'away'),
(167, 1959, 'Kansas', 'https://media.api-sports.io/basketball/teams/1959.png', '2021-03-19 20:28:46', '2021-03-19 20:28:46', '+10', 'home'),
(168, 1492, 'East. Washington', 'https://media.api-sports.io/basketball/teams/1492.png', '2021-03-19 20:28:46', '2021-03-19 20:28:46', '-10', 'away'),
(169, 1967, 'LSU', 'https://media.api-sports.io/basketball/teams/1967.png', '2021-03-19 20:28:46', '2021-03-19 20:28:46', '+10', 'home'),
(170, 2125, 'St. Bonaventure', 'https://media.api-sports.io/basketball/teams/2125.png', '2021-03-19 20:28:46', '2021-03-19 20:28:46', '-10', 'away'),
(171, 1994, 'Michigan', 'https://media.api-sports.io/basketball/teams/1994.png', '2021-03-19 20:28:46', '2021-03-19 20:28:46', '+10', 'home'),
(172, 246, 'Texas Southern', 'https://media.api-sports.io/basketball/teams/246.png', '2021-03-19 20:28:46', '2021-03-19 20:28:46', '-10', 'away'),
(173, 145, 'Los Angeles Lakers', 'https://media.api-sports.io/basketball/teams/145.png', '2021-03-19 20:28:46', '2021-03-19 20:28:46', '+10', 'home'),
(174, 132, 'Atlanta Hawks', 'https://media.api-sports.io/basketball/teams/132.png', '2021-03-19 20:28:46', '2021-03-19 20:28:46', '-10', 'away'),
(175, 182, 'Creighton', 'https://media.api-sports.io/basketball/teams/182.png', '2021-03-19 20:28:46', '2021-03-19 20:28:46', '+10', 'home'),
(176, 2164, 'UC Santa Barbara', 'https://media.api-sports.io/basketball/teams/2164.png', '2021-03-19 20:28:46', '2021-03-19 20:28:46', '-10', 'away'),
(177, 176, 'Alabama', 'https://media.api-sports.io/basketball/teams/176.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '+10', 'home'),
(178, 1949, 'Iona', 'https://media.api-sports.io/basketball/teams/1949.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '-10', 'away'),
(179, 2172, 'USC', 'https://media.api-sports.io/basketball/teams/2172.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '+10', 'home'),
(180, 228, 'Drake', 'https://media.api-sports.io/basketball/teams/228.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '-10', 'away'),
(181, 1950, 'Iowa', 'https://media.api-sports.io/basketball/teams/1950.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '+10', 'home'),
(182, 214, 'Grand Canyon', 'https://media.api-sports.io/basketball/teams/214.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '-10', 'away'),
(183, 2179, 'UConn', 'https://media.api-sports.io/basketball/teams/2179.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '+10', 'home'),
(184, 1985, 'Maryland', 'https://media.api-sports.io/basketball/teams/1985.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '-10', 'away'),
(185, 2189, 'Virginia', 'https://media.api-sports.io/basketball/teams/2189.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '+10', 'home'),
(186, 2057, 'Ohio', 'https://media.api-sports.io/basketball/teams/2057.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '-10', 'away'),
(187, 2059, 'Oklahoma', 'https://media.api-sports.io/basketball/teams/2059.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '+10', 'home'),
(188, 2006, 'Missouri', 'https://media.api-sports.io/basketball/teams/2006.png', '2021-03-19 20:28:47', '2021-03-19 20:28:47', '-10', 'away'),
(189, 697, 'San Jose Sharks', 'https://media.api-sports.io/hockey/teams/697.png', '2021-03-19 22:22:07', '2021-03-19 22:22:07', '+10', 'home'),
(190, 698, 'St. Louis Blues', 'https://media.api-sports.io/hockey/teams/698.png', '2021-03-19 22:22:07', '2021-03-19 22:22:07', '-10', 'away'),
(191, 674, 'Buffalo Sabres', 'https://media.api-sports.io/hockey/teams/674.png', '2021-03-19 22:22:07', '2021-03-19 22:22:07', '+10', 'home'),
(192, 673, 'Boston Bruins', 'https://media.api-sports.io/hockey/teams/673.png', '2021-03-19 22:22:07', '2021-03-19 22:22:07', '-10', 'away'),
(193, 690, 'New Jersey Devils', 'https://media.api-sports.io/hockey/teams/690.png', '2021-03-19 22:22:08', '2021-03-19 22:22:08', '+10', 'home'),
(194, 696, 'Pittsburgh Penguins', 'https://media.api-sports.io/hockey/teams/696.png', '2021-03-19 22:22:08', '2021-03-19 22:22:08', '-10', 'away'),
(195, 684, 'Florida Panthers', 'https://media.api-sports.io/hockey/teams/684.png', '2021-03-19 22:22:08', '2021-03-19 22:22:08', '+10', 'home'),
(196, 689, 'Nashville Predators', 'https://media.api-sports.io/hockey/teams/689.png', '2021-03-19 22:22:08', '2021-03-19 22:22:08', '-10', 'away'),
(197, 679, 'Colorado Avalanche', 'https://media.api-sports.io/hockey/teams/679.png', '2021-03-19 22:22:08', '2021-03-19 22:22:08', '+10', 'home'),
(198, 687, 'Minnesota Wild', 'https://media.api-sports.io/hockey/teams/687.png', '2021-03-19 22:22:08', '2021-03-19 22:22:08', '-10', 'away'),
(199, 699, 'Tampa Bay Lightning', 'https://media.api-sports.io/hockey/teams/699.png', '2021-03-19 22:22:08', '2021-03-19 22:22:08', '+10', 'home'),
(200, 678, 'Chicago Blackhawks', 'https://media.api-sports.io/hockey/teams/678.png', '2021-03-19 22:22:08', '2021-03-19 22:22:08', '-10', 'away'),
(201, 703, 'Washington Capitals', 'https://media.api-sports.io/hockey/teams/703.png', '2021-03-19 22:22:08', '2021-03-19 22:22:08', '+10', 'home'),
(202, 692, 'New York Rangers', 'https://media.api-sports.io/hockey/teams/692.png', '2021-03-19 22:22:08', '2021-03-19 22:22:08', '-10', 'away'),
(203, 700, 'Toronto Maple Leafs', 'https://media.api-sports.io/hockey/teams/700.png', '2021-03-19 22:22:09', '2021-03-19 22:22:09', '+10', 'home'),
(204, 675, 'Calgary Flames', 'https://media.api-sports.io/hockey/teams/675.png', '2021-03-19 22:22:09', '2021-03-19 22:22:09', '-10', 'away'),
(205, 691, 'New York Islanders', 'https://media.api-sports.io/hockey/teams/691.png', '2021-03-19 22:22:09', '2021-03-19 22:22:09', '+10', 'home'),
(206, 695, 'Philadelphia Flyers', 'https://media.api-sports.io/hockey/teams/695.png', '2021-03-19 22:22:09', '2021-03-19 22:22:09', '-10', 'away'),
(207, 688, 'Montreal Canadiens', 'https://media.api-sports.io/hockey/teams/688.png', '2021-03-19 22:22:09', '2021-03-19 22:22:09', '+10', 'home'),
(208, 701, 'Vancouver Canucks', 'https://media.api-sports.io/hockey/teams/701.png', '2021-03-19 22:22:09', '2021-03-19 22:22:09', '-10', 'away'),
(209, 682, 'Detroit Red Wings', 'https://media.api-sports.io/hockey/teams/682.png', '2021-03-19 22:22:09', '2021-03-19 22:22:09', '+10', 'home'),
(210, 681, 'Dallas Stars', 'https://media.api-sports.io/hockey/teams/681.png', '2021-03-19 22:22:09', '2021-03-19 22:22:09', '-10', 'away'),
(211, 676, 'Carolina Hurricanes', 'https://media.api-sports.io/hockey/teams/676.png', '2021-03-19 22:22:09', '2021-03-19 22:22:09', '+10', 'home'),
(212, 680, 'Columbus Blue Jackets', 'https://media.api-sports.io/hockey/teams/680.png', '2021-03-19 22:22:09', '2021-03-19 22:22:09', '-10', 'away'),
(213, 137, 'Cleveland Cavaliers', 'https://media.api-sports.io/basketball/teams/137.png', '2021-03-21 23:07:13', '2021-03-21 23:07:13', '+10', 'home'),
(214, 157, 'Sacramento Kings', 'https://media.api-sports.io/basketball/teams/157.png', '2021-03-21 23:07:13', '2021-03-21 23:07:13', '-10', 'away'),
(215, 681, 'Dallas Stars', 'https://media.api-sports.io/hockey/teams/681.png', '2021-03-21 23:07:32', '2021-03-21 23:07:32', '+10', 'home'),
(216, 689, 'Nashville Predators', 'https://media.api-sports.io/hockey/teams/689.png', '2021-03-21 23:07:32', '2021-03-21 23:07:32', '-10', 'away'),
(217, 680, 'Columbus Blue Jackets', 'https://media.api-sports.io/hockey/teams/680.png', '2021-03-21 23:07:32', '2021-03-21 23:07:32', '+10', 'home'),
(218, 676, 'Carolina Hurricanes', 'https://media.api-sports.io/hockey/teams/676.png', '2021-03-21 23:07:32', '2021-03-21 23:07:32', '-10', 'away'),
(219, 688, 'Montreal Canadiens', 'https://media.api-sports.io/hockey/teams/688.png', '2021-03-21 23:07:32', '2021-03-21 23:07:32', '+10', 'home'),
(220, 683, 'Edmonton Oilers', 'https://media.api-sports.io/hockey/teams/683.png', '2021-03-21 23:07:32', '2021-03-21 23:07:32', '-10', 'away'),
(221, 692, 'New York Rangers', 'https://media.api-sports.io/hockey/teams/692.png', '2021-03-21 23:07:32', '2021-03-21 23:07:32', '+10', 'home'),
(222, 674, 'Buffalo Sabres', 'https://media.api-sports.io/hockey/teams/674.png', '2021-03-21 23:07:32', '2021-03-21 23:07:32', '-10', 'away'),
(223, 693, 'Ottawa Senators', 'https://media.api-sports.io/hockey/teams/693.png', '2021-03-21 23:07:33', '2021-03-21 23:07:33', '+10', 'home'),
(224, 675, 'Calgary Flames', 'https://media.api-sports.io/hockey/teams/675.png', '2021-03-21 23:07:33', '2021-03-21 23:07:33', '-10', 'away'),
(225, 695, 'Philadelphia Flyers', 'https://media.api-sports.io/hockey/teams/695.png', '2021-03-21 23:07:33', '2021-03-21 23:07:33', '+10', 'home'),
(226, 691, 'New York Islanders', 'https://media.api-sports.io/hockey/teams/691.png', '2021-03-21 23:07:33', '2021-03-21 23:07:33', '-10', 'away'),
(227, 687, 'Minnesota Wild', 'https://media.api-sports.io/hockey/teams/687.png', '2021-03-21 23:07:33', '2021-03-21 23:07:33', '+10', 'home'),
(228, 670, 'Anaheim Ducks', 'https://media.api-sports.io/hockey/teams/670.png', '2021-03-21 23:07:33', '2021-03-21 23:07:33', '-10', 'away'),
(229, 153, 'Orlando Magic', 'https://media.api-sports.io/basketball/teams/153.png', '2021-03-23 02:04:04', '2021-03-23 02:04:04', '+10', 'home'),
(230, 139, 'Denver Nuggets', 'https://media.api-sports.io/basketball/teams/139.png', '2021-03-23 02:04:04', '2021-03-23 02:04:04', '-10', 'away'),
(231, 150, 'New Orleans Pelicans', 'https://media.api-sports.io/basketball/teams/150.png', '2021-03-23 02:04:05', '2021-03-23 02:04:05', '+10', 'home'),
(232, 145, 'Los Angeles Lakers', 'https://media.api-sports.io/basketball/teams/145.png', '2021-03-23 02:04:05', '2021-03-23 02:04:05', '-10', 'away'),
(233, 151, 'New York Knicks', 'https://media.api-sports.io/basketball/teams/151.png', '2021-03-23 02:04:05', '2021-03-23 02:04:05', '+10', 'home'),
(234, 161, 'Washington Wizards', 'https://media.api-sports.io/basketball/teams/161.png', '2021-03-23 02:04:05', '2021-03-23 02:04:05', '-10', 'away'),
(235, 695, 'Philadelphia Flyers', 'https://media.api-sports.io/hockey/teams/695.png', '2021-03-23 02:04:18', '2021-03-23 02:04:18', '+10', 'home'),
(236, 690, 'New Jersey Devils', 'https://media.api-sports.io/hockey/teams/690.png', '2021-03-23 02:04:19', '2021-03-23 02:04:19', '-10', 'away'),
(237, 673, 'Boston Bruins', 'https://media.api-sports.io/hockey/teams/673.png', '2021-03-23 02:04:19', '2021-03-23 02:04:19', '+10', 'home'),
(238, 691, 'New York Islanders', 'https://media.api-sports.io/hockey/teams/691.png', '2021-03-23 02:04:19', '2021-03-23 02:04:19', '-10', 'away');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `fee` float NOT NULL DEFAULT 0,
  `type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `amount`, `fee`, `type`, `created_at`, `updated_at`) VALUES
(15, 3, 969.9, 0.8, 3, '2021-03-20 00:32:34', '2021-03-20 00:32:34'),
(16, 3, 1940.9, 0.8, 3, '2021-03-20 00:57:33', '2021-03-20 00:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` float NOT NULL DEFAULT 0,
  `type` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_verify` tinyint(1) NOT NULL DEFAULT 0,
  `payment_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` int(30) NOT NULL,
  `notification` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `balance`, `type`, `email_verified_at`, `password`, `payment_verify`, `payment_email`, `remember_token`, `created_at`, `updated_at`, `avatar`, `device_token`, `notification`) VALUES
(3, 'King', 'Star', 'kingstar@gmail.com', 2910.8, 'user', NULL, '$2y$10$W4o9z.87qxhWYUHs42dHxeMRLgXFbQkDPmm2cQjaqKXdKIznDfImq', 1, 'piggy@outlook.com', NULL, '2021-03-17 10:55:48', '2021-03-25 03:39:06', 'assets/profile/60567f47385c0.jpg', 123123, 0),
(4, 'King', 'Toyota', 'toyota@gmail.com', 0, 'admin', NULL, '$2y$10$Jn3Y/WwqLYERic0rAJfzy.vKilprJhIRBEiKjXdvEgCYe2rSkPgIS', 0, NULL, NULL, '2021-03-18 09:44:21', '2021-03-20 14:32:50', 'assets/profile/6056943236b8c.jpg', 0, 0),
(5, 'King', 'Star', 'piggy@gmail.com', 0, 'user', NULL, '$2y$10$othXfLj8c2CGZcUKowFOxOMLxlPlqrFcQcELqiqVSGjUdByA7ksXe', 0, NULL, NULL, '2021-03-18 22:37:24', '2021-03-18 22:37:24', NULL, 0, 0),
(6, 'King', 'Star', 'ddd@gmail.com', 0, 'user', NULL, '$2y$10$CO7Do9y0x3bF.MAwJjhJmuSnTL8Eh5aySyud42Y4cdlmCg6tOr196', 0, NULL, NULL, '2021-03-19 08:39:18', '2021-03-19 08:39:18', NULL, 0, 0),
(8, 'King', 'Star', 'lca@rante.com', 0, 'user', NULL, '$2y$10$z/WYzkTwItDKINnWe0ZM8ecDG/rf5WTfW3zsITh3RLKxoEgnBCZn2', 0, NULL, NULL, '2021-03-22 15:51:22', '2021-03-22 15:51:22', NULL, 12345, 0),
(9, 'King', 'Star1', 'admin@gmail.com', 0, 'user', NULL, '$2y$10$b.c8FZj4crjrM2e8FYs3seOe7TUVphC6swwlf1Ois1lhrtoHSTGom', 0, NULL, NULL, '2021-03-22 15:52:31', '2021-03-22 15:52:31', NULL, 12345, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wages`
--

CREATE TABLE `wages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_id` int(11) NOT NULL,
  `sport_id` int(11) NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wages`
--

INSERT INTO `wages` (`id`, `game_id`, `sport_id`, `amount`, `status`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 74, 1, '15', 3, '2021-03-19 20:38:25', '2021-03-19 20:57:05', 3),
(4, 74, 1, '15', 0, '2021-03-19 20:41:41', '2021-03-19 20:41:41', 3),
(6, 99, 1, '15', 0, '2021-03-21 23:15:10', '2021-03-21 23:15:10', 3),
(7, 99, 1, '15', 0, '2021-03-21 23:18:05', '2021-03-21 23:18:05', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bettings`
--
ALTER TABLE `bettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contacts_owner_id_unique` (`owner_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leagues`
--
ALTER TABLE `leagues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sports_name_unique` (`name`),
  ADD UNIQUE KEY `sports_url_unique` (`url`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wages`
--
ALTER TABLE `wages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bettings`
--
ALTER TABLE `bettings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `leagues`
--
ALTER TABLE `leagues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wages`
--
ALTER TABLE `wages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
