<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_morador = $_POST["hidIdMorador"];
$txtNomeMorador = $_POST["txtNomeMorador"];
$cboNumeroDaCasa = $_POST["cboNumeroDaCasa"];
$txtDocumentoMorador = $_POST["txtDocumentoMorador"];
$txtDataNascimentoMorador = $_POST["txtDataNascimentoMorador"];
$txtTelefoneUmMorador = $_POST["txtTelefoneUmMorador"];
$txtTelefoneDoisMorador = $_POST["txtTelefoneDoisMorador"];
$txtEmailMorador = $_POST["txtEmailMorador"];
$txtTelefoneEmergenciaMorador = $_POST["txtTelefoneEmergenciaMorador"];

//Precisei fazer isto, pois quando o checkbox não é selecionado ele vem como "undefined"
if (!isset($_POST["chkLocatario"])){
    $chkLocatario = "";
} else {
    $chkLocatario = $_POST["chkLocatario"];
}

if ($chkLocatario != "") {
   
    $txtNomeLocatario = $_POST["txtNomeLocatario"];
    $txtDocumentoLocatario = $_POST["txtDocumentoLocatario"];
    $txtDataNascimentoLocatario = $_POST["txtDataNascimentoLocatario"];
    $txtTelefoneUmLocatario = $_POST["txtTelefoneUmLocatario"];
    $txtTelefoneDoisLocatario = $_POST["txtTelefoneDoisLocatario"];
    
}


//Inicia array dinamico para captura de veiculos de visitantes cadastrados
$stringIdsVeiculos = $_POST["hidArrayIdCamposVeiculos"];

// echo var_dump($stringIdsVeiculos);
// exit();

if ($stringIdsVeiculos != "-1"){

    /*Função para ignorar um caracter de uma string.
    Primeiro parametro indica o que voce quer ignorar e
    o segundo a string*/
    $arrayIdsVeiculos = explode(',', $stringIdsVeiculos);
    
    /* Realiza a contagem do meu vetor para utilizar nos incrementos abaixo*/
    $contadorVeiculos = count($arrayIdsVeiculos);

    // echo var_dump($arrayIdsVeiculos);
    // exit();

    $arrayPlacaVeiculo = [];
    $arrayTipoVeiculo = [];

    //Alimenta dinamicamente a quantidade de placas
    for ($i = 0; $i<$contadorVeiculos; $i++){

        $arrayTipoVeiculo[$i] = $_POST['cboTipoVeiculo'. $arrayIdsVeiculos[$i] .''];

        $arrayPlacaVeiculo[$i] = $_POST['txtPlacaVeiculoMorador'. $arrayIdsVeiculos[$i] .''];

        $arrayCorVeiculo[$i]  = $_POST['cboCorVeiculo'. $arrayIdsVeiculos[$i] .'']; 

    }

}



//Se vazio está adicionando 
if ($id_morador == "") {

    $mensagem = "";
    
    $sql = "INSERT INTO tb_morador ("
        . "nm_morador,"
        . " num_casa_morador,"
        . " documento_morador,"
        . " dt_nascimento_morador,"
        . " tel_um_morador,"
        . " tel_dois_morador,"
        . " email_morador,"
        . " tel_emergencia"
        . ") VALUES ("
        . "'$txtNomeMorador',"
        . "'$cboNumeroDaCasa',"
        . "'$txtDocumentoMorador',"
        . "'$txtDataNascimentoMorador',"
        . "'$txtTelefoneUmMorador',"
        . "'$txtTelefoneDoisMorador',"
        . "'$txtEmailMorador',"
        . "'$txtTelefoneEmergenciaMorador')";
    

    if (!mysqli_query($conn, $sql)) {

        //Mensagem Administrativa
        // $mensagem = "Erro SQL: " . mysqli_error($conn);
        $mensagem = "Erro ao INSERIR MORADOR. Contate o Administrador do Sistema";

        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['corMensagem'] = "danger";
        header("Location: cad_morador.php");
        
    } else {
        
        /* Retorna id do visitante cadastrado. Necessário, pois preciso informar 
        o id do visitante cadastrado sem precisar fazer uma outra consulta ao banco */
        $proximoIdMorador = mysqli_insert_id($conn);
        
        
        if ($chkLocatario != ""){        
        $sql = "UPDATE tb_morador SET"
              . " flag_locatario = '" . $chkLocatario . "'"
              . " ,nm_locatario = '" . $txtNomeLocatario . "'"
              . " ,documento_locatario = '" . $txtDocumentoLocatario . "'"
              . " ,dt_nascimento_locatario = '" . $txtDataNascimentoLocatario . "'"
              . " ,tel_um_locatario = '" . $txtTelefoneUmLocatario . "'"
              . " ,tel_dois_locatario = '" . $txtTelefoneDoisLocatario . "'"
              . " WHERE id_morador = " . $proximoIdMorador;
        
    
            mysqli_query($conn, $sql) or die("Erro ao INSERIR locatário");
        }
    

        //So cadastra o carro caso haja algum adicionado na hora do cadastro
        if($stringIdsVeiculos != "-1") {

            
            //Adiciona os veiculos informados
            for ($i = 0; $i<$contadorVeiculos; $i++){

                $sql = "INSERT INTO tb_veiculo ("
                    . "ds_placa_veiculo,"
                    . "fk_morador,"
                    . "fk_cor_veiculo,"
                    . "fk_tipo_veiculo"
                    . ") VALUES ("
                    . "'$arrayPlacaVeiculo[$i]',"
                    . "'$proximoIdMorador',"
                    . "'$arrayCorVeiculo[$i]',"
                    . "'$arrayTipoVeiculo[$i]')";
                
                mysqli_query($conn, $sql) or die("Erro ao INSERIR veiculo do morador");
            };
        }   

        $mensagem = "Morador CADASTRADO com sucesso!";

        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['corMensagem'] = "success";
        header("Location: cad_morador.php");
    };   
    
} else {

    //Update dos dados do morador
    $sql = "UPDATE tb_morador SET"
        . " nm_morador = '" . $txtNomeMorador . "'"
        . " , num_casa_morador = '" . $cboNumeroDaCasa . "'"
        . " , documento_morador = '" . $txtDocumentoMorador . "'"
        . " , dt_nascimento_morador = '" . $txtDataNascimentoMorador . "'"
        . " , tel_um_morador = '" . $txtTelefoneUmMorador . "'"
        . " , tel_dois_morador = '" . $txtTelefoneDoisMorador . "'"
        . " , email_morador = '" . $txtEmailMorador . "'"
        . " , tel_emergencia = '" . $txtTelefoneEmergenciaMorador . "'"
        . " WHERE id_morador = " . $id_morador;

    if (!mysqli_query($conn, $sql)) {
        // echo "Erro ao atualizar o banco";
        // echo "Erro SQL: " . mysqli_error($conn);

        //Mensagem Administrativa
        // $_SESSION['mensagem'] = "Erro Atualizar SQL: " . mysqli_error($conn);
        $_SESSION['mensagem'] = "Erro ao ATUALIZAR MORADOR. Contate o Administrador do Sistema";
        $_SESSION['corMensagem'] = "danger";
        mysqli_close($conn);
        header("Location: cad_morador.php");
        mysqli_close($conn);

    } else {
        
        if ($chkLocatario != ""){        
        $sql = "UPDATE tb_morador SET"
              . " flag_locatario = '" . $chkLocatario . "'"
              . ", nm_locatario = '" . $txtNomeLocatario . "'"
              . ", documento_locatario = '" . $txtDocumentoLocatario . "'"
              . ", dt_nascimento_locatario = '" . $txtDataNascimentoLocatario . "'"
              . ", tel_um_locatario = '" . $txtTelefoneUmLocatario . "'"
              . ", tel_dois_locatario = '" . $txtTelefoneDoisLocatario . "'"
              . " WHERE id_morador = " . $id_morador;
        
            mysqli_query($conn, $sql) or die("Erro ao ATUALIZAR LOCATÁRIO. Contate o Administrador do Sistema");
        
            
        } else {
            
            $sql = "UPDATE tb_morador SET"
              . " flag_locatario = ''"
              . ", nm_locatario = null"
              . ", documento_locatario = null"
              . ", dt_nascimento_locatario = null"
              . ", tel_um_locatario = null"
              . ", tel_dois_locatario = null"
              . " WHERE id_morador = " . $id_morador;

            mysqli_query($conn, $sql) or die("Erro ao APAGAR DADOS LOCATÁRIO. Contate o Administrador do Sistema");
            
        }
        
        if($stringIdsVeiculos != "-1") {

            for ($i = 0; $i<$contadorVeiculos; $i++){

                //Reseta a variavel auxiliar
                $temUpdate = 0;   
                
                /*Preciso realizar comparacao das placas para quando adiciono um novo carro
                em um visitante que ja possuia outro carro cadastrado */
                $sql = "SELECT * FROM tb_veiculo WHERE fk_morador = " . $id_morador;
            
                $results = mysqli_query($conn, $sql) or die("Erro ao retornar PLACAS na EDICAO do morador");
                

                while ($dados = $results->fetch_array()) {

                    $ds_placa_veiculo = $dados['ds_placa_veiculo'];  

                    /*Ao encontrar algum update, significa que a placa ja esta cadastrada e não precisa ser inserida
                    para evitar erro no banco*/
                    if($arrayPlacaVeiculo[$i] == $ds_placa_veiculo){

                        //Variavel contadora auxiliar 
                        $temUpdate += 1;
                        break;   

                    }

                }
                
                //Se existe algum update após o loop, ele executa o update.
                if ($temUpdate > 0 ) {

                    $sql = "UPDATE tb_veiculo SET"
                    . " ds_placa_veiculo = '" . $arrayPlacaVeiculo[$i] . "'"
                    . " , fk_cor_veiculo = '" . $arrayCorVeiculo[$i] . "'"
                    . " , fk_tipo_veiculo = '" . $arrayTipoVeiculo[$i] . "'"
                    . " WHERE ds_placa_veiculo = '" . $arrayPlacaVeiculo[$i] . "'";
            
                    mysqli_query($conn, $sql) or die("Erro ao ATUALIZAR veiculo do visitante");
                    
                } else {

                    $sql = "INSERT INTO tb_veiculo ("
                    . "ds_placa_veiculo,"
                    . "fk_morador,"
                    . "fk_cor_veiculo,"
                    . "fk_tipo_veiculo"
                    . ") VALUES ("
                    . "'$arrayPlacaVeiculo[$i]',"
                    . "'$id_morador',"
                    . "'$arrayCorVeiculo[$i]',"
                    . "'$arrayTipoVeiculo[$i]')";

                    mysqli_query($conn, $sql) or die("Erro ao INSERIR veiculo do morador na EDICAO");

                }

            }
                    
        }
            
    } 
    $_SESSION['mensagem'] = "Morador ATUALIZADO com sucesso!";
    $_SESSION['corMensagem'] = "warning";
    mysqli_close($conn);
    header("Location: cad_morador.php");
}
