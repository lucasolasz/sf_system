<?php
session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_usuario = $_POST["hidIdUsuario"];

//Se vazio esta cadastrando novo usuario
if ($id_usuario == "") {
    
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
        $fk_tipo_usuario = $dados['fk_tipo_usuario'];
        $usuario = $dados['ds_usuario'];
        $senha = "";
        $cep_usuario = $dados['ds_cep_usuario'];
    }
}

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


        <div class="container" id="containeralert"></div>

        <div class="container py-3">

            <!-- Div para mostrar o loading do ajax -->
            <div id="contentLoading">
                <div id="loading"></div>
            </div>

            <h2><?php echo $titulo_tela ?></h2>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="txtNomeUsuario">Nome Usuário</label>
                    <input type="text" class="form-control" name="txtNomeUsuario" id="txtNomeUsuario" value="<?php if (isset($nome_usuario)) {
                                                                                                                    echo $nome_usuario;
                                                                                                                } ?>" placeholder="Digite o nome">
                </div>
                <div class="form-group col-md-4">
                    <label for="txtEnderecoUsuario">Endereço</label>
                    <input type="text" class="form-control" name="txtEnderecoUsuario" id="txtEnderecoUsuario" value="<?php if (isset($endereco_usuario)) {
                                                                                                                            echo $endereco_usuario;
                                                                                                                        } ?>" placeholder="Digite o Endereço">
                </div>
                <div class="form-group col-md-4">
                    <label for="txtComplemento">Complemento</label>
                    <input type="text" class="form-control" name="txtComplemento" id="txtComplemento" value="<?php if (isset($complemento_usuario)) {
                                                                                                                    echo $complemento_usuario;
                                                                                                                } ?>" maxlength="15" pattern="([0-9]{3})" placeholder="Digite o Complemento">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="txtDocumento">Documento</label>
                    <input type="text" class="form-control" name="txtDocumento" id="txtDocumento" value="<?php if (isset($documento_usuario)) {
                                                                                                                echo $documento_usuario;
                                                                                                            } ?>" maxlength="11" placeholder="(RG ou CPF) Somente Números">
                </div>

                <div class="form-group col-md-4">
                    <label for="cboEstado">Estado</label>
                    <select class="form-select" id="cboEstado" name="cboEstado">
                        <option value="NULL"></option>
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
                        <option value="<?php echo $id_cidade ?>"><?php if (isset($ds_cidade)) {
                                                                        echo $ds_cidade;
                                                                    } ?></option>
                    </select>
                </div>
            </div>

            <div class="row">

                <div class="form-group col-md-4">
                    <label for="cboCargo">Cargo</label>
                    <select class="form-select" id="cboCargo" name="cboCargo">
                        <option value="NULL"></option>
                        <?php
                        $sql = "SELECT * FROM tb_cargo ORDER BY ds_cargo";
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
                    <label for="cboTipoUsuario">Tipo Usuário</label>
                    <select class="form-select" id="cboTipoUsuario" name="cboTipoUsuario">
                        <option value="NULL"></option>
                        <?php
                        $sql = "SELECT * FROM tb_tipo_usuario ORDER BY ds_tipo_usuario";
                        $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

                        if ($results->num_rows) {
                            while ($dados = $results->fetch_array()) {

                                $id_tipo_usuario = $dados['id_tipo_usuario'];
                                $ds_tipo_usuario = $dados['ds_tipo_usuario'];

                                $tipo_usuario_selecionado = "";
                                if ($id_tipo_usuario == $fk_tipo_usuario) {
                                    $tipo_usuario_selecionado = "selected";
                                }

                                echo "<option $tipo_usuario_selecionado value=$id_tipo_usuario>$ds_tipo_usuario</option>";
                            }
                        } else
                            echo "Nenhum Tipo de Usuário encontrado";
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="txtCep">CEP</label>
                    <input type="text" class="form-control" name="txtCep" id="txtCep" value="<?php if (isset($complemento_usuario)) {
                                                                                                    echo $cep_usuario;
                                                                                                } ?>" placeholder="Ex.: 00000-000">
                </div>

            </div>

            <div class="row">

                <div class="form-group col-md-4">
                    <label for="txtUsuario">Usuario de Login</label>
                    <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" value="<?php if (isset($complemento_usuario)) {
                                                                                                            echo $usuario;
                                                                                                        } ?>" <?php if ($id_usuario != "") { ?> readonly <?php } ?> placeholder="Usuario de login">
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

            <button type="button" class="btn btn-success btn-lg" name="btnCancelarNovoUsuario" id="btnCancelarNovoUsuario" onClick="">Cancelar</button>

            <?php if ($id_usuario == "") { ?>
                <button type="button" class="btn btn-success btn-lg" name="btnSalvarNovoUsuario" id="btnSalvarNovoUsuario" onClick="validaCamposNovoUsuario()">
                    <img src="../../../bootstrap-icons/check-square-fill.svg" alt=""> Salvar&nbsp;
                </button>
            <?php } else { ?>
                <button type="button" class="btn btn-success btn-lg" name="btnEditarUsuario" id="btnEditarUsuario" onClick="validaCamposEditUsuario()">
                    <img src="../../../bootstrap-icons/check-square-fill.svg" alt=""> Salvar&nbsp;
                </button>
            <?php } ?>




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
        
        usuario_validado = false;

        function validaCamposNovoUsuario() {
            
            var txtDocumento = $("#txtDocumento").val();
            var txtNomeUsuario = $("#txtNomeUsuario").val();
            var ds_usuario = $("#txtUsuario").val();
            var cboEstado = $("#cboEstado").val();
            var cboCargo = $("#cboCargo").val();
            var cboTipoUsuario = $("#cboTipoUsuario").val();
            var txtSenha = $("#txtSenha").val();

            //Verifica se campos estão vazios para salvar
            $("#containeralert").html("");
            if (txtNomeUsuario == "") {
                msg = "<b>Digite um NOME</b>";
                $("#containeralert").html(exibeMensagem(msg));
                return false;
            }

            $("#containeralert").html("");
            if (txtDocumento == "") {
                msg = "<b>Digite um DOCUMENTO</b>";
                $("#containeralert").html(exibeMensagem(msg));
                return false;
            }

            $("#containeralert").html("");
            if (cboCargo == "NULL") {
                msg = "<b>Selecione um CARGO</b>";
                $("#containeralert").html(exibeMensagem(msg));
                return false;
            }

            $("#containeralert").html("");
            if (cboTipoUsuario == "NULL") {
                msg = "<b>Selecione um TIPO USUÁRIO</b>";
                $("#containeralert").html(exibeMensagem(msg));
                return false;
            }

            $("#containeralert").html("");
            if (cboEstado == "NULL") {
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

            $("#containeralert").html("");
            if (txtSenha == "") {
                msg = "<b>Digite uma SENHA</b>";
                $("#containeralert").html(exibeMensagem(msg));
                return false;
            }

            //Invoca a função via Ajax para verificar se existe usuário semelhante
            validaUsuario(ds_usuario);

        };

        function validaCamposEditUsuario() {

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

            var form = document.getElementById("form_sf_system");
            form.action = "grava_usuario.php";
            form.submit();


        };


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