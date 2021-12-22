
-- CREATE TABLE `tb_morador` (
-- 	`id_morador` SMALLINT(6) NOT NULL AUTO_INCREMENT UNIQUE,
-- 	`nm_morador` VARCHAR(255) NULL DEFAULT NULL,
-- 	`nm_alternativo` VARCHAR(255) NULL DEFAULT NULL,
-- 	`documento_morador` VARCHAR(20) NULL DEFAULT NULL,
-- 	`ds_placa_veiculo` VARCHAR(20) NULL DEFAULT NULL,
-- 	`ds_cor_veiculo` VARCHAR(20) NULL DEFAULT NULL,
-- 	`fk_veiculo` SMALLINT(6) NULL DEFAULT NULL,
-- 	`num_casa_morador` SMALLINT(6) NULL DEFAULT NULL,
-- 	`telefone_um_morador` VARCHAR(20) NULL DEFAULT NULL,
-- 	`telefone_dois_morador` VARCHAR(20) NULL DEFAULT NULL,
-- 	`observacao_morador` VARCHAR(500) NULL DEFAULT NULL,
-- 	PRIMARY KEY (`id_morador`)
-- ) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;



CREATE TABLE `tb_visitante` (
	`id_visitante` SMALLINT(6) NOT NULL AUTO_INCREMENT UNIQUE,
	`nm_visitante` VARCHAR(255) NULL DEFAULT NULL,
	`documento_visitante` VARCHAR(20) NULL DEFAULT NULL,
	`telefone_um_visitante` VARCHAR(20) NULL DEFAULT NULL,
	`telefone_dois_visitante` VARCHAR(20) NULL DEFAULT NULL,
	`fk_tipo_visitante` SMALLINT(6) NULL DEFAULT NULL,
	PRIMARY KEY (`id_visitante`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


CREATE TABLE `tb_visita`(
	
	`id_visita` SMALLINT(6) NOT NULL AUTO_INCREMENT UNIQUE,
	`fk_visitante` SMALLINT(6) NOT NULL,
	`ds_placa_veiculo` VARCHAR(20) NULL DEFAULT NULL,
	`ds_cor_veiculo` VARCHAR(20) NULL DEFAULT NULL,
	`fk_tipo_visitante` SMALLINT(6) NULL DEFAULT NULL,
	`dt_entrada_visita` TIMESTAMP NULL DEFAULT NULL,
	`dt_saida_visita` TIMESTAMP NULL DEFAULT NULL,
	`observacao_visita` VARCHAR(500) NULL DEFAULT NULL,
	PRIMARY KEY (`id_visita`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


CREATE TABLE `tb_usuario` (
	`id_usuario` SMALLINT(6) NOT NULL AUTO_INCREMENT UNIQUE,
	`ds_nome_usuario` VARCHAR(255) NULL DEFAULT NULL,
	`ds_endereco_usuario` VARCHAR(255) NULL DEFAULT NULL,
	`ds_complemento_usuario` VARCHAR(255) NULL DEFAULT NULL,
	`ds_documento_usuario` VARCHAR(255) NULL DEFAULT NULL,
	`fk_cidade` SMALLINT(6) NULL DEFAULT NULL,
	`fk_estado` SMALLINT(6) NULL DEFAULT NULL,
	`ds_cep_usuario` VARCHAR(255) NULL DEFAULT NULL,
	`fk_cargo` SMALLINT(6) NULL DEFAULT NULL,
	`ds_usuario` VARCHAR(255) NULL DEFAULT NULL UNIQUE,
	`ds_senha` VARCHAR(255) NULL DEFAULT NULL,
	`fk_tipo_usuario` SMALLINT(6) NULL DEFAULT NULL,
	`fk_ponto_eletronico` SMALLINT(6) NULL DEFAULT NULL,
	PRIMARY KEY (`id_usuario`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO tb_usuario (ds_usuario, ds_senha) VALUES ('admin', MD5('sfsystem@admin'));

