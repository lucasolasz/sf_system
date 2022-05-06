<?php

//Verifica se veiculo está vinculado a alguma visita

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_veiculo = $_POST["id_veiculo"];

$sql = "DELETE FROM tb_veiculo WHERE id_veiculo =  $id_veiculo";

if (!mysqli_query($conn, $sql)) {

    $numeroErro = mysqli_errno($conn);

    if($numeroErro == 1451){
        $mensagem = "Não é possível <b>DELETAR</b> Veículo. Está vinculado a alguma visita"; 
        echo $mensagem;
    } else { 
        $mensagem ="Erro ao <b>DELETAR</b> Veículo! Contate o administrador do sistema.";
        echo $mensagem;
    }

} else {
    $mensagem = "";
    echo $mensagem;
}