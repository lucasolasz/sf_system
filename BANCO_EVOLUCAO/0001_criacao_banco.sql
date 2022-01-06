

CREATE DATABASE IF NOT EXISTS `sf_system` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sf_system`;

CREATE TABLE `tb_parametro`(	
	`grupo_parametro` VARCHAR(50) NULL DEFAULT NULL,
	`chave_parametro` VARCHAR(50) NULL DEFAULT NULL,
	`vl_parametro` VARCHAR(500) NULL DEFAULT NULL,
	`ds_parametro` VARCHAR(500) NULL DEFAULT NULL
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO tb_parametro (grupo_parametro, chave_parametro, vl_parametro, ds_parametro) VALUES('banco_dados', 'versao','v0001','Indica versão do banco de dados');





















