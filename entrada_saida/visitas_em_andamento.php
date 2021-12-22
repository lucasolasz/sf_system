<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

//Verifica se o usuario está logado
if (!isset($_SESSION['usuarioUsuario'])) {
    header("Location: index.php");
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once $_SESSION['caminhopadrao'] . "header.php"; ?>
<style>
    /* #tableVisitaEmAndamento {

        text-align: center;
        vertical-align: middle;
    } */
</style>

<body>

    <?php require_once $_SESSION['caminhopadrao'] . "nav.php"; ?>

    <div class="container" id="containeralert"> </div>

    <div class="container">
        <h2>Visitas em andamento</h2>
    </div>

    <div class="container">
        <table class="table table-success table-striped" id="tableVisitaEmAndamento">
            <thead>
                <tr>
                    <th>Nome Visitante</th>
                    <th>Tipo Visita</th>
                    <th>Horário de Entrada</th>
                    <th>Tempo de Visita</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" name="btnInformacoes" id="btnInformacoes" onClick="editarUsuario(<?php echo $dados['id_usuario']; ?>)">
                            <img src="../../../bootstrap-icons/exclamation-diamond.svg" alt=""> Informações&nbsp;
                        </button>

                        <button type="button" class="btn btn-danger btn-sm" name="btnSaida" id="btnSaida" onClick="exlcuirUsuario(<?php echo $dados['id_usuario']; ?>)">
                            <img src="../../../bootstrap-icons/arrow-up-square.svg" alt=""> Registra Saida&nbsp;
                        </button>
                    </td>

                </tr>

            </tbody>
        </table>
    </div>

</body>

</html>