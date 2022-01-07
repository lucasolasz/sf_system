<?php

session_start();
session_destroy(); //Destroi todas as variáveis globais deste site

    unset (
        $_SESSION['usuarioID'],
        $_SESSION['usuarioNome'], 
        $_SESSION['usuarioUsuario'],
        $_SESSION['usuarioSenha'],
        $_SESSION['fk_tipo_usuario'],
        $_SESSION['caminhopadrao']
    );

header("Location: index.php");
?>