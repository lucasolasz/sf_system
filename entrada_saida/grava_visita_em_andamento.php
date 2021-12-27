<?php 

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_visita = $_POST["hidIdVisita"];
$txtNomeVisita = trim($_POST["txtNomeVisita"]);
$txtDocumento = trim($_POST["txtDocumento"]);
$txtPlacaVeiculo = trim($_POST["txtPlacaVeiculo"]);
$cboCorVeiculo = trim($_POST["cboCorVeiculo"]);
$cboTipoVisita = $_POST["cboTipoVisita"];
$txtQtdPessoas = $_POST["txtQtdPessoas"];
$txtNumeroCasa = $_POST["txtNumeroCasa"];
$txtObervacao = $_POST["txtObervacao"];

//Define o timezone para são paulo
date_default_timezone_set('America/Sao_Paulo');

//Captura o valor do dia/mes/ano
$diaMesAno = date("d.m.y");

//Captura Hora/minuto/segundo
$horaMinutoSegundo = date("H:i:s");


$mensagem = "";


    $sql = "INSERT INTO tb_visita ("
      . "fk_visitante,"
      . "ds_placa_veiculo,"
      . "fk_cor_veiculo,"
      . "fk_tipo_visita,"
      . "dt_entrada_visita,"
      . "dt_hora_entrada_visita,"
      . "qt_pessoas_carro,"
      . "numero_casa_visita,"
      . "observacao_visita"
      . ") VALUES ("
      . "'$id_visita',"
      . "'$txtPlacaVeiculo',"
      . "'$cboCorVeiculo',"
      . "'$cboTipoVisita',"
      . "'$diaMesAno',"
      . "'$horaMinutoSegundo',"
      . "'$txtQtdPessoas',"
      . "'$txtNumeroCasa',"
      . "'$txtObervacao')";

    
    echo $sql;


?>