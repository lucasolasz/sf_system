<?php


//Valida se usuário informado já existe

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

if (isset($_POST["nm_morador"])) {
    $nm_morador = $_POST["nm_morador"];
    //Retorna morador para pesquisa
    $sql = "SELECT DISTINCT * FROM tb_morador mor"
            . " LEFT JOIN tb_casa tcas ON tcas.id_casa = mor.fk_casa"
            . " WHERE nm_morador LIKE '%$nm_morador%' OR ds_numero_casa LIKE '%$nm_morador%'"
            . " ORDER BY mor.nm_morador";
} else {
    $sql = "SELECT * from tb_morador mor"
        . " LEFT JOIN tb_casa tcas ON tcas.id_casa = mor.fk_casa"
        . " ORDER BY nm_morador";
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
            $ds_numero_casa = $dados['ds_numero_casa'];


            $data .= '
            <tr>
                <td>' . $nome . '</td>
                <td>' . $ds_numero_casa . '</td>
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
