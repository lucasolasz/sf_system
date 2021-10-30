<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";


$sql = "SELECT * FROM tb_usuario";
$results = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once $_SESSION['caminhopadrao'] . "header.php"; ?>

<body>

    <?php require_once $_SESSION['caminhopadrao'] . "nav.php"; ?>



    <form name="form_sf_system" id="form_sf_system" method="POST">

        <input type="hidden" name="hidOpcaoAdicionar" id="hidOpcaoAdicionar" value="">
        <input type="hidden" name="hidOpcaoEditar" id="hidOpcaoEditar" value="">
        <input type="hidden" name="hidOpcaoExcluir" id="hidOpcaoExcluir" value="">
        <input type="hidden" name="hidIdUsuario" id="hidIdUsuario" value="">

        <p class="text-center text-light py-3" style="background-color: success;">
            <?php if (isset($_SESSION['mensagem'])) {
                echo $_SESSION['mensagem'];
                unset($_SESSION['mensagem']);
            } ?>
        </p> 

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

                                    <button type="button" class="btn btn-danger btn-sm" name="btnExcluir" id="btnExcluir" onClick="">
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