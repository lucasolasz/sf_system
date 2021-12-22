<?php


//Valida se usuário informado já existe

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

if (isset($_POST["nm_visitante"])) {
    $nm_visitante = $_POST["nm_visitante"];
    //Retorna visitante para pesquisa
    $sql = "SELECT * FROM tb_visitante WHERE nm_visitante LIKE '%$nm_visitante%' ORDER BY nm_visitante";
} else {
    $sql = "SELECT * from tb_visitante ORDER BY nm_visitante";
}


$results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

$rowcountVisitante = mysqli_num_rows($results);

if ($rowcountVisitante > 0) {

    $data = '<div class="container">
        <table class="table table-success table-striped" id="tableVisitante">
        <tr>
            <th>Nome Visitante</th>
            <th>Ações</th>
        </tr>    
    ';
    if ($results->num_rows) {

        while ($dados = $results->fetch_array()) {


            $nm_visitante = $dados['nm_visitante'];
            //Função que converte a String em Primeira maiúscula e restante minúsculo
            $teste = mb_convert_case($nm_visitante , MB_CASE_TITLE , 'UTF-8');
            $id_visitante = $dados['id_visitante'];


            $data .= '
            <tr>
                <td>' . $teste . '</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" name="btnEditar" id="btnEditar" onClick="editarVisitante(' . $id_visitante . ')">
                        <img src="../../../bootstrap-icons/pencil.svg" alt=""> Editar&nbsp;
                    </button>

                    <button type="button" class="btn btn-danger btn-sm" name="btnExcluir" id="btnExcluir" onClick="exlcuirVisitante(' . $id_visitante . ')">
                        <img src="../../../bootstrap-icons/trash.svg" alt=""> Excluir&nbsp;
                    </button>
                </td>
                
            </tr>';
        }
        $data .= '</table></div>';
    }
} else {
    $data = '<div class="container">
    <table class="table table-success table-striped" id="tableVisitante">
    <tr>
        <th>Nome Visitante</th>
        <th>Ações</th>
    </tr>    
    ';
}

echo $data;
