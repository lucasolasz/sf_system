

CREATE DATABASE IF NOT EXISTS `sf_system` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sf_system`;



-- CREATE TABLE IF NOT EXISTS `tb_veiculo` (
--   `id_veiculo` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
--   `ds_veiculo` varchar(255) DEFAULT NULL,
--   `placa_veiculo` varchar(20) DEFAULT NULL,
--   `observacao_veiculo` varchar(255) DEFAULT NULL,
--   PRIMARY KEY (`id_veiculo`) USING BTREE
-- )  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


CREATE TABLE IF NOT EXISTS `tb_tipo_visitante` (
  `id_tipo_visitante` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
  `ds_tipo_visitante` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_visitante`) USING BTREE
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


CREATE TABLE IF NOT EXISTS `tb_tipo_usuario` (
  `id_tipo_usuario` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
  `ds_tipo_usuario` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_usuario`) USING BTREE
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;



CREATE TABLE IF NOT EXISTS `tb_cargo` (
  `id_cargo` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
  `ds_cargo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cargo`) USING BTREE
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


--Insere os cargos
INSERT INTO tb_cargo (id_cargo, ds_cargo) VALUES(1, 'Síndico');
INSERT INTO tb_cargo (id_cargo, ds_cargo) VALUES(2, 'Jardineiro');
INSERT INTO tb_cargo (id_cargo, ds_cargo) VALUES(3, 'Porteiro');



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
























