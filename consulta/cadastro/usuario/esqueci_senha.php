<?php

session_start();


require_once "../../../conexao.php";


?>


<!doctype html>
<html lang="pt-br">

<?php require_once "../../../header.php"; ?>

    <body class="text-center py-3">


        <h1>Trocar senha de acesso</h1>
        
        <br>
        
        
        <h4>Valide suas informações</h4>

        <main class="form-signin">
            <form name="form_sf_system" id="form_sf_system" method="POST">
                

                <div class="mb-3">
                    <label for="txtUsuario" class="form-label">Usuário cadastrado:</label>
                    <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="Digite usuario cadastrado">
                </div>
                
                <div class="mb-3">
                    <label for="txtDocumento" class="form-label">Documento cadastrado:</label>
                    <input type="text" class="form-control" id="txtDocumento" name="txtDocumento" placeholder="Insira o documento cadastrado">                   
                </div>

                <button type="submit" class="btn btn-success" id="btnCancelar" name="btnCancelar">Cancelar
                </button>

                <button type="submit" class="btn btn-success" id="btnContinuar" name="btnContinuar">Continuar&nbsp;
                    <img src="../../../bootstrap-icons/arrow-right-square-fill.svg" alt="" height="20px" width="20px">
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
            $("#btnContinuar").click(function () {        
                var form = document.getElementById("form_sf_system");
                form.action = "valida_senha_esquecida.php";
                form.submit();
            });
            
            
            $("#btnCancelar").click(function () {
                var form = document.getElementById("form_sf_system");
                form.action = "/index.php";
                form.submit();
            })
        </script>


    </body>

</html>