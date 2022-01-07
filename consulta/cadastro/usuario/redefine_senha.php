<?php

session_start();

//Verifica se o usuario está logado
if(!isset($_SESSION['confirmaUsuario'])){
    header("Location: esqueci_senha.php");
}


require_once "../../../conexao.php";

if (isset($_SESSION['documentoRecuperaSenha'])){
    
    //Resgata o documento digitado para realizar o update da senha
    $txtDocumento = $_SESSION['documentoRecuperaSenha'];
    
    //Destroi variavel de sessao
    unset($_SESSION['documentoRecuperaSenha']);
    
}


?>


<!doctype html>
<html lang="pt-br">

<?php require_once "../../../header.php"; ?>

    <body class="text-center py-3">


        <h1>Digite a nova senha</h1>

        <main class="form-signin">
            <form name="form_sf_system" id="form_sf_system" method="POST">
                
                <input type="hidden" name="hidOperacaoUpdateSenha" id="hidOperacaoUpdateSenha" value="">
                <input type="hidden" name="hidDocumento" id="hidDocumento" value="<?php echo $txtDocumento ?>">

                <div class="mb-3">
                    <label for="txtSenha" class="form-label">Senha:</label>
                    <input type="password" class="form-control" id="txtSenha" name="txtSenha" placeholder="Digite a nova senha">

                </div>
                <div class="mb-3">
                    <label for="txtConfirmaSenha" class="form-label">Confirme a senha:</label>
                    <input type="password" class="form-control" id="txtConfirmaSenha" name="txtConfirmaSenha" placeholder="Repita a nova senha">                   
                </div>
                
                <br>

                <button type="submit" class="btn btn-success" id="btnGravar" name="btnGravar">
                <img src="../../../bootstrap-icons/check-square-fill.svg" alt="" height="30px" width="30px"> Gravar&nbsp;
                </button>
                
                <button type="submit" class="btn btn-success" id="btnCancelar" name="btnCancelar">
                    <img src="../../../bootstrap-icons/arrow-left-square-fill.svg" alt="" height="30px" width="30px"> Cancelar&nbsp;
                </button>
                

            </form>
        </main>

        <div class="container">
            <p class="text-center text-light" style="background-color: firebrick;">
            <?php
            if (isset($_SESSION['loginErro'])) {
                echo $_SESSION['loginErro'];
                unset($_SESSION['loginErro']);
            }
            ?>
            </p>
        </div>

        <script>
            
            $("#btnCancelar").click(function () {
                var form = document.getElementById("form_sf_system");
                form.action = "/index.php";
                form.submit();
            });
            
            
            $("#btnGravar").click(function () {
                
                $("#hidOperacaoUpdateSenha").val(1);
                
                var form = document.getElementById("form_sf_system");
                form.action = "valida_senha_esquecida.php";
                form.submit();
            });
        </script>


    </body>

</html>