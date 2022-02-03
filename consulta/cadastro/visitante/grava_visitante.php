<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_visitante = $_POST["hidIdVisitante"];
$nm_visitante = trim($_POST["txtNomeVisitante"]);
$documento_visitante = trim($_POST["txtDocumento"]);
$telefone_um_visitante = trim($_POST["txtTelefoneUm"]);
$telefone_dois_visitante = trim($_POST["txtTelefoneDois"]);




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

        $arrayPlacaVeiculo[$i] = $_POST['txtPlacaVeiculoVisitante'. $arrayIdsVeiculos[$i] .''];

        $arrayCorVeiculo[$i]  = $_POST['cboCorVeiculo'. $arrayIdsVeiculos[$i] .'']; 


        // echo $arrayTipoVeiculo[$i] . "<br>";
        // echo $arrayPlacaVeiculo[$i] . "<br>";
        // echo $arrayCorVeiculo[$i] . "<br>";
        // exit();
    }

}



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


        //So cadastra o carro caso haja algum adicionado na hora do cadastro
        if($stringIdsVeiculos != "-1") {

            
            //Adiciona os veiculos informados
            for ($i = 0; $i<$contadorVeiculos; $i++){

                $sql = "INSERT INTO tb_veiculo ("
                    . "ds_placa_veiculo,"
                    . "fk_visitante,"
                    . "fk_cor_veiculo,"
                    . "fk_tipo_veiculo"
                    . ") VALUES ("
                    . "'$arrayPlacaVeiculo[$i]',"
                    . "'$proximoIdVisitante',"
                    . "'$arrayCorVeiculo[$i]',"
                    . "'$arrayTipoVeiculo[$i]')";

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
   
        if($stringIdsVeiculos != "-1") {

            for ($i = 0; $i<$contadorVeiculos; $i++){

                //Reseta a variavel auxiliar
                $temUpdate = 0;   
                
                /*Preciso realizar comparacao das placas para quando adiciono um novo carro
                em um visitante que ja possuia outro carro cadastrado */
                $sql = "SELECT * FROM tb_veiculo WHERE fk_visitante = " . $id_visitante;
            
                $results = mysqli_query($conn, $sql) or die("Erro ao retornar PLACAS na EDICAO");
                

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
                    . "fk_visitante,"
                    . "fk_cor_veiculo,"
                    . "fk_tipo_veiculo"
                    . ") VALUES ("
                    . "'$arrayPlacaVeiculo[$i]',"
                    . "'$id_visitante',"
                    . "'$arrayCorVeiculo[$i]',"
                    . "'$arrayTipoVeiculo[$i]')";

                    mysqli_query($conn, $sql) or die("Erro ao INSERIR veiculo do visitante na EDICAO");

                }

            }
                    
        }
            
    } 
    $_SESSION['mensagem'] = "Visitante ATUALIZADO com sucesso!";
    $_SESSION['corMensagem'] = "warning";
    mysqli_close($conn);
    header("Location: cad_visitante.php");
}
