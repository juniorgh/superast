DROP DATABASE IF EXISTS `asteriskcdrdb`;

CREATE DATABASE `asteriskcdrdb`;

USE `asteriskcdrdb`;

CREATE TABLE `cdr` (
    `id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `calldate` datetime NOT NULL default '0000-00-00 00:00:00',
    `clid` varchar(80) NOT NULL default '',
    `src` varchar(80) NOT NULL default '',
    `dst` varchar(80) NOT NULL default '',
    `dcontext` varchar(80) NOT NULL default '', 
    `channel` varchar(80) NOT NULL default '',
    `dstchannel` varchar(80) NOT NULL default '',
    `lastapp` varchar(80) NOT NULL default '',
    `lastdata` varchar(80) NOT NULL default '',
    `duration` int(11) NOT NULL default '0',
    `billsec` int(11) NOT NULL default '0',
    `disposition` varchar(45) NOT NULL default '', 
    `amaflags` int(11) NOT NULL default '0',
    `accountcode` varchar(20) NOT NULL default '',
    `userfield` varchar(255) NOT NULL default '',
    `uniqueid` VARCHAR(32) NOT NULL default '',
    `linkedid` VARCHAR(32) NOT NULL default '',
    `sequence` VARCHAR(32) NOT NULL default '',
    `peeraccount` VARCHAR(32) NOT NULL default ''
) ENGINE=InnoDB;

ALTER TABLE `cdr` ADD INDEX (`calldate`);
ALTER TABLE `cdr` ADD INDEX (`dst`);
ALTER TABLE `cdr` ADD INDEX (`accountcode`);