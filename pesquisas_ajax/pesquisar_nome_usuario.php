<?php


//Valida se usuário informado já existe

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

if (isset($_POST["ds_nome_usuario"])) {
    $ds_nome_usuario = $_POST["ds_nome_usuario"];
    //Retorna visitante para pesquisa
    $sql = "SELECT * FROM tb_usuario WHERE ds_nome_usuario LIKE '%$ds_nome_usuario%' ORDER BY ds_nome_usuario";
} else {
    $sql = "SELECT * FROM tb_usuario ORDER BY ds_nome_usuario";
}

$results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

$rowcountUsuario = mysqli_num_rows($results);

if ($rowcountUsuario > 0) {

    $data = '<div class="container">
        <table class="table table-success table-striped" id="tableUsuario">
        <tr>
            <th>Nome</th>
            <th>Nome Usuário</th>
            <th>Ações</th>
        </tr>    
    ';
    if ($results->num_rows) {

        while ($dados = $results->fetch_array()) {


            $ds_nome_usuario = $dados['ds_nome_usuario'];
            //Função que converte a String em Primeira maiúscula e restante minúsculo
            $ds_nome_usuario_fmt = mb_convert_case($ds_nome_usuario , MB_CASE_TITLE , 'UTF-8');
            $ds_usuario = $dados['ds_usuario'];
            $id_usuario = $dados['id_usuario'];


            $data .= '
            <tr>
                <td>' . $ds_nome_usuario_fmt . '</td>
                <td>' . $ds_usuario . '</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" name="btnEditar" id="btnEditar" onClick="editarUsuario(' . $id_usuario . ')">
                        <img src="../../../bootstrap-icons/pencil.svg" alt=""> Editar&nbsp;
                    </button>

                    <button type="button" class="btn btn-danger btn-sm" name="btnExcluir" id="btnExcluir" onClick="exlcuirUsuario(' . $id_usuario . ')">
                        <img src="../../../bootstrap-icons/trash.svg" alt=""> Excluir&nbsp;
                    </button>
                </td>
                
            </tr>';
        }
        $data .= '</table></div>';
    }
} else {
    $data = '<div class="container">
    <table class="table table-success table-striped" id="tableUsuario">
    <tr>
        <th>Nome</th>
        <th>Nome Usuário</th>
        <th>Ações</th>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center">Nenhum usuário encontrado</td>
    </tr>
    ';
}

echo $data;
