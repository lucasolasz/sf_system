<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

//Define o timezone para são paulo
date_default_timezone_set('America/Sao_Paulo');


$id_usuarioLogado =  $_SESSION['usuarioID'];
$nm_usuarioLogado = $_SESSION['usuarioNome'];
$id_visita = $_POST["hidIdVisita"];

//Captura o valor do ano/mes/dia - Hora/minuto/segundo
$anoMesDia = date("Y-m-d");

//Captura Hora/minuto/segundo
$horaMinutoSegundo = date("H:i:s"); 


$sql = "UPDATE tb_visita SET"
        . " dt_saida_visita = '" . $anoMesDia . "'"
        . " , dt_hora_saida_visita = '" . $horaMinutoSegundo . "'"
        . " , fk_usuario_saida = '" . $id_usuarioLogado . "'"
        . " WHERE id_visita = " . $id_visita;

if (!mysqli_query($conn, $sql)) {
    // echo "Erro ao deletar o visitante";
    // echo "Erro SQL: " . mysqli_error($conn);
    $_SESSION['mensagem'] = "Erro ao registrar SAIDA da visita! Contate o administrador do sistema.";
    $_SESSION['corMensagem'] = "danger";

    header("Location: visitas_em_andamento.php");
} else {
   
    $mensagem = "Registro de saída da VISITA realizado com sucesso!";

    $_SESSION['mensagem'] = $mensagem;
    $_SESSION['corMensagem'] = "success";
    header("Location: visitas_em_andamento.php");

}