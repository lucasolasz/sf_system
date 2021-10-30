<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_usuario = $_POST["hidIdUsuario"];
$ds_nome_usuario = trim($_POST["txtNomeUsuario"]);
$ds_endereco = $_POST["txtEnderecoUsuario"];
$ds_complemento = $_POST["txtComplemento"];
$ds_documento = $_POST["txtDocumento"];
$fk_estado = $_POST["cboEstado"];
$fk_cidade = $_POST["cboCidade"];
$fk_cargo = $_POST["cboCargo"];
$fk_tipo_cargo = $_POST["cboTipoUsuário"];
$ds_usuario = $_POST["txtUsuario"];
$ds_senha = $_POST["txtSenha"];


if ($id_usuario == "") {

    $sql = "INSERT INTO tb_usuario (" 
        . "ds_nome_usuario"         
        // . "ds_endereco_usuario = "
        // . "ds_complemento_usuario = "
        // . "ds_documento_usuario = "
        // . "fk_cidade = "
        // . "fk_estado = "
        // . "ds_cep_usuario = "
        // . "fk_cargo_usuario = "
        // . "ds_usuario = "
        // . "ds_senha = "
        // . "fk_tipo_usuario = 
        . ") VALUES ("
        . "'$ds_nome_usuario')";
            
        // echo var_dump($sql);
        // exit()    
        
        if (!mysqli_query($conn, $sql)){
            echo "Erro ao inserir no banco";
            echo "Erro SQL: " . mysqli_error($conn);
        };

        mysqli_close($conn);

        $_SESSION['mensagem'] = "Usuário inserido com sucesso!";
        header("Location: cad_usuario.php");

} else {

    $sql = "UPDATE tb_usuario SET  "
            . "ds_nome_usuario = " 
            . "'$ds_nome_usuario'"
            . "WHERE id_usuario = " . $id_usuario;
    
    
    // echo $sql;
    // __halt_compiler();
    
    if (!mysqli_query($conn, $sql)){
        echo "Erro ao atualizar o banco";
        echo "Erro SQL: " . mysqli_error($conn);
    };
    mysqli_close($conn);

    $_SESSION['mensagem'] = "Usuário atualizado com sucesso!";
    
    header("Location: cad_usuario.php");

} 




?>