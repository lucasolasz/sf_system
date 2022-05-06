<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";


$sql = "SELECT * FROM tb_morador";
$results = $conn->query($sql);

if (isset($_SESSION['corMensagem'])) {

    $corMensagem = $_SESSION['corMensagem'];
}

if (isset($_POST['hidIdMorador'])){
    $id_morador = $_POST['hidIdMorador'];
}


if (isset($_POST['hidIdOperacaoDeletar'])) {
    
    $opercaoDeletar = $_POST['hidIdOperacaoDeletar'];

    if ($opercaoDeletar){
    
        $sql = "DELETE FROM tb_morador WHERE id_morador = " . $id_morador;
        
        $resultsVisitante = mysqli_query($conn, $sql) or die("Erro ao DELETAR morador");

        $sql = "DELETE FROM tb_veiculo WHERE fk_morador = " . $id_morador;

        $resultsVisitante = mysqli_query($conn, $sql) or die("Erro ao DELETAR veiculo");
        
              
        if (!mysqli_query($conn, $sql)) {
            // echo "Erro ao deletar o visitante";
            // echo "Erro SQL: " . mysqli_error($conn);
    
            $_SESSION['mensagem'] = "Erro ao DELETAR Morador! Contate o administrador do sistema.";
            $_SESSION['corMensagem'] = "danger";
            mysqli_close($conn);
            header("Location: cad_morador.php");
            exit();
        } else {
    
            $_SESSION['mensagem'] = "Morador DELETADO com sucesso!";
            $_SESSION['corMensagem'] = "success";
            mysqli_close($conn);
            header("Location: cad_morador.php");
            exit();
        };
    }
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
                <input type="text" name="PesquisaNome" id="PesquisaNome" placeholder="Digite o nome ou casa" class="form-control">
            </div>
        </div>
    </div>


    <form name="form_sf_system" id="form_sf_system" method="POST">

        <input type="hidden" name="hidIdMorador" id="hidIdMorador" value="">
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
            <h2>Cadastro Morador</h2>
            <button type="button" class="btn btn-success btn-sm" name="btnAdicionarMorador" id="btnAdicionarMorador" onClick="">
                <img src="../../../bootstrap-icons/plus-circle-fill.svg" alt="" height="30px" width="30px"> Novo Morador&nbsp;
            </button>
        </div>
        
        <br>
        
        <div>
            <div id="resultadoMorador"></div>
        </div>
        
    </form>

    <script>
                
        function buscarNomeMorador(nm_morador){
            $.ajax({
                url: '/pesquisas_ajax/pesquisar_nome_morador.php',
                type: 'POST',
                data: {nm_morador : nm_morador},
                beforeSend: function() {
                    // loading_show();
                },
                success: function(data) {
                    // loading_hide();
                    $("#resultadoMorador").html(data)
                },
                error: function(data) {
                    console.log("Ocorreu erro ao BUSCAR morador via AJAX.");
                    // $('#cboCidade').html("Houve um erro ao carregar");
                }
            });
        }

        $(document).ready(function() {
            
            buscarNomeMorador();
            
            $("#PesquisaNome").keyup(function(){
                var nm_morador = $(this).val();
                if (nm_morador != ""){
                    buscarNomeMorador(nm_morador);
                } else {
                    buscarNomeMorador();
                }
            });
        });       

        function editarMorador(id_morador) {

            $("#hidIdMorador").val(id_morador);
            var form = document.getElementById("form_sf_system");
            form.action = "edit_morador.php";
            form.submit();

        };

        $("#btnAdicionarMorador").click(function() {

            var form = document.getElementById("form_sf_system");
            form.action = "edit_morador.php";
            form.submit();

        });
    </script>


</body>

</html>