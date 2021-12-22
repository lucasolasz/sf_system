<?php

//Valida se visitante informado já existe

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";


$nm_visitante = $_POST["nm_visitante"];

//Retorna cidades de acordo com Estado selecionado
$sql = "SELECT nm_visitante FROM tb_visitante WHERE nm_visitante LIKE '%$nm_visitante%'";
$results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

$rowcountVisitante = mysqli_num_rows($results);

if ($rowcountVisitante > 0) {

    $mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao criar Visitante: <b>NOME VISITANTE</b> já esta em uso. Utilize outro</div>";
    echo $mensagem;
}
