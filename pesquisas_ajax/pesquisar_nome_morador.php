<?php


//Valida se usuário informado já existe

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

if (isset($_POST["nm_morador"])) {
    $nm_morador = $_POST["nm_morador"];
    //Retorna morador para pesquisa
    $sql = "SELECT DISTINCT mor.nm_morador, vis.id_morador FROM tb_morador mor"
            . " LEFT JOIN tb_veiculo tvei ON tvei.fk_morador = mor.id_morador"
            . " WHERE mor.nm_morador LIKE '%$nm_morador%' OR tvei.ds_placa_veiculo LIKE '%$nm_morador%' "
            . " ORDER BY mor.nm_morador";
} else {
    $sql = "SELECT * from tb_morador ORDER BY nm_morador";
}


$results = mysqli_query($conn, $sql) or die("Erro ao retornar dados do morador");

$rowcountMorador = mysqli_num_rows($results);

if ($rowcountMorador > 0) {

    $data = '<div class="container">
        <table class="table table-success table-striped" id="tableMorador">
        <tr>
            <th>Nome Morador</th>
            <th>Número Casa</th>
            <th>Ações</th>
        </tr>    
    ';
    if ($results->num_rows) {

        while ($dados = $results->fetch_array()) {


            $nm_morador = $dados['nm_morador'];
            //Função que converte a String em Primeira maiúscula e restante minúsculo
            $nome = mb_convert_case($nm_morador , MB_CASE_TITLE , 'UTF-8');
            $id_morador = $dados['id_morador'];
            $num_casa_morador = $dados['num_casa_morador'];


            $data .= '
            <tr>
                <td>' . $nome . '</td>
                <td>' . $num_casa_morador . '</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" name="btnEditar" id="btnEditar" onClick="editarMorador(' . $id_morador . ')">
                        <img src="../../../bootstrap-icons/pencil.svg" alt=""> Editar&nbsp;
                    </button>                   
                </td>
                
            </tr>';
        }
        $data .= '</table></div>';
    }
} else {
    $data = '<div class="container">
    <table class="table table-success table-striped" id="tableMorador">
    <tr>
        <th>Nome Morador</th>
        <th>Número Casa</th>
        <th>Ações</th>
    </tr> 
    <tr>
        <td colspan="3" style="text-align: center">Nenhum Morador encontrado</td>
    </tr>
    ';
}

echo $data;
