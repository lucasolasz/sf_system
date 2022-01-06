<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_visitante = $_POST["hidIdVisitante"];
$nm_visitante = trim($_POST["txtNomeVisitante"]);
$documento_visitante = trim($_POST["txtDocumento"]);
$telefone_um_visitante = trim($_POST["txtTelefoneUm"]);
$telefone_dois_visitante = trim($_POST["txtTelefoneDois"]);


//Carrega quantidade de veiculos cadastrados
$contadorVeiculos = $_POST["hidContadorVaiculos"];

//Inicia array dinamico para captura das placas e dos tipos de veiculos cadastrados
$arrayPlacaVeiculo = [];
$arrayTipoVeiculo = [];

//Alimenta dinamicamente a quantidade de placas
for ($i = 1; $i<=$contadorVeiculos; $i++){
    
   $arrayTipoVeiculo[$i] = $_POST['cboTipoVeiculo'.$i.''];
    
   $arrayPlacaVeiculo[$i] = $_POST['txtPlacaVeiculoVisitante'.$i.''];

   $arrayCorVeiculo[$i]  = $_POST['cboCorVeiculo'.$i.''];
  
}


$observa = "que isso fera";


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
        // $mensagem = "Erro SQL: " . mysqli_error($conn);
        $mensagem = "Erro ao INSERIR VISITANTE. Contate o Administrador do Sistema";

        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['corMensagem'] = "danger";
        header("Location: cad_visitante.php");
    } else {
        
        /* Retorna id do visitante cadastrado. Necessário, pois preciso informar 
        o id do visitante cadastrado sem precisar fazer uma outra consulta ao banco */
        $proximoIdVisitante = mysqli_insert_id($conn);
        
        if($contadorVeiculos > 0) {
        //Adiciona os veiculos informados
        for ($i = 1; $i<=$contadorVeiculos; $i++){

            $sql = "INSERT INTO tb_veiculo ("
                . "ds_placa_veiculo,"
                . "fk_visitante,"
                . "fk_cor_veiculo,"
                . "fk_tipo_veiculo,"
                . "observacao_veiculo"
                . ") VALUES ("
                . "'$arrayPlacaVeiculo[$i]',"
                . "'$proximoIdVisitante',"
                . "'$arrayCorVeiculo[$i]',"
                . "'$arrayTipoVeiculo[$i]',"
                . "'$observa')";

            mysqli_query($conn, $sql) or die("Erro ao INSERIR veiculo do visitante");
        };
    }   

        $mensagem = "Visitante CADASTRADO com sucesso!";

        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['corMensagem'] = "success";
        header("Location: cad_visitante.php");
    };   
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

        
        if($contadorVeiculos > 0) {
            //Update dos veiculos informados
            for ($i = 1; $i<=$contadorVeiculos; $i++){
    
                $sql = "UPDATE tb_veiculo SET"
                . " ds_placa_veiculo = '" . $arrayPlacaVeiculo[$i] . "'"
                . " , fk_cor_veiculo = '" . $arrayCorVeiculo[$i] . "'"
                . " , fk_tipo_veiculo = '" . $arrayTipoVeiculo[$i] . "'"
                . " WHERE fk_visitante = " . $id_visitante;
       
                mysqli_query($conn, $sql) or die("Erro ao ATUALIZAR veiculo do visitante");
            };
    
        } 

        $_SESSION['mensagem'] = "Visitante ATUALIZADO com sucesso!";
        $_SESSION['corMensagem'] = "warning";
        mysqli_close($conn);
        header("Location: cad_visitante.php");
    }
}