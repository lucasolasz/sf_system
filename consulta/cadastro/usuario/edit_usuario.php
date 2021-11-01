<?php
session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_usuario = $_POST["hidIdUsuario"];


    // echo $opc_adicionar;
    // __halt_compiler();



if ($id_usuario == "") {

    $nome_usuario = "";
    $endereco_usuario = "";
    $complemento_usuario = "";
    $documento_usuario = "";
    $fk_estado = "";
    $fk_cidade = "";
    $fk_cargo = "";
    $fk_tipo_usuario = "";
    $usuario = "";
    $senha = "";
    $cep_usuario = "";

    $titulo_tela = "Novo Usuário";

   

} else {
   
    $titulo_tela = "Editar Usuário";

    $sql = "SELECT * FROM tb_usuario WHERE id_usuario = " . $id_usuario;
    $resultsUsuario = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

    while ($dados = mysqli_fetch_array($resultsUsuario)) {

        $nome_usuario = $dados['ds_nome_usuario'];
        $endereco_usuario = $dados['ds_endereco_usuario'];
        $complemento_usuario = $dados['ds_complemento_usuario'];
        $documento_usuario = $dados['ds_documento_usuario'];
        $fk_estado = "";
        $fk_cidade = "";
        $fk_cargo = "";
        $fk_tipo_usuario = "";
        $usuario = $dados['ds_usuario'];
        $senha = "";
        $cep_usuario = $dados['ds_cep_usuario'];
    }
    mysqli_close($conn);

   

}


?>


<!DOCTYPE html>
<html lang="pt-br">

<?php require_once $_SESSION['caminhopadrao'] . "header.php"; ?>

<body>

    <?php require_once $_SESSION['caminhopadrao'] . "nav.php"; ?>

    <form name="form_sf_system" id="form_sf_system" method="POST">

        <input type="hidden" name="hidIdUsuario" id="hidIdUsuario" value="<?php $id_usuario ?>">
        

        <div class="container py-3">
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
                    <input type="text" class="form-control" name="txtComplemento" id="txtComplemento" value="<?php echo $complemento_usuario ?>" placeholder="Digite o Complemento">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="txtDocumento">Documento</label>
                    <input type="text" class="form-control" name="txtDocumento" id="txtDocumento" value="<?php echo $documento_usuario ?>" placeholder="Digite um documento">
                </div>
                <div class="form-group col-md-4">
                    <label for="cboEstado">Estado</label>
                    <select class="form-select" id="cboEstado" name="cboEstado">
                        <option value=""></option>

                        <?php
                        // $sql = "SELECT * FROM tb_estados";
                        // $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

                        // if ($results->num_rows) {
                        //     while ($dados = $results->fetch_array()) {
                        //         $id_estado = $dados['id_estado'];
                        //         $ds_estado = $dados['ds_estado'];

                        //         echo "<option value=$id_estado>$ds_estado</option>";
                        //     }
                        // } else
                        //     echo "Nenhum Estado encontrado";
                        // mysqli_close($conn);
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="cboCidade">Cidade</label>
                    <select class="form-select" id="cboCidade" name="cboCidade">
                        <option value=""></option>
                        <?php
                        // $sql = "SELECT * FROM tb_cidades";
                        // $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");
                        // if ($results->num_rows) {
                        //     while ($dados = $results->fetch_array()) {
                        //         $id_cidade = $dados['id_estado'];
                        //         $ds_cidade =  $dados['ds_estado'];
                        //         echo "<option value=$id_cidade>$ds_cidade</option>";
                        //     }
                        // } else
                        //     echo "Nenhum Estado encontrado"; 
                        //     mysqli_close($conn);  
                        ?>
                    </select>
                </div>
            </div>

            <div class="row">

                <div class="form-group col-md-3">
                    <label for="cboCargo">Cargo</label>
                    <select class="form-select" id="cboCargo" name="cboCargo">
                        <option value=""></option>
                        <option value="">Jardineiro</option>
                        <option value="">Porteiro</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="cboTipoUsuário">Tipo Usuário</label>
                    <select class="form-select" id="cboTipoUsuário" name="cboTipoUsuário">
                        <option value=""></option>
                        <option value="">Empregado</option>
                        <option value="">Administrador</option>
                        <option value="">Super User</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="txtUsuario">Usuario de Login</label>
                    <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" value="<?php echo $usuario ?>" placeholder="Usuario de login">
                </div>

                <div class="form-group col-md-3">
                    <label for="txtSenha">Senha</label>
                    <input type="password" class="form-control" name="txtSenha" id="txtSenha" value="" placeholder="Digite senha de Login">
                </div>
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
      
        
        $("#btnSalvarNovoUsuario").click(function() {

            $("#hidIdUsuario").val(<?php echo $id_usuario ?>);
            var form = document.getElementById("form_sf_system");
            form.action = "grava_usuario.php";
            form.submit();

        });


        $("#btnCancelarNovoUsuario").click(function() {

            var form = document.getElementById("form_sf_system");
            form.action = "cad_usuario.php";
            form.submit();

        });
    </script>

</body>

</html>