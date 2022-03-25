<?php

session_start();

include_once ("../../../conexao.php");


if (isset($_POST['hidOperacaoUpdateSenha'])){
    
  $hidOperacaoUpdateSenha = $_POST['hidOperacaoUpdateSenha'];
  
  
  if ($hidOperacaoUpdateSenha == 1) {
  
   //Prevenindo SQL injection, caracteres especiais   
   $senha = mysqli_real_escape_string($conn, $_POST['txtSenha']);
   $confirmaSenha = mysqli_real_escape_string($conn, $_POST['txtConfirmaSenha']);
   $hidDocumento = mysqli_real_escape_string($conn, $_POST['hidDocumento']);   
   
   if ($senha == $confirmaSenha){
       
       
       $sql = "UPDATE tb_usuario SET ds_senha = md5('" .  $senha . "') WHERE ds_documento_usuario = '" . $hidDocumento . "'";
       echo $sql;
       exit();
        if (!mysqli_query($conn, $sql)) {
            
            $_SESSION['loginErro'] = "Erro ao ALTERAR a senha. Contate o Administrador do sistema.";
            header("Location: redefine_senha.php");
        } else {
       
            $_SESSION['loginErro'] = "Senha ALTERADA com sucesso";
            $_SESSION['corMensagem'] = 'Lime';
            header("Location: /index.php");
        }

   }else{
       
       $_SESSION['loginErro'] = "As senhas não conferem. Digite novamente";
       header("Location: redefine_senha.php");
       
   }
      

  }
  
    
} else {

    
    if ((isset($_POST['txtUsuario'])) && (isset($_POST['txtDocumento']))) {

        //Prevenindo SQL injection, caracteres especiais
        $usuario = mysqli_real_escape_string($conn, $_POST['txtUsuario']); 
        $documento = mysqli_real_escape_string($conn, $_POST['txtDocumento']);

        //Atribui valor para variavel de sessao e ser resgatado na pagina redefine_senha.php
        $_SESSION['documentoRecuperaSenha'] = $documento;



        $sql = "SELECT * FROM tb_usuario WHERE ds_usuario = '$usuario' && ds_documento_usuario = '$documento' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $resultado = mysqli_fetch_assoc($result);

        if(empty($resultado)){

            $_SESSION['loginErro'] = "Usuário ou senha inválido";
            header("Location: esqueci_senha.php");

        }elseif (isset($resultado)){

            $_SESSION['confirmaUsuario'] = true;

            header("Location: redefine_senha.php");
        }else{

            $_SESSION['loginErro'] = "Usuário ou senha inválido";
            header("Location: esqueci_senha.php");
        } 



    } else {
        $_SESSION['loginErro'] = "Usuário ou senha em inválido";
        header("Location: esqueci_senha.php");
    }

}

?>