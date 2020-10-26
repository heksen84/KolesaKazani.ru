-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 26 2020 г., 15:13
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `flix`
--

-- --------------------------------------------------------

--
-- Структура таблицы `socials`
--

CREATE TABLE `socials` (
  `id` int(10) UNSIGNED NOT NULL,
  `region_id` int(2) UNSIGNED ZEROFILL NOT NULL,
  `place_id` int(3) DEFAULT NULL,
  `insta_login` varchar(16) CHARACTER SET utf8 NOT NULL,
  `insta_pass` varchar(16) CHARACTER SET utf8 NOT NULL,
  `vk_login` varchar(16) CHARACTER SET utf8 NOT NULL,
  `vk_pass` varchar(16) CHARACTER SET utf8 NOT NULL,
  `ok_login` varchar(16) CHARACTER SET utf8 NOT NULL,
  `ok_pass` varchar(16) CHARACTER SET utf8 NOT NULL,
  `hash_tag` varchar(30) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `socials`
--

INSERT INTO `socials` (`id`, `region_id`, `place_id`, `insta_login`, `insta_pass`, `vk_login`, `vk_pass`, `ok_login`, `ok_pass`, `hash_tag`) VALUES
(1, 11, 50, 'test_site68', 'morphosis19', '', '', '', '', '#ilbo_aksu');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `region_id` (`region_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `socials`
--
ALTER TABLE `socials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
