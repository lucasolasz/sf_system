

CREATE TABLE IF NOT EXISTS `tb_veiculo` (
  `id_veiculo` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
  `ds_placa_veiculo` varchar(20) NULL DEFAULT NULL,
  `fk_visitante` smallint(6) NULL DEFAULT NULL,
  `fk_morador` smallint(6) NULL DEFAULT NULL,
  `fk_cor_veiculo` smallint(6) NULL DEFAULT NULL,
  `fk_tipo_veiculo` smallint(6) NULL DEFAULT NULL,
  PRIMARY KEY (`id_veiculo`) USING BTREE
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;


CREATE TABLE IF NOT EXISTS `tb_tipo_veiculo` (
  `id_tipo_veiculo` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
  `ds_tipo_veiculo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_veiculo`) USING BTREE
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO tb_tipo_veiculo (id_tipo_veiculo, ds_tipo_veiculo) VALUES(1, 'Moto');
INSERT INTO tb_tipo_veiculo (id_tipo_veiculo, ds_tipo_veiculo) VALUES(2, 'Carro');
INSERT INTO tb_tipo_veiculo (id_tipo_veiculo, ds_tipo_veiculo) VALUES(3, 'Caminhão');
INSERT INTO tb_tipo_veiculo (id_tipo_veiculo, ds_tipo_veiculo) VALUES(4, 'Bicicleta');




UPDATE tb_parametro SET vl_parametro = 'v0005' 
WHERE grupo_parametro = 'banco_dados' 
AND chave_parametro = 'versao';