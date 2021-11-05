<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";


$sql = "SELECT * FROM tb_usuario";
$results = $conn->query($sql);

if (isset($_SESSION['corMensagem'])) {

    $corMensagem = $_SESSION['corMensagem'];
}

if (isset($_POST['hidIdUsuario'])){
    $id_usuario = $_POST['hidIdUsuario'];
}


if (isset($_POST['hidIdOperacaoDeletar'])) {
    
    $opercaoDeletar = $_POST['hidIdOperacaoDeletar'];

    if ($opercaoDeletar){
    
        $sql = "DELETE FROM tb_usuario WHERE id_usuario = " . $id_usuario;
        
        $resultsUsuario = mysqli_query($conn, $sql) or die("Erro ao retornar dados");
        
    
        if (!mysqli_query($conn, $sql)) {
            echo "Erro ao deletar o usuario";
            echo "Erro SQL: " . mysqli_error($conn);
    
            $_SESSION['mensagem'] = "Erro ao deletar usuário! Contate o administrador do sistema.";
            $_SESSION['corMensagem'] = "danger";
            mysqli_close($conn);
            header("Location: cad_usuario.php");
            exit();
        } else {
    
            $_SESSION['mensagem'] = "Usuário deletado com sucesso!";
            $_SESSION['corMensagem'] = "success";
            mysqli_close($conn);
            header("Location: cad_usuario.php");
            exit();
        };
    }
}




// echo $corMensagem;

// __halt_compiler();

?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once $_SESSION['caminhopadrao'] . "header.php"; ?>

<body>

    <?php require_once $_SESSION['caminhopadrao'] . "nav.php"; ?>



    <form name="form_sf_system" id="form_sf_system" method="POST">

        <input type="hidden" name="hidIdUsuario" id="hidIdUsuario" value="">
        <input type="hidden" name="hidIdOperacaoDeletar" id="hidIdOperacaoDeletar" value="">

        <div class="container">
            <div class="alert alert-<?php echo $corMensagem; ?> text-center" role="alert">
                <?php if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    unset(
                        $_SESSION['mensagem'],
                        $_SESSION['corMensagem']
                    );
                } ?>
            </div>
        </div>


        <div class="container">
            <h2>Cadastro Usuário</h2>
            <button type="button" class="btn btn-success btn-sm" name="btnAdicionarUsuario" id="btnAdicionarUsuario" onClick="">
                <img src="../../../bootstrap-icons/plus-circle-fill.svg" alt="" height="30px" width="30px"> Novo Usuário&nbsp;
            </button>
        </div>

        <div class="container">
            <table class="table table-success table-striped" id="tableMorador">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Nome de usuário</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($results->num_rows) {
                        while ($dados = $results->fetch_array()) { ?>
                            <tr>
                                <td><?php echo $dados['ds_nome_usuario']; ?></td>
                                <td><?php echo $dados['ds_usuario']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" name="btnEditar" id="btnEditar" onClick="editarUsuario(<?php echo $dados['id_usuario']; ?>)">
                                        <img src="../../../bootstrap-icons/pencil.svg" alt=""> Editar&nbsp;
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm" name="btnExcluir" id="btnExcluir" onClick="exlcuirUsuario(<?php echo $dados['id_usuario']; ?>)">
                                        <img src="../../../bootstrap-icons/trash.svg" alt=""> Excluir&nbsp;
                                    </button>
                                </td>

                            </tr>
                    <?php }
                    } else
                        echo "Nenhum usuário encontrado";
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </form>

    <script>
        $(document).ready(function() {


        });

        function exlcuirUsuario(id_usuario) {

            $("#hidIdUsuario").val(id_usuario);
            $("#hidIdOperacaoDeletar").val(true);
            var form = document.getElementById("form_sf_system");
            form.action = "cad_usuario.php";
            form.submit();

        };

        function editarUsuario(id_usuario) {

            $("#hidIdUsuario").val(id_usuario);
            var form = document.getElementById("form_sf_system");
            form.action = "edit_usuario.php";
            form.submit();

        };

        $("#btnAdicionarUsuario").click(function() {

            var form = document.getElementById("form_sf_system");
            form.action = "edit_usuario.php";
            form.submit();

        });
    </script>


</body>

</html>