<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_usuario = $_POST["hidIdUsuario"];
$ds_nome_usuario = trim($_POST["txtNomeUsuario"]);
$ds_endereco = trim($_POST["txtEnderecoUsuario"]);
$ds_complemento = trim($_POST["txtComplemento"]);
$ds_documento = trim($_POST["txtDocumento"]);
$fk_estado = $_POST["cboEstado"];
$fk_cidade = $_POST["cboCidade"];
$ds_cep = $_POST["txtCep"];
$fk_cargo = $_POST["cboCargo"];
$fk_tipo_usuario = $_POST["cboTipoUsuario"];
$ds_usuario = trim($_POST["txtUsuario"]);
$ds_senha = trim($_POST["txtSenha"]);

//Se vazio está adicionando 
if ($id_usuario == "") {

    $mensagem = "";

    $sql = "INSERT INTO tb_usuario ("
      . "ds_nome_usuario,"
      . "ds_endereco_usuario,"
      . "ds_complemento_usuario,"
      . "ds_documento_usuario,"
      . "fk_cidade,"
      . "fk_estado,"
      . "fk_cargo,"
      . "fk_tipo_usuario,"
      . "ds_cep_usuario,"
      . "ds_usuario,"
      . "ds_senha"
      . ") VALUES ("
      . "'$ds_nome_usuario',"
      . "'$ds_endereco',"
      . "'$ds_complemento',"
      . "'$ds_documento',"
      . "'$fk_cidade',"
      . "'$fk_estado',"
      . "'$fk_cargo',"
      . "'$fk_tipo_usuario',"
      . "'$ds_cep',"
      . "'$ds_usuario',"
      . "md5('" . $ds_senha . "'))";

//         echo $sql;
//         exit();

    if (!mysqli_query($conn, $sql)) {

      //Mensagem Administrativa
      // $mensagem = "Erro SQL: " . mysqli_error($conn);
      $mensagem = "Erro ao INSERIR USUARIO. Contate o Administrador do Sistema";

      $_SESSION['mensagem'] = $mensagem;
      $_SESSION['corMensagem'] = "danger";
      header("Location: cad_usuario.php");
    } else {

      $mensagem = "Usuário cadastrado com sucesso!";

      $_SESSION['mensagem'] = $mensagem;
      $_SESSION['corMensagem'] = "success";
      header("Location: cad_usuario.php");
    };
  
} else {


    //Update dos dados do usuário
    $sql = "UPDATE tb_usuario SET"
        . " ds_nome_usuario = '" . $ds_nome_usuario . "'"
        . " , ds_endereco_usuario = '" . $ds_endereco . "'"
        . " , ds_complemento_usuario = '" . $ds_complemento . "'"
        . " , ds_documento_usuario = '" . $ds_documento . "'"
        . " , fk_cidade = " . $fk_cidade
        . " , fk_estado = " . $fk_estado
        . " , fk_cargo = " . $fk_cargo
        . " , fk_tipo_usuario = " . $fk_tipo_usuario
        . " , ds_cep_usuario = '" . $ds_cep . "'"
        . " WHERE id_usuario = " . $id_usuario;
    
//    echo $sql;
//    exit();

    if (!mysqli_query($conn, $sql)) {
        // echo "Erro ao atualizar o banco";
        // echo "Erro SQL: " . mysqli_error($conn);

        //Mensagem Administrativa
//         $_SESSION['mensagem'] = "Erro Atualizar SQL: " . mysqli_error($conn);
        $_SESSION['mensagem'] = "Erro ao ATUALIZAR USUÁRIO. Contate o Administrador do Sistema";
        $_SESSION['corMensagem'] = "danger";
        mysqli_close($conn);
        header("Location: cad_usuario.php");
        mysqli_close($conn);
    } else {

        $_SESSION['mensagem'] = "Usuário atualizado com sucesso!";
        $_SESSION['corMensagem'] = "warning";
        mysqli_close($conn);
        header("Location: cad_usuario.php");
    };
}
