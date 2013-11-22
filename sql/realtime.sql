DROP DATABASE IF EXISTS `asteriskrealtime`;

CREATE DATABASE `asteriskrealtime`;

USE `asteriskrealtime`;

CREATE TABLE `sip_buddies` (
   `id` int(11) NOT NULL auto_increment,
   `name` VARCHAR(80) NOT NULL,
   `callerid` VARCHAR(80) DEFAULT NULL,
   `DEFAULTuser` VARCHAR(80) NOT NULL,
   `regexten` VARCHAR(80) NOT NULL,
   `secret` VARCHAR(80) DEFAULT NULL,
   `mailbox` VARCHAR(50) DEFAULT NULL,
   `accountcode` VARCHAR(20) DEFAULT NULL,
   `context` VARCHAR(80) DEFAULT NULL,
   `amaflags` VARCHAR(7) DEFAULT NULL,
   `callgroup` VARCHAR(10) DEFAULT NULL,
   `canreinvite` CHAR(3) DEFAULT 'yes',
   `DEFAULTip` VARCHAR(15) DEFAULT NULL,
   `dtmfmode` VARCHAR(7) DEFAULT NULL,
   `fromuser` VARCHAR(80) DEFAULT NULL,
   `fromdomain` VARCHAR(80) DEFAULT NULL,
   `fullcontact` VARCHAR(80) DEFAULT NULL,
   `host` VARCHAR(31) NOT NULL,
   `insecure` VARCHAR(4) DEFAULT NULL,
   `language` CHAR(2) DEFAULT NULL,
   `md5secret` VARCHAR(80) DEFAULT NULL,
   `nat` VARCHAR(5) NOT NULL DEFAULT 'no',
   `deny` VARCHAR(95) DEFAULT NULL,
   `permit` VARCHAR(95) DEFAULT NULL,
   `mask` VARCHAR(95) DEFAULT NULL,
   `pickupgroup` VARCHAR(10) DEFAULT NULL,
   `port` VARCHAR(5) NOT NULL,
   `qualify` CHAR(3) DEFAULT NULL,
   `restrictcid` CHAR(1) DEFAULT NULL,
   `rtptimeout` CHAR(3) DEFAULT NULL,
   `rtpholdtimeout` CHAR(3) DEFAULT NULL,
   `type` VARCHAR(6) NOT NULL DEFAULT 'friend',
   `disallow` VARCHAR(100) DEFAULT 'all',
   `allow` VARCHAR(100) DEFAULT 'g729;ilbc;gsm;ulaw;alaw',
   `musiconhold` VARCHAR(100) DEFAULT NULL,
   `regseconds` int(11) NOT NULL DEFAULT '0',
   `ipaddr` VARCHAR(15) NOT NULL,
   `cancallforward` CHAR(3) DEFAULT 'yes',
   `lastms` int(11) NOT NULL,
   `useragent` CHAR(255) DEFAULT NULL,
   `regserver` VARCHAR(100) DEFAULT NULL,
   PRIMARY KEY  (`id`),
   UNIQUE KEY `name` (`name`),
   KEY `name_2` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `extensions` (
   `id` int(11) NOT NULL auto_increment,
   `context` VARCHAR(20) NOT NULL DEFAULT '',
   `exten` VARCHAR(20) NOT NULL DEFAULT '',
   `priority` tinyint(4) NOT NULL DEFAULT '0',
   `app` VARCHAR(20) NOT NULL DEFAULT '',
   `appdata` VARCHAR(128) NOT NULL DEFAULT '',
   PRIMARY KEY  (`context`,`exten`,`priority`),
   KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `voicemail_users` (
   `uniqueid` int(11) NOT NULL auto_increment,
   `customer_id` VARCHAR(11) NOT NULL DEFAULT '0',
   `context` VARCHAR(50) NOT NULL,
   `mailbox` VARCHAR(11) NOT NULL DEFAULT '0',
   `password` VARCHAR(5) NOT NULL DEFAULT '0',
   `fullname` VARCHAR(150) NOT NULL,
   `email` VARCHAR(50) NOT NULL,
   `pager` VARCHAR(50) NOT NULL,
   `tz` VARCHAR(10) NOT NULL DEFAULT 'central',
   `attach` VARCHAR(4) NOT NULL DEFAULT 'yes',
   `saycid` VARCHAR(4) NOT NULL DEFAULT 'yes',
   `dialout` VARCHAR(10) NOT NULL,
   `callback` VARCHAR(10) NOT NULL,
   `review` VARCHAR(4) NOT NULL DEFAULT 'no',
   `operator` VARCHAR(4) NOT NULL DEFAULT 'no',
   `envelope` VARCHAR(4) NOT NULL DEFAULT 'no',
   `sayduration` VARCHAR(4) NOT NULL DEFAULT 'no',
   `saydurationm` tinyint(4) NOT NULL DEFAULT '1',
   `sendvoicemail` VARCHAR(4) NOT NULL DEFAULT 'no',
   `delete` VARCHAR(4) NOT NULL DEFAULT 'no',
   `nextaftercmd` VARCHAR(4) NOT NULL DEFAULT 'yes',
   `forcename` VARCHAR(4) NOT NULL DEFAULT 'no',
   `forcegreetings` VARCHAR(4) NOT NULL DEFAULT 'no',
   `hidefromdir` VARCHAR(4) NOT NULL DEFAULT 'yes',
   `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   PRIMARY KEY  (`uniqueid`),
   KEY `mailbox_context` (`mailbox`,`context`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `queue_table` (
   `name` VARCHAR(128) NOT NULL,
   `musiconhold` VARCHAR(128) DEFAULT NULL,
   `announce` VARCHAR(128) DEFAULT NULL,
   `context` VARCHAR(128) DEFAULT NULL,
   `timeout` int(11) DEFAULT NULL,
   `monitor_join` tinyint(1) DEFAULT NULL,
   `monitor_format` VARCHAR(128) DEFAULT NULL,
   `queue_youarenext` VARCHAR(128) DEFAULT NULL,
   `queue_thereare` VARCHAR(128) DEFAULT NULL,
   `queue_callswaiting` VARCHAR(128) DEFAULT NULL,
   `queue_holdtime` VARCHAR(128) DEFAULT NULL,
   `queue_minutes` VARCHAR(128) DEFAULT NULL,
   `queue_seconds` VARCHAR(128) DEFAULT NULL,
   `queue_lessthan` VARCHAR(128) DEFAULT NULL,
   `queue_thankyou` VARCHAR(128) DEFAULT NULL,
   `queue_reporthold` VARCHAR(128) DEFAULT NULL,
   `announce_frequency` int(11) DEFAULT NULL,
   `announce_round_seconds` int(11) DEFAULT NULL,
   `announce_holdtime` VARCHAR(128) DEFAULT NULL,
   `retry` int(11) DEFAULT NULL,
   `wrapuptime` int(11) DEFAULT NULL,
   `maxlen` int(11) DEFAULT NULL,
   `servicelevel` int(11) DEFAULT NULL,
   `strategy` VARCHAR(128) DEFAULT NULL,
   `joinempty` VARCHAR(128) DEFAULT NULL,
   `leavewhenempty` VARCHAR(128) DEFAULT NULL,
   `eventmemberstatus` tinyint(1) DEFAULT NULL,
   `eventwhencalled` tinyint(1) DEFAULT NULL,
   `reportholdtime` tinyint(1) DEFAULT NULL,
   `memberdelay` int(11) DEFAULT NULL,
   `weight` int(11) DEFAULT NULL,
   `timeoutrestart` tinyint(1) DEFAULT NULL,
   `periodic_announce` VARCHAR(50) DEFAULT NULL,
   `periodic_announce_frequency` int(11) DEFAULT NULL,
   `ringinuse` tinyint(1) DEFAULT NULL,
   `setinterfacevar` tinyint(1) DEFAULT NULL,
   PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `queue_member_table` (
   `uniqueid` int(10) unsigned NOT NULL auto_increment,
   `membername` VARCHAR(40) DEFAULT NULL,
   `queue_name` VARCHAR(128) DEFAULT NULL,
   `interface` VARCHAR(128) DEFAULT NULL,
   `penalty` int(11) DEFAULT NULL,
   `paused` int(11) DEFAULT NULL,
   PRIMARY KEY  (`uniqueid`),
   UNIQUE KEY `queue_interface` (`queue_name`,`interface`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

CREATE TABLE `meetme` (
   `confno` VARCHAR(80) NOT NULL DEFAULT '0',
   `username` VARCHAR(64) NOT NULL DEFAULT '',
   `domain` VARCHAR(128) NOT NULL DEFAULT '',
   `pin` VARCHAR(20) DEFAULT NULL,
   `adminpin` VARCHAR(20) DEFAULT NULL,
   `members` int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY  (`confno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `sip_buddies` (`name`, `DEFAULTuser`, `secret`, `context`, `host`, `nat`, `qualify`, `type`) VALUES
('1000', '1000', '1234', 'from-sip', 'dynamic', 'yes', 'no', 'friend'),
('2000', '2000', '1234', 'from-sip', 'dynamic', 'yes', 'no', 'friend'),
('deltathree', '11111111', '1234', 'from-sip', 'sipauth.deltathree.com', 'yes', 'no', 'friend');

INSERT INTO `extensions`(`context`,`exten`,`priority`,`app`,`appdata`) VALUES
('from-sip', '12121111111', 1, 'Dial', 'SIP/1000|60'),
('from-sip', '12122222222', 1, 'Dial', 'SIP/2000|60'),
('from-sip', '_X.', 1, 'Dial', 'SIP/${EXTEN}|30'),
('from-sip', '_9X.', 1, 'Dial', 'SIP/${EXTEN:1}@deltathree'),
('from-sip', '_X.', 2, 'VoiceMail', '${EXTEN}@from-sip'),
('from-sip', '_X.', 3, 'hangup', ''),
('from-sip', '_*0', 1, 'VoiceMailMain', '${CALLERID(num)}@from-sip'),
('from-sip', '12127777777', 1, 'Queue', 'my_queue'),
('from-sip', '12129999999', 1, 'MeetMe', 'my_conf');

INSERT INTO `voicemail_users` (`customer_id`, `context`, `mailbox`, `password`, `fullname`, `email`) VALUES
('1000', 'from-sip', '1000', '1234', 'User-A', 'UserA@myemail.com'),
('2000', 'from-sip', '2000', '1234', 'User-B', 'UserB@myemail.com');

INSERT INTO `queue_table` (`name`,`context`) VALUES
('my_queue','from-sip');

INSERT INTO `queue_member_table` (`uniqueid`,`membername`,`queue_name`,`interface`,`penalty`,`paused`) VALUES
(1,'SIP/1000@from-sip','my_queue','SIP/1000',NULL,0),
(2,'SIP/2000@from-sip','my_queue','SIP/2000',NULL,0);

INSERT INTO `meetme` (`confno`,`username`,`domain`,`pin`,`adminpin`,`members`) VALUES
('my_conf', '', '', '5555', '4444', 0);