<?php

session_start();

//Verifica se o usuario está logado
if (!isset($_SESSION['usuarioUsuario'])) {
    header("Location: index.php");
}

$cadastrarMorador = 0;

?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once "../../header.php"; ?>

<body>

    <?php require_once "../../nav.php"; ?>

    <div class="container py-3">
        <h2>Cadastro</h2>
    </div>


    <form name="form_sf_system" id="form_sf_system" method="POST">

        <input type="hidden" name="hidOpcaoMorador" id="hidOpcaoMorador" value="">
        <input type="hidden" name="hidOpcaoVisitante" id="hidOpcaoVisitante" value="">
        <input type="hidden" name="hidOpcaoUsuario" id="hidOpcaoUsuario" value="">

        <div class="container">
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-success" id="btnNovoMorador" name="btnNovoMorador">
                    <img src="/bootstrap-icons/house-fill.svg" alt=""> MORADOR&nbsp;
                </button>
                <button type="button" class="btn btn-success" id="btnNovoVisitante" name="btnNovoVisitante">
                    <img src="/bootstrap-icons/file-person-fill.svg" alt=""> VISITANTE</button>
                
                <?php 
                    //Privileio para administrador
                    if($_SESSION['fk_tipo_usuario'] == 1){ ?>
                
                    <button type="button" class="btn btn-success" id="btnNovoUsuario" name="btnNovoUsuario">
                        <img src="/bootstrap-icons/person-bounding-box.svg" alt=""> USUÁRIO</button>

                <?php  } ?>
            
            </div>
        </div>

    </form>

    <script>
        
        $("#btnNovoVisitante").click(function() {

            // $('#hidOpcaoUsuario').val(1);

            var form = document.getElementById("form_sf_system");
            form.action = "./visitante/cad_visitante.php";
            form.submit();

        });





        $("#btnNovoUsuario").click(function() {

            // $('#hidOpcaoUsuario').val(1);

            var form = document.getElementById("form_sf_system");
            form.action = "./usuario/cad_usuario.php";
            form.submit();

        });
    </script>


</body>

</html>