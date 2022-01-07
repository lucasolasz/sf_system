<?php

session_start();

include_once ("conexao.php");

if ((isset($_POST['txtUsuario'])) && (isset($_POST['txtSenha']))) {

    //Prevenindo SQL injection, caracteres especiais
    $usuario = mysqli_real_escape_string($conn, $_POST['txtUsuario']); 
    $senha = mysqli_real_escape_string($conn, $_POST['txtSenha']); 

    //Criptografia
    $senha = md5($senha);


    $sql = "SELECT * FROM tb_usuario WHERE ds_usuario = '$usuario' && ds_senha = '$senha' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $resultado = mysqli_fetch_assoc($result);

    if(empty($resultado)){
       
        $_SESSION['loginErro'] = "Usuário ou senha inválido";
        header("Location: index.php");
    
    }elseif (isset($resultado)){
        
        $_SESSION['usuarioID'] = $resultado['id_usuario'];
        $_SESSION['usuarioNome'] = $resultado['ds_nome'];
        $_SESSION['usuarioUsuario'] = $resultado['ds_usuario'];
        $_SESSION['usuarioSenha'] = $resultado['ds_senha'];
        $_SESSION['fk_tipo_usuario'] = $resultado['fk_tipo_usuario'];
        $_SESSION['caminhopadrao'] = $_SERVER['DOCUMENT_ROOT'] . "/";

        header("Location: home.php");
    }else{
       
        $_SESSION['loginErro'] = "Usuário ou senha inválido";
        header("Location: index.php");
    } 
    

 
} else {
    $_SESSION['loginErro'] = "Usuário ou senha inválido";
    header("Location: index.php");
}



?>