-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 15 Lut 2022, 16:50
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `gielczynski_4tb`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `albumy`
--

CREATE TABLE `albumy` (
  `id` int(11) NOT NULL,
  `tytul` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `id_uzytkownika` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `albumy`
--

INSERT INTO `albumy` (`id`, `tytul`, `data`, `id_uzytkownika`) VALUES
(63, 'miasta', '2022-02-14 17:47:26', 1),
(64, 'krajobrazy', '2022-02-14 17:48:50', 1),
(65, 'zwierzeta', '2022-02-14 17:49:42', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `login` varchar(16) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `zarejestrowany` date NOT NULL,
  `uprawnienia` enum('użytkownik','administrator','moderator') COLLATE utf8_polish_ci NOT NULL,
  `aktywny` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`, `email`, `zarejestrowany`, `uprawnienia`, `aktywny`) VALUES
(1, 'administrator', 'e3bc38a4faa625d074664d572d810c1e', 'admin@gmail.com', '2021-12-05', 'administrator', 1),
(3, 'zablokowany', 'e3bc38a4faa625d074664d572d810c1e', 'zablok@gmail.com', '2021-12-05', 'użytkownik', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia`
--

CREATE TABLE `zdjecia` (
  `id` int(11) NOT NULL,
  `opis` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `id_albumu` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `zaakceptowane` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zdjecia`
--

INSERT INTO `zdjecia` (`id`, `opis`, `id_albumu`, `data`, `zaakceptowane`) VALUES
(65, '', 63, '2022-02-14 17:48:22', 1),
(66, '', 63, '2022-02-14 17:48:26', 1),
(67, '', 63, '2022-02-14 17:48:31', 1),
(68, '', 63, '2022-02-14 17:48:36', 1),
(69, '', 63, '2022-02-14 17:48:40', 1),
(70, '', 63, '2022-02-14 17:48:44', 1),
(71, '', 64, '2022-02-14 17:48:57', 1),
(72, '', 64, '2022-02-14 17:49:00', 1),
(73, '', 64, '2022-02-14 17:49:05', 1),
(74, '', 64, '2022-02-14 17:49:08', 1),
(75, '', 64, '2022-02-14 17:49:13', 1),
(76, '', 64, '2022-02-14 17:49:15', 1),
(77, '', 64, '2022-02-14 17:49:20', 1),
(78, '', 64, '2022-02-14 17:49:22', 1),
(79, '', 64, '2022-02-14 17:49:25', 1),
(80, '', 64, '2022-02-14 17:49:28', 1),
(81, '', 64, '2022-02-14 17:49:30', 1),
(82, '', 65, '2022-02-14 17:49:44', 1),
(83, '', 65, '2022-02-14 17:49:47', 1),
(84, '', 65, '2022-02-14 17:49:50', 1),
(85, '', 65, '2022-02-14 17:49:53', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia_komentarze`
--

CREATE TABLE `zdjecia_komentarze` (
  `id` int(11) NOT NULL,
  `id_zdjecia` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `komentarz` text COLLATE utf8_polish_ci NOT NULL,
  `zaakceptowany` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zdjecia_komentarze`
--

INSERT INTO `zdjecia_komentarze` (`id`, `id_zdjecia`, `id_uzytkownika`, `data`, `komentarz`, `zaakceptowany`) VALUES
(15, 80, 1, '2022-02-14 17:51:06', 'ładne to to', 1),
(17, 76, 1, '2022-02-14 17:51:25', 'OOOOOo drzewo', 1),
(19, 74, 1, '2022-02-14 17:51:41', 'zimno tam chyba', 1),
(20, 73, 1, '2022-02-14 17:51:49', 'WoooooooooooooW', 1),
(21, 83, 1, '2022-02-14 17:52:03', 'lis', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia_oceny`
--

CREATE TABLE `zdjecia_oceny` (
  `id_zdjecia` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `ocena` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zdjecia_oceny`
--

INSERT INTO `zdjecia_oceny` (`id_zdjecia`, `id_uzytkownika`, `ocena`) VALUES
(80, 1, 5),
(78, 1, 4),
(77, 1, 9),
(75, 1, 4),
(74, 1, 3),
(83, 1, 10);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `albumy`
--
ALTER TABLE `albumy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_albumu` (`id_albumu`);

--
-- Indeksy dla tabeli `zdjecia_komentarze`
--
ALTER TABLE `zdjecia_komentarze`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_zdjecia` (`id_zdjecia`);

--
-- Indeksy dla tabeli `zdjecia_oceny`
--
ALTER TABLE `zdjecia_oceny`
  ADD KEY `id_zdjecia` (`id_zdjecia`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `albumy`
--
ALTER TABLE `albumy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT dla tabeli `zdjecia_komentarze`
--
ALTER TABLE `zdjecia_komentarze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `albumy`
--
ALTER TABLE `albumy`
  ADD CONSTRAINT `albumy_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
  ADD CONSTRAINT `zdjecia_ibfk_1` FOREIGN KEY (`id_albumu`) REFERENCES `albumy` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `zdjecia_komentarze`
--
ALTER TABLE `zdjecia_komentarze`
  ADD CONSTRAINT `zdjecia_komentarze_ibfk_1` FOREIGN KEY (`id_zdjecia`) REFERENCES `zdjecia` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `zdjecia_oceny`
--
ALTER TABLE `zdjecia_oceny`
  ADD CONSTRAINT `zdjecia_oceny_ibfk_1` FOREIGN KEY (`id_zdjecia`) REFERENCES `zdjecia` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
