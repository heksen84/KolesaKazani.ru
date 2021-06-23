-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 23 2021 г., 15:21
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
(1, 'Транспорт', 'transport', 'Куплю или продам транспорт в @place', 'Покупка, продажа и сдача в аренду транспорта в @place', '', '@category в @place'),
(2, 'Недвижимость', 'nedvizhimost', 'Куплю или продам недвижимость в @place', 'Покупка, продажа и сдача в аренду недвижимости в @place', '', '@category в @place'),
(3, 'Электроника', 'elektronika', 'Куплю или продам электронику в @place', 'Покупка, продажа и сдача в аренду электроники в @place', '', '@category в @place'),
(4, 'Работа и бизнес', 'rabota-i-biznes', 'Поиск работы в @place', 'Предложения по работе и бизнесу в @place', '', '@category в @place'),
(5, 'Для дома и дачи', 'dlya-doma-i-dachi', 'Куплю или продам всё для дома и дачи в @place', 'Покупка, продажа и сдача в аренду товаров для дома и дачи в @place', '', '@category в @place'),
(6, 'Личные вещи', 'lichnye-veschi', 'Куплю или продам личные вещи в @place', 'Покупка, продажа и сдача в аренду личных вещей в @place', '', '@category в @place'),
(7, 'Животные', 'zhivotnye', 'Куплю или продам животное в @place', 'Покупка и продажа животных в @place', '', '@category в @place'),
(8, 'Хобби и отдых', 'hobbi-i-otdyh', 'Куплю или продам вещи для хобби и отдыха в @place', 'Покупка, продажа и сдача в аренду вещей для хобби и отдыха в @place', '', '@category в @place'),
(9, 'Услуги', 'uslugi', 'Окажу услуги в @place', 'Различные услуги в @place', '', '@category в @place'),
(10, 'Знакомства', 'znakomstva', 'Познакомлюсь в @place', 'Знакомства в @place', '', '@category в @place');

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
