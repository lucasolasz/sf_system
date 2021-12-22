<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";


$sql = "SELECT * FROM tb_usuario";
$results = $conn->query($sql);

if (isset($_SESSION['corMensagem'])) {

    $corMensagem = $_SESSION['corMensagem'];
}

if (isset($_POST['hidIdUsuario'])) {
    $id_usuario = $_POST['hidIdUsuario'];
}


if (isset($_POST['hidIdOperacaoDeletar'])) {

    $opercaoDeletar = $_POST['hidIdOperacaoDeletar'];

    if ($opercaoDeletar) {

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

    <br>

    <div class="container topo">
        <h2>Pesquisar</h2>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-text">
                    <img src="../../../bootstrap-icons/search.svg" alt="" height="30px" width="30px">&nbsp;
                </span>
                <input type="text" name="PesquisaNome" id="PesquisaNome" placeholder="Digite o nome" class="form-control">
            </div>
        </div>
    </div>



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

        <br>

        <div>
            <div id="resultadoUsuario"></div>
        </div>


    </form>

    <script>
        function buscarNomeUsuario(ds_nome_usuario) {
            $.ajax({
                url: '/pesquisas_ajax/pesquisar_nome_usuario.php',
                type: 'POST',
                data: {
                    ds_nome_usuario: ds_nome_usuario
                },
                beforeSend: function() {
                    // loading_show();
                },
                success: function(data) {
                    // loading_hide();
                    $("#resultadoUsuario").html(data)
                },
                error: function(data) {
                    console.log("Ocorreu erro ao BUSCAR usuário via AJAX.");
                    // $('#cboCidade').html("Houve um erro ao carregar");
                }
            });
        }

        $(document).ready(function() {
            
            buscarNomeUsuario();

            $("#PesquisaNome").keyup(function() {
                var ds_nome_usuario = $(this).val();
                if (ds_nome_usuario != "") {
                    buscarNomeUsuario(ds_nome_usuario);
                } else {
                    buscarNomeUsuario();
                }
            });

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