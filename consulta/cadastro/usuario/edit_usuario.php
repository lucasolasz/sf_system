<?php
session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_usuario = $_POST["hidIdUsuario"];




// echo $opc_adicionar;
// __halt_compiler();


//Se vazio esta cadastrando novo usuario
if ($id_usuario == "") {

    $nome_usuario           = "";
    $endereco_usuario       = "";
    $complemento_usuario    = "";
    $documento_usuario      = "";
    $fk_estado              = "";
    $fk_cidade              = "";
    $id_cidade              = "";
    $ds_cidade              = "";
    $fk_cargo               = "";
    $fk_tipo_usuario        = "";
    $usuario                = "";
    $senha                  = "";
    $cep_usuario            = "";

    $titulo_tela = "Novo Usuário";
} else {

    $titulo_tela = "Editar Usuário";

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
        $fk_tipo_usuario = "";
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

        <input type="hidden" name="hidIdUsuario" id="hidIdUsuario" value="<?php echo $id_usuario ?>">


        <div class="container" id="containeralert">
        

        </div>

        <div class="container py-3">

            <!-- Div para mostrar o loading do ajax -->
            <div id="contentLoading">
                <div id="loading"></div>
            </div>

            <h2><?php echo $titulo_tela ?></h2>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="txtNomeUsuario">Nome Usuário</label>
                    <input type="text" class="form-control" name="txtNomeUsuario" id="txtNomeUsuario" value="<?php echo $nome_usuario ?>" placeholder="Digite o nome">
                </div>
                <div class="form-group col-md-4">
                    <label for="txtEnderecoUsuario">Endereço</label>
                    <input type="text" class="form-control" name="txtEnderecoUsuario" id="txtEnderecoUsuario" value="<?php echo $endereco_usuario ?>" placeholder="Digite o Endereço">
                </div>
                <div class="form-group col-md-4">
                    <label for="txtComplemento">Complemento</label>
                    <input type="text" class="form-control" name="txtComplemento" id="txtComplemento" value="<?php echo $complemento_usuario ?>" maxlength="15" pattern="([0-9]{3})" placeholder="Digite o Complemento">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="txtDocumento">Documento</label>
                    <input type="number" class="form-control" name="txtDocumento" id="txtDocumento" value="<?php echo $documento_usuario ?>" maxlength="15" placeholder="(RG ou CPF) Somente Números">
                </div>

                <div class="form-group col-md-4">
                    <label for="cboEstado">Estado</label>
                    <select class="form-select" id="cboEstado" name="cboEstado">
                        <option value=""></option>
                        <?php
                        $sql = "SELECT * FROM tb_estados";
                        $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

                        if ($results->num_rows) {
                            while ($dados = $results->fetch_array()) {

                                $id_estado = $dados['id_estado'];
                                $ds_estado = $dados['ds_estado'];

                                $estadoSelecionado = "";
                                if ($id_estado == $fk_estado) {
                                    $estadoSelecionado = "selected";
                                }

                                echo "<option $estadoSelecionado value=$id_estado>$ds_estado</option>";
                            }
                        } else
                            echo "Nenhum Estado encontrado";
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="cboCidade">Cidade</label>
                    <select class="form-select" id="cboCidade" name="cboCidade">
                        <!-- Options alimentados via ajax -->
                        <option value="<?php echo $id_cidade ?>"><?php echo $ds_cidade ?></option>
                    </select>
                </div>
            </div>

            <div class="row">

                <div class="form-group col-md-4">
                    <label for="cboCargo">Cargo</label>
                    <select class="form-select" id="cboCargo" name="cboCargo">
                        <option value=""></option>
                        <?php
                        $sql = "SELECT * FROM tb_cargo";
                        $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

                        if ($results->num_rows) {
                            while ($dados = $results->fetch_array()) {

                                $id_cargo = $dados['id_cargo'];
                                $ds_cargo = $dados['ds_cargo'];

                                $cargo_selecionado = "";
                                if ($id_cargo == $fk_cargo) {
                                    $cargo_selecionado = "selected";
                                }

                                echo "<option $cargo_selecionado value=$id_cargo>$ds_cargo</option>";
                            }
                        } else
                            echo "Nenhum Cargo encontrado";
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="cboTipoUsuário">Tipo Usuário</label>
                    <select class="form-select" id="cboTipoUsuário" name="cboTipoUsuário">
                        <option value=""></option>
                        <option value="">Empregado</option>
                        <option value="">Administrador</option>
                        <option value="">Super User</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="txtCep">CEP</label>
                    <input type="text" class="form-control" name="txtCep" id="txtCep" value="<?php echo $cep_usuario ?>" placeholder="Ex.: 00000-000">
                </div>

            </div>

            <div class="row">

                <div class="form-group col-md-4">
                    <label for="txtUsuario">Usuario de Login</label>
                    <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" value="<?php echo $usuario ?>" <?php if ($id_usuario != "") { ?> readonly <?php } ?> placeholder="Usuario de login">
                </div>
                <!-- habilita o campo de senha quando for cadastrar usuario -->
                <?php if ($id_usuario == "") { ?>
                    <div class="form-group col-md-4">
                        <label for="txtSenha">Senha</label>
                        <input type="password" class="form-control" name="txtSenha" id="txtSenha" value="" placeholder="Digite senha de Login">
                    </div>
                <?php } ?>
            </div>

            <br>
            <br>

            <button type="button" class="btn btn-success btn-sm" name="btnSalvarNovoUsuario" id="btnSalvarNovoUsuario" onClick="">
                <img src="../../../bootstrap-icons/check-square-fill.svg" alt="" height="30px" width="30px"> Salvar&nbsp;
            </button>

            <button type="button" class="btn btn-success btn-sm" name="btnCancelarNovoUsuario" id="btnCancelarNovoUsuario" onClick="">
                <img src="../../../bootstrap-icons/arrow-left-square-fill.svg" alt="" height="30px" width="30px"> Cancelar&nbsp;
            </button>


        </div>

    </form>


    <script>
        $(document).ready(function() {

            $("#txtCep").mask("99.999-999");

            usuario_validado = false;

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




        $("#btnSalvarNovoUsuario").click(function() {

            var cboCargo = $("#cboCargo").val();

            //Verifica se cargo foi selecionado
            if (cboCargo == ""){
                mensagemPrrenchimento = "<b>Selecione um cargo</b>";
                mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao criar usuário: " + mensagemPrrenchimento + "</div>";
                $("#containeralert").html(mensagem);
                return false;
            }
            
            ds_usuario = $("#txtUsuario").val();
            validaUsuario(ds_usuario);
            
            //Se usuário for único, prossegue a atualização
            if (usuario_validado){

                // $("#hidIdUsuario").val(id_usuario);
                var form = document.getElementById("form_sf_system");
                form.action = "grava_usuario.php";
                form.submit();
            }

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
                    usuario_validado = true;
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