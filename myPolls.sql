-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 19 2023 г., 07:24
-- Версия сервера: 10.8.4-MariaDB
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `myPolls`
--

-- --------------------------------------------------------

--
-- Структура таблицы `access`
--

CREATE TABLE `access` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `Fio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `id_user`, `Fio`) VALUES
(13, 38, 'Сергеев Пётр Александрович');

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `points` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer`, `points`) VALUES
(216, 156, 'стараетесь беспристрастно анализировать достоинства и недостатки, успехи и неудачи школьника;', 1),
(217, 156, 'подчеркиваете достоинства и успехи школьника, анализируете его неудачи и недостатки;', 2),
(218, 156, 'стараетесь проанализировать неудачи и недостатки школьника, упоминаете его успехи', 0),
(219, 157, 'выслушиваете замечания и предложения родителей, после\r\nчего предлагаете свое видение ситуации', 1),
(220, 157, 'выслушиваете их ровно до тех пор, пока это целесообразно', 1),
(221, 157, 'высказываете родителям свою точку зрения на ситуацию,\r\nпосле чего выслушиваете их замечания и предложени', 1),
(222, 158, 'индивидуальная консультация', 1),
(223, 158, 'родительское собрание', 1),
(224, 158, 'проведение открытых уроков (внеучебных занятий) для родителей школьников', 1),
(225, 158, 'вызов родителей в школу', 0),
(226, 158, 'встреча с семьей в домашней обстановке', 1),
(227, 158, 'совместная подготовка и проведение внутриклассных дел и\r\nсобытий', 1),
(250, 168, 'не очень', 1),
(251, 168, 'нравится', 3),
(252, 168, 'не нравится', 0),
(253, 169, 'чаще хочется остаться дома', 0),
(254, 169, 'бывает по-разному', 1),
(255, 169, 'иду с радостью', 3),
(256, 170, 'не нравится', 3),
(257, 170, 'бывает по-разному', 1),
(258, 170, 'нравится', 0),
(259, 171, 'хотел бы', 0),
(260, 171, 'не хотел бы', 3),
(261, 171, 'не знаю', 1),
(262, 172, 'да', 3),
(263, 172, 'не очень', 1),
(264, 172, 'нет', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `classes`
--

INSERT INTO `classes` (`id`, `name`) VALUES
(1, '1A'),
(2, '2В'),
(4, '5А');

-- --------------------------------------------------------

--
-- Структура таблицы `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `Fio` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `parents`
--

INSERT INTO `parents` (`id`, `id_user`, `Fio`, `email`, `phone`) VALUES
(4, 52, 'Сергеев Виктор Фёдорович', 'test20@mail.ru', '79272298012');

-- --------------------------------------------------------

--
-- Структура таблицы `polls`
--

CREATE TABLE `polls` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `polls`
--

INSERT INTO `polls` (`id`, `title`) VALUES
(162, 'ВЗАИМОДЕЙСТВИЕ С СЕМЬЯМИ ШКОЛЬНИКОВ'),
(167, 'Оценка уровня школьной мотивации');

-- --------------------------------------------------------

--
-- Структура таблицы `poll_responses`
--

CREATE TABLE `poll_responses` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `answer` varchar(16000) DEFAULT NULL,
  `open_answer_points` int(11) DEFAULT 0,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `poll_responses`
--

INSERT INTO `poll_responses` (`id`, `poll_id`, `question_id`, `id_user`, `answer_id`, `answer`, `open_answer_points`, `date`) VALUES
(655, 162, 156, 38, 216, NULL, 0, '2023-06-15 17:10:34'),
(656, 162, 157, 38, 219, NULL, 0, '2023-06-15 17:10:34'),
(657, 162, 158, 38, 222, NULL, 0, '2023-06-15 17:10:34'),
(658, 162, 158, 38, 223, NULL, 0, '2023-06-15 17:10:34'),
(659, 162, 158, 38, 224, NULL, 0, '2023-06-15 17:10:34'),
(660, 162, 158, 38, 226, NULL, 0, '2023-06-15 17:10:34'),
(661, 162, 158, 38, 227, NULL, 0, '2023-06-15 17:10:34'),
(662, 167, 168, 38, 251, NULL, 0, '2023-06-16 14:00:38'),
(663, 167, 169, 38, 255, NULL, 0, '2023-06-16 14:00:38'),
(664, 167, 170, 38, 258, NULL, 0, '2023-06-16 14:00:38'),
(665, 167, 171, 38, 260, NULL, 0, '2023-06-16 14:00:38'),
(666, 167, 172, 38, 262, NULL, 0, '2023-06-16 14:00:38'),
(677, 167, 168, 61, 251, NULL, 0, '2023-06-16 22:59:37'),
(678, 167, 169, 61, 254, NULL, 0, '2023-06-16 22:59:37'),
(679, 167, 170, 61, 257, NULL, 0, '2023-06-16 22:59:37'),
(680, 167, 171, 61, 259, NULL, 0, '2023-06-16 22:59:37'),
(681, 167, 172, 61, 262, NULL, 0, '2023-06-16 22:59:37');

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `question` varchar(16000) NOT NULL,
  `answer_type` enum('scale','single_choice','multiple_choice','open_answer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `poll_id`, `question`, `answer_type`) VALUES
(156, 162, 'В общении с родителями школьника Вы, как правило:', 'single_choice'),
(157, 162, 'Рассматривая вместе с родителями школьную ситуацию их ребенка, Вы, как правило:', 'single_choice'),
(158, 162, 'Какие формы взаимодействия с родителями (лицами, их заменяющими) школьника Вы обычно используете в своей работе:', 'multiple_choice'),
(168, 167, 'Тебе нравится в школе?', 'single_choice'),
(169, 167, 'Утром, когда ты просыпаешься, ты всегда с радостью идёшь в школу или тебе часто хочется остаться дома?', 'single_choice'),
(170, 167, 'Тебе нравится, когда у вас отменяют какие-нибудь уроки?', 'single_choice'),
(171, 167, 'Ты хотел бы, чтобы тебе не задавали домашних заданий?', 'single_choice'),
(172, 167, 'Тебе нравятся твои одноклассники?', 'single_choice');

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `Fio` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `id_user`, `Fio`, `class_id`, `parent_id`) VALUES
(12, 12, 'Иванов Виктор Сергеевич', 1, 4),
(21, 61, 'Сергеев Максим Викторович', 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `Fio` varchar(255) NOT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `teachers`
--

INSERT INTO `teachers` (`id`, `id_user`, `Fio`, `class_id`) VALUES
(7, 14, 'Иванов Иван Иванович', 2),
(10, 17, 'Кирсанов Сергей Максимович', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('student','parent','teacher','admin') NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role`, `login`, `password`) VALUES
(12, 'student', 'student12', 'student'),
(14, 'teacher', 'asda', 'asd'),
(17, 'teacher', 'rrrrrrrrrr1', '$2y$10$u4bGT9l5GVpgI1eaK.Vak.IrNPymqFK/QkVEt81GSUO3g2I08egP.'),
(22, 'parent', 'rddr2', '$2y$10$IWA6nxGlv34rkeIRJSIc1eb1BSMmecnOweRjRry6Ktp6imSfxaJeW'),
(25, 'parent', 're', '$2y$10$ilRPv/md6.sUi2e6AjclfOimJNUzPT3bTZ9ZMaAzXjOjeoqmTznG6'),
(27, 'parent', 'rer', '$2y$10$OyX59K87e5bniq9Grj1ljuVYtOhfsyfvCfNIroxYPybN/XbUanPQi'),
(28, 'parent', 'rtt', '$2y$10$Ka/GT8KyDzO3ADl/QwSp1.rRwytQ6tZU0R9NcWa6i2iUfdJBkLujy'),
(31, 'parent', '123123', '$2y$10$8BFUMWc1xk/mFpoZRD40JuxcSZdK2/uIFwcbLTC3Rzpi3JLQYEpPm'),
(32, 'parent', '4444', '$2y$10$avTaFv.Pnu2vyZ.z5wry6.hcammJQjeEmkeoWIaA7BTqmcYUnPPw2'),
(33, 'parent', '44444', '$2y$10$iQf99mafgpMmkWcot6GrMOTUydrLd9eDoDM9lGHhKIqB7aZkrp.em'),
(34, 'student', 'User12345', '$2y$10$jOq8HtFJJmjQzRWRtzKnTevqL2XwUB3DLOvAepDNQKDKFgw...ksa'),
(35, 'student', '12', '$2y$10$GwQ5n5Gn9yhUvASmt9BMe.7WrpcULQE/VWDge3T/SbUjdWQeHZssu'),
(36, 'student', 'asdasdasd25', '$2y$10$xQudrDvFk54PZ10WLls.vOtNA8gaPx2U4ZMz6yTcitxr9gjidF2VS'),
(37, 'student', 'asdasdasd2', '$2y$10$CwzIdZhcUa5fPyrEqf5AkuRvyqwKmnrxZPMkOPabQgxPlHMxQSROK'),
(38, 'admin', 'NewAdmin', '$2y$10$GT65Gfw.nrNttjtpnvtVnu7.dbTN.ucUt/zfVE0CIXJ/VfPqjTN0u'),
(40, 'student', 'Student13', '$2y$10$YRLjeNG33pBZZZ.TJlkSBuh/FYaFHo4i2Vs5I3RA4KR9InGVlyg4O'),
(43, 'teacher', 'justUser231', '$2y$10$7t0x9Lo5/KthJ2mtxj2X9ekoQIZmuo5qjBwmw/au118nRyPNks3GS'),
(44, 'teacher', 'JustUser3333', '$2y$10$ahbbqE/yZSgi0VmFjVNrfO3VdKkSzHlNdp8btc0alpOVPzqjzyiyi'),
(45, 'teacher', 'JustUserTeacher1', '$2y$10$FFMNPISwVMseYk7RdOf7FeL2LZQwLv4YmuNEeLo4F.nxQd5lTeQrK'),
(48, 'teacher', 'NewIsUser123', '$2y$10$zIlT3xoVvH/Lz0YWy8r05eQwxHPAcfXtjASAU0GdLcPaElfN.56fy'),
(52, 'parent', 'JustStudentUser14', '$2y$10$LmoiFiLrRxg1MQHmy6CSKOtCwi.NN9EE3US2OkWfQooVvbIAJLjNK'),
(61, 'student', 'NewStudent1', '$2y$10$mbRshfs94e661qP65XLHTuShHs4xSg4rIeDtSZ0xa2Y9OqJT2I1m2');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`poll_id`),
  ADD KEY `poll_id` (`poll_id`);

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user_2` (`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Индексы таблицы `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Индексы таблицы `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Индексы таблицы `poll_responses`
--
ALTER TABLE `poll_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poll_id` (`poll_id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `answer_id` (`answer_id`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poll_id` (`poll_id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user_2` (`id_user`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Индексы таблицы `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `class_id` (`class_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `access`
--
ALTER TABLE `access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT для таблицы `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT для таблицы `poll_responses`
--
ALTER TABLE `poll_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=682;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `access_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `access_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `poll_responses`
--
ALTER TABLE `poll_responses`
  ADD CONSTRAINT `poll_responses_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `poll_responses_ibfk_4` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `poll_responses_ibfk_5` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `poll_responses_ibfk_6` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_3` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teachers_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
