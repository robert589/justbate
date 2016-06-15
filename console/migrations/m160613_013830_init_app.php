<?php

use yii\db\Migration;

class m160613_013830_init_app extends Migration
{
    private $template;

    public function up()
    {
        $this->execute($this->getTemplate());
    }

    public function down()
    {
        echo "m160613_013830_init_app cannot be reverted.\n";

        return false;
    }

    public function getTemplate(){
        return "-- phpMyAdmin SQL Dump
            -- version 4.1.14
            -- http://www.phpmyadmin.net
            --
            -- Host: localhost:3306
            -- Generation Time: Jun 15, 2016 at 06:21 PM
            -- Server version: 5.6.17
            -- PHP Version: 5.5.12

            SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
            SET time_zone = \"+00:00\";

            --
            -- Database: `startupapp`
            --

            -- --------------------------------------------------------

            --
            -- Table structure for table `auth_assignment`
            --

            CREATE TABLE IF NOT EXISTS `auth_assignment` (
              `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
              `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
              `created_at` int(11) DEFAULT NULL,
              PRIMARY KEY (`item_name`,`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            -- --------------------------------------------------------

            --
            -- Table structure for table `auth_item`
            --

            CREATE TABLE IF NOT EXISTS `auth_item` (
              `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
              `type` int(11) NOT NULL,
              `description` text COLLATE utf8_unicode_ci,
              `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
              `data` text COLLATE utf8_unicode_ci,
              `created_at` int(11) DEFAULT NULL,
              `updated_at` int(11) DEFAULT NULL,
              PRIMARY KEY (`name`),
              KEY `rule_name` (`rule_name`),
              KEY `idx-auth_item-type` (`type`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            -- --------------------------------------------------------

            --
            -- Table structure for table `auth_item_child`
            --

            CREATE TABLE IF NOT EXISTS `auth_item_child` (
              `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
              `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
              PRIMARY KEY (`parent`,`child`),
              KEY `child` (`child`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            -- --------------------------------------------------------

            --
            -- Table structure for table `auth_rule`
            --

            CREATE TABLE IF NOT EXISTS `auth_rule` (
              `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
              `data` text COLLATE utf8_unicode_ci,
              `created_at` int(11) DEFAULT NULL,
              `updated_at` int(11) DEFAULT NULL,
              PRIMARY KEY (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            -- --------------------------------------------------------

            --
            -- Table structure for table `child_comment`
            --

            CREATE TABLE IF NOT EXISTS `child_comment` (
              `comment_id` int(11) NOT NULL,
              `parent_id` int(11) NOT NULL,
              PRIMARY KEY (`comment_id`),
              KEY `parent_id` (`parent_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            -- --------------------------------------------------------

            --
            -- Table structure for table `choice`
            --

            CREATE TABLE IF NOT EXISTS `choice` (
              `choice_text` varchar(255) NOT NULL,
              `thread_id` int(11) NOT NULL,
              `choice_status` smallint(6) NOT NULL DEFAULT '10',
              `created_at` int(11) NOT NULL,
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`choice_text`,`thread_id`),
              KEY `thread_id` (`thread_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            -- --------------------------------------------------------

            --
            -- Table structure for table `comment`
            --

            CREATE TABLE IF NOT EXISTS `comment` (
              `comment_id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `created_at` int(11) NOT NULL,
              `comment` text NOT NULL,
              `updated_at` int(11) DEFAULT NULL,
              `comment_status` smallint(6) NOT NULL DEFAULT '10',
              PRIMARY KEY (`comment_id`),
              KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=758 ;

            -- --------------------------------------------------------

            --
            -- Table structure for table `comment_vote`
            --

            CREATE TABLE IF NOT EXISTS `comment_vote` (
              `user_id` int(11) NOT NULL,
              `comment_id` int(11) NOT NULL,
              `vote` tinyint(4) NOT NULL,
              `created_at` int(11) NOT NULL,
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`user_id`,`comment_id`),
              KEY `comment_id` (`comment_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            -- --------------------------------------------------------

            --
            -- Table structure for table `email_validation_token`
            --

            CREATE TABLE IF NOT EXISTS `email_validation_token` (
              `user_id` int(11) NOT NULL,
              `code` varchar(255) NOT NULL,
              `email` varchar(255) NOT NULL,
              `created_at` int(11) NOT NULL,
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`user_id`),
              KEY `email` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            -- --------------------------------------------------------

            --
            -- Table structure for table `follower_relation`
            --

            CREATE TABLE IF NOT EXISTS `follower_relation` (
              `follower_id` int(11) NOT NULL,
              `followee_id` int(11) NOT NULL,
              `created_at` int(11) NOT NULL,
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`follower_id`,`followee_id`),
              KEY `followee_id` (`followee_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            -- --------------------------------------------------------

            --
            -- Table structure for table `issue`
            --

            CREATE TABLE IF NOT EXISTS `issue` (
              `issue_name` char(255) NOT NULL,
              `issue_description` text NOT NULL,
              `created_at` int(11) NOT NULL,
              `issue_status` smallint(6) DEFAULT '10',
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`issue_name`),
              UNIQUE KEY `issue_name` (`issue_name`),
              UNIQUE KEY `issue_name_2` (`issue_name`),
              KEY `tag_name` (`issue_name`),
              KEY `tag_name_2` (`issue_name`),
              KEY `tag_name_3` (`issue_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            -- --------------------------------------------------------

            --
            -- Table structure for table `menu`
            --

            CREATE TABLE IF NOT EXISTS `menu` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(128) NOT NULL,
              `parent` int(11) DEFAULT NULL,
              `route` varchar(255) DEFAULT NULL,
              `order` int(11) DEFAULT NULL,
              `data` blob,
              PRIMARY KEY (`id`),
              KEY `parent` (`parent`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

            -- --------------------------------------------------------

            --
            -- Table structure for table `migration`
            --

            CREATE TABLE IF NOT EXISTS `migration` (
              `version` varchar(180) NOT NULL,
              `apply_time` int(11) DEFAULT NULL,
              PRIMARY KEY (`version`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            -- --------------------------------------------------------

            --
            -- Table structure for table `notification`
            --

            CREATE TABLE IF NOT EXISTS `notification` (
              `notification_id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `description` text NOT NULL,
              `created_at` int(11) NOT NULL,
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`notification_id`),
              KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=719 ;

            -- --------------------------------------------------------

            --
            -- Table structure for table `thread`
            --

            CREATE TABLE IF NOT EXISTS `thread` (
              `thread_id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `title` varchar(255) DEFAULT NULL,
              `created_at` int(11) NOT NULL,
              `anonymous` tinyint(1) DEFAULT '0',
              `thread_status` smallint(6) NOT NULL DEFAULT '10',
              `description` text NOT NULL,
              `type` varchar(255) NOT NULL DEFAULT 'GENERAL',
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`thread_id`),
              KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=118 ;

            -- --------------------------------------------------------

            --
            -- Table structure for table `thread_comment`
            --

            CREATE TABLE IF NOT EXISTS `thread_comment` (
              `comment_id` int(11) NOT NULL,
              `choice_text` varchar(255) NOT NULL,
              `thread_id` int(11) NOT NULL,
              PRIMARY KEY (`comment_id`),
              KEY `choice_text` (`choice_text`,`thread_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            -- --------------------------------------------------------

            --
            -- Table structure for table `thread_issue`
            --

            CREATE TABLE IF NOT EXISTS `thread_issue` (
              `issue_name` varchar(255) NOT NULL,
              `thread_id` int(11) NOT NULL,
              `created_at` int(11) NOT NULL,
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`issue_name`,`thread_id`),
              KEY `thread_id` (`thread_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            -- --------------------------------------------------------

            --
            -- Table structure for table `thread_vote`
            --

            CREATE TABLE IF NOT EXISTS `thread_vote` (
              `user_id` int(11) NOT NULL,
              `thread_id` int(11) NOT NULL,
              `choice_text` varchar(255) NOT NULL,
              `created_at` int(11) NOT NULL,
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`user_id`,`thread_id`,`choice_text`),
              KEY `thread_id` (`thread_id`,`choice_text`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            -- --------------------------------------------------------

            --
            -- Table structure for table `user`
            --

            CREATE TABLE IF NOT EXISTS `user` (
              `photo_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.png',
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
              `status` smallint(6) NOT NULL DEFAULT '10',
              `created_at` int(11) NOT NULL,
              `updated_at` int(11) NOT NULL,
              `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `notif_last_seen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `reputation` int(11) NOT NULL DEFAULT '0',
              `facebook_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `username` (`username`),
              UNIQUE KEY `facebook_id` (`facebook_id`),
              KEY `photo_unique_id` (`photo_path`(1)),
              KEY `fk_per_photo` (`photo_path`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=76 ;

            -- --------------------------------------------------------

            --
            -- Table structure for table `user_email_authentication`
            --

            CREATE TABLE IF NOT EXISTS `user_email_authentication` (
              `user_id` int(11) NOT NULL,
              `password_hash` varchar(255) DEFAULT NULL,
              `password_reset_token` varchar(255) DEFAULT NULL,
              `primary_email` tinyint(4) NOT NULL DEFAULT '1',
              `email` varchar(100) NOT NULL,
              `validated` tinyint(4) NOT NULL DEFAULT '0',
              `created_at` int(11) NOT NULL,
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`user_id`),
              UNIQUE KEY `email` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            -- --------------------------------------------------------

            --
            -- Table structure for table `user_followed_issue`
            --

            CREATE TABLE IF NOT EXISTS `user_followed_issue` (
              `issue_name` varchar(255) NOT NULL,
              `user_id` int(11) NOT NULL,
              `created_at` int(11) NOT NULL,
              `updated_at` int(11) NOT NULL,
              PRIMARY KEY (`issue_name`,`user_id`),
              KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

            --
            -- Constraints for dumped tables
            --

            --
            -- Constraints for table `auth_assignment`
            --
            ALTER TABLE `auth_assignment`
              ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

            --
            -- Constraints for table `auth_item`
            --
            ALTER TABLE `auth_item`
              ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

            --
            -- Constraints for table `auth_item_child`
            --
            ALTER TABLE `auth_item_child`
              ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

            --
            -- Constraints for table `child_comment`
            --
            ALTER TABLE `child_comment`
              ADD CONSTRAINT `child_comment_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `thread_comment` (`comment_id`);

            --
            -- Constraints for table `choice`
            --
            ALTER TABLE `choice`
              ADD CONSTRAINT `choice_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`);

            --
            -- Constraints for table `comment`
            --
            ALTER TABLE `comment`
              ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

            --
            -- Constraints for table `comment_vote`
            --
            ALTER TABLE `comment_vote`
              ADD CONSTRAINT `comment_vote_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
              ADD CONSTRAINT `comment_vote_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`comment_id`);

            --
            -- Constraints for table `email_validation_token`
            --
            ALTER TABLE `email_validation_token`
              ADD CONSTRAINT `email_validation_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_email_authentication` (`user_id`),
              ADD CONSTRAINT `email_validation_token_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user_email_authentication` (`email`);

            --
            -- Constraints for table `follower_relation`
            --
            ALTER TABLE `follower_relation`
              ADD CONSTRAINT `follower_relation_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `user` (`id`),
              ADD CONSTRAINT `follower_relation_ibfk_2` FOREIGN KEY (`followee_id`) REFERENCES `user` (`id`);

            --
            -- Constraints for table `menu`
            --
            ALTER TABLE `menu`
              ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

            --
            -- Constraints for table `notification`
            --
            ALTER TABLE `notification`
              ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

            --
            -- Constraints for table `thread`
            --
            ALTER TABLE `thread`
              ADD CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

            --
            -- Constraints for table `thread_comment`
            --
            ALTER TABLE `thread_comment`
              ADD CONSTRAINT `thread_comment_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`comment_id`),
              ADD CONSTRAINT `thread_comment_ibfk_2` FOREIGN KEY (`choice_text`, `thread_id`) REFERENCES `choice` (`choice_text`, `thread_id`);

            --
            -- Constraints for table `thread_issue`
            --
            ALTER TABLE `thread_issue`
              ADD CONSTRAINT `thread_issue_ibfk_1` FOREIGN KEY (`issue_name`) REFERENCES `issue` (`issue_name`),
              ADD CONSTRAINT `thread_issue_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`thread_id`);

            --
            -- Constraints for table `thread_vote`
            --
            ALTER TABLE `thread_vote`
              ADD CONSTRAINT `thread_vote_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
              ADD CONSTRAINT `thread_vote_ibfk_2` FOREIGN KEY (`thread_id`, `choice_text`) REFERENCES `choice` (`thread_id`, `choice_text`);

            --
            -- Constraints for table `user_email_authentication`
            --
            ALTER TABLE `user_email_authentication`
              ADD CONSTRAINT `user_email_authentication_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

            --
            -- Constraints for table `user_followed_issue`
            --
            ALTER TABLE `user_followed_issue`
              ADD CONSTRAINT `user_followed_issue_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
            ";
    }
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
