<?php

//Valida se visitante informado já existe

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";


$documento_morador = trim($_POST["documento_morador"]);

if($documento_morador == "") {
    $mensagem = "";
    echo $mensagem;
    exit();
}

//Retorna cidades de acordo com Estado selecionado
$sql = "SELECT documento_morador FROM tb_morador WHERE documento_morador LIKE '$documento_morador%'";
$results = mysqli_query($conn, $sql) or die("Erro ao retornar dados do morador");

$rowcountMorador = mysqli_num_rows($results);

if ($rowcountMorador > 0) {

    $mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao criar Morador: Já existe <b>DOCUMENTO MORADOR </b> associado a este nome. Utilize outro</div> ";
    echo $mensagem;
} 
