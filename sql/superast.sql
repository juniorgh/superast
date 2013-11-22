DROP DATABASE IF EXISTS `superast`;
CREATE DATABASE `superast`;
USE `superast`;

CREATE TABLE `menu` (
    `menu_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `menu_name` VARCHAR(255),
    `menu_description` VARCHAR(255),
    `menu_page_title` VARCHAR(255),
    `menu_module` VARCHAR(255),
    `menu_controller` VARCHAR(255),
    `menu_action` VARCHAR(255),
    `menu_data_target` VARCHAR(255),
    `menu_icon_class` VARCHAR(255),
    `menu_parent` INT(10) UNSIGNED
)  ENGINE=InnoDB;

CREATE TABLE `firm` (
    `firm_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `firm_name` VARCHAR(255),
    `firm_active` TINYINT(1)
)  ENGINE=InnoDB AUTO_INCREMENT=2;

INSERT INTO `firm` (`firm_id`, `firm_name`, `firm_active`) VALUES
(1, 'Scitech', 1);

CREATE TABLE `role` (
    `role_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `role_description` VARCHAR(255),
    `role_active` TINYINT(1) DEFAULT 1
)  ENGINE=InnoDB AUTO_INCREMENT=2;

INSERT INTO `role` (`role_id`, `role_description`, `role_active`) VALUES
(1, 'Desenvolvedor', 1);

CREATE TABLE `user` (
    `user_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_name` VARCHAR(255),
    `user_login` VARCHAR(255),
    `user_password` VARCHAR(255),
    `user_role` INT(10) UNSIGNED,
    `user_active` TINYINT(1) DEFAULT 1
)  ENGINE=InnoDB AUTO_INCREMENT=2;

INSERT INTO `user` (`user_id`, `user_name`, `user_login`, `user_password`, `user_role`, `user_active`) VALUES
(1, 'William Urbano', 'william', MD5(123), 1, 1);

CREATE TABLE `group` (
    `group_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `group_name` VARCHAR(255),
    `group_active` TINYINT(1) DEFAULT 1
)  ENGINE=InnoDB AUTO_INCREMENT=2;

INSERT INTO `group` (`group_id`, `group_name`, `group_active`) VALUES
(1, 'Master', 1);

CREATE TABLE `user_group` (
    `user_group_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_group_user` INT(10) UNSIGNED NOT NULL,
    `user_group_group` INT(10) UNSIGNED NOT NULL
)  ENGINE=InnoDB AUTO_INCREMENT=2;

INSERT INTO `user_group` (`user_group_id`, `user_group_user`, `user_group_group`) VALUES 
(1, 1, 1);

CREATE TABLE `user_firm` (
    `user_firm_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_firm_user` INT(10) UNSIGNED NOT NULL,
    `user_firm_firm` INT(10) UNSIGNED NOT NULL
)  ENGINE=InnoDB;

CREATE TABLE `group_menu` (
    `group_menu_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `group_menu_group` INT(10) UNSIGNED NOT NULL,
    `group_menu_menu` INT(10) UNSIGNED NOT NULL
)  ENGINE=InnoDB;

CREATE TABLE `server` (
    `server_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `server_hostname` VARCHAR(255),
    `server_ip_address` VARCHAR(255),
    `server_database_user` VARCHAR(255),
    `server_database_password` VARCHAR(255),
    `server_asterisk_manager_user` VARCHAR(255),
    `server_asterisk_manager_secret` VARCHAR(255),
    `server_is_elastix` TINYINT(1) DEFAULT 0,
    `server_active` TINYINT(1) DEFAULT 1
)  ENGINE=InnoDB;

ALTER TABLE `user`
ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`user_role`) REFERENCES `role`(`role_id`) ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE `user_group`
ADD CONSTRAINT `fk_user_group_user` FOREIGN KEY (`user_group_user`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT `fk_user_group_group` FOREIGN KEY (`user_group_group`) REFERENCES `group`(`group_id`) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE `user_firm`
ADD CONSTRAINT `fk_user_firm_user` FOREIGN KEY (`user_firm_user`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT `fk_user_firm_firm` FOREIGN KEY (`user_firm_firm`) REFERENCES `firm`(`firm_id`) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE `group_menu`
ADD CONSTRAINT `fk_group_menu_group` FOREIGN KEY (`group_menu_group`) REFERENCES `group`(`group_id`) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT `fk_group_menu_menu` FOREIGN KEY (`group_menu_menu`) REFERENCES `menu`(`menu_id`) ON UPDATE CASCADE ON DELETE CASCADE;