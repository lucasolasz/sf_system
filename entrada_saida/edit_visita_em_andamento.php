<?php
session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_visita = $_POST["hidIdVisita"];

// echo $opc_adicionar;
// __halt_compiler();


//Se vazio esta cadastrando novo usuario
if ($id_visita == "") {

    $fk_visitante           = "";
    $ds_placa_veiculo       = "";
    $ds_cor_veiculo         = "";
    $fk_tipo_visitante      = "";
    $dt_entrada_visita      = "";
    $qt_pessoas_carro       = "";
    $observacao_visita      = "";


    $titulo_tela = "Nova Visita";
} else {

    $titulo_tela = "Editar Visita";

    $sql = "SELECT * FROM tb_usuario tus";
    $sql .= " JOIN tb_cidades tcid ON tcid.id_cidade = tus.fk_cidade";
    $sql .= " WHERE id_usuario = " . $id_usuario;

    // echo $sql;
    // exit();
    $resultsUsuario = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

    while ($dados = mysqli_fetch_array($resultsUsuario)) {

        $nome_usuario = $dados['ds_nome_usuario'];
        $endereco_usuario = $dados['ds_endereco_usuario'];
        $complemento_usuario = $dados['ds_complemento_usuario'];
        $documento_usuario = $dados['ds_documento_usuario'];
        $cep_usuario =  $dados['ds_cep_usuario'];
        $fk_estado = $dados['fk_estado'];
        $id_cidade = $dados['id_cidade'];
        $ds_cidade = $dados['ds_cidade'];
        $fk_cargo = $dados['fk_cargo'];
        $fk_tipo_usuario = $dados['fk_tipo_usuario'];
        $usuario = $dados['ds_usuario'];
        $senha = "";
        $cep_usuario = $dados['ds_cep_usuario'];
    }
}

// echo $fk_estado;
// exit();

?>


<!DOCTYPE html>
<html lang="pt-br">

<?php require_once $_SESSION['caminhopadrao'] . "header.php"; ?>

<style>
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

        <input type="hidden" name="hidIdVisita" id="hidIdVisita" value="<?php echo $id_visita ?>">


        <div class="container" id="containeralert"></div>

        <div class="container py-3">

            <!-- Div para mostrar o loading do ajax -->
            <div id="contentLoading">
                <div id="loading"></div>
            </div>

            <h2><?php echo $titulo_tela ?></h2>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="txtNomeVisita">Nome Visita</label>
                    <input type="text" class="form-control" name="txtNomeVisita" id="txtNomeVisita" value="<?php if (isset($nome_usuario)) {
                                                                                                                echo $nome_usuario;
                                                                                                            } ?>" placeholder="Digite o nome">
                </div>
                <div class="form-group col-md-4">
                    <label for="txtDocumento">Documento</label>
                    <input type="text" class="form-control" name="txtDocumento" id="txtDocumento" value="<?php if (isset($endereco_usuario)) {
                                                                                                                echo $endereco_usuario;
                                                                                                            } ?>" maxlength="11" placeholder="Digite o Documento">
                </div>
                <div class="form-group col-md-4">
                    <label for="txtPlacaVeiculo">Placa do Veículo</label>
                    <input type="text" class="form-control" name="txtPlacaVeiculo" id="txtPlacaVeiculo" value="<?php if (isset($documento_usuario)) {
                                                                                                                    echo $documento_usuario;
                                                                                                                } ?>" maxlength="11" placeholder="Digite a placa">
                </div>
            </div>

            <div class="row">

                <div class="form-group col-md-4">
                    <label for="cboCorVeiculo">Cor Veículo</label>
                    <select class="form-select" name="cboCorVeiculo" id="cboCorVeiculo">
                        <option value=""></option>
                    </select>
                </div>


                <div class="form-group col-md-4">
                    <label for="cboTipoVisita">Tipo Visita</label>
                    <select class="form-select" name="cboTipoVisita" id="cboTipoVisita">
                        <option value=""></option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="txtQtdPessoas">Quantidade Pessoas no carro</label>
                    <input type="text" class="form-control" name="txtQtdPessoas" id="txtQtdPessoas" value="<?php if (isset($documento_usuario)) {
                                                                                                                    echo $documento_usuario;
                                                                                                                } ?>" placeholder="Digite a quantidade">
                </div>

            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="txtObervacao">Obervação</label>
                    <textarea class="form-control" id="txtObervacao" rows="3" placeholder="Digite a observação"></textarea>
                </div>
            </div>

            <br>
            <br>

            <div class="row">
                <button type="button" class="btn btn-success btn-lg btn-block">
                <img src="../../../bootstrap-icons/check-square-fill.svg" alt="" height="30px" width="30px"> Registrar Entrada&nbsp;
                </button>
            </div>

        </div>

    </form>


    <script>
        $(document).ready(function() {

            $("#txtCep").mask("99.999-999");

            //Força usuário a digitar somente números
            $("#txtDocumento").keyup(function() {
                $("#txtDocumento").val(this.value.match(/[0-9]*/));
            });

        });

        $("#cboEstado").change(function() {

            id_estado = $('#cboEstado').val();
            carregaCidades(id_estado);
        });

        // Ativa a imagem de load
        function loading_show() {
            // console.log('apresentando ampulheta');
            $('#loading').html("<img src='/img/loading.gif'/>").fadeIn('fast');
        }


        // Desativa a imagem de loading
        function loading_hide() {
            // console.log('escondendo ampulheta');
            $('#loading').fadeOut('fast');
        }

        function carregaCidades(id_estado) {

            $.ajax({
                url: '/pesquisas_ajax/obter_lista_cidades.php',
                type: 'POST',
                data: "id_estado=" + id_estado,
                beforeSend: function() {
                    // loading_show();
                },
                success: function(data) {
                    // loading_hide();
                    $('#cboCidade').html(data);
                },
                error: function(data) {
                    console.log("Ocorreu erro em carregar Cidades via AJAX.");
                    // $('#cboCidade').html("Houve um erro ao carregar");
                }
            });

        }

        function exibeMensagem(msg) {
            mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao criar usuário: " + msg + "</div>";
            return mensagem
        }

        $("#btnEditarUsuario").click(function() {
            var form = document.getElementById("form_sf_system");
            form.action = "grava_usuario.php";
            form.submit();
        });

        usuario_validado = false;

        $("#btnSalvarNovoUsuario").click(function() {

            var ds_usuario = $("#txtUsuario").val();
            var cboEstado = $("#cboEstado").val();
            var cboCargo = $("#cboCargo").val();
            var cboTipoUsuario = $("#cboTipoUsuario").val();

            //Verifica se campos estão vazios para salvar
            $("#containeralert").html("");
            if (cboCargo == "") {
                msg = "<b>Selecione um CARGO</b>";
                $("#containeralert").html(exibeMensagem(msg));
                return false;
            }

            $("#containeralert").html("");
            if (cboTipoUsuario == "") {
                msg = "<b>Selecione um TIPO USUÁRIO</b>";
                $("#containeralert").html(exibeMensagem(msg));
                return false;
            }

            $("#containeralert").html("");
            if (cboEstado == "") {
                msg = "<b>Selecione um ESTADO e uma CIDADE</b>";
                $("#containeralert").html(exibeMensagem(msg));
                return false;
            }

            $("#containeralert").html("");
            if (ds_usuario == "") {
                msg = "<b>Digite um USUÁRIO DE LOGIN</b>";
                $("#containeralert").html(exibeMensagem(msg));
                return false;
            }

            //Invoca a função via Ajax para verificar se existe usuário semelhante
            validaUsuario(ds_usuario);

        });


        function validaUsuario(ds_usuario) {

            $.ajax({
                url: '/pesquisas_ajax/verifica_se_usuario_existe.php',
                type: 'POST',
                data: "ds_usuario=" + ds_usuario,
                beforeSend: function() {
                    // loading_show();
                },
                success: function(data) {
                    // loading_hide();
                    $mensagem = data;
                    $("#containeralert").html($mensagem);
                    if ($mensagem == "") {
                        var form = document.getElementById("form_sf_system");
                        form.action = "grava_usuario.php";
                        form.submit();
                    }
                    //Define um tempo para o elemento sumir da tela.
                    // setTimeout(function(){
                    //     $("#containeralert").fadeOut('Slow');
                    // },4000)
                },
                error: function(data) {
                    console.log("Ocorreu erro ao VALIDAR usuário via AJAX.");
                    // $('#cboCidade').html("Houve um erro ao carregar");
                }
            });

        }


        $("#btnCancelarNovoUsuario").click(function() {

            var form = document.getElementById("form_sf_system");
            form.action = "cad_usuario.php";
            form.submit();

        });
    </script>

</body>

</html>