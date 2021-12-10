-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 10 2021 г., 19:36
-- Версия сервера: 10.6.5-MariaDB
-- Версия PHP: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bd1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `actors`
--

CREATE TABLE `actors` (
  `ID_actor` int(2) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `year_of_birth` int(4) NOT NULL,
  `country_of_birth` varchar(100) NOT NULL,
  `career_start_year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `actors`
--

INSERT INTO `actors` (`ID_actor`, `first_name`, `last_name`, `year_of_birth`, `country_of_birth`, `career_start_year`) VALUES
(1, 'Charles', 'Gray', 1952, 'Switzerland', 1986),
(2, 'Gordon', 'Silver', 1962, 'France', 2009),
(3, 'Abraham', 'Snow', 1991, 'France', 2015),
(4, 'Daisy', 'Violet', 1964, 'Germany', 2006),
(5, 'Irene', 'Brown', 1970, 'Hungary', 1991),
(6, 'Henry', 'Sand', 1992, 'Poland', 2019),
(7, 'Edward', 'Red', 1955, 'Netherlands', 1973),
(8, 'Francis', 'Gold', 1956, 'Czech', 1981),
(9, 'Charles', 'Gray', 1953, 'Hungary', 1999),
(10, 'Helen', 'Orange', 1996, 'UK', 2017),
(11, 'Henry', 'Silver', 1988, 'Portugal', 2016),
(12, 'Grace', 'Green', 1975, 'Netherlands', 2019),
(13, 'Daniel', 'Lime', 1961, 'Switzerland', 2011),
(14, 'Christine', 'Silver', 1978, 'Netherlands', 2016),
(15, 'Evelyn', 'Green', 1968, 'Austria', 2008),
(16, 'George', 'Cyan', 1979, 'Poland', 2010),
(17, 'Daisy', 'Brown', 1957, 'Italy', 1986),
(18, 'Jane', 'Violet', 1967, 'Poland', 2016),
(19, 'Grace', 'Lime', 1976, 'Switzerland', 2004),
(20, 'Abraham', 'Pink', 1952, 'USA', 2018),
(21, 'Albert', 'Green', 1993, 'UK', 2012),
(22, 'George', 'Violet', 1982, 'Switzerland', 2017),
(23, 'Edward', 'Olive', 1999, 'Italy', 2020),
(24, 'Henry', 'Cyan', 1954, 'Portugal', 1977),
(25, 'Irene', 'White', 1980, 'UK', 1998),
(26, 'Jane', 'Gold', 2001, 'Austria', 2019),
(27, 'Emily', 'White', 1963, 'Germany', 2012),
(28, 'Harry', 'Violet', 1960, 'France', 2003),
(29, 'Florence', 'White', 1970, 'Poland', 1997),
(30, 'Henry', 'Gold', 1975, 'Austria', 1999),
(31, 'Ann', 'White', 1982, 'Czech', 2017),
(32, 'Caroline', 'Tan', 1958, 'Hungary', 1987),
(33, 'Jane', 'Gray', 1988, 'Czech', 2007),
(34, 'Jane', 'Gray', 1973, 'Austria', 2014),
(35, 'Albert', 'Green', 1976, 'France', 2017),
(36, 'Grace', 'White', 1991, 'Belgium', 2011),
(37, 'Gloria', 'Maroon', 1953, 'Spain', 1984),
(38, 'Adam', 'Lime', 1992, 'Spain', 2015),
(39, 'Albert', 'Snow', 1994, 'UK', 2018),
(40, 'Harold', 'Salmon', 1982, 'Germany', 2004),
(41, 'Henry', 'Maroon', 1978, 'UK', 2001),
(42, 'Irene', 'Plum', 1952, 'Poland', 1991),
(43, 'Harry', 'Sand', 1954, 'Germany', 2005),
(44, 'Gloria', 'Salmon', 1992, 'UK', 2012),
(45, 'Henry', 'Tan', 1973, 'UK', 2019),
(46, 'Caroline', 'Cyan', 1954, 'USA', 1985),
(47, 'Caroline', 'Cyan', 1955, 'France', 2017),
(48, 'Henry', 'Aqua', 1958, 'Italy', 1995),
(49, 'Daisy', 'Gray', 1968, 'Czech', 1989),
(50, 'Charles', 'Red', 1950, 'Italy', 1973);

-- --------------------------------------------------------

--
-- Структура таблицы `awards`
--

CREATE TABLE `awards` (
  `ID_awards` int(11) NOT NULL,
  `ID_film` int(2) NOT NULL,
  `award` varchar(100) NOT NULL,
  `date` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `awards`
--

INSERT INTO `awards` (`ID_awards`, `ID_film`, `award`, `date`) VALUES
(1, 15, 'Cesar', 1977),
(2, 30, 'Goya', 2006),
(3, 48, 'Cesar', 2009),
(4, 16, 'Saturn', 1968),
(5, 15, 'Golden Globe', 1969),
(6, 33, 'Goya', 1988),
(7, 10, 'Saturn', 1999),
(8, 13, 'Golden Globe', 1995),
(9, 7, 'Cesar', 1978),
(10, 4, 'Goya', 1999),
(11, 35, 'Cesar', 1999),
(12, 14, 'Saturn', 1993),
(13, 28, 'Saturn', 1999),
(14, 19, 'Oscar', 2007),
(15, 39, 'Oscar', 1968),
(16, 27, 'Golden Globe', 1968),
(17, 46, 'Golden Globe', 1973),
(18, 13, 'Golden Globe', 1983),
(19, 45, 'Golden Globe', 2016),
(20, 10, 'Saturn', 1980),
(21, 22, 'Saturn', 2018),
(22, 9, 'Cesar', 2011),
(23, 11, 'Golden Globe', 1982),
(24, 26, 'Oscar', 1973),
(25, 5, 'Oscar', 1970),
(26, 5, 'Golden Globe', 1991),
(27, 50, 'Oscar', 2001),
(28, 42, 'Oscar', 1968),
(29, 22, 'Oscar', 2008),
(30, 43, 'Oscar', 2004),
(31, 24, 'Oscar', 2019),
(32, 2, 'Golden Globe', 2013),
(33, 11, 'Goya', 2008),
(34, 33, 'Cesar', 1980),
(35, 12, 'Cesar', 1971),
(36, 1, 'Goya', 1976),
(37, 34, 'Saturn', 1984),
(38, 35, 'Saturn', 2005),
(39, 5, 'Goya', 2020),
(40, 11, 'Cesar', 1996),
(41, 25, 'Saturn', 2016),
(42, 4, 'Oscar', 2001),
(43, 1, 'Cesar', 2002),
(44, 19, 'Golden Globe', 2020),
(45, 14, 'Saturn', 2014),
(46, 37, 'Saturn', 1992),
(47, 13, 'Cesar', 2011),
(48, 36, 'Oscar', 1984),
(49, 49, 'Goya', 1996),
(50, 8, 'Goya', 2013);

-- --------------------------------------------------------

--
-- Структура таблицы `films`
--

CREATE TABLE `films` (
  `ID_film` int(2) NOT NULL,
  `film_name` varchar(100) NOT NULL,
  `year_of_release` int(4) NOT NULL,
  `country_of_release` varchar(100) NOT NULL,
  `IMDb_rating` int(3) NOT NULL,
  `RT_rating` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `films`
--

INSERT INTO `films` (`ID_film`, `film_name`, `year_of_release`, `country_of_release`, `IMDb_rating`, `RT_rating`) VALUES
(1, 'Hot Winter', 1977, 'Switzerland', 21, 4),
(2, 'Wonderful Spring', 2015, 'Germany', 40, 2),
(3, 'Hot Heat', 2000, 'Czech', 29, 10),
(4, 'Wonderful Fall', 2008, 'UK', 22, 2),
(5, 'Magical Winter', 1974, 'Hungary', 42, 7),
(6, 'Beautiful Miami', 2000, 'Spain', 61, 1),
(7, 'Space Summer', 1981, 'Spain', 11, 5),
(8, 'Ugly Heat', 2010, 'France', 21, 9),
(9, 'Hot Heat', 2005, 'Portugal', 43, 9),
(10, 'Ugly Clerk', 1968, 'Switzerland', 49, 2),
(11, 'Space Vegas', 1999, 'Poland', 42, 1),
(12, 'Beautiful Vegas', 2010, 'Czech', 84, 9),
(13, 'Wonderful Fall', 2000, 'France', 14, 4),
(14, 'Cold Winter', 1998, 'Poland', 23, 8),
(15, 'Space New York', 2007, 'Switzerland', 79, 8),
(16, 'Trembling Vegas', 1987, 'Poland', 92, 1),
(17, 'Trembling Miami', 1995, 'France', 19, 1),
(18, 'Cold Miami', 1990, 'UK', 94, 8),
(19, 'Cold Clerk', 2015, 'Hungary', 56, 6),
(20, 'Cold New York', 2000, 'Belgium', 88, 9),
(21, 'Cold Girls', 1988, 'Portugal', 97, 10),
(22, 'Magical Girls', 1988, 'Switzerland', 40, 5),
(23, 'Cold Clerk', 2011, 'Spain', 10, 8),
(24, 'Red Summer', 2016, 'Hungary', 70, 10),
(25, 'Magical New York', 1998, 'Italy', 6, 5),
(26, 'Ugly Spring', 2005, 'USA', 4, 6),
(27, 'Magical Miami', 1989, 'UK', 57, 10),
(28, 'Red Summer', 1988, 'Poland', 16, 2),
(29, 'Cold Heat', 1979, 'UK', 54, 5),
(30, 'Space Winter', 1972, 'France', 94, 3),
(31, 'Wonderful Winter', 2008, 'Czech', 74, 9),
(32, 'Hot Fall', 2018, 'Austria', 43, 8),
(33, 'Red Heat', 2009, 'Italy', 45, 4),
(34, 'Hot Vegas', 2011, 'Austria', 71, 1),
(35, 'Cold Clerk', 1968, 'UK', 74, 6),
(36, 'Magical Spring', 2015, 'Italy', 89, 2),
(37, 'Red Fall', 1991, 'UK', 4, 5),
(38, 'Ugly Winter', 1980, 'Australia', 38, 3),
(39, 'Wonderful Girls', 2004, 'Czech', 12, 4),
(40, 'Cold Spring', 1990, 'Poland', 43, 3),
(41, 'Hot Miami', 1982, 'Poland', 78, 6),
(42, 'Red New York', 1990, 'Czech', 88, 7),
(43, 'Magical Heat', 1973, 'Spain', 62, 10),
(44, 'Ugly New York', 1983, 'Portugal', 25, 3),
(45, 'Trembling Spring', 2010, 'Switzerland', 36, 5),
(46, 'Wonderful Fall', 2014, 'Australia', 4, 4),
(47, 'Magical Clerk', 1973, 'Germany', 78, 4),
(48, 'Outraging Summer', 2017, 'Austria', 68, 10),
(49, 'Magical New York', 1976, 'Australia', 2, 6),
(50, 'Red Winter', 2001, 'Czech', 35, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `films-actors`
--

CREATE TABLE `films-actors` (
  `ID_pair` int(11) NOT NULL,
  `ID_actor` int(2) NOT NULL,
  `ID_film` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `films-actors`
--

INSERT INTO `films-actors` (`ID_pair`, `ID_actor`, `ID_film`) VALUES
(1, 40, 19),
(2, 27, 24),
(3, 32, 19),
(4, 4, 38),
(5, 19, 3),
(6, 50, 10),
(7, 28, 8),
(8, 45, 10),
(9, 16, 35),
(10, 26, 12),
(11, 38, 47),
(12, 13, 21),
(13, 49, 50),
(14, 16, 41),
(15, 28, 26),
(16, 11, 21),
(17, 46, 21),
(18, 28, 37),
(19, 34, 47),
(20, 40, 18),
(21, 13, 13),
(22, 41, 9),
(23, 1, 7),
(24, 35, 45),
(25, 11, 14),
(26, 8, 9),
(27, 29, 30),
(28, 15, 25),
(29, 14, 22),
(30, 42, 13),
(31, 19, 13),
(32, 28, 44),
(33, 25, 43),
(34, 24, 45),
(35, 38, 9),
(36, 35, 1),
(37, 11, 16),
(38, 27, 2),
(39, 26, 7),
(40, 50, 14),
(41, 42, 35),
(42, 33, 37),
(43, 50, 35),
(44, 11, 33),
(45, 23, 15),
(46, 3, 27),
(47, 6, 48),
(48, 30, 3),
(49, 10, 34),
(50, 25, 14),
(51, 46, 23);

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE `genres` (
  `ID_genres` int(2) NOT NULL,
  `ID_film` int(2) NOT NULL,
  `genre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `genres`
--

INSERT INTO `genres` (`ID_genres`, `ID_film`, `genre`) VALUES
(3, 27, 'Crime'),
(4, 22, 'SciFi'),
(5, 17, 'SciFi'),
(6, 25, 'Fantasy'),
(7, 42, 'Musical'),
(8, 15, 'Musical'),
(9, 23, 'Crime'),
(10, 32, 'SciFi'),
(11, 45, 'Crime'),
(12, 26, 'Comedy'),
(13, 8, 'Musical'),
(14, 5, 'Drama'),
(15, 50, 'Musical'),
(16, 6, 'Crime'),
(17, 45, 'Fantasy'),
(18, 29, 'Musical'),
(19, 20, 'Crime'),
(20, 28, 'Comedy'),
(21, 35, 'Horror'),
(22, 11, 'Drama'),
(23, 9, 'SciFi'),
(24, 16, 'Musical'),
(25, 49, 'Horror'),
(26, 30, 'Comedy'),
(27, 39, 'Musical'),
(28, 42, 'Fantasy'),
(29, 49, 'Horror'),
(30, 47, 'SciFi'),
(31, 5, 'Horror'),
(32, 6, 'Drama'),
(33, 39, 'Comedy'),
(34, 39, 'Fantasy'),
(35, 31, 'Crime'),
(36, 23, 'Comedy'),
(37, 28, 'SciFi'),
(38, 22, 'Musical'),
(39, 27, 'Fantasy'),
(40, 35, 'Comedy'),
(41, 17, 'SciFi'),
(42, 29, 'Horror'),
(43, 32, 'Comedy'),
(44, 27, 'Drama'),
(45, 12, 'Horror'),
(46, 24, 'Musical'),
(47, 31, 'Fantasy'),
(48, 49, 'Crime'),
(49, 37, 'Horror'),
(50, 47, 'Crime'),
(51, 9, 'Comedy'),
(52, 33, 'SciFi');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`ID_actor`);

--
-- Индексы таблицы `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`ID_awards`),
  ADD KEY `ID_film` (`ID_film`);

--
-- Индексы таблицы `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`ID_film`);

--
-- Индексы таблицы `films-actors`
--
ALTER TABLE `films-actors`
  ADD PRIMARY KEY (`ID_pair`),
  ADD KEY `ID_actor` (`ID_actor`),
  ADD KEY `ID_film` (`ID_film`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`ID_genres`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `actors`
--
ALTER TABLE `actors`
  MODIFY `ID_actor` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT для таблицы `awards`
--
ALTER TABLE `awards`
  MODIFY `ID_awards` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT для таблицы `films`
--
ALTER TABLE `films`
  MODIFY `ID_film` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT для таблицы `films-actors`
--
ALTER TABLE `films-actors`
  MODIFY `ID_pair` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `ID_genres` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `awards_ibfk_1` FOREIGN KEY (`ID_film`) REFERENCES `films` (`ID_film`);

--
-- Ограничения внешнего ключа таблицы `films-actors`
--
ALTER TABLE `films-actors`
  ADD CONSTRAINT `films-actors_ibfk_1` FOREIGN KEY (`ID_actor`) REFERENCES `actors` (`ID_actor`),
  ADD CONSTRAINT `films-actors_ibfk_2` FOREIGN KEY (`ID_film`) REFERENCES `films` (`ID_film`);

--
-- Ограничения внешнего ключа таблицы `genres`
--
ALTER TABLE `genres`
  ADD CONSTRAINT `genres_ibfk_1` FOREIGN KEY (`ID_film`) REFERENCES `films` (`ID_film`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
