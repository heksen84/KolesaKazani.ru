-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 03 2020 г., 14:16
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
-- Структура таблицы `subcats`
--

CREATE TABLE `subcats` (
  `id` int(2) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `url` varchar(60) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `h1` varchar(60) NOT NULL,
  `category_id` int(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subcats`
--

INSERT INTO `subcats` (`id`, `name`, `url`, `title`, `description`, `keywords`, `h1`, `category_id`) VALUES
(1, 'Легковой автомобиль', 'legkovoy-avtomobil', 'Покупка, продажа и сдача в аренду легкового авто в @place', 'Покупка, продажа и сдача в аренду легкового авто в @place', '', 'Легковой транспорт в @place', 1),
(2, 'Грузовой автомобиль', 'gruzovoy-avtomobil', 'Покупка, продажа и сдача в аренду грузового авто в @place', 'Покупка, продажа и сдача в аренду грузового авто в @place', '', 'Грузовой транспорт в @place', 1),
(3, 'Мототехника', 'mototehnika', 'Покупка, продажа и сдача в аренду мототехники в @place', 'Покупка, продажа и сдача в аренду мототехники в @place', '', 'Мототехника в @place', 1),
(4, 'Спецтехника', 'spectehnika', 'Покупка, продажа и сдача в аренду спецтехники в @place', 'Покупка, продажа и сдача в аренду спецтехники в @place', '', 'Спецтехника в @place', 1),
(5, 'Ретро-автомобиль', 'retro-avtomobil', 'Покупка, продажа и сдача в аренду ретро авто в @place', 'Покупка, продажа и сдача в аренду ретро авто в @place', '', 'Ретро транспорт в @place', 1),
(6, 'Водный транспорт', 'vodnyy-transport', 'Покупка, продажа и сдача в аренду водного транспорта в @place', 'Покупка, продажа и сдача в аренду водного транспорта в @place', '', 'Водный транспорт в @place', 1),
(7, 'Велосипед', 'velosiped', 'Покупка, продажа и сдача в аренду велосипедов в @place', 'Покупка, продажа и сдача в аренду велосипедов в @place', '', 'Вело-транспорт в @place', 1),
(8, 'Воздушный транспорт', 'vozdushnyy-transport', 'Покупка, продажа и сдача в аренду воздушного транспорта в @place', 'Покупка, продажа и сдача в аренду воздушного транспорта в @place', '', 'Воздушный транспорт в @place', 1),
(9, 'Квартира', 'kvartira', 'Покупка, продажа и сдача в аренду квартир в @place', 'Покупка, продажа и сдача в аренду квартир в @place', '', 'Квартиры в @place', 2),
(10, 'Комната', 'komnata', 'Покупка, продажа и сдача в аренду комнат в @place', 'Покупка, продажа и сдача в аренду комнат в @place', '', 'Комнаты в @place', 2),
(11, 'Дом, дача, коттедж', 'dom-dacha-kottedzh', 'Покупка, продажа и сдача в аренду дома, дачи, коттеджа в @place', 'Покупка, продажа и сдача в аренду дома, дачи, коттеджа в @place', '', 'Дома, дачи, коттеджи в @place', 2),
(12, 'Земельный участок', 'zemelnyy-uchastok', 'Покупка, продажа и сдача в аренду земельных участков в @place', 'Покупка, продажа и сдача в аренду земельных участков в @place', '', 'Земельные участки в @place', 2),
(13, 'Гараж или машиноместо', 'garazh-ili-mashinomesto', 'Покупка, продажа и сдача в аренду гаражей или машиномест в @place', 'Покупка, продажа и сдача в аренду гаражей или машиномест в @place', '', 'Гараж или машиноместо в @place', 2),
(14, 'Коммерческая недвижимость', 'kommercheskaya-nedvizhimost', 'Покупка, продажа и сдача в аренду коммерческой недвижимости в @place', 'Покупка, продажа и сдача в аренду коммерческой недвижимости в @place', '', 'Коммерческая недвижимость в @place', 2),
(15, 'Недвижимость за рубежом', 'nedvizhimost-za-rubezhom', 'Покупка, продажа и сдача в аренду недвижимости за рубежом в @place', 'Покупка, продажа и сдача в аренду недвижимости за рубежом в @place', '', 'Недвижимость за рубежом', 2),
(16, 'Аудио и видео', 'audio-i-video', 'Покупка, продажа и сдача в аренду аудио и видео техники в @place', 'Покупка, продажа и сдача в аренду аудио и видео техники в @place', '', 'Аудио и видео в @place', 3),
(17, 'Игры, приставки и программы', 'igry-pristavki-i-programmy', 'Покупка, продажа и сдача в аренду игр, приставок и программ в @place', 'Покупка, продажа и сдача в аренду игр, приставок и программ в @place', '', 'Игры, приставки и программы в @place', 3),
(18, 'Настольные компьютеры', 'nastolnye-kompyutery', 'Покупка, продажа и сдача в аренду настольных компьютеров в @place', 'Покупка, продажа и сдача в аренду настольных компьютеров в @place', '', 'Настольные компьютеры в @place', 3),
(19, 'Ноутбуки', 'noutbuki', 'Покупка, продажа и сдача в аренду ноутбуков в @place', 'Покупка, продажа и сдача в аренду ноутбуков в @place', '', 'Ноутбуки в @place', 3),
(20, 'Оргтехника и расходники', 'orgtehnika-i-rashodniki', 'Покупка, продажа и сдача в аренду оргтехники и расходных материалов в @place', 'Покупка, продажа и сдача в аренду оргтехники и расходных материалов в @place', '', 'Оргтехника и расходники в @place', 3),
(21, 'Планшеты и электронные книги', 'planshety-i-elektronnye-knigi', 'Покупка, продажа и сдача в аренду планшетов и электронных книг в @place', 'Покупка, продажа и сдача в аренду планшетов и электронных книг в @place', '', 'Планшеты и электронные книги в @place', 3),
(22, 'Телефоны и гаджеты', 'telefony-i-gadzhety', 'Покупка, продажа и сдача в аренду смартфонов, телефонов и различных гаджетов в @place', 'Покупка, продажа и сдача в аренду смартфонов, телефонов и различных гаджетов в @place', '', 'Телефоны и гаджеты в @place', 3),
(23, 'Товары для компьютера', 'tovary-dlya-kompyutera', 'Покупка, продажа и сдача в аренду товаров для компьютеров в @place', 'Покупка, продажа и сдача в аренду товаров для компьютеров в @place', '', 'Товары для компьютера в @place', 3),
(24, 'Фототехника', 'fototehnika', 'Покупка, продажа и сдача в аренду фототехники в @place', 'Покупка, продажа и сдача в аренду фототехники в @place', '', 'Фототехника в @place', 3),
(25, 'Вакансии', 'vakansii', 'Свежие вакансии в @place', 'Свежие вакансии в @place', '', 'Вакансии в @place', 4),
(26, 'Резюме', 'rezyume', 'Свежие резюме в @place', 'Свежие резюме в @place', '', 'Резюме в @place', 4),
(27, 'Бытовая техника', 'bytovaya-tehnika', 'Покупка, продажа и сдача в аренду бытовой техники в @place', 'Покупка, продажа и сдача в аренду бытовой техники в @place', '', 'Бытовая техника в @place', 5),
(28, 'Мебель и интерьер', 'mebel-i-interer', 'Покупка, продажа и сдача в аренду мебели и товаров для интерьера в @place', 'Покупка, продажа и сдача в аренду мебели и товаров для интерьера в @place', '', 'Мебель и интерьер в @place', 5),
(29, 'Посуда и товары для кухни', 'posuda-i-tovary-dlya-kuhni', 'Покупка, продажа и сдача в аренду посуды и товаров для кухни в @place', 'Покупка, продажа и сдача в аренду посуды и товаров для кухни в @place', '', 'Посуда и товары для кухни в @place', 5),
(30, 'Продукты питания', 'produkty-pitaniya', 'Покупка, продажа продуктов питания в @place', 'Покупка, продажа продуктов питания в @place', '', 'Продукты питания в @place', 5),
(31, 'Ремонт и строительство', 'remont-i-stroitelstvo', 'Покупка, продажа и сдача в аренду товаров для ремонта и строительства в @place', 'Покупка, продажа и сдача в аренду товаров для ремонта и строительства в @place', '', 'Ремонт и строительство в @place', 5),
(32, 'Растения', 'rasteniya', 'Покупка, продажа растений в @place', 'Покупка, продажа растений в @place', '', 'Растения в @place', 5),
(33, 'Одежда, обувь, аксессуары', 'odezhda-obuv-aksessuary', 'Покупка, продажа одежды, обуви и аксессуаров в @place', 'Покупка, продажа одежды, обуви и аксессуаров в @place', '', 'Одежда, обувь, аксессуары в @place', 6),
(34, 'Детская одежда и обувь', 'detskaya-odezhda-i-obuv', 'Покупка, продажа детской одежды и обуви в @place', 'Покупка, продажа детской одежды и обуви в @place', '', 'Детская одежда и обувь в @place', 6),
(35, 'Товары для детей и игрушки', 'tovary-dlya-detey-i-igrushki', 'Покупка, продажа и сдача в аренду товаров для детей и игрушек в @place', 'Покупка, продажа и сдача в аренду товаров для детей и игрушек в @place', '', 'Товары для детей и игрушки в @place', 6),
(36, 'Часы и украшения', 'chasy-i-ukrasheniya', 'Покупка, продажа и сдача в аренду часов и украшений в @place', 'Покупка, продажа и сдача в аренду часов и украшений в @place', '', 'Часы и украшения в @place', 6),
(37, 'Красота и здоровье', 'krasota-i-zdorove', 'Услуги в сфере красота и здоровье в @place', 'Услуги в сфере красота и здоровье в @place', '', 'Красота и здоровье в @place', 6),
(38, 'Собаки', 'sobaki', 'Покупка и продажа cобак в @place', 'Покупка и продажа cобак в @place', '', 'Собаки в @place', 7),
(39, 'Кошки', 'koshki', 'Покупка и продажа кошек в @place', 'Покупка и продажа кошек в @place', '', 'Кошки в @place', 7),
(40, 'Птицы', 'pticy', 'Покупка и продажа птиц в @place', 'Покупка и продажа птиц в @place', '', 'Птицы в @place', 7),
(41, 'Аквариум', 'akvarium', 'Всё для аквариума в @place', 'Всё для аквариума в @place', '', 'Аквариум в @place', 7),
(42, 'Другие животные', 'drugie-zhivotnye', 'Покупка, продажа различных животных в @place', 'Покупка, продажа различных животных в @place', '', 'Другие животные в @place', 7),
(43, 'Товары для животных', 'tovary-dlya-zhivotnyh', 'Покупка, продажа и сдача в аренду товаров для животных в @place', 'Покупка, продажа и сдача в аренду товаров для животных в @place', '', 'Товары для животных в @place', 7),
(44, 'Билеты и путешествия', 'bilety-i-puteshestviya', 'Покупка, продажа билетов в @place', 'Покупка, продажа билетов в @place', '', 'Билеты и путешествия в @place', 8),
(45, 'Велосипеды', 'velosipedy', 'Покупка, продажа и сдача в аренду велосипедов в @place', 'Покупка, продажа и сдача в аренду велосипедов в @place', '', 'Велосипеды в @place', 8),
(46, 'Книги и журналы', 'knigi-i-zhurnaly', 'Покупка и продажа книг и журналов в @place', 'Покупка и продажа книг и журналов в @place', '', 'Книги и журналы в @place', 8),
(47, 'Коллекционирование', 'kollekcionirovanie', 'Всё для коллекционирования в @place', 'Всё для коллекционирования в @place', '', 'Коллекционирование в @place', 8),
(48, 'Музыкальные инструменты', 'muzykalnye-instrumenty', 'Покупка, продажа и сдача в аренду музыкальных инструментов в @place', 'Покупка, продажа и сдача в аренду музыкальных инструментов в @place', '', 'Музыкальные инструменты в @place', 8),
(49, 'Охота и рыбалка', 'ohota-i-rybalka', 'Покупка, продажа и сдача в аренду товаров для охоты и рыбалки в @place', 'Покупка, продажа и сдача в аренду товаров для охоты и рыбалки в @place', '', 'Охота и рыбалка в @place', 8),
(50, 'Спорт и отдых', 'sport-i-otdyh', 'Покупка, продажа и сдача в аренду товаров для спорта и отдыха в @place', 'Покупка, продажа и сдача в аренду товаров для спорта и отдыха в @place', '', 'Спорт и отдых в @place', 8),
(51, 'IT, интернет, телеком', 'it-internet-telekom', 'IT, интернет, телеком в @place', 'IT, интернет, телеком в @place', '', 'IT, интернет, телеком в @place', 9),
(52, 'Бытовые услуги', 'bytovye-uslugi', 'Бытовые услуги в @place', 'Бытовые услуги в @place', '', 'Бытовые услуги в @place', 9),
(53, 'Деловые услуги', 'delovye-uslugi', 'Деловые услуги в @place', 'Деловые услуги в @place', '', 'Деловые услуги в @place', 9),
(54, 'Искусство', 'iskusstvo', 'Искусство в @place', 'Искусство в @place', '', 'Искусство в @place', 9),
(55, 'Красота, здоровье', 'krasota-zdorove', 'Предоставление услуг в сфере красоты, здоровья в @place', 'Предоставление услуг в сфере красоты, здоровья в @place', '', 'Красота, здоровье в @place', 9),
(56, 'Курьерские поручения', 'kurerskie-porucheniya', 'Курьерские услуги в @place', 'Курьерские услуги в @place', '', 'Курьерские поручения в @place', 9),
(57, 'Мастер на час', 'master-na-chas', 'Услуги мастера в @place', 'Услуги мастера в @place', '', 'Мастер на час в @place', 9),
(58, 'Няни, сиделки', 'nyani-sidelki', 'Услуги нянь и сиделок в @place', 'Услуги нянь и сиделок в @place', '', 'Няни, сиделки в @place', 9),
(59, 'Оборудование, производство', 'oborudovanie-proizvodstvo', 'Услуги по предоставлению оборудования в @place', 'Услуги по предоставлению оборудования в @place', '', 'Оборудование, производство в @place', 9),
(60, 'Обучение, курсы', 'obuchenie-kursy', 'Обучение, курсы в @place', 'Обучение, курсы в @place', '', 'Обучение, курсы в @place', 9),
(61, 'Охрана, безопасность', 'ohrana-bezopasnost', 'Услуги по предоставлению охраны и безопасности в @place', 'Услуги по предоставлению охраны и безопасности в @place', '', 'Охрана, безопасность в @place', 9),
(62, 'Питание, кейтеринг', 'pitanie-keytering', 'Питание, кейтеринг в @place', 'Питание, кейтеринг в @place', '', 'Питание, кейтеринг в @place', 9),
(63, 'Праздники, мероприятия', 'prazdniki-meropriyatiya', 'Организация праздников и мероприятий в @place', 'Организация праздников и мероприятий в @place', '', 'Праздники, мероприятия в @place', 9),
(64, 'Реклама, полиграфия', 'reklama-poligrafiya', 'Рекламные услуги и полиграфия в @place', 'Рекламные услуги и полиграфия в @place', '', 'Реклама, полиграфия в @place', 9),
(65, 'Ремонт и обслуживание техники', 'remont-i-obsluzhivanie-tehniki', 'Услуги по ремонту и обслуживанию техники в @place', 'Услуги по ремонту и обслуживанию техники в @place', '', 'Ремонт и обслуживание техники в @place', 9),
(66, 'Ремонт, строительство', 'remont-stroitelstvo', 'Услуги по ремонту и строительству в @place', 'Услуги по ремонту и строительству в @place', '', 'Ремонт, строительство в @place', 9),
(67, 'Сад, благоустройство', 'sad-blagoustroystvo', 'Сад, благоустройство в @place', 'Сад, благоустройство в @place', '', 'Сад, благоустройство в @place', 9),
(68, 'Транспорт, перевозки', 'transport-perevozki', 'Услуги транспорта и перевозок в @place', 'Услуги транспорта и перевозок в @place', '', 'Транспорт, перевозки в @place', 9),
(69, 'Уборка', 'uborka', 'Услуги уборки помещений в @place', 'Услуги уборки помещений в @place', '', 'Уборка в @place', 9),
(70, 'Установка техники', 'ustanovka-tehniki', 'Услуги по установке техники в @place', 'Услуги по установке техники в @place', '', 'Установка техники в @place', 9),
(71, 'Уход за животными', 'uhod-za-zhivotnymi', 'Услуги по уходу за животными в @place', 'Услуги по уходу за животными в @place', '', 'Уход за животными в @place', 9),
(72, 'Фото- и видеосъёмка', 'foto--i-videosemka', 'Услуги фото- и видеосъёмки в @place', 'Услуги фото- и видеосъёмки в @place', '', 'Фото- и видеосъёмка в @place', 9),
(73, 'Другое', 'drugoe', 'Различные объявления в @place', 'Различные объявления в @place', '', 'Другое в @place', 9),
(74, 'Запчасти', 'zapchasti', 'Запчасти в @place', 'Запчасти в @place', '', 'Запчасти для транспорта в @place', 1),
(77, 'Прочая электроника', 'prochaya-elektronika', 'Прочая электроника в @place', 'Прочая электроника в @place', '', 'Прочая электроника в @place', 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `subcats`
--
ALTER TABLE `subcats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `url_ru` (`url`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `subcats`
--
ALTER TABLE `subcats`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
