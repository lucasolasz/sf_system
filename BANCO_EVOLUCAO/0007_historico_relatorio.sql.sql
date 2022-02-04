

CREATE TABLE `tb_historico_relatorio_visita`(	
	`id_relatorio_visita_hst` SMALLINT(6) NOT NULL AUTO_INCREMENT UNIQUE,
	`nm_visitante_hst` VARCHAR(255) DEFAULT NULL,
        `telefone_um_visitante_hst` VARCHAR(20) NULL DEFAULT NULL,
        `telefone_dois_visitante_hst` VARCHAR(20) NULL DEFAULT NULL,
	`ds_placa_veiculo_visitante_hst` VARCHAR(20) NULL DEFAULT NULL,
        `ds_tipo_veiculo_hst` varchar(50) DEFAULT NULL,
	`ds_tipo_visita_hst` VARCHAR(50) NULL DEFAULT NULL,
	`nm_usuario_entrada_hst` VARCHAR(255) NULL DEFAULT NULL,
	`nm_usuario_saida_hst` VARCHAR(255) NULL DEFAULT NULL,	
	`dt_entrada_visita_hst` DATE NULL DEFAULT NULL,
	`dt_hora_entrada_visita_hst` TIME NULL DEFAULT NULL,
	`dt_saida_visita_hst` DATE NULL DEFAULT NULL,
	`dt_hora_saida_visita_hst` TIME NULL DEFAULT NULL,
	`qt_pessoas_carro_hst` VARCHAR(20) NULL DEFAULT NULL,
	`ds_casa_visita_hst` VARCHAR(10) NULL DEFAULT NULL,
	`observacao_visita_hst` VARCHAR(500) NULL DEFAULT NULL,
	PRIMARY KEY (`id_relatorio_visita_hst`)
) CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;



UPDATE tb_parametro SET vl_parametro = 'v0007' 
WHERE grupo_parametro = 'banco_dados' 
AND chave_parametro = 'versao';