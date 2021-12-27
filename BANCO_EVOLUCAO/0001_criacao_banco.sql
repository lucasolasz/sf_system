

CREATE DATABASE IF NOT EXISTS `sf_system` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sf_system`;

CREATE TABLE `tb_parametro`(	
	`grupo_parametro` VARCHAR(50) NULL DEFAULT NULL,
	`chave_parametro` VARCHAR(50) NULL DEFAULT NULL,
	`vl_parametro` VARCHAR(500) NULL DEFAULT NULL,
	`ds_parametro` VARCHAR(500) NULL DEFAULT NULL,
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO tb_parametro (grupo_parametro, chave_parametro, vl_parametro, ds_parametro) VALUES('banco_dados', 'versao','v0001','Indica versão do banco de dados');





-- CREATE TABLE IF NOT EXISTS `tb_veiculo` (
--   `id_veiculo` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
--   `ds_veiculo` varchar(255) DEFAULT NULL,
--   `placa_veiculo` varchar(20) DEFAULT NULL,
--   `observacao_veiculo` varchar(255) DEFAULT NULL,
--   PRIMARY KEY (`id_veiculo`) USING BTREE
-- )  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;



-- CREATE TABLE IF NOT EXISTS `tb_ponto_eletronico` (
--   `id_ponto_eletronico` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
--   `dt_entrada` TIMESTAMP NULL DEFAULT NULL,
--   `dt_entrada_almoco` TIMESTAMP NULL DEFAULT NULL,
--   `dt_saida_almoco` TIMESTAMP NULL DEFAULT NULL,
--   `dt_saida` TIMESTAMP NULL DEFAULT NULL,
--   `dt_hora_extra` TIMESTAMP NULL DEFAULT NULL,
--   `observacao_ponto_eletronico` TIMESTAMP NULL DEFAULT NULL,
--   PRIMARY KEY (`id_ponto_eletronico`) USING BTREE
-- )  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;
























