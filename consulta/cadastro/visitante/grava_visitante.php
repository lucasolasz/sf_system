<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_visitante = $_POST["hidIdVisitante"];
$nm_visitante = trim($_POST["txtNomeVisitante"]);
$documento_visitante = trim($_POST["txtDocumento"]);
$telefone_um_visitante = trim($_POST["txtTelefoneUm"]);
$telefone_dois_visitante = trim($_POST["txtTelefoneDois"]);

//Se vazio está adicionando 
if ($id_visitante == "") {

    $mensagem = "";


    $sql = "INSERT INTO tb_visitante ("
        . "nm_visitante,"
        . "documento_visitante,"
        . "telefone_um_visitante,"
        . "telefone_dois_visitante"
        . ") VALUES ("
        . "'$nm_visitante',"
        . "'$documento_visitante',"
        . "'$telefone_um_visitante',"
        . "'$telefone_dois_visitante')";

    // echo $sql;
    // exit();

    if (!mysqli_query($conn, $sql)) {

        //Mensagem Administrativa
        $mensagem = "Erro SQL: " . mysqli_error($conn);
        // $mensagem = "Erro ao INSERIR VISITANTE. Contate o Administrador do Sistema";

        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['corMensagem'] = "danger";
        header("Location: cad_visitante.php");
    } else {

        $mensagem = "Visitante CADASTRADO com sucesso!";

        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['corMensagem'] = "success";
        header("Location: cad_visitante.php");
    };
    // }
} else {


    //Update dos dados do visitante
    $sql = "UPDATE tb_visitante SET"
        . " nm_visitante = '" . $nm_visitante . "'"
        . " , documento_visitante = '" . $documento_visitante . "'"
        . " , telefone_um_visitante = '" . $telefone_um_visitante . "'"
        . " , telefone_dois_visitante = '" . $telefone_dois_visitante . "'"
        . " WHERE id_visitante = " . $id_visitante;


    if (!mysqli_query($conn, $sql)) {
        // echo "Erro ao atualizar o banco";
        // echo "Erro SQL: " . mysqli_error($conn);

        //Mensagem Administrativa
        // $_SESSION['mensagem'] = "Erro Atualizar SQL: " . mysqli_error($conn);
        $_SESSION['mensagem'] = "Erro ao ATUALIZAR VISITANTE. Contate o Administrador do Sistema";
        $_SESSION['corMensagem'] = "danger";
        mysqli_close($conn);
        header("Location: cad_visitante.php");
        mysqli_close($conn);
    } else {

        $_SESSION['mensagem'] = "Visitante ATUALIZADO com sucesso!";
        $_SESSION['corMensagem'] = "warning";
        mysqli_close($conn);
        header("Location: cad_visitante.php");
    };
}
