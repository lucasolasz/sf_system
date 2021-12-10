<?php

//Obtem lista de Cidades de Acordo com o Estado Selecionado.

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";


$id_estado = $_POST["id_estado"];

//Retorna cidades de acordo com Estado selecionado
$sql = "SELECT * FROM tb_cidades WHERE fk_estado = $id_estado";
$results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

if ($results->num_rows) {

    while ($dados = $results->fetch_array()){
        
        $id_cidade = $dados['id_cidade'];
        $ds_cidade = $dados['ds_cidade'];

        echo '<option value='. $id_cidade .'>'.$ds_cidade.'</option>';
    
    }
} else 
    echo "Nenhuma Cidade encontrada";

?>

