CREATE TABLE IF NOT EXISTS `tb_cor_veiculo` (
	`id_cor_veiculo` int(2) unsigned NOT NULL AUTO_INCREMENT,
	`ds_cor_veiculo` varchar(50) DEFAULT NULL,
	PRIMARY KEY (`id_cor_veiculo`) USING BTREE,
	UNIQUE KEY `id_cor_veiculo` (`id_cor_veiculo`)
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO `tb_cor_veiculo` (`id_cor_veiculo`, `ds_cor_veiculo`) VALUES
	(1, 'AMARELO'),
	(2, 'AZUL'),
	(3, 'BEGE'),
	(4, 'BRANCA'),
	(5, 'CINZA'),
	(6, 'DOURADA'),
	(7, 'GRENA'),
	(8, 'LARANJA'),
	(9, 'MARROM'),
	(10, 'PRATA'),
	(11, 'PRETA'),
	(12, 'ROSA'),
	(13, 'ROXA'),
	(14, 'VERDE'),
	(15, 'VERMELHA'),
	(16, 'FANTASIA');


UPDATE tb_parametro SET vl_parametro = 'v0004' 
WHERE grupo_parametro = 'banco_dados' 
AND chave_parametro = 'versao';