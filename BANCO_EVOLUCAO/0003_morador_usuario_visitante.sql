
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
	PRIMARY KEY (`id_visitante`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


CREATE TABLE `tb_visita`(	
	`id_visita` SMALLINT(6) NOT NULL AUTO_INCREMENT UNIQUE,
	`fk_visitante` SMALLINT(6) NOT NULL,
	`ds_placa_veiculo_visitante` VARCHAR(20) NULL DEFAULT NULL,
	`fk_cor_veiculo_visitante` SMALLINT(6) NULL DEFAULT NULL,
	`fk_tipo_visita` SMALLINT(6) NULL DEFAULT NULL,
	`fk_usuario_entrada` SMALLINT(6) NULL DEFAULT NULL,
	`fk_usuario_saida` SMALLINT(6) NULL DEFAULT NULL,	
	`dt_entrada_visita` TIMESTAMP NULL DEFAULT NULL,
	`dt_hora_entrada_visita` TIME NULL DEFAULT NULL,
	`dt_saida_visita` TIMESTAMP NULL DEFAULT NULL,
	`dt_hora_saida_visita` TIME NULL DEFAULT NULL,
	`qt_pessoas_carro` VARCHAR(20) NULL DEFAULT NULL,
	`numero_casa_visita` SMALLINT(6) NULL DEFAULT NULL,
	`observacao_visita` VARCHAR(500) NULL DEFAULT NULL,
	PRIMARY KEY (`id_visita`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


CREATE TABLE IF NOT EXISTS `tb_tipo_visita` (
  `id_tipo_visita` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
  `ds_tipo_visita` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_visita`) USING BTREE
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO tb_tipo_visita (id_tipo_visita, ds_tipo_visita) VALUES(1, 'Manutenção');
INSERT INTO tb_tipo_visita (id_tipo_visita, ds_tipo_visita) VALUES(2, 'Visita Comum');
INSERT INTO tb_tipo_visita (id_tipo_visita, ds_tipo_visita) VALUES(3, 'Delivery');
INSERT INTO tb_tipo_visita (id_tipo_visita, ds_tipo_visita) VALUES(4, 'Uber');


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
	PRIMARY KEY (`id_usuario`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO tb_usuario (ds_nome_usuario,ds_usuario, ds_senha) VALUES ('Administrador','admin', MD5('sfsystem@admin'));


CREATE TABLE IF NOT EXISTS `tb_tipo_usuario` (
  `id_tipo_usuario` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
  `ds_tipo_usuario` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_usuario`) USING BTREE
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO tb_tipo_usuario (id_tipo_usuario, ds_tipo_usuario) VALUES(1, 'Administrador');
INSERT INTO tb_tipo_usuario (id_tipo_usuario, ds_tipo_usuario) VALUES(2, 'Empregado');
INSERT INTO tb_tipo_usuario (id_tipo_usuario, ds_tipo_usuario) VALUES(3, 'Super User');



CREATE TABLE IF NOT EXISTS `tb_cargo` (
  `id_cargo` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
  `ds_cargo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cargo`) USING BTREE
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


INSERT INTO tb_cargo (id_cargo, ds_cargo) VALUES(1, 'Síndico');
INSERT INTO tb_cargo (id_cargo, ds_cargo) VALUES(2, 'Jardineiro');
INSERT INTO tb_cargo (id_cargo, ds_cargo) VALUES(3, 'Porteiro');


UPDATE tb_parametro SET vl_parametro = 'v0003' 
WHERE grupo_parametro = 'banco_dados' 
AND chave_parametro = 'versao';