-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2022 at 10:48 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `batato`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `chapter` decimal(10,0) NOT NULL,
  `user_id` int(11) NOT NULL,
  `data_path` text NOT NULL,
  `awaiting_approval` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `name`, `value`) VALUES
(1, 'url', 'http://localhost/FoOlSlideX-DexEdition/'),
(2, 'title', 'BATA.TO'),
(3, 'description', 'Read Manga Online'),
(4, 'cookie', 'bata'),
(5, 'captcha_enabled', '0'),
(6, 'captcha_key', ''),
(7, 'captcha_secret', ''),
(8, 'cache_enabled', '0'),
(9, 'default_theme', 'de_light'),
(10, 'default_language', 'en'),
(11, 'tailwind_type', 'cdn'),
(12, 'tailwind_url', ''),
(13, 'home_display_titles', '16'),
(14, 'home_display_chapters', '36'),
(15, 'site_started', '2022'),
(16, 'display_credits', '1');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `link` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `id` int(11) NOT NULL,
  `cover` varchar(4) NOT NULL,
  `title` varchar(100) NOT NULL,
  `alt_names` varchar(500) DEFAULT NULL,
  `authors` varchar(100) DEFAULT NULL,
  `artists` varchar(100) DEFAULT NULL,
  `genre` text NOT NULL,
  `original_language` varchar(20) NOT NULL,
  `original_work` int(1) DEFAULT NULL,
  `upload_status` int(1) DEFAULT NULL,
  `release_year` int(4) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`id`, `cover`, `title`, `alt_names`, `authors`, `artists`, `genre`, `original_language`, `original_work`, `upload_status`, `release_year`, `summary`, `timestamp`) VALUES
(1, 'jpeg', 'The Queen of Avalon', '아발론의 여왕, アヴァロンの女王, La reine Arthur d\'Avalon ', 'Rosiwon', 'Shyan', 'Manhwa, Webtoon, Shoujo, Adaptation, Drama, Fantasy, Full Color, Historical, Isekai, Magic, Romance', 'Korean', 1, 1, 2021, 'What if one day you found out to be sharing a soul with another person from a different time? And what if that person is no other than a historical figure ruling over the kingdom? Sian was living a tragic life. Her parents had passed away, and her uncle and aunt, who took her, treated her basely without showing any affection. Her day-to-day misery finally takes an upturn when she gets sucked into a fantastical world she only read about in her books. When she opens her eyes, she is holding an Excalibur in front of the people who are too dazed to speak. When they come to their senses, people start to call her Queen Arthur. Everything is a blur, and Sian can\'t make out what\'s happening until she learns she is sharing a soul with King Arthur Pendragon. Sian\'s adventure of becoming a queen begins, and it appears smooth sailing until she learns that she bears a mission, and that is to get a hold of the Holy Grail and correct the mistakes of King Arthur, ensuring that the people in the Kingdom of Britain will live happily ever after. Surrounded by her knights, the great wizard, and enemies, she sets out on the journey of becoming a wise and loving queen who wants to bring peace and happiness to this land.', '2022-10-07 19:36:01'),
(2, 'jpg', 'The Record of Fallen Vampire', 'Vampire Juuji Kai - Fallen Vampire, Fallen Vampire, Vampire Chronicles, ヴァンパイア十字界, 吸血十字界 ', 'Shirodaira Kyou', 'Shirodaira Kyou', 'Shounen, Action, Drama, Fantasy, Romance, Sci-Fi, Supernatural, Tragedy', 'Japanese', 2, 2, NULL, 'From Tsuzuku Jinsei o...: There is a legend that tells of how the world was almost destroyed thousands of years ago by the vampire queen after she unleashed her latent powers. Despite their efforts, the humans were unable to defeat her, and thus resorted to sealing her away until the time came that they would be powerful enough to destroy the seal and kill her. However, the humans are not the only ones after the seal. Having cast aside his kingdom and betraying his own race and the dhampirs (half-vampires), the vampire king is persistantly searching, even to this day, for where his queen has been sealed away so he may break the seal and free her before the humans do. Fearing that once the king and queen are reunited, they shall continue to destroy the world together, the humans and dhampirs hunt the king, using any method possible.', '2022-10-07 20:06:17'),
(3, 'jpg', 'The Peach of June', 'Peach of June, 유월의 복숭아', 'Yoo Paul-Hee', '38 (II)', 'Fantasy, Romance, Josei, Adaption, Full Color, Long Strip, Web Comic', 'Korean', 1, 0, 2022, 'Leah has been dreaming of a happy marriage. She has had two tries at her luck, but both times the engagements ended. When she got engaged for the third time she was determined that this time it was going to last. Even though she is determined, she keeps seeing a man called Julien with whom she got familiar prior to her engagement. Julien\'s proposal, combined with his kind personality and handsome face, made her swoon and she agreed to marry him.\r\n\r\nAfter their wedding, she was enjoying her honeymoon in Julien\'s estate, where she discovers traces of herself that she didn\'t know he had. She enters Julien\'s secret room that he had been hiding from her...', '2022-10-07 20:15:59'),
(4, 'jpeg', 'How To Survive Sleeping With The Emperor', '황제와의 잠자리에서 살아남는 법 ', '로판 (furnace sheet), ropan', '가쓸 (gossip)', 'Manhwa, Historical, Romance, Villainess', 'Korean', 1, 1, 2022, '\'It has been but several months ever since I became the Empress, and I\'ve never acceded to sleeping with the Emperor of the Empire.\' \"Dehardt.\" A mighty empire led by those of the inheritors of the [Gold Dragon Bloodline], and it is led by its ruler, \"Carmonde Dehardt\". \"Robelia Negrad (Dehardt)\", a princess from the Clan of Negrad, has married the Emperor of Dehardt and has now become its Empress. Now that she\'s the Empress, she must perform her duties of bearing an offspring to continue the Dehardt lineage. However, she finds herself in a situation where she has to avoid sleeping with Carmonde to avoid a deadlock on a \'mission\' she\'s tasked with. Will she be able to survive for long without spending a night with the Emperor and achieve her purpose? Or does fate have a different path in mind for her?', '2022-10-07 20:17:06'),
(5, 'jpeg', 'The Duke\'s Bored Daughter is My Master', '만렙 공녀는 오늘도 무료하다, 最強公女は今日も退屈です, 满级公女今天也很无聊, Tuan Putri Jagoan Sedang Bosan Hari Ini ', 'Royal b', 'Autumn', 'Manhwa, Webtoon, Shoujo, Adaptation, Childhood Friends, Comedy, Drama, Fantasy, Full Color, Historical, Reincarnation, Romance', 'Korean', 1, 1, 2022, 'I was an illegitimate daughter abandoned by the promiscuous emperor. From there, I ended up on the street where I learned that I had a knack for the sword. I competed in tournaments, became a mercenary, and I made a name for myself. Just when I had become the talk of the empire, the emperor wanted me back. In return, I demanded to be next in line for the throne. After years of hard work, I finally became empress and died happily. But here I am, alive again. Ugh, can’t a girl be left alone? This time, I’m going to be as lazy as I please!', '2022-10-07 20:18:50'),
(6, 'jpeg', 'The Archvillain\'s Daughter-In-Law', '시한부라서 흑막의-며느리가 되었는데, 余命わずかだから黒幕一家の嫁になったんだけど, ฉันกลายเป็นลูกสะใภ้จำกัดเวลาของตัวร้าย, 短命媳婦的逃跑計畫, 幕后黑手的短命儿媳, Menantu Tokoh Antagonis Punya Batasan Waktu ', 'Yunajin, Salty', 'Basak', 'Manhwa, Webtoon, Shoujo, Adaptation, Drama, Fantasy, Full Color, Historical, Isekai, Kids, Reincarnation, Romance', 'Korean', 2, 1, 2022, 'After losing her parents, Laria Losstree is saddled with a mountain of bills. Enter the archvillain, Duke Icardes, who agrees to pay off her debt, but only if she’ll marry his son, Evan. Cool and distant, he’s not exactly ideal husband material, but that’s okay, since Laria plans to secretly stash his money, then bounce! But when the duke starts acting suspiciously nice to her, Laria begins to wonder if he\'s on to her plan, and a battle of wits between archvillain and daughter-in-law begins!', '2022-10-07 20:22:05'),
(7, 'jpeg', '[ blank。]', NULL, 'Lins', 'Lins', 'Webtoon, Shoujo, Drama, Full Color, Mystery, Romance, Slice of Life', 'English', 1, 1, 2022, 'Is this my second chance at life? After waking from a 3-month coma, Nina doesn’t remember anything about herself. Not even her name. With no one looking for her, she only has one option: to start a new life. She’s more than ready to do so until the memory of someone abandoning her in a park haunts her. Can she handle the truth?', '2022-10-07 20:23:18'),
(8, 'jpeg', 'Kishin Kakka no Migawari Hanayome ~Yotsugi ga Dekitara Rien Desu~', '鬼神閣下の身代わり花嫁 〜世継ぎができたら離縁です〜 ', 'Hachikumo Rin', 'Hachikumo Rin', 'Manga, Josei, Smut, Romance', 'Japanese', 1, 1, 2022, 'Tsukiko is a young woman who has been a sickly and frail child, and is treated as ‘a good for nothing’. She becomes the replacement for her twin sister who was going to marry His Excellency, Kishi, a man who rose to become a Lieutenant General of the army at a young age. Due to his ruthlessness, he gained the nickname of ‘Demon God’. She met him once before, and his kindness became the one thing that supported her. But instead of that kindness, he bluntly says, ‘if you can fulfill your duty and give birth to a boy that will become my successor, I will divorce you without making a fuss.’', '2022-10-07 20:24:55'),
(9, 'jpeg', 'Tiger & Dragon', 'Taiga & Doragon, たいがー＆どらごん, Tiger & Dragon: A Love Story Between Three Childhood Friends ', 'Hoshino Mizuki', 'Hoshino Mizuki', 'Shoujo, Comedy, Romance, School Life, Slice of Life', 'Japanese', 1, 1, 2022, 'From Lovesick Alley: When Konomi and Tora were five, Tora moved away and got separated from Konomi. Ten years later, without any communication, Konomi decides to move on. Just as she declared it, her other childhood friend, Mikkun, asks her out! And right when she’s decided to consider Mikkun, Tora suddenly appears?! A crazy love triangle story between three childhood friends is set to take place!', '2022-10-07 20:28:10'),
(10, 'jpeg', 'After God', 'アフターゴッド ', 'Eno Sumi', 'Eno Sumi', 'Manga, Action, Drama, Psychological, Supernatural', 'Japanese', 1, 1, 2022, '“Once you regain consciousness, you and your friends will learn to fear me and obey me.” Japan has been invaded by Gods, leaving giant Danger Zones where once were cityscapes. While patrolling the area, Anti-God researcher Tokinaga discovers Kamikura Waka looking forlornly through the protective fence. In her eyes, he spots something deep and dangerous. Something capable of changing the world...', '2022-10-07 20:29:44'),
(11, 'jpeg', 'Völundio ~Divergent Sword Saga~ (Official)', 'Volundio - Divergent Sword Saga, Iken Senki Völundio, Helck: Völundio ~Surreal Sword Saga~, Iken Senki: Verndio, Verndio - Surreal Sword Saga, 異剣戦記ヴェルンディオ ', 'Nanao Nanaki', 'Nanao Nanaki', 'Manga, Action, Adventure, Comedy, Drama, Fantasy', 'Japanese', 1, 1, 2021, '“I want to live a peaceful and stable life! That’s my dream! That’s why I refuse to die here!” The latest title from the author of \"Helck\"! Cleo is a mercenary whose dream is to buy his own home and live peacefully. But while he’s fleeing from a group of bandits that were unexpectedly strong, he meets a mysterious demi-human girl named Kohaku that claims to have foreseen his death. And for some untold reason, she has also vowed to protect him from any and all danger. Will Cleo manage to survive and live his dream life?', '2022-10-07 20:30:57'),
(12, 'jpeg', 'Fall In The Night With You (Official)', 'Falling in the Night with You, Hei Ye You Suo Si, Heiye Yousuo Si, Hēi Yè Yǒu Suǒ Sī, Hēiyè Yǒusuǒ Sī, Nyx Stay Night, 黑夜有所斯, 黑夜有所斯 ~Nyx Stay Night~, 악마와 키스를 ', 'Hu Tao, Vedaccc', 'Hu Tao, Vedaccc', 'Manhua, Seinen, Shounen, Fantasy, Full Color, Magic, Mystery, Romance, Supernatural', 'Chinese', 1, 1, 2018, 'The sudden appearance of the amnestic witch Nyx brought a lot of changes to the young Ren Xi\'s life. The two supported each other to grow up and grew up in love. Ren Xi wanted to help Nyx recover the lost memory, but in the process of searching for the memory, he gradually discovered an amazing secret...', '2022-10-07 20:36:05'),
(13, 'jpeg', 'I\'m a Villainess But I Became a Mother', 'The Villainess Became a Mother, 悪女なのにママになりました, 악녀인데 엄마가 되어버렸다 ', '시세 (sisse)', '곰지 (gomji)', 'Manhwa, Shoujo, Full Color, Reincarnation, Romance, Royal family, Villainess', 'Korean', 1, 1, 2022, 'I reincarnated as the villainess of that novel? In that case, I will have to leave him before I get betrayed! \"Calix, let us break off this marriage.\" \"You cannot run from me, Loure.\" Even though he will end up choosing another woman... Why does he continue to haunt me? Then there’s the unexpected turn of events of getting pregnant with Calix\'s child... And so, once again, I naively had the fleeting thought that I would be able to live my days in happiness. What’s worse, I one day witnessed Calix kissing another woman. To protect the child in my womb, I abandoned everything and set off on a journey, still unaware of Calix\'s newfound irrational obsession...', '2022-10-07 20:37:28'),
(14, 'jpeg', 'Duchess Crow', 'The Raven Duchess, The Duchess\'s Jewel Story, 公爵夫人的宝石物语, 까마귀 공작 부인 ', 'Bittoru', 'Sbread', 'Manhwa, Webtoon, Shoujo, Drama, Fantasy, Full Color, Historical, Romance', 'Korean', 1, 1, 2021, 'Could love bedazzle like a gem? For Melisa, the best gemologist in Annabel, no love can outshine a gem. She\'d rather remain single and devoted to her career! But just when she thinks she has it all figured out, Duke Lewis Winterfelt, the most eligible bachelor in all the kingdom, asks for her hand in marriage — through a contract!', '2022-10-07 20:41:24'),
(15, 'jpeg', 'TOY XX BOX', '토이즈박스(TOY XX BOX) ', 'Pizzahooman', 'Pizzahooman', 'Manhwa, Webtoon, Yuri, Smut, Comedy, Drama, Full Color, Romance, Slice of Life', 'Korean', 1, 1, 2022, 'Taeyi has a reputation on campus for being extremely beautiful but a hard nut to crack. There’s a reason for that. She’d much rather enjoy the company of her toys than other people. She’s had enough of complicated and bothersome relationships with real humans. That is until a certain underclassman, Kim Ha-on, approaches her. After being convinced that she needs a partner to make the most of her new toy, she reluctantly let’s Ha-on in on her fun. But only on a strictly no strings attached basis! Things were supposed to be purely physical but it was only a matter of time before someone started to catch feelings… Will Ha-on become Taeyi’s new favorite toy or just be thrown back in the box with the rest of them?', '2022-10-07 20:42:54'),
(16, 'jpeg', 'A Princess\'s Guide to Saving Dragons', 'Dragon Raising Manual, Handbook for Feeding Dragon, Si Long Shou Ce, Sì Lóng Shǒu Cè, 饲龙手册 ', 'Pimo', 'Pimo', 'Manhua, Webtoon, Shoujo, Fantasy, Full Color, Historical, Isekai, Reincarnation, Romance, Supernatural', 'Chinese', 1, 1, 2021, 'Before the overworked Yumi Clarke took her last breath, she wished to be reborn as a fabulously wealthy person. So imagine her delight when she awoke in a video game as a princess! In true princess fashion, she gets rescued by a handsome stranger. But life in the castle is no ball when her brother is plotting to overthrow the emperor, a tyrant known for waging a war against dragons. Oh, and the stranger? His name’s Qastor Ace… the dragon prince! Can Yumi bring peace to these factions or does she need to learn how to reword her wishes better?', '2022-10-07 20:44:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
