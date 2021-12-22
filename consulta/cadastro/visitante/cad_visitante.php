<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";


$sql = "SELECT * FROM tb_visitante";
$results = $conn->query($sql);

if (isset($_SESSION['corMensagem'])) {

    $corMensagem = $_SESSION['corMensagem'];
}

if (isset($_POST['hidIdVisitante'])){
    $id_visitante = $_POST['hidIdVisitante'];
}


if (isset($_POST['hidIdOperacaoDeletar'])) {
    
    $opercaoDeletar = $_POST['hidIdOperacaoDeletar'];

    if ($opercaoDeletar){
    
        $sql = "DELETE FROM tb_visitante WHERE id_visitante = " . $id_visitante;
        
        $resultsVisitante = mysqli_query($conn, $sql) or die("Erro ao retornar dados");
        
    
        if (!mysqli_query($conn, $sql)) {
            // echo "Erro ao deletar o visitante";
            // echo "Erro SQL: " . mysqli_error($conn);
    
            $_SESSION['mensagem'] = "Erro ao DELETAR Visitante! Contate o administrador do sistema.";
            $_SESSION['corMensagem'] = "danger";
            mysqli_close($conn);
            header("Location: cad_visitante.php");
            exit();
        } else {
    
            $_SESSION['mensagem'] = "Visitante DELETADO com sucesso!";
            $_SESSION['corMensagem'] = "success";
            mysqli_close($conn);
            header("Location: cad_visitante.php");
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

        <input type="hidden" name="hidIdVisitante" id="hidIdVisitante" value="">
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
            <h2>Cadastro Visitante</h2>
            <button type="button" class="btn btn-success btn-sm" name="btnAdicionarVisitante" id="btnAdicionarVisitante" onClick="">
                <img src="../../../bootstrap-icons/plus-circle-fill.svg" alt="" height="30px" width="30px"> Novo Visitante&nbsp;
            </button>
        </div>
        
        <br>
        
        <div>
            <div id="resultadoVisita"></div>
        </div>
        
    </form>

    <script>
                
        function buscarNome(nm_visitante){
            $.ajax({
                url: '/pesquisas_ajax/pesquisar_nome.php',
                type: 'POST',
                data: {nm_visitante : nm_visitante},
                beforeSend: function() {
                    // loading_show();
                },
                success: function(data) {
                    // loading_hide();
                    $("#resultadoVisita").html(data)
                },
                error: function(data) {
                    console.log("Ocorreu erro ao VALIDAR usuário via AJAX.");
                    // $('#cboCidade').html("Houve um erro ao carregar");
                }
            });
        }

        $(document).ready(function() {
            
            buscarNome();
            
            $("#PesquisaNome").keyup(function(){
                var nm_visitante = $(this).val();
                if (nm_visitante != ""){
                    buscarNome(nm_visitante);
                } else {
                    buscarNome();
                }
            });
        });



        function exlcuirVisitante(id_visitante) {

            $("#hidIdVisitante").val(id_visitante);
            $("#hidIdOperacaoDeletar").val(true);
            var form = document.getElementById("form_sf_system");
            form.action = "cad_visitante.php";
            form.submit();

        };

        function editarVisitante(id_visitante) {

            $("#hidIdVisitante").val(id_visitante);
            var form = document.getElementById("form_sf_system");
            form.action = "edit_visitante.php";
            form.submit();

        };

        $("#btnAdicionarVisitante").click(function() {

            var form = document.getElementById("form_sf_system");
            form.action = "edit_visitante.php";
            form.submit();

        });
    </script>


</body>

</html>