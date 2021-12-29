

CREATE TABLE IF NOT EXISTS `tb_veiculo` (
  `id_veiculo` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
  `ds_placa_veiculo` varchar(20) NULL DEFAULT NULL,
  `ds_tipo_veiculo` varchar(20) NULL DEFAULT NULL,
  `fk_visitante` smallint(6) NULL DEFAULT NULL,
  `fk_morador` smallint(6) NULL DEFAULT NULL,
  `observacao_veiculo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_veiculo`) USING BTREE
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;




UPDATE tb_parametro SET vl_parametro = 'v0005' 
WHERE grupo_parametro = 'banco_dados' 
AND chave_parametro = 'versao';