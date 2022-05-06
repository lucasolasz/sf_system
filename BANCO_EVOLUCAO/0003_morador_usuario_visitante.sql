
CREATE TABLE `tb_morador` (
    `id_morador` int(2) unsigned NOT NULL AUTO_INCREMENT,
	`nm_morador` varchar(255) DEFAULT NULL,
	`fk_casa` int(2) unsigned DEFAULT NULL,
	`flag_locatario` char(1) DEFAULT NULL,
	`documento_morador` varchar(20) DEFAULT NULL,
	`dt_nascimento_morador` date DEFAULT NULL,
	`tel_um_morador` varchar(20) DEFAULT NULL,
	`tel_dois_morador` varchar(20) DEFAULT NULL,
	`email_morador` varchar(100) DEFAULT NULL,
	`tel_emergencia` varchar(20) DEFAULT NULL,
	`nm_locatario` varchar(255) DEFAULT NULL,
	`documento_locatario` varchar(20) DEFAULT NULL,
	`dt_nascimento_locatario` date DEFAULT NULL,
	`tel_um_locatario` varchar(20) DEFAULT NULL,
	`tel_dois_locatario` varchar(20) DEFAULT NULL,
	PRIMARY KEY (`id_morador`),
	UNIQUE KEY `id_morador` (`id_morador`),
	KEY `fk_casa_tb_morador` (`fk_casa`),
	CONSTRAINT `fk_casa_tb_morador` FOREIGN KEY (`fk_casa`) REFERENCES `tb_casa` (`id_casa`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


CREATE TABLE `tb_visitante` (
	`id_visitante` int(4) unsigned NOT NULL AUTO_INCREMENT,
	`nm_visitante` varchar(255) DEFAULT NULL,
	`documento_visitante` varchar(20) DEFAULT NULL,
	`telefone_um_visitante` varchar(20) DEFAULT NULL,
	`telefone_dois_visitante` varchar(20) DEFAULT NULL,
	PRIMARY KEY (`id_visitante`),
	UNIQUE KEY `id_visitante` (`id_visitante`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


CREATE TABLE IF NOT EXISTS `tb_tipo_visita` (
	`id_tipo_visita` int(2) unsigned NOT NULL AUTO_INCREMENT,
	`ds_tipo_visita` varchar(50) DEFAULT NULL,
	PRIMARY KEY (`id_tipo_visita`) USING BTREE,
	UNIQUE KEY `id_tipo_visita` (`id_tipo_visita`)
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


INSERT INTO tb_tipo_visita (id_tipo_visita, ds_tipo_visita) VALUES(1, 'Manutenção');
INSERT INTO tb_tipo_visita (id_tipo_visita, ds_tipo_visita) VALUES(2, 'Visita Comum');
INSERT INTO tb_tipo_visita (id_tipo_visita, ds_tipo_visita) VALUES(3, 'Delivery');
INSERT INTO tb_tipo_visita (id_tipo_visita, ds_tipo_visita) VALUES(4, 'Uber');



CREATE TABLE IF NOT EXISTS `tb_tipo_usuario` (
	`id_tipo_usuario` int(2) unsigned NOT NULL AUTO_INCREMENT,
	`ds_tipo_usuario` varchar(50) DEFAULT NULL,
	PRIMARY KEY (`id_tipo_usuario`) USING BTREE,
	UNIQUE KEY `id_tipo_usuario` (`id_tipo_usuario`)
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO tb_tipo_usuario (id_tipo_usuario, ds_tipo_usuario) VALUES(1, 'Administrador');
INSERT INTO tb_tipo_usuario (id_tipo_usuario, ds_tipo_usuario) VALUES(2, 'Empregado');



CREATE TABLE IF NOT EXISTS `tb_cargo` (
  `id_cargo` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `ds_cargo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cargo`) USING BTREE,
  UNIQUE KEY `id_cargo` (`id_cargo`)
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO `tb_cargo` (`id_cargo`, `ds_cargo`) VALUES
	(1, 'Síndico'),
	(2, 'Porteiro'),
	(3, 'Zelador');


CREATE TABLE `tb_usuario` (
	`id_usuario` int(4) unsigned NOT NULL AUTO_INCREMENT,
	`ds_nome_usuario` varchar(255) DEFAULT NULL,
	`ds_endereco_usuario` varchar(255) DEFAULT NULL,
	`ds_complemento_usuario` varchar(255) DEFAULT NULL,
	`ds_documento_usuario` varchar(255) DEFAULT NULL,
	`fk_cidade` int(4) unsigned DEFAULT NULL,
	`fk_estado` int(2) unsigned DEFAULT NULL,
	`ds_cep_usuario` varchar(255) DEFAULT NULL,
	`fk_cargo` int(2) unsigned DEFAULT NULL,
	`ds_usuario` varchar(255) DEFAULT NULL,
	`ds_senha` varchar(255) DEFAULT NULL,
	`fk_tipo_usuario` int(2) unsigned DEFAULT NULL,
	PRIMARY KEY (`id_usuario`),
	UNIQUE KEY `id_usuario` (`id_usuario`),
	UNIQUE KEY `ds_usuario` (`ds_usuario`),
	KEY `fk_cidade_tb_cidade` (`fk_cidade`),
	KEY `fk_estado_tb_estados` (`fk_estado`),
	KEY `fk_cargo_tb_cargo` (`fk_cargo`),
	KEY `fk_tipo_usuario_tb_usuario` (`fk_tipo_usuario`),
	CONSTRAINT `fk_cargo_tb_usuario` FOREIGN KEY (`fk_cargo`) REFERENCES `tb_cargo` (`id_cargo`),
	CONSTRAINT `fk_cidade_tb_usuario` FOREIGN KEY (`fk_cidade`) REFERENCES `tb_cidades` (`id_cidade`),
	CONSTRAINT `fk_estado_tb_usuario` FOREIGN KEY (`fk_estado`) REFERENCES `tb_estados` (`id_estado`),
	CONSTRAINT `fk_tipo_usuario_tb_usuario` FOREIGN KEY (`fk_tipo_usuario`) REFERENCES `tb_tipo_usuario` (`id_tipo_usuario`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO `tb_usuario` (`id_usuario`, `ds_nome_usuario`, `ds_endereco_usuario`, `ds_complemento_usuario`, `ds_documento_usuario`, `fk_cidade`, `fk_estado`, `ds_cep_usuario`, `fk_cargo`, `ds_usuario`, `ds_senha`, `fk_tipo_usuario`) VALUES
	(1, 'Administrador', NULL, NULL, NULL, 6861, 19, NULL, 1, 'admin', '198a4dc05d06909710fd727df9eec8ba', 1);


CREATE TABLE `tb_visita`(	
	`id_visita` int(4) unsigned NOT NULL AUTO_INCREMENT,
	`fk_visitante` int(4) unsigned NOT NULL,
	`fk_veiculo` int(4) unsigned DEFAULT NULL,
	`fk_tipo_visita` int(2) unsigned DEFAULT NULL,
	`fk_usuario_entrada` int(4) unsigned DEFAULT NULL,
	`fk_usuario_saida` int(4) unsigned DEFAULT NULL,
	`dt_entrada_visita` date DEFAULT NULL,
	`dt_hora_entrada_visita` time DEFAULT NULL,
	`dt_saida_visita` date DEFAULT NULL,
	`dt_hora_saida_visita` time DEFAULT NULL,
	`qt_pessoas_carro` varchar(20) DEFAULT NULL,
	`fk_casa` int(2) unsigned DEFAULT NULL,
	`observacao_visita` varchar(500) DEFAULT NULL,
	PRIMARY KEY (`id_visita`),
	UNIQUE KEY `id_visita` (`id_visita`),
	KEY `fk_visitante_tb_visita` (`fk_visitante`),
	KEY `fk_veiculo_tb_visita` (`fk_veiculo`),
	KEY `fk_tipo_visita_tb_visita` (`fk_tipo_visita`),
	KEY `fk_usuario_entrada_tb_visita` (`fk_usuario_entrada`),
	KEY `fk_usuario_saida_tb_visita` (`fk_usuario_saida`),
	KEY `fk_casa_tb_visita` (`fk_casa`),
	CONSTRAINT `fk_casa_tb_visita` FOREIGN KEY (`fk_casa`) REFERENCES `tb_casa` (`id_casa`),
	CONSTRAINT `fk_tipo_visita_tb_visita` FOREIGN KEY (`fk_tipo_visita`) REFERENCES `tb_tipo_visita` (`id_tipo_visita`),
	CONSTRAINT `fk_usuario_entrada_tb_visita` FOREIGN KEY (`fk_usuario_entrada`) REFERENCES `tb_usuario` (`id_usuario`),
	CONSTRAINT `fk_usuario_saida_tb_visita` FOREIGN KEY (`fk_usuario_saida`) REFERENCES `tb_usuario` (`id_usuario`),
	CONSTRAINT `fk_veiculo_tb_visita` FOREIGN KEY (`fk_veiculo`) REFERENCES `tb_veiculo` (`id_veiculo`),
	CONSTRAINT `fk_visitante_tb_visita` FOREIGN KEY (`fk_visitante`) REFERENCES `tb_visitante` (`id_visitante`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;




UPDATE tb_parametro SET vl_parametro = 'v0003' 
WHERE grupo_parametro = 'banco_dados' 
AND chave_parametro = 'versao';