<?php
session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_visitante = $_POST["hidIdVisitante"];

// echo $opc_adicionar;
// __halt_compiler();
// 
//Se vazio esta cadastrando novo visitante
if ($id_visitante == "") {

    $nm_visitante = "";
    $documento_visitante = "";
    $telefone_um_visitante = "";
    $telefone_dois_visitante = "";
    $fk_tipo_visitante = "";

    $titulo_tela = "Novo Visitante";
} else {

    $titulo_tela = "Editar Visitante";

    $sql = "SELECT * FROM tb_visitante tvis";
    $sql .= " WHERE id_visitante = " . $id_visitante;

    // echo $sql;
    // exit();
    $resultsVisitante = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

    while ($dados = mysqli_fetch_array($resultsVisitante)) {

        $nm_visitante = $dados['nm_visitante'];
        $documento_visitante = $dados['documento_visitante'];
        $telefone_um_visitante = $dados['telefone_um_visitante'];
        $telefone_dois_visitante = $dados['telefone_dois_visitante'];
        // $fk_tipo_visitante =  $dados['fk_tipo_visitante'];
    }
}

// echo $id_visitante;
// exit();
?>


<!DOCTYPE html>
<html lang="pt-br">

    <?php require_once $_SESSION['caminhopadrao'] . "header.php"; ?>

    <style>
        /* Remove setas do campo DOCUMENTO que tem o tipo number. 
    
        /* Chrome e outros */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        #contentLoading {
            position: absolute;
            z-index: 1;
            left: 50%;
            top: 20%;
            margin-left: -110px;
            margin-top: -40px;
        }
    </style>

    <body>

        <?php require_once $_SESSION['caminhopadrao'] . "nav.php"; ?>

        <form name="form_sf_system" id="form_sf_system" method="POST">

            <input type="hidden" name="hidIdVisitante" id="hidIdVisitante" value="<?php echo $id_visitante ?>">
            <input type="hidden" name="hidIdOperacaoDeletar" id="hidIdOperacaoDeletar" value="">


            <div class="container" id="containeralert"></div>

            <div class="container py-3">

                <!-- Div para mostrar o loading do ajax -->
                <div id="contentLoading">
                    <div id="loading"></div>
                </div>

                <h2><?php echo $titulo_tela ?></h2>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="txtNomeVisitante">Nome Completo Visitante</label>
                        <input type="text" class="form-control" name="txtNomeVisitante" id="txtNomeVisitante" value="<?php
                        if (isset($nm_visitante)) {
                            echo $nm_visitante;
                        }
                        ?>" placeholder="Digite o nome">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtDocumento">Documento</label>
                        <input type="text" class="form-control" name="txtDocumento" id="txtDocumento" value="<?php
                        if (isset($documento_visitante)) {
                            echo $documento_visitante;
                        }
                        ?>" maxlength="11" placeholder="(RG ou CPF) Somente Números">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="txtTelefoneUm">Telefone 1</label>
                        <input type="text" class="form-control" name="txtTelefoneUm" id="txtTelefoneUm" value="<?php
                        if (isset($telefone_um_visitante)) {
                            echo $telefone_um_visitante;
                        }
                        ?>" maxlength="11" pattern="([0-9]{3})" placeholder="Digite o Telefone (Somente Números)">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="txtTelefoneDois">Telefone 2</label>
                        <input type="text" class="form-control" name="txtTelefoneDois" id="txtTelefoneDois" value="<?php
                        if (isset($telefone_dois_visitante)) {
                            echo $telefone_dois_visitante;
                        }
                        ?>" maxlength="11" placeholder="Digite o telefone (Somente Números)">
                    </div>

                </div>

                <br>
                <br>

                <?php if ($id_visitante == "") { ?>
                    <button type="button" class="btn btn-success btn-sm" name="btnSalvarNovoVisitante" id="btnSalvarNovoVisitante" onClick="">
                        <img src="../../../bootstrap-icons/check-square-fill.svg" alt="" height="30px" width="30px"> Salvar&nbsp;
                    </button>
                <?php } else { ?>
                    <button type="button" class="btn btn-success btn-sm" name="btnEditarVisitante" id="btnEditarVisitante" onClick="">
                        <img src="../../../bootstrap-icons/check-square-fill.svg" alt="" height="30px" width="30px"> Salvar&nbsp;
                    </button>
                <?php } ?>

                <button type="button" class="btn btn-success btn-sm" name="btnCancelarNovoVisitante" id="btnCancelarNovoVisitante" onClick="">
                    <img src="../../../bootstrap-icons/arrow-left-square-fill.svg" alt="" height="30px" width="30px"> Cancelar&nbsp;
                </button>

                <?php if ($id_visitante != "") { ?>
                    <button type="button" class="btn btn-danger btn-sm" name="btnExcluir" id="btnExcluir" onClick="exlcuirVisitante(<?php echo $id_visitante ?>)">
                        <img src="../../../bootstrap-icons/trash.svg" alt="" height="30px" width="30px"> Excluir&nbsp;
                    </button>
                <?php } ?>

            </div>
        </form>


        <script>

            $(document).ready(function () {

                //Força usuário a digitar somente números
                $("#txtTelefoneUm").keyup(function () {
                    $("#txtTelefoneUm").val(this.value.match(/[0-9]*/));
                });

                $("#txtTelefoneDois").keyup(function () {
                    $("#txtTelefoneDois").val(this.value.match(/[0-9]*/));
                });

                $("#txtDocumento").keyup(function () {
                    $("#txtDocumento").val(this.value.match(/[0-9]*/));
                });


            });


            $("#btnEditarVisitante").click(function () {
                var form = document.getElementById("form_sf_system");
                form.action = "grava_visitante.php";
                form.submit();
            });

            function exibeMensagem(msg) {
                mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao criar visitante: " + msg + "</div>";
                return mensagem
            }


            $("#btnSalvarNovoVisitante").click(function () {

                var txtNomeVisitante = $("#txtNomeVisitante").val();
                var txtDocumento = $("#txtDocumento").val();

                //Verifica se campos estão vazios para salvar
                $("#txtNomeVisitante").html("");
                if (txtNomeVisitante == "") {
                    msg = "<b>Digite um NOME</b>";
                    $("#containeralert").html(exibeMensagem(msg));
                    return false;
                }

                $("#txtDocumento").html("");
                if (txtDocumento == "") {
                    msg = "<b>Digite um DOCUMENTO</b>";
                    $("#containeralert").html(exibeMensagem(msg));
                    return false;
                }

                //Invoca a função via Ajax para verificar se existe visitante semelhante
                validaVisitante(txtNomeVisitante);

            });

            function validaVisitante(txtNomeVisitante) {

                $.ajax({
                    url: '/pesquisas_ajax/verifica_se_visitante_existe.php',
                    type: 'POST',
                    data: "nm_visitante=" + txtNomeVisitante,
                    beforeSend: function () {
                        // loading_show();
                    },
                    success: function (data) {
                        // loading_hide();
                        $mensagem = data;
                        $("#containeralert").html($mensagem);
                        if ($mensagem == "") {
                            var form = document.getElementById("form_sf_system");
                            form.action = "grava_visitante.php";
                            form.submit();
                        }
                        //Define um tempo para o elemento sumir da tela.
                        // setTimeout(function(){
                        //     $("#containeralert").fadeOut('Slow');
                        // },4000)
                    },
                    error: function (data) {
                        console.log("Ocorreu erro ao VALIDAR usuário via AJAX.");
                        // $('#cboCidade').html("Houve um erro ao carregar");
                    }
                });

            }

            function exlcuirVisitante(id_visitante) {
                
                console.log(id_visitante);

                $("#hidIdVisitante").val(id_visitante);
                $("#hidIdOperacaoDeletar").val(true); 
                var form = document.getElementById("form_sf_system");
                form.action = "cad_visitante.php";
                form.submit();

            }
            

            $("#btnCancelarNovoVisitante").click(function () {

                var form = document.getElementById("form_sf_system");
                form.action = "cad_visitante.php";
                form.submit();

            });
        </script>

    </body>

</html>