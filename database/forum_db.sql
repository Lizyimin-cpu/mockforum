/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : forum_db

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2024-01-14 06:33:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('7', 'Books', 'Record the books you have read, want to read, and are currently reading. Rate, tag, add personal notes, and write reviews. Get book recommendations based on your taste.', '2024-01-14 05:30:48', './assets/uploads/240113/logo.png', '1');
INSERT INTO `categories` VALUES ('8', 'Local Events', 'Provides information about offline activities such as music, theater, lectures, gatherings, travel, etc., and recommends good events based on your taste to help you meet like-minded people.', '2024-01-14 05:30:46', './assets/uploads/240114/smile.jpg', '1');
INSERT INTO `categories` VALUES ('9', 'Music', 'Record albums you want to listen to, are listening to, and have listened to. Rate, tag, add personal notes, and write reviews. Get album recommendations based on your taste.', '2024-01-14 05:30:45', './assets/uploads/240113/a.jpg', '1');
INSERT INTO `categories` VALUES ('10', 'Movies', 'Find the latest movie introductions and reviews, including screening information and ticket services. Track movies and shows you want to watch, are watching, and have watched, rate and write reviews. Get movie recommendations based on your taste.', '2024-01-14 05:30:43', './assets/uploads/240114/logo.png', '1');
INSERT INTO `categories` VALUES ('11', 'Food', 'Share delicious food.', '2024-01-14 05:38:30', './assets/uploads/240114/dog.jpg', '2');
INSERT INTO `categories` VALUES ('12', 'Shopping', 'Share beautiful things for those who love life.', '2024-01-14 05:38:03', './assets/uploads/240114/dog.jpg', '1');
INSERT INTO `categories` VALUES ('13', 'Lifestyle', 'Share daily life and discover a wonderful world.', '2024-01-14 05:56:22', './assets/uploads/240114/pig.jpg', '1');
INSERT INTO `categories` VALUES ('14', 'Dentistry', 'Share dental tips.', '2024-01-14 06:08:18', './assets/uploads/240114/c.jpg', '11');

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `topic_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of comments
-- ----------------------------
INSERT INTO `comments` VALUES ('8', '7', '1', 'It’s amazing to do it yourself!', '2024-01-14 05:45:11', '2024-01-14 05:45:11');
INSERT INTO `comments` VALUES ('9', '7', '3', 'Thanks for sharing, saved!', '2024-01-14 05:46:17', '2024-01-14 05:46:17');
INSERT INTO `comments` VALUES ('10', '7', '4', 'Post more, I’m learning!', '2024-01-14 05:46:50', '2024-01-14 05:46:50');
INSERT INTO `comments` VALUES ('11', '8', '4', 'This book is great', '2024-01-14 05:50:50', '2024-01-14 05:50:50');
INSERT INTO `comments` VALUES ('12', '8', '1', 'Nice!', '2024-01-14 05:51:10', '2024-01-14 05:51:10');
INSERT INTO `comments` VALUES ('13', '9', '1', 'The teacher ended up so tragically...', '2024-01-14 05:53:25', '2024-01-14 05:53:25');
INSERT INTO `comments` VALUES ('14', '10', '1', 'Any suggestions on cleaning schedules for teeth?', '2024-01-14 05:58:39', '2024-01-14 05:58:39');
INSERT INTO `comments` VALUES ('15', '10', '2', 'What to do if my last molar always has a black spot?', '2024-01-14 05:59:10', '2024-01-14 05:59:10');
INSERT INTO `comments` VALUES ('16', '10', '3', 'Do you recommend using mouthwash?', '2024-01-14 05:59:49', '2024-01-14 05:59:49');
INSERT INTO `comments` VALUES ('17', '10', '4', 'My molar has interproximal caries; should I see another doctor?', '2024-01-14 06:00:18', '2024-01-14 06:00:18');
INSERT INTO `comments` VALUES ('18', '10', '9', 'Is a water flosser necessary?', '2024-01-14 06:00:44', '2024-01-14 06:00:44');
INSERT INTO `comments` VALUES ('19', '11', '1', 'Handmade noodles, amazing!', '2024-01-14 06:10:12', '2024-01-14 06:10:12');
INSERT INTO `comments` VALUES ('20', '11', '3', 'So great, wishing grandma a long life!', '2024-01-14 06:10:34', '2024-01-14 06:10:34');

-- ----------------------------
-- Table structure for forum_views
-- ----------------------------
DROP TABLE IF EXISTS `forum_views`;
CREATE TABLE `forum_views` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `topic_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of forum_views
-- ----------------------------
INSERT INTO `forum_views` VALUES ('13', '7', '1');
INSERT INTO `forum_views` VALUES ('14', '7', '3');
INSERT INTO `forum_views` VALUES ('15', '7', '4');
INSERT INTO `forum_views` VALUES ('16', '8', '1');
INSERT INTO `forum_views` VALUES ('17', '9', '1');
INSERT INTO `forum_views` VALUES ('18', '10', '1');
INSERT INTO `forum_views` VALUES ('19', '10', '2');
INSERT INTO `forum_views` VALUES ('20', '10', '3');
INSERT INTO `forum_views` VALUES ('21', '10', '4');
INSERT INTO `forum_views` VALUES ('22', '10', '9');
INSERT INTO `forum_views` VALUES ('23', '10', '7');
INSERT INTO `forum_views` VALUES ('24', '10', '14');
INSERT INTO `forum_views` VALUES ('25', '11', '1');
INSERT INTO `forum_views` VALUES ('26', '11', '3');

-- ----------------------------
-- Table structure for replies
-- ----------------------------
DROP TABLE IF EXISTS `replies`;
CREATE TABLE `replies` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `comment_id` int(30) NOT NULL,
  `reply` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of replies
-- ----------------------------
INSERT INTO `replies` VALUES ('11', '8', 'Haha! Healthy and delicious at a good price!', '2', '2024-01-14 05:45:34', '2024-01-14 05:45:34');
INSERT INTO `replies` VALUES ('12', '14', 'Once every six months to a year, for those who are healthy, usually once a year.', '11', '2024-01-14 06:01:25', '2024-01-14 06:01:25');
INSERT INTO `replies` VALUES ('13', '15', 'Is the black spot on the surface you bite with? You could use a toothpick to check if it’s hard.', '11', '2024-01-14 06:01:53', '2024-01-14 06:01:53');
INSERT INTO `replies` VALUES ('14', '16', 'Unless prescribed by a doctor, generally, no need for mouthwash.', '11', '2024-01-14 06:02:02', '2024-01-14 06:02:02');
INSERT INTO `replies` VALUES ('15', '17', 'Have you had X-rays? Small cavities might not need treatment yet, just floss regularly.', '11', '2024-01-14 06:02:24', '2024-01-14 06:02:24');
INSERT INTO `replies` VALUES ('16', '17', 'Thanks, friend. Now I can’t go without floss.', '4', '2024-01-14 06:03:38', '2024-01-14 06:03:38');
INSERT INTO `replies` VALUES ('17', '17', 'I have a wisdom tooth that’s never hurt. Should it be removed?', '7', '2024-01-14 06:04:53', '2024-01-14 06:04:53');
INSERT INTO `replies` VALUES ('18', '17', 'Not having a baby, so maybe it’s not necessary.', '14', '2024-01-14 06:05:49', '2024-01-14 06:05:49');
INSERT INTO `replies` VALUES ('19', '17', 'If it’s straight and healthy, no need to worry; just monitor it.', '11', '2024-01-14 06:06:17', '2024-01-14 06:06:17');

-- ----------------------------
-- Table structure for system_settings
-- ----------------------------
DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE `system_settings` (
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `about` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of system_settings
-- ----------------------------
INSERT INTO `system_settings` VALUES ('Simple Forum System', '3062015463@qq.com', '3062015463', 'A simple forum system', './assets/uploads/240114/logo.png', '<a href=\'https://hpc.baicaitang.cn\'>@hpc Site</a>');

-- ----------------------------
-- Table structure for topics
-- ----------------------------
DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `category_ids` text NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of topics
-- ----------------------------
INSERT INTO `topics` VALUES ('7', '11', 'I made six months of weight-loss meals for myself (Lunch part)', '<p>Since April 2023, I have been preparing weight-loss meals for all three meals a day. My weight has transitioned smoothly from 102 pounds to 95 pounds without any pain, feeling lighter and more comfortable...</p>', '2', '2024-01-14 05:44:50');
INSERT INTO `topics` VALUES ('8', '7', 'You may not have seen the movie "Full River Red", but you should check out this book', '<p>This book was a thorough read for me. It’s often that books like this exaggerate characters...</p>', '4', '2024-01-14 05:49:50');
INSERT INTO `topics` VALUES ('9', '10', 'Reflections on "Monster" | Talking with Director Hirokazu Koreeda', '<p>I love the narrative style of this film. It unfolds in three chapters, using three perspectives to clarify a single storyline...</p>', '9', '2024-01-14 05:53:00');
INSERT INTO `topics` VALUES ('10', '14,13', 'Dental Tips from a Dental Graduate Student', '<p>Friends, please consider my replies carefully...</p>', '11', '2024-01-14 05:58:24');
INSERT INTO `topics` VALUES ('11', '13,11', 'Mom taught me to make longevity noodles for Grandma', '<span>Grandma was happy to eat the noodles I made.</span><p>Today is Grandma’s 82nd birthday...</p>', '4', '2024-01-14 06:09:59');
INSERT INTO `topics` VALUES ('12', '7', 'Thoughts on Four Recent Chinese Sci-Fi Short Story Collections', '<p>Recently, I read four Chinese sci-fi short story collections...</p>', '3', '2024-01-14 06:11:28');
INSERT INTO `topics` VALUES ('13', '13', 'Good Book Sharing - E-Book Sharing Topic', '<p>Hi, everyone~</p><p>If you frequently browse this group, my ID might look familiar...</p>', '14', '2024-01-14 06:12:20');
INSERT INTO `topics` VALUES ('14', '10', '"Wonka" - A Traditional Fairy Tale', '<p>Today, I watched the newly released movie <span><b>Wonka</b></span>. I actually liked it...</p>', '14', '2024-01-14 06:14:18');
INSERT INTO `topics` VALUES ('15', '10', '10 Things You Didn’t Know About "Free Guy"', '<p>1. Hugh Jackman, Dwayne Johnson, John Krasinski (from "A Quiet Place"), Tina Fey...</p>', '14', '2024-01-14 06:16:30');
INSERT INTO `topics` VALUES ('16', '8,13', 'Hiking Hong Kong’s MacLehose Trail, Forward from Stage 1 & 2 + Tap Mun Island for 2 Days', '<span>A spontaneous trip</span><br><span>Don’t let time and cost stop you</span>', '4', '2024-01-14 06:18:24');
INSERT INTO `topics` VALUES ('17', '8,13', 'Climbing the Highest Peak in Guangzhou Every Wednesday, Saturday, Sunday', '<span>Highlight 1: Climb the highest peak in Guangzhou</span><br><span>Highlight 2: Embrace the wilderness...</span>', '4', '2024-01-14 06:19:49');
INSERT INTO `topics` VALUES ('18', '13', 'Recommended Photo Editing Apps for Phones?', '<span>Mainly for removing objects in photos</span>', '9', '2024-01-14 06:21:56');
INSERT INTO `topics` VALUES ('19', '13', 'Recommend an app for health tracking', '<span>Mainly to record weight, blood pressure, and blood sugar</span>', '9', '2024-01-14 06:22:38');
INSERT INTO `topics` VALUES ('20', '13', 'These Liquids Can Actually Be Carried on Planes', '<span>Reposted from SkyScanner</span>', '2', '2024-01-14 06:24:12');
INSERT INTO `topics` VALUES ('21', '13', 'How to Decorate to Make a Room Feel Cozy?', '<p>Just rented an old house. The furniture is a bit old, the house is small. How to make it feel warmer and more comfortable?</p>', '2', '2024-01-14 06:27:49');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '3' COMMENT '1=Admin,2=Staff, 3= subscriber',
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1', '');
INSERT INTO `users` VALUES ('2', 'user1', 'user1', 'e10adc3949ba59abbe56e057f20f883e', '2', '');
INSERT INTO `users` VALUES ('3', 'user2', 'user2', 'e10adc3949ba59abbe56e057f20f883e', '3', '');
INSERT INTO `users` VALUES ('4', 'user3', 'user3', 'e10adc3949ba59abbe56e057f20f883e', '3', '');
INSERT INTO `users` VALUES ('9', 'user4', 'user4', 'e10adc3949ba59abbe56e057f20f883e', '3', '');
INSERT INTO `users` VALUES ('11', 'user5', 'user5', 'e10adc3949ba59abbe56e057f20f883e', '3', '');
INSERT INTO `users` VALUES ('12', 'user6', 'user6', 'e10adc3949ba59abbe56e057f20f883e', '3', '');
INSERT INTO `users` VALUES ('13', 'user7', 'user7', 'e10adc3949ba59abbe56e057f20f883e', '3', '');
INSERT INTO `users` VALUES ('14', 'user8', 'user8', 'e10adc3949ba59abbe56e057f20f883e', '3', '');

SET FOREIGN_KEY_CHECKS=1;
