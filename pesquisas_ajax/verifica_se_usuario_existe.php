<?php

//Valida se usuário informado já existe

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";


$ds_usuario = $_POST["ds_usuario"];

//Retorna cidades de acordo com Estado selecionado
$sql = "SELECT ds_usuario FROM tb_usuario WHERE ds_usuario = '$ds_usuario'";
$results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

$rowcountUsuario = mysqli_num_rows($results);

if ($rowcountUsuario > 0) {

    $mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao criar usuário: <b>USUÁRIO DE LOGIN</b> já esta em uso. Utilize outro</div>";
    echo $mensagem;
}
