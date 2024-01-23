-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 23, 2024 at 09:44 PM
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
-- Struktura tabeli dla tabeli `category_list`
--

CREATE TABLE `category_list` (
  `id` int(11) NOT NULL,
  `matka` int(11) NOT NULL DEFAULT 0,
  `nazwa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `matka`, `nazwa`) VALUES
(5, 0, 'Dom'),
(6, 0, 'Ogród'),
(7, 6, 'Narzedzia'),
(12, 6, 'Rośliny'),
(13, 12, 'Doniczkowe');

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
(2, 'Skrypty', '<form class=\"buttoms\" method=\"post\" name=\"background\">\r\n    <input type=\"button\" value=\"yellow\" onclick=\"changeBackground(\'#FFF000\')\">\r\n    <input type=\"button\" value=\"black\" onclick=\"changeBackground(\'#000000\')\">\r\n    <input type=\"button\" value=\"white\" onclick=\"changeBackground(\'FFFFFF\')\">\r\n    <input type=\"button\" value=\"green\" onclick=\"changeBackground(\'00FF00\')\">\r\n    <input type=\"button\" value=\"blue\" onclick=\"changeBackground(\'0000FF\')\">\r\n    <input type=\"button\" value=\"orange\" onclick=\"changeBackground(\'FF8000\')\">\r\n    <input type=\"button\" value=\"grey\" onclick=\"changeBackground(\'c0c0c0\')\">\r\n    <input type=\"button\" value=\"red\" onclick=\"changeBackground(\'FF0000\')\">\r\n</form>\r\n<div id=\"animacjaTestowa1\" class=\"test-block\"> Kliknij, a się powiększy</div>\r\n<script>\r\n    $(\"#animacjaTestowa1\").on(\"click\", function(){\r\n        $(this).animate({\r\n            width:\"500px\",\r\n            opacity: 0.4,\r\n            fontSize: \"3em\",\r\n            borderWidth: \"10px\",\r\n        }, 1500);\r\n    });\r\n</script>\r\n<div id=\"animacjaTestowa2\" class=\"test-block\"> Najedz kursorem, a się powiększe</div>\r\n<script>\r\n    $(\"#animacjaTestowa2\").on({\r\n        \"mouseover\" : function(){\r\n            $(this).animate({\r\n                width:300\r\n            }, 800);\r\n        },\r\n        \"mouseout\" : function(){\r\n            $(this).animate({\r\n                width:200\r\n            }, 800);\r\n        }\r\n    });\r\n</script>\r\n<div id=\"animacjaTestowa3\" class=\"test-block\"> Kliknij, abym urósł</div>\r\n<script>\r\n    $(\"#animacjaTestowa3\").on(\"click\", function(){\r\n        if (!$(this).is(\":animated\")){\r\n            $(this).animate({\r\n                width: \"+=\" + 50,\r\n                height: \"+=\" + 10,\r\n                opacity: \"-=\" + 0.1,\r\n                duration: 3000\r\n            });\r\n        }\r\n    });\r\n</script>\r\n', 1),
(3, 'Gwiazdy NBA', '<style>\r\n    .gracz {\r\n        background-color: #fff;\r\n        margin: 20px;\r\n        padding: 20px;\r\n        border-radius: 8px;\r\n        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);\r\n        overflow: hidden; /* Zapobiega wyjściu obrazka poza obszar div.gracz */\r\n    }\r\n\r\n    .img-left {\r\n        float: left;\r\n        margin-right: 20px;\r\n        border-radius: 8px;\r\n        max-width: 100%; /* Działa w połączeniu z overflow: hidden; */\r\n    }\r\n\r\n    h2 {\r\n        color: #333;\r\n    }\r\n\r\n    p {\r\n        color: #666;\r\n    }\r\n\r\n    @media (max-width: 768px) {\r\n        .img-left {\r\n            float: none;\r\n            margin-right: 0;\r\n            margin-bottom: 10px;\r\n        }\r\n    }\r\n</style>\r\n<body>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda1.jpg\" alt=\"LeBron James\">\r\n    <h2>LeBron James</h2>\r\n    <p>LeBron Raymone James Sr. to amerykański koszykarz, występujący w drużynie Los Angeles Lakers w NBA. Urodzony 30 grudnia 1984 roku w Akron, Ohio. Jeden z najbardziej utytułowanych koszykarzy w historii NBA.</p>\r\n    <p>Wzrost: 206 cm</p>\r\n    <p>Waga: 113 kg</p>\r\n    <p>Pozycja: Niski skrzydłowy</p>\r\n</div>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda2.jpg\" alt=\"Stephen Curry\">\r\n    <h2>Stephen Curry</h2>\r\n    <p>Wardell Stephen Curry II to amerykański koszykarz, grający w drużynie Golden State Warriors w NBA. Urodzony 14 marca 1988 roku w Akron, Ohio. Trzykrotny mistrz NBA.</p>\r\n    <p>Wzrost: 191 cm</p>\r\n    <p>Waga: 83 kg</p>\r\n    <p>Pozycja: Rzucający obrońca</p>\r\n</div>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda3.jpg\" alt=\"Giannis Antetokounmpo\">\r\n    <h2>Giannis Antetokounmpo</h2>\r\n    <p>Giannis Sina Ugo Antetokounmpo to grecki koszykarz, reprezentujący barwy Milwaukee Bucks w NBA. Urodzony 6 grudnia 1994 roku w Atenach, Grecja. Dwukrotny MVP NBA.</p>\r\n    <p>Wzrost: 213 cm</p>\r\n    <p>Waga: 109 kg</p>\r\n    <p>Pozycja: Silny skrzydłowy</p>\r\n</div>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda4.jpg\" alt=\"Kevin Durant\">\r\n    <h2>Kevin Durant</h2>\r\n    <p>Kevin Wayne Durant to amerykański koszykarz, występujący w drużynie Brooklyn Nets w NBA. Urodzony 29 września 1988 roku w Washington, D.C. Dwukrotny mistrz NBA.</p>\r\n    <p>Wzrost: 208 cm</p>\r\n    <p>Waga: 109 kg</p>\r\n    <p>Pozycja: Niski skrzydłowy / Skrzydłowy</p>\r\n</div>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda5.jpg\" alt=\"Kawhi Leonard\">\r\n    <h2>Kawhi Leonard</h2>\r\n    <p>Kawhi Anthony Leonard to amerykański koszykarz, grający w drużynie Los Angeles Clippers w NBA. Urodzony 29 czerwca 1991 roku w Los Angeles, Kalifornia. Dwukrotny mistrz NBA i dwukrotny MVP Finałów NBA.</p>\r\n    <p>Wzrost: 201 cm</p>\r\n    <p>Waga: 102 kg</p>\r\n    <p>Pozycja: Niski skrzydłowy</p>\r\n</div>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda6.jpg\" alt=\"James Harden\">\r\n    <h2>James Harden</h2>\r\n    <p>James Edward Harden Jr. to amerykański koszykarz, występujący w drużynie Brooklyn Nets w NBA. Urodzony 26 sierpnia 1989 roku w Los Angeles, Kalifornia. Były MVP NBA.</p>\r\n    <p>Wzrost: 196 cm</p>\r\n    <p>Waga: 100 kg</p>\r\n    <p>Pozycja: Rzucający obrońca / Obrońca</p>\r\n</div>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda7.jpg\" alt=\"Luka Dončić\">\r\n    <h2>Luka Dončić</h2>\r\n    <p>Luka Dončić to słoweński koszykarz, reprezentujący barwy Dallas Mavericks w NBA. Urodzony 28 lutego 1999 roku w Lublanie, Słowenia. Młody talent, uznawany za jednego z najbardziej obiecujących zawodników ligi.</p>\r\n    <p>Wzrost: 201 cm</p>\r\n    <p>Waga: 109 kg</p>\r\n    <p>Pozycja: Rzucający obrońca / Rozgrywający</p>\r\n</div>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda8.jpg\" alt=\"Joel Embiid\">\r\n    <h2>Joel Embiid</h2>\r\n    <p>Joel Hans Embiid to kameruński koszykarz, występujący w drużynie Philadelphia 76ers w NBA. Urodzony 16 marca 1994 roku w Jaunde, Kamerun. Zaliczany do jednych z najlepszych środkowych w lidze.</p>\r\n    <p>Wzrost: 213 cm</p>\r\n    <p>Waga: 113 kg</p>\r\n    <p>Pozycja: Środkowy</p>\r\n</div>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda9.jpg\" alt=\"Damian Lillard\">\r\n    <h2>Damian Lillard</h2>\r\n    <p>Damian Lamonte Ollie Lillard to amerykański koszykarz, grający w drużynie Portland Trail Blazers w NBA. Urodzony 15 lipca 1990 roku w Oakland, Kalifornia. Posiadacz licznych rekordów i uznawany za jednego z najlepszych rozgrywających ligi.</p>\r\n    <p>Wzrost: 191 cm</p>\r\n    <p>Waga: 88 kg</p>\r\n    <p>Pozycja: Rozgrywający</p>\r\n</div>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda10.jpg\" alt=\"Anthony Davis\">\r\n    <h2>Anthony Davis</h2>\r\n    <p>Anthony Marshon Davis Jr. to amerykański koszykarz, występujący w drużynie Los Angeles Lakers w NBA. Urodzony 11 marca 1993 roku w Chicago, Illinois. Mistrz NBA i wielokrotny All-Star.</p>\r\n    <p>Wzrost: 208 cm</p>\r\n    <p>Waga: 115 kg</p>\r\n    <p>Pozycja: Skrzydłowy / Środkowy</p>\r\n</div>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda11.jpg\" alt=\"Devin Booker\">\r\n    <h2>Devin Booker</h2>\r\n    <p>Devin Armani Booker to amerykański koszykarz, grający w drużynie Phoenix Suns w NBA. Urodzony 30 października 1996 roku w Grand Rapids, Michigan. Jedna z czołowych postaci wśród młodych talentów ligi.</p>\r\n    <p>Wzrost: 196 cm</p>\r\n    <p>Waga: 93 kg</p>\r\n    <p>Pozycja: Rzucający obrońca</p>\r\n</div>\r\n\r\n<div class=\"gracz\">\r\n    <img class=\"img-left\" src=\"img/gwiazda12.jpg\" alt=\"Jayson Tatum\">\r\n    <h2>Jayson Tatum</h2>\r\n    <p>Jayson Christopher Tatum to amerykański koszykarz, reprezentujący barwy Boston Celtics w NBA. Urodzony 3 marca 1998 roku w Saint Louis, Missouri. Młody skrzydłowy uchodzi za jednego z przyszłych liderów ligi.</p>\r\n    <p>Wzrost: 203 cm</p>\r\n    <p>Waga: 93 kg</p>\r\n    <p>Pozycja: Niski skrzydłowy</p>\r\n</div>\r\n</body>\r\n</html>\r\n', 1),
(4, 'Filmy', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/YcCfD8NmMQA?si=iZRj44l4Dco_6gzQ\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>\r\n<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/CTCdOBLUPfc?si=Q9Lva-Hn1xiN3-aX\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>\r\n<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/_uB6V4bTg24?si=oz9TYFoDEHm6jp59\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>\r\n', 1),
(5, 'Kontakt', '<form action=\"psiwek@gmail.com\" name=\"formularz\" method=\"POST\">\r\n    <label for=\"name\">Imię:</label>\r\n        <input type=\"text\" id=\"name\" name=\"name\" required><br>\r\n    <label for=\"email\">Email:</label>\r\n        <input type=\"email\" id=\"email\" name=\"email\" required><br>\r\n    <label for=\"message\">Wiadomość:</label>\r\n        <textarea id=\"message\" name=\"message\" rows=\"4\" required></textarea><br>\r\n        <input type=\"submit\" value=\"Wyślij\">\r\n</form>', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_list`
--

CREATE TABLE `product_list` (
  `id` int(11) NOT NULL,
  `tytul` varchar(255) NOT NULL,
  `opis` text NOT NULL,
  `data_utworzenia` date NOT NULL,
  `data_modyfikacji` date NOT NULL,
  `data_wygasniecia` date NOT NULL,
  `cena_netto` float NOT NULL,
  `podatek_vat` float NOT NULL,
  `ilosc` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `kategoria` varchar(255) NOT NULL,
  `gabaryt` varchar(255) NOT NULL,
  `zdjecie` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `tytul`, `opis`, `data_utworzenia`, `data_modyfikacji`, `data_wygasniecia`, `cena_netto`, `podatek_vat`, `ilosc`, `status`, `kategoria`, `gabaryt`, `zdjecie`) VALUES
(57, 'Piłka do koszykówki', 'Piłka do gry', '2024-01-18', '2024-01-18', '2025-02-02', 500, 23, 100, 1, '5', 'mały', 0x7a646a656369612f696d6167655f363561383635623063326663655f70696c6b692d646f2d6b6f737a796b6f776b692e61766966),
(58, 'Donica', 'Donica', '2024-01-18', '2024-01-18', '2025-04-12', 2500, 23, 20, 1, '6', 'mały', 0x7a646a656369612f696d6167655f363561383730373634613466345f776c6f736b612d646f6e6963612d6d6f6b612e77656270),
(59, 'Młotek', 'boli', '2024-01-18', '2024-01-18', '0000-00-00', 50, 23, 50, 1, '7', 'mały', 0x7a646a656369612f696d6167655f363561383730623565316533355f6269675f4d6c6f74656b2d736c75736172736b692d312d352d6b672e6a7067),
(60, 'Tulipan', 'kwiatek', '2024-01-18', '2024-01-18', '2025-03-12', 25, 23, 1000, 1, '12', 'mały', 0x7a646a656369612f696d6167655f363561383730663362643730365f74756c6970616e2d706f6a6564796e637a792d3438636d2d6265617574792d677265656e2e6a7067),
(61, 'Kordylina', 'kwiat doniczkowy', '2024-01-18', '2024-01-18', '2024-02-12', 30, 23, 300, 1, '13', 'duży', 0x7a646a656369612f696d6167655f363561383731346537393530315f706f6272616e652e6a7067),
(62, 'test', 'test', '2024-01-18', '2024-01-18', '0000-00-00', 0, 0, 0, 0, '5', '', 0x7a646a656369612f696d6167655f363561383733363062633336345f677769617a6461322e6a7067);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
