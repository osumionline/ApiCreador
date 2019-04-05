/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

CREATE TABLE `project` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada proyecto',
  `id_user` INT(11) NOT NULL COMMENT 'Id del usuario dueño del proyecto',
  `name` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre del proyecto',
  `slug` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Slug del nombre del proyecto',
  `description` TEXT NULL COMMENT 'Descripción del proyecto',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada usuario',
  `username` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre de usuario',
  `pass` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Contraseña cifrada del usuario',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `include_version` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id unico de la version del include',
  `id_include_type` INT(11) NOT NULL COMMENT 'Id del tipo de include',
  `version` VARCHAR(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Número de versión del tipo de include',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `row` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada campo del modelo',
  `id_model` INT(11) NOT NULL COMMENT 'Id del modelo al que pertenece el campo',
  `name` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre del campo',
  `type` INT(11) NOT NULL DEFAULT '0' COMMENT 'Tipo de campo PK 1 PK Str 10 Created 2 Updated 3 Num 4 Texto 5 Fecha 6 Bool 7 Longtext 8 Float 9',
  `size` INT(11) NULL COMMENT 'Tamaño del campo',
  `auto_increment` TINYINT(1) NULL COMMENT 'Indica si el campo es AUTO_INCREMENT 1 o no 0',
  `nullable` TINYINT(1) NULL COMMENT 'Indica si el campo puede ser nulo 1 o no 0',
  `default` VARCHAR(250) COLLATE utf8_unicode_ci NULL COMMENT 'Valor por defecto para un campo',
  `ref` VARCHAR(50) COLLATE utf8_unicode_ci NULL COMMENT 'Referencia a otra tabla',
  `comment` VARCHAR(200) COLLATE utf8_unicode_ci NULL COMMENT 'Comentario para el campo',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `project_config_list_item` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada proyecto',
  `id_project_config` INT(11) NOT NULL COMMENT 'Id de la configuración a la que hace referencia',
  `type` INT(11) NOT NULL DEFAULT '0' COMMENT 'Tipo de elemento 0 css 1 ext_css 2 js 3 ext_js 4 extra 5 libs 6 dir',
  `key` VARCHAR(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Clave para los tipos extra y dir',
  `value` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Valor del elemento de lista',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `include_file` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada archivo a incluir',
  `id_include_version` INT(11) NOT NULL COMMENT 'Id de la version del include',
  `type` INT(11) NOT NULL DEFAULT '0' COMMENT 'Tipo de archivo 0 CSS 1 JS',
  `filename` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre del archivo a incluir',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `project_include` (
  `id_project` INT(11) NOT NULL COMMENT 'Id del proyecto en el que se incluye',
  `id_type` INT(11) NOT NULL COMMENT 'Id del tipo de include',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id_project`,`id_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `project_config` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada proyecto',
  `id_project` INT(11) NOT NULL COMMENT 'Id del proyecto al que pertenece la configuración',
  `db_host` VARCHAR(50) COLLATE utf8_unicode_ci NULL COMMENT 'Host de la base de datos',
  `db_user` VARCHAR(50) COLLATE utf8_unicode_ci NULL COMMENT 'Nombre de usuario para la base de datos',
  `db_pass` VARCHAR(100) COLLATE utf8_unicode_ci NULL COMMENT 'Contraseña cifrada para la base de datos',
  `db_name` VARCHAR(50) COLLATE utf8_unicode_ci NULL COMMENT 'Nombre de la base de datos',
  `cookies_prefix` VARCHAR(50) COLLATE utf8_unicode_ci NULL COMMENT 'Prefijo para las cookies',
  `cookies_url` VARCHAR(100) COLLATE utf8_unicode_ci NULL COMMENT 'URL para las cookies',
  `module_browser` TINYINT(1) NOT NULL DEFAULT '' COMMENT 'Indica si habilitar el módulo browser 1 o no 0',
  `module_email` TINYINT(1) NOT NULL DEFAULT '' COMMENT 'Indica si habilitar el módulo email 1 o no 0',
  `module_email_smtp` TINYINT(1) NOT NULL DEFAULT '' COMMENT 'Indica si habilitar el módulo browser 1 o no 0',
  `module_ftp` TINYINT(1) NOT NULL DEFAULT '' COMMENT 'Indica si habilitar el módulo ftp 1 o no 0',
  `module_image` TINYINT(1) NOT NULL DEFAULT '' COMMENT 'Indica si habilitar el módulo image 1 o no 0',
  `module_pdf` TINYINT(1) NOT NULL DEFAULT '' COMMENT 'Indica si habilitar el módulo pdf 1 o no 0',
  `module_translate` TINYINT(1) NOT NULL DEFAULT '' COMMENT 'Indica si habilitar el módulo translate 1 o no 0',
  `base_url` VARCHAR(250) COLLATE utf8_unicode_ci NULL COMMENT 'URL base de la aplicación',
  `admin_email` VARCHAR(100) COLLATE utf8_unicode_ci NULL COMMENT 'Dirección email para notificaciones al admin',
  `default_title` VARCHAR(100) COLLATE utf8_unicode_ci NULL COMMENT 'Título por defecto para las páginas',
  `lang` VARCHAR(10) COLLATE utf8_unicode_ci NULL COMMENT 'Código de idioma por defecto',
  `smtp_host` VARCHAR(100) COLLATE utf8_unicode_ci NULL COMMENT 'Host para el envío de emails por SMTP',
  `smtp_port` VARCHAR(5) COLLATE utf8_unicode_ci NULL COMMENT 'Puerto para el envío de emails por SMTP',
  `smtp_secure` VARCHAR(10) COLLATE utf8_unicode_ci NULL COMMENT 'Tipo de cifrado para el envío de emails por SMTP',
  `smtp_user` VARCHAR(50) COLLATE utf8_unicode_ci NULL COMMENT 'Nombre de usuario para el envío de emails por SMTP',
  `smtp_pass` VARCHAR(100) COLLATE utf8_unicode_ci NULL COMMENT 'Contraseña cifrada para el envío de emails por SMTP',
  `error_403` VARCHAR(100) COLLATE utf8_unicode_ci NULL COMMENT 'URL al que redirigir en caso de error 403',
  `error_404` VARCHAR(100) COLLATE utf8_unicode_ci NULL COMMENT 'URL al que redirigir en caso de error 404',
  `error_500` VARCHAR(100) COLLATE utf8_unicode_ci NULL COMMENT 'URL al que redirigir en caso de error 500',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `model` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para cada modelo',
  `id_project` INT(11) NOT NULL COMMENT 'Id del proyecto al que pertenece el modelo',
  `name` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre del modelo',
  `table_name` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre de la tabla en la base de datos',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `include_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Id único para tipo de include',
  `name` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nombre del tipo de include',
  `show_include` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Indica si debe mostrarse en la lista de includes disponibles',
  `created_at` DATETIME NOT NULL COMMENT 'Fecha de creación del registro',
  `updated_at` DATETIME NULL COMMENT 'Fecha de última modificación del registro',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `project`
  ADD KEY `fk_project_user_idx` (`id_user`),
  ADD CONSTRAINT `fk_project_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `include_version`
  ADD KEY `fk_include_version_include_type_idx` (`id_include_type`),
  ADD CONSTRAINT `fk_include_version_include_type` FOREIGN KEY (`id_include_type`) REFERENCES `include_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `row`
  ADD KEY `fk_row_model_idx` (`id_model`),
  ADD CONSTRAINT `fk_row_model` FOREIGN KEY (`id_model`) REFERENCES `model` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `project_config_list_item`
  ADD KEY `fk_project_config_list_item_project_config_idx` (`id_project_config`),
  ADD CONSTRAINT `fk_project_config_list_item_project_config` FOREIGN KEY (`id_project_config`) REFERENCES `project_config` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `include_file`
  ADD KEY `fk_include_file_include_version_idx` (`id_include_version`),
  ADD CONSTRAINT `fk_include_file_include_version` FOREIGN KEY (`id_include_version`) REFERENCES `include_version` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `project_config`
  ADD KEY `fk_project_config_project_idx` (`id_project`),
  ADD CONSTRAINT `fk_project_config_project` FOREIGN KEY (`id_project`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


ALTER TABLE `model`
  ADD KEY `fk_model_project_idx` (`id_project`),
  ADD CONSTRAINT `fk_model_project` FOREIGN KEY (`id_project`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
