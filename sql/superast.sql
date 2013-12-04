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
    `menu_route` VARCHAR(255),
    `menu_data_target` VARCHAR(255),
    `menu_icon_class` VARCHAR(255),
    `menu_parent` INT(10) UNSIGNED,
    `menu_order` INT
)  ENGINE=InnoDB AUTO_INCREMENT=23;

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_description`, `menu_page_title`, `menu_module`, `menu_controller`, `menu_action`, `menu_route`, `menu_data_target`, `menu_icon_class`, `menu_parent`, `menu_order`) VALUES
(1, 'Dashboard', 'Resumo de informaÃ§Ãµes da aplicaÃ§Ã£o', 'Dashboard', 'default', 'index', 'index', 'dashboard_action', '', 'dashboard', NULL, 1),
(2, 'AplicaÃ§Ãµes', '', '', '', '', '', 'index_action', '#sidebar_aplicacoes', 'grid layout', NULL, 2),
(3, 'ConfiguraÃ§Ãµes', 'ConfiguraÃ§Ãµes do sistema', '', '', '', '', 'index_action', '#sidebar_configuracoes', 'settings', NULL, 3),
(4, 'CRM', 'Relacionamento com o cliente', 'CRM', '', '', '', 'index_action', '', 'suitcase', 2, 1),
(5, 'Clientes', 'Gerenciamento de clientes', 'Clientes', 'crm', 'customers', 'index', 'index_action', '', 'briefcase', 4, 1),
(6, 'Atendimentos', 'Contatos realizados com os clientes', 'Atendimentos', 'crm', 'attendances', 'index', 'index_action', '', 'headphones', 4, 2),
(7, 'Meus agendamentos', 'Agendamento de contatos a serem realizados com os clientes', 'Meus agendamentos', 'crm', 'schedules', 'index', 'index_action', '', 'calendar', 4, 3),
(8, 'RelatÃ³rios', 'RelatÃ³rios de informaÃ§Ãµes de clientes', 'RelatÃ³rios', 'crm', 'reports', 'index', 'index_action', '', 'chart basic', 4, 4),
(9, 'Telefonia', 'Gerenciamento do Asterisk', 'Telefonia', '', '', '', 'index_action', '', 'phone', 2, 2),
(10, 'Servidores', 'Gerenciamento dos servidores Asterisk cadastrados.', 'Servidores', 'telephony', 'servers', 'index', 'index_action', '', 'hdd', 9, 1),
(11, 'Filas', 'Gerenciamento das filas de atendimento do Asterisk', 'Filas', 'telephony', 'queues', 'index', 'index_action', '', 'ellipsis vertical', 9, 2),
(12, 'Ramais', 'Gerenciamento dos ramais do Asterisk', 'Ramais', 'telephony', 'extensions', 'index', 'index_action', '', 'phone', 9, 3),
(13, 'Campanhas', 'Gerenciamento de campanhas ativas e receptivas das filas de atendimento', 'Campanhas', 'telephony', 'campaigns', 'index', 'index_action', '', 'exchange', 9, 4),
(14, 'Monitoramento', 'Monitoramento dos serviÃ§os de telefonia', 'Monitoramento', 'telephony', 'monitoring', 'index', 'index_action', '', 'tasks', 9, 5),
(15, 'RelatÃ³rios', 'RelatÃ³rios de informaÃ§Ãµes de telefonia', 'RelatÃ³rios', 'telephony', 'reports', 'index', 'index_action', '', 'chart basic', 9, 7),
(16, 'TarifaÃ§Ã£o', 'ConferÃªncia de custos de telefonia', 'TarifaÃ§Ã£o', 'telephony', 'billing', 'index', 'index_action', '', 'money', 9, 6),
(17, 'Acessos', 'Gerenciamento do controle de acesso de usuÃ¡rios', 'Acessos', '', '', '', 'index_action', '', 'community basic', 3, 1),
(18, 'Empresas', 'Gerenciamento de empresas de usuÃ¡rios cadastrados', 'Empresas', 'default', 'companies', 'index', 'settings_index_action', '', 'building', 17, 1),
(19, 'Grupos', 'Gerenciamento de grupos de usuÃ¡rios', 'Grupos', 'default', 'groups', 'index', 'settings_index_action', '', 'users', 17, 2),
(20, 'UsuÃ¡rios', 'Gerenciamento de usuÃ¡rios do sistema', 'UsuÃ¡rios', 'default', 'users', 'index', 'settings_index_action', '', 'user', 17, 3),
(21, 'Menus', 'Gerenciamento de Ã¡reas desenvolvidas disponÃ­veis do sistema', 'Menus', 'default', 'menus', 'index', 'settings_index_action', '', 'reorder', 17, 4),
(22, 'Cargos', 'Cargos exercidos pelos usuÃ¡rios', 'Cargos', 'default', 'roles', 'index', 'settings_index_action', '', 'wrench', 17, 2);

CREATE TABLE `company` (
    `company_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `company_name` VARCHAR(255),
    `company_active` TINYINT(1) DEFAULT 1
)  ENGINE=InnoDB AUTO_INCREMENT=2;

INSERT INTO `company` (`company_id`, `company_name`, `company_active`) VALUES
(1, 'Scitech', 1);

CREATE TABLE `role` (
    `role_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `role_name` VARCHAR(255),
    `role_active` TINYINT(1) DEFAULT 1
)  ENGINE=InnoDB AUTO_INCREMENT=2;

INSERT INTO `role` (`role_id`, `role_name`, `role_active`) VALUES
(1, 'Desenvolvedor', 1);

CREATE TABLE `user` (
    `user_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_name` VARCHAR(255),
    `user_login` VARCHAR(255),
    `user_password` VARCHAR(255),
    `user_role` INT(10) UNSIGNED,
	`user_company` INT(10) UNSIGNED,
    `user_active` TINYINT(1) DEFAULT 1
)  ENGINE=InnoDB AUTO_INCREMENT=2;

INSERT INTO `user` (`user_id`, `user_name`, `user_login`, `user_password`, `user_role`, `user_active`) VALUES
(1, 'William Urbano', 'william', MD5(123), 1, 1);

CREATE TABLE `group` (
    `group_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `group_name` VARCHAR(255),
    `group_visible` TINYINT(1) DEFAULT 1,
    `group_active` TINYINT(1) DEFAULT 1
)  ENGINE=InnoDB AUTO_INCREMENT=2;

INSERT INTO `group` (`group_id`, `group_name`, `group_visible`, `group_active`) VALUES
(1, 'Master', 1, 1);

CREATE TABLE `user_group` (
    `user_group_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_group_user` INT(10) UNSIGNED NOT NULL,
    `user_group_group` INT(10) UNSIGNED NOT NULL
)  ENGINE=InnoDB AUTO_INCREMENT=2;

INSERT INTO `user_group` (`user_group_id`, `user_group_user`, `user_group_group`) VALUES 
(1, 1, 1);

CREATE TABLE `group_menu` (
    `group_menu_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `group_menu_group` INT(10) UNSIGNED NOT NULL,
    `group_menu_menu` INT(10) UNSIGNED NOT NULL
)  ENGINE=InnoDB;

CREATE TABLE `user_company` (
    `user_company_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_company_user` INT(10) UNSIGNED NOT NULL,
    `user_company_company` INT(10) UNSIGNED NOT NULL
)  ENGINE=InnoDB;

CREATE TABLE `server` (
    `server_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `server_hostname` VARCHAR(255),
    `server_ip_address` VARCHAR(255),
    `server_database_user` VARCHAR(255),
    `server_database_password` VARCHAR(255),
    `server_ami_user` VARCHAR(255),
    `server_ami_secret` VARCHAR(255),
    `server_is_elastix` TINYINT(1) DEFAULT 0,
    `server_active` TINYINT(1) DEFAULT 1
)  ENGINE=InnoDB AUTO_INCREMENT=4;

INSERT INTO `server` (`server_id`, `server_hostname`, `server_ip_address`, `server_database_user`, `server_database_password`, `server_ami_user`, `server_ami_secret`, `server_is_elastix`, `server_active`) VALUES
(1, 'callcenter', '10.0.0.18', 'root', 'sci134!', 'admin', 'sci134', 1, 1),
(2, 'zincornio', '10.0.0.132', 'root', 'ultima91', 'admin', '123123', 1, 1),
(3, 'voip', '10.0.0.1', 'root', 'MySQL987', 'admin', 'Pbx987Linux', 1, 1);

CREATE TABLE `queue` (
    `queue_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `queue_name` VARCHAR(255),
    `queue_number` VARCHAR(255),
    `queue_server` INT(10) UNSIGNED NOT NULL,
    `queue_company` INT(10) UNSIGNED DEFAULT NULL,
    `queue_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE `agent` (
    `agent_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `agent_name` VARCHAR(255),
    `agent_number` VARCHAR(255),
    `agent_password` VARCHAR(255),
    `agent_server` INT(10) UNSIGNED NOT NULL,
    `agent_company` INT(10) UNSIGNED NOT NULL,
    `agent_user` INT(10) UNSIGNED NOT NULL,
    `agent_active` TINYINT(1) DEFAULT 1
)  ENGINE=InnoDB;

ALTER TABLE `user`
ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`user_role`) REFERENCES `role`(`role_id`) ON UPDATE CASCADE ON DELETE NO ACTION,
ADD CONSTRAINT `fk_user_company` FOREIGN KEY (`user_company`) REFERENCES `company`(`company_id`) ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE `user_group`
ADD CONSTRAINT `fk_user_group_user` FOREIGN KEY (`user_group_user`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT `fk_user_group_group` FOREIGN KEY (`user_group_group`) REFERENCES `group`(`group_id`) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE `group_menu`
ADD CONSTRAINT `fk_group_menu_group` FOREIGN KEY (`group_menu_group`) REFERENCES `group`(`group_id`) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT `fk_group_menu_menu` FOREIGN KEY (`group_menu_menu`) REFERENCES `menu`(`menu_id`) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE `user_company`
ADD CONSTRAINT `fk_user_company_user` FOREIGN KEY (`user_company_user`) REFERENCES `user`(`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT `fk_user_company_company` FOREIGN KEY (`user_company_company`) REFERENCES `company`(`company_id`) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE `queue`
ADD CONSTRAINT `fk_queue_server` FOREIGN KEY (`queue_server`) REFERENCES `server`(`server_id`) ON UPDATE CASCADE ON DELETE CASCADE,
ADD CONSTRAINT `fk_queue_company` FOREIGN KEY (`queue_company`) REFERENCES `company`(`company_id`) ON UPDATE CASCADE ON DELETE NO ACTION;

ALTER TABLE `agent`
ADD CONSTRAINT `fk_agent_server` FOREIGN KEY (`agent_server`) REFERENCES `server`(`server_id`),
ADD CONSTRAINT `fk_agent_company` FOREIGN KEY (`agent_company`) REFERENCES `company`(`company_id`),
ADD CONSTRAINT `fk_agent_user` FOREIGN KEY (`agent_user`) REFERENCES `user`(`user_id`);