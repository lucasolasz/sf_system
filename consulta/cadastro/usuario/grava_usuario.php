<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

// $operacao_deletar = $_POST["hidIdOperacaoDeletar"];
$id_usuario = $_POST["hidIdUsuario"];
$ds_nome_usuario = trim($_POST["txtNomeUsuario"]);
$ds_endereco = trim($_POST["txtEnderecoUsuario"]);
$ds_complemento = trim($_POST["txtComplemento"]);
$ds_documento = trim($_POST["txtDocumento"]);
$fk_estado = $_POST["cboEstado"];
$fk_cidade = $_POST["cboCidade"];
$ds_cep = $_POST["txtCep"];
$fk_cargo = $_POST["cboCargo"];
$fk_tipo_cargo = $_POST["cboTipoUsuário"];
$ds_usuario = trim($_POST["txtUsuario"]);
$ds_senha = trim($_POST["txtSenha"]);


//Se vazio está adicionando 
if ($id_usuario == "") {

    $mensagem = "";

    // Verifica se tem usuario semelhante no banco
    $sql = "SELECT ds_usuario FROM tb_usuario WHERE ds_usuario = '$ds_usuario'";
    if ($result = mysqli_query($conn, $sql)) {
        //retorna quantidade de linhas da query
        $rowcountUsuario = mysqli_num_rows($result);
    }

    if ($rowcountUsuario > 0) {
        $mensagem = "Falha ao criar usuário: <b>USUÁRIO DE LOGIN</b> já esta em uso. Utilize outro";
    } 
   

    if ($mensagem == ""){

        

        $sql = "INSERT INTO tb_usuario ("
        . "ds_nome_usuario,"
        . "ds_endereco_usuario,"
        . "ds_complemento_usuario,"
        . "ds_documento_usuario,"
        // . "fk_cidade"
        // . "fk_estado"
        // . "ds_cep_usuario"
        // . "fk_cargo_usuario"
        . "ds_cep_usuario,"
        . "ds_usuario,"
        . "ds_senha"
        // . "fk_tipo_usuario
        . ") VALUES ("
        . "'$ds_nome_usuario',"
        . "'$ds_endereco',"
        . "'$ds_complemento',"
        . "'$ds_documento',"
        . "'$ds_cep',"
        . "'$ds_usuario',"
        . "md5('" . $ds_senha . "'))";

        mysqli_query($conn, $sql);

        $mensagem = "Usuário cadastrado com sucesso!";

        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['corMensagem'] = "success";
        header("Location: cad_usuario.php");

    } else {

        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['corMensagem'] = "danger";
        header("Location: cad_usuario.php");

    }
 

    
} else {
    
   
    //Update dos dados do usuário
    $sql = "UPDATE tb_usuario SET  "
        . "ds_nome_usuario = "
        . " '$ds_nome_usuario'"
        . " WHERE id_usuario = " . $id_usuario;


    // echo $sql;
    // exit();

    if (!mysqli_query($conn, $sql)) {
        echo "Erro ao atualizar o banco";
        echo "Erro SQL: " . mysqli_error($conn);

        $_SESSION['mensagem'] = "Erro ao atualizar usuário! Contate o administrador do sistema.";
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