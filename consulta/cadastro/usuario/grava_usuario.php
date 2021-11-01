<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";



$operacao_deletar = $_POST["hidIdOperacaoDeletar"];
$id_usuario = $_POST["hidIdUsuario"];


//Se vazio está adicionando 
if ($id_usuario == "") {

    $ds_nome_usuario = trim($_POST["txtNomeUsuario"]);
    $ds_endereco = trim($_POST["txtEnderecoUsuario"]);
    $ds_complemento = trim($_POST["txtComplemento"]);
    $ds_documento = trim($_POST["txtDocumento"]);
    $fk_estado = $_POST["cboEstado"];
    $fk_cidade = $_POST["cboCidade"];
    $fk_cargo = $_POST["cboCargo"];
    $fk_tipo_cargo = $_POST["cboTipoUsuário"];
    $ds_usuario = trim($_POST["txtUsuario"]);
    $ds_senha = trim($_POST["txtSenha"]);

    $sql = "INSERT INTO tb_usuario ("
        . "ds_nome_usuario,"
        . "ds_endereco_usuario,"
        . "ds_complemento_usuario,"
        . "ds_documento_usuario,"
        // . "fk_cidade"
        // . "fk_estado"
        // . "ds_cep_usuario"
        // . "fk_cargo_usuario"
        . "ds_usuario,"
        . "ds_senha"
        // . "fk_tipo_usuario
        . ") VALUES ("
        . "'$ds_nome_usuario',"
        . "'$ds_endereco',"
        . "'$ds_complemento',"
        . "'$ds_documento',"
        . "'$ds_usuario',"
        . "md5('" . $ds_senha . "'))";


    // echo var_dump($sql);
    // exit();

    if (!mysqli_query($conn, $sql)) {
        echo "Erro ao inserir no banco";
        echo "Erro SQL: " . mysqli_error($conn);
        // exit();

        $_SESSION['mensagem'] = "Erro ao incluir usuário! Contate o administrador do sistema.";
        $_SESSION['corMensagem'] = "danger";
        mysqli_close($conn);
        header("Location: cad_usuario.php");
    } else {
        $_SESSION['mensagem'] = "Usuário inserido com sucesso!";
        $_SESSION['corMensagem'] = "danger";
        mysqli_close($conn);
        header("Location: cad_usuario.php");
    };
    
} else {



    if ($operacao_deletar == true) {

        $sql = "DELETE FROM tb_usuario WHERE id_usuario = " . $id_usuario;
        $resultsUsuario = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

        if (!mysqli_query($conn, $sql)) {
            echo "Erro ao deletar o usuario";
            echo "Erro SQL: " . mysqli_error($conn);

            $_SESSION['mensagem'] = "Erro ao deletar usuário! Contate o administrador do sistema.";
            $_SESSION['corMensagem'] = "danger";
            mysqli_close($conn);
            header("Location: cad_usuario.php");
            exit();
        } else {

            $_SESSION['mensagem'] = "Usuário deletado com sucesso!";
            $_SESSION['corMensagem'] = "success";
            mysqli_close($conn);
            header("Location: cad_usuario.php");
            exit();
        };
    }

    $sql = "UPDATE tb_usuario SET  "
        . "ds_nome_usuario = "
        . "'$ds_nome_usuario'"
        . "WHERE id_usuario = " . $id_usuario;


    // echo $sql;
    // __halt_compiler();

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
        $_SESSION['corMensagem'] = "success";
        mysqli_close($conn);
        header("Location: cad_usuario.php");
    };
} 

// if ($opc_excluir == true) {

//     

// }
