-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 09:14 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moja_strona`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`) VALUES
(1, 'Strona Główna', '<h1>Moje hobby to koszykówka</h1>\r\n<p><img class=\"left\" src=\"img/tlo4.jpg\" alt=\"pierwsze zdjecie\" />Koszykówka (lub piłka koszykowa) – dyscyplina sportu drużynowego (sport olimpijski), w której dwie pięcioosobowe drużyny grają przeciwko sobie próbując zdobyć jak największą liczbę punktów wrzucając piłkę do kosza drużyny przeciwnej.\r\n    Za datę powstania koszykówki uznaje się 21 grudnia 1891 r., a za jej twórcę – Jamesa Naismitha.Koszykówka powstała około grudnia 1891 roku w Springfield w stanie Massachusetts, gdy protestancki pastor i amerykański nauczyciel wychowania fizycznego (pochodzenia kanadyjskiego) w YMCA James Naismith opracował nową grę zespołową.\r\n    W 1891 roku Rada Pedagogiczna w Springfield YMCA Sport College rozpisała konkurs na dyscyplinę sportu potrzebną do zachowania kondycji dzieci i młodzieży w czasie semestru zimowego.\r\n    Naismith chciał stworzyć grę, która minimalizowałaby kontakt fizyczny, ale zawierała dużo skakania, biegania oraz koordynacji wzrokowo-ruchowej związanej z posiadaniem piłki w dłoniach. Wygrał projekt dr. Jamesa Naismitha, który napisał: \"Przeciętny człowiek jest pod silnym wpływem tradycji. Jeśli jest zainteresowany grą sportową,\r\n    jakikolwiek wysiłek fizyczny, aby coś w niej zmienić, tworzy sprzeciw w jego umyśle. Uświadomiłem sobie, że wszelkie usiłowania, by zmienić znane gry, nieuchronnie przyniosą opłakany rezultat.[…] Wówczas wziąłem pod uwagę dużą piłkę, łatwą w ujęciu, którą każdy mógłby chwytać i rzucać po niewielkim przygotowaniu. […] potem znalazłem\r\n    dwa stare kosze do zbierania brzoskwiń. Znalazłem młotek i kilka gwoździ i przybiłem kosze do dolnej krawędzi balkonów sali gimnastycznej\".Gra polegała na rzucaniu piłki do wiklinowych koszy zawieszonych na balkonach sali gimnastycznej. Kosze te nie miały dziury na ich dnie, więc po każdym celnym rzucie piłkę należało wyciągać specjalnymi kijami.\r\n</p>\r\n<p> Początkowo do gry w koszykówkę używano zwykłej piłki futbolowej. Pierwsza piłka przeznaczona wyłącznie do koszykówki powstała w 1894 roku. Naismith stworzył podstawowe zasady gry w koszykówkę:\r\n    Okrągłą piłką należało grać wyłącznie przy użyciu rąk. Piłka powinna być duża, lekka i możliwa do trzymania w dłoniach.\r\n</p>\r\nTrzymając piłkę, nie wolno było się z nią przemieszczać – należało ją podawać.Zawodnicy mieli prawo znajdować się w dowolnym miejscu boiska.Nie wolno było stosować przemocy fizycznej między zawodnikami.Niewielka bramka w formie kosza powinna być umieszczona poziomo, wysoko w górze.\r\n21 grudnia 1891 w sali gimnastycznej YMCA przy Armory Street w Springfield został rozegrany pierwszy nieoficjalny mecz koszykówki. W grze brały udział dwie dziewięcioosobowe drużyny studentów Scholl of Christian Workers. Na boisku jednocześnie przebywało osiemnastu zawodników. Pierwszy oficjalny mecz koszykówki odbył się 11 marca 1892 roku,\r\nnatomiast pierwszy mecz koszykówki kobiet odbył się 22 marca 1893 roku.<img class=\"right\" src=\"img/tlo5.jpg\" alt=\"drugie zdjecie\">Ze względu na pochodzenie twórcy koszykówki, pierwszym państwem poza USA, w którym grano w koszykówkę, była Kanada. Następnie koszykówka została zaprezentowana m.in. we Francji (1893), Anglii (1894), Australii, Chinach, Indiach i Japonii (1895-1900).\r\nW 1894 roku wprowadzono pierwsze zmiany w przepisach gry w koszykówkę – duża brutalność tej gry wymusiła wprowadzenie rzutów wolnych. Około 1895/96 zmieniono zasady punktacji – rzuty z gry były warte nie 3, a 2 punkty, zaś rzuty wolne – nie 3, lecz 1 punkt. Od 1895 roku zaczęły się pojawiać drewniane tablice koszów,\r\nnatomiast od 1896 roku można już było kozłować. W 1900 roku kosze na brzoskwinie zastąpiono metalowymi obręczami z siatkami bez dna. Inne źródła podają, że miało to miejsce dopiero ok. 1912-1913 roku. W 1903 roku wprowadzono przepis, że wszystkie linie ograniczające boisko muszą być proste – na boisku nie mogą znajdować się np. kolumny, schody, czy inne konstrukcje/przedmioty przeszkadzające w grze.\r\nW 1904 roku koszykówka była dyscypliną pokazową na igrzyskach olimpijskich. W 1906 roku powstała organizacja Intercollegiate Athletic Association of the United States (obecnie: National Collegiate Athletic Association – NCAA),\r\nkontrolująca rozgrywki między amerykańskimi koledżami, w tym koszykówkę.\r\n<p>W 1915 roku zmniejszono liczbę zawodników drużyny znajdujących się jednocześnie na boisku do pięciu (niektóre źródła podają, że miało to miejsce już ok. 1895-1897).\r\n    18 czerwca 1932 w Genewie powstała Międzynarodowa Federacja Koszykówki (Fédération Internationale de Basketball Amateur – FIBA). Organizacja ta do dziś zarządza międzynarodowymi meczami koszykówki. W 1934 roku opublikowano pierwsze międzynarodowe przepisy gry w koszykówkę FIBA.\r\n    Od 1935 roku rozgrywane są mistrzostwa Europy w koszykówce, a od 1936 roku koszykówka jest dyscypliną olimpijską. Do 1936/37 roku po każdym celnym rzucie odbywał się rzut sędziowski – w tym roku zniesiono ten przepis, co pozytywnie wpłynęło na rozwój i popularyzację koszykówki.\r\n    <img class=\"left2\" src=\"img/tlo6.jpg\" alt=\"trzecie zdjecie\">Podczas kongresu FIBA w Berlinie w 1936 wprowadzono również linię środkową boiska.Wiązało się to z wprowadzeniem zasady 10 sekund (obecnie znanej jako zasada 8 sekund).W 1949 roku powstała liga National Basketball Association (NBA). NBA powstało z połączenia dwóch zawodowych lig amerykańskich: BAA (Basketball Association of America) oraz NBL (National Basketball League).\r\n    Ponieważ BAA powstało już w roku 1946, a NBA jest niejako kontynuacją, czasem za datę powstania zawodowej ligi NBA przyjmuje się już rok 1946. Za pierwszy sezon w historii NBA uznaje się rozgrywki 1946/47, mimo że wtedy liga ta nazywała się jeszcze BAA.\r\n    Od 1950 roku rozgrywane są mistrzostwa świata w koszykówce.W 1954 wprowadzono w NBA zasadę 24 sekund. W 1956 roku w FIBA wprowadzono zasadę 30 sekund. W 1956 roku powiększono także obszar ograniczony do kształtu trapezu, który obowiązywał aż do 2010 roku. W 1979 roku NBA wprowadziła rzuty za 3 punkty (7,24 m od obręczy kosza). Ten sam pomysł zaakceptowała FIBA w 1984 roku (6,25 m od obręczy kosza).\r\n    Od 1976 roku dyscypliną olimpijską stała się także koszykówka kobiet. W sezonie 1996/97 utworzono Women\'s National Basketball Association (WNBA).W 2000 roku, w celu zwiększenia dynamiki gry, regułę 10 sekund zmieniono na regułę 8 sekund, a regułę 30 sekund, na regułę 24 sekund. W 2010 roku całkowicie zmieniono wygląd boiska do koszykówki FIBA.\r\n</p>\r\n\r\n', 1),
(2, 'Historia', '<p> historia </p>\r\n<div id=\"animacjaTestowa1\" class=\"test-block\"> Kliknij, a się powiększy</div>\r\n<script>\r\n    $(\"#animacjaTestowa1\").on(\"click\", function(){\r\n        $(this).animate({\r\n            width:\"500px\",\r\n            opacity: 0.4,\r\n            fontSize: \"3em\",\r\n            borderWidth: \"10px\",\r\n        }, 1500);\r\n    });\r\n</script>\r\n<div id=\"animacjaTestowa2\" class=\"test-block\"> Najedz kursorem, a się powiększe</div>\r\n<script>\r\n    $(\"#animacjaTestowa2\").on({\r\n        \"mouseover\" : function(){\r\n            $(this).animate({\r\n                width:300\r\n            }, 800);\r\n        },\r\n        \"mouseout\" : function(){\r\n            $(this).animate({\r\n                width:200\r\n            }, 800);\r\n        }\r\n    });\r\n</script>\r\n<div id=\"animacjaTestowa3\" class=\"test-block\"> Kliknij, abym urósł</div>\r\n<script>\r\n    $(\"#animacjaTestowa3\").on(\"click\", function(){\r\n        if (!$(this).is(\":animated\")){\r\n            $(this).animate({\r\n                width: \"+=\" + 50,\r\n                height: \"+=\" + 10,\r\n                opacity: \"-=\" + 0.1,\r\n                duration: 3000\r\n            });\r\n        }\r\n    });\r\n</script>\r\n', 1),
(3, 'Gwiazdy NBA', '<p> tu będą gwiazdy NBA </p>', 1),
(4, 'Filmy', '<p>filmy</p>', 1),
(5, 'Kontakt', '<form action=\"../formularz.php\" name=\"formularz\" method=\"post\">\r\n    <label for=\"name\">Imię:</label>\r\n        <input type=\"text\" id=\"name\" name=\"name\" required><br>\r\n    <label for=\"email\">Email:</label>\r\n        <input type=\"email\" id=\"email\" name=\"email\" required><br>\r\n    <label for=\"message\">Wiadomość:</label>\r\n        <textarea id=\"message\" name=\"message\" rows=\"4\" required></textarea><br>\r\n        <input type=\"submit\" value=\"Wyślij\">\r\n</form>', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
