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
                <input type="text" name="PesquisaNome" id="PesquisaNome" placeholder="Digite o nome ou placa" class="form-control">
            </div>
        </div>
    </div>


    <form name="form_sf_system" id="form_sf_system" method="POST">

        <input type="hidden" name="hidIdVisitante" id="hidIdVisitante" value="">
        <input type="hidden" name="hidIdOperacaoDeletar" id="hidIdOperacaoDeletar" value="">
        
        <br>

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
        <!-- div para receber a tabela resposta do ajax -->
        <div>
            <div id="resultadoVisita"></div>
        </div>
        
    </form>

    <script>
        
        
        //Ajax para gerar e buscar os visitantes cadastrados
        function buscarNomeVisitante(nm_visitante){
            $.ajax({
                url: '/pesquisas_ajax/pesquisar_nome_visitante.php',
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
                    console.log("Ocorreu erro ao BUSCAR visitante via AJAX.");
                    // $('#cboCidade').html("Houve um erro ao carregar");
                }
            });
        }

        $(document).ready(function() {
            
            buscarNomeVisitante();
            
            $("#PesquisaNome").keyup(function(){
                var nm_visitante = $(this).val();
                if (nm_visitante != ""){
                    buscarNomeVisitante(nm_visitante);
                } else {
                    buscarNomeVisitante();
                }
            });
        });

        
        function entradaVisita(id_visitante) {
            $("#hidIdVisitante").val(id_visitante);
            var form = document.getElementById("form_sf_system");
            form.action = "/entrada_saida/edit_visita_em_andamento.php";
            form.submit();
            
        }
        

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