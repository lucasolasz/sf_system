CREATE TABLE IF NOT EXISTS `tb_cor_veiculo` (
  `id_cor_veiculo` smallint(6) NOT NULL AUTO_INCREMENT UNIQUE,
  `ds_cor_veiculo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cor_veiculo`) USING BTREE
)  CHARACTER SET utf8 COLLATE UTF8_GENERAL_CI;

INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(1,'AMARELO');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(2,'AZUL');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(3,'BEGE');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(4,'BRANCA');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(5,'CINZA');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(6,'DOURADA');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(7,'GRENA');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(8,'LARANJA');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(9,'MARROM');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(10,'PRATA');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(11,'PRETA');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(12,'ROSA');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(13,'ROXA');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(14,'VERDE');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(15,'VERMELHA');
INSERT INTO tb_cor_veiculo (id_cor_veiculo, ds_cor_veiculo) VALUES(16,'FANTASIA')


UPDATE tb_parametro SET vl_parametro = 'v0004' 
WHERE grupo_parametro = 'banco_dados' 
AND chave_parametro = 'versao';