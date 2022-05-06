
CREATE TABLE IF NOT EXISTS `tb_tipo_veiculo` (
  `id_tipo_veiculo` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `ds_tipo_veiculo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_veiculo`) USING BTREE,
  UNIQUE KEY `id_tipo_veiculo` (`id_tipo_veiculo`)
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO `tb_tipo_veiculo` (`id_tipo_veiculo`, `ds_tipo_veiculo`) VALUES
	(1, 'Moto'),
	(2, 'Carro'),
	(3, 'Caminhão'),
	(4, 'Bicicleta');


CREATE TABLE IF NOT EXISTS `tb_veiculo` (
    `id_veiculo` int(4) unsigned NOT NULL AUTO_INCREMENT,
	`ds_placa_veiculo` varchar(20) DEFAULT NULL,
	`fk_visitante` int(4) unsigned DEFAULT NULL,
	`fk_morador` int(2) unsigned DEFAULT NULL,
	`fk_cor_veiculo` int(2) unsigned DEFAULT NULL,
	`fk_tipo_veiculo` int(2) unsigned DEFAULT NULL,
	PRIMARY KEY (`id_veiculo`) USING BTREE,
	UNIQUE KEY `id_veiculo` (`id_veiculo`),
	KEY `fk_cor_veiculo_tb_veiculo` (`fk_cor_veiculo`),
	KEY `fk_morador_tb_veiculo` (`fk_morador`),
	KEY `fk_tipo_veiculo_tb_veiculo` (`fk_tipo_veiculo`),
	KEY `fk_visitante_tb_veiculo` (`fk_visitante`),
	CONSTRAINT `fk_cor_veiculo_tb_veiculo` FOREIGN KEY (`fk_cor_veiculo`) REFERENCES `tb_cor_veiculo` (`id_cor_veiculo`),
	CONSTRAINT `fk_morador_tb_veiculo` FOREIGN KEY (`fk_morador`) REFERENCES `tb_morador` (`id_morador`),
	CONSTRAINT `fk_tipo_veiculo_tb_veiculo` FOREIGN KEY (`fk_tipo_veiculo`) REFERENCES `tb_tipo_veiculo` (`id_tipo_veiculo`),
	CONSTRAINT `fk_visitante_tb_veiculo` FOREIGN KEY (`fk_visitante`) REFERENCES `tb_visitante` (`id_visitante`)
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;




UPDATE tb_parametro SET vl_parametro = 'v0005' 
WHERE grupo_parametro = 'banco_dados' 
AND chave_parametro = 'versao';