<?php

session_start();
session_destroy(); //Destroi todas as variáveis globais deste site

    unset (
        $_SESSION['usuarioID'],
        $_SESSION['usuarioNome'], 
        $_SESSION['usuarioUsuario'],
        $_SESSION['usuarioSenha']
    );

header("Location: index.php");
?>