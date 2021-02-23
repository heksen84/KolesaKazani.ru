-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 23 2021 г., 19:43
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
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(40) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `h1` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `url`, `title`, `description`, `keywords`, `h1`) VALUES
(1, 'Транспорт', 'transport', 'Транспорт в @place', 'Покупка, продажа и сдача в аренду транспорта в @place', '', 'Транспорт в @place'),
(2, 'Недвижимость', 'nedvizhimost', 'Недвижимость в @place', 'Покупка, продажа и сдача в аренду недвижимости в @place', '', 'Недвижимость в @place'),
(3, 'Электроника', 'elektronika', 'Электроника в @place', 'Покупка, продажа и сдача в аренду электроники в @place', '', 'Электроника в @place'),
(4, 'Работа и бизнес', 'rabota-i-biznes', 'Работа и бизнес в @place', 'Предложения по работе и бизнесу в @place', '', 'Работа и бизнес в @place'),
(5, 'Для дома и дачи', 'dlya-doma-i-dachi', 'Сдача в аренду в @place', 'Покупка, продажа и сдача в аренду товаров для дома и дачи в @place', '', 'Товары для дома и дачи в @place'),
(6, 'Личные вещи', 'lichnye-veschi', 'Личные вещи в @place', 'Покупка, продажа и сдача в аренду личных вещей в @place', '', 'Личные вещи в @place'),
(7, 'Животные', 'zhivotnye', 'Животные в @place', 'Покупка и продажа животных в @place', '', 'Животные в @place'),
(8, 'Хобби и отдых', 'hobbi-i-otdyh', 'Хобби и отдых в @place', 'Покупка, продажа и сдача в аренду вещей для хобби и отдыха в @place', '', 'Хобби и отдых в @place'),
(9, 'Услуги', 'uslugi', 'Различные услуги в @place', 'Различные услуги в @place', '', 'Услуги в @place'),
(10, 'Знакомства', 'znakomstva', 'Знакомства в @place', 'Знакомства в @place', '', 'Знакомства в @place');

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
