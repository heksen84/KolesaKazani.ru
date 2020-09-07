-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 07 2020 г., 17:11
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.2.22

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
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(40) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `keywords` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `url`, `title`, `description`, `keywords`) VALUES
(1, 'Транспорт', 'transport', 'Транспорт в @place', 'Покупка, продажа и обмен транспорта в @place', 'покупка, продажа, обмен, транспорт'),
(2, 'Недвижимость', 'nedvizhimost', 'Недвижимость в @place', 'Покупка, продажа и обмен недвижимости в @place', 'покупка, продажа, обмен, недвижимость'),
(3, 'Электроника', 'elektronika', 'Электроника в @place', 'Покупка, продажа и обмен электроники в @place', 'покупка, продажа, обмен, электроника'),
(4, 'Работа и бизнес', 'rabota-i-biznes', 'Работа и бизнес в @place', 'Предложения по работе и бизнесу в @place', 'предложения, работа, бизнес'),
(5, 'Для дома и дачи', 'dlya-doma-i-dachi', 'Для дома и дачи в @place', 'Покупка, продажа и обмен товаров для дома и дачи в @place', 'покупка, продажа, обмен, дом, дача'),
(6, 'Личные вещи', 'lichnye-veschi', 'Личные вещи в @place', 'Покупка, продажа и обмен личными вещами в @place', 'покупка, продажа, обмен, личные вещи'),
(7, 'Животные', 'zhivotnye', 'Животные в @place', 'Покупка, продажа и обмен животными в @place', 'покупка, продажа, обмен, животные'),
(8, 'Хобби и отдых', 'hobbi-i-otdyh', 'Хобби и отдых в @place', 'Покупка, продажа и обмен личными вещами для хобби и отдыха в @place', 'покупка, продажа, обмен, хобби, отдых'),
(9, 'Услуги', 'uslugi', 'Услуги в @place', 'Различные услуги в @place', 'различные услуги'),
(10, 'Знакомства', 'znakomstva', 'Знакомства в @place', 'Знакомства в @place', 'знакомства, познакомлюсь, свидание, встреча, любовь, секс');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
