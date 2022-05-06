

CREATE TABLE `tb_historico_relatorio_visita`(	
	`id_relatorio_visita_hst` int(4) unsigned NOT NULL AUTO_INCREMENT,
	`fk_visita` int(4) unsigned DEFAULT NULL,
	`nm_visitante_hst` varchar(255) DEFAULT NULL,
	`telefone_um_visitante_hst` varchar(20) DEFAULT NULL,
	`telefone_dois_visitante_hst` varchar(20) DEFAULT NULL,
	`ds_placa_veiculo_visitante_hst` varchar(20) DEFAULT NULL,
	`ds_tipo_veiculo_hst` varchar(50) DEFAULT NULL,
	`ds_tipo_visita_hst` varchar(50) DEFAULT NULL,
	`nm_usuario_entrada_hst` varchar(255) DEFAULT NULL,
	`nm_usuario_saida_hst` varchar(255) DEFAULT NULL,
	`dt_entrada_visita_hst` date DEFAULT NULL,
	`dt_hora_entrada_visita_hst` time DEFAULT NULL,
	`dt_saida_visita_hst` date DEFAULT NULL,
	`dt_hora_saida_visita_hst` time DEFAULT NULL,
	`qt_pessoas_carro_hst` varchar(20) DEFAULT NULL,
	`ds_casa_visita_hst` varchar(10) DEFAULT NULL,
	`observacao_visita_hst` varchar(500) DEFAULT NULL,
	PRIMARY KEY (`id_relatorio_visita_hst`),
	UNIQUE KEY `id_relatorio_visita_hst` (`id_relatorio_visita_hst`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;



UPDATE tb_parametro SET vl_parametro = 'v0007' 
WHERE grupo_parametro = 'banco_dados' 
AND chave_parametro = 'versao';