<?php

session_start();

//Verifica se o usuario está logado
if(!isset($_SESSION['usuarioUsuario'])){
    header("Location: index.php");
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once "header.php"; ?>


<body>

    <?php require_once "nav.php"; ?>

    <div class="container">
        <img src="/img/Logo.png" class="img-fluid" alt="" height="300px" width="900px" style="display: block; margin-left: auto; margin-right: auto;">
    </div>

</body>

</html>