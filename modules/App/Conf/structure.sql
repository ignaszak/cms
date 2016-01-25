USE @dbName@;


--
-- Table structure for table `categories`
--
CREATE TABLE `categories` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `parent_id` int(11) unsigned NOT NULL,
    `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `users`
--
CREATE TABLE `users` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `reg_date` datetime NOT NULL COMMENT 'Register date',
    `log_date` datetime NOT NULL COMMENT 'Last login date',
    `role` enum('admin','moderator','user','') COLLATE utf8_unicode_ci
        NOT NULL DEFAULT 'user' COMMENT 'admin|moderator|user',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `posts`
--
CREATE TABLE `posts` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `category_id` int(11) unsigned DEFAULT 1,
    `author_id` int(11) unsigned NOT NULL,
    `date` datetime NOT NULL,
    `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `content` longtext COLLATE utf8_unicode_ci NOT NULL,
    `public` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    INDEX `FK_POST_CAT` (`category_id`),
    INDEX `FK_POST_USER` (`author_id`),
    CONSTRAINT `FK_POST_CAT`
        FOREIGN KEY (`category_id`)
        REFERENCES `categories` (`id`)
        ON UPDATE NO ACTION
        ON DELETE SET NULL,
    CONSTRAINT `FK_POST_USER`
        FOREIGN KEY (`author_id`)
        REFERENCES `users` (`id`)
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `pages`
--
CREATE TABLE `pages` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `author_id` int(11) unsigned NOT NULL,
    `date` datetime DEFAULT NULL,
    `title` varchar(255) DEFAULT NULL,
    `alias` varchar(255) DEFAULT NULL,
    `content` longtext,
    `public` int(1) unsigned DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    INDEX `FK_PAGE_USER` (`author_id`),
    CONSTRAINT `FK_PAGE_USER`
        FOREIGN KEY (`author_id`)
        REFERENCES `users` (`id`)
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- Table structure for table `menus`
--
CREATE TABLE `menus` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `menu_items`
--
CREATE TABLE `menu_items` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `menu_id` int(11) unsigned NOT NULL,
    `sequence` int(3) unsigned NOT NULL,
    `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `adress` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    INDEX `FK_MENU_ITEMS_MENU` (`menu_id`),
    CONSTRAINT `FK_MENU_ITEMS_MENU`
        FOREIGN KEY (`menu_id`)
        REFERENCES `menus` (`id`)
        ON UPDATE NO ACTION
        ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `options`
--
CREATE TABLE `options` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `site_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `admin_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `view_limit` int(10) unsigned NOT NULL DEFAULT '10',
    `date_format` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'j.n.Y H:i',
    `base_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `request_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `theme` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'theme folder',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DELIMITER //
CREATE TRIGGER `set_default_cat_id_in_posts`
AFTER DELETE
    ON `categories` FOR EACH ROW
    BEGIN
        UPDATE `posts` SET `category_id` = 1 WHERE `category_id` IS NULL;
    END; //
DELIMITER ;
